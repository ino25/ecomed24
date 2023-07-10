Payment<!--sidebar end-->
<!--main content start-->



<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="panel">
            <header class="panel-heading"><?php echo lang('list_facture') . ' pour :' . $destinatairs; ?>
            </header>
            <div class="panel-body">
                  <form  action="partenaire/genereFactures" id="genereFactures" class="clearfix" method="post" enctype="multipart/form-data">
                <div class="adv-table editable-table "> 
                    <div class="space15">  <button type="submit" name="submit" class="btn btn-info pull-left" id="add"><?php echo lang('selection'); ?> </button></div>
                    <table class="table table-hover progress-table text-center" id="dataTable-liste">
                        <thead>
                            <tr>
                                <th style="text-align:center;"><input type="checkbox" name="select_all" value="1" id="select_all"></th>
                                <th style="text-align:center;"><?php echo lang('date_commande'); ?></th>
                                <th style="text-align:center;"><?php echo lang('number'); ?></th>
                                <th style="text-align:center;"><?php echo lang('amount'); ?></th>
                                <th style="text-align:center;"><?php echo lang('Status'); ?></th>
                                <th style="text-align:center;"><?php echo lang('options'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($listeCommandes as $key => $commande) { ?>
                                <tr class="" >
                                    <td style="vertical-align:middle;"><?php echo $commande[6]; ?> </td>
                                    <td style="vertical-align:middle;"><?php echo $commande[1]; ?></td>   
                                    <td style="vertical-align:middle;"> <?php echo $commande[2]; ?></td>
                                    <td style="vertical-align:middle;"> <?php echo $commande[3]; ?></td>
                                    <td style="vertical-align:middle;"> <?php echo $commande[4]; ?></td>
                                    <td style="vertical-align:middle;"> <?php echo $commande[5]; ?></td>

                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                   </form>     
                <a id="" class="btn btn-info btn-secondary pull-left" href="partenaire/relation">
                    Retour
                </a>
            </div>
        </section>
        <!-- page end-->
    </section>
</section>

<div class="modal fade" id="sttChangeModal"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog ">
        <div class="modal-content" id="sttChangeModalHtml" >

        </div>
    </div>
</div>

<!--main content end-->
<!--footer start-->

<script src="<?php echo base_url(); ?>common/js/ecomed24.min.js"></script>
<script>
    function paybutton(payment) {
        $.ajax({
            url: 'partenaire/paybutton?id=' + payment,
            method: 'GET',
            data: '',
            dataType: 'json'
        }).success(function (response) {
            if (response) {

                $('#sttChangeModal').trigger("reset");
                $('#sttChangeModalHtml').empty().html(response);
                $('#sttChangeModal').modal('show');

            }
        });
    }
    $(document).ready(function () {
  var table2 = $('#dataTable-liste').DataTable({
            responsive: true,
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
              buttons: [  {
                        // extend: 'excelHtml5',
                        // className: 'dt-button-icon-left dt-button-icon-excel',
                        // exportOptions: {
                            // columns: [0, 1, 2, 3, 4, 5],
                        // }
                    // },
                    // {
                        // extend: 'pdfHtml5',
                        // className: 'dt-button-icon-left dt-button-icon-pdf',
                        // exportOptions: {
                            // columns: [0, 1, 2, 3, 4, 5],
                        // }
                    // },
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
              
 'columnDefs': [{
         'targets': 0,
         'searchable': false,
         'orderable': false,
         'className': 'dt-body-center',
         'render': function (data, type, full, meta){
             return '<input type="checkbox" name="id[]" value="' + $('<div/>').text(data).html() + '"> ';
         }        
      }],
              select: {
            style:    'os',
            selector: 'td:first-child'
        },
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
        table2.buttons().container().appendTo('.custom_buttons');
        
         $('#select_all').on('click', function(){
      // Get all rows with search applied
      var rows = table2.rows({ 'search': 'applied' }).nodes();
      // Check/uncheck checkboxes for all rows in the table
      $('input[type="checkbox"]', rows).prop('checked', this.checked);
   });
   
   // Handle click on checkbox to set state of "Select all" control
   $('#dataTable-liste tbody').on('change', 'input[type="checkbox"]', function(){
      // If checkbox is not checked
      if(!this.checked){
         var el = $('#select_all').get(0);
        var tt = 0;
         if(el && el.checked && ('indeterminate' in el)){
           tt++;
            el.indeterminate = true;
         }
 
      }
   });
   
   
    });
</script>