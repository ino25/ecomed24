const mail = require("../config").mailConfig;
const nodemailer = require("nodemailer");

// Send Mail
async function Mailer(to, from, subject, html) {
  try {
    let transporter = nodemailer.createTransport(mail);
    await transporter.sendMail(
      {
        to: to,
        from: process.env.MFROM,
        subject: subject,
        html: html,
      },
      (error, info) => {
        if (error) {
          return false;
        }
        return true;
      }
    );
  } catch (error) {
    throw error;
  }
}

module.exports = {
  Mailer,
};
