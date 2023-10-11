const { DataTypes } = require('sequelize');
const sequelize = require('../config').sequelize;

const LabReport = sequelize.define('LabReport', {
  id: {
    type: DataTypes.INTEGER,
    primaryKey: true,
    autoIncrement: true
  },
  payment: {
    type: DataTypes.STRING,
    allowNull: false
  },
  patient: {
    type: DataTypes.STRING,
    allowNull: false
  },
  details: {
    type: DataTypes.STRING,
    allowNull: false
  },
  lab_id: {
    type: DataTypes.STRING,
    allowNull: false
  },
  conclusion: {
    type: DataTypes.STRING,
    allowNull: false
  },
  sampling: {
    type: DataTypes.STRING,
    allowNull: false
  },
  sampling_date: {
    type: DataTypes.STRING,
    allowNull: false
  },
  id_organisation: {
    type: DataTypes.STRING,
    allowNull: false
  },
  qr_code: {
    type: DataTypes.STRING,
    allowNull: false
  },
  signature: {
    type: DataTypes.STRING,
    allowNull: false
  },
  transfer: {
    type: DataTypes.STRING,
    allowNull: false
  },
  user: {
    type: DataTypes.STRING,
    allowNull: false
  },
  report_code: {
    type: DataTypes.STRING,
    allowNull: false
  },
  doc_id: {
    type: DataTypes.STRING,
    allowNull: false
  },
  status: {
    type: DataTypes.STRING,
    allowNull: false
  },
  date_string: {
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
  tableName: 'lab_report',
  timestamps: false // Disable Sequelize's default timestamps
});

module.exports = LabReport;



