<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="panel">
            <header class="panel-heading" style="margin-top:41px;">
                <h2><?php echo lang('time_schedule'); ?> des <?php echo lang('doctors'); ?></h2>

            </header>
            <div class="panel-body">
                <div class="adv-table editable-table ">
                    <div class="space15"></div>
                    <table class="table table-hover progress-table text-center__ " id="editable-sample">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th><?php echo lang('name'); ?></th>
                                <th><?php echo lang('email'); ?></th>
                                <th><?php echo lang('phone'); ?></th>
                                <th><?php echo lang('service'); ?></th>
                                <?php
                                if ($this->ion_auth->in_group(array('admin', 'adminmedecin', 'Receptionist', 'Assistant'))) { ?>

                                    <th class="no-print"><?php echo lang('options'); ?></th>
                                <?php  } ?>

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
<!--footer start-->

<?php
//
//foreach ($doctors as $doctor) {
//	if ($doctor->first_name && $doctor->last_name) { ?>
<!--        <tr class="">-->
<!---->
<!--            <td>--><?php //echo $doctor->iduser; ?><!--</td>-->
<!--            <td>--><?php //echo $doctor->first_name . ' ' . $doctor->last_name; ?><!--</td>-->
<!--            <td>--><?php //echo $doctor->email; ?><!--</td>-->
<!--            <td>--><?php //echo $doctor->phone; ?><!--</td>-->
<!--            <td>--><?php //echo $doctor->name_service; ?><!--</td>-->
<!--			--><?php
//			if ($this->ion_auth->in_group(array('admin', 'adminmedecin', 'Receptionist', 'Assistant'))) { ?>
<!---->
<!--                <td class="no-print">-->
<!--                    <a href="horaire/timeSchedule?doctor=--><?php //echo $doctor->id; ?><!--" class="btn btn-info btn-xs btn_width" data-toggle="modal" data-id="--><?php //echo $doctor->id; ?><!--"><i class="fa fa-book"></i> --><?php //echo lang('time_schedule'); ?><!--</a>-->
<!--                </td>-->
<!--			--><?php // } ?>
<!---->
<!--        </tr>-->
<!--	--><?php //}
//} ?>


<script src="<?php echo base_url(); ?>common/js/codearistos.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $(".table").on("click", ".editbutton", function() {
            // Get the record's ID via attribute  
            var iid = $(this).attr('data-id');
            $("#img").attr("src", "uploads/cardiology-patient-icon-vector-6244713.jpg");
            $('#editDoctorForm').trigger("reset");
            $.ajax({
                url: 'doctor/editDoctorByJason?id=' + iid,
                method: 'GET',
                data: '',
                dataType: 'json',
            }).success(function(response) {
                // Populate the form fields with the data returned from server
                $('#editDoctorForm').find('[name="id"]').val(response.doctor.id).end()
                $('#editDoctorForm').find('[name="name"]').val(response.doctor.name).end()
                $('#editDoctorForm').find('[name="password"]').val(response.doctor.password).end()
                $('#editDoctorForm').find('[name="email"]').val(response.doctor.email).end()
                $('#editDoctorForm').find('[name="address"]').val(response.doctor.address).end()
                $('#editDoctorForm').find('[name="phone"]').val(response.doctor.phone).end()
                $('#editDoctorForm').find('[name="department"]').val(response.doctor.department).end()
                $('#editDoctorForm').find('[name="profile"]').val(response.doctor.profile).end()

                if (typeof response.doctor.img_url !== 'undefined' && response.doctor.img_url != '') {
                    $("#img").attr("src", response.doctor.img_url);
                }

                $('.js-example-basic-single.department').val(response.doctor.department).trigger('change');

                $('#myModal2').modal('show');

            });
        });
    });
</script>





<script>
    $(document).ready(function() {
        var table = $('#editable-sample').DataTable({
            responsive: true,
            "processing": true,
            "serverSide": true,
            "searchable": true,
            "ajax": {
                url: "horaire/getEmployees",
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
                buttons: [
                    // {
                    // extend: 'pageLength',
                    // },
                    // {
                    // extend: 'excelHtml5',
                    // className: 'dt-button-icon-left dt-button-icon-excel',
                    // exportOptions: {
                    // columns: [0,1,2,3,4,5,6],
                    // }
                    // },
                    // {
                    // extend: 'pdfHtml5',
                    // className: 'dt-button-icon-left dt-button-icon-pdf',
                    // exportOptions: {
                    // columns: [0,1,2,3,4,5,6],
                    // }
                    // },
                ],
                dom: {
                    button: {
                        className: 'h4 btn btn-secondary dt-button-custom'
                    },
                    buttonLiner: {
                        tag: null
                    }
                }
            },
            lengthMenu: [
                [10, 25, 50, 100, -1],
                ['10', '25', '50', '100', 'Tout afficher']
            ],
            iDisplayLength: 10,
            "order": [
                [0, "desc"]
            ],
            "language": {
                "processing": "<div style='margin:-10px'><span style='margin:-10px' class='fa-stack fa-lg'>\n\
                            <i  style='margin:-10px' class='fa fa-spinner fa-spin fa-stack-2x fa-fw'></i>\n\
                       </span>&emsp;Traitement en cours ...</div>",
                // "select": {
                //     "rows": {
                //         _: '%d rows selected',
                //         0: 'Click row to select',
                //         1: '1 row selected'
                //     }
                // },
                // processing: "Traitement en cours...",
                // processing: "<span class='fa-stack fa-lg'>\n\
                //             <i class='fa fa-spinner fa-spin fa-stack-2x fa-fw'></i>\n\
                //        </span>&emsp;Processing ...",
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
            // language: {
            //     "url": "common/assets/DataTables/languages/<?php echo $this->language; ?>.json?<?php echo time(); ?>",
            //     processing: "Traitement en cours...",
            //     search: "_INPUT_",
            //     lengthMenu: "Afficher _MENU_ &eacute;l&eacute;ments",
            //     info: "Affichage de l'&eacute;lement _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
            //     infoEmpty: "Affichage de l'&eacute;lement 0 &agrave; 0 sur 0 &eacute;l&eacute;ments",
            //     infoFiltered: "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
            //     infoPostFix: "",
            //     loadingRecords: "Chargement en cours...",
            //     zeroRecords: "Aucun &eacute;l&eacute;ment &agrave; afficher",
            //     emptyTable: "", //emptyTable: "Aucune donnée disponible dans le tableau",
            //     paginate: {
            //         first: "Premier",
            //         previous: "Pr&eacute;c&eacute;dent",
            //         next: "Suivant",
            //         last: "Dernier"
            //     },
            //     aria: {
            //         sortAscending: ": activer pour trier la colonne par ordre croissant",
            //         sortDescending: ": activer pour trier la colonne par ordre décroissant"
            //     },
            //     buttons: {
            //         pageLength: {
            //             _: "Afficher %d éléments",
            //             '-1': "Tout afficher"
            //         }
            //     }
            // }
        });
        table.buttons().container().appendTo('.custom_buttons');
    });
</script>




<script>
    $(document).ready(function() {
        $(".flashmessage").delay(3000).fadeOut(100);
    });
</script>