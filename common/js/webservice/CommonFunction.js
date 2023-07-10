var isToastVisible = false;
//var BASE_URL = "http://192.168.2.25:5151/zuulu";
//var UNREG_URL = "http://182.74.113.132:7080/pay/pay.html";

//var BASE_URL = "http://125.63.92.172:5151/zuulu";
// var BASE_URL = "http://194.187.94.199:5053/zuulu";
//var BASE_URL = "https://zuulu.net:5051/zuulu";
var BASE_URL = "https://dev.zuulu.net:5051/zuulu";

// var UNREG_URL = "http://125.63.92.172:2525/do/guestUserPage";
var timeout = 60000;
var isAJAXAlive = false;
var dataTable2Obj;
var dataTable3Obj;
var invoices = [];

// version="1.0" encoding="UTF-8" ?><Request FN="LNC" fromMember="2214010000" PIN="881188" fromType="M" osType="Android" deviceToken="undefined" updateDeviceToken="false" deviceModel="SM-E7000" devicePlatform="Android" deviceVersion="4.4.2" deviceManufacturer="samsung" packageName="com.zuulu.zuulu" versionNumber="1.0.11" isVirtualDevice="false" geoLatitude="" geoLongitude="" appClientName="Samba Diallo" appType="production" deviceIP="41.83.206.199" ipLocationCode="SN" uniqueDeviceKey="1585590508687" LN="FR"
var appInfo = {
    "deviceModel": "ZUULUBIZ",
    "devicePlatform": "ZUULUBIZ",
    "deviceVersion": "1.0.0",
    "deviceManufacturer": "ZUULUBIZ",
    "packageName": "com.zuulu.zuulu",
    "versionNumber": "1.0.11",
    "isVirtualDevice": false,
    "geoLatitude": "",
    "geoLongitude": "",
    "appClientName": "Samba Diallo",
    "appType": "production",
    "deviceIP": "41.83.206.199",
    "ipLocationCode": "SN",
    "reverse": "false",
    "isLocal": "true",
    "addBeneficiary": "false",
    "nickName": ""
}
// <?xml version="1.0" encoding="utf-8"?><Request deviceModel="ZUULUBIZ" devicePlatform="ZUULUBIZ" deviceVersion="1.0.0" deviceManufacturer="ZUULUBIZ" packageName="com.zuulu.zuulu" versionNumber="1.0.11" isVirtualDevice="false" geoLatitude="" geoLongitude="" appClientName="Samba Diallo" appType="production" ipLocationCode="SN" uniqueDeviceKey="42325819292526" transferTypeId="326" reverse="false" isLocal="true" ttType="R" LN="FR" FN="GPD" addBeneficiary="false" nickName="" mobNo="(+221) 78 115 63 35" amount="100" fromPartnerId="2214030000" fromCustmer="2214030000" PIN="281972"/>

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


function solde(lang, formCustmer, pin) {

    if (typeof (dataTable2Obj) != "undefined") {
        dataTable2Obj.destroy();
    }

    var listeDonsHTML = "";

    var montantTotalDons = parseFloat(0);

    var requestXML = '<?xml version="1.0" encoding="UTF-8" ?><Request  FN="BALP" fromPartnerId="' + formCustmer + '" fromCustmer="' + formCustmer + '" PIN="' + pin + '"></Request>';

    makeAJAXCallSolde(requestXML, "POST", "xml", loadDonsSuccess, loadDonsError);



    function loadDonsSuccess(ResponseXML) {
        // $("#servicePage_Loading").hide();
        var responseObj = $.xml2json(ResponseXML);


        if (responseObj.ResponseStatus == "success") {
            var ResponseMessageObj = responseObj.ResponseMessage;
            //  var res = JSON.stringify(ResponseMessageObj);
            //  alert(res);
            return ResponseMessageObj;
        } else {

            var ResponseMessageObj = responseObj.ResponseMessage;
            error.style['display'] = 'block';
            document.querySelector('#error').innerHTML = ResponseMessageObj;
            // alert(JSON.stringify(ResponseMessageObj,null,4));alert('nnnnnnok');
        }



    }

    function loadDonsError() {

       // alert("Erreur inattendue");

    }

}

function makeAJAXCallSolde(param, type, dataType, successCallback, errorCallback) {
    //printLogMessages("makeAJAXCall appInfo------>" + JSON.stringify(appInfo));
    // $("#footer_div").hide();
    //$(".header_class").hide();
    isAJAXAlive = true;
    if (param.indexOf('></Request>') != -1) {

        var requestXML = param.split('></Request>');
        var requestData = addDeviceParams(requestXML[0]);
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
        beforeSend: function () {

        },
        success: function (response) {
            isAJAXAlive = false;
            // console.log("response xml-->" + (new XMLSerializer()).serializeToString(response));
            var responseObj = $.xml2json(response);
            var compteEncaissement;
            var compteService;
            var comptePayroll;
            var solde;
            var temp = responseObj.ResponseMessage.split("|");
            for (i = 0; i < temp.length; i++) {
                var courant = temp[i];
                if (courant.indexOf("Services") != -1) {
                    compteService = courant.split(":")[1];
                    solde = courant.split(":")[1];
                    compteService = compteService.replace(/,[0-9]+/, '').replace(',', '.').trim();
                }
                else if (courant.indexOf("Encaissements") != -1) {
                    compteEncaissement = courant.split(":")[1];
                    compteEncaissement = compteEncaissement.replace(/,[0-9]+/, '').replace(',', '.').trim();
                }
                else if (courant.indexOf("Payroll") != -1) {
                    comptePayroll = courant.split(":")[1];
                    comptePayroll = comptePayroll.replace(/,[0-9]+/, '').replace(',', '.').trim();
                }
            }

            if(compteService === undefined){
                compteService = " ";
            }
            if(compteEncaissement === undefined){
                compteEncaissement = " ";
            }


            // document.querySelector('#soldeDisponible').innerHTML = compteService;
            // document.querySelector('#soldeEncaissement').innerHTML = compteEncaissement;
            // document.querySelector('#soldePrincipal').innerHTML = 'Solde disponible ' + compteService;
            // document.getElementById('soldeServiceInitial').value = compteService;
            // document.getElementById('soldeEncaissementInitial').value = compteEncaissement;
            // document.querySelector('#solde').innerHTML = solde;
            // alert("Compte Encaissement "+compteEncaissement+ " Compte Service "+compteService+ " Compte Payroll "+comptePayroll );

            if (responseObj.ResponseCode == "1212") {
                //openPage("AccountOTP");
                // $("#Payments_Loading").hide();
                // $("#servicePage_Loading").hide()
                // displayMultiLoginBox(responseObj.ResponseMessage);
                // alert(responseObj.ResponseMessage);


            } else {

                // if (localStorage.serviceFlag == "true") {
                // $("#footer_div").show();
                // }
                if (successCallback) {
                    successCallback(response);
                }

            }
        },
        error: function (x, t, m) {
            var responseObj = $.xml2json(x);
            //printLogMessages("responseObj error-->"+JSON.stringify(responseObj));
            isAJAXAlive = false;
            // if (localStorage.serviceFlag == "true") {
            // $("#footer_div").show();
            // }
            if (t === "timeout") {
            //    alert("Timeout");
                // displayToastNotifications(getValidationMSGLocale("TIMEOUT_ERROR"));
            } else {
                // displayToastNotifications(getValidationMSGLocale("ZUULU_SERVICE_ERROR"));
              //  alert("Service Error");
            }
            if (errorCallback) {
                errorCallback(x);
            }
        }

    });
}


function makeAJAXCall(param, type, dataType, successCallback, errorCallback, phone, phoneFormat) {
    //printLogMessages("makeAJAXCall appInfo------>" + JSON.stringify(appInfo));
    // $("#footer_div").hide();
    //$(".header_class").hide();
    isAJAXAlive = true;
    if (param.indexOf('></Request>') != -1) {

        var requestXML = param.split('></Request>');
        var requestData = addDeviceParams(requestXML[0]);
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
        beforeSend: function () {

        },
        success: function (response) {
            isAJAXAlive = false;
            // console.log("response xml-->" + (new XMLSerializer()).serializeToString(response));
            var responseObj = $.xml2json(response);
            var frais = responseObj.ResponseMessage.TransactionCharges.Charge.feeAmount;
            document.querySelector('#phone').innerHTML = phoneFormat;
            var amount = responseObj.ResponseMessage.Amount;
            document.querySelector('#amountconfirmation').innerHTML = responseObj.ResponseMessage.Amount;
            document.querySelector('#feeAmount').innerHTML = frais;
            document.querySelector('#totalconfirmation').innerHTML = responseObj.ResponseMessage.TotalAmount;
            document.getElementById('convertmontant').value = responseObj.ResponseMessage.TotalAmount;
            if (responseObj.ResponseCode == "1212") {
                //openPage("AccountOTP");
                // $("#Payments_Loading").hide();
                // $("#servicePage_Loading").hide()
                // displayMultiLoginBox(responseObj.ResponseMessage);
                // alert(responseObj.ResponseMessage);


            } else {

                // if (localStorage.serviceFlag == "true") {
                // $("#footer_div").show();
                // }
                if (successCallback) {
                    successCallback(response);
                }

            }
        },
        error: function (x, t, m) {
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

function loadDons(lang, numPhone, amount, phoneFormat, formCustmer, pin) {

    if (typeof (dataTable2Obj) != "undefined") {
        dataTable2Obj.destroy();
    }

    var listeDonsHTML = "";

    var montantTotalDons = parseFloat(0);

    var requestXML = '<?xml version="1.0" encoding="UTF-8" ?><Request mobNo="' + numPhone + '" ttType="R" transferTypeId="326" amount="' + amount + '" FN="GPD" fromPartnerId="' + formCustmer + '" fromCustmer="' + formCustmer + '" PIN="' + pin + '"></Request>';

    makeAJAXCall(requestXML, "POST", "xml", loadDonsSuccess, loadDonsError, numPhone, phoneFormat);



    function loadDonsSuccess(ResponseXML) {
        // $("#servicePage_Loading").hide();
        var responseObj = $.xml2json(ResponseXML);
        // printLogMessages("getAmountForCotisationSuccess-->" + JSON.stringify(responseObj));
        var achat = document.getElementById('achat');
        var confirmationachat = document.getElementById('confirmationachat');
        var error = document.getElementById('error');

        if (responseObj.ResponseStatus == "success") {
            achat.style['display'] = 'none';
            confirmationachat.style['display'] = 'block';
            var ResponseMessageObj = responseObj.ResponseMessage;
            // var res = JSON.stringify(ResponseMessageObj);
            // alert(res);
            return ResponseMessageObj;
        } else {

            var ResponseMessageObj = responseObj.ResponseMessage;
            error.style['display'] = 'block';
            document.querySelector('#error').innerHTML = ResponseMessageObj;
            // alert(JSON.stringify(ResponseMessageObj,null,4));alert('nnnnnnok');
        }



    }

    function loadDonsError() {

     //   alert("Erreur inattendue");

    }

}


function validationCredit(lang, numPhone, amount, amountFCFA, phoneFormat, formCustmer, pin) {

    if (typeof (dataTable2Obj) != "undefined") {
        dataTable2Obj.destroy();
    }

    var listeDonsHTML = "";

    var montantTotalDons = parseFloat(0);

    var requestXML = '<?xml version="1.0" encoding="UTF-8" ?><Request mobNo="' + numPhone + '" ttType="R" transferTypeId="326" amount="' + amount + '" fromPartnerId="' + formCustmer + '" FN="WP" fromCustmer="' + formCustmer + '" PIN="' + pin + '"></Request>';

    makeAJAXCallValider(requestXML, "POST", "xml", loadDonsSuccess, loadDonsError, numPhone, amount, amountFCFA, phoneFormat);



    function loadDonsSuccess(ResponseXML) {
        // $("#servicePage_Loading").hide();
        var responseObj = $.xml2json(ResponseXML);
        var res = responseObj.ResponseMessage;
        // printLogMessages("getAmountForCotisationSuccess-->" + JSON.stringify(responseObj));
        var achat = document.getElementById('achat');
        var confirmationachat = document.getElementById('confirmationachat');
        var validationachat = document.getElementById('validationachat');


        if (responseObj.ResponseStatus == "success") {
            var success = document.getElementById('success');
            var heure = responseObj.ResponseMessage.match(/\d{2}:\d{2}:\d{2}/)[0];
            var numeroTransaction = responseObj.ResponseMessage.match(/\d{3}-\d{7}-\d{2}/)[0];
            var type = "Achat Crédit";
            achat.style['display'] = 'none';
            confirmationachat.style['display'] = 'none';
            validationachat.style['display'] = 'block';
            success.style['display'] = 'block';
            document.getElementById("valider").style.visibility = "hidden";
            $.ajax({
                url: 'finance/confirmationCredit?code=acredit&amount=' + amount + '&phone=' + numPhone + '&type=' + type + '&transaction=' + numeroTransaction + '&heure=' + heure,
                method: 'POST',
                data: '',
                dataType: 'json',
            }).success(function (response) {

            });


            return ResponseMessageObj;
            alert('ok');
        } else {

            var ResponseMessageObj = responseObj.ResponseMessage;
            var ResponseMessageObj = responseObj.ResponseMessage;
            error.style['display'] = 'block';
            document.querySelector('#error').innerHTML = ResponseMessageObj;

            // alert(JSON.stringify(ResponseMessageObj,null,4));alert('nnnnnnok');
        }



    }

    function loadDonsError() {

       // alert("Erreur inattendue");

    }

}

function addDeviceParams(requestXML) {

    for (var item in appInfo) {
        requestXML += ' ' + item + '="' + appInfo[item] + '"';
    }

    requestXML += ' uniqueDeviceKey="42325819292526"';
    // if(localStorage.APP_LANG){
    // var app_lang = localStorage.APP_LANG;
    requestXML += ' LN="FR"';
    // }


    // printLogMessages("requestXML -->"+requestXML);
    return requestXML;
}

function getCurrentTiemstap() {

    if (localStorage.currentTime) {
        return localStorage.currentTime;
    } else {
        var Now = new Date();
        var currentTime = Now.getTime();
        localStorage.currentTime = currentTime;
        return currentTime;
    }

}

function makeAJAXCallValider(param, type, dataType, successCallback, errorCallback, numPhone, amount, amountFCFA, phoneFormat) {
    //printLogMessages("makeAJAXCall appInfo------>" + JSON.stringify(appInfo));
    // $("#footer_div").hide();
    //$(".header_class").hide();
    isAJAXAlive = true;
    if (param.indexOf('></Request>') != -1) {

        var requestXML = param.split('></Request>');
        var requestData = addDeviceParams(requestXML[0]);
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
        beforeSend: function () {

        },
        success: function (response) {
            isAJAXAlive = false;
            // console.log("response xml-->" + (new XMLSerializer()).serializeToString(response));
            var responseObj = $.xml2json(response);
            // alert(JSON.stringify(responseObj,null,4));
            var res = responseObj.ResponseMessage;

            var date = responseObj.ResponseMessage.match(/\d{2}\/\d{2}\/\d{4}/)[0];
            var heure = responseObj.ResponseMessage.match(/\d{2}:\d{2}:\d{2}/)[0];
            var numeroTransaction = responseObj.ResponseMessage.match(/\d{3}-\d{7}-\d{2}/)[0];

            // alert("**"+date+"$$$"+heure+"---"+numeroTransaction);
            document.querySelector('#phonevalidation').innerHTML = phoneFormat;
            document.querySelector('#idTransaction').innerHTML = numeroTransaction;
            document.querySelector('#dateTransaction').innerHTML = date;
            document.querySelector('#heureTransaction').innerHTML = heure;
            document.querySelector('#amountconfirmationvalidation').innerHTML = amountFCFA;
            if (responseObj.ResponseCode == "1212") {
                //openPage("AccountOTP");
                // $("#Payments_Loading").hide();
                // $("#servicePage_Loading").hide()
                // displayMultiLoginBox(responseObj.ResponseMessage);
                // alert(responseObj.ResponseMessage);


            } else {

                // if (localStorage.serviceFlag == "true") {
                // $("#footer_div").show();
                // }
                if (successCallback) {
                    successCallback(response);
                }

            }
        },
        error: function (x, t, m) {
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


/*********************** ORANGE MONEY ************************************/
function depotOrangeMoney(lang, amount, phoneFormat, formCustmer, pin) {
    if (typeof (dataTable2Obj) != "undefined") {
        dataTable2Obj.destroy();
    }

    var listeDonsHTML = "";

    var montantTotalDons = parseFloat(0);

    var requestXML = '<?xml version="1.0" encoding="UTF-8" ?><Request  FN="WP" fromType="M" transferTypeId="1176" mobNo="' + phoneFormat + '" amount="' + amount + '" fromPartnerId="' + formCustmer + '" fromCustmer="' + formCustmer + '" PIN="' + pin + '"></Request>';

    makeAJAXCalldepotOrangeMoney(requestXML, "POST", "xml", loadDonsSuccess, loadDonsError);



    function loadDonsSuccess(ResponseXML) {
        // $("#servicePage_Loading").hide();
        var responseObj = $.xml2json(ResponseXML);


        if (responseObj.ResponseStatus == "success") {
            var ResponseMessageObj = responseObj.ResponseMessage;
            return ResponseMessageObj;
        } else {

            var ResponseMessageObj = responseObj.ResponseMessage;
            error.style['display'] = 'block';
            document.querySelector('#error').innerHTML = ResponseMessageObj;
            // alert(JSON.stringify(ResponseMessageObj,null,4));alert('nnnnnnok');
        }



    }

    function loadDonsError() {

      //  alert("Erreur inattendue");

    }

}

function makeAJAXCalldepotOrangeMoney(param, type, dataType, successCallback, errorCallback) {
    //printLogMessages("makeAJAXCall appInfo------>" + JSON.stringify(appInfo));
    // $("#footer_div").hide();
    //$(".header_class").hide();
    isAJAXAlive = true;
    if (param.indexOf('></Request>') != -1) {

        var requestXML = param.split('></Request>');
        var requestData = addDeviceParams(requestXML[0]);
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
        beforeSend: function () {

        },
        success: function (response) {
            isAJAXAlive = false;
            // console.log("response xml-->" + (new XMLSerializer()).serializeToString(response));
            var responseObj = $.xml2json(response);
            var temp = responseObj.ResponseMessage.split("|");
            var ussd = responseObj.ResponseMessage.split('=')[3];
            var idtransaction = responseObj.TransactionId;
            document.querySelector('#msgussd').innerHTML = ussd;
            document.getElementById('idTransaction').value = idtransaction;

            if (responseObj.ResponseCode == "1212") {
                //openPage("AccountOTP");
                // $("#Payments_Loading").hide();
                // $("#servicePage_Loading").hide()
                // displayMultiLoginBox(responseObj.ResponseMessage);
                // alert(responseObj.ResponseMessage);


            } else {

                // if (localStorage.serviceFlag == "true") {
                // $("#footer_div").show();
                // }
                if (successCallback) {
                    successCallback(response);
                }

            }
        },
        error: function (x, t, m) {
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


/*********************** Paiement ORANGE MONEY ************************************/
function paiementOrangeMoney(lang, amount, phoneFormat, formCustmer, pin) {
    if (typeof (dataTable2Obj) != "undefined") {
        dataTable2Obj.destroy();
    }

    var listeDonsHTML = "";

    var montantTotalDons = parseFloat(0);

    var requestXML = '<?xml version="1.0" encoding="UTF-8" ?><Request  FN="WP" fromType="M" transferTypeId="1180" mobNo="' + phoneFormat + '" amount="' + amount + '" fromPartnerId="' + formCustmer + '" fromCustmer="' + formCustmer + '" PIN="' + pin + '"></Request>';
  console.log(requestXML);
    makeAJAXCallpaiementOrangeMoney(requestXML, "POST", "xml", loadDonsSuccess, loadDonsError);



    function loadDonsSuccess(ResponseXML) {
        // $("#servicePage_Loading").hide();
        var responseObj = $.xml2json(ResponseXML);


        if (responseObj.ResponseStatus == "success") {
            var ResponseMessageObj = responseObj.ResponseMessage;
            return ResponseMessageObj;
        } else {

            var ResponseMessageObj = responseObj.ResponseMessage;
            error.style['display'] = 'block';
            document.querySelector('#error').innerHTML = ResponseMessageObj;
            // alert(JSON.stringify(ResponseMessageObj,null,4));alert('nnnnnnok');
        }



    }

    function loadDonsError() {

      //  alert("Erreur inattendue");

    }

}

function makeAJAXCallpaiementOrangeMoney(param, type, dataType, successCallback, errorCallback) {
    //printLogMessages("makeAJAXCall appInfo------>" + JSON.stringify(appInfo));
    // $("#footer_div").hide();
    //$(".header_class").hide();
    isAJAXAlive = true;
    if (param.indexOf('></Request>') != -1) {

        var requestXML = param.split('></Request>');
        var requestData = addDeviceParams(requestXML[0]);
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
        beforeSend: function () {

        },
        success: function (response) {
            isAJAXAlive = false;
            // console.log("response xml-->" + (new XMLSerializer()).serializeToString(response));
            var responseObj = $.xml2json(response); console.log(responseObj);
            var temp = responseObj.ResponseMessage.split("|");
            var ussd = responseObj.ResponseMessage.split('=')[3]; console.log("-ussd--"+ussd);
            document.querySelector('#msgussd').innerHTML = ussd;
            var idtransaction = responseObj.TransactionId;
            document.getElementById('idTransaction').value = idtransaction;

            if (responseObj.ResponseCode == "1212") {
                //openPage("AccountOTP");
                // $("#Payments_Loading").hide();
                // $("#servicePage_Loading").hide()
                // displayMultiLoginBox(responseObj.ResponseMessage);
                // alert(responseObj.ResponseMessage);


            } else {

                // if (localStorage.serviceFlag == "true") {
                // $("#footer_div").show();
                // }
                if (successCallback) {
                    successCallback(response);
                }

            }
        },
        error: function (x, t, m) {
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




/*********************** Paiement ORANGE MONEY PARTENAIRE ************************************/
function paiementOrangeMoneyOrganisation(lang, amount, phoneFormat, formCustmer, pin) {
    if (typeof (dataTable2Obj) != "undefined") {
        dataTable2Obj.destroy();
    }

    var listeDonsHTML = "";

    var montantTotalDons = parseFloat(0);

    var requestXML = '<?xml version="1.0" encoding="UTF-8" ?><Request  FN="WP" fromType="M" transferTypeId="1187" mobNo="' + phoneFormat + '" amount="' + amount + '" fromPartnerId="' + formCustmer + '" fromCustmer="' + formCustmer + '" PIN="' + pin + '"></Request>';
  console.log(requestXML);
    makeAJAXCallpaiementOrangeMoneyOrganisation(requestXML, "POST", "xml", loadDonsSuccess, loadDonsError);



    function loadDonsSuccess(ResponseXML) {
        // $("#servicePage_Loading").hide();
        var responseObj = $.xml2json(ResponseXML);


        if (responseObj.ResponseStatus == "success") {
            var ResponseMessageObj = responseObj.ResponseMessage;
            return ResponseMessageObj;
        } else {

            var ResponseMessageObj = responseObj.ResponseMessage;
            error.style['display'] = 'block';
            document.querySelector('#error').innerHTML = ResponseMessageObj;
            // alert(JSON.stringify(ResponseMessageObj,null,4));alert('nnnnnnok');
        }



    }

    function loadDonsError() {

      //  alert("Erreur inattendue");

    }

}

function makeAJAXCallpaiementOrangeMoneyOrganisation(param, type, dataType, successCallback, errorCallback) {
    //printLogMessages("makeAJAXCall appInfo------>" + JSON.stringify(appInfo));
    // $("#footer_div").hide();
    //$(".header_class").hide();
    isAJAXAlive = true;
    if (param.indexOf('></Request>') != -1) {

        var requestXML = param.split('></Request>');
        var requestData = addDeviceParams(requestXML[0]);
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
        beforeSend: function () {

        },
        success: function (response) {
            isAJAXAlive = false;
            // console.log("response xml-->" + (new XMLSerializer()).serializeToString(response));
            var responseObj = $.xml2json(response); console.log(responseObj);
            var temp = responseObj.ResponseMessage.split("|");
            var ussd = responseObj.ResponseMessage.split('=')[3]; console.log("-ussd--"+ussd);
            document.querySelector('#msgussd').innerHTML = ussd;
            var idtransaction = responseObj.TransactionId;
            document.getElementById('idTransaction').value = idtransaction;

            if (responseObj.ResponseCode == "1212") {
                //openPage("AccountOTP");
                // $("#Payments_Loading").hide();
                // $("#servicePage_Loading").hide()
                // displayMultiLoginBox(responseObj.ResponseMessage);
                // alert(responseObj.ResponseMessage);


            } else {

                // if (localStorage.serviceFlag == "true") {
                // $("#footer_div").show();
                // }
                if (successCallback) {
                    successCallback(response);
                }

            }
        },
        error: function (x, t, m) {
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





/**************************************** Transfert Interne ******************************************************* */

function makeAJAXCallInterne(param, type, dataType, successCallback, errorCallback) {
    //printLogMessages("makeAJAXCall appInfo------>" + JSON.stringify(appInfo));
    // $("#footer_div").hide();
    //$(".header_class").hide();
    isAJAXAlive = true;
    if (param.indexOf('></Request>') != -1) {

        var requestXML = param.split('></Request>');
        var requestData = addDeviceParams(requestXML[0]);
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
        beforeSend: function () {

        },
        success: function (response) {
            isAJAXAlive = false;
            // console.log("response xml-->" + (new XMLSerializer()).serializeToString(response));
            var responseObj = $.xml2json(response);
            var frais = responseObj.ResponseMessage.TransactionCharges.Charge.feeAmount;
            var amount = responseObj.ResponseMessage.Amount;
            document.querySelector('#amountconfirmation').innerHTML = responseObj.ResponseMessage.Amount;
            document.querySelector('#feeAmount').innerHTML = frais;
            document.querySelector('#totalconfirmation').innerHTML = responseObj.ResponseMessage.TotalAmount;
            document.getElementById('convertmontant').value = responseObj.ResponseMessage.TotalAmount;
            if (responseObj.ResponseCode == "1212") {
                //openPage("AccountOTP");
                // $("#Payments_Loading").hide();
                // $("#servicePage_Loading").hide()
                // displayMultiLoginBox(responseObj.ResponseMessage);
                // alert(responseObj.ResponseMessage);


            } else {

                // if (localStorage.serviceFlag == "true") {
                // $("#footer_div").show();
                // }
                if (successCallback) {
                    successCallback(response);
                }

            }
        },
        error: function (x, t, m) {
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

function transfertInterne(lang, amount, formCustmer, pin) {

    if (typeof (dataTable2Obj) != "undefined") {
        dataTable2Obj.destroy();
    }

    var listeDonsHTML = "";

    var montantTotalDons = parseFloat(0);

    var requestXML = '<?xml version="1.0" encoding="UTF-8" ?><Request mobNo="' + formCustmer + '" ttType="R" transferTypeId="1156" amount="' + amount + '"  FN="GPD" fromPartnerId="' + formCustmer + '" fromCustmer="' + formCustmer + '" PIN="' + pin + '"></Request>';
    makeAJAXCallInterne(requestXML, "POST", "xml", loadDonsSuccess, loadDonsError);



    function loadDonsSuccess(ResponseXML) {
        // $("#servicePage_Loading").hide();
        var responseObj = $.xml2json(ResponseXML);
        var interfaceInterne = document.getElementById('interfaceInterne');
        var confirmationInterne = document.getElementById('confirmationInterne');

        if (responseObj.ResponseStatus == "success") {
            interfaceInterne.style['display'] = 'none';
            confirmationInterne.style['display'] = 'block';
            var ResponseMessageObj = responseObj.ResponseMessage;
            return ResponseMessageObj;
        } else {

            // var ResponseMessageObj = responseObj.ResponseMessage;
            // error.style['display'] = 'block';
            // document.querySelector('#error').innerHTML = ResponseMessageObj;
            // alert(JSON.stringify(ResponseMessageObj,null,4));alert('nnnnnnok');
        }



    }

    function loadDonsError() {

        //alert("Erreur inattendue");

    }

}


function validationInterne(lang, amount, formCustmer, pin) {

    if (typeof (dataTable2Obj) != "undefined") {
        dataTable2Obj.destroy();
    }

    var listeDonsHTML = "";

    var montantTotalDons = parseFloat(0);

    var requestXML = '<?xml version="1.0" encoding="UTF-8" ?><Request mobNo="' + formCustmer + '" ttType="R" transferTypeId="1156" amount="' + amount + '" fromPartnerId="' + formCustmer + '" FN="WP" fromCustmer="' + formCustmer + '" PIN="' + pin + '"></Request>';
    makeAJAXCallValiderInterne(requestXML, "POST", "xml", loadDonsSuccess, loadDonsError);



    function loadDonsSuccess(ResponseXML) {
        // $("#servicePage_Loading").hide();
        var responseObj = $.xml2json(ResponseXML);
        var res = responseObj.ResponseMessage;
        // printLogMessages("getAmountForCotisationSuccess-->" + JSON.stringify(responseObj));
        var confirmationInterne = document.getElementById('confirmationInterne');
        var interfaceInterne = document.getElementById('interfaceInterne');
        var validertransfertInterne = document.getElementById('validertransfertInterne');


        if (responseObj.ResponseStatus == "success") {
            var success = document.getElementById('success');
            var heure = responseObj.ResponseMessage.match(/\d{2}:\d{2}:\d{2}/)[0];
            var numeroTransaction = responseObj.ResponseMessage.match(/\d{3}-\d{7}-\d{2}/)[0];
            var type = "interne";
            var description = "Transfert Interne";
            var initiateur = "Compte Encaissement";
            var destinataire = "Compte Service";
            var statut = "VALIDATED";
            confirmationInterne.style['display'] = 'none';
            interfaceInterne.style['display'] = 'none';
            validertransfertInterne.style['display'] = 'block';
            success.style['display'] = 'block';
            $.ajax({
                url: 'depot/confirmationinterne?amount=' + amount + '&initiateur=' + initiateur + '&type=' + type + '&transaction=' + numeroTransaction + '&destinataire=' + destinataire + '&statut=' + statut + '&description=' + description,
                method: 'POST',
                data: '',
                dataType: 'json',
            }).success(function (response) {

            });


            return ResponseMessageObj;
            alert('ok');
        } else {

            var ResponseMessageObj = responseObj.ResponseMessage;
            var ResponseMessageObj = responseObj.ResponseMessage;
            error.style['display'] = 'block';
            document.querySelector('#error').innerHTML = ResponseMessageObj;

            // alert(JSON.stringify(ResponseMessageObj,null,4));alert('nnnnnnok');
        }



    }

    function loadDonsError() {

      //  alert("Erreur inattendue");

    }

}

function addDeviceParams(requestXML) {

    for (var item in appInfo) {
        requestXML += ' ' + item + '="' + appInfo[item] + '"';
    }

    requestXML += ' uniqueDeviceKey="42325819292526"';
    // if(localStorage.APP_LANG){
    // var app_lang = localStorage.APP_LANG;
    requestXML += ' LN="FR"';
    // }


    // printLogMessages("requestXML -->"+requestXML);
    return requestXML;
}

function getCurrentTiemstap() {

    if (localStorage.currentTime) {
        return localStorage.currentTime;
    } else {
        var Now = new Date();
        var currentTime = Now.getTime();
        localStorage.currentTime = currentTime;
        return currentTime;
    }

}

function makeAJAXCallValiderInterne(param, type, dataType, successCallback, errorCallback) {
    //printLogMessages("makeAJAXCall appInfo------>" + JSON.stringify(appInfo));
    // $("#footer_div").hide();
    //$(".header_class").hide();
    isAJAXAlive = true;
    if (param.indexOf('></Request>') != -1) {

        var requestXML = param.split('></Request>');
        var requestData = addDeviceParams(requestXML[0]);
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
        beforeSend: function () {

        },
        success: function (response) {
            isAJAXAlive = false;
            // console.log("response xml-->" + (new XMLSerializer()).serializeToString(response));
            var responseObj = $.xml2json(response);
            // alert(JSON.stringify(responseObj,null,4));
            var res = responseObj.ResponseMessage;

            var date = responseObj.ResponseMessage.match(/\d{2}\/\d{2}\/\d{4}/)[0];
            var heure = responseObj.ResponseMessage.match(/\d{2}:\d{2}:\d{2}/)[0];
            var numeroTransaction = responseObj.ResponseMessage.match(/\d{3}-\d{7}-\d{2}/)[0];

            // alert("**"+date+"$$$"+heure+"---"+numeroTransaction);
            document.querySelector('#idTransaction').innerHTML = numeroTransaction;
            document.querySelector('#dateTransaction').innerHTML = date;
            document.querySelector('#heureTransaction').innerHTML = heure;
            if (responseObj.ResponseCode == "1212") {
                //openPage("AccountOTP");
                // $("#Payments_Loading").hide();
                // $("#servicePage_Loading").hide()
                // displayMultiLoginBox(responseObj.ResponseMessage);
                // alert(responseObj.ResponseMessage);


            } else {

                // if (localStorage.serviceFlag == "true") {
                // $("#footer_div").show();
                // }
                if (successCallback) {
                    successCallback(response);
                }

            }
        },
        error: function (x, t, m) {
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



/**************************************** Transfert Externe ******************************************************* */

function makeAJAXCallExterne(param, type, dataType, successCallback, errorCallback) {
    //printLogMessages("makeAJAXCall appInfo------>" + JSON.stringify(appInfo));
    // $("#footer_div").hide();
    //$(".header_class").hide();
    isAJAXAlive = true;
    if (param.indexOf('></Request>') != -1) {

        var requestXML = param.split('></Request>');
        var requestData = addDeviceParams(requestXML[0]);
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
        beforeSend: function () {

        },
        success: function (response) {
            isAJAXAlive = false;
            // alert("response xml-->" + (new XMLSerializer()).serializeToString(response));
            // var rep = response.ResponseMessage;
            // var isReceiverRegistered = rep.isReceiverRegistered._text;
            // var receiverFirstName = rep.receiverFirstName._text;
            // var receiverLastName = rep.receiverLastName._text;
            // var receiverGroup = rep.receiverGroup._text;
            // var receiverCommercialName = rep.receiverCommercialName._text;
            // alert(rep);
            if (response.ResponseCode == "1212") {
                //openPage("AccountOTP");
                // $("#Payments_Loading").hide();
                // $("#servicePage_Loading").hide()
                // displayMultiLoginBox(responseObj.ResponseMessage);
                // alert(responseObj.ResponseMessage);


            } else {

                // if (localStorage.serviceFlag == "true") {
                // $("#footer_div").show();
                // }
                if (successCallback) {
                    successCallback(response);
                }

            }
        },
        error: function (x, t, m) {
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

function fraisClient() {
    alert("Frais Client");
}

function transfertExterne(lang, phoneFormat, formCustmer, pin) {
    if (typeof (dataTable2Obj) != "undefined") {
        dataTable2Obj.destroy();
    }

    var listeDonsHTML = "";

    var montantTotalDons = parseFloat(0);

    var requestXML = '<?xml version="1.0" encoding="UTF-8" ?><Request receiverMobileNumber="' + phoneFormat + '" ttType="R" FN="FETRR" fromPartnerId="' + formCustmer + '" fromCustmer="' + formCustmer + '" PIN="' + pin + '"></Request>';

    makeAJAXCallExterne(requestXML, "POST", "xml", loadDonsSuccess, loadDonsError);

    


    function loadDonsSuccess(ResponseXML) {
        var responseObj = $.xml2json(ResponseXML);
        var res = responseObj.ResponseMessage;
        //res = JSON.stringify(res,null,4);
        //alert(res);
        var isReceiverRegistered = res.isReceiverRegistered;
        var receiverFirstName = res.receiverFirstName;
        var receiverLastName = res.receiverLastName;
        var receiverGroup = res.receiverGroup;
        var receiverCommercialName = res.receiverCommercialName;
        $('#client').html(``);
        $('#notification').html(``);
        $('#notificationMembre').html(``);
        $('#partners').html(``);
        $('#noClient').html(``);
        if (receiverGroup != 'CUSTOMERS' && receiverGroup != 'PARTNERS' && phoneFormat.length > 10 && phoneFormat.length < 12) {
            $('#notification').html(`
            <br>
            <code class="flash_message">Veuillez respecter le format requis</code>
            `);
        } else if (receiverGroup == 'CUSTOMERS') {
            $('#client').html(`
            <br>
            <div class="form-group col-md-5">
                <label for="exampleInputEmail1">Prénom</label>
                <input class="form-control" type="text" name="FirstName" value="${receiverFirstName}" placeholder="" required autocompleted="off" readonly>
            </div>
            <div class="form-group col-md-5">
                <label for="exampleInputEmail1">Nom</label>
                <input class="form-control" type="text" name="LastName" value="${receiverLastName}" placeholder="" required autocompleted="off" readonly>
            </div>
            <div class="form-group col-md-5">
                <label for="exampleInputEmail1">Montant</label>
                <input class="form-control money" type="text" name="amount" id="amount" min="100" max="100000" value="" placeholder="" required autocompleted="off">
                <code id="montantID" class="flash_message" style="display:none">Cette valeur doit être comprise entre 100 et 100.000 FCFA</code>
                <code id="montantsup" class="flash_message" style="display:none">Le montant saisi est supérieur au solde du Compte Encaissement</code>
            </div>
            <div class="form-group col-md-5">
                <label for="exampleInputEmail1">Motif</label>
                <select name="motif" class="form-control m-bot15" required="">
                    <option selected="selected">
                    </option>
                    <option value="Autres">Autres</option>
                    <option value="Cadeau">Cadeau</option>
                    <option value="Don">Don</option>
                    <option value="Evenement">Evenement</option>
                    <option value="Loyer ou Prestataires">Loyer ou
                        Prestataires
                    </option>
                    <option value="Reglement">Réglement</option>
                    <option value="Remboursement">Remboursement</option>
                    <option value="Scolarite">Scolarite</option>
                </select>
            </div>
            <div class="form-group col-md-5">
                <label for="exampleInputEmail1">Référence</label>
                <input class="form-control" type="text" name="reference" value="" placeholder="Référence" autocompleted="off">
            </div>
            <div class="form-group col-md-10">
                <div class="form-group col-md-12" style="padding-top:20px">
                    <button onclick="fraisClient()" name="submit" class="btn btn-info pull-right" style="margin-left:15px">Continuer</button>
                </div>
            </div>
            `);
        }else if (phoneFormat == formCustmer) {
            $('#notificationMembre').html(`
            <br>
            <code class="flash_message">Vous avez saisi votre numéro d'ogranisation comme Identifiant bénéficiaire. Veuillez saisir un identifiant différent
            </code>
            `);
        }else if (receiverGroup == 'PARTNERS'){
            $('#partners').html(`
            <br>
            <div class="form-group col-md-5">
                <label for="exampleInputEmail1">Prénom</label>
                <input class="form-control" type="text" name="FirstName" value="${receiverFirstName}" placeholder="" required autocompleted="off" readonly>
            </div>
            <div class="form-group col-md-5">
                <label for="exampleInputEmail1">Nom</label>
                <input class="form-control" type="text" name="LastName" value="${receiverLastName}" placeholder="" required autocompleted="off" readonly>
            </div>
            <div class="form-group col-md-5">
                <label for="exampleInputEmail1">Montant</label>
                <input class="form-control money" type="text" name="amount" id="amount" min="100" max="100000" value="" placeholder="" required autocompleted="off">
                <code id="montantID" class="flash_message" style="display:none">Cette valeur doit être comprise entre 100 et 100.000 FCFA</code>
                <code id="montantsup" class="flash_message" style="display:none">Le montant saisi est supérieur au solde du Compte Encaissement</code>
            </div>
            <div class="form-group col-md-5">
                <label for="exampleInputEmail1">Motif</label>
                <select name="motif" class="form-control m-bot15" required="">
                    <option selected="selected">
                    </option>
                    <option value="Autres">Autres</option>
                    <option value="Cadeau">Cadeau</option>
                    <option value="Don">Don</option>
                    <option value="Evenement">Evenement</option>
                    <option value="Loyer ou Prestataires">Loyer ou
                        Prestataires
                    </option>
                    <option value="Reglement">Réglement</option>
                    <option value="Remboursement">Remboursement</option>
                    <option value="Scolarite">Scolarite</option>
                </select>
            </div>
            <div class="form-group col-md-5">
                <label for="exampleInputEmail1">Nom Commercial</label>
                <input class="form-control" type="text" name="receiverCommercialName" value="${receiverCommercialName}" placeholder="" autocompleted="off" readonly>
            </div>
            <div class="form-group col-md-5">
                <label for="exampleInputEmail1">Référence</label>
                <input class="form-control" type="text" name="reference" value="" placeholder="Référence" autocompleted="off">
            </div>
            `);
        }else {
            $('#noClient').html(`
            <div class="form-group col-md-8">
            <label class="grandeligne" style="color:#0D4D99;margin-left:3%">Vous êtes sur le point d'effectuer un transfert par code</label>
            </div>
            <div class="form-group col-md-5">
                <label for="exampleInputEmail1">Prénom</label>
                <input class="form-control" type="text" name="FirstName" value="" placeholder="" required autocompleted="off">
            </div>
            <div class="form-group col-md-5">
                <label for="exampleInputEmail1">Nom</label>
                <input class="form-control" type="text" name="LastName" value="" placeholder="" required autocompleted="off">
            </div>
            <div class="form-group col-md-5">
                <label for="exampleInputEmail1">Montant</label>
                <input class="form-control money" type="text" name="amount" id="amount" min="100" max="100000" value="" placeholder="" required autocompleted="off">
                <code id="montantID" class="flash_message" style="display:none">Cette valeur doit être comprise entre 100 et 100.000 FCFA</code>
                <code id="montantsup" class="flash_message" style="display:none">Le montant saisi est supérieur au solde du Compte Encaissement</code>
            </div>
            <div class="form-group col-md-5">
                <label for="exampleInputEmail1">Motif</label>
                <select name="motif" class="form-control m-bot15" required="">
                    <option selected="selected">
                    </option>
                    <option value="Autres">Autres</option>
                    <option value="Cadeau">Cadeau</option>
                    <option value="Don">Don</option>
                    <option value="Evenement">Evenement</option>
                    <option value="Loyer ou Prestataires">Loyer ou
                        Prestataires
                    </option>
                    <option value="Reglement">Réglement</option>
                    <option value="Remboursement">Remboursement</option>
                    <option value="Scolarite">Scolarite</option>
                </select>
            </div>
            <div class="form-group col-md-5">
                <label for="exampleInputEmail1">Pays</label>
                <select name="pays" class="form-control m-bot15" required="">
                    <option selected="selected" value="Senegal">Sénégal
                    </option>
                </select>
            </div>
            <div class="form-group col-md-5">
                <label for="exampleInputEmail1">Région</label>
                <select name="region" class="form-control m-bot15" required="">
                    <option selected="selected">
                    </option>
                    <option value="Dakar">Dakar</option>
                    <option value="Fouta">Fouta</option>
                    <option value="Mbour">Mbour</option>
                    <option value="Thies">Thies</option>
                    <option value="Tivaouane">Tivaouane</option>
                    <option value="Touba">Touba</option>
                    <option value="Ziguinchor">Ziguinchor</option>
                </select>
            </div>
            <div class="form-group col-md-5">
                <label for="exampleInputEmail1">Adresse</label>
                <input class="form-control" type="text" name="adresse" value="" placeholder="Adresse" autocompleted="off">
            </div>
            <div class="form-group col-md-5">
                <label for="exampleInputEmail1">Référence</label>
                <input class="form-control" type="text" name="reference" value="" placeholder="Référence" autocompleted="off">
            </div>
            `)
        }

        //alert('Recevoir '+isReceiverRegistered+' Prenom '+receiverFirstName+' Nom '+receiverLastName+' Group '+receiverGroup);

        if (responseObj.ResponseStatus == "success") {

            // interfaceInterne.style['display'] = 'none';
            // confirmationInterne.style['display'] = 'block';
            var ResponseMessageObj = responseObj.ResponseMessage;
            return ResponseMessageObj;
        } else {

            // var ResponseMessageObj = responseObj.ResponseMessage;
            // error.style['display'] = 'block';
            // document.querySelector('#error').innerHTML = ResponseMessageObj;
            // alert(JSON.stringify(ResponseMessageObj,null,4));alert('nnnnnnok');
        }



    }

    function loadDonsError() {

       // alert("Erreur inattendue");

    }

}


function validationExterne(lang, amount, formCustmer, pin) {

    if (typeof (dataTable2Obj) != "undefined") {
        dataTable2Obj.destroy();
    }

    var listeDonsHTML = "";

    var montantTotalDons = parseFloat(0);

    var requestXML = '<?xml version="1.0" encoding="UTF-8" ?><Request mobNo="' + formCustmer + '" ttType="R" transferTypeId="1156" amount="' + amount + '" fromPartnerId="' + formCustmer + '" FN="WP" fromCustmer="' + formCustmer + '" PIN="' + pin + '"></Request>';
    makeAJAXCallValiderExterne(requestXML, "POST", "xml", loadDonsSuccess, loadDonsError);



    function loadDonsSuccess(ResponseXML) {
        // $("#servicePage_Loading").hide();
        var responseObj = $.xml2json(ResponseXML);
        var res = responseObj.ResponseMessage;
        // printLogMessages("getAmountForCotisationSuccess-->" + JSON.stringify(responseObj));
        var confirmationInterne = document.getElementById('confirmationInterne');
        var interfaceInterne = document.getElementById('interfaceInterne');
        var validertransfertInterne = document.getElementById('validertransfertInterne');


        if (responseObj.ResponseStatus == "success") {
            var success = document.getElementById('success');
            var heure = responseObj.ResponseMessage.match(/\d{2}:\d{2}:\d{2}/)[0];
            var numeroTransaction = responseObj.ResponseMessage.match(/\d{3}-\d{7}-\d{2}/)[0];
            var type = "TransfertInterne";
            confirmationInterne.style['display'] = 'none';
            interfaceInterne.style['display'] = 'none';
            validertransfertInterne.style['display'] = 'block';
            success.style['display'] = 'block';
            document.getElementById("valider").style.visibility = "hidden";
            // $.ajax({
            //     url: 'depot/confirmationInterne?code=acredit&amount=' + amount + '&phone=' + numPhone + '&type=' + type + '&transaction=' + numeroTransaction + '&heure=' + heure,
            //     method: 'POST',
            //     data: '',
            //     dataType: 'json',
            // }).success(function (response) {

            // });


            return ResponseMessageObj;
            alert('ok');
        } else {

            var ResponseMessageObj = responseObj.ResponseMessage;
            var ResponseMessageObj = responseObj.ResponseMessage;
            error.style['display'] = 'block';
            document.querySelector('#error').innerHTML = ResponseMessageObj;

            // alert(JSON.stringify(ResponseMessageObj,null,4));alert('nnnnnnok');
        }



    }

    function loadDonsError() {

      //  alert("Erreur inattendue");

    }

}

function addDeviceParams(requestXML) {

    for (var item in appInfo) {
        requestXML += ' ' + item + '="' + appInfo[item] + '"';
    }

    requestXML += ' uniqueDeviceKey="42325819292526"';
    // if(localStorage.APP_LANG){
    // var app_lang = localStorage.APP_LANG;
    requestXML += ' LN="FR"';
    // }


    // printLogMessages("requestXML -->"+requestXML);
    return requestXML;
}

function getCurrentTiemstap() {

    if (localStorage.currentTime) {
        return localStorage.currentTime;
    } else {
        var Now = new Date();
        var currentTime = Now.getTime();
        localStorage.currentTime = currentTime;
        return currentTime;
    }

}

function makeAJAXCallValiderExterne(param, type, dataType, successCallback, errorCallback) {
    //printLogMessages("makeAJAXCall appInfo------>" + JSON.stringify(appInfo));
    // $("#footer_div").hide();
    //$(".header_class").hide();
    isAJAXAlive = true;
    if (param.indexOf('></Request>') != -1) {

        var requestXML = param.split('></Request>');
        var requestData = addDeviceParams(requestXML[0]);
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
        beforeSend: function () {

        },
        success: function (response) {
            isAJAXAlive = false;
            // console.log("response xml-->" + (new XMLSerializer()).serializeToString(response));
            var responseObj = $.xml2json(response);
            // alert(JSON.stringify(responseObj,null,4));
            var res = responseObj.ResponseMessage;

            var date = responseObj.ResponseMessage.match(/\d{2}\/\d{2}\/\d{4}/)[0];
            var heure = responseObj.ResponseMessage.match(/\d{2}:\d{2}:\d{2}/)[0];
            var numeroTransaction = responseObj.ResponseMessage.match(/\d{3}-\d{7}-\d{2}/)[0];

            // alert("**"+date+"$$$"+heure+"---"+numeroTransaction);
            document.querySelector('#idTransaction').innerHTML = numeroTransaction;
            document.querySelector('#dateTransaction').innerHTML = date;
            document.querySelector('#heureTransaction').innerHTML = heure;
            if (responseObj.ResponseCode == "1212") {
                //openPage("AccountOTP");
                // $("#Payments_Loading").hide();
                // $("#servicePage_Loading").hide()
                // displayMultiLoginBox(responseObj.ResponseMessage);
                // alert(responseObj.ResponseMessage);


            } else {

                // if (localStorage.serviceFlag == "true") {
                // $("#footer_div").show();
                // }
                if (successCallback) {
                    successCallback(response);
                }

            }
        },
        error: function (x, t, m) {
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



/****************************************WOYOFAL******************************************************* */

function makeAJAXCallWofofal(param, type, dataType, successCallback, errorCallback, phone, numeroCompteur) {
    //printLogMessages("makeAJAXCall appInfo------>" + JSON.stringify(appInfo));
    // $("#footer_div").hide();
    //$(".header_class").hide();
    isAJAXAlive = true;
    if (param.indexOf('></Request>') != -1) {

        var requestXML = param.split('></Request>');
        var requestData = addDeviceParams(requestXML[0]);
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
        beforeSend: function () {

        },
        success: function (response) {
            isAJAXAlive = false;
            // console.log("response xml-->" + (new XMLSerializer()).serializeToString(response));
            var responseObj = $.xml2json(response); console.log('-----------responseObj-----------'); console.log(responseObj);
            var frais = responseObj.ResponseMessage.TransactionCharges.Charge.feeAmount;
            document.querySelector('#phone').innerHTML = phone;
            document.querySelector('#amountconfirmation').innerHTML = responseObj.ResponseMessage.Amount;
            document.querySelector('#feeAmount').innerHTML = frais;
            document.querySelector('#numCompteur').innerHTML = numeroCompteur;
            document.querySelector('#totalconfirmation').innerHTML = responseObj.ResponseMessage.TotalAmount;
            document.getElementById('convertmontant').value = responseObj.ResponseMessage.TotalAmount;
            if (responseObj.ResponseCode == "1212") {
                //openPage("AccountOTP");
                // $("#Payments_Loading").hide();
                // $("#servicePage_Loading").hide()
                // displayMultiLoginBox(responseObj.ResponseMessage);
                // alert(responseObj.ResponseMessage);


            }
            else {

                // if (localStorage.serviceFlag == "true") {
                // $("#footer_div").show();
                // }
                if (successCallback) {
                    successCallback(response);
                }

            }
        },
        error: function (x, t, m) {
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

function loadDonsWoyofal(lang, numPhone, amount, numeroCompteur, formCustmer, pin) {

    if (typeof (dataTable2Obj) != "undefined") { dataTable2Obj.destroy(); }

    var listeDonsHTML = "";

    var montantTotalDons = parseFloat(0);

    var requestXML = '<?xml version="1.0" encoding="UTF-8" ?><Request mobNo="' + numPhone + '" ttType="R" transferTypeId="307" amount="' + amount + '" meterId="' + numeroCompteur + '"  FN="GPD" fromPartnerId="' + formCustmer + '" fromCustmer="' + formCustmer + '" PIN="' + pin + '"></Request>';

    makeAJAXCallWofofal(requestXML, "POST", "xml", loadDonsSuccess, loadDonsError, numPhone, numeroCompteur);



    function loadDonsSuccess(ResponseXML) {
        // $("#servicePage_Loading").hide();
        var responseObj = $.xml2json(ResponseXML);
        // printLogMessages("getAmountForCotisationSuccess-->" + JSON.stringify(responseObj));
        var achat = document.getElementById('achat');
        var confirmationachat = document.getElementById('confirmationachat');
        var error = document.getElementById('error');
        var errorWoyofal = document.getElementById('errorWoyofal');
        if (responseObj.ResponseStatus == "success") {
            errorWoyofal.style['display'] = 'none';
            achat.style['display'] = 'none';
            confirmationachat.style['display'] = 'block';
            var ResponseMessageObj = responseObj.ResponseMessage;
            // var res = JSON.stringify(ResponseMessageObj);
            // alert(res);
            return ResponseMessageObj;
        } else {

            var ResponseMessageObj = responseObj.ResponseMessage;
            error.style['display'] = 'block';
            document.querySelector('#error').innerHTML = ResponseMessageObj;
            // alert(JSON.stringify(ResponseMessageObj,null,4));alert('nnnnnnok');
        }



    }

    function loadDonsError() {

      //  alert("Erreur inattendue");

    }

}


function validationWoyofal(lang, numPhone, amount, numeroCompteur, amountFCFA, formCustmer, pin) {

    if (typeof (dataTable2Obj) != "undefined") { dataTable2Obj.destroy(); }

    var listeDonsHTML = "";

    var montantTotalDons = parseFloat(0);

    var requestXML = '<?xml version="1.0" encoding="UTF-8" ?><Request mobNo="' + numPhone + '" ttType="PreE" transferTypeId="307" amount="' + amount + '" meterId="' + numeroCompteur + '" fromPartnerId="' + formCustmer + '" FN="WP" fromCustmer="' + formCustmer + '" PIN="' + pin + '"></Request>';

    makeAJAXCallValiderWoyofal(requestXML, "POST", "xml", loadDonsSuccess, loadDonsError, numPhone, numeroCompteur, amountFCFA);



    function loadDonsSuccess(ResponseXML) {
        // $("#servicePage_Loading").hide();
        var responseObj = $.xml2json(ResponseXML);

        // printLogMessages("getAmountForCotisationSuccess-->" + JSON.stringify(responseObj));
        var achat = document.getElementById('achat');
        var confirmationachat = document.getElementById('confirmationachat');
        var validationachat = document.getElementById('validationachat');
        var success = document.getElementById('success');
        var errorWoyofal = document.getElementById('errorWoyofal');
        if (responseObj.ResponseStatus == "success") {

            var codeRecharge = responseObj.ResponseMessage.match(/\d{4}-\d{4}-\d{4}-\d{4}-\d{4}/)[0]
            var numeroTransaction = responseObj.TransactionId;
            var type = "Achat Woyofal";
            achat.style['display'] = 'none';
            errorWoyofal.style['display'] = 'none';
            confirmationachat.style['display'] = 'none';
            validationachat.style['display'] = 'block';
            success.style['display'] = 'block';
            numeroCompteur = document.getElementById('numeroCompteurWoyofal').innerHTML;
            document.getElementById("valider").style.visibility = "hidden";
            // console.log("codeRecharge: "+codeRecharge+" "+" numPhone: "+numPhone+" numeroCompteur: "+numeroCompteur );
            // alert("codeRecharge: "+codeRecharge+" "+" numPhone: "+numPhone+" numeroCompteur: "+numeroCompteur );
            $.ajax({
                url: 'finance/confirmationwoyofal?code=awoyofal&amount=' + amount + '&numeroCompteur=' + numeroCompteur + '&phone=' + numPhone + '&type=' + type + '&transaction=' + numeroTransaction + '&codeRecharge=' + codeRecharge,
                method: 'POST',
                data: '',
                dataType: 'json',
            }).success(function (response) {

            });
            //  alert(JSON.stringify(ResponseMessageObj,null,4));

            return ResponseMessageObj;
            alert('ok');
        } else {

            var ResponseMessageObj = responseObj.ResponseMessage;
            error.style['display'] = 'block';
            document.querySelector('#error').innerHTML = ResponseMessageObj;

            // alert(JSON.stringify(ResponseMessageObj,null,4));alert('nnnnnnok');
        }



    }

    function loadDonsError() {

       // alert("Erreur inattendue");

    }

}

function makeAJAXCallValiderWoyofal(param, type, dataType, successCallback, errorCallback, phone, numeroCompteur, amountFCFA) {
    //printLogMessages("makeAJAXCall appInfo------>" + JSON.stringify(appInfo));
    // $("#footer_div").hide();
    //$(".header_class").hide();
    isAJAXAlive = true;
    if (param.indexOf('></Request>') != -1) {

        var requestXML = param.split('></Request>');
        var requestData = addDeviceParams(requestXML[0]);
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
        beforeSend: function () {

        },
        success: function (response) {
            isAJAXAlive = false;
            // console.log("response xml-->" + (new XMLSerializer()).serializeToString(response));
            var responseObj = $.xml2json(response); console.log('-----------responseObj-----------'); console.log(responseObj);
            // alert(JSON.stringify(responseObj,null,4));
            var errorWoyofal = document.getElementById('errorWoyofal');
            // console.log('-----------responseObj-----------');
            // console.log(responseObj);
            // alert(JSON.stringify(responseObj,null,4));
            var codeRecharge = responseObj.ResponseMessage.match(/\d{4}-\d{4}-\d{4}-\d{4}-\d{4}/)[0]
            var numeroTransaction = responseObj.TransactionId;

            document.querySelector('#phonevalidation').innerHTML = phone;
            document.querySelector('#numeroCompteurWoyofal').innerHTML = numeroCompteur;
            document.querySelector('#idTransaction').innerHTML = numeroTransaction;
            document.querySelector('#codeRecharge').innerHTML = codeRecharge;
            document.querySelector('#amountconfirmationvalidation').innerHTML = amountFCFA;
            errorWoyofal.style['display'] = 'none';
            if (responseObj.ResponseCode == "1011") {
                errorWoyofal.style['display'] = 'block';
                var ResponseMessageObj = responseObj.ResponseMessage;
                document.querySelector('#errorWoyofal').innerHTML = ResponseMessageObj;

            }
            else if (responseObj.ResponseCode == "1014") {
                errorWoyofal.style['display'] = 'block';
                var ResponseMessageObj = responseObj.ResponseMessage;
                document.querySelector('#errorWoyofal').innerHTML = ResponseMessageObj;

            }
            else {
                //alert(responseObj.ResponseMessage);
                // if (localStorage.serviceFlag == "true") {
                // $("#footer_div").show();
                // }
                if (successCallback) {
                    successCallback(response);
                }

            }


        },
        error: function (x, t, m) {
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
/************************************************************************ */

function invoiceSenEau(lang, customerReference, formCustmer, pin) {

    if (typeof (dataTable2Obj) != "undefined") {
        dataTable2Obj.destroy();
    }

    var listeDonsHTML = "";

    var montantTotalDons = parseFloat(0);

    var requestXML = '<?xml version="1.0" encoding="UTF-8" ?><Request ttType="R" waterCustmerReference="' + customerReference + '"  FN="WEPPOI" fromPartnerId="' + formCustmer + '" fromCustmer="' + formCustmer + '" PIN="' + pin + '"></Request>';

    makeAJAXCallInvoiceSeneau(requestXML, "POST", "xml", loadDonsSuccess, loadDonsError, customerReference);



    function loadDonsSuccess(ResponseXML) {

        // $("#servicePage_Loading").hide();
        var responseObj = $.xml2json(ResponseXML);
        // printLogMessages("getAmountForCotisationSuccess-->" + JSON.stringify(responseObj));
        var reference = document.getElementById('reference');
        var factures = document.getElementById('factures');
        var error = document.getElementById('error');
        error.style['display'] = 'none';
        if (responseObj.ResponseStatus == "success") {
            var listeFactureHTML = "";
            var ResponseMessageObj = Array.isArray(responseObj.ResponseMessage.invoices.invoice)
                ? responseObj.ResponseMessage.invoices.invoice
                : [responseObj.ResponseMessage.invoices.invoice];
            // var res = JSON.stringify(ResponseMessageObj);
            // alert(res);
            reference.style['display'] = 'none';
            factures.style['display'] = 'block';
            console.log(ResponseMessageObj);
            invoices = ResponseMessageObj;
            for (var i = 0; i < invoices.length; i++) {
                listeFactureHTML += "<tr>";
                var obj = invoices[i];
                listeFactureHTML += "<td>" + obj['firstName'] + " " + obj['lastName'] + "</td>";
                listeFactureHTML += `<td class="money">${formatCurrencyFacture(obj['totalAmount'])}</td>`;
                listeFactureHTML += "<td>" + obj['invoiceNumber'] + "</td>";
                listeFactureHTML += "<td>" + obj['dueDate'] + "</td>";
                listeFactureHTML += `<td><button onclick="recupererFraisSeneau(${i})" name="submit" class="btn-sm btn-info pull-right">Payer</button></td>`;
                listeFactureHTML += "</tr>";

            }
            $("#exemple").html(listeFactureHTML);

            return ResponseMessageObj;
        } else {

            var ResponseMessageObj = responseObj.ResponseMessage;
            error.style['display'] = 'block';
            document.querySelector('#error').innerHTML = ResponseMessageObj;
            // alert(JSON.stringify(ResponseMessageObj,null,4));alert('nnnnnnok');
        }



    }

    function loadDonsError() {

        //alert("Erreur inattendue");

    }

}

function makeAJAXCallInvoiceSeneau(param, type, dataType, successCallback, errorCallback, customerReference) {
    //printLogMessages("makeAJAXCall appInfo------>" + JSON.stringify(appInfo));
    // $("#footer_div").hide();
    //$(".header_class").hide();
    isAJAXAlive = true;
    if (param.indexOf('></Request>') != -1) {

        var requestXML = param.split('></Request>');
        var requestData = addDeviceParams(requestXML[0]);
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
        beforeSend: function () {

        },
        success: function (response) {
            isAJAXAlive = false;
            // console.log("response xml-->" + (new XMLSerializer()).serializeToString(response));
            var responseObj = $.xml2json(response);

            if (responseObj.ResponseCode == "1212") {
                //openPage("AccountOTP");
                // $("#Payments_Loading").hide();
                // $("#servicePage_Loading").hide()
                // displayMultiLoginBox(responseObj.ResponseMessage);
                // alert(responseObj.ResponseMessage);


            } else {

                // if (localStorage.serviceFlag == "true") {
                // $("#footer_div").show();
                // }
                if (successCallback) {
                    successCallback(response);
                }

            }
        },
        error: function (x, t, m) {
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

function recupererFraisSeneau(i) {
    // alert(JSON.stringify(invoices[i],null,4));
    var invoice = invoices[i];
    var id = invoice.id;
    var prenom = invoice.firstName;
    var nom = invoice.lastName;
    var montant = invoice.totalAmount;
    var numeroFacture = invoice.invoiceNumber;
    var delai = invoice.dueDate;
    var custmerReference = invoice.custmerReference;
    var formCustmer = $('#formCustmer').val();
    var pin = $('#PIN').val();
    // alert("Nom: "+nom+"++++"+"Prénom: "+prenom+"Montant: "+montant+"numeroFacture: "+numeroFacture+"Delai: "+delai);
    var reponseAll = fraisSeneau("fr", id, prenom, nom, montant, numeroFacture, delai, custmerReference, formCustmer, pin);
}

function fraisSeneau(lang, id, prenom, nom, montant, numeroFacture, delai, custmerReference, formCustmer, pin) {

    if (typeof (dataTable2Obj) != "undefined") {
        dataTable2Obj.destroy();
    }

    var listeDonsHTML = "";

    var montantTotalDons = parseFloat(0);

    var requestXML = '<?xml version="1.0" encoding="UTF-8" ?><Request ttType="PostW" transferTypeId="326" amount="' + montant + '" waterCustmerReference="' + custmerReference + '" FN="GPD" fromPartnerId="' + formCustmer + '" fromCustmer="' + formCustmer + '" PIN="' + pin + '"></Request>';

    makeAJAXCallFraisSeneau(requestXML, "POST", "xml", loadDonsSuccess, loadDonsError, id, prenom, nom, montant, numeroFacture, delai, custmerReference);



    function loadDonsSuccess(ResponseXML) {
        // $("#servicePage_Loading").hide();
        var responseObj = $.xml2json(ResponseXML);
        // printLogMessages("getAmountForCotisationSuccess-->" + JSON.stringify(responseObj));
        var reference = document.getElementById('reference');
        var factures = document.getElementById('factures');
        var frais = document.getElementById('frais');
        var errorSenEau = document.getElementById('errorSenEau');


        if (responseObj.ResponseStatus == "success") {
            errorSenEau.style['display'] = 'none';
            reference.style['display'] = 'none';
            factures.style['display'] = 'none';
            frais.style['display'] = 'block';
            var ResponseMessageObj = responseObj.ResponseMessage;
            // var res = JSON.stringify(ResponseMessageObj);
            // alert(res);
            return ResponseMessageObj;
        } else {

            var ResponseMessageObj = responseObj.ResponseMessage;
            error.style['display'] = 'block';
            document.querySelector('#error').innerHTML = ResponseMessageObj;
            // alert(JSON.stringify(ResponseMessageObj,null,4));alert('nnnnnnok');
        }



    }

    function loadDonsError() {

        //alert("Erreur inattendue");

    }

}

function makeAJAXCallFraisSeneau(param, type, dataType, successCallback, errorCallback, id, prenom, nom, montant, numeroFacture, delai, custmerReference) {
    //printLogMessages("makeAJAXCall appInfo------>" + JSON.stringify(appInfo));
    // $("#footer_div").hide();
    //$(".header_class").hide();
    isAJAXAlive = true;
    if (param.indexOf('></Request>') != -1) {

        var requestXML = param.split('></Request>');
        var requestData = addDeviceParams(requestXML[0]);
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
        beforeSend: function () {

        },
        success: function (response) {
            isAJAXAlive = false;
            // console.log("response xml-->" + (new XMLSerializer()).serializeToString(response));
            var responseObj = $.xml2json(response);
            var res = JSON.stringify(responseObj.ResponseMessage, null, 4);
            var frais = responseObj.ResponseMessage.TransactionCharges.Charge.feeAmount;
            document.querySelector('#nomClient').innerHTML = prenom + ' ' + nom;
            document.querySelector('#referenceFacture').innerHTML = custmerReference;
            document.querySelector('#numeroFacture').innerHTML = numeroFacture;
            document.querySelector('#montantFacture').innerHTML = responseObj.ResponseMessage.Amount;
            document.querySelector('#fraisFacture').innerHTML = frais;
            document.querySelector('#totalconfirmation').innerHTML = responseObj.ResponseMessage.TotalAmount;
            document.querySelector('#delaiPaiement').innerHTML = delai;
            document.getElementById('convertmontant').value = responseObj.ResponseMessage.TotalAmount;
            document.getElementById('hiddenReferenceFacture').value = custmerReference;
            document.getElementById('hiddenNumeroFacture').value = numeroFacture;
            document.getElementById('hiddenIdFacture').value = id;
            document.getElementById('hiddenAmount').value = responseObj.ResponseMessage.UnformattedTotalAmount;
            document.getElementById('hiddenClient').value = prenom + ' ' + nom;
            if (responseObj.ResponseCode == "1212") {
                //openPage("AccountOTP");
                // $("#Payments_Loading").hide();
                // $("#servicePage_Loading").hide()
                // displayMultiLoginBox(responseObj.ResponseMessage);
                // alert(responseObj.ResponseMessage);


            } else {

                // if (localStorage.serviceFlag == "true") {
                // $("#footer_div").show();
                // }
                if (successCallback) {
                    successCallback(response);
                }

            }
        },
        error: function (x, t, m) {
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

function validationSeneau() {
    var custmerReference = $('#hiddenReferenceFacture').val();
    var numeroFacture = $('#hiddenNumeroFacture').val();
    var montant = $('#hiddenAmount').val();
    var postpaidInvoiceId = $('#hiddenIdFacture').val();
    var amountFCFA = $('#convertmontant').val();
    var hiddenClient = $('#hiddenClient').val();
    var formCustmer = $('#formCustmer').val();
    var pin = $('#PIN').val();
    var reponseAll = paySeneau("fr", custmerReference, montant, numeroFacture, postpaidInvoiceId, amountFCFA, hiddenClient, formCustmer, pin);
    //alert("reference Facture: "+custmerReference+" numero Facture: "+numeroFacture+" montant Facture: "+montant+" id Facture: "+postpaidInvoiceId+"**"+amountFCFA);
}

function paySeneau(lang, custmerReference, montant, numeroFacture, postpaidInvoiceId, amountFCFA, hiddenClient, formCustmer, pin) {

    if (typeof (dataTable2Obj) != "undefined") {
        dataTable2Obj.destroy();
    }

    var listeDonsHTML = "";

    var montantTotalDons = parseFloat(0);

    var requestXML = '<?xml version="1.0" encoding="UTF-8" ?><Request postpaidInvoiceId="' + postpaidInvoiceId + '" ttType="PostE" transferTypeId="324" amount="' + montant + '" invoiceNumber="' + numeroFacture + '" waterCustmerReference="' + custmerReference + '" fromPartnerId="' + formCustmer + '" FN="WP" fromCustmer="' + formCustmer + '" PIN="' + pin + '"></Request>';

    makeAJAXCallValiderSeneau(requestXML, "POST", "xml", loadDonsSuccess, loadDonsError, custmerReference, montant, numeroFacture, postpaidInvoiceId, amountFCFA);



    function loadDonsSuccess(ResponseXML) {
        // $("#servicePage_Loading").hide();
        var responseObj = $.xml2json(ResponseXML);

        // printLogMessages("getAmountForCotisationSuccess-->" + JSON.stringify(responseObj));
        var reference = document.getElementById('reference');
        var factures = document.getElementById('factures');
        var frais = document.getElementById('frais');
        var success = document.getElementById('success');
        var cacherBouton = document.getElementById('cacherBouton');
        var cacherNumeroTransaction = document.getElementById('cacherNumeroTransaction');
        var menuservice = document.getElementById('menuservice');

        if (responseObj.ResponseStatus == "success") {
            var numeroTransaction = responseObj.ResponseMessage.match(/\d{3}-\d{7}-\d{2}/)[0];
            var type = "Paiement SenEau";
            reference.style['display'] = 'none';
            factures.style['display'] = 'none';
            cacherBouton.style['display'] = 'none';
            success.style['display'] = 'block';
            cacherNumeroTransaction.style['display'] = 'block';
            frais.style['display'] = 'block';
            menuservice.style['display'] = 'block';
            $.ajax({
                url: 'finance/confirmationseneau?code=aseneau&amount=' + montant + '&client=' + hiddenClient + '&type=' + type + '&transaction=' + numeroTransaction + '&numeroFacture=' + numeroFacture + '&referenceClient=' + custmerReference,
                method: 'POST',
                data: '',
                dataType: 'json',
            }).success(function (response) {

            });
            //  alert(JSON.stringify(ResponseMessageObj,null,4));

            return ResponseMessageObj;
            alert('ok');
        } else {

            var ResponseMessageObj = responseObj.ResponseMessage;
            error.style['display'] = 'block';
            document.querySelector('#error').innerHTML = ResponseMessageObj;

            // alert(JSON.stringify(ResponseMessageObj,null,4));alert('nnnnnnok');
        }



    }

    function loadDonsError() {

      //  alert("Erreur inattendue");

    }

}

function makeAJAXCallValiderSeneau(param, type, dataType, successCallback, errorCallback, custmerReference, montant, numeroFacture, postpaidInvoiceId, amountFCFA) {
    //printLogMessages("makeAJAXCall appInfo------>" + JSON.stringify(appInfo));
    // $("#footer_div").hide();
    //$(".header_class").hide();
    isAJAXAlive = true;
    if (param.indexOf('></Request>') != -1) {

        var requestXML = param.split('></Request>');
        var requestData = addDeviceParams(requestXML[0]);
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
        beforeSend: function () {

        },
        success: function (response) {
            isAJAXAlive = false;
            // console.log("response xml-->" + (new XMLSerializer()).serializeToString(response));
            var responseObj = $.xml2json(response);
            var errorSenEau = document.getElementById('errorSenEau');
            // console.log('-----------responseObj-----------');
            // console.log(responseObj);
            // alert(JSON.stringify(responseObj,null,4));
            errorSenEau.style['display'] = 'none';
            if (responseObj.ResponseCode == "1011") {
                errorSenEau.style['display'] = 'block';
                var ResponseMessageObj = responseObj.ResponseMessage;
                document.querySelector('#errorSenEau').innerHTML = ResponseMessageObj;

            } else {
                //alert(responseObj.ResponseMessage);
                // if (localStorage.serviceFlag == "true") {
                // $("#footer_div").show();
                // }
                if (successCallback) {
                    successCallback(response);
                }

            }
            var date = responseObj.ResponseMessage.match(/\d{2}\/\d{2}\/\d{4}/)[0];
            var heure = responseObj.ResponseMessage.match(/\d{2}:\d{2}:\d{2}/)[0];
            var numeroTransaction = responseObj.ResponseMessage.match(/\d{3}-\d{7}-\d{2}/)[0];

            // alert("**"+date+"$$$"+heure+"---"+numeroTransaction);
            document.querySelector('#idTransaction').innerHTML = numeroTransaction;
            document.querySelector('#dateHeure').innerHTML = date + " à " + heure;

        },
        error: function (x, t, m) {
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


/*************************Paiement Facture via zuuluPay ****************** */
function makeAJAXCallZuuluService(param, type, dataType, successCallback, errorCallback,formCustmer, pin, to_Custmer, to_pin, amountValidation) {
    //printLogMessages("makeAJAXCall appInfo------>" + JSON.stringify(appInfo));
    // $("#footer_div").hide();
    //$(".header_class").hide();
    isAJAXAlive = true;
    // if (param.indexOf('></Request>') != -1) {

    //     var requestXML = param.split('></Request>');
    //     var requestData = addDeviceParams(requestXML[0]);
    //     param = requestData + '></Request>';
        
    //     // printLogMessages("requestData->" + param);
    // }

    $.ajax({
        type: type,
        cache: false,
        data: param,
        url: BASE_URL,
        dataType: dataType,
        timeout: timeout,
        beforeSend: function () {

        },
        success: function (response) {
            isAJAXAlive = false;
            // console.log("response xml-->" + (new XMLSerializer()).serializeToString(response));
            var responseObj = $.xml2json(response);
            console.log(responseObj);
            var frais = responseObj.ResponseMessage.TransactionCharges.Charge.feeAmount;
            var amount = responseObj.ResponseMessage.Amount;
            var totalAmount = responseObj.ResponseMessage.TotalAmount;
            document.querySelector('#amountpay').innerHTML = responseObj.ResponseMessage.Amount;
            document.querySelector('#feeAmountpay').innerHTML = frais;
            document.querySelector('#totalAmountpay').innerHTML = responseObj.ResponseMessage.TotalAmount;
            document.getElementById('UnformattedTotalAmount').value = responseObj.ResponseMessage.UnformattedTotalAmount;
            if (responseObj.ResponseCode == "1212") {
                //openPage("AccountOTP");
                // $("#Payments_Loading").hide();
                // $("#servicePage_Loading").hide()
                // displayMultiLoginBox(responseObj.ResponseMessage);
                // alert(responseObj.ResponseMessage);


            } else {

                // if (localStorage.serviceFlag == "true") {
                // $("#footer_div").show();
                // }
                if (successCallback) {
                    successCallback(response);
                }

            }
        },
        error: function (x, t, m) {
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

function loadDonsZuuluService(lang, formCustmer, pin, to_Custmer, to_pin, amountValidation) {

    if (typeof (dataTable2Obj) != "undefined") {
        dataTable2Obj.destroy();
    }

    var listeDonsHTML = "";

    var montantTotalDons = parseFloat(0);

    var requestXML = '<?xml version="1.0" encoding="UTF-8" ?><Request fromCustmer="' + formCustmer + '" toCustmer="' + to_Custmer + '" ttType="" transferTypeId="1186" reverse="false" isLocal="true" FN="GPD" amount="' + amountValidation + '" PIN="' + pin + '" deviceModel="SM-E7000" devicePlatform="Android" deviceVersion="4.4.2" deviceManufacturer="samsung" packageName="com.zuulu.zuulu" versionNumber="1.0.5" isVirtualDevice="false" geoLatitude="" geoLongitude="" appClientName="Samba Diallo" appType="production" deviceIP="154.124.74.151" ipLocationCode="SN" uniqueDeviceKey="1608979848721" LN="FR"></Request>';
    
    makeAJAXCallZuuluService(requestXML, "POST", "xml", loadDonsSuccess, loadDonsError, formCustmer, pin, to_Custmer, to_pin, amountValidation);



    function loadDonsSuccess(ResponseXML) {
        // $("#servicePage_Loading").hide();
        var responseObj = $.xml2json(ResponseXML);
        // printLogMessages("getAmountForCotisationSuccess-->" + JSON.stringify(responseObj));
        var confirmZuuluPay = document.getElementById('confirmZuuluPay');
        var fraisZuulupay = document.getElementById('fraisZuulupay');
        var error = document.getElementById('error');
        var validerZuulupay = document.getElementById('validerZuulupay');
        var validerZuulupayEncaissement = document.getElementById('validerZuulupayEncaissement');
        validerZuulupayEncaissement.style['display'] = 'block';
        validerZuulupay.style['display'] = 'block';
        if (responseObj.ResponseStatus == "success") {
            confirmZuuluPay.style['display'] = 'none';
            fraisZuulupay.style['display'] = 'block';
            validerZuulupayEncaissement.style['display'] = 'none';
            validerZuulupay.style['display'] = 'block';
            var ResponseMessageObj = responseObj.ResponseMessage;
            // var res = JSON.stringify(ResponseMessageObj);
            // alert(res);
            return ResponseMessageObj;
        } else {

            var ResponseMessageObj = responseObj.ResponseMessage;
            error.style['display'] = 'block';
            document.querySelector('#error').innerHTML = ResponseMessageObj;
            // alert(JSON.stringify(ResponseMessageObj,null,4));alert('nnnnnnok');
        }



    }

    function loadDonsError() {

        //alert("Erreur inattendue");

    }

}


function validationZuuluService(lang, formCustmer, pin, to_Custmer, to_pin, amountValidation,idPayment) {
    if (typeof (dataTable2Obj) != "undefined") {
        dataTable2Obj.destroy();
    }

    var listeDonsHTML = "";

    var montantTotalDons = parseFloat(0);

    var requestXML = '<?xml version="1.0" encoding="UTF-8" ?><Request fromCustmer="' + formCustmer + '" toCustmer="' + to_Custmer + '" ttType="" transferTypeId="1186" reverse="false" isLocal="true" FN="WP" amount="' + amountValidation + '" PIN="' + pin + '" deviceModel="SM-E7000" devicePlatform="Android" deviceVersion="4.4.2" deviceManufacturer="samsung" packageName="com.zuulu.zuulu" versionNumber="1.0.5" isVirtualDevice="false" geoLatitude="" geoLongitude="" appClientName="Samba Diallo" appType="production" deviceIP="154.124.74.151" ipLocationCode="SN" uniqueDeviceKey="1608979848721" LN="FR"></Request>';

    makeAJAXCallValiderZuuluService(requestXML, "POST", "xml", loadDonsSuccess, loadDonsError, formCustmer, pin, to_Custmer, to_pin, amountValidation,idPayment);
    


    function loadDonsSuccess(ResponseXML) {
        // $("#servicePage_Loading").hide();
        var responseObj = $.xml2json(ResponseXML);
        var res = responseObj.ResponseMessage;
        // printLogMessages("getAmountForCotisationSuccess-->" + JSON.stringify(responseObj));
        
        var validationachat = document.getElementById('validationachat');
        var btnSucces = document.getElementById('btnSucces');
        var btnEffectuer = document.getElementById('btnEffectuer');

        if (responseObj.ResponseStatus == "success") {
            var success = document.getElementById('success');
            var date = responseObj.ResponseMessage.match(/\d{2}\/\d{2}\/\d{4}/)[0];
            var heure = responseObj.ResponseMessage.match(/\d{2}:\d{2}:\d{2}/)[0];
            var numeroTransaction = responseObj.ResponseMessage.match(/\d{3}-\d{7}-\d{2}/)[0];
            validationachat.style['display'] = 'block';
            success.style['display'] = 'block';
            btnSucces.style['display'] = 'block';
            btnEffectuer.style['display'] = 'none';
            $.ajax({
                url: 'partenaire/changeStatus?id='+idPayment+'&numeroTransaction=' + numeroTransaction,
                method: 'POST',
                data: '',
                dataType: 'json',
            }).success(function (response) {

            });


            return ResponseMessageObj;
            alert('ok');
        } else {

            var ResponseMessageObj = responseObj.ResponseMessage;
            var ResponseMessageObj = responseObj.ResponseMessage;
            error.style['display'] = 'block';
            document.querySelector('#error').innerHTML = ResponseMessageObj;

            // alert(JSON.stringify(ResponseMessageObj,null,4));alert('nnnnnnok');
        }



    }

    function loadDonsError() {

      //  alert("Erreur inattendue");

    }

}

function addDeviceParams(requestXML) {

    for (var item in appInfo) {
        requestXML += ' ' + item + '="' + appInfo[item] + '"';
    }

    requestXML += ' uniqueDeviceKey="42325819292526"';
    // if(localStorage.APP_LANG){
    // var app_lang = localStorage.APP_LANG;
    requestXML += ' LN="FR"';
    // }


    // printLogMessages("requestXML -->"+requestXML);
    return requestXML;
}

function getCurrentTiemstap() {

    if (localStorage.currentTime) {
        return localStorage.currentTime;
    } else {
        var Now = new Date();
        var currentTime = Now.getTime();
        localStorage.currentTime = currentTime;
        return currentTime;
    }

}

function makeAJAXCallValiderZuuluService(param, type, dataType, successCallback, errorCallback, formCustmer, pin, to_Custmer, to_pin, amountValidation,idPayment) {
    //printLogMessages("makeAJAXCall appInfo------>" + JSON.stringify(appInfo));
    // $("#footer_div").hide();
    //$(".header_class").hide();
    isAJAXAlive = true;
    // if (param.indexOf('></Request>') != -1) {

    //     var requestXML = param.split('></Request>');
    //     var requestData = addDeviceParams(requestXML[0]);
    //     param = requestData + '></Request>';
    //     // printLogMessages("requestData->" + param);
    // }

    $.ajax({
        type: type,
        cache: false,
        data: param,
        url: BASE_URL,
        dataType: dataType,
        timeout: timeout,
        beforeSend: function () {

        },
        success: function (response) {
            isAJAXAlive = false;
            // console.log("response xml-->" + (new XMLSerializer()).serializeToString(response));
            var responseObj = $.xml2json(response);
            // alert(JSON.stringify(responseObj,null,4));
            var res = responseObj.ResponseMessage;
            var errorPay = document.getElementById('errorPay');
            errorPay.style['display'] = 'none';
            if (responseObj.ResponseCode == "1020") {
                var res = responseObj.ResponseMessage;
                document.querySelector('#errorPay').innerHTML = res;
                errorPay.style['display'] = 'block';
                //openPage("AccountOTP");
                // $("#Payments_Loading").hide();
                // $("#servicePage_Loading").hide()
                // displayMultiLoginBox(responseObj.ResponseMessage);
                // alert(responseObj.ResponseMessage);


            } else {

                // if (localStorage.serviceFlag == "true") {
                // $("#footer_div").show();
                // }
                if (successCallback) {
                    successCallback(response);
                }

            }

            var date = responseObj.ResponseMessage.match(/\d{2}\/\d{2}\/\d{4}/)[0];
            var heure = responseObj.ResponseMessage.match(/\d{2}:\d{2}:\d{2}/)[0];
            var numeroTransaction = responseObj.ResponseMessage.match(/\d{3}-\d{7}-\d{2}/)[0];

            document.querySelector('#numeroTransaction').innerHTML = numeroTransaction;
            document.querySelector('#dateHeure').innerHTML = date+' à '+heure;
            
        },
        error: function (x, t, m) {
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


/****************************FIN PAIEMENT FACTURE via zuuluPay */


/*************************Paiement Facture ENCAISSEMENT via zuuluPay ****************** */
function makeAJAXCallZuuluEncaissement(param, type, dataType, successCallback, errorCallback,formCustmer, pin, to_Custmer, to_pin, amountValidation) {
    //printLogMessages("makeAJAXCall appInfo------>" + JSON.stringify(appInfo));
    // $("#footer_div").hide();
    //$(".header_class").hide();
    isAJAXAlive = true;
    // if (param.indexOf('></Request>') != -1) {

    //     var requestXML = param.split('></Request>');
    //     var requestData = addDeviceParams(requestXML[0]);
    //     param = requestData + '></Request>';
        
    //     // printLogMessages("requestData->" + param);
    // }

    $.ajax({
        type: type,
        cache: false,
        data: param,
        url: BASE_URL,
        dataType: dataType,
        timeout: timeout,
        beforeSend: function () {

        },
        success: function (response) {
            isAJAXAlive = false;
            // console.log("response xml-->" + (new XMLSerializer()).serializeToString(response));
            var responseObj = $.xml2json(response);
            console.log(responseObj);
            var frais = responseObj.ResponseMessage.TransactionCharges.Charge.feeAmount;
            var amount = responseObj.ResponseMessage.Amount;
            var totalAmount = responseObj.ResponseMessage.TotalAmount;
            document.querySelector('#amountpay').innerHTML = responseObj.ResponseMessage.Amount;
            document.querySelector('#feeAmountpay').innerHTML = frais;
            document.querySelector('#totalAmountpay').innerHTML = responseObj.ResponseMessage.TotalAmount;
            document.getElementById('UnformattedTotalAmount').value = responseObj.ResponseMessage.UnformattedTotalAmount;
            if (responseObj.ResponseCode == "1212") {
                //openPage("AccountOTP");
                // $("#Payments_Loading").hide();
                // $("#servicePage_Loading").hide()
                // displayMultiLoginBox(responseObj.ResponseMessage);
                // alert(responseObj.ResponseMessage);


            } else {

                // if (localStorage.serviceFlag == "true") {
                // $("#footer_div").show();
                // }
                if (successCallback) {
                    successCallback(response);
                }

            }
        },
        error: function (x, t, m) {
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

function loadDonsZuuluEncaissement(lang, formCustmer, pin, to_Custmer, to_pin, amountValidation) {

    if (typeof (dataTable2Obj) != "undefined") {
        dataTable2Obj.destroy();
    }

    var listeDonsHTML = "";

    var montantTotalDons = parseFloat(0);

    var requestXML = '<?xml version="1.0" encoding="UTF-8" ?><Request fromCustmer="' + formCustmer + '" toCustmer="' + to_Custmer + '" ttType="" transferTypeId="1182" reverse="false" isLocal="true" FN="GPD" amount="' + amountValidation + '" PIN="' + pin + '" deviceModel="SM-E7000" devicePlatform="Android" deviceVersion="4.4.2" deviceManufacturer="samsung" packageName="com.zuulu.zuulu" versionNumber="1.0.5" isVirtualDevice="false" geoLatitude="" geoLongitude="" appClientName="Samba Diallo" appType="production" deviceIP="154.124.74.151" ipLocationCode="SN" uniqueDeviceKey="1608979848721" LN="FR"></Request>';
    
    makeAJAXCallZuuluEncaissement(requestXML, "POST", "xml", loadDonsSuccess, loadDonsError, formCustmer, pin, to_Custmer, to_pin, amountValidation);



    function loadDonsSuccess(ResponseXML) {
        // $("#servicePage_Loading").hide();
        var responseObj = $.xml2json(ResponseXML);
        // printLogMessages("getAmountForCotisationSuccess-->" + JSON.stringify(responseObj));
        var confirmZuuluPay = document.getElementById('confirmZuuluPay');
        var fraisZuulupay = document.getElementById('fraisZuulupay');
        var error = document.getElementById('error');
        var validerZuulupay = document.getElementById('validerZuulupay');
        var validerZuulupayEncaissement = document.getElementById('validerZuulupayEncaissement');
        validerZuulupay.style['display'] = 'block';
        if (responseObj.ResponseStatus == "success") {
            confirmZuuluPay.style['display'] = 'none';
            fraisZuulupay.style['display'] = 'block';
            validerZuulupay.style['display'] = 'none';
            validerZuulupayEncaissement.style['display'] = 'block';
            
            var ResponseMessageObj = responseObj.ResponseMessage;
            // var res = JSON.stringify(ResponseMessageObj);
            // alert(res);
            return ResponseMessageObj;
        } else {

            var ResponseMessageObj = responseObj.ResponseMessage;
            error.style['display'] = 'block';
            document.querySelector('#error').innerHTML = ResponseMessageObj;
            // alert(JSON.stringify(ResponseMessageObj,null,4));alert('nnnnnnok');
        }



    }

    function loadDonsError() {

        //alert("Erreur inattendue");

    }

}


function validationZuuluEncaissement(lang, formCustmer, pin, to_Custmer, to_pin, amountValidation,idPayment) {
    if (typeof (dataTable2Obj) != "undefined") {
        dataTable2Obj.destroy();
    }

    var listeDonsHTML = "";

    var montantTotalDons = parseFloat(0);

    var requestXML = '<?xml version="1.0" encoding="UTF-8" ?><Request fromCustmer="' + formCustmer + '" toCustmer="' + to_Custmer + '" ttType="" transferTypeId="1182" reverse="false" isLocal="true" FN="WP" amount="' + amountValidation + '" PIN="' + pin + '" deviceModel="SM-E7000" devicePlatform="Android" deviceVersion="4.4.2" deviceManufacturer="samsung" packageName="com.zuulu.zuulu" versionNumber="1.0.5" isVirtualDevice="false" geoLatitude="" geoLongitude="" appClientName="Samba Diallo" appType="production" deviceIP="154.124.74.151" ipLocationCode="SN" uniqueDeviceKey="1608979848721" LN="FR"></Request>';

    makeAJAXCallValiderZuuluEncaissement(requestXML, "POST", "xml", loadDonsSuccess, loadDonsError, formCustmer, pin, to_Custmer, to_pin, amountValidation,idPayment);
    


    function loadDonsSuccess(ResponseXML) {
        // $("#servicePage_Loading").hide();
        var responseObj = $.xml2json(ResponseXML);
        var res = responseObj.ResponseMessage;
        // printLogMessages("getAmountForCotisationSuccess-->" + JSON.stringify(responseObj));
        
        var validationachat = document.getElementById('validationachat');
        var btnSucces = document.getElementById('btnSucces');
        var btnEffectuer = document.getElementById('btnEffectuer');

        if (responseObj.ResponseStatus == "success") {
            var success = document.getElementById('success');
            var date = responseObj.ResponseMessage.match(/\d{2}\/\d{2}\/\d{4}/)[0];
            var heure = responseObj.ResponseMessage.match(/\d{2}:\d{2}:\d{2}/)[0];
            var numeroTransaction = responseObj.ResponseMessage.match(/\d{3}-\d{7}-\d{2}/)[0];
            validationachat.style['display'] = 'block';
            success.style['display'] = 'block';
            btnSucces.style['display'] = 'block';
            btnEffectuer.style['display'] = 'none';
            $.ajax({
                url: 'partenaire/changeStatus?id='+idPayment+'&numeroTransaction=' + numeroTransaction,
                method: 'POST',
                data: '',
                dataType: 'json',
            }).success(function (response) {

            });


            return ResponseMessageObj;
            alert('ok');
        } else {

            var ResponseMessageObj = responseObj.ResponseMessage;
            var ResponseMessageObj = responseObj.ResponseMessage;
            error.style['display'] = 'block';
            document.querySelector('#error').innerHTML = ResponseMessageObj;

            // alert(JSON.stringify(ResponseMessageObj,null,4));alert('nnnnnnok');
        }



    }

    function loadDonsError() {

      //  alert("Erreur inattendue");

    }

}

function addDeviceParams(requestXML) {

    for (var item in appInfo) {
        requestXML += ' ' + item + '="' + appInfo[item] + '"';
    }

    requestXML += ' uniqueDeviceKey="42325819292526"';
    // if(localStorage.APP_LANG){
    // var app_lang = localStorage.APP_LANG;
    requestXML += ' LN="FR"';
    // }


    // printLogMessages("requestXML -->"+requestXML);
    return requestXML;
}

function getCurrentTiemstap() {

    if (localStorage.currentTime) {
        return localStorage.currentTime;
    } else {
        var Now = new Date();
        var currentTime = Now.getTime();
        localStorage.currentTime = currentTime;
        return currentTime;
    }

}

function makeAJAXCallValiderZuuluEncaissement(param, type, dataType, successCallback, errorCallback, formCustmer, pin, to_Custmer, to_pin, amountValidation,idPayment) {
    //printLogMessages("makeAJAXCall appInfo------>" + JSON.stringify(appInfo));
    // $("#footer_div").hide();
    //$(".header_class").hide();
    isAJAXAlive = true;
    // if (param.indexOf('></Request>') != -1) {

    //     var requestXML = param.split('></Request>');
    //     var requestData = addDeviceParams(requestXML[0]);
    //     param = requestData + '></Request>';
    //     // printLogMessages("requestData->" + param);
    // }

    $.ajax({
        type: type,
        cache: false,
        data: param,
        url: BASE_URL,
        dataType: dataType,
        timeout: timeout,
        beforeSend: function () {

        },
        success: function (response) {
            isAJAXAlive = false;
            // console.log("response xml-->" + (new XMLSerializer()).serializeToString(response));
            var responseObj = $.xml2json(response);
            // alert(JSON.stringify(responseObj,null,4));
            var res = responseObj.ResponseMessage;
            var errorPay = document.getElementById('errorPay');
            errorPay.style['display'] = 'none';
            if (responseObj.ResponseCode == "1020") {
                var res = responseObj.ResponseMessage;
                document.querySelector('#errorPay').innerHTML = res;
                errorPay.style['display'] = 'block';
                //openPage("AccountOTP");
                // $("#Payments_Loading").hide();
                // $("#servicePage_Loading").hide()
                // displayMultiLoginBox(responseObj.ResponseMessage);
                // alert(responseObj.ResponseMessage);


            } else {

                // if (localStorage.serviceFlag == "true") {
                // $("#footer_div").show();
                // }
                if (successCallback) {
                    successCallback(response);
                }

            }

            var date = responseObj.ResponseMessage.match(/\d{2}\/\d{2}\/\d{4}/)[0];
            var heure = responseObj.ResponseMessage.match(/\d{2}:\d{2}:\d{2}/)[0];
            var numeroTransaction = responseObj.ResponseMessage.match(/\d{3}-\d{7}-\d{2}/)[0];

            document.querySelector('#numeroTransaction').innerHTML = numeroTransaction;
            document.querySelector('#dateHeure').innerHTML = date+' à '+heure;
            
        },
        error: function (x, t, m) {
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


/****************************FIN PAIEMENT FACTURE ENCAISSEMENT via zuuluPay */



/****************************************************************************/

function invoiceSenelec(lang, customerReference, formCustmer, pin) {

    if (typeof (dataTable2Obj) != "undefined") {
        dataTable2Obj.destroy();
    }

    var listeDonsHTML = "";

    var montantTotalDons = parseFloat(0);

    var requestXML = '<?xml version="1.0" encoding="UTF-8" ?><Request ttType="R" custmerReference="' + customerReference + '"  FN="GEPPOI" fromPartnerId="' + formCustmer + '" fromCustmer="' + formCustmer + '" PIN="' + pin + '"></Request>';

    makeAJAXCallInvoiceSenelec(requestXML, "POST", "xml", loadDonsSuccess, loadDonsError, customerReference);



    function loadDonsSuccess(ResponseXML) {

        // $("#servicePage_Loading").hide();
        var responseObj = $.xml2json(ResponseXML);
        // printLogMessages("getAmountForCotisationSuccess-->" + JSON.stringify(responseObj));
        var reference = document.getElementById('reference');
        var factures = document.getElementById('factures');
        var error = document.getElementById('error');
        error.style['display'] = 'none';
        if (responseObj.ResponseStatus == "success") {
            var listeFactureHTML = "";
            var ResponseMessageObj = Array.isArray(responseObj.ResponseMessage.invoices.invoice)
                ? responseObj.ResponseMessage.invoices.invoice
                : [responseObj.ResponseMessage.invoices.invoice];
            // var res = JSON.stringify(ResponseMessageObj);
            // alert(res);
            reference.style['display'] = 'none';
            factures.style['display'] = 'block';
            console.log(ResponseMessageObj);
            invoices = ResponseMessageObj;
            for (var i = 0; i < invoices.length; i++) {
                listeFactureHTML += "<tr>";
                var obj = invoices[i];
                listeFactureHTML += "<td>" + obj['custmerReference'] + "</td>";
                listeFactureHTML += `<td>${formatCurrencyFacture(obj['amount'])}</td>`;
                listeFactureHTML += "<td>" + obj['invoiceNumber'] + "</td>";
                listeFactureHTML += "<td>" + obj['dueDate'] + "</td>";
                listeFactureHTML += `<td><button onclick="recupererFraisSenelec(${i})" name="submit" class="btn-sm btn-info pull-right">Payer</button></td>`;
                listeFactureHTML += "</tr>";

            }
            $("#exemple").html(listeFactureHTML);

            return ResponseMessageObj;
        } else {

            var ResponseMessageObj = responseObj.ResponseMessage;
            error.style['display'] = 'block';
            document.querySelector('#error').innerHTML = ResponseMessageObj;
            // alert(JSON.stringify(ResponseMessageObj,null,4));alert('nnnnnnok');
        }



    }

    function loadDonsError() {

      //  alert("Erreur inattendue");

    }

}

function makeAJAXCallInvoiceSenelec(param, type, dataType, successCallback, errorCallback, customerReference) {
    //printLogMessages("makeAJAXCall appInfo------>" + JSON.stringify(appInfo));
    // $("#footer_div").hide();
    //$(".header_class").hide();
    isAJAXAlive = true;
    if (param.indexOf('></Request>') != -1) {

        var requestXML = param.split('></Request>');
        var requestData = addDeviceParams(requestXML[0]);
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
        beforeSend: function () {

        },
        success: function (response) {
            isAJAXAlive = false;
            // console.log("response xml-->" + (new XMLSerializer()).serializeToString(response));
            var responseObj = $.xml2json(response);

            if (responseObj.ResponseCode == "1212") {
                //openPage("AccountOTP");
                // $("#Payments_Loading").hide();
                // $("#servicePage_Loading").hide()
                // displayMultiLoginBox(responseObj.ResponseMessage);
                // alert(responseObj.ResponseMessage);


            } else {

                // if (localStorage.serviceFlag == "true") {
                // $("#footer_div").show();
                // }
                if (successCallback) {
                    successCallback(response);
                }

            }
        },
        error: function (x, t, m) {
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

function recupererFraisSenelec(i) {
    // alert(JSON.stringify(invoices[i],null,4));
    var invoice = invoices[i];
    var id = invoice.id;
    var prenom = invoice.name;
    var montant = invoice.amount;
    var numeroFacture = invoice.invoiceNumber;
    var delai = invoice.dueDate;
    var custmerReference = invoice.custmerReference;
    var formCustmer = $('#formCustmer').val();
    var pin = $('#PIN').val();
    // alert("Nom: "+nom+"++++"+"Prénom: "+prenom+"Montant: "+montant+"numeroFacture: "+numeroFacture+"Delai: "+delai);
    var reponseAll = fraisSenelec("fr", id, prenom, montant, numeroFacture, delai, custmerReference, formCustmer, pin);
}

function fraisSenelec(lang, id, prenom, montant, numeroFacture, delai, custmerReference, formCustmer, pin) {

    if (typeof (dataTable2Obj) != "undefined") {
        dataTable2Obj.destroy();
    }

    var listeDonsHTML = "";

    var montantTotalDons = parseFloat(0);

    var requestXML = '<?xml version="1.0" encoding="UTF-8" ?><Request ttType="PostW" transferTypeId="326" amount="' + montant + '" custmerReference="' + custmerReference + '" FN="GPD" fromPartnerId="' + formCustmer + '" fromCustmer="' + formCustmer + '" PIN="' + pin + '"></Request>';

    makeAJAXCallFraisSenelec(requestXML, "POST", "xml", loadDonsSuccess, loadDonsError, id, prenom, montant, numeroFacture, delai, custmerReference);



    function loadDonsSuccess(ResponseXML) {
        // $("#servicePage_Loading").hide();
        var responseObj = $.xml2json(ResponseXML);
        // printLogMessages("getAmountForCotisationSuccess-->" + JSON.stringify(responseObj));
        var reference = document.getElementById('reference');
        var factures = document.getElementById('factures');
        var frais = document.getElementById('frais');
        var errorSenelec = document.getElementById('errorSenelec');


        if (responseObj.ResponseStatus == "success") {
            errorSenelec.style['display'] = 'none';
            reference.style['display'] = 'none';
            factures.style['display'] = 'none';
            frais.style['display'] = 'block';
            var ResponseMessageObj = responseObj.ResponseMessage;
            // var res = JSON.stringify(ResponseMessageObj);
            // alert(res);
            return ResponseMessageObj;
        } else {

            var ResponseMessageObj = responseObj.ResponseMessage;

            error.style['display'] = 'block';
            document.querySelector('#error').innerHTML = ResponseMessageObj;
            // alert(JSON.stringify(ResponseMessageObj,null,4));alert('nnnnnnok');
        }



    }

    function loadDonsError() {

        //alert("Erreur inattendue");

    }

}

function makeAJAXCallFraisSenelec(param, type, dataType, successCallback, errorCallback, id, prenom, montant, numeroFacture, delai, custmerReference) {
    //printLogMessages("makeAJAXCall appInfo------>" + JSON.stringify(appInfo));
    // $("#footer_div").hide();
    //$(".header_class").hide();
    isAJAXAlive = true;
    if (param.indexOf('></Request>') != -1) {

        var requestXML = param.split('></Request>');
        var requestData = addDeviceParams(requestXML[0]);
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
        beforeSend: function () {

        },
        success: function (response) {
            isAJAXAlive = false;
            // console.log("response xml-->" + (new XMLSerializer()).serializeToString(response));
            var responseObj = $.xml2json(response);
            var res = JSON.stringify(responseObj.ResponseMessage, null, 4);
            console.log(res);
            var frais = responseObj.ResponseMessage.TransactionCharges.Charge.feeAmount;
            document.querySelector('#referenceFacture').innerHTML = custmerReference;
            document.querySelector('#numeroFacture').innerHTML = numeroFacture;
            document.querySelector('#montantFacture').innerHTML = responseObj.ResponseMessage.Amount;
            document.querySelector('#fraisFacture').innerHTML = frais;
            document.querySelector('#totalconfirmation').innerHTML = responseObj.ResponseMessage.TotalAmount;
            document.querySelector('#delaiPaiement').innerHTML = delai;
            document.getElementById('convertmontant').value = responseObj.ResponseMessage.TotalAmount;
            document.getElementById('hiddenReferenceFacture').value = custmerReference;
            document.getElementById('hiddenNumeroFacture').value = numeroFacture;
            document.getElementById('hiddenIdFacture').value = id;
            document.getElementById('hiddenAmount').value = responseObj.ResponseMessage.UnformattedTotalAmount;
            if (responseObj.ResponseCode == "1212") {
                //openPage("AccountOTP");
                // $("#Payments_Loading").hide();
                // $("#servicePage_Loading").hide()
                // displayMultiLoginBox(responseObj.ResponseMessage);
                // alert(responseObj.ResponseMessage);


            } else {

                // if (localStorage.serviceFlag == "true") {
                // $("#footer_div").show();
                // }
                if (successCallback) {
                    successCallback(response);
                }

            }
        },
        error: function (x, t, m) {
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

function validationSenelec() {
    var custmerReference = $('#hiddenReferenceFacture').val();
    var numeroFacture = $('#hiddenNumeroFacture').val();
    var montant = $('#hiddenAmount').val();
    var postpaidInvoiceId = $('#hiddenIdFacture').val();
    var amountFCFA = $('#convertmontant').val();
    var formCustmer = $('#formCustmer').val();
    var pin = $('#PIN').val();
    var reponseAll = paySenelec("fr", custmerReference, montant, numeroFacture, postpaidInvoiceId, amountFCFA, formCustmer, pin);
    // alert("reference Facture: "+custmerReference+" numero Facture: "+numeroFacture+" montant Facture: "+montant+" id Facture: "+postpaidInvoiceId+"**"+amountFCFA);
}

function paySenelec(lang, custmerReference, montant, numeroFacture, postpaidInvoiceId, amountFCFA, formCustmer, pin) {

    if (typeof (dataTable2Obj) != "undefined") {
        dataTable2Obj.destroy();
    }

    var listeDonsHTML = "";

    var montantTotalDons = parseFloat(0);

    var requestXML = '<?xml version="1.0" encoding="UTF-8" ?><Request postpaidInvoiceId="' + postpaidInvoiceId + '" ttType="PostE" transferTypeId="323" amount="' + montant + '" invoiceNumber="' + numeroFacture + '" custmerReference="' + custmerReference + '" fromPartnerId="' + formCustmer + '" FN="WP" fromCustmer="' + formCustmer + '" PIN="' + pin + '"></Request>';

    makeAJAXCallValiderSenelec(requestXML, "POST", "xml", loadDonsSuccess, loadDonsError, custmerReference, montant, numeroFacture, postpaidInvoiceId, amountFCFA);



    function loadDonsSuccess(ResponseXML) {
        // $("#servicePage_Loading").hide();
        var responseObj = $.xml2json(ResponseXML);

        // printLogMessages("getAmountForCotisationSuccess-->" + JSON.stringify(responseObj));
        var reference = document.getElementById('reference');
        var factures = document.getElementById('factures');
        var frais = document.getElementById('frais');
        var success = document.getElementById('success');
        var error = document.getElementById('error');
        var cacherBouton = document.getElementById('cacherBouton');
        var cacherNumeroTransaction = document.getElementById('cacherNumeroTransaction');
        var menuservice = document.getElementById('menuservice');
        var errorSenelec = document.getElementById('errorSenelec');

        if (responseObj.ResponseStatus == "success") {
            var numeroTransaction = responseObj.ResponseMessage.match(/\d{3}-\d{7}-\d{2}/)[0];
            var type = "Paiement Senelec";
            errorSenelec.style['display'] = 'none';
            reference.style['display'] = 'none';
            factures.style['display'] = 'none';
            cacherBouton.style['display'] = 'none';
            success.style['display'] = 'block';
            cacherNumeroTransaction.style['display'] = 'block';
            frais.style['display'] = 'block';
            menuservice.style['display'] = 'block';
            $.ajax({
                url: 'finance/confirmationsenelec?code=aseneau&amount=' + montant + '&client=' + custmerReference + '&type=' + type + '&transaction=' + numeroTransaction + '&numeroFacture=' + numeroFacture + '&referenceClient=' + custmerReference,
                method: 'POST',
                data: '',
                dataType: 'json',
            }).success(function (response) {

            });
            //  alert(JSON.stringify(ResponseMessageObj,null,4));

            return ResponseMessageObj;
            alert('ok');
        } else {

            var ResponseMessageObj = responseObj.ResponseMessage;
            error.style['display'] = 'block';
            // alert(ResponseMessageObj);
            document.querySelector('#error').innerHTML = ResponseMessageObj;

            // alert(JSON.stringify(ResponseMessageObj,null,4));alert('nnnnnnok');
        }



    }

    function loadDonsError() {

       // alert("Erreur inattendue");

    }

}

function makeAJAXCallValiderSenelec(param, type, dataType, successCallback, errorCallback, custmerReference, montant, numeroFacture, postpaidInvoiceId, amountFCFA) {
    //printLogMessages("makeAJAXCall appInfo------>" + JSON.stringify(appInfo));
    // $("#footer_div").hide();
    //$(".header_class").hide();
    isAJAXAlive = true;
    if (param.indexOf('></Request>') != -1) {

        var requestXML = param.split('></Request>');
        var requestData = addDeviceParams(requestXML[0]);
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
        beforeSend: function () {

        },
        success: function (response) {
            isAJAXAlive = false;
            // console.log("response xml-->" + (new XMLSerializer()).serializeToString(response));
            var responseObj = $.xml2json(response);
            var errorSenelec = document.getElementById('errorSenelec');
            // console.log('-----------responseObj-----------');
            // console.log(responseObj);
            // alert(JSON.stringify(responseObj,null,4));
            // alert(responseObj.ResponseCode);
            errorSenelec.style['display'] = 'none';
            if (responseObj.ResponseCode == "1011") {
                errorSenelec.style['display'] = 'block';
                var ResponseMessageObj = responseObj.ResponseMessage;
                document.querySelector('#errorSenelec').innerHTML = ResponseMessageObj;

            } else {
                //alert(responseObj.ResponseMessage);
                // if (localStorage.serviceFlag == "true") {
                // $("#footer_div").show();
                // }
                if (successCallback) {
                    successCallback(response);
                }

            }
            var date = responseObj.ResponseMessage.match(/\d{2}\/\d{2}\/\d{4}/)[0];
            var heure = responseObj.ResponseMessage.match(/\d{2}:\d{2}:\d{2}/)[0];
            var numeroTransaction = responseObj.ResponseMessage.match(/\d{3}-\d{7}-\d{2}/)[0];

            // alert("**"+date+"$$$"+heure+"---"+numeroTransaction);
            document.querySelector('#idTransaction').innerHTML = numeroTransaction;
            document.querySelector('#dateHeure').innerHTML = date + " à " + heure;


        },
        error: function (x, t, m) {
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

function formatCurrencyFacture(number) {
    return (number || 0).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".") + ' FCFA';
}

function compteDebiteFrais(lang,type, formCustmer, pin) {

    if (typeof (dataTable2Obj) != "undefined") {
        dataTable2Obj.destroy();
    }
    var transfertTypeId = 1182;
if(type == 'service') {
    transfertTypeId = 1183;
}

    var requestXML = '<?xml version="1.0" encoding="UTF-8" ?><Request fromCustmer="' + formCustmer + '" toCustmer="' + toCustmer + '" ttType="" transferTypeId="' + transfertTypeId + '" reverse="false" isLocal="true" FN="GPD" amount="' + amount + '" PIN="' + pin + '" deviceModel="SM-E7000" devicePlatform="Android" deviceVersion="4.4.2" deviceManufacturer="samsung" packageName="com.zuulu.zuulu" versionNumber="1.0.5" isVirtualDevice="false" geoLatitude="" geoLongitude="" appClientName="Samba Diallo" appType="production" deviceIP="154.124.74.151" ipLocationCode="SN" uniqueDeviceKey="1608979848721" LN="FR"></Request>';

    makeAJAXCallFrais(requestXML, "POST", "xml", loadDonsSuccess, loadDonsError);



    function loadDonsSuccess(ResponseXML) {
        // $("#servicePage_Loading").hide();
        var responseObj = $.xml2json(ResponseXML);


        if (responseObj.ResponseStatus == "success") {
            var ResponseMessageObj = responseObj.ResponseMessage;
            //  var res = JSON.stringify(ResponseMessageObj);
            //  alert(res);
            return ResponseMessageObj;
        } else {

            var ResponseMessageObj = responseObj.ResponseMessage;
            error.style['display'] = 'block';
            document.querySelector('#error').innerHTML = ResponseMessageObj;
            // alert(JSON.stringify(ResponseMessageObj,null,4));alert('nnnnnnok');
        }



    }

    function loadDonsError() {

      //  alert("Erreur inattendue");

    }

}

function makeAJAXCallFrais(param, type, dataType, successCallback, errorCallback) {
    //printLogMessages("makeAJAXCall appInfo------>" + JSON.stringify(appInfo));
    // $("#footer_div").hide();
    //$(".header_class").hide();
    isAJAXAlive = true;
    if (param.indexOf('></Request>') != -1) {

        var requestXML = param.split('></Request>');
        var requestData = addDeviceParams(requestXML[0]);
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
        beforeSend: function () {

        },
        success: function (response) {
            isAJAXAlive = false;
             console.log("response xml-->" + (new XMLSerializer()).serializeToString(response));
            var responseObj = $.xml2json(response);
            var compteEncaissement;
            var compteService;
            var comptePayroll;
            var solde;
            var temp = responseObj.ResponseMessage.split("|");
            for (i = 0; i < temp.length; i++) {
                var courant = temp[i];
                if (courant.indexOf("Services") != -1) {
                    compteService = courant.split(":")[1];
                    solde = courant.split(":")[1];
                    compteService = compteService.replace(/,[0-9]+/, '').replace(',', '.').trim();
                }
                else if (courant.indexOf("Encaissements") != -1) {
                    compteEncaissement = courant.split(":")[1];
                    compteEncaissement = compteEncaissement.replace(/,[0-9]+/, '').replace(',', '.').trim();
                }
                else if (courant.indexOf("Payroll") != -1) {
                    comptePayroll = courant.split(":")[1];
                    comptePayroll = comptePayroll.replace(/,[0-9]+/, '').replace(',', '.').trim();
                }
            }

            if(compteService === undefined){
                compteService = " ";
            }
            if(compteEncaissement === undefined){
                compteEncaissement = " ";
            }


            document.querySelector('#soldeDisponible').innerHTML = compteService;
            document.querySelector('#soldeEncaissement').innerHTML = compteEncaissement;
            document.querySelector('#soldePrincipal').innerHTML = 'Solde disponible ' + compteService;
            document.getElementById('soldeServiceInitial').value = compteService;
            document.getElementById('soldeEncaissementInitial').value = compteEncaissement;
            // document.querySelector('#solde').innerHTML = solde;
            // alert("Compte Encaissement "+compteEncaissement+ " Compte Service "+compteService+ " Compte Payroll "+comptePayroll );

            if (responseObj.ResponseCode == "1212") {
                //openPage("AccountOTP");
                // $("#Payments_Loading").hide();
                // $("#servicePage_Loading").hide()
                // displayMultiLoginBox(responseObj.ResponseMessage);
                // alert(responseObj.ResponseMessage);


            } else {

                // if (localStorage.serviceFlag == "true") {
                // $("#footer_div").show();
                // }
                if (successCallback) {
                    successCallback(response);
                }

            }
        },
        error: function (x, t, m) {
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