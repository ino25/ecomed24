const express = require("express");
const PrescriptionController = require("../controllers/prescription.controller");
const VerifyToken = require("./VerifyToken");
const router = express.Router();
router.get(
  "/prescription/:list",
  VerifyToken,
  PrescriptionController.getPrescription
);
router.get(
  "/by-id/:prescription_id",
  VerifyToken,
  PrescriptionController.getPrescriptionByID
);

module.exports = router;
