// controllers/paymentMethod.controller.js

const PaymentMethod = require("../models/PaymentMethod");
console.log("PaymentMethod Model:", PaymentMethod);

// Get all payment methods
exports.getPaymentMethods = async (req, res) => {
  console.log("Received request to fetch payment methods.");

  try {
    // Retrieve all payment methods from the database
    const paymentMethods = await PaymentMethod.findAll({
      attributes: ["id", "methodType", "code", "providerName"],
    });

    console.log("Payment methods fetched successfully:", paymentMethods);

    // Return the list of payment methods
    res.status(200).json(paymentMethods);
  } catch (error) {
    console.error("Error fetching payment methods:", error);
    res
      .status(500)
      .json({ error: "An error occurred while retrieving payment methods" });
  }
};
