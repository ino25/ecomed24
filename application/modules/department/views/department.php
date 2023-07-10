<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="panel">
            <header class="panel-heading" style="margin-top:41px;">
                <div class="col-md-4 no-print pull-right"> 
                    <a data-toggle="modal" href="#myModal">
                        <div class="btn-group pull-right">
                            <button id="" class="btn green btn-xs">
                                <i class="fa fa-plus-circle"></i> Ajouter un Département
                            </button>
                        </div>
                    </a>
                </div>
                <h2>Départements</h2>
            </header> 
            <div class="panel-body panel-bodyAlt">
                <div class="adv-table editable-table ">
                    <div class="space15"></div>
                    <table class="table table-hover progress-table" id="editable-sample">
                        <thead>
                            <tr>
                                <th><?php echo lang('nom_name') ?></th>
                                <th><?php echo lang('description') ?></th>
                                <th class="no-print"><?php echo lang('options') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($departments as $department) { ?>
                                <tr class="">
                                    <td><?php echo $department->name; ?></td>
                                    <td><?php echo $department->description; ?></td>
                                    <td class="no-print">
                                        <button type="button" class="btn btn-info btn-xs btn_width editbutton" data-toggle="modal" title="<?php echo lang('edit'); ?>" data-id="<?php echo $department->id; ?>"><i class="fa fa-edit"></i> </button>   
                                        <!--<a class="btn btn-info btn-xs btn_width delete_button" title="<?php // echo lang('delete'); ?>" href="department/delete?id=<?php // echo $department->id; ?>" onclick="return confirm('Are you sure you want to delete this item?');"><i class="fa fa-trash"></i> </a>-->
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




<!-- Add Department Modal-->
<div class="modal fade" id="myModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Ajouter un Département</h4>
            </div> 
            <div class="modal-body">
                <form role="form" action="department/addNew" class="clearfix" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="exampleInputEmail1"> <?php echo lang('department') ?></label>
                        <input type="text" class="form-control" name="name" id="exampleInputEmail1" value='' placeholder=""  required="" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label class=""> <?php echo lang('description') ?></label>
                        <div class="">
                            <textarea class="ckeditor form-control" name="description" value="" rows="10">  </textarea>
                        </div>
                    </div>
                    <input type="hidden" name="id" value=''>
                    <section class="">
						<a href="javascript:$('#myModal').modal('hide');" class="btn btn-info btn-secondary pull-left" >Retour</a>
                        <button type="submit" name="submit" class="btn btn-info submit_button pull-right"> <?php echo lang('add') ?></button>
                    </section>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!-- Add Department Modal-->

<!-- Edit Department Modal-->
<div class="modal fade" id="myModal2" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Modifier Département</h4>
            </div>
            <div class="modal-body">
                <form role="form" id="departmentEditForm" class="clearfix" action="department/addNew" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="exampleInputEmail1"> <?php echo lang('department') ?> </label>
                        <input type="text" class="form-control" name="name" id="exampleInputEmail1" value='' placeholder="">
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
						<a href="javascript:$('#myModal2').modal('hide');" class="btn btn-info btn-secondary pull-left" >Retour</a>
                        <button type="submit" name="submit" class="btn btn-info submit_button pull-right"> <?php echo lang('edit') ?></button>
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
                                                    url: 'department/editDepartmentByJason?id=' + iid,
                                                    method: 'GET',
                                                    data: '',
                                                    dataType: 'json',
                                                }).success(function (response) {
                                                    // Populate the form fields with the data returned from server
                                                    $('#departmentEditForm').find('[name="id"]').val(response.department.id).end()
                                                    $('#departmentEditForm').find('[name="name"]').val(response.department.name).end()
                                                    CKEDITOR.instances['editor'].setData(response.department.description)
                                                    $('#myModal2').modal('show');
                                                });
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
