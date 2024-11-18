const { DataTypes } = require('sequelize');
const sequelize = require('../config').sequelize;

const Slot = sequelize.define('Slot', {
  id: {
    type: DataTypes.INTEGER,
    primaryKey: true,
    autoIncrement: true
  },
  org_id: {
    type: DataTypes.STRING,
    allowNull: false
  },
  doctor_id: {
    type: DataTypes.STRING,
    allowNull: false
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
  tableName: 'slots',
  timestamps: true // Disable Sequelize's default timestamps
});

module.exports = Slot;


