const { DataTypes } = require('sequelize');
const sequelize = require('../config').sequelize;

const OtPayment = sequelize.define('OtPayment', {
  id: {
    type: DataTypes.INTEGER,
    primaryKey: true,
    autoIncrement: true
  },
  patient: {
    type: DataTypes.STRING,
    allowNull: false
  },
  doctor_c_s: {
    type: DataTypes.STRING,
    allowNull: false
  },
  doctor_a_s_1: {
    type: DataTypes.STRING,
    allowNull: false
  },
  doctor_a_s_2: {
    type: DataTypes.STRING,
    allowNull: false
  },
  doctor_anaes: {
    type: DataTypes.STRING,
    allowNull: false
  },
  n_o_o: {
    type: DataTypes.STRING,
    allowNull: false
  },
  c_s_f: {
    type: DataTypes.STRING,
    allowNull: false
  },
  a_s_f_1: {
    type: DataTypes.STRING,
    allowNull: false
  },
  a_s_f_2: {
    type: DataTypes.STRING,
    allowNull: false
  },
  anaes_f: {
    type: DataTypes.STRING,
    allowNull: false
  },
  ot_charge: {
    type: DataTypes.STRING,
    allowNull: false
  },
  cab_rent: {
    type: DataTypes.STRING,
    allowNull: false
  },
  seat_rent: {
    type: DataTypes.STRING,
    allowNull: false
  },
  others: {
    type: DataTypes.STRING,
    allowNull: false
  },
  discount: {
    type: DataTypes.STRING,
    allowNull: false
  },
  date: {
    type: DataTypes.STRING,
    allowNull: false
  },
  amount: {
    type: DataTypes.STRING,
    allowNull: false
  },
  doctor_fees: {
    type: DataTypes.STRING,
    allowNull: false
  },
  hospital_fees: {
    type: DataTypes.STRING,
    allowNull: false
  },
  gross_total: {
    type: DataTypes.STRING,
    allowNull: false
  },
  flat_discount: {
    type: DataTypes.STRING,
    allowNull: false
  },
  amount_received: {
    type: DataTypes.STRING,
    allowNull: false
  },
  status: {
    type: DataTypes.STRING,
    allowNull: false
  },
  user: {
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
  tableName: 'ot_payment',
  timestamps: false // Disable Sequelize's default timestamps
});

module.exports = OtPayment;



