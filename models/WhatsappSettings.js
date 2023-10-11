const { DataTypes } = require('sequelize');
const sequelize = require('../config').sequelize;

const WhatsappSettings = sequelize.define('WhatsappSettings', {
  id: {
    type: DataTypes.INTEGER,
    primaryKey: true,
    autoIncrement: true
  },
  instance_id: {
    type: DataTypes.STRING,
    allowNull: false
  },
  token: {
    type: DataTypes.STRING,
    allowNull: false
  },
  status_changed: {
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
  tableName: 'whatsapp_settings',
  timestamps: false // Disable Sequelize's default timestamps
});

module.exports = WhatsappSettings;


