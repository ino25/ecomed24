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

Role.belongsTo(User, { as: "addedby_details", foreignKey: "added_by" });
Role.belongsTo(User, { as: "updatedby_details", foreignKey: "updated_by" });
Role.belongsTo(Organisation, { as: "org_details", foreignKey: "org_id" });

Role.hasMany(RolePermissionsMap, { as: "permissions", foreignKey: "role_id" });
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
    const { count, rows } = await Role.findAndCountAll({
      where: { org_id: req.org_id },
    });
    RoleModal = await Role.findAll({
      attributes: [
        "id",
        "name",
        "org_id",
        "description",
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
    if (RoleModal === null) {
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
    RoleModal = await Role.findOne({
      attributes: [
        "id",
        "name",
        "description",
        "org_id",
        "status",
        "added_by",
        "updated_by",
        "added_by",
        "updated_by",
        [
          Sequelize.fn(
            "DATE_FORMAT",
            Sequelize.col("Role.createdAt"),
            "%d/%m/%Y %H:%i"
          ),
          "createdAt",
        ],
        [
          Sequelize.fn(
            "DATE_FORMAT",
            Sequelize.col("Role.updatedAt"),
            "%d/%m/%Y %H:%i"
          ),
          "updatedAt",
        ],
      ],
      where: { id: req.params.id },
      include: [
        {
          model: RolePermissionsMap,
          attributes: ["id", "role_id", "op_id", "org_id", "status"],
          as: "permissions",
        },
      ],
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
    let permissions = req.body.permissions;
    RoleModal = await Role.create({
      name: req.body.name,
      description: req.body.description,
      org_id: req.org_id,
      status: req.body.status,
      added_by: req.userId,
    });

    if (RoleModal === null) {
      res.json({ status: 0, message: langCommon.errormessage });
    } else {
      permissions.forEach(async function (permissionid) {
        RolePermissionsMapModal = await RolePermissionsMap.create({
          role_id: RoleModal.id,
          op_id: permissionid,
          org_id: req.org_id,
          status: req.body.status,
          added_by: req.userId,
        });
      });

      res.json({ status: 1, message: langRoleModule.add, data: "" });
    }
  } catch (error) {
    throw error;
  }
};
exports.update = async (req, res) => {
  try {
    let permissions = req.body.permissions;
    RoleModal = await Role.update(
      {
        name: req.body.name,
        description: req.body.description,
        status: req.body.status,
        updated_by: req.userId,
      },
      {
        where: { id: req.params.id },
      }
    );

    if (RoleModal === null) {
      res.json({ status: 0, message: langCommon.errormessage });
    } else {
      MapModal = await RolePermissionsMap.destroy({
        where: { role_id: req.params.id },
      });
      permissions.forEach(async function (permissionid) {
        RolePermissionsMapModal = await RolePermissionsMap.create({
          role_id: req.params.id,
          op_id: permissionid,
          org_id: req.org_id,
          status: req.body.status,
          added_by: req.userId,
        });
      });
      res.json({ status: 1, message: langRoleModule.update, data: "" });
    }
  } catch (error) {
    throw error;
  }
};
exports.delete = async (req, res) => {
  try {
    RoleModal = await RolePermissionsMap.destroy({
      where: { role_id: req.params.id },
    });
    RoleModal = await Role.destroy({ where: { id: req.params.id } });
    if (RoleModal === null) {
      res.json({ status: 0, message: langCommon.errormessage });
    } else {
      res.json({
        status: 1,
        message: langRoleModule.appointment.delete,
        data: "",
      });
    }
  } catch (error) {
    throw error;
  }
};
exports.status = async (req, res) => {
  try {
    RoleModal = await Role.update(
      { status: req.body.status },
      { where: { id: req.params.id } }
    );
    if (RoleModal === null) {
      res.json({ status: 0, message: langCommon.errormessage });
    } else {
      res.json({
        status: 1,
        message: langRoleModule.appointment.status,
        data: "",
      });
    }
  } catch (error) {
    throw error;
  }
};
