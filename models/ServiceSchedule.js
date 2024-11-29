const { DataTypes } = require('sequelize');
const sequelize = require('../config').sequelize;

const ServiceSchedule = sequelize.define('ServiceSchedule', {
  id: {
    type: DataTypes.INTEGER,
    primaryKey: true,
    autoIncrement: true
  },
  org_id: {
    type: DataTypes.STRING,
    allowNull: false
  },
  service_id: {
    type: DataTypes.STRING,
    allowNull: true
  },
  start_time: {
    type: DataTypes.STRING,
    allowNull: false
  },
  end_time: {
    type: DataTypes.STRING,
    allowNull: false
  },
  weekday: {
    type: DataTypes.STRING,
    allowNull: false
  },
  interval: {
    type: DataTypes.STRING,
    allowNull: false
  },
  status: {
    type: DataTypes.INTEGER,
    allowNull: false
  },
  
}, {
  tableName: 'service_schedules',
  timestamps: true // Disable Sequelize's default timestamps
});

module.exports = ServiceSchedule;


