const i18n = require("i18n");
const langRoleModule = i18n.__("Roles");
const langCommon = i18n.__("common");
const Sequelize = require("sequelize");
const Database = require("../config").sequelize;
const Op = Sequelize.Op;
const moment = require("moment");
moment.locale("en");
const path = require("path");
const nodemailer = require("nodemailer");

var User = require("../models/User");
var District = require("../models/District");
var Region = require("../models/Region");
var Appointment = require("../models/Appointment");
var Patient = require("../models/Patient");
var Payment = require("../models/Payment");

//////Modal Relationship

// Role.belongsTo(User, { as: "addedby_details", foreignKey: "added_by" });
// Role.belongsTo(User, { as: "updatedby_details", foreignKey: "updated_by" });
// Role.belongsTo(Organisation, { as: "org_details", foreignKey: "org_id" });

// Role.hasMany(RolePermissionsMap, { as: "permissions", foreignKey: "role_id" });
// Function to get the start and end dates for the specified date type
function getDateRange(dateType) {
  let startDate, endDate;
  const now = moment();

  switch (dateType) {
    case "this_week":
      startDate = now.startOf("week").toDate();
      endDate = now.endOf("week").toDate();
      break;
    case "last_week":
      startDate = now.subtract(1, "weeks").startOf("week").toDate();
      endDate = now.endOf("week").toDate();
      break;
    case "this_month":
      startDate = now.startOf("month").toDate();
      endDate = now.endOf("month").toDate();
      break;
    case "last_month":
      startDate = now.subtract(1, "months").startOf("month").toDate();
      endDate = now.endOf("month").toDate();
      break;
    case "this_quarter":
      startDate = now.startOf("quarter").toDate();
      endDate = now.endOf("quarter").toDate();
      break;
    case "last_quarter":
      startDate = now.subtract(1, "quarters").startOf("quarter").toDate();
      endDate = now.subtract(1, "quarters").endOf("quarter").toDate();
      break;
    case "this_year":
      startDate = now.startOf("year").toDate();
      endDate = now.endOf("year").toDate();
      break;
    case "last_year":
      startDate = now.subtract(1, "years").startOf("year").toDate();
      endDate = now.subtract(1, "years").endOf("year").toDate();
      break;
    // Add more cases for other date types if needed
    default:
      startDate = moment().toDate();
      endDate = moment().toDate();
  }

  return { startDate, endDate };
}

exports.getNosologieReport = async (req, res) => {
  try {
    const { date_type, from_date, to_date } = req.query;

    let dateCondition = "";
    if (date_type) {
      if (date_type === "date_range" && from_date && to_date) {
        const startDate = moment(from_date).format("YYYY-MM-DD 00:00:00");
        const endDate = moment(to_date).format("YYYY-MM-DD 23:59:59");
        dateCondition = `AND d.createdAt BETWEEN '${startDate}' AND '${endDate}'`;
      } else {
        const { startDate, endDate } = getDateRange(date_type);
        const formattedStartDate = moment(startDate).format(
          "YYYY-MM-DD 00:00:00"
        );
        const formattedEndDate = moment(endDate).format("YYYY-MM-DD 23:59:59");
        dateCondition = `AND d.createdAt BETWEEN '${formattedStartDate}' AND '${formattedEndDate}'`;
      }
    }
    // req.org_id;
    const sql = `
          SELECT
              sub.name,
              COUNT(CASE WHEN p.age BETWEEN 0 AND 1 AND p.sex = 'Masculin' THEN 1 END) AS '0 - 1 an M',
              COUNT(CASE WHEN p.age BETWEEN 0 AND 1 AND p.sex = 'Feminin' THEN 1 END) AS '0 - 1 an F',
              COUNT(CASE WHEN p.age BETWEEN 2 AND 4 AND p.sex = 'Masculin' THEN 1 END) AS '1 - 4 ans M',
              COUNT(CASE WHEN p.age BETWEEN 2 AND 4 AND p.sex = 'Feminin' THEN 1 END) AS '1 - 4 ans F',
              COUNT(CASE WHEN p.age BETWEEN 5 AND 14 AND p.sex = 'Masculin' THEN 1 END) AS '5 - 14 ans M',
              COUNT(CASE WHEN p.age BETWEEN 5 AND 14 AND p.sex = 'Feminin' THEN 1 END) AS '5 - 14 ans F',
              COUNT(CASE WHEN p.age BETWEEN 15 AND 19 AND p.sex = 'Masculin' THEN 1 END) AS '15 - 19 ans M',
              COUNT(CASE WHEN p.age BETWEEN 15 AND 19 AND p.sex = 'Feminin' THEN 1 END) AS '15 - 19 ans F',
              COUNT(CASE WHEN p.age BETWEEN 20 AND 25 AND p.sex = 'Masculin' THEN 1 END) AS '20 - 25 ans M',
              COUNT(CASE WHEN p.age BETWEEN 20 AND 25 AND p.sex = 'Feminin' THEN 1 END) AS '20 - 25 ans F',
              COUNT(CASE WHEN p.age BETWEEN 26 AND 49 AND p.sex = 'Masculin' THEN 1 END) AS '26 - 49 ans M',
              COUNT(CASE WHEN p.age BETWEEN 26 AND 49 AND p.sex = 'Feminin' THEN 1 END) AS '26 - 49 ans F',
              COUNT(CASE WHEN p.age BETWEEN 50 AND 59 AND p.sex = 'Masculin' THEN 1 END) AS '50 - 59 ans M',
              COUNT(CASE WHEN p.age BETWEEN 50 AND 59 AND p.sex = 'Feminin' THEN 1 END) AS '50 - 59 ans F',
              COUNT(CASE WHEN p.age >= 60 AND p.sex = 'Masculin' THEN 1 END) AS '60 ans & + M',
              COUNT(CASE WHEN p.age >= 60 AND p.sex = 'Feminin' THEN 1 END) AS '60 ans & + F',
              COUNT(CASE WHEN p.age IS NULL AND p.sex = 'Masculin' THEN 1 END) AS 'Age ND M',
              COUNT(CASE WHEN p.age IS NULL AND p.sex = 'Feminin' THEN 1 END) AS 'Age ND F',
              COUNT(*) AS 'TOTAL'
          FROM (
              SELECT
                  name,
                  COUNT(*) as disease_count
              FROM
                  clinical_desease
                  WHERE clinical_desease.type='nosologie' and org_id=${req.org_id}
              GROUP BY
                  name
              ORDER BY
                  disease_count DESC
          ) sub
          INNER JOIN
              clinical_desease d ON sub.name = d.name
          INNER JOIN
              patient p ON p.id = d.patient_id
          WHERE d.type='nosologie' ${dateCondition}
          GROUP BY
              sub.name
      `;

    OrganisationModal = await Database.query(sql, {
      type: Database.QueryTypes.SELECT,
    });

    if (OrganisationModal === null) {
      res.json({ status: 0, message: langCommon.nodatafound });
    } else {
      res.json({
        status: 1,
        message: "Nosologie Report Fetched.",
        data: OrganisationModal,
      });
    }
  } catch (error) {
    throw error;
  }
};
