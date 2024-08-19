const { DataTypes } = require("sequelize");
const sequelize = require("../config").sequelize;

const OrganizationPermissions = sequelize.define(
  "OrganizationPermissions",
  {
    id: {
      type: DataTypes.INTEGER,
      primaryKey: true,
      autoIncrement: true,
    },
    org_id: {
      type: DataTypes.STRING,
      allowNull: true,
    },
    start_date: {
      type: DataTypes.STRING,
      allowNull: true,
    },
    end_date: {
      type: DataTypes.STRING,
      allowNull: true,
    },
    status: {
      type: DataTypes.STRING,
      allowNull: true,
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
    tableName: "organization_permissions",
    timestamps: true, // Disable Sequelize's default timestamps
  }
);

module.exports = OrganizationPermissions;
