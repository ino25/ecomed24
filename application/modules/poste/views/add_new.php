<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="panel">
            <header class="panel-heading">
                 <h4 style="color: #303f9f;margin-bottom: 10px;"><?php echo lang('add_poste'); ?> </h4>
            </header>
            <div class="panel-body">
                <div class="adv-table editable-table ">
                    <div class="clearfix">           
                        <div class="col-lg-12">
                            <section class="panel">
                                <div class="panel-body">
                                    <?php echo validation_errors(); ?>
                                    <form role="form" action="poste/addNew" method="post">
                                        <div class="form-group  col-md-12">
                                            <label for="exampleInputEmail1"><?php echo lang('service'); ?> <span class="fa fa-star label-required"></span></label>
                                            <select class="form-control m-bot15 js-example-basic-single" name="service" required="" >    <option value="">Veuillez sélectionner un service</option>
                                                <?php foreach ($services as $service) { ?>
                                                    <option value="<?php echo $service->idservice; ?>"> <?php echo $service->name_service; ?> </option>
                                                <?php } ?> 
                                            </select>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label class="control-label col-md-3"><?php echo lang('nom'); ?><span class="fa fa-star label-required"></span></label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" name="name" id="exampleInputEmail1" value='<?php
                                                if (!empty($setval)) {
                                                    echo set_value('name');
                                                }
                                                if (!empty($department->name)) {
                                                    echo $department->name;
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
                                                    if (!empty($department->description)) {
                                                        echo $department->description;
                                                    }
                                                    ?></textarea>
                                            </div>
                                        </div>
                                        <input type="hidden" name="id" value='<?php
                                        if (!empty($department->id)) {
                                            echo $department->id;
                                        }
                                        ?>'>
                                        <button type="submit" name="submit" class="btn  bg-blue"><?php echo lang('submit'); ?></button>
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
