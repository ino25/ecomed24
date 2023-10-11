const { DataTypes } = require('sequelize');
const sequelize = require('../config').sequelize;

const PreConditions = sequelize.define('PreConditions', {
  id: {
    type: DataTypes.INTEGER,
    primaryKey: true,
    autoIncrement: true
  },
  patient_id: {
    type: DataTypes.STRING,
    allowNull: true
  },
  content: {
    type: DataTypes.STRING,
    allowNull: true,
  },
  doctor_id: {
    type: DataTypes.STRING,
    allowNull: true
  },
  date_time: {
    type: DataTypes.STRING,
    allowNull: true
  },
  org_id: {
    type: DataTypes.STRING,
    allowNull: true
  },
  status: {
    type: DataTypes.STRING,
    allowNull: true
  },
  added_by: {
    type: DataTypes.STRING,
    allowNull: true
  },
  updated_by: {
    type: DataTypes.STRING,
    allowNull: true
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
  tableName: 'pre_conditions',
  timestamps: true // Disable Sequelize's default timestamps
});

module.exports = PreConditions;


