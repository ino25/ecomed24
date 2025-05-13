const StockRequest = require("../models/stockRequest");

exports.createStockRequest = async (req, res) => {
  try {
    const {
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

     const userId = req.user?.id || null;

    const newRequest = await StockRequest.create({
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
      createdBy: userId,
      updatedBy: userId,
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

exports.getStockRequestById = async (req, res) => {
  try {
    const { id } = req.params;

    const stockRequest = await StockRequest.findByPk(id);

    if (!stockRequest) {
      return res.status(404).json({
        status: 0,
        message: "Stock request not found",
        data: [],
      });
    }

    return res.status(200).json({
      status: 1,
      message: "Stock request retrieved successfully",
      data: [stockRequest],
    });
  } catch (error) {
    console.error("Error fetching stock request by ID:", error);
    return res.status(500).json({
      status: 0,
      message: "Internal Server Error",
      data: [],
    });
  }
};

exports.patchStockRequestStatus = async (req, res) => {
  try {
    const { id } = req.params;
    const { status } = req.body;
    const userId = req.user?.id || null;

    // Validate new status
    if (![0, 1, 2].includes(status)) {
      return res.status(400).json({
        status: 0,
        message: "Invalid status value. Must be 0 (requested), 1 (accepted), or 2 (rejected).",
        data: [],
      });
    }

    // Find the stock request by ID
    const stockRequest = await StockRequest.findByPk(id);

    if (!stockRequest) {
      return res.status(404).json({
        status: 0,
        message: "Stock request not found.",
        data: [],
      });
    }

    // Update only the status field
    await stockRequest.update({
      status,
      updatedBy: userId,
    });

    return res.status(200).json({
      status: 1,
      message: "Stock request status updated successfully.",
      data: [stockRequest],
    });
  } catch (error) {
    console.error("Error updating stock request status:", error);
    return res.status(500).json({
      status: 0,
      message: "Internal Server Error",
      data: [],
    });
  }
};
