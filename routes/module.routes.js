// routes/moduleRoutes.js

const express = require("express");
const {
  getModules,
  getModuleById,
  addModule,
  updateModule,
  deleteModule,
  getAllModulesWithTopics,
} = require("../controllers/moduleController");

const router = express.Router();

// Route to get all modules where code is not empty
router.get("/all", getModules);

router.get("/modulesWithTopics", getAllModulesWithTopics);

// Route to get a module by ID
router.get("/:id", getModuleById);

// Route to add a new module
router.post("/add", addModule);

// Route to update an existing module by ID
router.put("/:id", updateModule);

// Route to delete a module by ID
router.delete("/:id", deleteModule);

module.exports = router;
