<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="">
            <header class="panel-heading col-md-12">
                <div class="col-md-7 no-print pull-left"> 
                    <?php echo lang('medicine'); ?> </div>
                <?php if (!$this->ion_auth->in_group('Pharmacist')) { ?>
                    <div class="col-md-2 no-print pull-right"> 
                        <a data-toggle="modal" href="#myModal">
                            <div class="btn-group pull-right">
                                <button id="" class="btn green btn-xs">
                                    <i class="fa fa-plus-circle"></i> <?php echo lang('add_medicine'); ?>
                                </button>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-1 no-print pull-right"> </div>
                    <div class="col-md-2 btn-group pull-right" style="">
                        <button id="" class="btn green btn-xs downloadbutton">
                            <i class="fa fa-plus-circle"></i>&nbsp;<?php echo lang('import'); ?> <?php echo lang('medicine'); ?>
                        </button>
                    </div>
                <?php } ?>
            </header>


            <div class="panel-body"> 
                <div class="adv-table editable-table">
                    <div class="space15">
                    </div>
                    <table class="table table-hover progress-table text-center" id="editable-sample1">
                        <thead>
                            <tr>

                                <th> <?php echo lang('name'); ?></th>
                                <th> <?php echo lang('category'); ?></th>
                                <th> <?php echo lang('type'); ?></th>
                                <th> <?php echo lang('dosage'); ?></th>
                                <th> <?php echo lang('generic_name'); ?></th>
                                <th> <?php echo lang('company'); ?></th>
                                <th> <?php echo lang('description'); ?></th>
                                <?php if (!$this->ion_auth->in_group(array('Pharmacist'))) { ?>
                                    <th> <?php echo lang('status'); ?></th>
                                <?php } ?>
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






<!-- Add Accountant Modal-->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">  <?php echo lang('add_medicine'); ?></h4>
            </div>
            <div class="modal-body row">
                <form role="form" action="medicine/addMasterMedicine" class="clearfix" method="post" enctype="multipart/form-data">
                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"> <?php echo lang('name'); ?></label>
                        <input type="text" class="form-control" name="name" id="exampleInputEmail1" value='' placeholder="">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"> <?php echo lang('category'); ?></label>
                        <select class="form-control js-example-basic-single" name="category" value=''>
                            <?php foreach ($categories as $category) { ?>
                                <option value="<?php echo $category->category; ?>" <?php
                                if (!empty($medicine->category)) {
                                    if ($category->category == $medicine->category) {
                                        echo 'selected';
                                    }
                                }
                                ?> > <?php echo $category->category; ?> </option>
                                    <?php } ?> 
                        </select>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"> <?php echo lang('dosage'); ?></label>
                        <input type="text" class="form-control" name="dosage" id="exampleInputEmail1" value='' placeholder="">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"> <?php echo lang('type'); ?></label>
                        <select class="form-control js-example-basic-single" name="type" value=''>
                            <?php foreach ($types as $category) { ?>
                                <option value="<?php echo $category->type; ?>" <?php
                                if (!empty($medicine->type)) {
                                    if ($category->type == $medicine->type) {
                                        echo 'selected';
                                    }
                                }
                                ?> > <?php echo $category->type; ?> </option>
                                    <?php } ?> 
                        </select>
                    </div>
                    <!--                    <div class="form-group col-md-3">
                                            <label for="exampleInputEmail1"> <?php echo lang('quantity'); ?></label>
                                            <input type="text" class="form-control" name="quantity" id="exampleInputEmail1" value='' placeholder="">
                                        </div>-->
                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"> <?php echo lang('generic_name'); ?></label>
                        <input type="text" class="form-control" name="generic" id="exampleInputEmail1" value='' placeholder="">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"> <?php echo lang('company'); ?></label>
                        <input type="text" class="form-control" name="company" id="exampleInputEmail1" value='' placeholder="">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"> <?php echo lang('description'); ?></label>
                        <input type="text" class="form-control" name="description" id="exampleInputEmail1" value='' placeholder="">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"> <?php echo lang('status'); ?></label>
                        <select class="form-control m-bot15" name="status" value=''>
                            <option value="Active" <?php
                            if (!empty($medicine->status)) {
                                if ($medicine->status == 'Active') {
                                    echo 'selected';
                                }
                            }
                            ?> > <?php echo lang('active'); ?> </option> 
                            <option value="Deactive" <?php
                            if (!empty($medicine->status)) {
                                if ($medicine->status == 'Deactive') {
                                    echo 'selected';
                                }
                            }
                            ?> > <?php echo lang('deactive'); ?> </option>

                        </select>
                    </div>
                    <!--                    <div class="form-group col-md-4"> 
                                            <label for="exampleInputEmail1"> <?php echo lang('store_box'); ?></label>
                                            <input type="text" class="form-control" name="box" id="exampleInputEmail1" value='' placeholder="">
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="exampleInputEmail1"> <?php echo lang('expiry_date'); ?></label>
                                            <input type="text" class="form-control default-date-picker" name="e_date" id="exampleInputEmail1" value='' placeholder="" readonly="">
                                        </div>-->
                    <div class="form-group col-md-12">
                        <button type="submit" name="submit" class="btn btn-info pull-right"> <?php echo lang('submit'); ?></button>
                    </div>
                </form>

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!-- Add Accountant Modal-->







<!-- Edit Event Modal-->
<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">  <?php echo lang('edit_medicine'); ?></h4>
            </div>
            <div class="modal-body row">
                <form role="form" id="editMedicineForm" class="clearfix" action="medicine/addMasterMedicine" method="post" enctype="multipart/form-data">
                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"> <?php echo lang('name'); ?></label>
                        <input type="text" class="form-control" name="name" id="exampleInputEmail1" value='' placeholder="">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"> <?php echo lang('category'); ?></label>
                        <select class="form-control js-example-basic-single" name="category" value=''>
                            <?php foreach ($categories as $category) { ?>
                                <option value="<?php echo $category->category; ?>" <?php
                                if (!empty($medicine->category)) {
                                    if ($category->category == $medicine->category) {
                                        echo 'selected';
                                    }
                                }
                                ?> > <?php echo $category->category; ?> </option>
                                    <?php } ?> 
                        </select>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"> <?php echo lang('dosage'); ?></label>
                        <input type="text" class="form-control" name="dosage" id="exampleInputEmail1" value='' placeholder="">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"> <?php echo lang('type'); ?></label>
                        <select class="form-control js-example-basic-single" name="type" value=''>
                            <?php foreach ($types as $category) { ?>
                                <option value="<?php echo $category->type; ?>" <?php
                                if (!empty($medicine->type)) {
                                    if ($category->type == $medicine->type) {
                                        echo 'selected';
                                    }
                                }
                                ?> > <?php echo $category->type; ?> </option>
                                    <?php } ?> 
                        </select>
                    </div>
                    <!--                    <div class="form-group col-md-3">
                                            <label for="exampleInputEmail1"> <?php echo lang('quantity'); ?></label>
                                            <input type="text" class="form-control" name="quantity" id="exampleInputEmail1" value='' placeholder="">
                                        </div>-->
                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"> <?php echo lang('generic_name'); ?></label>
                        <input type="text" class="form-control" name="generic" id="exampleInputEmail1" value='' placeholder="">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"> <?php echo lang('company'); ?></label>
                        <input type="text" class="form-control" name="company" id="exampleInputEmail1" value='' placeholder="">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"> <?php echo lang('description'); ?></label>
                        <input type="text" class="form-control" name="description" id="exampleInputEmail1" value='' placeholder="">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"> <?php echo lang('status'); ?></label>
                        <select class="form-control m-bot15" name="status" value=''>
                            <option value="Active" <?php
                            if (!empty($medicine->status)) {
                                if ($medicine->status == 'Active') {
                                    echo 'selected';
                                }
                            }
                            ?> > <?php echo lang('active'); ?> </option> 
                            <option value="Deactive" <?php
                            if (!empty($medicine->status)) {
                                if ($medicine->status == 'Deactive') {
                                    echo 'selected';
                                }
                            }
                            ?> > <?php echo lang('deactive'); ?> </option>

                        </select>
                    </div>
                    <!--                    <div class="form-group col-md-4"> 
                                            <label for="exampleInputEmail1"> <?php echo lang('store_box'); ?></label>
                                            <input type="text" class="form-control" name="box" id="exampleInputEmail1" value='' placeholder="">
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="exampleInputEmail1"> <?php echo lang('expiry_date'); ?></label>
                                            <input type="text" class="form-control default-date-picker" name="e_date" id="exampleInputEmail1" value='' placeholder="" readonly="">
                                        </div>-->

                    <input type="hidden" name="id" value=''>
                    <div class="form-group col-md-12">
                        <button type="submit" name="submit" class="btn btn-info pull-right"> <?php echo lang('submit'); ?></button>
                    </div>



                </form>

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!-- Edit Event Modal-->



<div class="modal fade" id="myModalMaster" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"><?php echo lang('import'); ?> <?php echo lang('medicine'); ?> (xls, xlsx) </h4>
            </div>

            <div class="modal-body">
                <div class="btn-group" style="margin-right:5px;">
                    <a id="" class="btn green btn-xs btn-secondary" href="files/downloads/master_medicine_list.xlsx">
                        <i class="fa fa-download"></i>&nbsp;Télécharger le fichier de référence
                    </a>
                </div>
                <form role="form" id="departmentEditForm" class="clearfix" action="home/importMasterLabTest" method="post" enctype="multipart/form-data">

                    <div class="form-group has-feedback">
                        <label for="exampleInputEmail1"> <?php echo lang('choose_file'); ?> rempli</label>
                        <input type="file" class="form-control" placeholder="" name="filename" required accept=".xls, .xlsx ,.csv">
                        <span class="glyphicon glyphicon-file form-control-feedback"></span>
                        <input type="hidden" name="tablename"value="master_medicine">
                    </div>

                    <section class="">
                        <a href="javascript:$('#myModalMaster').modal('hide');" class="btn btn-info btn-secondary pull-left" >Retour</a>
                        <button type="submit" name="submit" class="btn btn-info submit_button pull-right"> <?php echo lang('submit') ?></button>
                    </section>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>


<?php
$current_user = $this->ion_auth->get_user_id();
$pharmacist_id = $this->db->get_where('pharmacist', array('ion_user_id' => $current_user))->row()->id;
?>


<!-- Load Medicine -->
<div class="modal fade" id="myModal3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"> <?php echo lang('import'); ?> <?php echo lang('medicine'); ?></h4>
            </div>
            <div class="modal-body">
                <form role="form" id="editMedicineForm" class="clearfix" action="medicine/importMedicine" method="post" enctype="multipart/form-data">

                    <div class="form-group">
                        <label for="exampleInputEmail1"> <?php echo lang('add_quantity'); ?></label>
                        <input type="number" min="1" step="0.01" class="form-control" name="quantity" id="exampleInputEmail1" value='' placeholder="" required="">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1"> <?php echo lang('s_price'); ?></label>
                        <input type="number" min="1" step="0.01" class="form-control" name="s_price" id="exampleInputEmail1" value='' placeholder="" required="">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1"> <?php echo lang('expiry_date'); ?></label>
                        <input type="text" class="form-control default-date-picker" name="e_date" id="exampleInputEmail1" value='' placeholder="" readonly="">
                    </div>
                    <input type="hidden" name="imported_id" value=''>
                    <input type="hidden" name="pharmacist_id" value="<?php echo $pharmacist_id ?>">
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
            $('#editMedicineForm').trigger("reset");
            $('#myModal2').modal('show');
            $.ajax({
                url: 'medicine/editMasterMedicineByJason?id=' + iid,
                method: 'GET',
                data: '',
                dataType: 'json',
            }).success(function (response) {
                // Populate the form fields with the data returned from server
                $('#editMedicineForm').find('[name="id"]').val(response.medicine.id).end()
                $('#editMedicineForm').find('[name="name"]').val(response.medicine.name).end()
                $('#editMedicineForm').find('[name="category"]').val(response.medicine.category).end()
                $('#editMedicineForm').find('[name="type"]').val(response.medicine.type).end()
                $('#editMedicineForm').find('[name="description"]').val(response.medicine.description).end()
//                $('#editMedicineForm').find('[name="quantity"]').val(response.medicine.quantity).end()
                $('#editMedicineForm').find('[name="generic"]').val(response.medicine.generic).end()
                $('#editMedicineForm').find('[name="company"]').val(response.medicine.company).end()
                $('#editMedicineForm').find('[name="status"]').val(response.medicine.status).end()
                $('#editMedicineForm').find('[name="dosage"]').val(response.medicine.dosage).end()
            });
        });
    });
</script>
<script type="text/javascript">
    $(document).ready(function () {
        $(".table").on("click", ".load", function () {

            // e.preventDefault(e);
            // Get the record's ID via attribute  
            var iid = $(this).attr('data-id');
            $('#editMedicineForm').trigger("reset");
            $('#myModal3').modal('show');

            //  var id = $(this).data('id');

            // Populate the form fields with the data returned from server
            $('#editMedicineForm').find('[name="imported_id"]').val(iid).end()
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
                url: "medicine/getMasterMedicineList",
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
                    // {
                    // extend: 'pageLength',
                    // },
                    // {
                    // extend: 'excelHtml5',
                    // className: 'dt-button-icon-left dt-button-icon-excel',
                    // exportOptions: {
                    // columns: [1,2,3,4,5,6,7,8,9,10],
                    // }
                    // },
                    // {
                    // extend: 'pdfHtml5',
                    // className: 'dt-button-icon-left dt-button-icon-pdf',
                    // exportOptions: {
                    // columns: [1,2,3,4,5,6,7,8,9,10],
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
        $(".flashmessage").delay(3000).fadeOut(100);
    });
</script>

<script>
    $(document).ready(function () {

//        var elem = document.querySelector('.js-switch-blue');
//        var switchery = new Switchery(elem, {color: '#2CA6CB', jackColor: '#FFFFFF'});
//        //blue color
        $(document).on('change', '.references_class', function () {
            var id = $(this).data('id');
            if ($(this).is(":checked")) {
                var value = 'Active';
            } else {
                var value = 'Deactive';
            }
            $.ajax({
                url: 'medicine/updateMasterMedicineStatus?id=' + id + '&value=' + value,
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
<script>
    $(document).ready(function () {
        // $(".flashmessage").delay(3000).fadeOut(100);

        $(".downloadbutton").click(function (e) {
            e.preventDefault(e);
            // Get the record's ID via attribute  
            $('#myModalMaster').modal('show');
        });
    });
</script>