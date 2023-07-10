
<!--sidebar end-->
<!--main content start-->
<section id="main-content"  >
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="panel">
            <header class="panel-heading" style="margin-top:41px;">
               
                <h2>Actes</h2>
            </header>

            <div class="panel-body panel-bodyAlt">
                <div class="adv-table editable-table ">
                    <table cellspacing="5" cellpadding="5" border="0">
                        <tbody>
                            <tr>
<?php if ($this->ion_auth->in_group(array('adminmedecin','Doctor','Laboratorist','Assistant'))) { ?>
                                <td class="mode-bars">
                                    <a href="finance/paymentLabo">   <i class="fas fa-list-ol"></i> Afficher par prestation</a> 
                                </td>
                                  <?php } ?>
                                <td class="mode-bars active">
                                    <a href="finance/payment">   <i class="fal fa-grip-vertical"></i> Afficher par dossier</a> 
                                </td>
                                <td>Type: </td>
                                <td>
                                    <select class="form-control" name="modeType" id="modeType">
                                        <option value=""> Tout </option>
                                        <option value="new"> <?php echo lang('new_'); ?> </option>
                                        <option value='pending'> <?php echo lang('pending_'); ?> </option>
                                        <option value='done'> <?php echo lang('done_'); ?> </option>
                                        <option value='valid'> <?php echo lang('valid_'); ?> </option>
                                        <option value='finish'> <?php echo lang('finish_'); ?> </option>
                                        <option value="cancelled"> ANNULÉ </option>
                                    </select>
                                </td>
                            </tr>
                            <tr>


                            </tr>
                        </tbody>
                    </table>
                    <div class="space15"></div>
                    <table class="table table-hover progress-table editable-sample editable-sample-paiement" id="editable-sample">
                        <thead>
                            <tr> <th></th><th></th>
                                 <th><?php echo lang('invoice_id'); ?></th>
                                <th><?php echo lang('date'); ?></th>
                                <th><?php echo lang('patient'); ?></th>
                                <th><?php echo lang('grand_total'); ?></th>
                                <th><?php echo lang('amount'); ?>
                                <?php echo lang('paid'); ?></th>
                                <th><?php echo lang('amount_to_be_paid'); ?></th>
                                <th><?php echo lang('status'); ?></th>
                               
                                <th class="option_th no-print"><?php echo lang('options'); ?></th>

                            </tr>
                        </thead>
                        <tbody>

                        <style>

                            .img_url{
                                height:20px;
                                width:20px;
                                background-size: contain; 
                                max-height:20px;
                                border-radius: 100px;
                            }
                            .option_th{
                                width:18%;
                            }

                        </style>

                        </tbody>
                    </table>
                </div>
            </div>
        </section>
        <!-- page end-->
    </section>
</section>
<!--main content end-->
<!--footer start-->
<!--main content end-->
<div class="modal fade" id="infoModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title" id="myModalLabel">Infos Patient</h4>
            </div>
            <div class="modal-body">
                <center>
                    <div class="col-md-12 patientImgClass">
                    </div>

                    <h3 class="media-heading"><span class="nameClass"></span> <span class="lastnameClass"></span><small> <span class="regionClass"></span> </small></h3>
                    <p><strong> <?php echo lang('number'); ?>: </strong> <span class="patientIdClass"></span> </p>
                    <span class="label label-primary"><i class='fa fa-user'></i> <span class="genderClass"></span></span>

                    <span class="label label-info"> <i class='fa fa-phone'></i> <span class="phoneClass"></span></span>

                    <span class="label label-success"> <i class='fa fa-envelope'></i> <span class="emailClass"> </span> </span>





                </center>
                <hr>
                <div class='row'>
                    <div class="form-group col-md-4">
                        <label><?php echo lang('age'); ?></label>
                        <div class="ageClass"></div>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="exampleInputEmail1"><?php echo lang('address'); ?></label>
                        <div class="addressClass"></div>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="exampleInputEmail1"><?php echo lang('region'); ?></label>
                        <div class="regionClass"></div>
                    </div>
                </div>
                <div class='row'>
                    <div class="form-group col-md-4">
                        <label><?php echo lang('birth_date'); ?></label>
                        <div class="birthdateClass"></div>
                    </div>

                    <div class="form-group col-md-4">
                        <label><?php echo lang('birth_position'); ?></label>
                        <div class="birth_positionClass"></div>
                    </div>
                    <div class="form-group col-md-4">
                        <label><?php echo lang('matricule'); ?></label>
                        <div class="matriculeClass"></div>
                    </div>
                </div>
                <div class='row'>
                    <div class="form-group col-md-4">
                        <label><?php echo lang('grade'); ?></label>
                        <div class="gradeClass"></div>
                    </div>
                    <div class="form-group col-md-4">
                        <label><?php echo lang('nom_contact'); ?></label>
                        <div class="nom_contactClass"></div>
                    </div>
                    <div class="form-group col-md-4">
                        <label><?php echo lang('phone_contact'); ?></label>
                        <div class="phone_contactClass"></div>
                    </div>
                </div>
                <div class='row'>
                    <div class="form-group col-md-4">
                        <label><?php echo lang('religion'); ?></label>
                        <div class="religionClass"></div>
                    </div>



                    <div class="form-group col-md-4">
                    </div>
                    <div class="form-group col-md-4">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <center>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><?php echo lang('close'); ?></button>
                </center>
            </div>
        </div><!-- /.modal-content -->

    </div><!-- /.modal-dialog -->
</div>
<div class="modal fade" id="myModaldone" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-paiement">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title myModaldoneTitle" id="myModaldoneTitle">  <?php echo lang('choice_done'); ?></h4>
            </div>
            <div class="modal-body" id="modal-body">
                <h5 style="color: #303f9f;margin-bottom: 10px;"></h5>
                <div class="single-table">
                    <div class="table-responsive">
                        <table id="dataTable" class="table table-bordered table-hover dataTable">
                            <thead class="text-uppercase">
                                <tr>
                                    <th scope="col">
                                   <!-- <input id="all-checkbox" type="checkbox" onchange="toggleSelectAll()">-->
                                    </th>
                                    <th scope="col">DATE</th> <th scope="col">PATIENT</th> <th scope="col">SERVICE</th>
                                    <th scope="col" style="width:200px">PRESTATION</th>
                                    <th scope="col">STATUT</th>
                                </tr>
                            </thead><tbody id="deposit-checkDone">

                            <div class="form-group" >  </div>


                            </tbody></table>
                        <form  action="finance/changeStatusPrestation" id="deposit-checkDepot" class="clearfix" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="idPrestation" id="idPrestation" value=""> <input type="hidden" name="payment" id="payment" value="" >  <input type="hidden" name="type" id="type" value="" >
                            <table class="col-md-12"> <tr class="form-group   right-six col-md-12"><td  class="col-md-6 pull-left">
                                        <button type="button" class="btn btn-info btn-secondary pull-left" data-dismiss="modal" aria-hidden="true"> <?php echo lang('close'); ?></button>
                                    </td><td class="col-md-6 pull-right"><button type="submit" name="submit" class="btn btn-info submit_button pull-right" id="myModaldoneSubmit" disabled = "true"><?php echo lang('done'); ?></button>
                                    </td></tr></table>
                        </form>

                    </div>
                </div>
            </div>
        </div>  
    </div>
</div>




<div class="modal fade" id="myModaldeposit2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">  <?php echo lang('add_deposit'); ?></h4>
            </div>
            <div class="modal-body">
                <form role="form" action="finance/checkDepot" id="deposit-checkDepot" class="clearfix" method="post" enctype="multipart/form-data">
                    <div class="form-group"> 
                        <label for="exampleInputEmail1"><?php echo lang('invoice'); ?></label> 
                        <select class="form-control m-bot15" id="paymentid" name="paymentid" > 

                        </select>
                    </div>

                    <div class="form-group">
                        <label><?php echo lang('reste_a_payer'); ?> : <span id="reste" ></span> <?php echo $settings->currency; ?></label>

                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1"><?php echo lang('deposit_amount'); ?></label>
                        <input type="text" class="form-control money" name="deposited" id="deposited" onkeyup="recuperationDepot(event)" value='' placeholder="">
                    </div>
                    <div class="form-group">
                        <input  type="hidden" class="form-control" name="deposited_amount" id="deposited_amount" value='' placeholder="">
                    </div>
                    <div class="form-group">
                        <div class="payment_label pull-left">
                            <label for="exampleInputEmail1"><?php echo lang('deposit_type'); ?></label>
                        </div>
                        <div class="">
                            <select class="form-control m-bot15 js-example-basic-single selecttype" id="selecttype" name="deposit_type" value=''>
                                <?php if ($this->ion_auth->in_group(array('admin','adminmedecin', 'Accountant', 'Receptionist','Assistant'))) { ?>
                                    <option value="Cash"> <?php echo lang('cash'); ?> </option>
                                    <option value="OrangeMoney"> <?php echo lang('orange_money'); ?> </option>
                                    <option value="zuulupay" disabled=""> <?php echo lang('zuulupay'); ?> </option>
                                    <option value="" disabled=""> <?php echo lang('carte_bancaire'); ?> </option>
                                    <option value="" disabled=""> <?php echo lang('demande'); ?> </option>
                                <?php } ?>

                            </select>
                        </div>
                    </div>



                    <input type="hidden" name="id" value=''>
                    <input type="hidden" name="patient" id="patient" value=''>
                    <input type="hidden" name="redirect" value='finance/payment'>
                    <div class="form-group cashsubmit payment  right-six col-md-12">
                        <button type="button" class="btn btn-info btn-secondary pull-left" data-dismiss="modal" aria-hidden="true"> <?php echo lang('close'); ?></button>
                        <button type="submit" name="submit2" id="submit1" class="btn btn-info row pull-right"> <?php echo lang('submit'); ?></button>
                    </div>

                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<div class="modal fade" id="datalabModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content" id="datalab">
            
        </div>
          </div>
      </div>

<div class="modal fade" id="sttChangeModal"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog payment-content">
        <div class="">
    <span id="btnPrintGenerik" class="btn btn-light border text-black-50 shadow-none"><i class="fa fa-print"></i> <?php echo lang('print'); ?> </span>
    <span id="btnDownloadGenerik" class="btn btn-light border text-black-50 shadow-none"><i class="fa fa-download"></i>  <?php echo lang('download'); ?> </span> 
    <span type="button" class="btn btn-light border text-black-50 shadow-none pull-right" data-dismiss="modal" aria-hidden="true"><i class="fa fa-clone"></i>  <?php echo lang('close'); ?></span>
</div>
        
        <div class="modal-content" id="sttChangeModalHtml" >

        </div>
    </div>
</div>

<script src="<?php echo base_url(); ?>common/js/codearistos.min.js"></script>

<script src="https://unpkg.com/imask"></script>
<script src="https://cdn.jsdelivr.net/npm/autonumeric@4.6.0/dist/autoNumeric.min.js"></script>


<script>

    var autoNumericInstance = new AutoNumeric.multiple('.money', {
        // currencySymbol: "Fcfa",
        // currencySymbolPlacement: "s",
        // emptyInputBehavior: "min",
        // selectNumberOnly: true,
        // selectOnFocus: true,
        overrideMinMaxLimits: 'invalid',
        emptyInputBehavior: "min",
        maximumValue: '100000',
        minimumValue: "0",
        decimalPlaces: 0,
        decimalCharacter: ',',
        digitGroupSeparator: '.'
    });

    function recuperationDepot(event){
        var amount = $('#deposited').val();
        var amountFormat = amount.replace(/[^\d]/g, '');
        document.getElementById('deposited_amount').value = amountFormat;

    }
</script>
<script>





    $(document).ready(function () {

        $(".flashmessage").delay(3000).fadeOut(100);
    });</script>

<?php
$status = '';
if (isset($_GET['status'])) {
    $status = $_GET['status'];
}
?>

<script>

    $(document).ready(function () {

        var table = $('#editable-sample').DataTable({
            responsive: true,
            //   dom: 'lfrBtip',

            "processing": true,
            "serverSide": true,
            "searchable": true,
            "ajax": {
                url: "finance/getPayment?status=<?php echo $status; ?>&all=true",
                type: 'POST',
            },
            scroller: {
                loadingIndicator: true
            },
            fixedHeader: true,
            dom: "<'row'<'col-sm-4 pull-left'l><'col-sm-4 pull-left'B><'col-sm-4 pull-right'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-5'i><'col-sm-7'p>>",
            buttons: {
               buttons: [
                    // {
                    // extend: 'pageLength',
                    // },
                    // {
                        // extend: 'excelHtml5',
                        // className: 'dt-button-icon-left dt-button-icon-excel',
                        // exportOptions: {
                            // columns: [1, 2, 3, 4, 5, 6, 7, 8, 9],
                        // }
                    // },
                    // {
                        // extend: 'pdfHtml5',
                        // className: 'dt-button-icon-left dt-button-icon-pdf',
                        // exportOptions: {
                            // columns: [1, 2, 3, 4, 5, 6, 7, 8, 9],
                        // }
                    // },
                ],
                dom: {
                    button: {
                        className: 'h4 btn btn-secondary dt-button-custom'
                    }
                    ,
                    buttonLiner: {
                        tag: null
                    }
                }
            },
            lengthMenu: [[10, 25, 50, 100, -1], ['10', '25', '50', '100', 'Tout afficher']],
            iDisplayLength: 10,
            "order": [[1, "desc"]],

            "language": {
                "processing": "<div style='margin:-10px'><span style='margin:-10px' class='fa-stack fa-lg'>\n\
                            <i  style='margin:-10px' class='fa fa-spinner fa-spin fa-stack-2x fa-fw'></i>\n\
                       </span>&emsp;Traitement en cours ...</div>",
                // "select": {
                //     "rows": {
                //         _: '%d rows selected',
                //         0: 'Click row to select',
                //         1: '1 row selected'
                //     }
                // },
                // processing: "Traitement en cours...",
                // processing: "<span class='fa-stack fa-lg'>\n\
                //             <i class='fa fa-spinner fa-spin fa-stack-2x fa-fw'></i>\n\
                //        </span>&emsp;Processing ...",
                search: "_INPUT_",
                lengthMenu: "Afficher _MENU_ &eacute;l&eacute;ments",
                info: "Affichage de l'&eacute;lement _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
                infoEmpty: "Affichage de l'&eacute;lement 0 &agrave; 0 sur 0 &eacute;l&eacute;ments",
                infoFiltered: "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
                infoPostFix: "",
                loadingRecords: "Chargement en cours...",
                zeroRecords: "Aucun &eacute;l&eacute;ment &agrave; afficher",
                emptyTable: "", //emptyTable: "Aucune donnée disponible dans le tableau",
                paginate: {
                    first: "Premier",
                    previous: "Pr&eacute;c&eacute;dent",
                    next: "Suivant",
                    last: "Dernier"
                },
                aria: {
                    sortAscending: ": activer pour trier la colonne par ordre croissant",
                    sortDescending: ": activer pour trier la colonne par ordre décroissant"
                },
                buttons: {
                    pageLength: {
                        _: "Afficher %d éléments",
                        '-1': "Tout afficher"
                    }
                }

            }

            // language: {
            //     "url": "common/assets/DataTables/languages/<?php echo $this->language; ?>.json?<?php echo time(); ?>",
            //     processing: "Traitement en cours...",
            //     search: "_INPUT_",
            //     lengthMenu: "Afficher _MENU_ &eacute;l&eacute;ments",
            //     info: "Affichage de l'&eacute;lement _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
            //     infoEmpty: "Affichage de l'&eacute;lement 0 &agrave; 0 sur 0 &eacute;l&eacute;ments",
            //     infoFiltered: "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
            //     infoPostFix: "",
            //     loadingRecords: "Chargement en cours...",
            //     zeroRecords: "Aucun &eacute;l&eacute;ment &agrave; afficher",
            //     emptyTable: "", //emptyTable: "Aucune donnée disponible dans le tableau",
            //     paginate: {
            //         first: "Premier",
            //         previous: "Pr&eacute;c&eacute;dent",
            //         next: "Suivant",
            //         last: "Dernier"
            //     },
            //     aria: {
            //         sortAscending: ": activer pour trier la colonne par ordre croissant",
            //         sortDescending: ": activer pour trier la colonne par ordre décroissant"
            //     },
            //     buttons: {
            //         pageLength: {
            //             _: "Afficher %d éléments",
            //             '-1': "Tout afficher"
            //         }
            //     }
            // }
        });
        table.buttons().container().appendTo('.custom_buttons');
        table.columns([0,1]).visible(false);

        $('#modeType').click(function() {
            var typeMode = $('#modeType').val();
            table.search(typeMode).draw() ;
           // table.columns(0).search(typeMode).draw();
            
        });

        // $('#modeType').click(function () {
        //     var typeMode = $('#modeType').val();
        //     table.columns(0).search(typeMode).draw();
        // });

       

        /* $('#modeTypeService').click( function() {
         var typeMode = $('#modeTypeService').val(); 
         table.search(typeMode).draw() ;
         } );
         */
         $(".editlab").click(function(e) {
            e.preventDefault(e);
            var id = $(this).attr('data-id');
           
        });
    });
  function editlab(payment) {
   $('#datalabModal').trigger("reset");$('#datalab').empty();
            $('#datalabModal').modal('show');
            $.ajax({
                url: 'lab/editLabByJasonPayment?payment=' + payment,
                method: 'GET',
                data: '',
                dataType: 'json',
            }).success(function(response) {
                $('#datalab').append(response);
            });
  }

    function depositbutton(payment) {
        var id = "#depot" + payment;
        var patient = $(id).attr('data-patient');
        var payment = $(id).attr('data-payment');
        $('#myModaldeposit2').trigger("reset");
        $('#myModaldeposit2').modal('show');
        var amount_received = $(id).attr('data-amount_received');
        var gross_total = $(id).attr('data-gross_total');
        var reste = gross_total - amount_received;
        $('#myModaldeposit2').find('[id="reste"]').html(reste).end();
        $('#myModaldeposit2').find('[id="patient"]').html(patient).end();
        var option1 = new Option(payment, payment, true, true);
        $('#myModaldeposit2').find('[name="paymentid"]').append(option1).trigger('change');
    }

    function donebutton(payment) {
        var id = "#carry" + payment;
        $('#myModaldone').trigger("reset");
        $('#deposit-checkDone').html('')
        $.ajax({
            url: 'finance/editStatutPaiementByJasonDone?id=' + payment + '&type=2',
            method: 'GET',
            data: '',
            dataType: 'json'
        }).success(function (response) {
            console.log(response.result);
            $('#myModaldone').find('[id="payment"]').val(payment).end();
            $('#myModaldone').find('[id="type"]').val(2).end();
            $('#deposit-checkDone').html(response.result);


            $('#myModaldone').modal('show');
        });
    }

    function pendingbuttonJson(payment) {
        $.ajax({
            url: 'finance/editStatutPaiementByJasonPending?id=' + payment + '&type=1',
            method: 'GET',
            data: '',
            dataType: 'json'
        }).success(function (response) {
            if (response.result) {

                var id = '#status-change' + payment;
                var tt = '<span class="status-p bg-primary"> <?php echo lang("pending_") ?> </span>';
                $(id).empty().html(tt);
               // if (response.profil) {
                    var idspanpending = '#spanpending' + payment;
                    //var htmlspanpending = '<button id="done' + payment + '" class="green btn" onclick="donebutton(' + payment + ')"  ><i class="fa  fa-hourglass-half"></i> <?php echo lang("done") ?></button>';
                    var htmlspanpending = '';//<a id="done2" class="green btn payment" href="finance/getPendingIBydActe?id=' + response.patient + '&payment=' + payment + '&prestation=all"><i class="fa  fa-hourglass-half"></i> <?php echo lang("done") ?></a>';
                    $(idspanpending).empty().html(htmlspanpending);
              //  }
                $('#sttChangeModal').modal('hide');
            }
        });
    }
    function pendingbutton(payment) {
       /* var html = ' <div class="modal-header">';
        html += '<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>';
        html += '<h4 class="modal-title">  <?php echo lang('change_stt'); ?></h4>';
        html += '</div>';
        html += '<div class="modal-body">';
        html += ' <form role="form" action="#" id="deposit-checkDepot" class="clearfix" method="post" enctype="multipart/form-data">';
        html += '<div class="form-group"> ';
        html += ' <label for="exampleInputEmail1"><?php echo lang('stt_encours'); ?></label> ';

        html += '  </div>';


        html += '<div class="form-group cashsubmit payment  right-six col-md-12">';
        html += ' <button type="button" class="btn btn-info btn-secondary pull-left" data-dismiss="modal" aria-hidden="true"> <?php echo lang('close'); ?></button>';
        html += ' <button type="button" name="submit2" id="pendingbutton" onclick="pendingbuttonJson(' + payment + ')"   class="btn btn-info row pull-right"> <?php echo lang('submit'); ?></button>';
        html += '  </div>';
        html += ' </form>';
        html += ' </div>';

        $('#sttChangeModal').trigger("reset");
        $('#sttChangeModalHtml').html(html);
        $('#sttChangeModal').modal('show');*/
    
    pendingbuttonJson(payment);
    }


    function validbutton(payment) {
        var id = "#carry" + payment;
        $('#myModaldone').trigger("reset");
        $('#deposit-checkDone').html('')
        $.ajax({
            url: 'finance/editStatutPaiementByJasonValid?id=' + payment + '&type=3',
            method: 'GET',
            data: '',
            dataType: 'json'
        }).success(function (response) {
            console.log(response.result);
            document.getElementById('myModaldoneSubmit').disabled = true;
            $('#myModaldone').find('[id="payment"]').val(payment).end();
            $('#myModaldone').find('[id="type"]').val(3).end();
            $('#myModaldone').find('[id="myModaldoneTitle"]').html("<?php echo lang('choice_valid'); ?>").end();
            $('#myModaldone').find('[id="myModaldoneSubmit"]').html("<?php echo lang('valid'); ?>").end();
            $('#deposit-checkDone').html(response.result);


            $('#myModaldone').modal('show');
        });
    }
    function finishbuttonJson(payment) {
        $.ajax({
            url: 'finance/editStatutPaiementByJasonFinish?id=' + payment + '&type=4',
            method: 'GET',
            data: '',
            dataType: 'json'
        }).success(function (response) {
            if (response.result) {
                // $('#sttChangeModal').trigger("reset");   $('#sttChangeModal').modal('show');

                var id = '#status-change' + payment;
                var tt = '<span class="status-p bg-success"> <?php echo lang("finish_") ?> </span>';
                $(id).empty().html(tt);

                var idspanpending = '#finish' + payment; $(idspanpending).empty();
                 var spanpending = '#spanpending' + payment; $(spanpending).empty();
                $('#sttChangeModal').modal('hide');
            }
        });
    }

    function finishbutton(payment) {
       /* var html = ' <div class="modal-header">';
        html += '<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>';
        html += '<h4 class="modal-title">  <?php echo lang('change_stt'); ?></h4>';
        html += '</div>';
        html += '<div class="modal-body">';
        html += ' <form role="form" action="#" id="deposit-checkDepot" class="clearfix" method="post" enctype="multipart/form-data">';
        html += '<div class="form-group"> ';
        html += ' <label for="exampleInputEmail1"><?php echo lang('stt_finish'); ?></label> ';

        html += '  </div>';


        html += '<div class="form-group cashsubmit payment  right-six col-md-12">';
        html += ' <button type="button" class="btn btn-info btn-secondary pull-left" data-dismiss="modal" aria-hidden="true"> <?php echo lang('close'); ?></button>';
        html += ' <button type="button" name="submit2" id="finishbutton" onclick="finishbuttonJson(' + payment + ')"   class="btn btn-info row pull-right"> <?php echo lang('submit'); ?></button>';
        html += '  </div>';
        html += ' </form>';
        html += ' </div>';

        $('#sttChangeModal').trigger("reset");
        $('#sttChangeModalHtml').html(html);
        $('#sttChangeModal').modal('show');

*/
    finishbuttonJson(payment);
    }

    var n = 0;
    function toggleSelect(i) {
        console.log('items[i]', i);
        var check = 'check' + i;
        var id = document.getElementById(check).value + ',';
        console.log(id);
        var items = document.getElementById(check).checked;
        var idPrestation_old = document.getElementById('idPrestation').value;
        console.log("avant--n---**" + n);
        console.log(idPrestation_old);
        if (items) {
            items = false;
            idPrestation_old = idPrestation_old + id;
            n++;
        } else {
            items = true;
            idPrestation_old = idPrestation_old.replace(id, '');
            n--;
        }

        document.getElementById('idPrestation').value = idPrestation_old;
        console.log("apres--n--***" + n);
        console.log(idPrestation_old);
        if (n > 0) {
            document.getElementById('myModaldoneSubmit').disabled = false;
        } else {
            document.getElementById('myModaldoneSubmit').disabled = true;
        }
    }

    function toggleSelectAll() {
        var items = document.getElementById("all-checkbox").checked;
        var idPrestation = "";
        if (items) {
            items = false;
            document.querySelectorAll('#dataTable * input.statusPresta').forEach(function (elt) {
                elt.checked = true;
                var id = elt.value;// var id = idcheck.replace('check','');
                idPrestation = idPrestation + "," + id;
                n++;
            });
        } else {
            items = true;
            document.querySelectorAll('#dataTable * input.statusPresta').forEach(function (elt) {
                elt.checked = false;
                n--;
                idPrestation = "";
            });
        }
        document.getElementById('idPrestation').value = idPrestation;
        console.log("apres--");
        console.log(idPrestation);
        if (n > 0) {
            document.getElementById('myModaldoneSubmit').disabled = false;
        } else {
            document.getElementById('myModaldoneSubmit').disabled = true;
        }
    }



</script>

<script type="text/javascript">
    function infosPatient(id){
        var iid = id;
        $("#img1").attr("src", "uploads/cardiology-patient-icon-vector-6244713.jpg");

        $('.patientImgClass').html("").end();
        $('.patientIdClass').html("").end();
        $('.nameClass').html("").end();
        $('.lastnameClass').html("").end();
        $('.emailClass').html("").end();
        $('.addressClass').html("").end();
        $('.phoneClass').html("").end();
        $('.genderClass').html("").end();
        $('.birthdateClass').html("").end();
        $('.ageClass').html("").end();
        $('.bloodgroupClass').html("").end();
        $('.matriculeClass').html("").end();

        $('.doctorClass').html("").end();
        $('.gradeClass').html("").end();
        $('.birth_positionClass').html("").end();
        $('.nom_contactClass').html("").end();
        $('.phone_contactClass').html("").end();
        $('.religionClass').html("").end();
        $('.regionClass').html("").end();

        $.ajax({
            url: 'patient/getPatientByJason?id=' + iid,
            method: 'GET',
            data: '',
            dataType: 'json',
        }).success(function(response) {
            // Populate the form fields with the data returned from server

            // alert(JSON(response.patient.img_url));
            var img_tag = JSON.stringify(response.patient.img_url) !== "null" ? "<img class='avatar' src='" + response.patient.img_url + "' alt='' style='max-width: 200px; max-height: 150px;margin-bottom:10px;'>" : "<img class='avatar' src='uploads/imgUsers/contact-512.png' alt='' style='max-width: 200px; max-height: 150px;margin-bottom:10px;'>";
            // alert(img_tag);
            $('.patientImgClass').append(img_tag).end();
            // alert($('.patientImgClass').html());
            $('.patientIdClass').append(response.patient.patient_id).end();
            $('.nameClass').append(response.patient.name).end();
            $('.lastnameClass').append(response.patient.last_name).end();
            $('.emailClass').append(response.patient.email).end();
            $('.addressClass').append(response.patient.address).end();
            $('.phoneClass').append(response.patient.phone).end();
            $('.genderClass').append(response.patient.sex).end();
            $('.birthdateClass').append(response.patient.birthdate).end();
            $('.ageClass').append(response.patient.age).end();
            $('.bloodgroupClass').append(response.patient.bloodgroup).end();

            $('.matriculeClass').append(response.patient.matricule).end();
            $('.gradeClass').append(response.patient.grade).end();
            $('.birth_positionClass').append(response.patient.birth_position).end();
            $('.nom_contactClass').append(response.patient.nom_contact).end();
            $('.phone_contactClass').append(response.patient.phone_contact).end();
            $('.religionClass').append(response.patient.religion).end();
            $('.regionClass').append(response.patient.region).end();

            if (response.doctor !== null) {
                //    $('.doctorClass').append(response.doctor.name).end()
            } else {
                //     $('.doctorClass').append('').end()
            }

            // if (typeof response.patient.img_url !== 'undefined' && response.patient.img_url != '') {
            // $("#img1").attr("src", response.patient.img_url);
            // }


            $('#infoModal').modal('show');

        });
    }
</script>