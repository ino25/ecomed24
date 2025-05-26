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
          as: "drug",
          attributes: ["id", "commercialName"],
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
  const { drugId, expiration_date, stock_level, sales_price, unit_price } =
    req.body;

  if (
    !drugId ||
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
      drugId,
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
          as: "drug",
          attributes: ["id", "commercialName"],
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

exports.bulkAdd = async (req, res) => {
  try {
    if (!req.file) {
      return res.status(400).json({ message: "No file uploaded." });
    }

    console.log("File details:", {
      originalname: req.file.originalname,
      mimetype: req.file.mimetype,
      size: req.file.size,
    });

    const workbook = xlsx.read(req.file.buffer, { type: "buffer" });
    const sheetName = workbook.SheetNames[0];
    const sheetData = xlsx.utils.sheet_to_json(workbook.Sheets[sheetName]);

    if (!sheetData.length) {
      return res.status(400).json({ message: "Uploaded sheet is empty." });
    }
    const formattedData = sheetData.map((row) => ({
      drugId: row.drugId,
      expiration_date: row.expiration_date,
      stock_level: row.stock_level,
      sales_price: row.sales_price,
      unit_price: row.unit_price,
      batch_number: Math.floor(Date.now() / 1000).toString(),
    }));

    const createdRecords = await Stock.bulkCreate(formattedData);

    return res.status(201).json({
      status: 1,
      message: `${createdRecords.length} stocks created successfully.`,
      data: createdRecords,
    });
  } catch (error) {
    console.error("Bulk upload error:", error);
    console.error("Error stack:", error.stack);
    return res.status(500).json({
      status: 0,
      message: "Failed to process bulk stock upload.",
      error: error.message,
    });
  }
};

exports.downloadSheet = async (req, res) => {
  try {
    const headers = [
      "drugId",
      "commercialName",
      "dci",
      "presentation",
      "galenicForm",
      "batch_number",
      "expiration_date",
      "stock_level",
      "sales_price",
    ];

    const worksheet = xlsx.utils.aoa_to_sheet([headers]);
    const workbook = xlsx.utils.book_new();
    xlsx.utils.book_append_sheet(workbook, worksheet, "StockTemplate");
    const buffer = xlsx.write(workbook, { type: "buffer", bookType: "xlsx" });
    res.setHeader(
      "Content-Disposition",
      "attachment; filename=stock_template.xlsx"
    );
    res.setHeader(
      "Content-Type",
      "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
    );

    res.send(buffer);
  } catch (err) {
    console.error("Excel generation error:", err);
    res.status(500).json({ message: "Excel generation failed" });
  }
};
