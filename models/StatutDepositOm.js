const { DataTypes } = require('sequelize');
const sequelize = require('../config').sequelize;

const StatutDepositOm = sequelize.define('StatutDepositOm', {
  id: {
    type: DataTypes.INTEGER,
    primaryKey: true,
    autoIncrement: true
  },
  id_transaction_externe: {
    type: DataTypes.STRING,
    allowNull: false
  },
  patient: {
    type: DataTypes.STRING,
    allowNull: false
  },
  id_organisation: {
    type: DataTypes.STRING,
    allowNull: false
  },
  payment_id: {
    type: DataTypes.STRING,
    allowNull: false
  },
  date: {
    type: DataTypes.STRING,
    allowNull: false
  },
  deposited_amount: {
    type: DataTypes.STRING,
    allowNull: false
  },
  amount_received_id: {
    type: DataTypes.STRING,
    allowNull: false
  },
  deposit_type: {
    type: DataTypes.STRING,
    allowNull: false
  },
  gateway: {
    type: DataTypes.STRING,
    allowNull: false
  },
  user: {
    type: DataTypes.STRING,
    allowNull: false
  },
  statut_deposit: {
    type: DataTypes.STRING,
    allowNull: false
  },
  ref_om: {
    type: DataTypes.STRING,
    allowNull: false
  },
  numero_om: {
    type: DataTypes.STRING,
    allowNull: false
  },
  estPro: {
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
  tableName: 'statut_deposit_om',
  timestamps: false // Disable Sequelize's default timestamps
});

module.exports = StatutDepositOm;


