const { DataTypes } = require("sequelize");
const sequelize = require("../config").sequelize; // Ensure this path is correct

const Inventory = sequelize.define(
  "Inventory",
  {
    id: {
      type: DataTypes.BIGINT, // Use BIGINT if referencing BIGINT columns in foreign tables
      primaryKey: true,
      autoIncrement: true,
    },
    tenantId: {
      type: DataTypes.BIGINT, // Use BIGINT to match the 'id' column of the 'organisation' table
      allowNull: false,
      references: {
        model: "organisation", // Ensure that the reference matches the exact table name in the DB
        key: "id",
      },
      onUpdate: "CASCADE",
      onDelete: "CASCADE",
    },
    createdAt: {
      type: DataTypes.DATE,
      defaultValue: DataTypes.NOW,
      allowNull: false,
    },
    updatedAt: {
      type: DataTypes.DATE,
      defaultValue: DataTypes.NOW,
      allowNull: false,
    },
  },
  {
    tableName: "inventories", // Ensures the correct table name
    timestamps: true, // Enable Sequelize's default timestamps
  }
);

module.exports = Inventory;
