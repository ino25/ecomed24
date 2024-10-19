// models/HelpCategory.js
const { Model, DataTypes } = require("sequelize");
const { sequelize } = require("../config");

class HelpCategory extends Model {}

HelpCategory.init(
  {
    id: {
      type: DataTypes.INTEGER,
      primaryKey: true,
      autoIncrement: true,
    },
    name: {
      type: DataTypes.STRING,
      allowNull: false,
      unique: true,
    },
    status: {
      type: DataTypes.ENUM,
      values: ["active", "inactive"],
      defaultValue: "active",
    },
    modifiedBy: {
      type: DataTypes.STRING,
      allowNull: false,
    },
  },
  {
    sequelize,
    modelName: "HelpCategory",
    tableName: "HelpCategories",
    timestamps: true, // Sequelize will handle timestamps automatically
  }
);

// Hook to update the updatedAt field on update
HelpCategory.addHook("beforeUpdate", (category) => {
  category.updatedAt = new Date();
});

HelpCategory.associate = (models) => {
  HelpCategory.hasMany(models.HelpTopic, {
    foreignKey: "categoryId",
    as: "topics",
  });
};

module.exports = HelpCategory;
