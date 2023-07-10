Payment<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="panel">
            <header class="panel-heading">
			
                <div class="col-md-6 no-print pull-right"> 
       
                        <div class="btn-group pull-right" style="margin-right:5px;">
                            <button id="" class="btn green btn-xs downloadbutton">
                                <i class="fa fa-plus-circle"></i> <?php echo lang('bulk_create_payment_procedure'); ?>
                            </button>
                        </div>
                   
                </div>
                <h2>Liste des Prestations: Service Labotaroire</h2>
            </header>
			<?php
			// echo "User Id:" .$this->session->userdata('user_id');
			// $users_groups = $this->ion_auth_model->get_users_groups($this->session->userdata('user_id'))->result();
			// $groups_array = array();
			// foreach ($users_groups as $group)
			// {
				// echo "Nom groupe:".$group->name;
			// }
			?>
            <div class="panel-body panel-bodyAlt">
                <div class="adv-table editable-table "> 
                    <div class="space15"></div>
                    <table class="table table-hover progress-table" id="editable-sample">
                        <thead>
                            <tr>
                                <th style=""><?php echo lang('speciality'); ?></th>
                                <th style=""><?php echo lang('procedure'); ?></th>
                                <th style=""><?php echo lang('description'); ?></th>
								
                                <?php 
								// A corriger: implementation du in_group pour le superadmin
								if ($this->ion_auth->in_group(array('admin', 'Accountant','adminmedecin'))) { ?>
                                    <th class="no-print" style="text-align:center;"><?php echo lang('options'); ?></th>
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

                        <?php foreach ($categories as $category) { ?>
                            <tr class="" >
                                <td style="vertical-align:middle;"> <?php echo $category->name_specialite; ?></td>
                                <td style="vertical-align:middle;"><?php echo $category->prestation; ?></td>   
                                <td style="vertical-align:middle;"> <?php echo $category->description; ?></td>

                                <?php if ($this->ion_auth->in_group(array('admin', 'Accountant','adminmedecin'))) { ?>
                                    <td class="no-print">
                                         <span class="btn btn-info btn-xs editbutton"  onclick="detailParametre(<?php echo $category->id; ?>)"><i class="fa fa-eye"> </i></span>
                                       
 <!--<a class="btn btn-info btn-xs delete_button" title="<?php // echo lang('delete'); ?>" href="finance/deletePaymentCategory?id=<?php // echo $category->id; ?>" onclick="return confi rm('Are you sure you want to delete this item?');"><i class="fa fa-trash"></i> </a>-->
                                    </td>
                                <?php } ?>
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

<div class="modal fade" id="myModaldone" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-paiement">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title myModaldoneTitle" id="myModaldoneTitle">  </h4>
            </div>
            <div class="modal-body" id="modal-body">
                <h3 id="title-checkDone"></h3>
                <div class="single-table">
                    <div class="table-responsive">
                        <table id="dataTable" class="table table-bordered table-hover dataTable">
                            <thead class="text-uppercase">
                                <tr>
                                <th scope="col" >PARAMETRES</th><th scope="col">UNITE</th><th scope="col">NORME</th>
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
  
<!--main content end-->
<!--footer start-->


<script src="<?php echo base_url(); ?>common/js/codearistos.min.js"></script>
<div class="modal fade" id="myModal2" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">  <?php echo lang('bulk_create_payment_procedure'); ?> (xls, xlsx) </h4>
            </div>
            <div class="modal-body">
                <form role="form" id="departmentEditForm" class="clearfix" action="home/importPrestationInfo" method="post" enctype="multipart/form-data">

                    <div class="form-group has-feedback">
                                    <label for="exampleInputEmail1"> <?php echo lang('choose_file'); ?></label>
                                    <input type="file" class="form-control" placeholder="" name="filename" required accept=".xls, .xlsx ,.csv">
                                    <span class="glyphicon glyphicon-file form-control-feedback"></span>
                                    <input type="hidden" name="tablename"value="payment_category">
                                </div>
                
                    <section class="">
                        <a href="javascript:$('#myModal2').modal('hide');" class="btn btn-info btn-secondary pull-left" >Retour</a>
						<button type="submit" name="submit" class="btn btn-info submit_button pull-right"> <?php echo lang('download') ?></button>
                    </section>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
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
						// className: 'dt-button-custom2',
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
			lengthMenu: [[10, 25, 50, 100, -1], ['10', '25', '50', '100', 'Tout']],
			// lengthMenu: [[10, 25, 50, 100], ['10', '25', '50', '100']],
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
        
        
        
        $(".downloadbutton").click(function (e) {
            e.preventDefault(e);
            // Get the record's ID via attribute  
           $('#myModal2').modal('show');
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
            var result = '<table>'; var title = '';
           $.each(response.prestations, function (key, value) {
               var uu = ''; if(value.unite){uu= value.unite;}
                 var uu2 = ''; if(value.valeurs){uu2= value.valeurs;}
               result += '<tr><td>'+value.nom_parametre+'</td><td>'+uu+'</td><td>'+uu2+'</td></tr>';
               title = value.name_specialite
           });
           result += '</table>';
           $('#deposit-checkDone').html(result);
        
$('#title-checkDone').html(' Service: Laboratoire - ' +' Specialite: '+title);

            $('#myModaldone').modal('show');
        });
    }

</script>
