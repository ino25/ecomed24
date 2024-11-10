const express = require("express");
const {
  getAllDrugs,
  getDrugById,
  addDrug,
  updateDrug,
  deleteDrug,
  setDrugStatus,
  bulkUploadDrugs,
  getDrugInfo,
  updateDrugInfo,
  requestDrugListing,
  checkAndFetchDrugInfo,
} = require("../controllers/drugController");

const router = express.Router();

router.get("/getAllDrugs", getAllDrugs);
router.get("/:id", getDrugById);
router.post("/", addDrug);
router.put("/:id", updateDrug);
router.delete("/:id", deleteDrug);
router.patch("/:id/status", setDrugStatus);
router.post("/bulk-upload", bulkUploadDrugs);
router.get("/:id/info", getDrugInfo);
router.put("/:id/info", updateDrugInfo);
router.post("/request", requestDrugListing);
router.post("/check-and-fetch-info", checkAndFetchDrugInfo);

module.exports = router;
