<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="col-md-12">
            <header class="panel-heading">
                <?php
                if (!empty($category->id))
                    echo "Modifier Prestation";
                else
                    echo "Ajouter une Prestation";
                ?>
            </header>
            <div class="panel-body">
                <div class="adv-table editable-table ">
                    <div class="clearfix">
                        <?php echo validation_errors(); ?>
                        <form role="form" action="finance/addPaymentCategory" class="clearfix" method="post" enctype="multipart/form-data">
						
							
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
			<div class="col-md-12">							
                            <div class="form-group col-md-6">
                                <label for="exampleInputEmail1"><?php echo lang('service'); ?></label>
                                <select class="form-control m-bot15" name="service" required value=''>
								<?php
								// echo var_dump($setting_services);
								foreach($setting_services as $service)
								{
								?>
                                    <option value="<?php echo $service->idservice ?>"
									<?php
                                    if (!empty($category->id_service) && $category->id_service == $service->idservice) {
										echo 'selected';
                                    }
									?>
									> 
									<?php echo $service->name_service; ?> 
									</option> 
								<?php
								}
								?>
                                </select>
                            </div>
					
                            <div class="form-group  col-md-6"> 
                                <label for="exampleInputEmail1"><?php echo lang('procedure');  ?></label>
                                <select class="form-control m-bot15" name="prestation" id="prestation" required >
                                    <?php
								
								if($category)
								{
								?>
                                    <option value="<?php echo $category->prestation ?>"
									
									> 
									<?php echo $category->prestation; ?> 
									</option> 
								<?php
								}
								?>
                                    
                                </select>
                            
                            </div> 
  </div>   
                        <div class="col-md-12">		     
                            <div class="form-group  col-md-6">
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
                               
                            <div class="form-group  col-md-6">
                                <label for="exampleInputEmail1"><?php echo lang('price2'); ?> <?php echo lang('public'); ?></label>
                                <input type="text" class="form-control money" name="tarif_public" id="exampleInputEmail1" required value='<?php
                                if (!empty($setval)) {
                                    echo set_value('tarif_public');
                                }
                                if (!empty($category->tarif_public)) {
                                    echo $category->tarif_public;
                                }
                                ?>' placeholder="">
                            </div>
                             </div>   
                            <div class="col-md-12">		
                            <div class="form-group  col-md-6">
                                <label for="exampleInputEmail1"><?php echo lang('price2'); ?> <?php echo lang('pro'); ?></label>
                                <input type="text" class="form-control money" name="tarif_professionnel" id="exampleInputEmail1" value='<?php
                                if (!empty($setval)) {
                                    echo set_value('tarif_professionnel');
                                }
                                if (!empty($category->tarif_professionnel)) {
                                    echo $category->tarif_professionnel;
                                }
                                ?>' placeholder="">
                            </div>
                            <div class="form-group  col-md-6">
                                <label for="exampleInputEmail1"><?php echo lang('price2'); ?> <?php echo lang('insurance'); ?></label>
                                <input type="text" class="form-control money" name="tarif_assurance" id="exampleInputEmail1" value='<?php
                                if (!empty($setval)) {
                                    echo set_value('tarif_assurance');
                                }
                                if (!empty($category->tarif_assurance)) {
                                    echo $category->tarif_assurance;
                                }
                                ?>' placeholder="">
                            </div>
                            </div>  
                       
				
                             <div class="col-md-12">	
                             <div class="form-group  col-md-6">
                                <label for="exampleInputEmail1"><?php echo lang('price2'); ?> <?php echo lang('ipm'); ?></label>
                                <input type="text" class="form-control money" name="tarif_ipm" id="exampleInputEmail1" value='<?php
                                if (!empty($setval)) {
                                    echo set_value('tarif_assurance');
                                }
                                if (!empty($category->tarif_assurance)) {
                                    echo $category->tarif_assurance;
                                }
                                ?>' placeholder="">
                            </div>
                            
                            
                            
                             </div>  
                          

                            <input type="hidden" name="id" value='<?php
                            if (!empty($category->id)) {
                                echo $category->id;
                            }
                            ?>'>
							<?php $submit_text = empty($category->id) ? lang('add') : lang('edit'); ?>
                            <div class="form-group col-md-12">
							<a id="" class="btn btn-info btn-secondary pull-left" href="finance/paymentCategory">
								Retour
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

<script src="<?php echo base_url(); ?>common/js/ecomed24.min.js"></script>
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

var div = document.getElementById('champs');
        function addField() {
            div.innerHTML += '<input type="text" name="titre[]" />' +
                '<input type="text" name="contenu[]" />' +
                '<input type="text" name="description[]" />';
        }
        
         $(document).ready(function () {
      /*  $("#prestation").select2({
            placeholder: 'Selectionnez une prestation',
            allowClear: true,
            ajax: {
                url: 'finance/listePrestationyJason',
                type: "post",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        searchTerm: params.term,service: 1
                    };
                },
                processResults: function (response) {
                    return {
                        results: response
                    };
                },
                cache: true
            }
 }); */
        });      
</script>
