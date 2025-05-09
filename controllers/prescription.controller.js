// const  Prescriptions  = require("../models/Prescriptions"); // adjust path as per your setup
// const PrescribedMedicins =require("../models/PrescribedMedicins");
// // GET: Fetch All Prescriptions

// exports.getAllPrescriptions = async (req, res) => {
//   try {
//     const prescriptions = await Prescriptions.findAll({
//       include: [
//         {
//           model: PrescribedMedicins,
//           as: "medicins",
//         },
//       ],
//       order: [["createdAt", "DESC"]],
//     });

//     return res.status(200).json({
//       status: 1,
//       message: "All prescriptions fetched successfully",
//       data: prescriptions,
//     });
//   } catch (error) {
//     console.error("Error fetching prescriptions:", error);
//     return res.status(500).json({
//       status: 0,
//       message: "Failed to fetch prescriptions",
//       error: error.message,
//     });
//   }
// };

const Prescriptions = require("../models/Prescriptions");
const PrescribedMedicins = require("../models/PrescribedMedicins");

// Export all controller functions
exports.getAllPrescriptions = async (req, res) => {
  try {
    const prescriptions = await Prescriptions.findAll({
      include: [
        {
          model: PrescribedMedicins,
          as: "medicins",
        },
      ],
      order: [["createdAt", "DESC"]],
    });

    return res.status(200).json({
      status: 1,
      message: "All prescriptions fetched successfully",
      data: prescriptions,
    });
  } catch (error) {
    console.error("Error fetching prescriptions:", error);
    return res.status(500).json({
      status: 0,
      message: "Failed to fetch prescriptions",
      error: error.message,
    });
  }
};

// Add other controller functions as needed