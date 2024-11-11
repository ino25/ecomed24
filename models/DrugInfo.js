const { DataTypes } = require("sequelize");
const sequelize = require("../config").sequelize;

const DrugInfo = sequelize.define(
  "DrugInfo",
  {
    id: {
      type: DataTypes.INTEGER,
      primaryKey: true,
      autoIncrement: true,
    },
    drugId: {
      type: DataTypes.INTEGER,
      allowNull: false,
      references: {
        model: "Drug", // Reference to the Drug model
        key: "id",
      },
      onUpdate: "CASCADE",
      onDelete: "CASCADE",
    },
    json_info: {
      type: DataTypes.JSON, // Storing drug information as JSON
      allowNull: false,
    },
    updated_by: {
      type: DataTypes.STRING(50), // Shortened length
      allowNull: false,
    },
    updated_at: {
      type: DataTypes.DATE,
      allowNull: false,
      defaultValue: DataTypes.NOW,
    },
  },
  {
    tableName: "drug_info", // Explicitly set table name
    timestamps: false, // Disable Sequelize's default timestamps
    hooks: {
      beforeUpdate: (drugInfo) => {
        drugInfo.updated_at = new Date(); // Update timestamp before update
      },
    },
  }
);

module.exports = DrugInfo;
