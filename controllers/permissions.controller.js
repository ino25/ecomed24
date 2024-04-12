const i18n = require('i18n');
const langPermissionModule = i18n.__('Permissions');
const langCommon = i18n.__('common');
const Sequelize = require('sequelize');
const Database = require('../config').sequelize;
const Op = Sequelize.Op;
const moment = require("moment");
moment.locale('en');
const path = require('path');
const nodemailer = require("nodemailer");

var User = require('../models/User');
var Permission = require('../models/Permission');
var OrgPermission = require('../models/OrgPermission');
var Organisation = require('../models/Organisation');

//////Modal Relationship

Permission.belongsTo(User, {as: 'addedby_details',foreignKey: 'added_by'});
Permission.belongsTo(User, {as: 'updatedby_details',foreignKey: 'updated_by'});
Permission.belongsTo(Organisation, {as: 'org_details',foreignKey: 'org_id'});



// Permission
exports.getList = async (req, res) => {
  try {
    let offsetdata = parseInt(req.query.offset ? ((req.query.offset == undefined || req.query.offset == 1) ? 0 :req.query.offset) : 0);
    if(isNaN(offsetdata)){
        offsetdata = 0;
    }
    let datalimit = parseInt(req.query.limit ? ((req.query.limit == undefined) ? 5 :req.query.limit) : 5);
    if(isNaN(datalimit)){
        datalimit = 5;
    }
    const { count, rows } = await Permission.findAndCountAll({where: { org_id: req.org_id }});
    PermissionModal = await Permission.findAll({attributes: ['id', 'name','type','status', 'added_by','updated_by','added_by','updated_by',[Sequelize.fn("DATE_FORMAT", Sequelize.col("createdAt"),"%d/%m/%Y %H:%i"),"createdAt"],[Sequelize.fn("DATE_FORMAT", Sequelize.col("updatedAt"),"%d/%m/%Y %H:%i"),"updatedAt"]], 
                                                    where: { patient: req.org_id },
                                                    order: [['id', 'DESC']],
                                                    limit: datalimit,
                                                    offset: offsetdata
                                                });
      if(PermissionModal === null){
          res.json({ status: 0, message: langCommon.nodatafound });
      }else{
          res.json({ status: 1, message: langPermissionModule.list, data: PermissionModal,total:count });
      }
      
  } catch (error) {
      throw error;
  }
};
exports.getByID = async (req, res) => {
  try {
    PermissionModal = await Permission.findOne({attributes: ['id', 'name','type','status', 'added_by','updated_by','added_by','updated_by',[Sequelize.fn("DATE_FORMAT", Sequelize.col("createdAt"),"%d/%m/%Y %H:%i"),"createdAt"],[Sequelize.fn("DATE_FORMAT", Sequelize.col("updatedAt"),"%d/%m/%Y %H:%i"),"updatedAt"]], where: { id: req.params.appointment_id } });
    if(PermissionModal === null){
        res.json({ status: 0, message: langCommon.nodatafound });
    }else{
        res.json({ status: 1, message: langPermissionModule.individual, data: PermissionModal });
    }
    
  } catch (error) {
      throw error;
  }
};
exports.add = async (req, res) => {
  try {
    PermissionModal = await Permission.create({ 
            name: req.body.name,
            type: req.body.type,
            status: req.body.status,
            added_by: req.userId,
    });
    
    if(PermissionModal === null){
        res.json({ status: 0, message: langCommon.errormessage });
    }else{
        res.json({ status: 1, message: langPermissionModule.add, data: '' });
    }
    
  } catch (error) {
      throw error;
  }
};
exports.update = async (req, res) => {
  try {
    
    PermissionModal = await Permission.update({ 
            name: req.body.name,
            type: req.body.type,
            status: req.body.status,
            updated_by: req.userId
    }, {
        where: {id: req.params.id}
    });
    
    if(PermissionModal === null){
        res.json({ status: 0, message: langCommon.errormessage });
    }else{
        
        res.json({ status: 1, message: langPermissionModule.update, data: '' });
    }
    
  } catch (error) {
      throw error;
  }
};
exports.delete = async (req, res) => {
  try {
    PermissionModal = await Permission.destroy({where: {id: req.params.id}});
    if(PermissionModal === null){
        res.json({ status: 0, message: langCommon.errormessage });
    }else{
        res.json({ status: 1, message: langPermissionModule.delete, data: '' });
    }
  } catch (error) {
  throw error;
  }
};
exports.status = async (req, res) => {
  try {
    
    PermissionModal = await Permission.update({status: req.body.status}, {where: {id: req.params.id}});
    if(PermissionModal === null){
        res.json({ status: 0, message: langCommon.errormessage });
    }else{
        res.json({ status: 1, message: langPermissionModule.status, data: '' });
    }
    
} catch (error) {
    throw error;
}
};


exports.AllowPermissionToOrg = async (req, res) => {
    try {

        let Systempermissions=req.body.sp_id;
        Systempermissions.forEach(async function(permissionid) {
                        OrgPermissionModal = await OrgPermission.create({ 
                                sp_id: permissionid,
                                org_id: req.body.org_id,
                                start_date: req.body.start_date,
                                end_date: req.body.end_date,
                                status: req.body.status,
                                added_by: req.userId,
                        });
        });
    //   if(OrgPermissionModal === null){
    //       res.json({ status: 0, message: langCommon.errormessage });
    //   }else{
          res.json({ status: 1, message: langPermissionModule.permissionassign, data: '' });
    //   }
      
    } catch (error) {
        throw error;
    }
};






  