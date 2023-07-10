<section id="main-content">
    <section class="wrapper site-min-height">
        <section class="col-md-12">
        
           <div id="div-listePrestationExel" style="display:block">
                 <header class="panel-heading">
                 <?php echo lang('confirm_import'); ?>

            </header>
          
            <div class="panel-body col-md-12">
              
                <table class="table table-hover progress-table text-center editable-sample editable-sample-paiement" id="editable-sample">
                        <thead>
                            <tr> 
                           
                                  <th><?php echo lang('service'); ?></th>
                                <th><?php echo lang('procedure'); ?></th>
                                 <th><?php echo lang('options'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                         <?php 
                         if(!empty($prestations)){
                         foreach ($prestations as $prestation) { ?>
                             
                           <tr class="" >
                               
                                <td style="vertical-align:middle;"><?php echo $prestation->name_service; ?></td>   
                                <td style="vertical-align:middle;"> <?php echo $prestation->prestation; ?></td>
                       
  <td class="no-print"><span class="btn btn-info btn-xs editbutton"  onclick="detailParametre(<?php echo $prestation->id_prestation; ?>,'<?php echo $prestation->prestation; ?>')"><i class="fa fa-eye"> </i></span>
                                   </td>
                            
                            </tr>
                         <?php }  } ?>
                        </tbody>
                 </table>
            </div>
               
                 <section class="col-md-12">
                     <a href="finance/paymentCategory" class="btn btn-info btn-secondary pull-left" >Retour</a>
                     <button  class="btn btn-info pull-right" id="add" onclick="importPrestationExel()"> <?php echo lang('submit_continuer'); ?></button>
              
            </section>
          
          </div>
          <div id="div-importPrestationExel" style="display:none">
                 <header class="panel-heading">
                 <?php echo lang('confirm_import'); ?>

            </header>
          
  <div style=""><div class="alert alert-info"><ul><li>Cliquez sur le bouton
          <b>TÉLÉCHARGER LE FICHIER EXCEL DE BASE</b>
          pour télécharger le fichier de base des prestations.</li> <li>Cliquez sur le bouton
          <b>CHARGER LE FICHIER EXCEL REMPLI</b>
          pour charger le fichier déjà rempli.</li></ul></div> 
      <div class="contenu-centre mt-2 mb-5 svelte-1eosvr0">
          <div class="col-md-6 pull-left">
                 <form id="form-para" action="finance/downloadPrestationInfo" method="POST">
                         <?php foreach ($prestations as $prestation) { ?>
                               <input type="hidden" name="id[]"  value='<?php echo $prestation->id_prestation; ?>'> 
                                 <?php }  ?>
          <button  type="submit" neme="submit" class="btn btn-primary m-1" >Télécharger le fichier Excel de base</button>
                </form>   
          </div>
          <div class="col-md-6 pull-right">    <form id="form-para-" action="finance/importPrestationInfo" method="POST" enctype="multipart/form-data">   <input type="file" name="filename" id="filename" accept=".xlsx" required="">
                <button type="submit" name="submit" class="parent-div btn btn-primary m-1" >
      Charger le fichier Excel rempli

    
    </button></form>
              
          
          </div>
                 
         
      
         
        </div>
       
            
          
</div>
               
                 <section class="col-md-12">
                     <button onclick="RetourimportPrestationExel()" class="btn btn-info btn-secondary pull-left" >Retour</button>
                   
            </section>
             
          </div>
           
            <!--
            <div id="confirm-importPrestationExel" style="display:none">
                   <header class="panel-heading">
                 <?php echo lang('download_import'); ?>

            </header>
                  <form role="form" action="<?php echo site_url('finance/importPrestationInfo') ?>" class="clearfix" method="post" enctype="multipart/form-data"> 
                            <div class="box-body">
                                <div class="form-group has-feedback">
                                    <label for="exampleInputEmail1"> <?php echo lang('choose_file'); ?></label>
                                    <input type="file" class="form-control" placeholder="" name="filename" required accept=".xls, .xlsx ,.csv">
                                    <span class="glyphicon glyphicon-file form-control-feedback"></span>
                                    <input type="hidden" name="tablename"value="payment_category">    
                                </div> 

                             <section class="col-md-12">
                     <button class="btn btn-info btn-secondary pull-left" onclick="importPrestationExel()">Retour</button>
                     <button type="submit" name="submit" class="btn btn-info pull-right" id="add-download"><i class="fa  fa-save"></i> <?php echo lang('submit'); ?></button>
              
            </section>   
                            </div>
                        </form>
            </div>  
            -->
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

<div class="modal fade" id="myModaldone" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-paiement">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title myModaldoneTitle" id="myModaldoneTitle">  </h4>
            </div>
            <div class="modal-body" id="modal-body">
                <h3 id="title-checkDone"></h3>
                <div class="single-table">
                    <div class="table-responsive">
                        <table id="dataTable" class="table table-bordered table-hover dataTable">
                            <thead class="text-uppercase">
                                <tr>
                                <th scope="col" >PARAMETRES</th><th scope="col">UNITE</th><th scope="col">NORME</th>
                                </tr>
                            </thead><tbody id="deposit-checkDone">

                            <div class="deposit-checkDone" >  </div>


                            </tbody></table>
                        <form  action="#" id="deposit-checkDepot" class="clearfix" method="post" enctype="multipart/form-data">
                           <table class="col-md-12"> <tr class="form-group   right-six col-md-12"><td  class="col-md-6 pull-left">
                                        <button type="button" class="btn btn-info btn-secondary pull-left" data-dismiss="modal" aria-hidden="true"> <?php echo lang('close'); ?></button>
                                    </td>
                                   </tr></table>
                        </form>

                    </div>
                </div>
            </div>
        </div>  
    </div>
</div>
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
function detailParametre(presta,prestation) {
   
        $('#myModaldone').trigger("reset");
        $('#deposit-checkDone').html('')
        $.ajax({
            url:  'finance/editTproFinanceByJasonParametre?prestation=' + presta,
            method: 'GET',
            data: '',
            dataType: 'json'
        }).success(function (response) {
            var result = '<table>'; var title = '';
           $.each(response.prestations, function (key, value) {
               var uu=''; if(value.unite){ uu = value.unite }
               var uu2=''; if(value.valeurs){ uu2 = value.valeurs }
               result += '<tr><td>'+value.nom_parametre+'</td><td>'+uu+'</td><td>'+uu2+'</td></tr>';
               title = value.name_specialite;
           });
           result += '</table>';
           $('#deposit-checkDone').html(result);
        
$('#title-checkDone').html(' Laboratoire Analyse - ' + title +' - '+prestation);

            $('#myModaldone').modal('show');
        });
    }
    
 function importPrestationExel() {
$('#div-listePrestationExel').hide();
$('#div-importPrestationExel').show();
 }
  
   function RetourimportPrestationExel() {
$('#div-listePrestationExel').show();
$('#div-importPrestationExel').hide();
 }
 
function financeImportPrestationInfo() {
var file = $('#excel')[0].files[0]; console.log(file);
        $.ajax({
            url:  'finance/importPrestationInfo',
            method: 'POST',
            data: file,
            dataType: 'json'
        }).success(function (response) {

        });
}
  function financedownloadPrestationInfo() {
/*var id = $('#id').val(); console.log(id);
        $.ajax({
            url:  'finance/financedownloadPrestationInfo',
            method: 'POST',
            data: id,
            dataType: 'json'
        }).success(function (response) {

        });*/
}  
    
</script>

