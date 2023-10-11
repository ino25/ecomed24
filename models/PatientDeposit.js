const { DataTypes } = require('sequelize');
const sequelize = require('../config').sequelize;

const PatientDeposit = sequelize.define('PatientDeposit', {
  id: {
    type: DataTypes.INTEGER,
    primaryKey: true,
    autoIncrement: true
  },
  patient: {
    type: DataTypes.STRING,
    allowNull: true
  },
  id_organisation: {
    type: DataTypes.STRING,
    allowNull: true,
  },
  payment_id: {
    type: DataTypes.STRING,
    allowNull: true
  },
  date: {
    type: DataTypes.STRING,
    allowNull: true
  },
  deposited_amount: {
    type: DataTypes.STRING,
    allowNull: true
  },
  amount_received_id: {
    type: DataTypes.STRING,
    allowNull: true
  },
  deposit_type: {
    type: DataTypes.STRING,
    allowNull: true
  },
  gateway: {
    type: DataTypes.STRING,
    allowNull: true
  },
  id_transaction_externe: {
    type: DataTypes.STRING,
    allowNull: true
  },
  user: {
    type: DataTypes.STRING,
    allowNull: true
  },
  status: {
    type: DataTypes.STRING,
    allowNull: true
  },
  added_by: {
    type: DataTypes.STRING,
    allowNull: true
  },
  updated_by: {
    type: DataTypes.INTEGER,
    allowNull: true
  },

}, {
  tableName: 'patient_deposit',
  timestamps: true // Disable Sequelize's default timestamps
});

module.exports = PatientDeposit;


