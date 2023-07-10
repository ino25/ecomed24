
$(document).ready(function () {
    $('#dis_id').keyup(function () {
        var val_dis = 0;
        var amount = 0;
        var ggggg = 0;
        amount = $('#subtotal').val();
        val_dis = this.value;
        var mutuelle = $('#charge_mutuelle').val();

        ggggg = amount - val_dis - mutuelle;

        $('#editPaymentForm').find('[name="grsss"]').val(ggggg)


        var amount_received = $('#amount_received').val();
        var change = amount_received - ggggg;
        $('#editPaymentForm').find('[name="change"]').val(change).end()

    });
});



$(document).ready(function () {

    $('#createPatient').click(function () {
        $.ajax({
            url: 'patient/addNewJson',
            method: 'POST',
            data: {
                name: $('#name').val(), last_name: $('#last_name').val(), address: $('#address').val(), phone: $('#phone').val(), sex: $('#sex').val(), birthdate: $('#birthdate').val(),
                region: $('#region').val(), email: $('#email').val(), nom_mutuelle: $('#nom_mutuelle').val(), nom_mutuelle_text: $('#nom_mutuelle').text(), num_police: $('#num_police').val(), date_valid: $('#date_valid').val(), charge_mutuelle: $('#charge_mutuelle_patient').val()
                , type: $('#type').val(), partenaire: $('#partenaire').val()
            },
            dataType: 'json',
            //  delai: 250
            success: function (response) {

                if (response.result) {
                    var name = response.name + ' ' + '(ID Patient: ' + response.patient_id + ')';
                    var patient_opt = new Option(name, response.id, true, true);
                    $('#editPaymentForm').find('[name="patient"]').append(patient_opt).trigger('change');

                } else {
                    html += '<div class=""><b>Erreur</b></div>';
                }

                $('#myModaladdPatient').trigger("reset");
                $('#myModaladdPatient').modal('hide');
            },
            error: function (request, status, error) {
                alert(request.responseText);
            }
        });
        return false;
    });
    // $('.multi-select').multiSelect('select_all');
    $('.multi-select').multiSelect('deselect_all');
    $('.multi-select').multiSelect('refresh');
    // var spartenaire = $( "#choicepartenaire" ).length ? document.getElementById("choicepartenaire").checked : null;

    $('.add_service').change(function () {
        chargeListePrestation();

    });

    $('#pos_select').change(function () {

        // alert("case 1");
        var id = $(this).val();
        $('.add_service').empty();
        $(".qfloww2").html("");
        $("#subtotal").val("0");
        $("#remarks").val("");
        $("#remarksId").val("");
        $("#remarksType").val("");
        $("#charge_mutuelle").val("0");
        $("#gross").val("0");

        // if ($("#spartenaire").val() == '') {
        if ($("#spartenaire").val() == null || $("#spartenaire").val() == '') {

            if (id != 'add_new') {
                var opt = '';
                $('.multi-select').multiSelect('refresh');
                //$('.multi-select').multiSelect('select_all');

                $.ajax({
                    url: 'finance/editMutuelleFinanceByJason?patient=' + id,
                    method: 'GET',
                    data: '',
                    dataType: 'json',
                    // delai: 250
                }).success(function (response) {
                    // alert("id_assurance: "+JSON.stringify(response));
                    // alert(response.services.length);
                    console.log(response);
                    $('select.multi-select').empty();
                    $('.info-mutuelle').empty();
                    $('#remarks').val('');
                    $('#remarksId').val('');
                    $('#remarksType').val('');
                    // var tt = new Date();
                    var tt = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate());
                    var now = tt.getTime();
                    console.log('-----------response-------0-----');
                    console.log(response);
                    var charge = 0;
                    var is_assurrance = false;
                    var is_ipm = false;
                    var remise = 0;
                    if (response.lien_parente) {
                        //secondaire
                        var html = '<div class="">' + response.lien_parente + ' de ' + response.mutuelles_relationInit.name + ' ' + response.mutuelles_relationInit.last_name + '</div>';
                        if (response.mutuellesInit) {
                            var datepm = response.mutuellesInit.pm_datevalid;
                            var nom = '';
                            if (response.mutuellesInit.nom) {
                                nom = response.mutuellesInit.nom;
                            }
                            html += '<div class=""><b>Tiers payant: </b>' + nom + '</div>';
                            html += '<div class=""><b>Numero: </b>' + response.mutuellesInit.pm_numpolice + '</div>';
                            html += '<div class=""><b>Prise en charge %: </b>' + response.mutuellesInit.pm_charge + '</div>';
                            html += '<div class=""><b>Date de validite: </b>' + response.mutuellesInit.pm_datevalid + '</div>';
                            if (response.mutuellesInit.type == "IPM") {
                                is_ipm = true;
                            } else if (response.mutuellesInit.type == "Assurance") {
                                is_assurrance = true;
                            }
                            charge = response.mutuellesInit.pm_charge;
                            var parts = datepm.split("/");

                            var userEnteredDateISO = parts[2] + "-" + parts[1] + "-" + parts[0];
                            // var userEnteredDateObj = new Date(userEnteredDateISO).getTime();
                            var userEnteredDateObj = new Date(userEnteredDateISO);
                            // if (userEnteredDateObj < now) {
                            if (userEnteredDateObj < tt) {
                                html += '<div class=""><b class="btn-danger">La date de validité est dépassée.</b></div>';
                            }
                            $('#remarks').val(response.mutuellesInit.nom);
                            $('#remarksId').val(response.mutuellesInit.pm_idmutuelle);
                            $('#remarksType').val(response.mutuellesInit.type);

                        } else {
                            html += '<div class=""><b>Aucun Tiers payant.</b></div>';
                        }

                    } else {
                        // pricipa
                        console.log(response.mutuelles);
                        var html = '<div class=""></div>';
                        if (response.mutuelles && response.mutuelles.nom) {
                            var datepm = response.mutuelles.pm_datevalid;
                            var nom = '';
                            if (response.mutuelles.nom) {
                                nom = response.mutuelles.nom;
                            }
                            html += '<div class=""><b>Tiers payant: </b>' + nom + '</div>';
                            html += '<div class=""><b>Numero: </b>' + response.mutuelles.pm_numpolice + '</div>';
                            html += '<div class=""><b>Prise en charge %: </b>' + response.mutuelles.pm_charge + '</div>';
                            html += '<div class=""><b>Date de validité: </b>' + datepm + '</div>';

                            if (response.mutuelles.type == "IPM") {
                                is_ipm = true;
                            } else if (response.mutuelles.type == "Assurance") {
                                is_assurrance = true;
                            }
                            charge = response.mutuelles.pm_charge;

                            var parts = datepm.split("/");

                            var userEnteredDateISO = parts[2] + "-" + parts[1] + "-" + parts[0];
                            // var userEnteredDateObj = new Date(userEnteredDateISO).getTime();
                            var userEnteredDateObj = new Date(userEnteredDateISO);
                            // if (userEnteredDateObj < now) {
                            if (userEnteredDateObj < tt) {
                                html += '<div class=""><b class="btn-danger">La date de validité est dépassée.</b></div>';
                            }
                            $('#remarks').val(response.mutuelles.nom);
                            $('#remarksId').val(response.mutuelles.pm_idmutuelle);
                            $('#remarksType').val(response.mutuelles.type);
                        } else {
                            html += '<div class=""><span>Aucun Tiers payant.</span></div>';
                        }



                    }
                    html += '<input type="hidden" id="charge" value="' + charge + '" />';

                    if (!html) {
                        html = '<div class=""><span>Aucun Tiers payant.</span></div>';
                    }
                    $('.info-mutuelle').append(html);
                    // alert(response.services.length);
                    $.each(response.services, function (key, value) {
                        var price_final = parseInt(value.tarif_public);
                        var price_pro = parseInt(value.tarif_professionnel);
                        var remise = 0;

                        if (value.est_couverte != "0") {
                            if (is_ipm) {
                                price_final = parseInt(value.tarif_ipm);
                                //  price_final = parseInt(value.tarif_assurance) -  parseInt(value.tarif_assurance) * parseInt(charge)/100;
                                remise = parseInt(parseInt(value.tarif_ipm) * parseInt(charge) / 100);
                            }
                            else if (is_assurrance) {
                                price_final = parseInt(value.tarif_assurance);
                                //  price_final = parseInt(value.tarif_assurance) -  parseInt(value.tarif_assurance) * parseInt(charge)/100;
                                remise = parseInt(parseInt(value.tarif_assurance) * parseInt(charge) / 100);
                            }
                        }

                        $('select.multi-select').append($('<option class="ooppttiioonn" data-id="' + price_final + '" data-pro="' + price_pro + '" data-idd="' + value.id + '" data-spec_name="' + value.name_specialite + '" data-cat_name="' + value.prestation + '"  data-remise="' + remise + '"  >' + value.prestation + '</option>').text(value.name_specialite + " > " + value.prestation).val(value.name_specialite + " > " + value.prestation));

                    });
                    $('.multi-select').multiSelect('refresh');

                });
                $('.ms-selectable input.search-input').attr('placeholder', 'Selectionnez une prestation');
            }
        }
        // chargeListePrestation();
    });

    $('.multi-select').change(function () {


        // alert("case 2");
        if ($('#pos_select').val()) {
            // if ($('#pos_select').val() && $('.add_service').val()) {
            var tot = 0;
            //  $(".qfloww").html("");
            var list_id = '';
            var list_qt = '';
            $(".ms-selected").click(function () {


                var idd = $(this).data('idd');
                var remise = $(this).data('remise');

                var id_categoryinput = '#categoryinput-' + idd;
                var is_categoryinput = $(id_categoryinput).val();
                if (is_categoryinput) {
                    // alert("idPrestation "+idd);
                    $('#divv' + idd).remove();
                    $('#idinput-' + idd).remove();
                    $('#categoryinput-' + idd).remove();
                    var mutuelle = parseInt($('#charge_mutuelle').val());
                    if (mutuelle > 0) {
                        var curr_remise = mutuelle - remise;
                        var tott = $('#charge_mutuelle').val() - remise;

                        $('#editPaymentForm').find('[name="charge_mutuelle"]').val(curr_remise);
                        $('#editPaymentForm').find('[name="grsss"]').val(tott)
                    }
                    var list_id_old = $('#list_id').val();

                    var list_id_new = list_id_old.replace('|' + idd, '');
                    $('#list_id').val(list_id_new);
                    var curr_val_old = $(this).data('id');
                    var tot = parseInt($('#subtotal').val()) - parseInt(curr_val_old);
                    var gross = parseInt($('#gross').val()) - parseInt(curr_val_old);
                    //var gross = tot - discount - mutuelle;
                    $('#editPaymentForm').find('[name="subtotal"]').val(tot).end()
                    $('#editPaymentForm').find('[name="grsss"]').val(gross);
                }
            });
            $.each($('select.multi-select option:selected'), function () {
                // console.log('---------- INO RESPONSE ------------');
                // console.log($(this).data());
                // console.log('---------- INO RESPONSE ------------');

                var val = $(this).val();
                // alert(val);
                var curr_val = $(this).data('id');

                var idd = $(this).data('idd');
                //  tot = tot + curr_val;
                var cat_name = $(this).data('cat_name');

                var id_categoryinput = '#categoryinput-' + idd;
                var is_categoryinput = $(id_categoryinput).val();

                if ($('#idinput-' + idd).length) {

                } else {
                    if ($('#id-div' + idd).length) {

                    } else {
                        if (!is_categoryinput) {
                            var spartenaire = $("#spartenaire").val();
                            var lightpartenaire = $("#lightpartenaire").val();
                            var price = parseInt($(this).data('id'));
                            var remise = parseInt($(this).data('remise'));

                            if (lightpartenaire) {
                                var price = parseInt($(this).data('pro'));
                                var liste_article = '<div class="col-md-12 left0" id="divv' + idd + '" >';
                                liste_article += '<div class="col-md-4 remove1_" id="id-div' + idd + '" id="id-remise' + idd + '">  ' + $(this).data("spec_name") + " > " + $(this).data("cat_name") + '</div>';

                                liste_article += '<input type="text" class="col-md-4 remove pull-left" id="price_final-' + idd + '" name="price_final[]" value="' + price + '">';
                                //liste_article += '<i class="col-md-2 remove pull-left fa fa-trash" id="delete-' + idd + '" />';
                                liste_article += '<i class="col-md-2 remove pull-left fa fa-trash delete" id="delete-' + idd + '" data-val="' + val + '"  data-remise="' + remise + '"  data-price="' + price + '" onclick="deletePresta(' + idd + ')" />';
                                liste_article += '<input type="hidden" class="remove" id="idinput-' + idd + '" name="quantity[]" value="1">';
                                liste_article += '<input type="hidden" class="remove" id="categoryinput-' + idd + '" name="category_id[]" value="' + idd + '">';
                                liste_article += '</div>';


                            } else {

                                var remise = $(this).data('remise');
                                var price_final = parseInt(price) - parseInt(remise);
                                // var price = vv;//.replace('.000000', '');
                                var prestation2 = $(this).data("cat_name");
                                if(prestation2 === "RECHERCHE D’ARN DU SARS-COV2 (qRT-PCR)"){
                                    document.getElementById('patientTestCovid').style.display = 'block';
                                    document.getElementById('renseignementClinique').style.display = 'none';
                                    $('#patientPassport').prop('required', true);
                                    $('#motifVoyage').prop('required', true);
                                }else{
                                    document.getElementById('patientTestCovid').style.display = 'none';
                                    document.getElementById('renseignementClinique').style.display = 'block';
                                    $('#patientPassport').prop('required', false);
                                    $('#motifVoyage').prop('required', false);
                                }
                                
                                var liste_article = '<div class="col-md-12 left0" id="divv' + idd + '" >';
                                liste_article += '<div class="col-md-4 remove1_" id="id-div' + idd + '" id="id-remise' + idd + '">  ' + $(this).data("spec_name") + " > " + $(this).data("cat_name") + '</div>';
                                liste_article += '<input type="text" class="col-md-2 remove pull-left" id="price-' + idd + '" name="price[]" value="' + price + '">';
                                liste_article += '<input type="text" class="col-md-3 remove pull-left" id="remise-' + idd + '" name="remise[]" value="' + remise + '">';
                                liste_article += '<input type="text" class="col-md-2 remove pull-left" id="price_final-' + idd + '" name="price_final[]" value="' + price_final + '">';
                                liste_article += '<i class="col-md-1 remove pull-left fa fa-trash delete" id="delete-' + idd + '"  data-val="' + val + '"    data-remise="' + remise + '"  data-price="' + price + '" onclick="deletePresta(' + idd + ')" />';
                                liste_article += '<input type="hidden" class="remove" id="idinput-' + idd + '" name="quantity[]" value="1">';
                                liste_article += '<input type="hidden" class="remove" id="categoryinput-' + idd + '" name="category_id[]" value="' + idd + '">';
                                liste_article += '</div>';
                            }


                            list_id = $('#list_id').val() + "|" + idd;
                            var list_id_remplace = list_id.startsWith("|") ? list_id.substring(1) : list_id;
                            $('#list_id').val(list_id_remplace);
                            $("#editPaymentForm .qfloww2").append(liste_article);

                            //var curr_remise = $(this).data('remise');

                            var curr_remise = parseInt(remise) + parseInt($('#charge_mutuelle').val());
                            $('#editPaymentForm').find('[name="charge_mutuelle"]').val(curr_remise)


                            var discount = $('#dis_id').val();
                            var mutuelle = $('#charge_mutuelle').val();
                            var sub_total = $(this).data('id') * 1;//$('#idinput-' + idd).val();

                            tot = parseInt($('#subtotal').val()) + sub_total;

                            if (lightpartenaire) {
                                var sub_total = $(this).data('pro') * 1;//$('#idinput-' + idd).val();
                                tot = parseInt($('#subtotal').val()) + sub_total;
                            }


                            if (lightpartenaire) {
                                var gross = tot - discount;
                            } else {
                                var gross = tot - discount - mutuelle;
                            }

                            $('#editPaymentForm').find('[name="subtotal"]').val(tot).end()

                            $('#editPaymentForm').find('[name="grsss"]').val(gross)
                            $('#editPaymentForm').find('[name="discount"]').val(discount)
                            var amount_received = $('#amount_received').val();
                            var change = amount_received - gross;
                            $('#editPaymentForm').find('[name="change"]').val(change).end()

                        }

                    }

                }




            });

        }/* else {
         
         alert("Veuiller Renseigner le service et le patient.");
         }*/
    }

    );
});

$(document).ready(function () {
    $('#dis_id').keyup(function () {
        var val_dis = 0;
        var amount = 0;
        var ggggg = 0;
        amount = $('#subtotal').val();
        val_dis = this.value;
        var mutuelle = $('#charge_mutuelle').val();

        ggggg = amount - mutuelle - val_dis;


        $('#editPaymentForm').find('[name="grsss"]').val(ggggg)


        var amount_received = $('#amount_received').val();
        var change = amount_received - ggggg;
        $('#editPaymentForm').find('[name="change"]').val(change).end()





    });
});










$(document).ready(function () {

    $(document.body).on('change', '#pos_select', function () {

        var v = $("select.pos_select option:selected").val();
        if (v == 'add_new') {
            $('#myModaladdPatient').trigger("reset");
            $('#myModaladdPatient').modal('show');
        } else {

            $('#myModaladdPatient').modal('hide');
        }
    });

    $("#nom_mutuelle").select2({
        placeholder: "Choisir un assurreur",
        allowClear: true,
        ajax: {
            url: 'patient/getMutuelleInfo',
            type: "post",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    searchTerm: params.term // search term
                };
            },
            processResults: function (response) {
                return {
                    results: response
                };
            },
            cache: true
        }

    });

});


$(document).ready(function () {

    $("#spartenaire").select2({
        placeholder: 'Selectionnez un partenaire',
        allowClear: true,
        ajax: {
            url: 'partenaire/searhPartenaire',
            type: "post",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    searchTerm: params.term // search term
                };
            },
            processResults: function (response) {
                return {
                    results: response
                };
            },
            cache: true
        }

    });
    $("#lightpartenaire").select2({
        placeholder: 'Selectionnez un partenaire',
        allowClear: true,
        ajax: {
            url: 'partenaire/searhPartenaireLight',
            type: "post",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    searchTerm: params.term // search term
                };
            },
            processResults: function (response) {
                return {
                    results: response
                };
            },
            cache: true
        }

    });

    $("#add_service").select2({
        placeholder: 'Selectionnez un service',
        allowClear: true,
        ajax: {
            // url: 'services/getSericeinfoByJason',
            url: 'services/getServicesInfoByJson',
            type: "post",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    searchTerm: params.term, organisation: $("#spartenaire").val() // search term
                };
            },
            processResults: function (response) {
                return {
                    results: response
                };
            },
            cache: true
        }

    });
    $('.ms-selectable input.search-input').attr('placeholder', 'Selectionnez une prestation');


});

function chargeListePrestation(search = '') {
    // alert("case 3");
    var spartenaire = document.getElementById("choicepartenaire").checked;
    var id_service_specialite_organisation = $('.add_service').val();
    var patient = $('#pos_select').val();
    var is_assurrance = false;
    var is_ipm = false;
    var lightpartenaire = $("#lightpartenaire").val();
    is_assurrance = $('#remarks').val() && $("#remarksType").val() == "Assurance" ? true : false;
    is_ipm = $('#remarks').val() && $("#remarksType").val() == "IPM" ? true : false;
    var assurance_id = $('#remarksId').val() ? $('#remarksId').val() : "0";
    var id_organisation = $('#spartenaire').val();




    if (!spartenaire) {

        var opt = '';
        if (patient && patient != 'add_new') {
            $('.multi-select').multiSelect('refresh');
            $('.multi-select').multiSelect('deselect_all');

            $.ajax({
                url: 'finance/editMutuelleFinanceByJason?patient=' + patient + '&id_service_specialite_organisation=' + id_service_specialite_organisation + "&id_assurance=" + assurance_id + "&search=" + search, // CHANGE DONE
                method: 'GET',
                data: '',
                async: false,
                dataType: 'json',
                // delai: 250
            }).success(function (response) {

                // console.log(JSON.stringify(response.services));
                $('select.multi-select').empty();

                console.log('-----------response------------');
                console.log(response);

                
                
                var remise = 0;
                // alert(response.services.length);
                $.each(response.services, function (key, value) {
                    var price_final = parseInt(value.tarif_public);

                    if (lightpartenaire) {
                        var price_pro = parseInt(value.tarif_professionnel);
                    }

                    // // alert(is_ipm);
                    // alert(is_assurrance);
                    if (is_ipm) {
                        // Check si prestation assurée ou pas
                        // Si prestation assurée
                        // alert(value.est_couverte);
                        if (value.est_couverte != "0") {
                            price_final = parseInt(value.tarif_ipm);
                        } else {// Sinon: tarif_public
                            price_final = parseInt(value.tarif_public);
                        }
                        //  price_final = parseInt(value.tarif_assurance) -  parseInt(value.tarif_assurance) * parseInt(charge)/100;
                        var charge = $('#charge').val();
                        // Check si prestation assurée ou pas
                        // Si prestation assurée
                        if (value.est_couverte != "0") {
                            remise = parseInt(parseInt(value.tarif_ipm) * parseInt(charge) / 100);
                        } else { // Sinon: pas de remise
                            remise = 0;
                        }
                    }
                    else if (is_assurrance) {

                        // Check si prestation assurée ou pas
                        // Si prestation assurée
                        if (value.est_couverte != "0") {
                            price_final = parseInt(value.tarif_assurance);
                        } else {// Sinon: tarif_public
                            price_final = parseInt(value.tarif_public);
                        }
                        //  price_final = parseInt(value.tarif_assurance) -  parseInt(value.tarif_assurance) * parseInt(charge)/100;
                        var charge = $('#charge').val();
                        // Check si prestation assurée ou pas
                        // Si prestation assurée
                        if (value.est_couverte != "0") {
                            remise = parseInt(parseInt(value.tarif_assurance) * parseInt(charge) / 100);
                        } else { // Sinon: pas de remise
                            remise = 0;
                        }
                    }
                    $('select.multi-select').append($('<option class="ooppttiioonn" data-id="' + price_final + '" data-pro="' + price_pro + '" data-idd="' + value.id + '" data-spec_name="' + value.name_specialite + '" data-cat_name="' + value.prestation + '" data-motcles="' + value.keywords + '"  data-remise="' + remise + '"  >' + value.prestation + '</option>').text(value.name_specialite + " > " + value.prestation).val(value.name_specialite + " > " + value.prestation));

                });

                $('.multi-select').multiSelect('refresh');
                $('.ms-selectable input.search-input').attr('placeholder', 'Selectionnez une prestation');
            });
        } else {
            alert('Veuillez choisir un patient---.');
        }

    }

    else {

        $('.multi-select').multiSelect('refresh');
        $('.multi-select').multiSelect('deselect_all');
        $.ajax({
            // url: 'finance/editTproFinanceByJason?organisation=' + spartenaire + '&service=' + idServicePrestationSpecialite, // CHANGEMENT A FAIRE EGALEMENT
            url: 'finance/editTproFinanceByJason?organisation=' + spartenaire + '&id_service_specialite_organisation=' + id_service_specialite_organisation + "&search=" + search + "&id_organisation=" + id_organisation,
            method: 'GET',
            data: '',
            dataType: 'json',
            // delai: 250
        }).success(function (response) {
            console.log(response);
            $('select.multi-select').empty();

       
            var remise = 0;
            if (response.services) {
                
                $.each(response.services, function (key, value) {

                    var tarif_professionnel = parseInt(value.tarif_professionnel);
                    var tarif_public = parseInt(value.tarif_public);

                    $('select.multi-select').append($('<option class="ooppttiioonn" data-id="' + tarif_public + '" data-idd="' + value.id + '" data-spec_name="' + value.name_specialite + '" data-motcles="' + value.keywords + '" data-cat_name="' + value.prestation + '"  data-remise="0"  >' + value.prestation + '</option>').text(value.name_specialite + " > " + value.prestation).val(value.name_specialite + " > " + value.prestation));
                });
            }
            $('.multi-select').multiSelect('refresh');
            $('.ms-selectable input.search-input').attr('placeholder', 'Selectionnez une prestation');
        });
    }

    $('.ms-selectable input.search-input').attr('placeholder', 'Selectionnez une prestation');
}
function deletePresta(idd) {

    var id_delete = '#delete-' + idd;
    var id_categoryinput = '#categoryinput-' + idd;
    var is_categoryinput = $(id_categoryinput).val();
    var curr_remise = 0;
    var remise = $(id_delete).data('remise');
    var val = $(id_delete).data('val');
    var price = $(id_delete).data('price');

    var lightpartenaire = $("#lightpartenaire").val();
    if (is_categoryinput) {
        $('#divv' + idd).remove();
        $('#idinput-' + idd).remove();
        $('#categoryinput-' + idd).remove();
        var mutuelle = parseInt($('#charge_mutuelle').val());
        if (mutuelle > 0) {
            curr_remise = parseInt(mutuelle) - parseInt(remise);
            var tott = parseInt($('#charge_mutuelle').val()) - parseInt(remise);

            $('#editPaymentForm').find('[name="charge_mutuelle"]').val(curr_remise);
            //  $('#editPaymentForm').find('[name="grsss"]').val(tott)
        }
        var list_id_old = $('#list_id').val();

        var list_id_new = list_id_old.replace('|' + idd, '');
        $('#list_id').val(list_id_new);

        var tot = parseInt($('#subtotal').val()) - parseInt(price);
        if (lightpartenaire) {
            var gross = parseInt(tot);
        } else {
            var gross = parseInt(tot) - curr_remise;
        }
        if (!tot) { tot = 0 }
        $('#editPaymentForm').find('[name="subtotal"]').val(tot).end()
        $('#editPaymentForm').find('[name="grsss"]').val(gross);

        $('.multi-select').multiSelect('deselect', val);
    }
}
