<!--sidebar end-->
<!--main content start-->

<style>
	td.details-control {
		background: url('uploads/details_open.png') no-repeat transparent center 10px !important;
		cursor: pointer !important;
	}

	tr.shown td.details-control {
		background: url('uploads/details_close.png') no-repeat transparent center 10px !important;
	}

	th.btn-toggle-all-children {
		background: url('uploads/details_open_all.png') no-repeat transparent center 10px !important;
		cursor: pointer !important;
	}

	tr.btn-toggle-shown th.btn-toggle-all-children {
		background: url('uploads/details_close_all.png') no-repeat transparent center 10px !important;
	}

	table.details {
		border: 1px solid #ccc;
		border-collapse: collapse;
		margin: 0;
		padding: 0;
		width: 100%;
		box-shadow: 0 0 0 .2rem rgba(13, 77, 153, .25) !important;
	}

	table.details tr {
		background: #F8F9FA !important;
		border: 1px solid #ddd;
		padding: .35em;
	}

	table.details th,
	table.details td {

		background: #F8F9FA !important;
		padding: .625em;
		text-align: center;
	}

	table.details th {

		background: #F8F9FA !important;
		font-size: .85em;
		letter-spacing: .1em;
		text-transform: uppercase;
	}

	.underlinedClass:hover {
		font-weight: bold;
		color: #0d4d99;
	}

	img.edit0,
	img.valid0,
	img.cancel0,
	img.edit1,
	img.valid1,
	img.cancel1,
	img.edit00,
	img.valid00,
	img.cancel00,
	img.edit01,
	img.valid01,
	img.cancel01,
	img.edit021,
	img.valid021,
	img.cancel021,
	img.edit022,
	img.valid022,
	img.cancel022,
	img.edit023,
	img.valid023,
	img.cancel023,
	img.edit024,
	img.valid024,
	img.cancel024,
	img.edit025,
	img.valid025,
	img.cancel025 {
		display: none;
	}

	td.edit0,
	td.edit1,
	td.edit00,
	td.edit01,
	td.edit021,
	td.edit022,
	td.edit023,
	td.edit024,
	td.edit025 {
		font-weight: bold;
	}
</style>
<style>
	.tooltips {
		position: relative;
	}

	.tooltips span {
		font: 300 12px 'Open Sans', sans-serif;
		position: absolute;
		color: #FFFFFF;
		background: #000000;
		padding: 5px 10px;
		margin-left: 50px;
		width: 140px;
		text-align: center;
		visibility: hidden;
		opacity: 0;
		filter: alpha(opacity=0);
	}

	.tooltips>span img {
		max-width: 140px;
	}

	.tooltips[tooltip-position="right"] span {}

	.tooltips span:after {
		content: '';
		position: absolute;
		width: 0;
		height: 0;
	}

	.tooltips[tooltip-position="right"] span:after {
		top: 50%;
		right: 100%;
		margin-top: -8px;
		border-right: 8px solid black;
		border-top: 8px solid transparent;
		border-bottom: 8px solid transparent;
	}

	.tooltips span {
		visibility: visible;
		opacity: 1;
		z-index: 999;
	}

	.tooltips[tooltip-position="right"]:hover span {}

	.tooltips[tooltip-type="primary"]>span {
		background-color: #2980b9;
	}

	.tooltips[tooltip-type="primary"][tooltip-position="right"]>span:after {
		border-right: 8px solid #2980b9;
	}

	.tooltips[tooltip-type="success"]>span {
		background-color: #27ae60;
	}

	.tooltips[tooltip-type="success"][tooltip-position="right"]>span:after {
		border-right: 8px solid #27ae60;
	}

	.tooltips[tooltip-type="warning"]>span {
		background-color: #f39c12;
	}

	.tooltips[tooltip-type="warning"][tooltip-position="right"]>span:after {
		border-right: 8px solid #f39c12;
	}

	.tooltips[tooltip-type="danger"]>span {
		background-color: #c0392b;
	}

	.tooltips[tooltip-type="danger"][tooltip-position="right"]>span:after {
		border-right: 8px solid #c0392b;
	}

	.aleredit {
		display: none;
	}

	.aleradd {
		display: none;
	}


	.modal-dialog {
		display: flex;
		min-width: 80vw;
	}

	.modal-header {
		min-width: 80vw;
	}
</style>

<script src="<?php echo base_url(); ?>common/js/ecomed24.min.js"></script>


<section id="main-content">

	<section class="wrapper site-min-height">
		<!-- page start-->
		<section class="panel">
			<header class="panel-heading" style="margin-top:41px;">
				<div class="col-md-5 no-print pull-left">
					<h3><?php echo lang('testList'); ?></h3>
				</div>
				<div class="col-md-10 no-print pull-right">
					<div>
						<!-- <div class="btn-group pull-right" style="margin-right:5px;">
							<button id="" class="btn green btn-xs downloadbutton2">
								<i class="fa fa-plus-circle"></i>&nbsp;Importer Autres Prestations
							</button>
						</div> -->
						<div class="btn-group pull-right" style="margin-right:5px;">
							<button id="" class="btn green btn-xs downloadbutton2">
								<i class="fa fa-plus-circle"></i>&nbsp;Importer prestation labo
							</button>
						</div>
					</div>

					<div class="btn-group pull-right" style="margin-right:5px;">
                            <button id="" class="btn green btn-xs downloadbutton">
                                <i class="fa fa-plus-circle"></i>&nbsp;Ajouter tarifs tiers-payant
                            </button>
                        </div>
					<div class="btn-group pull-right" style="margin-right:5px;">
						<button id="" class="btn btn-success btn-xs addtest" style="margin-top:0 !important">
							<i class="fa fa-plus-circle"></i>&nbsp;Ajouter Prestation
						</button>
					</div>

				</div>


			</header>
			<div class="col-md-12">
				<?php
				$message2 = $this->session->flashdata('message2');
				if (!empty($message2)) {
				?>
					<code class="flash_message pull-left"> <?php echo $message2; ?></code>
				<?php } ?>
			</div>
			<div class="panel-body panel-bodyAlt">
				<div class="adv-table editable-table ">
					<div class="space15"></div>
					<table class="table table-hover progress-table" id="editable-sample">
						<thead>
							<tr>
								<!--<th> <?php echo lang('department') ?></th>-->
								<th style="width:5%" class="btn-toggle-all-children"></th>
								<th style="width:25%"><?php echo lang('service');  ?></th>
								<th style="width:20%"><?php echo lang('speciality'); ?></th>
								<th style="width:35%">Prestation</th>
								<th style="width:0%">&nbsp;</th>
								<th style="width:15%">CODE : Coefficent</th>
								<!--<th style="width:10%" class="no-print">Actions</th>-->
							</tr>
						</thead>
						<tbody>

						</tbody>
					</table>
				</div>
			</div>
		</section>
		<!-- page end-->
	</section>
</section>
<!--main content end-->
<!--footer start-->



<div class="modal fade" id="myModal2" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 class="modal-title">Importer Prestations de laboratoire (xls, xlsx) </h4>
			</div>

			<div class="modal-body">
				<div class="btn-group" style="margin-right:5px;">
					<a id="" class="btn green btn-xs btn-secondary" href="home/createPrestationsTiersPayant">
						<i class="fa fa-download"></i>&nbsp;Télécharger le fichier de référence
					</a>
				</div>
				<form role="form" id="departmentEditForm" class="clearfix" action="home/importTiersPayant" method="post" enctype="multipart/form-data">

					<div class="form-group has-feedback">
						<label for="exampleInputEmail1"> <?php echo lang('choose_file'); ?> rempli</label>
						<input type="file" class="form-control" placeholder="" name="filenameLabo" required accept=".xls, .xlsx ,.csv">
						<span class="glyphicon glyphicon-file form-control-feedback"></span>
						<input type="hidden" name="tablename" value="payment_category">
					</div>

					<section class="">
						<a href="javascript:$('#myModal2').modal('hide');" class="btn btn-info btn-secondary pull-left">Retour</a>
						<button type="submit" name="submit" class="btn btn-info submit_button pull-right"> <?php echo lang('submit') ?></button>
					</section>
				</form>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div>



<div class="modal fade" id="myModal2backup" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 class="modal-title">Importer Prestations de laboratoire (xls, xlsx) </h4>
			</div>

			<div class="modal-body">
				<div class="btn-group" style="margin-right:5px;">
					<a id="" class="btn green btn-xs btn-secondary" href="home/createPrestationsTemplateLabo">
						<i class="fa fa-download"></i>&nbsp;Télécharger le fichier de référence
					</a>
				</div>
				<form role="form" id="departmentEditForm" class="clearfix" action="home/importPrestationsInfoLabo" method="post" enctype="multipart/form-data">

					<div class="form-group has-feedback">
						<label for="exampleInputEmail1"> <?php echo lang('choose_file'); ?> rempli</label>
						<input type="file" class="form-control" placeholder="" name="filenameLabo" required accept=".xls, .xlsx ,.csv">
						<span class="glyphicon glyphicon-file form-control-feedback"></span>
						<input type="hidden" name="tablename" value="payment_category">
					</div>

					<section class="">
						<a href="javascript:$('#myModal2').modal('hide');" class="btn btn-info btn-secondary pull-left">Retour</a>
						<button type="submit" name="submit" class="btn btn-info submit_button pull-right"> <?php echo lang('submit') ?></button>
					</section>
				</form>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div>

<div class="modal fade" id="myModal3" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 class="modal-title">Importer Autres Prestations (xls, xlsx) </h4>
			</div>

			<div class="modal-body">
				<div class="btn-group" style="margin-right:5px;">
					<a id="" class="btn green btn-xs btn-secondary" href="home/createPrestationsTemplateAutres">
						<i class="fa fa-download"></i>&nbsp;Télécharger le fichier de référence
					</a>
				</div>
				<form role="form" id="departmentEditForm" class="clearfix" action="home/importPrestationsInfoAutres" method="post" enctype="multipart/form-data">

					<div class="form-group has-feedback">
						<label for="exampleInputEmail1"> <?php echo lang('choose_file'); ?> rempli</label>
						<input type="file" class="form-control" placeholder="" name="filenameAutres" required accept=".xls, .xlsx ,.csv">
						<span class="glyphicon glyphicon-file form-control-feedback"></span>
						<input type="hidden" name="tablename" value="payment_category">
					</div>

					<section class="">
						<a href="javascript:$('#myModal3').modal('hide');" class="btn btn-info btn-secondary pull-left">Retour</a>
						<button type="submit" name="submit" class="btn btn-info submit_button pull-right"> <?php echo lang('submit') ?></button>
					</section>
				</form>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div>

<div class="modal fade addmodal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 class="modal-title">Ajouter Prestation </h4>
			</div>

			<div class="modal-body">


				<form class="position-relative" id="addForm">
					<div class="form-row">
						<div class="form-group col-sm-6">
							<label for="sl">Service:</label>
							<select name="Service" id="sl" class="form-control" required>
								<option selected disabled value="">Choisir Service ....</option>	
							</select>
						</div>
						<div class="form-group col-sm-6">
							<label for="sp">Specialite:</label>
							<select name="Specialite" id="sp" class="form-control" required>
								<!-- <option selected disabled value="">Choose....</option> -->

							</select>
						</div>

					</div>
					<div class="form-group col-sm-6">
						<label for="pres">Analyse</label>
						<input type="text" name="Prestaion" id="press" class="form-control" required>
					</div>
					<div class="form-group col-sm-2">
						<label for="na">Cotation:</label>
						<input type="text" class="form-control" id="cotation" name="cotation">
					</div>
					<div class="form-group col-sm-2">
						<label for="na">Coefficient:</label>
						<input type="text" class="form-control" id="coefficient" name="coefficient">
					</div>
					<div class="form-group col-sm-4">
						<label for="na">Mots-Clés:</label>
						<input type="text" class="form-control" id="na" name="name">
					</div>

					<div class="form-group col-sm-12">
						<label for="ds">Description:</label> <br>
						<textarea name="desc" id="ds" cols="240" rows="4" style="resize: none;"></textarea>
					</div>



					<table class="table table-bordered " id="_tbl_params">

						<thead style="background:#dddddd">
							<tr style="background:#454d55;color:#e3e3e3">
								<th colspan="8" class="text-center">PARAMÈTRES</th>
							</tr>
							<tr>

								<th colspan="8" class="text-right"><button type="button" name="addrow" class="btn btn-success btn-sm addrow"><i class="fas fa-plus"></button></th>
							</tr>

						</thead>

						<!--  -->

						<!--  -->
						<tbody class="tbodyaddtest">

						</tbody>
					</table>



					<button type="submit" class="btn btn-primary">Enregistrer</button>
					<div class="alert alert-success alert-dismissible aleradd" role="alert">
						Data edit successfuly.
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
				</form>
			</div>
		</div><!-- /.modal-dialog -->
	</div>
</div>

<div class="modal fade editmodal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 class="modal-title">Éditer Prestation </h4>
			</div>

			<div class="modal-body">
				<form id="editForm">
					<div class="form-group col-sm-6">
						<label for="pres">Analyse</label>
						<input type="text" name="Prestaion" id="press" class="form-control" readonly>
					</div>
					<input type="hidden" class="form-control" id="preid" name="preid">
					<input type="hidden" class="form-control" id="speid" name="speid">
					<input type="hidden" class="form-control" id="cota" name="cota">

					<div class="form-group col-sm-2">
						<label for="na">Cotation</label>
						<input type="text" class="form-control" id="cotation" name="cotation">
					</div>
					<div class="form-group col-sm-2">
						<label for="na">Coefficient</label>
						<input type="text" class="form-control" id="coefficient" name="coefficient">
					</div>

					<div class="form-group col-sm-4">
						<label for="na">Mots-Clés</label>
						<input type="text" class="form-control" id="na" name="name">
					</div>

					<div class="form-group col-sm-12">
						<label for="ds">Description</label>
						<br>
						<textarea name="desc" id="ds" cols="240" rows="4" style="resize: none;"></textarea>
					</div>
					<div class="form-group col-sm">
						<table class="table table-bordered " id="edittab">

							<thead style="background:#dddddd">
								<tr style="background:#454d55;color:#e3e3e3">
									<th colspan="8" class="text-center">LISTE PARAMÈTRES</th>
								</tr>
								<tr>
									<th colspan="8" class="text-right"><button type="button" name="addrow" class="btn btn-success btn-sm addrow2"><i class="fas fa-plus"></button></th>
								</tr>
							</thead>
							<tbody class="tbodyaddtest2">

							</tbody>
						</table>
					</div>

					</br>
					</br>
					<button type="submit" class="btn btn-primary">Sauvegarder les modifications</button>



					</br>

					<div class="alert alert-success alert-dismissible aleredit" role="alert">
						Data edit successfuly.
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>


				</form>
			</div>
		</div><!-- /.modal-dialog -->
	</div>
</div>




<script>
	var bigtable;
	var bigtable2;
	var iconhid;
	var para_rows = 0;
	var para_rows2 = 0;
	var tmp_cnt1 = 0;
	var tmp_cnt2 = 0;
	var tmp_cnt3 = 0;
	var tmp_cnt4 = 0;
	var tmp_cnt5 = 0;

	var servicesList = [];
	var specialiteList = [];


	function updateDataRequired(id) {
		var values_p = document.getElementById(id + 'values_p');
		var ref_low_p = document.getElementById(id + 'ref_low_p');
		var ref_high_p = document.getElementById(id + 'ref_high_p');

		if (values_p.value.length > 0) {
			ref_low_p.required = false;
			ref_high_p.required = false;
		} else {
			ref_low_p.required = true;
			ref_high_p.required = true;
		}


	}


	$(document).ready(function() {
		$("#editForm").on("submit", function(event) {
			event.preventDefault();
			var formData = $(this).serialize();

			$.post("home/editPrestationDetailsForm", formData, function(data) {
				$(".aleredit").fadeTo(2000, 500).slideUp(500, function() {
					$(".aleredit").slideUp(500);
				});
				window.location.reload();
			}).error(function(data) {
				alert("error: " + data);

			});
		});

		$("#addForm").on("submit", function(event) {
			// event.preventDefault();
			var formData = $(this).serialize();
			console.log(" ****** donnee insertion ********");
			console.log(formData);
			console.log(" ****** donnee insertion ********");
			
			$.post("home/addPrestationForm", formData, function(data) {

				$(".aleradd").fadeTo(2000, 500).slideUp(500, function() {

					$(".aleradd").slideUp(500);
				});
				// window.location.reload();
			}).error(function(data) {
				alert("error: " + data);

			});
		});


		$('.addmodal').on('hidden.bs.modal', function() {
			$('#addForm').trigger("reset");
			$('.tbodyaddtest').empty();
			tmp_cnt3 = 0;
			para_rows2 = 0;
			$('.aleradd').css({
				display: "none"
			});
		});

		$.ajax({
			url: 'home/getServiceName',
			method: 'GET',
			dataType: 'json',
			async: false,
			success: function(json) {

				servicesList.push(json);

			}
		});
		var srvce_html;
		for (var i = 0; i < servicesList[0].length; i++) {
			if (servicesList[0][i].name_service.trim() == "") continue;
			srvce_html = '<option value="' + servicesList[0][i].idservice + '">' + servicesList[0][i].name_service + '</option>';
			$('#sl').append(srvce_html);
		}

		// $.ajax({
		// 	//url: 'finance/models/Finance_model/getAllSpecialiteIdsAndNames',
		// 	url: 'home/getAllSpecialiteIdsAndNames',
		// 	method: 'GET',
		// 	dataType: 'json',
		// 	async: false,
		// 	success: function(json) {

		// 		specialiteList.push(json);

		// 	}
		// });
		// var specl_html;
		// for (var i = 0; i < specialiteList[0].length; i++) {
		// 	if (specialiteList[0][i].name_specialite.trim() == "") continue;
		// 	specl_html = '<option value="' + specialiteList[0][i].idspe + '">' + specialiteList[0][i].name_specialite + '</option>';
		// 	$('#sp').append(specl_html);
		// }


	});

	function getPrestationDetails(rowData) {
		// console.log(rowData.prestation);
		$.ajax({
			url: 'home/getPrestationDetails',
			method: 'GET',
			data: {
				idPrestation: rowData.id,
				typePrestation: rowData.type,
				nomPrestation: rowData.prestation,
				nomService: rowData.service,
				specialiteid: rowData.specialiteid,
				cotation: rowData.cotation,
				coefficient: rowData.coefficient
			},
			dataType: 'json',
			success: function(json) {

				bigtable = json;
				sericelist = json;

			}
		});
	}

	$(document).on('click', '.editbtnsub', function() {

		$('.editmodal').modal('show');

		console.log("******** VOIE BIGTABLE ******** ");
		console.log(bigtable);
		if (bigtable[0] == "Laboratoire") {
			$('#edittab').show();
			$('#editForm #press').val(bigtable[6]);
			$('#editForm #ds').val(bigtable[1]);
			$('#editForm #na').val(bigtable[2]);
			$('#editForm #preid').val(bigtable[4]);
			$('#editForm #speid').val(bigtable[5]);
			$('#editForm #cotation').val(bigtable[7]);
			$('#editForm #coefficient').val(bigtable[8]);

			for (var i = 0; i < bigtable[3].length; i++) {

				var html = '';
				html += '<tr>';

				html += '<td hidden><input type="hidden" id="idpara_p" name="custId" value="' + bigtable[3][i].idpara + '"></td>';
				html += '<td span="1" style="width: 15%;"><input placeholder="Paramètre" required type="text" id="nom_p" name="old[' + tmp_cnt1 + '][nom_p]" class="form-control from_rl"  value="' + bigtable[3][i].nom_parametre + '"/></td>';



				if (bigtable[3][i].type == 'numerical' || bigtable[3][i].type == '') {
					html += `<td span="1" style="width: 15%;">
							<select required id="type_p" name="old[${tmp_cnt1}][type_p]" class="form-control from_rl type-edit" value="${bigtable[3][i].type}">
								<option selected value="numerical">Min-Max</option>
								<option value="setofcode">Options</option>
								<option value="textcode">Texte</option>
								<option value="section">Section</option>
			 					<option value="sous_section">Sous-section</option>
							</select>
						</td>`;
					html += '<td class="params_unit" span="1" style="width: 10%;"><input required type="text" id="unit_p" name="old[' + tmp_cnt1 + '][unit_p]" class="form-control to_rl params_unit" value="' + bigtable[3][i].unite + '"/></td>'
					html += '<td class="params_ref_low" span="1" style="width: 10%;"><input type="text" id="ref_low_p" name="old[' + tmp_cnt1 + '][ref_low_p]" class="form-control equal" value="' + bigtable[3][i].ref_low + '"/></td>';
					html += '<td class="params_ref_high" span="1" style="width: 10%;"><input type="text" id="ref_high_p" name="old[' + tmp_cnt1 + '][ref_high_p]" class="form-control equal" value="' + bigtable[3][i].ref_high + '"/></td>';

					html += '<td class="params_norm" span="1" style="width: 60%;"><input required type="text" id="values_p" name="old[' + tmp_cnt1 + '][values_p]" class="form-control equal" value="' + bigtable[3][i].valeurs + '"/></td>';
					html += '<input required type="hidden" id="values_p" name="old[' + tmp_cnt1 + '][idpara_p]" " value="' + bigtable[3][i].idpara + '"/>';
					html += '<td><button type="button" name="remove" class="btn btn-danger btn-sm remove-old"><i class="fas fa-minus"></button></td></tr>';
				}
				if (bigtable[3][i].type == 'setofcode') {
					html += `<td>
							<select required id="type_p" name="old[${tmp_cnt1}][type_p]" class="form-control from_rl type-edit" value="${bigtable[3][i].type}">
								<option value="numerical">Min-Max</option>
								<option selected value="setofcode">Options</option>
								<option value="textcode">Texte</option>
								<option value="section">Section</option>
								 <option value="sous_section">Sous-section</option>
							</select>
						</td>`;
					html += `<td class="params_code" colspan="3"><input required placeholder="Options" type="text" data-role="tagsinput" id="code_p" value="${bigtable[3][i].set_of_code}" name="old[${tmp_cnt1}][code_p]" class="form-control to_rl" /></td>`;
					html += `<input type="hidden" class="params_ref_low" id="" name="" value="">`;
					html += `<input type="hidden" class="params_ref_high" id="" name="" value="">`;
					html += '<td class="params_norm" colspan="1"><input placeholder="VALUES" required type="text" id="values_p" name="old[' + tmp_cnt1 + '][values_p]" class="form-control equal" value="' + bigtable[3][i].valeurs + '"/></td>';
					html += '<input required type="hidden" id="values_p" name="old[' + tmp_cnt1 + '][idpara_p]" " value="' + bigtable[3][i].idpara + '"/>';
					html += '<td><button type="button" name="remove" class="btn btn-danger btn-sm remove-old"><i class="fas fa-minus"></button></td></tr>';
				}
				if (bigtable[3][i].type == 'textcode') {
					html += `<td>
							<select required id="type_p" name="old[${tmp_cnt1}][type_p]" class="form-control from_rl type-edit" value="${bigtable[3][i].type}">
							<option value="numerical">Min-Max</option>
							<option value="setofcode">Options</option>
							<option selected value="textcode">Texte</option>
							<option value="section">Section</option>
							<option value="sous_section">Sous-section</option>
								
							</select>
						</td>`;
					html += `<td class="params_text" colspan="3" style="height:100px">
    <textarea data-role="tagsinput" id="code_p"  name="old[${tmp_cnt1}][code_p]" cols="65" rows="10" placeholder="Texte  , Conclusion , ect..." class="params_code">${bigtable[3][i].set_of_code}</textarea>
</td>`;
					html += `<input type="hidden" class="params_ref_low" id="" name="" value="">`;
					html += `<input type="hidden" class="params_ref_high" id="" name="" value="">`;
					html += '<td class="params_norm" colspan="1"><input placeholder="VALUES" type="hidden" id="values_p" name="old[' + tmp_cnt1 + '][values_p]" class="form-control equal" value="' + bigtable[3][i].valeurs + '"/></td>';
					html += '<input required type="hidden" id="values_p" name="old[' + tmp_cnt1 + '][idpara_p]" " value="' + bigtable[3][i].idpara + '"/>';
					html += '<td><button type="button" name="remove" class="btn btn-danger btn-sm remove-old"><i class="fas fa-minus"></button></td></tr>';
				}

				if (bigtable[3][i].type == 'section') {
					html += `<td>
							<select required id="type_p" name="old[${tmp_cnt1}][type_p]" class="form-control from_rl type-edit" value="${bigtable[3][i].type}">
							<option value="numerical">Min-Max</option>
							<option value="setofcode">Options</option>
							<option value="textcode">Texte</option>
							<option selected value="section">Section</option>
							<option value="sous_section">Sous-section</option>
								
							</select>
						</td>`;
					html += `<td class="params_text" colspan="3" style="height:100px">
    <textarea hidden data-role="tagsinput" id="code_p"  name="old[${tmp_cnt1}][code_p]" cols="65" rows="10" placeholder="Texte  , Conclusion , ect..." class="params_code">${bigtable[3][i].set_of_code}</textarea>
</td>`;
					html += `<input type="hidden" class="params_ref_low" id="" name="" value="">`;
					html += `<input type="hidden" class="params_ref_high" id="" name="" value="">`;
					html += '<td class="params_norm" colspan="1"><input placeholder="VALUES" type="hidden" id="values_p" name="old[' + tmp_cnt1 + '][values_p]" class="form-control equal" value="' + bigtable[3][i].valeurs + '"/></td>';
					html += '<input required type="hidden" id="values_p" name="old[' + tmp_cnt1 + '][idpara_p]" " value="' + bigtable[3][i].idpara + '"/>';
					html += '<td><button type="button" name="remove" class="btn btn-danger btn-sm remove-old"><i class="fas fa-minus"></button></td></tr>';
				}

				if (bigtable[3][i].type == 'sous_section') {
					html += `<td>
							<select required id="type_p" name="old[${tmp_cnt1}][type_p]" class="form-control from_rl type-edit" value="${bigtable[3][i].type}">
							<option value="numerical">Min-Max</option>
							<option value="setofcode">Options</option>
							<option value="textcode">Texte</option>
							<option value="section">Section</option>
							<option selected value="sous_section">Sous-section</option>
								
							</select>
						</td>`;
					html += `<td class="params_text" colspan="3" style="height:100px">
    <textarea hidden data-role="tagsinput" id="code_p"  name="old[${tmp_cnt1}][code_p]" cols="65" rows="10" placeholder="Texte  , Conclusion , ect..." class="params_code">${bigtable[3][i].set_of_code}</textarea>
</td>`;
					html += `<input type="hidden" class="params_ref_low" id="" name="" value="">`;
					html += `<input type="hidden" class="params_ref_high" id="" name="" value="">`;
					html += '<td class="params_norm" colspan="1"><input placeholder="VALUES" type="hidden" id="values_p" name="old[' + tmp_cnt1 + '][values_p]" class="form-control equal" value="' + bigtable[3][i].valeurs + '"/></td>';
					html += '<input required type="hidden" id="values_p" name="old[' + tmp_cnt1 + '][idpara_p]" " value="' + bigtable[3][i].idpara + '"/>';
					html += '<td><button type="button" name="remove" class="btn btn-danger btn-sm remove-old"><i class="fas fa-minus"></button></td></tr>';
				}
				



				$('.tbodyaddtest2').append(html);
				tmp_cnt1++;
				para_rows++;

				if (para_rows > 1) {
					$(".remove").show();
					$(".remove-old").show();

				}
			}

		} else {
			$('#editForm #ds').val(bigtable[1]);
			$('#editForm #na').val(bigtable[2]);
			$('#editForm #preid').val(bigtable[3]);
			$('#edittab').hide();

		}





		$('.editmodal').on('hidden.bs.modal', function() {

			$('.tbodyaddtest2').empty();
			var tr = $(".details-control").closest('.shown');
			var row = iconhid.row(tr);
			if (row.child.isShown()) {
				// This row is already open - close it
				row.child.hide();
				tr.removeClass('shown');
				tmp_cnt1 = 0;
				tmp_cnt2 = 0;
				para_rows = 0;
				$('.aleredit').css({
					display: "none"
				});
			}

		});
		$('#editForm').on('change', function() {
			$('.aleredit').css({
				display: "none"
			});
		});



	});


	$(document).on('click', '.addrow2', '.remove', function() {
		//to take the last value from the tmp_cnt1 varible from edit table
		
		if (tmp_cnt2 < tmp_cnt1) {
			tmp_cnt2 = tmp_cnt1
		}
		var html = '';
		html += '<tr>';
		html += '<td span="1" style="width: 15%;"><input required placeholder="Paramètre" type="text" id="' + tmp_cnt2 + 'nom_p" name="new[' + tmp_cnt2 + '][nom_p]" class="form-control from_rl" /></td>';

		html += `<td span="1" style="width: 15%;">
		  <select required id="${tmp_cnt2}type_p" name="new[${tmp_cnt2}][type_p]" class="form-control from_rl type">
		 	<option value="numerical">Min-Max</option>
		 	<option value="setofcode">Options</option>
			 <option value="textcode">Texte</option>
			 <option value="section">Section</option>
			 <option value="sous_section">Sous-section</option>
		  </select>
  		  </td>`;

		html += '<td class="params_unit" span="1" style="width: 10%;"><input required placeholder="Unité" type="text" id="' + tmp_cnt2 + 'unit_p" name="new[' + tmp_cnt2 + '][unit_p]" class="form-control to_rl" /></td>';

		html += '<td class="params_text" span="1" style="display:none;"><input required placeholder="Unité" type="hidden" id="" name="" class="form-control to_rl" /></td>';

		html += '<td class="params_section" span="1" style="display:none"><input required placeholder="Section" type="hidden" id="" name="" class="form-control to_rl" /></td>';

html += '<td class="params_sous_section" span="1" style="display:none"><input required placeholder="Sous_section" type="hidden" id="" name="" class="form-control to_rl" /></td>';

		html += '<td class="params_ref_low" span="1" style="width: 10%;"><input required placeholder="Référence min" type="number" step="0.01" id="' + tmp_cnt2 + 'ref_low_p" name="new[' + tmp_cnt2 + '][ref_low_p]" class="form-control equal" /></td>';

		html += '<td class="params_ref_high" span="1" style="width: 10%;"><input required placeholder="Référence max" type="number" step="0.01" id="' + tmp_cnt2 + 'ref_high_p" name="new[' + tmp_cnt2 + '][ref_high_p]" class="form-control equal" /></td>';

		html += '<td class="params_norm" span="1" style="width: 60%;"><input onkeyup="updateDataRequired(\'' + tmp_cnt2 + '\')" required placeholder="Valeurs usuelles" type="text" id="' + tmp_cnt2 + 'values_p" name="new[' + tmp_cnt2 + '][values_p]" class="form-control equal" /></td>';
		html += '<td span="1" style="width: 5%;"><button type="button" name="remove" class="btn btn-danger btn-sm remove"><i class="fas fa-minus"></button></td></tr>';
		$('.tbodyaddtest2').append(html);
		tmp_cnt2++;
		para_rows++;
		if (para_rows > 1) {
			$('.remove').show();
		}
	});



	$(document).ready(function() {


		$('.addtest').on('click', function() {
			$('.addmodal').modal('show');
			var html = '';
			html += '<tr>';
			html += '<td span="1" style="width: 15%;"><input required placeholder="Paramètre" type="text" id="' + tmp_cnt3 + 'nom_p" name="new[' + tmp_cnt3 + '][nom_p]" class="form-control from_rl" /></td>';

			html += `<td span="1" style="width: 15%;">
		  <select required id="${tmp_cnt3}type_p" name="new[${tmp_cnt3}][type_p]" class="form-control from_rl type">
		 	<option value="numerical">Min-Max</option>
		 	<option value="setofcode">Options</option>
			 <option value="textcode">Texte</option>
			 <option value="section">Section</option>
			 <option value="sous_section">Sous-section</option>
			
		  </select>
  		  </td>`;

			
			html += '<td class="params_text" span="1" style="display:none"><input required placeholder="text....." type="hidden" id="" name="" class="form-control to_rl" /></td>';


html += '<td class="params_unit" span="1" style="width: 10%;"><input required placeholder="Unité" type="text" id="' + tmp_cnt3 + 'unit_p" name="new[' + tmp_cnt3 + '][unit_p]" class="form-control equal" /></td>';

html += '<td class="params_ref_low" span="1" style="width: 10%;"><input required placeholder="Référence min" type="number" step="0.01" id="' + tmp_cnt3 + 'ref_low_p" name="new[' + tmp_cnt3 + '][ref_low_p]" class="form-control equal" /></td>';

html += '<td class="params_ref_high" span="1" style="width: 10%;"><input required placeholder="Référence max" type="number" step="0.01" id="' + tmp_cnt3 + 'ref_high_p" name="new[' + tmp_cnt3 + '][ref_high_p]" class="form-control equal" /></td>';

html += '<td class="params_norm" span="1" style="width: 60%;"><input onkeyup="updateDataRequired(\'' + tmp_cnt3 + '\')" required placeholder="Valeurs usuelles" type="text" id="' + tmp_cnt3 + 'values_p" name="new[' + tmp_cnt3 + '][values_p]" class="form-control equal" /></td>';

html += '<td class="params_section" span="1" style="display:none"><input required placeholder="Section" type="hidden" id="" name="" class="form-control to_rl" /></td>';

html += '<td class="params_sous_section" span="1" style="display:none"><input required placeholder="Sous_section" type="hidden" id="" name="" class="form-control to_rl" /></td>';
html += '<td span="1" style="width: 5%;"><button type="button" name="remove" class="btn btn-danger btn-sm remove"><i class="fas fa-minus"></button></td></tr>';
			

			$('.tbodyaddtest').append(html);
			tmp_cnt3++;
			para_rows2++;
			if (para_rows2 > 1) {
				$('.remove').show();
			}


			// fin affichage parametre
			$('#sl').change(function() {
				var slctd_opt = this.value;

				for (var j = 0; j < servicesList[0].length; j++) {

					if (slctd_opt == servicesList[0][j].idservice) {
						if (servicesList[0][j].code_service == "labo") {
							$('#_tbl_params').show();
							break;
						} 
						if (servicesList[0][j].code_service == "MEDGEN") {
							$('#_tbl_params').show();
							break;
						}
						else {
							$('#_tbl_params').hide();
							break;
						}
					}
				}
				$("#sp").select2({
					placeholder: 'Choisir spécialité',
					allowClear: true,
					ajax: {
						url: 'home/getAllSpecialiteIdsAndNamesID?id=' + slctd_opt,
						type: "post",
						dataType: 'json',
						delay: 250,
						data: function(params) {
							return {
								searchTerm: params.term // search term
							};
						},
						processResults: function(response) {
							return {
								results: response
							};
						},
						cache: true
					}

				});
			});


		});


		$(document).on('click', '.remove', function() {
			if (para_rows > 1) {
				$(this).closest('tr').remove();
				para_rows--;
				if (para_rows == 1) {
					$('.remove').hide();
				}
			}

			if (para_rows2 > 1) {
				$(this).closest('tr').remove();
				para_rows2--;
				if (para_rows2 == 1) {
					$('.remove').hide();
				}
			}



		});




		////////////////////////////////////////////////////////////

		$(document).on('click', '.addrow', '.remove', function() {
			var html = '';
			
			html += '<tr>';
			html += '<td span="1" style="width: 15%;"><input required placeholder="Paramètre" type="text" id="' + tmp_cnt3 + 'nom_p" name="new[' + tmp_cnt3 + '][nom_p]" class="form-control from_rl" /></td>';

			html += `<td span="1" style="width: 15%;">
		  <select required id="${tmp_cnt3}type_p" name="new[${tmp_cnt3}][type_p]" class="form-control from_rl type">
		 	<option value="numerical">Min-Max</option>
		 	<option value="setofcode">Options</option>
			 <option value="textcode">Texte</option>
			 <option value="section">Section</option>
			 <option value="sous_section">Sous-section</option>
			
		  </select>
  		  </td>`;

			

			html += '<td class="params_text" span="1" style="display:none"><input required placeholder="text....." type="hidden" id="" name="" class="form-control to_rl" /></td>';


			html += '<td class="params_unit" span="1" style="width: 10%;"><input required placeholder="Unité" type="text" id="' + tmp_cnt3 + 'unit_p" name="new[' + tmp_cnt3 + '][unit_p]" class="form-control equal" /></td>';

			html += '<td class="params_ref_low" span="1" style="width: 10%;"><input required placeholder="Référence min" type="number" step="0.01" id="' + tmp_cnt3 + 'ref_low_p" name="new[' + tmp_cnt3 + '][ref_low_p]" class="form-control equal" /></td>';

			html += '<td class="params_ref_high" span="1" style="width: 10%;"><input required placeholder="Référence max" type="number" step="0.01" id="' + tmp_cnt3 + 'ref_high_p" name="new[' + tmp_cnt3 + '][ref_high_p]" class="form-control equal" /></td>';

			html += '<td class="params_norm" span="1" style="width: 60%;"><input onkeyup="updateDataRequired(\'' + tmp_cnt3 + '\')" required placeholder="Valeurs usuelles" type="text" id="' + tmp_cnt3 + 'values_p" name="new[' + tmp_cnt3 + '][values_p]" class="form-control equal" /></td>';
			
			html += '<td class="params_section" span="1" style="display:none"><input required placeholder="Section" type="hidden" id="" name="" class="form-control to_rl" /></td>';

			html += '<td class="params_sous_section" span="1" style="display:none"><input required placeholder="Sous_section" type="hidden" id="" name="" class="form-control to_rl" /></td>';
			html += '<td span="1" style="width: 5%;"><button type="button" name="remove" class="btn btn-danger btn-sm remove"><i class="fas fa-minus"></button></td></tr>';

			$('.tbodyaddtest').append(html);
			tmp_cnt3++;
			para_rows2++;
			if (para_rows2 > 1) {
				$('.remove').show();
			}
		});



		$(document).on('change', '.type', function() {
			var index = $(this).closest("tr").index();
			if ($(this).closest('tr').find(":selected").val() == 'numerical') {
				$(this).closest('tr').find(".params_text").html(``);
				$(this).closest('tr').find(".params_code").replaceWith(`<td class="params_unit" span="1" style="width: 10%;"><input required placeholder="Unité" type="text" data-role="tagsinput" id="${index}code_p" name="new[${index}][code_p]" class="form-control to_rl" /></td>`)
				$(this).closest('tr').find('.params_ref_low').replaceWith('<td class="params_ref_low" span="1" style="width: 10%;"><input required placeholder="Réféfence min" type="text" id="' + index + 'ref_low_p" name="new[' + index + '][ref_low_p]" class="form-control equal" /></td>')
				$(this).closest('tr').find('.params_ref_high').replaceWith('<td class="params_ref_high" span="1" style="width: 10%;"><input required placeholder="Référence max" type="text" id="' + index + 'ref_high_p" name="new[' + index + '][ref_high_p]" class="form-control equal" /></td>')
				$(this).closest('tr').find('.params_norm').replaceWith(`<td class="params_norm"><input required placeholder="Valeurs usuelles" type="text" id="${index}values_p" name="new[${index}][values_p]" class="form-control equal" /></td>`);
			}
			if ($(this).closest('tr').find(":selected").val() == 'setofcode') {
				$(this).closest('tr').find(".params_text").html(``);
				$(this).closest('tr').find(".params_unit").replaceWith(`<td class="params_code" colspan="3"><input required placeholder="Options séparées par virgule" type="text" data-role="tagsinput" id="${index}code_p" name="new[${index}][code_p]" class="form-control to_rl" /></td>`)
				$(this).closest('tr').find('.params_ref_low').replaceWith(`<input type="hidden" class="params_ref_low" id="" name="" value="">`);
				$(this).closest('tr').find('.params_ref_high').replaceWith(`<input type="hidden" class="params_ref_high" id="" name="" value="">`);
				$(this).closest('tr').find('.params_norm').replaceWith(`<td class="params_norm" colspan="1"><input required placeholder="Valeurs usuelles" type="text" id="${index}values_p" name="new[${index}][values_p]" class="form-control equal" /></td>`);
			}
			
			if ($(this).closest('tr').find(":selected").val() == 'textcode') {
				$(this).closest('tr').find(".params_code").html(``);
				$(this).closest('tr').find(".params_unit").html(``);
				$(this).closest('tr').find(".params_text").replaceWith(`<td class="params_text" colspan="3">
    <textarea data-role="tagsinput" id="${index}code_p" name="new[${index}][code_p]" cols="65" rows="10" placeholder="Texte  , Conclusion , ect..." class="params_code"></textarea>
</td>`)
				$(this).closest('tr').find('.params_ref_low').replaceWith(`<input type="hidden" class="params_ref_low" id="" name="" value="">`);
				$(this).closest('tr').find('.params_ref_high').replaceWith(`<input type="hidden" class="params_ref_high" id="" name="" value="">`);
				$(this).closest('tr').find('.params_norm').replaceWith(`<td class="params_norm" colspan="1"><input placeholder="Valeurs usuelles" type="hidden" id="${index}values_p" name="new[${index}][values_p]" class="form-control equal" /></td>`);
			}

			if ($(this).closest('tr').find(":selected").val() == 'section') {
				$(this).closest('tr').find(".params_code").html(``);
				$(this).closest('tr').find(".params_unit").html(``);
				$(this).closest('tr').find(".params_text").html(``);
				$(this).closest('tr').find(".params_sous_section").html(``);
				$(this).closest('tr').find(".params_text").replaceWith(`<td class="params_text" colspan="3">
    <textarea hidden data-role="tagsinput" id="${index}code_p" name="new[${index}][code_p]" cols="65" rows="10" placeholder="Texte  , Conclusion , ect..." class="params_code"></textarea>
</td>`)
				$(this).closest('tr').find('.params_ref_low').replaceWith(`<input type="hidden" class="params_ref_low" id="" name="" value="">`);
				$(this).closest('tr').find('.params_ref_high').replaceWith(`<input type="hidden" class="params_ref_high" id="" name="" value="">`);
				$(this).closest('tr').find('.params_norm').replaceWith(`<td class="params_norm" colspan="1"><input placeholder="Valeurs usuelles" type="hidden" id="${index}values_p" name="new[${index}][values_p]" class="form-control equal" /></td>`);
			}

			if ($(this).closest('tr').find(":selected").val() == 'sous_section') {
				$(this).closest('tr').find(".params_code").html(``);
				$(this).closest('tr').find(".params_unit").html(``);
				$(this).closest('tr').find(".params_text").html(``);
				$(this).closest('tr').find(".params_section").html(``);
				$(this).closest('tr').find(".params_text").replaceWith(`<td class="params_text" colspan="3">
    <textarea hidden data-role="tagsinput" id="${index}code_p" name="new[${index}][code_p]" cols="65" rows="10" placeholder="Texte  , Conclusion , ect..." class="params_code"></textarea>
</td>`)
				$(this).closest('tr').find('.params_ref_low').replaceWith(`<input type="hidden" class="params_ref_low" id="" name="" value="">`);
				$(this).closest('tr').find('.params_ref_high').replaceWith(`<input type="hidden" class="params_ref_high" id="" name="" value="">`);
				$(this).closest('tr').find('.params_norm').replaceWith(`<td class="params_norm" colspan="1"><input placeholder="Valeurs usuelles" type="hidden" id="${index}values_p" name="new[${index}][values_p]" class="form-control equal" /></td>`);
			}
			
		});

		$(document).on('change', '.type-edit', function() {
		
			var index = $(this).closest("tr").index();
			if ($(this).closest('tr').find(":selected").val() == 'setofcode') {
				$(this).closest('tr').find(".params_unit").replaceWith(`<td class="params_code" colspan="3"><input required placeholder="Options séparées par virgule" type="text" data-role="tagsinput" id="${index}code_p" name="old[${index}][code_p]" class="form-control to_rl" /></td>`)
				$(this).closest('tr').find('.params_ref_low').replaceWith(`<input type="hidden" class="params_ref_low" id="" name="" value="">`);
				$(this).closest('tr').find('.params_ref_high').replaceWith(`<input type="hidden" class="params_ref_high" id="" name="" value="">`);
				$(this).closest('tr').find('.params_norm').replaceWith(`<td class="params_norm" colspan="1"><input required placeholder="Valeurs usuelles" type="text" id="${index}values_p" name="old[${index}][values_p]" class="form-control equal" /></td>`);
			}
			if ($(this).closest('tr').find(":selected").val() == 'numerical') {
				$(this).closest('tr').find(".params_code").replaceWith(`<td class="params_unit" span="3" style="width: 10%;"><input required placeholder="Unité" type="text" data-role="tagsinput" id="${index}unit_p" name="old[${index}][unit_p]" class="form-control to_rl" /></td>`)
				$(this).closest('tr').find('.params_ref_low').replaceWith('<td class="params_ref_low" span="1" style="width: 10%;"><input required placeholder="Réféfence min" type="text" id="' + index + 'ref_low_p" name="old[' + index + '][ref_low_p]" class="form-control equal" /></td>')
				$(this).closest('tr').find('.params_ref_high').replaceWith('<td class="params_ref_high" span="1" style="width: 10%;"><input required placeholder="Référence max" type="text" id="' + index + 'ref_high_p" name="old[' + index + '][ref_high_p]" class="form-control equal" /></td>')
				$(this).closest('tr').find('.params_norm').replaceWith(`<td class="params_norm"><input required placeholder="Valeurs usuelles" type="text" id="${index}values_p" name="old[${index}][values_p]" class="form-control equal" /></td>`);
			}
			if ($(this).closest('tr').find(":selected").val() == 'textcode') {
				$(this).closest('tr').find(".params_code").html(``);
				$(this).closest('tr').find(".params_unit").html(``);
				$(this).closest('tr').find(".params_text").replaceWith(`<td class="params_text" colspan="3">
    <textarea data-role="tagsinput" id="${index}code_p" name="new[${index}][code_p]" cols="65" rows="10" placeholder="Texte  , Conclusion , ect..." class="params_code"></textarea>
</td>`)
				$(this).closest('tr').find('.params_ref_low').replaceWith(`<input type="hidden" class="params_ref_low" id="" name="" value="">`);
				$(this).closest('tr').find('.params_ref_high').replaceWith(`<input type="hidden" class="params_ref_high" id="" name="" value="">`);
				$(this).closest('tr').find('.params_norm').replaceWith(`<td class="params_norm" colspan="1"><input placeholder="Valeurs usuelles" type="hidden" id="${index}values_p" name="new[${index}][values_p]" class="form-control equal" /></td>`);
			}

			if ($(this).closest('tr').find(":selected").val() == 'section') {
				$(this).closest('tr').find(".params_code").html(``);
				$(this).closest('tr').find(".params_unit").html(``);
				$(this).closest('tr').find(".params_text").html(``);
				$(this).closest('tr').find(".params_sous_section").html(``);
				$(this).closest('tr').find(".params_text").replaceWith(`<td class="params_text" colspan="3">
    <textarea type="hidden" data-role="tagsinput" id="${index}code_p" name="new[${index}][code_p]" cols="65" rows="10" placeholder="Texte  , Conclusion , ect..." class="params_code"></textarea>
</td>`)
				$(this).closest('tr').find('.params_ref_low').replaceWith(`<input type="hidden" class="params_ref_low" id="" name="" value="">`);
				$(this).closest('tr').find('.params_ref_high').replaceWith(`<input type="hidden" class="params_ref_high" id="" name="" value="">`);
				$(this).closest('tr').find('.params_norm').replaceWith(`<td class="params_norm" colspan="1"><input placeholder="Valeurs usuelles" type="hidden" id="${index}values_p" name="new[${index}][values_p]" class="form-control equal" /></td>`);
			}

			if ($(this).closest('tr').find(":selected").val() == 'sous_section') {
				$(this).closest('tr').find(".params_code").html(``);
				$(this).closest('tr').find(".params_unit").html(``);
				$(this).closest('tr').find(".params_text").html(``);
				$(this).closest('tr').find(".params_section").html(``);
				$(this).closest('tr').find(".params_text").replaceWith(`<td class="params_text" colspan="3">
    <textarea type="hidden" data-role="tagsinput" id="${index}code_p" name="new[${index}][code_p]" cols="65" rows="10" placeholder="Texte  , Conclusion , ect..." class="params_code"></textarea>
</td>`)
				$(this).closest('tr').find('.params_ref_low').replaceWith(`<input type="hidden" class="params_ref_low" id="" name="" value="">`);
				$(this).closest('tr').find('.params_ref_high').replaceWith(`<input type="hidden" class="params_ref_high" id="" name="" value="">`);
				$(this).closest('tr').find('.params_norm').replaceWith(`<td class="params_norm" colspan="1"><input placeholder="Valeurs usuelles" type="hidden" id="${index}values_p" name="new[${index}][values_p]" class="form-control equal" /></td>`);
			}
		
		});

		$(document).on('click', '.remove-old', function() {
			let confirmAction = confirm('Êtes-vous sûr de vouloir supprimer ce paramètre')
			var idpara = $(this).closest('tr').find("#idpara_p").val();
			if (confirmAction) {
				if (para_rows > 1) {
					$(this).closest('tr').remove();
					para_rows--;
					if (para_rows == 1) {
						$('.remove').hide();
					}
				}

				if (para_rows2 > 1) {
					$(this).closest('tr').remove();
					para_rows2--;
					if (para_rows2 == 1) {
						$('.remove').hide();
					}
				}

					$.ajax({
						url: 'home/deletePrestationName?id=' + idpara,
						method: 'GET',
						data: '',
						dataType: 'json',
					}).success(function(response) {
						// Si succès: OK
						if (response == "OK") {
							alert('ok')
						} else if (response == "KO") {
							alert('not found')
						}
					});
			}

		});


		$(document).on('click', '.remove', function() {


		});


		/////////////////////////////////////////////////

		var editIcon = function(data, type, row) {
			if (type === 'display') {
				return '<img src="uploads/pen_2.png" style="width:12px;height:12px;margin-right:0.5em;" class="edit0"/>' + data;
			}
			return data;
		};

		var table = $('#editable-sample').DataTable({
			responsive: true,
			//   dom: 'lfrBtip',

			"processing": true,
			// "serverSide": true,
			"searchable": true,
			"ajax": {
				url: "home/getSuperPrestations",
				type: 'POST'
			},
			"columns": [{
					className: 'details-control',
					orderable: false,
					data: null,
					defaultContent: ''
				},
				// { "data": "prestation" , render: editIcon},
				// { "data": "prestation" , render: editIcon, className:     'underlinedClass'},
				{
					"data": "service"
				},
				{
					"data": "specialite",
					className: 'edit1',
					render: editIcon
				},
				{
					"data": "prestation",
					className: 'edit0',
					render: editIcon
				},
				{
					"data": "keywords"
				},
				{
					"data": "cotationCoefficiant"
				},
				
				// { "data": "options" }
				// { "data": null,	defaultContent: '-' }
			],

			createdRow: function(row, data, index) {
				if (data.service === '') {
					var td = $(row).find("td:first");
					td.removeClass('details-control');
				}
				$('td', row).eq(1).attr('id', 'td-' + index + '-1');
				$('td', row).eq(3).attr('id', 'td-' + index + '-3');
			},
			rowCallback: function(row, data, index) {
				console.log('rowCallback');
			},
			scroller: {
				loadingIndicator: true
			},
			columnDefs: [{
				targets: 4,
				searchable: true,
				visible: false
			}],
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
					// columns: [0,1,2],
					// }
					// },
					// {
					// extend: 'pdfHtml5',
					// className: 'dt-button-icon-left dt-button-icon-pdf',
					// exportOptions: {
					// columns: [0,1,2],
					// }
					// },
				],
				dom: {
					button: {
						className: 'h4 btn btn-secondary dt-button-custom'
					},
					buttonLiner: {
						tag: null
					}
				}
			},
			lengthMenu: [
				[10, 25, 50, 100, -1],
				['10', '25', '50', '100', 'Tout afficher']
			],
			iDisplayLength: 10,
			"order": [
				[0, "asc"]
			],
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

		table.buttons().container().appendTo('.custom_buttons');
		bigtable = table;
		iconhid = table;

		// Expand/Collpase All
		$('#editable-sample thead').on('click', 'th.btn-toggle-all-children', function() {
			// Expand row details
			table.rows(':not(.parent)').nodes().to$().find('td:first-child').trigger('click');
			if (!$(this).parent().hasClass("btn-toggle-shown")) {
				$(this).parent().addClass("btn-toggle-shown");
			} else {
				$(this).parent().removeClass("btn-toggle-shown");
			}

		});

		// Expand/Collapse Individual Add event listener for opening and closing details
		$('#editable-sample tbody').on('click', 'td.details-control', function() {
			// alert("ok1");
			var tr = $(this).closest('tr');
			var row = table.row(tr);



			if (row.child.isShown()) {
				// This row is already open - close it
				row.child.hide();
				tr.removeClass('shown');
			} else {



				// Open this row
				row.child(format(row.data())).show();
				getPrestationDetails(row.data());
				bigtable2 = row.data();

				tr.addClass('shown');

			}


		});

		function format(rowData) {
			// alert(rowData.id);
			// alert(rowData.type);
			var div = $("<div style='background-color:#EAEAEA;padding:10px;' />")
				.addClass('loading')
				.text('Chargement...');

			$.ajax({
				url: 'home/getSuperDuperPrestationDetails',
				method: 'GET',
				data: {
					idPrestation: rowData.id,
					typePrestation: rowData.type,
					nomPrestation: rowData.prestation,
					nomService: rowData.service

				},
				dataType: 'json',
				success: function(json) {
					// alert(json);


					div
						.html(json.html)
						.removeClass('loading');

				}
			});

			return div;
		}

		var removeElements = function(text, selector) {
			var wrapped = $("<div>" + text + "</div>");
			wrapped.find(selector).remove();
			return wrapped.html();
		}

		// Gestion Row Edit pour Row Supérieur

		// Nom Prestation
		// $('#editable-sample tbody').on( 'click', 'td img.edit0', function (e) {
		$('#editable-sample tbody').on('click', 'td.edit0', function(e) {

			$(this).removeClass("tooltips"); // Reset Elements laissés par Tooltip
			// Check si on rentre ou on sort (sortie via clic dans cellule pas dans cellule voisine)
			var witness = $(this).find("input").val();
			if (typeof(witness) == "undefined") { // S'assure que le clic out (dans la mme cellule pour sortir) n'est pas vu com un nouveau onclick
				var currentContent = $(this).html();
				var html2 = removeElements(currentContent, "img");
				var html2 = removeElements(html2, "span"); // Reset Elements laissés par Tooltip
				var newContent = '<input type="text" required name="edit" data-id="' + $('<div/>').text(html2).html() + '" value="' + $('<div/>').text(html2).html() + '" style="width:90%;color:#0d4d99;">' + '<img src="uploads/accept_cr.png" style="width:12px;height:12px;margin-left:0.5em;" class="valid0"/>' + '<img src="uploads/no_2.png" style="width:12px;height:12px;margin-left:0.5em;" class="cancel0"/>';
				$(this).html(newContent);
				$(this).find("input").focus();
			}

		}).on('blur', 'td.edit0', function(e) {

			var me = $(this); // Pour utilisant and ajax.success		
			var tdId = me.attr("id");
			$(this).append('<img src="uploads/loading-wheel.gif" style="width:15px;height:15px;margin-left:0.5em;" />');

			var previousContent = $(this).find("input").data('id');
			var currentContent = $(this).find("input").val();

			var tr = $(this).closest('tr');
			var row = table.row(tr);
			var idPrestation = row.data().id;
			var nomService = row.data().service;
			var cotation = row.data().cotation;
			var coefficient = row.data().coefficient;

			// Lancer Modification AJAX
			if (currentContent != "") { // Insertion uniquement si champ non vide
				$.ajax({
					url: 'home/editPrestationName',
					method: 'POST',
					data: {
						idPrestation: idPrestation,
						newName: currentContent,
						nomService: nomService,
						cotation: cotation,
						coefficient: coefficient
					}, 
					dataType: 'json',
				}).success(function(response) {
					// Si succès: OK
					if (response == "OK") {
						var html2 = currentContent;
						var newContent = '<img src="uploads/pen_2.png" style="width:12px;height:12px;margin-right:0.5em;" class="edit0"/>' + html2;
						me.addClass("tooltips"); // Début init Tooltip
						me.html(newContent);
						displayTooltipSuccess(tdId);
					} else if (response == "KO") {
						var html2 = previousContent;
						var newContent = '<img src="uploads/pen_2.png" style="width:12px;height:12px;margin-right:0.5em;" class="edit0"/>' + html2;
						me.addClass("tooltips"); // Début init Tooltip
						me.html(newContent);
						displayTooltipError(tdId, "Cette prestation existe déjà");
					}
				});
			} else {
				var html2 = previousContent;
				var newContent = '<img src="uploads/pen_2.png" style="width:12px;height:12px;margin-right:0.5em;" class="edit0"/>' + html2;
				me.addClass("tooltips"); // Début init Tooltip
				me.html(newContent);
				displayTooltipError(tdId, "Vous devez saisir un nom");
			}
		});


		$('#editable-sample tbody').on('click', 'td.edit0 input', function(e) { // Just to stop propagation: en cas de clic sur L'input - evite de retrigger l'event above alors qu'on est pas sorti
			e.stopPropagation();
		});

		// Liste déroulante pour Spécialité
		$('#editable-sample tbody').on('click', 'td.edit1', function(e) {

			var me = $(this);

			$(this).removeClass("tooltips"); // Reset Elements laissés par Tooltip
			// Check si on rentre ou on sort (sortie via clic dans cellule pas dans cellule voisine)
			var witness = $(this).find("select").val();
			if (typeof(witness) == "undefined") { // S'assure que le clic out (dans la mme cellule pour sortir) n'est pas vu com un nouveau onclick
				var currentContent = $(this).html();
				var html2 = removeElements(currentContent, "img");
				var html2 = removeElements(html2, "span"); // Reset Elements laissés par Tooltip

				$(this).append('<img src="uploads/loading-wheel.gif" style="width:15px;height:15px;margin-left:0.5em;" />');

				var tr = $(this).closest('tr');
				var row = table.row(tr);
				var idPrestation = row.data().id;
				var nomService = row.data().service;
				var nomSpecialite = row.data().specialite;

				$.ajax({
					url: 'home/getListeSpecialites',
					method: 'GET',
					data: {
						idPrestation: idPrestation,
						nomService: nomService,
						nomSpecialite: nomSpecialite
					},
					dataType: 'json',
				}).success(function(response) {
					// Si succès: OK
					var newContent = '<select class="form-control" data-id="' + $('<div/>').text(html2).html() + '" style="padding:0 !important" name="select_specialite">' + response + '</select>' + '<img src="uploads/accept_cr.png" style="width:12px;height:12px;margin-left:0.5em;" class="valid1"/>' + '<img src="uploads/no_2.png" style="width:12px;height:12px;margin-left:0.5em;" class="cancel1"/>';
					me.html(newContent);
					me.find("select").focus();
					console.log(response);
				});

				// var newContent = '<input type="text" required name="edit" data-id="'+$('<div/>').text(html2).html()+'" value="'+$('<div/>').text(html2).html()+'" style="width:90%;color:#0d4d99;">'+'<img src="uploads/accept_cr.png" style="width:12px;height:12px;margin-left:0.5em;" class="valid0"/>'+'<img src="uploads/no_2.png" style="width:12px;height:12px;margin-left:0.5em;" class="cancel0"/>';
			}

		}).on('blur', 'td.edit1', function(e) {

			var me = $(this); // Pour utilisant and ajax.success		
			var tdId = me.attr("id");
			$(this).append('<img src="uploads/loading-wheel.gif" style="width:15px;height:15px;margin-left:0.5em;" />');

			var previousContent = $(this).find("select").data('id');
			var currentContent = $(this).find("select").val();

			var tr = $(this).closest('tr');
			var row = table.row(tr);
			var idPrestation = row.data().id;
			var nomService = row.data().service;

			// Lancer Modification AJAX
			if (currentContent != "") { // Insertion uniquement si champ non vide
				$.ajax({
					url: 'home/editPrestationSpecialite',
					method: 'POST',
					data: {
						idPrestation: idPrestation,
						newSpecialite: currentContent,
						nomService: nomService
					},
					dataType: 'json',
				}).success(function(response) {
					// Si succès: OK
					if (response == "OK") {
						var html2 = currentContent;
						var newContent = '<img src="uploads/pen_2.png" style="width:12px;height:12px;margin-right:0.5em;" class="edit0"/>' + html2;
						me.addClass("tooltips"); // Début init Tooltip
						me.html(newContent);
						displayTooltipSuccess(tdId);
					} else if (response == "KO") {
						var html2 = previousContent;
						var newContent = '<img src="uploads/pen_2.png" style="width:12px;height:12px;margin-right:0.5em;" class="edit0"/>' + html2;
						me.addClass("tooltips"); // Début init Tooltip
						me.html(newContent);
						// displayTooltipError(tdId, "Cette prestation existe déjà");
						displayTooltipError(tdId, "Errreur lors de la mise à jour");
					}
				});
			} else { // Ne devrait jamais se produire
				var html2 = previousContent;
				var newContent = '<img src="uploads/pen_2.png" style="width:12px;height:12px;margin-right:0.5em;" class="edit0"/>' + html2;
				me.addClass("tooltips"); // Début init Tooltip
				me.html(newContent);
				displayTooltipError(tdId, "Vous devez sélectionner une spécialité");
			}
		});


		$('#editable-sample tbody').on('click', 'td.edit1 select', function(e) { // Just to stop propagation: en cas de clic sur L'input - evite de retrigger l'event above alors qu'on est pas sorti
			e.stopPropagation();
		});

		// Gestion Row Edit pour Détails Prestation

		// Description
		$('#editable-sample tbody').on('click', 'td.edit00', function(e) {
			$(this).removeClass("tooltips"); // Reset Elements laissés par Tooltip

			var witness = $(this).find("textarea").val();
			if (typeof(witness) == "undefined") {
				var currentContent = $(this).html();
				var html2 = removeElements(currentContent, "img");
				var html2 = removeElements(html2, "span"); // Reset Elements laissés par Tooltip
				var html2Buff = html2 == "Non fournie" ? "" : html2; // Reset Elements laissés par Tooltip
				var newContent = '<textarea  name="edit" data-id="' + $('<div/>').text(html2).html() + '" value="' + html2Buff + '" style="width:80%;color:#0d4d99;">' + html2Buff + '</textarea>';
				$(this).html(newContent);
				$(this).find('textarea').focus();
			}
		}).on('blur', 'td.edit00', function(e) {

			var me = $(this); // Pour utilisant and ajax.success			
			var tdId = me.attr("id");
			// // Affichage chargement
			$(this).append('<img src="uploads/loading-wheel.gif" style="width:15px;height:15px;margin-left:0.5em;" />');

			var previousContent = $(this).find("textarea").data('id');
			var currentContent = $(this).find("textarea").val();

			var domEl = $(this).parent().parent().parent().parent().parent().find("table");
			var buff00 = domEl.data("id").split("@@@@");
			var idPrestation = buff00[1];

			// var nomService = buff00[0];
			// Lancer Modification AJAX
			$.ajax({
				url: 'home/editPrestationDescription',
				method: 'POST',
				data: {
					idPrestation: idPrestation,
					newDescription: currentContent
				},
				dataType: 'json',
			}).success(function(response) {
				if (response == "OK") {
					var html2 = currentContent;
					var newContent = '<img src="uploads/pen_2.png" style="width:12px;height:12px;margin-right:0.5em;" class="edit00"/>' + html2;
					me.addClass("tooltips"); // Début init Tooltip
					me.html(newContent);
					displayTooltipSuccess(tdId);
				} else if (response == "KO") {
					var html2 = previousContent;
					var newContent = '<img src="uploads/pen_2.png" style="width:12px;height:12px;margin-right:0.5em;" class="edit00"/>' + html2;
					me.addClass("tooltips"); // Début init Tooltip
					me.html(newContent);
					displayTooltipError(tdId, "Erreur lors de l'insertion");
				}
			});
		});


		$('#editable-sample tbody').on('click', 'td.edit00 textarea', function(e) {
			e.stopPropagation();
		});

		// Keywords
		$('#editable-sample tbody').on('click', 'td.edit01', function(e) {
			$(this).removeClass("tooltips"); // Reset Elements laissés par Tooltip

			var witness = $(this).find("input").val();
			if (typeof(witness) == "undefined") {
				var currentContent = $(this).html();
				var html2 = removeElements(currentContent, "img");
				var html2 = removeElements(html2, "span"); // Reset Elements laissés par Tooltip
				var html2Buff = html2 == "Non fournie" ? "" : html2; // Reset Elements laissés par Tooltip
				var newContent = '<input type="text" name="edit" data-id="' + $('<div/>').text(html2).html() + '" value="' + $('<div/>').text(html2Buff).html() + '" style="width:80%;color:#0d4d99;">' + '<img src="uploads/accept_cr.png" style="width:12px;height:12px;margin-left:0.5em;" class="valid01"/>' + '<img src="uploads/no_2.png" style="width:12px;height:12px;margin-left:0.5em;" class="cancel01"/>';
				$(this).html(newContent);
				$(this).find('input').focus();
			}
		}).on('blur', 'td.edit01', function(e) {

			var me = $(this); // Pour utilisant and ajax.success			
			var tdId = me.attr("id");
			// // Affichage chargement
			$(this).append('<img src="uploads/loading-wheel.gif" style="width:15px;height:15px;margin-left:0.5em;" />');

			var previousContent = $(this).find("input").data('id');
			var currentContent = $(this).find("input").val();

			var domEl = $(this).parent().parent().parent().parent().parent().find("table");
			var buff00 = domEl.data("id").split("@@@@");
			var idPrestation = buff00[1];

			// var nomService = buff00[0];
			// Lancer Modification AJAX
			$.ajax({
				url: 'home/editPrestationKeywords',
				method: 'POST',
				data: {
					idPrestation: idPrestation,
					newKeywords: currentContent
				},
				dataType: 'json',
			}).success(function(response) {
				if (response == "OK") {
					var html2 = currentContent;
					var newContent = '<img src="uploads/pen_2.png" style="width:12px;height:12px;margin-right:0.5em;" class="edit01"/>' + html2;
					me.addClass("tooltips"); // Début init Tooltip
					me.html(newContent);
					displayTooltipSuccess(tdId);
				} else if (response == "KO") {
					var html2 = previousContent;
					var newContent = '<img src="uploads/pen_2.png" style="width:12px;height:12px;margin-right:0.5em;" class="edit01"/>' + html2;
					me.addClass("tooltips"); // Début init Tooltip
					me.html(newContent);
					displayTooltipError(tdId, "Erreur lors de l'insertion");
				}
			});
		});


		$('#editable-sample tbody').on('click', 'td.edit01 input', function(e) {
			e.stopPropagation();
		});

		// Params

		//Nom
		$('#editable-sample tbody').on('click', 'td.edit021', function(e) {
			$(this).removeClass("tooltips"); // Reset Elements laissés par Tooltip

			var witness = $(this).find("input").val();
			if (typeof(witness) == "undefined") {
				var currentContent = $(this).html();
				var html2 = removeElements(currentContent, "img");
				var html2 = removeElements(html2, "span"); // Reset Elements laissés par Tooltip
				var html2Buff = html2 == "Non fournie" ? "" : html2; // Reset Elements laissés par Tooltip
				var newContent = '<input required type="text" name="edit" data-id="' + $('<div/>').text(html2).html() + '" value="' + $('<div/>').text(html2Buff).html() + '" style="width:80%;color:#0d4d99;">' + '<img src="uploads/accept_cr.png" style="width:12px;height:12px;margin-left:0.5em;" class="valid021"/>' + '<img src="uploads/no_2.png" style="width:12px;height:12px;margin-left:0.5em;" class="cancel021"/>';
				$(this).html(newContent);
				$(this).find('input').focus();
			}
		}).on('blur', 'td.edit021', function(e) {

			var me = $(this); // Pour utilisant and ajax.success			
			var tdId = me.attr("id");
			// Affichage chargement
			$(this).append('<img src="uploads/loading-wheel.gif" style="width:15px;height:15px;margin-left:0.5em;" />');

			var previousContent = $(this).find("input").data('id');
			var currentContent = $(this).find("input").val();

			var domEl = $(this).parent().parent().parent().parent().parent().find("table");
			var buff00 = domEl.data("id").split("@@@@");
			var idPrestation = buff00[1];
			var buffParam = tdId.split("-");
			var idParametre = buffParam[2];

			// // var nomService = buff00[0];
			// // Lancer Modification AJAX
			if (currentContent != "") {
				$.ajax({
					url: 'home/editParamName',
					method: 'POST',
					data: {
						idPrestation: idPrestation,
						idParametre: idParametre,
						newName: currentContent
					},
					dataType: 'json',
				}).success(function(response) {
					if (response == "OK") {
						var html2 = currentContent;
						var newContent = '<img src="uploads/pen_2.png" style="width:12px;height:12px;margin-right:0.5em;" class="edit021"/>' + html2;
						me.addClass("tooltips"); // Début init Tooltip
						me.html(newContent);
						displayTooltipSuccess(tdId);
					} else if (response == "KO") {
						var html2 = previousContent;
						var newContent = '<img src="uploads/pen_2.png" style="width:12px;height:12px;margin-right:0.5em;" class="edit021"/>' + html2;
						me.addClass("tooltips"); // Début init Tooltip
						me.html(newContent);
						displayTooltipError(tdId, "Ce paramètre existe déjà");
					}
				});
			} else {
				var html2 = previousContent;
				var newContent = '<img src="uploads/pen_2.png" style="width:12px;height:12px;margin-right:0.5em;" class="edit021"/>' + html2;
				me.addClass("tooltips"); // Début init Tooltip
				me.html(newContent);
				displayTooltipError(tdId, "Vous devez saisir un nom");
			}
		});

		$('#editable-sample tbody').on('click', 'td.edit021 input', function(e) {
			e.stopPropagation();
		});

		// Unite
		$('#editable-sample tbody').on('click', 'td.edit022', function(e) {
			$(this).removeClass("tooltips"); // Reset Elements laissés par Tooltip

			var witness = $(this).find("input").val();
			if (typeof(witness) == "undefined") {
				var currentContent = $(this).html();
				var html2 = removeElements(currentContent, "img");
				var html2 = removeElements(html2, "span"); // Reset Elements laissés par Tooltip
				var html2Buff = html2 == "Non fournie" ? "" : html2; // Reset Elements laissés par Tooltip
				var newContent = '<input type="text" name="edit" data-id="' + $('<div/>').text(html2).html() + '" value="' + $('<div/>').text(html2Buff).html() + '" style="width:80%;color:#0d4d99;">' + '<img src="uploads/accept_cr.png" style="width:12px;height:12px;margin-left:0.5em;" class="valid022"/>' + '<img src="uploads/no_2.png" style="width:12px;height:12px;margin-left:0.5em;" class="cancel022"/>';
				$(this).html(newContent);
				$(this).find('input').focus();
			}
		}).on('blur', 'td.edit022', function(e) {

			var me = $(this); // Pour utilisant and ajax.success			
			var tdId = me.attr("id");
			// Affichage chargement
			$(this).append('<img src="uploads/loading-wheel.gif" style="width:15px;height:15px;margin-left:0.5em;" />');

			var previousContent = $(this).find("input").data('id');
			var currentContent = $(this).find("input").val();

			// var domEl = $(this).parent().parent().parent().parent().parent().find("table");
			// var buff00 = domEl.data("id").split("@@@@");
			// var idPrestation = buff00[1];
			var buffParam = tdId.split("-");
			var idParametre = buffParam[2];

			// // var nomService = buff00[0];
			// // Lancer Modification AJAX
			$.ajax({
				url: 'home/editParamUnite',
				method: 'POST',
				data: {
					idParametre: idParametre,
					newUnite: currentContent
				},
				dataType: 'json',
			}).success(function(response) {
				if (response == "OK") {
					var html2 = currentContent;
					var newContent = '<img src="uploads/pen_2.png" style="width:12px;height:12px;margin-right:0.5em;" class="edit022"/>' + html2;
					me.addClass("tooltips"); // Début init Tooltip
					me.html(newContent);
					displayTooltipSuccess(tdId);
				} else if (response == "KO") {
					var html2 = previousContent;
					var newContent = '<img src="uploads/pen_2.png" style="width:12px;height:12px;margin-right:0.5em;" class="edit022"/>' + html2;
					me.addClass("tooltips"); // Début init Tooltip
					me.html(newContent);
					displayTooltipError(tdId, "Erreur lors de l'insertion");
				}
			});
		});

		$('#editable-sample tbody').on('click', 'td.edit022 input', function(e) {
			e.stopPropagation();
		});

		// Valeurs
		$('#editable-sample tbody').on('click', 'td.edit023', function(e) {
			$(this).removeClass("tooltips"); // Reset Elements laissés par Tooltip

			var witness = $(this).find("input").val();
			if (typeof(witness) == "undefined") {
				var currentContent = $(this).html();
				var html2 = removeElements(currentContent, "img");
				var html2 = removeElements(html2, "span"); // Reset Elements laissés par Tooltip
				var html2Buff = html2 == "Non fournie" ? "" : html2; // Reset Elements laissés par Tooltip
				var newContent = '<input type="text" name="edit" data-id="' + $('<div/>').text(html2).html() + '" value="' + $('<div/>').text(html2Buff).html() + '" style="width:80%;color:#0d4d99;">' + '<img src="uploads/accept_cr.png" style="width:12px;height:12px;margin-left:0.5em;" class="valid023"/>' + '<img src="uploads/no_2.png" style="width:12px;height:12px;margin-left:0.5em;" class="cancel023"/>';
				$(this).html(newContent);
				$(this).find('input').focus();
			}
		}).on('blur', 'td.edit023', function(e) {

			var me = $(this); // Pour utilisant and ajax.success			
			var tdId = me.attr("id");
			// Affichage chargement
			$(this).append('<img src="uploads/loading-wheel.gif" style="width:15px;height:15px;margin-left:0.5em;" />');

			var previousContent = $(this).find("input").data('id');
			var currentContent = $(this).find("input").val();

			// var domEl = $(this).parent().parent().parent().parent().parent().find("table");
			// var buff00 = domEl.data("id").split("@@@@");
			// var idPrestation = buff00[1];
			var buffParam = tdId.split("-");
			var idParametre = buffParam[2];

			// // var nomService = buff00[0];
			// // Lancer Modification AJAX
			$.ajax({
				url: 'home/editParamValeurs',
				method: 'POST',
				data: {
					idParametre: idParametre,
					newValeurs: currentContent
				},
				dataType: 'json',
			}).success(function(response) {
				if (response == "OK") {
					var html2 = currentContent;
					var newContent = '<img src="uploads/pen_2.png" style="width:12px;height:12px;margin-right:0.5em;" class="edit023"/>' + html2;
					me.addClass("tooltips"); // Début init Tooltip
					me.html(newContent);
					displayTooltipSuccess(tdId);
				} else if (response == "KO") {
					var html2 = previousContent;
					var newContent = '<img src="uploads/pen_2.png" style="width:12px;height:12px;margin-right:0.5em;" class="edit023"/>' + html2;
					me.addClass("tooltips"); // Début init Tooltip
					me.html(newContent);
					displayTooltipError(tdId, "Erreur lors de l'insertion");
				}
			});
		});

		$('#editable-sample tbody').on('click', 'td.edit023 input', function(e) {
			e.stopPropagation();
		});




		/////////////////////////////////////////////////////////
		// Refe Low
		$('#editable-sample tbody').on('click', 'td.edit024', function(e) {
			$(this).removeClass("tooltips"); // Reset Elements laissés par Tooltip

			var witness = $(this).find("input").val();
			if (typeof(witness) == "undefined") {
				var currentContent = $(this).html();
				var html2 = removeElements(currentContent, "img");
				var html2 = removeElements(html2, "span"); // Reset Elements laissés par Tooltip
				var html2Buff = html2 == "Non fournie" ? "" : html2; // Reset Elements laissés par Tooltip
				var newContent = '<input type="text" name="edit" data-id="' + $('<div/>').text(html2).html() + '" value="' + $('<div/>').text(html2Buff).html() + '" style="width:80%;color:#0d4d99;">' + '<img src="uploads/accept_cr.png" style="width:12px;height:12px;margin-left:0.5em;" class="valid024"/>' + '<img src="uploads/no_2.png" style="width:12px;height:12px;margin-left:0.5em;" class="cancel024"/>';
				$(this).html(newContent);
				$(this).find('input').focus();
			}
		}).on('blur', 'td.edit024', function(e) {

			var me = $(this); // Pour utilisant and ajax.success			
			var tdId = me.attr("id");
			// Affichage chargement
			$(this).append('<img src="uploads/loading-wheel.gif" style="width:15px;height:15px;margin-left:0.5em;" />');

			var previousContent = $(this).find("input").data('id');
			var currentContent = $(this).find("input").val();

			// var domEl = $(this).parent().parent().parent().parent().parent().find("table");
			// var buff00 = domEl.data("id").split("@@@@");
			// var idPrestation = buff00[1];
			var buffParam = tdId.split("-");
			var idParametre = buffParam[2];

			// // var nomService = buff00[0];
			// // Lancer Modification AJAX
			$.ajax({
				url: 'home/editRefLow',
				method: 'POST',
				data: {
					idParametre: idParametre,
					newRefLow: currentContent
				},
				dataType: 'json',
			}).success(function(response) {
				if (response == "OK") {
					var html2 = currentContent;
					var newContent = '<img src="uploads/pen_2.png" style="width:12px;height:12px;margin-right:0.5em;" class="edit024"/>' + html2;
					me.addClass("tooltips"); // Début init Tooltip
					me.html(newContent);
					displayTooltipSuccess(tdId);
				} else if (response == "KO") {
					var html2 = previousContent;
					var newContent = '<img src="uploads/pen_2.png" style="width:12px;height:12px;margin-right:0.5em;" class="edit024"/>' + html2;
					me.addClass("tooltips"); // Début init Tooltip
					me.html(newContent);
					displayTooltipError(tdId, "Erreur lors de l'insertion");
				}
			});
		});

		$('#editable-sample tbody').on('click', 'td.edit024 input', function(e) {
			e.stopPropagation();
		});





		///////////////////////////////////////////////////////////



		/////////////////////////////////////////////////////////
		// Refe 
		$('#editable-sample tbody').on('click', 'td.edit025', function(e) {
			$(this).removeClass("tooltips"); // Reset Elements laissés par Tooltip

			var witness = $(this).find("input").val();
			if (typeof(witness) == "undefined") {
				var currentContent = $(this).html();
				var html2 = removeElements(currentContent, "img");
				var html2 = removeElements(html2, "span"); // Reset Elements laissés par Tooltip
				var html2Buff = html2 == "Non fournie" ? "" : html2; // Reset Elements laissés par Tooltip
				var newContent = '<input type="text" name="edit" data-id="' + $('<div/>').text(html2).html() + '" value="' + $('<div/>').text(html2Buff).html() + '" style="width:80%;color:#0d4d99;">' + '<img src="uploads/accept_cr.png" style="width:12px;height:12px;margin-left:0.5em;" class="valid024"/>' + '<img src="uploads/no_2.png" style="width:12px;height:12px;margin-left:0.5em;" class="cancel024"/>';
				$(this).html(newContent);
				$(this).find('input').focus();
			}
		}).on('blur', 'td.edit025', function(e) {

			var me = $(this); // Pour utilisant and ajax.success			
			var tdId = me.attr("id");
			// Affichage chargement
			$(this).append('<img src="uploads/loading-wheel.gif" style="width:15px;height:15px;margin-left:0.5em;" />');

			var previousContent = $(this).find("input").data('id');
			var currentContent = $(this).find("input").val();

			// var domEl = $(this).parent().parent().parent().parent().parent().find("table");
			// var buff00 = domEl.data("id").split("@@@@");
			// var idPrestation = buff00[1];
			var buffParam = tdId.split("-");
			var idParametre = buffParam[2];

			// // var nomService = buff00[0];
			// // Lancer Modification AJAX
			$.ajax({
				url: 'home/editRefHigh',
				method: 'POST',
				data: {
					idParametre: idParametre,
					newRefHigh: currentContent
				},
				dataType: 'json',
			}).success(function(response) {
				if (response == "OK") {
					var html2 = currentContent;
					var newContent = '<img src="uploads/pen_2.png" style="width:12px;height:12px;margin-right:0.5em;" class="edit025"/>' + html2;
					me.addClass("tooltips"); // Début init Tooltip
					me.html(newContent);
					displayTooltipSuccess(tdId);
				} else if (response == "KO") {
					var html2 = previousContent;
					var newContent = '<img src="uploads/pen_2.png" style="width:12px;height:12px;margin-right:0.5em;" class="edit025"/>' + html2;
					me.addClass("tooltips"); // Début init Tooltip
					me.html(newContent);
					displayTooltipError(tdId, "Erreur lors de l'insertion");
				}
			});
		});

		$('#editable-sample tbody').on('click', 'td.edit025 input', function(e) {
			e.stopPropagation();
		});





		///////////////////////////////////////////////////////////


		function displayTooltipSuccess(tdId) {
			// Tooltips Begin
			$("#" + tdId).append("<span></span>");
			$('.tooltips:not([tooltip-position])').attr('tooltip-position', 'right');
			$('.tooltips:not([tooltip-type])').attr('tooltip-type', 'primary');
			$("#" + tdId).find('span').empty().append("Modifié avec succès");
			$("#" + tdId).find("span").delay(1000).fadeOut();
		}

		function displayTooltipError(tdId, error) {
			// Tooltips Begin
			$("#" + tdId).append("<span></span>");
			$('.tooltips:not([tooltip-position])').attr('tooltip-position', 'right');
			$('.tooltips:not([tooltip-type])').attr('tooltip-type', 'danger');
			$("#" + tdId).find('span').empty().append(error);
			$("#" + tdId).find("span").delay(2000).fadeOut();
		}
	});
</script>
<script>
	$(document).ready(function() {
		// $(".flashmessage").delay(3000).fadeOut(100);

		$(".downloadbutton").click(function(e) {
			e.preventDefault(e);
			// Get the record's ID via attribute  
			$('#myModal2').modal('show');
		});
		$(".downloadbutton2").click(function(e) {
			e.preventDefault(e);
			// Get the record's ID via attribute  
			$('#myModal2backup').modal('show');
		});
		$(".displayParamLink").click(function(e) {
			e.preventDefault(e);
			var id = $(this).attr("id").split("-")[1];
			$("#paramsFor-" + id).toggle("fast");
		});





	});
</script>