const { DataTypes } = require('sequelize');
const sequelize = require('../config').sequelize;

const TiersPayant = sequelize.define('TiersPayant', {
  id: {
    type: DataTypes.INTEGER,
    primaryKey: true,
    autoIncrement: true
  },
  code: {
    type: DataTypes.STRING,
    allowNull: false
  },
  prix_assurance: {
    type: DataTypes.STRING,
    allowNull: false
  },
  prix_ipm: {
    type: DataTypes.STRING,
    allowNull: false
  },
  country_code: {
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
  tableName: 'tiers_payant',
  timestamps: false // Disable Sequelize's default timestamps
});

module.exports = TiersPayant;


