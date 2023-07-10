<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="panel">
            <header class="panel-heading">
                FACTURE POUR <?php echo $nom_partenaire ?>
            </header>
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
                <a class="btn btn-info btn-secondary pull-left" href="partenaire/listeFacturePrestation"><?php echo lang('retour'); ?></a>
                <!-- <a class="btn btn-info btn-sm invoice_button pull-left" href="<?php echo base_url(); ?><?php echo $invoiceNo; ?>" onclick="window.open(this.href, 'PDF', 'height=800, width= 1000, top=100, left=300, toolbar=no, menubar=no, location=no, resizable=yes, scrollbars=no,status=no' );return false;"><i class="fa fa-print"></i>Imprimer</a>
                <a class="btn btn-info btn-xs btn_width" href="<?php echo base_url(); ?><?php echo $invoiceNo; ?>" download> <i class="fa fa-download"></i>Télécharger</a> -->
                <?php if ($is_light == "yes") { ?>
                <a class="btn btn-info btn-xs btn_width" id="transfer" data-id="<?php echo $id_facture ?>" class="btn btn-info green btn-sm">
                    <i class="fa fa-paper-plane"></i> <?php echo lang('transfert'); ?>
                </a><?php } else {?> 
                <form action="partenaire/factureValid" class="clearfix" method="post" enctype="multipart/form-data">
                    <input type="hidden" id="id" name="partenaire" value="<?php echo $id_partenaire ?>">
                    <input type="hidden" id="date_debut" name="date_debut" value="<?php echo $date_debut ?>">
                    <input type="hidden" id="date_fin" name="date_fin" value="<?php echo $date_fin ?>">
                    <input type="hidden" id="code_facture" name="code_facture" value="<?php echo $filename ?>">
                    <button type="submit" style="margin-top: -18px;" name="submit" class="btn btn-info btn-xs btn_width">Enregistrer</button>
                </form>
                <?php }?> 
            </div>
            <div class="">
                
                <input type="hidden" id="id_recap" value="<?php echo $id_partenaire ?>">
                <input type="hidden" id="date_debut_recap" value="<?php echo $date_debut ?>">
                <input type="hidden" id="date_fin_recap" value="<?php echo $date_fin ?>">
                <input type="hidden" id="code_facture_recap" value="<?php echo $filename ?>">
                <input type="hidden"  value="<?php echo $is_light ?>">
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
    <div class="modal fade" id="transferModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title"> <?php echo lang('transfert'); ?> </h4>
                </div>
                <div class="modal-body">
                    <form role="form" id="transferLabReport" action="partenaire/transferFacture" class="clearfix" method="post" enctype="multipart/form-data">

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
                            <input type="hidden" name="code_facture" value='<?php echo $filename; ?>'>
                            <input type="hidden" name="id_facture" value='<?php echo $filename; ?>'>
                            <input type="hidden" name="partenaire" value='<?php echo $id_partenaire; ?>'>
                            <input type="hidden" id="date_debut" name="date_debut" value="<?php echo $date_debut ?>">
                            <input type="hidden" id="date_fin" name="date_fin" value="<?php echo $date_fin ?>">
                            <input type="hidden" name="periode" value='<?php echo $date_debut . ' au ' . $date_fin; ?>'>
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
    <!--main content end-->
    <!--footer start-->




    <!-- Add Patient Material Modal-->

    <!-- Add Patient Modal-->


    <script src="<?php echo base_url(); ?>common/js/codearistos.min.js"></script>

    <script src="/js/pdfobject.js"></script>
    <script></script>

    <script>
        $(document).ready(function() {
            show();
            id = $('#id_recap').val();
            date_debut = $('#date_debut_recap').val();
            date_fin = $('#date_fin_recap').val();
            code_facture = $('#code_facture_recap').val();
            resultat = "";

            $.ajax({
                url: 'partenaire/genererFacturePartenaireDocumente?id=' + id + '&date_debut=' + date_debut + '&date_fin=' + date_fin,
                method: 'GET',
                data: '',
                dataType: 'json',
            }).success(function(response) {
                // Populate the form fields with the data returned from server
                console.log('*** RESPONSE FACTURE ****');
                console.log(response);
                resultatFinal = JSON.stringify(response);
                resultat = JSON.stringify(response, null, 2);
                //  const container = document.querySelector('.responseJson');
                //  container.innerText = JSON.stringify(response, null, 2);
                id_facture = code_facture;
                var options = {
                    url: "finance/genererDocumentFacture",
                    dataType: "json",
                    type: "POST",
                    data: {
                        test: JSON.stringify(resultatFinal),
                        idpayment: id_facture,
                    }, // Our valid JSON string
                    success: function(data, status, xhr) {
                        hide();
                        PDFObject.embed("<?php echo base_url(); ?>uploads/invoicefile/" + data, "#example2");
                        //...
                    },
                    error: function(xhr, status, error) {
                        //...
                    }
                };
                $.ajax(options);

            });

        });
    </script>
    <script type="text/javascript">
        function show() {
            document.getElementById("myDiv").style.display = "block";
            document.getElementById("buttonAction").style.display = "none";
            setTimeout("hide()", 10000); // 5 seconds
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