<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="panel">
            <header class="panel-heading">
                PAIEMENT DE FACTURE 
            </header>
            <?php if($code_paiement == "oui"){ ?>
            <h3>Paiement effectué par <?php echo $payer_par ?> le <?php echo $date_paiement ?></h3>
            <?php   } ?>
            <!-- <div id="my-container" class="ng-scope pdfobject-container">
                <iframe src="" type="application/pdf" width="100%" height="100%" style="overflow: auto;">
                </iframe>
            </div> -->
            <center>
                <div id="myDiv" style="display:none">
                    <img id="myImage" src="<?php echo base_url(); ?>uploads/invoicefile/loading-waiting.gif">
                    <br>
                    <br><br><br>
                </div>
            </center>

            <div id="example2"></div>
            <div id="buttonAction" class="col-md-8">
                <a class="btn btn-info btn-secondary pull-left" href="partenaire/factures"><?php echo lang('retour'); ?></a>
                <!-- <a class="btn btn-info btn-sm invoice_button pull-left" href="<?php echo base_url(); ?>uploads/invoicefile/<?php echo $code_facture; ?>.pdf" onclick="window.open(this.href, 'PDF', 'height=800, width= 1000, top=100, left=300, toolbar=no, menubar=no, location=no, resizable=yes, scrollbars=no,status=no' );return false;"><i class="fa fa-print"></i>Imprimer</a>
                <a class="btn btn-info btn-xs btn_width" href="<?php echo base_url(); ?>uploads/invoicefile/<?php echo $code_facture; ?>.pdf" download> <i class="fa fa-download"></i>Télécharger</a> -->
                <!-- <a class="btn btn-info btn-xs btn_width" id="transfer" data-id="<?php echo $id_facture ?>" class="btn btn-info green btn-sm">
                            <i class="fa fa-paper-plane"></i> <?php echo lang('transfert');?>
            </a> -->
                
                        <input type="hidden" id="id" name="partenaire" value="<?php echo $id_partenaire ?>">
                        <input type="hidden" id="date_debut" name="date_debut" value="<?php echo $date_debut ?>">
                        <input type="hidden" id="date_fin" name="date_fin" value="<?php echo $date_fin ?>">
                        <input type="hidden" id="code_facture" name="code_facture" value="<?php echo $code_facture ?>">
                        <?php if($is_partenaire == "true" && $code_paiement != "oui"){ ?>
                            <a class="btn btn-info btn_width btn-xs" data-toggle="modal" href="#myModal1">
                                            <i class="fa fa-plus-circle"> </i> PAYER
                                        </a>
                        <?php   } else { ?>
                            <a class="btn btn-info btn-xs btn_width" id="transfer" data-id="<?php echo $id_facture ?>" class="btn btn-info green btn-sm">
                            <i class="fa fa-paper-plane"></i> <?php echo lang('transfert');?>
            </a>
                            <?php   } ?>
                
            </div>
            <div class="">

                <input type="hidden" id="id_recap" value="<?php echo $id_partenaire ?>">
                <input type="hidden" id="date_debut_recap" value="<?php echo $date_debut ?>">
                <input type="hidden" id="date_fin_recap" value="<?php echo $date_fin ?>">

                <div class="container">
                    <div class="panel panel-default">
                        <div class="responseJson" class="panel-body" style=" white-space: break-spaces;
                    font-family: monospace;
                    font-size: 12px;
                    color: brown;"></div>
                    </div>
                </div>

            </div>

            <style>
                table,
                th,
                td {
                    border: 1px solid #f1f2f7;
                    border-collapse: collapse;
                }

                th,
                td {
                    padding: 2px;
                    text-align: left;
                    font-size: 12px;
                }

                ul li {
                    list-style: square;
                }

                .pdfobject-container {
                    height: 55rem;
                    border: 1rem solid rgba(0, 0, 0, .1);
                }
            </style>
        </section>
    </section>
    <div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"> Paiement Facture <?php echo $code_facture; ?> </h4>
            </div>
            <div class="modal-body">
                <form role="form" action="partenaire/paiementFacture" class="clearfix row" method="post" enctype="multipart/form-data">
                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1">Moyen de paiement</label>
                        <select class="form-control m-bot15 js-example-basic-multiple templates" id="templates" name="canal_paiement" value=''>
                            <option value="Argent en espèce">Argent en espèce</option>
                            <option value="Virement">Virement Bancaire</option>
                            <option value="Orange Money">Orange Money</option>
                            <option value="Wave">Wave</option>
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"> Montant </label>
                        <input type="text" class="form-control" name="amount" value="<?php echo $amount; ?>" id="exampleInputEmail1" readonly>
                    </div>
                    <div class="form-group col-md-8">
                        <label for="exampleInputEmail1"> Référence de paiement </label>
                        <input type="text" class="form-control" name="reference" value="" id="reference">
                    </div>
                    <input type="hidden" name="code_facture" value='<?php echo $code_facture; ?>'>
                    <input type="hidden" name="id_facture" value='<?php echo $id_facture; ?>'>
                    <input type="hidden" name="statut" value='Payer'>
                    <div class="form-group col-md-12">
                        <button type="button" class="btn btn-info btn-secondary pull-left" data-dismiss="modal" aria-hidden="true"> <?php echo lang('close'); ?></button>
                        <button type="submit" name="submit" class="btn btn-info pull-right"> <?php echo lang('submit'); ?></button>
                    </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!-- Add Patient Modal-->
<div class="modal fade" id="transferModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"> <?php echo lang('transfert'); ?> </h4>
            </div>
            <div class="modal-body">
                <form role="form" id="transferLabReport" action="partenaire/transferFacturePayer" class="clearfix" method="post" enctype="multipart/form-data">
                    <div class="form-group col-md-12">
                        <label class="radio-inline"><input type="radio" class="medium" name="medium" value='email' checked><?php echo lang('email'); ?></label>
                        <label class="radio-inline"><input type="radio" class="medium" name="medium" value='whatsapp' disabled><?php echo lang('whatsapp'); ?> (Bientôt Disponible)</label>
                    </div>
                    <div class="form-group col-md-12 whatsapp hidden">
                        <label for="exampleInputEmail1"> <?php echo lang('whatsapp_number'); ?><span></span></label>
                        <input type="number" class="form-control" name="whatsapp" id="what_num" value="<?php echo $patient->phone; ?>" placeholder="">
                    </div>
                    <div class="form-group col-md-12 email_div">
                        <label for="exampleInputEmail1"> <?php echo lang('email'); ?></label>
                        <input type="email" class="form-control" name="email" id="email_id" value="<?php if (!empty($email_light)) {
                                                                                                        echo $email_light;
                                                                                                    }
                                                                                                    ?>" placeholder="" required="">
                        <input type="hidden" name="code_facture" value='<?php echo $code_facture; ?>'>
                        <input type="hidden" name="id_facture" value='<?php echo $id_facture; ?>'>
                        <input type="hidden" name="partenaire" value='<?php echo $id_partenaire; ?>'>
                        <input type="hidden" name="periode" value='<?php echo $date_debut.' au '.$date_fin; ?>'>
                    </div>
                    <input type="hidden" name="report_id" value="<?php echo $payments->id; ?>">
                    <div class="form-group">
                        <button type="submit" name="submit" class="btn btn-info pull-right"> <?php echo lang('submit'); ?></button>
                    </div>
                </form>

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
    <!--main content end-->
    <!--footer start-->




    <!-- Add Patient Material Modal-->

    <!-- Add Patient Modal-->


    <script src="<?php echo base_url(); ?>common/js/codearistos.min.js"></script>

    <script src="/js/pdfobject.js"></script>
    <script type="text/javascript">
    $(document).ready(function() {
        $(document.body).on('change', '#templates', function() {

            var iid = $("select.templates option:selected").val();
            if(iid != "Argent en espèce"){
                $('#reference').prop('required', true);
            }else {
                $('#reference').prop('required', false);
            }
        });
    });
</script>

    <script>
        $(document).ready(function() {
            show();
            id = $('#code_facture').val();
            PDFObject.embed("<?php echo base_url(); ?>uploads/invoicefile/" + id +".pdf", "#example2");
        });
    </script>
    <script type="text/javascript">
        function show() {
            document.getElementById("myDiv").style.display = "block";
            document.getElementById("buttonAction").style.display = "none";
            setTimeout("hide()", 1000); // 5 seconds
        }

        function hide() {
            document.getElementById("myDiv").style.display = "none";
            document.getElementById("buttonAction").style.display = "block";
        }
    </script>
    <script>
    $(document).ready(function() {
        $('#transfer').on('click', function() {
            var id = $(this).attr('data-id');
            $('#transferModal').modal('show');
        });

    });
</script>