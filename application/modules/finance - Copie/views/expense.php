<!--sidebar end-->
<!--main content start-->

<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="panel">
            <header class="panel-heading" style="margin-top:41px;">
            
                <div class="col-md-4 no-print pull-right"> 
                    <a  href="finance/addExpenseView">
                        <div class="btn-group pull-right">
                            <button id="" class="btn green btn-xs">
                                <i class="fa fa-plus-circle"></i> <?php echo lang('add_expense2'); ?>
                            </button>
                        </div>
                    </a>
                </div>
                <h2>Dépenses</h2>
            </header>
            <!-- <section class="col-md-9 no-print row">
                <form role="form" class="f_report" action="/finance/expensePaymentHistory" method="post" enctype="multipart/form-data">
                    <div class="form-group" style="margin-left:5%">
                        <div class="col-md-6">
                            <div class="input-group input-large" data-date="13/07/2013" data-date-format="mm/dd/yyyy">
                                <input type="text" class="form-control dpd1" name="date_from" value="<?php
                                if (!empty($date_from)) {
                                    echo date('m/d/Y', $date_from);
                                }
                                ?>" placeholder="<?php echo lang('date_from'); ?>" readonly="">
                                <span class="input-group-addon"><?php echo lang('to'); ?></span>
                                <input type="text" class="form-control dpd2" name="date_to" value="<?php
                                if (!empty($date_to)) {
                                    echo date('m/d/Y', $date_to);
                                }
                                ?>" placeholder="<?php echo lang('date_to'); ?>" readonly="">
                                <input type="hidden" class="form-control dpd2" name="category" value="">
                            </div>
                            <div class="row"></div>
                            <span class="help-block"></span> 
                        </div>
                        <div class="col-md-6 no-print">
                            <button type="submit" name="submit" class="btn btn-info range_submit"><?php echo lang('submit'); ?></button>
                        </div>
                    </div>
                </form>
            </section> -->
            <div class="panel-body panel-bodyAlt">
                <div class="adv-table editable-table">
                    <div class="space15"></div>
                    <table border="0" cellspacing="5" cellpadding="5">
                        <tbody>
                            <tr>
                                <td>Type: </td>
                                <td><select class="form-control" name="modeType" id="modeType">
                                    <option value=""> Tout </option>
                                    <option value="Achat Crédit"> Achat Crédit </option>
                                    <option value="Achat Woyofal"> Achat Woyofal </option>
                                    <option value="Paiement SenEau"> Paiement SenEau </option>
                                    <option value="Paiement Senelec"> Paiement Senelec </option>
                                    <option value="codeCourante"> Autres </option>
                                </select>
                                </td>
                            </tr>
                            <tr>

                            </tr>
                        </tbody>
                    </table>
                    <table class="table table-hover progress-table" id="editable-sample">
                        <thead>
                            <tr>
                                 <th>ID</th>
                                 <th><?php echo lang('date'); ?></th>
                                 <th><?php echo lang('type_depense'); ?></th>
                                 <th><?php echo lang('beneficiaire'); ?></th>
                                 <th><?php echo lang('amount'); ?></th>
                                <th><?php echo lang('reference_service'); ?></th>
                                <th class="no-print"><?php echo lang('options'); ?></th>
                                <td syle="display:none"></td>
                            </tr>
                        </thead>
                        <tbody>
                             <?php foreach ($expenses as $expense) { 
                                   if ($this->ion_auth->in_group(array('admin','adminmedecin'))) {
                $options1 = ' <a class="btn btn-info btn-xs editbutton" title="' . lang('edit') . '" href="finance/editExpense?id=' . $expense->id . '"><i class="fa fa-edit"> </i></a>';
            }

            $options2 = '<a class="btn btn-info btn-xs invoicebutton" title="' . lang('invoice') . '" style="color: #fff;" href="finance/expenseInvoice?id=' . $expense->id . '"><i class="fa fa-file-invoice"></i> </a>';
            //$options4 = '<a class="btn btn-info btn-xs invoicebutton" title="' . lang('print') . '" style="color: #fff;" href="finance/printInvoice?id=' . $payment->id . '"target="_blank"> <i class="fa fa-print"></i> ' . lang('print') . '</a>';
            if ($this->ion_auth->in_group(array('admin','adminmedecin'))) {
                $options3 = '<a class="btn btn-info btn-xs delete_button" title="' . lang('delete') . '" href="finance/deleteExpense?id=' . $expense->id . '" onclick="return confirm(\'Are you sure you want to delete this item?\');"><i class="fa fa-trash"></i> </a>';
            }

            if (empty($options1)) {
                $options1 = '';
            }

            if (empty($options3)) {
                $options3 = '';
            }

     if ($expense->status == '2') { $options1 = ''; $options3 = ''; }   
                                 
                                 
                                 ?>
                            <tr class="" >
                                <td style="vertical-align:middle;"><?php echo $expense->codeFacture; ?> </td>
                                <td style="vertical-align:middle;"><?php echo $expense->datestring; ?> </td>
                                <td style="vertical-align:middle;"><?php echo $expense->category; ?></td>   
                                <td style="vertical-align:middle;"><?php echo $expense->beneficiaire; ?> </td>
                                <td style="vertical-align:middle;" ><span class="money"><?php echo $expense->amount; ?></span> FCFA</td>
                                <!--<td style="vertical-align:middle;"><?php echo $expense->note; ?></td>-->
                                <!--<td style="vertical-align:middle;"><span style='font-weight:300;'><?php echo $expense->category == 'Achat Woyofal' ? "Compteur:" : ($expense->category == "Achat Crédit" ? "Portable:" : ($expense->category == "Paiement Senelec" || $expense->category == "Paiement SenEau" ? "Client:" : "")); ?></span> <?php echo $expense->referenceClient; ?><span style='font-weight:300;'><?php echo $expense->category == 'Achat Woyofal' ? "<br/>Code:" : ($expense->category == "Achat Crédit" ? "" : ($expense->category == "Paiement Senelec" || $expense->category == "Paiement SenEau" ? "<br/>Facture:" : "")); ?></span> <?php echo ($expense->category == "Achat Woyofal" ? $expense->note : $expense->numeroFacture); ?><?php if($expense->category == "Achat Crédit" || $expense->category == "Paiement Senelec" || $expense->category == "Paiement SenEau" || $expense->category == "Achat Woyofal") { ?><br><span style='font-weight:300;'>ID zuuluPay:</span> <?php echo $expense->numeroTransaction; ?><?php } ?></td>-->
								<td style="vertical-align:middle;" ><?php if($expense->category == "Achat Crédit" || $expense->category == "Paiement Senelec" || $expense->category == "Paiement SenEau" || $expense->category == "Achat Woyofal") { ?><span style='font-weight:300;'>ID zuuluPay:</span><br/> <?php echo $expense->numeroTransaction; ?><?php } ?></td>
                                <td style="vertical-align:middle;"><?php echo $options2; ?></td>
                                <td style="display:none"><?php echo $expense->codeType; ?></td>
                                
                               
                            </tr>
                        <?php } ?>
                        <style>

                            .img_url{
                                height:20px;
                                width:20px;
                                background-size: contain; 
                                max-height:20px;
                                border-radius: 100px;
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


<script src="<?php echo base_url(); ?>common/js/codearistos.min.js"></script>
<script src="<?php echo base_url(); ?>common/js/autoNumeric.min.js"></script>
<script> 
 $(document).ready(function () {
    var autoNumericInstance = new AutoNumeric.multiple('.money', {
    // currencySymbol: "Fcfa",
    // currencySymbolPlacement: "s",
// emptyInputBehavior: "min",
// selectNumberOnly: true,
// selectOnFocus: true,
overrideMinMaxLimits: 'invalid',
emptyInputBehavior: "min",
  //  maximumValue : '100000',
  //  minimumValue : "100",
decimalPlaces : 0,
    decimalCharacter : ',',
    digitGroupSeparator : '.'
});

 });

</script>
<script>


    $(document).ready(function () {
        var table = $('#editable-sample').DataTable({
             responsive: true,

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
							// columns: [0,1,2,3,4],
						// }
					// },
					// {
						// extend: 'pdfHtml5',
						// className: 'dt-button-icon-left dt-button-icon-pdf',
						// exportOptions: {
							// columns: [0,1,2,3,4],
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
            // "order": [[0, "desc"]],
            aaSorting:[],
			language: {
                "url": "common/assets/DataTables/languages/<?php echo $this->language; ?>.json?<?php echo time(); ?>",
                    processing: "Traitement en cours...",
                    search: "_INPUT_",
                    lengthMenu: "Afficher _MENU_ &eacute;l&eacute;ments",
                    info: "Affichage de l'&eacute;lement _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
                    infoEmpty: "Affichage de l'&eacute;lement 0 &agrave; 0 sur 0 &eacute;l&eacute;ments",
                    infoFiltered: "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
                    infoPostFix: "",
                    loadingRecords: "Chargement en cours...",
                    zeroRecords: "Aucun &eacute;l&eacute;ment &agrave; afficher",
                    emptyTable: "",//emptyTable: "Aucune donnée disponible dans le tableau",
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
        });
        table.buttons().container().appendTo('.custom_buttons');     
        $('#modeType').click( function() {
            var typeMode = $('#modeType').val(); 
            table.search(typeMode).draw() ;
        } );
    });

</script>
   