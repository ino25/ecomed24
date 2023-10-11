const { DataTypes } = require('sequelize');
const sequelize = require('../config').sequelize;

const Prescription = sequelize.define('Prescription', {
  id: {
    type: DataTypes.INTEGER,
    primaryKey: true,
    autoIncrement: true
  },
  id_organisation: {
    type: DataTypes.STRING,
    allowNull: false
  },
  date: {
    type: DataTypes.STRING,
    allowNull: false,
  },
  date_string: {
    type: DataTypes.STRING,
    allowNull: false
  },
  patient: {
    type: DataTypes.STRING,
    allowNull: false
  },
  doctor: {
    type: DataTypes.STRING,
    allowNull: false
  },
  symptom: {
    type: DataTypes.STRING,
    allowNull: false
  },
  advice: {
    type: DataTypes.STRING,
    allowNull: false
  },
  state: {
    type: DataTypes.STRING,
    allowNull: false
  },
  dd: {
    type: DataTypes.STRING,
    allowNull: false
  },
  medicine: {
    type: DataTypes.STRING,
    allowNull: false
  },
  validity: {
    type: DataTypes.STRING,
    allowNull: false
  },
  note: {
    type: DataTypes.STRING,
    allowNull: false
  },
  patientname: {
    type: DataTypes.STRING,
    allowNull: false
  },
  patientlastname: {
    type: DataTypes.STRING,
    allowNull: false
  },
  user: {
    type: DataTypes.STRING,
    allowNull: false
  },
  doctorname: {
    type: DataTypes.STRING,
    allowNull: false
  },
  medicament: {
    type: DataTypes.STRING,
    allowNull: false
  },
  etat: {
    type: DataTypes.STRING,
    allowNull: false
  },
  organisation_destinataire: {
    type: DataTypes.STRING,
    allowNull: false
  },
  code_facture: {
    type: DataTypes.STRING,
    allowNull: false
  },
  img_url: {
    type: DataTypes.STRING,
    allowNull: false
  },
  renew_date: {
    type: DataTypes.STRING,
    allowNull: false
  },
  lab_test: {
    type: DataTypes.STRING,
    allowNull: false
  },
  signature: {
    type: DataTypes.STRING,
    allowNull: false
  },
  qr_code: {
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
  tableName: 'prescription',
  timestamps: false // Disable Sequelize's default timestamps
});

module.exports = Prescription;


