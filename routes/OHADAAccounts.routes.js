const express = require("express");
const {
  getAllAccounts,
  getAccountById,
  addAccount,
  updateAccount,
  deleteAccount,
  bulkCreateTenantAccounts,
  getTenantAccounts,
  getAccountBalance,
  configureTenantCoA,
} = require("../controllers/OHADAAccount.controller");

const router = express.Router();

// Route to get all OHADA accounts
router.get("/getGenericAccounts", getAllAccounts);

// Route to get an OHADA account by ID
router.get("/getAccount/:id", getAccountById);

// Route to add a new OHADA account
router.post("/addAccount", addAccount);

// Route to update an existing OHADA account by ID
router.put("/updateAccount/:id", updateAccount);

// Route to delete an OHADA account by ID
router.delete("/deleteAccount/:id", deleteAccount);

// Route to bulk create accounts for a tenant
router.post("/bulkCreateTenantAccounts", bulkCreateTenantAccounts);

// Route to get all accounts for a particular tenant
router.get("/tenantAccounts/:tenantId", getTenantAccounts);

// Defining the route for getting account balance
router.get("/accounts/:id/balance", getAccountBalance);

// Route to configure tenant-specific Chart of Accounts
router.post("/configureTenantCoA", configureTenantCoA);

module.exports = router;
