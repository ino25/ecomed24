const express = require("express");
const router = express.Router();
const VerifyToken = require("./VerifyToken");
const dashboardController = require("../controllers/dashboard.controller");

// Dashboard
router.get(
  "/get-overall-metrics",
  VerifyToken,
  dashboardController.getOverallData
);
router.get(
  "/get-patient-demographic",
  VerifyToken,
  dashboardController.getPatientDemographicData
);
module.exports = router;
