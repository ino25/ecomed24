const { DataTypes } = require('sequelize');
const sequelize = require('../config').sequelize;

const PaymentCategory = sequelize.define('PaymentCategory', {
  id: {
    type: DataTypes.INTEGER,
    primaryKey: true,
    autoIncrement: true
  },
  code_prestation: {
    type: DataTypes.STRING,
    allowNull: false
  },
  prestation: {
    type: DataTypes.STRING,
    allowNull: false,
    unique: true
  },
  cotation: {
    type: DataTypes.STRING,
    allowNull: false
  },
  coefficient: {
    type: DataTypes.STRING,
    allowNull: false
  },
  description: {
    type: DataTypes.STRING,
    allowNull: false
  },
  keywords: {
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
  id_service: {
    type: DataTypes.STRING,
    allowNull: false
  },
  id_spe: {
    type: DataTypes.STRING,
    allowNull: false
  },
  nomenclature_prestation: {
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
  tableName: 'payment_category',
  timestamps: false // Disable Sequelize's default timestamps
});

module.exports = PaymentCategory;


