const express = require('express');
const router = express.Router();
const salesController = require('../controllers/sales.controller');
const VerifyToken = require("./VerifyToken");


router.post('/create',VerifyToken,  salesController.createSale);


router.get('/by-id/:sale_id',VerifyToken,  salesController.getSaleById);

router.get('/list',VerifyToken,  salesController.getSalesList);

module.exports = router;