<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="col-md-7">
            <header class="panel-heading">
				<h2>
                <?php
                if (!empty($tiers->idPartenariat))
                    echo "Modifier Tiers-Payant"; // Pas pertinent dans ce cas
                else
                    echo "Ajouter un Tiers-Payant";
                ?>
				</h2>
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
							<?php 
							if(count($assurances) == 0) {
							?>
								<span>Pas de nouvelle compagnie d'Assurance disponible actuellement</span>
							<?php
							} else {
							?>
                                <label for="exampleInputEmail1">Assurance</label>
                                <select class="form-control m-bot15" name="assurance" required value=''>
								<?php
								// echo var_dump($setting_services);
								foreach($assurances as $assurance)
								{
								?>
                                    <option value="<?php echo $assurance->id ?>"
									<?php
                                    if (!empty($tiers->idTiersPayant) && $tiers->idTiersPayant == $assurance->id) {
										echo 'selected';
                                    }
									?>
									> 
									<?php echo $assurance->nom; ?> 
									</option> 
								<?php
								}
								?>
                                </select>
							<?php 
							}
							?>
                            </div>
							
                            

                            <input type="hidden" name="id" value='<?php
                            if (!empty($tiers->idPartenariat)) {
                                echo $tiers->idPartenariat;
                            }
                            ?>'>
							<?php $submit_text = empty($tiers->idPartenariat) ? lang('add') : lang('edit'); ?>
                            <div class="form-group col-md-12">
							<a id="" class="btn btn-info btn-secondary pull-left" href="finance/insurance">
								Retour
							</a>
							<?php
							if(count($assurances) != 0) {
							?>
                            <button type="submit" name="submit" class="btn btn-info pull-right"><?php echo $submit_text; ?></button>
							<?php 
							} ?>
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


<script src="<?php echo base_url(); ?>common/js/autoNumeric.min.js"></script>
<!--<script src="https://cdn.jsdelivr.net/npm/autonumeric@4.6.0/dist/autoNumeric.min.js"></script-->

<script>
var autoNumericInstance = new AutoNumeric.multiple('.money', {
    // currencySymbol: "Fcfa",
    // currencySymbolPlacement: "s",
	// emptyInputBehavior: "min",
	selectNumberOnly: true,
	selectOnFocus: true,
	overrideMinMaxLimits: 'invalid',
	emptyInputBehavior: "min",
    maximumValue : '100000',
    minimumValue : "1000",
	decimalPlaces : 0,
    decimalCharacter : ',',
    digitGroupSeparator : '.'
});
</script>
