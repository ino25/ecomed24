const { DataTypes } = require('sequelize');
const sequelize = require('../config').sequelize;

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
    allowNull: false
  },
  adjustmentType: {
    type: DataTypes.ENUM('increasePercent', 'decreasePercent', 'increaseAbsolute', 'decreaseAbsolute'),
    allowNull: false
  },
  adjustmentValue: {
    type: DataTypes.STRING,
    allowNull: true
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
