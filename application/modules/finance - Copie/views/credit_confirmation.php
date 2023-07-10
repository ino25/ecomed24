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
        .confirmation {
            padding: 1rem 3rem;
        }
</style>


<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="col-md-7">
            <header class="panel-heading">
                <?php
                if (!empty($category->id))
                    echo lang('service_credit');
                else
                    echo lang('service_credit');
                ?>
            </header>
            <div class="panel-body">
                <?php echo validation_errors(); ?>
                <form role="form" action="finance/confirmationCredit" class="clearfix" method="post" enctype="multipart/form-data">
                    <div class="col-md-12 qfloww">
                        <label class="col-md-8 pull-left remove1">Numéro de Téléphone</label>
                        <label class="col-md-4 pull-right remove1">781156335</label>
                        <label class="col-md-8 pull-left remove1">Montant</label>
                        <label class="col-md-4 pull-right remove1">1.000 FCFA</label>
                        <label class="col-md-8 pull-left remove1">Frais</label>
                        <label class="col-md-4 pull-right remove1">0 FCFA</label>
                        <label class="col-md-8 pull-left remove1">Total</label>
                        <label class="col-md-4 pull-right remove1">1.000 FCFA</label>
                        <div class="form-group col-md-12" style="padding-top:20px">
                            <button type="submit" name="submit" class="btn btn-info pull-right"><?php echo lang('submit'); ?></button>
                        </div>
                    </div>
                   
                </form>
            </div>
        </section>
        <!-- page end-->
    </section>
</section>
