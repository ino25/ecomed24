const { DataTypes } = require('sequelize');
const sequelize = require('../config').sequelize;

const PaymentCategoryPanier = sequelize.define('PaymentCategoryPanier', {
  id: {
    type: DataTypes.INTEGER,
    primaryKey: true,
    autoIncrement: true
  },
  id_prestation: {
    type: DataTypes.STRING,
    allowNull: false
  },
  id_organisation: {
    type: DataTypes.STRING,
    allowNull: false,
    unique: true
  },
  statut: {
    type: DataTypes.STRING,
    allowNull: false
  },
  
//   created_at: {
//     type: DataTypes.DATE,
//     allowNull: false,
//     defaultValue: DataTypes.NOW
//   },
//   updated_at: {
//     type: DataTypes.DATE,
//     allowNull: false,
//     defaultValue: DataTypes.NOW
//   }
}, {
  tableName: 'payment_category_panier',
  timestamps: false // Disable Sequelize's default timestamps
});

module.exports = PaymentCategoryPanier;


