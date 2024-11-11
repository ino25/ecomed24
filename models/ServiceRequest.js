const { DataTypes } = require("sequelize");
const sequelize = require("../config").sequelize;

const ServiceRequest = sequelize.define(
  "ServiceRequest",
  {
    requestID: {
      type: DataTypes.INTEGER,
      autoIncrement: true,
      primaryKey: true,
    },
    patientID: {
      type: DataTypes.INTEGER,
      allowNull: false,
    },
    organisationID: {
      type: DataTypes.INTEGER,
      allowNull: false,
    },
    partenaireID: {
      type: DataTypes.INTEGER,
      allowNull: true,
    },
    status: {
      type: DataTypes.STRING(50),
      allowNull: false,
      defaultValue: "PENDING",
    },
    total_amount: {
      type: DataTypes.DECIMAL(10, 2),
      allowNull: true,
    },
    discount_amount: {
      type: DataTypes.DECIMAL(10, 2),
      allowNull: true,
      defaultValue: 0.0,
    },
    insured_amount: {
      type: DataTypes.DECIMAL(10, 2),
      allowNull: true,
      defaultValue: 0.0,
    },
    net_amount: {
      type: DataTypes.DECIMAL(10, 2),
      allowNull: true,
    },
    amount_paid: {
      type: DataTypes.DECIMAL(10, 2),
      allowNull: true,
      defaultValue: 0.0,
    },
    remaining_balance: {
      type: DataTypes.DECIMAL(10, 2),
      allowNull: true,
    },
    prescripteur: {
      type: DataTypes.STRING(255),
      allowNull: true,
    },
    lastModifiedBy: {
      type: DataTypes.INTEGER,
      allowNull: true,
    },
    lastModifiedAt: {
      type: DataTypes.DATE,
      allowNull: true,
    },
  },
  {
    tableName: "servicerequest",
    timestamps: false,
  }
);

module.exports = ServiceRequest;
