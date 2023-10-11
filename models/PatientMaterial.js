const { DataTypes } = require('sequelize');
const sequelize = require('../config').sequelize;

const PatientMaterial = sequelize.define('PatientMaterial', {
  id: {
    type: DataTypes.INTEGER,
    primaryKey: true,
    autoIncrement: true
  },
  id_organisation: {
    type: DataTypes.STRING,
    allowNull: true
  },
  date: {
    type: DataTypes.STRING,
    allowNull: true,
  },
  title: {
    type: DataTypes.STRING,
    allowNull: true
  },
  category: {
    type: DataTypes.STRING,
    allowNull: true
  },
  patient: {
    type: DataTypes.STRING,
    allowNull: true
  },
  patient_name: {
    type: DataTypes.STRING,
    allowNull: true
  },
  patient_address: {
    type: DataTypes.STRING,
    allowNull: true
  },
  patient_phone: {
    type: DataTypes.STRING,
    allowNull: true
  },
  url: {
    type: DataTypes.STRING,
    allowNull: true
  },
  date_string: {
    type: DataTypes.STRING,
    allowNull: true
  },
  added_by: {
    type: DataTypes.STRING,
    allowNull: true
  },
  updated_by: {
    type: DataTypes.STRING,
    allowNull: true
  },
  status: {
    type: DataTypes.STRING,
    allowNull: true
  },
  

}, {
  tableName: 'patient_material',
  timestamps: true // Disable Sequelize's default timestamps
});

module.exports = PatientMaterial;


