const axios = require("axios");
const Drug = require("../models/Drug");
const DrugInfo = require("../models/DrugInfo");
const XLSX = require("xlsx");
const multer = require("multer");

const OPENAI_API_KEY = process.env.OPENAI_API_KEY; // Ensure this is set in your environment variables

exports.getAllDrugs = async (req, res) => {
  try {
    console.log("Fetching all drugs...");
    const drugs = await Drug.findAll();
    console.log("Fetched drugs: ", drugs);
    res.json(drugs);
  } catch (error) {
    console.error("Error retrieving drugs: ", error);
    res.status(500).send("Error retrieving drugs");
  }
};

exports.getDrugById = async (req, res) => {
  try {
    console.log(`Fetching drug by ID: ${req.params.id}`);
    const drug = await Drug.findByPk(req.params.id);
    if (drug) {
      console.log("Fetched drug: ", drug);
      res.json(drug);
    } else {
      console.error("Drug not found");
      res.status(404).send("Drug not found");
    }
  } catch (error) {
    console.error("Error retrieving drug: ", error);
    res.status(500).send("Error retrieving drug");
  }
};

exports.addDrug = async (req, res) => {
  try {
    const {
      dci,
      commercialName,
      dosage,
      administrationRoute,
      presentation,
      laboratory,
      drugScope, // Include drugScope in the request body
    } = req.body;

    console.log("Adding drug: ", req.body);

    // Check for duplicates
    const existingDrug = await Drug.findOne({
      where: {
        dci,
        commercialName,
        dosage,
        administrationRoute,
        presentation,
        laboratory,
      },
    });

    if (existingDrug) {
      console.error("Drug already exists");
      return res.status(400).json({ error: "Drug already exists" });
    }

    // Ensure drugScope has a valid value
    const validDrugScopes = ["general", "IB"];
    if (!validDrugScopes.includes(drugScope)) {
      return res.status(400).json({ error: "Invalid drug scope" });
    }

    // Create the drug with the provided details
    const drug = await Drug.create({
      dci,
      commercialName,
      dosage,
      administrationRoute,
      presentation,
      laboratory,
      drugScope,
    });

    console.log("Drug added successfully: ", drug);

    // Create the drug monography after the drug is added
    await createDrugInfo(drug);

    res.json(drug);
  } catch (error) {
    console.error("Error adding drug: ", error);
    res.status(500).send("Error adding drug");
  }
};

exports.bulkUploadDrugs = async (req, res) => {
  try {
    console.log("Starting bulk upload of drugs...");
    const file = req.file; // The uploaded file from the request
    if (!file) {
      console.error("No file uploaded.");
      return res.status(400).json({ error: "No file uploaded" });
    }

    // Parse the Excel file
    console.log("Parsing uploaded Excel file...");
    const workbook = XLSX.read(file.buffer, { type: "buffer" });
    const sheetName = workbook.SheetNames[0]; // Read the first sheet
    const rows = XLSX.utils.sheet_to_json(workbook.Sheets[sheetName]);
    console.log(`Parsed ${rows.length} rows from the Excel file.`);

    const results = [];
    for (const [index, row] of rows.entries()) {
      console.log(`Processing row ${index + 1}:`, row);
      const {
        id,
        dci,
        commercialName,
        dosage,
        administrationRoute,
        presentation,
        laboratory,
        drugScope,
      } = row;

      if (id) {
        console.log(`Row ${index + 1}: Checking existing drug with ID: ${id}`);
        // Update existing drug
        const existingDrug = await Drug.findByPk(id);
        if (existingDrug) {
          console.log(`Row ${index + 1}: Found existing drug:`, existingDrug);
          // Check for changes
          const fieldsToUpdate = {};
          if (dci && existingDrug.dci !== dci) fieldsToUpdate.dci = dci;
          if (commercialName && existingDrug.commercialName !== commercialName)
            fieldsToUpdate.commercialName = commercialName;
          if (dosage && existingDrug.dosage !== dosage)
            fieldsToUpdate.dosage = dosage;
          if (
            administrationRoute &&
            existingDrug.administrationRoute !== administrationRoute
          )
            fieldsToUpdate.administrationRoute = administrationRoute;
          if (presentation && existingDrug.presentation !== presentation)
            fieldsToUpdate.presentation = presentation;
          if (laboratory && existingDrug.laboratory !== laboratory)
            fieldsToUpdate.laboratory = laboratory;

          if (Object.keys(fieldsToUpdate).length > 0) {
            console.log(`Row ${index + 1}: Updating fields:`, fieldsToUpdate);
            await existingDrug.update(fieldsToUpdate);
            results.push({
              row: row,
              status: "updated",
              message: "Existing drug updated successfully",
            });
          } else {
            console.log(`Row ${index + 1}: No changes detected for this drug.`);
            results.push({
              row: row,
              status: "unchanged",
              message: "No changes detected for existing drug",
            });
          }
        } else {
          console.error(
            `Row ${index + 1}: Drug ID ${id} not found for update.`
          );
          results.push({
            row: row,
            status: "failed",
            message: "Drug ID not found for update",
          });
        }
      } else {
        // Insert new drug
        console.log(
          `Row ${index + 1}: No ID provided, checking for duplicates...`
        );
        const duplicateDrug = await Drug.findOne({
          where: {
            dci,
            commercialName,
            dosage,
            administrationRoute,
            presentation,
            laboratory,
            drugScope,
          },
        });

        if (duplicateDrug) {
          console.warn(
            `Row ${index + 1}: Duplicate drug found, skipping insertion.`
          );
          results.push({
            row: row,
            status: "duplicate",
            message: "Duplicate drug found, skipped insertion",
          });
        } else {
          console.log(
            `Row ${index + 1}: No duplicate found, adding new drug...`
          );
          await Drug.create({
            dci,
            commercialName,
            dosage,
            administrationRoute,
            presentation,
            laboratory,
            drugScope,
          });
          results.push({
            row: row,
            status: "inserted",
            message: "New drug added successfully",
          });
        }
      }
    }

    console.log("Bulk upload completed. Results:", results);
    res.status(200).json({
      message: "Drug upload processed",
      results,
    });
  } catch (error) {
    console.error("Error processing drug upload:", error);
    res.status(500).json({ error: "Error processing drug upload" });
  }
};

exports.updateDrug = async (req, res) => {
  try {
    console.log(`Updating drug with ID: ${req.params.id}`, req.body);
    const drug = await Drug.findByPk(req.params.id);
    if (drug) {
      await drug.update(req.body);
      console.log("Drug updated successfully: ", drug);
      res.json(drug);
    } else {
      console.error("Drug not found");
      res.status(404).send("Drug not found");
    }
  } catch (error) {
    console.error("Error updating drug: ", error);
    res.status(500).send("Error updating drug");
  }
};

exports.deleteDrug = async (req, res) => {
  try {
    console.log(`Deleting drug with ID: ${req.params.id}`);
    const drug = await Drug.findByPk(req.params.id);
    if (drug) {
      await drug.destroy();
      console.log("Drug deleted successfully");
      res.send("Drug deleted");
    } else {
      console.error("Drug not found");
      res.status(404).send("Drug not found");
    }
  } catch (error) {
    console.error("Error deleting drug: ", error);
    res.status(500).send("Error deleting drug");
  }
};

exports.setDrugStatus = async (req, res) => {
  try {
    console.log(
      `Setting status of drug with ID: ${req.params.id} to ${req.body.status}`
    );
    const drug = await Drug.findByPk(req.params.id);
    if (drug) {
      await drug.update({ status: req.body.status });
      console.log("Drug status updated successfully: ", drug);
      res.json(drug);
    } else {
      console.error("Drug not found");
      res.status(404).send("Drug not found");
    }
  } catch (error) {
    console.error("Error updating drug status: ", error);
    res.status(500).send("Error updating drug status");
  }
};

async function createDrugInfo(drug) {
  try {
    const drugName = drug.dci;

    console.log("Create monography for:", drugName);

    const prompt = `
      Fournissez une monographie du médicament "${drugName}" y compris :
      1. Nom générique
      2. Classe thérapeutique
      3. Indications thérapeutiques
      4. Mécanisme d'action
      5. Posologie
      6. Effets indésirables courants
      7. Effets indésirables graves
      8. Contre-indications
      9. Interactions médicamenteuses
      10. Précautions d'emploi
      11. Sources
    Inclure des sources provenant de pays francophones (Afrique, France, Quebec). Pour tous les points fournir des informations les plus détaillées possibles`;

    const response = await axios.post(
      "https://api.openai.com/v1/chat/completions",
      {
        model: "gpt-4",
        messages: [{ role: "user", content: prompt }],
        temperature: 0.7,
      },
      {
        headers: {
          Authorization: `Bearer ${process.env.OPENAI_API_KEY}`,
          "Content-Type": "application/json",
        },
      }
    );

    const drugInfoText = response.data.choices[0].message.content;

    const extractSection = (text, section) => {
      const regex = new RegExp(`${section}\\s*:(.*?)(\\n\\d+\\. |$)`, "s");
      const match = text.match(regex);
      return match ? match[1].trim() : null;
    };

    const structuredDrugInfo = {
      nomGenerique: extractSection(drugInfoText, "1. Nom générique"),
      classeTherapeutique: extractSection(
        drugInfoText,
        "2. Classe thérapeutique"
      ),
      interactionstherapeutiques: extractSection(
        drugInfoText,
        "3. Indications thérapeutiques"
      ),
      mecanismedAction: extractSection(drugInfoText, "4. Mécanisme d'action"),
      posologie: extractSection(drugInfoText, "5. Posologie"),
      effetsIndesirablesCourants: extractSection(
        drugInfoText,
        "6. Effets indésirables courants"
      ),
      effetsIndesirablesGraves: extractSection(
        drugInfoText,
        "7. Effets indésirables graves"
      ),
      contreIndications: extractSection(drugInfoText, "8. Contre-indications"),
      interactionsMedicamenteuses: extractSection(
        drugInfoText,
        "9. Interactions médicamenteuses"
      ),
      precautionsdEmploi: extractSection(
        drugInfoText,
        "10. Précautions d'emploi"
      ),
      sources: extractSection(drugInfoText, "11. Sources"),
    };

    await DrugInfo.create({
      drugId: drug.id,
      json_info: JSON.stringify(structuredDrugInfo),
      updated_by: "system",
      updated_at: new Date(),
    });

    console.log("Drug info created successfully");
  } catch (error) {
    console.error("Error creating drug information:", error);
  }
}

exports.getDrugInfo = async (req, res) => {
  const { id } = req.params;

  try {
    // Fetch the drug to ensure it exists
    const drug = await Drug.findByPk(id);

    if (!drug) {
      return res.status(404).send({ error: "Drug not found" });
    }

    console.log("Fetching drug information for:", drug.dci);

    // Fetch the drug info from the database
    const drugInfo = await DrugInfo.findOne({ where: { drugId: id } });

    if (!drugInfo) {
      console.error("Drug information not found in the database");
      return res.status(404).send({ error: "Drug information not found" });
    }

    // Return the drug information
    res.send({
      message: "Drug information fetched successfully",
      data: JSON.parse(drugInfo.json_info),
    });
  } catch (error) {
    console.error("Error fetching drug information:", error);
    res
      .status(500)
      .send({ error: "An error occurred while fetching drug information" });
  }
};

exports.updateDrugInfo = async (req, res) => {
  const { id } = req.params;
  const { json_info, user } = req.body;

  try {
    const drugInfo = await DrugInfo.findOne({ where: { drugId: id } });

    if (!drugInfo) {
      return res.status(404).send({ error: "Drug information not found" });
    }

    await drugInfo.update({
      json_info,
      updated_by: user,
      updated_at: new Date(),
    });

    res.send({
      message: "Drug information updated successfully",
      data: drugInfo.json_info,
    });
  } catch (error) {
    console.error("Error updating drug information:", error); // Log the error
    res
      .status(500)
      .send({ error: "An error occurred while updating drug information" });
  }
};

// Request a new drug listing
exports.requestDrugListing = async (req, res) => {
  console.log("Drug model:", Drug);
  try {
    const {
      dci,
      commercialName,
      dosage = "Non Disponible",
      administrationRoute = "Non Disponible",
      presentation = "Non Disponible",
      laboratory = "Non Disponible",
      drugScope = "general",
    } = req.body;

    // Validation: Ensure at least one of dci or commercialName is provided
    if (!dci && !commercialName) {
      return res.status(400).json({
        error: "At least one of 'dci' or 'commercialName' must be provided.",
      });
    }

    // Set missing dci or commercialName to "Non Disponible" if needed
    const validatedDCI = dci || "Non Disponible";
    const validatedCommercialName = commercialName || "Non Disponible";

    console.log("Drug model:", Drug);

    // Create the new drug entry with status "requested"
    const newDrug = await Drug.create({
      dci: validatedDCI,
      commercialName: validatedCommercialName,
      dosage,
      administrationRoute,
      presentation,
      laboratory,
      status: "requested", // Set status to "requested"
      drugScope, // Default to "general" if not provided
    });

    console.log("Drug requested successfully: ", newDrug);

    // Return the created drug entry
    res.json(newDrug);
  } catch (error) {
    console.error("Error requesting drug listing: ", error);
    res.status(500).send("Error requesting drug listing");
  }
};

exports.checkAndFetchDrugInfo = async (req, res) => {
  try {
    // Fetch all drugs
    console.log("Fetching all drugs...");
    const drugs = await Drug.findAll();

    // Loop through each drug
    for (const drug of drugs) {
      // Check if drug information exists in the DrugInfo table
      const drugInfo = await DrugInfo.findOne({ where: { drugId: drug.id } });

      if (drugInfo) {
        // If drug information is available, log "info available"
        console.log(`Info available for drug: ${drug.commercialName}`);
      } else {
        // If drug information is not available, fetch and create it
        await createDrugInfo(drug);
        console.log(
          `Drug info fetched and created for: ${drug.commercialName}`
        );
      }
    }

    res.status(200).send("Drug info check and fetch completed successfully.");
  } catch (error) {
    console.error("Error checking and fetching drug info: ", error);
    res.status(500).send("Error checking and fetching drug info");
  }
};

// Reuse the createDrugInfo function from the previous code snippet for generating drug info
async function createDrugInfo(drug) {
  try {
    const drugName = drug.dci;

    console.log("Creating monography for:", drugName);

    const prompt = `
      Fournissez une monographie du médicament "${drugName}" y compris :
      1. Nom générique
      2. Classe thérapeutique
      3. Indications thérapeutiques
      4. Mécanisme d'action
      5. Posologie
      6. Effets indésirables courants
      7. Effets indésirables graves
      8. Contre-indications
      9. Interactions médicamenteuses
      10. Précautions d'emploi
      11. Sources
    Inclure des sources provenant de pays francophones (Afrique, France, Quebec). Pour tous les points fournir des informations les plus détaillées possibles`;

    const response = await axios.post(
      "https://api.openai.com/v1/chat/completions",
      {
        model: "gpt-4",
        messages: [{ role: "user", content: prompt }],
        temperature: 0.7,
      },
      {
        headers: {
          Authorization: `Bearer ${process.env.OPENAI_API_KEY}`,
          "Content-Type": "application/json",
        },
      }
    );

    const drugInfoText = response.data.choices[0].message.content;

    const extractSection = (text, section) => {
      const regex = new RegExp(`${section}\\s*:(.*?)(\\n\\d+\\. |$)`, "s");
      const match = text.match(regex);
      return match ? match[1].trim() : null;
    };

    const structuredDrugInfo = {
      nomGenerique: extractSection(drugInfoText, "1. Nom générique"),
      classeTherapeutique: extractSection(
        drugInfoText,
        "2. Classe thérapeutique"
      ),
      interactionstherapeutiques: extractSection(
        drugInfoText,
        "3. Indications thérapeutiques"
      ),
      mecanismedAction: extractSection(drugInfoText, "4. Mécanisme d'action"),
      posologie: extractSection(drugInfoText, "5. Posologie"),
      effetsIndesirablesCourants: extractSection(
        drugInfoText,
        "6. Effets indésirables courants"
      ),
      effetsIndesirablesGraves: extractSection(
        drugInfoText,
        "7. Effets indésirables graves"
      ),
      contreIndications: extractSection(drugInfoText, "8. Contre-indications"),
      interactionsMedicamenteuses: extractSection(
        drugInfoText,
        "9. Interactions médicamenteuses"
      ),
      precautionsdEmploi: extractSection(
        drugInfoText,
        "10. Précautions d'emploi"
      ),
      sources: extractSection(drugInfoText, "11. Sources"),
    };

    await DrugInfo.create({
      drugId: drug.id,
      json_info: JSON.stringify(structuredDrugInfo),
      updated_by: "system",
      updated_at: new Date(),
    });

    console.log("Drug info created successfully");
  } catch (error) {
    console.error("Error creating drug information:", error);
  }
}
