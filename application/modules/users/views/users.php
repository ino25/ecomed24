<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="panel">
            <header class="panel-heading" style="margin-top:41px;">
                <div class="col-md-4 no-print pull-right"> 
                    <a href="users/addNonPatientUser">
                        <div class="btn-group pull-right">
                            <button id="" class="btn green btn-xs">
                                <i class="fa fa-plus-circle"></i> Ajouter Utilisateur
                            </button>
                        </div>
                    </a>
                </div>
                <h2>Utilisateurs</h2>
            </header>
            <div class="panel-body panel-bodyAlt">
                <div class="adv-table editable-table ">
                    <div class="space15"></div>
                    <table class="table table-hover progress-table" id="editable-sample">
                        <thead>
                            <tr>
                                <th>&nbsp;</th>
                                <th>Utilisateur</th>
                                <th><?php echo lang('service'); ?></th>
                                <th><?php echo lang('phone'); ?></th>
                                <th>Fonction</th>
								<th>Dernière connexion</th>
                                <th class="no-print"><?php echo lang('options'); ?></th>
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

                        <?php foreach ($users as $user) { 
						$last_login = $user->last_login != "" ? date('d/m/Y H:i:s', $user->last_login) : "";
						?>
                            <tr class="">
                                <td style="width:10%;vertical-align:middle;">
								<?php
								if (!empty($user->img_url)) {
								?>
									<img class="avatar" style="max-width:50px;max-height:50px;" src="<?php echo $user->img_url; ?>">
								<?php } else { ?>
								<img class="avatar" style="width:50px;height:50px;" src="uploads/imgUsers/24_519.png">
								<?php } ?>
								</td>
                                <td style="vertical-align:middle;"> <?php echo $user->first_name." ".$user->last_name ; ?></td>
                                  <td style="vertical-align:middle;"><?php echo $user->service_name; ?></td>
                                    <td style="vertical-align:middle;"><?php echo $user->phone; ?></td>
                                <!--<td style="vertical-align:middle;"><?php echo $user->email; ?></td>-->
                                
                                <!--<td class="center" style="vertical-align:middle;"><?php echo $user->adresse; ?></td>-->
                                <td class="center" style="vertical-align:middle;"><?php if ($user->group_label_fr === 'Médecin'){
                                    echo 'Médecin Biologiste';
                                }else if ($user->group_label_fr === 'Biologiste Médical') {
                                    echo 'Technicien(ne) de Laboratoire';
                                }
                                    else if ($user->group_label_fr === 'Réceptionniste') {
                                        echo 'Secrétaire';
                                } else echo $user->group_label_fr; ?></td>
                              
                                <td style="vertical-align:middle;"><?php echo $last_login; ?></td>
                                <td class="no-print" style="vertical-align:middle;">
									<a class="btn btn-info btn-xs editbutton"  title="<?php echo lang('edit'); ?>" href="users/editNonPatientUser?id=<?php echo $user->id ?>"><i class="fa fa-eye"></i></a>
									<!--<a class="btn btn-info btn-xs editbutton" title="Modifier Utilisateur"  href="users/editNonAdminUser?id=<?php //echo $user->id ?>"><i class="fa fa-edit"></i> </a>-->
                                    <!--<button type="button" class="btn btn-info btn-xs btn_width editbutton" title="<?php //echo lang('edit'); ?>" data-toggle="modal" data-id="<?php // echo $user->id; ?>"><i class="fa fa-edit"> </i></button>-->   
                                    <!--<a class="btn btn-info btn-xs btn_width delete_button" title="<?php // echo lang('delete'); ?>" href="nurse/delete?id=<?php // echo $nurse->id; ?>" onclick="return confirm('Are you sure you want to delete this item?');"><i class="fa fa-trash"></i> </a>-->
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
                                    // $(document).ready(function () {
                                        // $(".editbutton").click(function (e) {
                                            // e.preventDefault(e);
                                            // Get the record's ID via attribute  
                                            // var iid = $(this).attr('data-id');
                                            // $('#editNurseForm').trigger("reset");
                                            // $.ajax({
                                                // url: 'nurse/editNurseByJason?id=' + iid,
                                                // method: 'GET',
                                                // data: '',
                                                // dataType: 'json',
                                            // }).success(function (response) {
                                                // Populate the form fields with the data returned from server
                                                // $('#editNurseForm').find('[name="id"]').val(response.nurse.id).end()
                                                // $('#editNurseForm').find('[name="name"]').val(response.nurse.name).end()
                                                // $('#editNurseForm').find('[name="password"]').val(response.nurse.password).end()
                                                // $('#editNurseForm').find('[name="email"]').val(response.nurse.email).end()
                                                // $('#editNurseForm').find('[name="address"]').val(response.nurse.address).end()
                                                // $('#editNurseForm').find('[name="phone"]').val(response.nurse.phone).end()
                                                // $('#myModal2').modal('show');
                                            // });

                                        // });
                                    // });
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
							// columns: [1, 2, 3, 4],
						// }
					// },
					// {
						// extend: 'pdfHtml5',
						// className: 'dt-button-icon-left dt-button-icon-pdf',
						// exportOptions: {
							// columns: [1, 2, 3, 4],
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
        $(".flashmessage").delay(3000).fadeOut(100);
    });
</script>

