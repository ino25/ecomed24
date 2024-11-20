const express = require("express");
const router = express.Router();
const VerifyToken = require("./VerifyToken");
const slotController = require("../controllers/slot.controller");

// Slots Manage Rutes
router.get("/", VerifyToken, slotController.getList);
router.get("/by-id/:id", slotController.getByID);
router.post("/add", VerifyToken, slotController.add);
router.post("/update/:id", VerifyToken, slotController.update);
router.delete("/delete/:id", VerifyToken, slotController.delete);
router.patch("/status/:id", VerifyToken, slotController.status);

module.exports = router;
