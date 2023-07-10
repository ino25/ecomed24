<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="panel">
            <header class="panel-heading">
                <?php
                if (!empty($patient->id))
                    echo lang('edit_patient');
                else
                    echo lang('add_new_patient');
                ?>
            </header>
            <div class="panel-body col-md-7">
                <div class="adv-table editable-table ">
                    <div class="clearfix">
                        <div class="col-lg-12">
                            <section class="panel">
                                <div class="panel-body">
                                    <div class="col-lg-12">
                                        <div class="col-lg-3"></div>
                                        <div class="col-lg-6">
                                            <?php echo validation_errors(); ?>
                                        </div>
                                        <div class="col-lg-3"></div>
                                    </div>
                                    <form role="form" action="patient/addNew" method="post" enctype="multipart/form-data">
                             
                                        <div class="form-group">
                                            <label for="exampleInputEmail1"><?php echo lang('name'); ?></label>
                                            <input type="text" class="form-control" name="name" id="exampleInputEmail1" value='<?php
                                            if (!empty($setval)) {
                                                echo set_value('name');
                                            }
                                            if (!empty($patient->name)) {
                                                echo $patient->name;
                                            }
                                            ?>' placeholder="">
                                        </div>
                                         <div class="form-group">
                                            <label for="exampleInputEmail1"><?php echo lang('last_name'); ?></label>
                                            <input type="text" class="form-control" name="last_name" id="exampleInputlast_name" value='<?php
                                            if (!empty($setval)) {
                                                echo set_value('last_name');
                                            }
                                            if (!empty($patient->last_name)) {
                                                echo $patient->last_name;
                                            }
                                            ?>' placeholder="">
                                        </div>


                                        <div class="form-group">
                                            <label for="exampleInputEmail1"><?php echo lang('email'); ?></label>
                                            <input type="text" class="form-control" name="email" id="exampleInputEmail1" value='<?php
                                            if (!empty($patient->email)) {
                                                echo $patient->email;
                                            }
                                            ?>' placeholder="">
                                        </div>

                                        <div class="form-group">        
                                            <label for="exampleInputEmail1"><?php echo lang('password'); ?></label>
                                            <input type="password" class="form-control" name="password" id="exampleInputEmail1" placeholder="">
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleInputEmail1"><?php echo lang('address'); ?></label>
                                            <input type="text" class="form-control" name="address" id="exampleInputEmail1" value='<?php
                                            if (!empty($setval)) {
                                                echo set_value('address');
                                            }
                                            if (!empty($patient->address)) {
                                                echo $patient->address;
                                            }
                                            ?>' placeholder="">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1"><?php echo lang('phone'); ?></label>
                                            <input type="text" class="form-control" name="phone" id="exampleInputEmail1" value='<?php
                                            if (!empty($setval)) {
                                                echo set_value('phone');
                                            }
                                            if (!empty($patient->phone)) {
                                                echo $patient->phone;
                                            }
                                            ?>' placeholder="" required="">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1"><?php echo lang('sex'); ?></label>
                                            <select class="form-control m-bot15" name="sex" value=''>
                                                <option value="Male" <?php
                                                if (!empty($setval)) {
                                                    if (set_value('sex') == 'Male') {
                                                        echo 'selected';
                                                    }
                                                }
                                                if (!empty($patient->sex)) {
                                                    if ($patient->sex == 'Male') {
                                                        echo 'selected';
                                                    }
                                                }
                                                ?> > Male </option>
                                                <option value="Female" <?php
                                                if (!empty($setval)) {
                                                    if (set_value('sex') == 'Female') {
                                                        echo 'selected';
                                                    }
                                                }
                                                if (!empty($patient->sex)) {
                                                    if ($patient->sex == 'Female') {
                                                        echo 'selected';
                                                    }
                                                }
                                                ?> > Female </option>
                                                <option value="Others" <?php
                                                if (!empty($setval)) {
                                                    if (set_value('sex') == 'Others') {
                                                        echo 'selected';
                                                    }
                                                }
                                                if (!empty($patient->sex)) {
                                                    if ($patient->sex == 'Others') {
                                                        echo 'selected';
                                                    }
                                                }
                                                ?> > <?php echo lang('others'); ?> </option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label><?php echo lang('birth_date'); ?></label>
                                            <input class="form-control form-control-inline input-medium default-date-picker" type="text" name="birthdate" value="<?php
                                            if (!empty($setval)) {
                                                echo set_value('birthdate');
                                            }
                                            if (!empty($patient->birthdate)) {
                                                echo $patient->birthdate;
                                            }
                                            ?>" placeholder="">      
                                        </div>

                                  

                                        <div class="form-group">
                                            <label for="exampleInputEmail1"><?php echo lang('image'); ?></label>
                                            <input type="file" name="img_url">
                                        </div>

                                        <?php if (empty($id)) { ?>

                                            <div class="form-group" style="background-color: transparent;">
                                                <div class="payment_label"> 
                                                </div>
                                                <div class=""> 
                                                    <input type="checkbox" name="sms" value="sms"> <?php echo lang('send_sms') ?><br>
                                                </div>
                                            </div>

                                        <?php } ?>

                                        <input type="hidden" name="id" value='<?php
                                        if (!empty($patient->id)) {
                                            echo $patient->id;
                                        }
                                        ?>'>
                                        <input type="hidden" name="p_id" value='<?php
                                        if (!empty($patient->patient_id)) {
                                            echo $patient->patient_id;
                                        }
                                        ?>'>
                                        <section class="">
                                            <button type="submit" name="submit" class="btn btn-info"><?php echo lang('submit'); ?></button>
                                        </section>
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
