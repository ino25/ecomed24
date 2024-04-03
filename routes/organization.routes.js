const express = require("express");
const router = express.Router();
const VerifyToken = require('./VerifyToken');
const organizationController = require("../controllers/organization.controller");


// Organizations
router.get('/',VerifyToken, organizationController.getOrganizationList);
router.get('/get-org-byid/:org_id',VerifyToken, organizationController.getOrganizationByID);
router.post('/add',VerifyToken, organizationController.addOrganization);
router.post('/update/:org_id',VerifyToken, organizationController.updateOrganization);
router.patch('/status/:id',VerifyToken, organizationController.statusOrganization);


// invoice and payments
router.get('/invoice-payments/:org_id',VerifyToken, organizationController.getInvoicePaymentsByORG);
router.get('/invoice-payments/payment-receipt/:payment_id',VerifyToken, organizationController.getPaymentReceipt);
router.get('/invoice-payments/payment/details/:payment_id',VerifyToken, organizationController.getPaymentDetails);
router.get('/invoice-payments/payment/deposits/:payment_id',VerifyToken, organizationController.getDepositList);
router.post('/invoice-payments/payment/deposit/add',VerifyToken, organizationController.addDeposit);

// helper
router.get('/get-organization-types',VerifyToken, organizationController.getOrganizationType);
router.get('/get-pricing-category',VerifyToken, organizationController.getPricingCategory);

module.exports = router;
