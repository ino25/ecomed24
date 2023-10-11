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

// Current Medications
CurrentMedications.belongsTo(User, {as: 'addedby_details',foreignKey: 'added_by'});
CurrentMedications.belongsTo(User, {as: 'updatedby_details',foreignKey: 'updated_by'});
CurrentMedications.belongsTo(Organisation, {as: 'org_details',foreignKey: 'org_id'});

// known Health issue
PreConditions.belongsTo(User, {as: 'addedby_details',foreignKey: 'added_by'});
PreConditions.belongsTo(User, {as: 'updatedby_details',foreignKey: 'updated_by'});
PreConditions.belongsTo(Organisation, {as: 'org_details',foreignKey: 'org_id'});

// Attachments

PatientMaterial.belongsTo(User, {as: 'addedby_details',foreignKey: 'added_by'});
PatientMaterial.belongsTo(User, {as: 'updatedby_details',foreignKey: 'updated_by'});
PatientMaterial.belongsTo(Organisation, {as: 'org_details',foreignKey: 'id_organisation'});
PatientMaterial.belongsTo(DocumentTypes, {as: 'doctypes_details',foreignKey: 'category'});
// Vital Sign
VitalSign.belongsTo(User, {as: 'addedby_details',foreignKey: 'added_by'});
VitalSign.belongsTo(User, {as: 'updatedby_details',foreignKey: 'updated_by'});
VitalSign.belongsTo(Organisation, {as: 'org_details',foreignKey: 'id_organisation'});

// Appointment
Appointment.belongsTo(User, {as: 'addedby_details',foreignKey: 'added_by'});
Appointment.belongsTo(User, {as: 'updatedby_details',foreignKey: 'updated_by'});
Appointment.belongsTo(Organisation, {as: 'org_details',foreignKey: 'id_organisation'});

// Appointment
Payment.belongsTo(User, {as: 'addedby_details',foreignKey: 'added_by'});
Payment.belongsTo(User, {as: 'updatedby_details',foreignKey: 'updated_by'});
Payment.belongsTo(Organisation, {as: 'org_details',foreignKey: 'id_organisation'});


// Assurance
PatientMutuelle.belongsTo(User, {as: 'addedby_details',foreignKey: 'added_by'});
PatientMutuelle.belongsTo(User, {as: 'updatedby_details',foreignKey: 'updated_by'});
PatientMutuelle.belongsTo(Organisation, {as: 'org_details',foreignKey: 'id_organisation'});
PatientMutuelle.belongsTo(Organisation, {as: 'nom_mutuelle_details',foreignKey: 'pm_idmutuelle'});


// Dependants
PatientRelation.belongsTo(Patient, {as: 'parent_details',foreignKey: 'parent_id'});
PatientRelation.belongsTo(Patient, {as: 'dependant_details',foreignKey: 'relative_id'});
PatientRelation.belongsTo(User, {as: 'addedby_details',foreignKey: 'added_by'});
PatientRelation.belongsTo(User, {as: 'updatedby_details',foreignKey: 'updated_by'});
PatientRelation.belongsTo(Organisation, {as: 'org_details',foreignKey: 'org_id'});

// Clinical Notes
ClinicalNotes.belongsTo(User, {as: 'addedby_details',foreignKey: 'added_by'});
ClinicalNotes.belongsTo(User, {as: 'updatedby_details',foreignKey: 'updated_by'});
ClinicalNotes.belongsTo(Organisation, {as: 'org_details',foreignKey: 'org_id'});

// Confidential Notes
ConfidentialNotes.belongsTo(User, {as: 'addedby_details',foreignKey: 'added_by'});
ConfidentialNotes.belongsTo(User, {as: 'updatedby_details',foreignKey: 'updated_by'});
ConfidentialNotes.belongsTo(Organisation, {as: 'org_details',foreignKey: 'org_id'});

// Death Record
DeathRecord.belongsTo(User, {as: 'addedby_details',foreignKey: 'added_by'});
DeathRecord.belongsTo(User, {as: 'updatedby_details',foreignKey: 'updated_by'});
DeathRecord.belongsTo(Organisation, {as: 'org_details',foreignKey: 'org_id'});

// Hospitalization
PatientHospitalization.belongsTo(User, {as: 'addedby_details',foreignKey: 'added_by'});
PatientHospitalization.belongsTo(User, {as: 'updatedby_details',foreignKey: 'updated_by'});
PatientHospitalization.belongsTo(Organisation, {as: 'org_details',foreignKey: 'org_id'});

// Prescriptions
Prescriptions.belongsTo(User, {as: 'addedby_details',foreignKey: 'added_by'});
Prescriptions.belongsTo(User, {as: 'updatedby_details',foreignKey: 'updated_by'});
Prescriptions.belongsTo(Organisation, {as: 'org_details',foreignKey: 'org_id'});

// Requests
TestRequests.belongsTo(User, {as: 'addedby_details',foreignKey: 'added_by'});
TestRequests.belongsTo(User, {as: 'updatedby_details',foreignKey: 'updated_by'});
TestRequests.belongsTo(Organisation, {as: 'org_details',foreignKey: 'org_id'});

// Timeline
PatientLogs.belongsTo(User, {as: 'addedby_details',foreignKey: 'added_by'});
PatientLogs.belongsTo(User, {as: 'updatedby_details',foreignKey: 'updated_by'});
PatientLogs.belongsTo(Organisation, {as: 'org_details',foreignKey: 'org_id'});

const BASEURL = process.env.SITE_URL;

exports.getAllPatients = async (req, res) => {
  try {
    let offsetdata = parseInt(req.query.offset ? ((req.query.offset == undefined || req.query.offset == 1) ? 0 :req.query.offset) : 0);
    if(isNaN(offsetdata)){
        offsetdata = 0;
    }
    let datalimit = parseInt(req.query.limit ? ((req.query.limit == undefined) ? 5 :req.query.limit) : 5);
    if(isNaN(datalimit)){
        datalimit = 5;
    }
    const { count, rows } = await Patient.findAndCountAll({where: { id_organisation: req.org_id }});
      PatientModal = await Patient.findAll({ 
          attributes: ['id','unique_id', 'name','last_name',['patient_id','code'],['sex','gender'], 'age','email','phone','address','region',['registration_time','register'],'grade','estCivil','passport','matricule',['bloodgroup','blood_type'],'birthdate',['birth_position','birth_place'],'religion','img_url',['nom_contact','emergency_contact_name'],['phone_contact','emergency_contact_no']],
          order: [['id', 'DESC']],
          limit: datalimit,
          offset: offsetdata,
          where: { id_organisation: req.org_id }
         });
      if(PatientModal === null){
          res.json({ status: 0, message: 'No Data Found' });
      }else{
          res.json({ status: 1, message: 'Patient List', data: PatientModal,total:count });
      }
  } catch (error) {
      throw error;
  }
};

exports.updateUniqueID = async (req, res) => {
  try {
    PatientModal = await Patient.findAll({ });
    if(PatientModal === null){
        res.json({ status: 0, message: 'No Data Found' });
    }else{
        PatientModal.map(async patient => {
            await Patient.update({ unique_id: '2101'+patient.id_organisation+patient.id }, {where: {id: patient.id}});
        })
        res.json({ status: 1, message: 'Unique Patient ID Generated', data: '' });
    }
  } catch (error) {
      throw error;
  }
};

exports.addPatient = async (req, res) => {
  try { 
      PatientModal = await Patient.create({
                              name: req.body.name,
                              last_name: req.body.last_name,
                              sex: req.body.sex,
                              birthdate: moment(req.body.birthdate).format('DD/MM/YYYY'),
                              age: req.body.age,
                              phone: req.body.phone,
                              email: req.body.email,
                              passport: req.body.passport,
                              address: req.body.address,
                              region: req.body.region,
                              estCivil: req.body.estCivil,
                              bloodgroup: req.body.bloodgroup,
                              birth_position: req.body.birth_position,
                              nom_contact: req.body.nom_contact,
                              phone_contact: req.body.phone_contact,
                              religion: req.body.religion,
                              matricule: req.body.matricule,
                              grade: req.body.grade,
                              parent_id: req.body.parent_id,
                              unique_id:req.body.unique_id,
                              registration_time: moment().unix(),
                              add_date: moment().format('MM/DD/YY'),
                              id_organisation:req.org_id,
                              added_by:req.userId,
                              img_url:req.files.profile[0].filename,
                              status:1,
                      });
          if(PatientModal === null){
              res.json({ status: 0, message: 'Something Went Wrong, Please Try Againg Later!!' });
          }else{
              res.json({ status: 1, message: 'New Patient Has been added.', data: '' });
          }
          
  } catch (error) {
      throw error;
  }
};

exports.getGeneralInfo = async (req, res) => {
  try {
    let getData = {};
    PatientModal = await Patient.findOne({ 
        attributes: ['id','unique_id', 'name','last_name',['patient_id','code'],['sex','gender'], 'age','email','phone','address','region',['registration_time','register'],'grade','estCivil','passport','matricule',['bloodgroup','blood_type'],'birthdate',['birth_position','birth_place'],'religion','img_url',['nom_contact','emergency_contact_name'],['phone_contact','emergency_contact_no']],
        where: { id: req.params.patient_id },
       
    });
    // console.log(PatientModal);
    if(PatientModal === null){
        res.json({ status: 0, message: 'No Data Found' });
    }else{
        if (PatientModal.img_url) {
            PatientModal.img_url = BASEURL+"/uploads/imgUsers/" + PatientModal.img_url;
        } else {
            PatientModal.img_url = BASEURL+"/uploads/user-profile-placeholder.png";
        }
        next_appointment = await Appointment.findOne({ attributes: ['id','patient', 'id_organisation','time_slot','s_time','e_time','appointment_date'],where: { status: 'Confirmed',patient: req.params.patient_id,appointment_date:{[Op.gte]:moment().format('YYYY-MM-DD')} },order:[['appointment_date', 'ASC']]});
        last_appointment = await Appointment.findOne({ attributes: ['id','patient', 'id_organisation','time_slot','s_time','e_time','appointment_date'],where: { status: 'Treaty',patient: req.params.patient_id,appointment_date:{[Op.lte]:moment().format('YYYY-MM-DD')} },order:[['appointment_date', 'DESC']]});
        // console.log(PatientModal.dataValues);         
        res.json({ status: 1, message: 'Patient General INFO', data: PatientModal,next_appointment: next_appointment,last_appointment:last_appointment});
    }
    
} catch (error) {
    res.json({ status: 0, message: error, data: '' });
    // throw error;
}
};

exports.updateGeneralInfo = async (req, res) => {
  try {
    let getData, getProfile = [], file, results;
    getData =   { 
                    name: req.body.name,
                    last_name: req.body.last_name,
                    sex: req.body.sex,
                    birthdate: req.body.birthdate,
                    age: req.body.age,
                    phone: req.body.phone,
                    email: req.body.email,
                    passport: req.body.passport,
                    address: req.body.address,
                    region: req.body.region,
                    estCivil: req.body.estCivil,
                    bloodgroup: req.body.bloodgroup,
                    birth_position: req.body.birth_position,
                    nom_contact: req.body.nom_contact,
                    phone_contact: req.body.phone_contact,
                    religion: req.body.religion,
                    matricule: req.body.matricule,
                    grade: req.body.grade,
                    updated_by: req.userId,    
                };
                
            if(req.files.profile){
                getData.img_url = req.files.profile[0].filename;
            }
            // console.log(getData);
        PatientModal = await Patient.update(getData, {where: {id: req.params.patient_id}
                            });
        if(PatientModal === null){
            res.json({ status: 0, message: 'Something Went Wrong, Please Try Againg Later!!' });
        }else{
            // if (PatientModal.img_url) {
            //     PatientModal.img_url = "/uploads/imgUsers/user_pic/" + PatientModal.img_url;
            // } else {
            //     PatientModal.img_url = "/uploads/imgUsers/user-profile-placeholder.png";
            // }
            res.json({ status: 1, message: 'Patient Details Updated.', data: '' });
        }
        
} catch (error) {
    throw error;
}
};

// Appointment
exports.getAppontments = async (req, res) => {
  try {
    let offsetdata = parseInt(req.query.offset ? ((req.query.offset == undefined || req.query.offset == 1) ? 0 :req.query.offset) : 0);
    if(isNaN(offsetdata)){
        offsetdata = 0;
    }
    let datalimit = parseInt(req.query.limit ? ((req.query.limit == undefined) ? 5 :req.query.limit) : 5);
    if(isNaN(datalimit)){
        datalimit = 5;
    }
    const { count, rows } = await Appointment.findAndCountAll({where: { patient: req.params.patient_id }});
    AppointmentModal = await Appointment.findAll({attributes: ['id', 'date','time_slot','service', 'servicename','tele_consultation','remarks','status','appointment_date','added_by','updated_by',[Sequelize.fn("DATE_FORMAT", Sequelize.col("createdAt"),"%d-%m-%Y %H:%i:%s"),"createdAt"],[Sequelize.fn("DATE_FORMAT", Sequelize.col("updatedAt"),"%d-%m-%Y %H:%i:%s"),"updatedAt"]], 
                                                    where: { patient: req.params.patient_id },
                                                    order: [['id', 'DESC']],
                                                    limit: datalimit,
                                                    offset: offsetdata
                                                });
      if(AppointmentModal === null){
          res.json({ status: 0, message: 'No Data Found' });
      }else{
          res.json({ status: 1, message: 'Patient Appointment List', data: AppointmentModal,total:count });
      }
      
  } catch (error) {
      throw error;
  }
};
exports.getAppointmentByID = async (req, res) => {
  try {
    let getData = [];
    AppointmentModal = await Appointment.findOne({attributes: ['id', 'date','appointment_date','time_slot','service', 'servicename','tele_consultation','remarks','status'], where: { id: req.params.appointment_id } });
    if(AppointmentModal === null){
        res.json({ status: 0, message: 'No Data Found' });
    }else{
        res.json({ status: 1, message: 'Appointment has been fetched', data: AppointmentModal });
    }
    
  } catch (error) {
      throw error;
  }
};
exports.addAppontment = async (req, res) => {
  try {
    // let getData = [], getProfile = [], file, results;
    console.log(req.body);
    PatientModal = await Patient.findOne({where : {id:req.body.uniqueID}});
    let room_id = 'teleconsulation_ecomed24-'+ PatientModal.phone + '-' + Math.floor((Math.random() * 444444) + 1000000);
    let live_meeting_link = 'https://teleconsultation.ecomed24.com/' + room_id;
        AppointmentModal = await Appointment.create({ 
            patient: req.body.uniqueID,
            code: req.body.code,
            id_organisation: req.org_id,
            doctor: req.body.doctor,
            date: moment(req.body.date).unix(),
            time_slot: req.body.time_slot,
            s_time: req.body.s_time,
            e_time: req.body.e_time,
            remarks: req.body.remarks,
            add_date: moment().format('MM/DD/YYYY'),
            registration_time: moment().unix(),
            s_time_key: req.body.s_time_key,
            status: req.body.status,
            user: req.userId,
            request: req.body.request,
            patientname: req.body.patientname,
            doctorname: req.body.doctorname,
            service: req.body.service,
            servicename: req.body.servicename,
            room_id: room_id,
            live_meeting_link: live_meeting_link,
            appointment_date:moment(req.body.date).format('YYYY-MM-DD'),
            tele_consultation: req.body.tele_consultation == 1 ? 1 : 0,
            added_by: req.userId,
    });
    
    if(AppointmentModal === null){
        res.json({ status: 0, message: 'Something Went Wrong, Please Try Againg Later!!' });
    }else{
        await PatientLogs.create({
            patient_id: AppointmentModal.patient,
            org_id: req.org_id,
            description: 'New Appointment has been generated.',
            type: 'appointment',
            relation_id: AppointmentModal.id,
            status: 1,
            added_by: req.userId
        });
        res.json({ status: 1, message: 'New Appointment has been generated.', data: '' });
    }
    
  } catch (error) {
      throw error;
  }
};
exports.updateAppontment = async (req, res) => {
  try {
    let getData = [], getProfile = [], file, results;
    console.log();
    // PatientModal = await Patient.findOne({where : {id:req.body.uniqueID}});
    
        AppointmentModal = await Appointment.update({ 
            date: moment(req.body.date).unix(),
            time_slot: req.body.time_slot,
            s_time: req.body.s_time,
            e_time: req.body.e_time,
            remarks: req.body.remarks,
            s_time_key: req.body.s_time_key,
            status: req.body.status,
            service: req.body.service,
            servicename: req.body.servicename,
            appointment_date:moment(req.body.date).format('YYYY-MM-DD'),
            updated_by: req.userId,
            tele_consultation: req.body.tele_consultation == 1 ? 1 : 0,
    }, {
        where: {id: req.params.id}
    });
    
    if(AppointmentModal === null){
        res.json({ status: 0, message: 'Something Went Wrong, Please Try Againg Later!!' });
    }else{
        AppointmentData = await Appointment.findOne({attributes: ['id','patient'], where: { id: req.params.id } }); 
        console.log(AppointmentData);
        await PatientLogs.create({
            patient_id: AppointmentData.patient,
            org_id: req.org_id,
            description: 'Appointment has been Updated.',
            type: 'appointment',
            relation_id: AppointmentData.id,
            status: 1,
            added_by: req.userId
        });
        res.json({ status: 1, message: 'Appointment has been Updated.', data: '' });
    }
    
  } catch (error) {
      throw error;
  }
};
exports.deleteAppontment = async (req, res) => {
  try {
    AppointmentModal = await Appointment.destroy({where: {id: req.params.id}});
    if(AppointmentModal === null){
        res.json({ status: 0, message: 'Something Went Wrong, Please Try Againg Later!!' });
    }else{
        res.json({ status: 1, message: 'Appointment has been Deleted.', data: '' });
    }
  } catch (error) {
  throw error;
  }
};
exports.statusAppontment = async (req, res) => {
  try {
    AppointmentData = await Appointment.findOne({attributes: ['id','patient'], where: { id: req.params.id } });     
    console.log(AppointmentData);
    AppointmentModal = await Appointment.update({status: req.body.status}, {where: {id: req.params.id}});
    if(AppointmentModal === null){
        res.json({ status: 0, message: 'Something Went Wrong, Please Try Againg Later!!' });
    }else{
        await PatientLogs.create({
            patient_id: AppointmentData.patient,
            org_id: req.org_id,
            description: 'Appointment status has been Updated.',
            type: 'appointment',
            relation_id: AppointmentData.id,
            status: 1,
            added_by: req.userId
        });
        res.json({ status: 1, message: 'Appointment status has been Updated.', data: '' });
    }
    
} catch (error) {
    throw error;
}
};
exports.serviceAppontment = async (req, res) => {
  try {
    let getData = [];
    SettingServiceModal = await SettingService.findAll({
        attributes: ['idservice', 'name_service'],
        where: {status_service: 1}
      });
    if(SettingServiceModal === null){
        res.json({ status: 0, message: 'No Data Found' });
    }else{
        res.json({ status: 1, message: 'Appointment services', data: SettingServiceModal });
    }
    
} catch (error) {
    throw error;
}
};
exports.timeSlotAppontment = async (req, res) => {
  try {
    let getData = [];
    HolidaysServiceModal = await HolidaysService.findAll();
    console.log(req.body);
   
    // console.log(moment(req.body.date).format("MM/DD/yyyy") );
    // console.log(moment(req.body.date).format("dddd") );
    TimeSlotServiceModal = await TimeSlotService.findAll({
        attributes: ['id', 'service','s_time','e_time',[Sequelize.fn('CONCAT', Sequelize.col(`s_time`),' - ',Sequelize.col(`e_time`)), 'time_slots']],
        where: {service: req.body.service,weekday: moment(req.body.date).format("dddd")},order: [['s_time_key', 'asc']]
    });
    
    // if(HolidaysServiceModal.length === 0){
    //     AppointmentModal = await Appointment.findAll({where: {date: req.params.id,service: req.params.id}});
    //     TimeSlotServiceModal = await TimeSlotService.findAll({where: {service: req.params.id,weekday: req.params.id},order: [['s_time_key', 'asc']]});
    // }
    if(TimeSlotServiceModal === null){
        res.json({ status: 0, message: 'No Data Found' });
    }else{
        res.json({ status: 1, message: 'Available time slots', data: TimeSlotServiceModal });
    }
    
} catch (error) {
    throw error;
}
};

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
    const { count, rows } = await Payment.findAndCountAll({where: { patient: req.params.patient_id }});
    PaymentModal = await Payment.findAll({ 
        attributes: ['id','date', 'code','amount','gross_total','amount_received','status_paid','added_by','updated_by',[Sequelize.fn("DATE_FORMAT", Sequelize.col("createdAt"),"%d-%m-%Y %H:%i:%s"),"createdAt"],[Sequelize.fn("DATE_FORMAT", Sequelize.col("updatedAt"),"%d-%m-%Y %H:%i:%s"),"updatedAt"]],
        where: { patient: req.params.patient_id,bulletinAnalyse: ''},
        order:[['id','DESC']],
        limit: datalimit,
        offset: offsetdata
    });
    if(PaymentModal === null){
        res.json({ status: 0, message: 'No Data Found' });
    }else{
        res.json({ status: 1, message: 'Patient invoices and payments list', data: PaymentModal,total:count });
    }
      
  } catch (error) {
      throw error;
  }
};
exports.addDepositInvoicePayments = async (req, res) => {
  try {
    let getData = [],getRelationData = [], results;
    paymentDetails = await Payment.findOne({where:{id: req.body.paymentid}});
    if(req.body.deposit_type == 'Cash'){
        deposited_amount = parseInt(req.body.deposited_amount) + parseInt(paymentDetails.amount_received ? paymentDetails.amount_received : 0);
        console.log(deposited_amount);
        if(parseInt(paymentDetails.gross_total) + parseInt(paymentDetails.frais_service) < deposited_amount){
           return res.json({ status: 0, message: 'You can not deposit more then remaining amount!!' });
        }  
        
        let status_paid = 'unpaid';
        let status = paymentDetails.status;

        if(paymentDetails.gross_total == deposited_amount){
            status_paid = 'paid';
        }

        if(paymentDetails.status == 'new'){
            data_amount_received = {
                                    'amount_received' : deposited_amount, 
                                    'status' : 'pending', 
                                    'status_paid' : status_paid
                                };
        }else{
            data_amount_received = {
                                    'amount_received' : deposited_amount, 
                                    'status' : status, 
                                    'status_paid' : status_paid
                                };
        }
        PaymentUpdate = await Payment.update(data_amount_received,{where:{id: paymentDetails.id}});

        PatientDepositModal = await PatientDeposit.create({ 
                                        patient: req.body.patient_id,
                                        id_organisation: req.org_id,
                                        payment_id: req.body.paymentid,
                                        date: moment().unix(),
                                        deposited_amount: req.body.deposited_amount,
                                        deposit_type: req.body.deposit_type,
                                        user: req.userId,
                                        status: 1,
                                        added_by: req.userId
                                    });
        if(PatientDepositModal === null){
            return res.json({ status: 0, message: 'Something Went Wrong, Please Try Againg Later!!' });
        }else{
            return res.json({ status: 1, message: 'New Deposit has been Added..', data: PatientDepositModal });
        }
    }else if(req.body.deposit_type == 'OrangeMoney'){
            return res.json({ status: 0, message: 'Orange Money not integrated' });
    }
    
} catch (error) {
    throw error;
}
};
exports.getReceiptInvoicePayments = async (req, res) => {
  try {
    let data = {};
    // getData.push(req.params.invoice_id);
    SettingsModal = await Settings.findOne({attributes: ['discount'] });
    PaymentModal = await Payment.findOne({
        where: { id: req.params.invoice_id},
        include: [{
            model: User,
            attributes: ['id', ['id_organisation','org_id'],'first_name','last_name', 'username','email','phone'],
            as:'addedby_details'
        },{
            model: User,
            attributes: ['id', ['id_organisation','org_id'],'first_name','last_name', 'username','email'],
            as:'updatedby_details'
        },{
            model: Organisation,
            attributes: ['id', 'nom','email','adresse'],
            as:'org_details'
        }]
    });
    SettingsModalAll = await Settings.findOne();
    OrganisationModal = await Organisation.findOne({attributes: ['path_logo','nom','entete','footer','signature'] ,where: { id: req.org_id} });
    /*OrganisationModal = await Organisation.findOne({where: { id: req.org_id} });*/
    data.discount_type = SettingsModal.discount;
    data.payment = PaymentModal;
    data.patient = await Patient.findOne({where: { id: PaymentModal.patient} });
    var str_array = PaymentModal.category_name.split(',');
    console.log(str_array);
    let items = [];
    for(var i = 0; i < str_array.length; i++) {
       // Trim the excess whitespace.
       items[i] = str_array[i].replace(/^\s*/, "").replace(/\s*$/, "").split('*');
       // Add additional code here, such as:
       if(items[i][5] == 'service'){
           Pycategory  = await PaymentCategory.findOne({where: { id: items[i][0]} });
           items[i][0] = Pycategory.prestation;
       }else{
            Pycategory  = await LabTest.findOne({where: { id: items[i][0]} });
           items[i][0] = Pycategory.name;
       }
       let amount = items[i][1]
       items[i][1] = parseInt(amount).toFixed(1) + ' '+SettingsModalAll.currency;

       
       items[i][3] = (parseInt(amount) * parseInt(items[i][3])) + ' '+SettingsModalAll.currency;
       
    }
    data.items = items;
    console.log(items);
    data.settings = SettingsModalAll;
    data.id_organisation = req.org_id;
    /*data.organisation = OrganisationModal;*/
    data.path_logo = OrganisationModal.path_logo ? BASEURL+'/'+OrganisationModal.path_logo:null;
    data.nom_organisation = OrganisationModal.nom;
    data.entete = OrganisationModal.entete ? BASEURL+'/'+OrganisationModal.entete:null;
    data.footer = OrganisationModal.footer ? BASEURL+'/'+OrganisationModal.footer:null;
    data.signature = OrganisationModal.signature ? BASEURL+'/'+OrganisationModal.signature:null;

        res.json({ status: 1, message: 'Receipt', data: data });

} catch (error) {
    throw error;
}
};
exports.getServiceInvoicePayments = async (req, res) => {
  try {
    let getData = [];
    getData.push(req.org_id);
    ServiceCategoryModal = await ServiceCategory.findAll({ 
        attributes: ['id','category', 'montant','amount','id_organisation'],
        where: { id_organisation: req.org_id} });

    if(ServiceCategoryModal === null){
        res.json({ status: 0, message: 'No Data Found' });
    }else{
        res.json({ status: 1, message: 'Service Category list', data: ServiceCategoryModal });
    }
    
} catch (error) {
    throw error;
}
};
exports.getPartnerOrgInvoicePayments = async (req, res) => {
  try {
    let getData = [];
    OrganisationModal = await Organisation.findAll({attributes: ['id','nom'],where: { is_light: 0} });
    if(OrganisationModal === null){
        res.json({ status: 0, message: 'No Data Found' });
    }else{
        res.json({ status: 1, message: 'Light Organization list', data: OrganisationModal });
    }
} catch (error) {
    throw error;
}
};
exports.getLightOrgInvoicePayments = async (req, res) => {
  try {
    let getData = [];
    OrganisationModal = await Organisation.findAll({attributes: ['id','nom'],where: { is_light: 1} });
    if(OrganisationModal === null){
        res.json({ status: 0, message: 'No Data Found' });
    }else{
        res.json({ status: 1, message: 'Light Organization list', data: OrganisationModal });
    }
} catch (error) {
    throw error;
}
};
exports.getPaymentDetailsInvoicePayments = async (req, res) => {
  let data = {};
  data.labs = [];
  data.patient = await Patient.findOne({where: { id: req.params.patient_id} });
  SettingsModal = await Settings.findOne({attributes: ['discount'] });
  data.discount_type = SettingsModal.discount;
  data.currentuser = await User.findOne({attributes: ['id', ['id_organisation','org_id'],'first_name','last_name', 'username','email'],where:{id: req.userId}});
  data.mutuelles = await PatientMutuelle.findAll({ 
      attributes: [['idpm','id'],['pm_idmutuelle','payer_name'], 'pm_idmutuelle','pm_numpolice','pm_charge','pm_datevalid','added_by','updated_by',[Sequelize.fn("DATE_FORMAT", Sequelize.col("createdAt"),"%d-%m-%Y %H:%i:%s"),"createdAt"],[Sequelize.fn("DATE_FORMAT", Sequelize.col("updatedAt"),"%d-%m-%Y %H:%i:%s"),"updatedAt"]],
      where: { pm_idpatent: req.params.patient_id,pm_status: 1},
      order:[['id','DESC']],
      include: [{
          model: User,
          attributes: ['id', ['id_organisation','org_id'],'first_name','last_name', 'username','email'],
          as:'addedby_details'
      },{
          model: User,
          attributes: ['id', ['id_organisation','org_id'],'first_name','last_name', 'username','email'],
          as:'updatedby_details'
      },{
          model: Organisation,
          attributes: ['id', 'nom','email','adresse'],
          as:'org_details'
      },{
          model: Organisation,
          attributes: ['id', 'nom','email','adresse'],
          as:'nom_mutuelle_details'
      }] });
  data.mutuelles_relation	 = await Patient.findAll({where: { parent_id: req.params.patient_id} });
  data.mutuellesInit = [];
  data.lien_parente = '';
  data.mutuelles_relationInit = [];
  if(data.patient.parent_id){
      data.mutuellesInit = await PatientMutuelle.findAll({ 
                          attributes: [['idpm','id'],['pm_idmutuelle','payer_name'], 'pm_idmutuelle','pm_numpolice','pm_charge','pm_datevalid','added_by','updated_by',[Sequelize.fn("DATE_FORMAT", Sequelize.col("createdAt"),"%d-%m-%Y %H:%i:%s"),"createdAt"],[Sequelize.fn("DATE_FORMAT", Sequelize.col("updatedAt"),"%d-%m-%Y %H:%i:%s"),"updatedAt"]],
                          where: { pm_idpatent: data.patient.parent_id,pm_status: 1},
                          order:[['id','DESC']],
                          include: [{
                              model: User,
                              attributes: ['id', ['id_organisation','org_id'],'first_name','last_name', 'username','email'],
                              as:'addedby_details'
                          },{
                              model: User,
                              attributes: ['id', ['id_organisation','org_id'],'first_name','last_name', 'username','email'],
                              as:'updatedby_details'
                          },{
                              model: Organisation,
                              attributes: ['id', 'nom','email','adresse'],
                              as:'org_details'
                          },{
                              model: Organisation,
                              attributes: ['id', 'nom','email','adresse'],
                              as:'nom_mutuelle_details'
                          }] });
      data.mutuelles_relationInit = await Patient.findAll({where: { id: data.patient.parent_id} });
      data.lien_parente = 'Autres';
      if(data.patient.lien_parente == 'Pere'){
          data.lien_parente = 'Enfant';
      }else if(data.patient.lien_parente == 'Mere'){
          data.lien_parente = 'Enfant';
      }else if(data.patient.lien_parente == 'Enfant'){
          data.lien_parente = 'Parent';
      }
      
  }
  let bonus_clause='';
  let bonus_select='';
  let id_organisation=req.org_id;
  // console.log(Sequelize);
  data.services = await Database.query("select payment_category.id, payment_category.prestation,payment_category_organisation.tarif_public, payment_category_organisation.tarif_professionnel, payment_category_organisation.tarif_assurance, payment_category_organisation.tarif_ipm, setting_service_specialite.name_specialite "+bonus_select+" from setting_service_specialite_organisation join setting_service_specialite on setting_service_specialite.idspe = setting_service_specialite_organisation.id_specialite and setting_service_specialite_organisation.statut = 1 join setting_service on setting_service_specialite_organisation.id_service = setting_service.idservice and setting_service_specialite_organisation.id_organisation = "+id_organisation+" and setting_service_specialite_organisation.statut = 1 join payment_category on payment_category.id_service = setting_service.idservice and payment_category.id_spe = setting_service_specialite_organisation.id_specialite join payment_category_organisation on payment_category_organisation.id_presta = payment_category.id and payment_category_organisation.id_organisation = setting_service_specialite_organisation.id_organisation "+bonus_clause+" order by payment_category.prestation asc",{type: Database.QueryTypes.SELECT});
  data.labs = await LabTest.findAll({where: { id_organisation: req.org_id} });
  //console.log(data.services);

  res.json({ status: 1, message: 'Payment Details', data: data });
};
exports.addPayments = async (req, res) => {
  try {
    let getData = [],getRelationData = [], results, items = [];
      let amount_received = req.body.amount_received ? req.body.amount_received : 0 ;
      let services = req.body.services;
      console.log(req);
      for(var i = 0; i < services.length; i++) {
          if(services[i].type == 'service'){
            items[i] = services[i].id+'*'+services[i].amount+'*1*1*1*'+services[i].type;
           }else{
            items[i] = services[i].id+'*'+services[i].amount+'*'+services[i].name+'*1*1*'+services[i].type;
           }
      }

   PatientModal = await Patient.findOne({where: { id: req.body.patient_id} });
    PaymentModal = await Payment.create({ 
        category_name: items.join(','),
        category_name_pro: req.category_name_pro,
        patient: req.body.patient_id,
        date: moment().unix(),
        amount: req.body.total_amount,
        doctor: req.userId,
        service: '1',
        discount: req.body.discount,
        flat_discount: req.body.discount,
        gross_total: req.body.hospital_amount - req.body.discount,
        hospital_amount: req.body.hospital_amount,
        doctor_amount: req.body.doctor_amount,
        user: req.userId,
        patient_name: PatientModal.name+ ''+PatientModal.last_name,
        patient_phone: PatientModal.phone,
        patient_address: PatientModal.address,
        doctor_name: 'Sagar Sharma',
        date_string: moment().format('d/m/Y H:i'),
        id_organisation: req.org_id,
        remarks: req.body.remarks,
        charge_mutuelle:req.body.charge_mutuelle,
        etat: req.body.subcontractor,
        etatlight: req.body.subcontractor_light,
        organisation_destinataire: req.body.subcontractor_id,
        organisation_light_origin: req.body.subcontractor_light_id,
        prescripteur: req.userId,
        renseignementClinique: req.body.renseignementClinique,
        purpose: req.body.purpose,
        added_by: req.userId,
        frais_service: req.body.category.amount,
        bulletinAnalyse: '',
    });
    if(PaymentModal === null){
       return res.json({ status: 0, message: 'Something Went Wrong, Please Try Againg Later!!' });
    }else{
    OrganisationModal = await Organisation.findOne({where: {id: req.org_id}});
    payments = await Payment.findAndCountAll({where: {id_organisation: req.org_id}});
    codeFacture = 'ABC';
    if (req.body.subcontractor == '1' || req.body.subcontractor_light == '1') {
        codeFacture = 'CO' + (OrganisationModal ? OrganisationModal.code : '') + payments.count;
    } else {
        codeFacture = 'F' + (OrganisationModal ? OrganisationModal.code : '') + payments.count;
    }

    PaymentUpdateCode = await Payment.update({code: codeFacture},{where:{id: PaymentModal.id}});


    if(amount_received > 0){
        sub_total = req.body.hospital_amount - req.body.discount;
        statuspaid = 'unpaid';
        rece = amount_received + req.body.discount + req.body.charge_mutuelle;
        if (rece >= PaymentModal.amount) {
            statuspaid = 'paid';
        }
        PaymentUpdate = await Payment.update({ 
                                        amount_received: amount_received,
                                        deposit_type: req.body.deposit_type,
                                        status: 'new',
                                        status_paid: statuspaid
                                    },{where:{id: PaymentModal.id}});
    }
    
        /*if (amount_received && $etatlight != '1' && !$destinatairelight) {
        
        }*/



        PatientDepositModal = await PatientDeposit.create({ 
            date: moment().unix(),
            patient: req.body.patient_id,
            deposited_amount: req.body.amount_received,
            payment_id: PaymentModal.id,
            amount_received_id: null,
            deposit_type: 'Cash',
            user: req.userId,
            id_organisation: req.org_id,
            status: 1,
            added_by: req.userId,
        });
        await PatientLogs.create({
            patient_id: PaymentModal.patient,
            org_id: req.org_id,
            description: 'New Invoice has been Generated.',
            type: 'payment',
            relation_id: PaymentModal.id,
            status: 1,
            added_by: req.userId
        });
        res.json({ status: 1, message: 'New Invoice has been Generated.', data: '' });
    }
    
} catch (error) {
    throw error;
}
};

// Dependants
exports.getDependants = async (req, res) => {
  try {
    let offsetdata = parseInt(req.query.offset ? ((req.query.offset == undefined || req.query.offset == 1) ? 0 :req.query.offset) : 0);
    if(isNaN(offsetdata)){
        offsetdata = 0;
    }
    let datalimit = parseInt(req.query.limit ? ((req.query.limit == undefined) ? 5 :req.query.limit) : 5);
    if(isNaN(datalimit)){
        datalimit = 5;
    }
    const { count, rows } = await PatientRelation.findAndCountAll({where: { parent_id: req.params.patient_id }});
    PatientRelationModal = await PatientRelation.findAll({
        attributes: ['id','parent_id', 'relative_id','relation_type','org_id','added_by','updated_by','createdAt','updatedAt'],
        where: {parent_id: req.params.patient_id},
        order:[['id','DESC']],
        limit: datalimit,
        offset: offsetdata,
        include: [{
            model: Patient,
            attributes: ['id', ['id_organisation','org_id'],'name','last_name', 'email'],
            as:'parent_details'
        },{
            model: Patient,
            attributes: ['id', ['id_organisation','org_id'],'name','last_name', 'sex','birthdate','age','phone','email','passport','address','region','estCivil','bloodgroup','birth_position','nom_contact','phone_contact','religion','matricule','grade'],
            as:'dependant_details'
        },{
            model: User,
            attributes: ['id', ['id_organisation','org_id'],'first_name','last_name', 'username','email'],
            as:'addedby_details'
        },{
            model: User,
            attributes: ['id', ['id_organisation','org_id'],'first_name','last_name', 'username','email'],
            as:'updatedby_details'
        },{
            model: Organisation,
            attributes: ['id', 'nom','email','adresse'],
            as:'org_details'
        }]
    });
    if(PatientRelationModal === null){
        res.json({ status: 0, message: 'No Data Found' });
    }else{
        res.json({ status: 1, message: 'Dependants List', data: PatientRelationModal,total:count });
    }
    
} catch (error) {
    throw error;
}
};
exports.getDependantByID = async (req, res) => {
  try {
    let getData = [];
    PatientRelationModal = await PatientRelation.findOne({
        attributes: ['id','parent_id', 'relative_id','relation_type','org_id','added_by','updated_by','createdAt','updatedAt'],
        where: {id: req.params.dependant_id},
        order:[['id','DESC']],
        include: [{
            model: Patient,
            attributes: ['id', ['id_organisation','org_id'],'name','last_name', 'email'],
            as:'parent_details'
        },{
            model: Patient,
            attributes: ['id', ['id_organisation','org_id'],'name','last_name', 'sex','birthdate','age','phone','email','passport','address','region','estCivil','bloodgroup','birth_position','nom_contact','phone_contact','religion','matricule','grade'],
            as:'dependant_details'
        },{
            model: User,
            attributes: ['id', ['id_organisation','org_id'],'first_name','last_name', 'username','email'],
            as:'addedby_details'
        },{
            model: User,
            attributes: ['id', ['id_organisation','org_id'],'first_name','last_name', 'username','email'],
            as:'updatedby_details'
        },{
            model: Organisation,
            attributes: ['id', 'nom','email','adresse'],
            as:'org_details'
        }]
    });
    if(PatientRelationModal === null){
        res.json({ status: 0, message: 'No Data Found' });
    }else{
        res.json({ status: 1, message: 'Dependant Details has been fetched', data: PatientRelationModal });
    }
    
} catch (error) {
    throw error;
}
};
exports.addDependant = async (req, res) => {
  try {
    let getData = [],getRelationData = [], results;
        
    PatientModal = await Patient.create({
                            name: req.body.name,
                            last_name: req.body.last_name,
                            sex: req.body.sex,
                            birthdate: moment(req.body.birthdate).format('DD/MM/YYYY'),
                            age: req.body.age,
                            phone: req.body.phone,
                            email: req.body.email,
                            passport: req.body.passport,
                            address: req.body.address,
                            region: req.body.region,
                            estCivil: req.body.estCivil,
                            bloodgroup: req.body.bloodgroup,
                            birth_position: req.body.birth_position,
                            nom_contact: req.body.nom_contact,
                            phone_contact: req.body.phone_contact,
                            religion: req.body.religion,
                            matricule: req.body.matricule,
                            grade: req.body.grade,
                            parent_id: req.body.parent_id,
                            added_by: req.userId,
                            id_organisation: req.org_id

                    });
    
    if(PatientModal === null){
        res.json({ status: 0, message: 'Something Went Wrong, Please Try Againg Later!!' });
    }else{
        PatientRelationModal = await PatientRelation.create({
            parent_id: req.body.parent_id,
            relative_id: PatientModal.id,
            relation_type: req.body.relation_type,
            user_id: req.userId,
            added_by: req.userId,
            status: 1,
            created_date: moment().format('YYYY-MM-DD HH:mm:ss'),
        });
        await PatientLogs.create({
            patient_id: PatientRelationModal.parent_id,
            org_id: req.org_id,
            description: 'New Dependant has been Added.',
            type: 'dependent',
            relation_id: PatientRelationModal.id,
            status: 1,
            added_by: req.userId
        });
        res.json({ status: 1, message: 'New Dependant has been Added.', data: {'relational_details':PatientModal,'data':PatientRelationModal} });
    }

} catch (error) {
    throw error;
}
};
exports.updateDependant = async (req, res) => {
  try {
    let getData = [], results,patientID;
    console.log(req.params.id);
    PatientRelationModal = await PatientRelation.findOne({where: {id: req.params.id}});
    // console.log(PatientRelationModal);
    if(PatientRelationModal === null){
        res.json({ status: 0, message: 'Something Went Wrong, Please Try Againg Later!!' });
    }else{
        PatientRelationupdate = await PatientRelation.update({relation_type: req.body.relation_type,updated_by: req.userId,}, {where: {id: req.params.id}});

        PatientModal = await Patient.update({
                                name: req.body.name,
                                last_name: req.body.last_name,
                                sex: req.body.sex,
                                birthdate: moment(req.body.birthdate).format('DD/MM/YYYY'),
                                age: req.body.age,
                                phone: req.body.phone,
                                email: req.body.email,
                                passport: req.body.passport,
                                address: req.body.address,
                                region: req.body.region,
                                estCivil: req.body.estCivil,
                                bloodgroup: req.body.bloodgroup,
                                birth_position: req.body.birth_position,
                                nom_contact: req.body.nom_contact,
                                phone_contact: req.body.phone_contact,
                                religion: req.body.religion,
                                matricule: req.body.matricule,
                                grade: req.body.grade,
                                added_by: req.userId,

                            }, {
                                where: {id: PatientRelationModal.relative_id}
                            });
                            await PatientLogs.create({
                                patient_id: PatientRelationModal.parent_id,
                                org_id: req.org_id,
                                description: 'Dependent has been Updated.',
                                type: 'dependent',
                                relation_id: PatientRelationModal.id,
                                status: 1,
                                added_by: req.userId
                            });
        res.json({ status: 1, message: 'Dependent has been Updated.', data: '' });
    }
    
  } catch (error) {
      throw error;
  }
};
exports.deleteDependant = async (req, res) => {
  try {
    let getData = [], results;
        getData.push(req.params.id);
        PatientRelationModal = await PatientRelation.findOne({where: {id: req.params.id}});
        if(PatientRelationModal === null){
            PatientRelationModal = await PatientRelation.destroy({where: {id: req.params.id}});
            PatientModal = await Patient.destroy({where: {id: PatientRelationModal.relative_id}});
            res.json({ status: 0, message: 'Something Went Wrong, Please Try Againg Later!!' });
        }else{
            res.json({ status: 1, message: 'Dependants has been Deleted.', data: '' });
        }
        
} catch (error) {
    throw error;
}
};

// Assurance
exports.getAssurance = async (req, res) => {
  try {
    let offsetdata = parseInt(req.query.offset ? ((req.query.offset == undefined || req.query.offset == 1) ? 0 :req.query.offset) : 0);
    if(isNaN(offsetdata)){
        offsetdata = 0;
    }
    let datalimit = parseInt(req.query.limit ? ((req.query.limit == undefined) ? 5 :req.query.limit) : 5);
    if(isNaN(datalimit)){
        datalimit = 5;
    }
    const { count, rows } = await PatientMutuelle.findAndCountAll({where: { pm_idpatent: req.params.patient_id }});
    PatientMutuelleModal = await PatientMutuelle.findAll({ 
        attributes: [['idpm','id'],['pm_idmutuelle','payer_name'], 'pm_idmutuelle','pm_numpolice','pm_charge','pm_datevalid','validity_date','added_by','updated_by',[Sequelize.fn("DATE_FORMAT", Sequelize.col("createdAt"),"%d-%m-%Y %H:%i:%s"),"createdAt"],[Sequelize.fn("DATE_FORMAT", Sequelize.col("updatedAt"),"%d-%m-%Y %H:%i:%s"),"updatedAt"]],
        where: { pm_idpatent: req.params.patient_id},
        order:[['id','DESC']],
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
            model: Organisation,
            attributes: ['id', 'nom','email','adresse'],
            as:'org_details'
        },{
            model: Organisation,
            attributes: ['id', 'nom','email','adresse'],
            as:'nom_mutuelle_details'
        }] });
    if(PatientMutuelleModal === null){
        res.json({ status: 0, message: 'No Data Found' });
    }else{
        res.json({ status: 1, message: 'Patient Assurance list', data: PatientMutuelleModal,total:count });
    }
    
} catch (error) {
    throw error;
}
};
exports.getAssuranceByID = async (req, res) => {
  try {
    let getData = [];
    getData.push(req.params.assurance_id);
    // PatientRelationModal = await PatientRelation.findAll({where: {id: req.params.id}});
    PatientMutuelleModal = await PatientMutuelle.findOne({ 
        attributes: [['idpm','id'],['pm_idmutuelle','payer_name'], 'pm_idmutuelle','pm_numpolice','pm_charge','pm_datevalid','validity_date'],
        where: { idpm: req.params.assurance_id},
        include: [{
            model: User,
            attributes: ['id', ['id_organisation','org_id'],'first_name','last_name', 'username','email'],
            as:'addedby_details'
        },{
            model: User,
            attributes: ['id', ['id_organisation','org_id'],'first_name','last_name', 'username','email'],
            as:'updatedby_details'
        },{
            model: Organisation,
            attributes: ['id', 'nom','email','adresse'],
            as:'org_details'
        },{
            model: Organisation,
            attributes: ['id', 'nom','email','adresse'],
            as:'nom_mutuelle_details'
        }] });
    if(PatientMutuelleModal === null){
        res.json({ status: 0, message: 'No Data Found' });
    }else{
        res.json({ status: 1, message: 'Patient Assurance ', data: PatientMutuelleModal });
    }
    
  } catch (error) {
      throw error;
  }
};
exports.getAssuranceOrg = async (req, res) => {
  try {
    let getData = [];
    OrganisationModal = await Organisation.findAll({ 
        attributes: ['id', 'nom'],
        where: { [Op.or]: [{ type: 'ASSURANCE' }, { type: 'IPM' }] } });
    if(OrganisationModal === null){
        res.json({ status: 0, message: 'No Data Found' });
    }else{
        res.json({ status: 1, message: 'Assurance Organization list', data: OrganisationModal });
    }
    
} catch (error) {
    throw error;
}
};
exports.addAssurance = async (req, res) => {
  try {
    let getData = [], results;
        
        PatientMutuelleModal = await PatientMutuelle.create({ 
            pm_idpatent: req.body.patient_id,
            id_organisation: req.org_id,
            pm_idmutuelle: req.body.nom_mutuelle,
            pm_numpolice: req.body.num_police,
            pm_charge: req.body.charge_mutuelle,
            pm_datevalid: moment(req.body.date_valid).format('DD/MM/YYYY'),
            validity_date: moment(req.body.date_valid).format('YYYY-MM-DD'),
            pm_status: 1,
            added_by: req.userId,
        });
        if(PatientMutuelleModal === null){
        res.json({ status: 0, message: 'Something Went Wrong, Please Try Againg Later!!' });
        }else{
            await PatientLogs.create({
                patient_id: PatientMutuelleModal.pm_idpatent,
                org_id: req.org_id,
                description: 'New Assurance has been Added.',
                type: 'assurance',
                relation_id: PatientMutuelleModal.idpm,
                status: 1,
                added_by: req.userId
            });
        res.json({ status: 1, message: 'New Assurance has been Added.', data: '' });
        }
} catch (error) {
    throw error;
}
};
exports.updateAssurance = async (req, res) => {
  try {
    let getData = [], results;
    
        PatientMutuelleModal = await PatientMutuelle.update({
                                    pm_idmutuelle: req.body.nom_mutuelle,
                                    pm_numpolice: req.body.num_police,
                                    pm_charge: req.body.charge_mutuelle,
                                    pm_datevalid: moment(req.body.date_valid).format('DD/MM/YYYY'),
                                    validity_date: moment(req.body.date_valid).format('YYYY-MM-DD'),
                                    updated_by: req.userId,
                                }, 
                                {where: {idpm: req.params.id}
                            });
        if(PatientMutuelleModal === null){
            res.json({ status: 0, message: 'Something Went Wrong, Please Try Againg Later!!' });
        }else{
            AssuranceD = await PatientMutuelle.findOne({where: {idpm: req.params.id}});

            await PatientLogs.create({
                patient_id: AssuranceD.pm_idpatent,
                org_id: req.org_id,
                description: 'Assurance has been Updated.',
                type: 'assurance',
                relation_id: AssuranceD.idpm,
                status: 1,
                added_by: req.userId
            });
            res.json({ status: 1, message: 'Assurance has been Updated.', data: '' });
        }
        
} catch (error) {
    throw error;
}
};
exports.deleteAssurance = async (req, res) => {
  try {
    let getData = [], results;
        getData.push(req.params.id);
        PatientMutuelleModal = await PatientMutuelle.findOne({where: {idpm: req.params.id}});
        if(PatientMutuelleModal === null){
            res.json({ status: 0, message: 'Something Went Wrong, Please Try Againg Later!!' });
        }else{
            res.json({ status: 1, message: 'Assurance has been Deleted.', data: '' });
        }
} catch (error) {
    throw error;
}
};

// Attachments
exports.getAttachments = async (req, res) => {
  try {
    let offsetdata = parseInt(req.query.offset ? ((req.query.offset == undefined || req.query.offset == 1) ? 0 :req.query.offset) : 0);
    if(isNaN(offsetdata)){
        offsetdata = 0;
    }
    let datalimit = parseInt(req.query.limit ? ((req.query.limit == undefined || req.query.limit == 1) ? 5 :req.query.limit) : 5);
    if(isNaN(datalimit)){
        datalimit = 5;
    }
    const { count, rows } = await PatientMaterial.findAndCountAll({where: { patient: req.params.patient_id }});
    PatientMaterialModal = await PatientMaterial.findAll({ 
        attributes: ['id', 'title', [Sequelize.fn('CONCAT', BASEURL+'/uploads/documentsPatient/',Sequelize.col(`url`)), 'url'] , 'category','id_organisation','added_by','updated_by',[Sequelize.fn("DATE_FORMAT", Sequelize.col("PatientMaterial.createdAt"),"%d-%m-%Y %H:%i:%s"),"createdAt"],[Sequelize.fn("DATE_FORMAT", Sequelize.col("PatientMaterial.updatedAt"),"%d-%m-%Y %H:%i:%s"),"updatedAt"]],
        where: { patient: req.params.patient_id },
        order:[['id','DESC']],
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
                    model: Organisation,
                    attributes: ['id', 'nom','email','adresse'],
                    as:'org_details'
                },{
                    model: DocumentTypes,
                    attributes: ['id', 'name'],
                    as:'doctypes_details'
                }]
    });
    if(PatientMaterialModal === null){
        res.json({ status: 0, message: 'No Data Found' });
    }else{
        res.json({ status: 1, message: 'Patient Document list', data: PatientMaterialModal,total:count });
    }
    
  } catch (error) {
      throw error;
  }
};
exports.getAttachmentsByID = async (req, res) => {
  try {
    PatientMaterialModal = await PatientMaterial.findOne({ 
        attributes: ['id', 'title',  [Sequelize.fn('CONCAT', BASEURL+'/uploads/documentsPatient/',Sequelize.col(`url`)), 'url'], 'date'],
        where: { id: req.params.attachment_id } });
    if(PatientMaterialModal === null){
        res.json({ status: 0, message: 'No Data Found' });
    }else{
        res.json({ status: 1, message: 'Patient Document', data: PatientMaterialModal });
    }
      
  } catch (error) {
      throw error;
  }
};
exports.getAttachmentsTypes = async (req, res) => {
  try {
    let getData = [];
    // getData.push(req.params.patient_id);
    DocumentTypesModal = await DocumentTypes.findAll({ 
        attributes: ['id', 'name'],
        where: { status: 1 } });
    if(DocumentTypesModal === null){
        res.json({ status: 0, message: 'No Data Found' });
    }else{
        res.json({ status: 1, message: 'Document Types', data: DocumentTypesModal });
    }
    
} catch (error) {
    throw error;
}
};
exports.addAttachments = async (req, res) => {
  if(Object.keys(req.files).length == 0){
    res.json({ status: 0, message: 'No File attached. Please attach an file' });
}
try {
    let Data = [], results;
    PatientModal = await Patient.findOne({ attributes: ['id','unique_id', 'name','last_name',['sex','gender'], 'age','email','phone','address','region',['registration_time','register'],'grade','estCivil','passport','matricule',['bloodgroup','blood_type'],'birthdate',['birth_position','birth_place'],'religion'],where: { id: req.body.uniqueID } });
        
        PatientMaterialModal = await PatientMaterial.create({ 
                                            id_organisation: req.org_id,
                                            date: moment().unix(),
                                            title: req.body.title,
                                            category: req.body.category,
                                            patient: req.body.uniqueID,
                                            patient_name: PatientModal.name+' '+PatientModal.last_name,
                                            patient_address: PatientModal.address,
                                            patient_phone: PatientModal.phone,
                                            url: req.files.document[0].filename,
                                            added_by: req.userId,
                                            status: 1,
                                            date_string: moment().format('YYYY-MM-DD HH:mm:ss'),
                                        });
        if(PatientMaterialModal === null){
            res.json({ status: 0, message: 'Something Went Wrong, Please Try Againg Later!!' });
        }else{
            await PatientLogs.create({
                patient_id: PatientMaterialModal.patient,
                org_id: req.org_id,
                description: 'New Document has been uploaded.',
                type: 'documents',
                relation_id: PatientMaterialModal.id,
                status: 1,
                added_by: req.userId
            });
            res.json({ status: 1, message: 'New Document has been uploaded.', data: '' });
        }
} catch (error) {
    throw error;
}
};
exports.updateAttachments = async (req, res) => {
  try {
    let getData = [], results;
    getData.push(req.orgId);
    getData.push(req.body.date);
    getData.push(req.body.title);
    getData.push(req.body.category);
    getData.push(req.body.uniqueID);
    getData.push(req.body.patient_name);
    getData.push(req.body.patient_address);
    getData.push(req.body.patient_phone);
    getData.push(req.files.document[0].filename);
    getData.push(req.body.date_string);
        results = await patients.updateAttachment(getData);

        if (results) {
            res.json({ status: 1, message: 'Document has been Updated.', data: '' });
        } else {
            res.json({ status: 0, message: 'Something Went Wrong, Please Try Againg Later!!' });
        }
  } catch (error) {
      throw error;
  }
};
exports.deleteAttachments = async (req, res) => {
  try {
    let getData = [], results;
        getData.push(req.params.id);
        PatientMaterialModal = await PatientMaterial.findOne({where: {id: req.params.id}});
        if(PatientMaterialModal === null){
            res.json({ status: 0, message: 'Something Went Wrong, Please Try Againg Later!!' });
        }else{
            fs.unlinkSync('../uploads/documentsPatient/' + PatientMaterialModal.url);
            PatientMaterialModal = await PatientMaterial.destroy({where: {id: req.params.id}});
            res.json({ status: 1, message: 'Document has been Deleted.', data: '' });
        }
        
} catch (error) {
    throw error;
}
};

// Vital Sign
exports.getVitalSign = async (req, res) => {
  try {
    let offsetdata = parseInt(req.query.offset ? ((req.query.offset == undefined || req.query.offset == 1) ? 0 :req.query.offset) : 0);
    if(isNaN(offsetdata)){
        offsetdata = 0;
    }
    let datalimit = parseInt(req.query.limit ? ((req.query.limit == undefined) ? 5 :req.query.limit) : 5);
    if(isNaN(datalimit)){
        datalimit = 5;
    }
    const { count, rows } = await VitalSign.findAndCountAll({where: {patient: req.params.patient_id}});
   

    VitalSignModal = await VitalSign.findAll({ 
        attributes: ['id', 'date_string', ['frequenceRespiratoire','respiratory_rate'], ['frequenceCardiaque','heart_rate'],  ['saturationArterielle','stauration_en_o2'], 'temperature','systolique','diastolique',['tensionArterielle','blood_pressure'],'weight','blood_sugar','height','body_mass_index','id_organisation','added_by','updated_by',[Sequelize.fn("DATE_FORMAT", Sequelize.col("createdAt"),"%d-%m-%Y %H:%i:%s"),"createdAt"],[Sequelize.fn("DATE_FORMAT", Sequelize.col("updatedAt"),"%d-%m-%Y %H:%i:%s"),"updatedAt"]],
        where: { patient: req.params.patient_id },
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
            model: Organisation,
            attributes: ['id', 'nom','email','adresse'],
            as:'org_details'
        }]
    });
    if(VitalSignModal === null){
        res.json({ status: 0, message: 'No Data Found' });
    }else{
        res.json({ status: 1, message: 'Patient Vital Sign list', data: VitalSignModal,total:count });
    }
    
} catch (error) {
    throw error;
}
};
exports.getVitalSignGraph = async (req, res) => {
  try {
    let getData = {};
   
    let offsetdata = parseInt(req.query.offset ? req.query.offset : 0);
    //  console.log(typeof offsetdata);
        getData.respiratory_rate = await VitalSign.findAll({ 
                                                attributes: ['id', ['frequenceRespiratoire','respiratory_rate'],'id_organisation','added_by','updated_by',[Sequelize.fn("DATE_FORMAT", Sequelize.col("createdAt"),"%d-%m-%Y %H:%i:%s"),"createdAt"],[Sequelize.fn("DATE_FORMAT", Sequelize.col("updatedAt"),"%d-%m-%Y %H:%i:%s"),"updatedAt"]],
                                                where: { patient: req.params.patient_id,frequenceRespiratoire:{[Op.and]:{[Op.not]: null,[Op.not]: ''} } },
                                                order: [
                                                    ['id', 'DESC']
                                                ],
                                                limit: 5,
                                                offset: offsetdata,
                                                
                                                            });
        getData.heart_rate = await VitalSign.findAll({ 
                                                attributes: ['id', ['frequenceCardiaque','heart_rate'],'id_organisation','added_by','updated_by',[Sequelize.fn("DATE_FORMAT", Sequelize.col("createdAt"),"%d-%m-%Y %H:%i:%s"),"createdAt"],[Sequelize.fn("DATE_FORMAT", Sequelize.col("updatedAt"),"%d-%m-%Y %H:%i:%s"),"updatedAt"]],
                                                where: { patient: req.params.patient_id,frequenceCardiaque:{[Op.or]:{[Op.not]: null,[Op.not]: ''}} },
                                                order: [
                                                    ['id', 'DESC']
                                                ],
                                                limit: 5,
                                                offset: offsetdata,
                                                
                                            });
        getData.stauration_en_o2 = await VitalSign.findAll({ 
                                                    attributes: ['id',  ['saturationArterielle','stauration_en_o2'],'id_organisation','added_by','updated_by',[Sequelize.fn("DATE_FORMAT", Sequelize.col("createdAt"),"%d-%m-%Y %H:%i:%s"),"createdAt"],[Sequelize.fn("DATE_FORMAT", Sequelize.col("updatedAt"),"%d-%m-%Y %H:%i:%s"),"updatedAt"]],
                                                    where: { 
                                                        patient: req.params.patient_id,
                                                        saturationArterielle:{[Op.or]:{[Op.not]: null,[Op.not]: ''}}
                                                    },
                                                    order: [['id', 'DESC']],
                                                    limit: 5,
                                                    offset: offsetdata,
                                                    
                                                });
        getData.temperature = await VitalSign.findAll({ 
                                                    attributes: ['id', 'temperature','id_organisation','added_by','updated_by',[Sequelize.fn("DATE_FORMAT", Sequelize.col("createdAt"),"%d-%m-%Y %H:%i:%s"),"createdAt"],[Sequelize.fn("DATE_FORMAT", Sequelize.col("updatedAt"),"%d-%m-%Y %H:%i:%s"),"updatedAt"]],
                                                    where: { patient: req.params.patient_id,temperature:{[Op.and]:{[Op.not]: null,[Op.not]: ''}} },
                                                    order: [
                                                        ['id', 'DESC']
                                                    ],
                                                    limit: 5,
                                                    offset: offsetdata,
                                                    
                                                });
        getData.blood_pressure = await VitalSign.findAll({ 
                                                    attributes: ['id','systolique','diastolique',['tensionArterielle','blood_pressure'],'id_organisation','added_by','updated_by',[Sequelize.fn("DATE_FORMAT", Sequelize.col("createdAt"),"%d-%m-%Y %H:%i:%s"),"createdAt"],[Sequelize.fn("DATE_FORMAT", Sequelize.col("updatedAt"),"%d-%m-%Y %H:%i:%s"),"updatedAt"]],
                                                    where: { patient: req.params.patient_id,systolique:{[Op.and]:{[Op.not]: null,[Op.not]: ''}},diastolique:{[Op.or]:{[Op.not]: null,[Op.not]: ''}} },
                                                    order: [
                                                        ['id', 'DESC']
                                                    ],
                                                    limit: 5,
                                                    offset: offsetdata,
                                                    
                                                });

    res.json({ status: 1, message: 'Patient Vital Sign Graph', data: getData });
    
} catch (error) {
    throw error;
}
};
exports.getVitalSignByID = async (req, res) => {
  try {
    let getData = [];
    
    VitalSignModal = await VitalSign.findOne({ 
        attributes: ['id', 'date_string', ['frequenceRespiratoire','respiratory_rate'], ['frequenceCardiaque','heart_rate'],  ['saturationArterielle','stauration_en_o2'], 'temperature','systolique','diastolique',['tensionArterielle','blood_pressure'],'weight','blood_sugar','height','body_mass_index',[Sequelize.fn("DATE_FORMAT", Sequelize.col("createdAt"),"%d-%m-%Y %H:%i:%s"),"createdAt",]],
        where: { id: req.params.vital_id }});
    if(VitalSignModal === null){
        res.json({ status: 0, message: 'No Data Found' });
    }else{
        res.json({ status: 1, message: 'Patient Vital Sign', data: VitalSignModal });
    }
    
} catch (error) {
    throw error;
}
};
exports.addVitalSign = async (req, res) => {
  try {
    let getData = [], results;
        
        VitalSignModal = await VitalSign.create({ 
                                    patient: req.body.uniqueID,
                                    id_organisation: req.org_id,
                                    prescripteur: req.body.prescripteur,
                                    frequenceRespiratoire: req.body.frequenceRespiratoire,
                                    frequenceCardiaque: req.body.frequenceCardiaque,
                                    saturationArterielle: req.body.saturationArterielle,
                                    temperature: req.body.temperature,
                                    systolique: req.body.systolique,
                                    diastolique: req.body.diastolique,
                                    tensionArterielle: req.body.tensionArterielle,
                                    weight: req.body.weight,
                                    blood_sugar: req.body.blood_sugar,
                                    height: req.body.height,
                                    body_mass_index: req.body.body_mass_index,
                                    ion_user_id: req.userId,//loggedin id
                                    add_date: moment(req.body.add_date).format('YYYY-MM-DD'),
                                    patient_name: '',
                                    patient_address: '',
                                    patient_phone: '',
                                    date_string: moment().format('DD-MM-YYYY'),
                                    date: moment().unix(),
                                    added_by: req.userId,
                                    status: 1,
                                });
        if(VitalSignModal === null){
            res.json({ status: 0, message: 'Something Went Wrong, Please Try Againg Later!!' });
        }else{
            await PatientLogs.create({
                patient_id: VitalSignModal.patient,
                org_id: req.org_id,
                description: 'New Vital Sign has been Added.',
                type: 'vital_sign',
                relation_id: VitalSignModal.id,
                status: 1,
                added_by: req.userId
            });
            res.json({ status: 1, message: 'New Vital Sign has been Added.', data: VitalSignModal });
        }

} catch (error) {
    throw error;
}
};
exports.updateVitalSign = async (req, res) => {
  try {
    let getData = [], results;
    getData.push(req.body.uniqueID);
    getData.push(req.orgId);
    getData.push(req.body.prescripteur);
    getData.push(req.body.frequenceRespiratoire);
    getData.push(req.body.frequenceCardiaque);
    getData.push(req.body.saturationArterielle);
    getData.push(req.body.temperature);
    getData.push(req.body.systolique);
    getData.push(req.body.diastolique);
    getData.push(req.body.tensionArterielle);

    getData.push(req.userId);///loggedin id

    getData.push(req.body.add_date);
    getData.push(req.body.patient_name);
    getData.push(req.body.patient_address);
    getData.push(req.body.patient_phone);
    getData.push(req.body.date_string);
    getData.push(req.body.date);
        results = await patients.UpdateVitalSign(getData);

        if (results) {
            res.json({ status: 1, message: 'Vital Sign has been Updated.', data: '' });
        } else {
            res.json({ status: 0, message: 'Something Went Wrong, Please Try Againg Later!!' });
        }
  } catch (error) {
      throw error;
  }
};
exports.deleteVitalSign = async (req, res) => {
  try {
    let getData = [], results;
        getData.push(req.params.id);
        VitalSignModal = await VitalSign.destroy({where: {id: req.params.id}});
        if(VitalSignModal === null){
            res.json({ status: 0, message: 'Something Went Wrong, Please Try Againg Later!!' });
        }else{
            res.json({ status: 1, message: 'Vital Sign has been Deleted.', data: '' });
        } 
        
} catch (error) {
    throw error;
}
};


// Medications
exports.getCurrentMedication = async (req, res) => {
  try {
    let offsetdata = parseInt(req.query.offset ? ((req.query.offset == undefined || req.query.offset == 1) ? 0 :req.query.offset) : 0);
    if(isNaN(offsetdata)){
        offsetdata = 0;
    }
    let datalimit = parseInt(req.query.limit ? ((req.query.limit == undefined) ? 5 :req.query.limit) : 5);
    if(isNaN(datalimit)){
        datalimit = 5;
    }
    const { count, rows } = await CurrentMedications.findAndCountAll({where: { patient_id: req.params.patient_id }});
    CurrentMedicationsModal = await CurrentMedications.findAll({
        attributes: ['id', 'patient_id', 'doctor_id', 'content', 'date_time', 'status','added_by','updated_by','org_id',[Sequelize.fn("DATE_FORMAT", Sequelize.col("createdAt"),"%d-%m-%Y %H:%i:%s"),"createdAt",],[Sequelize.fn("DATE_FORMAT", Sequelize.col("updatedAt"),"%d-%m-%Y %H:%i:%s"),"updatedAt",]], 
        where: { patient_id: req.params.patient_id },
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
                model: Organisation,
                attributes: ['id', 'nom','email','adresse'],
                as:'org_details'
            }]
        });
    if(CurrentMedicationsModal === null){
        res.json({ status: 0, message: 'No Data Found' });
    }else{
        
        res.json({ status: 1, message: 'Current Medication List', data: CurrentMedicationsModal,total:count });
    }
  } catch (error) {
      throw error;
  }
};
exports.getCurrentMedicationByID = async (req, res) => {
  try {
    let getData = [], results;
    CurrentMedicationsModal = await CurrentMedications.findOne({ where: { id: req.params.medication_id } });
    if(CurrentMedicationsModal === null){
        res.json({ status: 0, message: 'No Data Found' });
    }else{
        res.json({ status: 1, message: 'Current Medication', data: CurrentMedicationsModal });
    }
  } catch (error) {
      throw error;
  }
};
exports.addCurrentMedication = async (req, res) => {
  try {
    let getData = [], results;
        CurrentMedicationsModal = await CurrentMedications.create({ 
            patient_id: req.body.patient_id,
            doctor_id: req.body.doctor_id,
            content: req.body.content,
            added_by: req.userId,
            org_id: req.org_id,
            status: 1,
        });
    if(CurrentMedicationsModal === null){
        res.json({ status: 0, message: 'Something Went Wrong, Please Try Againg Later!!' });
    }else{
        await PatientLogs.create({
            patient_id: CurrentMedicationsModal.patient_id,
            org_id: req.org_id,
            description: 'New Medication has been Added.',
            type: 'current_medication',
            relation_id: CurrentMedicationsModal.id,
            status: 1,
            added_by: req.userId
        });
        res.json({ status: 1, message: 'New Medication has been Added.', data: '' });
    }

  } catch (error) {
      throw error;
  }
};
exports.updateCurrentMedication = async (req, res) => {
  try {
    let getData = [], results;
        //getData.push(req.body.content);
        //getData.push(req.params.id);
        
        CurrentMedicationsModal = await CurrentMedications.update({content: req.body.content,updated_by: req.userId,}, {where: {id: req.params.id}});
        if(CurrentMedicationsModal === null){
            res.json({ status: 0, message: 'Something Went Wrong, Please Try Againg Later!!' });
        }else{
            await PatientLogs.create({
                patient_id: CurrentMedicationsModal.patient_id,
                org_id: req.org_id,
                description: 'Patient Current Medication has been added',
                type: 'current_medication',
                relation_id: CurrentMedicationsModal.id,
                status: 1,
                added_by: req.userId
            });
            res.json({ status: 1, message: 'Medication has been Updated.', data: '' });
        }
          
  } catch (error) {
      throw error;
  }
};
exports.deleteCurrentMedication = async (req, res) => {
  try {
    let getData = [], results;
    CurrentMedicationsModal = await CurrentMedications.destroy({where: {id: req.params.id}});
    if(CurrentMedicationsModal === null){
        res.json({ status: 0, message: 'Something Went Wrong, Please Try Againg Later!!' });
    }else{
        res.json({ status: 1, message: 'Medication has been Deleted.', data: '' });
    } 
  } catch (error) {
  throw error;
  }
};


// Known Health issues
exports.getKnownHealthIssues = async (req, res) => {
  try {
    let offsetdata = parseInt(req.query.offset ? ((req.query.offset == undefined || req.query.offset == 1) ? 0 :req.query.offset) : 0);
    if(isNaN(offsetdata)){
        offsetdata = 0;
    }
    let datalimit = parseInt(req.query.limit ? ((req.query.limit == undefined) ? 5 :req.query.limit) : 5);
    if(isNaN(datalimit)){
        datalimit = 5;
    }
    const { count, rows } = await PreConditions.findAndCountAll({where: { patient_id: req.params.patient_id }});

    PreConditionsModal = await PreConditions.findAll({
        attributes: ['id', 'patient_id', 'doctor_id', 'content', 'date_time', 'status','added_by','updated_by','org_id',[Sequelize.fn("DATE_FORMAT", Sequelize.col("createdAt"),"%d-%m-%Y %H:%i:%s"),"createdAt",],[Sequelize.fn("DATE_FORMAT", Sequelize.col("updatedAt"),"%d-%m-%Y %H:%i:%s"),"updatedAt",]], 
        where: { patient_id: req.params.patient_id },
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
            model: Organisation,
            attributes: ['id', 'nom','email','adresse'],
            as:'org_details'
        }]
    });
    if(PreConditionsModal === null){
        res.json({ status: 0, message: 'No Data Found' });
    }else{
        res.json({ status: 1, message: 'Known Health issues List', data: PreConditionsModal,total:count });
    }
  } catch (error) {
      throw error;
  }
};
exports.getKnownHealthIssuesByID = async (req, res) => {
  try {
    let getData = [], results;
    PreConditionsModal = await PreConditions.findOne({ where: { id: req.params.pre_condition_id } });
    if(PreConditionsModal === null){
        res.json({ status: 0, message: 'No Data Found' });
    }else{
        res.json({ status: 1, message: 'Known Health issues', data: PreConditionsModal });
    }
  } catch (error) {
      throw error;
  }
};
exports.addKnownHealthIssues = async (req, res) => {
  try {
    let getData = [], results;
        
    PreConditionsModal = await PreConditions.create({ 
                                            patient_id: req.body.patient_id,
                                            doctor_id: req.body.doctor_id,
                                            content: req.body.content,
                                            added_by: req.userId,
                                            org_id: req.org_id,
                                            status: 1,
                                        });
    if(PreConditionsModal === null){
        res.json({ status: 0, message: 'Something Went Wrong, Please Try Againg Later!!' });
    }else{
        await PatientLogs.create({
            patient_id: PreConditionsModal.patient_id,
            org_id: req.org_id,
            description: 'Patient Know health issue has been added',
            type: 'know_health_issue',
            relation_id: PreConditionsModal.id,
            status: 1,
            added_by: req.userId
        });
        res.json({ status: 1, message: 'New Health has been Added.', data: '' });
    }
        
  } catch (error) {
      throw error;
  }
};
exports.updateKnownHealthIssues = async (req, res) => {
  try {
    let getData = [], results;
        PreConditionData = await PreConditions.findOne({where: { id: req.params.id} }); 
        PreConditionsModal = await PreConditions.update({content: req.body.content,updated_by: req.userId,}, {where: {id: req.params.id}});
        if(PreConditionsModal === null){
            res.json({ status: 0, message: 'Something Went Wrong, Please Try Againg Later!!' });
        }else{
            await PatientLogs.create({
                patient_id: PreConditionData.patient_id,
                org_id: req.org_id,
                description: 'Patient Know health issue has been updated',
                type: 'know_health_issue',
                relation_id: PreConditionData.id,
                status: 1,
                added_by: req.userId
            });
            res.json({ status: 1, message: 'Health issue has been Updated.', data: '' });
        }

  } catch (error) {
      throw error;
  }
};
exports.deleteKnownHealthIssues = async (req, res) => {
  try {
    let getData = [], results;
        PreConditionsModal = await PreConditions.destroy({where: {id: req.params.id}});
        if(PreConditionsModal === null){
            res.json({ status: 0, message: 'Something Went Wrong, Please Try Againg Later!!' });
        }else{
            res.json({ status: 1, message: 'Health issue has been Deleted.', data: '' });
        } 
  } catch (error) {
      throw error;
  }
};


// Confidential Notes
exports.getConfidentialNotes = async (req, res) => {
  try {
    let offsetdata = parseInt(req.query.offset ? ((req.query.offset == undefined || req.query.offset == 1) ? 0 :req.query.offset) : 0);
    if(isNaN(offsetdata)){
        offsetdata = 0;
    }
    let datalimit = parseInt(req.query.limit ? ((req.query.limit == undefined) ? 5 :req.query.limit) : 5);
    if(isNaN(datalimit)){
        datalimit = 5;
    }
    const { count, rows } = await ConfidentialNotes.findAndCountAll({where: { patient_id: req.params.patient_id }});

    const ConfidentialNotesModal = await ConfidentialNotes.findAll({
        // attributes: ['id', 'description','type','relation_id', 'status','added_by','updated_by',[Sequelize.fn("DATE_FORMAT", Sequelize.col("createdAt"),"%d-%m-%Y %H:%i:%s"),"createdAt"],[Sequelize.fn("DATE_FORMAT", Sequelize.col("updatedAt"),"%d-%m-%Y %H:%i:%s"),"updatedAt"],'patient_id','org_id'], 
        where: { patient_id: req.params.patient_id },
        order: [['id', 'desc']],
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
            model: Organisation,
            attributes: ['id', 'nom','email','adresse'],
            as:'org_details'
        }]
    });
    
    if(ConfidentialNotesModal === null){
        res.json({ status: 0, message: 'No Data Found' });
    }else{
        res.json({ status: 1, message: 'Confidential Notes', data: ConfidentialNotesModal,total:count  });
    }
  } catch (error) {
      throw error;
  }
};
exports.getConfidentialNotesByID = async (req, res) => {
  try {
    let getData = [], results;
    ConfidentialNotesModal = await ConfidentialNotes.findOne({ where: { id: req.params.confidential_notes_id } });
    if(ConfidentialNotesModal === null){
        res.json({ status: 0, message: 'No Data Found' });
    }else{
        res.json({ status: 1, message: 'Confidential Notes', data: ConfidentialNotesModal });
    }
  } catch (error) {
      throw error;
  }
};
exports.addConfidentialNotes = async (req, res) => {
  try {
    let getData = [], results;
        
    ConfidentialNotesModal = await ConfidentialNotes.create({ 
                                            patient_id: req.body.patient_id,
                                            doctor_id: req.userId,
                                            note: req.body.content,
                                            added_by: req.userId,
                                            org_id: req.org_id,
                                            status: 1,
                                        });
    if(ConfidentialNotesModal === null){
        res.json({ status: 0, message: 'Something Went Wrong, Please Try Againg Later!!' });
    }else{
        res.json({ status: 1, message: 'New Confidential Note has been Added.', data: '' });
    }
          
  } catch (error) {
      throw error;
  }
};
exports.updateConfidentialNotes = async (req, res) => {
  try {
    let getData = [], results;
    ConfidentialNotesModal = await ConfidentialNotes.update({note: req.body.content,updated_by: req.userId,}, {where: {id: req.params.id}});
        if(ConfidentialNotesModal === null){
            res.json({ status: 0, message: 'Something Went Wrong, Please Try Againg Later!!' });
        }else{
            res.json({ status: 1, message: 'Confidential Notes has been Updated.', data: '' });
        }

  } catch (error) {
      throw error;
  }
};
exports.deleteConfidentialNotes = async (req, res) => {
  try {
    let getData = [], results;
    ConfidentialNotesModal = await ConfidentialNotes.destroy({where: {id: req.params.id}});
        if(ConfidentialNotesModal === null){
            res.json({ status: 0, message: 'Something Went Wrong, Please Try Againg Later!!' });
        }else{
            res.json({ status: 1, message: 'Confidential Notes has been Deleted.', data: '' });
        } 
} catch (error) {
    throw error;
}
};

// Clinical Notes
exports.getClinicalNotes = async (req, res) => {
  try {
    let offsetdata = parseInt(req.query.offset ? ((req.query.offset == undefined || req.query.offset == 1) ? 0 :req.query.offset) : 0);
    if(isNaN(offsetdata)){
        offsetdata = 0;
    }
    let datalimit = parseInt(req.query.limit ? ((req.query.limit == undefined) ? 5 :req.query.limit) : 5);
    if(isNaN(datalimit)){
        datalimit = 5;
    }
    const { count, rows } = await ClinicalNotes.findAndCountAll({where: { patient_id: req.params.patient_id }});
    ClinicalNotesModal = await ClinicalNotes.findAll({ 
        where: { patient_id: req.params.patient_id },
        order: [['id', 'desc']],
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
            model: Organisation,
            attributes: ['id', 'nom','email','adresse'],
            as:'org_details'
        }]
    });
    if(ClinicalNotesModal === null){
        res.json({ status: 0, message: 'No Data Found' });
    }else{
        res.json({ status: 1, message: 'Clinical Notes', data: ClinicalNotesModal,total: count});
    }
  } catch (error) {
      throw error;
  }
};
exports.getClinicalNotesByID = async (req, res) => {
  try {
    let getData = [], results;
    ClinicalNotesModal = await ClinicalNotes.findOne({ where: { id: req.params.clinical_note_id } });
    if(ClinicalNotesModal === null){
        res.json({ status: 0, message: 'No Data Found' });
    }else{
        res.json({ status: 1, message: 'Clinical Notes', data: ClinicalNotesModal });
    }
  } catch (error) {
      throw error;
  }
};
exports.addClinicalNotes = async (req, res) => {
  try {
    let getData = [], results;
        
    ClinicalNotesModal = await ClinicalNotes.create({ 
                                patient_id: req.body.patient_id,
                                org_id: req.org_id,
                                date_time: req.body.date_time,
                                channel: req.body.channel,
                                motive: req.body.motive,
                                known_health_issues: req.body.known_health_issues,
                                consultation: req.body.consultation,
                                desease: JSON.parse(req.body.desease),
                                documents: req.body.documents,
                                status: 1,
                                added_by: req.userId,
                            });
    if(ClinicalNotesModal === null){
        res.json({ status: 0, message: 'Something Went Wrong, Please Try Againg Later!!' });
    }else{
        await PatientLogs.create({
            patient_id: ClinicalNotesModal.patient_id,
            org_id: req.org_id,
            description: 'Patient New clinical notes has been added ',
            type: 'clinical_notes',
            relation_id: ClinicalNotesModal.id,
            status: 1,
            added_by: req.userId
        });
        res.json({ status: 1, message: 'New Clinical Note has been Added.', data: '' });
    }
        
  } catch (error) {
      throw error;
  }
};
exports.updateClinicalNotes = async (req, res) => {
  try {
    let getData = [], results;
    ClinicalNotesModal = await ClinicalNotes.update({content: req.body.content,updated_by: req.userId,}, {where: {id: req.params.id}});
        if(ClinicalNotesModal === null){
            res.json({ status: 0, message: 'Something Went Wrong, Please Try Againg Later!!' });
        }else{
            res.json({ status: 1, message: 'Clinical Notes has been Updated.', data: '' });
        }

  } catch (error) {
      throw error;
  }
};
exports.deleteClinicalNotes = async (req, res) => {
  try {
    let getData = [], results;
    ClinicalNotesModal = await ClinicalNotes.destroy({where: {id: req.params.id}});
        if(ClinicalNotesModal === null){
            res.json({ status: 0, message: 'Something Went Wrong, Please Try Againg Later!!' });
        }else{
            res.json({ status: 1, message: 'Clinical Note has been Deleted.', data: '' });
        } 
  } catch (error) {
      throw error;
  }
};

// Death Record
exports.getDeathRecord = async (req, res) => {
  try {
    let getData = [], results;
    DeathRecordModal = await DeathRecord.findOne({ 
        where: { patient_id: req.params.patient_id },
        include: [{
            model: User,
            attributes: ['id', ['id_organisation','org_id'],'first_name','last_name', 'username','email'],
            as:'addedby_details'
        },{
            model: User,
            attributes: ['id', ['id_organisation','org_id'],'first_name','last_name', 'username','email'],
            as:'updatedby_details'
        },{
            model: Organisation,
            attributes: ['id', 'nom','email','adresse'],
            as:'org_details'
        }]
     });
    if(DeathRecordModal === null){
        res.json({ status: 0, message: 'No Data Found' });
    }else{
        res.json({ status: 1, message: 'Death Record', data: DeathRecordModal });
    }
  } catch (error) {
      throw error;
  }
};
exports.getDeathRecordByID = async (req, res) => {
  try {
    let getData = [], results;
    DeathRecordModal = await DeathRecord.findOne({ 
        where: { id: req.params.death_id },
        include: [{
            model: User,
            attributes: ['id', ['id_organisation','org_id'],'first_name','last_name', 'username','email'],
            as:'addedby_details'
        },{
            model: User,
            attributes: ['id', ['id_organisation','org_id'],'first_name','last_name', 'username','email'],
            as:'updatedby_details'
        },{
            model: Organisation,
            attributes: ['id', 'nom','email','adresse'],
            as:'org_details'
        }]
     });
    if(DeathRecordModal === null){
        res.json({ status: 0, message: 'No Data Found' });
    }else{
        res.json({ status: 1, message: 'Death Record', data: DeathRecordModal });
    }
  } catch (error) {
      throw error;
  }
};
exports.addDeathRecord = async (req, res) => {
  try {
    let getData = [], results;
    PatientModal = await Patient.findOne({where: { id: req.body.patient_id} });    
    DeathRecordModal = await DeathRecord.create({ 
        patient_id: req.body.patient_id,
        org_id: req.org_id,

        patient_name: PatientModal.name +' '+PatientModal.last_name,
        gender: PatientModal.sex,
        age: PatientModal.age,

        cause_of_death: req.body.cause_of_death,
        manner_of_death: req.body.manner_of_death,
        pregnancy_death_associated: req.body.pregnancy_death_associated,
        was_there_delivery: req.body.was_there_delivery,
        dateofdeath: req.body.dateofdeath,
        timeofdeath: req.body.timeofdeath,

        status: 1,
        added_by: req.userId
                            });
    if(DeathRecordModal === null){
        res.json({ status: 0, message: 'Something Went Wrong, Please Try Againg Later!!' });
        
    }else{
        await PatientLogs.create({
            patient_id: DeathRecordModal.patient_id,
            org_id: req.org_id,
            description: 'Patient Has been died on '+DeathRecordModal.dateofdeath+' '+req.body.timeofdeath,
            type: 'death_record',
            relation_id: DeathRecordModal.id,
            status: 1,
            added_by: req.userId
        });
        res.json({ status: 1, message: 'Death has been recorded.', data: '' });
    }
          
  } catch (error) {
      throw error;
  }
};
exports.updateDeathRecord = async (req, res) => {
  try {
    let getData = [], results;
    DeathRecordModal = await DeathRecord.update({content: req.body.content,updated_by: req.userId,}, {where: {id: req.params.id}});
        if(DeathRecordModal === null){
            res.json({ status: 0, message: 'Something Went Wrong, Please Try Againg Later!!' });
        }else{
            res.json({ status: 1, message: 'Death record has been Updated.', data: '' });
        }
  } catch (error) {
      throw error;
  }
};
exports.deleteDeathRecord = async (req, res) => {
  try {
    let getData = [], results;
    DeathRecordModal = await DeathRecord.destroy({where: {id: req.params.id}});
        if(DeathRecordModal === null){
            res.json({ status: 0, message: 'Something Went Wrong, Please Try Againg Later!!' });
        }else{
            res.json({ status: 1, message: 'Death record has been Deleted.', data: '' });
        } 
  } catch (error) {
      throw error;
  }
};

// Hospitalization
exports.getHospitalization = async (req, res) => {
  try {
    let offsetdata = parseInt(req.query.offset ? ((req.query.offset == undefined || req.query.offset == 1) ? 0 :req.query.offset) : 0);
    if(isNaN(offsetdata)){
        offsetdata = 0;
    }
    let datalimit = parseInt(req.query.limit ? ((req.query.limit == undefined) ? 5 :req.query.limit) : 5);
    if(isNaN(datalimit)){
        datalimit = 5;
    }
    const { count, rows } = await PatientHospitalization.findAndCountAll({where: { patient_id: req.params.patient_id }});

    PatientHospitalizationModal = await PatientHospitalization.findAll({ 
        where: { patient_id: req.params.patient_id },
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
            model: Organisation,
            attributes: ['id', 'nom','email','adresse'],
            as:'org_details'
        }]
     });
    if(PatientHospitalizationModal === null){
        res.json({ status: 0, message: 'No Data Found' });
    }else{
        res.json({ status: 1, message: 'Patient hospitalizations List', data: PatientHospitalizationModal,total:count });
    }
  } catch (error) {
      throw error;
  }
};
exports.getHospitalizationByID = async (req, res) => {
  try {
    let getData = [], results;
    PatientHospitalizationModal = await PatientHospitalization.findOne({ where: { id: req.params.hospitalization_id } });
    if(PatientHospitalizationModal === null){
        res.json({ status: 0, message: 'No Data Found' });
    }else{
        res.json({ status: 1, message: 'Patient hospitalization Details', data: PatientHospitalizationModal });
    }
  } catch (error) {
      throw error;
  }
};
exports.addHospitalization = async (req, res) => {
  try {
    let getData = [], results;
    PatientModal = await Patient.findOne({where: { id: req.body.patient_id} });    
    PatientHospitalizationModal = await PatientHospitalization.create({ 
        patient_id: req.body.patient_id,
        org_id: req.org_id,

        patient_name: PatientModal.name +' '+PatientModal.last_name,
        patient_dob: PatientModal.birthdate,
        patient_age: PatientModal.age,
        patient_gender: PatientModal.sex,
        patient_phone: PatientModal.phone_contact,
        patient_address: PatientModal.address,

        reason: req.body.reason,
        current_disease: req.body.current_disease,
        hospitalization_date: req.body.hospitalization_date,
        hospitalization_time: req.body.hospitalization_time,

        status: 1,
        added_by: req.userId
                            });
    if(PatientHospitalizationModal === null){
        res.json({ status: 0, message: 'Something Went Wrong, Please Try Againg Later!!' });
    }else{
        
        await PatientLogs.create({
            patient_id: PatientHospitalizationModal.patient_id,
            org_id: req.org_id,
            description: 'Patient Has been hospitalized on '+PatientHospitalizationModal.hospitalization_date,
            type: 'hospitalization',
            relation_id: PatientHospitalizationModal.id,
            status: 1,
            added_by: req.userId
        });
        res.json({ status: 1, message: 'Patient hospitalization has been recorded.', data: '' });
    }
          
  } catch (error) {
      throw error;
  }
};
exports.updateHospitalization = async (req, res) => {
  try {
    let getData = [], results;
    PatientHospitalizationModal = await PatientHospitalization.update({content: req.body.content,updated_by: req.userId,}, {where: {id: req.params.id}});
        if(PatientHospitalizationModal === null){
            res.json({ status: 0, message: 'Something Went Wrong, Please Try Againg Later!!' });
        }else{
            res.json({ status: 1, message: 'Patient hospitalization has been Updated.', data: '' });
        }

  } catch (error) {
      throw error;
  }
};
exports.deleteHospitalization = async (req, res) => {
  try {
    let getData = [], results;
    PatientHospitalizationModal = await PatientHospitalization.destroy({where: {id: req.params.id}});
        if(PatientHospitalizationModal === null){
            res.json({ status: 0, message: 'Something Went Wrong, Please Try Againg Later!!' });
        }else{
            res.json({ status: 1, message: 'Patient hospitalization has been Deleted.', data: '' });
        } 
  } catch (error) {
      throw error;
  }
};

// Prescription
exports.getPrescription = async (req, res) => {
  try {
    let offsetdata = parseInt(req.query.offset ? ((req.query.offset == undefined || req.query.offset == 1) ? 0 :req.query.offset) : 0);
    if(isNaN(offsetdata)){
        offsetdata = 0;
    }
    let datalimit = parseInt(req.query.limit ? ((req.query.limit == undefined) ? 5 :req.query.limit) : 5);
    if(isNaN(datalimit)){
        datalimit = 5;
    }
    const { count, rows } = await Prescriptions.findAndCountAll({where: { patient_id: req.params.patient_id }});

    PrescriptionsModal = await Prescriptions.findAll({ 
        where: { patient_id: req.params.patient_id },
        limit: datalimit,
        offset: offsetdata
     });
    if(PrescriptionsModal === null){
        res.json({ status: 0, message: 'No Data Found' });
    }else{
        res.json({ status: 1, message: 'Prescription List', data: PrescriptionsModal,total:count });
    }
  } catch (error) {
      throw error;
  }
};
exports.getPrescriptionByID = async (req, res) => {
  try {
    let getData = [], results;
    PrescriptionsModal = await Prescriptions.findOne({ where: { id: req.params.prescription_id } });
    if(PrescriptionsModal === null){
        res.json({ status: 0, message: 'No Data Found' });
    }else{
        
        res.json({ status: 1, message: 'Prescription fetched', data: PrescriptionsModal });
    }
  } catch (error) {
      throw error;
  }
};
exports.addPrescription = async (req, res) => {
  try {
      let getData = [], results;
      PatientModal = await Patient.findOne({where: { id: req.body.patient_id} });    
      PrescriptionsModal = await Prescriptions.create({ 
          patient_id: req.body.patient_id,
          org_id: req.org_id,

          patient_name: PatientModal.name +' '+PatientModal.last_name,
          patient_gender: PatientModal.sex,
          patient_age: PatientModal.age,
          patient_dob: PatientModal.birthdate,

          advice: req.body.advice,
          medicin: JSON.parse(req.body.medicin),

          status: 1,
          added_by: req.userId
                              });
      if(PrescriptionsModal === null){
          res.json({ status: 0, message: 'Something Went Wrong, Please Try Againg Later!!' });
      }else{
            await PatientLogs.create({
                patient_id: PrescriptionsModal.patient_id,
                org_id: req.org_id,
                description: 'New prescription has been added ',
                type: 'precription',
                relation_id: PrescriptionsModal.id,
                status: 1,
                added_by: req.userId
            });
          res.json({ status: 1, message: 'New prescription has been added.', data: '' });
      }
          
  } catch (error) {
      throw error;
  }
};
exports.updatePrescription = async (req, res) => {
  try {
    let getData = [], results;
    PrescriptionsModal = await Prescriptions.update({content: req.body.content,updated_by: req.userId,}, {where: {id: req.params.id}});
        if(PrescriptionsModal === null){
            res.json({ status: 0, message: 'Something Went Wrong, Please Try Againg Later!!' });
        }else{
            res.json({ status: 1, message: 'Prescription has been updated.', data: '' });
        }

  } catch (error) {
      throw error;
  }
};
exports.deletePrescription = async (req, res) => {
  try {
    let getData = [], results;
    PrescriptionsModal = await Prescriptions.destroy({where: {id: req.params.id}});
        if(PrescriptionsModal === null){
            res.json({ status: 0, message: 'Something Went Wrong, Please Try Againg Later!!' });
        }else{
            res.json({ status: 1, message: 'Prescription has been Deleted.', data: '' });
        } 
  } catch (error) {
      throw error;
  }
};


// Lab Test
exports.getLabTest = async (req, res) => {
    try {
        let offsetdata = parseInt(req.query.offset ? ((req.query.offset == undefined || req.query.offset == 1) ? 0 :req.query.offset) : 0);
        if(isNaN(offsetdata)){
            offsetdata = 0;
        }
        let datalimit = parseInt(req.query.limit ? ((req.query.limit == undefined) ? 5 :req.query.limit) : 5);
        if(isNaN(datalimit)){
            datalimit = 5;
        }
        const { count, rows } = await TestRequests.findAndCountAll({where: { patient_id: req.params.patient_id,type:'lab' }});

      TestRequestsModal = await TestRequests.findAll({ 
            where: { patient_id: req.params.patient_id,type:'lab' },
            limit: datalimit,
            offset: offsetdata
        });
      if(TestRequestsModal === null){
          res.json({ status: 0, message: 'No Data Found' });
      }else{
          res.json({ status: 1, message: 'Lab Request List', data: TestRequestsModal,total:count });
      }
    } catch (error) {
        throw error;
    }
  };
exports.getLabTestByID = async (req, res) => {
try {
    let getData = [], results;
    TestRequestsModal = await TestRequests.findOne({ where: { id: req.params.request_id,type:'lab' } });
    if(TestRequestsModal === null){
        res.json({ status: 0, message: 'No Data Found' });
    }else{
        res.json({ status: 1, message: 'Lab Requests fetched', data: TestRequestsModal });
    }
} catch (error) {
    throw error;
}
};
exports.getLabTestList = async (req, res) => {
try {
        LabTestList = await Database.query("SELECT payment_category.id,payment_category.prestation,setting_service.code_service FROM setting_service LEFT JOIN setting_service_specialite ON setting_service.idservice=setting_service_specialite.id_service LEFT JOIN payment_category ON setting_service.idservice=payment_category.id_service where code_service='labo'",{type: Database.QueryTypes.SELECT});
        if(LabTestList === null){
            res.json({ status: 0, message: 'No Data Found' });
        }else{
            res.json({ status: 1, message: 'Lab Test List', data: LabTestList });
        }
    } catch (error) {
        throw error;
    }
};
exports.addLabTest = async (req, res) => {
    try {
        let getData = [], results;
        PatientModal = await Patient.findOne({where: { id: req.body.patient_id} });    
        TestRequestsModal = await TestRequests.create({ 
            patient_id: req.body.patient_id,
            org_id: req.org_id,
            type: 'lab',
            reports: JSON.parse(req.body.reports),
            status: 0,
            added_by: req.userId
        });
        if(TestRequestsModal === null){
            res.json({ status: 0, message: 'Something Went Wrong, Please Try Againg Later!!' });
            
        }else{
            await PatientLogs.create({
                patient_id: TestRequestsModal.patient_id,
                org_id: req.org_id,
                description: 'New Lab Request has been added ',
                type: 'lab',
                relation_id: TestRequestsModal.id,
                status: 1,
                added_by: req.userId
            });
            res.json({ status: 1, message: 'New Lab Request has been added.', data: '' });
        }
            
    } catch (error) {
        throw error;
    }
  };
exports.updateLabTest = async (req, res) => {
    try {
        let getData = [], results;
        TestRequestsModal = await TestRequests.update({content: req.body.content,updated_by: req.userId,}, {where: {id: req.params.id}});
            if(TestRequestsModal === null){
                res.json({ status: 0, message: 'Something Went Wrong, Please Try Againg Later!!' });
            }else{
                res.json({ status: 1, message: 'Lab Request has been updated.', data: '' });
            }

    } catch (error) {
        throw error;
    }
};
exports.deleteLabTest = async (req, res) => {
    try {
        let getData = [], results;
        TestRequestsModal = await TestRequests.destroy({where: {id: req.params.id}});
            if(TestRequestsModal === null){
                res.json({ status: 0, message: 'Something Went Wrong, Please Try Againg Later!!' });
            }else{
                res.json({ status: 1, message: 'Lab Request has been Deleted.', data: '' });
            } 
    } catch (error) {
        throw error;
    }
};


  // Imaging Request
exports.getImagingRequest = async (req, res) => {
try {
    let offsetdata = parseInt(req.query.offset ? ((req.query.offset == undefined || req.query.offset == 1) ? 0 :req.query.offset) : 0);
    if(isNaN(offsetdata)){
        offsetdata = 0;
    }
    let datalimit = parseInt(req.query.limit ? ((req.query.limit == undefined || req.query.limit == 1) ? 5 :req.query.limit) : 5);
    if(isNaN(datalimit)){
        datalimit = 5;
    }
    const { count, rows } = await ImagingRequests.findAndCountAll({where: { patient_id: req.params.patient_id,type: 'imaging'  }});

    ImagingRequestsModal = await ImagingRequests.findAll({ 
        where: { patient_id: req.params.patient_id,type: 'imaging' },
        limit: datalimit,
        offset: offsetdata
     });
    if(ImagingRequestsModal === null){
        res.json({ status: 0, message: 'No Data Found' });
    }else{
        res.json({ status: 1, message: 'ImagingRequest', data: ImagingRequestsModal,total:count });
    }
} catch (error) {
    throw error;
}
};
exports.getImagingRequestByID = async (req, res) => {
try {
    let getData = [], results;
    TestRequestsModal = await TestRequests.findOne({ where: { id: req.params.request_id,type: 'imaging' } });
    if(TestRequestsModal === null){
        res.json({ status: 0, message: 'No Data Found' });
    }else{
        res.json({ status: 1, message: 'Prescription fetched', data: TestRequestsModal });
    }
} catch (error) {
    throw error;
}
};
exports.getImagingRequestList = async (req, res) => {
    try {

        ImagingReq = await Database.query("SELECT setting_service_specialite.idspe,setting_service_specialite.name_specialite,setting_service.code_service FROM setting_service LEFT JOIN setting_service_specialite ON setting_service.idservice=setting_service_specialite.id_service where code_service='IMAG'",{type: Database.QueryTypes.SELECT});
        if(ImagingReq === null){
            res.json({ status: 0, message: 'No Data Found' });
        }else{
            res.json({ status: 1, message: 'Imaging List', data: ImagingReq });
        }
    } catch (error) {
        throw error;
    }
};
exports.addImagingRequest = async (req, res) => {
try {
    PatientModal = await Patient.findOne({where: { id: req.body.patient_id} });    
    TestRequestsModal = await TestRequests.create({ 
        patient_id: req.body.patient_id,
        org_id: req.org_id,
        type: 'imaging',
        reports: JSON.parse(req.body.reports),
        status: 0,
        added_by: req.userId
                            });
    if(TestRequestsModal === null){
        res.json({ status: 0, message: 'Something Went Wrong, Please Try Againg Later!!' });
        
    }else{
        await PatientLogs.create({
            patient_id: TestRequestsModal.patient_id,
            org_id: req.org_id,
            description: 'New Imaging Request has been added ',
            type: 'imaging_request',
            relation_id: TestRequestsModal.id,
            status: 1,
            added_by: req.userId
        });
        res.json({ status: 1, message: 'New Imaging Request has been added.', data: '' });
    }
        
} catch (error) {
    throw error;
}
};
exports.updateImagingRequest = async (req, res) => {
try {
    TestRequestsModal = await TestRequests.update({content: req.body.content,updated_by: req.userId,}, {where: {id: req.params.id}});
        if(TestRequestsModal === null){
            res.json({ status: 0, message: 'Something Went Wrong, Please Try Againg Later!!' });
        }else{
            res.json({ status: 1, message: 'Imaging Request has been updated.', data: '' });
        }

} catch (error) {
    throw error;
}
};
exports.deleteImagingRequest = async (req, res) => {
try {
    TestRequestsModal = await TestRequests.destroy({where: {id: req.params.id}});
        if(TestRequestsModal === null){
            res.json({ status: 0, message: 'Something Went Wrong, Please Try Againg Later!!' });
        }else{
            res.json({ status: 1, message: 'Imaging Request has been Deleted.', data: '' });
        } 
} catch (error) {
    throw error;
}
};


// Helper
exports.medicinList = async (req, res) => {
  try {
    let getData = [], results;
        
        MasterMedicineModal = await MasterMedicine.findAll({ 
            attributes: ['id', 'name', 'category', 'dosage', 'type', 'generic','company','description'], 
            where: { status: 'Active' } });
    if(MasterMedicineModal === null){
        res.json({ status: 0, message: 'No Data Found' });
    }else{
        res.json({ status: 1, message: 'Medicin List', data: MasterMedicineModal });
    }
  } catch (error) {
      throw error;
  }
};
exports.deseaseList = async (req, res) => {
  try {
    let getData = [], results;
        console.log(req);
    IllnessModal = await Illness.findAll({ where: {
        affection: {
          [Op.like]: ''+req.query.search+'%'
        }
      },limit: 50 });
    if(IllnessModal === null){
        res.json({ status: 0, message: 'No Data Found' });
    }else{
        res.json({ status: 1, message: 'Desease List', data: IllnessModal });
    }
  } catch (error) {
      throw error;
  }
};
exports.timeLine = async (req, res) => {
  try {
    let offsetdata = parseInt(req.query.offset ? ((req.query.offset == undefined || req.query.offset == 1) ? 0 :req.query.offset) : 0);
    if(isNaN(offsetdata)){
        offsetdata = 0;
    }
    let datalimit = parseInt(req.query.limit ? ((req.query.limit == undefined || req.query.limit == 1) ? 5 :req.query.limit) : 5);
    if(isNaN(datalimit)){
        datalimit = 5;
    }
    const { count, rows } = await PatientLogs.findAndCountAll({where: { patient_id: req.params.patient_id }});

    const PatientLogsModal = await PatientLogs.findAll({
        attributes: ['id', 'description','type','relation_id', 'status','added_by','updated_by',[Sequelize.fn("DATE_FORMAT", Sequelize.col("createdAt"),"%d-%m-%Y %H:%i:%s"),"createdAt"],[Sequelize.fn("DATE_FORMAT", Sequelize.col("updatedAt"),"%d-%m-%Y %H:%i:%s"),"updatedAt"],'patient_id','org_id'], 
        where: { patient_id: req.params.patient_id },
        order: [['id', 'desc']],
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
            model: Organisation,
            attributes: ['id', 'nom','email','adresse'],
            as:'org_details'
        }]
    });
    if(PatientLogsModal === null){
        res.json({ status: 0, message: 'No Data Found' });
    }else{
        res.json({ status: 1, message: 'Patient Logs', data: PatientLogsModal,total:count });
    }
  } catch (error) {
      throw error;
  }
};











