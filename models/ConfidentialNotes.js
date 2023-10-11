const { DataTypes } = require('sequelize');
const sequelize = require('../config').sequelize;

const ConfidentialNotes = sequelize.define('ConfidentialNotes', {
  id: {
    type: DataTypes.INTEGER,
    primaryKey: true,
    autoIncrement: true
  },
  patient_id: {
    type: DataTypes.INTEGER,
    allowNull: false
  },
  note: {
    type: DataTypes.STRING,
    allowNull: false
  },
  doctor_id: {
    type: DataTypes.INTEGER,
    allowNull: true
  },
  status: {
    type: DataTypes.INTEGER,
    allowNull: false
  },
  added_by: {
    type: DataTypes.INTEGER,
    allowNull: true
  },
  updated_by: {
    type: DataTypes.STRING,
    allowNull: true
  },
  org_id: {
    type: DataTypes.STRING,
    allowNull: true
  },
}, {
  tableName: 'confidential_notes',
  timestamps: true // Disable Sequelize's default timestamps
});

module.exports = ConfidentialNotes;



