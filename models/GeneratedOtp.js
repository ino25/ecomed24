const { DataTypes } = require("sequelize");
const sequelize = require("../config").sequelize;

const GeneratedOtp = sequelize.define(
  "GeneratedOtp",
  {
    id: {
      type: DataTypes.INTEGER,
      primaryKey: true,
      autoIncrement: true,
    },
    user_id: {
      type: DataTypes.STRING,
      allowNull: false,
    },
    mobile_number: {
      type: DataTypes.STRING,
      allowNull: false,
    },
    email: {
      type: DataTypes.STRING,
      allowNull: false,
    },
    otp: {
      type: DataTypes.STRING,
      allowNull: false,
    },
    date_created: {
      type: DataTypes.STRING,
      allowNull: false,
    },
    is_valid: {
      type: DataTypes.STRING,
      allowNull: true,
    },
    for_patient_record: {
      type: DataTypes.STRING,
      allowNull: true,
    },

    //   created_at: {
    //     type: DataTypes.DATE,
    //     allowNull: false,
    //     defaultValue: DataTypes.NOW
    //   },
    //   updated_at: {
    //     type: DataTypes.DATE,
    //     allowNull: false,
    //     defaultValue: DataTypes.NOW
    //   }
  },
  {
    tableName: "generated_otp",
    timestamps: false, // Disable Sequelize's default timestamps
  }
);

module.exports = GeneratedOtp;
