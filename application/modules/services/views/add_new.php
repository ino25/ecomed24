<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="panel">
            <header class="panel-heading">
                <?php echo lang('add_service'); ?>
            </header>
            <div class="panel-body">
                <div class="adv-table editable-table ">
                    <div class="clearfix">           
                        <div class="col-lg-12">
                            <section class="panel">
                                <div class="panel-body">
                                    <?php echo validation_errors(); ?>
                                    <form role="form" action="service/addNew" method="post">
                                         <div class="form-group  col-md-12">
                                            <label for="exampleInputEmail1"><?php echo lang('department'); ?> <span class="fa fa-star label-required"></span></label>
                                            <select class="form-control m-bot15 js-example-basic-single" name="department" required="" >    <option value=""> --- </option>
                                                <?php foreach ($departments as $department) { ?>
                                                    <option value="<?php echo $department->iddepartment; ?>"> <?php echo $department->name_department; ?> </option>
                                                <?php } ?> 
                                            </select>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label class="control-label col-md-3"><?php echo lang('nom'); ?> <span class="fa fa-star label-required"></span></label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" name="name" id="exampleInputEmail1" value='<?php
                                                if (!empty($setval)) {
                                                    echo set_value('name');
                                                }
                                                if (!empty($service->name_service)) {
                                                    echo $service->name_service;
                                                }
                                                ?>' required="" min="2" max="100" >
                                            </div>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label class="control-label col-md-3"></label>
                                            <div class="col-md-9">

                                            </div>

                                        </div>
                                        <div class="form-group col-md-12">
                                            <label class="control-label col-md-3"><?php echo lang('description'); ?></label>
                                            <div class="col-md-9">
                                                <textarea class="ckeditor form-control" name="description" value="" rows="10"><?php
                                                    if (!empty($setval)) {
                                                        echo set_value('description');
                                                    }
                                                    if (!empty($service->description_service)) {
                                                        echo $service->description_service;
                                                    }
                                                    ?></textarea>
                                            </div>
                                        </div>
                                        <input type="hidden" name="id" value='<?php
                                        if (!empty($service->idservice)) {
                                            echo $service->idservice;
                                        }
                                        ?>'>
                                         <?php if ($this->ion_auth->in_group(array('Doctor', 'Receptionist','adminmedecin'))) { ?>
                                        <button type="submit" name="submit" class="btn  bg-blue"><?php echo lang('submit'); ?></button>
                                         <?php } ?>
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
