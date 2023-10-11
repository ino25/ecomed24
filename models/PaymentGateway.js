const { DataTypes } = require('sequelize');
const sequelize = require('../config').sequelize;

const PaymentGateway = sequelize.define('PaymentGateway', {
  id: {
    type: DataTypes.INTEGER,
    primaryKey: true,
    autoIncrement: true
  },
  name: {
    type: DataTypes.STRING,
    allowNull: false
  },
  merchant_key: {
    type: DataTypes.STRING,
    allowNull: false,
    unique: true
  },
  salt: {
    type: DataTypes.STRING,
    allowNull: false
  },
  x: {
    type: DataTypes.STRING,
    allowNull: false
  },
  y: {
    type: DataTypes.STRING,
    allowNull: false
  },
  APIUsername: {
    type: DataTypes.STRING,
    allowNull: false
  },
  APIPassword: {
    type: DataTypes.STRING,
    allowNull: false
  },
  APISignature: {
    type: DataTypes.STRING,
    allowNull: false
  },
  status: {
    type: DataTypes.STRING,
    allowNull: false
  },
  publish: {
    type: DataTypes.STRING,
    allowNull: false
  },
  secret: {
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
  tableName: 'paymentgateway',
  timestamps: false // Disable Sequelize's default timestamps
});

module.exports = PaymentGateway;


