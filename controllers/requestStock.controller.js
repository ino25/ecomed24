

const StockRequest = require("../models/stockRequest");

exports.createStockRequest = async (req, res) => {
  try {
    const {
      productId,
      therapeuticClass,
      dci,
      commercialName,
      dosage,
      administrationRoute,
      presentation,
      galenicForm,
      publicPrice,
      referencePrice,
      currency,
      laboratory,
      status,
      drugScope,
    } = req.body;

    // Validate required fields
    if (!dci || !commercialName) {
      return res.status(400).json({
        status: 0,
        message: "Missing required fields",
        data: [],
      });
    }

    const newRequest = await StockRequest.create({
      productId,
      therapeuticClass,
      dci,
      commercialName,
      dosage,
      administrationRoute,
      presentation,
      galenicForm,
      publicPrice,
      referencePrice,
      currency,
      laboratory,
      status,
      drugScope,
    });

    return res.status(201).json({
      status: 1,
      message: "Stock request created successfully",
      data: [newRequest],
    });
  } catch (error) {
    console.error("Error creating stock request:", error);
    return res.status(500).json({
      status: 0,
      message: "Internal Server Error",
      data: [],
    });
  }
};

exports.getAllStockRequests = async (req, res) => {
  try {
    const stockRequests = await StockRequest.findAll();

    return res.status(200).json({
      status: 1,
      message: "Stock requests retrieved successfully",
      data: stockRequests,
    });
  } catch (error) {
    console.error("Error fetching stock requests:", error);
    return res.status(500).json({
      status: 0,
      message: "Internal Server Error",
      data: [],
    });
  }
};
