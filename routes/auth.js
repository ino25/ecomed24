require('dotenv/config');
var express = require("express");
var router = express.Router();
const query = require('../config').query;
var User = require('../models/User');
var crypto = require('crypto');
var jwt = require('jsonwebtoken');
const VerifyToken = require('./VerifyToken');
const file = require('../helpers/FileHelper');
const mailer = require('../helpers/Mailer');



// Check user credentials and generate jwt
router.post('/login', async (req, res) => {
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

});

// Register user
router.post('/register', async (req, res) => {
    try {
        let getData = [];
        // if (!req.body.organization || !req.body.name || !req.body.email || !req.body.country || !req.body.state || !req.body.city || !req.body.mobile || !req.body.password || !req.body.ip) {
        if (!req.body.organization || !req.body.name || !req.body.email || !req.body.country || !req.body.state || !req.body.city || !req.body.mobile || !req.body.password) {
            return res.json({ status: 0, message: "Bad Request. Check Body Parameters." });
        }
        const organization = req.body.organization.trim();
        const userName = req.body.name.trim();
        const userMail = req.body.email.trim();
        const hash = crypto.createHash('md5').update(req.body.password.trim()).digest("hex");

        getData.push(organization);
        getData.push(userMail);
        //getData.push(hash);

        await user.getSingleRegisterUser(getData).then(async (results) => {
            if (results.length) {
                res.json({ status: 2, message: "User Already Registered!!" });
            } else {
                let userData = [];
                let mailData = {};
                const activationKey = crypto.createHash('md5').update(userMail + organization).digest("hex");

                // Prepare array for user creation
                userData.push(userName);
                userData.push(req.body.mobile);
                userData.push(userMail);
                userData.push(hash);
                userData.push(req.body.country);
                userData.push(req.body.state);
                userData.push(req.body.city);
                userData.push(organization);
                userData.push(organization);
                userData.push(activationKey);
                // userData.push(req.body.ip.trim());
                //userData.push(1234567);

                // Get student email template from database
                // await query(user.getMailBody, [organization, 'reg', 3]).then((data) => {
                // mailData = JSON.parse(data[0].template);
                // });

                // Generate activation link
                //const reglink = 'https://' + organization + '.' + process.env.URL + '/account-activation/' + activationKey;

                // Reading email layout
                //mailData.email = file.readEmail('email.html');

                // Replacing data in email template nad email layout
                // mailData.gjshtml = mailData.gjshtml.replaceArray(['{{user}}', '{{reg}}', '{{act}}'], [userName, reglink, activationKey]);
                // mailData.email = mailData.email.replaceArray(['{{title}}', '{{css}}', '{{body}}'], ['Account Activation', mailData.gjscss, mailData.gjshtml]);

                await query(user.createUser, userData).then(async (data) => {
                    if (data.affectedRows) {
                        // await mailer(userMail, 'Contact <contact@pathfinderacademy.in>', 'Account Activation', mailData.email).then(() => {
                        // res.json({ status: 1, message: "Registration Successful!! Check your mail for activation link!!" });
                        // }).catch(() => {
                        // res.json({ status: 0, message: "Server busy. Please contact admin." });
                        // });
                        res.json({ status: 1, message: "Your Registration completed, Redirecting to log in page." });

                    }
                }).catch(() => {
                    res.json({ status: 0, message: "Something went wrong. Please try again later." });
                });
            }
        }).catch((error) => {
            throw error;
        });
    } catch (error) {
        throw error;
    }
});

// Check user credentials and generate temporary password for user
router.post('/forgot', async (req, res) => {
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

});

// Register user
router.post('/activate', async (req, res) => {
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
});

// Logout user
router.get('/logout', VerifyToken, async (req, res) => {
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
});

module.exports = router;
