const express = require("express");
const router = express.Router();
const VerifyToken = require("./VerifyToken");
const labController = require("../controllers/lab.controller");
const multer = require('multer');

// Configure multer storage
const storage = multer.diskStorage({
  destination: function (req, file, cb) {
    cb(null, 'uploads/'); // Assurez-vous que ce répertoire existe
  },
  filename: function (req, file, cb) {
    cb(null, file.fieldname + '-' + Date.now());
  }
});

const upload = multer({ storage: storage });

router.get("/labs", VerifyToken, labController.getAllLabs);
router.post("/listactes", VerifyToken, labController.getActeDemande);
router.post("/statistiques", VerifyToken, labController.getStats);
router.post("/resultats", VerifyToken, labController.LabData);
router.post("/reprendre", VerifyToken, labController.Reprendre);
router.post("/validation", VerifyToken, labController.Validation);
router.post("/resultatbyid", VerifyToken, labController.getResultatById);
router.get("/user/:id", VerifyToken, labController.getUserById);
router.post(
  "/save-pdf",
  upload.single("pdfData"),
  VerifyToken,
  labController.savePDF
);
router.post("/envoyer-pdf", VerifyToken, labController.envoiPdf);

module.exports = router;
