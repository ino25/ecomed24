const { DataTypes } = require('sequelize');
const sequelize = require('../config').sequelize;

const PatientLogs = sequelize.define('PatientLogs', {
  id: {
    type: DataTypes.INTEGER,
    primaryKey: true,
    autoIncrement: true
  },
  patient_id: {
    type: DataTypes.INTEGER,
    allowNull: false
  },
  org_id: {
    type: DataTypes.INTEGER,
    allowNull: false,
  },
  description: {
    type: DataTypes.STRING,
    allowNull: true
  },
  type: {
    type: DataTypes.STRING,
    allowNull: true
  },
  action: {
    type: DataTypes.STRING,
    allowNull: true
  },
  relation_id: {
    type: DataTypes.INTEGER,
    allowNull: true
  },
  status: {
    type: DataTypes.STRING,
    allowNull: true
  },
  added_by: {
    type: DataTypes.STRING,
    allowNull: true
  },
  updated_by: {
    type: DataTypes.BOOLEAN,
    allowNull: true
  },
  
  
}, {
  tableName: 'patient_logs',
  timestamps: true // Disable Sequelize's default timestamps
});

module.exports = PatientLogs;



