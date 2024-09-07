const express = require("express");
const cookieParser = require("cookie-parser");
const morgan = require("morgan");
const helmet = require("helmet");
const cors = require("cors");
const i18n = require("i18n");
const bodyParser = require("body-parser");
const path = require("path");
const cron = require("node-cron");
require("dotenv/config");
const sequelize = require("./config").sequelize;
let options = {};
let protocol;
const http = require("http");
const https = require("https");
const fs = require("fs");
const { emailSchedule } = require("./controllers/cron.controller");

if (process.env.NODE_ENV === "production") {
  cron.schedule("*/5 * * * * *", emailSchedule);
}

if (process.env.SSL === "enabled") {
  protocol = https;
  const sslkey = process.env.SSL_KEY;
  const sslcert = process.env.SSL_CERT;
  options = {
    key: fs.readFileSync(sslkey, "utf8"),
    cert: fs.readFileSync(sslcert, "utf8"),
  };
} else {
  protocol = http;
  options = {};
}

// Sync models with the database
// sequelize
//   .sync()
//   .then(() => {
//     console.log("Database synced");
//   })
//   .catch((error) => {
//     console.error("Error syncing database:", error);
//   });

let app = express();

// Configure i18n
i18n.configure({
  locales: ["en", "fr", "es"], // Add more locales as needed
  defaultLocale: "fr",
  directory: __dirname + "/locales", // Folder where translation files are stored
  objectNotation: true, // Use dot notation for nested keys
  updateFiles: false, // Do not write to files
});

// Use i18n middleware
app.use(i18n.init);

// Set the default locale for the app
// app.locals.__ = res.__;

// Set up a middleware to set the user's locale based on a fixed variable
app.use((req, res, next) => {
  const fixedLocale = "fr"; // Set the fixed language/locale here
  req.setLocale(fixedLocale);
  res.locals.currentLocale = fixedLocale;
  next();
});

let server = protocol.Server(options, app);
app.use("/uploads", express.static("uploads"));
app.use("/uploads/invoicefile", express.static("uploads/invoicefile"));

const authRouter = require("./routes/auth.routes");
const helperRouter = require("./routes/helper.routes");
const labRoutes = require("./routes/lab.routes");
const patientsRoutes = require("./routes/patient.routes");
const billingRoutes = require("./routes/billing.routes");
const organizationRoutes = require("./routes/organization.routes");
const rolesRoutes = require("./routes/role.routes");
const permisssionRoutes = require("./routes/permission.routes");
const dashboardRoutes = require("./routes/dashboard.routes");
const reportRoutes = require("./routes/report.routes");

if (app.get("env") === "production") {
  app.use(morgan("combined"));
} else {
  app.use(morgan("dev"));
}
app.set("subdomain offset", 1);
app.use(helmet());
app.use(cors());
app.use(express.json({ limit: "10mb" }));
app.use(express.urlencoded({ limit: "10mb", extended: false }));
app.use(cookieParser());

app.use(function (req, res, next) {
  // Request methods you wish to allow
  res.setHeader(
    "Access-Control-Allow-Methods",
    "GET, POST, OPTIONS, PUT, PATCH, DELETE"
  );
  res.header("Access-Control-Allow-Origin", "*");
  next();
});

app.get("/", (req, res) => {
  const welcomeMessage = res.__("index");
  // res.send(welcomeMessage);
  res.json(welcomeMessage);
});
app.use("/auth", authRouter);
// app.use('/user', usersRouter);
app.use("/helper", helperRouter);
app.use("/patient", patientsRoutes);
app.use("/acts", labRoutes);
app.use("/billing", billingRoutes);
app.use("/organization", organizationRoutes);
app.use("/roles", rolesRoutes);
app.use("/permissions", permisssionRoutes);
app.use("/dashboard", dashboardRoutes);
app.use("/report", reportRoutes);

// Start server
const PORT = process.env.PORT || 3001;
server.listen(PORT, () => {
  console.log(`Server running on port ${PORT}`);
});

module.exports = { app: app, server: server };
