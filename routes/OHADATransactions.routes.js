const express = require("express");
const {
  createTransaction,
  getTransactions,
  getTransactionById,
  updateTransaction,
  deleteTransaction,
  createTransactionFromScenario,
  postCheckoutTransaction,
  postPaymentTransaction,
} = require("../controllers/OHADATransaction.controller.js");

const router = express.Router();

// Route to create a new OHADA transaction
router.post("/createTransaction", createTransaction);

// Route to get all OHADA transactions for a tenant
router.get("/getTransactions", getTransactions);

// Route to get an OHADA transaction by ID
router.get("/getTransaction/:id", getTransactionById);

// Route to update an existing OHADA transaction by ID
router.put("/updateTransaction/:id", updateTransaction);

// Route to delete an OHADA transaction by ID
router.delete("/deleteTransaction/:id", deleteTransaction);

// Route to create a transaction based on a predefined scenario
router.post("/createFromScenario", createTransactionFromScenario);

// Route to post checkout transaction
router.post("/postCheckoutTransaction", postCheckoutTransaction);

// Route to post payment transaction
router.post("/postPaymentTransaction", postPaymentTransaction);
module.exports = router;
