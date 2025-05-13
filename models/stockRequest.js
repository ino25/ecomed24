const { DataTypes } = require("sequelize");
const sequelize = require("../config").sequelize;
const Product = require("./Product");
const ProductCategory = require("./ProductCategory");

// Define the Drug model
const StockRequest = sequelize.define(
  "StockRequest",
  {
    id: {
      type: DataTypes.INTEGER,
      primaryKey: true,
      autoIncrement: true,
    },
    productId: {
      type: DataTypes.INTEGER,
      allowNull: true,
      references: {
        model: Product, // Reference the Product model
        key: "id",
      },
      onUpdate: "CASCADE",
      onDelete: "CASCADE",
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
      type: DataTypes.ENUM("accepted", "rejected", "requested"),
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
    tableName: "stock_request",
    timestamps: false,
    paranoid: true,
  }
);

// Establish associations
StockRequest.belongsTo(Product, { foreignKey: "productId", as: "product" });

module.exports = StockRequest;
