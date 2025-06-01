const { DataTypes } = require('sequelize');
const { sequelize } = require("../config");
const Prescriptions = require('./Prescriptions'); 

const PrescriptionSale = sequelize.define('PrescriptionSale', {
  id: {
    type: DataTypes.INTEGER,
    primaryKey: true,
    autoIncrement: true
  },
  prescription_id: {
    type: DataTypes.INTEGER,
    allowNull: false,
    references: {
      model: Prescriptions,
      key: "id",
    },
    onUpdate: "CASCADE",
    onDelete: "CASCADE",
  },
  patient_id: {
    type: DataTypes.INTEGER,
    allowNull: true,
  },
  name: {
    type: DataTypes.STRING,
    allowNull: false
  },
  phone: {
    type: DataTypes.STRING, // Changed from INTEGER to STRING for phone numbers
    allowNull: true
  },
  total: {
    type: DataTypes.FLOAT,
    allowNull: false
  },
  payment_method: {
    type: DataTypes.STRING,
    allowNull: false,
    defaultValue: 'Cash'
  },
  type: {
    type: DataTypes.STRING,
    allowNull: false,
    defaultValue: 'walk-in' // Changed from DataTypes.NOW to a proper string default
  },
  status: {
    type: DataTypes.INTEGER,
    allowNull: false,
    defaultValue: 1
  },
  added_by: {
    type: DataTypes.INTEGER,
    allowNull: true,
  },
  updated_by: {
    type: DataTypes.INTEGER,
    allowNull: true,
  },
}, {
  tableName: 'prescription_sales',
  timestamps: true, // adds createdAt and updatedAt 
   // paranoid: true,
});

module.exports = PrescriptionSale;