const { DataTypes } = require('sequelize');
const sequelize = require('../config').sequelize;

const VisitReason = sequelize.define('VisitReason', {
    id: {
        type: DataTypes.INTEGER,
        primaryKey: true,
        autoIncrement: true
    },
    name: {
        type: DataTypes.STRING,
        allowNull: true
    },
    description: {
        type: DataTypes.STRING,
        allowNull: true
    },
    tag: {
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
    tableName: 'visit_reason',
    timestamps: true
});

module.exports = VisitReason;



