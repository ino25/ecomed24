<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="panel">
            <header class="panel-heading">
            <h4 style="color: #303f9f;margin-bottom: 10px;"><?php echo lang('list_of_nutuelle') ?></h4>
                
                <div class="col-md-4 no-print pull-right"> 
                   <a href="mutuelle/addNewView">
                        <div class="btn-group pull-right">
                            <button id="" class="btn pull-right  bg-blue" >
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
                                <th> <?php echo lang('insurance_name') ?></th>
                                <th> <?php echo lang('discount') ?> %</th>
                                <th> <?php echo lang('insurance_no') ?></th>
                                <th> <?php echo lang('insurance_code') ?></th>
                                <th class="no-print"> <?php echo lang('options') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($mutuelles as $mutuelle) { ?>
                                <tr class="">
                                    <td><?php echo $mutuelle->insurance_name; ?></td>
                                    <td><?php echo $mutuelle->discount; ?></td>
                                    <td><?php echo $mutuelle->insurance_no; ?></td>
                                     <td><?php echo $mutuelle->insurance_code; ?></td>
                                    <td class="no-print">
                                       <a  class="btn btn-xs btn_width " href="mutuelle/editMutuelle?id=<?php echo $mutuelle->id; ?>"  title="<?php echo lang('edit'); ?>" data-id="<?php echo $mutuelle->id; ?>" style="background-color:#fff;color:#0D4D96"><i class="fa fa-edit"></i> </a>   
                                        <a class="btn btn-xs btn_width delete_button" title="<?php echo lang('delete'); ?>" href="mutuelle/delete?id=<?php echo $mutuelle->id; ?>" onclick="return confirm('Êtes-vous sûr de bien vouloir supprimer ce tiers payant?');" style="background-color:#fff;color:#0D4D96"><i class="fa fa-trash"></i> </a>

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


<script src="<?php echo base_url(); ?>common/js/codearistos.min.js"></script>
<script type="text/javascript">
                                        $(document).ready(function () {
                                            $(".editbutton").click(function (e) {
                                                e.preventDefault(e);
                                                // Get the record's ID via attribute  
                                                var iid = $(this).attr('data-id');
                                                $.ajax({
                                                    url: 'mutuelle/editMutuelle?id=' + iid,
                                                    method: 'GET',
                                                    data: '',
                                                    dataType: 'json',
                                                }).success(function (response) {
                                                   
                                                   
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
