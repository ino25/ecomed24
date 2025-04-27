const { DataTypes } = require("sequelize");
const sequelize = require("../config").sequelize;

const Prelevement = sequelize.define(
  "Prelevement",
  {
    id_prelevement: {
      type: DataTypes.INTEGER,
      autoIncrement: true,
      primaryKey: true,
    },
    service_instance_id: {
      type: DataTypes.STRING,
      allowNull: false,
    },
    date_prelevement: {
      type: DataTypes.DATE,
      allowNull: false,
    },
    method_prelevement: {
      type: DataTypes.STRING,
      allowNull: false,
    },
    type_echantillon: {
      type: DataTypes.STRING,
      allowNull: false,
    },
    statut_prelevement: {
      type: DataTypes.ENUM("En attente", "En cours", "Terminé"),
      allowNull: false,
      defaultValue: "En attente",
    },
    resultat_disponible: {
      type: DataTypes.ENUM("Oui", "Non"),
      defaultValue: "Non",
    },
    commentaire: {
      type: DataTypes.TEXT,
      allowNull: true,
    },
  },
  {
    tableName: "prelevement",
    timestamps: true, // Disable Sequelize's default timestamps
  }
);

module.exports = Prelevement;
