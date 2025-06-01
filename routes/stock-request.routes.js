const express = require("express");
const router = express.Router();
const VerifyToken = require("./VerifyToken");
const stockrequestController = require("../controllers/stock-request.controller");

// Stock Request
router.get("/", VerifyToken, stockrequestController.getList);
router.get("/my-request", VerifyToken, stockrequestController.getMyList);
router.get("/by-id/:id", stockrequestController.getByID);
router.post("/add", VerifyToken, stockrequestController.add);
router.post("/update/:id", VerifyToken, stockrequestController.update);
router.delete("/delete/:id", VerifyToken, stockrequestController.delete);
router.patch("/status/:id", VerifyToken, stockrequestController.status);

module.exports = router;
