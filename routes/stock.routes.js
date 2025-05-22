const express = require("express");
const router = express.Router();
const VerifyToken = require("./VerifyToken");
const stockController = require("../controllers/stock.controller");

const multer = require("multer");
const storage = multer.memoryStorage();
const upload = multer({ storage });

router.get("/", VerifyToken, stockController.getList);
router.post("/", VerifyToken, stockController.add);
router.get('/by-id/:id', VerifyToken, stockController.getById);
router.post("/bulk-add", VerifyToken, upload.single("file"), stockController.bulkAdd);
router.patch("/adjust/:id", VerifyToken, stockController.adjustStock);




module.exports = router;
