const { DataTypes } = require('sequelize');
const sequelize = require('../config').sequelize;

const ServiceRequest = sequelize.define('ServiceRequest', {
  requestID: {
    type: DataTypes.INTEGER,
    autoIncrement: true,
    primaryKey: true
  },
  patientID: {
    type: DataTypes.INTEGER,
    allowNull: false
  },
  organisationID: {
    type: DataTypes.INTEGER,
    allowNull: false
  },
  partenaireID: {
    type: DataTypes.INTEGER,
    allowNull: true
  },
  noteClinique: {
    type: DataTypes.TEXT, 
    allowNull: true
  },
  prescripteur: {
    type: DataTypes.STRING(255), 
    allowNull: true
  },
  status: {
    type: DataTypes.STRING(50),
    allowNull: false
  },
  lastModifiedBy: {
    type: DataTypes.DATE,
    allowNull: true
  },
  lastModifiedAt: {
    type: DataTypes.DATE,
    allowNull: true
  }
  
}, {
  tableName: 'servicerequest',
  timestamps: false // Disable Sequelize's default timestamps
});

module.exports = ServiceRequest;



