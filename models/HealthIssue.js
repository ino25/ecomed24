const { DataTypes } = require('sequelize');
const sequelize = require('../config').sequelize;

const HealthIssue = sequelize.define('HealthIssue', {
  id: {
    type: DataTypes.INTEGER,
    primaryKey: true,
    autoIncrement: true
  },
  name: {
    type: DataTypes.STRING,
    allowNull: false
  },
  type_id: {
    type: DataTypes.INTEGER,
    allowNull: false
  },
  status: {
    type: DataTypes.INTEGER,
    allowNull: false,
  },
  added_by: {
    type: DataTypes.INTEGER,
    allowNull: true,
  },
  updated_by: {
    type: DataTypes.INTEGER,
    allowNull: true,
  },

  

}, {
  tableName: 'health_issues',
  timestamps: true // Disable Sequelize's default timestamps
});

module.exports = HealthIssue;



