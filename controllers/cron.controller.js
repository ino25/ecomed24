const Sequelize = require("sequelize");
const Database = require("../config").sequelize;
const Op = Sequelize.Op;
const moment = require("moment");
moment.locale("en");
const { Mailer } = require("../helpers/Mailer");
var Email = require("../models/Email");
// Permission
const emailSchedule = async (req, res) => {
  try {
    EmailModal = await Email.findAll({
      where: { is_sent: null },
      order: [["id", "DESC"]],
    });

    if (Email === null) {
      res.json({ status: 0, message: "No data found" });
    } else {
      EmailModal.forEach(async (row) => {
        const status = await Mailer(
          row.reciepient,
          "",
          row.subject,
          row.message
        );
        // if (status) {
        EmailModal2 = await Email.update(
          { is_sent: 1, date: moment().format("YYYY-MM-DD HH:mm:ss") },
          { where: { id: row.id } }
        );
        // }
        console.log(status);
      });
      res.json({
        status: 1,
        message: "Fatched",
        data: EmailModal,
      });
    }
  } catch (error) {
    throw error;
  }
};

module.exports = { emailSchedule };
