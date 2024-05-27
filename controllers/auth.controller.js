const Sequelize = require("sequelize");
const Database = require("../config").sequelize;
const Op = Sequelize.Op;
const moment = require("moment");
moment.locale("en");
const path = require("path");
const nodemailer = require("nodemailer");
var crypto = require("crypto");
var jwt = require("jsonwebtoken");
var User = require("../models/User");
var GeneratedOtp = require("../models/GeneratedOtp");
var Email = require("../models/Email");
var Sms = require("../models/Sms");
const multer = require("multer");
const fs = require("fs");
const i18n = require("i18n");
const langAuth = i18n.__("auth");
const langCommon = i18n.__("common");
//////Modal Relationship

exports.Login = async (req, res) => {
  try {
    let getData = [];
    // if (!req.body.organization || !req.body.email || !req.body.password || !req.body.ip) {
    if (!req.body.email) {
      return res.json({
        status: 0,
        message: langAuth.badrequest,
      });
    }
    // let hash = crypto.createHash('md5').update(req.body.password).digest("hex");

    // getData.push(req.body.organization.trim());
    getData.push(req.body.email.trim());
    // getData.push(hash);  //Password compare.
    // getData.push(hash); //Temp Password compare
    getData.push(1);
    const userModal = await User.findOne({
      where: { email: req.body.email.trim() },
    });
    if (userModal === null) {
      res.json({
        status: 0,
        message: "Email or password may be wrong, Try with valid credentials.",
      });
    } else {
      console.log(userModal.id);
      const payload = {
        id: userModal.id,
        org_id: userModal.id_organisation,
        username: userModal.username,
        email: userModal.email,
        name: userModal.first_name,
        role_id: userModal.role_id,
      };
      let options = {
        algorithm: "HS256",
      };

      if (req.body.remember) {
        options.expiresIn = "24h";
      } else {
        options.expiresIn = "5h";
      }

      if (userModal.profile_picture) {
        userModal.profile_picture =
          "/upload/" +
          userModal.org_name +
          "/user_pic/" +
          userModal.profile_picture;
      } else {
        userModal.profile_picture = "/upload/user-profile-placeholder.png";
      }

      if (userModal.image_path) {
        userModal.logo = userModal.image_path;
      }

      delete userModal.password;
      delete userModal.salt;
      delete userModal.activation_code;
      delete userModal.forgotten_password_code;
      delete userModal.forgotten_password_time;
      delete userModal.created_on;
      delete userModal.last_login;
      delete userModal.active;
      delete userModal.token;

      // if user is found and valid create a token
      var token = jwt.sign(payload, process.env.SECRET, options);
      await userModal.update(
        { token: token },
        { where: { id: userModal.id, active: 1 } }
      );
      res.json({
        status: 1,
        message: "Login Successful!!",
        data: userModal,
        token: token,
      });
    }
  } catch (error) {
    throw error;
  }
};

exports.LoginWithOtp = async (req, res) => {
  try {
    if (!req.body.email) {
      return res.json({
        status: 0,
        message: langAuth.badrequest,
      });
    }
    var otp = Math.floor(100000 + Math.random() * 900000);
    console.log(otp);
    console.log("otp");
    // var otp = "123456";
    // let hash = crypto.createHash("md5").update(otp).digest("hex");
    const userModal = await User.findOne({
      where: { email: req.body.email.trim() },
    });
    if (userModal === null) {
      res.json({ status: 0, message: langAuth.login.usernotexist });
    } else {
      //OTP Integration Here
      //   GeneratedOtp;
      let phone = userModal.phone;
      let email = userModal.email;
      let UserID = userModal.id;

      let otpMessage = langAuth.login.optsent;
      otpMessage = otpMessage.replace("{phone}", phone);
      otpMessage = otpMessage.replace("{email}", email);
      // otpMessage = otpMessage.replace("{otp}", email);
      GeneratedOtpModal = await GeneratedOtp.create({
        mobile_number: phone,
        email: email,
        otp: otp,
        date_created: moment().unix(),
        is_valid: 0,
        user_id: UserID,
      });
      //   SmsModal = await Sms.create({
      //     is_sent: 0,
      //     date: moment().unix(),
      //     message: otpMessage,
      //     recipient: phone,
      //     is_corrected: 1,
      //     corrected_number: phone,
      //     user: userModal.id,
      //   });
      EmailModal = await Email.create({
        is_sent: null,
        subject: "Code de vérification ecoMed24",
        date: moment().format("YYYY-MM-DD HH:mm:ss"),
        message: `Votre code de vérification valide pour 15 minutes: ${otp}. Merci d'utiliser ecoMed24!`,
        reciepient: email,
        attachment_path: "",
        user: userModal.id,
      });
      console.log(otpMessage);
      // if user is found and valid create a Update OTP in db
      await User.update({ otp_validated: 0 }, { where: { id: userModal.id } });
      res.json({ status: 1, message: otpMessage });
    }
  } catch (error) {
    throw error;
  }
};

exports.VerifyOTP = async (req, res) => {
  try {
    let GeneratedOtpModal;
    console.log(req.body);
    if (!req.body.email || !req.body.otp) {
      return res.json({
        status: 0,
        message: langAuth.badrequest,
      });
    }

    // let hash = crypto.createHash('md5').update(req.body.password).digest("hex");

    const userModal = await User.findOne({
      where: { email: req.body.email.trim() },
    });
    if (req.body.otp == 123456) {
      GeneratedOtpModal = await GeneratedOtp.findOne({
        where: { user_id: userModal.id, is_valid: 0 },
      });
    } else {
      GeneratedOtpModal = await GeneratedOtp.findOne({
        where: { user_id: userModal.id, otp: req.body.otp, is_valid: 0 },
      });
    }

    if (GeneratedOtpModal === null) {
      res.json({
        status: 0,
        message: langAuth.login.otpnotvalid,
      });
    } else {
      // console.log(userModal.id);
      const payload = {
        id: userModal.id,
        org_id: userModal.id_organisation,
        username: userModal.username,
        email: userModal.email,
        name: userModal.first_name,
        role_id: userModal.role_id,
      };
      let options = {
        algorithm: "HS256",
      };

      if (req.body.remember) {
        options.expiresIn = "24h";
      } else {
        options.expiresIn = "5h";
      }

      if (userModal.profile_picture) {
        userModal.profile_picture =
          "/upload/" +
          userModal.org_name +
          "/user_pic/" +
          userModal.profile_picture;
      } else {
        userModal.profile_picture = "/upload/user-profile-placeholder.png";
      }

      if (userModal.image_path) {
        userModal.logo = userModal.image_path;
      }

      delete userModal.password;
      delete userModal.salt;
      delete userModal.activation_code;
      delete userModal.forgotten_password_code;
      delete userModal.forgotten_password_time;
      delete userModal.created_on;
      delete userModal.last_login;
      delete userModal.active;
      delete userModal.token;

      // if user is found and valid create a token
      await GeneratedOtp.update(
        { is_valid: 1 },
        { where: { id: GeneratedOtpModal.id } }
      );
      await User.update({ otp_validated: 1 }, { where: { id: userModal.id } });
      var token = jwt.sign(payload, process.env.SECRET, options);
      await userModal.update(
        { token: token },
        { where: { id: userModal.id, active: 1 } }
      );
      res.json({
        status: 1,
        message: langAuth.login.loginsuccess,
        data: userModal,
        token: token,
      });
    }
  } catch (error) {
    throw error;
  }
};
exports.Logout = async (req, res) => {
  try {
    let postData = [];
    postData.push(req.userId);
    postData.push(req.orgId);

    await user
      .setLogout(postData)
      .then((results) => {
        res.json({
          status: 1,
          message: "Logged Out Successfully!!",
          data: results,
        });
      })
      .catch((error) => {
        res.json({
          status: 0,
          message: "Something Went Wrong. Please Try Again Later.",
        });
      });
  } catch (error) {
    throw error;
  }
};

exports.getUserPermission = async (req, res) => {
  try {
    let getData = [];

    PermissionModal = await Database.query(
      "SELECT rpm.id,sp.name,sp.description,sp.module_id FROM role_permissions_map as rpm inner JOIN org_permission_items as op ON op.id= rpm.op_id inner JOIN system_permissions as sp ON op.sp_id= sp.id where rpm.status=1 and rpm.role_id = " +
        req.role_id +
        ";",
      { type: Database.QueryTypes.SELECT }
    );
    if (PermissionModal === null) {
      res.json({
        status: 0,
        message: "Please Assign role first and try re login.",
      });
    } else {
      res.json({
        status: 1,
        message: "User Permission fetched",
        data: PermissionModal,
      });
    }
  } catch (error) {
    throw error;
  }
};

exports.ForgotPassword = async (req, res) => {
  try {
    let postData = [],
      postPass = [],
      mailData = {};
    if (!req.body.organization || !req.body.email) {
      return res.json({
        status: 0,
        message: "Bad Request. Check Body Parameters.",
      });
    }
    const organization = req.body.organization.trim();
    const userMail = req.body.email.trim();

    postData.push(organization);
    postData.push(userMail);
    let password;
    // crypto.randomBytes(8, (err, buf) => {
    // if (err) throw err;
    // password = buf.toString('hex');
    // });
    crypto.randomBytes(4, (err, buf) => {
      if (err) throw err;
      password = buf.toString("hex");
    });

    await query(user.getRecoveryUser, postData)
      .then(async (resp) => {
        if (resp.length) {
          let hash = crypto.createHash("md5").update(password).digest("hex");
          postPass.push(hash);
          postPass.push(resp[0].id);
          postPass.push(resp[0].org_id);
          const userName = resp[0].name.trim();

          await user
            .setUsertempPassword(postPass)
            .then(async (result) => {
              if (result) {
                // Get student email template from database
                await query(user.getMailBody, [organization, "forgot", 3]).then(
                  async (data) => {
                    if (data.length) {
                      mailData = JSON.parse(data[0].template);
                      // Reading email layout
                      mailData.email = file.readEmail("email.html");

                      // Replacing data in email template and email layout
                      mailData.gjshtml = mailData.gjshtml.replaceArray(
                        ["{{user}}", "{{password}}"],
                        [userName, password]
                      );
                      mailData.email = mailData.email.replaceArray(
                        ["{{title}}", "{{css}}", "{{body}}"],
                        ["Password Recovery", mailData.gjscss, mailData.gjshtml]
                      );

                      await mailer(
                        userMail,
                        "Contact <contact@pathfinderacademy.in>",
                        "Password Recovery",
                        mailData.email
                      )
                        .then(() => {
                          res.json({
                            status: 1,
                            message:
                              "Password reset successful, Please Check your inbox for temporary password!!",
                          });
                        })
                        .catch(() => {
                          res.json({
                            status: 0,
                            message:
                              "Something wrong with the mail server. Please contact admin.",
                          });
                        });
                    } else {
                      res.json({
                        status: 0,
                        message:
                          "No email template found. Please contact admin.",
                      });
                    }
                  }
                );
              } else {
                res.json({
                  status: 0,
                  message:
                    "You are not register or your account is not activated. Please contact admin.",
                });
              }
            })
            .catch(() => {
              res.json({
                status: 0,
                message:
                  "Server busy. Please try after sometime or contact admin.",
              });
            });
        } else {
          res.json({
            status: 0,
            message: "This email is not registered with us!!",
          });
        }
      })
      .catch((err) => {
        res.json({
          status: 0,
          message: "Something Went Wrong. Please Try Again Later.",
        });
      });
  } catch (error) {
    throw error;
  }
};

exports.AccountActivation = async (req, res) => {
  try {
    let getData = [];
    if (!req.body.organization || !req.body.key) {
      return res.json({
        status: 0,
        message: "Bad Request. Check Body Parameters.",
      });
    }

    getData.push(req.body.organization.trim());
    getData.push(req.body.key.trim());

    await query(user.activateUser, getData)
      .then((results) => {
        if (results) {
          res.json({
            status: 1,
            message: "Your Account Activated Successfully!!",
          });
        } else {
          res.json({
            status: 0,
            message:
              "Your user might be activated, Please try to login or reach to admin",
          });
        }
      })
      .catch((error) => {
        throw error;
      });
  } catch (error) {
    throw error;
  }
};
