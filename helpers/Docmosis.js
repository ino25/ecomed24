const https = require("https");
const fs = require("fs");
const moment = require("moment");
moment.locale("en");
const querystring = require("querystring");
// Docmosis

async function GeneratePDF(type, id, path, data) {
  return new Promise((resolve, reject) => {
    const formData = data;
    const templateNameValue = {
      lab: "ecoMed24.dev/requests/ecomed_MasterRequestTemplateV0.7.docx",
      lab_test_request:
        "ecoMed24.dev/requests/ecomed_MasterRequestTemplateV0.7.docx",
    };
    const outputName = `${type}-${id}-${moment().unix()}.pdf`;
    const accessKey = process.env.DOCMOSIS_ACCESSKEY;

    const postData = querystring.stringify({
      accessKey: accessKey,
      templateName: templateNameValue[type],
      outputName: outputName,
      data: JSON.stringify(formData),
    });

    const options = {
      hostname: "eu.dws3.docmosis.com",
      port: 443,
      path: "/api/render",
      method: "POST",
      headers: {
        "Content-Type": "application/x-www-form-urlencoded",
        "Content-Length": Buffer.byteLength(postData),
      },
    };

    const ReqPromise = new Promise((resolve, reject) => {
      const ReqResponse = https.request(options, (resp) => {
        switch (resp.statusCode) {
          case 200:
            const pdfPath = `${path}${outputName}`;
            const file = fs.createWriteStream(pdfPath);

            // feed response into file
            resp.pipe(file);
            file.on("finish", () => {
              file.close();

              console.log(pdfPath, "created");
              // Resolve with success JSON
              const successResponse = {
                status: true,
                message: "PDF created successfully",
                pdfPath: outputName,
              };
              resolve(successResponse);
            });
            break;
          default:
            // show error response (details)
            console.log("Error response:", resp.statusCode, resp.statusMessage);
            let errorResponse = "";
            resp.on("data", (data) => {
              errorResponse += data;
            });
            resp.on("end", () => {
              console.log(errorResponse);
              // Resolve with error JSON
              const errorResponseObj = {
                status: 0,
                message: `Error: ${resp.statusCode} ${resp.statusMessage}`,
                details: errorResponse,
              };
              resolve(errorResponseObj);
            });
        }
      });

      ReqResponse.on("error", (e) => {
        console.error("Request error:", JSON.stringify(e, null, 4));
        reject(e);
      });

      // write data to request body
      ReqResponse.write(postData);
      ReqResponse.end();
    });

    ReqPromise.then((response) => {
      resolve(response);
    }).catch((error) => {
      console.error("Server Error:", error);
      reject({
        status: 0,
        message: "Unable to generate PDF at the moment.",
      });
    });
  });
}

module.exports = GeneratePDF;
