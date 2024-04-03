const { DataTypes } = require('sequelize');
const sequelize = require('../config').sequelize;

const RolePermissionsMap = sequelize.define('RolePermissionsMap', {
  id: {
    type: DataTypes.INTEGER,
    primaryKey: true,
    autoIncrement: true
  },
  role_id: {
    type: DataTypes.STRING,
    allowNull: true
  },
  op_id: {
    type: DataTypes.STRING,
    allowNull: true
  },
  org_id: {
    type: DataTypes.STRING,
    allowNull: true
  },
  status: {
    type: DataTypes.STRING,
    allowNull: true
  },
  added_by: {
    type: DataTypes.INTEGER,
    allowNull: true
  },
  updated_by: {
    type: DataTypes.INTEGER,
    allowNull: true
  },
  
  
  
}, {
  tableName: 'role_permissions_map',
  timestamps: true // Disable Sequelize's default timestamps
});

module.exports = RolePermissionsMap;



