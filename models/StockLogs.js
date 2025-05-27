const { sequelize } = require("../config");
const { DataTypes } = require('sequelize');
const Stock = require("./Stock");

const StockLogs=sequelize.define('StockLogs', {
    
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
      type: DataTypes.ENUM('INCREASE', 'DECREASE', 'MANUAL_ADJUSTMENT'),
      allowNull: false,
    },
    previous_stock_level: {
      type: DataTypes.INTEGER,
      allowNull: false,
    },
    adjustment_value: {
      type: DataTypes.INTEGER,
      allowNull: false,
    },
    new_stock_level: {
      type: DataTypes.INTEGER,
      allowNull: false,
    },
    reason: {
      type: DataTypes.TEXT,
      allowNull: false,
    },
      status: {
         type: DataTypes.STRING,
         allowNull: true
       },
       added_by: {
         type: DataTypes.STRING,
         allowNull: true
       },
       updated_by: {
         type: DataTypes.BOOLEAN,
         allowNull: true
       },  
       tableName: 'stock_logs',
       timestamps: true
})

module.exports = StockLogs;

    