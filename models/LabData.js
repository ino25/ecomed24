const { DataTypes } = require('sequelize');
const sequelize = require('../config').sequelize;

const LabData = sequelize.define('LabData', {
  id: {
    type: DataTypes.INTEGER,
    primaryKey: true,
    autoIncrement: true
  },
  id_lab: {
    type: DataTypes.STRING,
    allowNull: false
  },
  idPaymentConcatRelevantCategoryPart: {
    type: DataTypes.STRING,
    allowNull: false
  },
  id_para: {
    type: DataTypes.STRING,
    allowNull: false
  },
  id_prestation: {
    type: DataTypes.STRING,
    allowNull: false
  },
  id_payment: {
    type: DataTypes.STRING,
    allowNull: false
  },
  resultats: {
    type: DataTypes.STRING,
    allowNull: false
  },
  status: {
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
  tableName: 'lab_data',
  timestamps: false // Disable Sequelize's default timestamps
});

module.exports = LabData;



