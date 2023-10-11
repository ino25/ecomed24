const { DataTypes } = require('sequelize');
const sequelize = require('../config').sequelize;

const Insurance = sequelize.define('Insurance', {
  id: {
    type: DataTypes.INTEGER,
    primaryKey: true,
    autoIncrement: true
  },
  insurance_name: {
    type: DataTypes.STRING,
    allowNull: false
  },
  discount: {
    type: DataTypes.STRING,
    allowNull: false
  },
  remark: {
    type: DataTypes.STRING,
    allowNull: false
  },
  insurance_no: {
    type: DataTypes.STRING,
    allowNull: false
  },
  insurance_code: {
    type: DataTypes.STRING,
    allowNull: false
  },
  disease_charge: {
    type: DataTypes.STRING,
    allowNull: false
  },
  status: {
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
  tableName: 'insurance',
  timestamps: false // Disable Sequelize's default timestamps
});

module.exports = Insurance;



