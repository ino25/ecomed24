const { DataTypes } = require("sequelize");
const sequelize = require("../config").sequelize;

const ClinicalDesease = sequelize.define(
  "ClinicalDesease",
  {
    id: {
      type: DataTypes.INTEGER,
      primaryKey: true,
      autoIncrement: true,
    },
    clinical_id: {
      type: DataTypes.INTEGER,
      allowNull: true,
    },
    org_id: {
      type: DataTypes.INTEGER,
      allowNull: true,
    },
    patient_id: {
      type: DataTypes.INTEGER,
      allowNull: true,
    },
    disease_id: {
      type: DataTypes.INTEGER,
      allowNull: true,
    },
    name: {
      type: DataTypes.STRING,
      allowNull: false,
    },
    type: {
      type: DataTypes.STRING,
      allowNull: true,
    },

    status: {
      type: DataTypes.INTEGER,
      allowNull: true,
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
    tableName: "clinical_desease",
    timestamps: true, // Disable Sequelize's default timestamps
  }
);

module.exports = ClinicalDesease;
