Payment<!--sidebar end-->
<!--main content start-->

<style>
	td.details-control {
		background: url('https://www.datatables.net/examples/resources/details_open.png') no-repeat transparent center 10px !important;
		cursor: pointer !important;
	}
	tr.shown td.details-control {
		background: url('https://www.datatables.net/examples/resources/details_close.png') no-repeat transparent center 10px !important;
	}
	
	th.btn-toggle-all-children {
		background: url('uploads/details_open_all.png') no-repeat transparent center center !important;
		cursor: pointer !important;
	}
	tr.btn-toggle-shown th.btn-toggle-all-children {
		background: url('uploads/details_close_all.png') no-repeat transparent center center !important;
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
	.underlinedClass:hover {
		font-weight:bold;
		color:#0d4d99;
	}
	
	img.edit0, img.valid0, img.cancel0, img.edit1, img.valid1, img.cancel1, img.edit00, img.valid00, img.cancel00, img.edit01, img.valid01, img.cancel01, img.edit021, img.valid021, img.cancel021, img.edit022, img.valid022, img.cancel022, img.edit023, img.valid023, img.cancel023 {
		/* display:none; */	
	}
	
	/* img.edit0, img.edit1, img.edit00, img.edit01, img.edit021, img.edit022, img.edit023 {
		display:inline-block; 
	}*/
	
	td.edit0, td.edit1, td.edit00, td.edit01, td.edit021, td.edit022, td.edit023 {
		font-weight:bold;
	}
</style>
<style>
.tooltips {
  position: relative;
}

.tooltips span {
  font:300 12px 'Open Sans', sans-serif;
  position: absolute;
  color: #FFFFFF;
  background: #000000;
  padding:5px 10px;
  margin-left:50px;
  width:140px;
  text-align: center;
  visibility: hidden;
  opacity: 0;
  filter: alpha(opacity=0);
}

.tooltips > span img{max-width:140px;}

.tooltips[tooltip-position="right"] span{

}

.tooltips span:after {
  content: '';
  position: absolute;
  width: 0; height: 0;
}

.tooltips[tooltip-position="right"] span:after{
  top: 50%;
  right: 100%;
  margin-top: -8px;
  border-right: 8px solid black;
  border-top: 8px solid transparent;
  border-bottom: 8px solid transparent;
}

.tooltips span {
  visibility: visible;
  opacity: 1;
  z-index: 999;
}

.tooltips[tooltip-position="right"]:hover span{

}

.tooltips[tooltip-type="primary"] > span {
  background-color:#2980b9;
}
.tooltips[tooltip-type="primary"][tooltip-position="right"] > span:after{
  border-right: 8px solid #2980b9;
}

.tooltips[tooltip-type="success"] > span {
  background-color:#27ae60;
}
.tooltips[tooltip-type="success"][tooltip-position="right"] > span:after{
  border-right: 8px solid #27ae60;
}

.tooltips[tooltip-type="warning"] > span {
  background-color:#f39c12;
}
.tooltips[tooltip-type="warning"][tooltip-position="right"] > span:after{
  border-right: 8px solid #f39c12;
}

.tooltips[tooltip-type="danger"] > span {
  background-color:#c0392b;
}
.tooltips[tooltip-type="danger"][tooltip-position="right"] > span:after{
  border-right: 8px solid #c0392b;
}
</style>

<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="panel">
            <header class="panel-heading">
			
                <div class="col-md-8 no-print pull-right"> 
                   <a href="finance/paymentCategoryPanier">
                        <div class="btn-group pull-right">
                            <button id="" class="btn green btn-xs">
                                <i class="fa fa-plus-circle"></i> Ajouter des prestations
                            </button>
                        </div>
                    </a>
                   
                        <!--<div class="btn-group pull-right" style="margin-right:5px;">
                            <button id="" class="btn green btn-xs downloadbutton" onclick="importPrestation()">
                                <i class="fa fa-plus-circle"></i> <?php echo lang('bulk_create_payment_procedure'); ?>
                            </button>
                        </div>-->
                    
                </div>
                <h2>Prestations</h2>
            </header>
            <div class="panel-body panel-bodyAlt">
                <div class="adv-table editable-table "> 
                    <div class="space15"></div>
                    <table class="table table-hover progress-table" id="editable-sample">
                        <thead>
                            <tr>
                                <th style="width:5%" class="btn-toggle-all-children"></th>
                                <th style=""><?php echo lang('service');  ?></th>
                                <th style=""><?php echo lang('speciality'); ?></th>
                                <th style="width:20%">Prestation</th>
                                <th style="width:0%">&nbsp;</th>
                                <!--<th style="">Type</th>-->
                                <th style="width:10%;"><?php echo lang('price2'); ?> <?php echo lang('public'); ?></th>
                                <th style="width:10%;"><?php echo lang('price2'); ?> <?php echo lang('pro'); ?></th>
                                <th style="width:10%;"><?php echo lang('price2'); ?> <?php echo lang('insurance'); ?></th>
                                <th style="width:10%;"><?php echo lang('price2'); ?> <?php echo lang('ipm'); ?></th>
                                <?php if ($this->ion_auth->in_group(array('admin','adminmedecin', 'Accountant'))) { ?>
                                    <th class="no-print" style="vertical-align:top;width:15%;"><?php echo lang('options'); ?></th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
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



<div class="modal fade" id="myModaldone2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
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
                     
                        <form  action="finance/updateModeleByLabo" id="formistemodele" class="clearfix" method="post" enctype="multipart/form-data">
                                 <div class="col-md-12">
<label><?php echo lang('liste-modele'); ?></label>
<select class="form-control" name="liste-modele"  id="liste-modele"> </select>
                         </div>
                     
                            <input type="hidden" value="" name="idpco" id="idpco" />
                           <div class="col-md-12">
                                        <button type="button" class="btn btn-info btn-secondary pull-left" data-dismiss="modal" aria-hidden="true"> <?php echo lang('close'); ?></button>
                                          <button type="submit" name="submit" class="btn btn-info pull-right"><?php echo lang('submit'); ?></button>
                                    </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>  
    </div>
</div>

<div class="modal fade" id="myModaldone3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-paiement">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title myModaldoneTitle" id="myModaldoneTitle">Modification Tarifs</h4>
            </div>
            <div class="modal-body" id="modal-body">
                <h5 style="color: #303f9f;margin-bottom: 10px;"></h5>
                <div class="single-table">
                    <div class="table-responsive">
                     
					
                    <div class="clearfix">
                        <?php echo validation_errors(); ?>
                        <form role="form" action="home/editPaymentCategoryPrices" id="formEditPrices" class="clearfix" method="post" enctype="multipart/form-data">
						
						<input type="hidden" name="idpco" id="idpco" value="" />
							
						<div class="col-md-12">							
                            <div class="form-group col-md-4">
                                <label for="exampleInputEmail1"><?php echo lang('service'); ?></label>
									<input type="text" class="form-control" name="service" id="service" disabled value='' placeholder="">
                            </div>
							
                            <div class="form-group col-md-4">
                                <label for="exampleInputEmail1"><?php echo lang('speciality'); ?></label>
									<input type="text" class="form-control" name="specialite" id="specialite" disabled value='' placeholder="">
                            </div>
					
                            <div class="form-group  col-md-4"> 
                                <label for="exampleInputEmail1"><?php echo lang('procedure');  ?></label>
									<input type="text" class="form-control" name="prestation" id="prestation" disabled value='' placeholder="">
                            
                            </div> 
  </div>
							
							<div class="col-md-12">		
                               
								<div class="form-group  col-md-3">
									<label for="exampleInputEmail1"><?php echo lang('price2'); ?> <?php echo lang('public'); ?></label>
									<input type="text" class="form-control money" name="tarif_public" id="tarif_public" required value='' placeholder="">
								</div>	
								<div class="form-group  col-md-3">
									<label for="exampleInputEmail1"><?php echo lang('price2'); ?> <?php echo lang('pro'); ?></label>
									<input type="text" class="form-control money" name="tarif_professionnel" id="tarif_professionnel" value='' placeholder="">
								</div>
								<div class="form-group  col-md-3">
									<label for="exampleInputEmail1"><?php echo lang('price2'); ?> <?php echo lang('insurance'); ?></label>
									<input type="text" class="form-control money" name="tarif_assurance" id="tarif_assurance" value='' placeholder="">
								</div>
								 <div class="form-group  col-md-3">
									<label for="exampleInputEmail1"><?php echo lang('price2'); ?> <?php echo lang('ipm'); ?></label>
									<input type="text" class="form-control money" name="tarif_ipm" id="tarif_ipm" value='<?php
									if (!empty($setval)) {
										echo set_value('tarif_assurance');
									}
									if (!empty($category->tarif_assurance)) {
										echo $category->tarif_assurance;
									}
									?>' placeholder="">
								</div>
                             </div>

                           <div class="col-md-12">
								<button type="button" class="btn btn-info btn-secondary pull-left" data-dismiss="modal" aria-hidden="true"> <?php echo lang('close'); ?></button>
								<button type="submit" name="submit" class="btn btn-info pull-right"><?php echo lang('submit'); ?></button>
							</div>							 
                          
                            
                        </form>
                    </div>
                    </div>
                </div>
            </div>
        </div>  
    </div>
</div>

<script src="<?php echo base_url(); ?>common/js/codearistos.min.js"></script>
<script src="<?php echo base_url(); ?>common/js/autoNumeric.min.js"></script>
<script>
    $(document).ready(function() {
        $(".flashmessage").delay(3000).fadeOut(100);
    });

    
</script>

<script>
    $(document).ready(function() {
     /*   var autoNumericInstance = new AutoNumeric.multiple('.money', {
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
        }); */
		var autoNumericInstance = new AutoNumeric.multiple('.money', {
			currencySymbol: " FCFA",
			currencySymbolPlacement: "s",
			// emptyInputBehavior: "min",
			selectNumberOnly: true,
			selectOnFocus: true,
			overrideMinMaxLimits: 'invalid',
			emptyInputBehavior: "min",
			maximumValue : '1000000',
			// minimumValue : "1000",
			minimumValue : "0",
			decimalPlaces : 0,
			decimalCharacter : ',',
			digitGroupSeparator : '.',
			// watchExternalChanges: true //!!!
		});

    });
</script>

<script>
    $(document).ready(function () {
		
		var editIcon = function ( data, type, row ) {
			if ( type === 'display' ) {
				return '<img src="uploads/edit.svg" style="width:14px;height:14px;margin-right:0.5em;" class="edit0"/>' + data;
			}
			return data;
		};
		
        var table = $('#editable-sample').DataTable({
            responsive: true,
            //   dom: 'lfrBtip',

            "processing": true,
            // "serverSide": true,
            "searchable": true,
            "ajax": {
                url: "home/getPrestationsOrganisation",
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
				// { "data": "type" },
				// {"data": "tarifPublic"   , className: 'edit0', render: editIcon},
				// { "data": "tarifProfessionnel"  , className: 'edit1', render: editIcon },
				// { "data": "tarifAssurance"  , className: 'edit1', render: editIcon },
				// { "data": "tarifIPM"  , className: 'edit1', render: editIcon },
				{"data": "tarifPublic"},
				{ "data": "tarifProfessionnel"},
				{ "data": "tarifAssurance"},
				{ "data": "tarifIPM"},
				{ "data": "options" }
			],
			createdRow: function ( row, data, index ) {
            if (data.service === '') {
              var td = $(row).find("td:first");
              td.removeClass( 'details-control' );
            }
			$('td', row).eq(4).attr('id', 'td-' + index + '-4');
			$('td', row).eq(5).attr('id', 'td-' + index + '-5');
			$('td', row).eq(6).attr('id', 'td-' + index + '-6');
			$('td', row).eq(7).attr('id', 'td-' + index + '-7');
			
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
        
		// Expand/Collpase All
		$('#editable-sample thead').on('click', 'th.btn-toggle-all-children', function(){
			// Expand row details
			table.rows(':not(.parent)').nodes().to$().find('td:first-child').trigger('click');
			if(!$(this).parent().hasClass("btn-toggle-shown")) {
				$(this).parent().addClass("btn-toggle-shown");
			} else {
				$(this).parent().removeClass("btn-toggle-shown");
			}
		});
		
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
		
		
		var removeElements = function(text, selector) {
			var wrapped = $("<div>" + text + "</div>");
			wrapped.find(selector).remove();
			return wrapped.html();
		}
		
		// Gestion Row Edit pour Row Supérieur
		
			// Nom Prestation
			$('#editable-sample tbody').on( 'click', 'td img.edit0', function (e) {
			// $('#editable-sample tbody').on( 'click', 'td.edit0', function (e) {
				// alert("this far");
				$(this).parent().removeClass("tooltips"); // Reset Elements laissés par Tooltip
				// Check si on rentre ou on sort (sortie via clic dans cellule pas dans cellule voisine)
				var witness = $(this).parent().find("input").val();
				if(typeof(witness) == "undefined") { // S'assure que le clic out (dans la mme cellule pour sortir) n'est pas vu com un nouveau onclick
					var currentContent = $(this).parent().html();
					var html2 = removeElements(currentContent, "img");
					var html2 = removeElements(html2, "span"); // Reset Elements laissés par Tooltip
					var html2NoCurrency = html2.replace("FCFA", "");
					var newContent = '<input type="text" required name="edit" data-id="'+$('<div/>').text(html2NoCurrency).html()+'" value="'+$('<div/>').text(html2NoCurrency).html()+'" style="width:90%;color:#0d4d99;">'+' FCFA<img src="uploads/check-circle.svg" style="width:14px;height:14px;margin-left:0.5em;" class="valid0"/>'+'<img src="uploads/x-circle.svg" style="width:14px;height:14px;margin-left:0.5em;" class="cancel0"/>';
					$(this).parent().html(newContent);
					$(this).parent().find("input").focus();
				}
				
			} ).on( 'click', 'td img.valid0', function (e) {
			// } ).on( 'blur', 'td.edit0', function (e) {
					
				var me = $(this); // Pour utilisant and ajax.success		
				var tdId = me.parent().attr("id");
				// alert(tdId);
				$(this).parent().append('<img src="uploads/loading-wheel.gif" style="width:15px;height:15px;margin-left:0.5em;" />');
				
				var previousContent = $(this).parent().find("input").data('id');
				var currentContent = $(this).parent().find("input").val();
				
				var tr = $(this).parent().closest('tr');
				var row = table.row( tr );
				var idPrestation = row.data().id;
				// var nomService = row.data().service;
				
				// Lancer Modification AJAX
				if(currentContent != "") { // Insertion uniquement si champ non vide
					/* $.ajax({
						url: 'home/editPrestationName',
						method: 'POST',
						data: {
							idPrestation: idPrestation,
							newPrice: currentContent,
							nomService: nomService
						},
						dataType: 'json',
					}).success(function (response) {
							// Si succès: OK
							if(response == "OK") {
								var html2 = currentContent;
								var newContent = '<img src="uploads/pen_2.png" style="width:12px;height:12px;margin-right:0.5em;" class="edit0"/>' + html2;
								me.addClass("tooltips"); // Début init Tooltip
								me.html(newContent);
								displayTooltipSuccess(tdId);
							} else if(response == "KO") {
								var html2 = previousContent;
								var newContent = '<img src="uploads/pen_2.png" style="width:12px;height:12px;margin-right:0.5em;" class="edit0"/>' + html2;
								me.addClass("tooltips"); // Début init Tooltip
								me.html(newContent);
								displayTooltipError(tdId, "Cette prestation existe déjà");
							}
					}); */
				} else {
					var html2 = previousContent;
					var newContent = '<img src="uploads/edit.svg" style="width:14px;height:14px;margin-right:0.5em;" class="edit0"/>' + html2 + " FCFA";
					me.parent().addClass("tooltips"); // Début init Tooltip
					me.parent().html(newContent);
					displayTooltipError(tdId, "Vous devez saisir un montant");
				}
			} ).on( 'click', 'td img.cancel0', function (e) {
			// } ).on( 'blur', 'td.edit0', function (e) {
					
				var me = $(this); // Pour utilisant and ajax.success		
				var tdId = me.parent().attr("id");
				// alert(tdId);
				$(this).parent().append('<img src="uploads/loading-wheel.gif" style="width:15px;height:15px;margin-left:0.5em;" />');
				
				var previousContent = $(this).parent().find("input").data('id');
				var currentContent = $(this).parent().find("input").val();
				
				var tr = $(this).parent().closest('tr');
				var row = table.row( tr );
				var idPrestation = row.data().id;
				// var nomService = row.data().service;
				
				var html2 = previousContent;
				var newContent = '<img src="uploads/edit.svg" style="width:14px;height:14px;margin-right:0.5em;" class="edit0"/>' + html2 + " FCFA";
				// me.parent().addClass("tooltips"); // Début init Tooltip
				me.parent().html(newContent);
				// displayTooltipError(tdId, "Vous devez saisir un montant");
			} );
			
			
			$('#editable-sample tbody').on( 'click', 'td.edit0 input', function (e) { // Just to stop propagation: en cas de clic sur L'input - evite de retrigger l'event above alors qu'on est pas sorti
				e.stopPropagation();
			} );
			
			
			function displayTooltipSuccess(tdId) {
				// Tooltips Begin
				$("#"+tdId).append("<span></span>");
				$('.tooltips:not([tooltip-position])').attr('tooltip-position','right');
				$('.tooltips:not([tooltip-type])').attr('tooltip-type','primary');
				$("#"+tdId).find('span').empty().append("Modifié avec succès");
				$("#"+tdId).find("span").delay(1000).fadeOut();
			}
			
			function displayTooltipError(tdId, error) {
				// Tooltips Begin
				$("#"+tdId).append("<span></span>");
				$('.tooltips:not([tooltip-position])').attr('tooltip-position','right');
				$('.tooltips:not([tooltip-type])').attr('tooltip-type','danger');
				$("#"+tdId).find('span').empty().append(error);
				$("#"+tdId).find("span").delay(2000).fadeOut();
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
                // "url": "common/assets/DataTables/languages/<?php echo $this->language; ?>.json",
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
      // Get all rows wit12047h search applied
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
   
 function editModele(id) {
        // var id = $(this).data('id');
        $('#listeModele12').trigger("reset");
        $('#listeModele').html('');
        var tt = '<option id="" value=""  > Choisir un modele </option>';
        $.ajax({
            url: 'finance/listeModeleByLabo?id=' + id,
            method: 'GET',
            data: '',
            dataType: 'json'
        }).success(function (response) {
            console.log(response);
            $.each(response.liste, function (key, value) {
              //  $('select.liste-modele').append($('<option class="" data-id="' + value.id + '"  >' + value.name + '</option>').text(value.name).val(value.id));
             tt += '<option id="' + value.id + '"  value="' + value.id + '"  >' + value.name + '</option>';
            });
            $('#liste-modele').html(tt);

                       $('#myModaldone2').modal('show');
          if(response.modele) {
                $('#formistemodele').find('[name="idpco"]').val(response.modele.idpco).end();
            
            if(response.modele.name) {
           var option1 = new Option(response.modele.name, response.modele.id, true, true);
               $('#formistemodele').find('[name="liste-modele"]').append(option1).trigger('change');
           }
       }
        });
 }

function editPrices(idpco) {
	
	// var id = $(this).data('id');
	// $('#listeModele12').trigger("reset");
	// $('#listeModele').html('');
	// var tt = '<option id="" value=""  > Choisir un modele </option>';
	$.ajax({
		url: 'home/getPCODetails',
		method: 'GET',
		data: {
			idpco: idpco 
		},
		dataType: 'json'
	}).success(function (response) {
		
		// $.each(response.details, function (key, value) {
			// alert(key+":"+value);
		 // tt += '<option id="' + value.id + '"  value="' + value.id + '"  >' + value.name + '</option>';
		// });
		// $('#liste-modele').html(tt);

	  $('#myModaldone3').modal('show');
	  if(response.details) {
			$('#formEditPrices').find('[name="idpco"]').val(response.details.idpco).end();
			$('#formEditPrices').find('[name="service"]').val(response.details.name_service).end();
			$('#formEditPrices').find('[name="specialite"]').val(response.details.name_specialite).end();
			$('#formEditPrices').find('[name="prestation"]').val(response.details.prestation).end();
			const element = AutoNumeric.getAutoNumericElement('#tarif_public');
			element.set(response.details.tarif_public);
			const element2 = AutoNumeric.getAutoNumericElement('#tarif_professionnel');
			element2.set(response.details.tarif_professionnel);
			const element3 = AutoNumeric.getAutoNumericElement('#tarif_assurance');
			element3.set(response.details.tarif_assurance);
			const element4 = AutoNumeric.getAutoNumericElement('#tarif_ipm');
			element4.set(response.details.tarif_ipm);
			// $('#formEditPrices').find('[name="tarif_public"]').val(response.details.tarif_public).end();
			// $('#formEditPrices').find('[name="tarif_professionnel"]').val(response.details.tarif_professionnel).end();
			// $('#formEditPrices').find('[name="tarif_assurance"]').val(response.details.tarif_assurance).end();
			// $('#formEditPrices').find('[name="tarif_ipm"]').val(response.details.tarif_ipm).end();
		
	   }
	});
}

</script>