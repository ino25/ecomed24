const { DataTypes } = require('sequelize');
const sequelize = require('../config').sequelize;

const MeetingSettings = sequelize.define('MeetingSettings', {
  id: {
    type: DataTypes.INTEGER,
    primaryKey: true,
    autoIncrement: true
  },
  api_key: {
    type: DataTypes.STRING,
    allowNull: false
  },
  secret_key: {
    type: DataTypes.STRING,
    allowNull: false
  },
  ion_user_id: {
    type: DataTypes.STRING,
    allowNull: false
  },
  y: {
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
  tableName: 'meeting_settings',
  timestamps: false // Disable Sequelize's default timestamps
});

module.exports = MeetingSettings;



