const { DataTypes } = require('sequelize');
const sequelize = require('../config').sequelize;

const Lab = sequelize.define('Lab', {
  id: {
    type: DataTypes.INTEGER,
    primaryKey: true,
    autoIncrement: true
  },
  numero_demande: {
    type: DataTypes.STRING,
    allowNull: false
  },
  category: {
    type: DataTypes.STRING,
    allowNull: false
  },
  patient: {
    type: DataTypes.STRING,
    allowNull: false
  },
  payment: {
    type: DataTypes.STRING,
    allowNull: false
  },
  demendeur: {
    type: DataTypes.STRING,
    allowNull: false
  },
  doctor: {
    type: DataTypes.STRING,
    allowNull: false
  },
  date: {
    type: DataTypes.STRING,
    allowNull: false
  },
  category_name: {
    type: DataTypes.STRING,
    allowNull: false
  },
  report: {
    type: DataTypes.STRING,
    allowNull: false
  },
  report_pro: {
    type: DataTypes.STRING,
    allowNull: false
  },
  status: {
    type: DataTypes.STRING,
    allowNull: false
  },
  user: {
    type: DataTypes.STRING,
    allowNull: false
  },
  patient_name: {
    type: DataTypes.STRING,
    allowNull: false
  },
  patient_phone: {
    type: DataTypes.STRING,
    allowNull: false
  },
  patient_address: {
    type: DataTypes.STRING,
    allowNull: false
  },
  doctor_name: {
    type: DataTypes.STRING,
    allowNull: false
  },
  date_string: {
    type: DataTypes.STRING,
    allowNull: false
  },
  id_organisation: {
    type: DataTypes.STRING,
    allowNull: false
  },
  code: {
    type: DataTypes.STRING,
    allowNull: false
  },
  consultation: {
    type: DataTypes.STRING,
    allowNull: false
  },
  numeroRegistre: {
    type: DataTypes.STRING,
    allowNull: false
  },
  idPayement: {
    type: DataTypes.STRING,
    allowNull: false
  },
  prescripteur: {
    type: DataTypes.STRING,
    allowNull: false
  },
  nomLabo: {
    type: DataTypes.STRING,
    allowNull: false
  },
  url: {
    type: DataTypes.STRING,
    allowNull: false
  },
  importLabo: {
    type: DataTypes.STRING,
    allowNull: false
  },
  type: {
    type: DataTypes.STRING,
    allowNull: false
  },
  type_prelevement: {
    type: DataTypes.STRING,
    allowNull: false
  },
  date_prelevement: {
    type: DataTypes.STRING,
    allowNull: false
  },
  heure_prelevement: {
    type: DataTypes.STRING,
    allowNull: false
  },
  numero_identifiant: {
    type: DataTypes.STRING,
    allowNull: false
  },
  id_presta: {
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
  tableName: 'lab',
  timestamps: false // Disable Sequelize's default timestamps
});

module.exports = Lab;



