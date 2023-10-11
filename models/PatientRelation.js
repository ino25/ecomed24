const { DataTypes } = require('sequelize');
const sequelize = require('../config').sequelize;

const PatientRelation = sequelize.define('PatientRelation', {
  id: {
    type: DataTypes.INTEGER,
    primaryKey: true,
    autoIncrement: true
  },
  parent_id: {
    type: DataTypes.STRING,
    allowNull: true
  },
  relative_id: {
    type: DataTypes.STRING,
    allowNull: true,
  },
  relation_type: {
    type: DataTypes.STRING,
    allowNull: true
  },
  user_id: {
    type: DataTypes.STRING,
    allowNull: true
  },
  created_date: {
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

}, {
  tableName: 'patient_relation',
  timestamps: true // Disable Sequelize's default timestamps
});

module.exports = PatientRelation;


