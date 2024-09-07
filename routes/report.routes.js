const express = require("express");
const router = express.Router();
const VerifyToken = require("./VerifyToken");
const reportController = require("../controllers/report.controller");

// Reports

router.get(
  "/get-nosologie-report",
  VerifyToken,
  reportController.getNosologieReport
);

module.exports = router;
