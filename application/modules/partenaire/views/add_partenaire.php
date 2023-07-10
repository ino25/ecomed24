<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="col-md-7">
            <header class="panel-heading">
                <?php
                if (!empty($tiers->idPartenariat))
                    echo "Modifier Tiers-Payant"; // Pas pertinent dans ce cas
                else
                    echo "Ajouter un Tiers-Payant";
                ?>
            </header>
            <div class="panel-body">
                <div class="adv-table editable-table ">
                    <div class="clearfix">
                        <?php echo validation_errors(); ?>
                        <form role="form" action="finance/addInsurance" class="clearfix" method="post" enctype="multipart/form-data">
						
							
							<?php
								// echo set_value('id_service');
								// echo set_value('service');
								// echo var_dump($setval);
								// echo var_dump($setting_services);
							?>
							
							<?php
								// echo var_dump($setting_services);
								// foreach($setting_services as $service)
								// {
							
                                    // echo $service->idservice;
                                    // echo $service->name_service;
			
								// }
								?>
								
                            <div class="form-group">
							
                                <label for="exampleInputEmail1">Assurance</label>
                                <select class="form-control m-bot15" name="assurance" require 
						
                                </select>
							
                            </div>
							
                            

                            <input type="hidden" name="id" value='<?php
                            if (!empty($tiers->idPartenariat)) {
                                echo $tiers->idPartenariat;
                            }
                            ?>'>
							<?php $submit_text = empty($tiers->idPartenariat) ? lang('add') : lang('edit'); ?>
                            <div class="form-group col-md-12">
							<a id="" class="btn btn-info btn-secondary pull-left" href="finance/insurance">
								<?php echo lang('close'); ?>
							</a>
							
                            <button type="submit" name="submit" class="btn btn-info pull-right"><?php echo $submit_text; ?></button>
							
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


