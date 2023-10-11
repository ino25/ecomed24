const { DataTypes } = require('sequelize');
const sequelize = require('../config').sequelize;

const Visite = sequelize.define('Visite', {
  id: {
    type: DataTypes.INTEGER,
    primaryKey: true,
    autoIncrement: true
  },
  id_organisation: {
    type: DataTypes.STRING,
    allowNull: false
  },
  date: {
    type: DataTypes.STRING,
    allowNull: false
  },
  taille: {
    type: DataTypes.STRING,
    allowNull: false
  },
  poids: {
    type: DataTypes.STRING,
    allowNull: false
  },
  patient: {
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
  patient_last_name: {
    type: DataTypes.STRING,
    allowNull: false
  },
  patient_phone: {
    type: DataTypes.STRING,
    allowNull: false
  },
  patient_code: {
    type: DataTypes.STRING,
    allowNull: false
  },
  user: {
    type: DataTypes.STRING,
    allowNull: false
  },
  rdv: {
    type: DataTypes.STRING,
    allowNull: false
  },
  bu: {
    type: DataTypes.STRING,
    allowNull: false
  },
  dextro: {
    type: DataTypes.STRING,
    allowNull: false
  },
  patient_birthday: {
    type: DataTypes.STRING,
    allowNull: false
  },
  patient_sexe: {
    type: DataTypes.STRING,
    allowNull: false
  },
  patient_address: {
    type: DataTypes.STRING,
    allowNull: false
  },
  type: {
    type: DataTypes.STRING,
    allowNull: false
  },
  patient_id: {
    type: DataTypes.STRING,
    allowNull: false
  },
  pignet: {
    type: DataTypes.STRING,
    allowNull: false
  },
  tension_arterielle: {
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
  oeil_droit: {
    type: DataTypes.STRING,
    allowNull: false
  },
  oeil_gauche: {
    type: DataTypes.STRING,
    allowNull: false
  },
  oreille_droite: {
    type: DataTypes.STRING,
    allowNull: false
  },
  oreille_gauche: {
    type: DataTypes.STRING,
    allowNull: false
  },
  url: {
    type: DataTypes.STRING,
    allowNull: false
  },
  date_string: {
    type: DataTypes.STRING,
    allowNull: false
  },
  perimetre_thoracique: {
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
  droit10: {
    type: DataTypes.STRING,
    allowNull: false
  },
  gauche10: {
    type: DataTypes.STRING,
    allowNull: false
  },
  oreilledroite10: {
    type: DataTypes.STRING,
    allowNull: false
  },
  oeilgauche10: {
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
  tableName: 'visite',
  timestamps: false // Disable Sequelize's default timestamps
});

module.exports = Visite;


