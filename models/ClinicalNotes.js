const { DataTypes } = require("sequelize");
const sequelize = require("../config").sequelize;

const ClinicalNotes = sequelize.define(
  "ClinicalNotes",
  {
    id: {
      type: DataTypes.INTEGER,
      primaryKey: true,
      autoIncrement: true,
    },
    patient_id: {
      type: DataTypes.INTEGER,
      allowNull: false,
    },
    org_id: {
      type: DataTypes.INTEGER,
      allowNull: false,
    },
    date_time: {
      type: DataTypes.STRING,
      allowNull: false,
    },
    channel: {
      type: DataTypes.INTEGER,
      allowNull: true,
    },
    motive: {
      type: DataTypes.STRING,
      allowNull: true,
    },
    known_health_issues: {
      type: DataTypes.STRING,
      allowNull: true,
    },
    consultation: {
      type: DataTypes.STRING,
      allowNull: true,
    },
    desease_history: {
      type: DataTypes.STRING,
      allowNull: true,
    },
    diagnostic: {
      type: DataTypes.STRING,
      allowNull: true,
    },
    treatment: {
      type: DataTypes.STRING,
      allowNull: true,
    },
    observation: {
      type: DataTypes.STRING,
      allowNull: true,
    },
    desease: {
      type: DataTypes.JSON,
      allowNull: true,
    },
    nosologie: {
      type: DataTypes.JSON,
      allowNull: true,
    },
    documents: {
      type: DataTypes.JSON,
      allowNull: true,
    },
    status: {
      type: DataTypes.STRING,
      allowNull: false,
    },
    added_by: {
      type: DataTypes.STRING,
      allowNull: false,
    },
    updated_by: {
      type: DataTypes.STRING,
      allowNull: true,
    },
  },
  {
    tableName: "clinical_notes",
    timestamps: true, // Disable Sequelize's default timestamps
  }
);

module.exports = ClinicalNotes;
