const { DataTypes } = require('sequelize');
const sequelize = require('../config').sequelize;

const User = sequelize.define('User', {
  id: {
    type: DataTypes.INTEGER,
    primaryKey: true,
    autoIncrement: true
  },
  id_organisation: {
    type: DataTypes.STRING,
    allowNull: false
  },
  ip_address: {
    type: DataTypes.STRING,
    allowNull: false,
    unique: true
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
    allowNull: true
  },
  email: {
    type: DataTypes.STRING,
    allowNull: false
  },
  activation_code: {
    type: DataTypes.STRING,
    allowNull: true
  },
  forgotten_password_code: {
    type: DataTypes.STRING,
    allowNull: true
  },
  forgotten_password_time: {
    type: DataTypes.STRING,
    allowNull: true
  },
  remember_code: {
    type: DataTypes.STRING,
    allowNull: true
  },
  created_on: {
    type: DataTypes.STRING,
    allowNull: false
  },
  last_login: {
    type: DataTypes.STRING,
    allowNull: true
  },
  active: {
    type: DataTypes.STRING,
    allowNull: true
  },
  first_name: {
    type: DataTypes.STRING,
    allowNull: true
  },
  last_name: {
    type: DataTypes.STRING,
    allowNull: true
  },
  company: {
    type: DataTypes.STRING,
    allowNull: true
  },
  phone: {
    type: DataTypes.STRING,
    allowNull: true
  },
  phone_recuperation: {
    type: DataTypes.STRING,
    allowNull: true
  },
  adresse: {
    type: DataTypes.STRING,
    allowNull: true
  },
  region: {
    type: DataTypes.STRING,
    allowNull: true
  },
  departement: {
    type: DataTypes.STRING,
    allowNull: true
  },
  arrondissement: {
    type: DataTypes.STRING,
    allowNull: true
  },
  collectivite: {
    type: DataTypes.STRING,
    allowNull: true
  },
  pays: {
    type: DataTypes.STRING,
    allowNull: true
  },
  default_img_url: {
    type: DataTypes.STRING,
    allowNull: true
  },
  otp_validated: {
    type: DataTypes.STRING,
    allowNull: true
  },
  service: {
    type: DataTypes.STRING,
    allowNull: true
  },
  signature: {
    type: DataTypes.STRING,
    allowNull: true
  },
  token: {
    type: DataTypes.STRING,
    allowNull: true
  },
  

}, {
  tableName: 'users',
  timestamps: false // Disable Sequelize's default timestamps
});

module.exports = User;



