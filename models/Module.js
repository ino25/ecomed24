const { DataTypes } = require("sequelize");
const sequelize = require("../config").sequelize;
const HelpTopic = require("./HelpTopic");

const Module = sequelize.define(
  "Module",
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
    code: {
      type: DataTypes.STRING,
      allowNull: true,
    },
  },
  {
    tableName: "modules",
    timestamps: true,
  }
);

// Define the reverse association (Module has many HelpTopics)
/*Module.hasMany(HelpTopic, {
  foreignKey: "moduleId",
  as: "helpTopics",
});*/

module.exports = Module;
