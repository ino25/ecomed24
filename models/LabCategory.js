const { DataTypes } = require('sequelize');
const sequelize = require('../config').sequelize;

const LabCategory = sequelize.define('LabCategory', {
  id: {
    type: DataTypes.INTEGER,
    primaryKey: true,
    autoIncrement: true
  },
  category: {
    type: DataTypes.STRING,
    allowNull: false
  },
  description: {
    type: DataTypes.STRING,
    allowNull: false
  },
  reference_value: {
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
  tableName: 'lab_category',
  timestamps: false // Disable Sequelize's default timestamps
});

module.exports = LabCategory;



