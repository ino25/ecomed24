
<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="panel">

            <header class="panel-heading" style="margin-top:41px;">
                <h2><?php echo lang('autoemailtemplate'); ?></h2>
            </header>

            <div class="panel-body panel-bodyAlt">
                <div class="adv-table editable-table ">

                    <div class="space15"></div>
                    <table class="table table-hover progress-table" id="editable-sample1">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th><?php echo "Déclencheur" ?></th>
                                <th><?php echo lang("subject"); ?></th>
                                <th><?php echo lang('message'); ?></th> 
                                <th><?php echo lang('status'); ?></th>
                                <th>Actions</th>
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
<!--main content end-->



<!-- Edit sms temp Modal-->
<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"><?php echo lang('edit'); ?> <?php echo lang('auto'); ?> <?php echo lang('template'); ?></h4>
            </div>
            <div class="modal-body">
                <?php echo validation_errors(); ?>
                <form role="form" id="emailtemp" name="myform" action="email/addNewAutoEmailTemplate" method="post" enctype="multipart/form-data">                                                                                    

                    <div class="form-group">
                        <label for="exampleInputEmail1"> <?php echo lang('subject'); ?></label>
                        <input type="text" class="form-control" name="category" id="exampleInputEmail1" value='' placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1"> <?php echo lang('message'); ?> <?php echo lang('template'); ?></label><br>
                        <div id="divbuttontag"></div>

                        <br><br>
                        <textarea class="ckeditor" name="message" id="editor1" value="" cols="70" rows="10"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1"> <?php echo lang('status'); ?> </label>
                        <select class="form-control" id="status" name="status"> 
                        </select> 
                    </div>
                    <input type="hidden" name="id" value=''>
                    <input type="hidden" name="type" value='email'>
                    <button type="submit" name="submit" class="btn btn-info"><?php echo lang('submit'); ?></button>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<script src="<?php echo base_url(); ?>common/js/codearistos.min.js"></script>

<script type="text/javascript">
    $(document).ready(function () {
        $(".table").on("click", ".editbutton1", function () {
            var iid = $(this).attr('data-id');
            $('#divbuttontag').html("");

            $.ajax({
                url: 'email/editAutoEmailTemplate?id=' + iid,
                method: 'GET',
                data: '',
                dataType: 'json',
            }).success(function (response) {
                // Populate the form fields with the data returned from server
                $('#emailtemp').find('[name="id"]').val(response.autotemplatename.id).end();
                $('#emailtemp').find('[name="category"]').val(response.autotemplatename.name).end();
                CKEDITOR.instances['editor1'].setData(response.autotemplatename.message);
                //  $('#smstemp').find('[name="message"]').val(response.autotemplatename.message).end();
                var option = '';
                var count = 0;
                $.each(response.autotag, function (index, value) {
                    option += '<input type="button" name="myBtn" value="' + value.name + '" onClick="addtext(this);">';
                    count += 1;
                    if (count % 7 === 0) {
                        option += '<br><br>';
                    }
                });
                $('#divbuttontag').html(option);
                $('#status').html(response.status_options);
                $('#myModal1').modal('show');
            });
        });
    });
</script>
<script>


    $(document).ready(function () {
        var table = $('#editable-sample1').DataTable({
            responsive: true,
            //   dom: 'lfrBtip',

            "processing": true,
            // "serverSide": true,
            "searchable": true,
            "ajax": {
                url: "email/getAutoEmailTemplateList",
                type: 'POST',
                'data': {'type': 'sms'}
            },
            scroller: {
                loadingIndicator: true
            },
            dom: "<'row'<'col-sm-4 pull-left'l><'col-sm-4 pull-left'B><'col-sm-4 pull-right'f>>" +
				"<'row'<'col-sm-12'tr>>" +
				"<'row'<'col-sm-5'i><'col-sm-7'p>>",
			buttons: {
				buttons: [
					// {
						// extend: 'pageLength',
					// },
					{
						extend: 'excelHtml5',
						className: 'dt-button-icon-left dt-button-icon-excel',
						exportOptions: {
							columns: [0,1,2],
						}
					},
					{
						extend: 'pdfHtml5',
						className: 'dt-button-icon-left dt-button-icon-pdf',
						exportOptions: {
							columns: [0,1,2],
						}
					},
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
        table.buttons().container()
                .appendTo('.custom_buttons');
    });
</script>
<script>
    $(document).ready(function () {
        $(".flashmessage").delay(3000).fadeOut(100);
    });
</script>

<script>
    function addtext(ele) {
        var fired_button = ele.value;
        var value = CKEDITOR.instances.editor1.getData()
        value += fired_button;

        // console.log(value);
        CKEDITOR.instances['editor1'].setData(value)
        //  console.log(fired_button);
        //document.myform.message.value += fired_button;
    }
</script>
<script>
    function addtext1(ele) {
        var fired_button = ele.value;
        document.myform1.message.value += fired_button;
    }
</script>
<script>
    $(document).ready(function () {
        CKEDITOR.config.autoParagraph = false;
    });
</script>