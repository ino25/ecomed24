const { DataTypes } = require('sequelize');
const sequelize = require('../config').sequelize;

const Keys = sequelize.define('Keys', {
  id: {
    type: DataTypes.INTEGER,
    primaryKey: true,
    autoIncrement: true
  },
  user_id: {
    type: DataTypes.STRING,
    allowNull: false
  },
  key: {
    type: DataTypes.STRING,
    allowNull: false
  },
  level: {
    type: DataTypes.STRING,
    allowNull: false
  },
  ignore_limits: {
    type: DataTypes.STRING,
    allowNull: false
  },
  is_private_key: {
    type: DataTypes.STRING,
    allowNull: false
  },
  ip_addresses: {
    type: DataTypes.STRING,
    allowNull: false
  },
  date_created: {
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
  tableName: 'keys',
  timestamps: false // Disable Sequelize's default timestamps
});

module.exports = Keys;



