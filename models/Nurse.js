const { DataTypes } = require('sequelize');
const sequelize = require('../config').sequelize;

const Nurse = sequelize.define('Nurse', {
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
  z: {
    type: DataTypes.STRING,
    allowNull: false
  },
  ion_user_id: {
    type: DataTypes.STRING,
    allowNull: false
  },
  
}, {
  tableName: 'nurse',
  timestamps: false // Disable Sequelize's default timestamps
});

module.exports = Nurse;



