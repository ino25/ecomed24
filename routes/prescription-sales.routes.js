const express = require('express');
const VerifyToken = require("./VerifyToken");
const router = express.Router();
const PrescriptionSalesController = require("../controllers/prescriptionSales.controller");
router.post('/add',VerifyToken, PrescriptionSalesController.AddPrescriptionSale);
router.get('/list', VerifyToken, PrescriptionSalesController.getSalesList);
router.get('/:sale_id', VerifyToken, PrescriptionSalesController.getSaleById);
router.get('/prescription/:prescription_id', VerifyToken, PrescriptionSalesController.getSaleByPrescriptionId);
module.exports = router;
