// Importing necessary modules and configurations
const { DataTypes } = require("sequelize");
const sequelize = require("../config").sequelize;

const OHADATransaction = require("./OHADATransaction");
const OHADAAccount = require("./OHADAAccount");

// Transaction Line Model Definition
const OHADATransactionLine = sequelize.define("OHADATransactionLine", {
  // Foreign key to associate with a specific transaction
  transaction_id: {
    type: DataTypes.INTEGER,
    references: {
      model: OHADATransaction,
      key: "id",
    },
    allowNull: false,
  },
  // Foreign key to associate with a specific account
  account_id: {
    type: DataTypes.INTEGER,
    references: {
      model: OHADAAccount,
      key: "id",
    },
    allowNull: false,
  },
  // Amount for the line item of the transaction
  amount: {
    type: DataTypes.DECIMAL(10, 2),
    allowNull: false,
  },
  // Type of the transaction line (DEBIT or CREDIT)
  type: {
    type: DataTypes.ENUM("DEBIT", "CREDIT"),
    allowNull: false,
  },
  // Created at timestamp
  createdAt: {
    type: DataTypes.DATE,
    allowNull: false,
    defaultValue: DataTypes.NOW,
  },
  // Updated at timestamp
  updatedAt: {
    type: DataTypes.DATE,
    allowNull: false,
    defaultValue: DataTypes.NOW,
  },
});

// Export the Transaction Line model
module.exports = OHADATransactionLine;

// Relationships
// Account can have many sub-accounts
OHADAAccount.hasMany(OHADAAccount, {
  foreignKey: "parent_id",
  as: "subAccounts",
});
