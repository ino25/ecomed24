const { DataTypes } = require("sequelize");
const sequelize = require("../config").sequelize;

const ReferenceForm = sequelize.define(
    "ReferenceForm",
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
        bulletin_de_transfer: {
            type: DataTypes.STRING,
            allowNull: true,
        },
        arrivalDateTime: {
            type: DataTypes.STRING,
            allowNull: false,
        },
        transferDateTime: {
            type: DataTypes.STRING,
            allowNull: true,
        },
        transferReason: {
            type: DataTypes.STRING,
            allowNull: true,
        },
        clinicalSummary: {
            type: DataTypes.STRING,
            allowNull: true,
        },
        providedTreatment: {
            type: DataTypes.STRING,
            allowNull: true,
        },
        urgencyLevel: {
            type: DataTypes.INTEGER,
            allowNull: true,
        },
        targetOrganisationType: {
            type: DataTypes.INTEGER,
            allowNull: true,
        },
        targetServiceType: {
            type: DataTypes.INTEGER,
            allowNull: true,
        },
        transportationMean: {
            type: DataTypes.INTEGER,
            allowNull: true,
        },

        carePerson: {
            type: DataTypes.INTEGER,
            allowNull: true,
        },
        ouverture_des_yeux: {
            type: DataTypes.STRING,
            allowNull: true,
        },
        reponse_verbale: {
            type: DataTypes.STRING,
            allowNull: true,
        },
        reponse_motrice: {
            type: DataTypes.STRING,
            allowNull: true,
        },
        status: {
            type: DataTypes.INTEGER,
            allowNull: false,
        },
        gcs_total: {
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
        tableName: "reference_form",
        timestamps: true,
    }
);

module.exports = ReferenceForm;
