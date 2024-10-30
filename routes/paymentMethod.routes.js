const express = require("express");
const {
  getPaymentMethods,
} = require("../controllers/paymentMethod.controller");

const router = express.Router();

// Route to get all payment methods
router.get("/getPaymentMethods", getPaymentMethods);

module.exports = router;
