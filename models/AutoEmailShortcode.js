const { DataTypes } = require('sequelize');
const sequelize = require('../config').sequelize;

const AutoEmailShortcode = sequelize.define('AutoEmailShortcode', {
  id: {
    type: DataTypes.INTEGER,
    primaryKey: true,
    autoIncrement: true
  },
  name: {
    type: DataTypes.STRING,
    allowNull: false
  },
  type: {
    type: DataTypes.STRING,
    allowNull: false,
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
  tableName: 'autoemailshortcode',
  timestamps: false // Disable Sequelize's default timestamps
});

module.exports = AutoEmailShortcode;



