const { DataTypes } = require('sequelize');
const sequelize = require('../config').sequelize;

const DiagnosticReport = sequelize.define('DiagnosticReport', {
  id: {
    type: DataTypes.INTEGER,
    primaryKey: true,
    autoIncrement: true
  },
  date: {
    type: DataTypes.STRING,
    allowNull: false
  },
  invoice: {
    type: DataTypes.STRING,
    allowNull: false
  },
  report: {
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
  tableName: 'Diagnostic_report',
  timestamps: false // Disable Sequelize's default timestamps
});

module.exports = DiagnosticReport;



