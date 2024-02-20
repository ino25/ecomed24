const { DataTypes } = require('sequelize');
const sequelize = require('../config').sequelize;

const VitalSign = sequelize.define('VitalSign', {
  id: {
    type: DataTypes.INTEGER,
    primaryKey: true,
    autoIncrement: true
  },
  id_organisation: {
    type: DataTypes.STRING,
    allowNull: true
  },
  prescripteur: {
    type: DataTypes.STRING,
    allowNull: true
  },
  frequenceRespiratoire: {
    type: DataTypes.STRING,
    allowNull: true
  },
  frequenceCardiaque: {
    type: DataTypes.STRING,
    allowNull: true
  },
  saturationArterielle: {
    type: DataTypes.STRING,
    allowNull: true
  },
  temperature: {
    type: DataTypes.STRING,
    allowNull: true
  },
  systolique: {
    type: DataTypes.STRING,
    allowNull: true
  },
  diastolique: {
    type: DataTypes.STRING,
    allowNull: true
  },
  tensionArterielle: {
    type: DataTypes.STRING,
    allowNull: true
  },
  weight: {
    type: DataTypes.STRING,
    allowNull: true
  },
  blood_sugar: {
    type: DataTypes.STRING,
    allowNull: true
  },
  height: {
    type: DataTypes.STRING,
    allowNull: true
  },
  body_mass_index: {
    type: DataTypes.STRING,
    allowNull: true
  },
  ion_user_id: {
    type: DataTypes.STRING,
    allowNull: true
  },
  add_date: {
    type: DataTypes.STRING,
    allowNull: true
  },
  patient: {
    type: DataTypes.STRING,
    allowNull: true
  },
  patient_name: {
    type: DataTypes.STRING,
    allowNull: true
  },
  patient_address: {
    type: DataTypes.STRING,
    allowNull: true
  },
  patient_phone: {
    type: DataTypes.STRING,
    allowNull: true
  },
  date_string: {
    type: DataTypes.STRING,
    allowNull: true
  },
  date: {
    type: DataTypes.STRING,
    allowNull: true
  },
  clinical_id: {
    type: DataTypes.INTEGER,
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
  status: {
    type: DataTypes.INTEGER,
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
  tableName: 'vital_sign',
  timestamps: true // Disable Sequelize's default timestamps
});

module.exports = VitalSign;


