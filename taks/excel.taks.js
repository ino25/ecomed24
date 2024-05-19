const { Workbook } = require("exceljs");

async function parseAndValidateExcelPrice(filepath) {
  const workbook = new Workbook();
  await workbook.xlsx.readFile(filepath);
  console.log("Fichier Excel lu avec succès !");
  const sheet = workbook.getWorksheet(1);
  const paymentLines = [];
  const phoneMap = new Map();
  let wsMessage;
  for (let i = 2; i <= sheet.rowCount; i++) {
    const row = sheet.getRow(i);
    let [ _, ID, Specialite, Prestation, Prix ] = row.values;
    ID = ID || '';
    Specialite = Specialite || '';
    Prix = parseInt(Prix);
    Prestation = Prestation || '';
    if (!/\w{1,}/.test(ID)) wsMessage = `ID PRODUIT '${ID}' invalide, ligne ${i}`;
    if (!/\w{1,}/.test(Prix)) wsMessage = `PRIX DU PRODUIT'${Prix}' invalide, ligne ${i}`;
    // if (!/\w{2,}/.test(registreNumber)) wsMessage = `Matricule '${registreNumber}' invalide, ligne ${i}`;
    if (wsMessage) return wsMessage;
    paymentLines.push({ ID, Specialite, Prestation, Prix });
  }
  // Check duplicate phone numbers
  return paymentLines;
}

module.exports = { parseAndValidateExcelPrice };
