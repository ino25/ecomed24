Payment<!--sidebar end-->
<!--main content start-->


<script src="<?php echo base_url(); ?>common/js/codearistos.min.js"></script>

<style>
	td.details-control {
		background: url('https://www.datatables.net/examples/resources/details_open.png') no-repeat transparent center 10px !important;
		cursor: pointer !important;
	}
	tr.shown td.details-control {
		background: url('https://www.datatables.net/examples/resources/details_close.png') no-repeat transparent center 10px !important;
	}
	
		table.details {
	  border: 1px solid #ccc;
	  border-collapse: collapse;
	  margin: 0;
	  padding: 0;
	  width: 100%;
	  box-shadow:0 0 0 .2rem rgba(13,77,153,.25) !important;
	}

	table.details tr {
	  background: #F8F9FA !important;
	  border: 1px solid #ddd;
	  padding: .35em;
	}

	table.details th, table.details td {
		
	  background: #F8F9FA !important;
	  padding: .625em;
	  text-align: center;
	}

	table.details th {
		
	  background: #F8F9FA !important;
	  font-size: .85em;
	  letter-spacing: .1em;
	  text-transform: uppercase;
	}
</style>

<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="panel">
            <header class="panel-heading">
			
                <div class="col-md-6 no-print pull-right"> 
                   <a href="javascript:;" class="">
                        <div class="btn-group pull-right">
                            <!--<button id="" class="btn green btn-xs">-->
                            <a id="" class="btn green btn-xs disabled"> <!-- ADDED TO DISABLE -->
                                <i class="fa fa-plus-circle"></i> Ajouter une prestation hors catalogue
                            <!--</button>-->
                            </a>
                        </div>
                    </a>
                   
                        <!--<div class="btn-group pull-right" style="margin-right:5px;">
                            <button id="" class="btn green btn-xs downloadbutton" onclick="importPrestation()">
                                <i class="fa fa-plus-circle"></i> <?php echo lang('bulk_create_payment_procedure'); ?>
                            </button>
                        </div>-->
                    
                </div>
                <h2>Catalogue des Prestations</h2>
            </header>
			
			<!--<div class="col-md-12 no-print pull-right"> 
                <a href="finance/paymentCategoryPanier">
                    <div class="btn-group pull-left" style="margin-right:5px;">
						<button id="" class="btn green btn-xs">
                        Valider ma sélection & Poursuivre
                        </button>
                   </div>
                </a>
			</div>-->
            <div class="panel-body panel-bodyAlt">
                <div class="adv-table editable-table "> 
                    <div class="space15"></div>
                    <!--<div class="col-lg-12 col-md-12">
                        <table border="0" cellspacing="0" cellpadding="0" style="float:left">
                            <tbody>
                                <tr>
                                    <th style="color:#0d4d99">Service:</th>
                                    <td><select class="form-control" name="modeType" id="modeType" onchange="typeUpdate(event)">
                                            <option value="">Tous les services</option>
											<?php foreach($prestations as $prestation) { ?>
										        <option value="<?php echo $prestation->id; ?>"><?php echo $prestation->name_service; ?></option>
											<?php } ?>
                                        </select>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>-->
                    <table class="table table-hover progress-table" id="editable-sample">
                        <thead>
                            <tr>
                                <th style="width:5%"></th>
                                <th style="width:20%;"><?php echo lang('service');  ?></th>
                                <th style="width:20%;"><?php echo lang('speciality'); ?></th>
                                <th style="width:25%;">Prestation</th>
                                <th style="width:0%">&nbsp;</th>
                                <th style="">Type</th>
                                <?php if ($this->ion_auth->in_group(array('admin','adminmedecin', 'Accountant'))) { ?>
                                    <th class="no-print" style="vertical-align:top;width:15%;">Est ajoutée au panier</th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
			<div class="col-md-12 no-print pull-right" style="margin-bottom:50px;"> 
                <a href="finance/paymentCategory">
                    <div class="btn-group pull-left" style="margin-right:5px;">
						<button id="" class="btn green btn-xs btn-secondary">
                        Retour
                        </button>
                   </div>
                </a>
				<div class="btn-group pull-right" style="margin-right:5px;">
					<button id="" class="btn green btn-xs downloadbutton">
						Valider ma séléction & Poursuivre
					</button>
                </div>
			</div>
        </section>
        <!-- page end-->
    </section>
</section>

<div class="modal fade" id="myModaldone" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-paiement">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title myModaldoneTitle" id="myModaldoneTitle">  </h4>
            </div>
            <div class="modal-body" id="modal-body">
                <h5 style="color: #303f9f;margin-bottom: 10px;"></h5>
                <div class="single-table">
                    <div class="table-responsive">
                        <table id="dataTable" class="table table-bordered table-hover dataTable">
                            <thead class="text-uppercase">
                                <tr>
                                <th scope="col">SPECIALITES</th> <th scope="col" >PARAMETRES</th><th scope="col">UNITE</th><th scope="col">NORME</th>
                                </tr>
                            </thead><tbody id="deposit-checkDone">

                            <div class="deposit-checkDone" >  </div>


                            </tbody></table>
                        <form  action="#" id="deposit-checkDepot" class="clearfix" method="post" enctype="multipart/form-data">
                           <table class="col-md-12"> <tr class="form-group   right-six col-md-12"><td  class="col-md-6 pull-left">
                                        <button type="button" class="btn btn-info btn-secondary pull-left" data-dismiss="modal" aria-hidden="true"> <?php echo lang('close'); ?></button>
                                    </td>
                                   </tr></table>
                        </form>

                    </div>
                </div>
            </div>
        </div>  
    </div>
</div>
 
<div class="modal fade" id="importPrestation" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-paiement">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title myModaldoneTitle" id="myModaldoneTitle">  </h4>
            </div>
                 <form  action="finance/confirmImportPrestation" id="confirmImportPrestation" class="clearfix" method="post" enctype="multipart/form-data">
            <div class="modal-body" id="modal-body">
                <h3 id="title-checkDone"></h3>
                    <a href="finance/newImport"  class="btn btn-info pull-right" id="add"><i class="fa  fa-plus"></i> <?php echo lang('add'); ?></a>
                <div class="single-table">
                    <div class="table-responsive">
                        <table id="dataTable-importPrestation" class="table table-bordered table-hover dataTable w-100" style="width: 100% !important;">
                            <thead class="text-uppercase">
                                <tr> 
                           
                               
                                <th><?php echo lang('speciality'); ?></th>
                                <th><?php echo lang('procedure'); ?></th>
                               <!--  <th><?php echo lang('options'); ?></th>-->
                                  <th><input type="checkbox" name="select_all" value="1" id="dataTable-importPrestation-all"> Tous</th>
                            </tr>
                            </thead><tbody id="deposit-importPrestation">

                            
                            </tbody></table>
                   
                           <table class="col-md-12"> <tr class="form-group   right-six col-md-12"><td  class="col-md-6 pull-left">
                                      <!--  <button type="button" class="btn btn-info btn-secondary pull-left" data-dismiss="modal" aria-hidden="true"> <?php echo lang('close'); ?></button>-->
                                    </td>
                                   </tr></table>
                      

                    </div>
                </div>
                          <button type="submit" name="submit" class="btn btn-info pull-left" id="add"><?php echo lang('selection'); ?> (<span id="count-checked-checkboxes">0</span>)</button>
              
            </div>
               </form>        
        </div>  
    </div>
</div> 
<!--main content end-->
<!--footer start-->

<div class="modal fade" id="myModal2" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">
				
				<?php $total_panier = $this->db->query("select setting_service.name_service, setting_service_specialite.name_specialite, payment_category.prestation from payment_category_panier join payment_category on payment_category.id = payment_category_panier.id_prestation join setting_service on setting_service.idservice = payment_category.id_service join setting_service_specialite on setting_service_specialite.id_service = setting_service.idservice where payment_category_panier.id_organisation = ".$id_organisation." and payment_category_panier.statut = 1 group by payment_category.id")->num_rows(); 
				?>
				Importer les <span style="font-style:italic;" id="totalPanierModal"><?php echo $total_panier ?></span> éléments sélectionnés à mes prestations (xls, xlsx) 
				</h4>
            </div>
			
            <div class="modal-body">
			<div class="btn-group" style="margin-right:5px;">
                            <a id="" class="btn green btn-xs btn-secondary" href="home/createPrestationsTemplatePanier">
                                <i class="fa fa-download"></i>&nbsp;Télécharger le fichier généré
                            </a>
                        </div>
                <form role="form" id="departmentEditForm" class="clearfix" action="home/importPrestationsInfoPanier" method="post" enctype="multipart/form-data">

                    <div class="form-group has-feedback">
                                    <label for="exampleInputEmail1"> <?php echo lang('choose_file'); ?> rempli</label>
                                    <input type="file" class="form-control" placeholder="" name="filenamePanier" required accept=".xls, .xlsx ,.csv">
                                    <span class="glyphicon glyphicon-file form-control-feedback"></span>
                                    <input type="hidden" name="tablename"value="payment_category">
                                </div>
                
                    <section class="">
                        <a href="javascript:$('#myModal2').modal('hide');" class="btn btn-info btn-secondary pull-left" >Retour</a>
						<button type="submit" name="submit" class="btn btn-info submit_button pull-right"> <?php echo lang('submit') ?></button>
                    </section>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

<script src="<?php echo base_url(); ?>common/js/autoNumeric.min.js"></script>
<script>
    $(document).ready(function() {
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
            decimalPlaces: 0,
            decimalCharacter: ',',
            digitGroupSeparator: '.'
        });

    });
</script>

<script>
// $(document).ready(function() {
	// alert("here");

	
	function fctSwitch(categoryId) {
		
		// alert(categoryId);
		var checkBox = document.getElementById("checkbox_"+categoryId);
		var text = document.getElementById("result_"+categoryId);
		
		var status = 0;
		if (checkBox.checked == true) {
			status = 1;
			text.innerHTML = '<span class="color-green">Oui</span>';
			$("#totalPanierModal").text(parseInt($("#totalPanierModal").text()) + 1);
		} else {
			text.innerHTML = '<span class="color-red">Non</span>';
			$("#totalPanierModal").text(parseInt($("#totalPanierModal").text()) - 1);
		}
		var idOrganisation = <?php echo json_encode($id_organisation); ?>;
		// var buff = categoryId.split("_"); 
		// var idService = buff[0];
		// var idSpecialite = buff[1];
		// alert(idOrganisation);
		// alert(idService);
		// alert(idSpecialite);
		// alert(status);
		// alert("ok");
		
		$.ajax({
			url: 'services/addRemovePrestationPanier?idPrestation='+categoryId+'&idOrganisation='+idOrganisation+'&statut=' + status,
			method: 'GET',
			dataType: 'json',
		}).success(function (response) {
			// alert(response);
		}).error(function(e) { 
		});
		
	}
// });
</script>

<script>
    $(document).ready(function () {
		$(".downloadbutton").click(function (e) {
            e.preventDefault(e);
            // Get the record's ID via attribute  
           $('#myModal2').modal('show');
        });
		
        var table = $('#editable-sample').DataTable({
            responsive: true,
            //   dom: 'lfrBtip',

            "processing": true,
            // "serverSide": true,
            "searchable": true,
            "ajax": {
                url: "home/getPrestationsOrganisationEncoreDispo",
                type: 'POST'
            },
			"columns": [
				{
					className:      'details-control',
					orderable:      false,
					data:           null,
					defaultContent: ''
				},
				{ "data": "service" },
				{ "data": "specialite" },
				{ "data": "prestation" },
				{ "data": "keywords" },
				{ "data": "type" },
				{ "data": "options" }
			],
			createdRow: function ( row, data, index ) {
            if (data.service === '') {
              var td = $(row).find("td:first");
              td.removeClass( 'details-control' );
            }
			
           },
          rowCallback: function ( row, data, index ) {
            console.log('rowCallback');
           },
            scroller: {
                loadingIndicator: true
            },
			columnDefs: [
				{
					targets: 4,
					searchable: true,
					visible: false
				}
			],
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
							// columns: [0,1,2],
						// }
					// },
					// {
						// extend: 'pdfHtml5',
						// className: 'dt-button-icon-left dt-button-icon-pdf',
						// exportOptions: {
							// columns: [0,1,2],
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
            "order": [[0, "asc"]],
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
        
		
		// Add event listener for opening and closing details
		$('#editable-sample tbody').on('click', 'td.details-control', function () {
			// alert("ok1");
			var tr = $(this).closest('tr');
			var row = table.row( tr );
	 
			if ( row.child.isShown() ) {
				// This row is already open - close it
				row.child.hide();
				tr.removeClass('shown');
			}
			else {
				// Open this row
				row.child( format(row.data()) ).show();
				tr.addClass('shown');
			}
		} );
		
		function format ( rowData ) {
			// alert(rowData.id);
			// alert(rowData.type);
			var div = $("<div style='background-color:#EAEAEA;padding:10px;' />")
				.addClass( 'loading' )
				.text( 'Chargement...' );
		 
			$.ajax( {
				url: 'home/getSuperPrestationDetails',
				method: 'GET',
				data: {
					idPrestation: rowData.id,
					typePrestation: rowData.type,
					nomPrestation: rowData.prestation
				},
				dataType: 'json',
				success: function ( json ) {
					// alert(json);
					div
						.html( json.html )
						.removeClass( 'loading' );
				}
			} );
		 
			return div;
		}
		
           var table2 = $('#dataTable-importPrestation').DataTable({
            responsive: true,
            "processing": true,
            // "serverSide": true,
            "searchable": true,
            "ajax": {
                url: "finance/getListePrestationsParamtres" ,
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
                buttons: [],
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
              
 'columnDefs': [{
         'targets': 2,
         'searchable': false,
         'orderable': false,
         'className': 'dt-body-center',
         'render': function (data, type, full, meta){
             return '<input type="checkbox" name="id[]" value="' + $('<div/>').text(data).html() + '"> ajouter';
         }        

      },
         {
                      'targets': [0,1,2],
         'className': 'dt-body-center'
              }],
              select: {
            style:    'os',
            selector: 'td:first-child'
        },
            language: {
                "url": "common/assets/DataTables/languages/<?php echo $this->language; ?>.json<?php echo time(); ?>",
                processing: "Traitement en cours...",
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
        });
        table2.buttons().container().appendTo('.custom_buttons');
        //table.columns(0).visible(false);

 // Handle click on "Select all" control
   $('#dataTable-importPrestation-all').on('click', function(){
      // Get all rows with search applied
      var rows = table2.rows({ 'search': 'applied' }).nodes();
      // Check/uncheck checkboxes for all rows in the table
      $('input[type="checkbox"]', rows).prop('checked', this.checked);
   });
   
   // Handle click on checkbox to set state of "Select all" control
   $('#dataTable-importPrestation tbody').on('change', 'input[type="checkbox"]', function(){
      // If checkbox is not checked
      if(!this.checked){
         var el = $('#dataTable-importPrestation-all').get(0);
        var tt = 0;
         if(el && el.checked && ('indeterminate' in el)){
           tt++;
            el.indeterminate = true;
         }
 
      }
   });
   
 
      $('#dataTable-importPrestation tbody').on('change', 'input[type="checkbox"]', function(){ 
       var countCheckedCheckboxes =  $('#dataTable-importPrestation input[type="checkbox"]').filter(':checked').length;
        $('#count-checked-checkboxes').text(countCheckedCheckboxes);
        
        $('#edit-count-checked-checkboxes').val(countCheckedCheckboxes);
    });
        
        
    });


  
  
        
function detailParametre(presta) {
   
        $('#myModaldone').trigger("reset");
        $('#deposit-checkDone').html('')
        $.ajax({
            url:  'finance/editTproFinanceByJasonParametre?prestation=' + presta,
            method: 'GET',
            data: '',
            dataType: 'json'
        }).success(function (response) {
            var result = '<table>';
           $.each(response.prestations, function (key, value) {
               result += '<tr><td>'+value.name_specialite+'</td><td>'+value.nom_parametre+'</td><td>'+value.unite+'</td><td>'+value.valeurs+'</td></tr>';
           });
           result += '</table>';
           $('#deposit-checkDone').html(result);


            $('#myModaldone').modal('show');
        });
    }

function importPrestation() {
     $('#importPrestation').modal('show');
   /* $('#importPrestation').trigger("reset");
      
        $.ajax({
            url:  'finance/getListePrestationsParamtres',
            method: 'GET',
            data: '',
            dataType: 'json'
        }).success(function (response) {
          


          
        });*/
    }
    
</script>
