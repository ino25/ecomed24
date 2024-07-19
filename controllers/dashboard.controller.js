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

var User = require("../models/User");
var Role = require("../models/Role");
var Organisation = require("../models/Organisation");
var RolePermissionsMap = require("../models/RolePermissionsMap");

//////Modal Relationship

// Role.belongsTo(User, { as: "addedby_details", foreignKey: "added_by" });
// Role.belongsTo(User, { as: "updatedby_details", foreignKey: "updated_by" });
// Role.belongsTo(Organisation, { as: "org_details", foreignKey: "org_id" });

// Role.hasMany(RolePermissionsMap, { as: "permissions", foreignKey: "role_id" });

exports.getOverallData = async (req, res) => {
  try {
    let getOverallData = {
      total_patients: 0,
      total_new_patients: 0,
      total_appointments: 0,
      completed_appointments: 0,
      revenue: 0,
      outstanding_payments: 0,
    };

    if (getOverallData === null) {
      res.json({ status: 0, message: langCommon.nodatafound });
    } else {
      res.json({
        status: 1,
        message: langRoleModule.individual,
        data: getOverallData,
      });
    }
  } catch (error) {
    throw error;
  }
};

exports.getPatientDemographicData = async (req, res) => {
  try {
    let getOverallData = {
      age_bar_chart: 0,
      gender_pie: 0,
      district_bar: 0,
    };

    if (getOverallData === null) {
      res.json({ status: 0, message: langCommon.nodatafound });
    } else {
      res.json({
        status: 1,
        message: langRoleModule.individual,
        data: getOverallData,
      });
    }
  } catch (error) {
    throw error;
  }
};
