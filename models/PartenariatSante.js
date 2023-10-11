const { DataTypes } = require('sequelize');
const sequelize = require('../config').sequelize;

const PartenariatSante = sequelize.define('PartenariatSante', {
  idp: {
    type: DataTypes.INTEGER,
    primaryKey: true,
    autoIncrement: true
  },
  id_organisation_origin: {
    type: DataTypes.STRING,
    allowNull: false
  },
  id_organisation_destinataire: {
    type: DataTypes.STRING,
    allowNull: false
  },
  partenariat_actif: {
    type: DataTypes.STRING,
    allowNull: false
  },
  date_created: {
    type: DataTypes.STRING,
    allowNull: false
  },
  category: {
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
  tableName: 'partenariat_sante',
  timestamps: false // Disable Sequelize's default timestamps
});

module.exports = PartenariatSante;



