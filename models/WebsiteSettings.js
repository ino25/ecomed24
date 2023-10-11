const { DataTypes } = require('sequelize');
const sequelize = require('../config').sequelize;

const WebsiteSettings = sequelize.define('WebsiteSettings', {
  id: {
    type: DataTypes.INTEGER,
    primaryKey: true,
    autoIncrement: true
  },
  title: {
    type: DataTypes.STRING,
    allowNull: false
  },
  logo: {
    type: DataTypes.STRING,
    allowNull: false
  },
  address: {
    type: DataTypes.STRING,
    allowNull: false
  },
  phone: {
    type: DataTypes.STRING,
    allowNull: false
  },
  emergency: {
    type: DataTypes.STRING,
    allowNull: false
  },
  support: {
    type: DataTypes.STRING,
    allowNull: false
  },
  email: {
    type: DataTypes.STRING,
    allowNull: false
  },
  currency: {
    type: DataTypes.STRING,
    allowNull: false
  },
  block_1_text_under_title: {
    type: DataTypes.STRING,
    allowNull: false
  },
  service_block__text_under_title: {
    type: DataTypes.STRING,
    allowNull: false
  },
  doctor_block__text_under_title: {
    type: DataTypes.STRING,
    allowNull: false
  },
  facebook_id: {
    type: DataTypes.STRING,
    allowNull: false
  },
  twitter_id: {
    type: DataTypes.STRING,
    allowNull: false
  },
  google_id: {
    type: DataTypes.STRING,
    allowNull: false
  },
  youtube_id: {
    type: DataTypes.STRING,
    allowNull: false
  },
  skype_id: {
    type: DataTypes.STRING,
    allowNull: false
  },
  x: {
    type: DataTypes.STRING,
    allowNull: false
  },
  twitter_username: {
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
  tableName: 'website_settings',
  timestamps: false // Disable Sequelize's default timestamps
});

module.exports = WebsiteSettings;


