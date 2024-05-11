const https = require("https");
const fs = require("fs");
const moment = require("moment");
moment.locale("en");
const Sequelize = require("sequelize");
const Database = require("../config").sequelize;
const Op = Sequelize.Op;
const querystring = require("querystring");
var TestRequests = require("../models/TestRequests");
var Patient = require("../models/Patient");
var Settings = require("../models/Settings");
var User = require("../models/User");
var DoctorSignature = require("../models/DoctorSignature");
var Organisation = require("../models/Organisation");
// Docmosis
const BASEURL = process.env.SITE_URL;
const BASEPATH = process.env.BASE_PATH;
async function Docmosis(type, id, data) {
  return new Promise((resolve, reject) => {
    const formData = data;
    const templateNameValue = {
      lab: "ecoMed24.dev/requests/ecomed_MasterRequestTemplateV0.7.docx",
      lab_test_request:
        "ecoMed24.dev/requests/ecomed_MasterRequestTemplateV0.7.docx",
      imaging_request:
        "ecoMed24.dev/requests/ecomed_MasterRequestTemplateV0.7.docx",
      prescription:
        "ecoMed24.dev/requests/ecomed_MasterRequestTemplateV0.7.docx",
    };

    const pathToStore = {
      lab: BASEPATH + "uploads/invoicefile/",
      lab_test_request: BASEPATH + "uploads/invoicefile/",
      imaging_request: BASEPATH + "uploads/invoicefile/",
      prescription: BASEPATH + "uploads/invoicefile/",
    };
    const outputName = `${type}-${id}-${moment().unix()}.pdf`;
    const accessKey = process.env.DOCMOSIS_ACCESSKEY;

    const postData = querystring.stringify({
      accessKey: accessKey,
      templateName: templateNameValue[type],
      outputName: outputName,
      data: JSON.stringify(formData),
    });

    const options = {
      hostname: "eu.dws3.docmosis.com",
      port: 443,
      path: "/api/render",
      method: "POST",
      headers: {
        "Content-Type": "application/x-www-form-urlencoded",
        "Content-Length": Buffer.byteLength(postData),
      },
    };

    const ReqPromise = new Promise((resolve, reject) => {
      const ReqResponse = https.request(options, (resp) => {
        switch (resp.statusCode) {
          case 200:
            const pdfPath = `${pathToStore[type]}${outputName}`;
            console.log(pdfPath);
            const file = fs.createWriteStream(pdfPath);

            // feed response into file
            resp.pipe(file);
            file.on("finish", () => {
              file.close();

              console.log(pdfPath, "created");
              // Resolve with success JSON
              const successResponse = {
                status: true,
                message: "PDF created successfully",
                pdfPath: BASEURL + "/uploads/invoicefile/" + outputName,
                filename: outputName,
              };
              resolve(successResponse);
            });
            break;
          default:
            // show error response (details)
            console.log("Error response:", resp.statusCode, resp.statusMessage);
            let errorResponse = "";
            resp.on("data", (data) => {
              errorResponse += data;
            });
            resp.on("end", () => {
              console.log(errorResponse);
              // Resolve with error JSON
              const errorResponseObj = {
                status: 0,
                message: `Error: ${resp.statusCode} ${resp.statusMessage}`,
                details: errorResponse,
              };
              resolve(errorResponseObj);
            });
        }
      });

      ReqResponse.on("error", (e) => {
        console.error("Request error:", JSON.stringify(e, null, 4));
        reject(e);
      });

      // write data to request body
      ReqResponse.write(postData);
      ReqResponse.end();
    });

    ReqPromise.then((response) => {
      resolve(response);
    }).catch((error) => {
      console.error("Server Error:", error);
      reject({
        status: 0,
        message: "Unable to generate PDF at the moment.",
      });
    });
  });
}

async function dataPrepare(type, org_id, signature, id, userId) {
  try {
    const preparedData = {};
    switch (type) {
      case "lab_test_request":
        TestRequestsModal = await TestRequests.findOne({
          where: { id: id, type: "lab" },
        });
        patientModel = await Patient.findOne({
          where: { id: TestRequestsModal.patient_id },
        });
        SettingsModal = await Settings.findOne({});
        OrganisationModal = await Organisation.findOne({
          where: { id: org_id },
        });
        UserModel = await User.findOne({
          where: { id: userId },
        });
        DoctorSignatureModal = await DoctorSignature.findOne({
          where: { doc_id: userId },
        });

        PreparedData = {
          id_acte: id,
          id_organisation: org_id,
          path_logo: OrganisationModal.path_logo,
          nom_organisation: OrganisationModal.nom,
          organisationLocation: OrganisationModal.adresse,
          settings: {
            id: SettingsModal.id,
            system_vendor: SettingsModal.system_vendor,
            title: SettingsModal.title,
            address: SettingsModal.address,
            phone: SettingsModal.phone,
            email: SettingsModal.email,
            facebook_id: SettingsModal.facebook_id,
            currency: SettingsModal.currency,
            language: SettingsModal.language,
            discount: SettingsModal.discount,
            vat: SettingsModal.vat,
            login_title: SettingsModal.login_title,
            logo: SettingsModal.logo,
            payment_gateway: SettingsModal.payment_gateway,
            sms_gateway: SettingsModal.sms_gateway,
            codec_username: SettingsModal.codec_username,
            codec_purchase_code: SettingsModal.codec_purchase_code,
            live_appointment_type: SettingsModal.live_appointment_type,
          },
          organisationID: org_id,
          doctorList: [
            {
              doctorFirstName: "Jean David",
              doctorLastName: "BONKOUNGOU",
              fonction: "Doctor",
            },
            {
              doctorFirstName: "Ndeye",
              doctorLastName: "Waré",
              fonction: "Doctor",
            },
            {
              doctorFirstName: "Ibnou",
              doctorLastName: "Diagne",
              fonction: "Medecin Gerant",
            },
            {
              doctorFirstName: "Ahmadou",
              doctorLastName: "Boye",
              fonction: "Medecin Gerant",
            },
            {
              doctorFirstName: "Babacar",
              doctorLastName: "Diallo",
              fonction: "Medecin Gerant",
            },
          ],
          organisationAddress: OrganisationModal.adresse,
          organisationLogo: ConvertToBase64(
            BASEPATH + OrganisationModal.path_logo
          ),
          resultQR:
            "image:base64:iVBORw0KGgoAAAANSUhEUgAABSgAAAUoAQMAAACVX6nLAAAABlBMVEX///8AAABVwtN+AAAACXBIWXMAAA7EAAAOxAGVKw4bAAAEUUlEQVR4nO3QSW7DQAxFwdz/0s4yQIOkPi1lAFJvJasHlvzxIUmSJEmSJEmSJEmSJEmSJEmSJOkP9LpuPjv/bN/tplFSUlJSUlJSUlJSUlJSUlJSUlJSUlJSUlKOypXjuHCeNP+MLZSUlJSUlJSUlJSUlJSUlJSUlJSUlJSUlJTXypYQrB5bAmVwHyUlJSUlJSUlJSUlJSUlJSUlJSUlJSUlJeWDynbzaiYlJSUlJSUlJSUlJSUlJSUlJSUlJSUlJSXl7yvbE+kCJSUlJSUlJSUlJSUlJSUlJSUlJSUlJSUl5bco09WKMFPvTKOkpKSkpKSkpKSkpKSkpKSkpKSkpKSkpKQMlOnMZ56CaZSUlJSUlJSUlJSUlJSUlJSUlJSUlJSUlJSpMq1Cz++enE5JSUlJSUlJSUlJSUlJSUlJSUlJSUlJSUl5PX01rnqqviZdoKSkpKSkpKSkpKSkpKSkpKSkpKSkpKSkpLyjnN+1omp6O3P+1gsvJSUlJSUlJSUlJSUlJSUlJSUlJSUlJSUl5aiszlW3puh5RjqIkpKSkpKSkpKSkpKSkpKSkpKSkpKSkpKSMlXOC6tvmFnBNEpKSkpKSkpKSkpKSkpKSkpKSkpKSkpKSsrbyldRy98r56+mpKSkpKSkpKSkpKSkpKSkpKSkpKSkpKSkXCkrajs4xbQz5s2UlJSUlJSUlJSUlJSUlJSUlJSUlJSUlJSUd5TtNV/vqi3BuFfRsa+9mZKSkpKSkpKSkpKSkpKSkpKSkpKSkpKSknJWzufSE9XP+dPTaZSUlJSUlJSUlJSUlJSUlJSUlJSUlJSUlJSzMiVUk97c3CpjKiUlJSUlJSUlJSUlJSUlJSUlJSUlJSUlJWVhm6cfTylrv4+SkpKSkpKSkpKSkpKSkpKSkpKSkpKSkpJypazOVTfsq86mXkpKSkpKSkpKSkpKSkpKSkpKSkpKSkpKSspU2e6pvMe+9ud8op2RfDYlJSUlJSUlJSUlJSUlJSUlJSUlJSUlJSVlAWw3tvz21vlEJU+ipKSkpKSkpKSkpKSkpKSkpKSkpKSkpKSkvFt6fyo6/p2H5JSUlJSUlJSUlJSUlJSUlJSUlJSUlJSUlP9P2d56nEu/M72lWqCkpKSkpKSkpKSkpKSkpKSkpKSkpKSkpKR8UznPrKbPk45LqxkXLEpKSkpKSkpKSkpKSkpKSkpKSkpKSkpKSsq1snVUk2bRvLkF9mhKSkpKSkpKSkpKSkpKSkpKSkpKSkpKSkrKu8qKkCqrkcE/QUlJSUlJSUlJSUlJSUlJSUlJSUlJSUlJSfmgMn1qrwpWKSkpKSkpKSkpKSkpKSkpKSkpKSkpKSkpKe8o999wLFT72tUVg5KSkpKSkpKSkpKSkpKSkpKSkpKSkpKSknJ2zLX3z8A331FSUlJSUlJSUlJSUlJSUlJSUlJSUlJSUlKulJIkSZIkSZIkSZIkSZIkSZIkSZJ+uE84LSfmdDBcVgAAAABJRU5ErkJggg==",
          request_type: "LABO",
          orderNumber: "F25713115-LAB-1095",
          orderingDoctor: "Dr " + UserModel.first_name + +UserModel.last_name,
          organisationAdress: OrganisationModal.adresse,
          orderingDoctorPhone: UserModel.phone,
          orderingDoctorMail: UserModel.email,
          patientPhone: "",
          patientMail: "",
          patientName: patientModel.name + " " + patientModel.last_name,
          patientFirstName: patientModel.name,
          patientLastName: patientModel.last_name,
          patientID: patientModel.unique_id,
          patientDOB: patientModel.birthdate,
          patientAge: patientModel.age,
          patientGender: patientModel.sex,
          receivedDate: moment(TestRequestsModal.createdAt).format(
            "DD/MM/YYYY HH:mm"
          ),
          receivedTime: "",
          collectedDate: moment(TestRequestsModal.createdAt).format(
            "DD/MM/YYYY HH:mm"
          ),
          numPassport: "PCDFK334343KL",
          motif: null,
          collectedTime: "",
          reportedDate: moment(TestRequestsModal.createdAt).format(
            "DD/MM/YYYY HH:mm"
          ),
          reportedTime: "",
          orderingOrganisationID: "",
          orderingOrganisationName: OrganisationModal.nom,
          clinicalNotes: "Clinical notes are here",
          signature: {
            id: DoctorSignatureModal.id,
            doc_id: DoctorSignatureModal.doc_id,
            sign_name: DoctorSignatureModal.sign_name,
            pin: DoctorSignatureModal.pin,
            date_time: DoctorSignatureModal.date_time,
          },
          doctorSignature: ConvertToBase64(
            BASEPATH + DoctorSignatureModal.sign_name
          ),
          specialtyList: [
            {
              specialtyID: "507",
              specialtyName: "Hématologie",
              code_specialite: "HEMATO",
              testList: TestRequestsModal.reports,
            },
          ],
          "note cliniques": "noteCliniques",
        };
        return PreparedData;
        break;
      case "imaging_request":
        TestRequestsModal = await TestRequests.findOne({
          where: { id: id, type: "imaging" },
        });
        patientModel = await Patient.findOne({
          where: { id: TestRequestsModal.patient_id },
        });
        SettingsModal = await Settings.findOne({});
        OrganisationModal = await Organisation.findOne({
          where: { id: org_id },
        });
        UserModel = await User.findOne({
          where: { id: userId },
        });
        DoctorSignatureModal = await DoctorSignature.findOne({
          where: { doc_id: userId },
        });

        PreparedData = {
          id_acte: id,
          id_organisation: org_id,
          path_logo: OrganisationModal.path_logo,
          nom_organisation: OrganisationModal.nom,
          organisationLocation: OrganisationModal.adresse,
          settings: {
            id: SettingsModal.id,
            system_vendor: SettingsModal.system_vendor,
            title: SettingsModal.title,
            address: SettingsModal.address,
            phone: SettingsModal.phone,
            email: SettingsModal.email,
            facebook_id: SettingsModal.facebook_id,
            currency: SettingsModal.currency,
            language: SettingsModal.language,
            discount: SettingsModal.discount,
            vat: SettingsModal.vat,
            login_title: SettingsModal.login_title,
            logo: SettingsModal.logo,
            payment_gateway: SettingsModal.payment_gateway,
            sms_gateway: SettingsModal.sms_gateway,
            codec_username: SettingsModal.codec_username,
            codec_purchase_code: SettingsModal.codec_purchase_code,
            live_appointment_type: SettingsModal.live_appointment_type,
          },
          organisationID: org_id,
          doctorList: [
            {
              doctorFirstName: "Jean David",
              doctorLastName: "BONKOUNGOU",
              fonction: "Doctor",
            },
            {
              doctorFirstName: "Ndeye",
              doctorLastName: "Waré",
              fonction: "Doctor",
            },
            {
              doctorFirstName: "Ibnou",
              doctorLastName: "Diagne",
              fonction: "Medecin Gerant",
            },
            {
              doctorFirstName: "Ahmadou",
              doctorLastName: "Boye",
              fonction: "Medecin Gerant",
            },
            {
              doctorFirstName: "Babacar",
              doctorLastName: "Diallo",
              fonction: "Medecin Gerant",
            },
          ],
          organisationAddress: OrganisationModal.adresse,
          organisationLogo: ConvertToBase64(
            BASEPATH + OrganisationModal.path_logo
          ),
          resultQR: "",
          patientName: patientModel.name + " " + patientModel.last_name,
          patientFirstName: patientModel.name,
          patientLastName: patientModel.last_name,
          patientID: patientModel.unique_id,
          patientDOB: patientModel.birthdate,
          patientAge: patientModel.age,
          patientGender: patientModel.sex,
          receivedDate: moment(TestRequestsModal.createdAt).format(
            "DD/MM/YYYY HH:mm"
          ),
          receivedTime: "",
          collectedDate: null,
          numPassport: null,
          motif: null,
          collectedTime: "",
          reportedDate: null,
          reportedTime: "",
          orderingDoctor: "Dr " + UserModel.first_name + +UserModel.last_name,
          orderingOrganisationID: org_id,
          orderingOrganisationName: OrganisationModal.nom,
          orderNumber: "",
          clinicalNotes: "",
          request_type: "RADIO",
          signature: {
            id: DoctorSignatureModal.id,
            doc_id: DoctorSignatureModal.doc_id,
            sign_name: DoctorSignatureModal.sign_name,
            pin: DoctorSignatureModal.pin,
            date_time: DoctorSignatureModal.date_time,
          },
          doctorSignature: ConvertToBase64(
            BASEPATH + DoctorSignatureModal.sign_name
          ),
          specialtyList: [
            {
              specialtyID: "362",
              specialtyName: "Radiologie",
              code_specialite: null,
              testList: TestRequestsModal.reports,
            },
          ],
        };
        return PreparedData;
        break;
      case "prescription":
        PrescriptionsModal = await Prescriptions.findOne({
          where: { id: id },
        });
        patientModel = await Patient.findOne({
          where: { id: PrescriptionsModal.patient_id },
        });
        SettingsModal = await Settings.findOne({});
        OrganisationModal = await Organisation.findOne({
          where: { id: org_id },
        });
        UserModel = await User.findOne({
          where: { id: userId },
        });
        DoctorSignatureModal = await DoctorSignature.findOne({
          where: { doc_id: userId },
        });
        PreparedData = {
          id_acte: id,
          id_organisation: org_id,
          path_logo: OrganisationModal.path_logo,
          nom_organisation: OrganisationModal.nom,
          organisationLocation: OrganisationModal.adresse,
          settings: {
            id: SettingsModal.id,
            system_vendor: SettingsModal.system_vendor,
            title: SettingsModal.title,
            address: SettingsModal.address,
            phone: SettingsModal.phone,
            email: SettingsModal.email,
            facebook_id: SettingsModal.facebook_id,
            currency: SettingsModal.currency,
            language: SettingsModal.language,
            discount: SettingsModal.discount,
            vat: SettingsModal.vat,
            login_title: SettingsModal.login_title,
            logo: SettingsModal.logo,
            payment_gateway: SettingsModal.payment_gateway,
            sms_gateway: SettingsModal.sms_gateway,
            codec_username: SettingsModal.codec_username,
            codec_purchase_code: SettingsModal.codec_purchase_code,
            live_appointment_type: SettingsModal.live_appointment_type,
          },
          organisationID: org_id,
          organisationAddress: OrganisationModal.adresse,
          organisationLogo: ConvertToBase64(
            BASEPATH + OrganisationModal.path_logo
          ),
          resultQR:
            "image:base64:iVBORw0KGgoAAAANSUhEUgAABSgAAAUoAQMAAACVX6nLAAAABlBMVEX///8AAABVwtN+AAAACXBIWXMAAA7EAAAOxAGVKw4bAAAEUUlEQVR4nO3QSW7DQAxFwdz/0s4yQIOkPi1lAFJvJasHlvzxIUmSJEmSJEmSJEmSJEmSJEmSJOkP9LpuPjv/bN/tplFSUlJSUlJSUlJSUlJSUlJSUlJSUlJSUlKOypXjuHCeNP+MLZSUlJSUlJSUlJSUlJSUlJSUlJSUlJSUlJTXypYQrB5bAmVwHyUlJSUlJSUlJSUlJSUlJSUlJSUlJSUlJeWDynbzaiYlJSUlJSUlJSUlJSUlJSUlJSUlJSUlJSXl7yvbE+kCJSUlJSUlJSUlJSUlJSUlJSUlJSUlJSUl5bco09WKMFPvTKOkpKSkpKSkpKSkpKSkpKSkpKSkpKSkpKQMlOnMZ56CaZSUlJSUlJSUlJSUlJSUlJSUlJSUlJSUlJSpMq1Cz++enE5JSUlJSUlJSUlJSUlJSUlJSUlJSUlJSUl5PX01rnqqviZdoKSkpKSkpKSkpKSkpKSkpKSkpKSkpKSkpLyjnN+1omp6O3P+1gsvJSUlJSUlJSUlJSUlJSUlJSUlJSUlJSUl5aiszlW3puh5RjqIkpKSkpKSkpKSkpKSkpKSkpKSkpKSkpKSMlXOC6tvmFnBNEpKSkpKSkpKSkpKSkpKSkpKSkpKSkpKSsrbyldRy98r56+mpKSkpKSkpKSkpKSkpKSkpKSkpKSkpKSkXCkrajs4xbQz5s2UlJSUlJSUlJSUlJSUlJSUlJSUlJSUlJSUd5TtNV/vqi3BuFfRsa+9mZKSkpKSkpKSkpKSkpKSkpKSkpKSkpKSknJWzufSE9XP+dPTaZSUlJSUlJSUlJSUlJSUlJSUlJSUlJSUlJSzMiVUk97c3CpjKiUlJSUlJSUlJSUlJSUlJSUlJSUlJSUlJWVhm6cfTylrv4+SkpKSkpKSkpKSkpKSkpKSkpKSkpKSkpJypazOVTfsq86mXkpKSkpKSkpKSkpKSkpKSkpKSkpKSkpKSspU2e6pvMe+9ud8op2RfDYlJSUlJSUlJSUlJSUlJSUlJSUlJSUlJSVlAWw3tvz21vlEJU+ipKSkpKSkpKSkpKSkpKSkpKSkpKSkpKSkvFt6fyo6/p2H5JSUlJSUlJSUlJSUlJSUlJSUlJSUlJSUlP9P2d56nEu/M72lWqCkpKSkpKSkpKSkpKSkpKSkpKSkpKSkpKR8UznPrKbPk45LqxkXLEpKSkpKSkpKSkpKSkpKSkpKSkpKSkpKSsq1snVUk2bRvLkF9mhKSkpKSkpKSkpKSkpKSkpKSkpKSkpKSkrKu8qKkCqrkcE/QUlJSUlJSUlJSUlJSUlJSUlJSUlJSUlJSfmgMn1qrwpWKSkpKSkpKSkpKSkpKSkpKSkpKSkpKSkpKe8o999wLFT72tUVg5KSkpKSkpKSkpKSkpKSkpKSkpKSkpKSknJ2zLX3z8A331FSUlJSUlJSUlJSUlJSUlJSUlJSUlJSUlKulJIkSZIkSZIkSZIkSZIkSZIkSZJ+uE84LSfmdDBcVgAAAABJRU5ErkJggg==",
          request_type: "PHARMA",
          orderNumber: "F25713115-LAB-1095",
          orderingDoctor: "Dr " + UserModel.first_name + +UserModel.last_name,
          organisationAdress: OrganisationModal.adresse,
          orderingDoctorPhone: UserModel.phone,
          orderingDoctorMail: UserModel.email,
          patientPhone: "",
          patientMail: "",
          patientName: patientModel.name + " " + patientModel.last_name,
          patientFirstName: patientModel.name,
          patientLastName: patientModel.last_name,
          patientID: patientModel.unique_id,
          patientDOB: patientModel.birthdate,
          patientAge: patientModel.age,
          patientGender: patientModel.sex,
          receivedDate: moment(PrescriptionsModal.createdAt).format(
            "DD/MM/YYYY HH:mm"
          ),
          receivedTime: "",
          collectedDate: moment(PrescriptionsModal.createdAt).format(
            "DD/MM/YYYY HH:mm"
          ),
          numPassport: "PCDFK334343KL",
          motif: null,
          collectedTime: "",
          reportedDate: moment(PrescriptionsModal.createdAt).format(
            "DD/MM/YYYY HH:mm"
          ),
          reportedTime: "",
          orderingOrganisationID: "",
          orderingOrganisationName: OrganisationModal.nom,
          clinicalNotes: PrescriptionsModal.advice,
          signature: {
            id: DoctorSignatureModal.id,
            doc_id: DoctorSignatureModal.doc_id,
            sign_name: DoctorSignatureModal.sign_name,
            pin: DoctorSignatureModal.pin,
            date_time: DoctorSignatureModal.date_time,
          },
          doctorSignature: ConvertToBase64(
            BASEPATH + DoctorSignatureModal.sign_name
          ),
          medicineList: PrescriptionsModal.medicin,
          remarks: PrescriptionsModal.advice,
        };
        return PreparedData;
        break;
      default:
        // show error response (details)
        console.log("Default State");
    }
  } catch (error) {
    throw error;
  }
}

function ConvertToBase64(imagePath) {
  // Check if the file exists
  if (fs.existsSync(imagePath)) {
    // Read the image file as a buffer
    const imageBuffer = fs.readFileSync(imagePath);

    // Convert the buffer to a base64 encoded string
    const base64String = imageBuffer.toString("base64");

    return base64String;
  } else {
    console.error(`File '${imagePath}' does not exist.`);
    return null; // or throw an error, return an empty string, etc. based on your requirement
  }
}

module.exports = {
  Docmosis,
  dataPrepare,
  ConvertToBase64,
};
