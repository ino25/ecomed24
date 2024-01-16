const express = require("express");
const router = express.Router();
const VerifyToken = require('./VerifyToken');
const organizationController = require("../controllers/organization.controller");


// Organizations
router.get('/',VerifyToken, organizationController.getOrganizationList);
router.get('/get-org-byid/:org_id',VerifyToken, organizationController.getOrganizationByID);
router.post('/add',VerifyToken, organizationController.addOrganization);

// helper
router.get('/get-organization-types',VerifyToken, organizationController.getOrganizationType);
router.get('/get-pricing-category',VerifyToken, organizationController.getPricingCategory);

module.exports = router;
