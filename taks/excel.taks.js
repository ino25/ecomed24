const { Workbook } = require("exceljs");

async function parseAndValidateExcelPrice(filepath) {
  const workbook = new Workbook();
  await workbook.xlsx.readFile(filepath);
  console.log("Fichier Excel lu avec succès !");
  const sheet = workbook.getWorksheet(1);
  const paymentLines = [];
  let wsMessage;

  for (let i = 2; i <= sheet.rowCount; i++) {
    const row = sheet.getRow(i);
    const ID = row.getCell(1).value || '';
    const Specialite = row.getCell(2).value || '';
    const Prestation = row.getCell(3).value || '';
    const Prix = parseInt(row.getCell(4).value);

    if (!/\w{1,}/.test(ID)) {
      wsMessage = `ID PRODUIT '${ID}' invalide, ligne ${i}`;
    }
    if (isNaN(Prix) || !/\d+/.test(Prix)) {
      wsMessage = `PRIX DU PRODUIT '${Prix}' invalide, ligne ${i}`;
    }
    
    if (wsMessage) {
      return wsMessage;
    }

    paymentLines.push({ ID, Specialite, Prestation, Prix });
  }

  return paymentLines;
}


module.exports = { parseAndValidateExcelPrice };
