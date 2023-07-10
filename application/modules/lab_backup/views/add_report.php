<section id="main-content">
    <section class="wrapper site-min-height">
        <div class="container-fluid invoice-container col-md-10">
            <!-- Header -->
            <style>
                .rowStyle {
                    background-color: #0D4D99;
                    color: #ffffff;
                }

                .invoice-container {
                    border: 1px solid #eee !important;
                }
            </style>
            <div class="panel panel-primary" id="invoice">
                <header>
                    <div class="row align-items-center">
                        <div class="col-sm-12 text-center text-sm-left mb-3 mb-sm-0">
                            <img id="logo" src="<?php echo !empty($entete) ? $entete : "uploads/entetePartenaires/default.png"; ?>" style="max-width:100%;height:18%" title="Koice" alt="Koice" />
                            <input hidden type="text" id="logo2" value="<?php echo !empty($entete) ? $entete : "uploads/entetePartenaires/default.png"; ?>">
                        </div>
                    </div>
                </header>
                <main>
                    <form role="form" action="lab/addNewReport" class="clearfix" method="post" enctype="multipart/form-data">
                        <div class="form-group col-md-4">
                            <label> <?php echo lang('first_name'); ?></label>
                            <input type="text" class="form-control" name="name" id="exampleInputEmail1" value='<?php echo $patient_details->name; ?>' placeholder="">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="exampleInputEmail1"> <?php echo lang('last_name'); ?></label>
                            <input type="text" class="form-control" name="last_name" id="exampleInputEmail1" value='<?php echo $patient_details->last_name; ?>' placeholder="">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="exampleInputEmail1"> <?php echo lang('patient_ids'); ?></label>
                            <input type="text" class="form-control" name="patient_id" id="exampleInputEmail1" value='<?php echo $patient_details->id; ?>' placeholder="" readonly="">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="exampleInputEmail1"> <?php echo lang('date_of_birth'); ?></label>
                            <input type="text" class="form-control" name="birthdate" id="exampleInputEmail1" value='<?php echo $patient_details->birthdate; ?>' placeholder="">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="exampleInputEmail1"> <?php echo lang('age'); ?></label>
                            <input type="text" class="form-control" name="age" id="exampleInputEmail1" value='<?php echo $patient_details->age; ?>' placeholder="">
                            <input type="hidden" class="form-control" name="phone" id="exampleInputEmail1" value='<?php echo $patient_details->phone; ?>' placeholder="">
                            <input type="hidden" class="form-control" name="email" id="exampleInputEmail1" value='<?php echo $patient_details->email; ?>' placeholder="">
                        </div>

                        <div class="form-group col-md-2">
                            <label for="exampleInputEmail1"> <?php echo lang('gender'); ?></label>
                            <input type="text" class="form-control" name="gender" id="exampleInputEmail1" value='<?php echo $patient_details->sex; ?>' placeholder="">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="exampleInputEmail1"> <?php echo lang('address'); ?></label>
                            <input type="text" class="form-control" name="address" id="exampleInputEmail1" value='<?php echo $patient_details->address; ?>' placeholder="">
                        </div>
                        <?php if (strtolower($lab_details->name) == 'pcr') { ?>
                            <div class="form-group col-md-4">
                                <label for="exampleInputEmail1"> <?php echo lang('passport_number'); ?></label>
                                <input type="text" class="form-control" name="passport" id="exampleInputEmail1" value='<?php echo $patient_details->passport; ?>' placeholder="">
                            </div>

                            <div class="form-group col-md-4">
                                <label for="exampleInputEmail1"> <?php echo lang('purpose_of_test'); ?></label>
                                <input type="text" class="form-control" name="purpose" id="exampleInputEmail1" value='<?php echo $this->db->get_where('purpose', array('id' => $payments->purpose))->row()->name; ?>' placeholder="" readonly="">
                            </div>
                        <?php } ?>
                        <div class="form-group col-md-4">
                            <label for="exampleInputEmail1"> <?php echo lang('report_id'); ?></label>
                            <input type="text" class="form-control" name="report_code" id="exampleInputEmail1" value='<?php
                                                                                                                        if (strtolower($lab_details->name) == 'pcr') {
                                                                                                                            $type_lab = 'COV';
                                                                                                                        } else {
                                                                                                                            $type_lab = 'LAB';
                                                                                                                        }

                                                                                                                        if (empty($report_details)) {
                                                                                                                            $last_row = $this->db->select('id')->order_by('id', "desc")->limit(1)->get('lab_report')->row();
                                                                                                                            if (strlen($last_row->id + 1) == 1) {
                                                                                                                                $number = '0000' . ($last_row->id + 1);
                                                                                                                            } elseif (strlen($last_row->id + 1) == 2) {
                                                                                                                                $number = '000' . ($last_row->id + 1);
                                                                                                                            } elseif (strlen($last_row->id + 1) == 3) {
                                                                                                                                $number = '00' . ($last_row->id + 1);
                                                                                                                            } elseif (strlen($last_row->id + 1) == 4) {
                                                                                                                                $number = '0' . ($last_row->id + 1);
                                                                                                                            } else {
                                                                                                                                $number = ($last_row->id + 1);
                                                                                                                            }
                                                                                                                            $report_id = $type_lab . '-' . date('y') . '-' . $lab_details->code . $number;
                                                                                                                            echo $report_id;
                                                                                                                        } else {
                                                                                                                            if (empty($report_details->report_code)) {

                                                                                                                                if (strlen($report_details->id) == 1) {
                                                                                                                                    $number = '0000' . ($last_row->id + 1);
                                                                                                                                } elseif (strlen($report_details->id) == 2) {
                                                                                                                                    $number = '000' . ($last_row->id + 1);
                                                                                                                                } elseif (strlen($report_details->id) == 3) {
                                                                                                                                    $number = '00' . ($last_row->id + 1);
                                                                                                                                } elseif (strlen($report_details->id) == 4) {
                                                                                                                                    $number = '0' . ($last_row->id + 1);
                                                                                                                                } else {
                                                                                                                                    $number = strlen($report_details->id);
                                                                                                                                }
                                                                                                                                $report_id = $type_lab . '-' . date('y') . '-' . $lab_details->code . $number;
                                                                                                                                echo $report_id;
                                                                                                                            } else {
                                                                                                                                echo $report_details->report_code;
                                                                                                                            }
                                                                                                                        }
                                                                                                                        ?>' placeholder="" readonly="">
                        </div>
                        <div class="col-md-12">
                            <hr>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="exampleInputEmail1"> <?php echo lang('type_of_sampling'); ?></label>
                            <select class="form_control type_pf js-example-basic-single" name="type_of_sampling" required="" value=" ">
                                <option value=" " disabled><?php echo lang('choose_type_sampling'); ?></option>
                                <?php foreach ($type_of_sampling as $type_sampling) { ?> <option value="<?php echo $type_sampling->id; ?>" <?php
                                                                                                                                            if (!empty($report_details)) {
                                                                                                                                                if ($report_details->sampling == $type_sampling->id) {
                                                                                                                                                    echo 'selected';
                                                                                                                                                }
                                                                                                                                            }
                                                                                                                                            ?>><?php echo $type_sampling->name; ?></option><?php } ?>
                                <!-- <option value="add_new"><?php echo lang('others'); ?></option> -->
                            </select>
                            <div class="new_sampling1 hidden">
                                <input type="text" value="" class="form-control new_sampling" name="new_sampling" placeholder="<?php echo lang('type_of_sampling'); ?>">
                            </div>
                        </div>


                        <div class="form-group col-md-6">
                            <label for="exampleInputEmail1"> <?php echo lang('sampling_date_time'); ?></label>
                            <div class="input-group" id="id_0">
                                <input type="text" value="<?php
                                                            if (!empty($report_details)) {
                                                                echo $report_details->sampling_date;
                                                            }
                                                            ?>" class="form-control <?php if (empty($report_details)) { ?> datetimepicker_ip <?php } ?>" name="date_time" required="" autocomplete="off">
                                <span class="input-group-addon">
                                    <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                                </span>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <hr>
                        </div>
                        <div class="col-md-12" style="padding-left: 150px;padding-right: 150px;">
                            <h3 class="text-center" style="border: 1px solid;border-block-width: 2px;"><?php echo $lab_details->speciality; ?></h3>
                        </div>
                        <div class="col-md-12">
                            <h4 class="text-center">PRESTATION : <?php echo $lab_details->name; ?></h4>
                        </div>

                        <div class="col-md-12">
                            <!-- <label for="exampleInputEmail1"> <?php echo lang('test_result'); ?>:</label><br> -->
                            <?php
                            $parameter = $lab_details->parameter;
                            $parameters = explode("**", $parameter);
                            foreach ($parameters as $para) {
                            ?>
                                <div class="col-md-12">
                                    <label for="exampleInputEmail1"><?php echo $para; ?></label>
                                    <?php
                                    $parameter_details = $this->lab_model->getMasterLabTestByIdByName($lab_details->master_id, $para);

                                    if (count($parameter_details) > 1) {
                                        if (!empty($report_details)) {
                                            $report_parameter_id = array();
                                            $report_details_explode = explode('##', $report_details->details);
                                            foreach ($report_details_explode as $report) {
                                                $report_ex = explode('**', $report);
                                                if ($report_ex[0] == 'off_switch') {
                                                    $report_parameter_id[] = $report_ex[6];
                                                } else {
                                                    $report_parameter_id[] = $report_ex[5];
                                                }
                                                if ($para == $report_ex[2]) {
                                                    $all_doc = $report;
                                                }
                                            }
                                        }
                                    ?>
                                        <select class="form-control js-example-basic-single choose_para" id="parameter_<?php echo $para ?>_<?php echo $lab_details->master_id; ?>" name="parameter_<?php echo $para ?>_<?php echo $lab_details->master_id; ?>">
                                            <option value=" " disabled="" selected=""><?php echo lang('choose_any_one_parameter'); ?></option>
                                            <?php foreach ($parameter_details as $para_para) { ?>
                                                <option value="<?php echo $para_para->id; ?>" <?php
                                                                                                if (!empty($report_details)) {
                                                                                                    if (in_array($para_para->id, $report_parameter_id)) {
                                                                                                        echo 'selected';
                                                                                                    }
                                                                                                }
                                                                                                ?>><?php echo $para_para->unit_of_measure; ?></option>
                                            <?php } ?>
                                        </select>
                                        <div class="col-md-12 parameter_unit" id="parameterchoose_<?php echo $para ?>_<?php echo $lab_details->master_id; ?>">
                                            <?php
                                            if (!empty($report_details)) {
                                                $report_select = explode("**", $all_doc);
                                                if ($report_select[0] == 'off_switch') {
                                            ?>
                                                    <div class="col-md-12">
                                                        <div class="col-md-6">
                                                            <label for="exampleInputEmail1"> <?php echo lang('high'); ?></label>
                                                            <input type="number" class="form-control" step="0.01" name="high_<?php echo $report_select[2] ?>_<?php echo $report_select[7]; ?>" required="">
                                                        </div>

                                                    </div>
                                                <?php } else { ?>
                                                    <select class="form-control js-example-basic-single" name="pos_<?php echo $para_1->parameter_name ?>_<?php echo $para_1->id; ?>" required="">
                                                        <option value="positive" <?php
                                                                                    if ($report_select[6] == 'positive') {
                                                                                        echo 'selected';
                                                                                    }
                                                                                    ?>><?php echo lang('positive'); ?></option>
                                                        <option value="negative" <?php
                                                                                    if ($report_select[6] == 'negative') {
                                                                                        echo 'selected';
                                                                                    }
                                                                                    ?>><?php echo lang('negative'); ?></option>
                                                    </select>
                                            <?php
                                                }
                                            }
                                            ?>
                                        </div>
                                        <?php
                                    } else {

                                        foreach ($parameter_details as $para_1) {

                                            if (!empty($report_details)) {
                                                $report_parameter_id = array();
                                                $report_details_explode = explode('##', $report_details->details);

                                                foreach ($report_details_explode as $report) {
                                                    $report_ex = explode('**', $report);
                                                    if ($report_ex[0] == 'off_switch') {
                                                        echo $para_1->id;
                                                        echo $report_ex[6];
                                                        if ($para_1->id == $report_ex[6]) {
                                                            $report_explo = explode("**", $report);
                                                        }
                                                        $report_parameter_id[] = $report_ex[6];
                                                    } else {
                                                        if ($para_1->id == $report_ex[5]) {
                                                            $report_explo = explode("**", $report);
                                                        }
                                                        $report_parameter_id[] = $report_ex[5];
                                                    }
                                                }
                                            }

                                            if ($para_1->reference_type == 'off_switch') {
                                        ?>
                                                <div class="col-md-12">
                                                    <div class="col-md-6">
                                                        <label for="exampleInputEmail1"> <?php echo lang('high'); ?></label>
                                                        <input type="number" class="form-control" value="<?php
                                                                                                            if (!empty($report_details)) {
                                                                                                                echo $report_explo[7];
                                                                                                            }
                                                                                                            ?>" step="0.01" name="high_<?php echo $para_1->parameter_name ?>_<?php echo $para_1->id; ?>" required="">
                                                    </div>

                                                </div>
                                            <?php } else { ?>
                                                <select class="form-control js-example-basic-single pos_select" id="pos_select" name="pos_<?php echo $para_1->parameter_name ?>_<?php echo $para_1->id; ?>" required="">
                                                    <option value="negative" <?php
                                                                                if (!empty($report_details)) {
                                                                                    if ($report_explo[6] == 'negative') {
                                                                                        echo 'selected';
                                                                                    }
                                                                                }
                                                                                ?>><?php echo lang('negative'); ?></option>
                                                    <option value="positive" <?php
                                                                                if (!empty($report_details)) {
                                                                                    if ($report_explo[6] == 'positive') {
                                                                                        echo 'selected';
                                                                                    }
                                                                                }
                                                                                ?>><?php echo lang('positive'); ?></option>

                                                </select>
                                    <?php
                                            }
                                        }
                                    }
                                    ?>
                                </div>
                            <?php }
                            ?>

                        </div>
                        <hr>
                                </br>
                        <div class="form-group col-md-12">
                           
                        <div class="row" style="padding-top:45px">
                        <h4 style="margin-left:25px">Conclusion</h4>
                        <center> <h4 id="conclusionFormat"></h4></center>
                        </div>
                           
                            <!-- <select class="form_control type_conclusion js-example-basic-single" name="conclusion" required="" value=" ">
                                <option value=" " disabled><?php echo lang('choose_any_conclusion'); ?></option>
                                <?php foreach ($conclusions as $conslusion) { ?> <option value="<?php echo $conslusion->id; ?>" <?php
                                                                                                                                if (!empty($report_details)) {
                                                                                                                                    if ($report_details->conclusion == $conslusion->id) {
                                                                                                                                        echo 'selected';
                                                                                                                                    }
                                                                                                                                }
                                                                                                                                ?>><?php echo $conslusion->name; ?></option><?php } ?>
                                <option value="add_new"><?php echo lang('others'); ?></option>
                            </select> -->
                            <input type="hidden" id="conclusion" name="conclusion" />
                            <div class="new_conclusion1 hidden" style="margin-top:5px;">
                                <textarea value="" class="form-control new_conclusion" name="new_conclusion" placeholder="<?php echo lang('conclusion'); ?>"></textarea>
                            </div>
                        </div>

                        <input type="hidden" name="lab_id" value="<?php echo $lab_details->id; ?>">
                        <input type="hidden" name="patient_id" value="<?php echo $patient_details->id; ?>">
                        <input type="hidden" name="payment_id" value="<?php echo $payment; ?>">
                        <input type="hidden" name="report_id" value="<?php
                                                                        if (!empty($report_details)) {
                                                                            echo $report_details->id;
                                                                        }
                                                                        ?>">
                        <div class="form-group">
                            <a href="finance/paymentLabo" class="btn btn-info btn-secondary pull-left"><?php echo lang('retour'); ?></a>
                            <button name="submit" class="btn btn-info pull-right submit_button"> <?php echo lang('submit'); ?></button>
                        </div>
                        <input type="hidden" name="redirect" value="finance/paymentLabo">

                    </form>

                </main>
            </div>



        </div>

        </div>
    </section>



    <style>
        th {
            text-align: center;
        }

        td {
            text-align: center;
        }

        tr.total {
            color: green;
        }



        .control-label,
        .control-label2 {
            width: 100px;
        }

        .control-label2 {
            font-weight: 800;
        }



        h1 {
            margin-top: 5px;
        }


        .print_width {
            width: 50%;
            float: left;
        }

        ul.amounts li {
            padding: 0px !important;
        }

        .invoice-list {
            margin-bottom: 10px;
        }




        .panel {
            border: 0px solid #5c5c47;
            background: #fff !important;
            height: 100%;
            margin: 20px 5px 5px 5px;
            border-radius: 0px !important;
            min-height: 700px;

        }



        .table.main {
            margin-top: -50px;
        }



        .control-label,
        .control-label2 {
            margin-bottom: 0px;
        }

        tr.total td {
            color: green !important;
        }

        .theadd th {
            background: #edfafa !important;
            background: #fff !important;
        }

        td {
            font-size: 12px;
            padding: 5px;
            font-weight: bold;
        }

        .details {
            font-weight: bold;
        }

        hr {
            border-bottom: 0px solid #f1f1f1 !important;
        }

        .corporate-id {
            margin-bottom: 5px;
        }

        .adv-table table tr td {
            padding: 5px 10px;
        }



        .btn {
            margin: 10px 10px 10px 0px;
        }

        .invoice_head_left h3 {
            color: #2f80bf !important;
            font-family: cursive;
        }


        .invoice_head_right {
            margin-top: 10px;
        }

        .invoice_footer {
            margin-bottom: 10px;
        }










        @media print {

            h1 {
                margin-top: 5px;
            }

            #main-content {
                padding-top: 0px;
            }

            .print_width {
                width: 50%;
                float: left;
            }

            ul.amounts li {
                padding: 0px !important;
            }

            .invoice-list {
                margin-bottom: 10px;
            }

            .wrapper {
                margin-top: 0px;
            }

            .wrapper {
                padding: 0px 0px !important;
                background: #fff !important;

            }



            .wrapper {
                border: 2px solid #777;
            }

            .panel {
                border: 0px solid #5c5c47;
                background: #fff !important;
                padding: 0px 0px;
                height: 100%;
                margin: 5px 5px 5px 5px;
                border-radius: 0px !important;

            }

            .site-min-height {
                min-height: 950px;
            }



            .table.main {
                margin-top: -50px;
            }



            .control-label {
                margin-bottom: 0px;
            }

            tr.total td {
                color: green !important;
            }

            .theadd th {
                background: #777 !important;
            }

            td {
                font-size: 12px;
                padding: 5px;
                font-weight: bold;
            }

            .details {
                font-weight: bold;
            }

            hr {
                border-bottom: 0px solid #f1f1f1 !important;
            }

            .corporate-id {
                margin-bottom: 5px;
            }

            .adv-table table tr td {
                padding: 5px 10px;
            }

            .invoice_head {
                width: 100%;
            }

            .invoice_head_left {
                float: left;
                width: 40%;
                color: #2f80bf;
                font-family: cursive;
            }

            .invoice_head_right {
                float: right;
                width: 40%;
                margin-top: 10px;
            }

            .hr_border {
                width: 100%;
            }

            .invoice_footer {
                margin-bottom: 10px;
            }


        }

        .modal-dialog {
            max-width: 350px;
            /* New width for default modal */
        }
    </style>
    <style id="dynamic-style">
        /* Default pour Modal */
        @media screen {
            #printSection {
                display: none;
            }
        }

        @media print {
            body {
                overflow: hidden;
            }

            body * {
                visibility: hidden;
            }

            #printSection,
            #printSection * {
                visibility: visible;
            }

            #printSection {
                position: absolute;
                left: 0;
                top: 0;
            }
        }
    </style>




    <!-- Edit Event Modal-->
    <div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header no-print" style="border-bottom:0;">
                    <div class="panel-body" style="font-size: 10px;">
                        <!--<div class="row invoice-list">
                                                                                                <div class="col-md-12" style="">
                                
                                                                                                        <div class="col-md-12 row details" style="">-->
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <!--<h4 class="modal-title" style="text-align:center;">Labels d'échantillons</h4>-->
                        <!--</div>
                                                                                </div>
                                                                                </div>-->
                    </div>
                </div>
                <div class="modal-body">
                    <!--<div class="panel-body" style="font-size: 10px;">-->
                    <div class="row invoice-list" style="font-size: 10px;">
                        <div class="col-md-12" style="">

                            <div class="col-md-12 row details" style="">
                                <p>
                                    <span style="text-transform: uppercase;">
                                        <label class="control-label2">ID Acte: </label>
                                        <span class="modal_id_acte">
                                            ...
                                        </span>
                                    </span>
                                </p>
                            </div>
                            <div class="col-md-12 row details" style="">
                                <p>
                                    <span style="text-transform: uppercase;">
                                        <label class="control-label2">Patient: </label>
                                        <span class="modal_identite_patient">
                                            ...
                                        </span>
                                    </span>
                                    <br /><span style="text-transform: uppercase;">
                                        <label class="control-label2">Date de naissance: </label>
                                        <span class="modal_date_naissance_patient">
                                            ...
                                        </span>
                                    </span>
                                    <br /><span style="text-transform: uppercase;">
                                        <label class="control-label2">Téléphone: </label>
                                        <span class="modal_tel_patient">
                                            ...
                                        </span>
                                    </span>
                                    <br /><span style="text-transform: uppercase;">
                                        <label class="control-label2">Sexe: </label>
                                        <span class="modal_sexe_patient">
                                            ...
                                        </span>
                                    </span>
                                </p>
                            </div>

                            <div class="col-md-12 row details" style="">
                                <p>
                                    <span style="text-transform: uppercase;font-weight:bold;" class="">
                                        <label class="control-label2">Prélèvement</label><br />
                                    </span>
                                    <span style="text-transform: uppercase;">
                                        <label class="control-label2" style="font-weight:400 !important;font-style:italic;">Effectué le:</label><br />
                                    </span>
                                    <span style="text-transform: uppercase;">
                                        <label class="control-label2" style="font-weight:400 !important;font-style:italic;">Par:</label>
                                    </span>
                                </p>
                            </div>
                        </div>

                        <div class="col-md-12 hr_border" style="margin-top:1px;margin-bottom:1px;">
                            <hr>
                        </div>
                        <div class="col-md-12" style="">

                            <div class="col-md-12 row details" style="">
                                <p>
                                    <span style="text-transform: uppercase;">
                                        <label class="control-label2">ID Acte: </label>
                                        <span class="modal_id_acte">
                                            ...
                                        </span>
                                    </span>
                                </p>
                            </div>
                            <div class="col-md-12 row details" style="">
                                <p>
                                    <span style="text-transform: uppercase;">
                                        <label class="control-label2">Patient: </label>
                                        <span class="modal_identite_patient">
                                            ...
                                        </span>
                                    </span>
                                    <br /><span style="text-transform: uppercase;">
                                        <label class="control-label2">Date de naissance: </label>
                                        <span class="modal_date_naissance_patient">
                                            ...
                                        </span>
                                    </span>
                                    <br /><span style="text-transform: uppercase;">
                                        <label class="control-label2">Téléphone: </label>
                                        <span class="modal_tel_patient">
                                            ...
                                        </span>
                                    </span>
                                    <br /><span style="text-transform: uppercase;">
                                        <label class="control-label2">Sexe: </label>
                                        <span class="modal_sexe_patient">
                                            ...
                                        </span>
                                    </span>
                                </p>
                            </div>

                            <div class="col-md-12 row details" style="">
                                <p>
                                    <span style="text-transform: uppercase;font-weight:bold;" class="">
                                        <label class="control-label2">Prélèvement</label><br />
                                    </span>
                                    <span style="text-transform: uppercase;">
                                        <label class="control-label2" style="font-weight:400 !important;font-style:italic;">Effectué le:</label><br />
                                    </span>
                                    <span style="text-transform: uppercase;">
                                        <label class="control-label2" style="font-weight:400 !important;font-style:italic;">Par:</label>
                                    </span>
                                </p>
                            </div>
                        </div>

                        <div class="col-md-12 hr_border" style="margin-top:1px;margin-bottom:1px;">
                            <hr>
                        </div>
                        <div class="col-md-12" style="">

                            <div class="col-md-12 row details" style="">
                                <p>
                                    <span style="text-transform: uppercase;">
                                        <label class="control-label2">ID Acte: </label>
                                        <span class="modal_id_acte">
                                            ...
                                        </span>
                                    </span>
                                </p>
                            </div>
                            <div class="col-md-12 row details" style="">
                                <p>
                                    <span style="text-transform: uppercase;">
                                        <label class="control-label2">Patient: </label>
                                        <span class="modal_identite_patient">
                                            ...
                                        </span>
                                    </span>
                                    <br /><span style="text-transform: uppercase;">
                                        <label class="control-label2">Date de naissance: </label>
                                        <span class="modal_date_naissance_patient">
                                            ...
                                        </span>
                                    </span>
                                    <br /><span style="text-transform: uppercase;">
                                        <label class="control-label2">Téléphone: </label>
                                        <span class="modal_tel_patient">
                                            ...
                                        </span>
                                    </span>
                                    <br /><span style="text-transform: uppercase;">
                                        <label class="control-label2">Sexe: </label>
                                        <span class="modal_sexe_patient">
                                            ...
                                        </span>
                                    </span>
                                </p>
                            </div>

                            <div class="col-md-12 row details" style="">
                                <p>
                                    <span style="text-transform: uppercase;font-weight:bold;" class="">
                                        <label class="control-label2">Prélèvement</label><br />
                                    </span>
                                    <span style="text-transform: uppercase;">
                                        <label class="control-label2" style="font-weight:400 !important;font-style:italic;">Effectué le:</label><br />
                                    </span>
                                    <span style="text-transform: uppercase;">
                                        <label class="control-label2" style="font-weight:400 !important;font-style:italic;">Par:</label>
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>
                    <!--</div>-->

                </div>
            </div><!-- /.modal-content -->
            <div class="btn-group btn-group-sm d-print-none" style="width:100%">
                <!-- <a class="btn btn-info btn-sm invoice_button pull-left" data-dismiss="modal"><i class="fa fa-arrow-circle-left"></i> Retour </a> -->
                <button type="submit" onclick="print()" class="btn btn-info btn-sm invoice_button pull-right" style="margin-left: 2%;"><i class="fa fa-print"></i> Imprimer</button>
                <a data-dismiss="modal" class="btn btn-info btn-sm invoice_button pull-right" style="margin-left: 2%;color:#edfafa">Retour</a>
            </div>

        </div><!-- /.modal-dialog -->
    </div>
    <!-- Edit Event Modal-->

    <script src="<?php echo base_url(); ?>common/js/codearistos.min.js"></script>

    <script>
        $(document).ready(function() {
            var e = document.getElementById("pos_select");
            var value = e.options[e.selectedIndex].value;
            if(value === "positive"){
                document.querySelector("#conclusionFormat").innerHTML = "Recherche directe d'ARN du SARS-Cov-2: Positive";
                document.getElementById("conclusion").value = 13;

            }else{
                document.querySelector("#conclusionFormat").innerHTML = "Recherche directe d'ARN du SARS-Cov-2: Négative";
                document.getElementById("conclusion").value = 12;
            }
            
            $(document.body).on('change', '#pos_select', function() {

                var v = $("select.pos_select option:selected").val()

                if (v == 'positive') {
                    document.querySelector("#conclusionFormat").innerHTML = "Recherche directe d'ARN du SARS-Cov-2: Positive";
                    document.getElementById("conclusion").value = 13;
                } else {
                    document.querySelector("#conclusionFormat").innerHTML = "Recherche directe d'ARN du SARS-Cov-2: Négative";
                    document.getElementById("conclusion").value = 12;
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('.type_pf').change(function() {
                var id = $(this).val();
                if (id === 'add_new') {
                    $('.new_sampling1').removeClass("hidden");
                    $('.new_sampling').prop("required", true);
                } else {
                    $('.new_sampling').prop("required", false);
                    $('.new_sampling1').addClass("hidden");
                }
            });
            $('.type_conclusion').change(function() {
                var id = $(this).val();
                if (id === 'add_new') {
                    $('.new_conclusion1').removeClass("hidden");
                    $('.new_conclusion').prop("required", true);
                } else {
                    $('.new_conclusion').prop("required", false);
                    $('.new_conclusion1').addClass("hidden");
                }
            });
            $(document).on('change', '.choose_para', function() {
                var id = $(this).attr('id');
                var value = $('#' + id).val();
                $.ajax({
                    url: 'lab/getLabParaMeterDetails?id=' + value,
                    method: 'GET',
                    data: '',
                    async: false,
                    dataType: 'json',
                    // delai: 250
                }).success(function(response) {
                    $('#parameterchoose_' + response.lab_parameter.parameter_name + '_' + response.lab_parameter.test_id).html(' ');
                    if (response.lab_parameter.reference_type === 'off_switch') {
                        var option = ' <div class="col-md-12" style=" margin-top:5px;"> ' +
                            '<div class="col-md-6">' +
                            ' <label for="exampleInputEmail1"><?php echo lang('high'); ?></label>' +
                            ' <input type="number"class="form-control" step="0.01" name="high_' + response.lab_parameter.parameter_name + '_' + response.lab_parameter.id + '" required="">' +
                            ' </div>' +
                            //                                                                            '  <div class="col-md-6">' +
                            //                                                                            '<label for="exampleInputEmail1"> <?php echo lang('low'); ?></label>' +
                            //                                                                            '<input type="number" class="form-control" step="0.01" name="low_' + response.lab_parameter.parameter_name + '_' + response.lab_parameter.id + '" required="">' +
                            //                                                                            '</div>' +
                            '</div>';
                    } else {
                        var option = '<select style=" margin-top:5px;" class="form-control js-example-basic-single" name="pos_' + response.lab_parameter.parameter_name + '_' + response.lab_parameter.id + '" required="">' +
                            ' <option value="positive"><?php echo lang('positive'); ?></option>' +
                            ' <option value="negative"><?php echo lang('negative'); ?></option>' +
                            '</select>';
                    }
                    $('#parameterchoose_' + response.lab_parameter.parameter_name + '_' + response.lab_parameter.test_id).append(option);
                });
            });
        });
    </script>