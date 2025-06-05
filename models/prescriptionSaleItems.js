const { sequelize } = require("../config");
const { DataTypes } = require('sequelize');
const PrescriptionSale = require("./prescriptionSales");
const Prescriptions = require("./Prescriptions"); // Import Prescriptions model

const PrescriptionSaleItem = sequelize.define("PrescriptionSaleItem", {
  id: {
    type: DataTypes.INTEGER,
    primaryKey: true,
    autoIncrement: true
  },
  product_id: {
    type: DataTypes.INTEGER,
    allowNull: false
  },
  price: {
    type: DataTypes.FLOAT,
    allowNull: false
  },
  quantity: {
    type: DataTypes.INTEGER,
    allowNull: false
  },
  subtotal: {
    type: DataTypes.FLOAT,
    allowNull: false
  },
  prescription_sale_id: {
    type: DataTypes.INTEGER,
    allowNull: false,
    references: {
      model: PrescriptionSale, 
      key: 'id'
    },
    onUpdate: 'CASCADE',
    onDelete: 'CASCADE'
  },
  status: {
    type: DataTypes.INTEGER,
    allowNull: false,
    defaultValue: 1 // Added default value
  },
  added_by: {
    type: DataTypes.INTEGER,
    allowNull: true
  },
  updated_by: {
    type: DataTypes.INTEGER,
    allowNull: true
  }
}, {
  tableName: 'prescription_sale_items',
  timestamps: true // Changed to true to match the sales table
});

module.exports = PrescriptionSaleItem; // Fixed export statement

// Add associations (add this to a separate associations file or at the end of your model definitions)
PrescriptionSale.hasMany(PrescriptionSaleItem, {
  foreignKey: 'prescription_sale_id',
  as: 'items'
});

PrescriptionSaleItem.belongsTo(PrescriptionSale, {
  foreignKey: 'prescription_sale_id',
  as: 'sale'
});

// Add association with Prescriptions
PrescriptionSale.belongsTo(Prescriptions, {
  foreignKey: 'prescription_id',
  as: 'prescription'
});

Prescriptions.hasMany(PrescriptionSale, {
  foreignKey: 'prescription_id',
  as: 'sales'
});