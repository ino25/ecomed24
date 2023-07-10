<section id="main-content">
    <section class="wrapper site-min-height">
        <section class="col-md-12">


            <div id="div-importPrestationExel" >
                <header class="panel-heading">
                    <?php echo lang('confirm_import'); ?>

                </header>
                <div class="biz-container svelte-1s990je"><h2 class="svelte-1s990je">Import fichier</h2> 
                  
                    </div> 
                    <div class="boutons-selection svelte-1s990je" style="">
                        <div class="col-md-6 pull-left"><p>Choisissez cette option si vous voulez fournir vous-même les
                                prestations</p>
                      <form id="form-para-" action="finance/importPrestationInfo" method="POST" enctype="multipart/form-data">   <input type="file" name="filename" id="filename" accept=".xlsx" required="">
                <button type="submit" name="submit" class="parent-div btn btn-primary m-1" >
      Charger le fichier Excel rempli

    
    </button></form>
                        
                        </div>
                        <div class="col-md-6 pull-right">  <p>Avec cette option, ecoMed24 générera automatique des prestations</p>
                            
                            <a href="files/downloads/prestation.xls" target="download" class="btn btn-light svelte-1s990je"><i class="fa fa-download"></i> 
                            <span>Télécharger le fichier de référence</span></a>
                            
                        </div>
                        </div>
                   
                               
                                   
                                        
                </div>


               <section class="col-md-12">
                     <a href="finance/paymentCategory" class="btn btn-info btn-secondary pull-left" >Retour</a>
                  
            </section>

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

                        });

</script>

