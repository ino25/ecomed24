// controllers/moduleController.js

const Module = require("../models/Module"); // Import the Module model
const HelpTopic = require("../models/HelpTopic");
const { Op } = require("sequelize"); // Import Sequelize operators for query conditions

Module.hasMany(HelpTopic, {
  foreignKey: "moduleId",
  as: "helpTopics",
});

// Get all modules where code is not empty
exports.getModules = async (req, res) => {
  try {
    const modules = await Module.findAll({
      where: {
        code: {
          [Op.ne]: "", // Op.ne means "not equal to"
        },
      },
    });
    res.json(modules);
  } catch (error) {
    console.error("Error retrieving modules:", error);
    res.status(500).send("Error retrieving modules");
  }
};

exports.getAllModulesWithTopics = async (req, res) => {
  try {
    // Fetch all modules and include associated help topics
    const modules = await Module.findAll({
      include: {
        model: HelpTopic,
        as: "helpTopics", // Ensure the alias matches your model association
      },
    });
    res.json(modules);
  } catch (error) {
    console.error("Error retrieving modules with topics:", error);
    res.status(500).send("Error retrieving modules with topics");
  }
};
// Get a module by ID
exports.getModuleById = async (req, res) => {
  try {
    const module = await Module.findByPk(req.params.id);
    if (module) {
      res.json(module);
    } else {
      res.status(404).send("Module not found");
    }
  } catch (error) {
    console.error("Error retrieving module by ID:", error);
    res.status(500).send("Error retrieving module");
  }
};

// Add a new module
exports.addModule = async (req, res) => {
  try {
    const { name, description, status, added_by, updated_by, code } = req.body;
    const module = await Module.create({
      name,
      description,
      status,
      added_by,
      updated_by,
      code,
    });
    res.json(module);
  } catch (error) {
    console.error("Error adding module:", error); // Log the full error
    res.status(500).send("Error adding module");
  }
};

// Update an existing module by ID
exports.updateModule = async (req, res) => {
  try {
    const module = await Module.findByPk(req.params.id);
    if (module) {
      await module.update(req.body);
      res.json(module);
    } else {
      res.status(404).send("Module not found");
    }
  } catch (error) {
    console.error("Error updating module:", error);
    res.status(500).send("Error updating module");
  }
};

// Delete a module by ID
exports.deleteModule = async (req, res) => {
  try {
    const module = await Module.findByPk(req.params.id);
    if (module) {
      await module.destroy();
      res.send("Module deleted");
    } else {
      res.status(404).send("Module not found");
    }
  } catch (error) {
    console.error("Error deleting module:", error);
    res.status(500).send("Error deleting module");
  }
};
