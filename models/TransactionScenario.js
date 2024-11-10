// models/TransactionScenario.js

const { DataTypes } = require("sequelize");
const sequelize = require("../config").sequelize;

const TransactionScenario = sequelize.define(
  "TransactionScenario",
  {
    name: {
      type: DataTypes.STRING,
      allowNull: false,
    },
    debit_account_id: {
      type: DataTypes.INTEGER,
      allowNull: false,
      references: {
        model: "OHADAAccount",
        key: "id",
      },
    },
    credit_account_id: {
      type: DataTypes.INTEGER,
      allowNull: false,
      references: {
        model: "OHADAAccount",
        key: "id",
      },
    },
    requires_approval: {
      type: DataTypes.BOOLEAN,
      defaultValue: false,
    },
    approval_conditions: {
      type: DataTypes.JSON,
      allowNull: true,
      // JSON field to store conditions such as:
      // { "amount_greater_than": 1000, "daily_transactions_limit": 5 }
    },
    tenant_id: {
      type: DataTypes.INTEGER,
      allowNull: false,
    },
    description: {
      type: DataTypes.STRING,
      allowNull: true,
    },
    createdBy: {
      type: DataTypes.INTEGER,
      allowNull: false,
    },
    updatedBy: {
      type: DataTypes.INTEGER,
      allowNull: false,
    },
  },
  {
    timestamps: true,
  }
);

module.exports = TransactionScenario;
