const { DataTypes } = require('sequelize');
const sequelize = require('../config').sequelize;


const Transaction = sequelize.define('Transaction', {
  id_payment: {
    type: DataTypes.INTEGER,
    allowNull: false,
  },
  id_prestation_organisation: {
    type: DataTypes.INTEGER,
    allowNull: false,
  },
  amount: {
    type: DataTypes.STRING,
    allowNull: true,
  },
  to_Pay: {
    type: DataTypes.STRING,
    allowNull: true,
  },
  id_patient_payeur: {
    type: DataTypes.INTEGER,
    allowNull: false,
  },
  id_patient_parent: {
    type: DataTypes.STRING,
    allowNull: true,
  },
  id_organisation_origine: {
    type: DataTypes.STRING,
    allowNull: true,
  },
  id_organisation_destinataire: {
    type: DataTypes.STRING,
    allowNull: true,
  },
  id_organisation_light: {
    type: DataTypes.STRING,
    allowNull: true,
  },
  id_organisation_assurance_ipm: {
    type: DataTypes.STRING,
    allowNull: true,
  },
  type: {
    type: DataTypes.STRING,
    allowNull: true,
  },
  Facturer: {
    type: DataTypes.STRING,
    defaultValue: '0',
    allowNull: false,
  },
  id_facture: {
    type: DataTypes.STRING,
    allowNull: true,
  },
  status: {
    type: DataTypes.STRING,
    allowNull: true,
  },
  Billing: {
    type: DataTypes.STRING,
    defaultValue: '0',
    allowNull: false,
  },
  code_facture: {
    type: DataTypes.STRING,
    allowNull: true,
  },
  code_facture_update: {
    type: DataTypes.STRING,
    allowNull: true,
  },
}, {
  tableName: 'transactions',
  timestamps: false,
});

module.exports = Transaction;
