const { DataTypes } = require("sequelize");
const sequelize = require("../config").sequelize;

const PrescribedMedicins = sequelize.define(
  "PrescribedMedicins",
  {
    id: {
      type: DataTypes.INTEGER,
      primaryKey: true,
      autoIncrement: true,
    },
    patient_id: {
      type: DataTypes.INTEGER,
      allowNull: true,
    },
    org_id: {
      type: DataTypes.INTEGER,
      allowNull: true,
    },
    prescription_id: {
      type: DataTypes.INTEGER,
      allowNull: true,
    },
    mdeicin_id: {
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
    advice: {
      type: DataTypes.STRING,
      allowNull: true,
    },
    dosage: {
      type: DataTypes.STRING,
      allowNull: true,
    },
    posology: {
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
    tableName: "prescribed_medicins",
    timestamps: true, // Disable Sequelize's default timestamps
  }
);

module.exports = PrescribedMedicins;
