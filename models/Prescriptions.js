const { DataTypes } = require('sequelize');
const sequelize = require('../config').sequelize;

const Prescriptions = sequelize.define('Prescriptions', {
  id: {
    type: DataTypes.INTEGER,
    primaryKey: true,
    autoIncrement: true
  },
  patient_id: {
    type: DataTypes.INTEGER,
    allowNull: true
  },
  org_id: {
    type: DataTypes.INTEGER,
    allowNull: true,
  },
  advice: {
    type: DataTypes.STRING,
    allowNull: true
  },
  medicin: {
    type: DataTypes.JSON,
    allowNull: true
  },
  patient_name: {
    type: DataTypes.STRING,
    allowNull: true
  },
  patient_age: {
    type: DataTypes.STRING,
    allowNull: true
  },
  patient_dob: {
    type: DataTypes.STRING,
    allowNull: true
  },
  doctor_name: {
    type: DataTypes.STRING,
    allowNull: true
  },
  patient_gender: {
    type: DataTypes.STRING,
    allowNull: true
  },
  
  status: {
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
  tableName: 'prescriptions',
  timestamps: true // Disable Sequelize's default timestamps
});

module.exports = Prescriptions;



