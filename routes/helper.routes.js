var express = require('express');
var router = express.Router();
const VerifyToken = require('./VerifyToken');

const helperController = require("../controllers/helper.controller");


router.get('/get-doctors',VerifyToken, helperController.getDoctorsList);
router.get('/get-services',VerifyToken, helperController.getServicesList);

// Country
router.get('/get-country-list',VerifyToken, helperController.getCountryList);
router.get('/get-region-list/:country_id',VerifyToken, helperController.getRegionList);
router.get('/get-district-list/:region_id',VerifyToken, helperController.getDistrictList);




module.exports = router;
