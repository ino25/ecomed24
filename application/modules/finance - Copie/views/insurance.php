Payment<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="panel">
            <header class="panel-heading">
                <div class="col-md-5 no-print pull-right"> 
                    <a href="finance/addInsuranceView">
                        <div class="btn-group pull-right">
                            <button id="" class="btn green btn-xs">
                                <i class="fa fa-plus-circle"></i> Ajouter un tiers-payant
                            </button>
                        </div>
                    </a>
                </div>
                <h2>Tiers-Payants</h2>
            </header>
            <div class="panel-body panel-bodyAlt">
                <div class="adv-table editable-table "> 
                    <div class="space15"></div>
                    <table class="table table-hover progress-table" id="editable-sample">
                        <thead>
							<tr>
								<th style="width:10px !important;"><?php echo lang('logo'); ?></th>
								<th style="">Nom</th>
								<th style="">Type</th>
								<th style="">Adresse</th>
								<th style="">Statut Partenariat</th>
								<th class="no-print" style="">Actions</th>
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

                        </style>


                        </tbody>
                    </table>
                </div>
            </div>
        </section>
        <!-- page end-->
    </section>
</section>


<?php //foreach ($tiers_payant as $tiers) {
//	$options_edit= "";
//	// $options_edit = '<a class="button" class="btn btn-xs btn_widt btn-liste" title="Modifier Organisation"  href="home/superEditOrganisation?id=' . $tiers->idTiersPayant . '"><i class="fa fa-edit"></i> </a>';
//	$options_edit .= '<a class="btn btn-info btn-xs editbutton" style="margin-left:15px;"  title="Couverture Prestations"  href="finance/insuranceCoverage?id=' . $tiers->idPartenariat . '"><i class="fa fa-medkit"></i>&nbsp;&nbsp;Couverture Prestations</a>';
//
//	$status = '';
//	if ($tiers->partenariat_actif == '1') {
//		$status = '<span class="status-p bg-success2">ACTIF</span>';
//		// $status = '';
//	} else {
//		$status = '<span class="status-p bg-success2">INACTIF</span>';
//	}
//
//	$img_url = '';
//	if ($tiers->pathLogoTiersPayant && !empty($tiers->pathLogoTiersPayant)) {
//		$img_url = '<img style="max-width:200px;max-height:90px;" src="'.$tiers->pathLogoTiersPayant.'" alt="Lgo">';
//	} else {
//		$img_url = '<img style="max-width:200px;max-height:90px;" src="uploads/logosPartenaires/default.png" alt="Lgo">';
//	}
//
//	?>
<!--    <tr class="" >-->
<!--        <td style="vertical-align:middle;"> --><?php //echo $img_url; ?><!--</td>-->
<!--        <td style="vertical-align:middle;">--><?php //echo $tiers->nomTiersPayant; ?><!--</td>-->
<!--        <td style="vertical-align:middle;"> --><?php //echo $tiers->typeTiersPayant; ?><!--</td>-->
<!--        <td style="vertical-align:middle;" >--><?php //echo $tiers->adresseTiersPayant; ?><!--</td>-->
<!--        <td style="vertical-align:middle;">--><?php //echo $status; ?><!--</td></td>-->
<!--		--><?php //if ($this->ion_auth->in_group(array('admin','adminmedecin', 'Accountant'))) { ?>
<!--            <td class="no-print">-->
<!--				--><?php //echo $options_edit; ?>
<!--                <!--<a class="btn btn-info btn-xs delete_button" title="--><?php //// echo lang('delete'); ?><!--" href="finance/deletePaymentCategory?id=--><?php //// echo $category->id; ?><!--" onclick="return confirm('Are you sure you want to delete this item?');"><i class="fa fa-trash"></i> </a>-->-->
<!--            </td>-->
<!--		--><?php //} ?>
<!--    </tr>-->
<?php //} ?>
  
<!--main content end-->
<!--footer start-->


<script src="<?php echo base_url(); ?>common/js/codearistos.min.js"></script>
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/autonumeric/4.0.3/autoNumeric.js"></script>-->
<script src="<?php echo base_url(); ?>common/js/autoNumeric.min.js"></script>
<!--<script src="https://cdn.jsdelivr.net/npm/autonumeric@4.6.0/dist/autoNumeric.min.js"></script>-->

<script>
var autoNumericInstance = new AutoNumeric.multiple('.money', {
    currencySymbol: " FCFA",
    currencySymbolPlacement: "s",
	emptyInputBehavior: "min",
    // maximumValue : "100000",
    // minimumValue : "1000",
	decimalPlaces : 0,
    decimalCharacter : ',',
    digitGroupSeparator : '.'
});
</script>

<script>
    $(document).ready(function () {
       var table = $('#editable-sample').DataTable({
            responsive: true,
			fixedHeader: true,
           "processing": true,
           "serverSide": true,
           "searchable": true,
           "ajax": {
               url: "finance/getInsurances",
               type: 'POST'
           },
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
							// columns: [0,1,2,3,4,5],
						// }
					// },
					// {
						// extend: 'pdfHtml5',
						// className: 'dt-button-icon-left dt-button-icon-pdf',
						// exportOptions: {
							// columns: [0,1,2,3,4,5],
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
            "order": [[0, "desc"]],
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
    });

</script>
