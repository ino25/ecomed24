
    $(document).ready(function () {
        $(".editbutton").click(function (e) {
            e.preventDefault(e);
            // Get the record's ID via attribute  
            var iid = $(this).attr('data-id');
            $.ajax({
                url: 'service/editServiceByJason?id=' + iid,
                method: 'GET',
                data: '',
                dataType: 'json',
            }).success(function (response) {
                // Populate the form fields with the data returned from server
                $('#serviceEditForm').find('[name="id"]').val(response.service.idservice).end()
                $('#serviceEditForm').find('[name="name"]').val(response.service.name_service).end()
                $('#serviceEditForm').find('[name="department"]').val(response.service.name_department).end()
                $('#serviceEditForm').find('[name="description"]').val(response.service.name_description).end()
            
            CKEDITOR.instances['editor'].setData(response.department.description_department)
                $('#myModal2').modal('show');
            });
        });
                                      
        var aujourdhui = new Date(); 
	var annee = aujourdhui.getFullYear(); // retourne le millésime
	var mois =aujourdhui.getMonth()+1; // date.getMonth retourne un entier entre 0 et 11 donc il faut ajouter 1
	var jour = aujourdhui.getDate(); // retourne le jour (1à 31)
        var joursemaine = aujourdhui.getDay() ;
        var heure = aujourdhui.getHours();
        var minute = aujourdhui.getMinutes();
        var seconde = aujourdhui.getSeconds();
	var tab_jour=new Array("Dimanche", "Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi");
	var dateExport = tab_jour[joursemaine] + ' ' + jour + '/' + mois + '/' + annee + ' à ' + heure + 'h:' + minute + 'min';
        var fin = jour + '_' + mois + '_' + annee + '_' + heure + 'h' + minute;
        
        var table = $('#editable-sample').DataTable({
            responsive: true,

            dom: 'Bfrtip',
            buttons: [
                 {extend:'pageLength',text: 'Afficher 10 éléments'},
                {extend: 'excelHtml5',orientation: 'landscape',exportOptions: { columns: [0,1]},text: '<span class="size12"><i class="fa fa-file-excel-o"></i> Excel</span>', messageTop: 'Date export :' + dateExport, title: 'liste des departements', filename: 'liste-des-departements-' + fin, footer: true, },
                {extend: 'pdfHtml5',orientation: 'landscape', exportOptions: { columns: [0,1]},text: '<span class="size12"><i class="fa fa-file-pdf-o"></i> Pdf</span>', messageTop: 'Date export :' + dateExport, title: 'liste des departements', filename: 'liste-des-departements-' + fin, footer: true,  },
                {extend: 'print',orientation: 'landscape', exportOptions: { columns: [0,1]}, text: '<span class="size12"><i class="fa fa-print "></i> Imprimer</span>', messageTop: 'Date export :' + dateExport, title: 'liste des departements', filename: 'liste-des-departements-' + fin, footer: true, }

            ],

            aLengthMenu: [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, "All"]
            ],
            iDisplayLength: -1,
            "order": [[0, "desc"]],

            "language": {
                "lengthMenu": "_MENU_",
                search: "_INPUT_",
                "url": "common/assets/DataTables/languages/french.json"
            }
        });
        table.buttons().container().appendTo('.custom_buttons');
    });

