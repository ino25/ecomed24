const { DataTypes } = require('sequelize');
const sequelize = require('../config').sequelize;

const NosologieIllness = sequelize.define('NosologieIllness', {
  id: {
    type: DataTypes.INTEGER,
    primaryKey: true,
    autoIncrement: true
  },
  name: {
    type: DataTypes.STRING,
    allowNull: false
  },
  status: {
    type: DataTypes.INTEGER,
    allowNull: true,
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
  tableName: 'nosologie_illness',
  timestamps: true // Disable Sequelize's default timestamps
});

module.exports = NosologieIllness;



