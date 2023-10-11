const fs = require('fs');

/*Download the base64 image in the server and returns the filename and path of image.*/
async function saveImage(org, baseImage) {
    //path of folder where you want to save the image.
    const localPath = `${process.env.NODE_PATH}/upload/` + org + `/user_pic/`;
    //Find extension of file
    const ext = baseImage.substring(baseImage.indexOf("/") + 1, baseImage.indexOf(";base64"));
    if (ext === '/') {
        return false;
    }
    const fileType = baseImage.substring("data:".length, baseImage.indexOf("/"));
    //Forming regex to extract base64 data of file.
    const regex = new RegExp(`^data:${fileType}\/${ext};base64,`, 'gi');
    //Extract base64 data.
    const base64Data = baseImage.replace(regex, "");
    const rand = Math.ceil(Math.random() * 1000);
    //Random photo name with timeStamp so it will not overide previous images.
    const filename = `profile_${Date.now()}_${rand}.${ext}`;

    //Check that if directory is present or not.
    if (!fs.existsSync(localPath)) {
        fs.mkdirSync(localPath, { recursive: true });
    }

    fs.writeFileSync(localPath + filename, base64Data, 'base64');
    return { filename, localPath };
}

// Remove Profile Image
async function removeImage(org, file) {
    fs.unlinkSync(`${process.env.NODE_PATH}/upload/${org}/user_pic/${file}`);
    return true;
}

// Read Email Template
function readEmail(url) {
    const buffer = fs.readFileSync(`${process.env.NODE_PATH}/template/${url}`);
    return buffer.toString();
}

// Find and Replace functionality
String.prototype.replaceArray = function (find, replace) {
    var replaceString = this;
    var regex;
    for (var i = 0; i < find.length; i++) {
        regex = new RegExp(find[i], "g");
        replaceString = replaceString.replace(regex, replace[i]);
    }
    return replaceString;
};

module.exports = {
    saveImage,
    removeImage,
    readEmail
};