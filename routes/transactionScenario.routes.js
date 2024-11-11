// routes/transactionScenarioRoutes.js

const express = require("express");
const router = express.Router();
const {
  createScenario,
  getAllScenarios,
  updateScenario,
  deleteScenario,
  createScenarioFromTransaction,
} = require("../controllers/transactionScenario.controller");

// Create a new scenario
router.post("/create", createScenario);

// Get all scenarios
router.get("/getScenarios", getAllScenarios);

// Update a scenario
router.put("/update/:id", updateScenario);

// Delete a scenario
router.delete("/delete/:id", deleteScenario);

// create a scenario from a transaction
router.post("/createFromTransaction", createScenarioFromTransaction);

module.exports = router;
