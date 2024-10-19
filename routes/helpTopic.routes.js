const express = require("express");
const {
  getAllHelpTopics,
  getTenantHelpTopics,
  getHelpTopicById,
  addHelpTopic,
  updateHelpTopic,
  deleteHelpTopic,
} = require("../controllers/helpTopic.controller");

const router = express.Router();

// Route for getting tenant-specific help topics (without filtering by tenantId)
router.get("/orgTopics", getTenantHelpTopics);

//Route to get all help topics
router.get("/topics", getAllHelpTopics);

// Route to get a help topic by ID
router.get("/getTopic/:id", getHelpTopicById);

// Route to add a new help topic
router.post("/addTopic", addHelpTopic);

// Route to update an existing help topic by ID
router.put("/updateTopic/:id", updateHelpTopic);

// Route to delete a help topic by ID
router.delete("/deleteTopic/:id", deleteHelpTopic);

module.exports = router;
