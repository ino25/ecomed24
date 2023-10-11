const { DataTypes } = require('sequelize');
const sequelize = require('../config').sequelize;

const MedicalHistory = sequelize.define('MedicalHistory', {
  id: {
    type: DataTypes.INTEGER,
    primaryKey: true,
    autoIncrement: true
  },
  patient_id: {
    type: DataTypes.STRING,
    allowNull: false
  },
  id_organisation: {
    type: DataTypes.STRING,
    allowNull: false
  },
  title: {
    type: DataTypes.STRING,
    allowNull: false
  },
  description: {
    type: DataTypes.STRING,
    allowNull: false
  },
  patient_name: {
    type: DataTypes.STRING,
    allowNull: false
  },
  patient_address: {
    type: DataTypes.STRING,
    allowNull: false
  },
  patient_phone: {
    type: DataTypes.STRING,
    allowNull: false
  },
  img_url: {
    type: DataTypes.STRING,
    allowNull: false
  },
  date: {
    type: DataTypes.STRING,
    allowNull: false
  },
  registration_time: {
    type: DataTypes.STRING,
    allowNull: false
  },
  date_string: {
    type: DataTypes.STRING,
    allowNull: false
  },
  payment_id: {
    type: DataTypes.STRING,
    allowNull: false
  },
  prestation: {
    type: DataTypes.STRING,
    allowNull: false
  },
  code: {
    type: DataTypes.STRING,
    allowNull: false
  },
  user: {
    type: DataTypes.STRING,
    allowNull: false
  },
  patient_last_name: {
    type: DataTypes.STRING,
    allowNull: false
  },
  specialite: {
    type: DataTypes.STRING,
    allowNull: false
  },
  poids: {
    type: DataTypes.STRING,
    allowNull: false
  },
  taille: {
    type: DataTypes.STRING,
    allowNull: false
  },
  temperature: {
    type: DataTypes.STRING,
    allowNull: false
  },
  frequenceRespiratoire: {
    type: DataTypes.STRING,
    allowNull: false
  },
  frequenceCardiaque: {
    type: DataTypes.STRING,
    allowNull: false
  },
  glycemyCapillaire: {
    type: DataTypes.STRING,
    allowNull: false
  },
  Saturationarterielle: {
    type: DataTypes.STRING,
    allowNull: false
  },
  SaturationVeineux: {
    type: DataTypes.STRING,
    allowNull: false
  },
  systolique: {
    type: DataTypes.STRING,
    allowNull: false
  },
  diastolique: {
    type: DataTypes.STRING,
    allowNull: false
  },
  tensionArterielle: {
    type: DataTypes.STRING,
    allowNull: false
  },
  namePrestation: {
    type: DataTypes.STRING,
    allowNull: false
  },
  HypertensionSystolique: {
    type: DataTypes.STRING,
    allowNull: false
  },
  HypertensionDiastolique: {
    type: DataTypes.STRING,
    allowNull: false
  },
  sucre: {
    type: DataTypes.STRING,
    allowNull: false
  },
  albumine: {
    type: DataTypes.STRING,
    allowNull: false
  },
  oeildroit: {
    type: DataTypes.STRING,
    allowNull: false
  },
  oeilgauche: {
    type: DataTypes.STRING,
    allowNull: false
  },
  oreilledroite: {
    type: DataTypes.STRING,
    allowNull: false
  },
  oreillegauche: {
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
  tableName: 'medical_history',
  timestamps: false // Disable Sequelize's default timestamps
});

module.exports = MedicalHistory;



