const Sequelize = require('sequelize');
const Database = require('../config').sequelize;
const Op = Sequelize.Op;
const moment = require("moment");
moment.locale('en');
const path = require('path');
const nodemailer = require("nodemailer");

var User = require('../models/User');
var Patient = require('../models/Patient');

var Organisation = require('../models/Organisation');
var OrganisationType = require('../models/OrganizationType');
var PricingCategory = require('../models/PricingCategory');
var Payment = require('../models/Payment');
var ServiceCategory = require('../models/ServiceCategory');
var Settings = require('../models/Settings');
var PaymentCategory = require('../models/PaymentCategory');
const multer  = require('multer');
const fs = require('fs');


// Attachments

Organisation.belongsTo(User, {as: 'addedby_details',foreignKey: 'added_by'});
Organisation.belongsTo(User, {as: 'updatedby_details',foreignKey: 'updated_by'});
Organisation.belongsTo(OrganisationType, {as: 'type_details',foreignKey: 'type'});
// Organisation.belongsTo(DocumentTypes, {as: 'doctypes_details',foreignKey: 'category'});
//////Modal Relationship

exports.getOrganizationList = async (req, res) => {
    try {
      let offsetdata = parseInt(req.query.offset ? ((req.query.offset == undefined || req.query.offset == 1) ? 0 :req.query.offset) : 0);
      if(isNaN(offsetdata)){
          offsetdata = 0;
      }
      let datalimit = parseInt(req.query.limit ? ((req.query.limit == undefined) ? 5 :req.query.limit) : 5);
      if(isNaN(datalimit)){
          datalimit = 5;
      }
      const { count, rows } = await Organisation.findAndCountAll();
      OrganisationModal = await Organisation.findAll({attributes: ['id', 'code','nom','nom_commercial', 'email','portable_responsable_legal','type','adresse','est_active','is_light','status','added_by','updated_by',[Sequelize.fn("DATE_FORMAT", Sequelize.col("Organisation.createdAt"),"%d/%m/%Y %H:%i"),"createdAt"],[Sequelize.fn("DATE_FORMAT", Sequelize.col("Organisation.updatedAt"),"%d/%m/%Y %H:%i"),"updatedAt"]], 
                                order: [['id', 'DESC']],
                                limit: datalimit,
                                offset: offsetdata,
                                include: [{
                                    model: User,
                                    attributes: ['id', ['id_organisation','org_id'],'first_name','last_name', 'username','email'],
                                    as:'addedby_details'
                                },{
                                    model: User,
                                    attributes: ['id', ['id_organisation','org_id'],'first_name','last_name', 'username','email'],
                                    as:'updatedby_details'
                                },{
                                    model: OrganisationType,
                                    attributes: ['id', 'name'],
                                    as:'type_details'
                                }]
                            });
        if(OrganisationModal === null){
            res.json({ status: 0, message: 'No Data Found' });
        }else{
            res.json({ status: 1, message: 'Organization List', data: OrganisationModal,total:count });
        }
    } catch (error) {
        throw error;
    }
};

exports.getOrganizationByID = async (req, res) => {
    try {
      
      OrganisationModal = await Organisation.findAll({attributes: ['id', 'code','nom','nom_commercial', 'email','portable_responsable_legal','adresse','region','departement','type','est_active','is_light','status','added_by','updated_by',[Sequelize.fn("DATE_FORMAT", Sequelize.col("createdAt"),"%d/%m/%Y %H:%i"),"createdAt"],[Sequelize.fn("DATE_FORMAT", Sequelize.col("updatedAt"),"%d/%m/%Y %H:%i"),"updatedAt"]], 
                                    where: { id: req.params.org_id },
                                
                            });
        if(OrganisationModal === null){
            res.json({ status: 0, message: 'No Data Found' });
        }else{
            res.json({ status: 1, message: 'Organization List', data: OrganisationModal });
        }
    } catch (error) {
        throw error;
    }
};

exports.addOrganization = async (req, res) => {
    try { 
        // console.log(req.body);
        OrganisationModal = await Organisation.create({
                                nom: req.body.name,
                                type: req.body.type,
                                portable_responsable_legal: req.body.phone,
                                email: req.body.email,
                                age: req.body.terrification,
                                adresse: req.body.address,
                                country: req.body.country,
                                region: req.body.region,
                                district: req.body.district,
                                added_by:req.userId,
                                status:1,
                        });
            if(OrganisationModal === null){
                res.json({ status: 0, message: 'Something Went Wrong, Please Try Againg Later!!' });
            }else{
                res.json({ status: 1, message: 'New Organization Has been added.', data: '' });
            }
            
    } catch (error) {
        res.json({ status: 0, message: 'Server Error, Please Try Againg Later!!' });
        // throw error;
    }
};

exports.updateOrganization = async (req, res) => {
    try {
        OrganisationModal = await Organisation.update({
                                            nom: req.body.name,
                                            type: req.body.type,
                                            portable_responsable_legal: req.body.phone,
                                            email: req.body.email,
                                            age: req.body.terrification,
                                            adresse: req.body.address,
                                            pays: req.body.country,
                                            region: req.body.region,
                                            departement: req.body.district,
                                            updated_by: req.userId,
                                        }, 
                                        {
                                            where: {id: req.params.org_id}
                                        });
            if(OrganisationModal === null){
                res.json({ status: 0, message: 'Something Went Wrong, Please Try Againg Later!!' });
            }else{
                res.json({ status: 1, message: 'Organization has been updated.', data: '' });
            }

    } catch (error) {
        throw error;
    }
};
exports.statusOrganization = async (req, res) => {
    try {   
        OrganisationModal = await Organisation.update({status: req.body.status}, {where: {id: req.params.id}});
      if(OrganisationModal === null){
          res.json({ status: 0, message: 'Something Went Wrong, Please Try Againg Later!!' });
      }else{
          
          res.json({ status: 1, message: 'Organization status has been Updated.', data: '' });
      }
      
  } catch (error) {
      throw error;
  }
  };
exports.getPricingCategory = async (req, res) => {
    try {
      
        PricingCategoryModal = await PricingCategory.findAll({attributes: ['id', 'name','status','added_by','updated_by',[Sequelize.fn("DATE_FORMAT", Sequelize.col("createdAt"),"%d-%m-%Y %H:%i:%s"),"createdAt"],[Sequelize.fn("DATE_FORMAT", Sequelize.col("updatedAt"),"%d-%m-%Y %H:%i:%s"),"updatedAt"]], 
                                order: [['id', 'DESC']]
                            });
        if(PricingCategoryModal === null){
            res.json({ status: 0, message: 'No Data Found' });
        }else{
            res.json({ status: 1, message: 'Pricing Category List', data: PricingCategoryModal });
        }
    } catch (error) {
        throw error;
    }
};

exports.getOrganizationType = async (req, res) => {
    try {
      
        OrganisationTypeModal = await OrganisationType.findAll({attributes: ['id', 'name','status','added_by','updated_by',[Sequelize.fn("DATE_FORMAT", Sequelize.col("createdAt"),"%d-%m-%Y %H:%i:%s"),"createdAt"],[Sequelize.fn("DATE_FORMAT", Sequelize.col("updatedAt"),"%d-%m-%Y %H:%i:%s"),"updatedAt"]], 
                                order: [['id', 'DESC']],
                            });
        if(OrganisationTypeModal === null){
            res.json({ status: 0, message: 'No Data Found' });
        }else{
            res.json({ status: 1, message: 'Organization Types List', data: OrganisationTypeModal });
        }
    } catch (error) {
        throw error;
    }
};











