const Stock = require("../models/Stock");
const Drug = require("../models/Drug");
const Sequelize = require("sequelize");
const xlsx = require("xlsx");
const path = require("path");

exports.getList = async (req, res) => {
  try {
    let offsetdata = parseInt(req.query.offset ?? 0);
    offsetdata = isNaN(offsetdata) || offsetdata < 0 ? 0 : offsetdata;

    let datalimit = parseInt(req.query.limit ?? 5);
    datalimit = isNaN(datalimit) || datalimit <= 0 ? 5 : datalimit;

    const stocksData = await Stock.findAll({
      include: [
        {
          model: Drug,
          as: "product",
          attributes: [
            "id",
            "commercialName",
            "dci",
            "presentation",
            "galenicForm",
            "publicPrice",
          ],
          required: true,
        },
      ],
      attributes: [
        "id",
        "batch_number",
        "expiration_date",
        "stock_level",
        "sales_price",
        "unit_price",
        "status",
        "added_by",
        "updated_by",
        [
          Sequelize.fn(
            "DATE_FORMAT",
            Sequelize.col("Stock.createdAt"),
            "%d/%m/%Y %H:%i"
          ),
          "createdAt",
        ],
        [
          Sequelize.fn(
            "DATE_FORMAT",
            Sequelize.col("Stock.updatedAt"),
            "%d/%m/%Y %H:%i"
          ),
          "updatedAt",
        ],
      ],
      order: [["id", "DESC"]],
      limit: datalimit,
      offset: offsetdata,
    });
    if (stocksData.length == 0) {
      res.json({ status: 0, message: "No stocks found." });
    } else {
      res.json({
        status: 1,
        message: "Stocks retrieved successfully.",
        data: stocksData,
        total: stocksData.length,
      });
    }
  } catch (error) {
    console.error("Error fetching stocks:", error);
    return res.status(500).json({
      status: 0,
      message: "Failed to retrieve stocks.",
      error: error.message,
    });
  }
};
exports.add = async (req, res) => {
  const { productId, expiration_date, stock_level, sales_price, unit_price } =
    req.body;

  if (
    !productId ||
    !expiration_date ||
    !stock_level ||
    !sales_price ||
    !unit_price
  ) {
    return res
      .status(400)
      .json({ message: "All required fields must be provided." });
  }

  const batch_number = Math.floor(Date.now() / 1000).toString();

  try {
    const newStock = await Stock.create({
      productId,
      batch_number,
      expiration_date,
      stock_level,
      sales_price,
      unit_price,
    });
    res.status(201).json({
      status: 1,
      message: "Stock created successfully",
      data: newStock,
    });
  } catch (error) {
    console.error("Error creating stock:", error);
    res.status(500).json({ status: 0, message: "Failed to create stock." });
  }
};

exports.getById = async (req, res) => {
  try {
    const stockId = req.params.id;

    if (!stockId) {
      return res.status(400).json({
        status: 0,
        message: "Stock ID is required.",
      });
    }

    const stockData = await Stock.findOne({
      where: { id: stockId },
      include: [
        {
          model: Drug,
          as: "product",
          attributes: ["id", "commercialName", "dci", "presentation", "galenicForm", "publicPrice"],
          required: true,
        },
      ],
      attributes: [
        "id",
        "batch_number",
        "expiration_date",
        "stock_level",
        "sales_price",
        "unit_price",
        "status",
        "reason",
        "added_by",
        "updated_by",
        [
          Sequelize.fn(
            "DATE_FORMAT",
            Sequelize.col("Stock.createdAt"),
            "%d/%m/%Y %H:%i"
          ),
          "createdAt",
        ],
        [
          Sequelize.fn(
            "DATE_FORMAT",
            Sequelize.col("Stock.updatedAt"),
            "%d/%m/%Y %H:%i"
          ),
          "updatedAt",
        ],
      ],
    });

    if (stockData === null) {
      return res.status(404).json({
        status: 0,
        message: "Stock not found.",
      });
    } else {
      res.json({
        status: 1,
        message: "Stock retrieved successfully.",
        data: stockData,
      });
    }
  } catch (error) {
    console.error("Error fetching stock by ID:", error);
    return res.status(500).json({
      status: 0,
      message: "Failed to retrieve stock.",
      error: error.message,
    });
  }
};

exports.adjustStock = async (req, res) => {
  try {
    const { id } = req.params;
    const { adjustment_value, reason } = req.body;
    const updated_by = req.user?.username;

    if (!id || typeof adjustment_value !== "number") {
      return res.status(400).json({
        status: 0,
        message: "Stock ID and a valid numeric adjustment value are required.",
      });
    }

    if (!reason || reason.trim() === "") {
      return res.status(400).json({
        status: 0,
        message: "Adjustment reason is required.",
      });
    }
    const stock = await Stock.findByPk(id);
    if (!stock) {
      return res.status(404).json({
        status: 0,
        message: "Stock not found.",
      });
    }

    stock.stock_level += adjustment_value;
    stock.updated_by = updated_by || "system";

    await stock.save();
    res.status(200).json({
      status: 1,
      message: "Stock adjusted successfully.",
      data: {
        id: stock.id,
        stock_level: stock.stock_level,
        adjustment_value,
        reason,
        updated_by,
      },
    });
  } catch (error) {
    console.error("Error adjusting stock:", error);
    res.status(500).json({
      status: 0,
      message: "Failed to adjust stock.",
      error: error.message,
    });
  }
};

function parseExcelDate(value) {
  if (typeof value === "string" && value.match(/^\d{4}-\d{2}-\d{2}$/)) {
    return value;
  }

  if (
    typeof value === "string" &&
    (value.includes("-") || value.includes("/"))
  ) {
    const parts = value.split(/[-\/]/);
    if (parts.length === 3) {
      const day = parts[0].padStart(2, "0");
      const month = parts[1].padStart(2, "0");
      const year = parts[2];
      return `${year}-${month}-${day}`;
    }
  }
  if (typeof value === "number") {
    const excelEpoch = new Date(1900, 0, 1);
    const date = new Date(
      excelEpoch.getTime() + (value - 2) * 24 * 60 * 60 * 1000
    );
    return date.toISOString().split("T")[0];
  }

  if (value instanceof Date) {
    return value.toISOString().split("T")[0];
  }

  const parsedDate = new Date(value);
  if (!isNaN(parsedDate.getTime())) {
    return parsedDate.toISOString().split("T")[0];
  }

  return value;
}

exports.bulkAdd = async (req, res) => {
  try {
    if (!req.file) {
      return res.status(400).json({ message: "No file uploaded." });
    }

    const workbook = xlsx.read(req.file.buffer, { type: "buffer" });
    const sheetName = workbook.SheetNames[0];
    const sheetData = xlsx.utils.sheet_to_json(workbook.Sheets[sheetName]);

    if (!sheetData.length) {
      return res.status(400).json({ message: "Uploaded sheet is empty." });
    }

    const requiredFields = [
      "productId",
      "expiration_date",
      "stock_level",
      "sales_price",
      "unit_price",
      "commercialName",
      "dci",
      "presentation",
      "galenicForm",
      "publicPrice",
    ];

    const errors = [];
    const validRows = [];

    for (let [index, row] of sheetData.entries()) {
      const rowNum = index + 2;

      const missingFields = requiredFields.filter(
        (field) => row[field] === undefined || row[field] === ""
      );

      if (missingFields.length > 0) {
        errors.push({
          row: rowNum,
          message: `Missing fields: ${missingFields.join(", ")}`,
        });
        continue;
      }

      const normalizedRow = {
        productId: Number(row.productId),
        commercialName: String(row.commercialName).trim(),
        dci: String(row.dci).trim(),
        presentation: String(row.presentation).trim(),
        galenicForm: String(row.galenicForm).trim(),
        publicPrice: Number(row.publicPrice),
      };

      const drug = await Drug.findOne({
        where: {
          id: normalizedRow.productId,
          commercialName: normalizedRow.commercialName,
          dci: normalizedRow.dci,
          presentation: normalizedRow.presentation,
          galenicForm: normalizedRow.galenicForm,
          publicPrice: normalizedRow.publicPrice,
        },
      });

      if (!drug) {
        errors.push({
          row: rowNum,
          message: `Drug not found or does not match for productId ${normalizedRow.productId}`,
        });
        continue;
      }
      const parsedExpirationDate = parseExcelDate(row.expiration_date);
      const dateRegex = /^\d{4}-\d{2}-\d{2}$/;
      if (!dateRegex.test(parsedExpirationDate)) {
        errors.push({
          row: rowNum,
          message: `Invalid expiration date format for productId ${normalizedRow.productId}. Expected YYYY-MM-DD format.`,
        });
        continue;
      }
      validRows.push({
        productId: normalizedRow.productId,
        expiration_date: parsedExpirationDate,
        stock_level: Number(row.stock_level),
        sales_price: Number(row.sales_price),
        unit_price: Number(row.unit_price),
        // batch_number: `BATCH-${Date.now()}-${row.productId}`,
        batch_number: Math.floor(Date.now() / 1000).toString(),
      });
    }

    if (errors.length > 0) {
      return res.status(400).json({
        status: 0,
        message: "Validation failed for some rows.",
        errors,
      });
    }

    const createdRecords = await Stock.bulkCreate(validRows);

    return res.status(201).json({
      status: 1,
      message: `${createdRecords.length} stock entries created successfully.`,
      data: createdRecords,
    });
  } catch (error) {
    console.error("Bulk upload error:", error);
    return res.status(500).json({
      status: 0,
      message: "Failed to process bulk stock upload.",
      error: error.message,
    });
  }
};

exports.downloadSheet = async (req, res) => {
  try {
    const drugs = await Drug.findAll({
      attributes: [
        "id", // productId
        "commercialName",
        "dci",
        "presentation",
        "galenicForm",
        "publicPrice",
      ],
      raw: true,
    });

    if (drugs.length === 0) {
      return res.status(404).json({ message: "No drug data found." });
    }

    const headers = [
      "productId",
      "commercialName",
      "dci",
      "presentation",
      "galenicForm",
      "publicPrice",
      "sales_price",
      "unit_price",
      "stock_level",
      "expiration_date",
    ];

    const rows = drugs.map((drug) => ({
      productId: drug.id,
      commercialName: drug.commercialName || "",
      dci: drug.dci || "",
      presentation: drug.presentation || "",
      galenicForm: drug.galenicForm || "",
      publicPrice: drug.publicPrice || "",
      sales_price: "",
      unit_price: "",
      stock_level: "",
      expiration_date: "",
    }));

    const worksheet = xlsx.utils.json_to_sheet(rows, { header: headers });
    const workbook = xlsx.utils.book_new();
    xlsx.utils.book_append_sheet(workbook, worksheet, "DrugStockTemplate");

    const buffer = xlsx.write(workbook, { type: "buffer", bookType: "xlsx" });

    res.setHeader(
      "Content-Disposition",
      "attachment; filename=drug_stock_template.xlsx"
    );
    res.setHeader(
      "Content-Type",
      "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
    );

    res.send(buffer);
  } catch (err) {
    console.error("Excel generation error:", err);
    res.status(500).json({ message: "Failed to generate Excel sheet." });
  }
};
