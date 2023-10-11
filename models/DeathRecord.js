const { DataTypes } = require('sequelize');
const sequelize = require('../config').sequelize;

const DeathRecord = sequelize.define('DeathRecord', {
  id: {
    type: DataTypes.INTEGER,
    primaryKey: true,
    autoIncrement: true
  },
  patient_id: {
    type: DataTypes.INTEGER,
    allowNull: false
  },
  org_id: {
    type: DataTypes.INTEGER,
    allowNull: false,
  },
  patient_name: {
    type: DataTypes.STRING,
    allowNull: false
  },
  gender: {
    type: DataTypes.STRING,
    allowNull: false
  },
  age: {
    type: DataTypes.INTEGER,
    allowNull: false
  },
  cause_of_death: {
    type: DataTypes.STRING,
    allowNull: false
  },
  manner_of_death: {
    type: DataTypes.STRING,
    allowNull: false
  },
  pregnancy_death_associated: {
    type: DataTypes.BOOLEAN,
    allowNull: false
  },
  was_there_delivery: {
    type: DataTypes.BOOLEAN,
    allowNull: false
  },
  dateofdeath: {
    type: DataTypes.STRING,
    allowNull: false
  },
  timeofdeath: {
    type: DataTypes.STRING,
    allowNull: false
  },
  status: {
    type: DataTypes.INTEGER,
    allowNull: false
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
  tableName: 'death_record',
  timestamps: true // Disable Sequelize's default timestamps
});

module.exports = DeathRecord;



