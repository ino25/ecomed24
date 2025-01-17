const sequelize = require("../config").sequelize;
const Product = require("../models/Product");
const ProductCategory = require("../models/ProductCategory");
const ProductInstance = require("../models/ProductInstance");

// ProductCategory -> Product
//ProductCategory.hasMany(Product, { foreignKey: "categoryId" });
ProductCategory.hasMany(Product, {
  foreignKey: "categoryId", // Ensure this matches the column in Product
  as: "products", // Alias for reverse association
});

//Product.belongsTo(ProductCategory, { foreignKey: "categoryId" });
Product.belongsTo(ProductCategory, {
  foreignKey: "categoryId", // Ensure this matches the column in Product
  as: "productCategory", // Alias for this association
});

// Product -> ProductInstance
Product.hasMany(ProductInstance, { foreignKey: "productId" });
ProductInstance.belongsTo(Product, { foreignKey: "productId" });

/**
 * Product CRUD
 */

// Create a new Product
exports.createProduct = async (req, res) => {
  try {
    const { name, categoryId, status } = req.body;
    const product = await Product.create({ name, categoryId, status });
    res.status(201).json(product);
  } catch (error) {
    console.error("Error creating product:", error);
    res.status(500).send("Error creating product");
  }
};

/**
 * Get all products
 */
exports.getAllProducts = async (req, res) => {
  try {
    const { type } = req.query;

    // If a type is specified, filter by type
    const filter = type ? { type } : {};

    const products = await Product.findAll({
      where: filter,
      include: [{ model: ProductCategory, as: "productCategory" }],
    });
    res.status(200).json(products);
  } catch (error) {
    console.error("Error fetching products:", error);
    res.status(500).send("Erreur lors de la récupération des produits.");
  }
};

// Read a Product by ID
exports.getProductById = async (req, res) => {
  try {
    const product = await Product.findByPk(req.params.id, {
      include: [{ model: ProductCategory, as: "category" }],
    });
    if (product) {
      res.status(200).json(product);
    } else {
      res.status(404).send("Product not found");
    }
  } catch (error) {
    console.error("Error fetching product:", error);
    res.status(500).send("Error fetching product");
  }
};

// Update a Product
exports.updateProduct = async (req, res) => {
  try {
    const product = await Product.findByPk(req.params.id);
    if (product) {
      await product.update(req.body);
      res.status(200).json(product);
    } else {
      res.status(404).send("Product not found");
    }
  } catch (error) {
    console.error("Error updating product:", error);
    res.status(500).send("Error updating product");
  }
};

// Delete a Product (soft delete)
exports.deleteProduct = async (req, res) => {
  try {
    const product = await Product.findByPk(req.params.id);
    if (product) {
      await product.update({ status: "deleted" }); // Soft delete
      res.status(200).send("Product deleted");
    } else {
      res.status(404).send("Product not found");
    }
  } catch (error) {
    console.error("Error deleting product:", error);
    res.status(500).send("Error deleting product");
  }
};

/**
 * ProductCategory CRUD
 */

// Create a new Product Category
exports.createProductCategory = async (req, res) => {
  try {
    const { name, status } = req.body;
    const category = await ProductCategory.create({ name, status });
    res.status(201).json(category);
  } catch (error) {
    console.error("Error creating category:", error);
    res.status(500).send("Error creating category");
  }
};

// Read all Product Categories
exports.getAllProductCategories = async (req, res) => {
  try {
    const categories = await ProductCategory.findAll();
    res.status(200).json(categories);
  } catch (error) {
    console.error("Error fetching categories:", error);
    res.status(500).send("Error fetching categories");
  }
};

// Update a Product Category
exports.updateProductCategory = async (req, res) => {
  try {
    const category = await ProductCategory.findByPk(req.params.id);
    if (category) {
      await category.update(req.body);
      res.status(200).json(category);
    } else {
      res.status(404).send("Category not found");
    }
  } catch (error) {
    console.error("Error updating category:", error);
    res.status(500).send("Error updating category");
  }
};

// Delete a Product Category (soft delete)
exports.deleteProductCategory = async (req, res) => {
  try {
    const category = await ProductCategory.findByPk(req.params.id);
    if (category) {
      await category.update({ status: "deleted" }); // Soft delete
      res.status(200).send("Category deleted");
    } else {
      res.status(404).send("Category not found");
    }
  } catch (error) {
    console.error("Error deleting category:", error);
    res.status(500).send("Error deleting category");
  }
};
