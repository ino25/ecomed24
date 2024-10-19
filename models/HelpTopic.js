const { DataTypes } = require("sequelize");
const { sequelize } = require("../config");
const Module = require("./Module");

const HelpTopic = sequelize.define(
  "HelpTopic",
  {
    id: {
      type: DataTypes.INTEGER,
      primaryKey: true,
      autoIncrement: true,
    },
    category: {
      type: DataTypes.STRING,
      allowNull: false,
    },
    name: {
      type: DataTypes.STRING,
      allowNull: false,
    },
    helpText: {
      type: DataTypes.TEXT,
      allowNull: false,
    },
    searchCount: {
      type: DataTypes.INTEGER,
      defaultValue: 0,
    },
    viewsCount: {
      type: DataTypes.INTEGER,
      defaultValue: 0,
    },
    lastAccessed: {
      type: DataTypes.DATE,
      allowNull: true,
    },
    modifiedBy: {
      type: DataTypes.STRING,
      allowNull: true,
    },
    author: {
      type: DataTypes.STRING,
      allowNull: false,
    },
    status: {
      type: DataTypes.STRING,
      allowNull: false,
      defaultValue: "draft",
    },
    ratings: {
      type: DataTypes.FLOAT,
      defaultValue: 0,
    },
    feedbackCount: {
      type: DataTypes.INTEGER,
      defaultValue: 0,
    },
    tags: {
      type: DataTypes.JSON,
      allowNull: true,
    },
    // Foreign key to associate with Module
    moduleId: {
      type: DataTypes.INTEGER,
      references: {
        model: "Module", // Table name
        key: "id",
      },
      onUpdate: "CASCADE",
      onDelete: "SET NULL",
    },
  },
  {
    tableName: "help_topic",
    timestamps: false, // Disable Sequelize's default timestamps
  }
);

// Define association between HelpTopic and Module
/*HelpTopic.belongsTo(Module, {
  foreignKey: "moduleId",
  as: "module", // Alias for the association
});*/

module.exports = HelpTopic;
