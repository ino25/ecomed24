const { DataTypes } = require("sequelize");
const sequelize = require("../config").sequelize;

const Organisation = sequelize.define(
  "Organisation",
  {
    id: {
      type: DataTypes.INTEGER,
      primaryKey: true,
      autoIncrement: true,
    },
    code: {
      type: DataTypes.STRING,
      allowNull: true,
    },
    nom: {
      type: DataTypes.STRING,
      allowNull: false,
    },
    nom_commercial: {
      type: DataTypes.STRING,
      allowNull: true,
    },
    path_logo: {
      type: DataTypes.STRING,
      allowNull: true,
    },
    entete: {
      type: DataTypes.STRING,
      allowNull: true,
    },
    footer: {
      type: DataTypes.STRING,
      allowNull: true,
    },
    signature: {
      type: DataTypes.STRING,
      allowNull: true,
    },
    adresse: {
      type: DataTypes.STRING,
      allowNull: true,
    },
    region: {
      type: DataTypes.STRING,
      allowNull: true,
    },
    departement: {
      type: DataTypes.STRING,
      allowNull: true,
    },
    arrondissement: {
      type: DataTypes.STRING,
      allowNull: true,
    },
    collectivite: {
      type: DataTypes.STRING,
      allowNull: true,
    },
    pays: {
      type: DataTypes.STRING,
      allowNull: true,
    },
    email: {
      type: DataTypes.STRING,
      allowNull: true,
    },
    numero_fixe: {
      type: DataTypes.STRING,
      allowNull: true,
    },
    prenom_responsable_legal: {
      type: DataTypes.STRING,
      allowNull: true,
    },
    nom_responsable_legal: {
      type: DataTypes.STRING,
      allowNull: true,
    },
    portable_responsable_legal: {
      type: DataTypes.STRING,
      allowNull: true,
    },
    fonction_responsable_legal: {
      type: DataTypes.STRING,
      allowNull: true,
    },
    description_courte_responsable_legal: {
      type: DataTypes.STRING,
      allowNull: true,
    },
    prenom_responsable_legal2: {
      type: DataTypes.STRING,
      allowNull: true,
    },
    nom_responsable_legal2: {
      type: DataTypes.STRING,
      allowNull: true,
    },
    portable_responsable_legal2: {
      type: DataTypes.STRING,
      allowNull: true,
    },
    fonction_responsable_legal2: {
      type: DataTypes.STRING,
      allowNull: true,
    },
    description_courte_responsable_legal2: {
      type: DataTypes.STRING,
      allowNull: true,
    },
    id_partenaire_zuuluPay: {
      type: DataTypes.STRING,
      allowNull: true,
    },
    pin_partenaire_zuuluPay_encrypted: {
      type: DataTypes.STRING,
      allowNull: true,
    },
    type: {
      type: DataTypes.STRING,
      allowNull: true,
    },
    est_active: {
      type: DataTypes.STRING,
      allowNull: true,
    },
    date_creation: {
      type: DataTypes.DATE,  // Utiliser un type DATE au lieu de STRING
      allowNull: true,  // Autoriser NULL
      defaultValue: null, // Valeur par défaut NULL
    },           
    date_mise_a_jour: {
      type: DataTypes.STRING,
      allowNull: true,
    },
    description_courte_activite: {
      type: DataTypes.STRING,
      allowNull: true,
    },
    description_courte_services: {
      type: DataTypes.STRING,
      allowNull: true,
    },
    slogan: {
      type: DataTypes.STRING,
      allowNull: true,
    },
    horaires_ouverture: {
      type: DataTypes.STRING,
      allowNull: true,
    },
    is_transfert: {
      type: DataTypes.STRING,
      allowNull: true,
    },
    is_light: {
      type: DataTypes.STRING,
      allowNull: true,
    },
    is_whatsapp: {
      type: DataTypes.STRING,
      allowNull: true,
    },
    other_emails: {
      type: DataTypes.JSON,
      allowNull: true,
    },
    pricing_category: {
      type: DataTypes.STRING,
      allowNull: true,
    },
    status: {
      type: DataTypes.STRING,
      allowNull: false,
    },
    added_by: {
      type: DataTypes.INTEGER,
      allowNull: true,
    },
    updated_by: {
      type: DataTypes.INTEGER,
      allowNull: true,
    },
  },
  {
    tableName: "organisation",
    timestamps: true, // Disable Sequelize's default timestamps
  }
);

module.exports = Organisation;
