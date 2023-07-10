<!--sidebar end-->
<!--main content start-->


<?php
$current_user = $this->ion_auth->get_user_id();
if ($this->ion_auth->in_group('Doctor')) {
    $doctor_id = $this->db->get_where('doctor', array('ion_user_id' => $current_user))->row()->id;
    $doctordetails = $this->db->get_where('doctor', array('id' => $doctor_id))->row();
}
?>


<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="col-md-12 thumbnail">
            <header class="panel-heading">
                <?php
                if (!empty($prescription->id))
                    echo lang('edit_prescription');
                else
                    echo lang('add_prescription');
                ?>
            </header>
            <div class="panel">
                <div class="adv-table editable-table ">
                    <div class="clearfix">
                        <?php echo validation_errors(); ?>
                        <form role="form" id="editPaymentForm" action="prescription/addNewPrescription" class="clearfix" method="post" enctype="multipart/form-data">
                            <div class="">
                                <input type="hidden" value="0" id="choicepartenaire" name="choicepartenaire" />
                                <!-- <div class="col-md-12 payment pad_bot">
                                     <input type="checkbox" value="0" id="choicepartenaire" name="choicepartenaire" />
                                     <label for="exampleInputEmail1" class="titre"> Envoyer à une pharmacie</label>
 
                                 </div>
                                 <div class="col-md-12 payment pad_bot liste_partenaire " id="liste_partenaire" style="display: none">
                                     <label for="exampleInputEmail1"> Pharmacie</label>
                                     <select class="form-control m-bot15" id="partenaire" name="partenaire">
 
                                     </select>
                                 </div>-->

                                <div class="col-md-12 payment">
                                    <br>
                                </div>
                                <input type="hidden" class="form-control form-control-inline input-medium default-date-picker" name="date" id="exampleInputEmail1" value='' placeholder="" readonly="">
                                <div class="form-group col-md-4">
                                    <label for="exampleInputEmail1"> <?php echo lang('date'); ?></label>
                                    <input type="text" class="form-control" name="date_string" id="today" value='' placeholder="" readonly="">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="exampleInputEmail1"> <?php echo lang('doctor'); ?></label>

                                    <input type="hidden"  name="doctor" id="doctorchoose" value='<?php echo $this->ion_auth->user()->row()->id; ?>' required>
                                    <input type="text" class="form-control" name="" id="" value='<?php echo $this->ion_auth->user()->row()->first_name . ' ' . $this->ion_auth->user()->row()->last_name; ?>' readonly="">

                                </div>

                                <div class="form-group col-md-4">
                                    <label for="exampleInputEmail1"> <?php echo lang('patient'); ?></label>
                                    <select class="form-control m-bot15" id="patientchoose" name="patient" value='' required>
                                        <?php if (!empty($prescription->patient)) { ?>
                                            <option value="<?php echo $patients->id; ?>" selected="selected"><?php echo $patients->name; ?> - (<?php echo lang('id'); ?> : <?php echo $patients->id; ?>)</option>
                                        <?php } ?>
                                        <?php
                                        if (!empty($setval)) {
                                            $patientdetails = $this->db->get_where('patient', array('id' => set_value('patient')))->row();
                                            ?>
                                            <option value="<?php echo $patientdetails->id; ?>" selected="selected"><?php echo $patientdetails->name; ?> - (<?php echo lang('id'); ?> : <?php echo $patientdetails->id; ?>)</option>
                                        <?php }
                                        ?>
                                    </select>
                                </div>



                                <!-- <div class="form-group col-md-6">
                                     <label class="control-label"><?php echo lang('history'); ?></label>
                                     <textarea class="form-control ckeditor" id="editor1" name="symptom" value="" rows="50" cols="20"><?php
                                if (!empty($setval)) {
                                    echo set_value('symptom');
                                }
                                if (!empty($prescription->symptom)) {
                                    echo $prescription->symptom;
                                }
                                ?></textarea>
                                 </div>-->



                                <!-- <div class="form-group col-md-6">
                                     <label class="control-label"><?php echo lang('note'); ?></label>
                                     <textarea class="form-control ckeditor" id="editor3" name="note" value="" rows="30" cols="20"><?php
                                if (!empty($setval)) {
                                    echo set_value('note');
                                }
                                if (!empty($prescription->note)) {
                                    echo $prescription->note;
                                }
                                ?></textarea>
                                 </div>-->
                                 <!-- <label class="control-label col-md-3"> <?php echo lang('medicine'); ?></label>
                                 <div class="col-md-9">
                                     <input class="form-control" type="text" value="" name="medicament" required>
                                 </div> -->
                                <div class="form-group col-md-12 medicine_block">
                                    <label class="control-label col-md-3"> <?php echo lang('medicine'); ?></label>
                                    <div class="col-md-6">
                                        <?php if (empty($prescription->medicine)) { ?>
                                            <select class="form-control m-bot15 medicinee" id="my_select1_disabled" name="category" value=''>

                                            </select>
                                        <?php } else { ?>
                                            <select name="category" class="form-control m-bot15 medicinee" multiple="multiple" id="my_select1_disabled">

                                                <?php
                                                if (!empty($prescription->medicine)) {

                                                    // $category_name = $payment->category_name;
                                                    $prescription_medicine = explode('###', $prescription->medicine);
                                                    foreach ($prescription_medicine as $key => $value) {
                                                        $prescription_medicine_extended = explode('***', $value);
                                                        $medicine = $this->medicine_model->getMasterMedicineById($prescription_medicine_extended[0]);
                                                        ?>
                                                        <option value="<?php echo $medicine->id . '*' . $medicine->name . '*' . $medicine->dosage; ?>" <?php echo 'data-dosage="' . $prescription_medicine_extended[1] . '"' . 'data-frequency="' . $prescription_medicine_extended[2] . '"data-days="' . $prescription_medicine_extended[3] . '"data-instruction="' . $prescription_medicine_extended[4] . '"'; ?> selected="selected">
                                                            <?php echo $medicine->name; ?>
                                                        </option>

                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        <?php } ?>
                                    </div>
                                    <div class='col-sm-3'>
                                        <button type='button' data-toggle="modal" data-target="#my_medicine_modal" class='btn btn-primary'> <?php echo lang('add_new'); ?></button>
                                    </div>
                                </div>
                                <div class="form-group col-md-12 panel-body medicine_block">
                                    <label class="control-label col-md-4"><?php echo lang('medicine'); ?></label>
                                    <div class="col-md-12 medicine pull-right">

                                    </div>
                                </div>

                                <div class="form-group col-md-12 lab_test">
                                    <label class="control-label col-md-3"> <?php echo lang('lab_test'); ?></label>
                                    <div class="col-md-6">
                                        <?php if (empty($prescription->lab_test)) { ?>
                                            <select class="form-control m-bot15 lab_test1" id="my_select1_lab_disabled" name="labtest[]" value=''>

                                            </select>
                                        <?php } else { ?>
                                            <select name="labtest[]" class="form-control m-bot15 lab_test1" multiple="multiple" id="my_select1_lab_disabled">

                                                <?php
                                                if (!empty($prescription->lab_test)) {

                                                    // $category_name = $payment->category_name;
                                                    $prescription_lab_test = explode('##', $prescription->lab_test);
                                                    foreach ($prescription_lab_test as $key => $value) {
                                                        $prescription_lab_test_extended = explode('*', $value);
                                                        $lab = $this->lab_model->getMasterLabById($prescription_lab_test_extended[0]);
                                                        ?>
                                                        <option value="<?php echo $lab->id . '*' . $lab->name . '*' . $lab->speciality; ?>" selected="selected">
                                                            <?php echo $lab->name; ?>
                                                        </option>

                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        <?php } ?>
                                    </div>

                                </div>

                                <div class="form-group col-md-12">
                                    <label class="control-label"><?php echo lang('advice'); ?></label>
                                    <textarea class="form-control ckeditor" id="editor3" name="advice" value="" rows="30" cols="20"><?php
                                        if (!empty($setval)) {
                                            echo set_value('advice');
                                        }
                                        if (!empty($prescription->advice)) {
                                            echo $prescription->advice;
                                        }
                                        ?>
                                    </textarea>
                                </div>



                                <input type="hidden" name="admin" value='admin'>

                                <input type="hidden" name="id" value='<?php
                                if (!empty($prescription->id)) {
                                    echo $prescription->id;
                                }
                                ?>'>

                                <div class="form-group">
                                    <a href="prescription/all" class="btn btn-info btn-secondary pull-left"><?php echo lang('retour'); ?></a>
                                    <button type="submit" name="submit" class="btn btn-info pull-right"> <?php echo lang('submit'); ?></button>
                                </div>
                            </div>

                            <div class="col-md-5">

                            </div>



                        </form>
                    </div>
                </div>
            </div>
        </section>
        <!-- page end-->
    </section>
</section>
<!--main content end-->
<!--footer start-->

<!-- Modal -->
<div class="modal fade" id="my_medicine_modal" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><?php echo lang('Add_Medicine'); ?></h4>
            </div>
            <div class="modal-body">
                <form role="form" class="clearfix" method="post" enctype="multipart/form-data">
                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"> <?php echo lang('name'); ?></label>
                        <input type="text" class="form-control" name="name" id="exampleInputEmail1" value='' placeholder="">
                    </div>
                    <input type="hidden" name="redirect" value='prescription'>
                    <input type="hidden" name="status" value='Active'>
                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"> <?php echo lang('category'); ?></label>
                        <select class="form-control m-bot15" name="category" value=''>
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
                        <select class="form-control m-bot15" name="type" value=''>
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

                    <!--                    <div class="form-group col-md-4"> 
                                            <label for="exampleInputEmail1"> <?php echo lang('store_box'); ?></label>
                                            <input type="text" class="form-control" name="box" id="exampleInputEmail1" value='' placeholder="">
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="exampleInputEmail1"> <?php echo lang('expiry_date'); ?></label>
                                            <input type="text" class="form-control default-date-picker" name="e_date" id="exampleInputEmail1" value='' placeholder="" readonly="">
                                        </div>-->
                    <div class="form-group col-md-12">
                        <button type="submit" name="submit" id="submitbtn" class="btn btn-info pull-right"> <?php echo lang('submit'); ?></button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>

<style>
    form {
        border: 0px;
    }

    .med_selected {
        background: #fff;
        padding: 10px 0px;
        margin: 5px;
    }


    .select2-container--bgform .select2-selection--multiple .select2-selection__choice {
        clear: both !important;
    }

    label {
        display: inline-block;
        margin-bottom: 5px;
        font-weight: 500;
        font-weight: bold;
    }

    .medicine_block {
        background: #f1f2f7;
        padding: 50px !important;
    }

    .titre {
        font-size: 1.2em;
    }
</style>


<script src="<?php echo base_url(); ?>common/js/codearistos.min.js"></script>
<script src="<?php echo base_url(); ?>common/js/paiement.js?<?php echo time(); ?>"></script>





<script type="text/javascript">
    dateaujourdhui = new Date();
    document.getElementById("today").value = dateaujourdhui.toLocaleDateString();
    $(document).ready(function () {
        $("#partenaire").select2({
            placeholder: 'Selectionnez un partenaire',
            allowClear: true,
            ajax: {
                url: 'prescription/searhPartenaire',
                type: "post",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        searchTerm: params.term // search term
                    };
                },
                processResults: function (response) {
                    return {
                        results: response
                    };
                },
                cache: true
            }

        });
        //   $(".medicine").html("");
        var selected = $('#my_select1_disabled').find('option:selected');
        var unselected = $('#my_select1_disabled').find('option:not(:selected)');
        selected.attr('data-selected', '1');
        $.each(unselected, function (index, value1) {
            if ($(this).attr('data-selected') == '1') {
                var value = $(this).val();
                var res = value.split("*");
                // var unit_price = res[1];
                var id = res[0];
                $('#med_selected_section-' + id).remove();
                // $('#removediv' + $(this).val() + '').remove();
                //this option was selected before

            }
        });

        /* $("select").on("select2:unselect", function (e) {
         var value = e.params.val();
         
         var res = value.split("*");
         // var unit_price = res[1];
         var id = res[0];
         $('#med_selected_section-' + id).remove();
         });
         */


        var count = 0;
        $.each($('select.medicinee option:selected'), function () {
            var value = $(this).val();
            var res = value.split("*");
            // var unit_price = res[1];
            var id = res[0];
            // var id = $(this).data('id');
            var med_id = res[0];
            var med_name = res[1];
            var dosage = $(this).data('dosage');
            var frequency = $(this).data('frequency');
            var days = $(this).data('days');
            var instruction = $(this).data('instruction');
            if ($('#med_id-' + id).length) {

            } else {

                $(".medicine").append('<section id="med_selected_section-' + med_id + '" class="med_selected row">\n\
         <div class = "form-group medicine_sect col-md-2"><div class=col-md-12>\n\
<label> <?php echo lang("medicine"); ?> </label>\n\
</div>\n\
\n\
<div class=col-md-12>\n\
<input class = "medi_div" name = "med_id[]" value = "' + med_name + '" placeholder="" required>\n\
 <input type="hidden" id="med_id-' + id + '" class = "medi_div" name = "medicine[]" value = "' + med_id + '" placeholder="" required>\n\
 </div>\n\
 </div>\n\
\n\
<div class = "form-group medicine_sect col-md-2" ><div class=col-md-12>\n\
<label><?php echo lang("dosage"); ?> </label>\n\
</div>\n\
<div class=col-md-12><input class = "state medi_div" name = "dosage[]" value = "' + dosage + '" placeholder="100 mg" required>\n\
 </div>\n\
 </div>\n\
\n\
<div class = "form-group medicine_sect col-md-2"><div class=col-md-12>\n\
<label><?php echo lang("frequency"); ?> </label>\n\
</div>\n\
<div class=col-md-12><input class = "potency medi_div sale" id="salee' + count + '" name = "frequency[]" value = "' + frequency + '" placeholder="1 + 0 + 1" required>\n\
</div>\n\
</div>\n\
\n\
<div class = "form-group medicine_sect col-md-2"><div class=col-md-12>\n\
<label>\n\
<?php echo lang("instruction"); ?> \n\
</label>\n\
</div>\n\
<div class=col-md-12><input class = "potency medi_div quantity" id="quantity' + count + '" name = "instruction[]" value = "' + instruction + '" placeholder="" required>\n\
</div>\n\
</div>\n\
\n\
\n\
 <div class="del col-md-1"></div>\n\
</section>');
            }
        });
    });

    var checkbox = document.getElementById('choicepartenaire');
    var pos_matricule = document.getElementById('liste_partenaire');

    checkbox.onclick = function () {

        var option1 = new Option('', '', true, true);
        $('#editPaymentForm').find('[name="patient"]').append(option1).trigger('change');
        var option2 = new Option('', '', true, true);
        $('#editPaymentForm').find('[name="doctor"]').append(option2).trigger('change');

        if (this.checked) {
            document.getElementById('choicepartenaire').value = '1';
            pos_matricule.style['display'] = 'block';

        } else {
            document.getElementById('choicepartenaire').value = '0';
            pos_matricule.style['display'] = 'none';

        }


    };
</script>





<script type="text/javascript">
    $(document).ready(function () {
        $('.medicinee').change(function () {
            //   $(".medicine").html("");
            var count = 0;
            var selected = $('#my_select1_disabled').find('option:selected');
            var unselected = $('#my_select1_disabled').find('option:not(:selected)');
            selected.attr('data-selected', '1');
            $.each(unselected, function (index, value1) {
                if ($(this).attr('data-selected') == '1') {
                    var value = $(this).val();
                    var res = value.split("*");
                    // var unit_price = res[1];
//                    var doages = res[2];
                    var id = res[0];
                    $('#med_selected_section-' + id).remove();
                    // $('#removediv' + $(this).val() + '').remove();
                    //this option was selected before

                }
            });

            $.each($('select.medicinee option:selected'), function () {
                var value = $(this).val();
                var res = value.split("*");
                // var unit_price = res[1];
                var id = res[0];
                // var id = $(this).data('id');
                var med_id = res[0];
                var med_name = res[1];
                var dosage = res[2];


                if ($('#med_id-' + id).length) {

                } else {


                    $(".medicine").append('<section class="med_selected row" id="med_selected_section-' + med_id + '">\n\
         <div class = "form-group medicine_sect col-md-2"><div class=col-md-12>\n\
<label> <?php echo lang("medicine"); ?> </label>\n\
</div>\n\
\n\
<div class=col-md-12>\n\
<input class = "medi_div" name = "med_id[]" value = "' + med_name + '" placeholder="" required>\n\
 <input type="hidden" class = "medi_div" id="med_id-' + id + '" name = "medicine[]" value = "' + med_id + '" placeholder="" required>\n\
 </div>\n\
 </div>\n\
\n\
<div class = "form-group medicine_sect col-md-2" ><div class=col-md-12>\n\
<label><?php echo lang("dosage"); ?> </label>\n\
</div>\n\
<div class=col-md-12><input class = "state medi_div" name = "dosage[]" value = " ' + dosage + ' " placeholder="100 mg" required>\n\
 </div>\n\
 </div>\n\
\n\
<div class = "form-group medicine_sect col-md-2"><div class=col-md-12>\n\
<label><?php echo lang("frequency"); ?> </label>\n\
</div>\n\
<div class=col-md-12><input class = "potency medi_div sale" cols = "100" rows = "100" id="salee' + count + '" name = "frequency[]" value = "" placeholder="1 + 0 + 1" required>\n\
</div>\n\
</div>\n\
\n\
<div class = "form-group medicine_sect col-md-2"><div class=col-md-12>\n\
<label>\n\
<?php echo lang("instruction"); ?> \n\
</label>\n\
</div>\n\
<div class=col-md-12><input class = "potency medi_div quantity" id="quantity' + count + '" name = "instruction[]" value = "" placeholder="Instraction" required>\n\
</div>\n\
</div>\n\
\n\
\n\
 <div class="del col-md-1"></div>\n\
</section>');
                }
            });
        });
    });
</script>
<script>
    $(document).ready(function () {

        $("#patientchoose").select2({
            placeholder: '<?php echo lang('select_patient'); ?>',
            allowClear: true,
            ajax: {
                url: 'patient/getPatientinfo',
                type: "post",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        searchTerm: params.term // search term
                    };
                },
                processResults: function (response) {
                    return {
                        results: response
                    };
                },
                cache: true
            }

        });
        /* $("#doctorchoose").select2({
         placeholder: '<?php echo lang('select_doctor'); ?>',
         allowClear: true,
         ajax: {
         url: 'doctor/getDoctorinfo',
         type: "post",
         dataType: 'json',
         delay: 250,
         data: function(params) {
         return {
         searchTerm: params.term // search term
         };
         },
         processResults: function(response) {
         return {
         results: response
         };
         },
         cache: true
         }
         
         });*/
        /*    $("#doctorchoose1").select2({
         placeholder: '<?php echo lang('select_doctor'); ?>',
         allowClear: true,
         ajax: {
         url: 'doctor/getDoctorInfo',
         type: "post",
         dataType: 'json',
         delay: 250,
         data: function(params) {
         return {
         searchTerm: params.term // search term
         };
         },
         processResults: function(response) {
         return {
         results: response
         };
         },
         cache: true
         }
         
         });*/



    });
</script>

<script>
    $(document).ready(function () {
        // $(".flashmessage").delay(3000).fadeOut(100);
        // $("#my_select10").select2();
        $('#my_select1').select2({
            multiple: true,
            placeholder: '<?php echo lang('medicine'); ?>',
            allowClear: true,
            closeOnSelect: true,
            ajax: {
                url: 'medicine/getMedicinenamelist',
                dataType: 'json',
                type: "post",
                delay: 250,
                data: function (params) {
                    return {
                        searchTerm: params.term, // search term
                        page: params.page
                    };
                },
                processResults: function (data, params) {
                    // parse the results into the format expected by Select2
                    // since we are using custom formatting functions we do not need to
                    // alter the remote JSON data, except to indicate that infinite
                    // scrolling can be used
                    params.page = params.page || 1;

                    return {
                        results: data,
                        newTag: true,
                        pagination: {
                            more: (params.page * 1) < data.total_count
                        }
                    };
                },
                cache: true
            },
        });
    });
</script>
<script>
    $(document).ready(function () {
        $("#my_select1_disabled").select2({
            placeholder: '<?php echo lang('medicine'); ?>',
            multiple: true,
            allowClear: true,
            ajax: {
                url: 'medicine/getMedicineListForSelect2',
                type: "post",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        searchTerm: params.term // search term
                    };
                },
                processResults: function (response) {
                    return {
                        results: response
                    };
                },
                cache: true
            }

        });
        $("#my_select1_lab_disabled").select2({
            placeholder: '<?php echo lang('lab_test'); ?>',
            multiple: true,
            allowClear: true,
            ajax: {
                url: 'lab/getLabListForSelect2',
                type: "post",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        searchTerm: params.term // search term
                    };
                },
                processResults: function (response) {
                    return {
                        results: response
                    };
                },
                cache: true
            }

        });
    });







    $(document).ready(function () {

        $("#medi_form").validate({
            rules: {
                designation: {
                    required: true
                },
                med_Category: {
                    required: true
                }
            },
            messages: {
                designation: {
                    required: "Please write the designation"
                },
                med_Category: {
                    required: "Please Pick the Med Category"
                }
            },
            submitHandler: function (form) { // for demo
                var formdata = new FormData($('#medi_form')[0]);
                //console.log();
                $.ajax({
                    url: 'medicine/addNewMedicineLightJson',
                    data: formdata,
                    contentType: false,
                    processData: false,
                    type: "post",
                    dataType: "json",
                    beforeSend: function () {
                        //$('.notes_loader').html('<i class="fa fa-spinner fa-spin"></i> Notes adding... ')
                    },
                    success: function (response) {
                        if (response.error) {
                            alert('some error occurs');
                        } else {
                            $('#my_medicine_modal').modal('hide');
                        }

                    }
                });
            }
        });







$('#submitbtn').click( function() {
    $.ajax({
        url: 'medicine/addRequestFromPrescription',
        type: 'post',
        dataType: 'json',
        data: $('form#myForm').serialize(),
        success: function(data) {
                   // ... do something with the data...
                 }
    });
});


    });
</script>