<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="panel-body col-md-10">
            <header class="panel-heading">
                <?php
                if (!empty($lab_test->id))
                    echo lang('edit_lab_test');
                else
                    echo lang('add_lab_test');
                ?>
            </header>
            <style>
                .form-control{
                    font-size: 11px !important;
                }

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
            <div class="row">
                <div class="adv-table editable-table ">
                    <div class="clearfix">
                        <div class="col-md-12">
                            <section class="panel row">
                                <div class = "panel-body">
                                    <?php echo validation_errors(); ?>
                                    <form role="form" action="<?php if(empty($request)){echo 'lab/addMasterLabTest';}else{echo'lab/addRequestMasterLabTest';}?>" class="clearfix" method="post" enctype="multipart/form-data">
                                        <div class="form-group col-md-6">
                                            <label for="exampleInputEmail1"> <?php echo lang('speciality'); ?></label>
                                            <input type="text" class="form-control" name="speciality" id="exampleInputEmail1" value='<?php
                                            if (!empty($lab_test->speciality)) {
                                                echo $lab_test->speciality;
                                            }
                                            ?>' placeholder="">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="exampleInputEmail1"> <?php echo lang('prestation'); ?></label>
                                            <input type="text" class="form-control" name="name" id="exampleInputEmail1" value='<?php
                                            if (!empty($lab_test->name)) {
                                                echo $lab_test->name;
                                            }
                                            ?>' placeholder="">
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="exampleInputEmail1"> <?php echo lang('description'); ?></label>
                                            <textarea  class="form-control" rows="3" name="description" id="exampleInputEmail1" value='' placeholder=""><?php
                                                if (!empty($lab_test->description)) {
                                                    echo $lab_test->description;
                                                }
                                                ?></textarea>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="exampleInputEmail1"> <?php echo lang('status'); ?></label>
                                            <select name="status" class="form-control" >
                                                <option value="active" <?php
                                                if (!empty($lab_test->status)) {
                                                    if ($lab_test->status == 'active') {
                                                        echo 'selected';
                                                    }
                                                }
                                                ?>><?php echo lang('active'); ?></option>
                                                <option value="inactive" <?php
                                                if (!empty($lab_test->status)) {
                                                    if ($lab_test->status == 'inactive') {
                                                        echo 'selected';
                                                    }
                                                }
                                                ?>><?php echo lang('in_active'); ?></option>
                                            </select>
                                        </div>

                                        <h3><?php echo lang('parameters'); ?></h3><hr>
                                        <div class="col-md-12">
                                            <div class="form-inline">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th><?php echo lang('parameter_name'); ?></th>
                                                            <th><?php echo lang('parameter_description'); ?></th>
                                                            <th><div class="col-md-6"><?php echo lang('unit_of_measure'); ?> 
                                                                </div><div  class="col-md-6"> <?php echo lang('reference_value'); ?></div></th>

                                                            <th> <a class="add-new"  title="Add" data-toggle="tooltip"><i class="fa fa-plus-circle fa-2x"></i></a></th>

                                                        </tr>
                                                    </thead><tbody id="row_input">
                                                        <?php if (empty($lab_test)) { ?>
                                                            <tr>
                                                                <td><input type="text" name="parameter_name[]" class="form-control" required placeholder="<?php echo lang('parameter_name'); ?>"></td>
                                                                <td><input type="text" name="parameter_description[]" class="form-control" placeholder="<?php echo lang('parameter_description'); ?>"></td>
                                                                <td id="attribute-1">  <div class="col-md-6">
                                                                        <span style="display:block;"><button data-toggle="tooltip" class="add_new_reference" id="add_new_reference-1-1" title="Add_reference"><i class="fa fa-plus-circle fa-sm"></i></button> 
                                                                            <input type="text" name="unit_of_measure-1[]" class="form-control" ></span></div>

                                                                    <div class="col-md-6"> <?php echo lang('high_low'); ?> <label class="switch">
                                                                            <input type="hidden" class="references_class" name="references_1[]" id="" value="off_switch"/>
                                                                            <input type="checkbox" class="references_class" name="references_1[]" id="high_low-1-1" value="on"/>

                                                                            <span class="slider round"></span>
                                                                        </label>  <?php echo lang('positive_negative'); ?>

                                                                        <div class="high_low" id="high_low_div-1-1">

                                                                            <input type="number" id="high-1-1" style="margin-top:3px;" step="0.01" class="form-control" name="high-1[]" value=""  placeholder="<?php echo lang('high'); ?>" required=""/>

                                                                            <input type="number" id="low-1-1" style="margin-top:3px;" step="0.01" class="form-control" name="low-1[]" value=""  placeholder="<?php echo lang('low'); ?>" required=""/>

                                                                        </div>
                                                                        <div class="positive_negative hidden col-md-12" id="positive_negative_div-1-1" style="margin-top:3px;">


                                                                            <select name="positive_negative-1[]" class="form-control" >
                                                                                <option value="positive"><?php echo lang('positive'); ?></option>
                                                                                <option value="negative" ><?php echo lang('negative'); ?></option>
                                                                            </select>

                                                                        </div>

                                                                    </div>
                                                                    <input type="hidden" name="num_of_resource[]" value="1" id="number_of_resource_1">
                                                                </td>
                                                                <td></td>
                                                            </tr>
                                                            <?php
                                                        } else {
                                                            $parameter_test = explode("**", $lab_test->parameter);
                                                            
                                                            $i = 1;
                                                            foreach ($parameter_test as $parameter) {
                                                                $parameter_details = array();
                                                                $parameter_details = $this->lab_model->getMasterLabTestByIdByName($lab_test->id, $parameter);
                                                                foreach ($parameter_details as $details) {
                                                                    if (!empty($details->parameter_description)) {
                                                                        $description = $details->parameter_description;
                                                                    } else {
                                                                        $description = ' ';
                                                                    }
                                                                }
                                                                ?>
                                                                <tr>
                                                                    <td><input type="text" value="<?php echo $parameter; ?>" name="parameter_name[]" class="form-control" required placeholder="<?php echo lang('parameter_name'); ?>"></td>
                                                                    <td><input type="text" value="<?php echo $description; ?>" name="parameter_description[]" class="form-control" placeholder="<?php echo lang('parameter_description'); ?>"></td>
                                                                    <td id="attribute-<?php echo $i; ?>">
                                                                        <?php
                                                                        $j = 1;
                                                                        foreach ($parameter_details as $details) {
                                                                            ?>

                                                                            <div class="col-md-6">
                                                                                <?php if ($j == 1) { ?>
                                                                                    <span style="display:block;"><button data-toggle="tooltip" class="add_new_reference" id="add_new_reference-<?php echo $i; ?>-<?php echo $j; ?>" title="Add_reference"><i class="fa fa-plus-circle fa-sm"></i></button> 
                                                                                    <?php } else { ?>
                                                                                        <span>    <button class="delete_new_reference" id="delete_new_reference-<?php echo $i; ?>-<?php echo $j; ?>" title="delete_reference"><i class="fa fa-minus-circle fa-sm"></i></button></span>
                                                                                    <?php } ?>
                                                                                        <input type="text" name="unit_of_measure-<?php echo $i; ?>[]" class="form-control" value="<?php echo $details->unit_of_measure;?>" ></span></div>

                                                                                        <div class="col-md-6" style="margin-top:3px;"> <?php echo lang('high_low'); ?> <label class="switch">
                                                                                    <input type="hidden" class="references_class" name="references_<?php echo $i; ?>[]" id="" value="off_switch"/>
                                                                                    <input type="checkbox" class="references_class" name="references_<?php echo $i; ?>[]" id="high_low-<?php echo $i; ?>-<?php echo $j; ?>" value="on" <?php if ($details->reference_type == 'on') {
                                                                            echo'checked';
                                                                        } ?>/>

                                                                                    <span class="slider round"></span>
                                                                                </label>  <?php echo lang('positive_negative'); ?>

                                                                                <div class="high_low <?php if ($details->reference_type == 'on') {
                                                                            echo'hidden';
                                                                        } ?>" id="high_low_div-<?php echo $i; ?>-<?php echo $j; ?>">

                                                                                    <input type="number" id="high-<?php echo $i; ?>-<?php echo $j; ?>" style="margin-top:3px;" step="0.01" class="form-control" name="high-<?php echo $i; ?>[]" value="<?php echo $details->high; ?>" min="0" placeholder="<?php echo lang('high'); ?>"/>

                                                                                    <input type="number" id="low-<?php echo $i; ?>-<?php echo $j; ?>" style="margin-top:3px;" step="0.01" class="form-control" name="low-<?php echo $i; ?>[]" value="<?php echo $details->low; ?>" min="0" placeholder="<?php echo lang('low'); ?>"/>

                                                                                </div>
                                                                                <div class="positive_negative <?php if ($details->reference_type == 'off_switch') {
                                                                            echo'hidden';
                                                                        } ?> col-md-12" id="positive_negative_div-<?php echo $i; ?>-<?php echo $j; ?>" style="margin-top:3px;">


                                                                                    <select name="positive_negative-<?php echo $i; ?>[]" class="form-control" >
                                                                                        <option value="positive" <?php if ($details->positive_negative == 'positive') {
                                                                            echo'selected';
                                                                        } ?>><?php echo lang('positive'); ?></option>
                                                                                        <option value="negative"<?php if ($details->positive_negative == 'negative') {
                                                                            echo'selected';
                                                                        } ?> ><?php echo lang('negative'); ?></option>
                                                                                    </select>

                                                                                </div>

                                                                            </div>
                                                                            <input type="hidden" name="num_of_resource[]" value="<?php echo count($parameter_details); ?>" id="number_of_resource_1">
            <?php $j++;
        } ?>
                                                                    </td>
                                                                    <td><?php if($i!=1){ ?> 
                                                                        <a class="delete" title="Delete" data-toggle="tooltip"><i class="fa fa-minus-circle fa-2x"></i></a>
                                                                        <?php } ?></td>
                                                                </tr>
        <?php
        $i++;
    }
}
?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>


                                        <input type="hidden" name="total_table_row" id="total_table_row" value="<?php if(empty($lab_test)){    echo '1';}else{ echo count($parameter_test);}?>">

                                        <input type="hidden" name="id" value='<?php
                                        if (!empty($lab_test->id)) {
                                            echo $lab_test->id;
                                        }
?>'>
                                        <input type="hidden" name="request" value='<?php
                                        if (!empty($request)) {
                                            echo $request;
                                        }
?>'>
                                        <div class="form-group col-md-12">
                                            <button type="submit" name="submit" class="btn btn-info pull-right"> <?php echo lang('submit'); ?></button>
                                        </div>
                                    </form>
                                </div>

                            </section>
                        </div>
                    </div>
                </div>
            </div>

        </section>
        <!-- page end-->
    </section>
</section>
<!--main content end-->
<!--footer start-->


<style>
    .wrapper{
        padding: 24px 30px;
    }
</style>
<script src="<?php echo base_url(); ?>common/js/codearistos.min.js"></script>
<script src="common/assets/switchery/switchery.js"></script>
<script>
    $(document).ready(function () {
        $('#row_input').on('change', '.references_class', function () {

            var id = $(this).attr('id');
            var ids = id.split('-');


            if ($('#' + id).is(':checked')) {
//                $('#' + id).val(' ');
//                $('#' + id).val('on');
                $('#positive_negative_div-' + ids[1] + '-' + ids[2]).removeClass('hidden');
                $('#high_low_div-' + ids[1] + '-' + ids[2]).addClass('hidden');
                $('#high-' + ids[1] + '-' + ids[2]).prop('required', false);
                $('#low-' + ids[1] + '-' + ids[2]).prop('required', false);


            } else {
//                $('#' + id).val(' ');
//                $('#' + id).val('off_switch');
                $('#positive_negative_div-' + ids[1] + '-' + ids[2]).addClass('hidden');
                $('#high_low_div-' + ids[1] + '-' + ids[2]).removeClass('hidden');
                $('#high-' + ids[1] + '-' + ids[2]).prop('required', true);
                $('#low-' + ids[1] + '-' + ids[2]).prop('required', true);
            }
        });
//        var elem4 = document.querySelector('.js-switch-mandatory-1-1');
//        var switchery1 = new Switchery(elem4, {color: '#70CA63', jackColor: '#FFFFFF', size: 'small'});
        $('.add-new').on('click', function () {
            var index = $("table tbody tr:last-child").index() + 1;

            var option = ' <tr>' +
                    '<td><input type="text" name="parameter_name[]" class="form-control" placeholder="' + "<?php echo lang('parameter_name'); ?>" + '"></td>' +
                    ' <td><input type="text" name="parameter_description[]" class="form-control" placeholder="' + "<?php echo lang('parameter_description'); ?>" + '"></td>' +
                    '<td id="attribute-' + (index + 1) + '"><div class="col-md-6"> <span ><button class="add_new_reference" id="add_new_reference-' + (index + 1) + '-1" title="Add_reference"><i class="fa fa-plus-circle fa-sm"></i></button> <input type="text" name="unit_of_measure-' + (index + 1) + '[]" class="form-control" ></span></div>' +
                    '<div class="col-md-6"><?php echo lang('high_low'); ?>' + ' <label class="switch"><input type="hidden" class="references_class" name="references_' + (index + 1) + '[]" id="" value="off_switch"/><input type="checkbox" class="references_class" value="on" name="references_' + (index + 1) + '[]" id="high_low-' + (index + 1) + '-1"    />  <span class="slider round"></span>' +
                    '</label> ' + '<?php echo lang('positive_negative'); ?>' +
                    '<div class="high_low" id="high_low_div-' + (index + 1) + '-1">' +
                    ' <input type="number" id="high-' + (index + 1) + '-1" style="margin-top:3px;" step="0.01" class="form-control" name="high-' + (index + 1) + '[]" value="" min="0" placeholder="' + "<?php echo lang('high'); ?>" + '" required=""/>' +
                    '      <input type="number" id="low-' + (index + 1) + '-1" style="margin-top:3px;" step="0.01" class="form-control" name="low-' + (index + 1) + '[]" value="" min="0" placeholder="' + "<?php echo lang('low'); ?>" + '" required=""/>' +
                    ' </div>' +
                    ' <div class="positive_negative hidden col-md-12" id="positive_negative_div-' + (index + 1) + '-1" style="margin-top:3px;">' +
                    '  <select name="positive_negative-' + (index + 1) + '[]" class="form-control" >' +
                    '<option value="positive">' + "<?php echo lang('positive'); ?>" + '</option>' +
                    ' <option value="negative" >' + "<?php echo lang('negative'); ?>" + '</option>' +
                    ' </select>' +
                    '  </div></div>' +
                    '   <input type="hidden" name="num_of_resource[]" value="1" id="number_of_resource_' + (index + 1) + '">  </td>' +
                    '<td> <a class="delete" title="Delete" data-toggle="tooltip"><i class="fa fa-minus-circle fa-2x"></i></a></td>' +
                    '</tr>';
            $("#row_input").append(option);
            $("table tbody tr").eq(index + 1).find(".add, .edit").toggle();
            $('[data-toggle="tooltip"]').tooltip();
            var get_row_number = parseInt($('#total_table_row').val());
            $('#total_table_row').val((get_row_number + 1));
//            var elem3 = document.querySelector('.js-switch-mandatory-' + (index + 1) + '-1');
//            var switchery1 = new Switchery(elem3, {color: '#70CA63', jackColor: '#FFFFFF', size: 'small'});
        });

        $('#row_input').on('click', '.add_new_reference', function () {
            var id = $(this).attr('id');
            var ids = id.split("-");
            var index = parseInt(ids[1]);

//            var content = $('#attribute-' + ids[1].).length;
            var content = $('#attribute-' + ids[1]).find(".references_class").map(function () {

                return $(this).attr('id');

            });
            var content_last = parseInt(content[(content.length) - 1].split("-")[2]);

            var option = '<div class="col-md-6" id="button-div-' + (index) + '-' + (content_last + 1) + '"> <span><button class="delete_new_reference" id="delete_new_reference-' + (index) + '-' + (content_last + 1) + '" title="delete_reference"><i class="fa fa-minus-circle fa-sm"></i></button> <input type="text" name="unit_of_measure-' + (index) + '[]" class="form-control" ></span></div>' +
                    '<div class="col-md-6" style="margin-top:3px;" id="option-div-' + (index) + '-' + (content_last + 1) + '"><?php echo lang('high_low'); ?> ' + '<label class="switch"><input type="hidden" class="references_class" name="references_' + (index) + '[]" id="" value="off_switch"/> <input type="checkbox" value="on" class="references_class" name="references_' + (index) + '[]" id="high_low-' + (index) + '-' + (content_last + 1) + '" >  <span class="slider round"></span>' +
                    '</label> ' + '<?php echo lang('positive_negative'); ?>' + '<div class="" id="high_low_div-' + (index) + '-' + (content_last + 1) + '">' +
                    ' <input type="number" id="high-' + (index) + '-' + (content_last + 1) + '" style="margin-top:3px;" step="0.01" class="form-control" name="high-' + (index) + '[]" value="" min="0" placeholder="' + "<?php echo lang('high'); ?>" + '" required=""/>' +
                    '      <input type="number" id="low-' + (index) + '-' + (content_last + 1) + '" style="margin-top:3px;" step="0.01" class="form-control" name="low-' + (index) + '[]" value="" min="0" placeholder="' + "<?php echo lang('low'); ?>" + '" required=""/>' +
                    ' </div>' +
                    ' <div class="positive_negative hidden col-md-12" id="positive_negative_div-' + (index) + '-' + (content_last + 1) + '" style="margin-top:3px;">' +
                    '  <select name="positive_negative-' + (index) + '[]" class="form-control" >' +
                    '<option value="positive">' + "<?php echo lang('positive'); ?>" + '</option>' +
                    ' <option value="negative" >' + "<?php echo lang('negative'); ?>" + '</option>' +
                    ' </select>' +
                    '  </div></div>';


            document.getElementById('attribute-' + ids[1]).insertAdjacentHTML('beforeend', option);
            $('#number_of_resource_' + ids[1]).val((parseInt($('#number_of_resource_' + ids[1]).val()) + 1));
//            $('#attribute-' + ids[1]).trigger('change');
//            $('#attribute-' + ids[1]).html(option);
//            $('[data-toggle="tooltip"]').tooltip();
//            var elem5 = document.querySelector('.js-switch-mandatory-' + (index) + '-' + (content_last + 1));
//            var switchery123 = new Switchery(elem5, {color: '#70CA63', jackColor: '#FFFFFF', size: 'small'});
        });

        $(document).on("click", ".delete", function () {
            $(this).parents("tr").remove();
            $(".add-new").removeAttr("disabled");
        });
        $(document).on("click", ".delete_new_reference", function () {
            var id = $(this).attr('id');
            var ids = id.split('-');
            $('#button-div-' + ids[1] + '-' + ids[2]).remove();
            $('#option-div-' + ids[1] + '-' + ids[2]).remove();
            $('#number_of_resource_' + ids[1]).val((parseInt($('#number_of_resource_' + ids[1]).val()) - 1));

        });
    });

</script>