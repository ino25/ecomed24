// models/PaymentMethod.js

const { DataTypes } = require("sequelize");
const sequelize = require("../config").sequelize;

const PaymentMethod = sequelize.define(
  "PaymentMethod",
  {
    id: {
      type: DataTypes.INTEGER,
      primaryKey: true,
      autoIncrement: true,
    },
    methodType: {
      type: DataTypes.STRING,
      allowNull: false,
      unique: true,
      validate: {
        isIn: [
          [
            "Credit Card",
            "Bank Transfer",
            "OrangeMoney",
            "WAVE",
            "Cash",
            "Cheque",
          ],
        ],
      },
    },
    code: {
      type: DataTypes.STRING,
      allowNull: false,
      unique: true,
      validate: {
        isIn: [
          [
            "method_CC",
            "method_bank_transfer",
            "method_wave",
            "method_orange",
            "method_cash",
            "method_cheque",
          ],
        ],
      },
    },
    providerName: {
      type: DataTypes.STRING,
      allowNull: true,
    },
  },
  {
    tableName: "PaymentMethods", // Match existing table name
    timestamps: true, // Enable Sequelize's default timestamps (createdAt, updatedAt)
  }
);

module.exports = PaymentMethod;
