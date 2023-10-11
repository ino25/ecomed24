const { DataTypes } = require('sequelize');
const sequelize = require('../config').sequelize;

const Illness = sequelize.define('Illness', {
  id: {
    type: DataTypes.INTEGER,
    primaryKey: true,
    autoIncrement: true
  },
  code: {
    type: DataTypes.STRING,
    allowNull: true
  },
  affection: {
    type: DataTypes.STRING,
    allowNull: true
  },
  groupe_maladie: {
    type: DataTypes.STRING,
    allowNull: true
  },
  sous_groupe: {
    type: DataTypes.STRING,
    allowNull: true
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
  tableName: 'illness',
  timestamps: false // Disable Sequelize's default timestamps
});

module.exports = Illness;



