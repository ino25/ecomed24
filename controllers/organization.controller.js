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
var PatientDepositInvoice = require('../models/PatientDepositInvoice');
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


// Patient Deposit invoice
PatientDepositInvoice.belongsTo(User, {as: 'addedby_details',foreignKey: 'added_by'});
PatientDepositInvoice.belongsTo(User, {as: 'updatedby_details',foreignKey: 'updated_by'});
PatientDepositInvoice.belongsTo(Organisation, {as: 'org_details',foreignKey: 'id_organisation'});
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
      OrganisationModal = await Organisation.findAll({attributes: ['id', 'code','nom','nom_commercial', 'email','portable_responsable_legal','type','adresse','est_active','is_light','other_emails','pricing_category','is_whatsapp','status','added_by','updated_by',[Sequelize.fn("DATE_FORMAT", Sequelize.col("Organisation.createdAt"),"%d/%m/%Y %H:%i"),"createdAt"],[Sequelize.fn("DATE_FORMAT", Sequelize.col("Organisation.updatedAt"),"%d/%m/%Y %H:%i"),"updatedAt"]], 
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
      
      OrganisationModal = await Organisation.findAll({attributes: ['id', 'code','nom','nom_commercial', 'email','portable_responsable_legal','adresse','region','departement','type','est_active','is_light','other_emails','pricing_category','is_whatsapp','status','added_by','updated_by',[Sequelize.fn("DATE_FORMAT", Sequelize.col("createdAt"),"%d/%m/%Y %H:%i"),"createdAt"],[Sequelize.fn("DATE_FORMAT", Sequelize.col("updatedAt"),"%d/%m/%Y %H:%i"),"updatedAt"]], 
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
                                is_light: req.body.is_light,
                                email: req.body.email,
                                pricing_category: req.body.pricing_category,
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
                                            is_whatsapp: req.body.is_whatsapp,
                                            is_light: req.body.is_light,
                                            email: req.body.email,
                                            other_emails: req.body.other_emails,
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

exports.updatePricing = async (req, res) => {
    try {   
        OrganisationModal = await Organisation.update({pricing_category: req.body.pricing_category}, {where: {id: req.params.id}});
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




exports.getInvoicePaymentsByORG = async (req, res) => {
    try {

        let offsetdata = parseInt(req.query.offset ? ((req.query.offset == undefined || req.query.offset == 1) ? 0 :req.query.offset) : 0);
        if(isNaN(offsetdata)){
            offsetdata = 0;
        }
        let datalimit = parseInt(req.query.limit ? ((req.query.limit == undefined) ? 5 :req.query.limit) : 5);
        if(isNaN(datalimit)){
            datalimit = 5;
        }
        id_organisation = req.params.org_id;
      OrganisationModal = await Database.query(`SELECT 
      payment_pro.idpro,
      (select organisation.nom from organisation where organisation.id = payment_pro.id_organisation limit 1) as nom,
      (select organisation.nom from organisation where organisation.id = payment_pro.id_organisation_destinataire limit 1) as destinataire,
      payment_pro.statut,
      payment_pro.codepro,
      payment_pro.codefacture,
      DATE_FORMAT(FROM_UNIXTIME(payment_pro.date), '%d/%m/%Y %H:%i') AS date,
      DATE_FORMAT(FROM_UNIXTIME(payment_pro.dateDebut), '%d/%m/%Y %H:%i') AS dateDebut,
      DATE_FORMAT(FROM_UNIXTIME(payment_pro.dateFin), '%d/%m/%Y %H:%i') AS dateFin,
      payment_pro.amount,
      payment_pro.users_valided,
      DATE_FORMAT(FROM_UNIXTIME(payment_pro.date_paiement), '%d/%m/%Y %H:%i') AS date_paiement,
      payment_pro.canal_paiement,
      payment_pro.transfer,
      payment_pro.reference
      from payment_pro
      where payment_pro.id_organisation_destinataire = ${id_organisation} ORDER BY payment_pro.idpro DESC LIMIT ${offsetdata}, ${datalimit}`,{type: Database.QueryTypes.SELECT});
        if(OrganisationModal === null){
            res.json({ status: 0, message: 'No Data Found' });
        }else{
            res.json({ status: 1, message: 'Organization Invoice List', data: OrganisationModal });
        }
    } catch (error) {
        throw error;
    }
}

exports.getPaymentReceipt = async (req, res) => {
    try {
        let payment_id = req.params.payment_id;
        PaymentReceipt =  await Database.query("select payment_pro.codefacture,CONCAT(codefacture, '.pdf') AS file,'/uploads/invoicefile/' AS url from payment_pro where idpro=" + payment_id,{type: Database.QueryTypes.SELECT});
          if(PaymentReceipt === null){
              res.json({ status: 0, message: 'No Data Found' });
          }else{
              res.json({ status: 1, message: 'Payment Receipt', data: PaymentReceipt });
          }
      } catch (error) {
          throw error;
      }
}

exports.getPaymentDetails = async (req, res) => {
    let data = {};
    let payment_id = req.params.payment_id;
  data.settings = await Settings.findOne();
  PaymentDetails = await Database.query(`select payment_pro.idpro as id,
                                        (select organisation.nom from organisation where organisation.id = payment_pro.id_organisation_destinataire limit 1) as destinataire,
                                        payment_pro.codefacture,
                                        payment_pro.dateDebut,
                                        payment_pro.dateFin,
                                        payment_pro.amount,
                                        (SELECT SUM(deposited_amount) AS total_deposited_amount FROM patient_deposit_invoice where payment_id=payment_pro.idpro) as total_deposited_amount,
                                        (payment_pro.amount - (SELECT SUM(deposited_amount) AS total_deposited_amount 
                                        FROM patient_deposit_invoice where payment_id=payment_pro.idpro)) as total_due,
                                        payment_pro.id_organisation_destinataire 
                                        from payment_pro where idpro=${payment_id}`,{type: Database.QueryTypes.SELECT});
 
  //console.log(data.services);

  res.json({ status: 1, message: 'Payment Details', data: PaymentDetails });
}

exports.getDepositList = async (req, res) => {
    try {

        let offsetdata = parseInt(req.query.offset ? ((req.query.offset == undefined || req.query.offset == 1) ? 0 :req.query.offset) : 0);
        if(isNaN(offsetdata)){
            offsetdata = 0;
        }
        let datalimit = parseInt(req.query.limit ? ((req.query.limit == undefined) ? 5 :req.query.limit) : 5);
        if(isNaN(datalimit)){
            datalimit = 5;
        }
        let payment_id = req.params.payment_id;
      Deposits =  await Database.query(`select 
      payment_pro.codefacture, 
      patient_deposit_invoice.id,  
      patient_deposit_invoice.id_organisation, 
      patient_deposit_invoice.payment_id, 
      DATE_FORMAT(FROM_UNIXTIME(patient_deposit_invoice.date), '%d/%m/%Y %H:%i') AS date,
      DATE_FORMAT(FROM_UNIXTIME(payment_pro.dateDebut), '%d/%m/%Y %H:%i') AS start_date,
      DATE_FORMAT(FROM_UNIXTIME(payment_pro.dateFin), '%d/%m/%Y %H:%i') AS end_date,
      patient_deposit_invoice.deposited_amount, 
      patient_deposit_invoice.amount_received_id, 
      patient_deposit_invoice.deposit_type, 
      patient_deposit_invoice.gateway, 
      patient_deposit_invoice.id_transaction_externe, 
      patient_deposit_invoice.user, 
      patient_deposit_invoice.status, 
      patient_deposit_invoice.added_by, 
      patient_deposit_invoice.updated_by, 
      patient_deposit_invoice.createdAt, 
      patient_deposit_invoice.updatedAt 
      from patient_deposit_invoice, payment_pro where payment_pro.idpro = patient_deposit_invoice.payment_id and patient_deposit_invoice.payment_id=${payment_id} ORDER BY patient_deposit_invoice.id DESC LIMIT  ${offsetdata}, ${datalimit}`,{type: Database.QueryTypes.SELECT});
        if(Deposits === null){
            res.json({ status: 0, message: 'No Data Found' });
        }else{
            res.json({ status: 1, message: 'Organization Deposit List', data: Deposits });
        }
    } catch (error) {
        throw error;
    }
}

exports.addDeposit = async (req, res) => {
    try {
        let getData = [],getRelationData = [], results;
        console.log(req.body);
        PatientDepositInvoiceModal = await PatientDepositInvoice.create({ 
                                                    date: moment().unix(),
                                                    deposited_amount: req.body.deposited_amount,
                                                    payment_id: req.body.payment_id,
                                                    amount_received_id: req.body.amount_received_id,
                                                    deposit_type: req.body.deposit_type,
                                                    partner_id: req.body.partner_id,
                                                    reference: req.body.reference,
                                                    id_organisation: req.org_id,
                                                    user: req.userId,
                                                    added_by: req.userId,
            
                                        });
        if(PatientDepositInvoiceModal === null){
            return res.json({ status: 0, message: langCommon.errormessage });
        }else{



            return res.json({ status: 1, message: "New Deposit has been saved", data: '' });
        }
        
    } catch (error) {
        throw error;
    }
}











