const express = require("express");
const router = express.Router();
const VerifyToken = require('./VerifyToken');
const patientController = require("../controllers/patient.controller");
const multer  = require('multer');
const support = require('../multer/pdf')

const storage = multer.diskStorage({
    destination: function (req, file, cb) {
      cb(null, '../uploads/imgUsers')
    },
    filename: function (req, file, cb) {
        const { originalname } = file;
        const fileExtension = (originalname.match(/\.+[\S]+$/) || [])[0];
        const uniqueSuffix = Date.now() + '-' + Math.round(Math.random() * 1E9)
        cb(null, file.fieldname + '-' + uniqueSuffix+fileExtension)
    }
  });
  const upload = multer({ storage: storage });

  //Attachment/Document Storage
  const Documentstorage = multer.diskStorage({
    destination: function (req, file, cb) {
      cb(null, '../uploads/documentsPatient/')
    },
    filename: function (req, file, cb) {
        const { originalname } = file;
        const fileExtension = (originalname.match(/\.+[\S]+$/) || [])[0];
        const uniqueSuffix = Date.now() + '-' + Math.round(Math.random() * 1E9)
        cb(null, file.fieldname + '-' + uniqueSuffix+fileExtension)
    }
  });

const DocumentUpload = multer({ storage: Documentstorage });
console.log(DocumentUpload);
router.get('/',VerifyToken, patientController.getAllPatients);
router.get('/update-unique-id',VerifyToken, patientController.updateUniqueID);


const PProfileUpload = upload.fields([{ name: 'profile', maxCount: 1 }]);
router.post('/add',[VerifyToken,PProfileUpload], patientController.addPatient);
router.get('/general-info/:patient_id',VerifyToken, patientController.getGeneralInfo);
router.post('/general-info-update/:patient_id',[VerifyToken,PProfileUpload], patientController.updateGeneralInfo);


// Appointments
router.get('/appointments/:patient_id',VerifyToken, patientController.getAppontments);
router.get('/appointment/by-id/:appointment_id',VerifyToken, patientController.getAppointmentByID);
router.post('/appointment/add',VerifyToken, patientController.addAppontment);
router.post('/appointment/update/:id',VerifyToken, patientController.updateAppontment);
router.delete('/appointment/delete/:id',VerifyToken, patientController.deleteAppontment);
router.patch('/appointment/status/:id',VerifyToken, patientController.statusAppontment);
router.get('/appointment/services',VerifyToken, patientController.serviceAppontment);
router.post('/appointment/time-slots',VerifyToken, patientController.timeSlotAppontment);


// Invoice Payments
router.get('/invoices-payments/:patient_id',VerifyToken, patientController.getInvoicePayments);
router.post('/invoice-payments/deposit/add',VerifyToken, patientController.addDepositInvoicePayments);
router.get('/invoice-payments/receipt/:invoice_id',VerifyToken, patientController.getReceiptInvoicePayments);
router.get('/invoice-payments/service-category',VerifyToken, patientController.getServiceInvoicePayments);
router.get('/invoice-payments/get-partner-organization',VerifyToken, patientController.getPartnerOrgInvoicePayments);
router.get('/invoice-payments/get-light-organization',VerifyToken, patientController.getLightOrgInvoicePayments);
router.get('/invoice-payments/patient/payment/details/:patient_id',VerifyToken, patientController.getPaymentDetailsInvoicePayments);
router.post('/invoice-payments/add',VerifyToken, patientController.addPayments);


// Dependants
router.get('/dependants/:patient_id',VerifyToken, patientController.getDependants);
router.get('/dependant/by-id/:dependant_id',VerifyToken, patientController.getDependantByID);
const DependantUpload = upload.fields([{ name: 'profile', maxCount: 1 }]);
router.post('/dependant/add',[VerifyToken,DependantUpload], patientController.addDependant);
const DependantUpdateUpload = upload.fields([{ name: 'profile', maxCount: 1 }]);
router.patch('/dependant/update/:id',[VerifyToken,DependantUpdateUpload], patientController.updateDependant);
router.delete('/dependant/delete/:id',VerifyToken, patientController.deleteDependant);


// Assurance
router.get('/get-assurance/:patient_id',VerifyToken, patientController.getAssurance);
router.get('/get-assurance/by-id/:assurance_id',VerifyToken, patientController.getAssuranceByID);
router.get('/assurance/organizations',VerifyToken, patientController.getAssuranceOrg);
router.post('/assurance/add',VerifyToken, patientController.addAssurance);
router.patch('/assurance/update/:id',VerifyToken, patientController.updateAssurance);
router.delete('/assurance/delete/:id',VerifyToken, patientController.deleteAssurance);

// Attachments
router.get('/get-attachments/:patient_id',VerifyToken, patientController.getAttachments);
router.get('/get-attachment/by-id/:attachment_id',VerifyToken, patientController.getAttachmentsByID);
router.get('/attachment/get-document-types',VerifyToken, patientController.getAttachmentsTypes);
const cpUpload = DocumentUpload.fields([{ name: 'document', maxCount: 1 }]);
router.post('/attachment/add',[VerifyToken,cpUpload], patientController.addAttachments);
router.patch('/attachment/update/:id',VerifyToken, patientController.updateAttachments);
router.delete('/attachment/delete/:id',VerifyToken, patientController.deleteAttachments);

// Vital Sign
router.get('/vital-sign/:patient_id',VerifyToken, patientController.getVitalSign);
router.get('/vital-sign/graph/:patient_id',VerifyToken, patientController.getVitalSignGraph);
router.get('/vital-sign/by-id/:vital_id',VerifyToken, patientController.getVitalSignByID);
router.post('/vital-sign/add',VerifyToken, patientController.addVitalSign);
router.patch('/vital-sign/update/:id',VerifyToken, patientController.updateVitalSign);
router.delete('/vital-sign/delete/:id',VerifyToken, patientController.deleteVitalSign);


// Medications
router.get('/get-current-medications/:patient_id',VerifyToken, patientController.getCurrentMedication);
router.get('/get-current-medication/by-id/:medication_id',VerifyToken, patientController.getCurrentMedicationByID);
router.post('/current-medication/add',VerifyToken, patientController.addCurrentMedication);
router.patch('/current-medication/update/:id',VerifyToken, patientController.updateCurrentMedication);
router.delete('/current-medication/delete/:id',VerifyToken, patientController.deleteCurrentMedication);


// Known Health issues
router.get('/get-known-health-issues/:patient_id',VerifyToken, patientController.getKnownHealthIssues);
router.get('/get-known-health-issue/by-id/:pre_condition_id',VerifyToken, patientController.getKnownHealthIssuesByID);
router.post('/known-health-issue/add',VerifyToken, patientController.addKnownHealthIssues);
router.patch('/known-health-issue/update/:id',VerifyToken, patientController.updateKnownHealthIssues);
router.delete('/known-health-issue/delete/:id',VerifyToken, patientController.deleteKnownHealthIssues);


// Confidential Notes
router.get('/confidential-notes/:patient_id',VerifyToken, patientController.getConfidentialNotes);
router.get('/confidential-notes/by-id/:confidential_notes_id',VerifyToken, patientController.getConfidentialNotesByID);
router.post('/confidential-notes/add',VerifyToken, patientController.addConfidentialNotes);
router.patch('/confidential-notes/update/:id',VerifyToken, patientController.updateConfidentialNotes);
router.delete('/confidential-notes/delete/:id',VerifyToken, patientController.deleteConfidentialNotes);


// clinical-notes.
router.get('/clinical-notes/:patient_id',VerifyToken, patientController.getClinicalNotes);
router.get('/clinical-notes/by-id/:clinical_note_id',VerifyToken, patientController.getClinicalNotesByID);
router.post('/clinical-notes/add',VerifyToken, patientController.addClinicalNotes);
router.patch('/clinical-notes/update/:id',VerifyToken, patientController.updateClinicalNotes);
router.delete('/clinical-notes/delete/:id',VerifyToken, patientController.deleteClinicalNotes);


// death-record
router.get('/death-record/:patient_id',VerifyToken, patientController.getDeathRecord);
router.get('/death-record/by-id/:death_id',VerifyToken, patientController.getDeathRecordByID);
router.post('/death-record/add',VerifyToken, patientController.addDeathRecord);
router.patch('/death-record/update/:id',VerifyToken, patientController.updateDeathRecord);
router.delete('/death-record/delete/:id',VerifyToken, patientController.deleteDeathRecord);


// Hospitalization
router.get('/hospitalization-record/:patient_id',VerifyToken, patientController.getHospitalization);
router.get('/hospitalization-record/by-id/:hospitalization_id',VerifyToken, patientController.getHospitalizationByID);
router.post('/hospitalization-record/add',VerifyToken, patientController.addHospitalization);
router.patch('/hospitalization-record/update/:id',VerifyToken, patientController.updateHospitalization);
router.delete('/hospitalization-record/delete/:id',VerifyToken, patientController.deleteHospitalization);


// Prescription
router.get('/prescription/:patient_id',VerifyToken, patientController.getPrescription);
router.get('/prescription/by-id/:prescription_id',VerifyToken, patientController.getPrescriptionByID);
router.post('/prescription/add',VerifyToken, patientController.addPrescription);
router.patch('/prescription/update/:id',VerifyToken, patientController.updatePrescription);
router.delete('/prescription/delete/:id',VerifyToken, patientController.deletePrescription);


// Lab Test request
router.get('/lab-test/:patient_id',VerifyToken, patientController.getLabTest);
router.get('/lab-test/by-id/:request_id',VerifyToken, patientController.getLabTestByID);
router.get('/labtest/list',VerifyToken, patientController.getLabTestList);
router.post('/lab-test/add',VerifyToken, patientController.addLabTest);
router.patch('/lab-test/update/:id',VerifyToken, patientController.updateLabTest);
router.delete('/lab-test/delete/:id',VerifyToken, patientController.deleteLabTest);

// Imaging Request
router.get('/imaging-request/:patient_id',VerifyToken, patientController.getImagingRequest);
router.get('/imaging-request/by-id/:request_id',VerifyToken, patientController.getImagingRequestByID);
router.get('/imagingrequest/list',VerifyToken, patientController.getImagingRequestList);
router.post('/imaging-request/add',VerifyToken, patientController.addImagingRequest);
router.patch('/imaging-request/update/:id',VerifyToken, patientController.updateImagingRequest);
router.delete('/imaging-request/delete/:id',VerifyToken, patientController.deleteImagingRequest);

router.get('/medicine-list',VerifyToken, patientController.medicinList);
router.get('/desease-list',VerifyToken, patientController.deseaseList);
router.get('/medical-history/timeline/:patient_id',VerifyToken, patientController.timeLine);


// Payment History
router.get('/payment-history/:patient_id',VerifyToken, patientController.getPaymentHistory);
router.get('/payment-history/payment/details/:patient_id',VerifyToken, patientController.getPaymentHistoryInfo);
router.get('/payment-history/deposit-logs/:payment_id',VerifyToken, patientController.getPaymentDepositLogs);
module.exports = router;
