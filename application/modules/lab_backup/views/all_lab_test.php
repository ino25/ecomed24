<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="">
            <header class="panel-heading">
                <?php echo lang('lab_test'); ?> 
                <?php if (!$this->ion_auth->in_group('Laboratorist')) { ?>
                    <div class="col-md-4 no-print pull-right"> 
                        <a  href="lab/allActiveLabTest">
                            <div class="btn-group pull-right">
                                <button id="" class="btn green btn-xs">
                                    <i class="fa fa-plus-circle"></i> <?php echo lang('import') . ' ' . lang('lab_test'); ?>
                                </button>
                            </div>
                        </a>
                    </div>
                <?php } ?>
            </header>
            <style>

                .switch {
                    position: relative;
                    display: inline-block;
                    width: 50px !important;
                    height: 25px !important;
                }


                .switch input {
                    opacity: 0;
                    width: 0;
                    height: 0;
                }


                .slider {
                    position: absolute;
                    cursor: pointer;
                    top: 0;
                    left: 0;
                    right: 0;
                    bottom: 0;
                    background-color: #ccc;
                    -webkit-transition: .4s;
                    transition: .4s;
                }

                .slider:before {
                    position: absolute;
                    content: "";
                    height: 16px !important;
                    width: 16px !important;
                    left: 5px !important;
                    bottom: 5px !important;
                    background-color: white;
                    -webkit-transition: .4s;
                    transition: .4s;
                }
                .slider {
                    margin-top: 0px !important;
                }
                input:checked + .slider {
                    background-color: #2196F3;
                }

                input:focus + .slider {
                    box-shadow: 0 0 1px #2196F3;
                }

                input:checked + .slider:before {
                    -webkit-transform: translateX(26px);
                    -ms-transform: translateX(26px);
                    transform: translateX(26px);
                }

                /* Rounded sliders */
                .slider.round {
                    border-radius: 34px;
                }

                .slider.round:before {
                    border-radius: 50%;
                }

            </style>

            <div class="panel-body"> 
                <div class="adv-table editable-table">
                    <div class="space15">
                    </div>
                    <table class="table table-hover progress-table text-center" id="editable-sample1">
                        <thead>
                            <tr>
                                <th> <?php echo lang('id'); ?></th>
                                <th> <?php echo lang('name'); ?></th>
                                <th> <?php echo lang('description'); ?></th>
                                <th> <?php echo lang('speciality'); ?></th>
                                <th> <?php echo lang('price'); ?></th>
                                <th> <?php echo lang('status'); ?></th>
                                <th> <?php echo lang('options'); ?></th>
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

                            .load{
                                float: right !important;
                            }

                        </style>


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
<?php
$current_user = $this->ion_auth->get_user_id();
$laboratorist_id = $this->db->get_where('laboratorist', array('ion_user_id' => $current_user))->row()->id;
?>
<!-- Load Medicine -->
<div class="modal fade" id="myModal3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"> <?php echo lang('import'); ?> <?php echo lang('lab_test'); ?></h4>
            </div>
            <div class="modal-body">
                <form role="form" id="editLabTestForm" class="clearfix" action="lab/importLabTest" method="post" enctype="multipart/form-data">


                    <div class="form-group col-md-12">
                        <label for="exampleInputEmail1"> <?php echo lang('add_price'); ?></label>
                        <input type="number" min="1" step="0.01" class="form-control" name="add_price" id="exampleInputEmail1" value='' placeholder="">
                    </div>
                    <div class="form-group col-md-12">
                        <label for="exampleInputEmail1"> <?php echo lang('status'); ?></label>
                        <select name="status" class="form-control" >
                            <option value="active"><?php echo lang('active'); ?></option>
                            <option value="inactive"><?php echo lang('in_active'); ?></option>
                        </select>
                    </div>
                    <input type="hidden" name="id" value=''>

                    <div class="form-group">
                        <button type="submit" name="submit" class="btn btn-info pull-right"> <?php echo lang('submit'); ?></button>
                    </div>
                </form>

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!-- Load Medicine -->


<script src="<?php echo base_url(); ?>common/js/codearistos.min.js"></script>
<script src="common/assets/switchery/switchery.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $(".table").on("click", ".editbutton", function () {


            var iid = $(this).attr('data-id');
            $('#editLabTestForm').trigger("reset");
            $('#myModal3').modal('show');
            $.ajax({
                url: 'lab/editImportedLabTestByJason?id=' + iid,
                method: 'GET',
                data: '',
                dataType: 'json',
            }).success(function (response) {
                // Populate the form fields with the data returned from server
                $('#editLabTestForm').find('[name="id"]').val(response.lab.id).end();
                $('#editLabTestForm').find('[name="add_price"]').val(response.lab.add_price).end();
                $('#editLabTestForm').find('[name="status"]').val(response.lab.status).trigger('change');

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
            "serverSide": true,
            "searchable": true,
            "ajax": {
                url: "lab/getAllImportedLabList",
                type: 'POST',
            },
            scroller: {
                loadingIndicator: true
            },
            dom: "<'row'<'col-sm-4 pull-left'l><'col-sm-4 pull-left'B><'col-sm-4 pull-right'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-5'i><'col-sm-7'p>>",
            buttons: {
                buttons: [

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
        table.buttons().container().appendTo('.custom_buttons');


    });
</script>


<script>
    $(document).ready(function () {
        $(document).on('change', '.references_class', function () {
            var id = $(this).data('id');
            if ($(this).is(":checked")) {
                var value = 'active';
            } else {
                var value = 'inactive';
            }
            $.ajax({
                url: 'lab/updateImportedLabTestStatus?id=' + id + '&value=' + value,
                method: 'GET',
                data: '',
                dataType: 'json',
            }).success(function (response) {
                console.log(response.response)
            });
        })
        $(".flashmessage").delay(3000).fadeOut(100);
    });
</script>