const express = require("express");
const router = express.Router();
const VerifyToken = require('./VerifyToken');
const permissionsController = require("../controllers/permissions.controller");


// Roles
router.get('/',VerifyToken, permissionsController.getList);
router.get('/get-role-byid/:id',VerifyToken, permissionsController.getByID);
router.post('/add',VerifyToken, permissionsController.add);
router.post('/update/:id',VerifyToken, permissionsController.update);
router.delete('/delete/:id',VerifyToken, permissionsController.delete);
router.patch('/status/:id',VerifyToken, permissionsController.status);


router.post('/org/add',VerifyToken, permissionsController.AllowPermissionToOrg);

module.exports = router;
