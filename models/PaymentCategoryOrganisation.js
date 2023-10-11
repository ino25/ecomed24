const { DataTypes } = require('sequelize');
const sequelize = require('../config').sequelize;

const PaymentCategoryOrganisation = sequelize.define('PaymentCategoryOrganisation', {
  idpco: {
    type: DataTypes.INTEGER,
    primaryKey: true,
    autoIncrement: true
  },
  id_presta: {
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
  tarif_public: {
    type: DataTypes.STRING,
    allowNull: false
  },
  tarif_professionnel: {
    type: DataTypes.STRING,
    allowNull: false
  },
  tarif_assurance: {
    type: DataTypes.STRING,
    allowNull: false
  },
  tarif_ipm: {
    type: DataTypes.STRING,
    allowNull: false
  },
  is_modele: {
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
  tableName: 'payment_category_organisation',
  timestamps: false // Disable Sequelize's default timestamps
});

module.exports = PaymentCategoryOrganisation;


