const mail = require("../config").mailConfig;
const nodemailer = require("nodemailer");

// Send Mail
async function LabMailer(to, from, subject, html, attachments) {
  try {
    let transporter = nodemailer.createTransport(mail);
    await transporter.sendMail(
      {
        to: to,
        from: from,
        subject: subject,
        html: html,
        attachments: attachments,
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

module.exports = LabMailer;
