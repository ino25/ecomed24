const { DataTypes } = require('sequelize');
const sequelize = require('../config').sequelize;

const PaymentPro = sequelize.define('PaymentPro', {
  idpro: {
    type: DataTypes.INTEGER,
    primaryKey: true,
    autoIncrement: true
  },
  codepro: {
    type: DataTypes.STRING,
    allowNull: false
  },
  codefacture: {
    type: DataTypes.STRING,
    allowNull: false,
    unique: true
  },
  date: {
    type: DataTypes.STRING,
    allowNull: false
  },
  dateDebut: {
    type: DataTypes.STRING,
    allowNull: false
  },
  dateFin: {
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
  tableName: 'payment_pro',
  timestamps: false // Disable Sequelize's default timestamps
});

module.exports = PaymentPro;


