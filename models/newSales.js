const { sequelize } = require("../config");
const { DataTypes } = require("sequelize");
const Prescriptions = require("./Prescriptions");

const NewSales = sequelize.define(
  "NewSales",
  {
    id: {
      type: DataTypes.INTEGER,
      primaryKey: true,
      autoIncrement: true,
    },
    prescription_id: {
      type: DataTypes.INTEGER,
      allowNull: false,
      references: {
        model: Prescriptions,
        key: "id",
      },
      onUpdate: "CASCADE",
      onDelete: "CASCADE",
    },
    patient_id: {
      type: DataTypes.INTEGER,
      allowNull: true,
    },
    name: {
      type: DataTypes.STRING,
      allowNull: true,
    },
    price: {
      type: DataTypes.FLOAT,
      allowNull: true,
    },
    quantity: {
      type: DataTypes.INTEGER,
      allowNull: true,
    },
    subtotal: {
      type: DataTypes.FLOAT,
      allowNull: true,
    },
    total: {
      type: DataTypes.FLOAT,
      allowNull: true,
    },
    payment_method: {
      type: DataTypes.STRING,
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
    tableName: "new_sales",
    timestamps: true,
  }
);
NewSales.belongsTo(Prescriptions, {
  foreignKey: "pricription_id",
  as: "prescription",
});
module.exports = NewSales;
