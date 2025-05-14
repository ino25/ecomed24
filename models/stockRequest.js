const { DataTypes } = require("sequelize");
const sequelize = require("../config").sequelize;

const StockRequest = sequelize.define(
  "StockRequest",
  {
    id: {
      type: DataTypes.INTEGER,
      primaryKey: true,
      autoIncrement: true,
    },

    therapeuticClass: {
      type: DataTypes.STRING(45),
      allowNull: true,
    },
    dci: {
      type: DataTypes.STRING(45),
      allowNull: false,
      defaultValue: "Non Disponible",
    },
    commercialName: {
      type: DataTypes.STRING(45),
      allowNull: false,
      defaultValue: "Non Disponible",
    },
    dosage: {
      type: DataTypes.STRING(45),
      allowNull: true,
      defaultValue: "Non Disponible",
    },
    administrationRoute: {
      type: DataTypes.STRING(45),
      allowNull: true,
      defaultValue: "Non Disponible",
    },
    presentation: {
      type: DataTypes.STRING(45),
      allowNull: true,
      defaultValue: "Non Disponible",
    },
    galenicForm: {
      type: DataTypes.STRING(45),
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
      type: DataTypes.STRING(45),
      allowNull: true,
      defaultValue: "Non Disponible",
    },

    status: {
      type: DataTypes.INTEGER, // 0 = requested, 1 = accepted, 2 = rejected
      defaultValue: 0,
      allowNull: false,
      validate: {
        isIn: [[0, 1, 2]],
      },
    },

    drugScope: {
      type: DataTypes.ENUM("general", "IB"),
      allowNull: false,
      defaultValue: "general",
    },

   added_by: {
      type: DataTypes.INTEGER,
      allowNull: true,
    },
    updated_by: {
      type: DataTypes.INTEGER,
      allowNull: true,
    },
     is_deleted: {
      type: DataTypes.INTEGER,
      allowNull: false,
      defaultValue: 0,
    },
  },
  {
    tableName: "stock_requests",
    timestamps: true, // adds createdAt and updatedAt 
    paranoid: true,   // adds deletedAt (soft delete)
    deletedAt: 'deletedAt'
  }
);

module.exports = StockRequest;
