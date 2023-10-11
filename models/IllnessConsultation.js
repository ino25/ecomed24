const { DataTypes } = require('sequelize');
const sequelize = require('../config').sequelize;

const IllnessConsultation = sequelize.define('IllnessConsultation', {
  id: {
    type: DataTypes.INTEGER,
    primaryKey: true,
    autoIncrement: true
  },
  patient_id: {
    type: DataTypes.STRING,
    allowNull: true
  },
  illness_id: {
    type: DataTypes.STRING,
    allowNull: true
  },
  medical_history_id: {
    type: DataTypes.STRING,
    allowNull: true
  },
  user_id: {
    type: DataTypes.STRING,
    allowNull: true
  },
  createdDate: {
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
  tableName: 'illness_consultation',
  timestamps: false // Disable Sequelize's default timestamps
});

module.exports = IllnessConsultation;



