const Sequelize = require('sequelize');
const Database = require('../config').sequelize;
const Op = Sequelize.Op;
const moment = require("moment");
moment.locale('en');
const path = require('path');
const nodemailer = require("nodemailer");

var User = require('../models/User');

const multer  = require('multer');
const fs = require('fs');

//////Modal Relationship



exports.Login = async (req, res) => {
    try {
        let getData = [];
        // if (!req.body.organization || !req.body.email || !req.body.password || !req.body.ip) {
        if (!req.body.email ) {
            return res.json({ status: 0, message: "Bad Request. Check Body Parameters." });
        }
        // let hash = crypto.createHash('md5').update(req.body.password).digest("hex");

        // getData.push(req.body.organization.trim());
        getData.push(req.body.email.trim());
        // getData.push(hash);  //Password compare.
        // getData.push(hash); //Temp Password compare
        getData.push(1);
        const userModal = await User.findOne({ where: { email: req.body.email.trim() } });
        if(userModal === null){
            res.json({ status: 0, message: "Email or password may be wrong, Try with valid credentials." });
        }else{
            console.log(userModal.id);
            const payload = { id: userModal.id, org_id: userModal.id_organisation,username:userModal.username,email:userModal.email,name:userModal.first_name };
                let options = {
                    algorithm: 'HS256',
                }

                if (req.body.remember) {
                    options.expiresIn = '24h'
                } else {
                    options.expiresIn = '5h'
                }

                if (userModal.profile_picture) {
                    userModal.profile_picture = "/upload/" + userModal.org_name + "/user_pic/" + userModal.profile_picture;
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
                await userModal.update({ token: token ,}, {where: {id: userModal.id,active:1}});
                res.json({ status: 1, message: "Login Successful!!", data: userModal, token: token });
        }
    } catch (error) {
        throw error;
    }
};

exports.LoginWithOtp = async (req, res) => {
    try {
        if (!req.body.mobile) {
            return res.json({ status: false, message: "Bad Request. Check Body Parameters." });
        }
        
        var otp = "1234";
        let hash = crypto.createHash('md5').update(otp).digest("hex");
        const userModal = await User.findOne({attributes:['id','email','username','name','mobile_number','failed_attempt','user_type','status'], where: { mobile_number: req.body.mobile.trim() } });
        if(userModal === null){
                NewUser = await User.create({
                    mobile_number: req.body.mobile,
                    user_type: req.body.user_type,
                    password:hash,
                    status: 1
                });
                
                
                await User.update({ otp: otp ,}, {where: {id: NewUser.id}});
                res.json({ status: true, message: "OTP sent to your mobile no."});
        }else{
                //OTP Integration Here

                
                // if user is found and valid create a Update OTP in db
                await User.update({ otp: otp ,}, {where: {id: userModal.id}});
                res.json({ status: true, message: "OTP sent to your mobile no." });
        }
    } catch (error) {
        throw error;
    }
};

exports.VerifyOTP = async (req, res) => {
    try {
        if (!req.body.mobile || !req.body.otp) {
            return res.json({ status: false, message: "Bad Request. Check Body Parameters." });
        }
        
        // let hash = crypto.createHash('md5').update(req.body.password).digest("hex");

        
        const userModal = await User.findOne({attributes:['id','email','username','name','mobile_number','failed_attempt','user_type','status'], where: { mobile_number: req.body.mobile.trim(),otp:req.body.otp } });
        if(userModal === null){
            res.json({ status: false, message: "Please Enter valid otp or try resend otp." });
        }else{
            // console.log(userModal.id);
            const payload = { id: userModal.id, user_type: userModal.user_type,username:userModal.username,email:userModal.email,name:userModal.name };
                let options = {
                    algorithm: 'HS256',
                }

                if (req.body.remember) {
                    options.expiresIn = '24h'
                } else {
                    options.expiresIn = '5h'
                }

                if (userModal.profile) {
                    userModal.profile = userModal.profile;
                } else {
                    userModal.profile = "/upload/user-profile-placeholder.png";
                }

                if (userModal.profile) {
                    userModal.logo = userModal.profile;
                }

                
                // if user is found and valid create a token
                var token = jwt.sign(payload, process.env.SECRET, options);
                await User.update({ token: token ,}, {where: {id: userModal.id}});
                res.json({ status: true, message: "Login Successful!!", data: userModal, token: token });
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

        await user.setLogout(postData).then((results) => {
            res.json({ status: 1, message: "Logged Out Successfully!!", data: results });
        }).catch((error) => {
            res.json({ status: 0, message: "Something Went Wrong. Please Try Again Later." });
        });
    } catch (error) {
        throw error;
    }
};

exports.getUserPermission = async (req, res) => {
    try {
        let getData = [];
        // OrgPermissionModal = await OrgPermission.findAll({ attributes: ['id', 'sp_id'],where: { status_service: 1 } });

        // OrgPermissionModal = await Database.query("SELECT op.id,sp.name,sp.type FROM ecomed24.org_permissions as op  LEFT JOIN ecomed24.system_permissions as sp ON op.sp_id= sp.id where op.status=1 and op.org_id = "+req.org_id+";",{type: Database.QueryTypes.SELECT});
        // if(OrgPermissionModal === null){
        //     res.json({ status: 0, message: 'No Data Found' });
        // }else{
        //     res.json({ status: 1, message: 'Organization Permission fetched', data: OrgPermissionModal });
        // }
    } catch (error) {
        // throw error;
    }
};


exports.ForgotPassword = async (req, res) => {
    try {
        let postData = [], postPass = [], mailData = {};
        if (!req.body.organization || !req.body.email) {
            return res.json({ status: 0, message: "Bad Request. Check Body Parameters." });
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
            password = buf.toString('hex');
        });

        await query(user.getRecoveryUser, postData).then(async (resp) => {
            if (resp.length) {
                let hash = crypto.createHash('md5').update(password).digest("hex");
                postPass.push(hash);
                postPass.push(resp[0].id);
                postPass.push(resp[0].org_id);
                const userName = resp[0].name.trim();

                await user.setUsertempPassword(postPass).then(async (result) => {
                    if (result) {
                        // Get student email template from database
                        await query(user.getMailBody, [organization, 'forgot', 3]).then(async (data) => {
                            if (data.length) {
                                mailData = JSON.parse(data[0].template);
                                // Reading email layout
                                mailData.email = file.readEmail('email.html');

                                // Replacing data in email template and email layout
                                mailData.gjshtml = mailData.gjshtml.replaceArray(['{{user}}', '{{password}}'], [userName, password]);
                                mailData.email = mailData.email.replaceArray(['{{title}}', '{{css}}', '{{body}}'], ['Password Recovery', mailData.gjscss, mailData.gjshtml]);

                                await mailer(userMail, 'Contact <contact@pathfinderacademy.in>', 'Password Recovery', mailData.email).then(() => {
                                    res.json({ status: 1, message: "Password reset successful, Please Check your inbox for temporary password!!" });
                                }).catch(() => {
                                    res.json({ status: 0, message: "Something wrong with the mail server. Please contact admin." });
                                });
                            } else {
                                res.json({ status: 0, message: "No email template found. Please contact admin." });
                            }
                        });
                    } else {
                        res.json({ status: 0, message: "You are not register or your account is not activated. Please contact admin." });
                    }
                }).catch(() => {
                    res.json({ status: 0, message: "Server busy. Please try after sometime or contact admin." });
                });
            } else {
                res.json({ status: 0, message: "This email is not registered with us!!" });
            }
        }).catch((err) => {
            res.json({ status: 0, message: "Something Went Wrong. Please Try Again Later." });
        });
    } catch (error) {
        throw error;
    }
}

exports.AccountActivation = async (req, res) => {
    try {
        let getData = [];
        if (!req.body.organization || !req.body.key) {
            return res.json({ status: 0, message: "Bad Request. Check Body Parameters." });
        }

        getData.push(req.body.organization.trim());
        getData.push(req.body.key.trim());

        await query(user.activateUser, getData).then((results) => {
            if (results) {
                res.json({ status: 1, message: "Your Account Activated Successfully!!" });
            } else {
                res.json({ status: 0, message: "Your user might be activated, Please try to login or reach to admin" });
            }
        }).catch((error) => {
            throw error;
        });
    } catch (error) {
        throw error;
    }
}











