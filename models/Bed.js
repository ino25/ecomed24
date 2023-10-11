const { DataTypes } = require('sequelize');
const sequelize = require('../config').sequelize;

const Bed = sequelize.define('Bed', {
  id: {
    type: DataTypes.INTEGER,
    primaryKey: true,
    autoIncrement: true
  },
  category: {
    type: DataTypes.STRING,
    allowNull: false
  },
  number: {
    type: DataTypes.STRING,
    allowNull: false
  },
  description: {
    type: DataTypes.STRING,
    allowNull: false
  },
  last_a_time: {
    type: DataTypes.STRING,
    allowNull: false
  },
  last_d_time: {
    type: DataTypes.STRING,
    allowNull: false
  },
  status: {
    type: DataTypes.STRING,
    allowNull: false
  },
  bed_id: {
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
  tableName: 'bed',
  timestamps: false // Disable Sequelize's default timestamps
});

module.exports = Bed;



