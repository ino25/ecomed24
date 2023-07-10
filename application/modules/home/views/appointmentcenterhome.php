<!--sidebar end-->
<!--main content start-->
<script type="text/javascript" src="<?php echo base_url(); ?>common/js/google-loader.js"></script>

<script src="<?php echo base_url(); ?>common/js/codearistos.min.js"></script>
<section id="main-content">
    <section class="wrapper site-min-height">
		<section class="panel">
                            <header class="panel-heading">
                                Liste des <?php echo lang('organisations'); ?>
                            </header>
                            <div class="panel-body">
								<div class="adv-table editable-table "> 
									<div class="space15"></div>	
                                        <table class="table table-hover progress-table text-center" id="editable-sample">
                                            <thead>
												<tr>
													<!--<th style="text-align:left !important;"><?php //echo lang('id'); ?></th>-->
													<!--<th style="text-align:left !important;">Code</th>-->
													<th style="text-align:left !important;width:10px !important;"><?php echo lang('logo'); ?></th>
													<th style="text-align:left !important;">Nom</th>
													<th style="text-align:left !important;">Type</th>
													<!--<th style="text-align:left !important;">Creation</th>
													<th style="text-align:left !important;">Mise à jour</th>-->
													<!--<th style="text-align:left !important;">PIN</th>-->
													<!--<th style="text-align:left !important;">Tel. Fixe</th>-->
													<th style="text-align:left !important;">Adresse</th>
													<th style="text-align:left !important;">Responsable Legal</th>
													<!--<th style="text-align:left !important;">Tel. Responsable</th>-->
													<th style="text-align:left !important;">Statut</th>
													<th class="no-print" style="text-align:left !important;">Actions</th>
												</tr>
											</thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    

                                </div>


                            </div>
                        </section>
    </section>
	<style>

            table{
                box-shadow: none;
            }

            .fc-head{

                box-shadow: 0 2px 5px 0 rgba(0, 0, 0, .16), 0 2px 10px 0 rgba(0, 0, 0, .12);

            }

            .panel-body{
                background: #fff;
            }

            thead{
                background: #fff;
            }

            .panel-body {
                background: #fff;
            }

            .state-overview .panel-heading {
                border-radius: 0px;
                background: #fff !important;
                color: #000;
                padding-left: 10px;
                font-size: 13px !important;
                margin-top: 3px;
                text-align: center;
            }

            .add_patient{
                background: #009988;
            }

            .add_appointment{
                background: #f8d347;
            }

            .add_prescription{
                background: blue;
            }

            .add_lab_report{

            }

            .y-axis li span {
                display: block;
                margin: -20px 0 0 -25px;
                padding: 0 20px;
                width: 40px;
            }

            .sale_color{
                background: #69D2E7 !important;
                padding: 10px !important;
                font-size: 5px;
                margin-right: 10px;
            }

            .expense_color{
                background: #F38630 !important;
                padding: 10px !important;
                font-size: 5px;
                margin-right: 10px;
            }

            audio, canvas, progress, video {
                display: inline-block;
                vertical-align: baseline;
                width: 100% !important;
                height: 101% !important;
                margin-bottom: 18%;
            }  


            .panel-heading{
                margin-top: 0px;
            }


        </style>
</section>
<!--main content end-->
<!--footer start-->
<!--footer end-->
</section>

<!-- js placed at the end of the document so the pages load faster -->

<script type="text/javascript">
    google.charts.load("current", {packages: ["corechart"]});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {

        var months = ["January", "February", "March", "April", "May", "June",
            "July", "August", "September", "October", "November", "December"];

        var d = new Date();
        var selectedMonthName = months[d.getMonth()] + ', ' + d.getFullYear();


        var data = google.visualization.arrayToDataTable([
            ['Task', 'Hours per Day'],
            ['Income', <?php
        if (!empty($this_month['payment'])) {
            echo $this_month['payment'];
        } else {
            echo '0';
        }
        ?>],
            ['Expense', <?php
        if (!empty($this_month['expense'])) {
            echo $this_month['expense'];
        } else {
            echo '0';
        }
        ?>],
        ]);

        var options = {
            title: selectedMonthName,
            is3D: true,
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
        chart.draw(data, options);
    }
</script>




<script type="text/javascript">
    google.charts.load("current", {packages: ["corechart"]});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {

        var months = ["January", "February", "March", "April", "May", "June",
            "July", "August", "September", "October", "November", "December"];

        var d = new Date();
        var selectedMonthName = months[d.getMonth()] + ', ' + d.getFullYear();

        var data = google.visualization.arrayToDataTable([
            ['Task', 'Hours per Day'],
            ['Treated', <?php
        if (!empty($this_month['appointment_treated'])) {
            echo $this_month['appointment_treated'];
        } else {
            echo '0';
        }
        ?>],
            ['cancelled', <?php
        if (!empty($this_month['appointment_cancelled'])) {
            echo $this_month['appointment_cancelled'];
        } else {
            echo '0';
        }
        ?>],
        ]);

        var options = {
            title: selectedMonthName + ' Appointment',
            pieHole: 0.4,
        };

        var chart = new google.visualization.PieChart(document.getElementById('donutchart'));
        chart.draw(data, options);
    }
</script>



<script type="text/javascript">
    google.charts.load('current', {'packages': ['corechart']});
    google.charts.setOnLoadCallback(drawVisualization);

    function drawVisualization() {
        // Some raw data (not necessarily accurate)
        var data = google.visualization.arrayToDataTable([
            ['Month', 'Income', 'Expense'],
            ['Jan', <?php echo $this_year['payment_per_month']['january']; ?>, <?php echo $this_year['expense_per_month']['january']; ?>],
            ['Feb', <?php echo $this_year['payment_per_month']['february']; ?>, <?php echo $this_year['expense_per_month']['february']; ?>],
            ['Mar', <?php echo $this_year['payment_per_month']['march']; ?>, <?php echo $this_year['expense_per_month']['march']; ?>],
            ['Apr', <?php echo $this_year['payment_per_month']['april']; ?>, <?php echo $this_year['expense_per_month']['april']; ?>],
            ['May', <?php echo $this_year['payment_per_month']['may']; ?>, <?php echo $this_year['expense_per_month']['may']; ?>],
            ['June', <?php echo $this_year['payment_per_month']['june']; ?>, <?php echo $this_year['expense_per_month']['june']; ?>],
            ['July', <?php echo $this_year['payment_per_month']['july']; ?>, <?php echo $this_year['expense_per_month']['july']; ?>],
            ['Aug', <?php echo $this_year['payment_per_month']['august']; ?>, <?php echo $this_year['expense_per_month']['august']; ?>],
            ['Sep', <?php echo $this_year['payment_per_month']['september']; ?>, <?php echo $this_year['expense_per_month']['september']; ?>],
            ['Oct', <?php echo $this_year['payment_per_month']['october']; ?>, <?php echo $this_year['expense_per_month']['october']; ?>],
            ['Nov', <?php echo $this_year['payment_per_month']['november']; ?>, <?php echo $this_year['expense_per_month']['november']; ?>],
            ['Dec', <?php echo $this_year['payment_per_month']['december']; ?>, <?php echo $this_year['expense_per_month']['december']; ?>],
        ]);

        var options = {
            title: new Date().getFullYear() + ' <?php echo lang('per_month_income_expense'); ?>',
            vAxis: {title: '<?php // echo $settings->currency; ?>'},
            hAxis: {title: '<?php echo lang('months'); ?>'},
            seriesType: 'bars',
            series: {5: {type: 'line'}}
        };

        var chart = new google.visualization.ComboChart(document.getElementById('chart_div'));
        chart.draw(data, options);
    }
</script>

<script>

	// alert("before 0");
$(document).ready(function() {
	// alert("before");
	
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
		
	
	// alert($("#editable-sample").html());	
	var table = $('#editable-sample').DataTable({
            responsive: true,

            "processing": true,
            // "serverSide": true,
            "searchable": true,
            "ajax": {
                url: "home/getOrganisationsForAppointment",
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
					// {
						// extend: 'pageLength',
					// },
					// {
						// extend: 'excelHtml5',
						// className: 'dt-button-icon-left dt-button-icon-excel',
						// exportOptions: {
							// columns: [0,1,2,3,4,5],
						// }
					// },
					// {
						// extend: 'pdfHtml5',
						// className: 'dt-button-icon-left dt-button-icon-pdf',
						// exportOptions: {
							// columns: [0,1,2,3,4,5],
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
            "order": [[0, "desc"]],
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
                    emptyTable: "",//emptyTable: "Aucune donnée disponible dans le tableau",
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
	
});
</script>









