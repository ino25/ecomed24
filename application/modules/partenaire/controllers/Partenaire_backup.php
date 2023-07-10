<?php
require_once FCPATH . '/vendor/autoload.php';

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Partenaire extends MX_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('partenaire_model');
		$this->load->model('finance/finance_model');
		$this->load->model('patient/patient_model');
		$this->load->model('home/home_model');
		$this->load->module('sms');
		// Bulk
		$this->load->library('Excel');
		$this->load->model('finance/import_model');
		$this->load->helper('file');
		$this->load->model('services/service_model');

		if (!$this->ion_auth->in_group(array('admin'))) {
			//redirect('home/permission');
		}

		$identity = $this->session->userdata["identity"];
		$this->id_organisation = $this->home_model->get_id_organisation($identity);
		$this->path_logo = $this->home_model->get_logo_organisation($this->id_organisation);
		$this->nom_organisation = $this->home_model->get_nom_organisation($this->id_organisation);
		$this->id_partenaire_zuuluPay = $this->home_model->id_partenaire_zuuluPay($this->id_organisation);
		$this->pin_partenaire_zuuluPay_encrypted = $this->home_model->pin_partenaire_zuuluPay_encrypted($this->id_organisation);
		$this->code_organisation = $this->home_model->get_code_organisation($this->id_organisation);
	}

	public function index()
	{

		if (!$this->ion_auth->logged_in()) {
			redirect('auth/login', 'refresh');
		} else {

			$data['partenaires'] = $this->partenaire_model->getPartenaires($this->id_organisation);
			$data['settings'] = $this->settings_model->getSettings();

			$data['id_organisation'] = $this->id_organisation;
			$data['path_logo'] = $this->path_logo;
			$data['nom_organisation'] = $this->nom_organisation;

			$this->load->view('home/dashboard', $data);
			$this->load->view('partenaire', $data);
			$this->load->view('home/footer');
		}
	}

	function getPartenaires() {
		$requestData = $_REQUEST;
		$start = $requestData['start'];
		$limit = $requestData['length'];
		$search = $this->input->post('search')['value'];

		$settings = $this->settings_model->getSettings();

		if ($limit == -1) {
			if (!empty($search)) {
				$data['partenaires'] = $this->partenaire_model->getTablePartenairesBySearch($search, $this->id_organisation);
			} else {
				$data['partenaires'] = $this->partenaire_model->getTablePartenaires($this->id_organisation);
			}
		} else {
			if (!empty($search)) {
				$data['partenaires'] = $this->partenaire_model->getTablePartenairesByLimitBySearch($limit, $start, $search, $this->id_organisation);
			} else {
				$data['partenaires'] = $this->partenaire_model->getTablePartenairesByLimit($limit, $start, $this->id_organisation);
			}
		}
//        if ($Payment_encours) {
//            $data['payments'] = $this->finance_model->getPaymentByFilter($this->id_organisation, $Payment_encours);
//        } else {
//            $data['payments'] = $this->finance_model->getPayment($this->id_organisation);
//        }
		$i = 0;
		foreach ($data['partenaires'] as $partenaire) {
			$i++;

			$status = '';
			if ($partenaire->partenariat_actif == '1') {
				$status = '<span class="status-p bg-success">ACTIF</span>';
				// $status = '';
			} else {
				$status = '<span class="status-p bg-success2">INACTIF</span>';
			}

			$img_url = '';
			if ($partenaire->path_logo && !empty($partenaire->path_logo)) {
				$img_url = '<img style="max-width:200px;max-height:90px;" src="'.$partenaire->path_logo.'" alt="Lgo">';
			} else {
				$img_url = '<img style="max-width:200px;max-height:90px;" src="uploads/logosPartenaires/default.png" alt="Lgo">';
			}
			$partenairetype = 'Sous-traitance';
			if($partenaire->is_light == 1) {
				$partenairetype = 'Prestataire'; }

			$info[] = array(
				'prt'.$partenaire->is_light,
				$img_url,
				$partenaire->nom,
				$partenaire->type,
				$partenaire->adresse,
				$status,
				$partenaire->date_created,
				$partenairetype,
			);
		}

		if(!empty($data['partenaires']) && trim($search)) {
			$output = array(
				"draw" => intval($requestData['draw']),
				"recordsTotal" => count($this->partenaire_model->getTablePartenaires($this->id_organisation)),
				"recordsFiltered" => count($this->partenaire_model->getTablePartenairesBysearch($search, $this->id_organisation)),
				"data" => $info
			);
		} else if (!empty($data['partenaires'])) {
			$output = array(
				"draw" => intval($requestData['draw']),
				"recordsTotal" => count($this->partenaire_model->getTablePartenaires($this->id_organisation)),
				"recordsFiltered" => count($this->partenaire_model->getTablePartenaires($this->id_organisation)),
				"data" => $info
			);
		} else {
			$output = array(
				// "draw" => 1,
				"recordsTotal" => 0,
				"recordsFiltered" => 0,
				"data" => []
			);
		}

		echo json_encode($output);
	}

	public function factures()
	{

		if (!$this->ion_auth->in_group(array('Receptionist', 'Assistant', 'admin', 'adminmedecin'))) {
			redirect('home/permission');
		}

		if (!$this->ion_auth->logged_in()) {
			redirect('auth/login', 'refresh');
		} else {
			$i = 0;

			$origins = $this->partenaire_model->payListeFactureByGroup($this->id_organisation, 1, 'demandpay', 'finish');
			$info = array();
			// $payments = $this->finance_model->getStatusPaymentByTraitance(1,'finish' ,$this->id_organisation);
			foreach ($origins as $payment) {
				if ($this->id_organisation == $payment->id_organisation || $this->id_organisation == $payment->organisation_destinataire) {
					//  if ($this->id_organisation == $payment->organisation_destinataire) {
					//   $cree_par = $this->partenaire_model->getPartenairesById($payment->id_organisation)->nom;
					isset($payment->organisation_destinataire) ? $cree_par = $this->partenaire_model->getPartenairesById($payment->organisation_destinataire)->nom : $cree_par = '';
					//  var_dump($payment->id .'--$this->id_organisation---'.$this->id_organisation.'--$payment->id_organisation--'.$payment->id_organisation.'--$payment->organisation_destinataire--'.$payment->organisation_destinataire);
					if ($payment->etat == 1) {
						$date = date('d/m/Y H:i', $payment->date);
						$status = '';
						if ($payment->status == 'accept') {
							$status = '<span class="status-p bg-danger">' . lang('demandpay_') . '</span>';
						}
						if ($payment->status == 'finish') {
							$status = '<span class="status-p bg-success">' . lang('finish_') . '</span>';
						}
						$options2 = '<a class="btn green btn-xs_ invoicebutton payment" title="' . lang('invoice_f') . '" style="color: #fff;" href="partenaire/genereFactures2?id=' . $payment->code . '"><i class="fa fa-plus-circle"></i> ' . lang('invoice_f') . '</a>';

						//  $options2 = '  <span id="depot' . $payment->id . '" class="green btn depositbutton payment" onclick="depositbutton(' . $payment->id . ')"  data-gross_total="' . $payment->gross_total . '"  data-amount_received="' . $payment->amount_received . '" data-payment="' . $payment->id . '" data-patient="' . $payment->patient . '" style="" ><i class="fa fa-plus-circle"></i> ' . lang('paye') . '</span>';
						// if ($payment->gross_total > $payment->amount_received && $payment->organisation_destinataire && $this->id_organisation == $payment->organisation_destinataire) {
						if ($payment->status_paid_pro != "paid" && $payment->organisation_destinataire && $this->id_organisation == $payment->organisation_destinataire) {
							if ($payment->status == 'accept') {
								$status = '<span class="status-p bg-success">' . lang('demandpay_') . '</span>';
								//$options2 = '';
							}
						}
						if ($payment->status_paid_pro != "paid" && $payment->id_organisation && $this->id_organisation == $payment->id_organisation) {
							if ($payment->status == 'accept') {
								$status = '<span class="status-p bg-danger">' . lang('demandpay_') . '</span>';
								//$options2 = '';
							}
						}
						// BLOC FINAL
						if ($payment->status_paid_pro == "paid") {
							$status = '<span class="status-p bg-success" style="text-transform:uppercase;">Payé</span>';
						} else if ($payment->status_paid_pro == "unpaid") {
							if ($payment->organisation_destinataire && $this->id_organisation == $payment->organisation_destinataire) {
								$status = '<span class="status-p bg-danger" style="text-transform:uppercase;">A Payer</span>';
							}
							if ($payment->id_organisation && $this->id_organisation == $payment->id_organisation) {
								$status = '<span class="status-p bg-danger" style="text-transform:uppercase;">En attente du paiement</span>';
							}
						} else if ($payment->status_paid_pro == "pending") {
							$status = '<span class="status-p" style="background-color:#0A3B76;text-transform:uppercase;font-size:95%;">En attente de validation <i class="fa fa-hourglass-half"></i></span>';
						}
						// BLOC FINAL
						$cumul_tarifs_pros_pour_prestations = 0;
						$category_name = $payment->category_name_pro;

						if ($category_name) {
							$buff0 = explode(',', $category_name);
							foreach ($buff0 as $presta) {
								$buff0_1 = explode("*", $presta);
								$cumul_tarifs_pros_pour_prestations += intval($buff0_1[1]); //$this->partenaire_model->prixPro($buff0_1[0]);
							}
						}

						$status_paid = '';
						if ($payment->status_paid_pro == "unpaid") {
							$status_paid = "nonpaye";
						} else if ($payment->status_paid_pro == "paid") {
							$status_paid = "paie";
						}
						$info[] = array(
							$status_paid,
							$date, $payment->code, $cree_par, $payment->nom,
							number_format($payment->gross_total, 0, ",", ".") . ' ' . $this->settings_model->getSettings()->currency,
							'<span id="status-change' . $payment->id . '">' . $status . '</span>',
							$options2
						);
					}
				}
			}
			$data['listeCommandes'] = $info;


			$data['settings'] = $this->settings_model->getSettings();

			$data['id_organisation'] = $this->id_organisation;
			$data['path_logo'] = $this->path_logo;
			$data['nom_organisation'] = $this->nom_organisation;

			$this->load->view('home/dashboard', $data);
			$this->load->view('facture', $data);
			$this->load->view('home/footer');
		}
	}

	function getFactures() {
		$requestData = $_REQUEST;
		$start = $requestData['start'];
		$limit = $requestData['length'];
		$search = $this->input->post('search')['value'];

		$settings = $this->settings_model->getSettings();

		if ($limit == -1) {
			if (!empty($search)) {
				$data['factures'] = $this->partenaire_model->payTableListeFactureByGroupBySearch($search, $this->id_organisation, 1, 'demandpay', 'finish');
			} else {
				$data['factures'] = $this->partenaire_model->payTableListeFactureByGroup($this->id_organisation, 1, 'demandpay', 'finish');
			}
		} else {
			if (!empty($search)) {
				$data['factures'] = $this->partenaire_model->payTableListeFactureByGroupByLimitBySearch($limit, $start, $search, $this->id_organisation, 1, 'demandpay', 'finish');
			} else {
				$data['factures'] = $this->partenaire_model->payTableListeFactureByGroupByLimit($limit, $start, $this->id_organisation, 1, 'demandpay', 'finish');
			}
		}
//        if ($Payment_encours) {
//            $data['payments'] = $this->finance_model->getPaymentByFilter($this->id_organisation, $Payment_encours);
//        } else {
//            $data['payments'] = $this->finance_model->getPayment($this->id_organisation);
//        }
		$i = 0;
		$info = array();
		$origins = $data['factures'];

		foreach ($origins as $payment) {
			if ($this->id_organisation == $payment->id_organisation || $this->id_organisation == $payment->organisation_destinataire) {
				//  if ($this->id_organisation == $payment->organisation_destinataire) {
				//   $cree_par = $this->partenaire_model->getPartenairesById($payment->id_organisation)->nom;
				isset($payment->organisation_destinataire) ? $cree_par = $this->partenaire_model->getPartenairesById($payment->organisation_destinataire)->nom : $cree_par = '';
				//  var_dump($payment->id .'--$this->id_organisation---'.$this->id_organisation.'--$payment->id_organisation--'.$payment->id_organisation.'--$payment->organisation_destinataire--'.$payment->organisation_destinataire);
				if ($payment->etat == 1) {
					$date = date('d/m/Y H:i', $payment->date);
					$status = '';
					if ($payment->status == 'accept') {
						$status = '<span class="status-p bg-danger">' . lang('demandpay_') . '</span>';
					}
					if ($payment->status == 'finish') {
						$status = '<span class="status-p bg-success">' . lang('finish_') . '</span>';
					}
					$options2 = '<a class="btn green btn-xs_ invoicebutton payment" title="' . lang('invoice_f') . '" style="color: #fff;" href="partenaire/genereFactures2?id=' . $payment->code . '"><i class="fa fa-plus-circle"></i> ' . lang('invoice_f') . '</a>';

					//  $options2 = '  <span id="depot' . $payment->id . '" class="green btn depositbutton payment" onclick="depositbutton(' . $payment->id . ')"  data-gross_total="' . $payment->gross_total . '"  data-amount_received="' . $payment->amount_received . '" data-payment="' . $payment->id . '" data-patient="' . $payment->patient . '" style="" ><i class="fa fa-plus-circle"></i> ' . lang('paye') . '</span>';
					// if ($payment->gross_total > $payment->amount_received && $payment->organisation_destinataire && $this->id_organisation == $payment->organisation_destinataire) {
					if ($payment->status_paid_pro != "paid" && $payment->organisation_destinataire && $this->id_organisation == $payment->organisation_destinataire) {
						if ($payment->status == 'accept') {
							$status = '<span class="status-p bg-success">' . lang('demandpay_') . '</span>';
							//$options2 = '';
						}
					}
					if ($payment->status_paid_pro != "paid" && $payment->id_organisation && $this->id_organisation == $payment->id_organisation) {
						if ($payment->status == 'accept') {
							$status = '<span class="status-p bg-danger">' . lang('demandpay_') . '</span>';
							//$options2 = '';
						}
					}
					// BLOC FINAL
					if ($payment->status_paid_pro == "paid") {
						$status = '<span class="status-p bg-success" style="text-transform:uppercase;">Payé</span>';
					} else if ($payment->status_paid_pro == "unpaid") {
						if ($payment->organisation_destinataire && $this->id_organisation == $payment->organisation_destinataire) {
							$status = '<span class="status-p bg-danger" style="text-transform:uppercase;">A Payer</span>';
						}
						if ($payment->id_organisation && $this->id_organisation == $payment->id_organisation) {
							$status = '<span class="status-p bg-danger" style="text-transform:uppercase;">En attente du paiement</span>';
						}
					} else if ($payment->status_paid_pro == "pending") {
						$status = '<span class="status-p" style="background-color:#0A3B76;text-transform:uppercase;font-size:95%;">En attente de validation <i class="fa fa-hourglass-half"></i></span>';
					}
					// BLOC FINAL
					$cumul_tarifs_pros_pour_prestations = 0;
					$category_name = $payment->category_name_pro;

					if ($category_name) {
						$buff0 = explode(',', $category_name);
						foreach ($buff0 as $presta) {
							$buff0_1 = explode("*", $presta);
							$cumul_tarifs_pros_pour_prestations += intval($buff0_1[1]); //$this->partenaire_model->prixPro($buff0_1[0]);
						}
					}

					$status_paid = '';
					if ($payment->status_paid_pro == "unpaid") {
						$status_paid = "nonpaye";
					} else if ($payment->status_paid_pro == "paid") {
						$status_paid = "paie";
					}
					$info[] = array(
						$status_paid,
						$date, $payment->code, $cree_par, $payment->nom,
						number_format($payment->gross_total, 0, ",", ".") . ' ' . $this->settings_model->getSettings()->currency,
						'<span id="status-change' . $payment->id . '">' . $status . '</span>',
						$options2
					);
				}
			}
		}

		if(!empty($data['factures']) && trim($search)) {
			$output = array(
				"draw" => intval($requestData['draw']),
				"recordsTotal" => count($this->partenaire_model->payTableListeFactureByGroup($this->id_organisation, 1, 'demandpay', 'finish')),
				"recordsFiltered" => count($this->partenaire_model->payTableListeFactureByGroupBySearch($search, $this->id_organisation, 1, 'demandpay', 'finish')),
				"data" => $info
			);
		} else if (!empty($data['factures'])) {
			$output = array(
				"draw" => intval($requestData['draw']),
				"recordsTotal" => count($this->partenaire_model->payTableListeFactureByGroup($this->id_organisation, 1, 'demandpay', 'finish')),
				"recordsFiltered" => count($this->partenaire_model->payTableListeFactureByGroup($this->id_organisation, 1, 'demandpay', 'finish')),
				"data" => $info
			);
		} else {
			$output = array(
				// "draw" => 1,
				"recordsTotal" => 0,
				"recordsFiltered" => 0,
				"data" => []
			);
		}

		echo json_encode($output);
	}


	public function facturesRapport()
	{

		if (!$this->ion_auth->in_group(array('Receptionist', 'Assistant', 'admin', 'adminmedecin'))) {
			redirect('home/permission');
		}

		if (!$this->ion_auth->logged_in()) {
			redirect('auth/login', 'refresh');
		} else {
			$i = 0;

			$origins = $this->partenaire_model->payListeFacturePaidByGroup($this->id_organisation, 1, 'paid', 'finish');
			$info = array();
			// $payments = $this->finance_model->getStatusPaymentByTraitance(1,'finish' ,$this->id_organisation);
			foreach ($origins as $payment) {
				if ($this->id_organisation == $payment->id_organisation || $this->id_organisation == $payment->organisation_destinataire) {
					//  if ($this->id_organisation == $payment->organisation_destinataire) {
					//   $cree_par = $this->partenaire_model->getPartenairesById($payment->id_organisation)->nom;
					isset($payment->organisation_destinataire) ? $cree_par = $this->partenaire_model->getPartenairesById($payment->organisation_destinataire)->nom : $cree_par = '';
					//  var_dump($payment->id .'--$this->id_organisation---'.$this->id_organisation.'--$payment->id_organisation--'.$payment->id_organisation.'--$payment->organisation_destinataire--'.$payment->organisation_destinataire);
					if ($payment->etat == 1) {
						$date = date('d/m/Y H:i', $payment->date);
						$status = '';
						if ($payment->status == 'accept') {
							$status = '<span class="status-p bg-danger">' . lang('demandpay_') . '</span>';
						}
						if ($payment->status == 'finish') {
							$status = '<span class="status-p bg-success">' . lang('finish_') . '</span>';
						}
						$options2 = '<a class="btn green btn-xs_ invoicebutton payment" title="' . lang('invoice_f') . '" style="color: #fff;" href="partenaire/genereFactures2?id=' . $payment->code . '"><i class="fa fa-plus-circle"></i> ' . lang('invoice_f') . '</a>';

						//  $options2 = '  <span id="depot' . $payment->id . '" class="green btn depositbutton payment" onclick="depositbutton(' . $payment->id . ')"  data-gross_total="' . $payment->gross_total . '"  data-amount_received="' . $payment->amount_received . '" data-payment="' . $payment->id . '" data-patient="' . $payment->patient . '" style="" ><i class="fa fa-plus-circle"></i> ' . lang('paye') . '</span>';
						// if ($payment->gross_total > $payment->amount_received && $payment->organisation_destinataire && $this->id_organisation == $payment->organisation_destinataire) {
						if ($payment->status_paid_pro != "paid" && $payment->organisation_destinataire && $this->id_organisation == $payment->organisation_destinataire) {
							if ($payment->status == 'accept') {
								$status = '<span class="status-p bg-success">' . lang('demandpay_') . '</span>';
								//$options2 = '';
							}
						}
						if ($payment->status_paid_pro != "paid" && $payment->id_organisation && $this->id_organisation == $payment->id_organisation) {
							if ($payment->status == 'accept') {
								$status = '<span class="status-p bg-danger">' . lang('demandpay_') . '</span>';
								//$options2 = '';
							}
						}
						// BLOC FINAL
						if ($payment->status_paid_pro == "paid") {
							$status = '<span class="status-p bg-success" style="text-transform:uppercase;">Payé</span>';
						} else if ($payment->status_paid_pro == "unpaid") {
							if ($payment->organisation_destinataire && $this->id_organisation == $payment->organisation_destinataire) {
								$status = '<span class="status-p bg-danger" style="text-transform:uppercase;">A Payer</span>';
							}
							if ($payment->id_organisation && $this->id_organisation == $payment->id_organisation) {
								$status = '<span class="status-p bg-danger" style="text-transform:uppercase;">En attente du paiement</span>';
							}
						} else if ($payment->status_paid_pro == "pending") {
							$status = '<span class="status-p" style="background-color:#0A3B76;text-transform:uppercase;font-size:95%;">En attente de validation <i class="fa fa-hourglass-half"></i></span>';
						}
						// BLOC FINAL
						$cumul_tarifs_pros_pour_prestations = 0;
						$category_name = $payment->category_name_pro;

						if ($category_name) {
							$buff0 = explode(',', $category_name);
							foreach ($buff0 as $presta) {
								$buff0_1 = explode("*", $presta);
								$cumul_tarifs_pros_pour_prestations += intval($buff0_1[1]); //$this->partenaire_model->prixPro($buff0_1[0]);
							}
						}

						$status_paid = '';
						$options3 = null;
						$status = '';
						$montant = '';
						//var_dump($this->id_organisation);
						if($payment->id_organisation === $this->id_organisation){
							$options3 = $payment->gross_total;
							$options3 = intval($options3);
							$status_paid = "recette";
							$status = '<span class="status-p bg-success" style="text-transform:uppercase;">Recette</span>';
							$montant = '<span style="color: #279B38;font-weight: bold;">'.number_format($options3, 0, ",", ".") . ' ' . $this->settings_model->getSettings()->currency.'</span>';

						}else{
							$options3 = '-'.$payment->gross_total;
							$options3 = intval($options3);
							$status_paid = "depense";
							$status = '<span class="status-p bg-danger" style="text-transform:uppercase;">Dépense</span>';
							$montant = '<span style="color: rgba(255, 0, 0, 1.00);font-weight: bold;">'.number_format($options3, 0, ",", ".") . ' ' . $this->settings_model->getSettings()->currency.'</span>';


						}
						
						$info[] = array(
							$status_paid,
							$date, $payment->code, $cree_par, $payment->nom,
							$montant,
							$status,
							$options3
						);
					}
				}
			}
			$data['listeCommandes'] = $info;


			$data['settings'] = $this->settings_model->getSettings();

			$data['id_organisation'] = $this->id_organisation;
			$data['path_logo'] = $this->path_logo;
			$data['nom_organisation'] = $this->nom_organisation;

			$this->load->view('home/dashboard', $data);
			$this->load->view('rapport_facture', $data);
			$this->load->view('home/footer');
		}
	}

	public function listeFacture()
	{

		if (!$this->ion_auth->in_group(array('Receptionist', 'Assistant', 'admin', 'adminmedecin'))) {
			redirect('home/permission');
		}

		if (!$this->ion_auth->logged_in()) {
			redirect('auth/login', 'refresh');
		} else {
			$i = 0;
			$id = $this->input->get('id');
			$origins = $this->partenaire_model->payListeFacture($id, $this->id_organisation, 1, 'accept');
			$info = array();
			// $payments = $this->finance_model->getStatusPaymentByTraitance(1,'finish' ,$this->id_organisation);
			foreach ($origins as $payment) {

				$date = date('d/m/Y H:i', $payment->date);
				$status = '';
				if ($payment->status == 'accept') {
					$status = '<span class="status-p bg-success">' . lang('accept_') . '</span>';
				}
				$options2 = ''; //  <span id="pay' . $payment->id . '" class="green btn payment" onclick="paybutton(' . $payment->id . ')"  ><i class="fa fa-money-bill-alt"></i> ' . lang('pay_transfert') . '</span>';
				// $cumul_tarifs_pros_pour_prestations = 0;
				$category_name = $payment->category_name;
				$buff0 = explode(',', $category_name);
				foreach ($buff0 as $presta) {
					$buff0_1 = explode("*", $presta);

					// echo "<script language=\"javascript\">alert(\"".$buff0_1[0]."\");</script>";
					$prix_pro_interne = $this->db->query("select payment_category_organisation.tarif_professionnel from payment_category_organisation join payment_category on payment_category_organisation.id_presta = payment_category.id and payment_category.id = " . $buff0_1[0])->row()->tarif_professionnel;
					$cumul_tarifs_pros_pour_prestations += $prix_pro_interne;
				}

				// echo "<script language=\"javascript\">alert(\"".$cumul_tarifs_pros_pour_prestations."\");</script>";
				$info[] = array(
					'status' => $payment->status,
					$i,
					$date, $payment->code,
					// number_format($payment->gross_total, 0, ",", ".") . ' ' . $this->settings_model->getSettings()->currency,
					number_format($cumul_tarifs_pros_pour_prestations, 0, ",", ".") . ' ' . $this->settings_model->getSettings()->currency,
					'<span id="status-change' . $payment->id . '">' . $status . '</span>',
					$options2, $payment->id
				);
				$i++;
			}
			$data['listeCommandes'] = $info;
			$nom = '';
			if (is_array($origins) && isset($origins) && isset($origins[0])) {
				$nom = $origins[0]->nom;
			}
			$data['destinatairs'] = $nom;

			$data['settings'] = $this->settings_model->getSettings();

			$data['id_organisation'] = $this->id_organisation;
			$data['path_logo'] = $this->path_logo;
			$data['nom_organisation'] = $this->nom_organisation;

			$this->load->view('home/dashboard', $data);
			$this->load->view('listeFacture', $data);
			$this->load->view('home/footer');
		}
	}

	public function paybutton()
	{

		$payment = $this->input->get('id');
		$origins = $this->partenaire_model->payButton($payment, $this->id_organisation, 'origin');
		$destinatairs = $this->partenaire_model->payButton($payment, $origins->id_organisation, '');
		$settings = $this->settings_model->getSettings();
		$html = '<section id="main-content-">';
		$html .= '<section class="wrapper site-min-height">';
		$html .= '<section class="col-md-12">';
		$html .= ' <div class="panel panel-primary" id="invoice">';
		$html .= '    <div class="panel-body" style="font-size: 10px;">';
		$html .= '           <div class="row invoice-list">';
		$html .= '					<div class="col-md-12 invoice_head clearfix">';
		$html .= '                 <div class="col-md-4 text-center invoice_head_left">';
		if ($origins->path_logo) {
			$html .= '                      <img src="' . $origins->path_logo . '" style="max-width:180px;max-height:80px;"/>';
		} else {
			$html .= '                      <img src="uploads/logosPartenaires/default.png" style="max-width:180px;max-height:80px;"/>';
		}
		$html .= '                </div>';
		$html .= '               <div class="col-md-8 text-center invoice_head_right">';
		$html .= '                    <h6>' . $origins->description_courte_activite . '<h6>';
		$html .= '                   <h3 style="margin-top:2px;margin-bottom:2px;">';
		$html .= $origins->nom;
		$html .= '						</h3>';
		$html .= '                   <div>' . $origins->phone . '</div>';
		$html .= '                   <div>' . $origins->email . '</div>';
		$html .= '                  <h6 style="text-transform:italic;">' . $origins->slogan . '</h6>';
		$html .= '                <h6> Horaires d\'ouverture</h6>';
		$html .= '						<p>';
		$html .= $origins->horaires_ouverture;
		$html .= '						</p>';
		$html .= '        </div>';
		$html .= '       </div>';
		$html .= '				<div class="col-md-12 hr_border">';
		$html .= '         <hr>';
		$html .= '      </div>';

		$html .= ' <div class="col-md-12 hr_border">';
		$html .= '     <hr>';
		$html .= ' </div>';
		$html .= ' <div class="col-md-12">';
		$html .= '     <h4 class="text-center" style="font-weight: bold; margin-top: 20px; text-transform: uppercase;">';
		$html .= lang('demand_pay');
		$html .= '    </h4>';
		$html .= '  </div>';

		$html .= ' <div class="col-md-12 hr_border">';
		$html .= '     <hr>';
		$html .= ' </div>';


		$html .= '  <div class="col-md-12">';
		$html .= '    <div class="col-md-6 pull-left row" style="text-align: left;">';
		$html .= '      <div class="col-md-12 row details" style="">';
		$html .= '          <p>';

		$html .= '             <label class="control-label">' . lang('entreprise') . ' </label>';
		$html .= '           <span style="text-transform: uppercase;"> : ';

		if (!empty($origins)) {
			$html .= $destinatairs->nom . ' <br>';
		}

		$html .= '           </span>';
		$html .= '    </p>';
		$html .= ' </div>';
		$html .= '  <div class="col-md-12 row details" style="">';
		$html .= '     <p>';
		$html .= '  <label class="control-label">' . lang('phone') . '  </label>';
		$html .= '      <span style="text-transform: uppercase;"> : ';

		if (!empty($origins)) {
			$html .= $destinatairs->phone . ' <br>';
		}

		$html .= '      </span>';
		$html .= '   </p>';
		$html .= ' </div>';

		$html .= '  <div class="col-md-12 row details" style="">';
		$html .= '     <p>';
		$html .= '  <label class="control-label">' . lang('email') . '  </label>';
		$html .= '      <span > : ';

		if (!empty($origins)) {
			$html .= $destinatairs->email . ' <br>';
		}

		$html .= '      </span>';
		$html .= '   </p>';
		$html .= ' </div>';
		$html .= '  <div class="col-md-12 row details" style="">';
		$html .= '      <p>';
		$html .= '       <label class="control-label">' . lang('address') . '</label>';
		$html .= '        <span style="text-transform: uppercase;"> : ';

		if (!empty($origins)) {
			$html .= $destinatairs->address . ' <br>';
		}

		$html .= '      </span>';
		$html .= '    </p>';
		$html .= ' </div>';



		$html .= ' </div>';

		$html .= ' <div class="col-md-6 pull-right" style="text-align: left;">';

		$html .= '    <div class="col-md-12 row details" style="">';
		$html .= '       <p>';
		$html .= '          <label class="control-label">' . lang('commande') . ' </label>';
		$html .= '          <span style="text-transform: uppercase;"> : ';

		if (!empty($origins->id)) {
			$html .= $origins->code;
		}

		$html .= '          </span>';
		$html .= '     </p>';
		$html .= ' </div>';
		$html .= '    <div class="col-md-12 row details" style="">';
		$html .= '       <p>';
		$html .= '          <label class="control-label">' . lang('patient') . ' </label>';
		$html .= '          <span style="text-transform: uppercase;"> : ';
		if (!empty($origins)) {
			$html .= $origins->patient_id . ' <br>';
		}
		$html .= '          </span>';
		$html .= '     </p>';
		$html .= ' </div>';

		$html .= '  <div class="col-md-12 row details">';
		$html .= '      <p>';
		$html .= '     <label class="control-label">' . lang('date') . '  </label>';
		$html .= '      <span style="text-transform: uppercase;"> : ';

		if (!empty($origins->date)) {
			$html .= date('d/m/Y', $origins->date) . ' <br>';
		}

		$html .= '   </span>';
		$html .= '  </p>';
		$html .= '  </div>';


		$html .= '  </div>';

		$html .= ' </div>';






		$html .= ' </div> ';

		$html .= ' <div class="col-md-12 hr_border">';
		$html .= '     <hr>';
		$html .= '  </div>';




		$html .= ' <table class="table table-striped table-hover">';

		$html .= '   <thead class="theadd">';
		$html .= '      <tr>';
		$html .= '        <th>#</th>';
		$html .= '         <th>' . lang('description') . '</th>';
		$html .= '          <th>' . lang('ref') . '</th>';
		$html .= '       <th>' . lang('patient') . '</th>';
		$html .= '       <th>' . lang('amount') . '</th>';

		$html .= '       </tr>';
		$html .= '   </thead>';
		$html .= '<tbody>';

		if (!empty($origins->category_name)) {
			$category_name = $origins->category_name;
			$category_name1 = explode(',', $category_name);
			$i = 0;
			foreach ($category_name1 as $category_name2) {
				$i = $i + 1;
				$category_name3 = explode('*', $category_name2);
				if ($category_name3[3] > 0 && $category_name3[1]) {
					$html .= '       <tr>';
					$html .= '        <td>' . $i . ' </td>';
					$html .= '         <td>' . $this->finance_model->getPaymentcategoryById($category_name3[0])->prestation . '</td>';
					$html .= '  <td class="">' . number_format($category_name3[1], 0, ",", ".") . ' ' . $settings->currency . ' </td>';
					$html .= '     <td class="">' . $category_name3[3] . ' </td>';
					$html .= '      <td class="">' . number_format($category_name3[1] * $category_name3[3], 0, ",", ".") . ' ' . $settings->currency . '</td>';
					$html .= '       </tr>';
				}
			}
		}

		$html .= ' </tbody>';
		$html .= '  </table>';

		$html .= '  <div class="col-md-12 hr_border">';
		$html .= '    <hr>';
		$html .= '  </div>';

		$html .= '<div class="">';
		$html .= '    <div class="col-lg-4 invoice-block pull-left">';
		$html .= '       <h4></h4>';
		$html .= '   </div>';
		$html .= '</div>';

		$html .= '<div class="">';
		$html .= '  <div class="col-lg-4 invoice-block pull-right">';
		$html .= '  <ul class="unstyled amounts">';

		$html .= '     <li><strong>' . lang('grand_total') . ': </strong> ' . $settings->currency . ' </li>';
		$html .= '   </ul>';
		$html .= '  </div>';
		$html .= ' </div>';

		$html .= '   <div class="col-md-12 invoice_footer">';
		$html .= '    <div class="row pull-left" style="">';
		$html .= '      <strong>' . lang('payment_gateway') . ' : </strong>';
		$html .= '  </div><br>';
		$html .= '    <div class="row pull-left" style=""> EcoMed <br/> Virement bancaire <br/> Cheque: ';
		$html .= '   </div>';
		$html .= ' </div>';
		$html .= ' <div class="col-md-12 invoice_footer">';
		$html .= '    <div class="row pull-right" style="">';
		$html .= '     <strong>' . lang('effectuer_par') . ' : </strong>';
		$html .= '  </div><br>';
		$html .= '  <div class="row pull-right" style="">' . $this->ion_auth->user()->row()->first_name . ' ' . $this->ion_auth->user()->row()->last_name . ' </div>';
		$html .= '</div>';
		$html .= '  <div class="col-md-12 hr_border">';
		$html .= '    <hr>';
		$html .= ' </div>';

		$html .= '     </div>';
		$html .= '        <div class="text-center"> 20' . date('y') . ' &copy;  Powered by ecoMed24.';
		$html .= '             </div>';

		$html .= ' <div class="col-md-12 no-print" style="margin-top: 20px;">';
		$html .= '      <div class="text-center col-md-12 row">';
		$html .= '        <a class="btn btn-info btn-sm invoice_button pull-left" id="btnPrint0"><i class="fa fa-paper-plane"></i> ' . lang('send') . ' à ' . $destinatairs->nom . ' </a>';
		$html .= '        <a class="btn btn-info btn-sm invoice_button" id="btnPrint0"><i class="fa fa-print"></i> ' . lang('print') . ' </a>';

		$html .= '     <a class="btn btn-info btn-sm detailsbutton pull-right download" id="download" ><i class="fa fa-download"></i>' . lang('download') . ' </a>';
		$html .= ' </div>';
		$html .= '   </div>';

		$html .= ' <div class="col-md-12 no-print" style="margin-top: 20px;">';
		$html .= '      <div class="text-center col-md-12 row">';
		$html .= '     <button type="button" class="btn btn-info btn-secondary pull-left" data-dismiss="modal" aria-hidden="true"> Fermer</button>';
		$html .= ' </div>';
		$html .= '   </div>';

		$html .= ' </section>';
		$html .= ' </section>';


		$html .= '</section>';;

		//  $response =  array('origins'=>$origins, 'destinatairs'=>$destinatairs);
		echo json_encode($html);
	}

	public function relation()
	{

		if (!$this->ion_auth->logged_in()) {
			redirect('auth/login', 'refresh');
		} else {

			$data['partenaires'] = $this->partenaire_model->getPartenairesDemande($this->id_organisation);
			$data['settings'] = $this->settings_model->getSettings();

			$data['id_organisation'] = $this->id_organisation;
			$data['path_logo'] = $this->path_logo;
			$data['nom_organisation'] = $this->nom_organisation;

			$this->load->view('home/dashboard', $data);
			$this->load->view('relation', $data);
			$this->load->view('home/footer');
		}
	}

	public function addPartenaireView()
	{
		$data['partenaire'] = $this->partenaire_model->getPartenaires($this->id_organisation);
		$data['id_organisation'] = $this->id_organisation;
		$data['path_logo'] = $this->path_logo;
		$data['nom_organisation'] = $this->nom_organisation;
		$this->load->view('home/dashboard', $data); // just the header file
		$this->load->view('add_partenaire', $data);
		$this->load->view('home/footer'); // just the header file
	}

	function searhPartenaireByAdd()
	{
		$searchTerm = $this->input->post('searchTerm');
		$id = $this->input->post('id');
		$idorgRecherche = $this->input->get('partenaire');
		$idPartenaire = $this->id_organisation;
		if (isset($id)) {
			$idPartenaire = $id;
		}
		$response = $this->partenaire_model->searhPartenaireByAdd($searchTerm, $idPartenaire, $idorgRecherche);
		echo json_encode($response);
	}

	function searhPartenaire()
	{
		$searchTerm = $this->input->post('searchTerm');
		$response = $this->partenaire_model->searhPartenaire($searchTerm, $this->id_organisation);
		echo json_encode($response);
	}

	function searhPartenaireLight()
	{
		$searchTerm = $this->input->post('searchTerm');
		$response = $this->partenaire_model->searhPartenaireLight($searchTerm, $this->id_organisation);
		echo json_encode($response);
	}

	function infoPartenaireByNewPatient()
	{
		$idorgRecherche = $this->input->get('partenaire');
		$response = $this->partenaire_model->infoPartenaireByNewPatient($idorgRecherche);
		echo json_encode($response);
	}

	public function addNew()
	{
		$idpartenaire = $this->input->post('partenaire');
		$redirect = 'partenaire';
		$id = $this->input->post('idpartenaire');
		$idPartenaire = $this->id_organisation;
		if (!empty($id)) {
			$idPartenaire = $id;
			$redirect = 'home/organisationsnolight?id=' . $id;
		}
		$data = array(
			'id_organisation_destinataire' => $idpartenaire,
			'id_organisation_origin' => $idPartenaire,
			'partenariat_actif' => 1
		);

		$output = $this->partenaire_model->insertPartenaire($data);
		$this->session->set_flashdata('feedback', lang('added'));

		redirect($redirect);
	}

	function genereFactures()
	{

		$payment = $this->input->post('id');  //var_dump($payment);
		$deb = $this->input->post('deb');
		$fin = $this->input->post('fin');

		if (is_array($payment) && isset($payment) && isset($payment[0])) {
			$id = $payment[0];
			$origins = $this->partenaire_model->infoPartenaire($id, $this->id_organisation, 'origin');            //var_dump($origins->id_organisation);
			$data['destinatairs'] = $this->partenaire_model->infoPartenaire($id, $origins->id_organisation, '');
			$data['origins'] = $origins;
			foreach ($payment as $value) {
				$data['prestations'][] = $this->partenaire_model->payButton($id, $origins->id_organisation, '');
			}

			$data['settings'] = $this->settings_model->getSettings();
			$data['id'] = $payment;

			$data['id_organisation'] = $this->id_organisation;
			$data['path_logo'] = $this->path_logo;
			$data['nom_organisation'] = $this->nom_organisation;

			$data['deb'] = $deb;
			$data['fin'] = $fin;
			$this->load->view('home/dashboard', $data); // just the header file
			$this->load->view('confirme_facture', $data);
			$this->load->view('home/footer'); // just the header file
		} else {
			$this->session->set_flashdata('feedback', lang('error'));

			redirect('partenaire');
		}
	}

	function changeStatus()
	{
		if (!$this->ion_auth->logged_in()) {
			redirect('auth/login', 'refresh');
		}
		$pro_invoice_id = $this->input->get('id');
		$numeroTransaction = $this->input->get('numeroTransaction');
		// $invoice_id = $this->input->post('payment');
		$status_paid = 'paid';
		$date = time();
		// $update_payment = array('status_paid_pro' => $status_paid);
		$date_Facture = array('date_Facture' => date('d/m/y H:i', $date));
		$id_zuulupay = array('id_zuulupay' => $numeroTransaction);

		// $payment = $this->finance_model->getPaymentById($invoice_id, $this->id_organisation);
		$payment_pro_entry = $this->finance_model->getPaymentByCode($pro_invoice_id);
		$innit = $this->partenaire_model->payListeFactureByGroup2(null, $pro_invoice_id, null, null, null);
		$code_original_entry = $innit[0]->codepro;
		$payment_original_entry = $this->finance_model->getPaymentByCode($code_original_entry);


		// $status = $payment->status;
		$status_original_entry = $payment_original_entry->status;
		$status_pro_entry = $payment_pro_entry->status;

		// $this->finance_model->updatePayment($invoice_id, $update_payment, $this->id_organisation,$date_Facture,$id_zuulupay);
		// $this->finance_model->updatePayment($payment, array("status_paid_pro" => "paid","date_Facture" => date('d/m/y H:i', $date),"id_zuulupay" => $numeroTransaction));

		if ($payment_original_entry->gross_total == $payment_original_entry->amount_received) { // Si le paiement avait été fait en intégralité à la création
			if ($payment->status == "demandpay") {
				// $status = "finish";
				$status_original_entry = "finish";
				$this->changeStatusPrestationByFinance($payment_original_entry->id, 4, 'all');
			}
		}

		$status_pro_entry = "finish";
		// $update_payment = array('status_paid_pro' => $status_paid, 'status' => $status);
		// $this->finance_model->updatePayment($invoice_id, $update_payment, $this->id_organisation);

		$update_payment_original_entry = array('status_paid_pro' => $status_paid, 'status' => $status_original_entry);
		$update_payment_pro_entry = array('status_paid_pro' => $status_paid, 'status' => $status_pro_entry);

		$this->finance_model->updatePayment($payment_original_entry->id, $update_payment_original_entry, $this->id_organisation);
		$this->finance_model->updatePayment($payment_pro_entry->id, $update_payment_pro_entry, $this->id_organisation);
	}

	function changeStatusPrestationByFinance($payment, $type, $idPrestation)
	{

		$category_name = $this->finance_model->getPaymentById($payment)->category_name;

		$checktABnewTab = explode(',', $category_name);
		$valuenew = array();
		foreach ($checktABnewTab as $value) {
			$checktABnewTab = explode('*', $value);
			$id = intval($checktABnewTab[0]);
			// $valuenew .= implode("*", $checktABnewTab2).','; 
			if (is_array($checktABnewTab) && count($checktABnewTab) > 3) {
				if ($idPrestation == '' || $idPrestation == 'all') {
					$check = $checktABnewTab[0] . '*' . $checktABnewTab[1] . '*' . $checktABnewTab[2] . '*' . $checktABnewTab[3] . '*' . $type;
					$category_name = str_replace($value, $check, $category_name);
				} else {
					if ($idPrestation == $id) {
						$check = $checktABnewTab[0] . '*' . $checktABnewTab[1] . '*' . $checktABnewTab[2] . '*' . $checktABnewTab[3] . '*' . $type;
						$category_name = str_replace($value, $check, $category_name);
					} else {
						$check = $checktABnewTab[0] . '*' . $checktABnewTab[1] . '*' . $checktABnewTab[2] . '*' . $checktABnewTab[3] . '*' . $checktABnewTab[4];
					}
				}
				//  }
				$valuenew[] = $check;
			}
		}
		$valueFinish = implode(",", $valuenew);
		/* / } else {
          $category_name = str_replace('*1*0', '*1*1', $category_name);
          } */

		//var_dump($category_name);  // exit();
		$this->finance_model->updatePayment($payment, array("category_name" => $category_name));

		if ($type == 2) {
			$sql = "select count(*) as total from payment where id =" . $payment . " and (category_name like '%*%*%*%*%0' or category_name like '%*%*%*%*%1' or category_name like '%*%*%*%*%3' or category_name like '%*%*%*%*%4' or category_name like '%*%*%*%*%5')";
			// var_dump($sql);

			$query = $this->db->query($sql);
			$num = intval($query->row()->total);            // var_dump($num); //exit();
			if (empty($num)) {

				$this->finance_model->updatePayment($payment, array("status" => "done", "status_presta" => "finish"));
			} else {
				$this->finance_model->updatePayment($payment, array("status" => "pending", "status_presta" => "pending"));
			}
		} else if ($type == 3) {
			$sql = "select count(*) as total from payment where id =" . $payment . " and (category_name like '%*%*%*%*%0' or category_name like '%*%*%*%*%1' or category_name like '%*%*%*%*%2' or category_name like '%*%*%*%*%4' or category_name like '%*%*%*%*%5')";

			$query = $this->db->query($sql);
			$num = intval($query->row()->total);
			if (empty($num)) {
				$this->finance_model->updatePayment($payment, array("status" => "valid", "status_presta" => "finish"));
				$t_labo = $this->finance_model->getPaymentByIdByservice($payment);
				if ($t_labo->code_service == 'labo') {
					$this->generateRapport($payment);
				}
			} else {
				$this->finance_model->updatePayment($payment, array("status" => "pending", "status_presta" => "pending"));
			}
		} else if ($type == 1) {
			$sql = "select count(*) as total from payment where id =" . $payment . " and (category_name like '%*%*%*%*%0' or category_name like '%*%*%*%*%2' or category_name like '%*%*%*%*%3' or category_name like '%*%*%*%*%4' or category_name like '%*%*%*%*%5')  ";
			// var_dump($sql);
			$query = $this->db->query($sql);
			$num = $query->row()->total;
			if (!empty($num)) {

				$this->finance_model->updatePayment($payment, array("status" => "new", "status_presta" => "pending"));
			} else {
				$this->finance_model->updatePayment($payment, array("status" => "pending", "status_presta" => "finish"));
			}
		} else if ($type == 4) {
			$sql = "select count(*) as total from payment where id =" . $payment . " and  (category_name like '%*%*%*%*%0' or category_name like '%*%*%*%*%1' or category_name like '%*%*%*%*%2' or category_name like '%*%*%*%*%3' or category_name like '%*%*%*%*%5') ";
			$query = $this->db->query($sql); //var_dump($sql);
			$num = $query->row()->total;    // var_dump($num);   exit();
			if (empty($num)) {
				$this->finance_model->updatePayment($payment, array("status" => "finish", "status_presta" => "finish"));
			} else {
				$this->finance_model->updatePayment($payment, array("status" => "pending", "status_presta" => "pending"));
			}
		} else if ($type == 5) {
			$sql = "select count(*) as total from payment where id =" . $payment . " and  (category_name like '%*%*%*%*%0' or category_name like '%*%*%*%*%1' or category_name like '%*%*%*%*%2' or category_name like '%*%*%*%*%3' or category_name like '%*%*%*%*%4') ";
			$query = $this->db->query($sql); //var_dump($sql);
			$num = $query->row()->total;    // var_dump($num);   exit();
			if (empty($num)) {
				$this->finance_model->updatePayment($payment, array("status" => "accept", "status_presta" => "finish"));
			} else {
				$this->finance_model->updatePayment($payment, array("status" => "pending", "status_presta" => "pending"));
			}
		} else if ($type == 6) {

			$this->finance_model->updatePayment($payment, array("status" => "demandpay", "status_presta" => "finish"));
		}
	}

	function genereFactures2()
	{

		$id = $this->input->get('id');  //var_dump($payment);
		$deb = $this->input->get('deb');
		$fin = $this->input->get('fin');

		if (isset($id)) {
			$payment = $this->partenaire_model->payListeFactureByGroup2($this->id_organisation, $id, 1, 'demandpay', 'finish');
			$mode = false;
			$modelight = false;
			if (!empty($payment)) {

				$codepro = $payment[0]->codepro;

				$paymentt = $this->finance_model->getPaymentByCode($codepro);

				$id_organisation = $paymentt->id_organisation;
				$organisation_destinataire = $paymentt->organisation_destinataire;
				if ($paymentt->etat == 1) {
					if ($this->id_organisation == $id_organisation) {
						$mode = true;
					}
				} else if ($paymentt->etatlight == 1) {
					if ($this->id_organisation == $id_organisation) {
						$modelight = true;
					}
				}
				foreach ($payment as $value) {
					$data['prestationTab'][] = $this->partenaire_model->payButtonByCode($value->codepro, $id_organisation);
				}
				if ($paymentt->etat == 1) {
					$data['destinatairs'] = $this->home_model->getOrganisationById($organisation_destinataire);
					$data['origins'] = $this->home_model->getOrganisationById($id_organisation);
				} else if ($paymentt->etatlight == 1) {
					$data['destinatairs'] = $this->home_model->getOrganisationById($id_organisation);
					$data['origins'] = $this->home_model->getOrganisationById($organisation_destinataire);
				}
				$data['settings'] = $this->settings_model->getSettings();
				$data['id'] = $id;

				$data['id_organisation'] = $this->id_organisation;
				$data['path_logo'] = $this->path_logo;
				$data['nom_organisation'] = $this->nom_organisation;
				$data['id_partenaire_zuuluPay'] = $this->id_partenaire_zuuluPay;
				$data['pin_partenaire_zuuluPay_encrypted'] = $this->pin_partenaire_zuuluPay_encrypted;
				$data['pin_decrypted'] = $this->encryption->decrypt($this->pin_partenaire_zuuluPay_encrypted);

				$data['deb'] = $deb;
				$data['fin'] = $fin;
				$data['mode'] = $mode;
				$data['modelight'] = $modelight;
				$data['code'] = $id; //$payment[0]->code;
				$data['pay'] = $paymentt->status;
				$data['payStatusPro'] = $paymentt->status_paid_pro;
				$infosFacture = $this->partenaire_model->getPaymentProByID($id);
				$data['dateEmise'] = $infosFacture->dateEmise;
				$data['dateDebut'] = $infosFacture->dateDebut;
				$data['dateFin'] = $infosFacture->dateFin;
				
			}
			$this->load->view('home/dashboard', $data); // just the header file
			$this->load->view('confirme_facture_1', $data);
			$this->load->view('home/footer'); // just the header file
		} else {
			$this->session->set_flashdata('feedback', lang('error'));

			//  redirect('partenaire');
		}
	}

	public function listeFacturePrestation()
	{

		if (!$this->ion_auth->in_group(array('Receptionist', 'admin','Assistant', 'adminmedecin'))) {
			redirect('home/permission');
		}

		if (!$this->ion_auth->logged_in()) {
			redirect('auth/login', 'refresh');
		} else {

			$idOrganisation = $this->input->post('idOrganisation');
			if ($idOrganisation) {
				$this->validFaurePartenaire();
			}

			$origins = $this->partenaire_model->payListeFactureByaLL($this->id_organisation, 1, false, 'accept');
			$originsLight = $this->partenaire_model->payListeFactureByaLL($this->id_organisation, false, 1, 'accept');
			$info = array();
			$origins = array_merge($origins, $originsLight);
			// $payments = $this->finance_model->getStatusPaymentByTraitance(1,'finish' ,$this->id_organisation);
			foreach ($origins as $payment) {
				if ($payment->etat == 1) {
					if ($this->id_organisation == $payment->organisation_destinataire) {
						//   $cree_par = $this->partenaire_model->getPartenairesById($payment->id_organisation)->nom;
						isset($payment->organisation_destinataire) ? $cree_par = $this->partenaire_model->getPartenairesById($payment->organisation_destinataire)->nom : $cree_par = '';
						$date = date('d/m/Y H:i', $payment->date);
						if ($payment->etat == 1) {
							$dataTab = explode(',', $payment->category_name_pro);
							foreach ($dataTab as $value) {
								$valueTab = explode('*', $value);
								if (isset($valueTab[4])) {
									$id_prestation = $valueTab[0];
									$tarif_professionnel = $valueTab[1];
									$current_prestation = $this->finance_model->getPaymentCategoryByOrganisationById2($id_prestation);
									/* $tarif_professionnel = '';
									  if (isset($current_prestation->tarif_professionnel)) {
									  $tarif_professionnel = number_format($current_prestation->tarif_professionnel, 0, ",", ".") . ' ' . $this->settings_model->getSettings()->currency;
									  }
									 */
									$info[] = array(
										$payment->id,
										$date,
										$payment->code,
										$current_prestation->prestation,
										$payment->nom,
										$payment->patient,
										number_format($tarif_professionnel, 0, ",", ".") . ' ' . $this->settings_model->getSettings()->currency
									);
								}
							}
						}
					}
				} else if ($payment->etatlight == 1) {
					if ($this->id_organisation == $payment->id_organisation) {
						//   $cree_par = $this->partenaire_model->getPartenairesById($payment->id_organisation)->nom;
						isset($payment->id_organisation) ? $cree_par = $this->partenaire_model->getPartenairesById($payment->id_organisation)->nom : $cree_par = '';
						$date = date('d/m/Y H:i', $payment->date);
						if ($payment->etatlight == 1) {
							$dataTab = explode(',', $payment->category_name_pro);
							foreach ($dataTab as $value) {
								$valueTab = explode('*', $value);
								if (isset($valueTab[4])) {
									$id_prestation = $valueTab[0];
									$tarif_professionnel = $valueTab[1];
									$current_prestation = $this->finance_model->getPaymentCategoryByOrganisationById2($id_prestation);
									/* $tarif_professionnel = '';
									  if (isset($current_prestation->tarif_professionnel)) {
									  $tarif_professionnel = number_format($current_prestation->tarif_professionnel, 0, ",", ".") . ' ' . $this->settings_model->getSettings()->currency;
									  }
									 */
									$info[] = array(
										$payment->id,
										$date,
										$payment->code,
										$current_prestation->prestation,
										$this->partenaire_model->getPartenairesById($payment->organisation_light_origin)->nom,
										$payment->patient,
										number_format($tarif_professionnel, 0, ",", ".") . ' ' . $this->settings_model->getSettings()->currency
									);
								}
							}
						}
					}
				}
			}
			$data['listeCommandes'] = $info;


			$data['settings'] = $this->settings_model->getSettings();

			$data['id_organisation'] = $this->id_organisation;
			$data['path_logo'] = $this->path_logo;
			$data['nom_organisation'] = $this->nom_organisation;

			$this->load->view('home/dashboard', $data);
			$this->load->view('liste_facture_prestation', $data);
			$this->load->view('home/footer');
		}
	}


	public function listeFacturePrestationAndSendLabBillPDF()
	{

		if (!$this->ion_auth->in_group(array('Receptionist', 'Assistant', 'admin', 'adminmedecin'))) {
			redirect('home/permission');
		}

		if (!$this->ion_auth->logged_in()) {
			redirect('auth/login', 'refresh');
		} else {

			// Création facture

			// Insertion
			$idOrganisation = $this->input->post('idOrganisation');
			if ($idOrganisation) {
				$codeFacture = $this->validFaurePartenaireLight();
			}

			// echo "<script language=\"javascript\">alert(\"".$codeFacture."\");</script>";
			// Récupération HTML
			if (isset($codeFacture)) {
				$payment = $this->partenaire_model->payListeFactureByGroup2($this->id_organisation, $codeFacture, 1, 'demandpay', 'finish');
				$mode = false;
				$modelight = false;
				if (!empty($payment)) {

					$codepro = $payment[0]->codepro;

					$paymentt = $this->finance_model->getPaymentByCode($codepro);

					$id_organisation = $paymentt->id_organisation;
					$organisation_destinataire = $paymentt->organisation_destinataire;
					if ($paymentt->etatlight == 1) {
						if ($this->id_organisation == $id_organisation) {
							$modelight = true;
						}
					}
					foreach ($payment as $value) {
						$prestationTab[] = $this->partenaire_model->payButtonByCode($value->codepro, $id_organisation);
					}
					if ($paymentt->etatlight == 1) {
						$destinatairs = $this->home_model->getOrganisationById($id_organisation);
						$origins = $this->home_model->getOrganisationById($organisation_destinataire);
					}
					$settings = $this->settings_model->getSettings();
					$codeFacture = $codeFacture;

					// $data['deb'] = $deb;
					// $data['fin'] = $fin;
					// $mode = $mode;
					// $modelight = $modelight;
					$code = $codeFacture; //$payment[0]->code;
					$pay = $paymentt->status;
					$payStatusPro = $paymentt->status_paid_pro;
				}
				// echo "<script language=\"javascript\">alert(\"html before: ".$html."\");</script>";
				// $this->load->view('home/dashboard', $data); // just the header file
				// $html = $this->load->view('template_facture_pro', $data, true);
				// $html = genererFactureProLightPourEnvoi();
				// $html = genererFactureProLightPourEnvoi($destinatairs, $origins, $settings, $codeFacture, $mode, $modelight, $code, $pay, $payStatusPro, $prestationTab);
				// $html = "<table><tr><td>HELLO WORLD</td></tr></table>";
				$baseURLF = base_url();
				$html = '<!DOCTYPE html>';
				$html .= '<head>';
				$html .= '     ';
				$html .= '        <meta charset="utf-8">';
				$html .= '        <!-- Bootstrap core CSS -->';

				$html .= '			<link href="'.$baseURLF.'common/css/bootstrap.min.css" rel="stylesheet">';
				$html .= '			<link href="'.$baseURLF.'common/css/bootstrap-reset.css" rel="stylesheet">';
				$html .= '			<!--external css-->';
				$html .= '			<link href="'.$baseURLF.'common/assets/fontawesome5pro/css/all.min.css" rel="stylesheet" />';
				$html .= '			<link href="'.$baseURLF.'common/assets/DataTables/datatables.css" rel="stylesheet" />';
				$html .= '			<link href="'.$baseURLF.'common/css/style.css" rel="stylesheet">';
				$html .= '			<link href="'.$baseURLF.'common/css/style-responsive.css" rel="stylesheet" />';
				$html .= '			<link href="'.$baseURLF.'common/css/invoice-print.css" rel="stylesheet" media="print">';
				// $html .= '            @import url("https://fonts.googleapis.com/css?family=Ubuntu&display=swap");';
				// $html .= '			#sidebar, .header, .site-footer {';
				// $html .= '				display: none ;';
				// $html .= '			}';
				$html .= '    </head>';
				$html .= '<div class="panel panel-primary" id="invoice">';
				$html .= '	<div class="panel-body" id="editPaymentForm">';
				$html .= '		<div class="col-md-12" id="body-print" style="background-color: #fff">';
				$html .= '			<div class="row invoice-list">';
				$html .= '			<table style="margin-bottom:5px;">';
				$html .= '			<tr>';
				$html .= '			<td style="text-align:left:width:50% !important;" class="col-md-6">';
				$html .= '				<div class="col-md-12 invoice_head clearfix">';
				$html .= '					<div class="col-md-4  invoice_head_left" style="float:left">';
				if ($destinatairs->path_logo) {
					$html .= '							<img src="' . $destinatairs->path_logo . '" style="max-width:220px;max-height:150px;margin-top:-12px" />';
				}
				$html .= '					</div>';

				$html .= '				</div>';
				$html .= '				<div class="col-md-12 invoice_head clearfix">';
				$html .= '					<div class="col-md-5  invoice_head_left" style="float:left;">';
				$html .= '						<table style="width:100%">';
				$html .= '							<tr>';
				$html .= '								<th>';
				$html .= '									<h4>';
				$html .= '										<label class="control-label pull-left">';
				$html .= '											<span style="font-size:12px;font-weight: normal;"> </span> <span class="blue">' . $destinatairs->nom;
				'</span>';
				$html .= '										</label>';
				$html .= '									</h4>';
				$html .= '								</th>';
				$html .= '							</tr>';
				$html .= '							<tr>';
				$html .= '								<th>';
				$html .= '									<h4>';
				$html .= '										<label class="control-label">';
				$html .= '											<span class="" style="font-weight: normal;">';
				$html .= '												' . $destinatairs->adresse . '<br>';
				$html .= '												<span style="float: left;">' . $destinatairs->region . ' , ' . $destinatairs->pays . '</span>';
				$html .= '											</span>';
				$html .= '										</label>';
				$html .= '									</h4>';
				$html .= '								</th>';
				$html .= '							</tr>';
				$html .= '							<tr>';
				$html .= '								<th>';
				$html .= '									<h4>';
				$html .= '										<label class="control-label pull-left" style="">';
				$html .= '											Emise le : ' . date('d/m/Y');
				$html .= '										</label>';
				$html .= '									</h4>';
				$html .= '								</th>';
				$html .= '							</tr>';
				$html .= '						</table>';
				$html .= '					</div>';
				$html .= '				</td>';
				$html .= '				<td style="text-align:right:width:50% !important" class="col-md-6">';
				$html .= '					<div class="col-md-8 invoice_head_right" style="float:right">';
				$html .= '						<table style="width:100%">';
				$html .= '							<tr>';
				$html .= '								<th>';
				$html .= '									<h4 class="blue">';
				$html .= '										<label class="control-label pull-right blue">' . lang("invoice_f") . ' NRO ' . '</label>';
				$html .= '									</h4>';
				$html .= '								</th>';
				$html .= '							</tr>';
				$html .= '							<tr>';
				$html .= '								<th>';
				$html .= '									<h3 class="blue"><label class="control-label pull-right blue">' . $code . '</label></h3>';
				$html .= '								</th>';
				$html .= '							</tr>';
				$html .= '						</table>';
				$html .= '						<br>';
				$html .= '';
				$html .= '					</div>';
				$html .= '					<div class="col-md-5 invoice_head_right" style="float:right;">';
				$html .= '						<table style="width:100%;">';
				$html .= '							<tr>';
				$html .= '								<th>';
				$html .= '									<h4>';
				$html .= '										<label class="control-label pull-right pp100" style="">';
				$html .= '											<span class="blue">' . $origins->nom . '</span>';
				$html .= '										</label>';
				$html .= '									</h4>';
				$html .= '								</th>';
				$html .= '							</tr>';
				$html .= '							<tr>';
				$html .= '								<th>';
				$html .= '									<h4>';
				$html .= '										<label class="control-label pull-right pp100" style="">';
				$orgiginsAdresse = $origins->adresse != null && trim($origins->adresse) != "" && trim($origins->adresse) != "--" ? trim($origins->adresse) : "";
				$html .= '											<span style="font-weight: normal;">' . $orgiginsAdresse . '</span>';
				$html .= '										</label>';
				$html .= '									</h4>';
				$html .= '								</th>';
				$html .= '							</tr>';
				$html .= '							<tr>';
				$html .= '								<th>';
				$html .= '									<h4>';

				$originsRegion = $origins->region != null && trim($origins->region) != "" && trim($origins->region) != "--" ? trim($origins->region) . ", " : "";

				$html .= '										<label class="control-label pull-right pp100" style="">';
				$html .= '											<span style="font-weight: normal;">' . $originsRegion . $origins->pays . '</span>';
				$html .= '										</label>';
				$html .= '									</h4>';
				$html .= '								</th>';
				$html .= '							</tr>';
				$html .= '';
				$html .= '							<tr>';
				$html .= '								<th>';
				$html .= '									<h4>';
				$html .= '										<label class="control-label pull-right pp100" style="">';
				$html .= '											<span style="font-weight: normal;">';
				$periode = date("d/m/Y", strtotime(date("Y-m-d") . ' + 15 DAY'));
				$html .= '												Période : ' . $periode;
				$html .= '											</span>';
				$html .= '										</label>';
				$html .= '									</h4>';
				$html .= '								</th>';
				$html .= '							</tr>';
				$html .= '							<tr>';
				$html .= '								<th>';
				$html .= '									<h4>';
				$html .= '										<label class="control-label pull-right pp100" style="">';
				$html .= '											A payer avant le : ' . $periode;
				$html .= '										</label>';
				$html .= '									</h4>';
				$html .= '								</th>';
				$html .= '							</tr>';
				$html .= '						</table>';
				$html .= '';
				$html .= '					</div>';
				$html .= '				</div>';
				$html .= '				</td>';
				$html .= '				</tr>';
				$html .= '				</table>';
				$html .= '';
				$html .= '			</div>';
				$html .= '';
				$html .= '';
				$html .= '';
				$html .= '';
				$html .= '		</div>';
				$html .= '';
				$html .= '';
				$html .= '';
				$html .= '		<table class="table table-hover progress-table text-center editable-sample editable-sample-paiement " id="editable-sample-">';
				$html .= '			<thead class="theadd">';
				$html .= '				<tr>';
				$html .= '';
				$html .= '					<th>' . lang("date") . '</th>';
				$html .= '					<th>' . lang("reference") . '</th>';
				$html .= '					<th>' . lang("patient") . '</th>';
				$html .= '					<th>' . lang("payment_procedures") . '</th>';
				$html .= '					<th>' . lang("amount") . '</th>';
				$html .= '				</tr>';
				$html .= '			</thead>';
				$html .= '			<tbody>';

				$total = 0;
				$prix = 0;
				foreach ($prestationTab as $prestations) {
					if (isset($prestations->category_name_pro)) {
						$category_name = $prestations->category_name_pro;
						$category_name1 = explode(",", $category_name);
						$i = 0;
						foreach ($category_name1 as $category_name2) {
							$i = $i + 1;
							$category_name3 = explode("*", $category_name2);
							if ($category_name3[3] > 0 && $category_name3[1]) {
								$html .= '								<tr>';
								$html .= '									<td>' . date("d/m/Y", $prestations->date) . '</td>';
								$html .= '									<td>' . $prestations->code_pro . '</td>';
								$html .= '									<td>' . $prestations->patient_id . '</td>';
								$html .= '									<td>' . $this->finance_model->getPaymentcategoryById($category_name3[0])->prestation . '</td>';

								$prix = $prix + $category_name3[1];

								$html .= '									<td class="">' . number_format($category_name3[1], 0, ",", ".") . ' ' . $settings->currency . '</td>';
								$html .= '								</tr>';

								$total =  $total + $category_name3[1];
							}
						}
					}
				}
				$html .= '			</tbody>';
				$html .= '		</table>';

				$html .= '		<div class="col-md-12 hr_border">';
				$html .= '			<hr>';
				$html .= '		</div>';
				$html .= '';
				$html .= '		<div class="">';
				$html .= '			<div class="col-lg-4 invoice-block pull-left">';
				$html .= '				<h4></h4>';
				$html .= '			</div>';
				$html .= '		</div>';
				$html .= '';
				$html .= '		<div class="col-md-12">';
				$html .= '			<div class="col-lg-4 invoice-block pull-right">';
				$html .= '				<ul class="unstyled amounts">';
				$html .= '';
				$html .= '					<li><strong>' . lang("grand_total_ht") . ': </strong> ' . number_format($total, 0, ",", ".") . ' ' .  $settings->currency . '</li>';
				$html .= '					<li><strong>' . lang("tva") . '%: </strong> 0 ' . $settings->currency . '</li>';
				$html .= '					<li><strong>' . lang("grand_total_ttc") . ': </strong> ' . number_format($total, 0, ",", ".") . ' ' .  $settings->currency . '</li>';
				$html .= '				</ul>';
				$html .= '			</div>';
				$html .= '		</div>';
				$html .= '';
				$html .= '		<div class="col-md-12 invoice_footer">';
				$html .= '			<div class="col-md-12 row" style="margin-bottom:40px">';
				$html .= '				<table>';
				$html .= '					<tr>';
				$html .= '						<th>';
				$html .= '';
				$html .= '							<label class="control-label" style="">';
				$html .= '								<span style="font-weight: normal;">';
				$html .= '									Merci de régler la facture avant échéance via virement bancaire, zuuluPay, Orange Money...';
				$html .= '								</span>';
				$html .= '';
				$html .= '							</label>';
				$html .= '';
				$html .= '						</th>';
				$html .= '					</tr>';
				$html .= '					<tr>';
				$html .= '						<th>';
				$html .= '';
				$html .= '							<label class="control-label" style="">';
				$html .= '								Nous vous remercions de votre fidelité';
				$html .= '							</label>';
				$html .= '';
				$html .= '						</th>';
				$html .= '					</tr>';
				$html .= '				</table>';
				$html .= '';
				$html .= '			</div>';
				$html .= '		</div>';
				$html .= '';
				$html .= '';
				$html .= '';
				$html .= '	</div>';
				$html .= '</div>';
				// $this->load->view('home/footer'); // just the header file
				// echo "<script language=\"javascript\">alert(\"html right after: ".$html."\");</script>";

			}

			$date1 = $this->input->post("date1");
			$date2 = $this->input->post("date2");
			$emailLight = $this->input->post("emailOrganisationLightOrigine");
			$name = $this->input->post("name");


			// Creation & Sauvegarde PDF
			try {
				$mpdf = new \Mpdf\Mpdf([
					'debug' => true,
					'allow_output_buffering' => true
				]);

				$mpdf->WriteHTML($html);
				// $mpdf->WriteHTML("<table><tr><td>HELLO WORLD</td></tr></table>");
				$mpdf->Output(FCPATH . 'files/sent/' . $name . ".pdf", \Mpdf\Output\Destination::FILE);
			} catch (\Mpdf\MpdfException $e) { // Note: safer fully qualified exception 
				//       name used for catch
				// Process the exception, log, print etc.
				// echo json_encode($e->getMessage());
			}

			// ob_end_clean();

			//// Email
			//// FACTURE {nro_facture} DU PRESTATAIRE {nom_organisation_prestataire} | PERIODE: {periode_facture}
			//// Cher Partenaire,
			//// Veuillez recevoir en pièce-jointe la facture numéro {nro_facture} pour la periode {periode_facture}.
			//// Merci de votre confiance
			//// {nom_organisation_prestataire} via ecoMed24.

			// Envoi email
			$attachment_path = FCPATH . 'files/sent/' . $name . ".pdf";
			$nom_organisation_prestataire = $this->home_model->get_nom_organisation($this->id_organisation);
			$nom_organisation_light_origin = $this->home_model->get_nom_organisation($idOrganisation);
			$periode_facture = $date1 . "-" . $date2;


			// echo "<script language=\"javascript\">alert(\"".$attachment_path."\");</script>";
			// echo "<script language=\"javascript\">alert(\"".$periode_facture."\");</script>";

			//// FACTURE {nro_facture} DU PRESTATAIRE {nom_organisation_prestataire} | PERIODE: {periode_facture}
			//// Cher Partenaire,
			//// Veuillez recevoir en pièce-jointe la facture numéro {nro_facture} pour la periode {periode_facture}.
			//// Merci de votre confiance
			//// {nom_organisation_prestataire} via ecoMed24.

			$data1Email = array(
				'nom_organisation_prestataire' => $nom_organisation_prestataire,
				'nro_facture' => $codeFacture,
				'periode_facture' => $periode_facture,
				'nom_organisation_light_origin' => $nom_organisation_light_origin
			);


			$autoemail = $this->email_model->getAutoEmailByType('facture_light');

			$message1 = $autoemail->message;
			$subject = $this->parser->parse_string($autoemail->name, $data1Email, true);
			$messageprint2 = $this->parser->parse_string($message1, $data1Email, true);
			$dataInsertEmail = array(
				'reciepient' => $emailLight,
				'subject' => $subject,
				'message' => $messageprint2,
				'date' => time(),
				'user' => $this->ion_auth->get_user_id(),
				'attachment_path' => $attachment_path,
			);
			$this->email_model->insertEmail($dataInsertEmail);

			$origins = $this->partenaire_model->payListeFactureByaLL($this->id_organisation, 1, false, 'accept');
			$originsLight = $this->partenaire_model->payListeFactureByaLL($this->id_organisation, false, 1, 'accept');
			$info = array();
			$origins = array_merge($origins, $originsLight);
			// $payments = $this->finance_model->getStatusPaymentByTraitance(1,'finish' ,$this->id_organisation);
			foreach ($origins as $payment) {
				if ($payment->etatlight == 1) {
					if ($this->id_organisation == $payment->id_organisation) {
						//   $cree_par = $this->partenaire_model->getPartenairesById($payment->id_organisation)->nom;
						isset($payment->id_organisation) ? $cree_par = $this->partenaire_model->getPartenairesById($payment->id_organisation)->nom : $cree_par = '';
						$date = date('d/m/Y H:i', $payment->date);
						if ($payment->etatlight == 1) {
							$dataTab = explode(',', $payment->category_name_pro);
							foreach ($dataTab as $value) {
								$valueTab = explode('*', $value);
								if (isset($valueTab[4])) {
									$id_prestation = $valueTab[0];
									$tarif_professionnel = $valueTab[1];
									$current_prestation = $this->finance_model->getPaymentCategoryByOrganisationById2($id_prestation);
									/* $tarif_professionnel = '';
									  if (isset($current_prestation->tarif_professionnel)) {
									  $tarif_professionnel = number_format($current_prestation->tarif_professionnel, 0, ",", ".") . ' ' . $this->settings_model->getSettings()->currency;
									  }
									 */
									$info[] = array(
										$payment->id,
										$date,
										$payment->code,
										$current_prestation->prestation,
										$this->partenaire_model->getPartenairesById($payment->organisation_light_origin)->nom,
										$payment->patient,
										number_format($tarif_professionnel, 0, ",", ".") . ' ' . $this->settings_model->getSettings()->currency
									);
								}
							}
						}
					}
				}
			}
			$data2['listeCommandes'] = $info;


			$data2['settings'] = $this->settings_model->getSettings();

			$data2['id_organisation'] = $this->id_organisation;
			$data2['path_logo'] = $this->path_logo;
			$data2['nom_organisation'] = $this->nom_organisation;

			$this->load->view('home/dashboard', $data2);
			$this->load->view('liste_facture_prestation', $data2);
			$this->load->view('home/footer');
		}
	}

	function searhPartenaireLightOriginByFacture()
	{
		$searchTerm = $this->input->post('searchTerm');
		$response = $this->partenaire_model->searhPartenaireLightOriginByFacture($searchTerm, $this->id_organisation);
		echo json_encode($response);
	}

	function searhPartenaireByFature()
	{
		$searchTerm = $this->input->post('searchTerm');
		$response = $this->partenaire_model->searhPartenaireByFature($searchTerm, $this->id_organisation);
		echo json_encode($response);
	}

	function listePrestationByPartenaire()
	{
		$id = $this->input->get('id');
		$date1 = $this->input->get('date1');
		$date2 = $this->input->get('date2');
		if ($date1) {
			$date1 = strtotime(str_replace('/', '-', $this->input->get('date1')));
		} else {
			$date1 =  '01-01-2020 23:59';
		}
		if ($date2) {
			$date2 = strtotime(str_replace('/', '-', $this->input->get('date2') . ' 23:59'));
		} else {
			$date2 =  date('d-m-Y 23:59');
		}
		// var_dump($date2 .'<'. $date1);

		/* if (!empty($date2) && !empty($date1) && $date2 < $date1) {
            echo json_encode(array('result' => false, 'message' => lang('time_selection_error_partenaite')));
            die();
        }*/

		$origins = $this->partenaire_model->payListeFactureByaLL($this->id_organisation, 1, false, 'accept', false, $id, $date1, $date2);
		$originsLight = $this->partenaire_model->payListeFactureByaLL($this->id_organisation, false, 1, 'accept', false, $id, $date1, $date2);
		$origins = array_merge($origins, $originsLight);

		//var_dump($origins);
		$info = '';
		$info0 = '';
		$paymentorganisation_destinataire = '';
		$paymentid_organisation = '';
		$Organisationdestinatairs = array();
		$Organisationorigins = array();
		$ttotal = 0;
		foreach ($origins as $payment) {
			if ($payment->etat == 1) {
				if ($this->id_organisation == $payment->organisation_destinataire) {

					isset($payment->organisation_destinataire) ? $cree_par = $this->partenaire_model->getPartenairesById($payment->organisation_destinataire)->nom : $cree_par = '';
					$date = date('d/m/Y H:i', $payment->date);
					if ($payment->etat == 1 && $payment->id_organisation == $id && ($date1 <= $payment->date && $payment->date <= $date2)) {
						$paymentorganisation_destinataire = $payment->organisation_destinataire;
						$paymentid_organisation = $payment->id_organisation;
						$dataTab = explode(',', $payment->category_name_pro);
						foreach ($dataTab as $value) {
							$valueTab = explode('*', $value);
							if (isset($valueTab[4])) {
								$id_prestation = $valueTab[0];
								$tarif_professionnel = $valueTab[1];
								$current_prestation = $this->finance_model->getPaymentCategoryByOrganisationById2($id_prestation);
								/* $tarif_professionnel = '';
								  if (isset($current_prestation->tarif_professionnel)) {
								  $tarif_professionnel = number_format($current_prestation->tarif_professionnel, 0, ",", ".") . ' ' . $this->settings_model->getSettings()->currency;
								  } */

								$info .= '<tr class="odd" role="row"> ' .
									'<td>' . $payment->id . '</td>' .
									'<td>' . $date . '</td>' .
									'<td>' . $payment->code . '</td>' .
									'<td>' . $current_prestation->prestation . '</td>' .
									//'<td>' . $cree_par . '</td>' .
									'<td>' . $payment->nom . '</td>' .
									'<td>' . $payment->patient . '</td>' .
									'<td>' .  number_format($tarif_professionnel, 0, ",", ".") . ' ' . $this->settings_model->getSettings()->currency . '</td></tr>';

								$info0 .= '<tr class="odd" role="row"> ' .
									'<td>' . $date . '</td>' .
									'<td>' . $payment->code . '</td>' .
									'<td>' . $current_prestation->prestation . '</td>' .
									'<td>' . $payment->patient . '</td>' .
									'<td>' .  number_format($tarif_professionnel, 0, ",", ".") . ' ' . $this->settings_model->getSettings()->currency . '</td></tr>';
								$ttotal = intval($ttotal) + intval($tarif_professionnel);
							}
						}
					}
				}
			} else if ($payment->etatlight == 1) {
				if ($this->id_organisation == $payment->id_organisation) {

					isset($payment->id_organisation) ? $cree_par = $this->partenaire_model->getPartenairesById($payment->id_organisation)->nom : $cree_par = '';
					$date = date('d/m/Y H:i', $payment->date);
					if ($payment->etatlight == 1 && $payment->organisation_light_origin == $id && ($date1 <= $payment->date && $payment->date <= $date2)) {
						$paymentorganisation_destinataire = $payment->id_organisation; // Même info dans les 2 champs com workaround temporaire
						$paymentid_organisation = $payment->organisation_light_origin;
						$dataTab = explode(',', $payment->category_name_pro);
						foreach ($dataTab as $value) {
							$valueTab = explode('*', $value);
							if (isset($valueTab[4])) {
								$id_prestation = $valueTab[0];
								$tarif_professionnel = $valueTab[1];
								$current_prestation = $this->finance_model->getPaymentCategoryByOrganisationById2($id_prestation);
								/* $tarif_professionnel = '';
								  if (isset($current_prestation->tarif_professionnel)) {
								  $tarif_professionnel = number_format($current_prestation->tarif_professionnel, 0, ",", ".") . ' ' . $this->settings_model->getSettings()->currency;
								  } */

								$info .= '<tr class="odd" role="row"> ' .
									'<td>' . $payment->id . '</td>' .
									'<td>' . $date . '</td>' .
									'<td>' . $payment->code . '</td>' .
									'<td>' . $current_prestation->prestation . '</td>' .
									//'<td>' . $cree_par . '</td>' .
									'<td>' . $this->partenaire_model->getPartenairesById($payment->organisation_light_origin)->nom . '</td>' .
									'<td>' . $payment->patient . '</td>' .
									'<td>' .  number_format($tarif_professionnel, 0, ",", ".") . ' ' . $this->settings_model->getSettings()->currency . '</td></tr>';

								$info0 .= '<tr class="odd" role="row"> ' .
									'<td>' . $date . '</td>' .
									'<td>' . $payment->code . '</td>' .
									'<td>' . $current_prestation->prestation . '</td>' .
									'<td>' . $payment->patient . '</td>' .
									'<td>' .  number_format($tarif_professionnel, 0, ",", ".") . ' ' . $this->settings_model->getSettings()->currency . '</td></tr>';
								$ttotal = intval($ttotal) + intval($tarif_professionnel);
							}
						}
					}
				}
			}
		}
		$tarif_ttotal = number_format($ttotal, 0, ",", ".") . ' ' . $this->settings_model->getSettings()->currency;
		$tarif_ttva = '0 ' . $this->settings_model->getSettings()->currency;

		if ($paymentorganisation_destinataire && $paymentid_organisation) {
			$Organisationdestinatairs = $this->home_model->getOrganisationById($paymentorganisation_destinataire);
			$Organisationorigins = $this->home_model->getOrganisationById($paymentid_organisation);
		}
		$is_light = '';
		if (isset($Organisationorigins->is_light)) {
			$is_light = $Organisationorigins->is_light;
		}
		$email = '';
		if (isset($Organisationorigins->email)) {
			$email = $Organisationorigins->email;
		}
		echo json_encode(array('result' => true, "message" => $info, "destinatairs" => $Organisationdestinatairs, "origins" => $Organisationorigins, "prestations" => $info0, "total" => $tarif_ttotal, "tva" => $tarif_ttva, "etatlight" => $is_light, "emailOrganisationLightOrigine" => $email));
	}

	function validFaurePartenaire()
	{
		log_message('ecomed', 'index appointment');
		$id = $this->input->post('idOrganisation');
		$date1 = strtotime(str_replace('/', '-', $this->input->post('date1')));
		$date2 = strtotime(str_replace('/', '-', $this->input->post('date2') . ' 23:59'));
		$origins = $this->partenaire_model->payListeFactureByaLL($this->id_organisation, 1, false, 'accept', false, $id, $date1, $date2);
		$originslight = $this->partenaire_model->payListeFactureByaLL($this->id_organisation, false, 1, 'accept', false, $id, $date1, $date2);
		$origins = array_merge($origins, $originslight);
		$date = time();
		$dateEmise = date('d/m/Y', $date);
		$valuenew = array();
		// var_dump($date1.' '.$date2.' '.$date_string);
		// exit();
		if (!empty($origins)) {
			$date = time();
			$date_string = date('d/m/Y H:i', $date);
			$user = $this->ion_auth->get_user_id();
			$data = array(
				'category_name_pro' => $category_name,
				'date' => $date,
				'user' => $user,
				'date_string' => $date_string,
				'id_organisation' => $this->id_organisation,
				'etat' => 1, "status" => "demandpay",
				'organisation_destinataire' => $id
			);
			$this->finance_model->insertPayment($data);
			$inserted_id = $this->db->insert_id();
			$count_payment = $this->db->get_where('payment', array('id_organisation =' => $this->id_organisation))->num_rows();
			
			// $codeFacture = 'F-' . $this->code_organisation . '-' . str_pad($count_payment, 4, "0", STR_PAD_LEFT);
			$codeFacture = 'F' . $this->code_organisation . '' . $count_payment;
			$this->finance_model->updatePayment($inserted_id, array('code' => $codeFacture), $this->id_organisation);
		}

		$total = 0;
		foreach ($origins as $payment) {
			$organisation_destinataire = $payment->organisation_destinataire;
			$id_organisation = $payment->id_organisation;
			if ($payment->etat == 1) {
				if ($this->id_organisation == $payment->organisation_destinataire) {
					if ($payment->etat == 1 && $payment->id_organisation == $id && ($date1 <= $payment->date && $payment->date <= $date2)) {
						$dataTab = explode(',', $payment->category_name_pro);
						$category_name = $payment->category_name_pro;
						foreach ($dataTab as $value) {
							$valueTab = explode('*', $value);
							if (isset($valueTab[4])) {
								$id_prestation = $valueTab[0];
								$type = 6;
								$check = $valueTab[0] . '*' . $valueTab[1] . '*' . $valueTab[2] . '*' . $valueTab[3] . '*' . $type;
								$category_name = str_replace($value, $check, $category_name);
								$total = intval($total) + intval($valueTab[1]);
							}

							$valuenew = array("category_name_pro" => $category_name, "code_pro" => $payment->code, "status" => "demandpay", "status_presta" => "finish");
						}

						if ($category_name) {
							$this->finance_model->updatePayment($payment->id, $valuenew);
							$this->partenaire_model->insertPaymentPro(array('codefacture' => $codeFacture, 'codepro' => $payment->code,'dateDebut' => $date1, 'dateFin' => $date2, 'date' => $dateEmise));
						}
					}
				}
			} else if ($payment->etatlight == 1) {
				if ($this->id_organisation == $payment->id_organisation) {
					if ($payment->etatlight == 1 && $payment->organisation_light_origin == $id && ($date1 <= $payment->date && $payment->date <= $date2)) {
						$dataTab = explode(',', $payment->category_name_pro);
						$category_name = $payment->category_name_pro;
						foreach ($dataTab as $value) {
							$valueTab = explode('*', $value);
							if (isset($valueTab[4])) {
								$id_prestation = $valueTab[0];
								$type = 6;
								$check = $valueTab[0] . '*' . $valueTab[1] . '*' . $valueTab[2] . '*' . $valueTab[3] . '*' . $type;
								$category_name = str_replace($value, $check, $category_name);
								$total = intval($total) + intval($valueTab[1]);
							}

							$valuenew = array("category_name_pro" => $category_name, "code_pro" => $payment->code, "status" => "demandpay", "status_presta" => "finish");
						}

						if ($category_name) {
							$this->finance_model->updatePayment($payment->id, $valuenew);
							$this->partenaire_model->insertPaymentPro(array('codefacture' => $codeFacture, 'codepro' => $payment->code,'dateDebut' => $date1, 'dateFin' => $date2, 'date' => $dateEmise ));
						}
					}
				}
			}
		}

		if ($category_name) {
			$this->finance_model->updatePaymentByCode($codeFacture, array('gross_total' => $total));
			$this->session->set_flashdata('feedback', lang('sendfacturepro'));
		}
	}

	function validFaurePartenaireLight()
	{

		$id = $this->input->post('idOrganisation');
		$date1 = strtotime(str_replace('/', '-', $this->input->post('date1')));
		$date2 = strtotime(str_replace('/', '-', $this->input->post('date2') . ' 23:59'));
		$origins = $this->partenaire_model->payListeFactureByaLL($this->id_organisation, 1, false, 'accept', false, $id, $date1, $date2);
		$originslight = $this->partenaire_model->payListeFactureByaLL($this->id_organisation, false, 1, 'accept', false, $id, $date1, $date2);
		$origins = array_merge($origins, $originslight);
		$date = time();
		$dateEmise = date('d/m/Y', $date);
		$valuenew = array();
		if (!empty($origins)) {
			$date = time();
			$date_string = date('d/m/Y H:i', $date);
			$user = $this->ion_auth->get_user_id();
			$data = array(
				'category_name_pro' => $category_name,
				'date' => $date,
				'user' => $user,
				'date_string' => $date_string,
				'id_organisation' => $this->id_organisation,
				'etat' => 1, "status" => "demandpay",
				'organisation_destinataire' => $id
			);
			$this->finance_model->insertPayment($data);
			$inserted_id = $this->db->insert_id();
			$count_payment = $this->db->get_where('payment', array('id_organisation =' => $this->id_organisation))->num_rows();

			// $codeFacture = 'F-' . $this->code_organisation . '-' . str_pad($count_payment, 4, "0", STR_PAD_LEFT);
			$codeFacture = 'F' . $this->code_organisation . '' . $count_payment;
			$this->finance_model->updatePayment($inserted_id, array('code' => $codeFacture), $this->id_organisation);
		}

		$total = 0;
		foreach ($origins as $payment) {
			$organisation_destinataire = $payment->organisation_destinataire;
			$id_organisation = $payment->id_organisation;
			if ($payment->etatlight == 1) {
				if ($this->id_organisation == $payment->id_organisation) {
					if ($payment->etatlight == 1 && $payment->organisation_light_origin == $id && ($date1 <= $payment->date && $payment->date <= $date2)) {
						$dataTab = explode(',', $payment->category_name_pro);
						$category_name = $payment->category_name_pro;
						foreach ($dataTab as $value) {
							$valueTab = explode('*', $value);
							if (isset($valueTab[4])) {
								$id_prestation = $valueTab[0];
								$type = 6;
								$check = $valueTab[0] . '*' . $valueTab[1] . '*' . $valueTab[2] . '*' . $valueTab[3] . '*' . $type;
								$category_name = str_replace($value, $check, $category_name);
								$total = intval($total) + intval($valueTab[1]);
							}

							$valuenew = array("category_name_pro" => $category_name, "code_pro" => $payment->code, "status" => "demandpay", "status_presta" => "finish");
						}

						if ($category_name) {
							$this->finance_model->updatePayment($payment->id, $valuenew);
							$this->partenaire_model->insertPaymentPro(array('codefacture' => $codeFacture, 'codepro' => $payment->code,'dateDebut' => $date1, 'dateFin' => $date2, 'date' => $dateEmise));						}
					}
				}
			}
		}

		if ($category_name) {
			$this->finance_model->updatePaymentByCode($codeFacture, array('gross_total' => $total));
			$this->session->set_flashdata('feedback', lang('sendfacturepro'));
		}
		return $codeFacture;
	}

	// function genererFactureProLightPourEnvoi($destinatairs, $origins, $settings, $codeFacture, $mode, $modelight, $code, $pay, $payStatusPro, $prestationTab) {

	// $html = '<div class="panel panel-primary" id="invoice">';
	// $html .= '	<div class="panel-body" id="editPaymentForm">';
	// $html .= '		<div class="col-md-12" id="body-print" style="background-color: #fff">';
	// $html .= '			<div class="row invoice-list">';
	// $html .= '				<div class="col-md-12 invoice_head clearfix">';
	// $html .= '					<div class="col-md-4  invoice_head_left" style="float:left">';
	// if($destinatairs->path_logo) { 
	// $html .= '							<img src="'.$destinatairs->path_logo.'" style="max-width:220px;max-height:150px;margin-top:-12px" />';
	// } 
	// $html .= '					</div>';
	// $html .= '					<div class="col-md-8 invoice_head_right" style="float:right">';
	// $html .= '						<table style="width:100%">';
	// $html .= '							<tr>';
	// $html .= '								<th>';
	// $html .= '									<h4 class="blue">';
	// $html .= '										<label class="control-label pull-right blue">'.lang("invoice_f").' NRO '. '</label>';
	// $html .= '									</h4>';
	// $html .= '								</th>';
	// $html .= '							</tr>';
	// $html .= '							<tr>';
	// $html .= '								<th>';
	// $html .= '									<h3 class="blue"><label class="control-label pull-right blue">'.$code.'</label></h3>';
	// $html .= '								</th>';
	// $html .= '							</tr>';
	// $html .= '						</table>';
	// $html .= '						<br>';
	// $html .= '';
	// $html .= '					</div>';
	// $html .= '				</div>';
	// $html .= '				<div class="col-md-12 invoice_head clearfix">';
	// $html .= '					<div class="col-md-5  invoice_head_left" style="float:left;">';
	// $html .= '						<table style="width:100%">';
	// $html .= '							<tr>';
	// $html .= '								<th>';
	// $html .= '									<h4>';
	// $html .= '										<label class="control-label pull-left">';
	// $html .= '											<span style="font-size:12px;font-weight: normal;"> </span> <span class="blue">'.$destinatairs->nom;'</span>';
	// $html .= '										</label>';
	// $html .= '									</h4>';
	// $html .= '								</th>';
	// $html .= '							</tr>';
	// $html .= '							<tr>';
	// $html .= '								<th>';
	// $html .= '									<h4>';
	// $html .= '										<label class="control-label">';
	// $html .= '											<span class="" style="font-weight: normal;">';
	// $html .= '												'.$destinatairs->adresse.'<br>';
	// $html .= '												<span style="float: left;">'.$destinatairs->region . ' , ' . $destinatairs->pays.'</span>';
	// $html .= '											</span>';
	// $html .= '										</label>';
	// $html .= '									</h4>';
	// $html .= '								</th>';
	// $html .= '							</tr>';
	// $html .= '							<tr>';
	// $html .= '								<th>';
	// $html .= '									<h4>';
	// $html .= '										<label class="control-label pull-left" style="">';
	// $html .= '											Emise le : '.$date_facture;
	// $html .= '										</label>';
	// $html .= '									</h4>';
	// $html .= '								</th>';
	// $html .= '							</tr>';
	// $html .= '						</table>';
	// $html .= '					</div>';
	// $html .= '					<div class="col-md-5 invoice_head_right" style="float:right;">';
	// $html .= '						<table style="width:100%;">';
	// $html .= '							<tr>';
	// $html .= '								<th>';
	// $html .= '									<h4>';
	// $html .= '										<label class="control-label pull-right pp100" style="">';
	// $html .= '											<span class="blue">'.$origins->nom.'</span>';
	// $html .= '										</label>';
	// $html .= '									</h4>';
	// $html .= '								</th>';
	// $html .= '							</tr>';
	// $html .= '							<tr>';
	// $html .= '								<th>';
	// $html .= '									<h4>';
	// $html .= '										<label class="control-label pull-right pp100" style="">';
	// $orgiginsAdresse = $origins->adresse != null && trim($origins->adresse) != "" && trim($origins->adresse) != "--" ? trim($origins->adresse) : "";
	// $html .= '											<span style="font-weight: normal;">'.$orgiginsAdresse.'</span>';
	// $html .= '										</label>';
	// $html .= '									</h4>';
	// $html .= '								</th>';
	// $html .= '							</tr>';
	// $html .= '							<tr>';
	// $html .= '								<th>';
	// $html .= '									<h4>';

	// $originsRegion = $origins->region != null && trim($origins->region) != "" && trim($origins->region) != "--" ? trim($origins->region).", " : "";

	// $html .= '										<label class="control-label pull-right pp100" style="">';
	// $html .= '											<span style="font-weight: normal;">'.$originsRegion . $origins->pays.'</span>';
	// $html .= '										</label>';
	// $html .= '									</h4>';
	// $html .= '								</th>';
	// $html .= '							</tr>';
	// $html .= '';
	// $html .= '							<tr>';
	// $html .= '								<th>';
	// $html .= '									<h4>';
	// $html .= '										<label class="control-label pull-right pp100" style="">';
	// $html .= '											<span style="font-weight: normal;">';
	// $periode = date("d/m/Y", strtotime(date("Y-m-d") . ' + 15 DAY'));
	// $html .= '												Période : '.$periode;
	// $html .= '											</span>';
	// $html .= '										</label>';
	// $html .= '									</h4>';
	// $html .= '								</th>';
	// $html .= '							</tr>';
	// $html .= '							<tr>';
	// $html .= '								<th>';
	// $html .= '									<h4>';
	// $html .= '										<label class="control-label pull-right pp100" style="">';
	// $html .= '											A payer avant le : '.$periode;
	// $html .= '										</label>';
	// $html .= '									</h4>';
	// $html .= '								</th>';
	// $html .= '							</tr>';
	// $html .= '						</table>';
	// $html .= '';
	// $html .= '					</div>';
	// $html .= '				</div>';
	// $html .= '';
	// $html .= '			</div>';
	// $html .= '';
	// $html .= '';
	// $html .= '';
	// $html .= '';
	// $html .= '		</div>';
	// $html .= '';
	// $html .= '';
	// $html .= '';
	// $html .= '		<table class="table table-hover progress-table text-center editable-sample editable-sample-paiement " id="editable-sample-">';
	// $html .= '			<thead class="theadd">';
	// $html .= '				<tr>';
	// $html .= '';
	// $html .= '					<th>'.lang("date").'</th>';
	// $html .= '					<th>'.lang("reference").'</th>';
	// $html .= '					<th>'.lang("patient").'</th>';
	// $html .= '					<th>'.lang("payment_procedures").'</th>';
	// $html .= '					<th>'.lang("amount").'</th>';
	// $html .= '				</tr>';
	// $html .= '			</thead>';
	// $html .= '			<tbody>';

	// $total = 0;
	// $prix = 0;
	// foreach ($prestationTab as $prestations) {     				
	// if (isset($prestations->category_name_pro)) {
	// $category_name = $prestations->category_name_pro;
	// $category_name1 = explode(",", $category_name);
	// $i = 0;
	// foreach ($category_name1 as $category_name2) {
	// $i = $i + 1;
	// $category_name3 = explode("*", $category_name2);
	// if ($category_name3[3] > 0 && $category_name3[1]) {
	// $html .= '								<tr>';
	// $html .= '									<td>'.date("d/m/Y", $prestations->date).'</td>';
	// $html .= '									<td>'.$prestations->code_pro.'</td>';
	// $html .= '									<td>'.$prestations->patient_id.'</td>';
	// $html .= '									<td>'.$this->finance_model->getPaymentcategoryById($category_name3[0])->prestation.'</td>';

	// $prix = $prix + $category_name3[1];

	// $html .= '									<td class="">'.number_format($category_name3[1], 0, ",", ".") . ' ' . $settings->currency.'</td>';
	// $html .= '								</tr>';

	// $total =  $total + $category_name3[1];
	// }
	// }
	// }
	// }
	// $html .= '			</tbody>';
	// $html .= '		</table>';

	// $html .= '		<div class="col-md-12 hr_border">';
	// $html .= '			<hr>';
	// $html .= '		</div>';
	// $html .= '';
	// $html .= '		<div class="">';
	// $html .= '			<div class="col-lg-4 invoice-block pull-left">';
	// $html .= '				<h4></h4>';
	// $html .= '			</div>';
	// $html .= '		</div>';
	// $html .= '';
	// $html .= '		<div class="col-md-12">';
	// $html .= '			<div class="col-lg-4 invoice-block pull-right">';
	// $html .= '				<ul class="unstyled amounts">';
	// $html .= '';
	// $html .= '					<li><strong>'.lang("grand_total_ht").': </strong> '.number_format($total, 0, ",", ".") . ' ' .  $settings->currency.'</li>';
	// $html .= '					<li><strong>'.lang("tva").'%: </strong> 0'.$settings->currency.'</li>';
	// $html .= '					<li><strong>'.lang("grand_total_ttc").': </strong> '.number_format($total, 0, ",", ".") . ' ' .  $settings->currency.'</li>';
	// $html .= '				</ul>';
	// $html .= '			</div>';
	// $html .= '		</div>';
	// $html .= '';
	// $html .= '		<div class="col-md-12 invoice_footer">';
	// $html .= '			<div class="col-md-12 row" style="margin-bottom:40px">';
	// $html .= '				<table>';
	// $html .= '					<tr>';
	// $html .= '						<th>';
	// $html .= '';
	// $html .= '							<label class="control-label" style="">';
	// $html .= '								<span style="font-weight: normal;">';
	// $html .= '									Merci de régler la facture avant échéance via virement bancaire, zuuluPay, Orange Money...';
	// $html .= '								</span>';
	// $html .= '';
	// $html .= '							</label>';
	// $html .= '';
	// $html .= '						</th>';
	// $html .= '					</tr>';
	// $html .= '					<tr>';
	// $html .= '						<th>';
	// $html .= '';
	// $html .= '							<label class="control-label" style="">';
	// $html .= '								Nous vous remercions de votre fidelité';
	// $html .= '							</label>';
	// $html .= '';
	// $html .= '						</th>';
	// $html .= '					</tr>';
	// $html .= '				</table>';
	// $html .= '';
	// $html .= '			</div>';
	// $html .= '		</div>';
	// $html .= '';
	// $html .= '';
	// $html .= '';
	// $html .= '	</div>';
	// $html .= '</div>';	

	// return $html;

	// }

}

/* End of file finance.php */
/* Location: ./application/modules/finance/controllers/finance.php */
