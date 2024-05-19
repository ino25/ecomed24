const { DataTypes } = require('sequelize');
const sequelize = require('../config').sequelize;
var Organisation = require("../models/Organisation");
var User = require("../models/User");


const PriceGrids = sequelize.define('PriceGrids', {
  gridID: {
    type: DataTypes.INTEGER,
    primaryKey: true,
    autoIncrement: true
  },
  organizationID: {
    type: DataTypes.STRING,
    allowNull: false
  },
  gridName: {
    type: DataTypes.STRING,
    allowNull: false,
    unique: true  // Ajoute une contrainte d'unicité pour le gridName
  },
  adjustmentType: {
    type: DataTypes.ENUM('increasePercent', 'decreasePercent', 'increaseAbsolute', 'decreaseAbsolute'),
    allowNull: false
  },
  adjustmentValue: {
    type: DataTypes.DECIMAL(10, 2),
    allowNull: true  // adjustmentValue peut être null
  },
  
  description: {
    type: DataTypes.TEXT,
    allowNull: true
  },
  effectiveDate: {
    type: DataTypes.DATEONLY,
    allowNull: true
  },
  expiryDate: {
    type: DataTypes.DATEONLY,
    allowNull: true
  },
  lastModifiedDate: {
    type: DataTypes.DATE,
    allowNull: true
  },
  lastModifiedBy: {
    type: DataTypes.STRING,
    allowNull: false
  },
  isActive: {
    type: DataTypes.BOOLEAN,
    defaultValue: true
  }
}, {
  tableName: 'priceGrids',
  timestamps: false
});

module.exports = PriceGrids;
