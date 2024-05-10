const { DataTypes } = require('sequelize');
const sequelize = require('../config').sequelize;

const PriceGridDetails = sequelize.define('PriceGridDetails', {
  detailID: {
    type: DataTypes.INTEGER,
    primaryKey: true,
    autoIncrement: true
  },
  gridID: {
    type: DataTypes.STRING,
    allowNull: false
  },
  productID: {
    type: DataTypes.STRING,
    allowNull: false
  },
  adjustedPrice: {
    type: DataTypes.STRING,
    allowNull: false
  },
  adjustmentType: {
    type: DataTypes.ENUM('increasePercent', 'decreasePercent', 'increaseAbsolute', 'decreaseAbsolute'),
    allowNull: false
  },
  adjustmentValue: {
    type: DataTypes.STRING,
    allowNull: false
  },
  effectiveDate: {
    type: DataTypes.DATEONLY,
    allowNull: true
  },
  expiryDate: {
    type: DataTypes.DATEONLY,
    allowNull: true
  }
}, {
  tableName: 'pricegriddetails',
  timestamps: false // Assurez-vous d'ajuster cette option selon vos besoins, notamment si vous souhaitez inclure les champs createdAt et updatedAt automatiquement gérés par Sequelize.
});

module.exports = PriceGridDetails;
