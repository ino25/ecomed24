const https = require("https");
const fs = require("fs");
const moment = require("moment");
moment.locale("en");
const Sequelize = require("sequelize");
const Database = require("../config").sequelize;
const Op = Sequelize.Op;
// Docmosis
const BASEURL = process.env.SITE_URL;
const BASEPATH = process.env.BASE_PATH;
const APPOINTMENT_APIURL = process.env.APPOINTMENT_APIURL;
const apiKey = process.env.APPOINTMENT_APIKEY;
const axios = require('axios');
// Utility function to call third-party API with axios
async function appointmentAPI (url, method, data = null) {

  const options = {
    method,
    url: `${APPOINTMENT_APIURL}${url}`,
    headers: {
      'x-api-key': `${apiKey}`,  // Add your authorization token here
      'Content-Type': 'application/json',
    },
    data,
  };
  console.log(options);
  try {
    const response = await axios(options);
    return response.data;
  } catch (error) {
    console.error(`Error in ${method} ${url}:`, error.response ? error.response.data : error.message);
    // throw error;
  }
};
module.exports = {
  appointmentAPI
};
