const { DataTypes } = require('sequelize');
const sequelize = require('../config').sequelize;

const PatientMutuelle = sequelize.define('PatientMutuelle', {
  idpm: {
    type: DataTypes.INTEGER,
    primaryKey: true,
    autoIncrement: true
  },
  pm_idpatent: {
    type: DataTypes.STRING,
    allowNull: true
  },
  id_organisation: {
    type: DataTypes.STRING,
    allowNull: true,
    unique: true
  },
  pm_idmutuelle: {
    type: DataTypes.STRING,
    allowNull: true
  },
  pm_numpolice: {
    type: DataTypes.STRING,
    allowNull: true
  },
  pm_datevalid: {
    type: DataTypes.STRING,
    allowNull: true
  },
  pm_charge: {
    type: DataTypes.STRING,
    allowNull: false
  },
  pm_status: {
    type: DataTypes.STRING,
    allowNull: false
  },
  validity_date: {
    type: DataTypes.INTEGER,
    allowNull: true
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
  tableName: 'patient_mutuelle',
  timestamps: true // Disable Sequelize's default timestamps
});

module.exports = PatientMutuelle;


