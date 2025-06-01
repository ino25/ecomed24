const PrescriptionSaleItem = require("../models/prescriptionSaleItems");
const Prescriptions = require("../models/Prescriptions");
var PrescriptionSale = require("../models/prescriptionSales");
var User = require("../models/User");
PrescriptionSale.belongsTo(User, { as: "addedby_details", foreignKey: "added_by" });
PrescriptionSale.belongsTo(User, { as: "updatedby_details", foreignKey: "updated_by" });

exports.AddPrescriptionSale = async (req, res) => {
  const transaction = await PrescriptionSale.sequelize.transaction();
  
  try {
    const {
      prescription_id,
      total,
      payment_method,
      added_by,
      items // Array of items with product_id, price, quantity, subtotal
    } = req.body;

    if (!prescription_id || !total || !payment_method || !items || items.length === 0) {
      return res.json({
        status: 0,
        message: "Missing required fields: prescription_id, total, payment_method, and items are required"
      });
    }

    const prescription = await Prescriptions.findByPk(prescription_id);
    if (!prescription) {
      return res.json({
        status: 0,
        message: "Prescription not found"
      });
    }
    const calculatedTotal = items.reduce((sum, item) => {
      return sum + (item.price * item.quantity);
    }, 0);

    if (Math.abs(calculatedTotal - total) > 0.01) {
      return res.json({
        status: 0,
        message: "Total amount mismatch with items calculation"
      });
    }

    // Create main sales record
    const saleData = {
      prescription_id: prescription_id,
      patient_id: prescription.patient_id || null,
      name: prescription.patient_name,
      phone: prescription.phone || null,
      total: total,
      payment_method: payment_method,
      type: 0, 
      status: 1,
      added_by:req.userId,
    };

    const createdSale = await PrescriptionSale.create(saleData, { transaction });

    // Create sales items
    const salesItems = items.map(item => ({
      prescription_sale_id: createdSale.id,
      product_id: item.product_id, 
      price: item.price,
      quantity: item.quantity,
      subtotal: item.subtotal,
      status: 1,
      added_by:req.userId,
    }));

    await PrescriptionSaleItem.bulkCreate(salesItems, { transaction });
    await Prescriptions.update(
      { 
        status: 2, // 2 = dispensed
        updated_by: added_by || null
      },
      { 
        where: { id: prescription_id },
        transaction 
      }
    );

    await transaction.commit();

    res.json({
      status: 1,
      message: "Sale created successfully",
      data:salesItems,
      // data: {
      //   sale_id: createdSale.id,
      //   prescription_id: prescription_id,
      //   total: total,
      //   payment_method: payment_method,
      //   items_count: items.length,
      //   created_at: createdSale.createdAt
      // }
    });

  } catch (error) {
    await transaction.rollback();
    console.error("Error creating sale:", error);
    res.json({
      status: 0,
      message: "Error creating sale: " + error.message
    });
  }
};

exports.getSaleById = async (req, res) => {
  try {
    const saleId = req.params.sale_id;
    
    const sale = await PrescriptionSale.findOne({
      where: { id: saleId },
      include: [
        {
          model: PrescriptionSaleItem,
          as: 'items' 
        }
      ]
    });

    if (!sale) {
      return res.json({
        status: 0,
        message: "Sale not found"
      });
    }

    res.json({
      status: 1,
      message: "Sale fetched successfully",
      data: sale
    });

  } catch (error) {
    console.error("Error fetching sale:", error);
    res.json({
      status: 0,
      message: "Error fetching sale: " + error.message
    });
  }
};

exports.getSalesList = async (req, res) => {
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
      req.query.limit ? (req.query.limit == undefined ? 10 : req.query.limit) : 10
    );
    if (isNaN(datalimit)) {
      datalimit = 10;
    }

    const { count, rows } = await PrescriptionSale.findAndCountAll({
      include: [
        {
          model: PrescriptionSaleItem,
          as: 'items' // You may need to define this association in your models
        }
      ],
      limit: datalimit,
      offset: offsetdata,
      order: [['createdAt', 'DESC']] // Changed from created_at since timestamps are enabled
    });

    res.json({
      status: 1,
      message: "Sales list fetched successfully",
      data: rows,
      total: count
    });

  } catch (error) {
    console.error("Error fetching sales list:", error);
    res.json({
      status: 0,
      message: "Error fetching sales list: " + error.message
    });
  }
};

exports.getSaleByPrescriptionId = async (req, res) => {
  try {
    const prescriptionId = req.params.prescription_id;
    console.log("Looking for prescription_id:", prescriptionId); 
    const sales = await PrescriptionSale.findAll({
      where: { prescription_id: prescriptionId },
      include: [
        {
          model: PrescriptionSaleItem,
          as: 'items'
        },
        {
          model: Prescriptions,
          as: 'prescription',
          attributes: ['id', 'patient_name', 'status']
        }
      ],
      order: [['createdAt', 'DESC']]
    });

    if (!sales || sales.length === 0) {
      return res.json({
        status: 0,
        message: "No sales found for this prescription"
      });
    }

    res.json({
      status: 1,
      message: "Sales fetched successfully",
      data: sales,
      total: sales.length
    });

  } catch (error) {
    console.error("Error fetching sales by prescription ID:", error);
    res.json({
      status: 0,
      message: "Error fetching sales: " + error.message
    });
  }
};


// // Update Sale Status

// exports.updateSaleStatus = async (req, res) => {
//   try {
//     const saleId = req.params.sale_id;
//     const { status, updated_by } = req.body;

//     if (!saleId || !status) {
//       return res.json({
//         status: 0,
//         message: "Sale ID and status are required"
//       });
//     }

//     const sale = await PrescriptionSale.findByPk(saleId);
//     if (!sale) {
//       return res.json({
//         status: 0,
//         message: "Sale not found"
//       });
//     }

//     await PrescriptionSale.update(
//       { 
//         status: parseInt(status),
//         updated_by: updated_by || null
//       },
//       { 
//         where: { id: saleId }
//       }
//     );

//     res.json({
//       status: 1,
//       message: "Sale status updated successfully"
//     });

//   } catch (error) {
//     console.error("Error updating sale status:", error);
//     res.json({
//       status: 0,
//       message: "Error updating sale status: " + error.message
//     });
//   }
// };

// // Get Sales Summary/Statistics
// exports.getSalesSummary = async (req, res) => {
//   try {
//     const { start_date, end_date } = req.query;
    
//     let whereClause = {};
//     if (start_date && end_date) {
//       whereClause.createdAt = {
//         [Op.between]: [start_date, end_date]
//       };
//     }

//     const summary = await PrescriptionSale.findAll({
//       where: whereClause,
//       attributes: [
//         [sequelize.fn('COUNT', sequelize.col('id')), 'total_sales'],
//         [sequelize.fn('SUM', sequelize.col('total')), 'total_revenue'],
//         [sequelize.fn('AVG', sequelize.col('total')), 'average_sale'],
//         'payment_method'
//       ],
//       group: ['payment_method']
//     });

//     const totalStats = await PrescriptionSale.findAll({
//       where: whereClause,
//       attributes: [
//         [sequelize.fn('COUNT', sequelize.col('id')), 'total_sales'],
//         [sequelize.fn('SUM', sequelize.col('total')), 'total_revenue'],
//         [sequelize.fn('AVG', sequelize.col('total')), 'average_sale']
//       ]
//     });

//     res.json({
//       status: 1,
//       message: "Sales summary fetched successfully",
//       data: {
//         overall: totalStats[0],
//         by_payment_method: summary
//       }
//     });

//   } catch (error) {
//     console.error("Error fetching sales summary:", error);
//     res.json({
//       status: 0,
//       message: "Error fetching sales summary: " + error.message
//     });
//   }
// };