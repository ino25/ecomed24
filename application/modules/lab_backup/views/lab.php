<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="panel col-md-8 no-print">
            <header class="panel-heading no-print">
                <?php
                if (!empty($lab_single->id))
                    echo lang('edit_lab_report');
                else
                    echo lang('add_lab_report');
                ?>
            </header>
            <div class="no-print">
                <div class="adv-table editable-table ">
                    <div class="clearfix">
                        <style> 
                            .lab{
                                padding-top: 10px;
                                padding-bottom: 20px;
                                border: none;

                            }
                            .pad_bot{
                                padding-bottom: 5px;
                            }  

                            form{
                                background: #ffffff;
                                padding: 20px 0px;
                            }

                            .modal-body form{
                                background: #fff;
                                padding: 21px;
                            }

                            .remove{
                                float: right;
                                margin-top: -45px;
                                margin-right: 42%;
                                margin-bottom: 41px;
                                width: 94px;
                                height: 29px;
                            }

                            .remove1 span{
                                width: 33%;
                                height: 50px !important;
                                padding: 10px

                            }

                            .qfloww {
                                padding: 10px 0px;
                                height: 370px;
                                background: #f1f2f9;
                                overflow: auto;
                            }

                            .remove1 {
                                background: #5A9599;
                                color: #fff;
                                padding: 5px;
                            }


                            .span2{
                                padding: 6px 12px;
                                font-size: 14px;
                                font-weight: 400;
                                line-height: 1;
                                color: #555;
                                text-align: center;
                                background-color: #eee;
                                border: 1px solid #ccc
                            }

                        </style>

                        <form role="form" id="editLabForm" class="clearfix" action="lab/addLabNew" method="post" enctype="multipart/form-data">

                            <div class="">
                                <div class="col-md-6 lab pad_bot">
                                    <label for="exampleInputEmail1"><?php echo lang('date'); ?></label>
                                    <input type="text" class="form-control pay_in" name="date" value='<?php
                                    if (!empty($lab_single->date)) {
                                        echo date('d/m/Y', $lab_single->date);
                                    } else {
                                        echo date('d/m/Y');
                                    }
                                    ?>' placeholder="" readonly>
                                </div>

                                <div class="col-md-6 lab pad_bot">
                                    <label for="exampleInputEmail1"><?php echo lang('patient'); ?></label>
                                    <select class="form-control m-bot15 pos_select" id="pos_select" name="patient" value='' required readonly> 
                                        <?php if (!empty($lab_single->patient)) { ?>
                                            <option value="<?php echo $patients->id; ?>" selected="selected"><?php echo $patients->name . ' ' . $patients->last_name; ?> - (ID Patient: <?php echo $patients->patient_id; ?>)</option>  
                                        <?php } ?>
                                    </select>
                                </div> 

                                <div class="col-md-8 panel"> 
                                </div>

                                <!--<div class="pos_client">
                                    <div class="col-md-8 lab pad_bot">
                                        <div class="col-md-3 lab_label"> 
                                            <label for="exampleInputEmail1"> <?php echo lang('patient'); ?> <?php echo lang('name'); ?></label>
                                        </div>
                                        <div class="col-md-9"> 
                                            <input type="text" class="form-control pay_in" name="p_name" value='<?php
                                if (!empty($lab_single->p_name)) {
                                    echo $lab_single->p_name;
                                }
                                ?>' placeholder="">
                                        </div>
                                    </div>
                                    <div class="col-md-8 lab pad_bot">
                                        <div class="col-md-3 lab_label"> 
                                            <label for="exampleInputEmail1"> <?php echo lang('patient'); ?> <?php echo lang('email'); ?></label>
                                        </div>
                                        <div class="col-md-9"> 
                                            <input type="text" class="form-control pay_in" name="p_email" value='<?php
                                if (!empty($lab_single->p_email)) {
                                    echo $lab_single->p_email;
                                }
                                ?>' placeholder="">
                                        </div>
                                    </div>
                                    <div class="col-md-8 lab pad_bot">
                                        <div class="col-md-3 lab_label"> 
                                            <label for="exampleInputEmail1"> <?php echo lang('patient'); ?> <?php echo lang('phone'); ?></label>
                                        </div>
                                        <div class="col-md-9"> 
                                            <input type="text" class="form-control pay_in" name="p_phone" value='<?php
                                if (!empty($lab_single->p_phone)) {
                                    echo $lab_single->p_phone;
                                }
                                ?>' placeholder="">
                                        </div>
                                    </div>
                                    <div class="col-md-8 lab pad_bot">
                                        <div class="col-md-3 lab_label"> 
                                            <label for="exampleInputEmail1"> <?php echo lang('patient'); ?> <?php echo lang('age'); ?></label>
                                        </div>
                                        <div class="col-md-9"> 
                                            <input type="text" class="form-control pay_in" name="p_age" value='<?php
                                if (!empty($lab_single->p_age)) {
                                    echo $lab_single->p_age;
                                }
                                ?>' placeholder="">
                                        </div>
                                    </div> 
                                    <div class="col-md-8 lab pad_bot">
                                        <div class="col-md-3 lab_label"> 
                                            <label for="exampleInputEmail1"> <?php echo lang('patient'); ?> <?php echo lang('gender'); ?></label>
                                        </div>
                                        <div class="col-md-9"> 
                                            <select class="form-control m-bot15" name="p_gender" value=''>

                                                <option value="Male" <?php
                                if (!empty($patient->sex)) {
                                    if ($patient->sex == 'Male') {
                                        echo 'selected';
                                    }
                                }
                                ?> > Male </option>   
                                                <option value="Female" <?php
                                if (!empty($patient->sex)) {
                                    if ($patient->sex == 'Female') {
                                        echo 'selected';
                                    }
                                }
                                ?> > Female </option>
                                                <option value="Others" <?php
                                if (!empty($patient->sex)) {
                                    if ($patient->sex == 'Others') {
                                        echo 'selected';
                                    }
                                }
                                ?> > Others </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>-->
                                <!--<div class="col-md-6 lab pad_bot">
                                    <label for="exampleInputEmail1"> <?php echo lang('effectuer_par'); ?></label> 
                                    <select class="form-control m-bot15  add_doctor" id="add_doctor" name="doctor" value='' readonly>  
                                <?php if (!empty($lab_single->doctor)) { ?>
                                                <option value="<?php echo $doctors->id; ?>" selected="selected"><?php echo $doctors->name; ?> - <?php echo $doctors->id; ?></option>  
                                <?php } ?>
                                    </select>
                                </div>-->
                                <!--<div class="col-md-6 lab pad_bot">
                                    <label for="exampleInputEmail1">
                                <?php echo lang('template'); ?>
                                    </label>
                                    <select class="form-control m-bot15 js-example-basic-multiple template" id="template" name="template" value=''> 
                                        <option value="">Select .....</option>
                                <?php foreach ($templates as $template) { ?>
                                                <option value="<?php echo $template->id; ?>"><?php echo $template->name; ?> </option>
                                <?php } ?>
                                    </select>
                                </div>-->
                                <!--<div class="pos_doctor">
                                    <div class="col-md-8 lab pad_bot">
                                        <div class="col-md-3 lab_label"> 
                                            <label for="exampleInputEmail1"> <?php echo lang('doctor'); ?> <?php echo lang('name'); ?></label>
                                        </div>
                                        <div class="col-md-9"> 
                                            <input type="text" class="form-control pay_in" name="d_name" value='<?php
                                if (!empty($lab_single->p_name)) {
                                    echo $lab_single->p_name;
                                }
                                ?>' placeholder="">
                                        </div>
                                    </div>
                                    <div class="col-md-8 lab pad_bot">
                                        <div class="col-md-3 lab_label"> 
                                            <label for="exampleInputEmail1"> <?php echo lang('doctor'); ?> <?php echo lang('email'); ?></label>
                                        </div>
                                        <div class="col-md-9"> 
                                            <input type="text" class="form-control pay_in" name="d_email" value='<?php
                                if (!empty($lab_single->p_email)) {
                                    echo $lab_single->p_email;
                                }
                                ?>' placeholder="">
                                        </div>
                                    </div>
                                    <div class="col-md-8 lab pad_bot">
                                        <div class="col-md-3 lab_label"> 
                                            <label for="exampleInputEmail1"> <?php echo lang('doctor'); ?> <?php echo lang('phone'); ?></label>
                                        </div>
                                        <div class="col-md-9"> 
                                            <input type="text" class="form-control pay_in" name="d_phone" value='<?php
                                if (!empty($lab_single->p_phone)) {
                                    echo $lab_single->p_phone;
                                }
                                ?>' placeholder="">
                                        </div>
                                    </div>
                                </div>-->

                                <!--<div class="col-md-8 panel">
                                </div>-->
                            </div>
                            <!--<div class="col-md-12 lab pad_bot">
                                <label for="exampleInputEmail1">R&eacute;sultats des analyses</label>
                                <textarea class="ckeditor form-control" id="editor" name="report" value="" rows="10"><?php
                            if (!empty($setval)) {
                                echo set_value('report');
                            }
                            if (!empty($lab_single->report)) {
                                echo $lab_single->report;
                            }
                            ?>
                                </textarea>
                            </div>-->
                            <div class="col-md-12 lab pad_bot" id="report_group">
                                <label for="exampleInputEmail1">R&eacute;sultats des analyses</label>
                                <table class="table table-hover progress-table text-center" cellpadding="1" cellspacing="1" style="width:100%" id='report_table'>
                                        <!--<caption>R&Eacute;SULTATS DES ANALYSES</caption>-->
                                    <thead style="margin-top:5px;">
                                        <tr>
                                            <th style="text-transform:none !important;" scope="col">Analyse(s) Demand&eacute;es</th>
                                            <th style="text-transform:none !important;" scope="col">R&eacute;sultats</th>
                                            <th style="text-transform:none !important;" scope="col">Unit&eacute;</th>
                                            <th style="text-transform:none !important;" scope="col">Valeurs Usuelles</th>
                                        </tr>
                                    </thead>
                                    <tbody id='report_body'>
                                        <?php
                                        foreach ($lab_data as $single_lab_data) {
                                            // print_r($single_lab_data); // N'est pas mise à jour apres validation	
                                            ?>
                                            <tr>
                                                <?php
                                                $id_prestationBuff0 = explode("@@@@", $single_lab_data->idPaymentConcatRelevantCategoryPart);
                                                $id_prestationBuff1 = explode("*", $id_prestationBuff0[1]);
                                                $id_prestation = $id_prestationBuff1[0];
                                                $default_values_entries = $this->lab_model->getPrestationLabDefaultValues($id_prestation);
                                                $default_unite = !empty($default_values_entries->default_unite) ? $default_values_entries->default_unite : "";
                                                $default_valeurs = !empty($default_values_entries->default_valeurs) ? $default_values_entries->default_valeurs : "";

                                                // Récupérer statut Reel
                                                $id_payment = $id_prestationBuff0[0];
                                                $this->db->where("id", $id_payment);
                                                $query = $this->db->get("payment");
                                                $payment = $query->row();
                                                $category_name = $payment->category_name;
                                                // echo "<br/>".$id_prestationBuff0[1]."<br/>".$category_name;
                                                $exploded_category_name1 = explode(",", $category_name);
                                                $is_valid = false;
                                                foreach ($exploded_category_name1 as $exploded1) {
                                                    $exploded2 = explode("*", $exploded1);
                                                    $is_valid = $exploded2[0] == $id_prestationBuff1[0] && $exploded2[1] == $id_prestationBuff1[1] && $exploded2[2] == $id_prestationBuff1[2] && $exploded2[3] == $id_prestationBuff1[3] && $exploded2[4] == 3;
                                                    if ($is_valid) {
                                                        break;
                                                    }
                                                }
                                                $is_valid_array[] = $is_valid;
                                                // echo "<br/>".$is_valid;
                                                ?>
                                                <td style='font-weight:500;'><?php echo $single_lab_data->prestation; ?><br/><span style='font-weight:400;'>(ID Acte: <?php echo $single_lab_data->code; ?>)</span><input type='hidden' id='prestations_<?php echo $single_lab_data->idPaymentConcatRelevantCategoryPart; ?>' name='prestations_<?php echo $single_lab_data->idPaymentConcatRelevantCategoryPart; ?>' value="<?php echo $single_lab_data->prestation; ?>" /><input type='hidden' id='codes_<?php echo $single_lab_data->idPaymentConcatRelevantCategoryPart; ?>' name='codes_<?php echo $single_lab_data->idPaymentConcatRelevantCategoryPart; ?>' value="<?php echo $single_lab_data->code; ?>" /><input type='hidden' id='idPaymentConcatRelevantCategoryPart_<?php echo $single_lab_data->idPaymentConcatRelevantCategoryPart; ?>' name='idPaymentConcatRelevantCategoryPart_<?php echo $single_lab_data->idPaymentConcatRelevantCategoryPart; ?>' value="<?php echo $single_lab_data->idPaymentConcatRelevantCategoryPart; ?>" /><input type='hidden' id='labDataId_<?php echo $single_lab_data->idPaymentConcatRelevantCategoryPart; ?>' name='labDataId_<?php echo $single_lab_data->idPaymentConcatRelevantCategoryPart; ?>' value="<?php echo $single_lab_data->id; ?>" /></td>
                                                <td><input class='form-control shadow' size='15' max-length='15' type='text' id='resultats_<?php echo $single_lab_data->idPaymentConcatRelevantCategoryPart; ?>' name='resultats_<?php echo $single_lab_data->idPaymentConcatRelevantCategoryPart; ?>' value='<?php echo $single_lab_data->resultats; ?>' <?php if ($is_valid) { ?> readonly <?php } ?> placeholder='' /></td>

                                                <td><input class='form-control shadow' size='5' max-length='5' type='text' id='unite_<?php echo $single_lab_data->idPaymentConcatRelevantCategoryPart; ?>' name='unite_<?php echo $single_lab_data->idPaymentConcatRelevantCategoryPart; ?>' value='<?php echo!empty($single_lab_data->unite) ? $single_lab_data->unite : $default_unite; ?>' <?php if (!empty($single_lab_data->unite) || $is_valid) { ?> readonly <?php } ?> placeholder='' /></td>

                                                <td><input class='form-control shadow' size='5' max-length='5' type='text'  id='valeurs_<?php echo $single_lab_data->idPaymentConcatRelevantCategoryPart; ?>' name='valeurs_<?php echo $single_lab_data->idPaymentConcatRelevantCategoryPart; ?>' value='<?php echo!empty($single_lab_data->valeurs) ? $single_lab_data->valeurs : $default_valeurs; ?>' <?php if (!empty($single_lab_data->valeurs) || $is_valid) { ?> readonly <?php } ?> placeholder='' /></td>

                                            </tr>
                                            <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>

                                <p>&nbsp;</p>
<!--<textarea class="ckeditor form-control" style="display:none;" id="editor" name="report" value="" rows="10"><?php
                                        if (!empty($setval)) {
                                            echo set_value('report');
                                        }
                                        if (!empty($lab->report)) {
                                            echo $lab->report;
                                        }
                                        ?>
</textarea>-->
                            </div>

                            <input type="hidden" name="redirect" value="<?php
                                // if (!empty($lab_single)) {
                                // echo 'lab?id=' . $lab_single->id;
                                // } else {
                                echo 'lab';
                                // }
                                        ?>">

                            <input type="hidden" name="id" value='<?php
                            if (!empty($lab_single->id)) {
                                echo $lab_single->id;
                            }
                                        ?>'>

                            <?php
                            $is_valid_total = false;
                            // print_r($is_valid_array);
                            foreach ($is_valid_array as $is_valid_single) {
                                $is_valid_total = $is_valid_single;
                            }
                            ?>
                            <div class="col-md-12 lab"> 
                                <a href="lab" class="btn btn-info btn-secondary pull-left" >Retour</a>
                                <button type="submit" name="submit" <?php if ($is_valid_total) { ?> disabled <?php } ?> class="btn btn-info pull-right"><?php echo lang('edit'); ?></button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </section>

        <section class="col-md-7" style="display:none">
            <header class="panel-heading">
                <?php echo lang('lab_report'); ?>
                <div class="col-md-4 no-print pull-right"> 
                    <a href="lab/addLabView">
                        <div class="btn-group pull-right">
                            <button id="" class="btn green btn-xs">
                                <i class="fa fa-plus-circle"></i> <?php echo lang('add_lab_report'); ?>
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
                                <th><?php echo lang('report_id'); ?></th>
                                <th><?php echo lang('patient'); ?></th>
                                <th><?php echo lang('date'); ?></th>
                                <th class=""><?php echo lang('options'); ?></th>
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
                            .option_th{
                                width:18%;
                            }

                        </style>

                        </tbody>
                    </table>
                </div>
            </div>
        </section>
        <!-- page end-->
    </section>

    <style>

        th{
            text-align: center;
        }

        td{
            text-align: center;
        }

        tr.total{
            color: green;
        }



        .control-label{
            width: 100px;
        }



        h1{
            margin-top: 5px;
        }


        .print_width{
            width: 50%;
            float: left;
        } 

        ul.amounts li {
            padding: 0px !important;
        }

        .invoice-list {
            margin-bottom: 10px;
        }




        .panel{
            border: 0px solid #5c5c47;
            background: #fff !important;
            height: 100%;
            margin: 20px 5px 5px 5px;
            border-radius: 0px !important;

        }



        .table.main{
            margin-top: -50px;
        }



        .control-label{
            margin-bottom: 0px;
        }

        tr.total td{
            color: green !important;
        }

        .theadd th{
            background: #edfafa !important;
        }

        td{
            font-size: 12px;
            padding: 5px;
            font-weight: bold;
        }

        .details{
            font-weight: bold;
        }

        hr{
            border-bottom: 2px solid green !important;
        }

        .corporate-id {
            margin-bottom: 5px;
        }

        .adv-table table tr td {
            padding: 5px 10px;
        }



        .btn{
            margin: 10px 10px 10px 0px;
        }












        @media print {

            h1{
                margin-top: 5px;
            }

            #main-content{
                padding-top: 0px;
            }

            .print_width{
                width: 50%;
                float: left;
            } 

            ul.amounts li {
                padding: 0px !important;
            }

            .invoice-list {
                margin-bottom: 10px;
            }

            .wrapper{
                margin-top: 0px;
            }

            .wrapper{
                padding: 0px 0px !important;
                background: #fff !important;

            }



            .wrapper{
                border: 2px solid #777;
                min-height: 910px;
            }

            .panel{
                border: 0px solid #5c5c47;
                background: #fff !important;
                padding: 0px 0px;
                height: 100%;
                margin: 5px 5px 5px 5px;
                border-radius: 0px !important;

            }



            .table.main{
                margin-top: -50px;
            }



            .control-label{
                margin-bottom: 0px;
            }

            tr.total td{
                color: green !important;
            }

            .theadd th{
                background: #edfafa !important;
            }

            td{
                font-size: 12px;
                padding: 5px;
                font-weight: bold;
            }
            .details{
                font-weight: bold;
            }

            hr{
                border-bottom: 2px solid green !important;
            }

            .corporate-id {
                margin-bottom: 5px;
            }

            .adv-table table tr td {
                padding: 5px 10px;
            }
        }
    </style>

</section>
<!--main content end-->
<!--footer start-->

<style>
    .shadow {
        box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .16), 0 2px 10px 0 rgba(0, 0, 0, .12);
    }
</style>

<script src="<?php echo base_url(); ?>common/js/codearistos.min.js"></script>
<script>
    $(document).ready(function () {
        $(".flashmessage").delay(3000).fadeOut(100);
    });
</script>


<script>
    $(document).ready(function () {
        var table = $('#editable-sample').DataTable({
            responsive: true,

            "processing": true,
            "serverSide": true,
            "searchable": true,
            "ajax": {
                url: "lab/getLab",
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
                            // columns: [0, 1, 2],
                        // }
                    // },
                    // {
                        // extend: 'pdfHtml5',
                        // className: 'dt-button-icon-left dt-button-icon-pdf',
                        // exportOptions: {
                            // columns: [0, 1, 2],
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
<?php if (!empty($lab_single->id)) { ?>
        $("#pos_select").css("pointer-events", "none");
        $("#add_doctor").css("pointer-events", "none");
<?php } ?>

    $(document).ready(function () {
        // $('#zero_group').hide();
        // $('#report_group').hide();
        // $('#report_table').hide();
        // $('#editor').hide();

        $('.pos_client').hide();
        // $(document.body).on('change', '#pos_select', function () {

        // var v = $("select.pos_select option:selected").val()
        // if (v == 'add_new') {
        // $('.pos_client').show();
        // } else {
        // $('.pos_client').hide();
        // }
        // });

    });


</script>

<script>
    $(document).ready(function () {
        $('.pos_doctor').hide();
        // $(document.body).on('change', '#add_doctor', function () {

        // var v = $("select.add_doctor option:selected").val()
        // if (v == 'add_new') {
        // $('.pos_doctor').show();
        // } else {
        // $('.pos_doctor').hide();
        // }
        // });

    });


</script>



<script type="text/javascript">
    $(document).ready(function () {
        $(document.body).on('change', '#template', function () {
            var iid = $("select.template option:selected").val();
            $.ajax({
                url: 'lab/getTemplateByIdByJason?id=' + iid,
                method: 'GET',
                data: '',
                dataType: 'json',
            }).success(function (response) {
                var data = CKEDITOR.instances.editor.getData();
                if (response.template.template != null) {
                    var data1 = data + response.template.template;
                } else {
                    var data1 = data;
                }
                CKEDITOR.instances['editor'].setData(data1)
            });
        });
    });
</script>
<script>
    $(document).ready(function () {
        // $("#pos_select").select2({
        // placeholder: '<?php echo lang('select_patient'); ?>',
        // allowClear: true,
        // ajax: {
        // url: 'patient/getPatientinfoWithAddNewOptionLab',
        // type: "post",
        // dataType: 'json',
        // delay: 250,
        // data: function (params) {
        // return {
        // searchTerm: params.term // search term
        // };
        // },
        // processResults: function (response) {
        // return {
        // results: response
        // };
        // },
        // cache: true
        // }

        // });

        // $("#add_doctor").select2({
        // placeholder: '<?php echo lang('select_doctor'); ?>',
        // allowClear: true,
        // ajax: {
        // url: 'doctor/getDoctorWithAddNewOptionLab',
        // type: "post",
        // dataType: 'json',
        // delay: 250,
        // data: function (params) {
        // return {
        // searchTerm: params.term // search term
        // };
        // },
        // processResults: function (response) {
        // return {
        // results: response
        // };
        // },
        // cache: true
        // }

        // });

    });
</script>