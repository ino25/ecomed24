const { Sequelize } = require("sequelize");
const sequelize = require("../config").sequelize;
const moment = require("moment");
const fs = require("fs");
const path = require("path");
const Client = require("ssh2-sftp-client");
const nodemailer = require("nodemailer");
const axios = require("axios");
const mailer = require("../helpers/LabMailer");
const multer = require("multer");
const { DocmosisTestLab, dataPrepare } = require("../helpers/DocmosisHelper");
const { URLSearchParams } = require("url");

const upload = multer({ dest: "uploads/" });
exports.getAllLabs = async (req, res) => {
  try {
    const labs = await sequelize.query("SELECT * FROM lab_data", {
      type: Sequelize.QueryTypes.SELECT,
    });

    res.json(labs);
  } catch (error) {
    console.error("Erreur :", error);
    res
      .status(500)
      .send("Une erreur s'est produite lors de la récupération des données");
  }
};

//afficher la liste des actes demandés

exports.getActeDemande = async (req, res) => {
  const id_organisation = req.body.id_organisation;

  try {
    // Fetching initial payment data
    const paymentData = await sequelize.query(
      `SELECT * FROM payment WHERE id_organisation = ${sequelize.escape(
        id_organisation
      )} ORDER BY date_string DESC`,
      { type: sequelize.QueryTypes.SELECT }
    );

    let categoryIds = new Set();
    paymentData.forEach((payment) => {
      if (payment.category_name) {
        payment.category_name.split(",").forEach((category) => {
          const [categoryId] = category.split("*");
          categoryIds.add(categoryId);
        });
      }
    });

    // Fetching all needed data in parallel
    const [
      categoriesData,
      servicesData,
      specialitesData,
      prestationsData,
      patientsData,
      labsData,
      allLabData,
    ] = await Promise.all([
      sequelize.query(
        `SELECT * FROM payment_category WHERE id IN (${[...categoryIds]
          .map((id) => sequelize.escape(id))
          .join(", ")})`,
        { type: sequelize.QueryTypes.SELECT }
      ),
      sequelize.query(`SELECT * FROM setting_service`, {
        type: sequelize.QueryTypes.SELECT,
      }),
      sequelize.query(`SELECT * FROM setting_service_specialite`, {
        type: sequelize.QueryTypes.SELECT,
      }),
      sequelize.query(
        `SELECT * FROM payment_category_parametre WHERE id_prestation IN (${[
          ...categoryIds,
        ]
          .map((id) => sequelize.escape(id))
          .join(", ")})`,
        { type: sequelize.QueryTypes.SELECT }
      ),
      sequelize.query(
        `SELECT * FROM patient WHERE id IN (${paymentData
          .map((p) => sequelize.escape(p.patient))
          .join(", ")})`,
        { type: sequelize.QueryTypes.SELECT }
      ),
      sequelize.query(
        `SELECT * FROM lab WHERE payment IN (${paymentData
          .map((p) => sequelize.escape(p.id))
          .join(", ")})`,
        { type: sequelize.QueryTypes.SELECT }
      ),
      sequelize.query(
        `SELECT * FROM lab_data WHERE id_payment IN (${paymentData
          .map((p) => sequelize.escape(p.id))
          .join(", ")})`,
        { type: sequelize.QueryTypes.SELECT }
      ),
    ]);

    // Creating maps for quick lookup
    const serviceMap = servicesData.reduce((map, service) => {
      map[service.idservice] = service;
      return map;
    }, {});

    const specialiteMap = specialitesData.reduce((map, specialite) => {
      map[specialite.idspe] = specialite;
      return map;
    }, {});

    const patientMap = patientsData.reduce((map, patient) => {
      map[patient.id] = patient;
      return map;
    }, {});

    const labMap = labsData.reduce((map, lab) => {
      map[lab.payment] = lab;
      return map;
    }, {});

    const labDataMap = allLabData.reduce((map, labData) => {
      const key = `${labData.id_para}-${labData.id_payment}`;
      map[key] = labData;
      return map;
    }, {});

    // Building the final labData array
    let labData = [];
    paymentData.forEach((payment) => {
      const paymentCategories = payment.category_name
        ? payment.category_name.split(",")
        : [];
      paymentCategories.forEach((categoryString) => {
        const [categoryId, , , , status_number] = categoryString.split("*");
        const category = categoriesData.find(
          (cat) => cat.id.toString() === categoryId
        );
        if (category) {
          const service = serviceMap[category.id_service];
          const specialite = specialiteMap[category.id_spe];
          const patient = patientMap[payment.patient];
          const lab = labMap[payment.id];
          const prestationParams = prestationsData
            .filter((p) => p.id_prestation === category.id)
            .map((p) => {
              const labKey = `${p.idpara}-${payment.id}`;
              return {
                ...p,
                prestationSaisie: labDataMap[labKey]
                  ? labDataMap[labKey]
                  : null,
              };
            });

          labData.push({
            id_payment: payment.id,
            payment_code: payment.code,
            amount: payment.amount,
            code: payment.code + category.id,
            date_string: payment.date_string,
            patient_name: payment.patient_name,
            id_service: category.id_service,
            name_service: service ? service.name_service : null,
            id_specialite: category.id_spe,
            name_specialite: specialite ? specialite.name_specialite : null,
            code_specialite: specialite ? specialite.code_specialite : null,
            id_prestation: category.id,
            prestation: category.prestation,
            id_organisation: payment.id_organisation,
            id_doctor: payment.doctor,
            doctor_name: payment.doctor_name,
            status_number: status_number,
            status:
              ["UNKNOWN", "EN COURS", "EFFECTUÉ", "VALIDÉ"][status_number] ||
              "UNKNOWN",
            date_prelevement: lab ? lab.date_prelevement : null,
            clinique: payment.renseignementClinique,
            patient_data: patient,
            prestationDetails: prestationParams,
            lab: lab,
            motifVoyage: payment.motifVoyage,
          });
        }
      });
    });

    // Sorting and sending response
    labData.sort((a, b) => new Date(b.date_string) - new Date(a.date_string));
    if (labData.length > 0) {
      res.json(labData);
    } else {
      res.status(404).send("Pas de données trouvées pour cet id_organisation");
    }
  } catch (error) {
    console.error("Erreur :", error);
    res
      .status(500)
      .send("Une erreur s'est produite lors de la récupération des données");
  }
};

//obtenir le nombre de spécialité en cours ou effectué

exports.getStats = async (req, res) => {
  const id_organisation = req.body.id_organisation;

  try {
    const paymentData = await sequelize.query(
      `SELECT payment.id, payment.code, payment.category_name, payment.date_string, payment.patient_name, payment.id_organisation, payment.patient, payment.doctor_name, payment.doctor
       FROM payment
       WHERE payment.id_organisation = ${sequelize.escape(id_organisation)}
       ORDER BY payment.date_string DESC`,
      { type: sequelize.QueryTypes.SELECT }
    );

    let labData = [];
    for (let payment of paymentData) {
      let category_ids = payment.category_name
        ? payment.category_name.split(",")
        : [];
      for (let category_id of category_ids) {
        let splitString = category_id.split("*");
        const id_prestation = splitString[0];
        const status_number = splitString[4];

        const categoryData = await sequelize.query(
          `SELECT id, prestation, id_service,	id_spe  FROM payment_category WHERE id = ${sequelize.escape(
            id_prestation
          )}`,
          { type: sequelize.QueryTypes.SELECT }
        );

        if (categoryData[0]) {
          // Get name_specialite
          const specialiteData = await sequelize.query(
            `SELECT name_specialite FROM setting_service_specialite WHERE idspe = ${sequelize.escape(
              categoryData[0].id_spe
            )}`,
            { type: sequelize.QueryTypes.SELECT }
          );

          if (specialiteData[0]) {
            let specialites = specialiteData[0].name_specialite.split(",");
            for (let specialite of specialites) {
              let splitSpecialite = specialite.split("*");
              const name_specialite = splitSpecialite[0];
              if (status_number === "1" || status_number === "2") {
                labData.push({
                  name_specialite: name_specialite,
                  status_number: status_number,
                });
              }
            }
          }
        }
      }
    }

    let stats = labData.reduce((result, item) => {
      let key = `${item.name_specialite}`;
      if (!result[key]) {
        result[key] = { name_specialite: item.name_specialite, total: 0 };
      }
      result[key].total++;
      return result;
    }, {});

    stats = Object.values(stats);
    // Trier les stats par name_specialite
    stats.sort((a, b) => a.name_specialite.localeCompare(b.name_specialite));

    if (stats.length > 0) {
      res.json(stats);
    } else {
      res.status(404).send("Pas de données trouvées pour cet id_organisation");
    }
  } catch (error) {
    console.error("Erreur :", error);
    res
      .status(500)
      .send("Une erreur s'est produite lors de la récupération des données");
  }
};

exports.LabData = async (req, res) => {
  const record = req.body;
  console.log(req.body); // Pour voir ce que contient le corps de la requête
  console.log(req.body.lab); // Pour vérifier si l'objet 'lab' existe
  try {
    const existingRecord = await sequelize.query(
      `SELECT * FROM lab WHERE payment = ${sequelize.escape(
        record.lab.payment
      )}`,
      { type: sequelize.QueryTypes.SELECT }
    );

    let labId;
    if (!existingRecord.length) {
      const sqlInsertQuery = `
        INSERT INTO lab (patient, payment, demendeur, date, user, patient_name, doctor_name, date_string, id_organisation, code, consultation, numeroRegistre, prescripteur, nomLabo, importLabo, date_prelevement, numero_identifiant, id_presta)
        VALUES (${sequelize.escape(record.lab.patient)}, ${sequelize.escape(
        record.lab.payment
      )}, ${sequelize.escape(record.lab.demendeur)}, ${sequelize.escape(
        record.lab.date
      )}, ${sequelize.escape(record.lab.user)}, ${sequelize.escape(
        record.lab.patient_name
      )}, ${sequelize.escape(record.lab.doctor_name)}, ${sequelize.escape(
        record.lab.date_string
      )}, ${sequelize.escape(record.lab.id_organisation)}, ${sequelize.escape(
        record.lab.code
      )}, ${sequelize.escape(record.lab.consultation)}, ${sequelize.escape(
        record.lab.numeroRegistre
      )}, ${sequelize.escape(record.lab.prescripteur)}, ${sequelize.escape(
        record.lab.nomLabo
      )}, ${sequelize.escape(record.lab.importLabo)}, ${sequelize.escape(
        record.lab.date_prelevement
      )}, ${sequelize.escape(
        record.lab.numero_identifiant
      )}, ${sequelize.escape(record.lab.id_presta)} )
      `;
      const insertResult = await sequelize.query(sqlInsertQuery);
      labId = insertResult[0];
    } else {
      labId = existingRecord[0].id;
    }

    for (let labDataRecord of record.labdata) {
      const sqlInsertQuery = `
        INSERT INTO lab_data (id_lab, id_para, idPaymentConcatRelevantCategoryPart, id_prestation, id_payment, resultats, status)
        VALUES (${sequelize.escape(labId)}, ${sequelize.escape(
        labDataRecord.idpara
      )}, ${sequelize.escape(
        labDataRecord.idPaymentConcatRelevantCategoryPart
      )}, ${sequelize.escape(labDataRecord.id_prestation)}, ${sequelize.escape(
        labDataRecord.id_payment
      )}, ${sequelize.escape(labDataRecord.resultats)}, ${sequelize.escape(
        labDataRecord.status
      )})
      `;
      await sequelize.query(sqlInsertQuery);

      const paymentRecord = await sequelize.query(
        `SELECT * FROM payment WHERE id = ${sequelize.escape(
          labDataRecord.id_payment
        )}`,
        { type: sequelize.QueryTypes.SELECT }
      );

      let categoryNames = paymentRecord[0].category_name.split(",");
      categoryNames = categoryNames.map((categoryName) => {
        const parts = categoryName.split("*");
        if (parts[0] === labDataRecord.id_prestation.toString()) {
          parts[4] = labDataRecord.status;
          return parts.join("*");
        }
        return categoryName;
      });

      const updatedCategoryName = categoryNames.join(",");

      const sqlUpdateQuery = `
     UPDATE payment
     SET category_name = ${sequelize.escape(updatedCategoryName)},
     renseignementClinique = ${sequelize.escape(
       record.lab.renseignementClinique
     )}
     WHERE id = ${sequelize.escape(labDataRecord.id_payment)}
   `;
      await sequelize.query(sqlUpdateQuery);
    }

    res.json({
      message:
        "Les enregistrements ont été insérés avec succès dans les tables 'lab' et 'labData'",
    });
  } catch (error) {
    console.error("Erreur :", error);
    res
      .status(500)
      .send(
        "Une erreur s'est produite lors de l'insertion des données dans les tables 'lab' et 'labData'"
      );
  }
};

exports.Reprendre = async (req, res) => {
  const { id_payment, id_prestation, status } = req.body;

  try {
    // Update the payment table
    let paymentData = await sequelize.query(
      `SELECT category_name FROM payment WHERE id = ${sequelize.escape(
        id_payment
      )}`,
      { type: sequelize.QueryTypes.SELECT }
    );
    if (paymentData.length > 0) {
      let category_name = paymentData[0].category_name.split(",");
      for (let i = 0; i < category_name.length; i++) {
        let splitString = category_name[i].split("*");
        if (splitString[0] == id_prestation) {
          splitString[4] = status;
          category_name[i] = splitString.join("*");
          break;
        }
      }
      category_name = category_name.join(",");
      await sequelize.query(
        `UPDATE payment SET category_name = ${sequelize.escape(
          category_name
        )} WHERE id = ${sequelize.escape(id_payment)}`
      );
    }

    // Delete entries in the lab_data table
    await sequelize.query(
      `DELETE FROM lab_data WHERE id_prestation = ${sequelize.escape(
        id_prestation
      )} AND id_payment = ${sequelize.escape(id_payment)}`
    );

    res.json({ message: "Update and deletion successful" });
  } catch (error) {
    console.error("Error: ", error);
    res.status(500).send("An error occurred while updating the data");
  }
};

exports.Validation = async (req, res) => {
  const { id_payment, id_prestations, status } = req.body;

  try {
    let paymentData = await sequelize.query(
      `SELECT category_name FROM payment WHERE id = ${sequelize.escape(
        id_payment
      )}`,
      { type: sequelize.QueryTypes.SELECT }
    );
    if (paymentData.length > 0) {
      let category_name = paymentData[0].category_name.split(",");
      for (let i = 0; i < category_name.length; i++) {
        let splitString = category_name[i].split("*");
        for (let j = 0; j < id_prestations.length; j++) {
          if (splitString[0] == id_prestations[j]) {
            splitString[4] = status;
            category_name[i] = splitString.join("*");
            console.log("category_name after update: ", category_name); // Add logging
            break;
          }
        }
      }
      category_name = category_name.join(",");
      console.log("Final category_name: ", category_name); // Add logging
      await sequelize.query(
        `UPDATE payment SET category_name = ${sequelize.escape(
          category_name
        )} WHERE id = ${sequelize.escape(id_payment)}`
      );
    }

    for (let k = 0; k < id_prestations.length; k++) {
      await sequelize.query(
        `UPDATE lab_data SET status = ${sequelize.escape(
          status
        )} WHERE id_prestation = ${sequelize.escape(
          id_prestations[k]
        )} AND id_payment = ${sequelize.escape(id_payment)}`
      );
    }

    res.json({ message: "Update successful" });
  } catch (error) {
    console.error("Error: ", error);
    res.status(500).send("An error occurred while updating the data");
  }
};

exports.getResultatById = async (req, res) => {
  const id_organisation = req.body.id_organisation;
  const id_payment = req.body.id_payment;

  try {
    const paymentData = await sequelize.query(
      `SELECT payment.id, payment.code, payment.category_name, payment.date_string, payment.patient_name, payment.id_organisation, payment.patient, payment.doctor_name, payment.doctor, payment.amount,payment.renseignementClinique
       FROM payment
       WHERE payment.id_organisation = ${sequelize.escape(
         id_organisation
       )} AND payment.id = ${sequelize.escape(id_payment)}
       ORDER BY payment.date_string DESC`,
      { type: sequelize.QueryTypes.SELECT }
    );

    let results = [];

    for (let payment of paymentData) {
      let category_ids = payment.category_name
        ? payment.category_name.split(",")
        : [];
      let prestats = [];

      for (let category_id of category_ids) {
        let splitString = category_id.split("*");
        category_id = splitString[0];
        const status_number = splitString[4];
        let status;
        if (status_number === "1") status = "EN COURS";
        else if (status_number === "2") status = "EFFECTUÉ";
        else if (status_number === "3") status = "VALIDÉ";
        else status = "UNKNOWN";

        const categoryData = await sequelize.query(
          `SELECT id, prestation, id_service,	id_spe  FROM payment_category WHERE id = ${sequelize.escape(
            category_id
          )}`,
          { type: sequelize.QueryTypes.SELECT }
        );

        if (categoryData[0]) {
          const serviceData = await sequelize.query(
            `SELECT name_service FROM setting_service WHERE idservice = ${sequelize.escape(
              categoryData[0].id_service
            )}`,
            { type: sequelize.QueryTypes.SELECT }
          );

          const specialiteData = await sequelize.query(
            `SELECT name_specialite FROM setting_service_specialite WHERE idspe = ${sequelize.escape(
              categoryData[0].id_spe
            )}`,
            { type: sequelize.QueryTypes.SELECT }
          );

          const prestationParamData = await sequelize.query(
            `SELECT * FROM payment_category_parametre WHERE id_prestation = ${sequelize.escape(
              categoryData[0].id
            )}`,
            { type: sequelize.QueryTypes.SELECT }
          );

          let prestationParam = await Promise.all(
            prestationParamData.map(async (param) => {
              const prestationSaisieData = await sequelize.query(
                `SELECT * FROM lab_data WHERE id_para = ${sequelize.escape(
                  param.idpara
                )} AND id_payment = ${sequelize.escape(payment.id)}`,
                { type: sequelize.QueryTypes.SELECT }
              );

              return {
                // ... rest of your data here
                id: param.idpara,
                idprestation: param.id_prestation,
                idspecialite: param.id_specialite,
                nomparametre: param.nom_parametre,
                unite: param.unite,
                valeurs: param.unite,
                ref_low: param.ref_low,
                ref_high: param.ref_high,
                type: param.type,
                set_of_code: param.set_of_code,
                prestationSaisie: prestationSaisieData[0]
                  ? prestationSaisieData[0]
                  : null,
              };
            })
          );

          prestats.push({
            id_prestation: categoryData[0].id,
            prestation: categoryData[0].prestation,
            id_service: categoryData[0].id_service,
            name_service: serviceData[0] ? serviceData[0].name_service : null,
            id_specialite: categoryData[0].id_spe,
            name_specialite: specialiteData[0]
              ? specialiteData[0].name_specialite
              : null,
            status_number: status_number,
            status: status,
            prestationDetails: prestationParam,
          });
        }
      }

      const patientData = await sequelize.query(
        `SELECT * FROM patient WHERE id = ${sequelize.escape(payment.patient)}`,
        { type: sequelize.QueryTypes.SELECT }
      );

      let labDataPrelevement = await sequelize.query(
        `SELECT date_prelevement, numeroRegistre, numero_identifiant FROM lab WHERE payment = ${sequelize.escape(
          payment.id
        )}`,
        { type: sequelize.QueryTypes.SELECT }
      );
      let date_prelevement = labDataPrelevement[0]
        ? labDataPrelevement[0].date_prelevement
        : null;
      let numeroRegistre = labDataPrelevement[0]
        ? labDataPrelevement[0].numeroRegistre
        : null;
      let numero_identifiant = labDataPrelevement[0]
        ? labDataPrelevement[0].numero_identifiant
        : null;

      results.push({
        id_payment: payment.id,
        payment_code: payment.code,
        amount: payment.amount,
        code: payment.code + (category_ids.length > 0 ? category_ids[0] : ""),
        date_string: payment.date_string,
        patient_name: payment.patient_name,
        id_organisation: payment.id_organisation,
        id_doctor: payment.doctor,
        doctor_name: payment.doctor_name,
        date_prelevement: date_prelevement,
        numero_identifiant: numero_identifiant,
        numeroRegistre: numeroRegistre,
        clinique: payment.renseignementClinique,
        patient_data: patientData[0] ? patientData[0] : null,
        prestats: prestats,
      });
    }

    results.sort((a, b) => (a.date_string < b.date_string ? 1 : -1));

    return res.status(200).send(results);
  } catch (error) {
    console.error(`[Error in controller] ${error}`);
    return res.status(500).send({ error });
  }
};

exports.getUserById = async (req, res) => {
  try {
    const userId = req.params.id;

    // Récupérer les informations de l'utilisateur
    const user = await sequelize.query(
      `SELECT * FROM users WHERE id = ${sequelize.escape(userId)}`,
      { type: sequelize.QueryTypes.SELECT }
    );
    if (user.length === 0) {
      return res.status(404).send({ message: "Utilisateur non trouvé." });
    }

    // Récupérer les groupes auxquels l'utilisateur appartient
    const groups = await sequelize.query(
      `SELECT g.* FROM \`groups\` g JOIN users_groups ug ON g.id = ug.group_id WHERE ug.user_id = ${sequelize.escape(
        userId
      )}`,
      { type: sequelize.QueryTypes.SELECT }
    );

    // Récupérer l'organisation de l'utilisateur
    const organisation = await sequelize.query(
      `SELECT * FROM organisation WHERE id = ${sequelize.escape(
        user[0].id_organisation
      )}`,
      { type: sequelize.QueryTypes.SELECT }
    );
    if (organisation.length === 0) {
      return res.status(404).send({ message: "Organisation non trouvée." });
    }

    // Récupérer la signature
    const doctor_signature = await sequelize.query(
      `SELECT * FROM doctor_signature WHERE doc_id = ${sequelize.escape(
        userId
      )}`,
      { type: sequelize.QueryTypes.SELECT }
    );
    /*if (doctor_signature.length === 0) {
      return res.status(404).send({ message: 'Signature non trouvée.' });
    }*/

    // récuperer setting
    const settings = await sequelize.query(`SELECT * FROM settings `, {
      type: sequelize.QueryTypes.SELECT,
    });

    const otherUsersInOrganization = await sequelize.query(
      `
    SELECT u.*, d.*
    FROM users u
    INNER JOIN doctor d ON u.id = d.ion_user_id
    WHERE u.id_organisation = ${sequelize.escape(user[0].id_organisation)}
  `,
      { type: sequelize.QueryTypes.SELECT }
    );

    const result = {
      id: user[0].id,
      id_organisation: user[0].id_organisation,
      email_user: user[0].email,
      first_name: user[0].first_name,
      last_name: user[0].last_name,
      name: groups[0].name,
      description: groups[0].description,
      label_fr: groups[0].label_fr,
      organisation: organisation[0],
      settings: settings[0],
      otherUsersInOrganization: otherUsersInOrganization,
      code: organisation[0].code,
      nom: organisation[0].nom,
      nom_commercial: organisation[0].nom_commercial,
      path_logo: organisation[0].path_logo,
      entete: organisation[0].entete,
      footer: organisation[0].footer,
      doctorSignature: doctor_signature[0],
      signature: doctor_signature[0] ? doctor_signature[0].sign_name : null,
      adresse: organisation[0].adresse,
      email: organisation[0].email,
      numero_fixe: organisation[0].numero_fixe,
    };

    res.status(200).send(result);
  } catch (error) {
    console.error(`[Error in controller] ${error}`);
    return res.status(500).send({
      error: "Une erreur s'est produite lors de la récupération des données",
    });
  }
};

// Endpoint pour sauvegarder le fichier PDF

exports.savePDF = (req, res) => {
  try {
    const type = req.body.type;
    const ouputName = req.body.ouputName;
    const data = req.body.data;

    DocmosisTestLab(type, ouputName, data)
      .then(async (response) => {
        if (response.status) {
          res.json({
            status: 1,
            message: response.message,
            pdfpath: response.pdfPath,
          });
        } else {
          res.json({
            status: 0,
            message: "Server Error, Please Try Againg Later!!",
          });
        }
        console.log("Response:", response, req.body.type);
      })
      .catch((error) => {
        console.error("Error:", error);
        res.json({
          status: 0,
          message: "Server Error, Please Try Againg Later!!",
        });
      });
  } catch (error) {
    console.error("Error:", error);
    res.json({ status: 0, message: "Server Error, Please Try Againg Later!!" });
    // throw error;
  }
};

exports.envoiPdf = async (req, res) => {
  const { email, pdfFilePath } = req.body;

  const fileName = path.basename(pdfFilePath);
  const filePath = pdfFilePath;

  fs.access(filePath, fs.constants.F_OK, async (err) => {
    if (err) {
      console.error("Fichier PDF introuvable:", err);
      return res.status(404).send({ message: "Fichier PDF introuvable." });
    }

    const mailOptions = {
      from: "contact@pathfinderacademy.in",
      to: email,
      subject: "Votre fichier PDF",
      html: "Voici votre fichier PDF en pièce jointe.",
      attachments: [
        {
          filename: fileName,
          path: filePath,
        },
      ],
    };

    // Utilisez la fonction mailer pour envoyer l'e-mail
    try {
      const emailSent = await mailer(
        email,
        mailOptions.from,
        mailOptions.subject,
        mailOptions.html,
        mailOptions.attachments
      );
      if (emailSent) {
        console.log("E-mail envoyé avec succès.");
        res.status(200).send("E-mail envoyé avec succès.");
      } else {
        throw new Error("Failed to send email");
      }
    } catch (error) {
      console.error("Erreur lors de l'envoi de l'e-mail :", error);
      res.status(500).send("Erreur lors de l'envoi de l'e-mail.");
    }
  });
};
