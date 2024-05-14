const express = require("express");
const router = express.Router();
const VerifyToken = require("./VerifyToken");
const permissionsController = require("../controllers/permissions.controller");

// Roles
router.get("/", VerifyToken, permissionsController.getList);
router.get("/by-id/:id", VerifyToken, permissionsController.getByID);
router.post("/add", VerifyToken, permissionsController.add);
router.post("/update/:id", VerifyToken, permissionsController.update);
router.delete("/delete/:id", VerifyToken, permissionsController.delete);
router.patch("/status/:id", VerifyToken, permissionsController.status);

router.get(
  "/get-system-permissions",
  VerifyToken,
  permissionsController.getSystemPermissions
);
router.post(
  "/org/add",
  VerifyToken,
  permissionsController.AllowPermissionToOrg
);

module.exports = router;
