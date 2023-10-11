const { DataTypes } = require('sequelize');
const sequelize = require('../config').sequelize;

const PartenariatSanteAssurance = sequelize.define('PartenariatSanteAssurance', {
  idp: {
    type: DataTypes.INTEGER,
    primaryKey: true,
    autoIncrement: true
  },
  id_organisation_sante: {
    type: DataTypes.STRING,
    allowNull: false
  },
  id_organisation_assurance: {
    type: DataTypes.STRING,
    allowNull: false
  },
  partenariat_actif: {
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
  tableName: 'partenariat_sante_assurance',
  timestamps: false // Disable Sequelize's default timestamps
});

module.exports = PartenariatSanteAssurance;



