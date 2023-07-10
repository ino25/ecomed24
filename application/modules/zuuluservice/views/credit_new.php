<style>
        input[type=number] {
            -moz-appearance: textfield;
        }

        /* Chrome */
        input::-webkit-inner-spin-button,
        input::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Opéra*/
        input::-o-inner-spin-button,
        input::-o-outer-spin-button {
            -o-appearance: none;
            margin: 0
        }
</style>


<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="panel">
            <header class="panel-heading">
                <?php
                if (!empty($patient->id))
                 echo '  <h4 style="color: #303f9f;margin-bottom: 10px;">'.  lang('service_credit').'  </h4>';
                else
                    echo '<h4 style="color: #303f9f;margin-bottom: 10px;">'. lang('service_credit'). ' </h4>';
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
                                           <div class="form-group">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1"><?php echo lang('phoneNumber'); ?><span class="fa fa-star label-required"></span></label>
                                            <input type="tel" class="form-control" name="mobNo" id="mobNo" value="" placeholder=""
                                            pattern="[0-9]{9}" required autocompleted="off">
                                            <small class="form-text text-muted">Format requis 786485686.
                                            </small>
                                        </div>
                                         <div class="form-group">
                                             <label><?php echo lang('amountService'); ?><span class="fa fa-star label-required"></span></label>
                                            <input class="form-control" type="number" name="amount" id="amount"  min="100" max="100000" value="" placeholder="" required autocompleted="off">      
                                        </div>
                                        <a href="zuuluservice" type="submit" name="submit" class="btn" style="background-color:#AEA3A0;color:#ffffff"><?php echo lang('retour'); ?></a>
                                        <button name="submit" id="submit" class="btn  bg-blue"><?php echo lang('submit'); ?></button>
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

<script src="<?php echo base_url(); ?>common/js/codearistos.min.js"></script>
<script type="text/javascript">
  $(document).ready(function () {
   $("#submit").click(function (e) {
       var phone = $('#mobNo').val();
                var amount = $('#amount').val();
       var reponse =  loadDons("fr",phone,amount);
        
            e.preventDefault(e);
          
            $.ajax({
                url: 'finance/confirmationCredit',
                method: 'POST',
                data: reponse,
                dataType: 'json',
            }).success(function (response) {
               
            });
        });
   
    });
  </script>


