<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height row">
        <!-- page start-->
        <section class="col-md-6">
            <header class="panel-heading">
                <?php
                if (!empty($category->id))
                    echo lang('edit_cat_service');
                else
                    echo lang('add_cat_service');
                ?>
            </header>
            <div class="panel-body">
                <div class="adv-table editable-table "> 
                    <div class="clearfix">
                        <?php echo validation_errors(); ?>
                        <form role="form" action="finance/addServiceCategory" class="clearfix" method="post" enctype="multipart/form-data">
                            <div class="form-group"> 
                                <label for="exampleInputEmail1"><?php echo lang('category'); ?></label>
                                <input type="text" class="form-control" name="category" id="exampleInputEmail1" value='<?php
                                if (!empty($setval)) {
                                    echo set_value('category');
                                }
                                if (!empty($category->category)) {
                                    echo $category->category;
                                }
                                ?>' placeholder="" required>    
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1"><?php echo lang('description'); ?></label>
                                <input type="text" class="form-control" name="description" id="exampleInputEmail1" value='<?php
                                if (!empty($setval)) {
                                    echo set_value('description');
                                }
                                if (!empty($category->description)) {
                                    echo $category->description;
                                }
                                ?>' placeholder="">
                            </div>
                            <div class="form-group col-md-12">
                                <label for="exampleInputEmail1"><?php echo lang('amount'); ?></label>
                                <input type="text" class="form-control money" name="amount" id="exampleInputEmail1" value='<?php
                                if (!empty($setval)) {
                                    echo set_value('amount');
                                }
                                if (!empty($category->montant)) {
                                    echo $category->montant;
                                }
                                ?>' placeholder="">
                            </div>
                            <input type="hidden" name="id" value='<?php
                            if (!empty($category->id)) {
                                echo $category->id;
                            }
                            ?>'>
                            <div class="form-group cl-md-12">
                            <a href="finance/serviceCategory" name="submit" class="btn btn-info btn-secondary pull-left"><?php echo lang('submit_retour'); ?></a>
                            <?php  if (!empty($category->id)) { ?>
                                <button type='submit' name='submit' class='btn btn-info pull-right' style="margin-left:15px"><?php echo lang('edit'); ?></button>
                            <?php } ?>
                            <?php  if (empty($category->id)) { ?>
                                <button type='submit' name='submit' class='btn btn-info pull-right' style="margin-left:15px"><?php echo lang('add'); ?></button>
                            <?php } ?>
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
    maximumValue : '10000000',
    minimumValue : "500",
decimalPlaces : 0,
    decimalCharacter : ',',
    digitGroupSeparator : '.'
});
</script>

