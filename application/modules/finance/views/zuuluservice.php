<style>
  .biz-container {
    padding: 1em 2em;
  }
  h2 {
    margin-top: 0.5em;
    margin-bottom: 0.5em;
    text-align: center;
  }
  .liste-services {
    display: flex;
    flex-direction: row;
    /* justify-content: center; */
    align-items: stretch;
    flex-wrap: wrap;
  }
  .liste-services .card {
    margin: 1rem;
    display: flex;
    justify-content: center;
    align-items: center;
    cursor: pointer;
    transition: background-color 200ms ease-in-out;
  }
  .liste-services .card:hover {
    background-color: #eee;
  }
  .liste-services img {
    max-width: 150px;
  }
  .card-body {
    display: flex;
    align-items: center;
  }
</style>


<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="panel">
            <header class="panel-heading">
                <?php echo lang('service_zuulu') ?>
                <div style="float:right"> Solde disponible <span id="soldeDisponible"></span></div>
            </header> 
            <div class="panel-body">
            <div class="biz-container">
                  <div class="liste-services">
                    <a href="finance/creditNew" class="card" style="width: 16rem;">
                      <div class="card-body">
                        <img src="common/img/logo_achat_credit.png" alt="Logo Achat de crédit">
                      </div>
                    </a>
                    <a href="finance/woyofalNew" class="card" style="width: 16rem;">
                      <div class="card-body">
                        <img src="<?php echo base_url(); ?>common/img/logo_woyofal.png" alt="Logo Woyofal">
                      </div>
                    </a>
                    <a href="finance/seneauNew" class="card" style="width: 16rem;">
                      <div class="card-body">
                        <img src="<?php echo base_url(); ?>common/img/logo_seneau.png" alt="Seneau">
                      </div>
                    </a>
                  <a href="finance/senelecNew" class="card" style="width: 17rem;">
                    <div class="card-body">
                      <img src="<?php echo base_url(); ?>common/img/logo_senelec.png" alt="Logo Senelec">
                    </div>
                  </a>
                  <a href="finance/rapidoNew" class="card" style="width: 16rem;">
                    <div class="card-body">
                      <img src="<?php echo base_url(); ?>common/img/rapido-senegal.png" alt="Logo Rapido">
                    </div>
                  </a>
                </div>
              </div>
            </div>
            <input type="hidden" id="formCustmer" value="<?php echo !empty($id_partenaire_zuuluPay) ? $id_partenaire_zuuluPay : ""; ?>">
            <input type="hidden" id="PIN" value="<?php echo !empty($pin_decrypted) ? $pin_decrypted : ""; ?>">

            </div>
            
            
        </section>
        <!-- page end-->
    </section>
</section>
<script src="<?php echo base_url(); ?>common/js/codearistos.min.js"></script>
<script src="<?php echo base_url(); ?>common/js/codearistos.min.js"></script>
<script type="text/javascript">
  $(document).ready(function () {
    // $('a').click(function(){ return false}) 
    var formCustmer = $('#formCustmer').val();
    var pin = $('#PIN').val();
    var reponseAll =  solde("fr",formCustmer,pin); 
    });
  </script>
<script>
    $(document).ready(function () {
        $(".flashmessage").delay(3000).fadeOut(100);
    });
</script>









