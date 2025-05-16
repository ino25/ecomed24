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
var StockRequest = require("../models/StockRequest");

//////Modal Relationship

StockRequest.belongsTo(User, { as: "addedby_details", foreignKey: "added_by" });
StockRequest.belongsTo(User, { as: "updatedby_details", foreignKey: "updated_by" });
StockRequest.belongsTo(Organisation, { as: "org_details", foreignKey: "org_id" });

// Role.hasMany(RolePermissionsMap, { as: "permissions", foreignKey: "role_id" });
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
    const { count, rows } = await StockRequest.findAndCountAll({
      where: { org_id: req.org_id },
    });
    RoleModal = await StockRequest.findAll({
      attributes: [
        "id",
        "org_id",
        "therapeuticClass",
        "dci",
        "commercialName",
        "dosage",
        "administrationRoute",
        "presentation",
        "galenicForm",
        "publicPrice",
        "referencePrice",
        "currency",
        "laboratory",
        "status",
        "added_by",
        "updated_by",
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
      order: [["id", "DESC"]],
      limit: datalimit,
      offset: offsetdata,
    });
    if (RoleModal.length == 0) {
      res.json({ status: 0, message: langCommon.nodatafound });
    } else {
      res.json({
        status: 1,
        message: langRoleModule.list,
        data: RoleModal,
        total: count,
      });
    }
  } catch (error) {
    throw error;
  }
};

exports.getMyList = async (req, res) => {
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
    const { count, rows } = await StockRequest.findAndCountAll({
      where: { org_id: req.org_id },
    });
    RoleModal = await StockRequest.findAll({
      attributes: [
        "id",
        "org_id",
        "therapeuticClass",
        "dci",
        "commercialName",
        "dosage",
        "administrationRoute",
        "presentation",
        "galenicForm",
        "publicPrice",
        "referencePrice",
        "currency",
        "laboratory",
        "status",
        "added_by",
        "updated_by",
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
      where: { org_id: req.org_id },
      order: [["id", "DESC"]],
      limit: datalimit,
      offset: offsetdata,
    });
    console.log(RoleModal);
    if (RoleModal.length == 0) {
      res.json({ status: 0, message: langCommon.nodatafound });
    } else {
      res.json({
        status: 1,
        message: langRoleModule.list,
        data: RoleModal,
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
    RoleModal = await StockRequest.findOne({
      attributes: [
        "id",
        "org_id",
        "therapeuticClass",
        "dci",
        "commercialName",
        "dosage",
        "administrationRoute",
        "presentation",
        "galenicForm",
        "publicPrice",
        "referencePrice",
        "currency",
        "laboratory",
        "status",
        "added_by",
        "updated_by",
        "added_by",
        "updated_by",
        [
          Sequelize.fn(
            "DATE_FORMAT",
            Sequelize.col("StockRequest.createdAt"),
            "%d/%m/%Y %H:%i"
          ),
          "createdAt",
        ],
        [
          Sequelize.fn(
            "DATE_FORMAT",
            Sequelize.col("StockRequest.updatedAt"),
            "%d/%m/%Y %H:%i"
          ),
          "updatedAt",
        ],
      ],
      where: { id: req.params.id },
      
    });
    if (RoleModal === null) {
      res.json({ status: 0, message: langCommon.nodatafound });
    } else {
      res.json({
        status: 1,
        message: langRoleModule.individual,
        data: RoleModal,
      });
    }
  } catch (error) {
    throw error;
  }
};
exports.add = async (req, res) => {
  try {
    const {
      therapeuticClass,
      dci,
      commercialName,
      dosage,
      administrationRoute,
      presentation,
      galenicForm,
      publicPrice,
      referencePrice,
      currency,
      laboratory,
      status,
      drugScope,
    } = req.body;
      StockRequestModal = await StockRequest.create({
                            therapeuticClass,
                            dci,
                            commercialName,
                            dosage,
                            administrationRoute,
                            presentation,
                            galenicForm,
                            publicPrice,
                            referencePrice,
                            currency,
                            laboratory,
                            drugScope,
                            org_id: req.org_id,
                            added_by: req.userId,
      });
    if (StockRequestModal === null) {
       res.json({ status: 0, message: langCommon.errormessage, data: "" });
    } else {
      res.json({ status: 1, message: langRoleModule.add, data: "" });
    }
  } catch (error) {
    throw error;
  }
};
exports.update = async (req, res) => {
  try {
    const {
      therapeuticClass,
      dci,
      commercialName,
      dosage,
      administrationRoute,
      presentation,
      galenicForm,
      publicPrice,
      referencePrice,
      currency,
      laboratory,
      drugScope,
    } = req.body;
    StockRequestModal = await StockRequest.update({
                          therapeuticClass,
                            dci,
                            commercialName,
                            dosage,
                            administrationRoute,
                            presentation,
                            galenicForm,
                            publicPrice,
                            referencePrice,
                            currency,
                            laboratory,
                            drugScope,
                            updated_by: req.userId,
                        },{
          where: { id: req.params.id },
        });
    if (StockRequestModal === null) {
      res.json({ status: 0, message: langCommon.errormessage });
    } else {
      
      res.json({ status: 1, message: langRoleModule.update, data: "" });
    }
  } catch (error) {
    throw error;
  }
};
exports.delete = async (req, res) => {
  try {
    StockRequestModal = await StockRequest.destroy({
      where: { id: req.params.id },
    });

    if (StockRequestModal === null) {
      res.json({ status: 0, message: langCommon.errormessage });
    } else {
      // RoleModal = await StockRequest.destroy({ where: { id: req.params.id } });
      res.json({
        status: 1,
        message: "Role Successfully deleted",
        data: "",
      });
    }
  } catch (error) {
    throw error;
  }
};
exports.status = async (req, res) => {
  try {
    RoleModal = await StockRequest.update(
      { status: req.body.status },
      { where: { id: req.params.id } }
    );
    if (RoleModal === null) {
      res.json({ status: 0, message: langCommon.errormessage });
    } else {
      res.json({
        status: 1,
        message: "status updated",
        data: "",
      });
    }
  } catch (error) {
    throw error;
  }
};
