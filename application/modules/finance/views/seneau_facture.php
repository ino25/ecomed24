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
        .center {
            text-align: center;
        }
</style>
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="panel">
            <header class="panel-heading">
                <?php echo lang('service_seneau') ?>
            </header> 
            <div class="col-lg-12">
                <div class="panel-body">
                <div class="confirmation">
                    <table class="table">
                    <thead>
                        <th>Client</th>
                        <th>Montant facture</th>
                        <th>Numéro facture</th>
                        <th>Délai</th>
                        <th>Action</th>
                    </thead>
                        <tbody>
                        <tr>
                            <td class="center">Prénom Nom</td>
                            <td class="center">10.000 FCFA</td>
                            <td class="center">0 FCFA</td>
                            <td class="center">19/10/2020</td>
                            <td>
                                <button type="submit" name="submit" class="btn-sm  bg-blue"><?php echo lang('payer'); ?></button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <br>
                <form role="form" action="finance/confirmationCredit" method="post" enctype="multipart/form-data">
                    <a name="submit" class="btn" onclick="history.go(-1)" style="background-color:#AEA3A0;color:#ffffff"><?php echo lang('retour'); ?></a>
                    <button type="submit" name="submit" class="btn  bg-blue"><?php echo lang('submit'); ?></button>
                </form>
            </div>
            </div>
        </section>
        <!-- page end-->
    </section>
</section>

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
            <div class="panel-body col-md-12">
                    
        </section>
        <!-- page end-->
    </section>
</section>
<!--main content end-->
<!--footer start-->
