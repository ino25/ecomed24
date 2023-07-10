<section id="main-content">
    <section class="wrapper site-min-height">
        <section class="col-md-12">
        
           <div id="div-listePrestationExel" style="display:block">
                 <header class="panel-heading">
                 <?php echo lang('invoice_f'); ?> à <?php echo $destinatairs->nom; ?>

            </header>
          
            <div class="panel-body col-md-12">
                  <section id="main-content-">
    <section class="wrapper site-min-height">
        <section class="col-md-12"  id="body-print" style="background:#fff;">
            <div class="panel panel-primary" id="invoice">
                <div class="panel-body" style="font-size: 10px;">
                    <div class="row invoice-list">
						<div class="col-md-12 invoice_head clearfix">
                            <div class="col-md-4 text-center invoice_head_left">
            <?php if($origins->path_logo){ ?>
                                <img src="<?php echo $origins->path_logo; ?>" style="max-width:180px;max-height:80px;"/>
          <?php   } else { ?>
	                       <img src="uploads/logosPartenaires/default.png" style="max-width:180px;max-height:80px;"/>
            <?php } ?>
                             </div>
                            <div class="col-md-8 text-center invoice_head_right">
                                <h6><?php $origins->description_courte_activite;  ?><h6>
                                <h3 style="margin-top:2px;margin-bottom:2px;">
							<?php echo  $origins->nom  ?>
								</h3>
                                <div><?php echo  $origins->phone;  ?></div>
                                  <div><?php echo $origins->email;  ?></div>
                                <h6 style="text-transform:italic;"><?php echo $origins->slogan;  ?></h6>				
                                <h6> Horaires d'ouverture</h6>
								<p>
			<?php echo $origins->horaires_ouverture;  ?>
								</p>
                            </div>
                        </div>
						<div class="col-md-12 hr_border">
                            <hr>
                        </div>
	
                        <div class="col-md-12 hr_border">
                                          <div class="col-md-12 row details" style="">
                                    <p>
                                     
                                        <label class="control-label"> <?php echo lang('entreprise'); ?> </label>
                                        <span style="text-transform: uppercase;"> : 
                                         
                                         <?php    if (!empty($origins)) {?> 
                                               <?php echo $destinatairs->nom; ?> <br>
                                          <?php   } ?> 
                                          
                                        </span>
                                    </p>
                                </div>
                                <div class="col-md-12 row details" style="">
                                    <p>
                                        <label class="control-label"><?php echo  lang('phone') ?>  </label>
                                        <span style="text-transform: uppercase;"> : 
                                        
                                           <?php  if (!empty($origins)) { ?> 
                                                <?php echo $destinatairs->phone; ?> <br>
                                          <?php   } ?> 
                                           
                                        </span>
                                    </p>
                                </div>
                               
                                           <div class="col-md-12 row details" style="">
                                    <p>
                                        <label class="control-label"><?php echo  lang('email'); ?>  </label>
                                        <span > : 
                                        
                                          <?php   if (!empty($origins)) { ?> 
                                                <?php echo  $destinatairs->email; ?> <br>
                                            <?php } ?> 
                                           
                                        </span>
                                    </p>
                                </div>
                                <div class="col-md-12 row details" style="">
                                    <p>
                                        <label class="control-label"><?php echo lang('address'); ?></label>
                                        <span style="text-transform: uppercase;"> : 
                                          
                                          <?php   if (!empty($origins)) { ?>
                                                <?php echo  $destinatairs->address; ?> <br>
                                          <?php   } ?>
                                           
                                        </span>
                                    </p>
                                </div>
                 
                        </div>
                        <div class="col-md-12">
                            <h4 class="text-center" style="font-weight: bold; margin-top: 20px; text-transform: uppercase;">
                     <?php echo        lang('invoice_f'); ?>
                            </h4>
                        </div>

                        <div class="col-md-12 hr_border">
                            <hr>
                        </div>


                        <div class="col-md-12">
                            <div class="col-md-6 pull-left row" style="text-align: left;">
                                                 <div class="col-md-12 row details" style="">
                                    <p>
                                        <label class="control-label"> <?php echo  lang('number').' '.lang('invoice_f') ?> </label>
                                        <span style="text-transform: uppercase;"> : <?php  echo  $invoice_id; ?>
                                           
                                         
     
                                        </span>
                                    </p>
                                </div>
  <div class="col-md-12 row details" style="">
                                    <p>
                                        <label class="control-label"> <?php echo  lang('date').' '.lang('invoice_f') ?> </label>
                                        <span style="text-transform: uppercase;"> :  <?php  $date_facture = date('d/m/Y'); echo  $date_facture ; ?>
                                           
                                         
     
                                        </span>
                                    </p>
                                </div>

                            </div>

                            <div class="col-md-6 pull-right" style="text-align: left;">


        <div class="col-md-12 row details" style="">
                                    <p>
                                        <label class="control-label"><?php echo  lang('echeance'); ?> </label>
                                        <span style="text-transform: uppercase;"> : 
                                              <?php echo  date('d/m/Y', strtotime(date('Y-m-d').' + 15 DAY')); ?>
                                        </span>
                                    </p>
                                </div>
  <?php if (!empty($deb) && !empty($fin)) { ?>
                                <div class="col-md-12 row details">
                                    <p>
                                        <label class="control-label"><?php echo  lang('periode'); ?>  </label>
                                        <span style="text-transform: uppercase;"> : 
                                          
                                          
                                               <?php echo  date('d/m/Y', strtotime(date('Y-m-d').' + 15 DAY')); ?> <br>
                                          
                                           
                                        </span>
                                    </p>
                                </div>
  <?php } ?>
     
                            </div>

                        </div>






                    </div> 

                    <div class="col-md-12 hr_border">
                        <hr>
                    </div>


                <table class="table table-hover progress-table text-center editable-sample editable-sample-paiement" id="editable-sample-">
                        <thead>
                            <tr> 
                           <th>#</th>
                                  <th><?php echo lang('date'); ?></th>
                                <th><?php echo lang('reference'); ?></th>
                                 <th><?php echo lang('patient'); ?></th>   <th><?php echo lang('payment_procedures'); ?></th>
                                  <th><?php echo lang('amount'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                         <?php
                         $total=0;
                         foreach ($prestations as $prestation) {
                             if (!empty($origins->category_name)) {
                                $category_name = $origins->category_name;
                                $category_name1 = explode(',', $category_name);
                                $i = 0;
                                foreach ($category_name1 as $category_name2) {
                                    $i = $i + 1;
                                    $category_name3 = explode('*', $category_name2);
                                    if ($category_name3[3] > 0 && $category_name3[1]) { ?>
                                        <tr>
                                          <td> <?php echo $i; ?> </td>
                                           <td> <?php echo date('d/m/Y', $prestation->date); ?> </td>
                                             <td> <?php echo $prestation->code.'-'.$category_name3[0]; ?> </td>  <td> <?php echo $prestation->patient_id; ?> </td>
                                           <td> <?php echo $this->finance_model->getPaymentcategoryById($category_name3[0])->prestation; ?></td>
											<?php
											$prix = (($this->db->query("select payment_category_organisation.tarif_professionnel from payment_category_organisation join payment_category on payment_category_organisation.id_presta = payment_category.id and payment_category.id = ".$category_name3[0]))->row())->tarif_professionnel;
											?>
                                           <td class=""> <?php  
											// echo number_format($category_name3[1], 0, ",", ".").' '. $settings->currency; 
											echo number_format($prix, 0, ",", ".").' '. $settings->currency; 
											?>
											</td>
                                        </tr>
                                    <?php 
                                    
                                   // $total =  $total+$category_name3[1];
                                   $total =  $total+$prix;
                                    }
                                }
                            }
                         }
                         ?>

                        
                                      </tbody>
                    </table>

                    <div class="col-md-12 hr_border">
                        <hr>
                    </div>

                    <div class="">
                        <div class="col-lg-4 invoice-block pull-left">
                            <h4></h4>
                        </div>
                    </div>

                    <div class="">
                        <div class="col-lg-4 invoice-block pull-right">
                            <ul class="unstyled amounts">
                            
                             <li><strong><?php echo  lang('grand_total'); ?>: </strong> <?php echo  $total; ?><?php echo  $settings->currency; ?> </li>
                              <li><strong><?php echo  lang('tva'); ?>%: </strong> <?php echo  '0'; ?></li>
                             </ul>
                        </div>
                    </div>
                    
                       <div class="col-md-12 invoice_footer">
                    
                        <div class="row pull-left" style=""> Merci de régler la facture avant échéance  via virement bancaire, zuuluPay, OraneMoney... 
                        </div><br>
                               <div class="row pull-left" style="">
                          <strong><?php echo 'Nous vous remercions de votre fidelité'; ?>  </strong>
                        </div>
                    </div>
                    <div class="col-md-12 invoice_footer">
                        <div class="row pull-right" style="">
                           <strong><?php echo  lang('effectuer_par'); ?> : </strong>
                        </div><br>
                        <div class="row pull-right" style=""><?php echo  $this->ion_auth->user()->row()->first_name .' '.$this->ion_auth->user()->row()->last_name; ?> </div>
                    </div>
                    <div class="col-md-12 hr_border">
                        <hr>
                    </div>
                   
                </div>
                <div class="text-center"> 20 <?php echo date('y'); ?> &copy;  Powered by ecoMed24.
                     </div>
        
            <div class="col-md-12 no-print" style="margin-top: 20px;">
                  <div class="text-center col-md-12 row">
         <a href="partenaire" class="btn btn-info btn-secondary pull-left" >Retour</a>
                    <div class=" col-md-12"> 
                         <span id="btnDownloadGenerik" class="btn btn-info row pull-left"><i class="fa fa-download"></i> <?php echo lang('download'); ?></span>
                          <a class="btn btn-secondary btn-sm invoice_button pull-right" id="btnPrintGenerik"><i class="fa fa-print"></i> <?php echo lang('print'); ?> </a>
                    </div>
                  </div>
                    </div>
                 
          
                 
        </section>
         </section>
       
        
      </section>;
            </div>
               
            
          
          </div>
            </
          <div id="div-importPrestationExel" style="display:none">
     
          </div>
    
            <div class="col-md-12">
                <?php
                $message2 = $this->session->flashdata('message2');
                if (!empty($message2)) {
                    ?>
                    <code class="flash_message pull-right"> <?php echo $message2; ?></code>
                <?php } ?> 
            </div>
        </section>
    </section>
</section>


<style>


    .flash_message{
        padding: 3px;
        text-align: center;
        margin-left: 0px;
        margin-top: 0px;
    }

</style>

<script src="<?php echo base_url(); ?>common/js/ecomed24.min.js"></script>
<!-- #######################################################################-->
<script>
    $(document).ready(function () {

        var table = $('#editable-sample').DataTable({
            responsive: true,
            //   dom: 'lfrBtip',

            "processing": true,
            // "serverSide": true,
            "searchable": true,
            scroller: {
                loadingIndicator: true
            },
            fixedHeader: true,
           dom: "<'row'<'col-sm-4 pull-left'l><'col-sm-4 pull-left'B><'col-sm-4 pull-right'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-5'i><'col-sm-7'p>>",
            buttons: {
                buttons: [
                ],
                dom: {
                    button: {
                        className: 'h4 btn btn-secondary dt-button-custom'
                    }
                    ,
                    buttonLiner: {
                        tag: null
                    }
                }
            },
            lengthMenu: [[10, 25, 50, 100, -1], ['10', '25', '50', '100', 'Tout afficher']],
            iDisplayLength: 10,
            "order": [[1, "desc"]],
            language: {
                // "url": "common/assets/DataTables/languages/<?php echo $this->language; ?>.json",
                processing: "Traitement en cours...",
                search: "_INPUT_",
                lengthMenu: "Afficher _MENU_ &eacute;l&eacute;ments",
                info: "Affichage de l'&eacute;lement _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
                infoEmpty: "Affichage de l'&eacute;lement 0 &agrave; 0 sur 0 &eacute;l&eacute;ments",
                infoFiltered: "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
                infoPostFix: "",
                loadingRecords: "Chargement en cours...",
                zeroRecords: "Aucun &eacute;l&eacute;ment &agrave; afficher",
                emptyTable: "", //emptyTable: "Aucune donnée disponible dans le tableau",
                paginate: {
                    first: "Premier",
                    previous: "Pr&eacute;c&eacute;dent",
                    next: "Suivant",
                    last: "Dernier"
                },
                aria: {
                    sortAscending: ": activer pour trier la colonne par ordre croissant",
                    sortDescending: ": activer pour trier la colonne par ordre décroissant"
                },
                buttons: {
                    pageLength: {
                        _: "Afficher %d éléments",
                        '-1': "Tout afficher"
                    }
                }
            }
        });
        table.buttons().container().appendTo('.custom_buttons');
        //table.columns(0).visible(false);
        $('#modeType').click(function () {
            var typeMode = $('#modeType').val();
            table.columns(0).search(typeMode).draw();
        });


    });

    
 function importPrestationExel() {
$('#div-listePrestationExel').hide();
$('#div-importPrestationExel').show();
 }
  
   function RetourimportPrestationExel() {
$('#div-listePrestationExel').show();
$('#div-importPrestationExel').hide();
 }
 document.getElementById("btnPrintGenerik").onclick = function () {
				printElementNew(document.getElementById("body-print"));
			}
     document.getElementById("btnDownloadGenerik").onclick = function () {
         var name = 'facture-'+new Date().toJSON().slice(0,10).replace(/-/g,'/');
				downloadElementNew('body-print',name);
			} 
</script>

