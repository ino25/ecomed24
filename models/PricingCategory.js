const { DataTypes } = require('sequelize');
const sequelize = require('../config').sequelize;

const PricingCategory = sequelize.define('PricingCategory', {
  id: {
    type: DataTypes.INTEGER,
    primaryKey: true,
    autoIncrement: true
  },
  name: {
    type: DataTypes.STRING,
    allowNull: false
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
  tableName: 'pricing_category',
  timestamps: true // Disable Sequelize's default timestamps
});

module.exports = PricingCategory;



