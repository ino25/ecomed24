const { DataTypes } = require("sequelize");
const sequelize = require("../config").sequelize;

const OrgPermissionItems = sequelize.define(
  "OrgPermissionItems",
  {
    id: {
      type: DataTypes.INTEGER,
      primaryKey: true,
      autoIncrement: true,
    },
    sp_id: {
      type: DataTypes.STRING,
      allowNull: true,
    },
    org_id: {
      type: DataTypes.STRING,
      allowNull: true,
    },
    org_permissionid: {
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
    tableName: "org_permission_items",
    timestamps: true, // Disable Sequelize's default timestamps
  }
);

module.exports = OrgPermissionItems;
