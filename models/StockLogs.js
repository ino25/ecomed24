const { sequelize } = require("../config");
const { DataTypes } = require("sequelize");
const Stock = require("./Stock");

const StockLogs = sequelize.define(
  "StockLogs",
  {
    id: {
      type: DataTypes.INTEGER,
      primaryKey: true,
      autoIncrement: true,
    },
    stockId: {
      type: DataTypes.INTEGER,
      allowNull: false,
      references: {
        model: Stock,
        key: "id",
      },
      onUpdate: "CASCADE",
      onDelete: "CASCADE",
    },
    adjustment_type: {
      type: DataTypes.INTEGER, // 0 = decrement, 1 = Increment
      defaultValue: 0,
      allowNull: true,
    },
    previous_stock_level: {
      type: DataTypes.INTEGER,
      allowNull: true,
    },
    adjustment_value: {
      type: DataTypes.INTEGER,
      allowNull: true,
    },
    new_stock_level: {
      type: DataTypes.INTEGER,
      allowNull: true,
    },
    reason: {
      type: DataTypes.TEXT,
      allowNull: true,
    },
    // status: {
    //    type: DataTypes.STRING,
    //    allowNull: true
    //  },
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
    tableName: "stock_logs",
      timestamps: true,
  }
);
StockLogs.belongsTo(Stock, { foreignKey: "stockId", as: "stock" });

module.exports = StockLogs;
