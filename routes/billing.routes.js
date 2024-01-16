const express = require("express");
const router = express.Router();
const VerifyToken = require('./VerifyToken');
const billingController = require("../controllers/billing.controller");


// Hospitalization
router.get('/list-invoice-partner',VerifyToken, billingController.getInvoicePayments);



module.exports = router;
