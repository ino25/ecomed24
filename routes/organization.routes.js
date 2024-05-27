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
router.patch('/pricing/update/:id',VerifyToken, organizationController.updatePricing);


// invoice and payments
router.get('/invoice-payments/:org_id',VerifyToken, organizationController.getInvoicePaymentsByORG);
router.get('/invoice-payments/payment-receipt/:payment_id',VerifyToken, organizationController.getPaymentReceipt);
router.get('/invoice-payments/payment/details/:payment_id',VerifyToken, organizationController.getPaymentDetails);
router.get('/invoice-payments/payment/deposits/:payment_id',VerifyToken, organizationController.getDepositList);
router.post('/invoice-payments/payment/deposit/add',VerifyToken, organizationController.addDeposit);

// helper
router.get('/get-organization-types',VerifyToken, organizationController.getOrganizationType);
router.get('/get-pricing-category',VerifyToken, organizationController.getPricingCategory);

// Price Prestation
router.post('/add-price-grid',VerifyToken, organizationController.addPriceGrids);
router.post('/import-price-detail',VerifyToken, organizationController.importPriceGridDetails);
router.get('/get-price-grids',VerifyToken, organizationController.getPriceGridsAll);
router.get('/get-price-grid/:gridID',VerifyToken, organizationController.getPriceGridByID);
router.get('/get-price-grid-details',VerifyToken, organizationController.getPriceGridDetailsAll);
router.get('/get-price-assurance-ipm/:org_id/:byID', organizationController.getPriceIpmAssurancePriceGrid);
router.get('/get-price/:org_id', organizationController.getPriceGridsDetails);
router.get('/get-price-product/:org_id/:product_id', organizationController.getPriceGridProductID);
router.put('/update-price-details/:productID', VerifyToken, organizationController.updatePriceGridDetailsByProductID);
router.get('/get-all-prestation/:org_id', VerifyToken, organizationController.getOrganisationPrestationsAll);


// router.get('/get-price-grid-detail/:gridDetailsID',VerifyToken, organizationController.getPriceGridDetailByID);
// router.get('/get-price-grid-by/:gridID',VerifyToken, organizationController.getPriceGridDetailByGridID);
// router.get('/update-price-detail-by/:detailID',VerifyToken, organizationController.updatePriceGridDetails);
// router.get('/update-bulk-price-grid-by/:gridID',VerifyToken, organizationController.updatePriceGridDetails);


module.exports = router;

