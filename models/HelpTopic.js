const { DataTypes } = require("sequelize");
const { sequelize } = require("../config");
const HelpCategory = require("./HelpCategory");

const HelpTopic = sequelize.define(
  "HelpTopic",
  {
    id: {
      type: DataTypes.INTEGER,
      primaryKey: true,
      autoIncrement: true,
    },
    name: {
      type: DataTypes.STRING,
      allowNull: false,
    },
    helpText: {
      type: DataTypes.TEXT,
      allowNull: false,
    },
    status: {
      type: DataTypes.ENUM,
      values: ["active", "inactive"],
      defaultValue: "active",
    },
    added_by: {
      type: DataTypes.INTEGER,
      allowNull: true,
    },
    updated_by: {
      type: DataTypes.INTEGER,
      allowNull: true,
    },
    categoryId: {
      type: DataTypes.INTEGER,
      references: {
        model: HelpCategory,
        key: "id",
      },
    },
  },
  {
    tableName: "HelpTopics",
    timestamps: true,
  }
);

HelpTopic.associate = (models) => {
  const { DataTypes } = require("sequelize");
  const sequelize = require("../config").sequelize;

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
    },
    {
      tableName: "help_topic",
      timestamps: false, // Disable Sequelize's default timestamps
    }
  );

  module.exports = HelpTopic;

  HelpTopic.belongsTo(models.HelpCategory, {
    foreignKey: "categoryId",
    as: "category",
  });
};

module.exports = HelpTopic;
