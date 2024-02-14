const { DataTypes } = require('sequelize');
const sequelize = require('../config').sequelize;

const Patient = sequelize.define('Patient', {
  id: {
    type: DataTypes.INTEGER,
    primaryKey: true,
    autoIncrement: true
  },
  unique_id: {
    type: DataTypes.STRING,
    allowNull: true
  },
  id_organisation: {
    type: DataTypes.INTEGER,
    allowNull: true
  },
  img_url: {
    type: DataTypes.STRING,
    allowNull: true
  },
  name: {
    type: DataTypes.STRING,
    allowNull: true
  },
  last_name: {
    type: DataTypes.STRING,
    allowNull: true
  },
  email: {
    type: DataTypes.STRING,
    unique: true,
    allowNull: true
  },
  doctor: {
    type: DataTypes.STRING,
    allowNull: true
  },
  address: {
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
  sex: {
    type: DataTypes.STRING,
    allowNull: true
  },
  birthdate: {
    type: DataTypes.STRING,
    allowNull: true
  },
  age: {
    type: DataTypes.STRING,
    allowNull: true
  },
  bloodgroup: {
    type: DataTypes.STRING,
    allowNull: true
  },
  ion_user_id: {
    type: DataTypes.STRING,
    allowNull: true
  },
  patient_id: {
    type: DataTypes.STRING,
    allowNull: true
  },
  add_date: {
    type: DataTypes.STRING,
    allowNull: true
  },
  registration_time: {
    type: DataTypes.STRING,
    allowNull: true
  },
  how_added: {
    type: DataTypes.STRING,
    allowNull: true
  },
  status: {
    type: DataTypes.STRING,
    allowNull: true
  },
  matricule: {
    type: DataTypes.STRING,
    allowNull: true
  },
  grade: {
    type: DataTypes.STRING,
    allowNull: true
  },
  birth_position: {
    type: DataTypes.STRING,
    allowNull: true
  },
  nom_contact: {
    type: DataTypes.STRING,
    allowNull: true
  },
  phone_contact: {
    type: DataTypes.STRING,
    allowNull: true
  },
  phone_contact_recuperation: {
    type: DataTypes.STRING,
    allowNull: true
  },
  religion: {
    type: DataTypes.STRING,
    allowNull: true
  },
  country: {
    type: DataTypes.STRING,
    allowNull: true
  },
  region: {
    type: DataTypes.STRING,
    allowNull: true
  },
  district: {
    type: DataTypes.STRING,
    allowNull: true
  },
  lien_parente: {
    type: DataTypes.STRING,
    allowNull: true
  },
  parent_id: {
    type: DataTypes.STRING,
    allowNull: true
  },
  parent_name: {
    type: DataTypes.STRING,
    allowNull: true
  },
  passport: {
    type: DataTypes.STRING,
    allowNull: true
  },
  estCivil: {
    type: DataTypes.STRING,
    allowNull: true
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
  tableName: 'patient',
  timestamps: true // Disable Sequelize's default timestamps
});

module.exports = Patient;


