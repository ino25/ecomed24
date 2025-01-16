const { DataTypes } = require("sequelize");
const sequelize = require("../config").sequelize;
const Product = require("../models/Product");

/**
 * ProductInstance model
 * Represents a specific instance of a product (e.g., a batch of drugs).
 * Includes batch details, expiration dates, and stock levels.
 */
const ProductInstance = sequelize.define(
  "ProductInstance",
  {
    id: {
      type: DataTypes.INTEGER,
      primaryKey: true,
      autoIncrement: true,
    },
    productId: {
      type: DataTypes.INTEGER,
      allowNull: false,
      references: {
        model: Product, // Reference to Product model
        key: "id",
      },
      onUpdate: "CASCADE",
      onDelete: "CASCADE",
    },
    batchNumber: {
      type: DataTypes.STRING,
      allowNull: false,
    },
    expirationDate: {
      type: DataTypes.DATE,
      allowNull: false,
    },
    stockLevel: {
      type: DataTypes.INTEGER,
      allowNull: false,
    },
  },
  {
    tableName: "product_instances",
    timestamps: true,
  }
);

module.exports = ProductInstance;
