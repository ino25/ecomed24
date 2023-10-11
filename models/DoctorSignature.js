const { DataTypes } = require('sequelize');
const sequelize = require('../config').sequelize;

const DoctorSignature = sequelize.define('DoctorSignature', {
  id: {
    type: DataTypes.INTEGER,
    primaryKey: true,
    autoIncrement: true
  },
  doc_id: {
    type: DataTypes.STRING,
    allowNull: false
  },
  sign_name: {
    type: DataTypes.STRING,
    allowNull: false
  },
  pin: {
    type: DataTypes.STRING,
    allowNull: false
  },
  date_time: {
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
  tableName: 'doctor_signature',
  timestamps: false // Disable Sequelize's default timestamps
});

module.exports = DoctorSignature;



