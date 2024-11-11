const { DataTypes } = require("sequelize");
const sequelize = require("../config").sequelize;

const OHADATransaction = sequelize.define(
  "OHADATransaction",
  {
    reference_number: {
      type: DataTypes.STRING,
      allowNull: false,
      unique: true,
    },
    date: {
      type: DataTypes.DATE,
      allowNull: false,
    },
    description: {
      type: DataTypes.STRING,
    },
    amount: {
      type: DataTypes.DECIMAL(10, 2), // Define as appropriate
      allowNull: false,
      defaultValue: 0.0,
    },
    scenario_id: {
      type: DataTypes.INTEGER,
      references: {
        model: "TransactionScenario",
        key: "id",
      },
      allowNull: true, // Not all transactions need a scenario
    },
    original_transaction_id: {
      type: DataTypes.INTEGER,
      references: {
        model: "OHADATransaction",
        key: "id",
      },
      allowNull: true, // Only refund or reversal transactions would have this reference
    },
    requires_approval: {
      type: DataTypes.BOOLEAN,
      defaultValue: false,
    },
    approval_status: {
      type: DataTypes.ENUM("PENDING", "APPROVED", "REJECTED"),
      defaultValue: "APPROVED",
    },
    status: {
      type: DataTypes.ENUM("PENDING", "APPROVED", "REJECTED"),
      defaultValue: "PENDING",
    },
    tenant_id: {
      type: DataTypes.INTEGER,
      allowNull: false,
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

module.exports = OHADATransaction;
