const { DataTypes } = require('sequelize');
const { sequelize } = require('../config');

const DepenseType = sequelize.define('DepenseType', {
  libelle: {
    type: DataTypes.STRING,
    allowNull: false
  },
  description: {
    type: DataTypes.STRING
  },
  created_by: {
    type: DataTypes.INTEGER,
    allowNull: false
  },
  last_updated_by: {
    type: DataTypes.INTEGER
  }
}, {
  tableName: 'depense_types',
  timestamps: true,
  paranoid: true, 
  deletedAt: 'deleted_at'
});

module.exports = DepenseType;
