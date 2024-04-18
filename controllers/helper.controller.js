const Sequelize = require('sequelize');
const Database = require('../config').sequelize;
const Op = Sequelize.Op;
const moment = require("moment");
moment.locale('en');
const path = require('path');
const nodemailer = require("nodemailer");
const axios = require("axios");
var Country = require('../models/Country');
var Region = require('../models/Region');
var District = require('../models/District');

const multer  = require('multer');
const fs = require('fs');
var Doctor = require('../models/Doctor');
var SettingService = require('../models/SettingService');
var OrgPermission = require('../models/OrgPermission');

exports.getDoctorsList = async (req, res) => {
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
};
exports.getServicesList = async (req, res) => {
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
};




exports.getCountryList = async (req, res) => {
    try {
      
        CountryModal = await Country.findAll({attributes: ['id', 'name','country_code','status','added_by','updated_by',[Sequelize.fn("DATE_FORMAT", Sequelize.col("createdAt"),"%d-%m-%Y %H:%i:%s"),"createdAt"],[Sequelize.fn("DATE_FORMAT", Sequelize.col("updatedAt"),"%d-%m-%Y %H:%i:%s"),"updatedAt"]], 
                                order: [['id', 'ASC']],
                                where: { status: 1 }
                            });
        if(CountryModal === null){
            res.json({ status: 0, message: 'No Data Found' });
        }else{
            res.json({ status: 1, message: 'Country List', data: CountryModal });
        }
    } catch (error) {
        throw error;
    }
};

exports.getRegionList = async (req, res) => {
    try {
      
        RegionModal = await Region.findAll({attributes: ['id', 'name','status','added_by','updated_by',[Sequelize.fn("DATE_FORMAT", Sequelize.col("createdAt"),"%d-%m-%Y %H:%i:%s"),"createdAt"],[Sequelize.fn("DATE_FORMAT", Sequelize.col("updatedAt"),"%d-%m-%Y %H:%i:%s"),"updatedAt"]], 
                                    where: { country_id: req.params.country_id },
                                
                            });
        if(RegionModal === null){
            res.json({ status: 0, message: 'No Data Found' });
        }else{
            res.json({ status: 1, message: 'Region List', data: RegionModal });
        }
    } catch (error) {
        throw error;
    }
};

exports.getDistrictList = async (req, res) => {
    try {
      
        DistrictModal = await District.findAll({attributes: ['id', 'name','status','added_by','updated_by',[Sequelize.fn("DATE_FORMAT", Sequelize.col("createdAt"),"%d-%m-%Y %H:%i:%s"),"createdAt"],[Sequelize.fn("DATE_FORMAT", Sequelize.col("updatedAt"),"%d-%m-%Y %H:%i:%s"),"updatedAt"]], 
                                    where: { id_region: req.params.region_id },
                                
                            });
        if(DistrictModal === null){
            res.json({ status: 0, message: 'No Data Found' });
        }else{
            res.json({ status: 1, message: 'District List', data: DistrictModal });
        }
    } catch (error) {
        throw error;
    }
};


exports.getOrganizationPermission = async (req, res) => {
    try {
        let getData = [];
        // OrgPermissionModal = await OrgPermission.findAll({ attributes: ['id', 'sp_id'],where: { status_service: 1 } });

        OrgPermissionModal = await Database.query("SELECT op.id,sp.name,sp.description,sp.module_id FROM org_permissions as op  LEFT JOIN system_permissions as sp ON op.sp_id= sp.id where op.status=1 and op.org_id = "+req.org_id+";",{type: Database.QueryTypes.SELECT});
        if(OrgPermissionModal === null){
            res.json({ status: 0, message: 'No Data Found' });
        }else{
            res.json({ status: 1, message: 'Organization Permission fetched', data: OrgPermissionModal });
        }
    } catch (error) {
        throw error;
    }
};


exports.savePDFdf = async (req, res) => {
    const { formData } = req.body;
    const templateNameValue =
      "ecoMed24.dev/ecomed-templates/ecomed_MasterLabTemplate.docx";
    const outputName = `lab-report--00${formData?.id_acte}.pdf`;
    const accessKey =
      "ODBiYzNkNzItYWE2Ni00ZGIzLWE0YzgtY2MzYjYzODkwZmRjOjA4MjQ5MjQ";
  
    const postData = new URLSearchParams({
      accessKey: accessKey,
      templateName: templateNameValue,
      outputName: outputName,
      data: JSON.stringify(formData),
    }).toString();
  
    const requestOptions = {
      headers: {
        "Content-Type": "application/x-www-form-urlencoded",
        "Content-Length": String(new TextEncoder().encode(postData).length), // Convert to string
      },
    };
  
    try {
      console.log(formData);
      const response = await axios.post(
        `https://eu.dws3.docmosis.com/api/render`,
        postData,
        requestOptions
      );
  
      if (response.status === 200) {
        const pdfData = response.data; // Response data is already in Blob format
        const blob = new Blob([pdfData], { type: "application/pdf" });
  
        // Enregistrez le fichier PDF sur le serveur
        const pdfPath = `./pdfs/${outputName}`;
        const pdfFile = fs.createWriteStream(pdfPath);
        blob.stream().pipe(pdfFile);
  
        pdfFile.on("finish", () => {
          res.json({ message: "Fichier PDF sauvegardé avec succès." });
        });
      } else {
        console.log("Error response:", response.status, response.statusText);
        throw new Error("Network response was not ok.");
      }
    } catch (error) {
      console.error("Request error:", error);
      res
        .status(500)
        .json({ error: "Une erreur est survenue lors de la génération du PDF." });
    }
  };








