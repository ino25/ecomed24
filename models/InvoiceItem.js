const { DataTypes } = require('sequelize');
const sequelize = require('../config').sequelize;

const InvoiceItem = sequelize.define('InvoiceItem', {
  id: { type: DataTypes.INTEGER, primaryKey: true, autoIncrement: true },
  invoice_id: { type: DataTypes.INTEGER, allowNull: false },
  description: { type: DataTypes.STRING },
  beneficiaire: { type: DataTypes.STRING },
  reference: { type: DataTypes.STRING },
  quantity: { type: DataTypes.INTEGER },
  unit_price: { type: DataTypes.DECIMAL(10, 2) },
  total: { type: DataTypes.DECIMAL(10, 2) },
  service_code: { type: DataTypes.STRING },
  statut: {
  type: DataTypes.ENUM('LIBRE', 'FACTURÉ'),
  defaultValue: 'LIBRE'
}

}, {
  tableName: 'invoice_items',
  timestamps: false
});

module.exports = InvoiceItem;
