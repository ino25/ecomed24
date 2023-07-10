<!--sidebar end--> 
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="col-md-6 row">
            <header class="panel-heading">
                <?php
                if (!empty($whatsapp->id))
                    echo lang('edit').''.lang('whatsapp_settings'). '&'. lang('status').' '.lang('setiings') ;
                else
                    echo lang('add').''.lang('whatsapp_settings'). '&'. lang('status').' '.lang('setiings') ;
                ?>
            </header>
            <div class="">
                <div class="adv-table editable-table ">
                    <div class="clearfix">
                        <div class="panel-body">
                                    <?php echo validation_errors(); ?>
                                    <form role="form" action="home/addNewSettings" class="clearfix" method="post" enctype="multipart/form-data">
                                        <div class="form-group"> 
                                            <label for="exampleInputEmail1"> <?php  echo lang('instance_id'); ?> </label>
                                            <input type="text" class="form-control" name="instance_id" id="exampleInputEmail1" value='<?php
                                            if (!empty($whatsapp->instance_id)) {
                                                echo $whatsapp->instance_id;
                                            }
                                            ?>' placeholder="" required="">    
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1"> <?php  echo lang('token'); ?></label>
                                            <input type="text" class="form-control" name="token" id="exampleInputEmail1" value='<?php
                                            if (!empty($whatsapp->token)) {
                                                echo $whatsapp->token;
                                            }
                                            ?>' placeholder="" required="">
                                        </div>
                                         <div class="form-group">
                                            <label for="exampleInputEmail1"> <?php  echo lang('status_changed'); ?>(days)</label>
                                            <input type="number" min="1" class="form-control" name="status_changed" id="exampleInputEmail1" value='<?php
                                            if (!empty($whatsapp->status_changed)) {
                                                echo $whatsapp->status_changed;
                                            }
                                            ?>' placeholder="" required="">
                                        </div>
                                        <input type="hidden" name="id" value='<?php
                                        if (!empty($whatsapp->id)) {
                                            echo $whatsapp->id;
                                        }
                                        ?>'>
                                        <button type="submit" name="submit" class="btn btn-info"> <?php  echo lang('submit'); ?></button>
                                    </form>
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
