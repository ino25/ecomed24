const express = require("express");
const router = express.Router();
const VerifyToken = require("./VerifyToken");
const rolesController = require("../controllers/roles.controller");

// Roles
router.get("/", VerifyToken, rolesController.getList);
router.get("/by-id/:id", rolesController.getByID);
router.post("/add", VerifyToken, rolesController.add);
router.post("/update/:id", VerifyToken, rolesController.update);
router.delete("/delete/:id", VerifyToken, rolesController.delete);
router.patch("/status/:id", VerifyToken, rolesController.status);

module.exports = router;
