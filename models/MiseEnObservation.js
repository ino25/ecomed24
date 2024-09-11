const { DataTypes } = require("sequelize");
const sequelize = require("../config").sequelize;

const MiseEnObservation = sequelize.define(
    "MiseEnObservation",
    {
        id: {
            type: DataTypes.INTEGER,
            primaryKey: true,
            autoIncrement: true,
        },
        patient_id: {
            type: DataTypes.INTEGER,
            allowNull: false,
        },
        org_id: {
            type: DataTypes.INTEGER,
            allowNull: false,
        },
        MiseenObservation: {
            type: DataTypes.STRING,
            allowNull: true,
        },
        arrivalDateTime: {
            type: DataTypes.STRING,
            allowNull: false,
        },

        clinicalSummary: {
            type: DataTypes.STRING,
            allowNull: true,
        },
        requestedTests: {
            type: DataTypes.STRING,
            allowNull: true,
        },
        providedTreatment: {
            type: DataTypes.STRING,
            allowNull: true,
        },
        observation: {
            type: DataTypes.STRING,
            allowNull: true,
        },
        evolutions: {
            type: DataTypes.STRING,
            allowNull: true,
        },

        status: {
            type: DataTypes.INTEGER,
            allowNull: false,
        },
        added_by: {
            type: DataTypes.INTEGER,
            allowNull: false,
        },
        updated_by: {
            type: DataTypes.INTEGER,
            allowNull: true,
        },
    },
    {
        tableName: "mise_en_observation",
        timestamps: true,
    }
);

module.exports = MiseEnObservation;
