const { DataTypes } = require('sequelize');
const sequelize = require('../config').sequelize;


const ServiceRequest = require('../models/ServiceRequest');

const PaymentBis = sequelize.define('PaymentBis', {
  paymentID: {
    type: DataTypes.INTEGER,
    autoIncrement: true,
    primaryKey: true
  },
  serviceRequestID: {
    type: DataTypes.INTEGER,
    allowNull: false,
    references: {
      model: ServiceRequest, 
      key: 'requestID'
    }
  },
  amount: {
    type: DataTypes.FLOAT,
    allowNull: false
  },
  amountDue: {
    type: DataTypes.FLOAT,
    allowNull: true
  },
  date_created: {
    type: DataTypes.DATE,
    allowNull: false
  },
  walletType: {
    type: DataTypes.STRING(255), 
    allowNull: true
  },
  referenceTransaction: {
    type: DataTypes.STRING(255), 
    allowNull: true
  }
  
  
}, {
  tableName: 'paymentbis',
  timestamps: false // Disable Sequelize's default timestamps
});

module.exports = PaymentBis;



