// Import Model
const query = require('../config').query;

// const createUser = "INSERT INTO `eExam_Users` (`name`, `mobile`, `email`, `username`, `password`, `utype`, `country`, `state`, `city`, `org_id`, `org_name`, `role`, `package_id`, `act_key`, `ip`, `created_by`, `created_date`, `status`) VALUES (?, ?, ?, '', ?, '3', ?, ?, ?, (SELECT `id` FROM `eExam_Organization` WHERE `name` = ?), ?, '0', '', ?, INET_ATON(?), '0', NOW(), '1')";
const createUser = "INSERT INTO `eExam_Users` (`name`, `mobile`, `email`, `username`, `password`, `utype`, `country`, `state`, `city`, `org_id`, `org_name`, `role`, `package_id`, `act_key`, `ip`, `created_by`, `created_date`, `status`) VALUES (?, ?, ?, '', ?, '3', ?, ?, ?, (SELECT `id` FROM `eExam_Organization` WHERE `name` = ?), ?, '0', '', ?, '1234567', '0', NOW(), '1')";

const getSingleUser = "SELECT `eu`.`id`, `eu`.`name`, `eu`.`mobile`, `eu`.`email`, `eu`.`org_id`, `eu`.`org_name`, `eo`.`image_path`, `eu`.`profile_picture`, `eu`.`package_id` FROM `eExam_Users` AS `eu` LEFT JOIN `eExam_Organization` AS `eo` ON `eo`.`id` = `eu`.`org_id` WHERE `eu`.`org_name`= ? AND `eu`.`email`= ? AND `eu`.`password`= ? AND `eu`.`utype`='3' ";

const getSingleRegisterUser = "SELECT `eu`.`id`, `eu`.`name`, `eu`.`mobile`, `eu`.`email`, `eu`.`org_id`, `eu`.`org_name`, `eo`.`image_path`, `eu`.`profile_picture`, `eu`.`package_id` FROM `eExam_Users` AS `eu` LEFT JOIN `eExam_Organization` AS `eo` ON `eo`.`id` = `eu`.`org_id` WHERE `eu`.`org_name`= ? AND `eu`.`email`= ? AND `eu`.`utype`='3' ";

const getRecoveryUser = "SELECT id, name, org_id FROM `eExam_Users` WHERE `org_name`= ? AND `email`= ? AND `utype`='3' ";

const getUserDetails = "SELECT `eu`.name, `eu`.mobile, `eu`.email, `eu`.org_id, `eu`.org_name, `eo`.`image_path`, `eu`.profile_picture, `eu`.guardian_name, `eu`.guardian_occupation, `eu`.gur_name, `eu`.gur_mobile, `eu`.collage_name, `eu`.university_name, `eu`.highest_degree, `eu`.other_highest_degree, `eu`.displine, `eu`.current_qualification, `eu`.passing_year, `eu`.gender, `eu`.enroll_number, `eu`.dob, `eu`.doreg, `eu`.country, `eu`.state, `eu`.city, `eu`.address, `eu`.zipcode, `eu`.landline, `eu`.enq_medium, `eu`.enq_reference, `eu`.enq_status FROM `eExam_Users` AS `eu` LEFT JOIN `eExam_Organization` AS `eo` ON `eo`.`id` = `eu`.`org_id`  WHERE `eu`.`id`= ? AND `eu`.`org_id`= ? AND `eu`.`utype`='3' AND `eu`.`status`='1' LIMIT 1";

const setUserDetails = "UPDATE `eExam_Users` SET `name` = ?, `mobile` = ?, `guardian_name` = ?, `guardian_occupation` = ?, `dob` = ?, `doreg` = ?, `gender` = ?, `address` = ?, `country` = ?, `state` = ?, `city` = ?, `zipcode` = ?, `landline` = ?, `enq_medium` = ?, `enq_reference` = ?, `gur_name` = ?, `gur_mobile` = ?, `collage_name` = ?, `university_name` = ?, `highest_degree` = ?, `displine` = ?, `passing_year` = ?, `current_qualification` = ? WHERE `id` = ? AND `org_id` = ? AND `status` = 1";

 const setUserIp = "UPDATE `eExam_Users` SET `ip` = INET_ATON(?), `is_login` = 1 WHERE `id` = ? AND `org_id` = ? AND `status` = 1";
//const setUserIp = "UPDATE `eExam_Users` SET `ip` = '1234567', `is_login` = 1 WHERE `id` = ? AND `org_id` = ? AND `status` = 1";

const setLogout = "UPDATE `users` SET `token` = NULL WHERE `id` = ? AND `id_organisation` = ? AND `active` = 1";
const logoutRedirectUser = "SELECT `redirect` FROM `eExam_Organization` WHERE `id` = ?";

const setUserProfile = "UPDATE `eExam_Users` SET `profile_picture` = ? WHERE `id` = ? AND `org_id` = ? AND `status` = 1";
const setUserPassword = "UPDATE `eExam_Users` SET `password` = ? WHERE `id` = ? AND `org_id` = ? AND `status` = 1";

const activateUser = "UPDATE `eExam_Users` SET `status` = '1', `act_key` = '' WHERE `org_name` = ? AND `act_key` = ? AND `status` = 0";

const getMailBody = "SELECT `template` FROM `eExam_Email_Template` WHERE `org_name` = ? AND `action` = ? AND `utype` = ? AND `status` = 1";

module.exports = {

    // Register User
    createUser,

    // Get Single User
    getSingleUser(data) {
        let q = '';
        try {
            if (data[3]) {
                q = getSingleUser + 'AND `eu`.`status` = 1 ';
            } else {
                q = getSingleUser + 'LIMIT 1';
            }
            return new Promise((resolve, reject) => {
                query(q, data).then((rows) => {
                    resolve(JSON.parse(JSON.stringify(rows)));
                }).catch((err) => {
                    reject(err);
                });
            });
        } catch (err) {
            throw err;
        }
    },
	
	 // Get Single User
    getSingleRegisterUser(data) {
        let q = '';
        try {
            if (data[3]) {
                q = getSingleRegisterUser + 'AND `eu`.`status` = 1 ';
            } else {
                q = getSingleRegisterUser + 'LIMIT 1';
            }
            return new Promise((resolve, reject) => {
                query(q, data).then((rows) => {
                    resolve(JSON.parse(JSON.stringify(rows)));
                }).catch((err) => {
                    reject(err);
                });
            });
        } catch (err) {
            throw err;
        }
    },

    // Get User For Account Recovery
    getRecoveryUser,

    // Get User Details
    getUserDetails,

    // Set User IP
    setUserIp(data) {
        try {
            return new Promise((resolve, reject) => {
                query(setUserIp, data).then((rows) => {
                    if (rows.affectedRows)
                        resolve(true);
                    else
                        resolve(false);
                }).catch((err) => {
                    reject(err);
                });
            });
        } catch (err) {
            throw err;
        }
    },

    // Set User Logout Flag
    setLogout(data) {
        try {
            return new Promise(async (resolve, reject) => {
                await query(setLogout, data).then(async () => {
                    await query(logoutRedirectUser, [data[1]]).then((rows) => {
                        resolve(JSON.parse(JSON.stringify(rows[0].redirect)));
                    }).catch((err) => {
                        reject(err);
                    });
                }).catch((err) => {
                    reject(err);
                });
            });
        } catch (err) {
            throw err;
        }
    },

    // Set User Details
    setUserDetails(data) {
        try {
            return new Promise((resolve, reject) => {
                query(setUserDetails, data).then((rows) => {
                    if (rows.affectedRows)
                        resolve(true);
                    else
                        resolve(false);
                }).catch((err) => {
                    reject(err);
                });
            });
        } catch (err) {
            throw err;
        }
    },

    // Set User Profile
    setUserProfile(data) {
        try {
            return new Promise((resolve, reject) => {
                query(setUserProfile, data).then((rows) => {
                    if (rows.affectedRows)
                        resolve(true);
                    else
                        resolve(false);
                }).catch((err) => {
                    reject(err);
                });
            });
        } catch (err) {
            throw err;
        }
    },

    // Set User Password
    setUserPassword(data) {
        try {
            return new Promise((resolve, reject) => {
                query(setUserPassword, data).then((rows) => {
                    if (rows.affectedRows)
                        resolve(true);
                    else
                        resolve(false);
                }).catch((err) => {
                    reject(err);
                });
            });
        } catch (err) {
            throw err;
        }
    },

    // Activate User Account
    activateUser,

    // Activate User Account
    getMailBody,

}
