const i18n = require("i18n");
const langPermissionModule = i18n.__("Permissions");
const langCommon = i18n.__("common");
const Sequelize = require("sequelize");
const Database = require("../config").sequelize;
const Op = Sequelize.Op;
const moment = require("moment");
moment.locale("en");
const path = require("path");
const nodemailer = require("nodemailer");

var User = require("../models/User");
var Permission = require("../models/Permission");
var OrgPermissionItems = require("../models/OrgPermissionItems");
var OrganizationPermissions = require("../models/OrganizationPermissions");
var Module = require("../models/Module");
var Organisation = require("../models/Organisation");

//////Modal Relationship

Permission.belongsTo(User, { as: "addedby_details", foreignKey: "added_by" });
Permission.belongsTo(User, {
  as: "updatedby_details",
  foreignKey: "updated_by",
});

OrganizationPermissions.hasMany(OrgPermissionItems, {
  as: "permissions",
  foreignKey: "org_permissionid",
});
// Permission.belongsTo(Organisation, { as: "org_details", foreignKey: "org_id" });

// Permission
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
    const { count, rows } = await Permission.findAndCountAll({});
    PermissionModal = await Permission.findAll({
      attributes: [
        "id",
        "name",
        "description",
        "module_id",
        "status",
        "added_by",
        "updated_by",
        [
          Sequelize.fn(
            "DATE_FORMAT",
            Sequelize.col("Permission.createdAt"),
            "%d/%m/%Y %H:%i"
          ),
          "createdAt",
        ],
        [
          Sequelize.fn(
            "DATE_FORMAT",
            Sequelize.col("Permission.updatedAt"),
            "%d/%m/%Y %H:%i"
          ),
          "updatedAt",
        ],
      ],

      order: [["id", "DESC"]],
      limit: datalimit,
      offset: offsetdata,
    });
    if (PermissionModal === null) {
      res.json({ status: 0, message: langCommon.nodatafound });
    } else {
      res.json({
        status: 1,
        message: langPermissionModule.list,
        data: PermissionModal,
        total: count,
      });
    }
  } catch (error) {
    throw error;
  }
};
exports.getByID = async (req, res) => {
  try {
    PermissionModal = await Permission.findOne({
      attributes: [
        "id",
        "name",
        "description",
        "module_id",
        "status",
        "added_by",
        "updated_by",
        "added_by",
        "updated_by",
        [
          Sequelize.fn(
            "DATE_FORMAT",
            Sequelize.col("Permission.createdAt"),
            "%d/%m/%Y %H:%i"
          ),
          "createdAt",
        ],
        [
          Sequelize.fn(
            "DATE_FORMAT",
            Sequelize.col("Permission.updatedAt"),
            "%d/%m/%Y %H:%i"
          ),
          "updatedAt",
        ],
      ],
      where: { id: req.params.id },
    });
    if (PermissionModal === null) {
      res.json({ status: 0, message: langCommon.nodatafound });
    } else {
      res.json({
        status: 1,
        message: langPermissionModule.individual,
        data: PermissionModal,
      });
    }
  } catch (error) {
    throw error;
  }
};
exports.add = async (req, res) => {
  try {
    PermissionModal = await Permission.create({
      name: req.body.name,
      description: req.body.description,
      module_id: req.body.module_id,
      status: req.body.status,
      added_by: req.userId,
    });

    if (PermissionModal === null) {
      res.json({ status: 0, message: langCommon.errormessage });
    } else {
      res.json({ status: 1, message: langPermissionModule.add, data: "" });
    }
  } catch (error) {
    throw error;
  }
};
exports.update = async (req, res) => {
  try {
    PermissionModal = await Permission.update(
      {
        name: req.body.name,
        description: req.body.description,
        module_id: req.body.module_id,
        status: req.body.status,
        updated_by: req.userId,
      },
      {
        where: { id: req.params.id },
      }
    );

    if (PermissionModal === null) {
      res.json({ status: 0, message: langCommon.errormessage });
    } else {
      res.json({ status: 1, message: langPermissionModule.update, data: "" });
    }
  } catch (error) {
    throw error;
  }
};
exports.delete = async (req, res) => {
  try {
    PermissionModal = await Permission.destroy({
      where: { id: req.params.id },
    });
    if (PermissionModal === null) {
      res.json({ status: 0, message: langCommon.errormessage });
    } else {
      res.json({ status: 1, message: langPermissionModule.delete, data: "" });
    }
  } catch (error) {
    throw error;
  }
};
exports.status = async (req, res) => {
  try {
    PermissionModal = await Permission.update(
      { status: req.body.status },
      { where: { id: req.params.id } }
    );
    if (PermissionModal === null) {
      res.json({ status: 0, message: langCommon.errormessage });
    } else {
      res.json({ status: 1, message: langPermissionModule.status, data: "" });
    }
  } catch (error) {
    throw error;
  }
};

exports.getModulesList = async (req, res) => {
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
    const { count, rows } = await Module.findAndCountAll({});
    ModuleModal = await Module.findAll({
      attributes: [
        "id",
        "name",
        "description",
        "status",
        "added_by",
        "updated_by",

        [
          Sequelize.fn(
            "DATE_FORMAT",
            Sequelize.col("Module.createdAt"),
            "%d/%m/%Y %H:%i"
          ),
          "createdAt",
        ],
        [
          Sequelize.fn(
            "DATE_FORMAT",
            Sequelize.col("Module.updatedAt"),
            "%d/%m/%Y %H:%i"
          ),
          "updatedAt",
        ],
      ],

      order: [["id", "DESC"]],
      limit: datalimit,
      offset: offsetdata,
    });
    if (ModuleModal === null) {
      res.json({ status: 0, message: langCommon.nodatafound });
    } else {
      res.json({
        status: 1,
        message: langPermissionModule.list,
        data: ModuleModal,
        total: count,
      });
    }
  } catch (error) {
    throw error;
  }
};

//Organization Permission assignment

exports.AllowPermissionToOrg = async (req, res) => {
  try {
    CheckPermissionExists = await OrganizationPermissions.findOne({
      where: { org_id: req.body.org_id },
    });

    if (CheckPermissionExists === null) {
      // console.log(CheckPermissionExists);
      let Systempermissions = req.body.sp_id;

      OrganizationPermissionsModal = await OrganizationPermissions.create({
        org_id: req.body.org_id,
        start_date: req.body.start_date,
        end_date: req.body.end_date,
        status: req.body.status,
        added_by: req.userId,
      });

      if (OrganizationPermissionsModal === null) {
        res.json({ status: 0, message: langCommon.errormessage });
      } else {
        Systempermissions.forEach(async function (permissionid) {
          OrgPermissionItemsModal = await OrgPermissionItems.create({
            org_permissionid: OrganizationPermissionsModal.id,
            sp_id: permissionid,
            org_id: req.body.org_id,
            status: req.body.status,
            added_by: req.userId,
          });
        });
        res.json({
          status: 1,
          message: langPermissionModule.permissionassign,
          data: "",
        });
      }
    } else {
      res.json({
        status: 0,
        message: "Permissions Already assigned to this organization",
      });
    }
  } catch (error) {
    throw error;
  }
};

exports.getSystemPermissions = async (req, res) => {
  try {
    PermissionModal = await Permission.findAll({
      attributes: ["id", "name"],
      order: [["id", "DESC"]],
      where: { status: 1 },
    });
    if (PermissionModal === null) {
      res.json({ status: 0, message: langCommon.nodatafound });
    } else {
      res.json({
        status: 1,
        message: langPermissionModule.list,
        data: PermissionModal,
      });
    }
  } catch (error) {
    throw error;
  }
};

// list
exports.getOrgAssignedList = async (req, res) => {
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
    const { count, rows } = await OrganizationPermissions.findAndCountAll({});
    OrganizationPermissionsModal = await OrganizationPermissions.findAll({
      attributes: [
        "id",
        "org_id",
        "start_date",
        "end_date",
        "status",
        "added_by",
        "updated_by",
        "added_by",
        "updated_by",
        [
          Sequelize.fn(
            "DATE_FORMAT",
            Sequelize.col("OrganizationPermissions.createdAt"),
            "%d/%m/%Y %H:%i"
          ),
          "createdAt",
        ],
        [
          Sequelize.fn(
            "DATE_FORMAT",
            Sequelize.col("OrganizationPermissions.updatedAt"),
            "%d/%m/%Y %H:%i"
          ),
          "updatedAt",
        ],
      ],

      order: [["id", "DESC"]],
      limit: datalimit,
      offset: offsetdata,
    });
    if (OrganizationPermissionsModal === null) {
      res.json({ status: 0, message: langCommon.nodatafound });
    } else {
      res.json({
        status: 1,
        message: langPermissionModule.list,
        data: OrganizationPermissionsModal,
        total: count,
      });
    }
  } catch (error) {
    throw error;
  }
};

exports.getOrgPermissionByID = async (req, res) => {
  try {
    OrganizationPermissionsModal = await OrganizationPermissions.findOne({
      attributes: [
        "id",
        "org_id",
        "start_date",
        "end_date",
        "status",
        "added_by",
        "updated_by",
        "added_by",
        "updated_by",
        [
          Sequelize.fn(
            "DATE_FORMAT",
            Sequelize.col("OrganizationPermissions.createdAt"),
            "%d/%m/%Y %H:%i"
          ),
          "createdAt",
        ],
        [
          Sequelize.fn(
            "DATE_FORMAT",
            Sequelize.col("OrganizationPermissions.updatedAt"),
            "%d/%m/%Y %H:%i"
          ),
          "updatedAt",
        ],
      ],
      where: { id: req.params.id },
      include: [
        {
          model: OrgPermissionItems,
          attributes: ["id", "org_permissionid", "sp_id", "org_id", "status"],
          as: "permissions",
        },
      ],
    });
    if (OrganizationPermissionsModal === null) {
      res.json({ status: 0, message: langCommon.nodatafound });
    } else {
      res.json({
        status: 1,
        message: langPermissionModule.individual,
        data: OrganizationPermissionsModal,
      });
    }
  } catch (error) {
    throw error;
  }
};

exports.OrgPermissionUpdate = async (req, res) => {
  try {
    OrganizationPermissionsModal = await OrganizationPermissions.update(
      {
        // org_id: req.body.org_id,
        start_date: req.body.start_date,
        end_date: req.body.end_date,
        status: req.body.status,
        updated_by: req.userId,
      },
      {
        where: { id: req.params.id },
      }
    );

    if (OrganizationPermissionsModal === null) {
      res.json({ status: 0, message: langCommon.errormessage });
    } else {
      MapModal = await OrgPermissionItems.destroy({
        where: { org_permissionid: req.params.id },
      });
      Systempermissions = req.body.sp_id;
      Systempermissions.forEach(async function (permissionid) {
        OrgPermissionItemsModal = await OrgPermissionItems.create({
          org_permissionid: req.params.id,
          sp_id: permissionid,
          org_id: req.body.org_id,
          status: req.body.status,
          added_by: req.userId,
        });
      });
      res.json({ status: 1, message: langPermissionModule.update, data: "" });
    }
  } catch (error) {
    throw error;
  }
};
exports.OrgPermissionDelete = async (req, res) => {
  try {
    OrganizationPermissionsModal = await OrganizationPermissions.destroy({
      where: { id: req.params.id },
    });
    if (OrganizationPermissionsModal === null) {
      res.json({ status: 0, message: langCommon.errormessage });
    } else {
      MapModal = await OrgPermissionItems.destroy({
        where: { org_permissionid: req.params.id },
      });
      res.json({
        status: 1,
        message: "Organization Permission Deleted",
        data: "",
      });
    }
  } catch (error) {
    throw error;
  }
};
exports.OrgPermissionStatus = async (req, res) => {
  try {
    OrganizationPermissionsModal = await OrganizationPermissions.update(
      { status: req.body.status },
      { where: { id: req.params.id } }
    );
    if (OrganizationPermissionsModal === null) {
      res.json({ status: 0, message: langCommon.errormessage });
    } else {
      OrgPermissionItemsModal = await OrgPermissionItems.update(
        { status: req.body.status },
        { where: { org_permissionid: req.params.id } }
      );
      res.json({ status: 1, message: langPermissionModule.status, data: "" });
    }
  } catch (error) {
    throw error;
  }
};
