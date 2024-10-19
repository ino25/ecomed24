const HelpTopic = require("../models/HelpTopic");
const Module = require("../models/Module");

HelpTopic.belongsTo(Module, {
  foreignKey: "moduleId",
  as: "module", // Alias for the association
});

exports.getModuleHelpTopics = async (req, res) => {
  try {
    const moduleWithTopics = await Module.findByPk(req.params.moduleId, {
      include: [
        {
          model: HelpTopic,
          as: "helpTopics",
        },
      ],
    });
    res.json(moduleWithTopics);
  } catch (error) {
    console.error("Error retrieving module help topics:", error);
    res.status(500).send("Error retrieving help topics for this module");
  }
};

// Get all help topics
exports.getAllHelpTopics = async (req, res) => {
  try {
    // Find all help topics and include their associated modules
    const helpTopics = await HelpTopic.findAll({
      include: {
        model: Module,
        as: "module", // This alias should match the one used in your association
      },
    });
    res.json(helpTopics);
  } catch (error) {
    console.error("Error retrieving help topics:", error.message);
    res.status(500).send("Error retrieving help topics");
  }
};

exports.getHelpTopicById = async (req, res) => {
  try {
    const helpTopic = await HelpTopic.findByPk(req.params.id, {
      include: [
        {
          model: Module,
          as: "module",
        },
      ],
    });
    if (helpTopic) {
      res.json(helpTopic);
    } else {
      res.status(404).send("Help Topic not found");
    }
  } catch (error) {
    res.status(500).send("Error retrieving help topic");
  }
};

exports.getTenantHelpTopics = async (req, res) => {
  try {
    // Fetch help topics without filtering by tenantId
    const helpTopics = await HelpTopic.findAll({
      attributes: ["id", "category", "name", "helpText", "tags"], // Select only the relevant fields
    });

    // Return the filtered help topics
    res.json(helpTopics);
  } catch (error) {
    console.error("Error retrieving tenant help topics:", error);
    res.status(500).send("Error retrieving help topics");
  }
};

/// Add a new help topic
// Add a new help topic
exports.addHelpTopic = async (req, res) => {
  try {
    // Destructure the request body and set default author to 'Admin'
    const {
      category,
      name,
      helpText,
      tags,
      moduleId, // This should be captured from the request body
      references,
      author = "Admin",
    } = req.body;

    // Check if moduleId is provided
    if (!moduleId) {
      return res.status(400).send("moduleId is required");
    }

    // Create the new help topic
    const helpTopic = await HelpTopic.create({
      category,
      name,
      helpText,
      tags,
      moduleId, // Make sure moduleId is passed here
      references,
      author,
    });

    // Return the created help topic
    res.json(helpTopic);
  } catch (error) {
    console.error("Error adding help topic:", error); // Log the full error
    res.status(500).send("Error adding help topic");
  }
};

// Update an existing help topic by ID
exports.updateHelpTopic = async (req, res) => {
  try {
    const helpTopic = await HelpTopic.findByPk(req.params.id);
    if (helpTopic) {
      await helpTopic.update(req.body);
      res.json(helpTopic);
    } else {
      res.status(404).send("Help Topic not found");
    }
  } catch (error) {
    res.status(500).send("Error updating help topic");
  }
};

// Delete a help topic by ID
exports.deleteHelpTopic = async (req, res) => {
  try {
    const helpTopic = await HelpTopic.findByPk(req.params.id);
    if (helpTopic) {
      await helpTopic.destroy();
      res.send("Help Topic deleted");
    } else {
      res.status(404).send("Help Topic not found");
    }
  } catch (error) {
    res.status(500).send("Error deleting help topic");
  }
};
