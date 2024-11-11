// controllers/transactionScenarioController.js

const OHADATransaction = require("../models/OHADATransaction");
const OHADATransactionLine = require("../models/OHADATransactionLine");
const OHADAAccount = require("../models/OHADAAccount");
const TransactionScenario = require("../models/TransactionScenario");

OHADAAccount.hasMany(TransactionScenario, {
  foreignKey: "debit_account_id",
  as: "debitScenarios",
});

OHADAAccount.hasMany(TransactionScenario, {
  foreignKey: "credit_account_id",
  as: "creditScenarios",
});

// Create Transaction Scenario
exports.createScenario = async (req, res) => {
  // Logging request payload
  console.log("Received request payload:", req.body);

  // Validation: No duplicate accounts for the tenant
  const tenantId = parseInt(req.headers["x-tenant-id"], 10);
  if (!tenantId) {
    console.log("Tenant ID is missing.");
    return res.status(400).json({ message: "Tenant ID is required." });
  }

  console.log("****** Tenant ID*******:", tenantId);

  try {
    const scenario = await TransactionScenario.create({
      ...req.body,
      createdBy: req.headers["x-user-id"],
      updatedBy: req.headers["x-user-id"],
    });

    res.status(201).json(scenario);
  } catch (error) {
    console.error("Error creating transaction scenario:", error);
    res.status(500).json({ error: "Failed to create transaction scenario" });
  }
};

// Create a new transaction based on a scenario
exports.createTransactionFromScenario = async (req, res) => {
  try {
    console.log("Starting createTransactionFromScenario...");

    const { scenario_id, reference_number, date, description, amount } =
      req.body;
    const tenantId = parseInt(req.headers["x-tenant-id"], 10);

    if (!tenantId) {
      console.log("Tenant ID is missing.");
      return res.status(400).json({ message: "Tenant ID is required." });
    }

    console.log("Tenant ID:", tenantId);

    // Validate amount
    if (!amount || amount <= 0) {
      console.log("Invalid or missing amount.");
      return res.status(400).json({ message: "Valid amount is required." });
    }

    // Find the scenario by ID
    const scenario = await TransactionScenario.findOne({
      where: { id: scenario_id },
    });

    if (!scenario) {
      console.log(`Transaction Scenario ID ${scenario_id} not found.`);
      return res
        .status(404)
        .json({ message: "Transaction Scenario not found." });
    }

    console.log("Transaction Scenario found:", scenario);

    // Create the transaction based on the scenario
    const approvalStatus = scenario.requires_approval ? "PENDING" : "APPROVED";

    const newTransaction = await OHADATransaction.create(
      {
        reference_number,
        date,
        description,
        tenant_id: tenantId,
        status: "PENDING", // Assuming transactions start with a status of PENDING
        requires_approval: scenario.requires_approval,
        approval_status: approvalStatus,
        createdBy: req.user.id,
        updatedBy: req.user.id,
        transactionLines: [
          {
            type: "DEBIT",
            account_id: scenario.debit_account_id,
            amount: amount,
          },
          {
            type: "CREDIT",
            account_id: scenario.credit_account_id,
            amount: amount,
          },
        ],
      },
      {
        include: ["transactionLines"],
      }
    );

    console.log("Transaction created successfully:", newTransaction);
    res.status(201).json(newTransaction);
  } catch (error) {
    console.error("Error creating transaction from scenario:", error);
    res
      .status(500)
      .json({ message: "Error creating transaction from scenario." });
  }
};

// Create a Transaction Scenario based on an existing Transaction
// Create a Transaction Scenario based on an existing Transaction
exports.createScenarioFromTransaction = async (req, res) => {
  try {
    console.log("Starting createScenarioFromTransaction...");

    const { name, description, requires_approval, approval_conditions } =
      req.body;
    const tenantId = parseInt(req.headers["x-tenant-id"], 10);
    console.log("Tenant ID:", tenantId);

    const userId = req.headers["x-user-id"];
    const transactionId = req.headers["x-transaction-id"];

    console.log("Request Headers: ", { transactionId, tenantId, userId });
    console.log("Request Body: ", {
      name,
      description,
      requires_approval,
      approval_conditions,
    });

    // Validate request parameters
    if (!tenantId) {
      console.log("Tenant ID is required.");
      return res.status(400).json({ message: "Tenant ID is required." });
    }

    if (!transactionId) {
      console.log("Transaction ID is required.");
      return res.status(400).json({ message: "Transaction ID is required." });
    }

    if (!name) {
      console.log("Scenario name is required.");
      return res.status(400).json({ message: "Scenario name is required." });
    }

    // Fetch the transaction
    console.log("Fetching transaction with ID:", transactionId);
    const transaction = await OHADATransaction.findOne({
      where: { id: transactionId, tenant_id: tenantId },
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
      console.log(
        `Transaction not found for ID: ${transactionId} and Tenant ID: ${tenantId}`
      );
      return res.status(404).json({ message: "Transaction not found." });
    }

    console.log(
      "Transaction fetched successfully:",
      JSON.stringify(transaction, null, 2)
    );

    // Extract debit and credit account information from transaction lines
    console.log("Extracting DEBIT and CREDIT lines from transaction...");
    const debitLine = transaction.transactionLines.find(
      (line) => line.type === "DEBIT"
    );
    const creditLine = transaction.transactionLines.find(
      (line) => line.type === "CREDIT"
    );

    if (!debitLine || !creditLine) {
      console.log("Transaction does not have both DEBIT and CREDIT lines.");
      return res.status(400).json({
        message: "Transaction must have both DEBIT and CREDIT lines.",
      });
    }

    console.log("Debit line found:", debitLine);
    console.log("Credit line found:", creditLine);

    // Prepare scenario data
    const scenarioData = {
      name,
      description,
      debit_account_id: debitLine.account_id,
      credit_account_id: creditLine.account_id,
      requires_approval: requires_approval || false,
      approval_conditions: requires_approval ? approval_conditions : null,
      tenant_id: tenantId,
      createdBy: userId,
      updatedBy: userId,
    };

    console.log(
      "Creating scenario with data:",
      JSON.stringify(scenarioData, null, 2)
    );

    // Create the scenario
    const scenario = await TransactionScenario.create(scenarioData);

    console.log(
      "Scenario created successfully:",
      JSON.stringify(scenario, null, 2)
    );

    res.status(201).json(scenario);
  } catch (error) {
    console.error("Error creating scenario from transaction:", error);
    res
      .status(500)
      .json({ message: "Failed to create scenario from transaction." });
  }
};

// Get All Scenarios
exports.getAllScenarios = async (req, res) => {
  try {
    const scenarios = await TransactionScenario.findAll();
    res.status(200).json(scenarios);
  } catch (error) {
    console.error("Error fetching transaction scenarios:", error);
    res.status(500).json({ error: "Failed to fetch transaction scenarios" });
  }
};

// Update Transaction Scenario
exports.updateScenario = async (req, res) => {
  try {
    const { id } = req.params;
    await TransactionScenario.update(
      { ...req.body, updatedBy: req.user.id },
      { where: { id } }
    );
    res
      .status(200)
      .json({ message: "Transaction scenario updated successfully" });
  } catch (error) {
    console.error("Error updating transaction scenario:", error);
    res.status(500).json({ error: "Failed to update transaction scenario" });
  }
};

// Delete Transaction Scenario
exports.deleteScenario = async (req, res) => {
  try {
    const { id } = req.params;
    await TransactionScenario.destroy({ where: { id } });
    res
      .status(200)
      .json({ message: "Transaction scenario deleted successfully" });
  } catch (error) {
    console.error("Error deleting transaction scenario:", error);
    res.status(500).json({ error: "Failed to delete transaction scenario" });
  }
};
