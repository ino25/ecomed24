require("dotenv/config");
var express = require("express");
var router = express.Router();
const query = require("../config").query;
var User = require("../models/User");
var crypto = require("crypto");
var jwt = require("jsonwebtoken");
const VerifyToken = require("./VerifyToken");
const file = require("../helpers/FileHelper");
const mailer = require("../helpers/Mailer");
const authController = require("../controllers/auth.controller");
// const helperController = require("../controllers/helper.controller");

router.post("/login", authController.Login);
router.post("/login-with-otp", authController.LoginWithOtp);
router.post("/verify-otp", authController.VerifyOTP);
router.patch("/forgot-password", authController.ForgotPassword);
router.post("/activate", authController.AccountActivation);
router.get("/logout", VerifyToken, authController.Logout);
router.get("/authcheck", VerifyToken, authController.getAuthcheck);
//Get User Permissions
router.get(
  "/get-user-permissions",
  VerifyToken,
  authController.getUserPermission
);

module.exports = router;
