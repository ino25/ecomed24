const { DataTypes } = require('sequelize');
const sequelize = require('../config').sequelize;

const TimeSlotService = sequelize.define('TimeSlotService', {
  id: {
    type: DataTypes.INTEGER,
    primaryKey: true,
    autoIncrement: true
  },
  service: {
    type: DataTypes.STRING,
    allowNull: false
  },
  s_time: {
    type: DataTypes.STRING,
    allowNull: false
  },
  e_time: {
    type: DataTypes.STRING,
    allowNull: false
  },
  weekday: {
    type: DataTypes.STRING,
    allowNull: false
  },
  s_time_key: {
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
  tableName: 'time_slot_service',
  timestamps: false // Disable Sequelize's default timestamps
});

module.exports = TimeSlotService;


