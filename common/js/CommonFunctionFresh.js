var isToastVisible = false;
//var BASE_URL = "http://192.168.2.25:5151/zuulu";
//var UNREG_URL = "http://182.74.113.132:7080/pay/pay.html";

//var BASE_URL = "http://125.63.92.172:5151/zuulu";
// var BASE_URL = "http://194.187.94.199:5053/zuulu";
// var BASE_URL = "https://zuulu.net:5051/zuulu";
var BASE_URL = "https://dev.zuulu.net:5051/zuulu";

// var UNREG_URL = "http://125.63.92.172:2525/do/guestUserPage";

var timeout = 60000;
var isAJAXAlive = false;
// var dataTable2Obj;
// var dataTable3Obj;
// version="1.0" encoding="UTF-8" ?><Request FN="LNC" fromMember="2214010000" PIN="881188" fromType="M" osType="Android" deviceToken="undefined" updateDeviceToken="false" deviceModel="SM-E7000" devicePlatform="Android" deviceVersion="4.4.2" deviceManufacturer="samsung" packageName="com.zuulu.zuulu" versionNumber="1.0.11" isVirtualDevice="false" geoLatitude="" geoLongitude="" appClientName="Samba Diallo" appType="production" deviceIP="41.83.206.199" ipLocationCode="SN" uniqueDeviceKey="1585590508687" LN="FR"
var appInfoFresh = {
        "deviceModel": "Website",
        "devicePlatform": "Web",
        "deviceVersion": "1.5",
        "deviceManufacturer": "Website",
        "packageName": "com.zuulu.zuulu",
        "versionNumber": "1.0.11",
        "isVirtualDevice": false,
        "geoLatitude": "",
        "geoLongitude": "",
        "appClientName": "Samba Diallo",
        "appType": "production",
        "deviceIP": "41.83.206.199",
        "ipLocationCode": "SN"
    }
	
var sessionTime = 60 * 1000;
var isMenuVisible = false;
var serviceImageIdArr = [];
var isPhotoActive = false;
var TimerIntervalId = null;

var uBillsRes_XML = null;
var isUBillPenReq = false;
var isWaterDemo = false;
/**
 * @Desc function used to make ajax call with any url
 * @Param url, type, dataType, success callback, error callback, timeout
 * @Return none.
 */
 
 function testScript() {
	alert("ok");
 }
function makeAJAXCallFresh(param, type, dataType, successCallback, errorCallback) {
    //printLogMessages("makeAJAXCall appInfo------>" + JSON.stringify(appInfo));
    // $("#footer_div").hide();
    //$(".header_class").hide();
    isAJAXAlive = true;
    if (param.indexOf('></Request>') != -1) {

        var requestXML = param.split('></Request>');
        var requestData = addDeviceParamsFresh(requestXML[0]);
        param = requestData + '></Request>';
        // printLogMessages("requestData->" + param);
    }

    $.ajax({
        type: type,
        cache: false,
        data: param,
        url: BASE_URL,
        dataType: dataType,
        timeout: timeout,
        beforeSend: function() {

        },
        success: function(response) {
            isAJAXAlive = false;
            // console.log("response xml-->" + (new XMLSerializer()).serializeToString(response));
            var responseObj = $.xml2json(response);
            if(responseObj.ResponseCode == "1212"){
                 //openPage("AccountOTP");
                 // $("#Payments_Loading").hide();
                 // $("#servicePage_Loading").hide()
                 // displayMultiLoginBox(responseObj.ResponseMessage);
				 alert(responseObj.ResponseMessage);

            }
            else{

              // if (localStorage.serviceFlag == "true") {
                  // $("#footer_div").show();
              // }
              if (successCallback) {
                  successCallback(response);
              }

            }
        },
        error: function(x, t, m) {
            var responseObj = $.xml2json(x);
            //printLogMessages("responseObj error-->"+JSON.stringify(responseObj));
            isAJAXAlive = false;
            // if (localStorage.serviceFlag == "true") {
                // $("#footer_div").show();
            // }
            if (t === "timeout") {
				alert("Timeout");
                // displayToastNotifications(getValidationMSGLocale("TIMEOUT_ERROR"));
            } else {
                // displayToastNotifications(getValidationMSGLocale("ZUULU_SERVICE_ERROR"));
                alert("Service Error");
            }
            if (errorCallback) {
                errorCallback(x);
            }
        }
    });
}

/**
 * @Desc function used to make ajax in background wihout interrupting user interface
 * @Param url, type, dataType, success callback, error callback, timeout
 * @Return none.
 */

function backgroundAJAXCall(param, type, dataType, successCallback, errorCallback) {
    printLogMessages("backgroundAJAXCall------>" + BASE_URL);
    if (param.indexOf('></Request>') != -1) {
        var requestXML = param.split('></Request>');
        var requestData = addDeviceParams(requestXML[0]);
        param = requestData + '></Request>';
        printLogMessages("requestData->" + param);
    }
    $.ajax({
        type: type,
        cache: false,
        data: param,
        url: BASE_URL,
        dataType: dataType,
        timeout: timeout,
        beforeSend: function() {

        },
        success: function(response) {
          console.log("response xml-->" + (new XMLSerializer()).serializeToString(response));
            if (successCallback) {
                successCallback(response);
            }
        },
        error: function(errorObj) {
            if (errorCallback) {
                errorCallback(errorObj);
            }
        }
    });
}

function thirdPartyAJAXCall(API_URL, param, type, dataType, successCallback, errorCallback) {
    console.log("API_URL--->" + API_URL);
    $.ajax({
        type: type,
        cache: false,
        data: param,
        url: API_URL,
        dataType: dataType,
        timeout: timeout,
        crossDomain: true,
        beforeSend: function() {

        },
        success: function(response) {
          if (successCallback) {
              successCallback(response);
          }
        },
        error: function(x, t, m) {

           if (t === "timeout") {
               displayToastNotifications(getValidationMSGLocale("TIMEOUT_ERROR"));
           } else {
               displayToastNotifications(getValidationMSGLocale("ZUULU_SERVICE_ERROR"));
           }

            if (errorCallback) {
                errorCallback(x);
            }
        }
    });
}

function printLogMessages(MSG_TEXT){
  console.log(MSG_TEXT);
}

//function addDeviceParams(requestXML) {
//
//    for (var item in appInfo) {
//        requestXML += ' ' + item + '="' + appInfo[item] + '"';
//    }
//
//    requestXML += ' uniqueDeviceKey="' + getCurrentTiemstap() + '"';
//    printLogMessages("requestXML -->"+requestXML);
//    return requestXML;
//}

function appendPINXML(xmlString, mpin){
   var requestXML = null;
   if (xmlString.indexOf('></Request>') != -1) {

        var xmlStringArr = xmlString.split('></Request>');
        var requestXML = xmlStringArr[0] + ' PIN="' + mpin + '"';
        requestXML = requestXML + '></Request>';
       
    }
    return requestXML;

}

function appendTransferToAmt(xmlString, amount){
   var requestXML = null;
   if (xmlString.indexOf('></Request>') != -1) {

        var xmlStringArr = xmlString.split('></Request>');
        var requestXML = xmlStringArr[0] + ' amount="' + amount + '"';
        requestXML = requestXML + '></Request>';

    }
    return requestXML;

}



function openUnregisteredPage() {
    //window.open(UNREG_URL, '_system');
    window.open(UNREG_URL, "_blank", "location=yes,hardwareback=no,zoom=no");
    //openPage("URServicePage");
}


function validateWithStoredPIN(NewPIN){
 if(localStorage.mPIN == NewPIN){
    return true;
 }
 return false;
}
/**
 * @Desc function check internet connection and display message.
 * @Param none
 * @Return boolean.
 */

function isConnectionAvailable() {
    if (navigator.connection.type == Connection.NONE) {
        navigator.notification.alert(getValidationMSGLocale("CONNECTION_ERROR"));
        return false;
    } else {
        return true;
    }
}
/**
 * @Desc function display message in alert box.
 * @Param MESSAGE
 * @Return none.
 */
function displayMessageInAlertBox(MESSAGE) {
    navigator.notification.alert(MESSAGE, function(){}, getValidationMSGLocale("ALERT_TITLE"), 'Ok');
}

/**
 * @Desc function display message as Toast notification.
 * @Param messageText
 * @Return none.
 */
function displayToastNotifications(messageText) {

//    if (isToastVisible == false) {
//        isToastVisible = true;
//        window.plugins.toast.showLongTop(messageText, function(a) {
//            printLogMessages('toast success: ' + a)
//        }, function(b) {
//            printLogMessages('toast error: ' + b)
//        })
//        setTimeout(function() {
//            isToastVisible = false;
//        }, 2500);
//    }
 navigator.notification.alert(messageText, function(){}, getValidationMSGLocale("ALERT_TITLE"), 'Ok');

}
function displayToast(messageText) {

    if (isToastVisible == false) {
        isToastVisible = true;
        window.plugins.toast.showLongTop(messageText, function(a) {
            //printLogMessages('toast success: ' + a)
        }, function(b) {
            //printLogMessages('toast error: ' + b)
        })
        setTimeout(function() {
            isToastVisible = false;
        }, 2500);
    }


}

function pageNavigation(PageID) {
    switch (PageID) {
        case "LoginPage":
            openPage("LoginPage");
            break;
        case "HomePage":
            openPage("HomePage");
            $("#footer_div").show();
            changeActiveTab("Footer_Payment");
            break;
        case "PrepaidElectricity":
            openPage("PrepaidElectricity");
            changeActiveTab("Footer_Payment");
            break;
        case "PreviewDocument":
            $("#uploadDoc").attr("src", "img/preview_image.png");
            openPage("PreviewDocument");
            break;
        case "MyAccount":
            openPage("MyAccount");
            changeActiveTab("Footer_MyAccount");
            break;
        case "CustomersPage":
            openPage("CustomersPage");
            changeActiveTab("Footer_Customer");
            break;
        case "PendingReqPage":
            displayPendingRequest();
            changeActiveTab("Footer_request");
            break;

    }
}
/**
 * @Desc function open page in DOM.
 * @Param PageID.
 * @Return none.
 */
function openPage(PageID) {
    $.mobile.pageContainer.pagecontainer("change", "#" + PageID, {
        transition: "none",
        changeHash: false
    });
}

/**
 * @Desc function set active state of selected Tab on footer.
 * @Param SName = name of the Tab which needs to set as active.
 * @Return none.
 */
function changeActiveTab(SName) {
    if (SName == "Footer_Payment") {
        $("#Footer_Payment").hide();
        $("#Footer_Payment_hover").show();
        $("#Footer_MyAccount").show();
        $("#Footer_MyAccount_hover").hide();
        if (localStorage.Subtype == "AGENTS") {
            $("#Footer_customers").show();
            $("#Footer_customers_hover").hide();
        }


        if (localStorage.Subtype == "CUSTOMERS") {
            $("#Footer_request").show();
            $("#Footer_request_hover").hide();
        }
        else{
           $("#Footer_request").hide();
           $("#Footer_request_hover").hide();
        }
        RefreshBalance();
    } else if (SName == "Footer_MyAccount") {
        $("#Footer_Payment").show();
        $("#Footer_Payment_hover").hide();
        $("#Footer_MyAccount").hide();
        $("#Footer_MyAccount_hover").show();

        if (localStorage.Subtype == "AGENTS") {
            $("#Footer_customers").show();
            $("#Footer_customers_hover").hide();
        }

        if (localStorage.Subtype == "CUSTOMERS") {
            $("#Footer_request").show();
            $("#Footer_request_hover").hide();
        }
        else{
           $("#Footer_request").hide();
           $("#Footer_request_hover").hide();
        }

    } else if (SName == "Footer_Customer") {
        $("#Footer_Payment").show();
        $("#Footer_Payment_hover").hide();
        $("#Footer_MyAccount").show();
        $("#Footer_MyAccount_hover").hide();
        if (localStorage.Subtype == "AGENTS" || localStorage.Subtype == "NFC_ADMIN") {
            $("#Footer_customers").hide();
            $("#Footer_customers_hover").show();
        }

        if (localStorage.Subtype == "CUSTOMERS") {
            $("#Footer_request").show();
            $("#Footer_request_hover").hide();
        }
        else{
           $("#Footer_request").hide();
           $("#Footer_request_hover").hide();
        }

    } else if (SName == "Footer_request") {
        $("#Footer_Payment").show();
        $("#Footer_Payment_hover").hide();
        $("#Footer_MyAccount").show();
        $("#Footer_MyAccount_hover").hide();

        if (localStorage.Subtype == "AGENTS") {
            $("#Footer_customers").show();
            $("#Footer_customers_hover").hide();
        }

        if (localStorage.Subtype == "CUSTOMERS") {
           $("#Footer_request").hide();
           $("#Footer_request_hover").show();
        }
        else{
           $("#Footer_request").hide();
           $("#Footer_request_hover").hide();
        }


    }
}

function isStringValid(str) {

    return /^[a-zA-Z0-9- ]*$/.test(str);

}
/**
 * @Desc function validates mobile number and return error message OR true.
 * @Param PhoneNumber which needs to be validate.
 * @Return String/Boolean.
 */
function PhoneNumberValidation(PhoneNumber) {
    var message = '';
    var flag = true;
    var PhoneNumber = $.trim(PhoneNumber);
    if (!PhoneNumber) {
        message = getValidationMSGLocale("MOBNO_EMPTY");
        flag = false;
        return message;
    }

    if (PhoneNumber.length < 7) {
        message = getValidationMSGLocale("MOBNO_VALID");
        flag = false;
        return message;
    }

    if ($.isNumeric(PhoneNumber) == false) {
        message = getValidationMSGLocale("MOBNO_VALID");
        flag = false;
        return message;
    }

    if (flag == true) {

        return true;
    }
}
/**
 * @Desc function validates PIN and return error message OR true.
 * @Param mPin which needs to be validate.
 * @Return String/Boolean.
 */
function PinValidation(mPin) {

    var message = '';
    var flag = true;
    var mPin = $.trim(mPin);
    if (!mPin) {
        message = getValidationMSGLocale("WP_PIN_EMPTY");
        flag = false;
        return message;

    }

    if (mPin.length < 6) {
        message = getValidationMSGLocale("WP_PIN_LENGTH");
        flag = false;
        return message;


    }
    if (mPin.length > 6) {
        message = getValidationMSGLocale("WP_PIN_LENGTH");
        flag = false;
        return message;

    }

    if ($.isNumeric(mPin) == false) {
        message = getValidationMSGLocale("WP_PIN_LENGTH");
        flag = false;
        return message;
    }

    if (flag == true) {

        return true;
    }


}

/*
 * Email validation 
 */

function validateEmail(email) {
    var email = $.trim(email);
    if (!email) {

        return false;
    } else {

        var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
        return emailReg.test(email);

    }

}

function validateCreditCard(CCN){
var creditCN = $.trim(CCN);

 if (!creditCN) {

     return false;

 } else {

     var CCNReg = /^(?:4[0-9]{12}(?:[0-9]{3})?|5[1-5][0-9]{14}|6(?:011|5[0-9][0-9])[0-9]{12}|3[47][0-9]{13}|3(?:0[0-5]|[68][0-9])[0-9]{11}|(?:2131|1800|35\d{3})\d{11})$/;
     return CCNReg.test(creditCN);

 }
}
/**
 * @Desc callback function which needs to be execute when application is paused.
 * @Param none.
 * @Return none.
 */
function onAppPause() {

 localStorage.sessionTime = (new Date()).getTime();
}

function onAppResume() {

   if (localStorage.sessionTime) {

       var timeDiff = (new Date()).getTime() - parseInt(localStorage.sessionTime);

       if (timeDiff >= sessionTime) {

              if (isPhotoActive == false && localStorage.mCustomerID != null) {
                  console.log("hey app resumed");
                  $("#infoDiv").hide();
                  localStorage.removeItem("mPIN");
                  localStorage.removeItem("GroupName");
                  localStorage.removeItem("GroupId");
                  localStorage.removeItem("MemberName");
                  localStorage.removeItem("Email");
                  localStorage.removeItem("CanSendBills");
                  localStorage.removeItem("Subtype");
                  localStorage.removeItem("AccessLevel");

                  localStorage.removeItem("showStageTranx");
                  localStorage.removeItem("isUpgradable");

                  localStorage.removeItem("isSuspendEnabled");
                  localStorage.removeItem("isNFCWriteEnabled");
                  localStorage.removeItem("canViewAllCustmers");
                  localStorage.removeItem("isLocal");
                  localStorage.removeItem("lastName");
                  localStorage.removeItem("serviceFlag");
                  //localStorage.removeItem("senelecReference");

                  $("#footer_div").hide();
                  pageNavigation("LoginPage");
                  //$(".settings-menu").hide();
                  isMenuVisible = false;
                  if (localStorage.isAlreadyLogin == "true") {
                      $("#Login_RegOpt").hide();
                      $("#Login_ActivateOpt").hide();

                  }
                  $(".overlay_prt").hide();
                  $(".pop_section").hide();
                  

              }
          }

       }

  getDeviceIP();
}

function generate16DigitRandomN() {
    return Math.floor(1000000000000000 + Math.random() * 9000000000000000);
}

function displayHomePage() {
    pageNavigation("HomePage");
    RefreshBalance();
    $(".header_class").show();
    $("#footer_div").show();
    //getGeolocationCoordinate();
}

function displayMyAccountPage() {
    pageNavigation("MyAccount");
    displayLast10Txn();

}

function displayMenu() {
    if (isMenuVisible === false) {
        $(".settings-menu").show("fast");
        isMenuVisible = true;
    } else {
        $(".settings-menu").hide("fast");
        isMenuVisible = false;
    }

}
/**
@Desc function open device camera or gallery.
@Param source camera/gallery
@Return none
*/
var PicBase64code = null;
var isCameraActive = false;
var pictureEleId = null;

function capturePhoto(source) {
    if (source == "camera")
        capturePhotoFromSource(Camera.PictureSourceType.CAMERA);
    else
        capturePhotoFromSource(Camera.PictureSourceType.PHOTOLIBRARY);

}
// open device camera or gallery
function capturePhotoFromSource(sType) {
    isPhotoActive = true;
    if (isCameraActive == false) {
        isCameraActive = true;
        navigator.camera.getPicture(capturePhotoSuccessCall, capturePhotoErrorCall, {
            sourceType: sType,
            destinationType: Camera.DestinationType.DATA_URL,
            quality: 50,
            targetWidth: window.screen.width,
            targetHeight: window.screen.height,
            correctOrientation: true,
            allowEdit: false,
            mediaType: window.Camera.MediaType.PICTURE,
            encodingType: window.Camera.EncodingType.JPEG
        });
        setTimeout(function() {
            isCameraActive = false;
        }, 3000);
    }
}
/**
@Desc function is callback and set captured picture on dom element.
@Param imageData base64code of captured image
@Return none
*/
function capturePhotoSuccessCall(imageData) {
    PicBase64code = imageData;
    if (pictureEleId) {
        var imageUrl = "data:image/jpeg;base64," + imageData;
        pictureEleId.src = imageUrl;
        $(".userprofile-pic").attr("src", imageUrl);
        uploadProfilePicOnServer();

    } else {
        var image = document.getElementById("uploadDoc");
        image.src = "data:image/jpeg;base64," + imageData;
    }
    pictureEleId = null;
    isPhotoActive = false;
}

function capturePhotoErrorCall() {
    pictureEleId = null;
    isPhotoActive = false;
    //displayToastNotifications(getValidationMSGLocale("PHOTO_CAPTURE_ERROR"));
}

function displayCashInForm() {
    if (cashin_id) {
        generateServiceForm(cashin_id);
        $("#Footer_Payment").show();
        $("#Footer_Payment_hover").hide();
        $("#Footer_MyAccount").show();
        $("#Footer_MyAccount_hover").hide();
        if (localStorage.Subtype == "AGENTS") {
            $("#Footer_customers").show();
            $("#Footer_customers_hover").hide();
        }

        $("#Footer_request").show();
        $("#Footer_request_hover").hide();
    }

}

function displayHelpPage() {
    openPage("HelpPage");
}
function openPendingReqPage(){
  pageNavigation("PendingReqPage");
  //displayPendingRequest();
}
function displayLoginPage() {
    pageNavigation("LoginPage");
}

function getRandomizer0to3() {
    var min = 0;
    var max = 1;
    return Math.floor(Math.random() * (max - min + 1)) + min;
}

function manageSubmitQCancelbtn() {
    if (localStorage.mPIN) {
        displayHomePage();
    } else {
        //displayLoginPage();
        var LoginMobNo = $("#singleQAns").attr("LoginMobNo");
        var LoginPIN = $("#singleQAns").attr("LoginPIN");
        $("#Payments_Loading").show();
        userLoginAfterSecurityQuestions(LoginMobNo, LoginPIN);

    }
}

function changePINCancelBtn() {
    var isSetPIN = $("#changePINBtn").attr("isSetPIN");
    if (isSetPIN == "true") {
        displayLoginPage();
    } else {
        displayHomePage();
    }
}
/**
@Desc function open barcode scanner and call callback
@Param none
@Return none
**/
function customerScanPay() {
    isPhotoActive = true;
    cordova.plugins.barcodeScanner.scan(
        barcodeScannerSuccess,
        barcodeScannerError
    );
}

function barcodeScannerSuccess(result) {
    if (result.cancelled) {
        displayToastNotifications(getValidationMSGLocale("SCANNER_CANCEL"));
    } else if (result.text) {
        var scannedText = result.text;

        if (scannedText) {
            var QRPlainTxt = decrypt(scannedText, ENCRYP_KEY);
            if (QRPlainTxt.indexOf("OTxnId") != -1 && QRPlainTxt.indexOf("InvoiceId") != -1) {

                var MerchantArray = QRPlainTxt.split("|");
                var MemberName = MerchantArray[0].split("=")[1];
                var MerchantID = MerchantArray[1].split("=")[1];
                var InvoiceId = MerchantArray[2].split("=")[1];
                var amount = MerchantArray[3].split("=")[1];
                var tranferTypeId = MerchantArray[4].split("=")[1];
                var timestamp = MerchantArray[5].split("=")[1];

                displayQRCodePayPage(MemberName, MerchantID, amount, InvoiceId, tranferTypeId, timestamp);
            } else {
                displayToastNotifications(getValidationMSGLocale("SCANNER_INVALID"));
            }
        } else {
            displayToastNotifications(getValidationMSGLocale("SCANNER_NOCAPTURE"));
        }
    } else {
        displayToastNotifications(getValidationMSGLocale("SCANNER_NOCAPTURE"));
    }
    isPhotoActive = false;
}

function barcodeScannerError() {
    displayToastNotifications(getValidationMSGLocale("BARCODE_SCANNER_ERROR"));
    isPhotoActive = false;
}

function displayQRCodePayPage(MemberName, MerchantID, amount, InvoiceId, tranferTypeId, timestamp) {
   wpFieldArr = [];
   //var requestXML = '<?xml version="1.0" encoding="UTF-8" ?><Request FN="WP" isLocal="' + localStorage.isLocal + '" fromCustmer="' + localStorage.mCustomerID + '" toCustmer="' + MerchantID + '" amount="' + amount + '" invoiceNo="' + InvoiceId + '" otcId="' + timestamp + '" transferTypeId="' + tranferTypeId + '" reverse="false"  addBeneficiary="false" nickName="" ttType="R"></Request>';

   //var txnFeeUrl = '<?xml version="1.0" encoding="UTF-8" ?><Request FN="GPD" isLocal="' + localStorage.isLocal + '" fromCustmer="' + localStorage.mCustomerID + '" toCustmer="' + MerchantID + '" amount="' + amount + '" invoiceNo="' + InvoiceId + '" otcId="' + timestamp + '" transferTypeId="' + tranferTypeId + '" reverse="false" addBeneficiary="false" nickName="" ttType="R"></Request>';

      var requestXML = '<?xml version="1.0" encoding="UTF-8" ?><Request FN="WP" isLocal="' + localStorage.isLocal + '" fromCustmer="' + localStorage.mCustomerID + '" toCustmer="' + MerchantID + '" amount="' + amount + '" invoiceNo="' + InvoiceId + '" otcId="' + timestamp + '" transferTypeId="' + tranferTypeId + '" reverse="false"  addBeneficiary="false" nickName="" ttType=""></Request>';

      var txnFeeUrl = '<?xml version="1.0" encoding="UTF-8" ?><Request FN="GPD" isLocal="' + localStorage.isLocal + '" fromCustmer="' + localStorage.mCustomerID + '" toCustmer="' + MerchantID + '" amount="' + amount + '" invoiceNo="' + InvoiceId + '" otcId="' + timestamp + '" transferTypeId="' + tranferTypeId + '" reverse="false" addBeneficiary="false" nickName="" ttType=""></Request>';

  $("#WP_backBtn").attr("LastPage", "HomePage");
  wpFieldArr.push({elementName: getValidationMSGLocale("BARCODE_SCAN_MEMBERNAME"), elementValue: MemberName});
  wpFieldArr.push({elementName: getValidationMSGLocale("BARCODE_SCAN_MERCHANTID"), elementValue: MerchantID});
  wpFieldArr.push({elementName: getValidationMSGLocale("BARCODE_SCAN_INVOICEID"), elementValue: InvoiceId});

  walletConfirmPage(requestXML, false, "HomePage", wpFieldArr, txnFeeUrl, "W", "WP");

}




function validateQRCodeForm() {

    var OTCPay_PIN = $.trim($("#OTCPay_PIN").val());

    if (PinValidation(OTCPay_PIN) != true) {

        displayToastNotifications(PinValidation(OTCPay_PIN));
        $("#OTCPay_PIN").focus();

    } else {

        var mCustomerID = localStorage.mCustomerID;

        var MechantInfo = $("#OTCPay_PIN").attr("PayData");
        var MechantInfoArr = MechantInfo.split("**");

        var requestXML = '<?xml version="1.0" encoding="UTF-8" ?><Request FN="WP" fromCustmer="' + mCustomerID + '" PIN="' + OTCPay_PIN + '" toCustmer="' + MechantInfoArr[0] + '" amount="' + MechantInfoArr[1] + '" invoiceNo="' + MechantInfoArr[2] + '" otcId="' + MechantInfoArr[3] + '" transferTypeId="' + MechantInfoArr[4] + '" reverse="false" fd="false"></Request>';

        printLogMessages("validateQRCodeForm requestXML-->" + requestXML);
        if (isConnectionAvailable() === true) {
            $("#Payments_Loading").show();
            makeAJAXCall(requestXML, "POST", "xml", QRPaymentSuccessCallback, QRPaymentErrorCallback);

        }
    }

    function QRPaymentSuccessCallback(ResponseXML) {
        $("#Payments_Loading").hide();
        $("#OTCPay_PIN").val("");
        var responseObj = $.xml2json(ResponseXML);
        printLogMessages("QRPaymentSuccessCallback-->" + JSON.stringify(responseObj));
        $("#OTCPay_PIN").val("");
        if (responseObj.ResponseStatus == "success") {

            var responseMsg = responseObj.ResponseMessage;
            var responseMsgArr = responseMsg.split("~");
            $("#responseMSG").text(responseMsgArr[0]);
            $.mobile.pageContainer.pagecontainer("change", "#dialogPopup", {
                transition: "none",
                changeHash: false
            });

        } else {

            displayToastNotifications(responseObj.ResponseMessage);

        }
    }

    function QRPaymentErrorCallback(error) {
        $("#OTCPay_PIN").val("");
        printLogMessages("QRPaymentErrorCallback-->" + error);
        $("#Payments_Loading").hide();

    }
}

function OTCPaymentOption() {

    $("#OTC_form").show();
    $("#QRCodePreview").hide();
    $("#QRCodeImage").html("");

    $("#OTC_Amount").val("");
    $("#OTC_InvoiceId").val("");
    $(".change-pin").css("margin-top", "120px");
    //hide NFC button
    if(device.platform != "iOS"){
        if(!NFCPaymentId){
            $("#NFCReadButton").hide();
        }
        else{
           $("#NFCReadButton").show();
        }
    }
    else{
       $("#NFCReadButton").hide();
    }

    if(!QRCodePaymentId){
        $("#QRButton").hide();
    }
    else{
       $("#QRButton").show();
    }

    if(!QRCodePaymentId && NFCPaymentId){
      if ($("#NFCReadButton").hasClass("Add_btnn")) {
          $("#NFCReadButton").removeClass("Add_btnn")
      }
      $("#NFCReadButton").addClass("button_login");
    }

     if(!NFCPaymentId && QRCodePaymentId){
          if ($("#QRButton").hasClass("Add_btn")) {
              $("#QRButton").removeClass("Add_btn")
          }
          $("#QRButton").addClass("button_login");
     }
    
    openPage("OTCPayPage");
}

function generateQRCode() {

    var OTC_Amount = $.trim($("#OTC_Amount").val());
    var OTC_InvoiceId = $.trim($("#OTC_InvoiceId").val());
    var flag = true;

    if (!OTC_Amount) {
        displayToastNotifications(getValidationMSGLocale("WP_AMOUNT"));
        flag = false;
    } else if (!(OTC_Amount > 0)) {
        displayToastNotifications(getValidationMSGLocale("WP_AMOUNT"));
        flag = false;
    } else if ($.isNumeric(OTC_Amount) == false) {
        displayToastNotifications(getValidationMSGLocale("WP_VALID_AMOUNT"));
        flag = false;
    } else if (!OTC_InvoiceId) {
        displayToastNotifications(getValidationMSGLocale("INVOICE_NUMBER"));
        flag = false;
    } else if (isStringValid(OTC_InvoiceId) == false) {
        displayToastNotifications(getValidationMSGLocale("VALID_INVOICE_NUMBER"));
        flag = false;
    } else if (OTC_InvoiceId.length < 6) {
        displayToastNotifications(getValidationMSGLocale("INVOICE_NUMBER_MIN"));
        flag = false;
    } else if (flag == true) {

        printLogMessages("OTC_CustomerID--->" + OTC_Amount);

        $("#OTC_form").hide();
        $("#QRCodePreview").show();
        $("#QRCodeImage").html("");

        var QRPlainTxt = "Member=" + localStorage.MemberName + "|MID=" + localStorage.mCustomerID + "|InvoiceId=" + OTC_InvoiceId + "|amount=" + OTC_Amount + "|tranferTypeId=" + QRCodePaymentId + "|OTxnId=" + parseInt((new Date()).getTime() / 1000);
        var QRCipherTxt = encrypt(QRPlainTxt, ENCRYP_KEY);
        $("#QRCodeImage").qrcode({
            "size": 160,
            "color": "#3a3",
            "text": QRCipherTxt
        });
        $("#countdown").text("03:00");
        startTimer(3 * 60);
    }

}

function startTimer(duration) {

    if (TimerIntervalId) {
        clearInterval(TimerIntervalId);
    }
    TimerIntervalId = null;
    var timer = duration,
        minutes, seconds;

    TimerIntervalId = setInterval(function() {
        minutes = parseInt(timer / 60, 10)
        seconds = parseInt(timer % 60, 10);

        minutes = minutes < 10 ? "0" + minutes : minutes;
        seconds = seconds < 10 ? "0" + seconds : seconds;

        $("#countdown").text(minutes + ":" + seconds);

        if (--timer < 0) {
            displayHomePage();
            if (TimerIntervalId) {
                clearInterval(TimerIntervalId);
                TimerIntervalId = null;
            }
        }
    }, 1000);
}

/**
@Desc: function call API to perform OTC/NFC transaction and display OTP screen.
@Param NFCMobNo, Name and Email
@Return none
*/
function performNFCTxn(NFCMobNo, Name) {
    printLogMessages("performNFCTxn-->" + NFCMobNo + "--" + Name);
    var OTC_Amount = $("#OTC_Amount").val();
    var OTC_InvoiceId = $("#OTC_InvoiceId").val();
    var mCustomerID = localStorage.mCustomerID;
    var mPIN = localStorage.mPIN;

    var requestXML = '<?xml version="1.0" encoding="UTF-8" ?><Request FN="WP" fromCustmer="' + mCustomerID + '" PIN="' + mPIN + '" toCustmer="' + NFCMobNo + '" amount="' + OTC_Amount + '" invoiceNo="' + OTC_InvoiceId + '" transferTypeId="' + NFCPaymentId + '" reverse="true" fd="false"></Request>';
    printLogMessages("performNFCTxn requestXML-->" + requestXML);
    if (isConnectionAvailable() === true) {
        $("#Payments_Loading").show();
        makeAJAXCall(requestXML, "POST", "xml", NFCPaymentSuccessCallback, NFCPaymentErrorCallback);

    }

    function NFCPaymentSuccessCallback(ResponseXML) {
        $("#Payments_Loading").hide();
        var responseObj = $.xml2json(ResponseXML);
        printLogMessages("NFCPaymentSuccessCallback-->" + JSON.stringify(responseObj));
        if (responseObj.ResponseStatus == "success") {

            var TransactionId = responseObj.TransactionId;
            var responseMsg = responseObj.ResponseMessage;
            var responseMsgArr = responseMsg.split("~");

            displayToastNotifications(responseMsgArr[0]);

            if (TransactionId) {
                $("#OTPSubmitBtn").attr("tranxId", responseObj.TransactionId);
            } else {
                $("#OTPSubmitBtn").attr("tranxId", "");
            }

            $("#OTPSubmitBtn").attr("toCustmer", NFCMobNo);
            $("#OTPSubmitBtn").attr("amount", OTC_Amount);
            $("#OTPSubmitBtn").attr("pageID", "HomePage");

            $.mobile.pageContainer.pagecontainer("change", "#OTPPopup", {
                transition: "none",
                changeHash: false
            });

            $("#OTC_Amount").val("");
            $("#OTC_InvoiceId").val("");
            //displayToastNotifications(responseObj.ResponseMessage);

        } else {

            displayToastNotifications(responseObj.ResponseMessage);

        }
    }

    function NFCPaymentErrorCallback() {

        $("#Payments_Loading").hide();

    }
}

function hideSettingMenu(){

  if (isMenuVisible === true) {
      $(".settings-menu").hide("fast");
      isMenuVisible = false;
  }

}

function displayPrePaidEPage(){
 //$("#UR_PEBenef").css('visibility', 'hidden');
 displayToastNotifications("Coming soon !");
 return;

}

function displayElectricityPage(){
   $("#UR_PEBenef").hide();
   $(".check-uncheck").attr("src", "img/uncheck.png");
   openPage("UR_PrepaidE");
}

function checkUncheck(Obj){
  if($(Obj).attr("src") == "img/uncheck.png"){
     $(Obj).attr("src", "img/tick.png");
      //$("#UR_PEBenef").css('visibility', 'visible');
      $("#UR_PEBenef").show();
  }
  else{
    $(Obj).attr("src", "img/uncheck.png");
     //$("#UR_PEBenef").css('visibility', 'hidden');
     $("#UR_PEBenef").hide();
  }
}

function checkUncheckSenderId(Obj){
  if($(Obj).attr("src") == "img/uncheck.png"){
     $(Obj).attr("src", "img/tick.png");

   if($("#paySubmitBtn").hasClass("ben_disabled")){
    $("#paySubmitBtn").removeClass("ben_disabled");
   }

  }
  else{

    $(Obj).attr("src", "img/uncheck.png");
    $("#paySubmitBtn").addClass("ben_disabled");

  }
}

function displayLanguagePopup(){
    try{
      $("[data-role=panel]").panel("close");
    }
    catch(error){

    }

    if(localStorage.APP_LANG == "fr"){

      $("#englishRadio img").attr("src", "img/radio_off.png");
      $("#frenchRadio img").attr("src", "img/radio_on.png");

    }
    else{

      $("#englishRadio img").attr("src", "img/radio_on.png");
      $("#frenchRadio img").attr("src", "img/radio_off.png");

    }

  $(".overlay_prt").show();
  $("#LangSelection").show();
}

function selectUnSelectEnRadio(){
 //printLogMessages($("#englishRadio img").attr("src"));
  if($("#englishRadio img").attr("src") == "img/radio_on.png"){

     //$("#englishRadio img").attr("src", "img/radio_off.png");
     //$("#frenchRadio img").attr("src", "img/radio_on.png");

  }
  else{
     $("#englishRadio img").attr("src", "img/radio_on.png");
     $("#frenchRadio img").attr("src", "img/radio_off.png");
  }
}

function selectUnSelectFrRadio(){
  //printLogMessages($("#frenchRadio img").attr("src"));
    if($("#frenchRadio img").attr("src") == "img/radio_on.png"){

       //$("#englishRadio img").attr("src", "img/radio_on.png");
       //$("#frenchRadio img").attr("src", "img/radio_off.png");

    }
    else{
       $("#englishRadio img").attr("src", "img/radio_off.png");
       $("#frenchRadio img").attr("src", "img/radio_on.png");
    }
}

function manageAppLocalize(){
      if($("#frenchRadio img").attr("src") == "img/radio_on.png"){

         localStorage.APP_LANG = "fr";
         FrenchTranslation();
         frenchFooterImage();
         RefreshBalance();
      }
      else{

         localStorage.APP_LANG = "en";
         englishTranslation();
         englishFooterImage();
         RefreshBalance();

      }
      $(".overlay_prt").hide();
      $("#LangSelection").hide();
}

function manageRegisterCheckbox(Obj){
   if($(Obj).attr("src") == "img/uncheck.png"){
       $(Obj).attr("src", "img/tick.png");
    }
    else{
      $(Obj).attr("src", "img/uncheck.png");
    }
}

function manageTypeOfBusinesDD(Obj){

  if($(Obj).val().toLowerCase() == "others"){

    $("#Regist_otherValue").show();

  }
  else{
    $("#Regist_otherValue").hide();
  }
}

function isCheckboxChecked(){

  var checkBoxObject = $(".registration-checkbox");

  for(var item=0; item<checkBoxObject.length; item++){

     if($(checkBoxObject[item]).attr("src") == "img/tick.png"){
         return true;
         break;
     }

  }

  return false;

}

function getSelectedCheckbox(){

   var checkBoxObject = $(".registration-checkbox");

   var selectedArr = [];

    for(var item=0; item<checkBoxObject.length; item++){
       if($(checkBoxObject[item]).attr("src") == "img/tick.png"){
           selectedArr.push($(checkBoxObject[item]).attr("modeName"));
       }
    }

    return selectedArr.join(",");
}

function displayStagedTxnBox(){
  $("#stagedTxnId").val("");
  $(".overlay_prt").show();
  $("#StagedTxn").show();
}

function hideStagedTxnBox(){
    $(".overlay_prt").hide();
    $("#StagedTxn").hide();
}

function isCashInExist(serviceId){
  if(cashInArr){

    if(cashInArr.indexOf(",") != -1){

        var localCashInArr = cashInArr.split(",");

        for(var item=0; item < localCashInArr.length; item++){

          if(localCashInArr[item] == serviceId){
             return true;
             break;
          }
        }
    }
    else if(serviceId == cashInArr){
      return true;
    }

  }
  return false;
}

//function displayPhoneBook(eleID){
//
//   navigator.contacts.pickContact(function(contact){
//        printLogMessages('The following contact has been selected:' + JSON.stringify(contact));
//        if((contact.displayName || contact.name.givenName) && contact.phoneNumbers){
//
//        var PhoneNumbersArr = contact.phoneNumbers;
//        var mobNumberArr = [];
//        for(var item=0; item<PhoneNumbersArr.length; item++){
//            if(PhoneNumbersArr[item].value){
//               var mobileNumber = PhoneNumbersArr[item].value.replace(/[\s()-]+/gi,"");
//                if(mobileNumber){
//                //var countryCode = null;
//                  if(mobileNumber.charAt(0) == "0"){
//                    mobileNumber = mobileNumber.substring(1);
//                  }
//                  if(mobileNumber.length > 7){
//                    mobNumberArr.push(mobileNumber);
//                  }
//
//               }
//            }
//        }
//        if(mobNumberArr.length > 0){
//           for(var item = 0; item<mobNumberArr.length; item++){
//            printLogMessages("mobNumberArr-->"+mobNumberArr[item]);
//           }
//            var contactNumber = mobNumberArr[0];
//
//               if(contactNumber.charAt(0) == "+"){
//                    printLogMessages("charAt-->"+contactNumber);
////                    try{
////                        var mobileNumberObj = parsePhone(contactNumber);
////                        var parsedNumber = mobileNumberObj.areaCode+mobileNumberObj.number;
////                        var countryCode = mobileNumberObj.countryCode;
////                        $("#"+eleID).val(countryCode + parsedNumber);
////
////                    }
////                    catch(error){
//                      $("#"+eleID).val(contactNumber.substring(1));
//                    //}
//                }
//                else{
//                   $("#"+eleID).val(contactNumber);
//                }
//
//        }
//        else{
//         displayToastNotifications("Please select a valid contact.");
//        }
//
//        }
//        else{
//         displayToastNotifications("Please select a valid contact.");
//        }
//
//        },function(err){
//           displayToastNotifications("Operation is cancelled.");
//        });
//}

function displayPhoneBook(eleID, isTrimCC){

   navigator.contacts.pickContact(function(contact){
        printLogMessages('The following contact has been selected:' + JSON.stringify(contact));
        if((contact.displayName || contact.name.givenName) && contact.phoneNumbers){

        var PhoneNumbersArr = contact.phoneNumbers;
        var mobNumberArr = [];
        for(var item=0; item<PhoneNumbersArr.length; item++){
            if(PhoneNumbersArr[item].value){
               var mobileNumber = PhoneNumbersArr[item].value.replace(/[\s()-]+/gi,"");
                if(mobileNumber){
                //var countryCode = null;
                  if(mobileNumber.charAt(0) == "0"){
                    mobileNumber = mobileNumber.replace(/^0+/, '');
                  }
                  if(mobileNumber.length > 7){
                    mobNumberArr.push(mobileNumber);
                  }

               }
            }
        }
        if(mobNumberArr.length > 0){

           if(mobNumberArr.length > 1){

                $(".overlay_prt").show();
                $("#contactPicker").show();
                $("#ContactListView").html("");
                var contactDynHtml = '';
                for(var item = 0; item<mobNumberArr.length; item++){
                        var contactNumber = mobNumberArr[item];
                        if(contactNumber.charAt(0) == "+"){
                            contactNumber = getMobileNoWithoutCC(contactNumber, isTrimCC);
                         }
                         else{
                          contactNumber = fetchMobileNoWithoutCC(contactNumber, isTrimCC);
                         }

                         //$("#ContactListView").append('<li><a href="javascript:void(0);" onclick="setContactNumber(\'' + contactNumber + '\', \'' + eleID + '\')">' + contactNumber + '</a></li>');
                         contactDynHtml += '<div class="div_border" onclick="setContactNumber(\'' + contactNumber + '\', \'' + eleID + '\')"><div class="bani_leftpenal">' + contactNumber + '<br><span class="color_light_nblue"></span></div>';
                         contactDynHtml += '<div class="clear_class"></div></div>';
                }
                $("#ContactListView").html(contactDynHtml);
           }
           else{

                var contactNumber = mobNumberArr[0];
                if(contactNumber.charAt(0) == "+"){

                       $("#"+eleID).val(getMobileNoWithoutCC(contactNumber, isTrimCC));
                 }
                 else{
                    $("#"+eleID).val(fetchMobileNoWithoutCC(contactNumber, isTrimCC));
                 }
           }

        }
        else{
         displayToastNotifications("Please select a valid contact.");
        }

        }
        else{
         displayToastNotifications("Please select a valid contact.");
        }

        },function(err){
           displayToastNotifications(getValidationMSGLocale("OPERATION_CANCELLED"));
        });
}

function setContactNumber(contactNo, elementId){

    $(".overlay_prt").hide();
    $("#contactPicker").hide();
    $("#"+elementId).val(contactNo);

}

function getMobileNoWithoutCC(contactNumber, isTrimCC){
     if(isTrimCC == "R"){
            try{
                 var mobileNumberObj = parsePhone(contactNumber);
                 var parsedNumber = mobileNumberObj.areaCode+mobileNumberObj.number;
             }
             catch(error){
               var parsedNumber = contactNumber.substring(1);
             }
     }
     else{
        var parsedNumber = contactNumber.substring(1);
     }

     return parsedNumber;
}

function fetchMobileNoWithoutCC(contactNumber, isTrimCC){
     if(isTrimCC == "R"){
            try{
                 var mobileNumberObj = parsePhone(contactNumber);
                 var parsedNumber = mobileNumberObj.areaCode+mobileNumberObj.number;
             }
             catch(error){
               var parsedNumber = contactNumber;
             }
     }
     else{
        var parsedNumber = contactNumber;
     }

     return parsedNumber;
}


function manageServiceRadioBtn(item, serviceId){

  $("#serviceRadio1 img").attr("src", "img/radio_off.png");
  $("#serviceRadio2 img").attr("src", "img/radio_off.png");
  $("#serviceRadio3 img").attr("src", "img/radio_off.png");
  blankInputFields();
  if($("#SD_BenDiv").hasClass("ben_disabled")){
  
   $("#SD_BenDiv").removeClass("ben_disabled");

  }
  if(item == 1){

    $("#serviceRadio1 img").attr("src", "img/radio_on.png");
    $("#SD_BenDiv").hide();
    $("#SD_NickName").hide();
    $("#SD_RequestTo").hide();
    $("#BenIcon").hide();
    $(".mobno_hide").hide();
    $(".phonebooklink").css("display", "none");
    $(".requestToLabel").hide();
    //$("#Self_Comment").hide();
    $(".SD_RequestTo").hide();
    getSelfStoredData(serviceId);

  }
  else if(item == 2){
    $("#serviceRadio2 img").attr("src", "img/radio_on.png");

    $("#SD_BenDiv").show();
    $("#add_ben_checkbox img").attr("src", "img/uncheck.png");
    $("#SD_NickName").hide();
    $("#SD_RequestTo").hide();
    $("#BenIcon").show();
    $(".requestToLabel").hide();
    $(".mobno_hide").show();
    $(".phonebooklink").css("display", "block");
    //$("#Self_Comment").hide();
    $(".SD_RequestTo").hide();

  }
  else if(item == 3){

    $("#serviceRadio3 img").attr("src", "img/radio_on.png");

    $("#SD_BenDiv").show();
    $("#add_ben_checkbox img").attr("src", "img/uncheck.png");
    $("#SD_NickName").hide();
    $("#SD_RequestTo").show();
    $("#BenIcon").show();
    $(".mobno_hide").show();
    $(".phonebooklink").css("display", "block");
    $(".requestToLabel").show();
    //$("#Self_Comment").show();
    $(".SD_RequestTo").show();

  }

}

function confirmPaymentCheckbox(item){

  $("#Wallet-check img").attr("src", "img/radio_off.png");
  $("#UBills-check img").attr("src", "img/radio_off.png");

  if(item == 1){
    $("#Wallet-check img").attr("src", "img/radio_on.png");
  }
  else if(item == 2){
    $("#UBills-check img").attr("src", "img/radio_on.png");
  }
}

function pendingPaymentCheckbox(item){

  $("#Wallet-pending img").attr("src", "img/radio_off.png");
  $("#UBills-pending img").attr("src", "img/radio_off.png");

  if(item == 1){
    $("#Wallet-pending img").attr("src", "img/radio_on.png");
  }
  else if(item == 2){
    $("#UBills-pending img").attr("src", "img/radio_on.png");
  }
}


function manageBPCheckBox(Obj){
  if($(Obj).attr("src") == "img/uncheck.png"){
      $(Obj).attr("src", "img/tick.png");
      $("#SD_NickName").show();
  }
  else{
     $(Obj).attr("src", "img/uncheck.png");
     $("#SD_NickName").hide();
  }
}

function blankInputFields(){
  $('input[type="tel"]').val("");
  $('input[type="text"]').val("");
  $('input[type="password"]').val("");
  $('input[type="number"]').val("");
  $('input[type="password"]').val("");
  $('select').val("0");
}

function getOperatorList(eleObject){
   //alert(countryCode+"--"+mobNo);
   var ccode = $.trim($(eleObject).val());
   if (ccode == 0) {
       displayToastNotifications("Please select Country Code.");
       $(eleObject).focus();
       return;
   }
//   if (ccode != SENEGAL_COUNTRY_CODE) {
//      displayToastNotifications(getValidationMSGLocale("RECHARGE_SENEGAL_VAL"));
//      $(eleObject).focus();
//      return;
//   }


   /*********************** get recharge list ********************************/
   if (isConnectionAvailable() === true) {

       $("#servicePage_Loading").show();
       var requestXML = '<?xml version="1.0" encoding="UTF-8" ?><Request FN="GROI" countryCode="' + ccode + '"></Request>';
       printLogMessages("requestXML-->"+requestXML);
       makeAJAXCall(requestXML, "POST", "xml", getOperatorListSuccess, getOperatorListError);

   }

       function getOperatorListSuccess(ResponseXML) {

           var responseObj = $.xml2json(ResponseXML);
           printLogMessages("getOperatorInfoSuccess-->" + JSON.stringify(responseObj));
           $("#servicePage_Loading").hide();
           var selectHTML = '';
           $("#operatorInfoDiv").html("");
           if (responseObj.ResponseStatus == "success") {
               $("#operatorInfoDiv").show();
               var ResponseMessageObj = responseObj.ResponseMessage;
               if (typeof(ResponseMessageObj.operator) != "undefined") {

                   var product_listObj = ResponseMessageObj.operator;
                   var operatoridObj = ResponseMessageObj.operatorid;
                   selectHTML += '<div class="styled-select">';
                   selectHTML += '<select name="operatorDD"  id="operatorDD" data-role="none" onchange="pullRechargeList(this);">';
                   selectHTML += '<option value="0">' + getValidationMSGLocale("WP_OPERATOR_DD") + '</option>';
                   if (product_listObj != "undefined") {

                       if(product_listObj.indexOf(",") != -1){

                         var product_listArr = product_listObj.split(",");
                         var operatorIdArr = operatoridObj.split(",");
                          for (var item = 0; item < product_listArr.length; item++) {

                            printLogMessages("operatorIdArr-->" + operatorIdArr[item]);
                            selectHTML += '<option value="' + operatorIdArr[item] + '">' + product_listArr[item] + '</option>';

                          }

                       }
                       else{
                         selectHTML += '<option value="' + operatoridObj + '">' + product_listObj + '</option>';
                       }

                   }
                   selectHTML += '</select>';
                   selectHTML += '</div>';
                   $("#operatorInfoDiv").html(selectHTML);

               }
           } else {
               displayToastNotifications(responseObj.ResponseMessage);
           }

       }

       function getOperatorListError() {
           $("#servicePage_Loading").hide();
       }

}

/* <?xml version="1.0" encoding="UTF-8" ?><Request fromCustmer="2214030000" ttType="CI" transferTypeId="1179" reverse="true" isLocal="true" amount="100" FN="WP" PIN="281972" isExternal="true" external_channel="ORABANK" status="SUCCESS" DataBlockBitmap="1110010" Transaction_Response="111111|ZUULU1607376503|XOF|100.00|CC|VISA|01" Transaction_related_information="1111101|2001759238899745|08-Dec-2020 01:28:29 AM|ENROLLED|Fully Secure|75923889974510001|017078" Transaction_Status_information="111|SUCCESS|00000|No Error." Merchant_Information="" Fraud_Block="" DCC_Block="10000|NO" Additional="" deviceModel="ZUULUBIZ" devicePlatform="ZUULUBIZ" deviceVersion="1.0.0" deviceManufacturer="ZUULUBIZ" packageName="com.zuulu.zuulu" versionNumber="1.0.11" isVirtualDevice="false" geoLatitude="" geoLongitude="" appClientName="Samba Diallo" appType="production" deviceIP="41.83.206.199" ipLocationCode="SN" reverse="false" isLocal="true" addBeneficiary="false" nickName="" uniqueDeviceKey="42325819292526" LN="FR"></Request> */

/* <?xml version="1.0" encoding="UTF-8" ?><Request fromCustmer="2214030000" ttType="CI" transferTypeId="1179" reverse="true" isLocal="true" amount="10000" FN="WP" PIN="281972" isExternal="true" deviceModel="iPhone6,2" devicePlatform="iOS" deviceVersion="12.4.9" deviceManufacturer="Apple" packageName="com.zuulu.zuulu" versionNumber="1.0.11" isVirtualDevice="false" geoLatitude="" geoLongitude="" appClientName="Samba Diallo" appType="production" deviceIP="212.95.7.237" ipLocationCode="SN" uniqueDeviceKey="1516126756746" LN="FR" external_channel="ORABANK" status="SUCCESS" DataBlockBitmap="1110010" Transaction_Response="111111|ZUULU1606901266|XOF|100000.00|CC|VISA|01" Transaction_related_information="1111101|2001907174058163|02-Dec-2020 01:28:19 PM|ENROLLED|Fully Secure|90717405816310001|013898" Transaction_Status_information="111|SUCCESS|00000|No Error." Merchant_Information="" Fraud_Block="" DCC_Block="10000|NO" Additional="" addBeneficiary="false" nickName="" ></Request> */

function depotCBToZuuluPay(partnerId, partnerPIN, ttType, transferTypeId, reverse, isLocal, amount, FN, isExternal, external_channel, status, DataBlockBitmap, Transaction_Response, Transaction_related_information, Transaction_Status_information, Merchant_Information, Fraud_Block, DCC_Block, Additional) {
	
	// if(typeof(dataTable2Obj) != "undefined") { dataTable2Obj.destroy();}
	// var reponse = "";
	// var montantTotalDons = parseFloat(0);
	var requestXML = '<?xml version="1.0" encoding="UTF-8" ?><Request fromCustmer="'+partnerId+'" ttType="'+ttType+'" transferTypeId="'+transferTypeId+'" reverse="'+reverse+'" isLocal="'+isLocal+'" amount="'+amount+'" FN="'+FN+'" PIN="'+partnerPIN+'" isExternal="'+isExternal+'" external_channel="'+external_channel+'" status="'+status+'" DataBlockBitmap="'+DataBlockBitmap+'" Transaction_Response="'+Transaction_Response+'" Transaction_related_information="'+Transaction_related_information+'" Transaction_Status_information="'+Transaction_Status_information+'" Merchant_Information="'+Merchant_Information+'" Fraud_Block="'+Fraud_Block+'" DCC_Block="'+DCC_Block+'" Additional="'+Additional+'"></Request>';
	// alert("requestXML Before: " + requestXML);
	makeAJAXCallFresh(requestXML, "POST", "xml", depotCBToZuuluPaySuccess, depotCBToZuuluPayError);

      function depotCBToZuuluPaySuccess(ResponseXML) {

          // $("#servicePage_Loading").hide();
          var responseObj = $.xml2json(ResponseXML);
          printLogMessages("depotCBToZuuluPay AJAX SUCCESS-->" + JSON.stringify(responseObj));
		// <?xml version="1.0" encoding="utf-8"?><Response type="service-response"><ResponseCode>00</ResponseCode><ResponseStatus>success</ResponseStatus><ResponseMessage>La transaction de 10000.0 FCFA a bien été effectuée le 07/12/2020 à 11:07:47 ID de transaction : 221-0018675-01 ~ 18675 ~ WP</ResponseMessage><TransactionId>221-0018675-01</TransactionId></Response>	
          if (responseObj.ResponseStatus == "success") {
			 
			 
				// alert("Debut process Success");
                var ResponseMessageObj = responseObj.ResponseMessage;
                var TransactionIdObj = responseObj.TransactionId;
				
				// if(ResponseMessageObj.hasOwnProperty("Dons")){
				
				// var donsObj = ResponseMessageObj.Dons;
					// if(donsObj.hasOwnProperty("Don")) {
						// var listeDons = donsObj.Don;
						// listeDonsStringified = JSON.stringify(donsObj.Don);

						// for (var i = 0; i < listeDons.length; i++){
							// listeDonsHTML += "<tr>";
							// var obj = listeDons[i];
							
							// var numeroPortablePrefixLength = ((obj['numeroPortable']).slice(0, -4)).length;
							// var numeroPortablePrefix = "";
							// for(j = 0;j<numeroPortablePrefixLength;j++) {
								// numeroPortablePrefix += "*";
							// }
							// listeDonsHTML += "<td>"+ numeroPortablePrefix + (obj['numeroPortable']).substr((obj['numeroPortable'].length) - 4)+"</td>";
							// montantTotalDons += parseFloat(obj["montant"]);
							// listeDonsHTML += "<td>"+accounting.formatNumber(parseFloat(obj['montant']).toFixed(0), 0, ".")+" <span style='font-size:10px;'>FCFA</span></td>";
							
							// listeDonsHTML += "<td>"+obj['date']+"</td>";
							
							// listeDonsHTML += "<td>"+(obj['indicatifEtPays'].split("~"))[0]+"</td>";
							// listeDonsHTML += "</tr>";
						// }
					// }
				// } 
				// $("#listeDons").html(listeDonsHTML);
				// $("#successP").html(JSON.stringify(ResponseMessageObj));
				// var solde = balancePartner(partnerId, partnerPIN);
				// alert("solde: "+solde);
				
					// alert("00: " + $("#successP").html());
				$("#successP").html("Votre dépôt par carte bancaire de "+amount.replace(/\B(?=(\d{3})+(?!\d))/g, ".")+" FCFA vers votre Compte Principal a bien effectué. ID de transaction : "+TransactionIdObj);
				balancePartner(partnerId, partnerPIN);
				
				// $("#successWrapper").show();
					// alert("0: " + $("#successP").html());
				// $("#successP").html("Votre dépôt par carte bancaire de "+amount.replace(/\B(?=(\d{3})+(?!\d))/g, ".")+" FCFA vers votre Compte Principal a bien effectué.<br/>ID de transaction : "+TransactionIdObj);
				// $("#successWrapper").show();
				// return "OK";
          } else {
			  // alert("Debut Process AJAX");
			  // return "KO";
				// $("#depot").hide();
				$("#successP").html("Votre dépôt par carte bancaire n'a pas pu être effectué.");
				$( "#successCBTrigger" ).trigger( "click" );
				// $("#successWrapper").show();
				// $("#successCB").show();
		  }
      }

      function depotCBToZuuluPayError() {
          printLogMessages("depotCBToZuuluPay AJAX ERROR-->" + JSON.stringify(responseObj));
				// $("#depot").hide();
				$("#successP").html("Votre dépôt par carte bancaire n'a pas pu être effectué.");
				$( "#successCBTrigger" ).trigger( "click" );
				// $("#successWrapper").show();
				// $("#successCB").show();
		  // alert("Erreur inattendue");
      }
}

function balancePartner(partnerID, partnerPIN) {

    var requestXML = '<?xml version="1.0" encoding="UTF-8" ?><Request  FN="BALP" fromPartnerId="' + partnerID + '" fromCustmer="' + partnerID + '" PIN="' + partnerPIN + '"></Request>';

    makeAJAXCallFresh(requestXML, "POST", "xml", balancePartnerSuccess, balancePartnerError);

    function balancePartnerSuccess(ResponseXML) {
        // $("#servicePage_Loading").hide();
        var responseObj = $.xml2json(ResponseXML);        

        if (responseObj.ResponseStatus == "success") {
            var ResponseMessageObj = responseObj.ResponseMessage;
            //  var res = JSON.stringify(ResponseMessageObj);
            //  alert(res);
			// <?xml version="1.0" encoding="utf-8"?><Response type="service-response"><ResponseCode>00</ResponseCode><ResponseStatus>success</ResponseStatus><ResponseMessage>||Compte Services Partenaire:205.337  FCFA | Compte Payroll Partenaire:5.938.479  FCFA | Compte Encaissements Partenaire:81.700  FCFA  ||</ResponseMessage></Response>
			var allBal = ResponseMessageObj.split(" | ");
			var soldeServices;
			for(var i = 0;i<allBal.length;i++) {
				// alert(allBal[i]); 
				// ||Compte Services Partenaire:219.337  FCFA
				if(allBal[i].indexOf("Services") != -1) {
					var buff0 = allBal[i].split(":");
					// alert(buff0[1]);
					// 219.337  FCFA
					var buff1 = buff0[1].split(" ");
					var buff2 = buff1[0];
					// alert(buff1[0]);
					// "219.337"
					soldeServices = buff2;
					// return soldeServices;
					// alert("1: " + $("#successP").html());
					// $("#depot").hide();
					$("#successP").html($("#successP").html()+".<br/>Votre nouveau solde est de "+soldeServices+" FCFA.");
					$( "#successCBTrigger" ).trigger( "click" );
					// alert("2: " + $("#successP").html());
					// $("#successWrapper").show();
					// $("#successCB").show();
					break;
				}
			}
        } else {
			return "";
            // var ResponseMessageObj = responseObj.ResponseMessage;
            // error.style['display'] = 'block';
            // document.querySelector('#error').innerHTML = ResponseMessageObj;
            // alert(JSON.stringify(ResponseMessageObj,null,4));alert('nnnnnnok');
        }



    }

    function balancePartnerError() {
		return "";
        // alert("Erreur inattendue");

    }
}

function loadDons(lang){
	
	if(typeof(dataTable2Obj) != "undefined") { dataTable2Obj.destroy();}
	var listeDonsHTML = "";
	var montantTotalDons = parseFloat(0);
			var requestXML = '<?xml version="1.0" encoding="UTF-8" ?><Request FN="FDONSCVD19" fromCustmer="221766459226" PIN="040186" startIndex="1" offset="1000" ></Request>';
			makeAJAXCall(requestXML, "POST", "xml", loadDonsSuccess, loadDonsError);

      function loadDonsSuccess(ResponseXML) {

          // $("#servicePage_Loading").hide();
          var responseObj = $.xml2json(ResponseXML);
          // printLogMessages("getAmountForCotisationSuccess-->" + JSON.stringify(responseObj));
			
          if (responseObj.ResponseStatus == "success") {
			  
			  
                var ResponseMessageObj = responseObj.ResponseMessage;
				
				if(ResponseMessageObj.hasOwnProperty("Dons")){
				
				var donsObj = ResponseMessageObj.Dons;
					if(donsObj.hasOwnProperty("Don")) {
						var listeDons = donsObj.Don;
						listeDonsStringified = JSON.stringify(donsObj.Don);

						for (var i = 0; i < listeDons.length; i++){
							// alert(i);
							listeDonsHTML += "<tr>";
							var obj = listeDons[i];
							
							// Traitement + affichage Nro Portable
							var numeroPortablePrefixLength = ((obj['numeroPortable']).slice(0, -4)).length;
							var numeroPortablePrefix = "";
							for(j = 0;j<numeroPortablePrefixLength;j++) {
								numeroPortablePrefix += "*";
							}
							listeDonsHTML += "<td>"+ numeroPortablePrefix + (obj['numeroPortable']).substr((obj['numeroPortable'].length) - 4)+"</td>";
							
							// Somme montant pour affichage Total + affichage montant individuel
							montantTotalDons += parseFloat(obj["montant"]);
							listeDonsHTML += "<td>"+accounting.formatNumber(parseFloat(obj['montant']).toFixed(0), 0, ".")+" <span style='font-size:10px;'>FCFA</span></td>";
							
							listeDonsHTML += "<td>"+obj['date']+"</td>";
							
							listeDonsHTML += "<td>"+(obj['indicatifEtPays'].split("~"))[0]+"</td>";
							// {"numeroPortable":"221766459226","montant":"1000.000000","date":"27/03/2020","indicatifEtPays":"Sénégal~221"}
							
							// for (var key in obj){
								// var attrName = key;
								// var attrValue = obj[key];
							// }
							listeDonsHTML += "</tr>";
						}
					}
				} 
				
				$("#listeDons").html(listeDonsHTML);
				// $("#montantTotalDons").text(accounting.formatNumber(parseFloat(montantTotalDons).toFixed(0), 0, "."));
				// Initialisation DataTable
				
				
				$.fn.dataTable.moment('DD/MM/YYYY');
				if(lang == "fr") {
					dataTable2Obj = $('#dataTable2').DataTable({
							"order": [[ 2, "desc" ]],
							"responsive": true,
							"language": {
								"search": "Recherche:",
								"lengthMenu": "Afficher _MENU_ résultats par page",
								"zeroRecords": "Aucun résultat",
								"info": "Page _PAGE_ sur _PAGES_",
								"infoEmpty": "Aucune entrée pour le moment",
								"infoFiltered": "(Trié sur un total de _MAX_ résultats)",
								"paginate": {
								  "first": "Première page",
								  "last": "Dernière page",
								  "previous": "Prec.",
								  "next": "Suiv."
								}
							}
						});
				} else {
				
					dataTable2Obj = $('#dataTable2').DataTable({
							"order": [[ 2, "desc" ]],
							"responsive": true
						});
				}
				$("#listeDonsLastUpdate").text(NOWUTC());
						
          }
      }

      function loadDonsError() {
		  alert("Erreur inattendue");
      }
}

function loadFichiers(lang){
	
	
	if(typeof(dataTable3Obj) != "undefined") { dataTable3Obj.destroy();}
	
	var listeFichiersHTML = "";
	var montantTotalDons = parseFloat(0);
			var requestXML = '<?xml version="1.0" encoding="UTF-8" ?><Request FN="FFICHIERSCVD19" fromCustmer="221766459226" PIN="040186" ></Request>';
			makeAJAXCall(requestXML, "POST", "xml", loadFichiersSuccess, loadFichiersError);

      function loadFichiersSuccess(ResponseXML) {

          // $("#servicePage_Loading").hide();
          var responseObj = $.xml2json(ResponseXML);
          // printLogMessages("getAmountForCotisationSuccess-->" + JSON.stringify(responseObj));
			
          if (responseObj.ResponseStatus == "success") {
			  
			  
                var ResponseMessageObj = responseObj.ResponseMessage;
				
				if(ResponseMessageObj.hasOwnProperty("Fichiers")){
				
				var fichiersObj = ResponseMessageObj.Fichiers;
					if(fichiersObj.hasOwnProperty("Fichier")) {
						var listeFichiers = fichiersObj.Fichier;
						listeFichiersStringified = JSON.stringify(fichiersObj.Fichier);

						for (var i = 0; i < listeFichiers.length; i++){
							// alert(i);
							// <Fichier nomFichier="bordereau-senMedic-22-pour-fact-432020.pdf" dateHeureFichier="05/04/2020 15:47:33"/>
							listeFichiersHTML += "<tr>";
							var obj = listeFichiers[i];
							
							// Nom fichir
							var nomFichier = obj['nomFichier'];
							listeFichiersHTML += "<td style='text-align:left !important;'>";
							listeFichiersHTML += "<a href='http://194.187.94.199/CVD19/"+nomFichier+"' target='_blank'>";
							listeFichiersHTML += nomFichier;
							listeFichiersHTML += "</a>";
							listeFichiersHTML += "</td>";
							
							// Date Fichiers
							listeFichiersHTML += "<td>"+obj['dateHeureFichier']+"</td>";
							
							listeFichiersHTML += "<td>";
							listeFichiersHTML += "<a href='http://194.187.94.199/CVD19/"+nomFichier+"' target='_blank'>";
							if(lang == "fr") {listeFichiersHTML += "<i class='fa fa-eye icon-large'></i>&nbsp;Voir le fichier";}
							else {listeFichiersHTML += "<i class='fa fa-eye icon-large'></i>&nbsp;View file";}
							listeFichiersHTML += "</a>";
							listeFichiersHTML += "</td>";
							
							listeFichiersHTML += "</tr>";
						}
					}
				} 
				
				$("#listeFichiers").html(listeFichiersHTML);
				// Initialisation DataTable
				
				$.fn.dataTable.moment('DD/MM/YYYY HH:mm:ss');
				if(lang == "fr") {
					dataTable3Obj = $('#dataTable3').DataTable({
							"order": [[ 1, "desc" ]],
								"responsive": true,
								"language": {
									"search": "Recherche:",
									"lengthMenu": "Afficher _MENU_ résultats par page",
									"zeroRecords": "Aucun résultat",
									"info": "Page _PAGE_ sur _PAGES_",
									"infoEmpty": "Aucune entrée pour le moment",
									"infoFiltered": "(Trié sur un total de _MAX_ résultats)",
									"paginate": {
									  "first": "Première page",
									  "last": "Dernière page",
									  "previous": "Prec.",
									  "next": "Suiv."
									}
								}
							});
				} else {
					dataTable3Obj = $('#dataTable3').DataTable({
							"order": [[ 1, "desc" ]],
								"responsive": true
							});
				}
				// $("#listeDonsLastUpdate").text(NOWUTC());
						
          }
      }

      function loadFichiersError() {
		  alert("Erreur inattendue");
      }
}

function NOWUTC() {

    var date = new Date();
    var aaaa = date.getUTCFullYear();
    var gg = date.getUTCDate();
    var mm = (date.getUTCMonth() + 1);

    if (gg < 10)
        gg = "0" + gg;

    if (mm < 10)
        mm = "0" + mm;

    var cur_day = gg + "/" + mm + "/" + aaaa;

    var hours = date.getUTCHours()
    var minutes = date.getUTCMinutes()
    var seconds = date.getUTCSeconds();

    if (hours < 10)
        hours = "0" + hours;

    if (minutes < 10)
        minutes = "0" + minutes;

    if (seconds < 10)
        seconds = "0" + seconds;

    return cur_day + " " + hours + ":" + minutes + ":" + seconds;

}

function loadConversions(Obj){

var XOFAmount = $(Obj).val().trim();
  if(XOFAmount != ""){

      if (isConnectionAvailable() === true) {

          // $("#servicePage_Loading").show();
          // var requestXML = '<?xml version="1.0" encoding="UTF-8" ?><Request FN="RCA" fromCustmer="' + localStorage.mCustomerID + '" PIN="' + localStorage.mPIN + '" transactionId="' + transactionId + '"></Request>';
          // makeAJAXCall(requestXML, "POST", "xml", getTxnIdAmountSuccess, getTxnIdAmountError);
			var requestXML = '<?xml version="1.0" encoding="UTF-8" ?><Request FN="GCONVCVD19" fromCustmer="' + localStorage.mCustomerID + '" PIN="' + localStorage.mPIN + '" XOFAmount="'+XOFAmount+'"></Request>';
			makeAJAXCall(requestXML, "POST", "xml", loadConversionsSuccess, loadConversionsError);

      }

      function loadConversionsSuccess(ResponseXML) {

          // $("#servicePage_Loading").hide();
          var responseObj = $.xml2json(ResponseXML);
          printLogMessages("getAmountForCotisationSuccess-->" + JSON.stringify(responseObj));

          if (responseObj.ResponseStatus == "success") {

                var ResponseMessageObj = responseObj.ResponseMessage;
                if(ResponseMessageObj.hasOwnProperty("EURRate")){
					$("#COVID19_amount_EUR").text(parseFloat(parseFloat(XOFAmount) * parseFloat(ResponseMessageObj.EURRate)).toFixed(2));
                }
                if(ResponseMessageObj.hasOwnProperty("USDRate")){
					$("#COVID19_amount_USD").text(parseFloat(parseFloat(XOFAmount) * parseFloat(ResponseMessageObj.USDRate)).toFixed(2));
                }
                if(ResponseMessageObj.hasOwnProperty("CADRate")){
					$("#COVID19_amount_CAD").text(parseFloat(parseFloat(XOFAmount) * parseFloat(ResponseMessageObj.CADRate)).toFixed(2));
                }
                if(ResponseMessageObj.hasOwnProperty("SEKRate")){
					$("#COVID19_amount_SEK").text(parseFloat(parseFloat(XOFAmount) * parseFloat(ResponseMessageObj.SEKRate)).toFixed(2));
                }
          }
          // else{
			// TBD

          // }
      }

      function loadConversionsError() {
          // $("#field" + "_" + ID + "_transactionId").val("");
		  alert("Erreur inattendue");
		  
			$("#COVID19_amount_USD").text(0);
			$("#COVID19_amount_CAD").text(0);
			$("#COVID19_amount_SEK").text(0);
          // $("#servicePage_Loading").hide();
      }
  }
}

function getAmountForCotisation(partnerFdNumber, eleObject){
   //alert(countryCode+"--"+mobNo);
   var ccode = $.trim($(eleObject).val());
   // if (ccode == 0) {
       // displayToastNotifications("Please select Country Code.");
       // $(eleObject).focus();
       // return;
   // }
      $("#payment_amount").val("");
      //$("#payment_amount").prop("disabled", true);

      if (isConnectionAvailable() === true) {

          $("#servicePage_Loading").show();
          // var requestXML = '<?xml version="1.0" encoding="UTF-8" ?><Request FN="RCA" fromCustmer="' + localStorage.mCustomerID + '" PIN="' + localStorage.mPIN + '" transactionId="' + transactionId + '"></Request>';
          // makeAJAXCall(requestXML, "POST", "xml", getTxnIdAmountSuccess, getTxnIdAmountError);
			var requestXML = '<?xml version="1.0" encoding="UTF-8" ?><Request FN="GAFCOT" fromCustmer="' + localStorage.mCustomerID + '" PIN="' + localStorage.mPIN + '"  partnerFdNumber="' + partnerFdNumber + '" nbMoisCotisation="' + ccode + '"></Request>';
			makeAJAXCall(requestXML, "POST", "xml", getAmountForCotisationSuccess, getAmountForCotisationError);

      }

      function getAmountForCotisationSuccess(ResponseXML) {

          $("#servicePage_Loading").hide();
          var responseObj = $.xml2json(ResponseXML);
          printLogMessages("getAmountForCotisationSuccess-->" + JSON.stringify(responseObj));

          if (responseObj.ResponseStatus == "success") {

                var ResponseMessageObj = responseObj.ResponseMessage;
                if(ResponseMessageObj.hasOwnProperty("finalAmount")){
                   //$("#payment_amount").prop("disabled", true);
                   $("#payment_amount").val(ResponseMessageObj.finalAmount);
                }



          }
          // else{
			// TBD

          // }
      }

      function getAmountForCotisationError() {
          // $("#field" + "_" + ID + "_transactionId").val("");
		  alert("Erreur inattendue");
          $("#servicePage_Loading").hide();
      }

}

function getMensualiteForCotisation(partnerFdNumber){
   //alert(countryCode+"--"+mobNo);
      $("#montantMensuelForCotisation_"+partnerFdNumber).text("");

      if (isConnectionAvailable() === true) {

          $("#servicePage_Loading").show();
			var requestXML = '<?xml version="1.0" encoding="UTF-8" ?><Request FN="GMENSCOT" fromCustmer="' + localStorage.mCustomerID + '" PIN="' + localStorage.mPIN + '"  partnerFdNumber="' + partnerFdNumber + '" ></Request>';
			makeAJAXCall(requestXML, "POST", "xml", getMensualiteForCotisationSuccess, getMensualiteForCotisationError);

      }

      function getMensualiteForCotisationSuccess(ResponseXML) {

          $("#servicePage_Loading").hide();
          var responseObj = $.xml2json(ResponseXML);
          printLogMessages("getMensualiteForCotisationSuccess-->" + JSON.stringify(responseObj));

          if (responseObj.ResponseStatus == "success") {

                var ResponseMessageObj = responseObj.ResponseMessage;
                if(ResponseMessageObj.hasOwnProperty("mensualite")){
                   //$("#payment_amount").prop("disabled", true);
                   $("#montantMensuelForCotisation_"+partnerFdNumber).text(ResponseMessageObj.mensualite);
                }



          }
          // else{
			// TBD

          // }
      }

      function getMensualiteForCotisationError() {
          // $("#field" + "_" + ID + "_transactionId").val("");
		  alert("Erreur inattendue");
          $("#servicePage_Loading").hide();
      }

}

function getLabelCVID19(){
   //alert(countryCode+"--"+mobNo);
      $("#label_CVID19").html("");

      if (isConnectionAvailable() === true) {

          $("#servicePage_Loading").show();
			var requestXML = '<?xml version="1.0" encoding="UTF-8" ?><Request FN="GLBLCVD19" fromCustmer="' + localStorage.mCustomerID + '" PIN="' + localStorage.mPIN + '"  ></Request>';
			makeAJAXCall(requestXML, "POST", "xml", getLabelCVID19Success, getLabelCVID19nError);

      }

      function getLabelCVID19Success(ResponseXML) {

          $("#servicePage_Loading").hide();
          var responseObj = $.xml2json(ResponseXML);
          printLogMessages("getLabelCVID19Success-->" + JSON.stringify(responseObj));

          if (responseObj.ResponseStatus == "success") {

                var ResponseMessageObj = responseObj.ResponseMessage;
                if(ResponseMessageObj.hasOwnProperty("label_CVID19")){
                   //$("#payment_amount").prop("disabled", true);
                   $("#label_CVID19").html(ResponseMessageObj.label_CVID19);
                }
          }
          // else{
			// TBD

          // }
      }

      function getLabelCVID19nError() {
          // $("#field" + "_" + ID + "_transactionId").val("");
		  alert("Erreur inattendue");
          $("#servicePage_Loading").hide();
      }

}
function getURLCVID19(){
   //alert(countryCode+"--"+mobNo);
      $("#URL_CVID19").attr("onclick", "");

      if (isConnectionAvailable() === true) {

          $("#servicePage_Loading").show();
			var requestXML = '<?xml version="1.0" encoding="UTF-8" ?><Request FN="GURLCVD19" fromCustmer="' + localStorage.mCustomerID + '" PIN="' + localStorage.mPIN + '"  ></Request>';
			makeAJAXCall(requestXML, "POST", "xml", getURLCVID19Success, getURLCVID19nError);

      }

      function getURLCVID19Success(ResponseXML) {

          $("#servicePage_Loading").hide();
          var responseObj = $.xml2json(ResponseXML);
          printLogMessages("getURLCVID19Success-->" + JSON.stringify(responseObj));

          if (responseObj.ResponseStatus == "success") {

                var ResponseMessageObj = responseObj.ResponseMessage;
                if(ResponseMessageObj.hasOwnProperty("URL_CVID19")){
                   //$("#payment_amount").prop("disabled", true);
                   $("#URL_CVID19").attr("onclick", "window.open('"+ResponseMessageObj.URL_CVID19+"','_blank', 'location=yes,hardwareback=no,zoom=no');");
				   // return ResponseMessageObj.URL_CVID19
                }
          }
          // else{
			// TBD

          // }
      }

      function getURLCVID19nError() {
          // $("#field" + "_" + ID + "_transactionId").val("");
		  alert("Erreur inattendue");
          $("#servicePage_Loading").hide();
      }

}

function pullRechargeList(eleObject){
   //alert(countryCode+"--"+mobNo);
   var operatorId = $.trim($(eleObject).val());
   //FN=GPI&operatorId=1313
   //var MobileNo = $.trim($("#"+mobNo).val());
   if (operatorId == 0) {
       displayToastNotifications(getValidationMSGLocale("RECHARGE_OPERATOR_SELECT"));
       $(eleObject).focus();
       return;
   }


   /*********************** get recharge list ********************************/
   if (isConnectionAvailable() === true) {

       $("#servicePage_Loading").show();
       var requestXML = '<?xml version="1.0" encoding="UTF-8" ?><Request FN="GPI" operatorId="' + operatorId + '"></Request>';
       makeAJAXCall(requestXML, "POST", "xml", pullRechargeListSuccess, pullRechargeListError);

   }

       function pullRechargeListSuccess(ResponseXML) {

           var responseObj = $.xml2json(ResponseXML);
           printLogMessages("pullRechargeListSuccess-->" + JSON.stringify(responseObj));
           $("#servicePage_Loading").hide();
           var selectHTML = '';
           $("#rechargeInfoDiv").html("");
           if (responseObj.ResponseStatus == "success") {
               $("#rechargeInfoDiv").show();
               var ResponseMessageObj = responseObj.ResponseMessage;
               if (typeof(ResponseMessageObj.product_list) != "undefined") {

                   var product_listObj = ResponseMessageObj.product_list;
                   var retail_priceObj = ResponseMessageObj.retail_price_list;
                   if(ResponseMessageObj.destination_currency){
                     var destination_currency = ResponseMessageObj.destination_currency;
                   }
                   else{
                     var destination_currency = "";
                   }

                   selectHTML += '<div class="styled-select">';
                   selectHTML += '<select name="payment_amount" currency ="' + destination_currency + '" id="payment_amount" data-role="none" onchange="displayRechargeAmount(this);">';
                   selectHTML += '<option value="0">' + getValidationMSGLocale("WP_OPERATOR_AMOUNT") + '</option>';
                   if (product_listObj != "undefined") {

                       if(product_listObj.indexOf(",") != -1){

                         var product_listArr = product_listObj.split(",");
                         var retail_priceArr = retail_priceObj.split(",");

                          for (var item = 0; item < product_listArr.length; item++) {
                            //printLogMessages("product_listArr-->" + product_listArr[item]);
                            selectHTML += '<option value="' + product_listArr[item] + '">' + retail_priceArr[item] + '</option>';

                          }

                       }
                       else{
                         selectHTML += '<option value="' + product_listObj + '">' + retail_priceObj + '</option>';
                       }

                   }
                   selectHTML += '</select>';
                   selectHTML += '</div>';
                   $("#rechargeInfoDiv").html(selectHTML);

               }
           } else {
               displayToastNotifications(responseObj.ResponseMessage);
           }

       }

       function pullRechargeListError() {
           $("#servicePage_Loading").hide();
       }

}
function hideBenificiaryPopup(){
  $(".overlay_prt").hide();
  $("#BenPopup").hide();
  $("#contactPicker").hide();
}

function deleteBeneficiary(beneficiaryId, bpID){

  printLogMessages("beneficiaryId-->"+beneficiaryId);
  if (isConnectionAvailable() === true) {
          var requestXML = '<?xml version="1.0" encoding="UTF-8" ?><Request FN="DELBN" fromCustmer="' + localStorage.mCustomerID + '" PIN="' + localStorage.mPIN + '" beneficiaryId="' + beneficiaryId + '" ></Request>';
          printLogMessages("deleteBeneficiary-->"+requestXML);
           $("#Payments_Loading").show();
           makeAJAXCall(requestXML, "POST", "xml", deleteBeneficiarySuccessCallback, deleteBeneficiaryErrorCallback);

       }

       function deleteBeneficiarySuccessCallback(ResponseXML) {
           $("#Payments_Loading").hide();
           var responseObj = $.xml2json(ResponseXML);
           printLogMessages("deleteBeneficiarySuccessCallback-->" + JSON.stringify(responseObj));

           if (responseObj.ResponseStatus == "success") {
              displayToastNotifications(responseObj.ResponseMessage);
              displayBeneficiaryList(bpID);
           } else {
               displayToastNotifications(responseObj.ResponseMessage);
           }
       }

       function deleteBeneficiaryErrorCallback() {
           $("#Payments_Loading").hide();
       }
}
function selectBeneficiary(benIndex){
 if(beneficiaryArrList.length > 0){
    var beneficiaryObject = beneficiaryArrList[benIndex];
    printLogMessages("beneficiaryObject-->" + JSON.stringify(beneficiaryObject));
    var serviceId = beneficiaryObject.transferTypeId;
    var keyCount = 0;
    for(objKey in beneficiaryObject){
        if (beneficiaryObject.hasOwnProperty(objKey)) {
            printLogMessages(objKey + " -> " + beneficiaryObject[objKey]);

            if(objKey != "transferTypeId" || objKey != "beneficiaryId"){
              if(objKey == "nickName"){
                   $("#SD_NickName").val(beneficiaryObject[objKey]);
              }
              if($("#field" + "_" + serviceId + "_" + objKey).length > 0){
                 if(objKey == "countryCode")
                  $("#field" + "_" + serviceId + "_" + objKey).val(beneficiaryObject[objKey]).change();
                 else
                  $("#field" + "_" + serviceId + "_" + objKey).val(beneficiaryObject[objKey])
              }
            }
            keyCount++;
          }
    }

    if(keyCount > 0){
      $("#SD_NickName").hide();
      $("#add_ben_checkbox img").attr("src", "img/uncheck.png");
      $("#SD_BenDiv").addClass("ben_disabled");
    }

 }
 else{
  displayToastNotifications("Invalid beneficiary information.");
 }
 hideBenificiaryPopup();
}

function openPenReqDetailPage(index){
 $("#TxnDetail_List").html("");
 var detailHTML = '';
 if(penReqArrList.length > 0){
   //TxnDetail_List
    printLogMessages("penReqArrList-->"+JSON.stringify(penReqArrList[index]));
    var pendingDetailObj = penReqArrList[index];

    if(pendingDetailObj.hasOwnProperty("payMode")){
       var payMode = pendingDetailObj.payMode;
    }
    else{
      var payMode = "W";
    }

    var isOTPFlag = false;
    if(typeof(pendingDetailObj.otp) != "undefined"){
      isOTPFlag = pendingDetailObj.otp;
    }
    detailHTML += '<div class="div_border_change"><div class="requestTo_leftpenal_confirm">' + getValidationMSGLocale("PEN_REQUEST_TYPE") + ' </div><div class="requestTo_trans_change">' + pendingDetailObj.transferTypeName + '</div><div class="clear_class"></div></div>';

    detailHTML += '<div class="div_border_change"><div class="requestTo_leftpenal_confirm">' + getValidationMSGLocale("PEN_REQUEST_BY") + ' </div><div class="requestTo_trans_change">' + pendingDetailObj.requestedByName + '('+ pendingDetailObj.requestedBy + ')</div><div class="clear_class"></div></div>';
    

//    detailHTML += '<div class="div_border_pending"><div class="txndetail_leftpenal" style="color: #197be7; font-size: 0.85em !important;">Requested To  <img src="img/Pending_requests_arrow.png"  width="8"> ' + pendingDetailObj.requestedTo + '</div></div>';
//    detailHTML += '<div class="clear_class"></div>';

    detailHTML += '<div class="div_border_change"><div class="requestTo_leftpenal_confirm">' + getValidationMSGLocale("SERVICE_FORM_AMOUNT") + ' </div><div class="requestTo_trans_change">' + pendingDetailObj.amount + '</div><div class="clear_class"></div></div>';
    

    detailHTML += '<div><div class="requestTo_leftpenal_confirm">' + getValidationMSGLocale("PEN_REQUEST_DATE") + '</div><div class="requestTo_trans_change">' + pendingDetailObj.creationDate + ' </div><div class="clear_class"></div></div>';
    
     //PIN Input Field
    detailHTML += '<div data-demo-html="true" align="center">';
    detailHTML += '<input type="tel" class="inputs_class" placeholder="' + getValidationMSGLocale("SERVICE_FORM_PIN") + '" maxlength="6" name="txnconfirm_pin" id="txnconfirm_pin" value="" autocomplete="off" data-role="none" style="-webkit-text-security: disc;margin-top:20px;">';
    detailHTML += '</div>';

     /*************************** add paymode checkbox *****************************************************/
        detailHTML += '<div data-demo-html="true" align="center"><span style="text-align:left; margin: 0 0 0 5%; padding-bottom: 5px; display:block; color:#063e7b;font-size:16px;text-decoration: underline;">' + getValidationMSGLocale("WP_PAYMENT_METHOD") + '</span></div>';

     if(payMode == "B"){

          detailHTML += '<div data-demo-html="true" align="center" id="Wallet-pending-div" onclick="pendingPaymentCheckbox(1);">';
          //detailHTML += '<span style="text-align:left; margin: 0 0 0 5%; display:block; color:#063e7b;font-size:16px;">' + getValidationMSGLocale("WP_PAYMENT_METHOD") + '</span><br/>';
          detailHTML += '<span class="confirm-pay-radio" id="Wallet-pending"><img src="img/radio_on.png" width="20" /></span>';
          detailHTML += '<span style="float: left; margin:3px 0; display:block; color:#063e7b;font-size:14px;">' + getValidationMSGLocale("WP_PAYMENT_WALLET") + '</span>';
          detailHTML += '</div>';
          detailHTML += '<div style="clear:both"></div>';
          detailHTML += '<div data-demo-html="true" align="center" id="UBills-pending-div" onclick="pendingPaymentCheckbox(2);">';
          detailHTML += '<span class="confirm-pay-radio" id="UBills-pending"><img src="img/radio_off.png" width="20" /></span>';
          detailHTML += '<span style="float: left; margin:3px 0; display:block; color:#063e7b;font-size:14px;">' + getValidationMSGLocale("WP_PAYMENT_UBILLS") + '</span>';
          detailHTML += '</div>';
          detailHTML += '<div style="clear:both"></div>';
     }

     if(payMode == "E"){
         detailHTML += '<div data-demo-html="true" align="center" id="UBills-pending-div" onclick="pendingPaymentCheckbox(2);">';
         detailHTML += '<span class="confirm-pay-radio" id="UBills-pending"><img src="img/radio_off.png" width="20" /></span>';
         detailHTML += '<span style="float: left; margin:3px 0; display:block; color:#063e7b;font-size:14px;">' + getValidationMSGLocale("WP_PAYMENT_UBILLS") + '</span>';
         detailHTML += '</div>';
         detailHTML += '<div style="clear:both"></div>';
     }

     if(payMode == "W"){

            detailHTML += '<div data-demo-html="true" align="center" id="Wallet-pending-div" onclick="pendingPaymentCheckbox(1);">';
            //detailHTML += '<span style="text-align:left; margin: 0 0 0 5%; display:block; color:#063e7b;font-size:16px;">' + getValidationMSGLocale("WP_PAYMENT_METHOD") + '</span><br/>';
            detailHTML += '<span class="confirm-pay-radio" id="Wallet-pending"><img src="img/radio_on.png" width="20" /></span>';
            detailHTML += '<span style="float: left; margin:3px 0; display:block; color:#063e7b;font-size:14px;">' + getValidationMSGLocale("WP_PAYMENT_WALLET") + '</span>';
            detailHTML += '</div>';
            detailHTML += '<div style="clear:both"></div>';
     }


       /*************************** paymode checkbox ends ****************************************************/

    detailHTML += '<div data-demo-html="false" data-role="none" align="center" class="div_margin"><input type="button" data-role="none" value="' + getValidationMSGLocale("WP_REQUEST_TO_SUBMIT") + '" class="button_login"  id="txnconfirm_btn" onclick="validateTxnConfirm(\''+ payMode +'\');" payURL="' + pendingDetailObj.payUrl + '" requestId ="' + pendingDetailObj.requestId + '" isOTPFlag="' + isOTPFlag + '"></div>';

    $("#TxnDetail_List").html(detailHTML);
    openPage("TxnDetail");

 }

}


function validateTxnConfirm(payMode){

  var payURL = $("#txnconfirm_btn").attr("payURL");
  var requestId = $("#txnconfirm_btn").attr("requestId");
  var isOTPFlag = $("#txnconfirm_btn").attr("isOTPFlag");

  var payment_pin = $.trim($("#txnconfirm_pin").val());

  if (PinValidation(payment_pin) != true) {

      displayToastNotifications(PinValidation(payment_pin));
      $("#txnconfirm_pin").focus();
      return;
  }

  var amount = null;
  uBillsRes_XML = null;
  isUBillPenReq = true;

  var requestXML = '<?xml version="1.0" encoding="UTF-8" ?>';
  requestXML += '<Request FN="WP" fromCustmer=' + '"' + localStorage.mCustomerID + '"';
  requestXML += ' ' + 'requestId=' + '"' + requestId + '"' + ' isRequestToPay="true"' + ' isLocal="' + localStorage.isLocal + '"';
  if(payURL.indexOf("|") != -1){
    var payURLArray = payURL.split("|");
    for(var s=0; s < payURLArray.length; s++){
       var internalNameArr = payURLArray[s].split("_");
       if(internalNameArr[0] == "amount"){
        amount = internalNameArr[1];
       }
       requestXML += ' ' + internalNameArr[0] + '=' + '"' + internalNameArr[1] + '"';
    }
  }
  requestXML += ' ' + 'PIN=' + '"' + payment_pin + '"' + '></Request>';
  printLogMessages("requestXML-->"+requestXML);
  uBillsRes_XML = requestXML;
  ////////////// check for wallet and ubills ///////////////////////////////////////////
   var uBillsDesc = "Zuulu uBiils payment";
   if(serviceObj){
    uBillsDesc = serviceObj.name;
   }
  var passParamObj = {firstName:localStorage.MemberName, lastName:localStorage.lastName, email:localStorage.Email, mobileNumber:localStorage.mCustomerID,  randomNo:generate16DigitRandomN(), description: uBillsDesc, ubMerchantId: UBills_MerchantID, ubReturnUrl: UBills_ReturnURL, amount: amount };
    if(payMode == "B"){

     if($("#UBills-pending img").attr("src") == "img/radio_on.png"){
        uBillsPayment(passParamObj);
     }
     else{
        //not external
        processPendingPayment(requestXML, isOTPFlag);
     }

    }
    else if(payMode == "E"){
      uBillsPayment(passParamObj);
    }
    else{
      //not external
      processPendingPayment(requestXML, isOTPFlag);
    }

  //////////////////////////////////////////////////////////////////////////////////////

}

function processPendingPayment(requestXML, otpFlag) {

    if (isConnectionAvailable() === true) {
        $("#servicePage_Loading").show();
        makeAJAXCall(requestXML, "POST", "xml", processPendingPaymentSuccessCallback, processPendingPaymentErrorCallback);

    }

    function processPendingPaymentSuccessCallback(ResponseXML) {
        $("#servicePage_Loading").hide();
        var responseObj = $.xml2json(ResponseXML);
        printLogMessages("processPendingPaymentSuccessCallback-->" + JSON.stringify(responseObj));

        if (responseObj.ResponseStatus == "success") {
            RefreshBalance();
            $('input[type="tel"]').val("");
            $('input[type="text"]').val("");
            $('input[type="select"]').val("");
            $('input[type="password"]').val("");
            if (otpFlag == "true") {
                var responseMsg = responseObj.ResponseMessage;
                var responseMsgArr = responseMsg.split("~");

                var toCustomer = responseMsgArr[1].split("=")[1];
                if (toCustomer != "null" && toCustomer != "undefined") {

                    $("#OTPSubmitBtn").attr("tranxId", responseObj.TransactionId);
                    $("#OTPSubmitBtn").attr("toCustmer", toCustomer);
                    $("#OTPSubmitBtn").attr("amount", responseMsgArr[2].split("=")[1]);
                    $("#OTPSubmitBtn").attr("pageID", "PendingReqPage");

                    $.mobile.pageContainer.pagecontainer("change", "#OTPPopup", {
                        transition: "none",
                        changeHash: false
                    });
                } else {
                    displayPendingRequest();
                }
                displayToastNotifications(responseMsgArr[0]);
            } else {

                var responseMsg = responseObj.ResponseMessage;
                var responseMsgArr = responseMsg.split("~");
                //displayToastNotifications(responseObj.ResponseMessage);
//                $("#penReqDialogMsg").text(responseMsgArr[0]);
//                //$("#dialogPopup_okBtn").attr("pageID", "PendingReqPage");
//                $.mobile.pageContainer.pagecontainer("change", "#penReqDialog", {
//                    transition: "none",
//                    changeHash: false
//                });
               var tokenNumber = responseObj.hasOwnProperty("TokenNo") == true ? $.trim(responseObj.TokenNo): "";
               if(tokenNumber){
                   var resultMessage = getValidationMSGLocale("SENELAC_PREPAID_TOKEN") + "<br/>" + appendHyphenInString(tokenNumber) + "<br/>" + responseMsgArr[0];
                   $("#responseMSG").html(resultMessage);

                }
                else{

                  $("#responseMSG").text(responseMsgArr[0]);

                }


                $("#dialogPopup_okBtn").attr("pageID", "PendingReqPage");
                $.mobile.pageContainer.pagecontainer("change", "#dialogPopup", {
                  transition: "none",
                  changeHash: false
                 });

            }

        } else {
            $("#txnconfirm_pin").val("");
            displayToastNotifications(responseObj.ResponseMessage);
        }

    }

    function processPendingPaymentErrorCallback() {
        $("#servicePage_Loading").hide();
        $("#txnconfirm_pin").val("");
    }
}

function cancelPenReq(requestId){

     if (isConnectionAvailable() === true) {
         var requestXML = '<?xml version="1.0" encoding="UTF-8" ?><Request FN="CRTP" fromCustmer="' + localStorage.mCustomerID + '" PIN="' + localStorage.mPIN + '" requestId="' + requestId + '" ></Request>';
          $("#Payments_Loading").show();
          makeAJAXCall(requestXML, "POST", "xml",cancelPenReqSuccessCallback, cancelPenReqErrorCallback);

      }

      function cancelPenReqSuccessCallback(ResponseXML) {
          $("#Payments_Loading").hide();
          var responseObj = $.xml2json(ResponseXML);
          printLogMessages("cancelPenReqSuccessCallback-->" + JSON.stringify(responseObj));

          if (responseObj.ResponseStatus == "success") {

              $('input[type="tel"]').val("");
              $('input[type="text"]').val("");
              $('input[type="select"]').val("");
              $('input[type="password"]').val("");

              var responseMsg = responseObj.ResponseMessage;
              $("#responseMSG").text(responseMsg);
              $("#dialogPopup_okBtn").attr("pageID", "PendingReqPage");
              $.mobile.pageContainer.pagecontainer("change", "#dialogPopup", {
                transition: "none",
                changeHash: false
               });

          } else {
              displayToastNotifications(responseObj.ResponseMessage);
          }

      }

      function cancelPenReqErrorCallback() {
          $("#Payments_Loading").hide();
      }
}
var cancelRequestId = null;
function cancelReqConfirmBox(requestId) {
 cancelRequestId = null;
 cancelRequestId = requestId;
 navigator.notification.confirm(getValidationMSGLocale("CANCEL_REQUEST_CONFIRM"), cancelReqConfirmBoxCall, '', [getValidationMSGLocale("PENDINGREQ_POPUP_CONFIRMBTN"), getValidationMSGLocale("PENDINGREQ_POPUP_NOBTN")]);
}

function cancelReqConfirmBoxCall(buttonIndex) {

    if (buttonIndex == 1) {
        cancelPenReq(cancelRequestId);
    } else {

        return false;
    }

}

function checkUpgradeEligibility(){

  checkCustomerUpgradeEligibility(localStorage.mCustomerID, "HomePage");

}

function upgradeBackPage(){
  printLogMessages("dsfdsfdfds--"+$("#Upgrade_uploadBtn").attr("pageName"));
  if($("#Upgrade_uploadBtn").attr("pageName")){
    if($("#Upgrade_uploadBtn").attr("pageName") == "CustomersPage")
      displayCustomerPage();
    else
      openPage($("#Upgrade_uploadBtn").attr("pageName"));
  }
  else{
    displayHomePage();
  }
}

function documentBackPage(){
   if($("#docUploadBtn").attr("pageName")){
       if($("#docUploadBtn").attr("pageName") == "CustomersPage")
         displayCustomerPage();
       else
         openPage($("#docUploadBtn").attr("pageName"));
     }
     else{
       displayHomePage();
     }
}

function checkCustomerUpgradeEligibility(CustomerMobNo, pageName){
      if (isConnectionAvailable() === true) {
         var requestXML = '<?xml version="1.0" encoding="UTF-8" ?><Request FN="UPGEL" fromCustmer="' + localStorage.mCustomerID + '" PIN="' + localStorage.mPIN + '" upgradeMobileNumber="' + CustomerMobNo + '"></Request>';
          $("#Payments_Loading").show();
          makeAJAXCall(requestXML, "POST", "xml", upgradeEligibilitySuccessCallback, upgradeEligibilityErrorCallback);

      }

      function upgradeEligibilitySuccessCallback(ResponseXML) {
          $("#Upgrade_uploadBtn").attr("pageName", pageName);
          $("#Payments_Loading").hide();
          var responseObj = $.xml2json(ResponseXML);
          printLogMessages("upgradeEligibilitySuccessCallback-->" + JSON.stringify(responseObj));

          if (responseObj.ResponseStatus == "success") {
             var upgradeDetails = responseObj.ResponseMessage.upgradeDetails;
             if(upgradeDetails.isRequestPending == "false"){

                $("#accountUpgradeMsg").text(upgradeDetails.message);
                $("#upgrade_okbtn").hide();
                $("#Upgrade_uploadBtn").show();
                $("#Upgrade_uploadBtn").attr("CustomerMobNo", CustomerMobNo);

                $("#Upgrade_finishBtn").show();
                $("#Upgrade_finishBtn").attr("message", upgradeDetails.finishMessage);

                if(typeof(responseObj.ResponseMessage.documentTypes) != "undefined"){
                  populateDocTypeDD(responseObj.ResponseMessage.documentTypes);
                }

             }
             else{

                $("#accountUpgradeMsg").text(upgradeDetails.message);
                $("#upgrade_okbtn").show();
                $("#Upgrade_uploadBtn").hide();
                $("#Upgrade_finishBtn").hide();

             }

             openPage("UpgradeAccount");

          } else {
              displayToastNotifications(responseObj.ResponseMessage);
          }

      }

      function upgradeEligibilityErrorCallback() {
          $("#Payments_Loading").hide();
      }
}

function upgradeFinishMsg(){
   $("#accountUpgradeMsg").text($("#Upgrade_finishBtn").attr("message"));
   $("#upgrade_okbtn").show();
   $("#Upgrade_uploadBtn").hide();
   $("#Upgrade_finishBtn").hide();
}

function upgradeUploadDoc(){

  displayKYCPage($("#Upgrade_uploadBtn").attr("CustomerMobNo"), "UpgradeAccount", false);
}

function populateDocTypeDD(documentTypes){

          $("#Payments_Loading").hide();
          var selectHTML = '';
          $("#kycSelectType").html("");
          if (typeof(documentTypes.documentType) != "undefined") {

              var documentObj = documentTypes.documentType;
              selectHTML += '<option value="0">' + getValidationMSGLocale("UPLOAD_DOC_TYPE") + '</option>';
              if (typeof(documentObj.length) != "undefined") {
                  for (var item = 0; item < documentObj.length; item++) {
                      printLogMessages("documentObj-->" + documentObj[item].value);

                      selectHTML += '<option value="' + documentObj[item].type + '">' + documentObj[item].value + '</option>';

                  }
              } else {
                  selectHTML += '<option value="' + documentObj.type + '">' + documentObj.value + '</option>';
              }
              $("#kycSelectType").html(selectHTML);

          }
}

function upgradeCustomerRequest(){

      if (isConnectionAvailable() === true) {

          var upgradeMobileNumber = $("#kyc_finishbtn").attr("toCustmer");
          var requestXML = '<?xml version="1.0" encoding="UTF-8" ?><Request FN="UPGC" fromCustmer="' + localStorage.mCustomerID + '" PIN="' + localStorage.mPIN + '" upgradeMobileNumber="' + upgradeMobileNumber + '"></Request>';
          $("#Payments_Loading").show();
          makeAJAXCall(requestXML, "POST", "xml", upgradeCustomerSuccessCallback, upgradeCustomerErrorCallback);

      }

      function upgradeCustomerSuccessCallback(ResponseXML) {
          $("#Payments_Loading").hide();
          var responseObj = $.xml2json(ResponseXML);
          printLogMessages("upgradeCustomerRequest-->" + JSON.stringify(responseObj));

          if (responseObj.ResponseStatus == "success") {

              documentBackPage();
              displayMessageInAlertBox(responseObj.ResponseMessage);

          } else {
              displayToastNotifications(responseObj.ResponseMessage);
          }

      }

      function upgradeCustomerErrorCallback() {
          $("#Payments_Loading").hide();
      }
}

function completePendingTxn(tranxId, amount, toCustmer){
  printLogMessages("tranxId-->"+tranxId);
    $("#OTPSubmitBtn").attr("tranxId", tranxId);
    $("#OTPSubmitBtn").attr("toCustmer", toCustmer);
    $("#OTPSubmitBtn").attr("amount", amount);
    $("#OTPSubmitBtn").attr("pageID", "PendingTxn");

    $.mobile.pageContainer.pagecontainer("change", "#OTPPopup", {
        transition: "none",
        changeHash: false
    });
}
function displayPreviousPage(){
    if($("#OTPSubmitBtn").attr("pageID")){
        openPage($("#OTPSubmitBtn").attr("pageID"));
    }
    else{
        displayHomePage();
    }
}


function cancelPendingTxn(tranxId){
  printLogMessages("tranxId-->"+tranxId);

   if (isConnectionAvailable() === true) {

             var requestXML = '<?xml version="1.0" encoding="UTF-8"?><Request FN="DA" fromMember="' + localStorage.mCustomerID + '" PIN="' + localStorage.mPIN + '" tranxNum ="' + tranxId + '" comments="selfrejected" ></Request>';
             $("#Payments_Loading").show();
             printLogMessages("cancelPendingTxn-->"+requestXML);
             makeAJAXCall(requestXML, "POST", "xml", cancelPendingTxnSuccessCallback, cancelPendingTxnrErrorCallback);

         }

         function cancelPendingTxnSuccessCallback(ResponseXML) {
             $("#Payments_Loading").hide();
             var responseObj = $.xml2json(ResponseXML);
             printLogMessages("cancelPendingTxnSuccessCallback-->" + JSON.stringify(responseObj));

             if (responseObj.ResponseStatus == "success") {

                 displayToastNotifications(responseObj.ResponseMessage);
                 displayPendingTxn();

             } else {
                 displayToastNotifications(responseObj.ResponseMessage);
             }

         }

         function cancelPendingTxnrErrorCallback() {
             $("#Payments_Loading").hide();
         }
}
function dialogPopupBack(){
    if($("#dialogPopup_okBtn").attr("pageID")){
        if($("#dialogPopup_okBtn").attr("pageID") == "PendingReqPage"){
            displayPendingRequest();
        }
        else if($("#dialogPopup_okBtn").attr("pageID") == "PendingTxn"){
            displayPendingTxn();
        }
        else{
            openPage($("#dialogPopup_okBtn").attr("pageID"));
        }
    }
    else{
        displayHomePage();
    }
}

function displayBalancePopup(){
  $(".overlay_prt").show();
  $("#BalancePopup").show();
}
function closeBalDetailPopup(){
  $(".overlay_prt").hide();
  $("#BalancePopup").hide();
}

function suspendPINCancelBtn(){
  pageNavigation('HomePage');
}


function suspendPINConfirm(){

  var suspend_mpin = $.trim($("#suspend_mpin").val());

  if (PinValidation(suspend_mpin) != true) {

      displayToastNotifications(PinValidation(suspend_mpin));
      $("#suspend_mpin").focus();
      return;
  }

  printLogMessages("suspendOption-->"+suspendOption);
  $("#suspend_mpin").val("");
  suspendActiveAccount(suspendOption, suspend_mpin);
}

function displayRegSuccessPage(){
  openPage("RegistSuccess");
}

function loginAfterReg(){
  $("#Payments_Loading").show();
  userLoginAfterSecurityQuestions($("#RegistSuccess_okbtn").attr("fromCustomer"), 
$("#RegistSuccess_okbtn").attr("rPIN"));

}

function displayDisableNotification(eleObj){
 if(eleObj){
     if ($(eleObj).val() != "0") {
        navigator.notification.alert('Dear Customer, thank you for choosing zuulu wallet. The service you have selected is currently not available. We will notify you once it is. Have a nice day.', function(){}, 'Coming Soon!', 'Ok');
      }
 }
 else{
     navigator.notification.alert('Dear Customer, thank you for choosing zuulu wallet. The service you have selected is currently not available. We will notify you once it is. Have a nice day.', function(){}, 'Coming Soon!', 'Ok');
 }
}

function addMaskOnTxtField(eleObject){

   $('#ServicePage').on('keyup', '#'+eleObject, function(ev){
            var foo = $(this).val().split("-").join("");
              if (foo.length > 0) {
                foo = foo.match(new RegExp('.{1,4}', 'g')).join("-");
              }
              $(this).val(foo);
         });
}

function getCurrentTiemstap(){

  if(localStorage.currentTime){
     return localStorage.currentTime;
  }
  else{
	 var Now = new Date();
	 var currentTime = Now.getTime();
	 localStorage.currentTime = currentTime;
	 return currentTime;
  }

}

function displayMultiLoginBox(MESSAGE) {

     navigator.notification.confirm(MESSAGE,  multiLoginConfirm, 'Zuulu', [getValidationMSGLocale("MULTILOGIN_CONFIRMBTN"), getValidationMSGLocale("MULTILOGIN_CANCELBTN")]);
}


function multiLoginConfirm(buttonIndex){
    $("#Login_PIN").val("");
	if(buttonIndex == 1){

		 resendMultiOTP();

	}else{

		 logoutUserFromApp();
	}

}

function resendMultiOTP() {
    //$("#Payments_Loading").hide();
    var receiverMobNo = $("#multiLoginbtn").attr("CustMobNo");
    printLogMessages("resendVOTP resendMultiOTP--->"+receiverMobNo);

    if (isConnectionAvailable() === true) {

         $("#Payments_Loading").show();
         var requestXML = '<?xml version="1.0" encoding="UTF-8" ?><Request FN="SOTP" fromCustmer="' + receiverMobNo + '"></Request>';
         makeAJAXCall(requestXML, "POST", "xml", resendMultiOTPSuccessCall, resendMultiOTPErrorCall);

     }

     function resendMultiOTPSuccessCall(ResponseXML) {

         var responseObj = $.xml2json(ResponseXML);
         printLogMessages("resendVOTPSuccessCall-->" + JSON.stringify(responseObj));
         $("#Payments_Loading").hide();

         if (responseObj.ResponseStatus == "success") {
             openPage("MultiLogOTP");
             var ResponseMessageObj = (responseObj.ResponseMessage).split("-");
             displayMessageInAlertBox(ResponseMessageObj[0]);

         } else {
             displayMessageInAlertBox(responseObj.ResponseMessage);
         }

     }

     function resendMultiOTPErrorCall() {

         $("#Payments_Loading").hide();

     }
}

function validateMultiLogOTP() {
//$("#multiLoginbtn").attr("CustMobNo", LoginMobNo);
            //$("#multiLoginbtn").attr("CustPIN", LoginPIN);
    var fromCustomer = $("#multiLoginbtn").attr("CustMobNo");
    printLogMessages("validateMultiLogOTP fromCustomer-->"+fromCustomer);
    //var AuthID = $("#AVOTP_Btn").attr("AuthID");

    var OTPValue = $("#ML_OTP").val();
    var validateFlag = true;
    if (!OTPValue) {
        displayToastNotifications(getValidationMSGLocale("OTP_EMPTY"));
        $("#ML_OTP").focus();
        validateFlag = false;
        return;
    }
    if (OTPValue.length < 4) {
        displayToastNotifications(getValidationMSGLocale("OTP_VALID_LEN"));
        $("#ML_OTP").focus();
        validateFlag = false;
        return;
    }
    if (!$.isNumeric(OTPValue)) {
        displayToastNotifications(getValidationMSGLocale("OTP_NUMERIC"));
        $("#ML_OTP").focus();
        validateFlag = false;
        return;
    }

    if (validateFlag == true) {

        if (isConnectionAvailable() === true) {

            $("#Payments_Loading").show();
            var requestXML = '<?xml version="1.0" encoding="UTF-8" ?><Request FN="VOTP" fromCustmer="' + fromCustomer + '" otp="' + OTPValue + '"  updateDeviceKey="true"></Request>';

            makeAJAXCall(requestXML, "POST", "xml", validateMultiLogOTPSuccessCallback, validateMultiLogOTPErrorCallback);

        }
    }

    function validateMultiLogOTPSuccessCallback(ResponseXML) {
        var responseObj = $.xml2json(ResponseXML);
        printLogMessages("OTPAuthSuccessCallback-->" + JSON.stringify(responseObj));

        $("#ML_OTP").val("");
        if (responseObj.ResponseStatus == "success") {

             userLoginAfterSecurityQuestions($("#multiLoginbtn").attr("CustMobNo"), $("#multiLoginbtn").attr("CustPIN"));

        } else {
            displayToastNotifications(responseObj.ResponseMessage);
            $("#Payments_Loading").hide();
        }
    }

    function validateMultiLogOTPErrorCallback() {
        $("#ML_OTP").val("");
        $("#Payments_Loading").hide();
    }

}

function addAutoCompleter(rechargeInfo){

  $('.wpCountryCode').autocomplete({
lookup: countryArr,
 onSelect: function (suggestion) {

      $('.wpCountryCode').val(suggestion.data);
    
} 

   });

}

function readNFCFn(){

   isNFCAvailable(function() {

               isPhotoActive = true;
               nfc.addNdefListener(NDEFDataCallback,
                   function() {
                       printLogMessages("Waiting for NDEF tag");
                       isEventRemoved = false;
                       $(".nfc_overlay").show();
                       removeCallBackAfterTime("R");
                   },
                   function(error) {
                       displayToastNotifications(getValidationMSGLocale("NFC_READ_ERROR"));
                       removeCallbackForNdef("R");
                   }
               );

       }, function() {
           displayToastNotifications(getValidationMSGLocale("NFC_ENABLED"));
       });
}

function NFCAdminDataCallback(nfcEvent) {
    printLogMessages("NFCAdminDataCallback NFCAdminDataCallback NFCAdminDataCallback");
    $(".nfc_overlay").hide();
    var tag = nfcEvent.tag,
        ndefMessage = tag.ndefMessage;

    if (ndefMessage != null && ndefMessage != "undefined") {

        if (ndefMessage[0].payload) {

            if (ndefMessage[0].payload.length > 0) {

                var resData = nfc.bytesToString(ndefMessage[0].payload.slice(3));

                if (resData.indexOf("ProductName") != -1) {

                    var payloadArr = resData.split("***");
                    var customerDetailArr = payloadArr[1].split("&");
                    var cMobNo = decrypt(customerDetailArr[1], ENCRYP_KEY);
                    var cName = customerDetailArr[0];
                    var cEmail = decrypt(customerDetailArr[2], ENCRYP_KEY);

                    printLogMessages("formattedStr-->" + cMobNo);
                    printLogMessages("nameFieldVal-->" + cName);
                    printLogMessages("cEmail-->" + cEmail);
                    navigator.vibrate(2000);
                    displayNFCReadData(cName, cEmail, cMobNo);

                } else {

                    displayToastNotifications(getValidationMSGLocale("NFC_INVALID_FORMAT"));

                }
            }

        } else {

            displayToastNotifications(getValidationMSGLocale("NFC_EMPTY"));
        }
    } else {

        displayToastNotifications(getValidationMSGLocale("NFC_EMPTY"));
    }

    removeCallbackForNdef("R");
}

function writeNFCCustomerDetail(){
     isNFCAvailable(function() {
                //NFC is enabled on this device
                isPhotoActive = true;
                nfc.addNdefListener(
                    writeData,
                    function() {
                        printLogMessages("Listening for NDEF tags.");
                        isEventRemoved = false;
                        $(".nfc_overlay").show();
                        removeCallBackAfterTime("W");
                    },
                    function() {
                        printLogMessages("WriteData NDEF tags error.");
                        removeCallbackForNdef("W");
                    }
                );

            }, function() {

                displayToastNotifications(getValidationMSGLocale("NFC_ENABLED"));

            });
}

function getNFCCustomerDetail() {

    var NFCDetail_MobNo = $.trim($("#NFCDetail_MobNo").val());

    if (PhoneNumberValidation(NFCDetail_MobNo) != true) {
        displayToastNotifications(PhoneNumberValidation(NFCDetail_MobNo));
    } else {

        if (isConnectionAvailable() === true) {

            $("#Payments_Loading").show();

            var requestXML = '<?xml version="1.0" encoding="UTF-8" ?><Request FN="GNFUD" fromCustmer="' + localStorage.mCustomerID + '" PIN="' + localStorage.mPIN + '" userMobileNumber="' + NFCDetail_MobNo + '"></Request>';
            makeAJAXCall(requestXML, "POST", "xml", NFCCustomerDetailSuccessCall, NFCCustomerDetailErrorCall);

        }
    }

    function NFCCustomerDetailSuccessCall(ResponseXML) {
        var responseObj = $.xml2json(ResponseXML);
        printLogMessages("NFCCustomerDetailSuccessCall-->" + JSON.stringify(responseObj));
        $("#Payments_Loading").hide();

        if (responseObj.ResponseStatus == "success") {
             var ResponseMessageObj = responseObj.ResponseMessage;
             if(ResponseMessageObj.hasOwnProperty("User")){
                  displayNFCCustDetail(ResponseMessageObj);
             }

        } else {
            displayToastNotifications(responseObj.ResponseMessage);
        }

    }

    function NFCCustomerDetailErrorCall() {
        $("#Payments_Loading").hide();
    }
}

function displayNFCCustDetail(ResponseMessageObj){
    $("#NFCCustDetail_List").html("");
    var customerName = ResponseMessageObj.User.FirstName;
    if(ResponseMessageObj.User.LastName){
      customerName = customerName + ' ' + ResponseMessageObj.User.LastName;
    }
    var detailHTML = '';
    detailHTML += '<div class="div_border_pending"><div class="txndetail_leftpenal" style="color: #197be7; font-size: 17px !important;">Name  <img src="img/Pending_requests_arrow.png"  width="8"> ' + customerName + '</div></div>';
    detailHTML += '<div class="clear_class"></div>';

//    detailHTML += '<div class="div_border_pending"><div class="txndetail_leftpenal" style="color: #197be7; font-size: 17px !important;">Last Name  <img src="img/Pending_requests_arrow.png"  width="8"> ' + ResponseMessageObj.User.LastName + '</div></div>';
//    detailHTML += '<div class="clear_class"></div>';

     detailHTML += '<div class="div_border_pending"><div class="txndetail_leftpenal" style="color: #197be7; font-size: 17px !important;">Mobile Number  <img src="img/Pending_requests_arrow.png"  width="8"> ' + ResponseMessageObj.User.MobileNumber + '</div></div>';
     detailHTML += '<div class="clear_class"></div>';

     detailHTML += '<div class="div_border_pending"><div class="txndetail_leftpenal" style="color: #197be7; font-size: 17px !important;">Email  <img src="img/Pending_requests_arrow.png"  width="8"> ' + ResponseMessageObj.User.Email + '</div></div>';
     detailHTML += '<div class="clear_class"></div>';

    $("#NFCCustDetail_List").html(detailHTML);
    $("#NFCCustDetail_writeBtn").show();
    $("#NFCCustDetail_writeBtn").attr("cName", ResponseMessageObj.User.FirstName + ' ' + ResponseMessageObj.User.LastName);
    $("#NFCCustDetail_writeBtn").attr("cMobNo", ResponseMessageObj.User.MobileNumber);
    $("#NFCCustDetail_writeBtn").attr("cEmail", ResponseMessageObj.User.Email);
    openPage("NFCCustDetail");
}

function displayNFCReadData(Name, Email, MobileNumber){

    $("#NFCCustDetail_List").html("");
    var detailHTML = '';
    detailHTML += '<div class="div_border_pending"><div class="txndetail_leftpenal" style="color: #197be7; font-size: 17px !important;">Name  <img src="img/Pending_requests_arrow.png"  width="8"> ' + Name + '</div></div>';
    detailHTML += '<div class="clear_class"></div>';


     detailHTML += '<div class="div_border_pending"><div class="txndetail_leftpenal" style="color: #197be7; font-size: 17px !important;">Email  <img src="img/Pending_requests_arrow.png"  width="8"> ' + Email + '</div></div>';
     detailHTML += '<div class="clear_class"></div>';

     detailHTML += '<div class="div_border_pending"><div class="txndetail_leftpenal" style="color: #197be7; font-size: 17px !important;">Mobile Number  <img src="img/Pending_requests_arrow.png"  width="8"> ' + MobileNumber + '</div></div>';
     detailHTML += '<div class="clear_class"></div>';

    $("#NFCCustDetail_writeBtn").hide();
    $("#NFCCustDetail_List").html(detailHTML);
    openPage("NFCCustDetail");

}

function displayServicePage(){
 if($("#WP_backBtn").attr("LastPage") ==  "SenelecBillDetail"){
   openPage("SenelecBillDetail");
 }
 else if($("#WP_backBtn").attr("LastPage") ==  "WaterBillDetail"){
   openPage("WaterBillDetail");
 }
 else if($("#WP_backBtn").attr("LastPage") ==  "AquatechBillDetail"){
    openPage("AquatechBillDetail");
 }
 else if($("#WP_backBtn").attr("LastPage") ==  "HomePage"){
    displayHomePage();
  }
 else{
   openPage("ServicePage");
 }

}

function isValidNumber(eleVal) {

    var patt = /^[1-9][0-9]*$/g;
    if(patt.test(eleVal) && parseInt(eleVal) > 0)
      return true;
    else
      return false;
}

function generate16DigitRandomN() {
        return Math.floor(1000000000000000 + Math.random() * 9000000000000000);
}

function storeUBillsTxn(UBills_RefID, ResponseObj){

   if (uBillsRes_XML.indexOf('></Request>') != -1) {

       var paymentTxnXMLArr = uBillsRes_XML.split('></Request>');
       var finalReqXML = paymentTxnXMLArr[0];

       for (var key in ResponseObj) {

           if(key != "amount"){

             finalReqXML += ' ' + key + '="' + ResponseObj[key] + '"';

           }

       }

       finalReqXML += ' ref="' + UBills_RefID + '"';
       finalReqXML += ' isExternal="true"';

       finalReqXML = finalReqXML + '></Request>';
       printLogMessages("appendUBillsParams->" + finalReqXML);
      if(isUBillPenReq == true){

        var isOTPFlag = $("#txnconfirm_btn").attr("isOTPFlag");
        processPendingPayment(finalReqXML, isOTPFlag);

      }
      else{

        var otpFlag = $("#WP_submitBtn").attr("otpFlag");
        var pageName = $("#WP_submitBtn").attr("pageName");
        walletPaymentService(finalReqXML, otpFlag, pageName);

      }

   }

}

function addDeviceParamsFresh(requestXML) {
	
	
	// alert("requestXML Before Loop: " + requestXML);
    for (var item in appInfoFresh) {
        requestXML += ' ' + item + '="' + appInfoFresh[item] + '"';
		// alert(' ' + item + '="' + appInfoFresh[item] + '"');
    }
	
	// alert("requestXML After Loop: " + requestXML);

    // requestXML += ' uniqueDeviceKey="' + getCurrentTiemstap() + '"';
	requestXML += ' uniqueDeviceKey="42325819292526"';
    // if(localStorage.APP_LANG){
     // var app_lang = localStorage.APP_LANG;
     requestXML += ' LN="FR"';
    // }


    // printLogMessages("requestXML -->"+requestXML);
    return requestXML;
}

function senelacRefPage(isSelf){

 openPage("ServicePage");
 //$("#subcat_name").html('<div class="leftstyle" style="text-align:center !important;"><p class="p_t_text" style="padding-top:0px;">' + getValidationMSGLocale("SENELEC_REFNO_PAGETITLE") + '</p></div><img width="30" height="25" src="img/beneficiary_browse_btn.png" class="ben_headerleft_icon" id="BenIcon" onclick="displayBeneficiaryList(\'' + $("#senelecSelfbtn").attr("SId") + '\');" style="display:none;" />');
$("#subcat_name").html('<p class="p_t_text" style="padding-top:0px;">' + getValidationMSGLocale("SENELEC_REFNO_PAGETITLE") + '</p>');
$("#BenIcon").html('');
$("#BenIcon").hide();

$("#payform_xml").html("");

 var dynamicHtml = '<div align="center" style="margin-bottom: 10px;"><div align="center"><img src="img/bulb.png" width="45"></div></div>';
 dynamicHtml += '<div align="center" class="header_text" id="PostpaidRefMsg_msg" style="text-align:center !important;color:#004d95;">' + (isSelf == "true" ? getValidationMSGLocale("SENELEC_SELF_REFNO") : getValidationMSGLocale("SENELEC_OTHER_REFNO")) + '</div>';

 dynamicHtml += '<div data-demo-html="true" align="center">';
 if(isSelf == "true" && localStorage.senelecReference){
  dynamicHtml += '<input type="text" class="inputs_class" placeholder="' + getValidationMSGLocale("SENELEC_ENTER_REFNO") + '" maxlength="50" value="' + localStorage.senelecReference + '" name="custmerReference" id="custmerReference" autocomplete="off" data-role="none">';
 }
 else{
  dynamicHtml += '<input type="text" class="inputs_class" placeholder="' + getValidationMSGLocale("SENELEC_ENTER_REFNO") + '" maxlength="20" name="custmerReference" value="" id="custmerReference" autocomplete="off" data-role="none">';
 }

 dynamicHtml += '</div>';
 dynamicHtml += '<div data-demo-html="false" data-role="none" align="center" class="div_margin"><input type="button" data-role="none" value="' + getValidationMSGLocale("SERVICE_FORM_BACK") + '" class="Add_btn" onclick="openSenelecMainPage();"><input type="button" data-role="none" value="' + getValidationMSGLocale("SENELEC_CONTINUE_BUTTON") + '" class="Add_btnn" onclick="pullListOfSenelecBills();"></div>';
 //console.log(dynamicHtml);
 $("#payform_xml").html(dynamicHtml);


}
function isNumberAlreadyRegister(ID){

    printLogMessages("isNumberAlreadyRegister");
    $("#field" + "_" + ID + "_receiverFirstName").val("");
    $("#field" + "_" + ID + "_receiverLastName").val("");
    $("#field" + "_" + ID + "_receiverAddress").val("");
    $("#field" + "_" + ID + "_receiverCity").val("0");
    $("#field" + "_" + ID + "_receiverCountry").val("0");

    $("#field" + "_" + ID + "_senderIdNo").val("");
    $("#field" + "_" + ID + "_senderIdType").val("0");

    $("#field" + "_" + ID + "_receiverAddress").show();
    $("#field" + "_" + ID + "_receiverCity").parent().show();
    $("#field" + "_" + ID + "_receiverCountry").parent().show();

    $("#field" + "_" + ID + "_senderIdNo").show();
    $("#field" + "_" + ID + "_senderIdType").parent().show();

    $("#paySubmitBtn").attr("isNumberRegister", "false");

   var receiverMobileNumber = $.trim($("#field" + "_" + ID + "_receiverMobileNumber").val());
   receiverMobileNumber = formatMobileNumberForRemittance(receiverMobileNumber); // NEW Changements Remittance
   $("#field" + "_" + ID + "_receiverMobileNumber").val(receiverMobileNumber); // NEW Changements Remittance
   if (PhoneNumberValidation(receiverMobileNumber) != true) {
        return;
   }


   if (isConnectionAvailable() === true) {

       $("#servicePage_Loading").show();
       var requestXML = '<?xml version="1.0" encoding="UTF-8" ?><Request FN="RRR" fromCustmer="' + localStorage.mCustomerID + '" PIN="' + localStorage.mPIN + '" receiverMobileNumber="' + receiverMobileNumber + '"></Request>';
       makeAJAXCall(requestXML, "POST", "xml", isNumberAlreadyRegisterSuccess, isNumberAlreadyRegisterError);

   }

       function isNumberAlreadyRegisterSuccess(ResponseXML) {

           $("#servicePage_Loading").hide();
           var responseObj = $.xml2json(ResponseXML);
           printLogMessages("isNumberAlreadyRegisterSuccess-->" + JSON.stringify(responseObj));

           if (responseObj.ResponseStatus == "success") {

                 var ResponseMessageObj = responseObj.ResponseMessage;
                 if(ResponseMessageObj.hasOwnProperty("isReceiverRegistered")){

                     if(ResponseMessageObj.isReceiverRegistered == "true"){

                         if(ResponseMessageObj.receiverFirstName != "null"){

                            $("#field" + "_" + ID + "_receiverFirstName").val(ResponseMessageObj.receiverFirstName);

                        }

                        if(ResponseMessageObj.receiverLastName != "null"){

                          $("#field" + "_" + ID + "_receiverLastName").val(ResponseMessageObj.receiverLastName);

                        }

                          $("#field" + "_" + ID + "_receiverAddress").val("");

                          $("#field" + "_" + ID + "_receiverCity").val("0");
                          $("#field" + "_" + ID + "_receiverCountry").val("0");

                          $("#field" + "_" + ID + "_receiverAddress").hide();
                          $("#field" + "_" + ID + "_receiverCity").parent().hide();
                          $("#field" + "_" + ID + "_receiverCountry").parent().hide();

                          $("#field" + "_" + ID + "_senderIdNo").hide();
                          $("#field" + "_" + ID + "_senderIdType").parent().hide();

                          $("#paySubmitBtn").attr("isNumberRegister", "true");

                     }
                 }

           } else {
               displayToast(responseObj.ResponseMessage);
           }

       }

       function isNumberAlreadyRegisterError() {
           $("#servicePage_Loading").hide();
       }

}

function formatMobileNumberForRemittance(mobileNo) { // Chagements Remittance
	// alert("mobileNo: " + mobileNo);
	mobileNo = mobileNo.replace(/^[0]+/g,""); // Leading Zeros
	mobileNo = mobileNo.replace(/\s+/g, ''); // White spaces
	if( mobileNo.length == 9 && (mobileNo.indexOf("70") == 0 || mobileNo.indexOf("78") == 0 || mobileNo.indexOf("77") == 0 || mobileNo.indexOf("76") == 0) ) { // + 221
		mobileNo = "221" + mobileNo;	
	}
	return mobileNo;
}

function getTxnIdAmount(ID){

      var transactionId = $.trim($("#field" + "_" + ID + "_transactionId").val());
	  // str = transactionIdObj.value;
		transactionId = transactionId.replace(/-/g , ""); // Changements Remittance
		// A FINIR SUR LE MOBILE
      $("#payment_amount").val("");
      //$("#payment_amount").prop("disabled", true);

      var serviceObj_ttType = serviceObj.ttType;

      if(serviceObj_ttType == "AgentC"){
          $("#field" + "_" + ID + "_receiverFirstName").val("");
          $("#field" + "_" + ID + "_receiverLastName").val("");

          $("#field" + "_" + ID + "_receiverFirstName").prop("disabled", false);
          $("#field" + "_" + ID + "_receiverLastName").prop("disabled", false);

      }

      if(serviceObj_ttType == "AgentR"){
         $("#field" + "_" + ID + "_senderFName").val("");
         $("#field" + "_" + ID + "_senderLName").val("");

         $("#field" + "_" + ID + "_senderFName").prop("disabled", false);
         $("#field" + "_" + ID + "_senderLName").prop("disabled", false);
      }

      printLogMessages("serviceObj_ttType-->" + serviceObj_ttType);

      if (!transactionId) {
           return;
      }

      if (isConnectionAvailable() === true) {

          $("#servicePage_Loading").show();
          var requestXML = '<?xml version="1.0" encoding="UTF-8" ?><Request FN="RCA" fromCustmer="' + localStorage.mCustomerID + '" PIN="' + localStorage.mPIN + '" transactionId="' + transactionId + '"></Request>';
          makeAJAXCall(requestXML, "POST", "xml", getTxnIdAmountSuccess, getTxnIdAmountError);

      }

      function getTxnIdAmountSuccess(ResponseXML) {

          $("#servicePage_Loading").hide();
          var responseObj = $.xml2json(ResponseXML);
          printLogMessages("getTxnIdAmountSuccess-->" + JSON.stringify(responseObj));

          if (responseObj.ResponseStatus == "success") {

                var ResponseMessageObj = responseObj.ResponseMessage;
                if(ResponseMessageObj.hasOwnProperty("amount")){
                   //$("#payment_amount").prop("disabled", true);
                   $("#payment_amount").val(ResponseMessageObj.amount);
                }

                if(serviceObj_ttType == "AgentC"){
                     if(ResponseMessageObj.hasOwnProperty("receiverFirstName")){
                        $("#field" + "_" + ID + "_receiverFirstName").val(ResponseMessageObj.receiverFirstName);
                        $("#field" + "_" + ID + "_receiverFirstName").prop("disabled", true);
                     }
                     if(ResponseMessageObj.hasOwnProperty("receiverLastName")){
                        $("#field" + "_" + ID + "_receiverLastName").val(ResponseMessageObj.receiverLastName);
                        $("#field" + "_" + ID + "_receiverLastName").prop("disabled", true);
                     }
                }

                if(serviceObj_ttType == "AgentR"){
                     if(ResponseMessageObj.hasOwnProperty("receiverFirstName")){
                        $("#field" + "_" + ID + "_senderFName").val(ResponseMessageObj.receiverFirstName);
                        $("#field" + "_" + ID + "_senderFName").prop("disabled", true);
                     }
                     if(ResponseMessageObj.hasOwnProperty("receiverLastName")){
                        $("#field" + "_" + ID + "_senderLName").val(ResponseMessageObj.receiverLastName);
                        $("#field" + "_" + ID + "_senderLName").prop("disabled", true);
                     }
                }

          }
          else{

             $("#field" + "_" + ID + "_transactionId").val("");
             displayMessageInAlertBox(responseObj.ResponseMessage);

          }
      }

      function getTxnIdAmountError() {
          $("#field" + "_" + ID + "_transactionId").val("");
          $("#servicePage_Loading").hide();
      }

}

function openSenelecMainPage(){
  if(localStorage.Subtype == "AGENTS"){
    displayHomePage();
  }
  else{
   openPage("PostpaidSelfOther");
  }

}

var senelecBillArr = [];
function pullListOfSenelecBills(){
  //http://localhost:8282/zuulu?FN=GEPPOI&custmerReference=1150707232
      $("#senelecBillList").html('');
      senelecBillArr = [];

      var custmerReference = $.trim($("#custmerReference").val());

      if (!custmerReference) {
          displayToastNotifications(getValidationMSGLocale("SENELEC_REFNO_NULL"));
      }
      // else if(custmerReference.length != 10){
      else if(custmerReference.length < 10){
       displayToastNotifications(getValidationMSGLocale("REFNO_LENGTHVAL"));
      }
      else {

          if (isConnectionAvailable() === true) {

              $("#Payments_Loading").show();

              var requestXML = '<?xml version="1.0" encoding="UTF-8" ?><Request FN="GEPPOI" fromCustmer="' + localStorage.mCustomerID + '" PIN="' + localStorage.mPIN + '" custmerReference="' + custmerReference + '"></Request>';
              makeAJAXCall(requestXML, "POST", "xml", pullListOfSenelecBillsSuccessCall, pullListOfSenelecBillsErrorCall);

          }
      }

      function pullListOfSenelecBillsSuccessCall(ResponseXML) {
          var responseObj = $.xml2json(ResponseXML);
          printLogMessages("pullListOfSenelecBills-->" + JSON.stringify(responseObj));
          $("#Payments_Loading").hide();

          if (responseObj.ResponseStatus == "success") {
               localStorage.senelecReference = custmerReference;
               var ResponseMessageObj = responseObj.ResponseMessage;

               if(ResponseMessageObj.hasOwnProperty("invoices")){
                  var invoicesListObj = ResponseMessageObj.invoices;

                  if(invoicesListObj.hasOwnProperty("invoice")){

                    var invoiceObj = invoicesListObj.invoice;

                    var dynamicHTMl = '';
                    dynamicHTMl += '<table width="100%" cellspacing="0" border="1" cellpadding="0">';
                    dynamicHTMl += '<col width="19%"><col width="19%"><col width="20%"><col width="24%"><col width="18%">';

                    if (typeof(invoiceObj.length) != "undefined") {
                      console.log("loop h bhhai");
                     for (var i = 0; i < invoiceObj.length; i++) {

                       //if($.trim(invoiceObj[i].billPeriodFrom) != "null"){
                         var billPeriodFrom = $.trim(invoiceObj[i].billPeriodFrom);
                         if(billPeriodFrom == "null"){
                           billPeriodFrom = "NA";
                         }
//                       }
//                       else{
//                        var billPeriodFrom = "";
//                       }

                     // if($.trim(invoiceObj[i].billPeriodTo) != "null"){
                        var billPeriodTo = $.trim(invoiceObj[i].billPeriodTo);
                        if(billPeriodTo == "null"){
                          billPeriodTo = "NA";
                        }

                        var dueDate = invoiceObj[i].dueDate;
                        if(dueDate == "null"){
                          dueDate = "NA";
                        }
//                      }
//                      else{
//                       var billPeriodTo = "";
//                      }
                       dynamicHTMl += '<tr>';
                       dynamicHTMl += '<td><span class="gray_fontSpan">' + getValidationMSGLocale("SENELEC_BILLLIST_INVOICENO") + '</span><span class="blue_fontSpan">' +  invoiceObj[i].invoiceNumber + '</span></td>';
                       dynamicHTMl += '<td><span class="gray_fontSpan">' + getValidationMSGLocale("SENELEC_BILLLIST_PERIODFROM") + '</span><span class="blue_fontSpan">' +  billPeriodFrom  + '<br/><span style="color:#7e7c7f;">' + getValidationMSGLocale("SENELEC_BILLLIST_PERIODTO") + '</span><br/>' +  billPeriodTo + '</span></td>';
                       dynamicHTMl += '<td><span class="gray_fontSpan">' + getValidationMSGLocale("SENELEC_BILLLIST_AMOUNT") + '</span><span class="blue_fontSpan">' +  invoiceObj[i].amount + '</span></td>';
                       dynamicHTMl += '<td><span class="gray_fontSpan">' + getValidationMSGLocale("SENELEC_BILLLIST_DUEDATE") + '</span><span class="blue_fontSpan">' +  dueDate + '</span></td>';
                        dynamicHTMl += '<td style="vertical-align: middle;font-size: 15px;"><input type="button" data-role="none" value="' + getValidationMSGLocale("SENELEC_BILLLIST_PAYBTN") + '" class="selelac_paybtn" onclick="displaySenelecBillDetail(\'' + i + '\');" style="display: block;margin: auto;"></td>';
                       dynamicHTMl += '</tr>';
                       senelecBillArr.push(invoiceObj[i]);

                     }

                    }
                    else{
                      //code for single element
                      //if($.trim(invoiceObj.billPeriodFrom) != "null"){
                         var billPeriodFrom = $.trim(invoiceObj.billPeriodFrom);
                         if(billPeriodFrom == "null"){
                          billPeriodFrom = "NA";
                         }
//                      }
//                      else{
//                        var billPeriodFrom = "";
//                      }

                      //if($.trim(invoiceObj.billPeriodTo) != "null"){
                        var billPeriodTo = $.trim(invoiceObj.billPeriodTo);
                        if(billPeriodTo == "null"){
                          billPeriodTo = "NA";
                        }
                        var dueDate = invoiceObj.dueDate;
                        if(dueDate == "null"){
                          dueDate = "NA";
                        }
//                      }
//                      else{
//                       var billPeriodTo = "";
//                      }
                    dynamicHTMl += '<tr>';
                    dynamicHTMl += '<td><span class="gray_fontSpan">' + getValidationMSGLocale("SENELEC_BILLLIST_INVOICENO") + '</span><span class="blue_fontSpan">' +  invoiceObj.invoiceNumber + '</span></td>';
                    dynamicHTMl += '<td><span class="gray_fontSpan">' + getValidationMSGLocale("SENELEC_BILLLIST_PERIODFROM") + '</span><span class="blue_fontSpan">' +  billPeriodFrom  + '<br/><span style="color:#7e7c7f;">' + getValidationMSGLocale("SENELEC_BILLLIST_PERIODTO") + '</span><br/>' +  billPeriodTo + '</span></td>';
                    dynamicHTMl += '<td><span class="gray_fontSpan">' + getValidationMSGLocale("SENELEC_BILLLIST_AMOUNT") + '</span><span class="blue_fontSpan">' +  invoiceObj.amount + '</span></td>';
                    dynamicHTMl += '<td><span class="gray_fontSpan">' + getValidationMSGLocale("SENELEC_BILLLIST_DUEDATE") + '</span><span class="blue_fontSpan">' +  dueDate + '</span></td>';
                    dynamicHTMl += '<td style="vertical-align: middle;font-size: 15px;"><input type="button" data-role="none" value="' + getValidationMSGLocale("SENELEC_BILLLIST_PAYBTN") + '" class="selelac_paybtn" onclick="displaySenelecBillDetail(0);" style="display: block;margin: auto;border-right:0px;"></td>';
                    dynamicHTMl += '</tr>';

                    senelecBillArr.push(invoiceObj);

                    }

                    dynamicHTMl += '</table>';

                  }
                  console.log("senelecBillList-->"+dynamicHTMl);
                  $("#senelecBillList").html(dynamicHTMl);
                  openPage("SenelecBills");

               }




          } else {
              displayToastNotifications(responseObj.ResponseMessage);
          }

      }

      function pullListOfSenelecBillsErrorCall() {
          $("#Payments_Loading").hide();
      }
}

function displaySenelecBillDetail(billIndex){

$("#invoice-box").html('');

 var dueDate = senelecBillArr[billIndex].dueDate;
 if(dueDate == "null"){
   dueDate = "NA";
 }
var billHTML = '<table cellpadding="0" cellspacing="0">';

    billHTML += '<tr class="top">';
    billHTML += '<td colspan="2">';
    billHTML += '<table style="text-align:center;">';

    billHTML += '<tr><td class="title">';
    billHTML += '<img src="img/senelec_logo.png" style="width:100%; max-width:150px;">';
    billHTML += '</td></tr>';

    billHTML += '<tr>';
    billHTML += '<td><span style="color:#ce0316; font-weight:700;">' + getValidationMSGLocale("SENELEC_BILL_DUEDATE") + '</span>' + dueDate + '<br><br>';

    billHTML += '<span style="color: #004d95;">' + getValidationMSGLocale("SENELEC_BILL_INVOICENO") + '</span>' + senelecBillArr[billIndex].invoiceNumber + '<br>';

    if(senelecBillArr[billIndex].issueDate != "null" && senelecBillArr[billIndex].issueDate != ""){

     billHTML += '<span style="color: #004d95;">' + getValidationMSGLocale("SENELEC_BILL_DATE") + '</span>' + (senelecBillArr[billIndex].issueDate).split(" ")[0] + '<br>';

    }
    else{

     billHTML += '<span style="color: #004d95;">' + getValidationMSGLocale("SENELEC_BILL_DATE") + '</span>NA<br>';

    }


    billHTML += '<span style="color: #004d95;">' + getValidationMSGLocale("SENELEC_BILL_POLICE") + '</span>' + senelecBillArr[billIndex].custmerReference + '<br><br>';

    billHTML += '<span style="color: #004d95;">' + getValidationMSGLocale("SENELEC_BILL_NAME") + '</span><br>' + senelecBillArr[billIndex].name + '<br><br>';
    billHTML += '<span style="color: #004d95;">' + getValidationMSGLocale("SENELEC_BILL_ADDRESS") + '</span><br>' + senelecBillArr[billIndex].address;

    billHTML += '</td>';
    billHTML += '</tr>';
    billHTML += '</table>';
    billHTML += '</td>';
    billHTML += '</tr>';

    billHTML += '<tr class="information">';
    billHTML += '<td colspan="2">';
    billHTML += '<table style="text-align:center;">';
    billHTML += '<tr>';
    billHTML += '<td><span style="color: #004d95;">' + getValidationMSGLocale("SENELEC_DELIVERY_ADDRESS") + '</span><br>' + senelecBillArr[billIndex].address + '<br></td>';
    billHTML += '</tr>';
    billHTML += '</table>';
    billHTML += '</td>';
    billHTML += '</tr>';

    billHTML += '<tr class="heading"><td colspan="2" align="center">' + getValidationMSGLocale("SENELEC_BILL_ITEMS") + '</td></tr>';

    billHTML += '<tr class="item"><td>' + getValidationMSGLocale("SENELEC_PERIOD_FROM") + '</td><td>NA</td></tr>';
    billHTML += '<tr class="item"><td>' + getValidationMSGLocale("SENELEC_PERIOD_TO") + '</td><td>NA</td></tr>';
    billHTML += '<tr class="item"><td>' + getValidationMSGLocale("SENELEC_BILL_NOOFDAYS") + '</td><td>NA</td></tr>';

    billHTML += '<tr class="item last"><td>' + getValidationMSGLocale("SENELEC_BILL_AMOUNT") + '</td><td>' + senelecBillArr[billIndex].amount + '</td></tr>';
    billHTML += '<tr class="item remove_br"><td>' + getValidationMSGLocale("SENELEC_BILL_FEE") + '<br/><span style="font-weight:normal;font-size:11px;margin-top:-10px;">' + getValidationMSGLocale("SENELEC_BILL_FEE_SUB") + '</span></td><td>' + senelecBillArr[billIndex].cashPaymentFee + '</td></tr>';
    //billHTML += '<tr class="item feesub"><td>' + getValidationMSGLocale("SENELEC_BILL_FEE_SUB") + '</td><td></td></tr>';
    billHTML += '</table>';
    //console.log("billHTML-->"+billHTML);
    $("#invoice-box").html(billHTML);
    $("#senelecSelfPayBtn").attr("amount", senelecBillArr[billIndex].amount);
    $("#senelecSelfPayBtn").attr("custmerReference", senelecBillArr[billIndex].custmerReference);
    $("#senelecSelfPayBtn").attr("invoiceNumber", senelecBillArr[billIndex].invoiceNumber);
    $("#senelecSelfPayBtn").attr("billID", senelecBillArr[billIndex].id);

    openPage("SenelecBillDetail");

}

function openSenelecRequestPage(){
  openPage("SenelecRequestTo");
}

function validateSenelecRequestTo(){

  var SenelecRequestTo_MobNo = $.trim($("#SenelecRequestTo_MobNo").val());

  if (PhoneNumberValidation(SenelecRequestTo_MobNo) != true) {
          displayToastNotifications(PhoneNumberValidation(SenelecRequestTo_MobNo));
  }
  else {

     senelecPostpaidPayment("SRTP", SenelecRequestTo_MobNo);

  }
}
function senelecPostpaidPayment(fnType, requestedToNumber){
      wpFieldArr = [];
      var Sname = $("#senelecSelfPayBtn").attr("Sname");
      var SId = $("#senelecSelfPayBtn").attr("SId");
      var ttType = $("#senelecSelfPayBtn").attr("ttType");
      var payMode = $("#senelecSelfPayBtn").attr("payMode");
      var amount = $("#senelecSelfPayBtn").attr("amount");
      var custmerReference = $("#senelecSelfPayBtn").attr("custmerReference");
      var invoiceNumber = $("#senelecSelfPayBtn").attr("invoiceNumber");
      var postpaidInvoiceId = $("#senelecSelfPayBtn").attr("billID");

      wpFieldArr.push({elementName: getValidationMSGLocale("Payment_Type_CNFM"), elementValue: Sname});

      if(requestedToNumber){
       wpFieldArr.push({elementName:getValidationMSGLocale("WP_REQUESTED_TO"), elementValue: requestedToNumber});
      }

      wpFieldArr.push({elementName:getValidationMSGLocale("WP_CUSTOMER_REFERENCE"), elementValue: custmerReference});
      wpFieldArr.push({elementName:getValidationMSGLocale("WP_INVOICE_NUMBER"), elementValue: invoiceNumber});

      var requestXML = '<?xml version="1.0" encoding="UTF-8" ?><Request fromCustmer="' + localStorage.mCustomerID + '" isLocal="' + localStorage.isLocal + '" addBeneficiary="false" nickName=""';
      if(requestedToNumber){
         requestXML += ' requestedTo="' + requestedToNumber + '"';
      }
       requestXML += ' ttType="' + ttType + '" amount="' + amount + '" transferTypeId="' + SId + '" reverse="false" FN="' + fnType + '" invoiceNumber="' + invoiceNumber + '" custmerReference="' + custmerReference + '" postpaidInvoiceId="' + postpaidInvoiceId + '"></Request>';

      var txnFeeUrl = '<?xml version="1.0" encoding="UTF-8" ?><Request fromCustmer="' + localStorage.mCustomerID + '" isLocal="' + localStorage.isLocal + '" addBeneficiary="false" nickName=""';
      if(requestedToNumber){
        txnFeeUrl += ' requestedTo="' + requestedToNumber + '"';
      }
      txnFeeUrl += ' ttType="' + ttType + '" amount="' + amount + '" transferTypeId="' + SId + '" reverse="false" FN="GPD" invoiceNumber="' + invoiceNumber + '" custmerReference="' + custmerReference + '" postpaidInvoiceId="' + postpaidInvoiceId + '"></Request>';
  $("#WP_backBtn").attr("LastPage", "SenelecBillDetail");
  walletConfirmPage(requestXML, false, "HomePage", wpFieldArr, txnFeeUrl, payMode, fnType);
}

function senelacSelfPayment(){

  senelecPostpaidPayment("WP", null);

}

/********************************************** water bill payment flow *****************************************/
function waterRefPage(isSelf){

 openPage("WaterServicePage");

 if(isSelf == "true"){
   $("#WaterRefMsg_msg").text(getValidationMSGLocale("WATER_SELF_MSG"));
 }
 else{
   $("#WaterRefMsg_msg").text(getValidationMSGLocale("WATER_OTHER_MSG"));
 }

 if(isSelf == "true" && localStorage.waterReference != null){
    $("#waterReference").val(localStorage.waterReference);
 }

}

function displayWaterBillDetail(itemIndex){

var waterBillObject = senelecBillArr[itemIndex];
var clientName = "NA";

if(waterBillObject.firstName){
  clientName = waterBillObject.firstName;
}

if(waterBillObject.lastName){
  clientName +=" " + waterBillObject.lastName;
}
clientName = clientName.toUpperCase();

$("#Water-billbox").html('');
var billHTML = '<table cellpadding="0" cellspacing="0">';

    billHTML += '<tr class="top">';
    billHTML += '<td colspan="2">';
    billHTML += '<table style="text-align:center;">';

    billHTML += '<tr><td class="title">';
    billHTML += '<img src="img/SenEau_bill_icon.png" style="width:100%; max-width:120px;">';
    billHTML += '</td></tr>';

    billHTML += '<tr>';
    billHTML += '<td><span style="color:#ce0316; font-weight:700;">' + getValidationMSGLocale("SENELEC_BILL_DUEDATE") + '</span>' + waterBillObject.dueDate + '<br><br>';

    billHTML += '<span style="color: #004d95;">' + getValidationMSGLocale("SENELEC_BILL_INVOICENO") + '</span>' + waterBillObject.invoiceNumber + '<br>';

    //billHTML += '<span style="color: #004d95;">' + getValidationMSGLocale("SENELEC_BILL_DATE") + '</span>' + waterBillObject.issueDate + '<br>';

    billHTML += '<span style="color: #004d95;">' + getValidationMSGLocale("WATER_BILL_REFERENCENo") + '</span>' + waterBillObject.custmerReference + '<br><br>';

    billHTML += '<span style="color: #004d95;">' + getValidationMSGLocale("SENELEC_BILL_NAME") + '</span><br>' + clientName + '<br><br>';
    //billHTML += '<span style="color: #004d95;">' + getValidationMSGLocale("SENELEC_BILL_ADDRESS") + '</span><br>' + waterBillObject.location;

    billHTML += '</td>';
    billHTML += '</tr>';
    billHTML += '</table>';
    billHTML += '</td>';
    billHTML += '</tr>';

    billHTML += '<tr class="heading"><td colspan="2" align="center">' + getValidationMSGLocale("SENELEC_BILL_ITEMS") + '</td></tr>';

    //billHTML += '<tr class="item"><td>' + getValidationMSGLocale("SENELEC_PERIOD_FROM") + '</td><td>' + waterBillObject.dateFrom + '</td></tr>';
    //billHTML += '<tr class="item"><td>' + getValidationMSGLocale("SENELEC_PERIOD_TO") + '</td><td>' + waterBillObject.dateTo + '</td></tr>';
    //billHTML += '<tr class="item"><td>' + getValidationMSGLocale("SENELEC_BILL_NOOFDAYS") + '</td><td>' + waterBillObject.noOFDays + '</td></tr>';

    billHTML += '<tr class="item"><td>' + getValidationMSGLocale("WATER_BILL_AMOUNTTTC") + '</td><td>' + waterBillObject.totalAmount + '</td></tr>';
    //billHTML += '<tr class="item"><td>' + getValidationMSGLocale("WATER_BILL_AMOUNTSOLDE") + '</td><td>' + waterBillObject.charges + '</td></tr>';
    billHTML += '<tr class="item last"><td>' + getValidationMSGLocale("WATER_BILL_TOTAL") + '</td><td>' + waterBillObject.totalAmount + '</td></tr>';

    billHTML += '<tr class="item remove_br"><td>' + getValidationMSGLocale("SENELEC_BILL_FEE") + '<br/><span style="font-weight:normal;font-size:9px;margin-top:-10px;">' + getValidationMSGLocale("SENELEC_BILL_FEE_SUB") + '</span></td><td>0</td></tr>';

    billHTML += '</table>';
    //console.log("billHTML-->"+billHTML);
    $("#Water-billbox").html(billHTML);

    $("#WaterSelfPayBtn").attr("amount", waterBillObject.totalAmount);
    $("#WaterSelfPayBtn").attr("custmerReference", waterBillObject.custmerReference);
    $("#WaterSelfPayBtn").attr("invoiceNumber", waterBillObject.invoiceNumber);
    $("#WaterSelfPayBtn").attr("billID", waterBillObject.id);

    openPage("WaterBillDetail");

}

function waterServiceBack(){

    if(localStorage.Subtype == "AGENTS"){
      displayHomePage();
    }
    else{
     openPage("WaterSelfOther");
    }

}

function validateWaterBillReference(){

      $("#WaterBillList").html('');
      senelecBillArr = [];

      var custmerReference = $.trim($("#waterReference").val());

      if (!custmerReference) {
          displayToastNotifications(getValidationMSGLocale("WATER_REFNO_NULL"));
      }
      else if(custmerReference.length < 10){
       displayToastNotifications(getValidationMSGLocale("WATER_REFNO_LENGTHVAL"));
      }
      else {

          if (isConnectionAvailable() === true) {

              $("#Payments_Loading").show();

              var requestXML = '<?xml version="1.0" encoding="UTF-8" ?><Request FN="WEPPOI" fromCustmer="' + localStorage.mCustomerID + '" PIN="' + localStorage.mPIN + '" waterCustmerReference="' + custmerReference + '"></Request>';
              makeAJAXCall(requestXML, "POST", "xml", pullListOfWaterBillsSuccessCall, pullListOfWaterBillsErrorCall);

          }
      }

      function pullListOfWaterBillsSuccessCall(ResponseXML) {
          var responseObj = $.xml2json(ResponseXML);
          printLogMessages("pullListOfWaterBillsSuccessCall-->" + JSON.stringify(responseObj));
          $("#Payments_Loading").hide();

          if (responseObj.ResponseStatus == "success") {
               localStorage.waterReference = custmerReference;
               var ResponseMessageObj = responseObj.ResponseMessage;

               if(ResponseMessageObj.hasOwnProperty("invoices")){
                  var invoicesListObj = ResponseMessageObj.invoices;

                  if(invoicesListObj.hasOwnProperty("invoice")){

                    var invoiceObj = invoicesListObj.invoice;

                    var dynamicHTMl = '';


                    dynamicHTMl += '<table width="100%" cellspacing="0" border="1" cellpadding="0">';
                    dynamicHTMl += '<col width="33%"><col width="20%"><col width="23%"><col width="25%">';

                    if (typeof(invoiceObj.length) != "undefined") {
                      console.log("loop h bhhai");
                     for (var i = 0; i < invoiceObj.length; i++) {

                         var billPeriodFrom = $.trim(invoiceObj[i].billPeriodFrom);
                         if(!billPeriodFrom || billPeriodFrom == "null"){
                           billPeriodFrom = "NA";
                         }

                        var billPeriodTo = $.trim(invoiceObj[i].billPeriodTo);
                        if(!billPeriodTo || billPeriodTo == "null"){
                          billPeriodTo = "NA";
                        }

                        var dueDate = $.trim(invoiceObj[i].dueDate);
                        if(!dueDate || dueDate == "null"){
                          dueDate = "NA";
                        }

                       dynamicHTMl += '<tr>';
                       dynamicHTMl += '<td><span class="gray_fontSpan">' + getValidationMSGLocale("SENELEC_BILLLIST_INVOICENO") + '</span><span class="blue_fontSpan">' +  invoiceObj[i].invoiceNumber + '</span></td>';
                       //dynamicHTMl += '<td><span class="gray_fontSpan">' + getValidationMSGLocale("SENELEC_BILLLIST_PERIODFROM") + '</span><span class="blue_fontSpan">' +  billPeriodFrom  + '<br/><span style="color:#7e7c7f;">' + getValidationMSGLocale("SENELEC_BILLLIST_PERIODTO") + '</span><br/>' +  billPeriodTo + '</span></td>';
                       dynamicHTMl += '<td><span class="gray_fontSpan">' + getValidationMSGLocale("SENELEC_BILLLIST_AMOUNT") + '</span><span class="blue_fontSpan">' +  invoiceObj[i].totalAmount + '</span></td>';
                       dynamicHTMl += '<td><span class="gray_fontSpan">' + getValidationMSGLocale("SENELEC_BILLLIST_DUEDATE") + '</span><span class="blue_fontSpan">' +  dueDate + '</span></td>';
                       dynamicHTMl += '<td style="vertical-align: middle;font-size: 12px;"><input type="button" data-role="none" value="' + getValidationMSGLocale("SENELEC_BILLLIST_PAYBTN") + '" class="water_paybtn" onclick="displayWaterBillDetail(\'' + i + '\');" style="display:block;margin:auto;border-right:0px;"></td>';
                       dynamicHTMl += '</tr>';
                       senelecBillArr.push(invoiceObj[i]);

                     }

                    }
                    else{

                         var billPeriodFrom = $.trim(invoiceObj.billPeriodFrom);
                         if(!billPeriodFrom || billPeriodFrom == "null"){
                           billPeriodFrom = "NA";
                         }

                        var billPeriodTo = $.trim(invoiceObj.billPeriodTo);
                        if(!billPeriodTo || billPeriodTo == "null"){
                          billPeriodTo = "NA";
                        }
                        var dueDate = invoiceObj.dueDate;
                        if(!dueDate || dueDate == "null"){
                          dueDate = "NA";
                        }

                       dynamicHTMl += '<tr>';
                       dynamicHTMl += '<td style="word-wrap: break-word;word-break: break-all;white-space: normal;"><span class="gray_fontSpan">' + getValidationMSGLocale("SENELEC_BILLLIST_INVOICENO") + '</span><span class="blue_fontSpan">' +  invoiceObj.invoiceNumber + '</span></td>';
                       //dynamicHTMl += '<td><span class="gray_fontSpan">' + getValidationMSGLocale("SENELEC_BILLLIST_PERIODFROM") + '</span><span class="blue_fontSpan">' +  billPeriodFrom  + '<br/><span style="color:#7e7c7f;">' + getValidationMSGLocale("SENELEC_BILLLIST_PERIODTO") + '</span><br/>' +  billPeriodTo + '</span></td>';
                       dynamicHTMl += '<td><span class="gray_fontSpan">' + getValidationMSGLocale("SENELEC_BILLLIST_AMOUNT") + '</span><span class="blue_fontSpan">' +  invoiceObj.totalAmount + '</span></td>';
                       dynamicHTMl += '<td><span class="gray_fontSpan">' + getValidationMSGLocale("SENELEC_BILLLIST_DUEDATE") + '</span><span class="blue_fontSpan">' +  dueDate + '</span></td>';
                       dynamicHTMl += '<td style="vertical-align: middle;font-size: 12px;"><input type="button" data-role="none" value="' + getValidationMSGLocale("SENELEC_BILLLIST_PAYBTN") + '" class="water_paybtn" onclick="displayWaterBillDetail(0);" style="display:block;margin:auto;border-right:0px;"></td>';
                       dynamicHTMl += '</tr>';

                       senelecBillArr.push(invoiceObj);

                    }

                    dynamicHTMl += '</table>';

                  }
                  console.log("WaterBillList-->"+dynamicHTMl);
                  $("#WaterBillList").html(dynamicHTMl);
                  openPage("WaterBills");

               }

          } else {
              displayToastNotifications(responseObj.ResponseMessage);
          }

      }

      function pullListOfWaterBillsErrorCall() {
          $("#Payments_Loading").hide();
      }
}


function validateWaterRequestTo(){

    var WaterRequestTo_MobNo = $.trim($("#WaterRequestTo_MobNo").val());

    if (PhoneNumberValidation(WaterRequestTo_MobNo) != true) {
            displayToastNotifications(PhoneNumberValidation(WaterRequestTo_MobNo));
    }
    else {

       waterBillPayment("SRTP", WaterRequestTo_MobNo);

    }
}

function waterBillPayment(fnType, requestedToNumber){

      wpFieldArr = [];
      var Sname = $("#WaterSelfPayBtn").attr("Sname");
      var SId = $("#WaterSelfPayBtn").attr("SId");
      var ttType = $("#WaterSelfPayBtn").attr("ttType");
      var payMode = $("#WaterSelfPayBtn").attr("payMode");
      var amount = $("#WaterSelfPayBtn").attr("amount");
      var custmerReference = $("#WaterSelfPayBtn").attr("custmerReference");
      var invoiceNumber = $("#WaterSelfPayBtn").attr("invoiceNumber");
      var postpaidInvoiceId = $("#WaterSelfPayBtn").attr("billID");

      wpFieldArr.push({elementName: getValidationMSGLocale("Payment_Type_CNFM"), elementValue: Sname});

      if(requestedToNumber){
       wpFieldArr.push({elementName:getValidationMSGLocale("WP_REQUESTED_TO"), elementValue: requestedToNumber});
      }

      wpFieldArr.push({elementName:getValidationMSGLocale("WATER_CUSTOMER_REFERENCE"), elementValue: custmerReference});
      wpFieldArr.push({elementName:getValidationMSGLocale("WP_INVOICE_NUMBER"), elementValue: invoiceNumber});

      var requestXML = '<?xml version="1.0" encoding="UTF-8" ?><Request fromCustmer="' + localStorage.mCustomerID + '" isLocal="' + localStorage.isLocal + '" addBeneficiary="false" nickName=""';
      if(requestedToNumber){
         requestXML += ' requestedTo="' + requestedToNumber + '"';
      }
       requestXML += ' ttType="' + ttType + '" amount="' + amount + '" transferTypeId="' + SId + '" reverse="false" FN="' + fnType + '" invoiceNumber="' + invoiceNumber + '" waterCustmerReference="' + custmerReference + '" postpaidInvoiceId="' + postpaidInvoiceId + '"></Request>';

      var txnFeeUrl = '<?xml version="1.0" encoding="UTF-8" ?><Request fromCustmer="' + localStorage.mCustomerID + '" isLocal="' + localStorage.isLocal + '" addBeneficiary="false" nickName=""';
      if(requestedToNumber){
        txnFeeUrl += ' requestedTo="' + requestedToNumber + '"';
      }
      txnFeeUrl += ' ttType="' + ttType + '" amount="' + amount + '" transferTypeId="' + SId + '" reverse="false" FN="GPD" invoiceNumber="' + invoiceNumber + '" waterCustmerReference="' + custmerReference + '" postpaidInvoiceId="' + postpaidInvoiceId + '"></Request>';
      $("#WP_backBtn").attr("LastPage", "WaterBillDetail");
      walletConfirmPage(requestXML, false, "HomePage", wpFieldArr, txnFeeUrl, payMode, fnType);
}

function waterSelfPayment(){
  waterBillPayment("WP", null);
}
/********************************* forgot PIN flow ************************************************/

function validateForgotForm() {

    var ForgotPINMob_MobNo = $.trim($("#ForgotPINMob_MobNo").val());

    if(localStorage.mCustomerID){
      if(ForgotPINMob_MobNo != localStorage.mCustomerID){
        displayToastNotifications(getValidationMSGLocale("MOBNO_VALID"));
        return;
      }
    }

    if (PhoneNumberValidation(ForgotPINMob_MobNo) != true) {
        displayToastNotifications(PhoneNumberValidation(ForgotPINMob_MobNo));
    } else {
      //$("#forgotOTP_Btn").attr("fromCustomer", receiverMobNo);

      forgotSendOTP(ForgotPINMob_MobNo);

    }
}

function forgotSendOTP(receiverMobNo){

      printLogMessages("ForgotPINMob_MobNo--->"+receiverMobNo);

      if (isConnectionAvailable() === true) {

          $("#Payments_Loading").show();
          var requestXML = '<?xml version="1.0" encoding="UTF-8" ?><Request FN="SOTP" fromCustmer="' + receiverMobNo + '"></Request>';
          makeAJAXCall(requestXML, "POST", "xml", forgotSendOTPSuccessCall, forgotSendOTPErrorCall);

      }

      function forgotSendOTPSuccessCall(ResponseXML) {
          var responseObj = $.xml2json(ResponseXML);
          printLogMessages("sendOTPSuccessCall-->" + JSON.stringify(responseObj));
          $("#Payments_Loading").hide();

          if (responseObj.ResponseStatus == "success") {
              var ResponseMessageObj = (responseObj.ResponseMessage).split("-");
              displayMessageInAlertBox(ResponseMessageObj[0]);
              $("#forgotOTP_Btn").attr("fromCustomer", receiverMobNo);
              $("#forgotOTP_Btn").attr("AuthID", ResponseMessageObj[1]);
              openPage("forgotOTP");
              $("#forgotOTPMsg").text(getValidationMSGLocale("ACTIVATE_OTPTITLE_PRE") + receiverMobNo + getValidationMSGLocale("FORGOT_OTPTITLE_SUFFIX"));

          } else {
              displayMessageInAlertBox(responseObj.ResponseMessage);
          }

      }

      function forgotSendOTPErrorCall() {
          $("#Payments_Loading").hide();
      }
}

function forgotResendVOTP(){

  forgotSendOTP($("#forgotOTP_Btn").attr("fromCustomer"));

}

function validateForgotOTP() {

    var fromCustomer = $("#forgotOTP_Btn").attr("fromCustomer");
    printLogMessages("fromCustomer-->"+fromCustomer);
    //var AuthID = $("#AVOTP_Btn").attr("AuthID");

    var OTPValue = $("#forgotOTP_OTP").val();
    var validateFlag = true;
    if (!OTPValue) {
        displayToastNotifications(getValidationMSGLocale("OTP_EMPTY"));
        $("#forgotOTP_OTP").focus();
        validateFlag = false;
        return;
    }
    if (OTPValue.length < 4) {
        displayToastNotifications(getValidationMSGLocale("OTP_VALID_LEN"));
        $("#forgotOTP_OTP").focus();
        validateFlag = false;
        return;
    }
    if (!$.isNumeric(OTPValue)) {
        displayToastNotifications(getValidationMSGLocale("OTP_NUMERIC"));
        $("#forgotOTP_OTP").focus();
        validateFlag = false;
        return;
    }

    if (validateFlag == true) {
        if (isConnectionAvailable() === true) {
            $("#Payments_Loading").show();
            var requestXML = '<?xml version="1.0" encoding="UTF-8" ?><Request FN="VOTP" fromCustmer="' + fromCustomer + '" otp="' + OTPValue + '"  authId=""></Request>';

            makeAJAXCall(requestXML, "POST", "xml", validateForgotOTPSuccessCallback, validateForgotOTPErrorCallback);
        }
    }

    function validateForgotOTPSuccessCallback(ResponseXML) {
        var responseObj = $.xml2json(ResponseXML);
        printLogMessages("OTPAuthSuccessCallback-->" + JSON.stringify(responseObj));
        $("#Payments_Loading").hide();
        $("#forgotOTP_OTP").val("");
        if (responseObj.ResponseStatus == "success") {

             displayToastNotifications(responseObj.ResponseMessage);
             askForgotSecurityQ(fromCustomer);

        } else {
            displayToastNotifications(responseObj.ResponseMessage);
        }
    }

    function validateForgotOTPErrorCallback() {
        $("#forgotOTP_OTP").val("");
        $("#Payments_Loading").hide();
    }

}

function askForgotSecurityQ(LoginMobNo) {
    //openPage('ChangePIN');
    if (isConnectionAvailable() === true) {
        $("#Payments_Loading").show();
        var requestXML = '<?xml version="1.0" encoding="UTF-8" ?><Request FN="GETCUSTSQ" fromCustmer="' + LoginMobNo + '"></Request>';
        printLogMessages("requestXML askRandomSecurityQ-->" + requestXML);
        makeAJAXCall(requestXML, "POST", "xml", askForgotSecurityQSuccessCallback, askForgotSecurityQErrorCallback);
    }

    function askForgotSecurityQSuccessCallback(ResponseXML) {
        var responseObj = $.xml2json(ResponseXML);
        printLogMessages("askRandomSecurityQSuccessCallback-->" + JSON.stringify(responseObj));
        $("#Payments_Loading").hide();
        if (responseObj.ResponseStatus == "success") {
            printLogMessages("success ------");
            var ResponseMessageObj = responseObj.ResponseMessage;
            if (typeof(ResponseMessageObj.questions.question) != "undefined" && ResponseMessageObj.questions != "") {
                printLogMessages("typeof ------");
                var questionsArr = ResponseMessageObj.questions.question;
                if (questionsArr.length > 0) {
                    var randomNo = getRandomizer0to3();
                    //var randomNo = 3;
                    printLogMessages("randomNo-->" + randomNo);
                    $("#ForgotSingleQText").text(questionsArr[randomNo].value);
                    $("#ForgotSingleQAns").attr("singleQName", questionsArr[randomNo].name);
                    $("#ForgotSingleQAns").attr("LoginMobNo", LoginMobNo);
                }
                $(".set-pin").css("margin-top", "100px");
                $(".header_class").hide();
                $("#footer_div").hide();
                openPage("ForgotSingleQ");
            } else {
                displayToastNotifications(getValidationMSGLocale("ACC_NO_QUESTION"));
            }


        } else {

            displayToastNotifications(responseObj.ResponseMessage);
        }
    }

    function askForgotSecurityQErrorCallback() {
        $("#Payments_Loading").hide();
    }
}

function submitForgotQuestion() {
    //singleQAns
    var singleQAns = $.trim($("#ForgotSingleQAns").val());
    var singleQName = $("#ForgotSingleQAns").attr("singleQName");
    var LoginMobNo = $("#ForgotSingleQAns").attr("LoginMobNo");

    if (!singleQAns) {
        displayToastNotifications(getValidationMSGLocale("MULTIQ_ANS"));
        $("#ForgotSingleQAns").focus();
    } else {
        if (isConnectionAvailable() === true) {

            $("#Payments_Loading").show();

            var requestXML = '<?xml version="1.0" encoding="UTF-8" ?><Request FN="VERSQ" fromCustmer="' + LoginMobNo + '" lang="EN" ' + singleQName + '=' + '"' + singleQAns + '"' + '></Request>';
            printLogMessages("submitSingleQuestion requestXML-->" + requestXML);
            makeAJAXCall(requestXML, "POST", "xml", submitForgotQuestionSuccess, submitForgotQuestionError);

        }
    }

    function submitForgotQuestionSuccess(ResponseXML) {
        var responseObj = $.xml2json(ResponseXML);
        printLogMessages("submitSingleQuestionSuccess-->" + JSON.stringify(responseObj));
        $("#Payments_Loading").hide();
        $("#ForgotSingleQAns").val("");
        if (responseObj.ResponseStatus == "success") {

            displayToastNotifications(responseObj.ResponseMessage);
            $("#forgotSetPINBtn").attr("fromCustomer", LoginMobNo);
            $(".change-pin").css("margin-top", "65px");
            openPage("forgotSetPIN");

        } else {
            displayToastNotifications(responseObj.ResponseMessage);
        }

    }

    function submitForgotQuestionError() {
        $("#ForgotSingleQAns").val("");
        $("#Payments_Loading").hide();
    }

}

function forgotSetPINForm() {

    var forgotSetPIN_PIN = $.trim($("#forgotSetPIN_PIN").val());
    var forgotSetPIN_ConfirmPIN = $.trim($("#forgotSetPIN_ConfirmPIN").val());
    var fromCustomer = $("#forgotSetPINBtn").attr("fromCustomer");

    var validateFlag = true;
    if (PinValidation(forgotSetPIN_PIN) != true) {
        displayToastNotifications(PinValidation(forgotSetPIN_PIN));
        $("#forgotSetPIN_PIN").focus();
        validateFlag = false;
        return;
    }

    if (!forgotSetPIN_ConfirmPIN) {
        displayToastNotifications(getValidationMSGLocale("SETPIN_CONFIRM_EMPTY"));
        $("#forgotSetPIN_ConfirmPIN").focus();
        validateFlag = false;
        return;
    }
    if (forgotSetPIN_ConfirmPIN.length < 6) {
        displayToastNotifications(getValidationMSGLocale("SETPIN_CONFIRM_INVALID"));
        $("#forgotSetPIN_ConfirmPIN").focus();
        validateFlag = false;
        return;
    }
    if (!$.isNumeric(forgotSetPIN_ConfirmPIN)) {
        displayToastNotifications(getValidationMSGLocale("SETPIN_CONFIRM_INVALID"));
        $("#forgotSetPIN_ConfirmPIN").val("");
        $("#forgotSetPIN_ConfirmPIN").focus();
        validateFlag = false;
    }
    if (forgotSetPIN_ConfirmPIN != forgotSetPIN_PIN) {
        displayToastNotifications(getValidationMSGLocale("SETPIN_PIN_CPIN"));
        $("#forgotSetPIN_ConfirmPIN").val("");
        $("#forgotSetPIN_ConfirmPIN").focus();
        validateFlag = false;
        return;
    }

    if (validateFlag == true) {
        if (isConnectionAvailable() === true) {
            $("#Payments_Loading").show();
            var requestXML = '<?xml version="1.0" encoding="UTF-8" ?><Request FN="FTP" fromCustmer="' + fromCustomer + '" newPIN1="' + forgotSetPIN_PIN + '" newPIN2="' + forgotSetPIN_ConfirmPIN + '" FTL="true"></Request>';
            printLogMessages("requestXML pinset-->" + requestXML);
            makeAJAXCall(requestXML, "POST", "xml", forgotSetPINFormSuccessCallback, forgotSetPINFormErrorCallback);
        }
    }

    function forgotSetPINFormSuccessCallback(ResponseXML) {
        var responseObj = $.xml2json(ResponseXML);
        printLogMessages("OTPAuthSuccessCallback-->" + JSON.stringify(responseObj));

        if (responseObj.ResponseStatus == "success") {

            displayToastNotifications(responseObj.ResponseMessage);
            userLoginAfterSecurityQuestions(fromCustomer, forgotSetPIN_PIN);

            $("#forgotSetPIN_PIN").val("");
            $("#forgotSetPIN_ConfirmPIN").val("");

        } else {

           $("#Payments_Loading").hide();
           $("#forgotSetPIN_PIN").val("");
           $("#forgotSetPIN_ConfirmPIN").val("");
           displayToastNotifications(responseObj.ResponseMessage);

        }
    }

    function forgotSetPINFormErrorCallback() {
        $("#forgotSetPIN_PIN").val("");
        $("#forgotSetPIN_ConfirmPIN").val("");
        $("#Payments_Loading").hide();
    }

}

function forgotSubmitQCancelbtn() {
   displayLoginPage();
}

function openSenSelfOtherPage(){
 if(localStorage.Subtype == "AGENTS"){
   displayHomePage();
 }
 else{
   openPage('PostpaidSelfOther');
 }
}

function displayRechargeAmount(eleObject){
console.log("displayRechargeAmount-->");
  var rechargeAmtValue = $(eleObject).val();
  if(rechargeAmtValue != "0"){
    //$("#rechargeAmountMsg").text(rechargeAmtValue);
    //$("#rechargeAmountMsg").show();
  }

}

function getCountryCodeFromMobNo(contactNumber){
 var countryCode = null;
  try{
      var mobileNumberObj = parsePhone(contactNumber);
      countryCode = mobileNumberObj.countryCode;

  }
  catch(error){

  }

  return countryCode;
}

function appendHyphenInString(strVal){

  var maskedStr = "";
  if(strVal){
      maskedStr = strVal.split("-").join("");
      if (maskedStr.length > 0) {
        maskedStr = maskedStr.match(new RegExp('.{1,4}', 'g')).join("-");
      }
  }

  return maskedStr;

}

/********************************************** Aquatech bill payment flow *****************************************/
function AquatechRefPage(isSelf){

 openPage("AquatechServicePage");

 if(isSelf == "true"){
   $("#AquatechRefMsg_msg").text(getValidationMSGLocale("WATER_SELF_MSG"));
 }
 else{
   $("#AquatechRefMsg_msg").text(getValidationMSGLocale("WATER_OTHER_MSG"));
 }

 if(isSelf == "true" && localStorage.AquatechReference != null){
    $("#AquatechReference").val(localStorage.AquatechReference);
 }

}

function displayAquatechBillDetail(itemIndex){

var waterBillObject = senelecBillArr[itemIndex];
var clientName = "NA";

if(waterBillObject.name){
  clientName = waterBillObject.name;
}

clientName = clientName.toUpperCase();

var issueDate = "";
if(waterBillObject.hasOwnProperty("issueDate")){
  issueDate = waterBillObject.issueDate;
}

var billAddress = "";
if(waterBillObject.hasOwnProperty("address")){
 billAddress = waterBillObject.address;
}

var fromDate = "";
if(waterBillObject.hasOwnProperty("periodCoveredStartDate")){
 fromDate = waterBillObject.periodCoveredStartDate;
}

var toDate = "";
if(waterBillObject.hasOwnProperty("periodCoveredEndDate")){
 toDate = waterBillObject.periodCoveredEndDate;
}

var noOfDays = "";
if(waterBillObject.hasOwnProperty("noOfDays")){
 noOfDays = waterBillObject.noOfDays;
}

var fileAsText = "img/home_water_btn.png";
if($("#AquatechSelfPayBtn").attr("fileAsText")){
   fileAsText = "data:image/jpeg;base64," + $("#AquatechSelfPayBtn").attr("fileAsText");
}


$("#Aquatech-billbox").html('');
var billHTML = '<table cellpadding="0" cellspacing="0">';

    billHTML += '<tr class="top">';
    billHTML += '<td colspan="2">';
    billHTML += '<table style="text-align:center;">';

    billHTML += '<tr><td class="title">';
    billHTML += '<img src="' + fileAsText + '" style="width:100%; max-width:120px;">';
    billHTML += '</td></tr>';

    billHTML += '<tr>';
    billHTML += '<td><span style="color:#ce0316; font-weight:700;">' + getValidationMSGLocale("SENELEC_BILL_DUEDATE") + '</span>' + waterBillObject.dueDate + '<br><br>';

    billHTML += '<span style="color: #004d95;">' + getValidationMSGLocale("SENELEC_BILL_INVOICENO") + '</span>' + waterBillObject.invoiceNumber + '<br>';

    billHTML += '<span style="color: #004d95;">' + getValidationMSGLocale("SENELEC_BILL_DATE") + '</span>' + issueDate  + '<br>';

    billHTML += '<span style="color: #004d95;">' + getValidationMSGLocale("WATER_BILL_REFERENCENo") + '</span>' + waterBillObject.custmerReference + '<br><br>';

    billHTML += '<span style="color: #004d95;">' + getValidationMSGLocale("SENELEC_BILL_NAME") + '</span><br>' + clientName + '<br><br>';
    billHTML += '<span style="color: #004d95;">' + getValidationMSGLocale("SENELEC_BILL_ADDRESS") + '</span><br>' + billAddress;

    billHTML += '</td>';
    billHTML += '</tr>';
    billHTML += '</table>';
    billHTML += '</td>';
    billHTML += '</tr>';

    billHTML += '<tr class="heading"><td colspan="2" align="center">' + getValidationMSGLocale("SENELEC_BILL_ITEMS") + '</td></tr>';

    billHTML += '<tr class="item"><td>' + getValidationMSGLocale("SENELEC_PERIOD_FROM") + '</td><td>' + fromDate + '</td></tr>';
    billHTML += '<tr class="item"><td>' + getValidationMSGLocale("SENELEC_PERIOD_TO") + '</td><td>' + toDate + '</td></tr>';
    billHTML += '<tr class="item"><td>' + getValidationMSGLocale("SENELEC_BILL_NOOFDAYS") + '</td><td>' + noOfDays + '</td></tr>';

    billHTML += '<tr class="item last"><td>' + getValidationMSGLocale("SENELEC_BILL_AMOUNT") + '</td><td>' + waterBillObject.amount + '</td></tr>';
    billHTML += '<tr class="item remove_br"><td>' + getValidationMSGLocale("SENELEC_BILL_FEE") + '<br/><span style="font-weight:normal;font-size:11px;margin-top:-10px;">' + getValidationMSGLocale("SENELEC_BILL_FEE_SUB") + '</span></td><td>0</td></tr>';
    //billHTML += '<tr class="item feesub"><td>' + getValidationMSGLocale("SENELEC_BILL_FEE_SUB") + '</td><td></td></tr>';
    billHTML += '</table>';
    //console.log("billHTML-->"+billHTML);
    $("#Aquatech-billbox").html(billHTML);

    $("#AquatechSelfPayBtn").attr("amount", waterBillObject.amount);
    $("#AquatechSelfPayBtn").attr("custmerReference", waterBillObject.custmerReference);
    $("#AquatechSelfPayBtn").attr("invoiceNumber", waterBillObject.invoiceNumber);
    $("#AquatechSelfPayBtn").attr("billID", waterBillObject.id);

    openPage("AquatechBillDetail");

}

function AquatechServiceBack(){

    if(localStorage.Subtype == "AGENTS"){
      displayHomePage();
    }
    else{
     openPage("AquatechSelfOther");
    }

}

function validateAquatechBillReference(){

      $("#AquatechBillList").html('');
      senelecBillArr = [];

      var custmerReference = $.trim($("#AquatechReference").val());

      if (!custmerReference) {
          displayToastNotifications(getValidationMSGLocale("WATER_REFNO_NULL"));
      }
      else if(custmerReference.length < 6){
       displayToastNotifications(getValidationMSGLocale("WATER_REFNO_LENGTHVAL"));
      }
      else {

          if (isConnectionAvailable() === true) {

              $("#Payments_Loading").show();

              var businessPId = $("#AquatechSelfPayBtn").attr("SId");

              var requestXML = '<?xml version="1.0" encoding="UTF-8" ?><Request FN="OBS" fromCustmer="' + localStorage.mCustomerID + '" PIN="' + localStorage.mPIN + '" customerRef="' + custmerReference + '" bpId="' + businessPId + '"></Request>';
              makeAJAXCall(requestXML, "POST", "xml", pullListOfWaterBillsSuccessCall, pullListOfWaterBillsErrorCall);

          }
      }

      function pullListOfWaterBillsSuccessCall(ResponseXML) {
          var responseObj = $.xml2json(ResponseXML);
          printLogMessages("pullListOfWaterBillsSuccessCall-->" + JSON.stringify(responseObj));
          $("#Payments_Loading").hide();

          if (responseObj.ResponseStatus == "success") {
               localStorage.AquatechReference = custmerReference;
               var ResponseMessageObj = responseObj.ResponseMessage;

               if(ResponseMessageObj.hasOwnProperty("invoices")){
                  var invoicesListObj = ResponseMessageObj.invoices;

                  if(invoicesListObj.hasOwnProperty("invoice")){

                    var invoiceObj = invoicesListObj.invoice;

                    var dynamicHTMl = '';


                    dynamicHTMl += '<table width="100%" cellspacing="0" border="1" cellpadding="0">';
                    dynamicHTMl += '<col width="33%"><col width="20%"><col width="23%"><col width="25%">';

                    if (typeof(invoiceObj.length) != "undefined") {
                      console.log("loop h bhhai");
                     for (var i = 0; i < invoiceObj.length; i++) {


                        var dueDate = $.trim(invoiceObj[i].dueDate);
                        if(!dueDate || dueDate == "null"){
                          dueDate = "NA";
                        }

                       dynamicHTMl += '<tr>';
                       dynamicHTMl += '<td><span class="gray_fontSpan">' + getValidationMSGLocale("SENELEC_BILLLIST_INVOICENO") + '</span><span class="blue_fontSpan">' +  invoiceObj[i].invoiceNumber + '</span></td>';
                       //dynamicHTMl += '<td><span class="gray_fontSpan">' + getValidationMSGLocale("SENELEC_BILLLIST_PERIODFROM") + '</span><span class="blue_fontSpan">' +  billPeriodFrom  + '<br/><span style="color:#7e7c7f;">' + getValidationMSGLocale("SENELEC_BILLLIST_PERIODTO") + '</span><br/>' +  billPeriodTo + '</span></td>';
                       dynamicHTMl += '<td><span class="gray_fontSpan">' + getValidationMSGLocale("SENELEC_BILLLIST_AMOUNT") + '</span><span class="blue_fontSpan">' +  invoiceObj[i].amount + '</span></td>';
                       dynamicHTMl += '<td><span class="gray_fontSpan">' + getValidationMSGLocale("SENELEC_BILLLIST_DUEDATE") + '</span><span class="blue_fontSpan">' +  dueDate + '</span></td>';
                       dynamicHTMl += '<td style="vertical-align: middle;font-size: 12px;"><input type="button" data-role="none" value="' + getValidationMSGLocale("SENELEC_BILLLIST_PAYBTN") + '" class="water_paybtn" onclick="displayAquatechBillDetail(\'' + i + '\');" style="display:block;margin:auto;border-right:0px;"></td>';
                       dynamicHTMl += '</tr>';
                       senelecBillArr.push(invoiceObj[i]);

                     }

                    }
                    else{

                        var dueDate = invoiceObj.dueDate;
                        if(!dueDate || dueDate == "null"){
                          dueDate = "NA";
                        }

                       dynamicHTMl += '<tr>';
                       dynamicHTMl += '<td style="word-wrap: break-word;word-break: break-all;white-space: normal;"><span class="gray_fontSpan">' + getValidationMSGLocale("SENELEC_BILLLIST_INVOICENO") + '</span><span class="blue_fontSpan">' +  invoiceObj.invoiceNumber + '</span></td>';
                       //dynamicHTMl += '<td><span class="gray_fontSpan">' + getValidationMSGLocale("SENELEC_BILLLIST_PERIODFROM") + '</span><span class="blue_fontSpan">' +  billPeriodFrom  + '<br/><span style="color:#7e7c7f;">' + getValidationMSGLocale("SENELEC_BILLLIST_PERIODTO") + '</span><br/>' +  billPeriodTo + '</span></td>';
                       dynamicHTMl += '<td><span class="gray_fontSpan">' + getValidationMSGLocale("SENELEC_BILLLIST_AMOUNT") + '</span><span class="blue_fontSpan">' +  invoiceObj.amount + '</span></td>';
                       dynamicHTMl += '<td><span class="gray_fontSpan">' + getValidationMSGLocale("SENELEC_BILLLIST_DUEDATE") + '</span><span class="blue_fontSpan">' +  dueDate + '</span></td>';
                       dynamicHTMl += '<td style="vertical-align: middle;font-size: 12px;"><input type="button" data-role="none" value="' + getValidationMSGLocale("SENELEC_BILLLIST_PAYBTN") + '" class="water_paybtn" onclick="displayAquatechBillDetail(0);" style="display:block;margin:auto;border-right:0px;"></td>';
                       dynamicHTMl += '</tr>';

                       senelecBillArr.push(invoiceObj);

                    }

                    dynamicHTMl += '</table>';

                  }
                  console.log("AquatechBillList-->"+dynamicHTMl);
                  $("#AquatechBillList").html(dynamicHTMl);
                  openPage("AquatechBills");

               }

          } else {
              displayToastNotifications(responseObj.ResponseMessage);
          }

      }

      function pullListOfWaterBillsErrorCall() {
          $("#Payments_Loading").hide();
      }
}


function validateAquatechRequestTo(){

    var AquatechRequestTo_MobNo = $.trim($("#AquatechRequestTo_MobNo").val());

    if (PhoneNumberValidation(AquatechRequestTo_MobNo) != true) {
            displayToastNotifications(PhoneNumberValidation(AquatechRequestTo_MobNo));
    }
    else {

       AquatechBillPayment("SRTP", AquatechRequestTo_MobNo);

    }
}

function AquatechBillPayment(fnType, requestedToNumber){

      wpFieldArr = [];
      var Sname = $("#AquatechSelfPayBtn").attr("Sname");
      var SId = $("#AquatechSelfPayBtn").attr("SId");
      var ttType = $("#AquatechSelfPayBtn").attr("ttType");
      var payMode = $("#AquatechSelfPayBtn").attr("payMode");
      var amount = $("#AquatechSelfPayBtn").attr("amount");
      var custmerReference = $("#AquatechSelfPayBtn").attr("custmerReference");
      var invoiceNumber = $("#AquatechSelfPayBtn").attr("invoiceNumber");
      var postpaidInvoiceId = $("#AquatechSelfPayBtn").attr("billID");
      var fd = $("#AquatechSelfPayBtn").attr("fd");

      wpFieldArr.push({elementName: getValidationMSGLocale("Payment_Type_CNFM"), elementValue: Sname});

      if(requestedToNumber){
       wpFieldArr.push({elementName:getValidationMSGLocale("WP_REQUESTED_TO"), elementValue: requestedToNumber});
      }

      wpFieldArr.push({elementName:getValidationMSGLocale("WATER_CUSTOMER_REFERENCE"), elementValue: custmerReference});
      wpFieldArr.push({elementName:getValidationMSGLocale("WP_INVOICE_NUMBER"), elementValue: invoiceNumber});

      var requestXML = '<?xml version="1.0" encoding="UTF-8" ?><Request fromCustmer="' + localStorage.mCustomerID + '" isLocal="' + localStorage.isLocal + '" addBeneficiary="false" nickName=""';
      if(requestedToNumber){
         requestXML += ' requestedTo="' + requestedToNumber + '"';
      }
       requestXML += ' ttType="' + ttType + '" amount="' + amount + '" transferTypeId="' + SId + '" reverse="false" FN="' + fnType + '" invoiceNumber="' + invoiceNumber + '" customerRef="' + custmerReference + '" postpaidInvoiceId="' + postpaidInvoiceId + '" toCustmer="' + fd + '"></Request>';

      var txnFeeUrl = '<?xml version="1.0" encoding="UTF-8" ?><Request fromCustmer="' + localStorage.mCustomerID + '" isLocal="' + localStorage.isLocal + '" addBeneficiary="false" nickName=""';
      if(requestedToNumber){
        txnFeeUrl += ' requestedTo="' + requestedToNumber + '"';
      }
      txnFeeUrl += ' ttType="' + ttType + '" amount="' + amount + '" transferTypeId="' + SId + '" reverse="false" FN="GPD" invoiceNumber="' + invoiceNumber + '" customerRef="' + custmerReference + '" postpaidInvoiceId="' + postpaidInvoiceId + '" toCustmer="' + fd + '"></Request>';
      $("#WP_backBtn").attr("LastPage", "AquatechBillDetail");
      walletConfirmPage(requestXML, false, "HomePage", wpFieldArr, txnFeeUrl, payMode, fnType);
}

function AquatechSelfPayment(){
  AquatechBillPayment("WP", null);
}

