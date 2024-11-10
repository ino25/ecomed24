const sequelize = require("../config").sequelize;
const OHADATransaction = require("../models/OHADATransaction"); // Assuming Sequelize models are used
const OHADAAccount = require("../models/OHADAAccount");
const OHADATransactionLine = require("../models/OHADATransactionLine");
const TransactionScenario = require("../models/TransactionScenario");
const { Sequelize, DataTypes } = require("sequelize");
const ServiceRequest = require("../models/ServiceRequest");
const ServiceInstance = require("../models/ServiceInstance");
const PaymentMethod = require("../models/PaymentMethod");
const Patient = require("../models/Patient");
const SettingService = require("../models/SettingService");

// Transaction can have many transaction lines
OHADATransaction.hasMany(OHADATransactionLine, {
  foreignKey: "transaction_id",
  as: "transactionLines",
});

// Transaction Line belongs to a specific transaction and account
OHADATransactionLine.belongsTo(OHADATransaction, {
  foreignKey: "transaction_id",
  as: "transaction",
});
OHADATransactionLine.belongsTo(OHADAAccount, {
  foreignKey: "account_id",
  as: "account",
});

// Create a new transaction
// Create a new transaction
exports.createTransaction = async (req, res) => {
  const transaction = await sequelize.transaction();
  try {
    console.log("Starting createTransaction...");

    const {
      referenceNumber,
      date,
      description,
      status,
      transactionLines,
      requires_approval,
    } = req.body;

    console.log("Received request payload:", req.body);

    const tenantId = parseInt(req.headers["x-tenant-id"], 10);
    if (!tenantId) {
      console.log("Tenant ID is missing.");
      return res.status(400).json({ message: "Tenant ID is required." });
    }

    console.log("****** Tenant ID*******:", tenantId);

    // Velocity Check: Prevent the creation of identical transactions within a given period
    const velocityPeriod = 60 * 60 * 1000; // 1 hour in milliseconds
    const velocityCheckDate = new Date(Date.now() - velocityPeriod);

    const existingTransaction = await OHADATransaction.findOne({
      where: {
        reference_number: referenceNumber,
        tenant_id: tenantId,
        createdAt: {
          [Sequelize.Op.gte]: velocityCheckDate,
        },
      },
      transaction,
    });

    if (existingTransaction) {
      console.log(
        `Transaction with reference number "${referenceNumber}" was already created within the last hour.`
      );
      return res.status(400).json({
        message: `Transaction with reference number "${referenceNumber}" has been created recently. Please wait before creating it again.`,
      });
    }

    // Check if the accounts exist, belong to the tenant, and for DEBIT lines, if they have sufficient balance
    let insufficientFunds = false;
    let totalAmount = 0;

    for (let line of transactionLines) {
      console.log("Validating account:", line.account_id);
      const existingAccount = await OHADAAccount.findOne({
        where: { id: line.account_id, tenant_id: tenantId },
        transaction,
      });

      if (!existingAccount) {
        console.log(
          `Account ID ${line.account_id} does not exist for the tenant.`
        );
        return res.status(400).json({
          message: `Account ID ${line.account_id} does not exist for the tenant.`,
        });
      }

      // Check sufficient balance for DEBIT operations
      if (line.type === "DEBIT") {
        if (existingAccount.balance < line.amount) {
          console.log(`Insufficient balance in account ID ${line.account_id}`);
          insufficientFunds = true;
          break;
        }
        totalAmount += line.amount; // Sum all debit lines to get the total transaction amount
      }
    }

    // If insufficient funds, set transaction status to INSUFFICIENT_FUNDS
    if (insufficientFunds) {
      console.log(
        "Insufficient funds detected. Creating transaction with status INSUFFICIENT_FUNDS."
      );

      const insufficientFundsTransaction = await OHADATransaction.create(
        {
          reference_number: referenceNumber,
          date,
          description,
          status: "INSUFFICIENT_FUNDS",
          tenant_id: tenantId,
          requires_approval,
          approval_status: "PENDING",
          createdBy: req.headers["x-user-id"],
          updatedBy: req.headers["x-user-id"],
          amount: totalAmount,
        },
        { transaction }
      );

      await transaction.commit();

      return res.status(201).json({
        message:
          "Transaction created with status INSUFFICIENT_FUNDS due to insufficient balance.",
        transaction: insufficientFundsTransaction,
      });
    }

    console.log("All accounts validated successfully.");

    // Determine the approval status
    const approvalStatus = requires_approval ? "PENDING" : "APPROVED";

    // Update account balances as part of the transaction
    for (let line of transactionLines) {
      const account = await OHADAAccount.findOne({
        where: { id: line.account_id },
        transaction,
      });

      if (line.type === "DEBIT") {
        await account.update(
          { balance: account.balance - line.amount },
          { transaction }
        );
      } else if (line.type === "CREDIT") {
        await account.update(
          { balance: account.balance + line.amount },
          { transaction }
        );
      }
    }

    // Create the transaction
    const newTransaction = await OHADATransaction.create(
      {
        reference_number: referenceNumber,
        date,
        description,
        status,
        tenant_id: tenantId,
        amount: totalAmount, // Set the calculated amount
        transactionLines,
        requires_approval,
        approval_status: approvalStatus,
        createdBy: req.headers["x-user-id"],
        updatedBy: req.headers["x-user-id"],
      },
      {
        include: ["transactionLines"],
        transaction,
      }
    );

    // Commit the transaction
    await transaction.commit();

    console.log("Transaction created successfully:", newTransaction);

    res.status(201).json(newTransaction);
  } catch (error) {
    console.error("Error creating transaction:", error);
    if (transaction) await transaction.rollback();
    res.status(500).json({ message: "Error creating transaction." });
  }
};

exports.createTransactionFromScenario = async (req, res) => {
  const transaction = await sequelize.transaction();
  try {
    console.log("Starting createTransactionFromScenario...");

    const { scenario_id, reference_number, date, description } = req.body;
    const tenantId = parseInt(req.headers["x-tenant-id"], 10);

    if (!tenantId) {
      console.log("Tenant ID is missing.");
      return res.status(400).json({ message: "Tenant ID is required." });
    }

    console.log("Tenant ID:", tenantId);

    // Find the scenario by ID
    const scenario = await TransactionScenario.findOne({
      where: { id: scenario_id },
      transaction,
    });

    if (!scenario) {
      console.log(`Transaction Scenario ID ${scenario_id} not found.`);
      return res
        .status(404)
        .json({ message: "Transaction Scenario not found." });
    }

    console.log("Transaction Scenario found:", scenario);

    // Velocity check: prevent creating similar transactions within a given time frame (e.g., 24 hours)
    const velocityPeriod = 24 * 60 * 60 * 1000; // 24 hours in milliseconds
    const velocityCheckDate = new Date(Date.now() - velocityPeriod);

    const existingTransaction = await OHADATransaction.findOne({
      where: {
        tenant_id: tenantId,
        reference_number,
        createdAt: {
          [Sequelize.Op.gte]: velocityCheckDate,
        },
      },
      transaction,
    });

    if (existingTransaction) {
      console.log(
        "A similar transaction has been created within the last 24 hours."
      );
      return res.status(400).json({
        message:
          "A similar transaction has already been created within the last 24 hours. Please try again later.",
      });
    }

    // Fetch the debit and credit accounts
    const debitAccount = await OHADAAccount.findOne({
      where: { id: scenario.debit_account_id, tenant_id: tenantId },
      transaction,
    });

    const creditAccount = await OHADAAccount.findOne({
      where: { id: scenario.credit_account_id, tenant_id: tenantId },
      transaction,
    });

    if (!debitAccount || !creditAccount) {
      console.log("Debit or credit account not found.");
      return res
        .status(404)
        .json({ message: "Debit or credit account not found." });
    }

    console.log("Debit account:", debitAccount);
    console.log("Credit account:", creditAccount);

    // Calculate the total amount from the debit line(s)
    const debitAmount = scenario.amount;

    // Check if the debit account has sufficient balance
    if (debitAccount.balance < debitAmount) {
      console.log(`Insufficient balance in account ID ${debitAccount.id}`);
      return res.status(400).json({
        message: `Insufficient balance in account ID ${debitAccount.id}. Available balance is ${debitAccount.balance}, but transaction amount is ${debitAmount}.`,
      });
    }

    // Update account balances as part of the transaction
    await debitAccount.update(
      { balance: debitAccount.balance - debitAmount },
      { transaction }
    );

    await creditAccount.update(
      { balance: creditAccount.balance + debitAmount },
      { transaction }
    );

    // Create the transaction based on the scenario as part of the same database transaction
    const approvalStatus = scenario.requires_approval ? "PENDING" : "APPROVED";

    const newTransaction = await OHADATransaction.create(
      {
        reference_number,
        date,
        description,
        tenant_id: tenantId,
        status: "PENDING",
        requires_approval: scenario.requires_approval,
        approval_status: approvalStatus,
        amount: debitAmount, // Set the amount field
        createdBy: req.headers["x-user-id"],
        updatedBy: req.headers["x-user-id"],
        transactionLines: [
          {
            type: "DEBIT",
            account_id: scenario.debit_account_id,
            amount: debitAmount,
          },
          {
            type: "CREDIT",
            account_id: scenario.credit_account_id,
            amount: debitAmount,
          },
        ],
      },
      {
        include: ["transactionLines"],
        transaction, // Ensure the new transaction is part of the database transaction
      }
    );

    // Commit the transaction
    await transaction.commit();

    console.log("Transaction created successfully:", newTransaction);
    res.status(201).json(newTransaction);
  } catch (error) {
    console.error("Error creating transaction from scenario:", error);
    if (transaction) await transaction.rollback();
    res
      .status(500)
      .json({ message: "Error creating transaction from scenario." });
  }
};

// Get all transactions for a tenant
exports.getTransactions = async (req, res) => {
  try {
    const tenantId = req.headers["x-tenant-id"];
    const { startDate, endDate } = req.query;

    // Log tenant ID and date range being used for filtering
    console.log("****** Tenant ID *******:", tenantId);
    console.log("****** Start Date *******:", startDate);
    console.log("****** End Date *******:", endDate);
    if (!tenantId) {
      return res.status(400).json({ message: "Tenant ID is required." });
    }

    const transactions = await OHADATransaction.findAll({
      where: { tenant_id: tenantId },
      include: ["transactionLines"],
    });

    // Format the transactions
    const transactionsWithAmount = transactions.map((transaction) => {
      // Check if there are any transaction lines to sum up
      let totalDebitAmount = 0;
      if (
        transaction.transactionLines &&
        transaction.transactionLines.length > 0
      ) {
        totalDebitAmount = transaction.transactionLines
          .filter((line) => line.type === "DEBIT")
          .reduce((sum, line) => sum + line.amount, 0);
      }

      return {
        ...transaction.toJSON(),
        amount: totalDebitAmount > 0 ? totalDebitAmount : transaction.amount, // Use the correct amount from DB if totalDebitAmount is zero
      };
    });

    res.status(200).json(transactionsWithAmount);
  } catch (error) {
    console.error("Error fetching transactions:", error);
    res.status(500).json({ message: "Error fetching transactions." });
  }
};

// Get a transaction by ID
exports.getTransactionById = async (req, res) => {
  try {
    const { id } = req.params;

    const tenantId = req.headers["x-tenant-id"];
    if (!tenantId) {
      return res.status(400).json({ message: "Tenant ID is required." });
    }

    const transaction = await OHADATransaction.findOne({
      where: { id, tenant_id: tenantId },
      include: [
        {
          model: OHADATransactionLine,
          as: "transactionLines",
          include: [
            {
              model: OHADAAccount,
              as: "account",
            },
          ],
        },
      ],
    });

    if (!transaction) {
      return res.status(404).json({ message: "Transaction not found." });
    }

    res.status(200).json(transaction);
  } catch (error) {
    console.error("Error fetching transaction by ID:", error);
    res.status(500).json({ message: "Error fetching transaction by ID." });
  }
};

//to be revisited
async function getAllTransactionsForPatient(patientId) {
  try {
    const accountCode = `411-${patientId}`;
    const patientAccount = await OHADAAccount.findOne({
      where: { code: accountCode },
    });
    if (!patientAccount) {
      console.log("No account found for the given patient.");
      return [];
    }

    const transactions = await Transaction.findAll({
      where: { ohada_account_id: patientAccount.id },
    });

    return transactions;
  } catch (error) {
    console.error("Error fetching patient transactions:", error);
    throw error;
  }
}

// Update an existing transaction
exports.updateTransaction = async (req, res) => {
  try {
    const { id } = req.params;
    const { referenceNumber, date, description, status, transactionLines } =
      req.body;

    const tenantId = req.headers["x-tenant-id"];
    if (!tenantId) {
      return res.status(400).json({ message: "Tenant ID is required." });
    }

    const transaction = await OHADATransaction.findOne({
      where: { id, tenant_id: tenantId },
    });
    if (!transaction) {
      return res.status(404).json({ message: "Transaction not found." });
    }

    // Update transaction details
    transaction.referenceNumber = referenceNumber;
    transaction.date = date;
    transaction.description = description;
    transaction.status = status;
    await transaction.save();

    // Update transaction lines (simple example, better logic may be needed for real use)
    await transaction.setTransactionLines(transactionLines);

    res.status(200).json(transaction);
  } catch (error) {
    console.error("Error updating transaction:", error);
    res.status(500).json({ message: "Error updating transaction." });
  }
};

// Delete a transaction (soft delete)
exports.deleteTransaction = async (req, res) => {
  try {
    const { id } = req.params;

    const tenantId = req.headers["x-tenant-id"];
    if (!tenantId) {
      return res.status(400).json({ message: "Tenant ID is required." });
    }

    const transaction = await OHADATransaction.findOne({
      where: { id, tenant_id: tenantId },
    });
    if (!transaction) {
      return res.status(404).json({ message: "Transaction not found." });
    }

    // Soft delete the transaction
    await transaction.update({ deletedAt: new Date() });

    res.status(200).json({ message: "Transaction deleted successfully." });
  } catch (error) {
    console.error("Error deleting transaction:", error);
    res.status(500).json({ message: "Error deleting transaction." });
  }
};

// Define the API to post a transaction at the POS
exports.postCheckoutTransaction = async (req, res) => {
  const transaction = await sequelize.transaction();
  try {
    console.log("Starting postCheckoutTransaction...");

    const { payment_method_id, service_request_id, amount_paid } = req.body;
    const tenantId = parseInt(req.headers["x-tenant-id"], 10);
    const userId = parseInt(req.headers["x-user-id"], 10);

    console.log("Request body:", req.body);
    console.log("Headers - Tenant ID:", tenantId, "User ID:", userId);

    if (!tenantId || !userId) {
      console.log("Tenant ID or User ID is missing.");
      return res
        .status(400)
        .json({ message: "Tenant ID and User ID are required." });
    }

    console.log("Tenant ID:", tenantId);

    // Fetch Payment Method
    const paymentMethod = await PaymentMethod.findOne({
      where: { id: payment_method_id },
    });
    if (!paymentMethod) {
      console.log(`Payment Method ID ${payment_method_id} not found.`);
      return res.status(404).json({ message: "Payment Method not found." });
    }

    // Determine Scenario based on Payment Method
    console.log(
      "Determining scenario based on payment method type:",
      paymentMethod.methodType
    );
    let scenario;
    switch (paymentMethod.methodType) {
      case "OrangeMoney":
        scenario = await TransactionScenario.findOne({
          where: { name: "OrangeMoney Scenario", tenant_id: tenantId },
        });
        break;
      case "WAVE":
        scenario = await TransactionScenario.findOne({
          where: { name: "WaveMoney Scenario", tenant_id: tenantId },
        });
        break;
      case "Cheque":
        scenario = await TransactionScenario.findOne({
          where: { name: "Cheque Scenario", tenant_id: tenantId },
        });
        break;
      case "Bank Transfer":
        scenario = await TransactionScenario.findOne({
          where: { name: "Bank Transfer Scenario", tenant_id: tenantId },
        });
        break;
      case "Credit Card":
        scenario = await TransactionScenario.findOne({
          where: { name: "Credit Card Scenario", tenant_id: tenantId },
        });
        break;
      case "Cash":
        scenario = await TransactionScenario.findOne({
          where: { name: "Cash Scenario", tenant_id: tenantId },
        });
        break;
      default:
        return res.status(400).json({ message: "Unsupported payment method." });
    }

    if (!scenario) {
      console.log(
        `Transaction Scenario for Payment Method ${paymentMethod.methodType} not found.`
      );
      return res
        .status(404)
        .json({ message: "Transaction Scenario not found." });
    }

    console.log("Transaction Scenario found:", scenario);

    // Fetch Service Request
    console.log("Fetching Service Request with ID:", service_request_id);

    const serviceRequest = await ServiceRequest.findOne({
      where: { requestID: service_request_id },
    });
    if (!serviceRequest) {
      console.log(`Service Request ID ${service_request_id} not found.`);
      return res.status(404).json({ message: "Service Request not found." });
    }

    console.log("Service Request found:", serviceRequest);

    // Extract amounts from the service request
    const totalAmount = serviceRequest.total_amount;
    const discountAmount = serviceRequest.discount_amount;
    const amountDue = serviceRequest.remaining_balance;
    const netAmount = serviceRequest.net_amount;

    console.log(
      "Amounts from service request - Total Amount:",
      totalAmount,
      "Discount Amount:",
      discountAmount,
      "Amount Due:",
      amountDue,
      "Net Amount:",
      netAmount
    );

    // Fetch debit and credit accounts from the scenario
    const debitAccount = await OHADAAccount.findOne({
      where: { id: scenario.debit_account_id, tenant_id: tenantId },
    });
    const creditAccount = await OHADAAccount.findOne({
      where: { id: scenario.credit_account_id, tenant_id: tenantId },
    });
    const discountAccount = await OHADAAccount.findOne({
      where: { code: "7.015", tenant_id: tenantId },
    });
    const accountsReceivable = await OHADAAccount.findOne({
      where: { code: "4.1.1", tenant_id: tenantId },
    });

    if (
      !debitAccount ||
      !creditAccount ||
      !discountAccount ||
      !accountsReceivable
    ) {
      console.log("One or more required accounts not found.");
      return res.status(404).json({
        message:
          "Debit, Credit, Discount, or Accounts Receivable account not found.",
      });
    }

    console.log("Debit account:", debitAccount);
    console.log("Credit account:", creditAccount);
    console.log("Discount account:", discountAccount);
    console.log("Accounts Receivable account:", accountsReceivable);

    // Log balances before updates
    console.log("Balances before updates:");
    console.log("Debit Account Balance:", debitAccount.balance);
    console.log("Credit Account Balance:", creditAccount.balance);
    console.log(
      "&&&&&&&&&&&&&& Discount Account Balance:",
      discountAccount.balance
    );
    console.log("Accounts Receivable Balance:", accountsReceivable.balance);

    // Log amounts and accounts
    if (discountAmount > 0) {
      const formattedDiscountAmount = parseFloat(discountAmount);
      const currentBalance = parseFloat(discountAccount.balance);
      console.log(
        "<<<<<<<<<<<  Discount Amount Before Conversion <<<<<<<<<<<<:",
        discountAmount
      );
      console.log(
        "<<<<<<<<<<<  Discount Amount Balance Before Conversion <<<<<<<<<<<<:",
        currentBalance
      );
      console.log(
        `>>>>>>>>>>>>>> Posting discount amount ${formattedDiscountAmount} to Discount Account ID: ${discountAccount.id}`
      );

      await discountAccount.update(
        { balance: currentBalance + formattedDiscountAmount },
        { transaction }
      );
    }

    if (amount_paid > 0) {
      const formattedPaidAmount = parseFloat(amount_paid);
      const currentDebitAccountBalance = parseFloat(debitAccount.balance);
      const currentCreditAccountBalance = parseFloat(creditAccount.balance);
      console.log(
        `Posting amount paid ${amount_paid} - Debit Account ID: ${debitAccount.id}, Credit Account ID: ${creditAccount.id}`
      );

      await debitAccount.update(
        { balance: currentDebitAccountBalance - formattedPaidAmount },
        { transaction }
      );
      await creditAccount.update(
        { balance: currentCreditAccountBalance + formattedPaidAmount },
        { transaction }
      );
    }

    if (amountDue > 0) {
      const formattedDueAmount = parseFloat(amountDue);
      const currentAccountsReceivablesBalance = parseFloat(
        accountsReceivable.balance
      );
      console.log(
        `Posting amount due ${formattedDueAmount} to Accounts Receivable Account ID: ${accountsReceivable.id}`
      );
      console.log(
        "????????????  Accounts Receivable Balance Before Update??????????:",
        currentAccountsReceivablesBalance
      );
      await accountsReceivable.update(
        { balance: currentAccountsReceivablesBalance + formattedDueAmount },
        { transaction }
      );
      console.log(
        "******** Accounts Receivable Balance After Update*********:",
        accountsReceivable.balance
      );
    }

    // Log balances after updates
    await debitAccount.reload();
    await creditAccount.reload();
    await discountAccount.reload();
    await accountsReceivable.reload();

    console.log("Balances after updates:");
    console.log("Debit Account Balance:", debitAccount.balance);
    console.log("Credit Account Balance:", creditAccount.balance);
    console.log("Discount Account Balance:", discountAccount.balance);
    console.log("Accounts Receivable Balance:", accountsReceivable.balance);

    // Create the transaction
    const newTransaction = await OHADATransaction.create(
      {
        reference_number: `TXN-${Date.now()}`,
        date: new Date(),
        description: `Checkout transaction for ServiceRequest ID: ${service_request_id}. Prescripteur: ${serviceRequest.prescripteur}`,
        tenant_id: tenantId,
        status: "PENDING",
        requires_approval: scenario.requires_approval,
        approval_status: "APPROVED",
        amount: totalAmount,
        createdBy: userId,
        updatedBy: userId,
      },
      { transaction }
    );

    console.log("Transaction created successfully:", newTransaction);

    console.log("Transaction status before commit:", transaction.finished);

    // Commit the transaction
    console.log("Committing transaction...");
    await transaction.commit();
    console.log("Transaction committed successfully.");

    res.status(201).json({
      transaction: newTransaction,
      serviceRequest: {
        requestID: serviceRequest.requestID,
        status: "PROCESSED",
      },
    });
  } catch (error) {
    console.error("Error creating transaction from scenario:", error);
    if (transaction) await transaction.rollback();
    res
      .status(500)
      .json({ message: "Error creating transaction from scenario." });
  }
};

// Define the API to post a payment against Accounts Receivable
exports.postPaymentTransaction = async (req, res) => {
  const transaction = await sequelize.transaction();
  try {
    console.log("Starting postPaymentTransaction...");

    const { payment_method_id, service_request_id, amount_paid } = req.body;
    const tenantId = parseInt(req.headers["x-tenant-id"], 10);
    const userId = parseInt(req.headers["x-user-id"], 10);

    console.log("Request body:", req.body);
    console.log("Headers - Tenant ID:", tenantId, "User ID:", userId);

    if (!tenantId || !userId) {
      console.log("Tenant ID or User ID is missing.");
      return res
        .status(400)
        .json({ message: "Tenant ID and User ID are required." });
    }

    console.log("Tenant ID:", tenantId);

    // Fetch Payment Method
    const paymentMethod = await PaymentMethod.findOne({
      where: { id: payment_method_id },
    });
    if (!paymentMethod) {
      console.log(`Payment Method ID ${payment_method_id} not found.`);
      return res.status(404).json({ message: "Payment Method not found." });
    }

    // Determine Scenario based on Payment Method
    console.log(
      "Determining scenario based on payment method type:",
      paymentMethod.methodType
    );
    let scenario;
    switch (paymentMethod.methodType) {
      case "OrangeMoney":
        scenario = await TransactionScenario.findOne({
          where: { name: "OrangeMoney Scenario", tenant_id: tenantId },
        });
        break;
      case "WAVE":
        scenario = await TransactionScenario.findOne({
          where: { name: "WaveMoney Scenario", tenant_id: tenantId },
        });
        break;
      case "Cheque":
        scenario = await TransactionScenario.findOne({
          where: { name: "Cheque Scenario", tenant_id: tenantId },
        });
        break;
      case "Bank Transfer":
        scenario = await TransactionScenario.findOne({
          where: { name: "Bank Transfer Scenario", tenant_id: tenantId },
        });
        break;
      case "Credit Card":
        scenario = await TransactionScenario.findOne({
          where: { name: "Credit Card Scenario", tenant_id: tenantId },
        });
        break;
      case "Cash":
        scenario = await TransactionScenario.findOne({
          where: { name: "Cash Scenario", tenant_id: tenantId },
        });
        break;
      default:
        return res.status(400).json({ message: "Unsupported payment method." });
    }

    if (!scenario) {
      console.log(
        `Transaction Scenario for Payment Method ${paymentMethod.methodType} not found.`
      );
      return res
        .status(404)
        .json({ message: "Transaction Scenario not found." });
    }

    console.log("Transaction Scenario found:", scenario);

    // Fetch Service Request
    console.log("Fetching Service Request with ID:", service_request_id);

    const serviceRequest = await ServiceRequest.findOne({
      where: { requestID: service_request_id },
    });
    if (!serviceRequest) {
      console.log(`Service Request ID ${service_request_id} not found.`);
      return res.status(404).json({ message: "Service Request not found." });
    }

    console.log("Service Request found:", serviceRequest);

    // Extract outstanding amount from Accounts Receivable
    const amountDue = serviceRequest.remaining_balance;

    if (amount_paid > amountDue) {
      console.log(
        `Amount paid (${amount_paid}) exceeds the outstanding balance (${amountDue}).`
      );
      return res
        .status(400)
        .json({ message: "Amount paid exceeds the outstanding balance." });
    }

    // Fetch debit and credit accounts from the scenario
    const debitAccount = await OHADAAccount.findOne({
      where: { id: scenario.debit_account_id, tenant_id: tenantId },
    });
    const accountsReceivable = await OHADAAccount.findOne({
      where: { code: "4.1.1", tenant_id: tenantId },
    });

    if (!debitAccount || !accountsReceivable) {
      console.log("Debit or Accounts Receivable account not found.");
      return res.status(404).json({
        message: "Debit or Accounts Receivable account not found.",
      });
    }

    console.log("Debit account:", debitAccount);
    console.log("Accounts Receivable account:", accountsReceivable);

    // Log balances before updates
    console.log("Balances before updates:");
    console.log("Debit Account Balance:", debitAccount.balance);
    console.log("Accounts Receivable Balance:", accountsReceivable.balance);

    // Post the payment
    const formattedPaidAmount = parseFloat(amount_paid);
    const currentDebitAccountBalance = parseFloat(debitAccount.balance);
    const currentAccountsReceivablesBalance = parseFloat(
      accountsReceivable.balance
    );

    console.log(
      `Posting amount paid ${formattedPaidAmount} - Debit Account ID: ${debitAccount.id}, Accounts Receivable Account ID: ${accountsReceivable.id}`
    );

    await debitAccount.update(
      { balance: currentDebitAccountBalance + formattedPaidAmount },
      { transaction }
    );
    await accountsReceivable.update(
      { balance: currentAccountsReceivablesBalance - formattedPaidAmount },
      { transaction }
    );

    // Log balances after updates
    await debitAccount.reload();
    await accountsReceivable.reload();

    console.log("Balances after updates:");
    console.log("Debit Account Balance:", debitAccount.balance);
    console.log("Accounts Receivable Balance:", accountsReceivable.balance);

    // Create the payment transaction
    const newTransaction = await OHADATransaction.create(
      {
        reference_number: `PYM-${Date.now()}`,
        date: new Date(),
        description: `Payment transaction for ServiceRequest ID: ${service_request_id}. Prescripteur: ${serviceRequest.prescripteur}`,
        tenant_id: tenantId,
        status: "PENDING",
        requires_approval: scenario.requires_approval,
        approval_status: "APPROVED",
        amount: amount_paid,
        createdBy: userId,
        updatedBy: userId,
      },
      { transaction }
    );

    console.log("Payment Transaction created successfully:", newTransaction);

    // Update remaining balance in service request
    const newRemainingBalance = amountDue - formattedPaidAmount;
    await serviceRequest.update(
      { remaining_balance: newRemainingBalance },
      { transaction }
    );

    // Commit the transaction
    console.log("Committing transaction...");
    await transaction.commit();
    console.log("Transaction committed successfully.");

    res.status(201).json({
      transaction: newTransaction,
      serviceRequest: {
        requestID: serviceRequest.requestID,
        status: newRemainingBalance === 0 ? "PAID" : "PARTIALLY_PAID",
      },
    });
  } catch (error) {
    console.error("Error creating payment transaction:", error);
    if (transaction) await transaction.rollback();
    res.status(500).json({ message: "Error creating payment transaction." });
  }
};
