const { DataTypes } = require("sequelize");
const sequelize = require("../config").sequelize;

const Email = sequelize.define(
  "Email",
  {
    id: {
      type: DataTypes.INTEGER,
      primaryKey: true,
      autoIncrement: true,
    },
    is_sent: {
      type: DataTypes.STRING,
      allowNull: true,
    },
    subject: {
      type: DataTypes.STRING,
      allowNull: true,
    },
    date: {
      type: DataTypes.STRING,
      allowNull: true,
    },
    message: {
      type: DataTypes.STRING,
      allowNull: true,
    },
    reciepient: {
      type: DataTypes.STRING,
      allowNull: true,
    },
    attachment_path: {
      type: DataTypes.STRING,
      allowNull: true,
    },
    user: {
      type: DataTypes.STRING,
      allowNull: true,
    },
  },
  {
    tableName: "email",
    timestamps: false, // Disable Sequelize's default timestamps
  }
);

module.exports = Email;
