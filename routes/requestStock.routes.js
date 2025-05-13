const express = require("express");
const router = express.Router();
const stockRequestController = require("../controllers/requestStock.controller");

// POST /api/stock-requests
router.post("/request", stockRequestController.createStockRequest);
router.get("/requests", stockRequestController.getAllStockRequests);

module.exports = router;
