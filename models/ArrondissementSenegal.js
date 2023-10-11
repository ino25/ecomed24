const { DataTypes } = require('sequelize');
const sequelize = require('../config').sequelize;

const ArrondissementSenegal = sequelize.define('ArrondissementSenegal', {
  id: {
    type: DataTypes.INTEGER,
    primaryKey: true,
    autoIncrement: true
  },
  id_departement: {
    type: DataTypes.STRING,
    allowNull: false
  },
  label: {
    type: DataTypes.STRING,
    allowNull: false,
    unique: true
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
  tableName: 'arrondissement_senegal',
  timestamps: false // Disable Sequelize's default timestamps
});

module.exports = ArrondissementSenegal;



