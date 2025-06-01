const express = require("express");
const {
  getAllDrugs,
  getDrugById,
  addDrug,
  updateDrug,
  deleteDrug,
  setDrugStatus,
  getDrugInfo,
  updateDrugInfo,
  requestDrugListing,
  checkAndFetchDrugInfo,
  bulkUploadDrugs,
} = require("../controllers/drugController");

const router = express.Router();

router.get("/getAllDrugs", getAllDrugs);
router.get("get/:id", getDrugById);
router.post("add/", addDrug);
router.put("update/:id", updateDrug);
router.delete("delete/:id", deleteDrug);
router.patch("/:id/status", setDrugStatus);
router.post("/upload", bulkUploadDrugs);
router.get("/:id/info", getDrugInfo);
router.put("/:id/updateInfo", updateDrugInfo);
router.post("/request", requestDrugListing);
router.post("/check-and-fetch-info", checkAndFetchDrugInfo);


module.exports = router;
