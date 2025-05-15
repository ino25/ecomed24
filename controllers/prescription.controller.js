const Prescriptions = require("../models/Prescriptions");
const BASEURL = process.env.SITE_URL;
exports.getList = async (req, res) => {
  try {
    let offsetdata = parseInt(
      req.query.offset
        ? req.query.offset == undefined || req.query.offset == 1
          ? 0
          : req.query.offset
        : 0
    );
    if (isNaN(offsetdata)) {
      offsetdata = 0;
    }
    let datalimit = parseInt(
      req.query.limit ? (req.query.limit == undefined ? 5 : req.query.limit) : 5
    );
    if (isNaN(datalimit)) {
      datalimit = 5;
    }
    const { count, rows } = await Prescriptions.findAndCountAll({});

    PrescriptionsModal = await Prescriptions.findAll({
      limit: datalimit,
      offset: offsetdata,
    });
    if (PrescriptionsModal === null) {
      res.json({ status: 0, message: langCommon.nodatafound });
    } else {
      res.json({
        status: 1,
        message: " Prescription list fetched successfully",
        data: PrescriptionsModal,
        total: count,
      });
    }
  } catch (error) {
    throw error;
  }
};
exports.getByID = async (req, res) => {
  try {
    let getData = [],
      results;
    PrescriptionsModal = await Prescriptions.findOne({id: req.params.id});
    if (PrescriptionsModal === null) {
      res.json({ status: 0, message: "Not found"});
    } else {
      res.json({
        status: 1,
        message: "Prescription fetched successfully",
        data: PrescriptionsModal,
        url: BASEURL + "/uploads/invoicefile/",
      });
    }
  } catch (error) {
    throw error;
  }
};
