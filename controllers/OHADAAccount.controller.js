const OHADAAccount = require("../models/OHADAAccount"); // Assuming the model is in ../models

// Create OHADA Account
const addAccount = async (req, res) => {
  try {
    const { name_en, name_fr, code, type, parent_id, tenant_id, createdBy } =
      req.body;

    // Check if an account with the same tenant_id and code already exists
    const existingAccount = await OHADAAccount.findOne({
      where: {
        tenant_id,
        code,
      },
    });

    if (existingAccount) {
      return res.status(400).json({
        message: "An account with this code already exists for the tenant",
      });
    }

    // If no duplicate is found, create the new account
    const newAccount = await OHADAAccount.create({
      name_en,
      name_fr,
      code,
      type,
      parent_id,
      tenant_id,
      status: "ACTIVE",
      createdBy,
      updatedBy: createdBy,
      createdAt: new Date(),
      updatedAt: new Date(),
    });

    return res.status(201).json(newAccount);
  } catch (error) {
    return res.status(500).json({ message: "Error creating account", error });
  }
};

// Get OHADA Account by ID
const getAccountById = async (req, res) => {
  try {
    const { id } = req.params;
    const account = await OHADAAccount.findByPk(id);

    if (!account) {
      return res.status(404).json({ message: "Account not found" });
    }

    return res.status(200).json(account);
  } catch (error) {
    return res.status(500).json({ message: "Error fetching account", error });
  }
};

// Update OHADA Account
const updateAccount = async (req, res) => {
  try {
    const { id } = req.params;
    const { name_en, name_fr, code, type, parent_id, tenant_id, updatedBy } =
      req.body;

    const account = await OHADAAccount.findByPk(id);

    if (!account) {
      return res.status(404).json({ message: "Account not found" });
    }

    await account.update({
      name_en,
      name_fr,
      code,
      type,
      parent_id,
      tenant_id,
      updatedBy,
      updatedAt: new Date(),
    });

    return res.status(200).json(account);
  } catch (error) {
    return res.status(500).json({ message: "Error updating account", error });
  }
};

// Soft Delete OHADA Account
const deleteAccount = async (req, res) => {
  try {
    const { id } = req.params;
    const { updatedBy } = req.body;

    const account = await OHADAAccount.findByPk(id);

    if (!account) {
      return res.status(404).json({ message: "Account not found" });
    }

    await account.update({
      status: "INACTIVE",
      updatedBy,
      updatedAt: new Date(),
    });

    return res
      .status(200)
      .json({ message: "Account soft deleted successfully" });
  } catch (error) {
    return res
      .status(500)
      .json({ message: "Error soft deleting account", error });
  }
};

// List All OHADA Accounts
const getAllAccounts = async (req, res) => {
  try {
    const { status } = req.query; // Optionally filter by 'ACTIVE' or 'INACTIVE'

    const accounts = await OHADAAccount.findAll({
      where: status ? { status } : {},
    });

    return res.status(200).json(accounts);
  } catch (error) {
    return res.status(500).json({ message: "Error fetching accounts", error });
  }
};

// Bulk Create Tenant Accounts with Duplicate Check
const bulkCreateTenantAccounts = async (req, res) => {
  try {
    const { accountIds, tenantId, createdBy } = req.body;

    // Fetch the original accounts to be cloned
    const accountsToClone = await OHADAAccount.findAll({
      where: {
        id: accountIds,
        tenant_id: 0, // Only allow cloning from the generic OHADA accounts
      },
    });

    if (!accountsToClone.length) {
      return res.status(404).json({ message: "No accounts found to clone" });
    }

    // Extract the codes of the accounts to be cloned
    const accountCodesToClone = accountsToClone.map((account) => account.code);

    // Check if any of the accounts to be cloned already exist for the tenant
    const existingAccounts = await OHADAAccount.findAll({
      where: {
        tenant_id: tenantId,
        code: accountCodesToClone, // Check for duplicate codes for the tenant
      },
    });

    if (existingAccounts.length > 0) {
      // If there are duplicates, return an error
      const duplicateCodes = existingAccounts.map((account) => account.code);
      return res.status(400).json({
        message: `Duplicate accounts found for tenant: ${duplicateCodes.join(
          ", "
        )}`,
      });
    }

    // Prepare cloned accounts with the new tenant ID
    const clonedAccounts = accountsToClone.map((account) => ({
      name_en: account.name_en,
      name_fr: account.name_fr,
      code: account.code, // Maintain the same code for reference
      type: account.type,
      parent_id: account.parent_id, // Maintain hierarchical structure
      tenant_id: tenantId, // Assign new tenant ID
      status: "ACTIVE",
      createdBy,
      updatedBy: createdBy,
      createdAt: new Date(),
      updatedAt: new Date(),
    }));

    // Bulk create cloned accounts for the tenant
    const newAccounts = await OHADAAccount.bulkCreate(clonedAccounts);

    return res.status(201).json(newAccounts);
  } catch (error) {
    return res
      .status(500)
      .json({ message: "Error bulk creating tenant accounts", error });
  }
};

// Get All Accounts for a Particular Tenant
const getTenantAccounts = async (req, res) => {
  try {
    const { tenantId } = req.params;

    const tenantAccounts = await OHADAAccount.findAll({
      where: { tenant_id: tenantId },
    });

    if (!tenantAccounts.length) {
      return res
        .status(404)
        .json({ message: "No accounts found for the tenant" });
    }

    return res.status(200).json(tenantAccounts);
  } catch (error) {
    return res
      .status(500)
      .json({ message: "Error fetching tenant accounts", error });
  }
};

// Get Account Balance by ID
const getAccountBalance = async (req, res) => {
  try {
    const { id } = req.params;

    // Check if the account exists
    const account = await OHADAAccount.findByPk(id);
    if (!account) {
      return res.status(404).json({ message: "Account not found" });
    }

    // Calculate balance from transaction lines
    const debitTransactions = await OHADATransactionLine.sum("amount", {
      where: {
        account_id: id,
        type: "DEBIT",
      },
    });

    const creditTransactions = await OHADATransactionLine.sum("amount", {
      where: {
        account_id: id,
        type: "CREDIT",
      },
    });

    const balance = (debitTransactions || 0) - (creditTransactions || 0);

    return res.status(200).json({ account_id: id, balance });
  } catch (error) {
    console.error("Error fetching account balance:", error);
    return res
      .status(500)
      .json({ message: "Error fetching account balance", error });
  }
};

// Configure tenant-specific Chart of Accounts with Duplicate Check
const configureTenantCoA = async (req, res) => {
  try {
    const { tenantId, createdBy } = req.body;

    if (!tenantId) {
      return res.status(400).json({ message: "Tenant ID is required" });
    }

    // Find all generic financial, expense, and revenue accounts
    const genericAccounts = await OHADAAccount.findAll({
      where: {
        tenant_id: 0,
        type: ["ASSET", "LIABILITY", "REVENUE", "EXPENSE"],
      },
    });

    if (!genericAccounts.length) {
      return res
        .status(404)
        .json({ message: "No generic accounts found to configure" });
    }

    // Extract the codes of the generic accounts
    const accountCodesToClone = genericAccounts.map((account) => account.code);

    // Check if any of these accounts already exist for the tenant
    const existingAccounts = await OHADAAccount.findAll({
      where: {
        tenant_id: tenantId,
        code: accountCodesToClone, // Check for duplicate codes for the tenant
      },
    });

    if (existingAccounts.length > 0) {
      // If there are duplicates, return an error
      const duplicateCodes = existingAccounts.map((account) => account.code);
      return res.status(400).json({
        message: `Duplicate accounts found for tenant: ${duplicateCodes.join(
          ", "
        )}`,
      });
    }

    // Prepare cloned accounts with the new tenant ID
    const tenantAccounts = genericAccounts.map((account) => ({
      name_fr: account.name_fr,
      name_en: account.name_en,
      code: account.code,
      type: account.type,
      tenant_id: tenantId,
      parent_id: account.parent_id, // This will create a similar hierarchy
      status: "ACTIVE",
      createdBy: createdBy,
      updatedBy: createdBy,
      createdAt: new Date(),
      updatedAt: new Date(),
    }));

    // Bulk create accounts for the tenant
    await OHADAAccount.bulkCreate(tenantAccounts);

    return res.status(201).json({
      message: "Tenant-specific Chart of Accounts created successfully",
    });
  } catch (error) {
    return res
      .status(500)
      .json({ message: "Error configuring tenant Chart of Accounts", error });
  }
};

module.exports = {
  addAccount,
  getAccountById,
  updateAccount,
  deleteAccount,
  getAllAccounts,
  bulkCreateTenantAccounts,
  getTenantAccounts,
  getAccountBalance,
  configureTenantCoA,
};
