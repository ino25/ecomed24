const { DataTypes } = require("sequelize");
const sequelize = require("../config").sequelize;
const Drug = require("./Drug");

const Stock = sequelize.define(
  "Stock",
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
        model: Drug,
        key: "id",
      },
      onUpdate: "CASCADE",
      onDelete: "CASCADE",
    },
    batch_number: {
      type: DataTypes.STRING,
      allowNull: false,
    },
    expiration_date: {
      type: DataTypes.DATE,
      allowNull: false,
    },
    stock_level: {
      type: DataTypes.INTEGER,
      allowNull: false,
    },
    sales_price: {
      type: DataTypes.FLOAT,
      allowNull: false,
    },
    unit_price: {
      type: DataTypes.FLOAT,
      allowNull: false,
    },
     status: {
      type: DataTypes.INTEGER, // 0 = Ok, 1 = Low, 2 = Out
      defaultValue: 0,
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
    reason: {
      type: DataTypes.STRING,
      allowNull: true,
    },
  },
  {
    tableName: "stocks",
   timestamps: true, 
  // paranoid: true,  
    // deletedAt: 'deletedAt'
  }
);

// Association
Stock.belongsTo(Drug, { foreignKey: 'productId', as: 'product' });
module.exports = Stock;
