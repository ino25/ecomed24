const { DataTypes } = require("sequelize");
const sequelize = require("../config").sequelize;

const Product = sequelize.define(
  "Product",
  {
    id: {
      type: DataTypes.INTEGER,
      primaryKey: true,
      autoIncrement: true,
    },
    name: {
      type: DataTypes.STRING,
      allowNull: false,
    },
    categoryId: {
      type: DataTypes.INTEGER,
      allowNull: false,
      references: {
        model: "product_categories",
        key: "id",
      },
      onUpdate: "CASCADE",
      onDelete: "SET NULL",
    },
    status: {
      type: DataTypes.ENUM("active", "discontinued"),
      defaultValue: "active",
    },
    type: {
      type: DataTypes.ENUM(
        "Médicament", // Drug
        "Vaccin", // Vaccine
        "FluidesIntraveineux", // Intravenous Fluids
        "Anesthésique", // Anesthetic
        "Biologique", // Biologic
        "ProduitHerbal", // Herbal Product
        "OTC", // Over-The-Counter Product
        "SubstanceContrôlée", // Controlled Substance
        "Radiopharmaceutique", // Radiopharmaceutical
        "ThérapieHormonale", // Hormonal Therapy
        "Supplément", // Supplement
        "Antiseptique", // Antiseptic
        "MédicamentTopique", // Topical Medication
        "ProduitHoméopathique" // Homeopathic Product
      ),
      allowNull: false,
      defaultValue: "Médicament", // Default type is "Médicament"
    },
  },
  {
    tableName: "products",
    timestamps: true,
  }
);

module.exports = Product;
