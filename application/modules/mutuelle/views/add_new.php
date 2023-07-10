<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="panel">
            <header class="panel-heading">
                 <h4 class="title"><?php echo lang('add_mutuelle'); ?> </h4>
            </header>
            <div class="panel-body">
                <div class="panel-body panel-form">
                <div class="row">
                    <div class="col-md-9 col-sm-12">
                         <div class="col-lg-12">
                            <div class="col-lg-3"></div>
                            <div class="col-lg-6">
                                <?php echo validation_errors(); ?>
                                <?php echo $this->session->flashdata('feedback'); ?>
                            </div>
                            <div class="col-lg-3"></div>
                        </div>
                        <form action="mutuelle/addNew" enctype="multipart/form-data" method="post" accept-charset="utf-8">
                            <div class="form-group row">
                                <label for="insurance_name" class="col-xs-3 col-form--label"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Nom de l'assurance </font></font><i class="text-danger"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">*</font></font></i></label>
                                <div class="col-xs-9">
                                    <input name="insurance_name" type="text" class="form-control" id="insurance_name" placeholder="Nom de l'assurance" value="<?php
                                if (!empty($setval)) {
                                    echo set_value('insurance_name');
                                }
                                if (!empty($mutuelle->insurance_name)) {
                                    echo $mutuelle->insurance_name;
                                }
                                ?>" required="">
                                </div>
                            </div>
 
 
                            <div class="form-group row">
                                <label for="discount" class="col-xs-3 col-form-label"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Remise(%)</font></font></label>
                                <div class="col-xs-9">
                                    <input name="discount" type="text" class="form-control" id="discount" placeholder="Remise" value="<?php
                                if (!empty($setval)) {
                                    echo set_value('discount');
                                }
                                if (!empty($mutuelle->discount)) {
                                    echo $mutuelle->discount;
                                }
                                ?>">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="remark" class="col-xs-3 col-form-label"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Remarque</font></font></label>
                                <div class="col-xs-9">
                                    <textarea name="remark" class="form-control" placeholder="Remarque" rows="7"><?php
                                if (!empty($setval)) {
                                    echo set_value('insurance_name');
                                }
                                if (!empty($mutuelle->remark)) {
                                    echo $mutuelle->remark;
                                }
                                ?></textarea>
                                </div>
                            </div> 
 
                            <div class="form-group row">
                                <label for="insurance_no" class="col-xs-3 col-form-label"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">N ° d'assurance</font></font></label>
                                <div class="col-xs-9">
                                    <input name="insurance_no" type="text" class="form-control" id="insurance_no" placeholder="N ° d'assurance" value="<?php
                                if (!empty($setval)) {
                                    echo set_value('insurance_no');
                                }
                                if (!empty($mutuelle->insurance_no)) {
                                    echo $mutuelle->insurance_no;
                                }
                                ?>">
                                </div>
                            </div>
 
                            <div class="form-group row">
                                <label for="insurance_code" class="col-xs-3 col-form-label"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Code des assurances</font></font></label>
                                <div class="col-xs-9">
                                    <input name="insurance_code" type="text" class="form-control" id="insurance_code" placeholder="Code des assurances" value="<?php
                                if (!empty($setval)) {
                                    echo set_value('insurance_code');
                                }
                                if (!empty($mutuelle->insurance_code)) {
                                    echo $mutuelle->insurance_code;
                                }
                                ?>">
                                </div>
                            </div>
 
                           <div class="form-group row">
                                <label for="disease_charge" class="col-xs-3 col-form-label"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Prise en charge par acte</font></font></label>
                                <div class="col-xs-9" id="disease_charge">
                                   
                                     <div class="row" style="margin-bottom:10px">
                                        <div class="col-xs-4">
                                            <label for="exampleInputEmail1"> <?php echo lang('nom'); ?></label>
                                        </div>
                                        <div class="col-xs-4">
                                             <label for="exampleInputEmail1"> <?php echo lang('tarif') .' '.lang('public') ?></label>
                                        </div>
                                        <div class="col-xs-4">
                                             <label for="exampleInputEmail1"> Prise en Charge</label>
                                        </div>
                                        
                                    </div> 
                                     <?php foreach ($categories as $category) { ?>
                                    <div class="row" style="margin-bottom:10px">
                                        <div class="col-xs-4">
                                            <input name="disease_name[]" type="hidden" class="form-control" value="<?php echo $category->id; ?>" readonly="">
                                         
                                             <input name="acte[]" type="text" class="form-control"  value="<?php echo $category->category; ?>" readonly="">
                                        </div>
                                        <div class="col-xs-4">
                                            <input name="tarif[]" type="text" class="form-control" value="<?php echo $category->price_public; ?>" readonly="">
                                        </div>
                                        <div class="col-xs-4">
                                            <input name="disease_charge[]" type="number" class="form-control searchcharge" placeholder="Prise en Charge" value="<?php 
                                            
                                            if(isset($category->charge)) {
                                            echo $category->charge; } ?>">
                                        </div>
                                        
                                    </div> 
                                        <?php } ?>
                                    
                                </div>
                            </div>
 
      <input name="id" type="hidden" class="form-control" id="id" value="<?php
                             
                                if (!empty($mutuelle->id)) {
                                    echo $mutuelle->id;
                                }
                                ?>">
  

                            <div class="form-group row">
                                <div class="col-sm-offset-3 col-sm-6">
                                    <div class="ui buttons">
                                            <button type="submit" name="submit" class="btn  bg-blue"><?php echo lang('submit'); ?></button>
                                    </div>
                                </div>
                            </div>
                        </form>                    </div> 
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
<script src="<?php echo base_url('common/js/insurance.js') ?>" type="text/javascript"></script>