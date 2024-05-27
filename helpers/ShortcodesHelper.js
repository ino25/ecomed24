const https = require("https");
const fs = require("fs");
const moment = require("moment");
moment.locale("en");
const Sequelize = require("sequelize");
const Database = require("../config").sequelize;
const Op = Sequelize.Op;

function replaceShortcodes(template, replacements) {
  let result = template;
  for (const [key, value] of Object.entries(replacements)) {
    const regex = new RegExp(`{${key}}`, "g");
    result = result.replace(regex, value);
  }
  return result;
}

module.exports = {
  replaceShortcodes,
};
