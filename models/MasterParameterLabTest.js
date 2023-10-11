const { DataTypes } = require('sequelize');
const sequelize = require('../config').sequelize;

const MasterParameterLabTest = sequelize.define('MasterParameterLabTest', {
  id: {
    type: DataTypes.INTEGER,
    primaryKey: true,
    autoIncrement: true
  },
  high: {
    type: DataTypes.STRING,
    allowNull: false
  },
  low: {
    type: DataTypes.STRING,
    allowNull: false
  },
  reference_type: {
    type: DataTypes.STRING,
    allowNull: false
  },
  positive_negative: {
    type: DataTypes.STRING,
    allowNull: false
  },
  parameter_name: {
    type: DataTypes.STRING,
    allowNull: false
  },
  parameter_description: {
    type: DataTypes.STRING,
    allowNull: false
  },
  id_organisation: {
    type: DataTypes.STRING,
    allowNull: false
  },
  test_id: {
    type: DataTypes.STRING,
    allowNull: false
  },
  unit_of_measure: {
    type: DataTypes.STRING,
    allowNull: false
  },
  request_test_id: {
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
  tableName: 'master_parameter_lab_test',
  timestamps: false // Disable Sequelize's default timestamps
});

module.exports = MasterParameterLabTest;



