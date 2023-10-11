const { DataTypes } = require('sequelize');
const sequelize = require('../config').sequelize;

const PaymentCategoryParametre = sequelize.define('PaymentCategoryParametre', {
  idpara: {
    type: DataTypes.INTEGER,
    primaryKey: true,
    autoIncrement: true
  },
  id_prestation: {
    type: DataTypes.STRING,
    allowNull: false
  },
  id_specialite: {
    type: DataTypes.STRING,
    allowNull: false,
    unique: true
  },
  nom_parametre: {
    type: DataTypes.STRING,
    allowNull: false
  },
  unite: {
    type: DataTypes.STRING,
    allowNull: false
  },
  valeurs: {
    type: DataTypes.STRING,
    allowNull: false
  },
  ref_low: {
    type: DataTypes.STRING,
    allowNull: false
  },
  ref_high: {
    type: DataTypes.STRING,
    allowNull: false
  },
  type: {
    type: DataTypes.STRING,
    allowNull: false
  },
  set_of_code: {
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
  tableName: 'payment_category_parametre',
  timestamps: false // Disable Sequelize's default timestamps
});

module.exports = PaymentCategoryParametre;


