const i18n = require("i18n");
const langRoleModule = i18n.__("Roles");
const langCommon = i18n.__("common");
const Sequelize = require("sequelize");
const Database = require("../config").sequelize;
const Op = Sequelize.Op;
const moment = require("moment");
moment.locale("en");
const path = require("path");
const nodemailer = require("nodemailer");
const langPatientModule = i18n.__("patientModule");
var User = require("../models/User");
var Appointment = require("../models/Appointment");
var Patient = require("../models/Patient");
var Organisation = require("../models/Organisation");
var PatientLogs = require("../models/PatientLogs");
//////Modal Relationship
const {appointmentAPI} = require("../helpers/AppointmentHelper");
// Appointment.belongsTo(User, { as: "addedby_details", foreignKey: "added_by" });
// Appointment.belongsTo(User, { as: "updatedby_details", foreignKey: "updated_by" });
// Appointment.belongsTo(Organisation, { as: "org_details", foreignKey: "org_id" });

// Appointments
exports.getList = async (req, res) => {
  try {
    let offsetdata = parseInt(
      req.query.offset
        ? req.query.offset == undefined || req.query.offset == 1
          ? 0
          : req.query.offset
        : 0
    );
    if (isNaN(offsetdata)) {
      offsetdata = 0;
    }
    let datalimit = parseInt(
      req.query.limit ? (req.query.limit == undefined ? 5 : req.query.limit) : 5
    );
    if (isNaN(datalimit)) {
      datalimit = 5;
    }
    const { count, rows } = await Appointment.findAndCountAll({
      where: { id_organisation: req.org_id },
    });
    let updatedCurrentDate;
    const type = req.query.type ? req.query.type : 'month';
    const direction = req.query.direction ? req.query.direction : null;
    let startDate, endDate;
    const currentDate = req.query.currentDate ? req.query.currentDate : moment().format('YYYY-MM-DD');
// Parse the current date
const baseDate = moment(currentDate, "YYYY-MM-DD");

// Determine range and new current date based on type and direction
switch (type) {
  case "month":
    if (direction === "next") {
      updatedCurrentDate = baseDate.clone().add(1, "month");
      startDate = updatedCurrentDate.clone().startOf("month").format('YYYY-MM-DD');
      endDate = updatedCurrentDate.clone().endOf("month").format('YYYY-MM-DD');
    } else if (direction === "previous") {
      updatedCurrentDate = baseDate.clone().subtract(1, "month");
      startDate = updatedCurrentDate.clone().startOf("month").format('YYYY-MM-DD');
      endDate = updatedCurrentDate.clone().endOf("month").format('YYYY-MM-DD');
    } else {
      updatedCurrentDate = baseDate.clone();
      startDate = updatedCurrentDate.clone().startOf("month").format('YYYY-MM-DD');
      endDate = updatedCurrentDate.clone().endOf("month").format('YYYY-MM-DD');
    }
    break;

  case "week":
    if (direction === "next") {
      updatedCurrentDate = baseDate.clone().add(1, "week");
      startDate = updatedCurrentDate.clone().startOf("week").format('YYYY-MM-DD');
      endDate = updatedCurrentDate.clone().endOf("week").format('YYYY-MM-DD');
    } else if (direction === "previous") {
      updatedCurrentDate = baseDate.clone().subtract(1, "week");
      startDate = updatedCurrentDate.clone().startOf("week").format('YYYY-MM-DD');
      endDate = updatedCurrentDate.clone().endOf("week").format('YYYY-MM-DD');
    } else {
      updatedCurrentDate = baseDate.clone();
      startDate = updatedCurrentDate.clone().startOf("week").format('YYYY-MM-DD');
      endDate = updatedCurrentDate.clone().endOf("week").format('YYYY-MM-DD');
    }
    break;

  case "day":
    if (direction === "next") {
      updatedCurrentDate = baseDate.clone().add(1, "day");
      startDate = updatedCurrentDate.clone().startOf("day").format('YYYY-MM-DD');
      endDate = updatedCurrentDate.clone().endOf("day").format('YYYY-MM-DD');
    } else if (direction === "previous") {
      updatedCurrentDate = baseDate.clone().subtract(1, "day");
      startDate = updatedCurrentDate.clone().startOf("day").format('YYYY-MM-DD');
      endDate = updatedCurrentDate.clone().endOf("day").format('YYYY-MM-DD');
    } else {
      updatedCurrentDate = baseDate.clone();
      startDate = updatedCurrentDate.clone().startOf("day").format('YYYY-MM-DD');
      endDate = updatedCurrentDate.clone().endOf("day").format('YYYY-MM-DD');
    }
    break;

  case "agenda":
    // Agenda covers only today's appointments
    updatedCurrentDate = baseDate.clone(); // Agenda does not shift the date
    startDate = updatedCurrentDate.clone().startOf("day").format('YYYY-MM-DD');
    endDate = updatedCurrentDate.clone().endOf("day").format('YYYY-MM-DD');
    break;

  default:
    // Fallback case to prevent errors
    updatedCurrentDate = baseDate.clone();
    startDate = updatedCurrentDate.clone().startOf("day").format('YYYY-MM-DD');
    endDate = updatedCurrentDate.clone().endOf("day").format('YYYY-MM-DD');
    break;
}
  console.log(updatedCurrentDate);
    // Add the date range to the where clause
    const whereClause = {
      id_organisation: req.org_id,
      appointment_date: {
        [Sequelize.Op.between]: [startDate, endDate],
      },
    };
    console.log(whereClause);
    const datafromapi = await appointmentAPI(`/list`,'get',data={});
    console.log(datafromapi);
    AppointmentModal = await Appointment.findAll({
      attributes: [
        "id",
        "id_organisation",
        "patientname",
        "date",
        "time_slot",
        "s_time",
        "e_time",
        "service",
        "servicename",
        "tele_consultation",
        "remarks",
        "status",
        "appointment_date",
        [
          Sequelize.fn(
            "DATE_FORMAT",
            Sequelize.col("Appointment.appointment_date"),
            "%d/%m/%Y"
          ),
          "appointment_date_formatted",
        ],
        "added_by",
        "updated_by",
        [
          Sequelize.fn(
            "DATE_FORMAT",
            Sequelize.col("createdAt"),
            "%d/%m/%Y %H:%i"
          ),
          "createdAt",
        ],
        [
          Sequelize.fn(
            "DATE_FORMAT",
            Sequelize.col("updatedAt"),
            "%d/%m/%Y %H:%i"
          ),
          "updatedAt",
        ],
      ],
      where: whereClause ,
      order: [["id", "DESC"]],
      limit: datalimit,
      offset: offsetdata,
    });
    const formattedData = AppointmentModal.map(appointment => ({
      id: appointment.id,
      title: appointment.servicename,
      appointment_date_formatted: appointment.appointment_date_formatted,
      start: moment(appointment.appointment_date +' '+ appointment.s_time).format('YYYY-MM-DD HH:mm'),
      end: moment(appointment.appointment_date + appointment.e_time).format('YYYY-MM-DD HH:mm'),
      doctor_id: appointment.doctor,
      patient_id: appointment.patient,
      id_organisation: appointment.id_organisation,
      patient_name: appointment.patientname,
      doctor_name: appointment.id,
      service_name: appointment.servicename,
      status: appointment.status,
    }));
    if (AppointmentModal === null) {
      res.json({ status: 0, message: langCommon.nodatafound });
    } else {
      res.json({
        status: 1,
        message: langPatientModule.appointment.list,
        data: formattedData,
        title: startDate +' - '+ endDate,
        currentDate: updatedCurrentDate.format("YYYY-MM-DD"),
        total: count,
      });
    }
  } catch (error) {
    throw error;
  }
};
exports.getByID = async (req, res) => {
  try {
    let getData = [];
    AppointmentModal = await Appointment.findOne({
      attributes: [
        "id",
        "date",
        [
          Sequelize.fn(
            "DATE_FORMAT",
            Sequelize.col("Appointment.appointment_date"),
            "%d/%m/%Y"
          ),
          "appointment_date",
        ],
        "time_slot",
        "service",
        "servicename",
        "tele_consultation",
        "remarks",
        "status",
      ],
      where: { id: req.params.appointment_id },
    });
    if (AppointmentModal === null) {
      res.json({ status: 0, message: langCommon.nodatafound });
    } else {
      res.json({
        status: 1,
        message: langPatientModule.appointment.individual,
        data: AppointmentModal,
      });
    }
  } catch (error) {
    throw error;
  }
};
exports.add = async (req, res) => {
  try {
    PatientModal = await Patient.findOne({ where: { id: req.body.uniqueID } });
    let room_id =
      "teleconsulation_ecomed24-" +
      PatientModal.phone +
      "-" +
      Math.floor(Math.random() * 444444 + 1000000);
    let live_meeting_link = "https://teleconsultation.ecomed24.com/" + room_id;
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
      add_date: moment().format("MM/DD/YYYY"),
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
      appointment_date: moment(req.body.date).format("YYYY-MM-DD"),
      tele_consultation: req.body.tele_consultation == 1 ? 1 : 0,
      added_by: req.userId,
    });

    if (AppointmentModal === null) {
      res.json({ status: 0, message: langCommon.errormessage });
    } else {
      const datafromapi = await appointmentAPI(`/add`,'post',data={
        "appointment_date":moment(req.body.date).format("YYYY-MM-DD"),
        "start_time":req.body.s_time,
        "end_time":req.body.e_time,
        "service_provider_id":1,
        "service_provider_name":"Dr Sagar Sharma",
        "service_provider_email":"sagar@sukritinfotech.com",
        "service_provider_phone":"9999999999",
        "service_id":req.body.service,
        "service_name":req.body.servicename,
        "client_id":req.body.uniqueID,
        "client_name":PatientModal.name,
        "client_email":"sagar@sukritinfotech.com",
        "client_phone":PatientModal.phone
    });
      await PatientLogs.create({
        patient_id: AppointmentModal.patient,
        org_id: req.org_id,
        description: "New Appointment has been generated.",
        type: "appointment",
        action: "add", 
        relation_id: AppointmentModal.id,
        status: 1,
        added_by: req.userId,
      });
      res.json({
        status: 1,
        message: langPatientModule.appointment.add,
        data: "",
      });
    }
  } catch (error) {
    throw error;
  }
};
exports.update = async (req, res) => {
  try {
    let getData = [],
      getProfile = [],
      file,
      results;
    console.log();
    // PatientModal = await Patient.findOne({where : {id:req.body.uniqueID}});

    AppointmentModal = await Appointment.update(
      {
        date: moment(req.body.date).unix(),
        time_slot: req.body.time_slot,
        s_time: req.body.s_time,
        e_time: req.body.e_time,
        remarks: req.body.remarks,
        s_time_key: req.body.s_time_key,
        status: req.body.status,
        service: req.body.service,
        servicename: req.body.servicename,
        appointment_date: moment(req.body.date).format("YYYY-MM-DD"),
        updated_by: req.userId,
        tele_consultation: req.body.tele_consultation == 1 ? 1 : 0,
      },
      {
        where: { id: req.params.id },
      }
    );

    if (AppointmentModal === null) {
      res.json({ status: 0, message: langCommon.errormessage });
    } else {
      AppointmentData = await Appointment.findOne({
        attributes: ["id", "patient"],
        where: { id: req.params.id },
      });
      console.log(AppointmentData);
      await PatientLogs.create({
        patient_id: AppointmentData.patient,
        org_id: req.org_id,
        description: "Appointment has been Updated.",
        type: "appointment",
        action: "update",
        relation_id: AppointmentData.id,
        status: 1,
        added_by: req.userId,
      });
      res.json({
        status: 1,
        message: langPatientModule.appointment.update,
        data: "",
      });
    }
  } catch (error) {
    throw error;
  }
};
exports.delete = async (req, res) => {
  try {
    AppointmentModal = await Appointment.destroy({
      where: { id: req.params.id },
    });
    if (AppointmentModal === null) {
      res.json({ status: 0, message: langCommon.errormessage });
    } else {
      res.json({
        status: 1,
        message: langPatientModule.appointment.delete,
        data: "",
      });
    }
  } catch (error) {
    throw error;
  }
};
exports.status = async (req, res) => {
  try {
    AppointmentData = await Appointment.findOne({
      attributes: ["id", "patient"],
      where: { id: req.params.id },
    });
    console.log(AppointmentData);
    AppointmentModal = await Appointment.update(
      { status: req.body.status },
      { where: { id: req.params.id } }
    );
    if (AppointmentModal === null) {
      res.json({ status: 0, message: langCommon.errormessage });
    } else {
      await PatientLogs.create({
        patient_id: AppointmentData.patient,
        org_id: req.org_id,
        description: "Appointment status has been Updated.",
        type: "appointment",
        action: "status",
        relation_id: AppointmentData.id,
        status: 1,
        added_by: req.userId,
      });
      res.json({
        status: 1,
        message: langPatientModule.appointment.status,
        data: "",
      });
    }
  } catch (error) {
    throw error;
  }
};
