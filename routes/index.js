var express = require('express');
var router = express.Router();
const query = require('../config').query;
// var dt = require("../helpers/TimeHelper");
var home = require("../models/Home");
// var test = require("../models/Test");
const VerifyToken = require('./VerifyToken');
var decode = require("unescape");
// var unserialize = require("phpunserialize");

// Get Notifications
router.get("/notifications", VerifyToken, async (req, res) => {
    try {
        let getData = [];
        if (req.orgId) {
            getData.push(req.orgId);
        }

        await query(home.getNotifications, getData).then((result) => {
            if (result.length) {
                result.filter((item) => {
                    if (item.title) { item.title = decode(item.title); }
                    if (item.description) { item.description = decode(item.description); }
                });
                res.json({ status: 1, message: "Notifications", data: results });
            } else {
                res.json({ status: 0, message: "No Data Found" });
            }
        }).catch((err) => { throw err; });
    } catch (error) {
        throw error;
    }
});

router.get("/dashboard", VerifyToken, async (req, res) => {
    try {
        let getData = [], dashboard = {}, subscribedProgram = [], notSubscribedProgram = [], programOffered = [], freePrograms = [], upcomingPrograms = [], graphData = { data: [], label: [] }; // postData = [], attemptedCount = 0, unattemptedCount = 0
        if (req.orgId) {
            getData.push(req.userId);
            getData.push(req.orgId);
        }

        // Get all Active and Subscribed program
        await query(home.getSubscribedPackages, getData).then((data) => {
            subscribedProgram = data;
        }).catch((err) => { throw err });

        // Get all Active and Not Subscribed program
        await query(home.getActivePrograms, getData).then((data) => {
            notSubscribedProgram = data;
            if (notSubscribedProgram.length) {
                notSubscribedProgram.filter((item) => {
                    item.totalTest = 0;
                    // Count total test id's in a program and assign counter to new object property
                    if (item.test_id) {
                        item.totalTest = item.test_id.split(',').length;
                    }
                    // delete test id's object property from current program
                    delete item.test_id;

                    // Convert program date to ISO standard
                    if (item.start_date) { item.start_date = new Date(item.start_date).toISOString(); }
                    if (item.end_date) { item.end_date = new Date(item.end_date).toISOString(); }

                    // Filter program on basis of subscription type to diffrent data structures
                    if (item.free_package) {
                        freePrograms.push(item);
                    } else {
                        programOffered.push(item);
                    }

                });
            }
        }).catch((err) => { throw err });

        // All Upcoming Test of Current Organization
        // await home.getScheduleTest([req.orgId]).then((data) => {
        //     upcomingTests = data;
        //     upcomingTests.filter((element) => {
        //         if (element.freeze_question) {
        //             // subscribedTest[i].no_of_questions = 0;
        //             element.total_marks = 0;
        //             if (element.section_question) { element.section_question = unserialize(element.section_question); }
        //             element.section_question.filter((ques) => {
        //                 element.total_marks = (element.total_marks + parseFloat(ques.marks, 10));
        //                 // subscribedTest[i].no_of_questions = (subscribedTest[i].no_of_questions + parseInt(ques.questions, 10));
        //             });
        //         }
        //         if (element.start_date_time) { element.start_date_time = new Date(element.start_date_time).toISOString(); }
        //         if (element.end_date_time) { element.end_date_time = new Date(element.end_date_time).toISOString(); }

        //         let firstDate = new Date(),
        //             secondDate = new Date(element.end_date_time),
        //             timeDifference = Math.abs(secondDate.getTime() - firstDate.getTime());

        //         let differentDays = Math.ceil(timeDifference / (1000 * 3600 * 24));
        //         if (differentDays < 5) {
        //             element.expiring = 1;
        //         }
        //     });
        // }).catch((err) => { throw err });

        // Get all Upcoming, Active and Not Expired program
        await query(home.getUpcomingPrograms, getData).then((data) => {
            upcomingPrograms = data;
            if (upcomingPrograms.length) {
                upcomingPrograms.filter((item) => {
                    item.totalTest = 0;
                    // Count total test id's in a program and assign counter to new object property
                    if (item.test_id) {
                        item.totalTest = item.test_id.split(',').length;
                    }
                    // delete test id's object property from current program
                    delete item.test_id;

                    // Convert program date to ISO standard
                    if (item.start_date) { item.start_date = new Date(item.start_date).toISOString(); }
                    if (item.end_date) { item.end_date = new Date(item.end_date).toISOString(); }

                });
            }
        }).catch((err) => { throw err });

        // All Performance Data
        await query(home.getPerformance, getData).then((data) => {
            data.filter((element) => {
                graphData.data.push(element.percentile);
                graphData.label.push(element.name + '(' + element.attempt + ')');
            });
        });

        // Unsubscribed Packages of Current Organization
        // let notSubscribedPackages = await home.getNotSubscribedPackages(getData);
        // notSubscribedPackages.forEach(element => {
        //     element.totalTest = element.test_id.split(',').length;
        //     delete element.test_id;
        // });

        // Free Packages of Current Organization
        // let freePackages = await home.getFreePackages(getData);

        // Filter and Remove Duplicates
        // let freeTests = [];
        // freePackages.filter((test) => {
        //     freeTests.push(test.test_id);
        // });
        // freePackages = new Set();
        // freeTests = freeTests.join(',').split(',');
        // freeTests.filter((test) => {
        //     freePackages.add(test);
        // });

        // Free Tests of Current User
        // freeTests = await home.getFreeTests([req.orgId, [...freePackages].join(',')]);
        // freeTests.filter((element) => {
        //     if (element.start_date_time) { element.start_date_time = dt.utcDate(element.start_date_time); }
        //     if (element.end_date_time) { element.end_date_time = dt.utcDate(element.end_date_time); }
        // });

        // // All Subscribed Test of Current Organization
        // postData.unshift(req.userId);
        // postData.unshift(req.userId);
        // // Get All Test From User Package
        // let packTest = await test.getTestFromPackage([req.userId, req.userId]);

        // // Filter and Remove Duplicates
        // let tests = [];
        // packTest.filter((test) => {
        //     tests.push(test.test_id);
        // });
        // packTest = new Set();
        // tests = tests.join(',').split(',');
        // tests.filter((test) => {
        //     packTest.add(test);
        // });
        // postData.push([...packTest].join(','));
        // postData.push(req.orgId);
        // let subscribedTest = await test.getAll(postData);

        // // All Attempted/Unattempted Test of Subscribed Test
        // for (let i = 0; i < subscribedTest.length; i++) {
        //     let firstDate = new Date(),
        //         secondDate = new Date(subscribedTest[i].end_date_time),
        //         timeDifference = Math.abs(secondDate.getTime() - firstDate.getTime());

        //     let differentDays = Math.ceil(timeDifference / (1000 * 3600 * 24));
        //     if (differentDays < 5) {
        //         subscribedTest[i].expiring = 1;
        //     }

        //     if (subscribedTest[i].start_date_time) { subscribedTest[i].start_date_time = dt.utcDate(subscribedTest[i].start_date_time); }
        //     if (subscribedTest[i].end_date_time) { subscribedTest[i].end_date_time = dt.utcDate(subscribedTest[i].end_date_time); }
        //     if (subscribedTest[i].my_attempt) {
        //         attemptedCount++;
        //     } else {
        //         unattemptedCount++;
        //     }
        // }

        // allTest.filter((element) => {
        //     if (element.freeze_question) {
        //         // subscribedTest[i].no_of_questions = 0;
        //         element.total_marks = 0;
        //         if (element.section_question) { element.section_question = unserialize(element.section_question); }
        //         element.section_question.filter((ques) => {
        //             element.total_marks = (element.total_marks + parseFloat(ques.marks, 10));
        //             // subscribedTest[i].no_of_questions = (subscribedTest[i].no_of_questions + parseInt(ques.questions, 10));
        //         });
        //     }

        //     // All Unsubscribed Test of Current Organization
        //     let firstDate = new Date(),
        //         secondDate = new Date(element.end_date_time),
        //         timeDifference = Math.abs(secondDate.getTime() - firstDate.getTime());

        //     let differentDays = Math.ceil(timeDifference / (1000 * 3600 * 24));
        //     if (differentDays < 5) {
        //         element.expiring = 1;
        //     }
        //     if (element.start_date_time) { element.start_date_time = dt.utcDate(element.start_date_time); }
        //     if (element.end_date_time) { element.end_date_time = dt.utcDate(element.end_date_time); }

        //     for (let i = 0; i < subscribedTest.length; i++) {
        //         if (element.id === subscribedTest[i].id) {
        //             continue;
        //         } else {
        //             unsubscribedTest.push(element);
        //         }
        //     }
        // });

        // dashboard = {
        //     'packages': unsubscribedPackages,
        //     'freeTests': freeTests,
        //     'subscribedTest': subscribedTest,
        //     'unsubscribedTest': unsubscribedTest,
        //     'totalSubscribed': subscribedTest.length,
        //     'totalUnsubscribed': unsubscribedTest.length,
        //     'totalSubscribedPackages': subscribedPackages.length,
        //     'totalNotSubscribedPackages': unsubscribedPackages.length,
        //     'attemptedCount': attemptedCount,
        //     'unattemptedCount': unattemptedCount,
        //     'performance': graphData
        // }

        dashboard = {
            'subscribedProgram': subscribedProgram.length,
            'notSubscribedProgram': notSubscribedProgram.length,
            'programOffered': programOffered,
            'freePrograms': freePrograms,
            'upcomingPrograms': upcomingPrograms,
            'performance': graphData
        }

        res.json({ status: 1, message: "Dashboard Data", data: dashboard });
    } catch (error) {
        throw error;
    }
});

// Get Country
router.get("/countries", async (req, res) => {
    try {
        await query(home.getCountries).then((resp) => {
            if (resp.length) {
                res.json({ status: 1, message: "Active Country list.", data: resp });
            } else {
                res.json({ status: 0, message: "No Country Found." });
            }
        }).catch((error) => {
            throw error;
        });
    } catch (error) {
        throw error;
    }
});

// Get States
router.post("/states", async (req, res) => {
    try {
        let getData = [];
        if (!req.body.country) {
            return res.json({ status: 0, message: "Invalid request parameter." });
        }
        getData.push(req.body.country);

        await query(home.getStates, getData).then((resp) => {
            if (resp.length) {
                res.json({ status: 1, message: "State list of current country", data: resp });
            } else {
                res.json({ status: 0, message: "No State Found." });
            }
        }).catch((error) => {
            throw error;
        });
    } catch (error) {
        throw error;
    }
});

// Get Cities
router.post("/cities", async (req, res) => {
    try {
        let getData = [];
        if (!req.body.state) {
            return res.json({ status: 0, message: "Invalid request parameter." });
        }
        getData.push(req.body.state);

        await query(home.getCities, getData).then((resp) => {
            if (resp.length) {
                res.json({ status: 1, message: "City list of current state", data: resp });
            } else {
                res.json({ status: 0, message: "No City Found." });
            }
        }).catch((error) => {
            throw error;
        });
    } catch (error) {
        throw error;
    }
});

module.exports = router;
