const express = require("express");
const router = express.Router();
const VerifyToken = require("./VerifyToken");
const dashboardController = require("../controllers/dashboard.controller");

// Dashboard
router.get("/get-totals", VerifyToken, dashboardController.getTotals);
router.get(
  "/get-patient-demographic",
  VerifyToken,
  dashboardController.getPatientDemographic
);
router.get(
  "/get-nosologie-report",
  VerifyToken,
  dashboardController.getNosologieReport
);

module.exports = router;
