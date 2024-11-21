const i18n = require("i18n");
const langRoleModule = i18n.__("Roles");
const langSlotModule = i18n.__("Slots");
const langCommon = i18n.__("common");
const Sequelize = require("sequelize");
const Database = require("../config").sequelize;
const Op = Sequelize.Op;
const moment = require("moment");
moment.locale("en");
const path = require("path");
const nodemailer = require("nodemailer");

var User = require("../models/User");
var Role = require("../models/Role");
var Organisation = require("../models/Organisation");
var RolePermissionsMap = require("../models/RolePermissionsMap");
var Slot = require("../models/Slot");

//////Modal Relationship


// Roles
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
    const { count, rows } = await Slot.findAndCountAll({
      where: { org_id: req.org_id,doctor_id:req.userId },
    });
    SlotModal = await Slot.findAll({
      attributes: [
        "id",
        "doctor_id",
        "start_time",
        "end_time",
        "weekday",
        "interval",
        "status",
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
      where: { org_id: req.org_id,doctor_id:req.userId },
      order: [["id", "DESC"]],
      limit: datalimit,
      offset: offsetdata,
    });
    if (SlotModal === null) {
      res.json({ status: 0, message: langCommon.nodatafound });
    } else {
      res.json({
        status: 1,
        message: langSlotModule.list,
        data: SlotModal,
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
    SlotModal = await Slot.findOne({
      attributes: [
        "id",
        "doctor_id",
        "start_time",
        "end_time",
        "weekday",
        "interval",
        "status",
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
      where: { id: req.params.id }
    });
    if (SlotModal === null) {
      res.json({ status: 0, message: langCommon.nodatafound });
    } else {
      res.json({
        status: 1,
        message: langSlotModule.individual,
        data: SlotModal,
      });
    }
  } catch (error) {
    throw error;
  }
};
exports.add = async (req, res) => {
  try {
    let doctor_id = req.body.doctor_id ? req.body.doctor_id : req.userId;

    SlotModalExists = await Slot.findOne({
      where: { doctor_id: doctor_id,weekday: req.body.weekday,start_time: req.body.start_time,end_time: req.body.end_time, org_id: req.org_id },
    });
    if (SlotModalExists === null) {
      
      SlotModal = await Slot.create({
        org_id: req.org_id,
        doctor_id: doctor_id,
        start_time: req.body.start_time,
        end_time: req.body.end_time,
        weekday: req.body.weekday,
        interval: req.body.interval,
        status: 1,
      });

      if (SlotModal === null) {
        res.json({ status: 0, message: langCommon.errormessage });
      } else {
        res.json({ status: 1, message: langSlotModule.add, data: "" });
      }
    } else {
      res.json({ status: 0, message: "Slot Already Exists with same time frame" });
    }
  } catch (error) {
    throw error;
  }
};
exports.update = async (req, res) => {
  try {
    RoleModal = await Slot.update(
      {
        start_time: req.body.start_time,
        end_time: req.body.end_time,
        weekday: req.body.weekday,
        interval: req.body.interval,
      },
      {
        where: { id: req.params.id },
      }
    );

    if (RoleModal === null) {
      res.json({ status: 0, message: langCommon.errormessage });
    } else {
     

      res.json({ status: 1, message: langSlotModule.update, data: "" });
    }
  } catch (error) {
    throw error;
  }
};
exports.delete = async (req, res) => {
  try {
    RoleModal = await Slot.destroy({
      where: { role_id: req.params.id },
    });

    if (RoleModal === null) {
      res.json({ status: 0, message: langCommon.errormessage });
    } else {
      RoleModal = await Role.destroy({ where: { id: req.params.id } });
      res.json({
        status: 1,
        message: langSlotModule.deleted,
        data: "",
      });
    }
  } catch (error) {
    throw error;
  }
};
exports.status = async (req, res) => {
  try {
    SlotModal = await Slot.update(
      { status: req.body.status },
      { where: { id: req.params.id } }
    );
    if (SlotModal === null) {
      res.json({ status: 0, message: langCommon.errormessage });
    } else {
      
      res.json({
        status: 1,
        message: langSlotModule.status,
        data: "",
      });
    }
  } catch (error) {
    throw error;
  }
};
