const { DataTypes } = require('sequelize');
const sequelize = require('../config').sequelize;

const DepartementSenegal = sequelize.define('DepartementSenegal', {
  id: {
    type: DataTypes.INTEGER,
    primaryKey: true,
    autoIncrement: true
  },
  id_region: {
    type: DataTypes.STRING,
    allowNull: false
  },
  label: {
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
  tableName: 'departement_senegal',
  timestamps: false // Disable Sequelize's default timestamps
});

module.exports = DepartementSenegal;



