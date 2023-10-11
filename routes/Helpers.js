var express = require('express');
var router = express.Router();
const query = require('../config').query;
var crypto = require('crypto');
// const FileUpload = require('../helpers/FileHelper');
const VerifyToken = require('./VerifyToken');
var Doctor = require('../models/Doctor');
var SettingService = require('../models/SettingService');
// Get Medical Services.
router.get('/get-services', VerifyToken, async (req, res) => {
    try {
        let getData = [];
        SettingServiceModal = await SettingService.findAll({ 
            attributes: [['idservice','id'],'name_service', 'code_service'],where: { status_service: 1 } });
        if(SettingServiceModal === null){
            res.json({ status: 0, message: 'No Data Found' });
        }else{
            res.json({ status: 1, message: 'Service List', data: SettingServiceModal });
        }
    } catch (error) {
        throw error;
    }
});

// Get Doctors.

router.get('/get-doctors', VerifyToken, async (req, res) => {
    try {
        let getData = [];
        DoctorModal = await Doctor.findAll({ 
            attributes: ['id', 'name']});
        if(DoctorModal === null){
            res.json({ status: 0, message: 'No Data Found' });
        }else{
            res.json({ status: 1, message: 'Doctors List', data: DoctorModal });
        }
    } catch (error) {
        throw error;
    }
});


module.exports = router;
