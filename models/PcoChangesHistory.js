const { DataTypes } = require('sequelize');
const sequelize = require('../config').sequelize;

const PcoChangesHistory = sequelize.define('PcoChangesHistory', {
  id: {
    type: DataTypes.INTEGER,
    primaryKey: true,
    autoIncrement: true
  },
  idpco: {
    type: DataTypes.STRING,
    allowNull: false
  },
  new_tarif_public: {
    type: DataTypes.STRING,
    allowNull: false,
    unique: true
  },
  new_tarif_professionnel: {
    type: DataTypes.STRING,
    allowNull: false
  },
  new_tarif_assurance: {
    type: DataTypes.STRING,
    allowNull: false
  },
  new_tarif_ipm: {
    type: DataTypes.STRING,
    allowNull: false
  },
  date: {
    type: DataTypes.STRING,
    allowNull: false
  },
  changed_by_user: {
    type: DataTypes.STRING,
    allowNull: false
  },
  is_initial: {
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
  tableName: 'pco_changes_history',
  timestamps: false // Disable Sequelize's default timestamps
});

module.exports = PcoChangesHistory;


