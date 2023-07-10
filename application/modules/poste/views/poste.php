<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="panel">
            <header class="panel-heading">
          <?php echo lang('list_of_postes') ?>
                
                <div class="col-md-4 no-print pull-right"> 
                    <a data-toggle="modal" href="#myModal">
                        <div class="btn-group pull-right">
                            <button id="" class="btn green btn-xs">
                                <i class="fa fa-plus-circle"></i> <?php echo lang('add_new'); ?>
                            </button>
                        </div>
                    </a>
                </div>
            </header> 
            <div class="panel-body">
                <div class="adv-table editable-table ">
                    <div class="space15"></div>
                    <table class="table table-hover progress-table text-center" id="editable-sample">
                        <thead>
                            <tr>
                                 <th> <?php echo lang('service') ?></th>
                                <th> <?php echo lang('poste') ?></th>
                                <th> <?php echo lang('description') ?></th>
                                <th class="no-print"> <?php echo lang('options') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($postes as $poste) { ?>
                                <tr class="">
                                     <td><?php echo $poste->name_service; ?></td>
                                    <td><?php echo $poste->name_poste; ?></td>
                                    <td><?php echo $poste->description_poste; ?></td>
                                    <td class="no-print">
                                        <button type="button" class="btn btn-info btn-xs btn_width editbutton" data-toggle="modal" title="<?php echo lang('edit'); ?>" data-id="<?php echo $poste->idposte; ?>" ><i class="fa fa-edit"></i> </button>   
                                        <a class="btn btn-info  btn-xs btn_width delete_button" title="<?php echo lang('delete'); ?>" href="poste/delete?id=<?php echo $poste->idposte; ?>" onclick="return confirm('Êtes-vous sûr de bien vouloir supprimer ce poste?');" ><i class="fa fa-trash"></i> </a>

                                    </td>
                         
                                </tr>
                            <?php } ?>
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




<!-- Add Poste Modal-->
<div class="modal fade" id="myModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"> <?php echo lang('add_poste') ?></h4>
            </div> 
            <div class="modal-body">
                <form role="form" action="poste/addNew" class="clearfix" method="post" enctype="multipart/form-data">
                     <div class="form-group ">
                        <label for="exampleInputEmail1"><?php echo lang('department'); ?> <span class="fa fa-star label-required"></span></label>
                        <select class="form-control m-bot15 js-example-basic-single" name="service" required="" >    <option value="">Veuillez sélectionner un service</option>
                            <?php foreach ($services as $service) { 
                            
                                ?>
                                <option value="<?php echo $service->idservice; ?>"> <?php echo $service->name_service; ?> </option>
                            <?php } ?> 
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="exampleInputEmail1"> <?php echo lang('poste') ?> <span class="fa fa-star label-required"></span></label>
                        <input type="text" class="form-control" name="name" id="exampleInputEmail1" value='' required=""  min="2" max="100" >
                    </div>
                    <div class="form-group">
                        <label class=""> <?php echo lang('description') ?></label>
                        <div class="">
                            <textarea class="ckeditor form-control" name="description" value="" rows="10">  </textarea>
                        </div>
                    </div>
                    <input type="hidden" name="id" value=''>
                    <section class="">
                        <button type="submit" name="submit" class="btn   btn-info submit_button pull-right"> <?php echo lang('submit') ?></button>
                    </section>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!-- Add Poste Modal-->

<!-- Edit Poste Modal-->
<div class="modal fade" id="myModal2" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">   <?php echo lang('edit_poste') ?></h4>
            </div>
            <div class="modal-body">
                <form role="form" id="posteEditForm" class="clearfix" action="poste/addNew" method="post" enctype="multipart/form-data">
                     <div class="form-group ">
                        <label for="exampleInputEmail1"><?php echo lang('service'); ?> <span class="fa fa-star label-required"></span></label>
                        <select class="form-control" name="service" required="" >  
                            <option value="">Veuillez sélectionner un service</option>
                            <?php foreach ($services as $service) {  ?>
                                <option 
                                      <?php  if (!empty($poste->id_service)) {                                
                                    if ($service->idservice == $poste->id_service) {
                                        echo ' selected';
                                    }
                                }?>
                                    
                                    value="<?php echo $service->idservice; ?>"> <?php echo $service->name_service; ?> </option>
                            <?php } ?> 
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1"> <?php echo lang('poste') ?> </label>
                        <input type="text" class="form-control" name="name" id="exampleInputEmail1" value='' required=""  min="2" max="100" >
                    </div>
                    <div class="form-group">
                        <label class=""> <?php echo lang('description') ?></label>
                        <div class="">
                            <textarea class="ckeditor form-control editor" id="editor" name="description" value="" rows="10">  </textarea>
                        </div>
                    </div>
                    <input type="hidden" name="id" value=''>
                    <input type="hidden" name="p_id" value=''>

                    <section class="">
                        <button type="submit" name="submit" class="btn   btn-info submit_button pull-right"> <?php echo lang('submit') ?></button>
                    </section>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<script src="<?php echo base_url(); ?>common/js/codearistos.min.js"></script>
<script type="text/javascript">
                                        $(document).ready(function () {
                                            $(".editbutton").click(function (e) {
                                                e.preventDefault(e);
                                                // Get the record's ID via attribute  
                                                var iid = $(this).attr('data-id');
                                                $.ajax({
                                                    url: 'poste/editPosteByJason?id=' + iid,
                                                    method: 'GET',
                                                    data: '',
                                                    dataType: 'json',
                                                }).success(function (response) {
                                                    // Populate the form fields with the data returned from server
                                                    $('#posteEditForm').find('[name="id"]').val(response.poste.idposte).end()
                                                    $('#posteEditForm').find('[name="name"]').val(response.poste.name_poste).end()
                                                     $('#posteEditForm').find('[name="service"]').val(response.poste.id_service).end()
                                                    CKEDITOR.instances['editor'].setData(response.poste.description_poste)
                                                    $('#myModal2').modal('show');
                                                });
                                            });
                                        });
</script>
<script>
    $(document).ready(function () {
        var aujourdhui = new Date(); 
	var annee = aujourdhui.getFullYear(); // retourne le millésime
	var mois =aujourdhui.getMonth()+1; // date.getMonth retourne un entier entre 0 et 11 donc il faut ajouter 1
	var jour = aujourdhui.getDate(); // retourne le jour (1à 31)
        var joursemaine = aujourdhui.getDay() ;
        var heure = aujourdhui.getHours();
        var minute = aujourdhui.getMinutes();
        var seconde = aujourdhui.getSeconds();
	var tab_jour=new Array("Dimanche", "Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi");
	var dateExport = tab_jour[joursemaine] + ' ' + jour + '/' + mois + '/' + annee + ' à ' + heure + 'h:' + minute + 'min';
        var fin = jour + '_' + mois + '_' + annee + '_' + heure + 'h' + minute;
        
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
							// columns: [0,1],
						// }
					// },
					// {
						// extend: 'pdfHtml5',
						// className: 'dt-button-icon-left dt-button-icon-pdf',
						// exportOptions: {
							// columns: [0,1],
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
        $(".flashmessage").delay(3000).fadeOut(100);
    });
</script>
