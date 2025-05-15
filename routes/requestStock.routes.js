const express = require("express");
const router = express.Router();
const VerifyToken = require("./VerifyToken");

const stockRequestController = require("../controllers/requestStock.controller");


router.post("/request", VerifyToken, stockRequestController.createStockRequest);
router.get("/requests", VerifyToken, stockRequestController.getAllStockRequests);
router.get("/request/by-id/:id", stockRequestController.getStockRequestById);
router.patch('/request/status/:id', VerifyToken, stockRequestController.patchStockRequestStatus);
router.delete("/request/delete/:id", VerifyToken, stockRequestController.delete);

module.exports = router;
