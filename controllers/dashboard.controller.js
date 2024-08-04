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
exports.getTotals = async (req, res) => {
  try {
    const { date_type, from_date, to_date } = req.query;

    // Initialize an empty object to store dynamic conditions
    let conditions = {};
    // conditions.patient_id = req.params.patient_id;

    // Date conditions based on date_type or custom range
    // let startDate, endDate;
    if (date_type) {
      if (date_type == "date_range") {
        const startDate = moment(from_date).format("YYYY-MM-DD 00:00:00");
        const endDate = moment(to_date).format("YYYY-MM-DD 00:00:00");
        conditions.createdAt = {
          [Op.between]: [startDate, endDate],
        };
      } else {
        const { startDate, endDate } = getDateRange(date_type);
        conditions.createdAt = {
          [Op.between]: [startDate, endDate],
        };
      }
    } else {
      const { startDate, endDate } = getDateRange("this_month");
      conditions.createdAt = {
        [Op.between]: [startDate, endDate],
      };
    }

    let data = {};

    data.total_patients = await Patient.count({ where: { status: 1 } });
    data.new_patients = await Patient.count({ where: conditions });
    data.scheduled_appointment = await Appointment.count({ where: conditions });
    data.completed_appointment = await Appointment.count({
      where: { status: 2, createdAt: conditions.createdAt },
    });
    data.revenue = await Payment.sum("amount_received");

    const outstanding = await Payment.findOne({
      attributes: [
        [
          Sequelize.fn(
            "SUM",
            Sequelize.literal("(gross_total + frais_service) - amount_received")
          ),
          "outstanding_payments",
        ],
      ],
      raw: true,
    });
    // console.log(totalExpression);
    data.outstanding_payments = outstanding.outstanding_payments;
    if (data === null) {
      res.json({ status: 0, message: langCommon.nodatafound });
    } else {
      res.json({ status: 1, message: "Dashboard totals fetched.", data: data });
    }
  } catch (error) {
    throw error;
  }
};

exports.getPatientDemographic = async (req, res) => {
  try {
    const { date_type, from_date, to_date } = req.query;

    // Initialize an empty object to store dynamic conditions
    let conditions = {};
    // conditions.patient_id = req.params.patient_id;

    // Date conditions based on date_type or custom range
    // let startDate, endDate;
    if (date_type) {
      if (date_type == "date_range") {
        const startDate = moment(from_date).format("YYYY-MM-DD 00:00:00");
        const endDate = moment(to_date).format("YYYY-MM-DD 00:00:00");
        conditions.createdAt = {
          [Op.between]: [startDate, endDate],
        };
      } else {
        const { startDate, endDate } = getDateRange(date_type);
        conditions.createdAt = {
          [Op.between]: [startDate, endDate],
        };
      }
    }

    let data = {};
    const ageRanges = [
      { label: "0-1 an", condition: { age: { [Op.between]: [0, 1] } } },
      { label: "1-4 ans", condition: { age: { [Op.between]: [1, 4] } } },
      { label: "5-14 ans", condition: { age: { [Op.between]: [5, 14] } } },
      { label: "15-19 ans", condition: { age: { [Op.between]: [15, 19] } } },
      { label: "20-25 ans", condition: { age: { [Op.between]: [20, 25] } } },
      { label: "26-49 ans", condition: { age: { [Op.between]: [26, 49] } } },
      { label: "50-59 ans", condition: { age: { [Op.between]: [50, 59] } } },
      { label: "60 ans & +", condition: { age: { [Op.gte]: 60 } } },
      { label: "Age ND", condition: { age: null } }, // Adjust this condition as needed
    ];

    const patiet_age_data = await Promise.all(
      ageRanges.map(async (range) => {
        const count = await Patient.count({
          where: range.condition,
        });
        return { label: range.label, count };
      })
    );

    const districtData = await District.findAll({});

    const patient_district_data = await Promise.all(
      districtData.map(async (range) => {
        const count = await Patient.count({
          where: { district: range.id },
        });

        return { label: range.name, count: count };
      })
    );
    console.log(patient_district_data);

    const genders = await Patient.findAll({
      attributes: [
        "sex",
        [Sequelize.fn("COUNT", Sequelize.col("id")), "count"],
      ],
      group: "sex",
    });

    const patient_gender_data = genders.map((gender) => ({
      gender: gender.sex,
      count: gender.dataValues.count,
    }));
    data.patiet_age_data = patiet_age_data;
    data.patient_district_data = patient_district_data;
    data.patient_gender_data = patient_gender_data;

    if (data === null) {
      res.json({ status: 0, message: langCommon.nodatafound });
    } else {
      res.json({
        status: 1,
        message: "Dashboard Demographic data fetched.",
        data: data,
      });
    }
  } catch (error) {
    throw error;
  }
};

exports.getNosologieReport = async (req, res) => {
  try {
    const { date_type, from_date, to_date } = req.query;

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
            COUNT(CASE WHEN p.age IS NULL AND p.sex = 'Feminin' THEN 1 END) AS 'Age ND F'
        FROM (
            SELECT
                name,
                COUNT(*) as disease_count
            FROM
                clinical_desease
            GROUP BY
                name
            ORDER BY
                disease_count DESC
            LIMIT 5
        ) sub
        INNER JOIN
            clinical_desease d ON sub.name = d.name
        INNER JOIN
            patient p ON p.id = d.patient_id
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
