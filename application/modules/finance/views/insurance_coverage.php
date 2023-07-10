Payment<!--sidebar end-->
<!--main content start-->



<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="panel">
            <header class="panel-heading">
				<h2>
                Couverture Prestations (<?php echo ($this->db->query("select organisation.nom from organisation join partenariat_sante_assurance on partenariat_sante_assurance.id_organisation_assurance = organisation.id AND partenariat_sante_assurance.id = ".$id_partenariat)->row())->nom; ?>)
				</h2>
            </header>
            <div class="panel-body panel-bodyAlt">
                <div class="adv-table editable-table "> 
                    <div class="space15"></div>
                    <table class="table table-hover progress-table" id="editable-sample">
                        <thead>
                            <tr>
                                <th style="width:15%;"><?php echo lang('service'); ?></th>
                                <th style="width:15%;"><?php echo lang('speciality'); ?></th>
                                <th style="width:30%;"><?php echo lang('procedure'); ?></th>
                                <!--<th style="width:25%;"><?php echo lang('description'); ?></th>-->
                                <!--<th style="text-align:center;"><?php echo lang('price2'); ?> <?php echo lang('public'); ?></th>
                                <th style="text-align:center;"><?php echo lang('price2'); ?> <?php echo lang('pro'); ?></th>-->
                                <th style="width:15%;"><?php echo lang('price2'); ?> <?php echo $typeTiersPayant->type; ?></th>
                                <?php if ($this->ion_auth->in_group(array('admin','adminmedecin', 'Accountant'))) { ?>
                                    <th class="no-print" style="text-align:center;">Est couverte</th>
                                <?php } ?>
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
                        <?php foreach ($categories as $category) { 
						// echo $category->est_couverte;
							// echo !empty(trim($category->est_couverte)) ? "abc".$category->est_couverte : "NO VALUE";
						?>
                            <tr class="" >
                                <td style="vertical-align:middle;"> <?php echo $category->name_service; ?></td>
                                <td style="vertical-align:middle;"> <?php echo $category->name_specialite; ?></td>
                                <td style="vertical-align:middle;"><?php echo $category->prestation; ?></td>   
                                <!--<td style="vertical-align:middle;"> <?php echo $category->description; ?></td>-->
                                <!--<td style="vertical-align:middle;" ><span class="money"><?php echo $category->tarif_public; ?></span></td>
                                <td style="vertical-align:middle;"><span class="money"><?php echo $category->tarif_professionnel; ?></span></td>-->
                                <td style="vertical-align:middle;"><span class="money"><?php echo !empty($typeTiersPayant) && $typeTiersPayant->type == "IPM" ? $category->tarif_ipm : $category->tarif_assurance; ?></span></td>
                                <?php if ($this->ion_auth->in_group(array('admin','adminmedecin', 'Accountant'))) { ?>
                                    <td class="no-print">
                                        <!--<li class="list-group-item">-->
											<span id="result_<?php echo $category->id; ?>" data-id="est_couverte_<?php echo $category->id; ?>" data-name="est_couverte_<?php echo $category->id; ?>"> 
											<?php if(!empty($category->est_couverte) && $category->est_couverte == "1") { ?>
												<span class="color-green">Oui</span>
												<?php 
												} else { ?>
												<span class="color-red">Non</span>
												<?php } ?>
												</span>
											<label class="switch pull-right">
												<input  type="checkbox" id="checkbox_<?php echo $category->id; ?>" <?php if(!empty($category->est_couverte) && $category->est_couverte == 1) { ?> checked <?php } ?>  onclick="fctSwitch(<?php echo $category->id; ?>);">
												<span class="slider round" ></span>
											</label>
										<!--</li>-->
                                    </td>
                                <?php } ?>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
				<a id="" class="btn btn-info btn-secondary pull-left" href="finance/insurance">
					Retour
				</a>
            </div>
        </section>
        <!-- page end-->
    </section>
</section>


  
<!--main content end-->
<!--footer start-->

<script src="<?php echo base_url(); ?>common/js/codearistos.min.js"></script>
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/autonumeric/4.0.3/autoNumeric.js"></script>-->
<script src="<?php echo base_url(); ?>common/js/autoNumeric.min.js"></script>
<!--<script src="https://cdn.jsdelivr.net/npm/autonumeric@4.6.0/dist/autoNumeric.min.js"></script>-->

<script>
// $(document).ready(function() {
	// alert("here");
	function fctSwitch(categoryId) {
		
		var checkBox = document.getElementById("checkbox_"+categoryId);
		var text = document.getElementById("result_"+categoryId);
		
		var status = 0;
		if (checkBox.checked == true) {
			status = 1;
			text.innerHTML = '<span class="color-green">Oui</span>';
		} else {
			text.innerHTML = '<span class="color-red">Non</span>';
		}
		
		
		// alert();
		
		$.ajax({
			url: 'finance/addRemoveInsuranceCoverage?idPartenariat=<?php echo $id_partenariat; ?>&idPaymentCategory='+categoryId+'&status=' + status,
			method: 'GET',
			// data: '',
			dataType: 'json',
		}).success(function (response) {
			// Rien pour l'instant
			// alert("success");
		}).error(function(e) { 
			//alert(e.message); 
		});
	}
// });
</script>
						
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
