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
    allowNull: true,
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
    allowNull: true
  },
  phone: {
    type: DataTypes.STRING, 
    allowNull: true
  },
  total: {
    type: DataTypes.FLOAT,
    allowNull: true
  },
  payment_method: {
    type: DataTypes.STRING,
    allowNull: false,
    defaultValue: 'Cash'
  },
  type: {
    type: DataTypes.STRING,
    allowNull: true,
    defaultValue: 0
  },
  status: {
    type: DataTypes.INTEGER,
    allowNull: true,
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
});

module.exports = PrescriptionSale;