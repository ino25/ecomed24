const express = require("express");
const cookieParser = require("cookie-parser");
const morgan = require("morgan");
const helmet = require("helmet");
const cors = require("cors");
const bodyParser = require("body-parser");
const path = require("path");
require("dotenv/config");
const sequelize = require("./config").sequelize;
let options = {};
let http;

if (process.env.NODE_ENV === "production") {
  http = require("http");
  // http = require('https');
  // options = {
  // 	key: fs.readFileSync('/etc/letsencrypt/live/sukritinfotech.com/privkey.pem', 'utf8'),
  // 	cert: fs.readFileSync('/etc/letsencrypt/live/sukritinfotech.com/cert.pem', 'utf8')
  // }
} else {
  http = require("http");
}

// Sync models with the database
sequelize
  .sync()
  .then(() => {
    console.log("Database synced");
  })
  .catch((error) => {
    console.error("Error syncing database:", error);
  });

let app = express();
let server = http.Server(options, app);
app.use("/pdfs", express.static("pdfs"));
const limitInBytes = 50 * 1024 * 1024 * 1024;
app.use(
  bodyParser.raw({ type: "application/octet-stream", limit: limitInBytes })
);
const documentsPath = path.join(__dirname, "pdfs");
app.use("/documents", express.static(documentsPath));

// let indexRouter = require('./routes/index');
let authRouter = require("./routes/auth");
// let usersRouter = require('./routes/users');
// let patientsRouter = require('./routes/Patients');
let HelperRouter = require("./routes/Helpers");
const labRoutes = require("./routes/lab.routes");
const patientsRoutes = require("./routes/patient.routes");

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
  res.json("Bienvenu dans ECOMED24!");
});
app.use("/auth", authRouter);
// app.use('/user', usersRouter);
app.use("/helper", HelperRouter);
app.use("/patient", patientsRoutes);
app.use("/acts", labRoutes);

module.exports = { app: app, server: server };
