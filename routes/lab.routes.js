const express = require("express");
const router = express.Router();
const VerifyToken = require('./VerifyToken');
const labController = require("../controllers/lab.controller");

const support = require('../multer/pdf')



router.get("/labs",VerifyToken, labController.getAllLabs);
router.post("/listactes",VerifyToken, labController.getActeDemande);
router.post("/statistiques",VerifyToken, labController.getStats);
router.post("/resultats",VerifyToken, labController.LabData);
router.post("/reprendre",VerifyToken, labController.Reprendre);
router.post("/validation",VerifyToken, labController.Validation);
router.post("/resultatbyid",VerifyToken, labController.getResultatById);
router.get("/user/:id",VerifyToken, labController.getUserById);
router.post("/save-pdf",VerifyToken, labController.savePDF);
router.post("/envoyer-pdf",VerifyToken, labController.envoiPdf);
module.exports = router;
