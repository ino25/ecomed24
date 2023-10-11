const { DataTypes } = require('sequelize');
const sequelize = require('../config').sequelize;

const PatientHospitalization = sequelize.define('PatientHospitalization', {
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
  reason: {
    type: DataTypes.STRING,
    allowNull: true
  },
  current_disease: {
    type: DataTypes.STRING,
    allowNull: true
  },
  hospitalization_date: {
    type: DataTypes.STRING,
    allowNull: true
  },
  hospitalization_time: {
    type: DataTypes.STRING,
    allowNull: true
  },
  patient_name: {
    type: DataTypes.STRING,
    allowNull: true
  },
  patient_dob: {
    type: DataTypes.STRING,
    allowNull: true
  },
  patient_age: {
    type: DataTypes.STRING,
    allowNull: true
  },
  patient_gender: {
    type: DataTypes.STRING,
    allowNull: true
  },
  patient_phone: {
    type: DataTypes.STRING,
    allowNull: true
  },
  patient_address: {
    type: DataTypes.STRING,
    allowNull: true
  },
  marrital_status: {
    type: DataTypes.STRING,
    allowNull: true
  },
  status: {
    type: DataTypes.INTEGER,
    allowNull: false
  },
  
  added_by: {
    type: DataTypes.INTEGER,
    allowNull: true
  },
  updated_by: {
    type: DataTypes.INTEGER,
    allowNull: true
  },
  
  
}, {
  tableName: 'patient_hospitalization',
  timestamps: true // Disable Sequelize's default timestamps
});

module.exports = PatientHospitalization;



