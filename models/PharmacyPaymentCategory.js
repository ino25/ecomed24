const { DataTypes } = require('sequelize');
const sequelize = require('../config').sequelize;

const PharmacyPaymentCategory = sequelize.define('PharmacyPaymentCategory', {
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
  },
  c_price: {
    type: DataTypes.STRING,
    allowNull: false
  },
  d_commission: {
    type: DataTypes.STRING,
    allowNull: false
  },
  h_commission: {
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
  tableName: 'pharmacy_payment_category',
  timestamps: false // Disable Sequelize's default timestamps
});

module.exports = PharmacyPaymentCategory;


