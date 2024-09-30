const { DataTypes } = require("sequelize");
const sequelize = require("../config").sequelize;

const UrgencyLevel = sequelize.define(
    "UrgencyLevel",
    {
        id: {
            type: DataTypes.INTEGER,
            primaryKey: true,
            autoIncrement: true,
        },

        name: {
            type: DataTypes.STRING,
            allowNull: true,
        },
        description: {
            type: DataTypes.STRING,
            allowNull: true,
        },
        status: {
            type: DataTypes.INTEGER,
            allowNull: false,
        },
        added_by: {
            type: DataTypes.INTEGER,
            allowNull: true,
        },
        updated_by: {
            type: DataTypes.INTEGER,
            allowNull: true,
        },
    },
    {
        tableName: "urgency_level",
        timestamps: true,
    }
);

module.exports = UrgencyLevel;
