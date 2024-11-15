const express = require("express");
const router = express.Router();
const VerifyToken = require("./VerifyToken");
const appointmentController = require("../controllers/appointment.controller");

// appointmentt
router.get("/", VerifyToken, appointmentController.getList);
router.get("/by-id/:id", appointmentController.getByID);
router.post("/add", VerifyToken, appointmentController.add);
router.post("/update/:id", VerifyToken, appointmentController.update);
router.delete("/delete/:id", VerifyToken, appointmentController.delete);
router.patch("/status/:id", VerifyToken, appointmentController.status);

module.exports = router;
