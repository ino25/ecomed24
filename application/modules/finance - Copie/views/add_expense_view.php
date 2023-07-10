<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height row">
        <!-- page start-->
        <section class="col-md-6">
            <header class="panel-heading">
                <?php
                if (!empty($expense->id))
                    echo lang('edit_expense');
                else
                    echo lang('add_expense2');
                ?>
            </header>
            <div class="panel-body">
                <div class="adv-table editable-table ">
                    <div class="clearfix"> 
                        <?php echo validation_errors(); ?>
                        <form role="form" action="finance/addExpense" class="clearfix row" method="post" enctype="multipart/form-data">
                            <div class="form-group col-md-12">
                                <label for="exampleInputEmail1"><?php echo lang('category'); ?></label>
                                <select class="form-control m-bot15  pos_select" id="pos_select" name="category" value='' required>
                                        <?php  if (!empty($expense_category)) { ?>
                                    <!--    <option value="<?php echo $expense_category[0]->id; ?> " selected="selected"><?php echo $expense_category[0]->category; ?> - </option>  --> 
                                        <?php } ?>
                                </select>
                            </div>
                            <div class="pos_client clearfix">
                                 <div class="col-md-8 payment pad_bot pull-right">
                                     <div class="form-group"> 
                                        <label for="exampleInputEmail1"><?php echo lang('category'); ?></label>
                                        <input type="text" class="form-control" name="c_category" id="exampleInputEmail1" value='' placeholder="">    
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1"><?php echo lang('description'); ?></label>
                                        <input type="text" class="form-control" name="c_description" id="exampleInputEmail1" value=''
                                         placeholder="">
                                    </div>
                                </div>
                            </div>
                            <!-- PARTIE I TEST -->
                            <div class="form-group col-md-12">
                                <label for="exampleInputEmail1"><?php echo lang('beneficiaire'); ?></label>
                                <select class="form-control m-bot15  pos_select2" id="pos_select2" name="beneficiaire" value=''>
                                <?php  if (empty($beneficiaire)) { ?>
                                    <option>  </option>
                                    <?php } ?>
                                    <?php  if (!empty($beneficiaire)) { ?>
                                    <!--    <option value="<?php echo $beneficiaire[0]->id; ?> " selected="selected"><?php echo $beneficiaire[0]->name; ?> - </option>  --> 
                                        <?php } ?>
                                </select>
                            </div>
                            <div class="pos_client2 clearfix">
                                 <div class="col-md-8 payment pad_bot pull-right">
                                     <div class="form-group"> 
                                        <label for="exampleInputEmail1"><?php echo lang('name'); ?></label>
                                        <input type="text" class="form-control" name="c_name" id="exampleInputEmail1" value='' placeholder="">    
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1"><?php echo lang('last_name'); ?></label>
                                        <input type="text" class="form-control" name="c_last_name" id="exampleInputEmail1" value=''
                                         placeholder="">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1"><?php echo lang('phone'); ?></label>
                                        <input type="text" class="form-control" name="telephone" id="telephone" value='' placeholder="">
                                    </div>
                                </div>
                            </div>
                            <!-- PARTIE II -->
                            <div class="form-group col-md-12">
                                <label for="exampleInputEmail1"><?php echo lang('amount'); ?></label>
                                <input type="text" class="form-control money" name="amount" id="exampleInputEmail1" value='<?php
                                if (!empty($setval)) {
                                    echo set_value('amount');
                                }
                                if (!empty($expense->amount)) {
                                    echo $expense->amount;
                                }
                                ?>' placeholder="">
                            </div>
                            <div class="form-group col-md-12">
                                <label for="exampleInputEmail1"><?php echo lang('note'); ?></label>
                                <input type="text" class="form-control" name="note" id="exampleInputEmail1" value='<?php
                                if (!empty($setval)) {
                                    echo set_value('note');
                                }
                                if (!empty($expense->note)) {
                                    echo $expense->note;
                                }
                                ?>' placeholder="">
                            </div>
                            <input type="hidden" name="id" value='<?php
                            if (!empty($expense->id)) {
                                echo $expense->id;
                            }
                            ?>'>
                            <div class="form-group col-md-12">
                                <a href="finance/expense" name="submit" class="btn btn-info btn-secondary pull-left"><?php echo lang('submit_retour'); ?></a>
                                <button type="submit" name="submit" class="btn btn-info pull-right"><?php echo lang('add'); ?></button>
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

<script src="<?php echo base_url(); ?>common/js/codearistos.min.js"></script>
<script src="<?php echo base_url(); ?>common/js/webservice/autoNumeric2.min.js"></script>
<script src="https://unpkg.com/imask"></script>
<!-- <script src="https://cdn.jsdelivr.net/npm/autonumeric@4.6.0/dist/autoNumeric.min.js"></script> -->
<script>
    var element = document.getElementById('telephone');
    var maskOptions = {
        mask: "{(+221)} 00 000 00 00",
    lazy: false,
    };
    var mask = IMask(element, maskOptions);
    mask.value = "{-- --- -- --";
       
    
</script>
<script> 
var autoNumericInstance = new AutoNumeric.multiple('.money', {
    // currencySymbol: "Fcfa",
    // currencySymbolPlacement: "s",
// emptyInputBehavior: "min",
// selectNumberOnly: true,
// selectOnFocus: true,
overrideMinMaxLimits: 'invalid',
emptyInputBehavior: "0",
    maximumValue : '100000',
    minimumValue : "500",
decimalPlaces : 0,
    decimalCharacter : ',',
    digitGroupSeparator : '.'
});
</script>

<script>
    $(document).ready(function () {
        $('.pos_client').hide();
        $('.pos_client2').hide();
        $(document.body).on('change', '#pos_select', function () {

            var v = $("select.pos_select option:selected").val()
            if (v == 'add_new') {
                $('.pos_client').show();
            } else {
                $('.pos_client').hide();
            }
        });
        $(document.body).on('change', '#pos_select2', function () {
            var v = $("select.pos_select2 option:selected").val()
            if (v == 'add_newBeneficiaire') {
                $('.pos_client2').show();
            } else {
                $('.pos_client2').hide();
            }
            });

    });


</script>
<script>
    $(document).ready(function () {
        $("#pos_select").select2({
            placeholder: '<?php echo lang('select_category'); ?>',
            allowClear: true,
            ajax: {
                url: 'finance/getCategoryinfoWithAddNewOption',
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

        $("#pos_select2").select2({
            placeholder: '<?php echo lang('select_beneficiaire'); ?>',
            allowClear: true,
            ajax: {
                url: 'finance/getBeneficiaireinfoWithAddNewOption',
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

        $("#adoctors").select2({
            placeholder: '<?php echo lang('select_doctor'); ?>',
            allowClear: true,
            ajax: {
                url: 'doctor/getDoctorInfo',
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
</script>

