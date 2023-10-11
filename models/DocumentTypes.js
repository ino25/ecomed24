const { DataTypes } = require('sequelize');
const sequelize = require('../config').sequelize;

const DocumentTypes = sequelize.define('DocumentTypes', {
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
    type: DataTypes.STRING,
    allowNull: false
  },
  added_by: {
    type: DataTypes.STRING,
    allowNull: true
  },
  updated_by: {
    type: DataTypes.STRING,
    allowNull: true
  },
  
}, {
  tableName: 'document_types',
  timestamps: true // Disable Sequelize's default timestamps
});

module.exports = DocumentTypes;



