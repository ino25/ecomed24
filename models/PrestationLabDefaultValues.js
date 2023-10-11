const { DataTypes } = require('sequelize');
const sequelize = require('../config').sequelize;

const PrestationLabDefaultValues = sequelize.define('PrestationLabDefaultValues', {
  id: {
    type: DataTypes.INTEGER,
    primaryKey: true,
    autoIncrement: true
  },
  id_prestation: {
    type: DataTypes.STRING,
    allowNull: false
  },
  default_unite: {
    type: DataTypes.STRING,
    allowNull: false,
  },
  default_valeurs: {
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
  tableName: 'prestation_lab_default_values',
  timestamps: false // Disable Sequelize's default timestamps
});

module.exports = PrestationLabDefaultValues;


