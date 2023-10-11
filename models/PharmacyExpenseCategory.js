const { DataTypes } = require('sequelize');
const sequelize = require('../config').sequelize;

const PharmacyExpenseCategory = sequelize.define('PharmacyExpenseCategory', {
  id: {
    type: DataTypes.INTEGER,
    primaryKey: true,
    autoIncrement: true
  },
  category: {
    type: DataTypes.STRING,
    allowNull: false
  },
  description: {
    type: DataTypes.STRING,
    allowNull: false,
    unique: true
  },
  x: {
    type: DataTypes.STRING,
    allowNull: false
  },
  y: {
    type: DataTypes.STRING,
    allowNull: false
  },
  
  
  
  
//   created_at: {
//     type: DataTypes.DATE,
//     allowNull: false,
//     defaultValue: DataTypes.NOW
//   },
//   updated_at: {
//     type: DataTypes.DATE,
//     allowNull: false,
//     defaultValue: DataTypes.NOW
//   }
}, {
  tableName: 'pharmacy_expense_category',
  timestamps: false // Disable Sequelize's default timestamps
});

module.exports = PharmacyExpenseCategory;


