const Prescriptions = require("../models/Prescriptions");
var User = require("../models/User");
var NewSales = require("../models/newSales");

NewSales.belongsTo(User, { as: "addedby_details", foreignKey: "added_by" });
NewSales.belongsTo(User, { as: "updatedby_details", foreignKey: "updated_by" });
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
    PrescriptionsModal = await Prescriptions.findOne({
      where: { id: req.params.prescription_id },
    });
    if (PrescriptionsModal === null) {
      res.json({ status: 0, message: "Not found" });
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

exports.storeSales = async (req, res) => {
  try {
    const {
      prescription_id,
      patient_id,
      products,
      total,
      payment_method,
      added_by,
    } = req.body;

    if (
      !prescription_id ||
      !products ||
      !Array.isArray(products) ||
      products.length === 0
    ) {
      return res.json({
        status: 0,
        message: "Prescription ID and products are required",
      });
    }

    const prescription = await Prescriptions.findOne({
      where: { id: prescription_id },
    });

    if (!prescription) {
      return res.json({
        status: 0,
        message: "Prescription not found",
      });
    }

    const salesData = products.map((product) => ({
      prescription_id: prescription_id,
      patient_id: patient_id || null,
      name: product.product || product.name,
      price: parseFloat(product.price) || 0,
      quantity: parseInt(product.quantity) || 0,
      subtotal: parseFloat(product.subtotal) || 0,
      total: parseFloat(total) || 0,
      payment_method: payment_method || "Cash",
      added_by: req.userId,
      updated_by: req.userId || null,
    }));

    const createdSales = await NewSales.bulkCreate(salesData, {
      returning: true,
    });

    await Prescriptions.update(
      { status: 2 },
      { where: { id: prescription_id } }
    );

    res.json({
      status: 1,
      message: "Sales stored successfully",
      data: {
        sales_count: createdSales.length,
        total_amount: total,
        prescription_id: prescription_id,
        sales_records: createdSales,
      },
    });
  } catch (error) {
    console.error("Error storing sales:", error);
    res.json({
      status: 0,
      message: "Failed to store sales data",
      error: error.message,
    });
  }
};
