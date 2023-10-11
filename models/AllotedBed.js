const { DataTypes } = require('sequelize');
const sequelize = require('../config').sequelize;

const AllotedBed = sequelize.define('AllotedBed', {
  id: {
    type: DataTypes.INTEGER,
    primaryKey: true,
    autoIncrement: true
  },
  number: {
    type: DataTypes.STRING,
    allowNull: false
  },
  category: {
    type: DataTypes.STRING,
    allowNull: false,
    unique: true
  },
  patient: {
    type: DataTypes.STRING,
    allowNull: false
  },
  a_time: {
    type: DataTypes.STRING,
    allowNull: false
  },
  d_time: {
    type: DataTypes.STRING,
    allowNull: false
  },
  status: {
    type: DataTypes.STRING,
    allowNull: false
  },
  x: {
    type: DataTypes.STRING,
    allowNull: false
  },
  bed_id: {
    type: DataTypes.STRING,
    allowNull: false
  },
  patientname: {
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
  tableName: 'alloted_bed',
  timestamps: false // Disable Sequelize's default timestamps
});

module.exports = AllotedBed;



