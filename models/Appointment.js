const { DataTypes } = require('sequelize');
const sequelize = require('../config').sequelize;

const Appointment = sequelize.define('Appointment', {
  id: {
    type: DataTypes.INTEGER,
    primaryKey: true,
    autoIncrement: true
  },
  code: {
    type: DataTypes.STRING,
    allowNull: true
  },
  patient: {
    type: DataTypes.STRING,
    allowNull: true
  },
  id_organisation: {
    type: DataTypes.STRING,
    allowNull: true
  },
  doctor: {
    type: DataTypes.STRING,
    allowNull: true
  },
  date: {
    type: DataTypes.STRING,
    allowNull: true
  },
  time_slot: {
    type: DataTypes.STRING,
    allowNull: true
  },
  s_time: {
    type: DataTypes.STRING,
    allowNull: true
  },
  e_time: {
    type: DataTypes.STRING,
    allowNull: true
  },
  remarks: {
    type: DataTypes.STRING,
    allowNull: true
  },
  add_date: {
    type: DataTypes.STRING,
    allowNull: true
  },
  registration_time: {
    type: DataTypes.STRING,
    allowNull: true
  },
  s_time_key: {
    type: DataTypes.STRING,
    allowNull: true
  },
  status: {
    type: DataTypes.STRING,
    allowNull: true
  },
  user: {
    type: DataTypes.STRING,
    allowNull: true
  },
  request: {
    type: DataTypes.STRING,
    allowNull: true
  },
  patientname: {
    type: DataTypes.STRING,
    allowNull: true
  },
  doctorname: {
    type: DataTypes.STRING,
    allowNull: true
  },
  service: {
    type: DataTypes.STRING,
    allowNull: true
  },
  servicename: {
    type: DataTypes.STRING,
    allowNull: true
  },
  room_id: {
    type: DataTypes.STRING,
    allowNull: true
  },
  live_meeting_link: {
    type: DataTypes.STRING,
    allowNull: true
  },
  appointment_date: {
    type: DataTypes.STRING,
    allowNull: true
  },
  tele_consultation: {
    type: DataTypes.TINYINT,
    allowNull: true
  },
  added_by: {
    type: DataTypes.INTEGER,
    allowNull: true
  },
  updated_by: {
    type: DataTypes.INTEGER,
    allowNull: true
  },
  
  
  
}, {
  tableName: 'appointment',
  timestamps: true // Disable Sequelize's default timestamps
});

module.exports = Appointment;



