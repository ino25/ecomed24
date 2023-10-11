const { DataTypes } = require('sequelize');
const sequelize = require('../config').sequelize;

const Slide = sequelize.define('Slide', {
  id: {
    type: DataTypes.INTEGER,
    primaryKey: true,
    autoIncrement: true
  },
  id_service: {
    type: DataTypes.STRING,
    allowNull: false
  },
  id_specialite: {
    type: DataTypes.STRING,
    allowNull: false
  },
  id_organisation: {
    type: DataTypes.STRING,
    allowNull: false
  },
  statut: {
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
  tableName: 'slide',
  timestamps: false // Disable Sequelize's default timestamps
});

module.exports = Slide;


