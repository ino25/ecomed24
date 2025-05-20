const Stock = require("../models/Stock");
const Drug = require("../models/Drug");
const Sequelize = require("sequelize");
const { status } = require("./stock-request.controller");
const multer = require("multer");


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
          Sequelize.fn("DATE_FORMAT", Sequelize.col("Stock.createdAt"), "%d/%m/%Y %H:%i"),
          "createdAt",
        ],
        [
          Sequelize.fn("DATE_FORMAT", Sequelize.col("Stock.updatedAt"), "%d/%m/%Y %H:%i"),
          "updatedAt",
        ],
      ],
      order: [["id", "ASC"]],
      limit: datalimit,
      offset: offsetdata,
    });
    if(stocksData.length == 0) {
      res.json({status: 0, message: "No stocks found."});
    }
    else{
       res.json({
      status: 1,
      message: "Stocks retrieved successfully.",
      data: stocksData,
      total:stocksData.length,
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
  const {
    drugId,
    expiration_date,
    stock_level,
    sales_price,
    unit_price,
  } = req.body;

  if (!drugId || !expiration_date || !stock_level || !sales_price || !unit_price) {
    return res.status(400).json({ message: "All required fields must be provided." });
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
    res.status(201).json({ message: "Stock created successfully", data: newStock });
  } catch (error) {
    console.error("Error creating stock:", error);
    res.status(500).json({ message: "Failed to create stock." });
  }
};

exports.getById = async (req, res) => {
  try {
    const stockId = req.params.id;
    
    if (!stockId) {
      return res.status(400).json({
        status: 0,
        message: "Stock ID is required."
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
        "added_by",
        "updated_by",
        [
          Sequelize.fn("DATE_FORMAT", Sequelize.col("Stock.createdAt"), "%d/%m/%Y %H:%i"),
          "createdAt",
        ],
        [
          Sequelize.fn("DATE_FORMAT", Sequelize.col("Stock.updatedAt"), "%d/%m/%Y %H:%i"),
          "updatedAt",
        ],
      ],
    });

   if(stockData === null) {
      return res.status(404).json({
        status: 0,
        message: "Stock not found."
      });
    }else{
      res.json({
        status: 1,
        message: "Stock retrieved successfully.",
        data: stockData
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


exports.bulkAdd = async (req, res) => {
  try {
    console.log("Request received for bulk add");
    console.log("Files in request:", req.file ? "File present" : "No file present");
    
    if (!req.file) {
      console.log("Headers:", req.headers);
      return res.status(400).json({ message: "No file uploaded." });
    }

    console.log("File details:", {
      originalname: req.file.originalname,
      mimetype: req.file.mimetype,
      size: req.file.size
    });

    // Read buffer into workbook
    const workbook = xlsx.read(req.file.buffer, { type: "buffer" });
    const sheetName = workbook.SheetNames[0];
    const sheetData = xlsx.utils.sheet_to_json(workbook.Sheets[sheetName]);

    if (!sheetData.length) {
      return res.status(400).json({ message: "Uploaded sheet is empty." });
    }

    console.log(`Processing ${sheetData.length} records from Excel file`);

    // Optional: Validate each row here
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
      message: `${createdRecords.length} stocks created successfully.`,
      data: createdRecords,
    });
  } catch (error) {
    console.error("Bulk upload error:", error);
    console.error("Error stack:", error.stack);
    return res.status(500).json({
      message: "Failed to process bulk stock upload.",
      error: error.message,
    });
  }
};