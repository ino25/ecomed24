const express = require("express");
const router = express.Router();
const VerifyToken = require("./VerifyToken");
const permissionsController = require("../controllers/permissions.controller");

// System Permissions
router.get("/", VerifyToken, permissionsController.getList);
router.get("/by-id/:id", VerifyToken, permissionsController.getByID);
router.post("/add", VerifyToken, permissionsController.add);
router.post("/update/:id", VerifyToken, permissionsController.update);
router.delete("/delete/:id", VerifyToken, permissionsController.delete);
router.patch("/status/:id", VerifyToken, permissionsController.status);
router.get(
  "/get-modules-list",
  VerifyToken,
  permissionsController.getModulesList
);

router.get(
  "/get-system-permissions",
  VerifyToken,
  permissionsController.getSystemPermissions
);

router.post(
  "/organization/add",
  VerifyToken,
  permissionsController.AllowPermissionToOrg
);

router.get(
  "/organization/list",
  VerifyToken,
  permissionsController.getOrgAssignedList
);
router.get(
  "/organization/by-id/:id",
  VerifyToken,
  permissionsController.getOrgPermissionByID
);
router.post(
  "/organization/update/:id",
  VerifyToken,
  permissionsController.OrgPermissionUpdate
);
router.delete(
  "/organization/delete/:id",
  VerifyToken,
  permissionsController.OrgPermissionDelete
);
router.patch(
  "/organization/status/:id",
  VerifyToken,
  permissionsController.OrgPermissionStatus
);

module.exports = router;
