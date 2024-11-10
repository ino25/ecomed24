// Importing necessary modules and configurations
const { DataTypes } = require("sequelize");
const sequelize = require("../config").sequelize;

// Account Model Definition
const OHADAAccount = sequelize.define("OHADAAccount", {
  // Unique code for the account, used to identify each account uniquely
  code: {
    type: DataTypes.STRING,
    allowNull: false,
    unique: true,
  },
  // Type of the account (ASSET, LIABILITY, EQUITY, REVENUE, EXPENSE)
  type: {
    type: DataTypes.ENUM("ASSET", "LIABILITY", "EQUITY", "REVENUE", "EXPENSE"),
    allowNull: false,
  },
  // Tenant ID - generic OHADA accounts have tenant_id = 0, tenant-specific accounts have the corresponding tenant ID
  tenant_id: {
    type: DataTypes.INTEGER,
    allowNull: false,
    defaultValue: 0, // Tenant ID = 0 for generic OHADA accounts
  },
  // Balance field to track the current balance of the account
  balance: {
    type: DataTypes.DECIMAL(15, 2),
    allowNull: false,
    defaultValue: 0.0,
  },
  // Status of the account (ACTIVE, INACTIVE)
  status: {
    type: DataTypes.ENUM("ACTIVE", "INACTIVE"),
    allowNull: false,
    defaultValue: "ACTIVE",
  },
  // English name for localization purposes
  name_en: {
    type: DataTypes.STRING,
    allowNull: false,
  },
  // French name for localization purposes
  name_fr: {
    type: DataTypes.STRING,
    allowNull: false,
  },
  // Parent account to maintain hierarchical structure (for sub-accounts)
  parent_id: {
    type: DataTypes.INTEGER,
    allowNull: true,
    references: {
      model: "OHADAAccounts",
      key: "id",
    },
  },
  // ID of the user who created the account
  createdBy: {
    type: DataTypes.INTEGER,
    allowNull: false,
  },
  // ID of the user who last updated the account
  updatedBy: {
    type: DataTypes.INTEGER,
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

// Export the Account model
module.exports = OHADAAccount;
