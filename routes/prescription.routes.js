
// const express = require("express");
// const PrescriptionController = require("../controllers/prescription.controller");
// const router = express.Router();

// // Use the specific function from the controller, not the entire controller object
// router.get("/prescriptions", PrescriptionController.getAllPrescriptions);

// module.exports = router;

const express = require("express");
const PrescriptionController = require("../controllers/prescription.controller");
const router = express.Router();

// Use the root path since the router is already mounted at /prescriptions in app.js
router.get("/", PrescriptionController.getAllPrescriptions);

module.exports = router;