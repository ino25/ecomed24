const { DataTypes } = require('sequelize');
const sequelize = require('../config').sequelize;

const SanteAssurancePrestation = sequelize.define('SanteAssurancePrestation', {
  id_partenariat_sante_assurance: {
    type: DataTypes.INTEGER,
    primaryKey: true,
    autoIncrement: true
  },
  id_payment_category: {
    type: DataTypes.STRING,
    allowNull: false
  },
  est_couverte: {
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
  tableName: 'sante_assurance_prestation',
  timestamps: false // Disable Sequelize's default timestamps
});

module.exports = SanteAssurancePrestation;


