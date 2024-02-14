const { DataTypes } = require('sequelize');
const sequelize = require('../config').sequelize;

const Region = sequelize.define('Region', {
  id: {
    type: DataTypes.INTEGER,
    primaryKey: true,
    autoIncrement: true
  },
  name: {
    type: DataTypes.STRING,
    allowNull: false
  },
  country_id: {
    type: DataTypes.INTEGER,
    allowNull: false,
  },
  status: {
    type: DataTypes.INTEGER,
    allowNull: false,
  },
  added_by: {
    type: DataTypes.INTEGER,
    allowNull: true,
  },
  updated_by: {
    type: DataTypes.INTEGER,
    allowNull: true,
  },

  

}, {
  tableName: 'region',
  timestamps: true // Disable Sequelize's default timestamps
});

module.exports = Region;


