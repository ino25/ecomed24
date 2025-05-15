const { sequelize } = require("../config");
const { DataTypes } = require("sequelize");
const Drug = require("./Drug");

const Stock = sequelize.define("Stock", {
  id: {
    type: DataTypes.INTEGER,
    primaryKey: true,
    autoIncrement: true,
  },
   drugId: {
      type: DataTypes.INTEGER,
      allowNull: false,
      references: {
        model: Drug,
        key: "id",
      },
      onUpdate: "CASCADE",
      onDelete: "CASCADE",
    },
     updated_by: {
      type: DataTypes.STRING(50), 
      allowNull: false,
    },
    updated_at: {
      type: DataTypes.DATE,
      allowNull: false,
      defaultValue: DataTypes.NOW,
    },
  // name: {
  //   type: DataTypes.STRING(50),
  //   allowNull: false,
  //   defaultValue: "Produit",
  // },
  // batch: {
  //   type: DataTypes.STRING(50),
  //   allowNull: false,
  // },
  // expiration: {
  //   type: DataTypes.DATE,
  //   allowNull: false,
  // },
  // stock: {
  //   type: DataTypes.INTEGER,
  //   allowNull: false,
  // },
  // sales_price:{
  //   type: DataTypes.FLOAT,
  //   allowNull: false,
  // },
  // unit_price:{
  //   type: DataTypes.FLOAT,
  //   allowNull: false,
  // },
  // status: {
  //   type: DataTypes.ENUM("ok", "low", "out"),
  //   defaultValue: "active",
  //   allowNull: false,
  // },
},
{
  tableName: "stocks", 
  freezeTableName: true,
  timestamps: false
});
module.exports = Stock;
