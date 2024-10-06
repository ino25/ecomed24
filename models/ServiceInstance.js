const { DataTypes } = require('sequelize');
const sequelize = require('../config').sequelize;


const ServiceRequest = require('../models/ServiceRequest');

const ServiceInstance = sequelize.define('ServiceInstance', {
  instanceID: {
    type: DataTypes.INTEGER,
    autoIncrement: true,
    primaryKey: true
  },
  serviceID: {
    type: DataTypes.INTEGER,
    allowNull: false,
    references: {
      model: ServiceRequest, // Référence au modèle ServiceRequest
      key: 'requestID'
    }
  },
  organisationID: {
    type: DataTypes.INTEGER,
    allowNull: false
  },
  patientID: {
    type: DataTypes.INTEGER,
    allowNull: false
  },
  status: {
    type: DataTypes.STRING(50),
    allowNull: false
  },
  productID: {
    type: DataTypes.INTEGER,
    allowNull: false 
  },
  priceProduct: {
    type: DataTypes.DECIMAL(10, 2), 
    allowNull: false 
  },
  lastModifiedBy: {
    type: DataTypes.STRING(100)
  },
  lastModifiedAt: {
    type: DataTypes.DATE,
    allowNull: true
  }
  
}, {
  tableName: 'serviceinstance',
  timestamps: false // Disable Sequelize's default timestamps
});

module.exports = ServiceInstance;



