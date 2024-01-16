const { DataTypes } = require('sequelize');
const sequelize = require('../config').sequelize;

const Organisation = sequelize.define('Organisation', {
  id: {
    type: DataTypes.INTEGER,
    primaryKey: true,
    autoIncrement: true
  },
  code: {
    type: DataTypes.STRING,
    allowNull: false
  },
  nom: {
    type: DataTypes.STRING,
    allowNull: false
  },
  nom_commercial: {
    type: DataTypes.STRING,
    allowNull: false
  },
  path_logo: {
    type: DataTypes.STRING,
    allowNull: false
  },
  entete: {
    type: DataTypes.STRING,
    allowNull: false
  },
  footer: {
    type: DataTypes.STRING,
    allowNull: false
  },
  signature: {
    type: DataTypes.STRING,
    allowNull: false
  },
  adresse: {
    type: DataTypes.STRING,
    allowNull: false
  },
  region: {
    type: DataTypes.STRING,
    allowNull: false
  },
  departement: {
    type: DataTypes.STRING,
    allowNull: false
  },
  arrondissement: {
    type: DataTypes.STRING,
    allowNull: false
  },
  collectivite: {
    type: DataTypes.STRING,
    allowNull: false
  },
  pays: {
    type: DataTypes.STRING,
    allowNull: false
  },
  email: {
    type: DataTypes.STRING,
    allowNull: false
  },
  numero_fixe: {
    type: DataTypes.STRING,
    allowNull: false
  },
  prenom_responsable_legal: {
    type: DataTypes.STRING,
    allowNull: false
  },
  nom_responsable_legal: {
    type: DataTypes.STRING,
    allowNull: false
  },
  portable_responsable_legal: {
    type: DataTypes.STRING,
    allowNull: false
  },
  fonction_responsable_legal: {
    type: DataTypes.STRING,
    allowNull: false
  },
  description_courte_responsable_legal: {
    type: DataTypes.STRING,
    allowNull: false
  },
  prenom_responsable_legal2: {
    type: DataTypes.STRING,
    allowNull: false
  },
  nom_responsable_legal2: {
    type: DataTypes.STRING,
    allowNull: false
  },
  portable_responsable_legal2: {
    type: DataTypes.STRING,
    allowNull: false
  },
  fonction_responsable_legal2: {
    type: DataTypes.STRING,
    allowNull: false
  },
  description_courte_responsable_legal2: {
    type: DataTypes.STRING,
    allowNull: false
  },
  id_partenaire_zuuluPay: {
    type: DataTypes.STRING,
    allowNull: false
  },
  pin_partenaire_zuuluPay_encrypted: {
    type: DataTypes.STRING,
    allowNull: false
  },
  type: {
    type: DataTypes.STRING,
    allowNull: false
  },
  est_active: {
    type: DataTypes.STRING,
    allowNull: false
  },
  date_creation: {
    type: DataTypes.STRING,
    allowNull: false
  },
  date_mise_a_jour: {
    type: DataTypes.STRING,
    allowNull: false
  },
  description_courte_activite: {
    type: DataTypes.STRING,
    allowNull: false
  },
  description_courte_services: {
    type: DataTypes.STRING,
    allowNull: false
  },
  slogan: {
    type: DataTypes.STRING,
    allowNull: false
  },
  horaires_ouverture: {
    type: DataTypes.STRING,
    allowNull: false
  },
  is_transfert: {
    type: DataTypes.STRING,
    allowNull: false
  },
  is_light: {
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
  tableName: 'organisation',
  timestamps: false // Disable Sequelize's default timestamps
});

module.exports = Organisation;



