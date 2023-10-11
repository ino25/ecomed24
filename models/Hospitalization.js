const { DataTypes } = require('sequelize');
const sequelize = require('../config').sequelize;

const Hospitalization = sequelize.define('Hospitalization', {
  id: {
    type: DataTypes.INTEGER,
    primaryKey: true,
    autoIncrement: true
  },
  patient: {
    type: DataTypes.STRING,
    allowNull: false
  },
  lieu: {
    type: DataTypes.STRING,
    allowNull: false
  },
  add_date: {
    type: DataTypes.STRING,
    allowNull: false
  },
  doctor: {
    type: DataTypes.STRING,
    allowNull: false
  },
  date: {
    type: DataTypes.STRING,
    allowNull: false
  },
  nature: {
    type: DataTypes.STRING,
    allowNull: false
  },
  patient_name: {
    type: DataTypes.STRING,
    allowNull: false
  },
  patient_phone: {
    type: DataTypes.STRING,
    allowNull: false
  },
  patient_address: {
    type: DataTypes.STRING,
    allowNull: false
  },
  date_string: {
    type: DataTypes.STRING,
    allowNull: false
  },
  id_organisation: {
    type: DataTypes.STRING,
    allowNull: false
  },
  prescripteur: {
    type: DataTypes.STRING,
    allowNull: false
  },
  url: {
    type: DataTypes.STRING,
    allowNull: false
  },
  nomLabo: {
    type: DataTypes.STRING,
    allowNull: false
  },
  motif: {
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
  tableName: 'hospitalization',
  timestamps: false // Disable Sequelize's default timestamps
});

module.exports = Hospitalization;



