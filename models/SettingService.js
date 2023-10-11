const { DataTypes } = require('sequelize');
const sequelize = require('../config').sequelize;

const SettingService = sequelize.define('SettingService', {
  idservice: {
    type: DataTypes.INTEGER,
    primaryKey: true,
    autoIncrement: true
  },
  id_organisation: {
    type: DataTypes.STRING,
    allowNull: false
  },
  name_service: {
    type: DataTypes.STRING,
    allowNull: false
  },
  description_service: {
    type: DataTypes.STRING,
    allowNull: false
  },
  id_department: {
    type: DataTypes.STRING,
    allowNull: false
  },
  x: {
    type: DataTypes.STRING,
    allowNull: false
  },
  y: {
    type: DataTypes.STRING,
    allowNull: false
  },
  status_service: {
    type: DataTypes.STRING,
    allowNull: false
  },
  code_service: {
    type: DataTypes.STRING,
    allowNull: false
  },
  
  
//   created_at: {
//     type: DataTypes.DATE,
//     allowNull: false,
//     defaultValue: DataTypes.NOW
//   },
//   updated_at: {
//     type: DataTypes.DATE,
//     allowNull: false,
//     defaultValue: DataTypes.NOW
//   }
}, {
  tableName: 'setting_service',
  timestamps: false // Disable Sequelize's default timestamps
});

module.exports = SettingService;


