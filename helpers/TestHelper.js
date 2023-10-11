const query = require('../config').query;
let report = require('../models/Report');
let decode = require('unescape');
let unserialize = require('phpunserialize');

// Prepare Subject List With Questions
function pushSubject(arr, obj) {
    const index = arr.findIndex((e) => { if (e.id === obj.id && e.subject === obj.subject) return true; });
    if (index === -1) {
        obj.data.unshift('');
        arr.push(obj);
    } else {
        arr[index].data = arr[index].data.concat(obj.data);
    }
}

// Push Subject Limit
function pushLimit(arr, obj) {
    obj.forEach((element) => {
        const arrIndex = arr.findIndex((e) => { if (e.id == element.id) return true; });
        if (arrIndex !== -1) {
            if (element.questions) {
                arr[arrIndex].questions = element.questions;
            }
            if (element.marks) {
                arr[arrIndex].marks = element.marks;
            }
        }
    });
}

// Generate Report
// const generateReport = async (data) => {
//     // return new Promise(async (resolve, console.log) => {
//     await report.generateReport(data).then(async (results) => {
//         if (results.length) {
//             // Rank List Array to Store Test Id and Attempt For User Rank Generation and Updation
//             rankList = [];
//             results.forEach(async (test) => {
//                 rankList.push({ id: test.id, attempt: test.attempt });
//                 let marks = {
//                     correct_question: 0,
//                     right_marks: 0,
//                     incorrect_question: 0,
//                     wrong_marks: 0,
//                     negative_marks: 0,
//                 }

//                 // Adjust Total Marks if Freezewise Setting is Active
//                 if (test.freeze_question) {
//                     test.total_marks = 0;
//                     if (test.section_question) { test.section_question = unserialize(test.section_question); }
//                     test.section_question.filter((ques) => { test.total_marks = (test.total_marks + parseInt(ques.marks, 10)) });
//                 }

//                 let getData = [];
//                 getData.push(test.question_sequence);
//                 getData.push(test.user_id);
//                 getData.push(test.id);
//                 getData.push(test.attempt);

//                 await report.getTestReport(getData).then((tests) => {
//                     tests.forEach(async (item) => {
//                         let pushData = [];
//                         item.question = decode(item.question);

//                         // Calculate Marks
//                         switch (item.qtype) {
//                             case 1:
//                             case 2:
//                                 if (item.answers !== null) {
//                                     if (item.answers !== 'N/A') {
//                                         item.answers = JSON.parse(item.answers);
//                                     } else {
//                                         item.answers = ['0'];
//                                     }
//                                 } else {
//                                     item.answers = ['0'];
//                                     item.time_taken = '';
//                                 }

//                                 // Convert Correct Answers Array Element To String
//                                 let answers = [];
//                                 item.answers.forEach((val) => {
//                                     val = val.toString();
//                                     answers.push(val);
//                                 });
//                                 item.answers = answers.sort((a, b) => a - b);
//                                 // phpUnserializing and html decoding
//                                 item.question_check = unserialize(item.question_check).sort((a, b) => a - b);

//                                 if (JSON.stringify(item.answers) === JSON.stringify(item.question_check)) {
//                                     marks.correct_question++;
//                                     marks.right_marks = marks.right_marks + item.right_marks;
//                                     pushData.push(item.right_marks);
//                                     pushData.push(1);
//                                 } else {
//                                     marks.incorrect_question++;
//                                     marks.wrong_marks = marks.wrong_marks + item.wrong_marks;
//                                     marks.negative_marks = marks.negative_marks + item.negative_marks;
//                                     pushData.push(item.wrong_marks - item.negative_marks);
//                                     pushData.push(0);
//                                 }

//                                 pushData.push(item.id);
//                                 pushData.push(test.user_id);
//                                 pushData.push(test.id);
//                                 pushData.push(test.attempt);

//                                 // Update Marks
//                                 await report.updateTestMarks(pushData).catch((err) => console.log(err));
//                                 break;
//                             case 3:
//                                 // Do Nothing for Subjetive type Questions.
//                                 break;
//                             default:
//                                 break;
//                         }
//                     });

//                 }).catch((err) => console.log(err));

//                 let pushTest = [];
//                 // let my_marks = (marks.right_marks + marks.wrong_marks) - marks.negative_marks;
//                 let my_marks = (marks.right_marks - marks.wrong_marks);
//                 let percent = (my_marks / test.total_marks) * 100;
//                 pushTest.push(my_marks);
//                 pushTest.push(marks.correct_question);
//                 pushTest.push(marks.right_marks);
//                 pushTest.push(marks.wrong_marks);
//                 pushTest.push(marks.incorrect_question);
//                 pushTest.push('-' + marks.negative_marks);
//                 pushTest.push(percent);
//                 pushTest.push(test.user_id);
//                 pushTest.push(test.id);
//                 pushTest.push(test.attempt);

//                 // Update Test
//                 await report.updateTest(pushTest).catch((err) => console.log(err));
//             });

//             // Filtering Rank List For Distinct Values
//             const rank = [];
//             const map = new Map();
//             for (const item of rankList) {
//                 if (!map.has(item.id)) {
//                     map.set(item.id, true);
//                     rank.push({
//                         id: item.id,
//                         attempt: item.attempt
//                     });
//                 }
//             }

//             if (rank.length) {
//                 rank.forEach(async (test) => {
//                     // Generate List Of User With Their Rank
//                     await report.generateRank([test.id, test.attempt]).then(async (test) => {
//                         // Update User Rank
//                         test.forEach(async (user) => {
//                             await report.updateRank([user.rank, user.id]).catch((err) => console.log(err));
//                         });
//                     }).catch((err) => console.log(err));
//                 });
//             }
//         }
//         // resolve(results.length);
//     }).catch((err) => { console.log(err); });
//     // });
// }

// Generate Report
const generateReport = async (data) => {
    return new Promise(async (resolve, reject) => {
        await report.generateReport(data).then(async (results) => {
            if (results.length) {
                // Rank List Array to Store Test Id and Attempt For User Rank Generation and Updation
                // rankList = [];
                results.forEach(async (test) => {
                    rankList = [];
                    rankList.push({ id: test.id, attempt: test.attempt });
                    let marks = {
                        correct_question: 0,
                        right_marks: 0,
                        incorrect_question: 0,
                        wrong_marks: 0,
                        negative_marks: 0,
                    }

                    // Adjust Total Marks if Freezewise Setting is Active
                    if (test.freeze_question) {
                        test.total_marks = 0;
                        if (test.section_question) { test.section_question = unserialize(test.section_question); }
                        test.section_question.filter((ques) => { test.total_marks = (test.total_marks + parseInt(ques.marks, 10)) });
                    }

                    let getData = [];
                    getData.push(test.question_sequence);
                    getData.push(test.user_id);
                    getData.push(test.id);
                    getData.push(test.attempt);

                    await query(report.getTestReport, getData).then((tests) => {
                        tests.forEach(async (item) => {
                            let pushData = [];
                            item.question = decode(item.question);

                            // Calculate Marks
                            switch (item.qtype) {
                                case 1:
                                case 2:
                                    if (item.answers !== null) {
                                        if (item.answers !== 'N/A') {
                                            item.answers = JSON.parse(item.answers);
                                        } else {
                                            item.answers = ['0'];
                                        }
                                    } else {
                                        item.answers = ['0'];
                                        item.time_taken = '';
                                    }

                                    // Convert Correct Answers Array Element To String
                                    let answers = [];
                                    item.answers.forEach((val) => {
                                        val = val.toString();
                                        answers.push(val);
                                    });
                                    item.answers = answers.sort((a, b) => a - b);
                                    // phpUnserializing and html decoding
                                    item.question_check = unserialize(item.question_check).sort((a, b) => a - b);

                                    if (JSON.stringify(item.answers) === JSON.stringify(item.question_check)) {
                                        marks.correct_question++;
                                        marks.right_marks = marks.right_marks + item.right_marks;
                                        pushData.push(item.right_marks);
                                        pushData.push(1);
                                    } else {
                                        marks.incorrect_question++;
                                        marks.wrong_marks = marks.wrong_marks + item.wrong_marks;
                                        marks.negative_marks = marks.negative_marks + item.negative_marks;
                                        pushData.push(item.wrong_marks - item.negative_marks);
                                        pushData.push(0);
                                    }

                                    pushData.push(item.id);
                                    pushData.push(test.user_id);
                                    pushData.push(test.id);
                                    pushData.push(test.attempt);

                                    // Update Marks
                                    await query(report.updateTestMarks, pushData).catch((err) => { console.log(err); });
                                    // await report.updateTestMarks(pushData).catch((err) => console.log(err));
                                    break;
                                case 3:
                                    // Do Nothing for Subjetive type Questions.
                                    break;
                                default:
                                    break;
                            }
                        });
                    }).catch((err) => console.log(err));

                    let pushTest = [];
                    // let my_marks = (marks.right_marks + marks.wrong_marks) - marks.negative_marks;
                    let my_marks = (marks.right_marks - marks.wrong_marks);
                    let percent = (my_marks / test.total_marks) * 100;
                    pushTest.push(my_marks);
                    pushTest.push(marks.correct_question);
                    pushTest.push(marks.right_marks);
                    pushTest.push(marks.wrong_marks);
                    pushTest.push(marks.incorrect_question);
                    pushTest.push('-' + marks.negative_marks);
                    pushTest.push(percent);
                    pushTest.push(test.user_id);
                    pushTest.push(test.id);
                    pushTest.push(test.attempt);

                    // Update Test
                    await query(report.updateTest, pushTest).then(() => {
                        generateRank(rankList);
                    }).catch((err) => { console.log(err); });
                    // await report.updateTest(pushTest).catch((err) => console.log(err));
                });
            }
            resolve(results.length);
        });
    }).catch((err) => {
        reject(err);
    });;
}

const generateRank = (rankList) => {
    // Filtering Rank List For Distinct Values
    const rank = [];
    const map = new Map();
    for (const item of rankList) {
        if (!map.has(item.id)) {
            map.set(item.id, true);
            rank.push({
                id: item.id,
                attempt: item.attempt
            });
        }
    }

    if (rank.length) {
        rank.forEach(async (test) => {
            // Generate List Of User With Their Rank
            await query(report.generateRank, [test.id, test.attempt]).then((result) => {
                // Update User Rank
                result.forEach(async (user) => {
                    await query(report.updateRank, [user.rank, user.id]).catch((err) => console.log(err));
                });
            }).catch((err) => console.log(err));
        });
    }
}

module.exports = {
    pushSubject,
    pushLimit,
    generateReport
};