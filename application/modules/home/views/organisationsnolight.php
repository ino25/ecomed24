<!--sidebar end-->
<!--main content start-->
<?php
$id = '';
if (isset($_GET['id'])) {
    $id = $_GET['id'];
}
?>
<script src="<?php echo base_url(); ?>common/js/codearistos.min.js"></script>
<section id="main-content">
    <section class="wrapper site-min-height">

        <section class="panel">
            <header class="panel-heading" style="margin-top:41px;">
                <div class="col-md-12 no-print "> 
                    <div class="btn-group pull-left" style="margin-right:5px;">
                       <a data-toggle="modal" href="#myModalAddOrg" readonly disabled>
                        <div class="btn-group pull-right">
                            <button id="" class="btn green btn-xs">
                                <i class="fa fa-plus-circle"></i> <?php echo lang('add'); ?>
                            </button>
                        </div>
                    </a>
                    </div>
                     <div class="btn-group pull-right" style="margin-right:5px;">
                        <button id="" class="btn green btn-xs downloadbutton disabled">
                            <i class="fa fa-plus-circle"></i>&nbsp;Importer
                        </button>
                    </div>
                </div>
               
            </header>
             <div class=""> 
            <h3> <b><?php echo $organisation; ?></b> : Liste des <?php echo lang('organisations'); ?> partenaires</h3>
             </div>
            <div class="panel-body panel-bodyAlt">
                <div class="adv-table editable-table "> 
                    <div class="space15 pull-right">* : A venir</div>	
                    <table class="table table-hover progress-table" id="editable-sample">
                        <thead>
                            <tr>
                                <th style="text-align:left !important;"><?php echo lang('id'); ?></th>

                                <th style="text-align:left !important;">Nom</th>
                                <th style="text-align:left !important;"><?php echo lang('phone'); ?></th>
                                <th style="text-align:left !important;"><?php echo lang('email'); ?></th>
                             
                                <th style="text-align:left !important;">Statut *</th>
                             <th style="text-align:left !important;">Ajout partenaire par l'admin *</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>


                </div>


            </div>
        </section>

    </section>

</section>
<!--main content end-->
<!--footer start-->
<!--footer end-->
</section>
<div class="modal fade" id="myModal2" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Importer la liste des organisations (xls, xlsx) </h4>
            </div>

            <div class="modal-body">

                <form role="form" id="departmentEditForm" class="clearfix" action="home/importOrganisationLight" method="post" enctype="multipart/form-data">

                    <div class="form-group has-feedback">
                        <label for="exampleInputEmail1"> <?php echo lang('choose_file'); ?> rempli</label>
                        <input type="file" class="form-control" placeholder="" name="filename" required accept=".xls, .xlsx ,.csv">
                        <span class="glyphicon glyphicon-file form-control-feedback"></span>
                        <input type="hidden" name="idOrganisationOrigin"value="<?php echo $id; ?>">
                    </div>

                    <section class="">
                        <button type="button" class="btn btn-info btn-secondary pull-left" data-dismiss="modal" aria-hidden="true"> <?php echo lang('close'); ?></button>0
                        <button type="submit" name="submit" class="btn btn-info submit_button pull-right"> <?php echo lang('submit') ?></button>
                    </section>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!-- js placed at the end of the document so the pages load faster -->

<div class="modal fade" id="myModalAddOrg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">  <?php echo lang('add_partenaire'); ?></h4>
            </div>
            <div class="modal-body row">
                <form role="form" action="partenaire/addNew" method="post" class="clearfix" enctype="multipart/form-data">
   
                    <div class="col-md-12 panel">
                        <label for="exampleInputEmail1">  <?php echo lang('liste_partenaire'); ?></label> 
                        <select class="form-control m-bot15" id="spartenaire" name="partenaire" required="">  

                        </select>
                    </div>

                    <input type="hidden"  id="idpartenaire" name="idpartenaire"  value="<?php echo $id; ?>" />
                    <div class="col-md-12 panel">
                        <button type="submit" name="submit" class="btn btn-info pull-right"> <?php echo lang('submit'); ?></button>
                    </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>


<script>
    $(document).ready(function () {
        $(".downloadbutton").click(function (e) {
            e.preventDefault(e);
            // Get the record's ID via attribute  
            $('#myModal2').modal('show');
        });
    });
</script>

<script>

    // alert("before 0");
    $(document).ready(function () {

        var table = $('#editable-sample').DataTable({
            responsive: true,

            "processing": true,
            // "serverSide": true,
            "searchable": true,
            "ajax": {
                url: "home/getOrganisationsnoLight?id=<?php echo $id; ?>",
                type: 'POST',
            },
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
            "order": [[0, "desc"]],
            language: {
                "url": "common/assets/DataTables/languages/<?php echo $this->language; ?>.json?<?php echo time(); ?>",
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
        // alert("after");
        table.buttons().container().appendTo('.custom_buttons');
        table.columns([0]).visible(false);
       
          $("#spartenaire").select2({
            placeholder: '<?php echo lang('select_partenaire'); ?>',
            allowClear: true,
            ajax: {
                 url: 'partenaire/searhPartenaireByAdd',
                type: "post",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        searchTerm: params.term,id:<?php echo $id; ?>
                    };
                },
                processResults: function (response) {
                    return {
                        results: response
                    };
                },
                cache: true
            }

        });
    });
</script>









