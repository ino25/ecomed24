const express = require("express");
const {
  createProduct,
  getAllProducts,
  getProductById,
  updateProduct,
  deleteProduct,
  createProductCategory,
  getAllProductCategories,
  updateProductCategory,
  deleteProductCategory,
} = require("../controllers/product.controller");

const router = express.Router();

/**
 * Product Routes
 */
// Route to create a new product
router.post("/create_product", createProduct);

// Route to get all products
router.get("/all_products", getAllProducts);

// Route to get a product by ID
router.get("/get_product/:id", getProductById);

// Route to update a product
router.put("/update_product/:id", updateProduct);

// Route to delete (soft delete) a product
router.delete("/remove_product/:id", deleteProduct);

/**
 * Product Category Routes
 */
// Route to create a new product category
router.post("/create_productCategory", createProductCategory);

// Route to get all product categories
router.get("/getProductCategories", getAllProductCategories);

// Route to update a product category
router.put("/getProductCategory/:id", updateProductCategory);

// Route to delete (soft delete) a product category
router.delete("/removeProductCategory/:id", deleteProductCategory);

module.exports = router;
