const Sequelize = require('sequelize');
const Database = require('../config').sequelize;
const Op = Sequelize.Op;
const moment = require("moment");
moment.locale('en');
const path = require('path');
const nodemailer = require("nodemailer");

var User = require('../models/User');
var Patient = require('../models/Patient');
var Appointment = require('../models/Appointment');
var SettingService = require('../models/SettingService');
var SettingServiceSpecialiteOrganisation = require('../models/SettingServiceSpecialiteOrganisation');
var HolidaysService = require('../models/HolidaysService');
var TimeSlotService = require('../models/TimeSlotService');
var CurrentMedications = require('../models/CurrentMedications');
var PreConditions = require('../models/PreConditions');
var PatientRelation = require('../models/PatientRelation');
var PatientMaterial = require('../models/PatientMaterial');
var DocumentTypes = require('../models/DocumentTypes');
var VitalSign = require('../models/VitalSign');
var Organisation = require('../models/Organisation');
var PatientMutuelle = require('../models/PatientMutuelle');
var Payment = require('../models/Payment');
var ServiceCategory = require('../models/ServiceCategory');
var PatientDeposit = require('../models/PatientDeposit');
var Settings = require('../models/Settings');
var LabTest = require('../models/LabTest');
var PaymentCategory = require('../models/PaymentCategory');
var MasterMedicine = require('../models/MasterMedicine');
var ClinicalNotes = require('../models/ClinicalNotes');
var ConfidentialNotes = require('../models/ConfidentialNotes');
var DeathRecord = require('../models/DeathRecord');
var PatientHospitalization = require('../models/PatientHospitalization');
var PatientLogs = require('../models/PatientLogs');
var Prescriptions = require('../models/Prescriptions');
var TestRequests = require('../models/TestRequests');
var Illness = require('../models/Illness');
var IllnessConsultation = require('../models/IllnessConsultation');
const multer  = require('multer');
const fs = require('fs');

//////Modal Relationship



// Invoice Payments
exports.getInvoicePayments = async (req, res) => {
    try {
      let offsetdata = parseInt(req.query.offset ? ((req.query.offset == undefined || req.query.offset == 1) ? 0 :req.query.offset) : 0);
      if(isNaN(offsetdata)){
          offsetdata = 0;
      }
      let datalimit = parseInt(req.query.limit ? ((req.query.limit == undefined) ? 5 :req.query.limit) : 5);
      if(isNaN(datalimit)){
          datalimit = 5;
      }
      let id_organisation=req.org_id;
  // console.log(Sequelize);
    PaymentModal = await Database.query(`SELECT
    payment.id AS id,
    payment.date AS date,
    payment.code AS code,
    payment.status_paid_pro AS status_paid_pro,
    payment.status AS status,
    organisation.nom AS nom,
    patient.patient_id AS patient,
    CONCAT(patient.name, " ", patient.last_name) AS patient_name,
    payment.category_name_pro AS category_name_pro,
    payment.organisation_destinataire AS organisation_destinataire,
    payment.organisation_light_origin AS organisation_light_origin,
    payment.etat AS etat,
    payment.etatlight AS etatlight,
    payment.id_organisation AS id_organisation
FROM
    organisation
LEFT JOIN payment ON payment.id_organisation = organisation.id
LEFT JOIN patient ON patient.id = payment.patient
where organisation.id = ${id_organisation} and payment.status = 'accept' order by payment.id LIMIT ${datalimit} OFFSET ${offsetdata};`,{type: Database.QueryTypes.SELECT});
   
      if(PaymentModal === null){
          res.json({ status: 0, message: 'No Data Found' });
      }else{

        maindata = [];

        for(var i = 0; i < PaymentModal.length; i++) {
            var str_array = PaymentModal[i].category_name_pro.split(',');
            let data = [];
            let items = [];
            for(var j = 0; j < str_array.length; j++) {
                
                // items[i] = str_array[i].replace(/^\s*/, "").replace(/\s*$/, "").split('*');
                data.push({
                    'id': '',
                    'date': moment(PaymentModal[i].date).format('Y-m-d H:i:s'),
                    'code': PaymentModal[i].code,
                    'benefit': '',
                    'insurance': PaymentModal[i].nom,
                    'patient': PaymentModal[i].patient_name,
                    'amount': ''
                });
                
            }
            maindata = maindata.concat(data);
            // maindata.push(data);
        }
        
         console.log(maindata);
          res.json({ status: 1, message: 'Patient invoices and payments list', data: maindata,total:maindata.length });
      }
        
    } catch (error) {
        throw error;
    }
  };











