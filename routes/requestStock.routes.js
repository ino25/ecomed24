const express = require("express");
const router = express.Router();
const stockRequestController = require("../controllers/requestStock.controller");

router.post("/request", stockRequestController.createStockRequest);
router.get("/requests", stockRequestController.getAllStockRequests);
router.get("/request/:id", stockRequestController.getStockRequestById);
router.patch('/request/:id/status', stockRequestController.patchStockRequestStatus);


module.exports = router;
