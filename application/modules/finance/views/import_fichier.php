<section id="main-content">
    <section class="wrapper site-min-height">
        <section class="col-md-12">
            <header class="panel-heading">
                 <?php echo lang('bulk_create_payment_procedure'); ?> (xls, xlsx)

            </header>
            <div class="panel-body col-md-12">
                <div class="col-md-6">
                    <blockquote>
                        <a href="files/downloads/prestation_xl_format.xlsx"><?php echo lang('download'); ?> le fichier modèle des prestations</a>.
                        <br> <?php echo lang('please_follow_the_exact_format'); ?>. 
                    </blockquote>
                </div>
                <!-- left column -->
                <div class="col-md-6">
                    <!-- general form elements -->
                    <div class="box box-primary">
                        <!-- form start -->
                        <form role="form" action="<?php echo site_url('finance/importPrestationInfo') ?>" class="clearfix" method="post" enctype="multipart/form-data"> 
                            <div class="box-body">
                                <div class="form-group has-feedback">
                                    <label for="exampleInputEmail1"> <?php echo lang('choose_file'); ?></label>
                                    <input type="file" class="form-control" placeholder="" name="filename" required accept=".xls, .xlsx ,.csv"> <button type="submit" name="submit" class="btn btn-info pull-right">Confirmer</button>
                                    <span class="glyphicon glyphicon-file form-control-feedback"></span>
                                    <input type="hidden" name="tablename"value="payment_category">    
                                </div> 

                              
                            </div>
                        </form>
                    </div>
                </div>

            </div>
          <!--  -->
          
            <section class="col-md-12"><a id="" class="btn btn-info btn-secondary pull-left" href="finance/paymentCategory">Retour</a> </section>
           
        </section>
    </section>
</section>




<script src="<?php echo base_url(); ?>common/js/ecomed24.min.js"></script>
<!-- #######################################################################-->
<script>
    $(document).ready(function () {

  
    });

</script>

