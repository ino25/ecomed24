const { DataTypes } = require('sequelize');
const sequelize = require('../config').sequelize;

const Expense = sequelize.define('Expense', {
  id: {
    type: DataTypes.INTEGER,
    primaryKey: true,
    autoIncrement: true
  },
  id_organisation: {
    type: DataTypes.STRING,
    allowNull: false
  },
  category: {
    type: DataTypes.STRING,
    allowNull: false
  },
  beneficiaire: {
    type: DataTypes.STRING,
    allowNull: false
  },
  date: {
    type: DataTypes.STRING,
    allowNull: false
  },
  heure: {
    type: DataTypes.STRING,
    allowNull: false
  },
  note: {
    type: DataTypes.STRING,
    allowNull: false
  },
  amount: {
    type: DataTypes.STRING,
    allowNull: false
  },
  user: {
    type: DataTypes.STRING,
    allowNull: false
  },
  datestring: {
    type: DataTypes.STRING,
    allowNull: false
  },
  status: {
    type: DataTypes.STRING,
    allowNull: false
  },
  numeroTransaction: {
    type: DataTypes.STRING,
    allowNull: false
  },
  numeroFacture: {
    type: DataTypes.STRING,
    allowNull: false
  },
  referenceClient: {
    type: DataTypes.STRING,
    allowNull: false
  },
  codeType: {
    type: DataTypes.STRING,
    allowNull: false
  },
  codeFacture: {
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
  tableName: 'expense',
  timestamps: false // Disable Sequelize's default timestamps
});

module.exports = Expense;



