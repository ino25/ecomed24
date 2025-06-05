const express = require("express");
const PrescriptionController = require("../controllers/prescription.controller");
const VerifyToken = require("./VerifyToken");
const router = express.Router();

router.get("/list", VerifyToken, PrescriptionController.getList);
router.get(
  "/by-id/:prescription_id",
  VerifyToken,
  PrescriptionController.getByID
);
router.post("/sales", VerifyToken, PrescriptionController.storeSales);

module.exports = router;
