const { DataTypes } = require('sequelize');
const sequelize = require('../config').sequelize;

const Payment = sequelize.define('Payment', {
  id: {
    type: DataTypes.INTEGER,
    primaryKey: true,
    autoIncrement: true
  },
  code: {
    type: DataTypes.STRING,
    allowNull: true
  },
  code_pro: {
    type: DataTypes.STRING,
    allowNull: true
  },
  category: {
    type: DataTypes.STRING,
    allowNull: true
  },
  patient: {
    type: DataTypes.STRING,
    allowNull: true
  },
  id_organisation: {
    type: DataTypes.STRING,
    allowNull: true
  },
  doctor: {
    type: DataTypes.STRING,
    allowNull: true
  },
  service: {
    type: DataTypes.STRING,
    allowNull: true
  },
  date: {
    type: DataTypes.STRING,
    allowNull: true
  },
  amount: {
    type: DataTypes.STRING,
    allowNull: true
  },
  vat: {
    type: DataTypes.STRING,
    allowNull: true
  },
  x_ray: {
    type: DataTypes.STRING,
    allowNull: true
  },
  flat_vat: {
    type: DataTypes.STRING,
    allowNull: true
  },
  discount: {
    type: DataTypes.STRING,
    allowNull: true
  },
  flat_discount: {
    type: DataTypes.STRING,
    allowNull: true
  },
  gross_total: {
    type: DataTypes.STRING,
    allowNull: true
  },
  remarks: {
    type: DataTypes.STRING,
    allowNull: true
  },
  hospital_amount: {
    type: DataTypes.STRING,
    allowNull: true
  },
  doctor_amount: {
    type: DataTypes.STRING,
    allowNull: true
  },
  category_amount: {
    type: DataTypes.STRING,
    allowNull: true
  },
  category_name: {
    type: DataTypes.STRING,
    allowNull: true
  },
  category_name_pro: {
    type: DataTypes.STRING,
    allowNull: true
  },
  category_name_assurance: {
    type: DataTypes.STRING,
    allowNull: true
  },
  amount_received: {
    type: DataTypes.STRING,
    allowNull: true
  },
  deposit_type: {
    type: DataTypes.STRING,
    allowNull: true
  },
  status: {
    type: DataTypes.STRING,
    allowNull: true
  },
  status_presta: {
    type: DataTypes.STRING,
    allowNull: true
  },
  status_paid: {
    type: DataTypes.STRING,
    allowNull: true
  },
  status_paid_pro: {
    type: DataTypes.STRING,
    allowNull: true
  },
  user: {
    type: DataTypes.STRING,
    allowNull: true
  },
  patient_name: {
    type: DataTypes.STRING,
    allowNull: true
  },
  patient_phone: {
    type: DataTypes.STRING,
    allowNull: true
  },
  patient_address: {
    type: DataTypes.STRING,
    allowNull: true
  },
  doctor_name: {
    type: DataTypes.STRING,
    allowNull: true
  },
  date_string: {
    type: DataTypes.STRING,
    allowNull: true
  },
  charge_mutuelle: {
    type: DataTypes.STRING,
    allowNull: true
  },
  etat: {
    type: DataTypes.STRING,
    allowNull: true
  },
  etatlight: {
    type: DataTypes.STRING,
    allowNull: true
  },
  etat_assurance: {
    type: DataTypes.STRING,
    allowNull: true
  },
  organisation_light_origin: {
    type: DataTypes.STRING,
    allowNull: true
  },
  organisation_destinataire: {
    type: DataTypes.STRING,
    allowNull: true
  },
  prescripteur: {
    type: DataTypes.STRING,
    allowNull: true
  },
  libelle_prestation: {
    type: DataTypes.STRING,
    allowNull: true
  },
  patient_age: {
    type: DataTypes.STRING,
    allowNull: true
  },
  libelle_specialite: {
    type: DataTypes.STRING,
    allowNull: true
  },
  renseignementClinique: {
    type: DataTypes.STRING,
    allowNull: true
  },
  purpose: {
    type: DataTypes.STRING,
    allowNull: true
  },
  qr_code: {
    type: DataTypes.STRING,
    allowNull: true
  },
  signature: {
    type: DataTypes.STRING,
    allowNull: true
  },
  date_rendu: {
    type: DataTypes.STRING,
    allowNull: true
  },
  transfer: {
    type: DataTypes.STRING,
    allowNull: true
  },
  frais_service: {
    type: DataTypes.STRING,
    allowNull: true
  },
  bulletinAnalyse: {
    type: DataTypes.STRING,
    allowNull: true
  },
  patientPassport: {
    type: DataTypes.STRING,
    allowNull: true
  },
  motifVoyage: {
    type: DataTypes.STRING,
    allowNull: true
  },
  date_prelevement: {
    type: DataTypes.STRING,
    allowNull: true
  },
  heure_prelevement: {
    type: DataTypes.STRING,
    allowNull: true
  },
  type_prelevement: {
    type: DataTypes.STRING,
    allowNull: true
  },
  statutEtat: {
    type: DataTypes.STRING,
    allowNull: true
  },
  statutLight: {
    type: DataTypes.STRING,
    allowNull: true
  },
  added_by: {
    type: DataTypes.INTEGER,
    allowNull: true
  },
  updated_by: {
    type: DataTypes.INTEGER,
    allowNull: true
  },

}, {
  tableName: 'payment',
  timestamps: true // Disable Sequelize's default timestamps
});

module.exports = Payment;


