<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="panel">
            <header class="panel-heading">
                <h2>Liste des Actes : (<?php echo $organisation->nom; ?>)</h2>
            </header>

            <div class="panel-body panel-bodyAlt">
                <div class="adv-table editable-table">
                    <div class="space15"></div>
                    <table class="table table-hover progress-table" id="editable-sample">
                        <thead>
                            <tr>
                                <td>
                                    <select class="form-control" name="modeType" id="modeType">
                                        <option value=""> Tout </option>
                                        <option value="new"> <?php echo lang('new_'); ?> </option>
                                        <option value='pending'> <?php echo lang('pending_'); ?> </option>
                                        <option value='done'> <?php echo lang('done_'); ?> </option>
                                        <option value='valid'> <?php echo lang('valid_'); ?> </option>
                                        <option value='finish'> <?php echo lang('finish_'); ?> </option>
                                        <option value="cancelled"> ANNULÉ </option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th>Date</th>
                                <th><?php echo lang('patient_id'); ?></th>
                                <th><?php echo lang('patient'); ?></th>
                                <th><?php echo lang('phone'); ?></th>
                                <th>Adresse</th>
                                <th>Statut</th>
                                <th syle="display:none"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (isset($payments)) {
                                foreach ($payments as $payment) {
                            ?>
                                    <tr class="">
                                        <td><?php echo $payment->dateFormat; ?> </td>
                                        <td><?php echo $payment->code; ?> </td>
                                        <td><?php echo $payment->patient_name; ?></td>
                                        <td><?php echo $payment->patient_phone; ?> </td>
                                        <td><?php echo $payment->patient_address; ?></td>
                                        <td><?php if ($payment->status == 'new') {
                                                echo '<span class="status-p bg-info-paid">' . lang('new_') . '</span>';
                                            } else if ($payment->status == 'pending') {
                                                echo '<span class="status-p bg-primary">' . lang('pending_') . '</span>';
                                            } else if ($payment->status == 'done') {
                                                echo '<span class="status-p bg-primary">' . lang('done_') . '</span>';
                                            } else if ($payment->status == 'valid') {
                                                echo '<span class="status-p bg-primary">' . lang('valid_') . '</span>';
                                            } else if ($payment->status == 'finish') {
                                                echo '<span class="status-p bg-success">' . lang('finish_') . '</span>';
                                            } else if ($payment->status == 'cancelled') {
                                                echo '<span class="status-p bg-danger">' . lang('cancelled') . '</span>';
                                            } else if ($payment->status == 'accept') {
                                                echo '<span class="status-p bg-success">' . lang('accept_') . '</span>';
                                            }; ?>
                                            <td style="display:none"><?php echo $payment->status; ?></td>
                                    </tr>
                            <?php }
                            } ?>
                        </tbody>
                    </table>
                    <a id="" class="btn btn-info btn-secondary pull-left" href="home/superhome">
                        Retour
                    </a>
                </div>
            </div>
            </div>
        </section>
        <!-- page end-->
    </section>
</section>
<div class="modal fade" id="infoModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title" id="myModalLabel"><?php echo lang('patient_fiche'); ?></h4>
            </div>
            <div class="modal-body">
                <center>
                    <div class="col-md-12 patientImgClass">
                    </div>

                    <h3 class="media-heading"><span class="nameClass"></span> <span class="lastnameClass"></span><small> <span class="regionClass"></span> </small></h3>
                    <p><strong> <?php echo lang('number'); ?>: </strong> <span class="patientIdClass"></span> </p>
                    <span class="label label-primary"><i class='fa fa-user'></i> <span class="genderClass"></span></span>

                    <span class="label label-info"> <i class='fa fa-phone'></i> <span class="phoneClass"></span></span>

                    <span class="label label-success"> <i class='fa fa-envelope'></i> <span class="emailClass"> </span> </span>





                </center>
                <hr>
                <div class='row'>
                    <div class="form-group col-md-4">
                        <label><?php echo lang('age'); ?></label>
                        <div class="ageClass"></div>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="exampleInputEmail1"><?php echo lang('address'); ?></label>
                        <div class="addressClass"></div>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="exampleInputEmail1"><?php echo lang('region'); ?></label>
                        <div class="regionClass"></div>
                    </div>
                </div>
                <div class='row'>
                    <div class="form-group col-md-4">
                        <label><?php echo lang('birth_date'); ?></label>
                        <div class="birthdateClass"></div>
                    </div>

                    <div class="form-group col-md-4">
                        <label><?php echo lang('birth_position'); ?></label>
                        <div class="birth_positionClass"></div>
                    </div>
                    <div class="form-group col-md-4">
                        <label><?php echo lang('matricule'); ?></label>
                        <div class="matriculeClass"></div>
                    </div>
                </div>
                <div class='row'>
                    <div class="form-group col-md-4">
                        <label><?php echo lang('grade'); ?></label>
                        <div class="gradeClass"></div>
                    </div>
                    <div class="form-group col-md-4">
                        <label><?php echo lang('nom_contact'); ?></label>
                        <div class="nom_contactClass"></div>
                    </div>
                    <div class="form-group col-md-4">
                        <label><?php echo lang('phone_contact'); ?></label>
                        <div class="phone_contactClass"></div>
                    </div>
                </div>
                <div class='row'>
                    <div class="form-group col-md-4">
                        <label><?php echo lang('religion'); ?></label>
                        <div class="religionClass"></div>
                    </div>



                    <div class="form-group col-md-4">
                    </div>
                    <div class="form-group col-md-4">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <center>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><?php echo lang('close'); ?></button>
                </center>
            </div>
        </div><!-- /.modal-content -->

    </div><!-- /.modal-dialog -->
</div>
<!--main content end-->
<!--footer start-->






<script src="<?php echo base_url(); ?>common/js/codearistos.min.js"></script>

<script>
    $(document).ready(function() {
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
                    // columns: [0,1,2,3,4],
                    // }
                    // },
                    // {
                    // extend: 'pdfHtml5',
                    // className: 'dt-button-icon-left dt-button-icon-pdf',
                    // exportOptions: {
                    // columns: [0,1,2,3,4],
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
            // "order": [[0, "desc"]],
            aaSorting: [],
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
        $('#modeType').click( function() {
            var typeMode = $('#modeType').val(); 
            table.search(typeMode).draw() ;
        } );

    });
</script>






<script>
    $(document).ready(function() {
        $(".flashmessage").delay(3000).fadeOut(100);
    });
</script>