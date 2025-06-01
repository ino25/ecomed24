const { DataTypes } = require('sequelize');
const Sales = require('./sales');
const { sequelize } = require("../config");

const SalesItem = sequelize.define('SalesItem', {
  id: {
    type: DataTypes.INTEGER,
    primaryKey: true,
    autoIncrement: true
  },
  sale_id: {
    type: DataTypes.INTEGER,
    allowNull: false,
    references: {
      model: Sales,
      key: 'id'
    }
  },
  product_name: {
    type: DataTypes.STRING,
    allowNull: false
  },
  price: {
    type: DataTypes.DECIMAL(10, 2),
    allowNull: false
  },
  quantity: {
    type: DataTypes.INTEGER,
    allowNull: false
  },
  subtotal: {
    type: DataTypes.DECIMAL(10, 2),
    allowNull: false
  },
  created_at: {
    type: DataTypes.DATE,
    allowNull: false,
    defaultValue: DataTypes.NOW
  },
  updated_at: {
    type: DataTypes.DATE,
    allowNull: false,
    defaultValue: DataTypes.NOW
  }
}, {
  tableName: 'sales_items',
  timestamps: false
});

// Define associations
Sales.hasMany(SalesItems, { foreignKey: 'sale_id', as: 'items' });
SalesItem.belongsTo(Sales, { foreignKey: 'sale_id', as: 'sale' });

module.exports = SalesItem;