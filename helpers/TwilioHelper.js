
const moment = require("moment");
const twilio = require("twilio");

const Database = require("../config").sequelize; // Adjust based on your actual configuration export
const Op = Sequelize.Op;

// Set locale for moment
moment.locale("en");


// Twilio Configuration
const twilioAccountSid = process.env.TWILIO_ACCOUNT_SID || "your_account_sid";
const twilioAuthToken = process.env.TWILIO_AUTH_TOKEN || "your_auth_token";
const twilioPhoneNumber = process.env.TWILIO_PHONE_NUMBER || "your_twilio_number";
const twilioClient = twilio(twilioAccountSid, twilioAuthToken);


/**
 * Send a WhatsApp notification using Twilio
 * @param {string} to - Recipient's WhatsApp number in E.164 format (e.g., 'whatsapp:+1234567890')
 * @param {string} message - Message to send
 * @returns {Promise<any>} - Twilio API response
 */
async function sendWhatsAppNotification(to, message) {
  try {
    const response = await twilioClient.messages.create({
      from: `whatsapp:${twilioPhoneNumber}`,
      to: `whatsapp:${to}`,
      body: message,
    });
    console.log("WhatsApp Message Sent:", response.sid);
    return response;
  } catch (error) {
    console.error("Error Sending WhatsApp Notification:", error.message);
    throw error;
  }
}

/**
 * Send an SMS notification using Twilio
 * @param {string} to - Recipient's phone number in E.164 format (e.g., '+1234567890')
 * @param {string} message - Message to send
 * @returns {Promise<any>} - Twilio API response
 */
async function sendSMSNotification(to, message) {
  try {
    const response = await twilioClient.messages.create({
      from: twilioPhoneNumber,
      to,
      body: message,
    });
    console.log("SMS Message Sent:", response.sid);
    return response;
  } catch (error) {
    console.error("Error Sending SMS Notification:", error.message);
    throw error;
  }
}

module.exports = {
  sendWhatsAppNotification,
  sendSMSNotification,
};
