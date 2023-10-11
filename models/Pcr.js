const { DataTypes } = require('sequelize');
const sequelize = require('../config').sequelize;

const Pcr = sequelize.define('Pcr', {
  id: {
    type: DataTypes.INTEGER,
    primaryKey: true,
    autoIncrement: true
  },
  payment: {
    type: DataTypes.STRING,
    allowNull: false
  },
  resultat: {
    type: DataTypes.STRING,
    allowNull: false,
    unique: true
  },
  conclusion: {
    type: DataTypes.STRING,
    allowNull: false
  },
  type_de_prelevement: {
    type: DataTypes.STRING,
    allowNull: false
  },
  heure_de_prelevement: {
    type: DataTypes.STRING,
    allowNull: false
  },
  date_rendu: {
    type: DataTypes.STRING,
    allowNull: false
  },
  prestation: {
    type: DataTypes.STRING,
    allowNull: false
  },
  specialite: {
    type: DataTypes.STRING,
    allowNull: false
  },
  signature: {
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
  tableName: 'pcr',
  timestamps: false // Disable Sequelize's default timestamps
});

module.exports = Pcr;


