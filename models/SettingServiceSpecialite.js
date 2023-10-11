const { DataTypes } = require('sequelize');
const sequelize = require('../config').sequelize;

const SettingServiceSpecialite = sequelize.define('SettingServiceSpecialite', {
  idspe: {
    type: DataTypes.INTEGER,
    primaryKey: true,
    autoIncrement: true
  },
  name_specialite: {
    type: DataTypes.STRING,
    allowNull: false
  },
  id_service: {
    type: DataTypes.STRING,
    allowNull: false
  },
  code_specialite: {
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
  tableName: 'setting_service_specialite',
  timestamps: false // Disable Sequelize's default timestamps
});

module.exports = SettingServiceSpecialite;


