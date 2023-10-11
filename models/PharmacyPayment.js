const { DataTypes } = require('sequelize');
const sequelize = require('../config').sequelize;

const PharmacyPayment = sequelize.define('PharmacyPayment', {
  id: {
    type: DataTypes.INTEGER,
    primaryKey: true,
    autoIncrement: true
  },
  category: {
    type: DataTypes.STRING,
    allowNull: false
  },
  patient: {
    type: DataTypes.STRING,
    allowNull: false,
    unique: true
  },
  doctor: {
    type: DataTypes.STRING,
    allowNull: false
  },
  date: {
    type: DataTypes.STRING,
    allowNull: false
  },
  amount: {
    type: DataTypes.STRING,
    allowNull: false
  },
  vat: {
    type: DataTypes.STRING,
    allowNull: false
  },
  x_ray: {
    type: DataTypes.STRING,
    allowNull: false
  },
  flat_vat: {
    type: DataTypes.STRING,
    allowNull: false
  },
  discount: {
    type: DataTypes.STRING,
    allowNull: false
  },
  flat_discount: {
    type: DataTypes.STRING,
    allowNull: false
  },
  gross_total: {
    type: DataTypes.STRING,
    allowNull: false
  },
  hospital_amount: {
    type: DataTypes.STRING,
    allowNull: false
  },
  doctor_amount: {
    type: DataTypes.STRING,
    allowNull: false
  },
  category_amount: {
    type: DataTypes.STRING,
    allowNull: false
  },
  category_name: {
    type: DataTypes.STRING,
    allowNull: false
  },
  amount_received: {
    type: DataTypes.STRING,
    allowNull: false
  },
  status: {
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
  tableName: 'pharmacy_payment',
  timestamps: false // Disable Sequelize's default timestamps
});

module.exports = PharmacyPayment;


