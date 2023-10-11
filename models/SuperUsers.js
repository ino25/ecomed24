const { DataTypes } = require('sequelize');
const sequelize = require('../config').sequelize;

const SuperUsers = sequelize.define('SuperUsers', {
  id: {
    type: DataTypes.INTEGER,
    primaryKey: true,
    autoIncrement: true
  },
  ip_address: {
    type: DataTypes.STRING,
    allowNull: false
  },
  username: {
    type: DataTypes.STRING,
    allowNull: false
  },
  password: {
    type: DataTypes.STRING,
    allowNull: false
  },
  salt: {
    type: DataTypes.STRING,
    allowNull: false
  },
  email: {
    type: DataTypes.STRING,
    allowNull: false
  },
  activation_code: {
    type: DataTypes.STRING,
    allowNull: false
  },
  forgotten_password_code: {
    type: DataTypes.STRING,
    allowNull: false
  },
  forgotten_password_time: {
    type: DataTypes.STRING,
    allowNull: false
  },
  remember_code: {
    type: DataTypes.STRING,
    allowNull: false
  },
  created_on: {
    type: DataTypes.STRING,
    allowNull: false
  },
  last_login: {
    type: DataTypes.STRING,
    allowNull: false
  },
  active: {
    type: DataTypes.STRING,
    allowNull: false
  },
  first_name: {
    type: DataTypes.STRING,
    allowNull: false
  },
  last_name: {
    type: DataTypes.STRING,
    allowNull: false
  },
  company: {
    type: DataTypes.STRING,
    allowNull: false
  },
  phone: {
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
  tableName: 'superusers',
  timestamps: false // Disable Sequelize's default timestamps
});

module.exports = SuperUsers;


