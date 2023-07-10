<!--sidebar end-->
<!--main content start-->



<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="panel">
            <header class="panel-heading" style="margin-top:41px;">
				<div class="col-md-4 no-print pull-right"> 
       
                        <div class="btn-group pull-right" style="margin-right:5px;">
                            <button id="" class="btn green btn-xs downloadbutton">
                                <i class="fa fa-plus-circle"></i>&nbsp;Importer Services & Spécialités
                            </button>
                        </div>
						<!--<div class="btn-group pull-right" style="margin-right:5px;">
                            <button id="" class="btn green btn-xs downloadbutton">
                                <i class="fa fa-plus-circle"></i>&nbsp;Ajouter un Service
                            </button>
                        </div>-->
                   
                </div>
                <h2>Services & Spécialités</h2>
				
            </header> 
			<div class="col-md-12">
                <?php
                $message2 = $this->session->flashdata('message2');
                if (!empty($message2)) {
                    ?>
                    <code class="flash_message pull-left"> <?php echo $message2; ?></code>
                <?php } ?> 
            </div>
            <div class="panel-body panel-bodyAlt">
                <div class="adv-table editable-table ">
                    <div class="space15"></div>
                    <table class="table table-hover progress-table" id="editable-sample">
                        <thead>
                            <tr>
                                 <!--<th> <?php echo lang('department') ?></th>-->
                                <th style="width:40%;"><?php echo lang('service');  ?></th>
                                <th style="width:40%;"><?php echo lang('speciality'); ?></th>
                                <th style="width:20%;" class="no-print">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($services as $service) 
							{ 
								// if($service->code_service == 'labo') 
								// { 
								?>
									<tr class="">
										<td><?php echo $service->name_service; ?> </td>
										<td><?php echo $service->name_specialite; ?></td>
									  
										<td class="no-print">
											<a href="javascript:;" class="btn btn-info btn-xs btn_width " data-id="<?php echo $service->idservice; ?>" disabled><i class="fa fa-edit"></i></a>   
										 
										</td>
									</tr>
								<?php 
								// } 
							} ?>
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



<script src="<?php echo base_url(); ?>common/js/ecomed24.min.js"></script>
<div class="modal fade" id="myModal2" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Importer Services & Prestations (xls, xlsx) </h4>
            </div>
			
            <div class="modal-body">
			<div class="btn-group" style="margin-right:5px;">
                            <a id="" class="btn green btn-xs btn-secondary" href="files/downloads/master_data_services_specialites.xlsx">
                                <i class="fa fa-download"></i>&nbsp;Télécharger le fichier de référence
                            </a>
                        </div>
                <form role="form" id="departmentEditForm" class="clearfix" action="home/importServicesSpecialitesInfo" method="post" enctype="multipart/form-data">

                    <div class="form-group has-feedback">
                                    <label for="exampleInputEmail1"> <?php echo lang('choose_file'); ?> rempli</label>
                                    <input type="file" class="form-control" placeholder="" name="filename" required accept=".xls, .xlsx ,.csv">
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
<script type="text/javascript">
                                      
</script>
<script>
    $(document).ready(function () {
        var table = $('#editable-sample').DataTable({
            responsive: true,

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
<script>
    $(document).ready(function () {
        // $(".flashmessage").delay(3000).fadeOut(100);
		
		$(".downloadbutton").click(function (e) {
            e.preventDefault(e);
            // Get the record's ID via attribute  
           $('#myModal2').modal('show');
        });
    });
</script>
