const { DataTypes } = require("sequelize");
const sequelize = require("../config").sequelize;

const TeleconferenceLink = sequelize.define(
  "TeleconferenceLink",
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
    evenement_id: { // 🔥 ici au lieu de rendezvous_id
      type: DataTypes.INTEGER,
      allowNull: false,
    },
    room_url: {
      type: DataTypes.STRING(500),
      allowNull: false,
    },
    expiration: {
      type: DataTypes.DATE,
      allowNull: true,
    },
    created_by: {
      type: DataTypes.STRING,
      allowNull: true,
    },
    updated_by: {
      type: DataTypes.STRING,
      allowNull: true,
    },
  },
  {
    tableName: "teleconference_links",
    timestamps: true,
  }
);

module.exports = TeleconferenceLink;
