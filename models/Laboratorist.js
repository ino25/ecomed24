const { DataTypes } = require('sequelize');
const sequelize = require('../config').sequelize;

const Laboratorist = sequelize.define('Laboratorist', {
  id: {
    type: DataTypes.INTEGER,
    primaryKey: true,
    autoIncrement: true
  },
  img_url: {
    type: DataTypes.STRING,
    allowNull: false
  },
  name: {
    type: DataTypes.STRING,
    allowNull: false
  },
  email: {
    type: DataTypes.STRING,
    allowNull: false
  },
  address: {
    type: DataTypes.STRING,
    allowNull: false
  },
  phone: {
    type: DataTypes.STRING,
    allowNull: false
  },
  x: {
    type: DataTypes.STRING,
    allowNull: false
  },
  y: {
    type: DataTypes.STRING,
    allowNull: false
  },
  ion_user_id: {
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
  tableName: 'laboratorist',
  timestamps: false // Disable Sequelize's default timestamps
});

module.exports = Laboratorist;



