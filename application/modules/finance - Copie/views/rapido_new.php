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
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <div class="top-nav">
            <code id="success" style="display:none" class="flashmessage pull-right"> Paiement SenEau effectué avec succès</code>
        </div>
        <div id="reference" style="display: block">
            <section class="col-md-7">
                <header class="panel-heading">
                    <?php
                    if (!empty($category->id))
                        echo lang('rapido');
                    else
                        echo lang('rapido');
                    ?>
                </header>
                <div class="panel-body">
                    <div class="adv-table editable-table ">
                        <div class="clearfix">
                            <h1>BIENTÔT DISPONIBLE</h1>
                        </div>
                    </div>
                    <div class="form-group col-md-12">
                        <a href="finance/menuService" type="submit" name="submit" class="btn btn-info btn-secondary pull-left"><?php echo lang('submit_retour'); ?></a>
                    </div>
                </div>
            </section>
    </section>
    <input hidden name="invoiceHidden" id="invoiceHidden" type="text" value="">
    <!--main content end-->
    <!--footer start-->
    <script src="https://cdn.jsdelivr.net/npm/autonumeric@4.6.0/dist/autoNumeric.min.js"></script>
    <script>
        $(document).ready(function() {
            var autoNumericInstance = new AutoNumeric.multiple('.money', {
                // currencySymbol: "Fcfa",
                // currencySymbolPlacement: "s",
                // emptyInputBehavior: "min",
                // selectNumberOnly: true,
                // selectOnFocus: true,
                // overrideMinMaxLimits: 'invalid',
                // emptyInputBehavior: "min",
                //     maximumValue : '100000',
                //     minimumValue : "1000",
                decimalPlaces: 0,
                decimalCharacter: ',',
                digitGroupSeparator: '.'
            });
        });
    </script>
    <script src="<?php echo base_url(); ?>common/js/codearistos.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            var formCustmer = $('#formCustmer').val();
            var pin = $('#PIN').val();
            $("#retourInvoice").click(function(e) {
                var reference = document.getElementById('reference');
                var factures = document.getElementById('factures');
                var frais = document.getElementById('frais');

                reference.style['display'] = 'none';
                factures.style['display'] = 'block';
                frais.style['display'] = 'none';
            });
            $("#retourCredit").click(function(e) {
                var reference = document.getElementById('reference');
                var factures = document.getElementById('factures');
                reference.style['display'] = 'block';
                factures.style['display'] = 'none';
            });
            $("#submit").click(function(e) {
                var compteurID = document.getElementById('compteurID');
                var customerReference = $('#customerReference').val();
                var nbreCustomerReference = customerReference.length;
                if (nbreCustomerReference < 4) {
                    compteurID.style['display'] = 'block';
                } else {
                    var reponseAll = invoiceSenEau("fr", customerReference, formCustmer, pin);
                    console.log('-----------reponseAll---------------');
                    console.log(reponseAll);
                }


                e.preventDefault(e);

            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $(".flashmessage").delay(3000).fadeOut(100);
        });
    </script>