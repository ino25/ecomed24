const { DataTypes } = require("sequelize");
const sequelize = require("../config").sequelize; // Ensure the path to your sequelize config is correct

// Define the Drug model with refined configurations
const Drug = sequelize.define(
  "Drug",
  {
    id: {
      type: DataTypes.INTEGER,
      primaryKey: true,
      autoIncrement: true,
    },
    therapeuticClass: {
      type: DataTypes.STRING(50),
      allowNull: true,
    },
    dci: {
      type: DataTypes.STRING(50),
      allowNull: false,
      defaultValue: "Non Disponible",
    },
    commercialName: {
      type: DataTypes.STRING(50),
      allowNull: false,
      defaultValue: "Non Disponible",
    },
    dosage: {
      type: DataTypes.STRING(50),
      allowNull: true,
      defaultValue: "Non Disponible",
    },
    administrationRoute: {
      type: DataTypes.STRING(50),
      allowNull: true,
      defaultValue: "Non Disponible",
    },
    presentation: {
      type: DataTypes.STRING(50),
      allowNull: true,
      defaultValue: "Non Disponible",
    },
    galenicForm: {
      type: DataTypes.STRING(50),
      allowNull: true,
      defaultValue: "Non Disponible",
    },
    publicPrice: {
      type: DataTypes.FLOAT,
      allowNull: true,
    },
    referencePrice: {
      type: DataTypes.FLOAT,
      allowNull: true,
    },
    currency: {
      type: DataTypes.STRING,
      defaultValue: "FCFA",
      allowNull: false,
    },
    laboratory: {
      type: DataTypes.STRING(50),
      allowNull: true,
      defaultValue: "Non Disponible",
    },
    status: {
      type: DataTypes.ENUM("active", "inactive", "requested"),
      defaultValue: "requested",
      allowNull: false,
    },
    drugScope: {
      type: DataTypes.ENUM("general", "IB"),
      allowNull: false,
      defaultValue: "general",
    },
  },
  {
    tableName: "drug",
    timestamps: false,
    indexes: [
      {
        unique: true,
        fields: [
          "dci",
          "commercialName",
          "dosage",
          "administrationRoute",
          "presentation",
          "galenicForm",
          "laboratory",
        ],
        name: "unique_drug_combination",
      },
    ],
    hooks: {
      beforeUpdate: (drug) => {
        if (drug.modifiedAt) {
          drug.modifiedAt = new Date();
        }
      },
    },
  }
);

module.exports = Drug; // Ensure it is directly exported
