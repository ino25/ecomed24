const Sequelize = require("sequelize");
const Database = require("../config").sequelize;
const Op = Sequelize.Op;
const moment = require("moment");
moment.locale("en");
const path = require("path");
const nodemailer = require("nodemailer");
const { parseAndValidateExcelPrice } = require("../taks/excel.taks.js");

var User = require("../models/User");
var Patient = require("../models/Patient");

var Organisation = require("../models/Organisation");
var OrganisationType = require("../models/OrganizationType");
var PricingCategory = require("../models/PricingCategory");
var PatientDepositInvoice = require("../models/PatientDepositInvoice");
var Payment = require("../models/Payment");
var ServiceCategory = require("../models/ServiceCategory");
var Settings = require("../models/Settings");
var PaymentCategory = require("../models/PaymentCategory");
const multer = require("multer");
const fs = require("fs");
const formidable = require("formidable");

var SettingServiceSpecialite = require("../models/SettingServiceSpecialite");
var PaymentCategoryOrganisation = require("../models/PaymentCategoryOrganisation");
var PriceGrids = require("../models/PriceGrids");
var PriceGridDetails = require("../models/PriceGridDetails");

// Attachments

Organisation.belongsTo(User, { as: "addedby_details", foreignKey: "added_by" });
Organisation.belongsTo(User, {
  as: "updatedby_details",
  foreignKey: "updated_by",
});
Organisation.belongsTo(OrganisationType, {
  as: "type_details",
  foreignKey: "type",
});
// Organisation.belongsTo(DocumentTypes, {as: 'doctypes_details',foreignKey: 'category'});

// Price Grids
PaymentCategoryOrganisation.belongsTo(PaymentCategory, {
  foreignKey: "id_presta",
});
PaymentCategory.hasMany(PaymentCategoryOrganisation, { foreignKey: "id" });

PaymentCategory.belongsTo(SettingServiceSpecialite, { foreignKey: "id_spe" });
SettingServiceSpecialite.hasMany(PaymentCategory, { foreignKey: "idspe" });

// Patient Deposit invoice
PatientDepositInvoice.belongsTo(User, {
  as: "addedby_details",
  foreignKey: "added_by",
});
PatientDepositInvoice.belongsTo(User, {
  as: "updatedby_details",
  foreignKey: "updated_by",
});
PatientDepositInvoice.belongsTo(Organisation, {
  as: "org_details",
  foreignKey: "id_organisation",
});

//
//////Modal Relationship

exports.getOrganizationList = async (req, res) => {
  try {
    let offsetdata = parseInt(
      req.query.offset
        ? req.query.offset == undefined || req.query.offset == 1
          ? 0
          : req.query.offset
        : 0
    );
    if (isNaN(offsetdata)) {
      offsetdata = 0;
    }
    let datalimit = parseInt(
      req.query.limit ? (req.query.limit == undefined ? 5 : req.query.limit) : 5
    );
    if (isNaN(datalimit)) {
      datalimit = 5;
    }
    const { count, rows } = await Organisation.findAndCountAll();
    OrganisationModal = await Organisation.findAll({
      attributes: [
        "id",
        "code",
        "nom",
        "nom_commercial",
        "email",
        "portable_responsable_legal",
        "type",
        "adresse",
        "est_active",
        "is_light",
        "other_emails",
        "pricing_category",
        "is_whatsapp",
        "status",
        "added_by",
        "updated_by",
        [
          Sequelize.fn(
            "DATE_FORMAT",
            Sequelize.col("Organisation.createdAt"),
            "%d/%m/%Y %H:%i"
          ),
          "createdAt",
        ],
        [
          Sequelize.fn(
            "DATE_FORMAT",
            Sequelize.col("Organisation.updatedAt"),
            "%d/%m/%Y %H:%i"
          ),
          "updatedAt",
        ],
      ],
      order: [["id", "DESC"]],
      limit: datalimit,
      offset: offsetdata,
      include: [
        {
          model: User,
          attributes: [
            "id",
            ["id_organisation", "org_id"],
            "first_name",
            "last_name",
            "username",
            "email",
          ],
          as: "addedby_details",
        },
        {
          model: User,
          attributes: [
            "id",
            ["id_organisation", "org_id"],
            "first_name",
            "last_name",
            "username",
            "email",
          ],
          as: "updatedby_details",
        },
        {
          model: OrganisationType,
          attributes: ["id", "name"],
          as: "type_details",
        },
      ],
    });
    if (OrganisationModal === null) {
      res.json({ status: 0, message: "No Data Found" });
    } else {
      res.json({
        status: 1,
        message: "Organization List",
        data: OrganisationModal,
        total: count,
      });
    }
  } catch (error) {
    throw error;
  }
};

exports.getOrganizationByID = async (req, res) => {
  try {
    OrganisationModal = await Organisation.findAll({
      attributes: [
        "id",
        "code",
        "nom",
        "nom_commercial",
        "email",
        "portable_responsable_legal",
        "adresse",
        "region",
        "departement",
        "type",
        "est_active",
        "is_light",
        "other_emails",
        "pricing_category",
        "is_whatsapp",
        "status",
        "added_by",
        "updated_by",
        [
          Sequelize.fn(
            "DATE_FORMAT",
            Sequelize.col("createdAt"),
            "%d/%m/%Y %H:%i"
          ),
          "createdAt",
        ],
        [
          Sequelize.fn(
            "DATE_FORMAT",
            Sequelize.col("updatedAt"),
            "%d/%m/%Y %H:%i"
          ),
          "updatedAt",
        ],
      ],
      where: { id: req.params.org_id },
    });
    if (OrganisationModal === null) {
      res.json({ status: 0, message: "No Data Found" });
    } else {
      res.json({
        status: 1,
        message: "Organization List",
        data: OrganisationModal,
      });
    }
  } catch (error) {
    throw error;
  }
};

exports.addOrganization = async (req, res) => {
  try {
    // console.log(req.body);
    OrganisationModal = await Organisation.create({
      nom: req.body.name,
      type: req.body.type,
      portable_responsable_legal: req.body.phone,
      is_light: req.body.is_light,
      email: req.body.email,
      pricing_category: req.body.pricing_category,
      adresse: req.body.address,
      country: req.body.country,
      region: req.body.region,
      district: req.body.district,
      added_by: req.userId,
      status: 1,
    });
    if (OrganisationModal === null) {
      res.json({
        status: 0,
        message: "Something Went Wrong, Please Try Againg Later!!",
      });
    } else {
      res.json({
        status: 1,
        message: "New Organization Has been added.",
        data: "",
      });
    }
  } catch (error) {
    res.json({ status: 0, message: "Server Error, Please Try Againg Later!!" });
    // throw error;
  }
};

exports.updateOrganization = async (req, res) => {
  try {
    OrganisationModal = await Organisation.update(
      {
        nom: req.body.name,
        type: req.body.type,
        portable_responsable_legal: req.body.phone,
        is_whatsapp: req.body.is_whatsapp,
        is_light: req.body.is_light,
        email: req.body.email,
        other_emails: req.body.other_emails,
        adresse: req.body.address,
        pays: req.body.country,
        region: req.body.region,
        departement: req.body.district,
        updated_by: req.userId,
      },
      {
        where: { id: req.params.org_id },
      }
    );
    if (OrganisationModal === null) {
      res.json({
        status: 0,
        message: "Something Went Wrong, Please Try Againg Later!!",
      });
    } else {
      res.json({
        status: 1,
        message: "Organization has been updated.",
        data: "",
      });
    }
  } catch (error) {
    throw error;
  }
};
exports.statusOrganization = async (req, res) => {
  try {
    OrganisationModal = await Organisation.update(
      { status: req.body.status },
      { where: { id: req.params.id } }
    );
    if (OrganisationModal === null) {
      res.json({
        status: 0,
        message: "Something Went Wrong, Please Try Againg Later!!",
      });
    } else {
      res.json({
        status: 1,
        message: "Organization status has been Updated.",
        data: "",
      });
    }
  } catch (error) {
    throw error;
  }
};

exports.updatePricing = async (req, res) => {
  try {
    OrganisationModal = await Organisation.update(
      { pricing_category: req.body.pricing_category },
      { where: { id: req.params.id } }
    );
    if (OrganisationModal === null) {
      res.json({
        status: 0,
        message: "Something Went Wrong, Please Try Againg Later!!",
      });
    } else {
      res.json({
        status: 1,
        message: "Organization status has been Updated.",
        data: "",
      });
    }
  } catch (error) {
    throw error;
  }
};
exports.getPricingCategory = async (req, res) => {
  try {
    PricingCategoryModal = await PricingCategory.findAll({
      attributes: [
        "id",
        "name",
        "status",
        "added_by",
        "updated_by",
        [
          Sequelize.fn(
            "DATE_FORMAT",
            Sequelize.col("createdAt"),
            "%d-%m-%Y %H:%i:%s"
          ),
          "createdAt",
        ],
        [
          Sequelize.fn(
            "DATE_FORMAT",
            Sequelize.col("updatedAt"),
            "%d-%m-%Y %H:%i:%s"
          ),
          "updatedAt",
        ],
      ],
      order: [["id", "DESC"]],
    });
    if (PricingCategoryModal === null) {
      res.json({ status: 0, message: "No Data Found" });
    } else {
      res.json({
        status: 1,
        message: "Pricing Category List",
        data: PricingCategoryModal,
      });
    }
  } catch (error) {
    throw error;
  }
};

exports.getOrganizationType = async (req, res) => {
  try {
    OrganisationTypeModal = await OrganisationType.findAll({
      attributes: [
        "id",
        "name",
        "status",
        "added_by",
        "updated_by",
        [
          Sequelize.fn(
            "DATE_FORMAT",
            Sequelize.col("createdAt"),
            "%d-%m-%Y %H:%i:%s"
          ),
          "createdAt",
        ],
        [
          Sequelize.fn(
            "DATE_FORMAT",
            Sequelize.col("updatedAt"),
            "%d-%m-%Y %H:%i:%s"
          ),
          "updatedAt",
        ],
      ],
      order: [["id", "DESC"]],
    });
    if (OrganisationTypeModal === null) {
      res.json({ status: 0, message: "No Data Found" });
    } else {
      res.json({
        status: 1,
        message: "Organization Types List",
        data: OrganisationTypeModal,
      });
    }
  } catch (error) {
    throw error;
  }
};

exports.getInvoicePaymentsByORG = async (req, res) => {
  try {
    let offsetdata = parseInt(
      req.query.offset
        ? req.query.offset == undefined || req.query.offset == 1
          ? 0
          : req.query.offset
        : 0
    );
    if (isNaN(offsetdata)) {
      offsetdata = 0;
    }
    let datalimit = parseInt(
      req.query.limit ? (req.query.limit == undefined ? 5 : req.query.limit) : 5
    );
    if (isNaN(datalimit)) {
      datalimit = 5;
    }
    id_organisation = req.params.org_id;
    OrganisationModal = await Database.query(
      `SELECT 
      payment_pro.idpro,
      (select organisation.nom from organisation where organisation.id = payment_pro.id_organisation limit 1) as nom,
      (select organisation.nom from organisation where organisation.id = payment_pro.id_organisation_destinataire limit 1) as destinataire,
      payment_pro.statut,
      payment_pro.codepro,
      payment_pro.codefacture,
      DATE_FORMAT(FROM_UNIXTIME(payment_pro.date), '%d/%m/%Y %H:%i') AS date,
      DATE_FORMAT(FROM_UNIXTIME(payment_pro.dateDebut), '%d/%m/%Y %H:%i') AS dateDebut,
      DATE_FORMAT(FROM_UNIXTIME(payment_pro.dateFin), '%d/%m/%Y %H:%i') AS dateFin,
      payment_pro.amount,
      payment_pro.users_valided,
      DATE_FORMAT(FROM_UNIXTIME(payment_pro.date_paiement), '%d/%m/%Y %H:%i') AS date_paiement,
      payment_pro.canal_paiement,
      payment_pro.transfer,
      payment_pro.reference
      from payment_pro
      where payment_pro.id_organisation_destinataire = ${id_organisation} ORDER BY payment_pro.idpro DESC LIMIT ${offsetdata}, ${datalimit}`,
      { type: Database.QueryTypes.SELECT }
    );
    if (OrganisationModal === null) {
      res.json({ status: 0, message: "No Data Found" });
    } else {
      res.json({
        status: 1,
        message: "Organization Invoice List",
        data: OrganisationModal,
      });
    }
  } catch (error) {
    throw error;
  }
};

exports.getPaymentReceipt = async (req, res) => {
  try {
    let payment_id = req.params.payment_id;
    PaymentReceipt = await Database.query(
      "select payment_pro.codefacture,CONCAT(codefacture, '.pdf') AS file,'/uploads/invoicefile/' AS url from payment_pro where idpro=" +
        payment_id,
      { type: Database.QueryTypes.SELECT }
    );
    if (PaymentReceipt === null) {
      res.json({ status: 0, message: "No Data Found" });
    } else {
      res.json({ status: 1, message: "Payment Receipt", data: PaymentReceipt });
    }
  } catch (error) {
    throw error;
  }
};

exports.getPaymentDetails = async (req, res) => {
  let data = {};
  let payment_id = req.params.payment_id;
  data.settings = await Settings.findOne();
  PaymentDetails = await Database.query(
    `select payment_pro.idpro as id,
                                        (select organisation.nom from organisation where organisation.id = payment_pro.id_organisation_destinataire limit 1) as destinataire,
                                        payment_pro.codefacture,
                                        payment_pro.dateDebut,
                                        payment_pro.dateFin,
                                        payment_pro.amount,
                                        (SELECT SUM(deposited_amount) AS total_deposited_amount FROM patient_deposit_invoice where payment_id=payment_pro.idpro) as total_deposited_amount,
                                        (payment_pro.amount - (SELECT SUM(deposited_amount) AS total_deposited_amount 
                                        FROM patient_deposit_invoice where payment_id=payment_pro.idpro)) as total_due,
                                        payment_pro.id_organisation_destinataire 
                                        from payment_pro where idpro=${payment_id}`,
    { type: Database.QueryTypes.SELECT }
  );

  //console.log(data.services);

  res.json({ status: 1, message: "Payment Details", data: PaymentDetails });
};

exports.getDepositList = async (req, res) => {
  try {
    let offsetdata = parseInt(
      req.query.offset
        ? req.query.offset == undefined || req.query.offset == 1
          ? 0
          : req.query.offset
        : 0
    );
    if (isNaN(offsetdata)) {
      offsetdata = 0;
    }
    let datalimit = parseInt(
      req.query.limit ? (req.query.limit == undefined ? 5 : req.query.limit) : 5
    );
    if (isNaN(datalimit)) {
      datalimit = 5;
    }
    let payment_id = req.params.payment_id;
    Deposits = await Database.query(
      `select 
      payment_pro.codefacture, 
      patient_deposit_invoice.id,  
      patient_deposit_invoice.id_organisation, 
      patient_deposit_invoice.payment_id, 
      DATE_FORMAT(FROM_UNIXTIME(patient_deposit_invoice.date), '%d/%m/%Y %H:%i') AS date,
      DATE_FORMAT(FROM_UNIXTIME(payment_pro.dateDebut), '%d/%m/%Y %H:%i') AS start_date,
      DATE_FORMAT(FROM_UNIXTIME(payment_pro.dateFin), '%d/%m/%Y %H:%i') AS end_date,
      patient_deposit_invoice.deposited_amount, 
      patient_deposit_invoice.amount_received_id, 
      patient_deposit_invoice.deposit_type, 
      patient_deposit_invoice.gateway, 
      patient_deposit_invoice.id_transaction_externe, 
      patient_deposit_invoice.user, 
      patient_deposit_invoice.status, 
      patient_deposit_invoice.added_by, 
      patient_deposit_invoice.updated_by, 
      patient_deposit_invoice.createdAt, 
      patient_deposit_invoice.updatedAt 
      from patient_deposit_invoice, payment_pro where payment_pro.idpro = patient_deposit_invoice.payment_id and patient_deposit_invoice.payment_id=${payment_id} ORDER BY patient_deposit_invoice.id DESC LIMIT  ${offsetdata}, ${datalimit}`,
      { type: Database.QueryTypes.SELECT }
    );
    if (Deposits === null) {
      res.json({ status: 0, message: "No Data Found" });
    } else {
      res.json({
        status: 1,
        message: "Organization Deposit List",
        data: Deposits,
      });
    }
  } catch (error) {
    throw error;
  }
};

exports.addDeposit = async (req, res) => {
  try {
    let getData = [],
      getRelationData = [],
      results;
    console.log(req.body);
    PatientDepositInvoiceModal = await PatientDepositInvoice.create({
      date: moment().unix(),
      deposited_amount: req.body.deposited_amount,
      payment_id: req.body.payment_id,
      amount_received_id: req.body.amount_received_id,
      deposit_type: req.body.deposit_type,
      partner_id: req.body.partner_id,
      reference: req.body.reference,
      id_organisation: req.org_id,
      user: req.userId,
      added_by: req.userId,
    });
    if (PatientDepositInvoiceModal === null) {
      return res.json({ status: 0, message: langCommon.errormessage });
    } else {
      return res.json({
        status: 1,
        message: "New Deposit has been saved",
        data: "",
      });
    }
  } catch (error) {
    throw error;
  }
};

exports.getOrganisationPrestation = async (req, res) => {
  try {
    if (req.params.type_id == "1") {
      const PaymentCategoryOrganisationModal =
        await PaymentCategoryOrganisation.findAll({
          attributes: [
            "idpco",
            [
              Sequelize.fn(
                "ROUND",
                Sequelize.col(
                  "PaymentCategoryOrganisation.tarif_professionnel"
                ),
                0
              ),
              "tarif_arrondi",
            ], // Arrondi à l'entier le plus proche
          ],
          include: [
            {
              model: PaymentCategory,
              attributes: ["prestation"],
              include: [
                {
                  model: SettingServiceSpecialite,
                  attributes: ["name_specialite"],
                },
              ],
            },
          ],
          where: { id_organisation: req.params.org_id },
        });
      if (PaymentCategoryOrganisationModal === null) {
        res.json({ status: 0, message: "Not Data Found" });
      } else {
        res.json({
          status: 1,
          message: "Payment Category Organisation List",
          data: PaymentCategoryOrganisationModal,
        });
      }
    } else if (req.params.type_id == "2") {
      PaymentCategoryOrganisationModal =
        await PaymentCategoryOrganisation.findAll({
          attributes: [
            "idpco",
            [
              Sequelize.fn(
                "ROUND",
                Sequelize.col("PaymentCategoryOrganisation.prix_public"),
                0
              ),
              "tarif_arrondi",
            ],
          ], // Sélection des attributs nécessaires du modèle principal
          include: [
            {
              model: PaymentCategory,
              attributes: ["prestation"], // Sélection des attributs nécessaires du modèle associé
              include: [
                {
                  model: SettingServiceSpecialite,
                  attributes: ["name_specialite"], // Sélection des attributs du modèle inclus de manière imbriquée
                },
              ],
            },
          ],
          where: { id_organisation: req.params.org_id },
        });
      if (PaymentCategoryOrganisationModal === null) {
        res.json({ status: 0, message: "Not Data Found" });
      } else {
        res.json({
          status: 1,
          message: "Payment Category Organisation List",
          data: PaymentCategoryOrganisationModal,
        });
      }
    } else {
      res.json({ status: 0, message: "Not Data Found" });
    }
  } catch (error) {
    throw error;
  }
};

exports.addPriceGrids = async (req, res) => {
  try {
    console.log(req.body);
    const priceGridsModel = await PriceGrids.create({
      organizationID: req.body.organizationID,
      gridName: req.body.gridName,
      description: req.body.description,
      effectiveDate: req.body.effectiveDate,
      expiryDate: req.body.expiryDate,
      lastModifiedDate: req.body.lastModifiedDate,
      lastModifiedBy: req.body.lastModifiedBy,
    });

    // Si aucun modèle n'est renvoyé, cela indique généralement une erreur non gérée.
    if (priceGridsModel === null) {
      res.json({
        status: 0,
        message: "Something went wrong, please try again later.",
      });
    } else {
      res.json({
        status: 1,
        message: "New PriceGrid has been added.",
        data: priceGridsModel,
      });
    }
  } catch (error) {
    // Intercepter spécifiquement les erreurs de violation de contrainte d'unicité
    if (error.name === "SequelizeUniqueConstraintError") {
      res.json({
        status: 0,
        message: "This grid name already exists. Please use a different name.",
      });
    } else {
      res.json({
        status: 0,
        message: "Server error, please try again later.",
        error: error.message, // Fournir plus de détails sur l'erreur
      });
    }
  }
};

exports.importPriceGridDetails = async (req, res) => {
  const form = new formidable.IncomingForm();
  form.multiples = true;
  form.parse(req, async (err, fields, files) => {
    if (err) {
      res.status(500).json({ wsMessage: "Error parsing the form data." });
      return;
    }

    // Normalisation des champs pour éviter des erreurs de type avec Sequelize
    const organizationID = Array.isArray(fields.organizationID)
      ? fields.organizationID[0]
      : fields.organizationID;
    const gridName = Array.isArray(fields.gridName)
      ? fields.gridName[0]
      : fields.gridName;
    const description = Array.isArray(fields.description)
      ? fields.description[0]
      : fields.description;
    const lastModifiedBy = Array.isArray(fields.lastModifiedBy)
      ? fields.lastModifiedBy[0]
      : fields.lastModifiedBy;
    const adjustmentType = Array.isArray(fields.adjustmentType)
      ? fields.adjustmentType[0]
      : fields.adjustmentType;
    const adjustmentValue = Array.isArray(fields.adjustmentValue)
      ? fields.adjustmentValue[0]
      : fields.adjustmentValue;

    // Création du modèle
    let priceGridsModel;
    try {
      priceGridsModel = await PriceGrids.create({
        organizationID,
        gridName,
        description,
        effectiveDate: fields.effectiveDate, // Supposons que ces dates sont correctement formatées
        expiryDate: fields.expiryDate,
        lastModifiedDate: fields.lastModifiedDate,
        adjustmentType,
        adjustmentValue,
        lastModifiedBy,
      });
    } catch (error) {
      console.error("Error creating PriceGrids model:", error);
      if (error.name === "SequelizeUniqueConstraintError") {
        res.json({
          status: 0,
          message:
            "This grid name already exists. Please use a different name.",
        });
      } else {
        res
          .status(500)
          .json({ wsMessage: "Database error, unable to create price grid." });
        return;
      }
    }

    // Traitement des fichiers, si le modèle est correctement créé
    if (
      !files.priceGrid ||
      !files.priceGrid.length ||
      !files.priceGrid[0].filepath
    ) {
      res
        .status(400)
        .json({ wsMessage: "No file uploaded or file path missing." });
      return;
    }

    const filepath = files.priceGrid[0].filepath;
    console.log("File path:", filepath);

    const result = await parseAndValidateExcelPrice(filepath);
    if (typeof result == "string") {
      res.status(400).json({ wsMessage: result });
      return;
    } else {
      console.log("Price grid details:", result);
      let gridDetails = result.map((elt) => ({
        gridID: priceGridsModel.gridID,
        productID: elt.ID,
        adjustedPrice: elt.Prix,
        effectiveDate: priceGridsModel.effectiveDate,
        expiryDate: priceGridsModel.expiryDate,
      }));
      try {
        const insertedGridDetails = await PriceGridDetails.bulkCreate(
          gridDetails
        );
        res.json({
          status: 1,
          message: "New PriceGrid Details List.",
          data: insertedGridDetails,
        });
      } catch (error) {
        console.error("Error inserting grid details:", error);
        res.status(500).json({
          status: 0,
          message: "Failed to insert price grid details.",
          error: error.toString(),
        });
      }
      // Traiter et sauvegarder les données ici
    }
  });
};

exports.getPriceGridsAll = async (req, res) => {
  try {
    PriceGridsAll = await PriceGrids.findAll({
      attributes: [
        "gridID",
        "organizationID",
        "description",
        "effectiveDate",
        "expiryDate",
        "lastModifiedDate",
        "lastModifiedBy",
        [
          Sequelize.fn(
            "DATE_FORMAT",
            Sequelize.col("effectiveDate"),
            "%d-%m-%Y %H:%i:%s"
          ),
          "effectiveDate",
        ],
        [
          Sequelize.fn(
            "DATE_FORMAT",
            Sequelize.col("lastModifiedDate"),
            "%d-%m-%Y %H:%i:%s"
          ),
          "lastModifiedDate",
        ],
      ],
      order: [["gridID", "DESC"]],
    });
    if (PriceGridsAll === null) {
      res.json({ status: 0, message: "No Data Found" });
    } else {
      res.json({
        status: 1,
        message: "Price Grid List",
        data: PriceGridsAll,
      });
    }
  } catch (error) {
    throw error;
  }
};

exports.getPriceGridByID = async (req, res) => {
  try {
    const PriceGrid = await PriceGrids.findOne({
      // Utilisation de findOne pour récupérer un seul enregistrement
      where: {
        gridID: req.params.gridID, // Condition où gridID est égal à req.params.gridID
      },
      attributes: [
        "gridID",
        "organizationID",
        "description",
        "effectiveDate",
        "expiryDate",
        "lastModifiedDate",
        "lastModifiedBy",
        [
          Sequelize.fn(
            "DATE_FORMAT",
            Sequelize.col("effectiveDate"),
            "%d-%m-%Y %H:%i:%s"
          ),
          "effectiveDate",
        ],
        [
          Sequelize.fn(
            "DATE_FORMAT",
            Sequelize.col("lastModifiedDate"),
            "%d-%m-%Y %H:%i:%s"
          ),
          "lastModifiedDate",
        ],
      ],
      order: [["gridID", "DESC"]],
    });

    if (PriceGrid === null) {
      res.json({ status: 0, message: "No Data Found" });
    } else {
      res.json({
        status: 1,
        message: "Price Grid Details",
        data: PriceGrid,
      });
    }
  } catch (error) {
    res.status(500).json({
      status: 0,
      message: "Error retrieving data",
      error: error.message,
    });
  }
};

exports.getPriceGridDetailsAll = async (req, res) => {
  try {
    PriceGridDetailsAll = await PriceGridDetails.findAll({
      attributes: [
        "detailID",
        "gridID",
        "productID",
        "adjustedPrice",
        "adjustmentType",
        "adjustmentValue",
        "effectiveDate",
        "expiryDate",
        [
          Sequelize.fn(
            "DATE_FORMAT",
            Sequelize.col("effectiveDate"),
            "%d-%m-%Y %H:%i:%s"
          ),
          "effectiveDate",
        ],
        [
          Sequelize.fn(
            "DATE_FORMAT",
            Sequelize.col("expiryDate"),
            "%d-%m-%Y %H:%i:%s"
          ),
          "expiryDate",
        ],
      ],
      order: [["detailID", "DESC"]],
    });
    if (PriceGridDetailsAll === null) {
      res.json({ status: 0, message: "No Data Found" });
    } else {
      res.json({
        status: 1,
        message: "Price Grid Details List",
        data: PriceGridDetailsAll,
      });
    }
  } catch (error) {
    throw error;
  }
};


const getOrCreatePriceGrid = async (gridName, tarifColumn, orgId, byID) => {
  const priceGrid = await PriceGrids.findOne({
    where: { gridName },
    attributes: [
      "gridID",
      "organizationID",
      "description",
      "effectiveDate",
      "expiryDate",
      "lastModifiedDate",
      "lastModifiedBy",
      [
        Sequelize.fn("DATE_FORMAT", Sequelize.col("effectiveDate"), "%d-%m-%Y %H:%i:%s"),
        "effectiveDate"
      ],
      [
        Sequelize.fn("DATE_FORMAT", Sequelize.col("lastModifiedDate"), "%d-%m-%Y %H:%i:%s"),
        "lastModifiedDate"
      ]
    ],
    order: [["gridID", "DESC"]]
  });

  if (priceGrid === null) {
    const paymentCategoryOrganisation = await PaymentCategoryOrganisation.findAll({
      attributes: [
        "idpco",
        tarifColumn,
        [Sequelize.fn("ROUND", Sequelize.col(`PaymentCategoryOrganisation.${tarifColumn}`), 0), "tarif_arrondi"]
      ],
      include: [
        {
          model: PaymentCategory,
          attributes: ["prestation"],
          include: [{ model: SettingServiceSpecialite, attributes: ["name_specialite"] }]
        }
      ],
      where: { id_organisation: orgId }
    });

    let priceGridsModel;
    try {
      priceGridsModel = await PriceGrids.create({
        organizationID: orgId,
        gridName,
        description: `Tarif ${gridName} généré automatiquement`,
        effectiveDate: moment().format("YYYY-MM-DD HH:mm:ss"),
        lastModifiedDate: moment().format("YYYY-MM-DD HH:mm:ss"),
        lastModifiedBy: byID,
        adjustmentType: "increaseAbsolute"
      });
    } catch (error) {
      console.error("Error creating PriceGrids model:", error);
      if (error.name === "SequelizeUniqueConstraintError") {
        throw new Error("This grid name already exists. Please use a different name.");
      } else {
        throw new Error("Database error, unable to create price grid.");
      }
    }

    const gridDetails = paymentCategoryOrganisation.map(elt => ({
      gridID: priceGridsModel.gridID,
      productID: elt.idpco,
      adjustedPrice: elt[tarifColumn],
      effectiveDate: moment().format("YYYY-MM-DD HH:mm:ss")
    }));

    try {
      await PriceGridDetails.bulkCreate(gridDetails);
      return {
        status: 1,
        message: `New PriceGrid Details List for ${gridName}`,
        data: gridDetails
      };
    } catch (error) {
      console.error("Error inserting grid details:", error);
      throw new Error("Failed to insert price grid details.");
    }
  } else {
    return {
      status: 1,
      message: `Price Grid ${gridName} Details`,
      data: priceGrid
    };
  }
};


exports.getPriceIpmAssurancePriceGrid = async (req, res) => {
  try {
    const orgId = req.params.org_id;
    const byID = req.params.byID;

    const assuranceResult = await getOrCreatePriceGrid("Assurance", "tarif_assurance", orgId, byID);
    const ipmResult = await getOrCreatePriceGrid("IPM", "tarif_ipm", orgId, byID);

    res.json({
      status: 1,
      message: "Price Grids Retrieved",
      data: {
        assurance: assuranceResult,
        ipm: ipmResult
      }
    });
  } catch (error) {
    res.status(500).json({
      status: 0,
      message: "Error retrieving data",
      error: error.message
    });
  }
};

