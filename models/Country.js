const { DataTypes } = require('sequelize');
const sequelize = require('../config').sequelize;

const Country = sequelize.define('Country', {
  id: {
    type: DataTypes.INTEGER,
    primaryKey: true,
    autoIncrement: true
  },
  name: {
    type: DataTypes.STRING,
    allowNull: false
  },
  country_code: {
    type: DataTypes.STRING,
    allowNull: false
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
  tableName: 'country',
  timestamps: true // Disable Sequelize's default timestamps
});

module.exports = Country;



