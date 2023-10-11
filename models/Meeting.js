const { DataTypes } = require('sequelize');
const sequelize = require('../config').sequelize;

const Meeting = sequelize.define('Meeting', {
  id: {
    type: DataTypes.INTEGER,
    primaryKey: true,
    autoIncrement: true
  },
  id_organisation: {
    type: DataTypes.STRING,
    allowNull: false
  },
  patient: {
    type: DataTypes.STRING,
    allowNull: false
  },
  doctor: {
    type: DataTypes.STRING,
    allowNull: false
  },
  topic: {
    type: DataTypes.STRING,
    allowNull: false
  },
  type: {
    type: DataTypes.STRING,
    allowNull: false
  },
  start_time: {
    type: DataTypes.STRING,
    allowNull: false
  },
  duration: {
    type: DataTypes.STRING,
    allowNull: false
  },
  timezone: {
    type: DataTypes.STRING,
    allowNull: false
  },
  meeting_id: {
    type: DataTypes.STRING,
    allowNull: false
  },
  meeting_password: {
    type: DataTypes.STRING,
    allowNull: false
  },
  date: {
    type: DataTypes.STRING,
    allowNull: false
  },
  time_slot: {
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
  remarks: {
    type: DataTypes.STRING,
    allowNull: false
  },
  add_date: {
    type: DataTypes.STRING,
    allowNull: false
  },
  registration_time: {
    type: DataTypes.STRING,
    allowNull: false
  },
  s_time_key: {
    type: DataTypes.STRING,
    allowNull: false
  },
  status: {
    type: DataTypes.STRING,
    allowNull: false
  },
  user: {
    type: DataTypes.STRING,
    allowNull: false
  },
  request: {
    type: DataTypes.STRING,
    allowNull: false
  },
  patientname: {
    type: DataTypes.STRING,
    allowNull: false
  },
  doctorname: {
    type: DataTypes.STRING,
    allowNull: false
  },
  ion_user_id: {
    type: DataTypes.STRING,
    allowNull: false
  },
  doctor_ion_id: {
    type: DataTypes.STRING,
    allowNull: false
  },
  patient_ion_id: {
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
  tableName: 'meeting',
  timestamps: false // Disable Sequelize's default timestamps
});

module.exports = Meeting;



