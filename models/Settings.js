const { DataTypes } = require('sequelize');
const sequelize = require('../config').sequelize;

const Settings = sequelize.define('Settings', {
  id: {
    type: DataTypes.INTEGER,
    primaryKey: true,
    autoIncrement: true
  },
  system_vendor: {
    type: DataTypes.STRING,
    allowNull: false
  },
  title: {
    type: DataTypes.STRING,
    allowNull: false
  },
  address: {
    type: DataTypes.STRING,
    allowNull: false
  },
  phone: {
    type: DataTypes.STRING,
    allowNull: false
  },
  email: {
    type: DataTypes.STRING,
    allowNull: false
  },
  facebook_id: {
    type: DataTypes.STRING,
    allowNull: false
  },
  currency: {
    type: DataTypes.STRING,
    allowNull: false
  },
  language: {
    type: DataTypes.STRING,
    allowNull: false
  },
  discount: {
    type: DataTypes.STRING,
    allowNull: false
  },
  vat: {
    type: DataTypes.STRING,
    allowNull: false
  },
  login_title: {
    type: DataTypes.STRING,
    allowNull: false
  },
  logo: {
    type: DataTypes.STRING,
    allowNull: false
  },
  invoice_logo: {
    type: DataTypes.STRING,
    allowNull: false
  },
  payment_gateway: {
    type: DataTypes.STRING,
    allowNull: false
  },
  sms_gateway: {
    type: DataTypes.STRING,
    allowNull: false
  },
  codec_username: {
    type: DataTypes.STRING,
    allowNull: false
  },
  codec_purchase_code: {
    type: DataTypes.STRING,
    allowNull: false
  },
  live_appointment_type: {
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
  tableName: 'settings',
  timestamps: false // Disable Sequelize's default timestamps
});

module.exports = Settings;


