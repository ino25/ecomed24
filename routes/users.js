var express = require('express');
var router = express.Router();
const query = require('../config').query;
var crypto = require('crypto');
var user = require('../models/User');
const FileUpload = require('../helpers/FileHelper');
const VerifyToken = require('./VerifyToken');

// Get User Details.
router.get('/', VerifyToken, async (req, res) => {
    try {
        let getData = [];
        getData.push(req.userId);
        getData.push(req.orgId);

        await query(user.getUserDetails, getData).then((results) => {
            if (results.length) {
                if (results[0].profile_picture) {
                    results[0].profile_picture = "/upload/" + results[0].org_name + "/user_pic/" + results[0].profile_picture;
                } else {
                    results[0].profile_picture = "/upload/user-profile-placeholder.png";
                }
                if (results[0].image_path) {
                    results[0].logo = results[0].image_path;
                }

                delete results[0].image_path;

                res.json({ status: 1, message: 'Current User Details', data: results });
            } else {
                res.json({ status: 0, message: 'No Data Found' });
            }
        }).catch((err) => { throw err; });
    } catch (error) {
        throw error;
    }
});

// Set User Details.
router.patch('/', VerifyToken, async (req, res, next) => {
    try {
        let getData = [], getProfile = [], file, results;
        if (req.body.action !== 'setPassword') {
            getData.push(req.body.name);
            getData.push(req.body.mobile);
            getData.push(req.body.guardian_name);
            getData.push(req.body.guardian_occupation);
            getData.push(req.body.dob);
            getData.push(req.body.doreg);
            getData.push(req.body.gender);
            getData.push(req.body.address);
            getData.push(req.body.country);
            getData.push(req.body.state);
            getData.push(req.body.city);
            getData.push(req.body.zipcode);
            getData.push(req.body.landline);
            getData.push(req.body.enq_medium);
            getData.push(req.body.enq_reference);
            getData.push(req.body.gur_name);
            getData.push(req.body.gur_mobile);
            getData.push(req.body.collage_name);
            getData.push(req.body.university_name);
            getData.push(req.body.highest_degree);
            getData.push(req.body.displine);
            getData.push(req.body.passing_year);
            getData.push(req.body.current_qualification);
            getData.push(req.userId);
            getData.push(req.orgId);

            if (req.body.profile_picture) {
                file = await FileUpload.saveImage(req.body.org, req.body.profile_picture);
                if (file.filename) {

                    await query(user.getUserDetails, [req.userId, req.orgId]).then(async (profile) => {
                        if (profile[0].profile_picture) {
                            await FileUpload.removeImage(req.body.org, profile[0].profile_picture);
                        }
                    }).catch((err) => { throw err; });

                    getProfile.push(file.filename);
                    getProfile.push(req.userId);
                    getProfile.push(req.orgId);
                    await user.setUserProfile(getProfile);
                }
            }

            results = await user.setUserDetails(getData);
        } else {
            let password = crypto.createHash('md5').update(req.body.password.trim()).digest("hex");
            getData.push(password);
            getData.push(req.userId);
            getData.push(req.orgId);

            results = await user.setUserPassword(getData);
        }

        await query(user.getUserDetails, [req.userId, req.orgId]).then(async (returnData) => {
            if (returnData[0].profile_picture) {
                returnData[0].profile_picture = "/upload/" + returnData[0].org_name + "/user_pic/" + returnData[0].profile_picture;
            } else {
                returnData[0].profile_picture = "/upload/user-profile-placeholder.png";
            }

            if (returnData[0].image_path) {
                returnData[0].logo = returnData[0].image_path;
            }

            delete returnData[0].image_path;

            if (results) {
                res.json({ status: 1, message: 'User Details Updated.', data: returnData });
            } else {
                res.json({ status: 0, message: 'Something Went Wrong, Please Try Againg Later!!' });
            }
        }).catch((err) => { throw err; });
    } catch (error) {
        throw error;
    }
});

module.exports = router;
