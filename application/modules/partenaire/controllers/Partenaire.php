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
		$this->entete = $this->home_model->get_entete($this->id_organisation);
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

	public function addNewLight()
	{

		if (!$this->ion_auth->logged_in()) {
			redirect('auth/login', 'refresh');
		} else {
			$data['partenaires'] = $this->partenaire_model->getPartenaires($this->id_organisation);
			$data['settings'] = $this->settings_model->getSettings();

			$data['id_organisation'] = $this->id_organisation;
			$data['path_logo'] = $this->path_logo;
			$data['nom_organisation'] = $this->nom_organisation;

			$nom = $this->input->post('name');
			$type = $this->input->post('type');
			$phone = $this->input->post('phone');
			$email = $this->input->post('email');
			$adresse = $this->input->post('adresse');
			$redirect = $this->input->post('redirect');
			$add_date = date('m/d/y');
			$data = array();
			$dataLight = array();
			$category = $this->input->post('category');
			$data = array(
				'nom' => $nom,
				'type' => $type,
				'is_light' => 1,
				'email' => $email,
				'portable_responsable_legal' => $phone,
				'path_logo' => '--',
				'adresse' => $adresse
			);
			$inserted_id =  $this->partenaire_model->insertPartenaireLight($data);
			$inserted_id = $this->db->insert_id();
			$dataLight = array(
				'id_organisation_origin' => $inserted_id,
				'id_organisation_destinataire' => $this->id_organisation,
				'partenariat_actif' => 1,
				'category' => $category
			);
			$output = $this->partenaire_model->insertPartenaire($dataLight);
			$this->session->set_flashdata('feedback', lang('added'));

			if ($redirect == "partenaire") {
				redirect($redirect);
			} else if ($redirect == "finance/addPaymentView") {
				$typetraitance = $this->input->post('typetraitance');
				$partenaire = $this->input->post('partenairetraitance');
				$redirect = $redirect . '?partenairelightcheck=' . $nom . '&idpartenairelightcheck=' . $inserted_id;
				redirect($redirect);
			}
		}
	}


	public function editNewLight()
	{

		if (!$this->ion_auth->logged_in()) {
			redirect('auth/login', 'refresh');
		} else {
			$data['partenaires'] = $this->partenaire_model->getPartenaires($this->id_organisation);
			$data['settings'] = $this->settings_model->getSettings();

			$data['id_organisation'] = $this->id_organisation;
			$data['path_logo'] = $this->path_logo;
			$data['nom_organisation'] = $this->nom_organisation;

			$nom = $this->input->post('name');
			$type = $this->input->post('type');
			$phone = $this->input->post('phone');
			$email = $this->input->post('email');
			$adresse = $this->input->post('adresse');
			$redirect = $this->input->post('redirect');
			$idPartenaire = $this->input->post('idPartenaire');
			$idOrganisation = $this->input->post('idOrganisation');
			$data = array();
			$dataLight = array();
			$category = $this->input->post('category');
			$data = array(
				'nom' => $nom,
				'type' => $type,
				'is_light' => 1,
				'email' => $email,
				'portable_responsable_legal' => $phone,
				'path_logo' => '--',
				'adresse' => $adresse
			);
			$dataLight = array(
				'category' => $category
			);
			$this->finance_model->updateOrganisation($idOrganisation, $data);
			$this->finance_model->updatePartenaire($idPartenaire, $dataLight);
			$this->session->set_flashdata('feedback', lang('updated'));
			redirect('partenaire');
		}
	}



	public function editLightPartenaire()
	{
		$data = array();
		$data['settings'] = $this->settings_model->getSettings();
		$id = $this->input->get('id');
		$idOrganisation = $this->input->get('idOrganisation');
		$data['id_organisation'] = $this->id_organisation;
		$data['path_logo'] = $this->path_logo;
		$data['nom_organisation'] = $this->nom_organisation;
		$data['organisation'] = $this->finance_model->getOrganisationById($idOrganisation);
		$data['partenaire'] = $this->finance_model->getOrganisationByLightId($id);
		$this->load->view('home/dashboard', $data);
		$this->load->view('edit_organisation_light', $data);
		$this->load->view('home/footer');
	}

	public function factures()
	{

		if (!$this->ion_auth->in_group(array('Receptionist', 'Assistant', 'admin', 'adminmedecin'))) {
			redirect('home/permission');
		}

		if (!$this->ion_auth->logged_in()) {
			redirect('auth/login', 'refresh');
		} else {

			$listeFactures = array();
			$listeFactures = $this->finance_model->getFacturePartenaires($this->id_organisation);
			$info = array();

			foreach ($listeFactures as $listeFacture) {
				$status = "";
				$status2 = "";
				$options2 = '';
				if ($listeFacture->statut == 'En cours') {
					$status = '<span class="status-p bg-danger" style="text-transform:uppercase;">En attente du paiement</span>';
					$options2 = '<a class="btn green btn-xs_ invoicebutton payment" title="' . lang('invoice_f') . '" style="color: #fff;" href="partenaire/genereFactures2?id=' . $listeFacture->codefacture . '"><i class="fa fa-plus-circle"></i> ' . lang('invoice_f') . '</a>';
				} else if ($listeFacture->statut == 'Payer') {
					$status = '<span class="status-p bg-success" style="text-transform:uppercase;">Payé</span>';
					$options2 = '<a class="btn green btn-xs_ invoicebutton payment" title="' . lang('invoice_f') . '" style="color: #fff;" href="partenaire/genereFactures2?id=' . $listeFacture->codefacture . '&payer=oui"><i class="fa fa-eye"></i></a>';
				}
				if ($listeFacture->transfer == 'yes') {
					$status2 = '<span class="status-p bg-primary" style="text-transform:uppercase;">Envoyé</span>';
					$options2 = '<a class="btn green btn-xs_ invoicebutton payment" title="' . lang('invoice_f') . '" style="color: #fff;" href="partenaire/genereFactures2?id=' . $listeFacture->codefacture . '&payer=oui"><i class="fa fa-eye"></i></a>';
				}



				$info[] = array(
					$listeFacture->idpro,
					$listeFacture->statut,
					date('d/m/Y H:i', $listeFacture->date),
					$listeFacture->codefacture,
					$listeFacture->destinataire,
					$listeFacture->nom,
					number_format($listeFacture->amount, 0, ",", ".") . ' ' . $this->settings_model->getSettings()->currency,
					$status . ' ' . $status2,
					$options2
				);
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



	public function facturesCodeGenerer()
	{

		if (!$this->ion_auth->in_group(array('Receptionist', 'Assistant', 'admin', 'adminmedecin'))) {
			redirect('home/permission');
		}

		if (!$this->ion_auth->logged_in()) {
			redirect('auth/login', 'refresh');
		} else {
			$canal_paiement = $this->input->post('canal_paiement');  //var_dump($payment);
			$code_facture = $this->input->post('code_facture');
			$id = $this->input->post('id_facture');
			$statut = $this->input->post('statut');
			$user = $this->ion_auth->get_user_id();
			$date = time();
			$listeFactures = array();
			$listeFactures = $this->finance_model->getFacturePartenaires($this->id_organisation);
			$info = array();
			$status = "";
			foreach ($listeFactures as $listeFacture) {
				$options2 = '';
				if ($listeFacture->statut == 'En cours') {
					$status = '<span class="status-p bg-danger" style="text-transform:uppercase;">En attente du paiement</span>';
					$options2 = '<a class="btn green btn-xs_ invoicebutton payment" title="' . lang('invoice_f') . '" style="color: #fff;" href="partenaire/genereFactures2?id=' . $listeFacture->codefacture . '"><i class="fa fa-plus-circle"></i> ' . lang('invoice_f') . '</a>';
				}
				if ($listeFacture->statut == 'Payer') {
					$status = '<span class="status-p bg-success" style="text-transform:uppercase;">Payé</span>';
					$options2 = '<a class="btn green btn-xs_ invoicebutton payment" title="' . lang('invoice_f') . '" style="color: #fff;" href="partenaire/genereFactures2?id=' . $listeFacture->codefacture . '&payer=oui"><i class="fa fa-eye"></i></a>';
				}



				$info[] = array(
					$listeFacture->statut,
					date('d/m/Y H:i', $listeFacture->date),
					$listeFacture->codefacture,
					$listeFacture->destinataire,
					$listeFacture->nom,
					number_format($listeFacture->amount, 0, ",", ".") . ' ' . $this->settings_model->getSettings()->currency,
					$status,
					$options2
				);
			}
		}


		$data['listeCommandes'] = $info;
		$data['settings'] = $this->settings_model->getSettings();
		$data['id_organisation'] = $this->id_organisation;
		$data['path_logo'] = $this->path_logo;
		$data['nom_organisation'] = $this->nom_organisation;
		$data['code_facture'] = $code_facture;
		$count_payment = $this->db->get_where('payment_pro', array('id_organisation =' => $this->id_organisation))->num_rows() + 1;
		$filename = "EM221040PAIE" . $this->id_organisation . "" . str_pad($count_payment, 4, "0", STR_PAD_LEFT);

		//$this->finance_model->updatePaymentPro($id, array('users_valided' => $user, 'statut' => $statut, 'date_paiement' => $date));
		//$this->session->set_flashdata('feedback', 'Paiement Effectué avec succés');

		$this->load->view('home/dashboard', $data);
		$this->load->view('facture_code', $data);
		$this->load->view('home/footer');
	}



	public function facturesbackup()
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
					$status_paid = '';
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
								$status_paid = "noypaid";
							}
							if ($payment->id_organisation && $this->id_organisation == $payment->id_organisation) {
								$status = '<span class="status-p bg-danger" style="text-transform:uppercase;">En attente du paiement</span>';
								$status_paid = "enattente";
							}
						} else if ($payment->status_paid_pro == "pending") {
							$status = '<span class="status-p bg-danger" style="text-transform:uppercase;">A Payer</span>';
							//$status = '<span class="status-p bg-danger" style="text-transform:uppercase;">En attente du paiement</span>';
							// $status = '<span class="status-p" style="background-color:#0A3B76;text-transform:uppercase;font-size:95%;">En attente de validation <i class="fa fa-hourglass-half"></i></span>';
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


						// if ($payment->status_paid_pro == "unpaid") {
						// 	$status_paid = "noypaid";
						// } else
						if ($payment->status_paid_pro == "paid") {
							$status_paid = "zpae";
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
								//$status = '<span class="status-p bg-danger" style="text-transform:uppercase;">En attente du paiement</span>';
								$status = '<span class="status-p bg-danger" style="text-transform:uppercase;">A Payer</span>';
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
						if ($payment->id_organisation === $this->id_organisation) {
							$options3 = $payment->gross_total;
							$options3 = intval($options3);
							$status_paid = "recette";
							$status = '<span class="status-p bg-success" style="text-transform:uppercase;">Recette</span>';
							$montant = '<span style="color: #279B38;font-weight: bold;">' . number_format($options3, 0, ",", ".") . ' ' . $this->settings_model->getSettings()->currency . '</span>';
						} else {
							$options3 = '-' . $payment->gross_total;
							$options3 = intval($options3);
							$status_paid = "depense";
							$status = '<span class="status-p bg-danger" style="text-transform:uppercase;">Dépense</span>';
							$montant = '<span style="color: rgba(255, 0, 0, 1.00);font-weight: bold;">' . number_format($options3, 0, ",", ".") . ' ' . $this->settings_model->getSettings()->currency . '</span>';
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
		$category = $this->input->post('category');
		$idPartenaire = $this->id_organisation;
		if (!empty($id)) {
			$idPartenaire = $id;
			$redirect = 'home/organisationsnolight?id=' . $id;
		}
		$data = array(
			'id_organisation_destinataire' => $idpartenaire,
			'id_organisation_origin' => $idPartenaire,
			'partenariat_actif' => 1,
			'category' => $category
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
		$payer = $this->input->get('payer');
		$data['code_paiement'] = $this->input->get('payer');
		$data['settings'] = $this->settings_model->getSettings();
		$data['id_organisation'] = $this->id_organisation;
		$data['path_logo'] = $this->path_logo;
		$data['nom_organisation'] = $this->nom_organisation;
		$partenaire = $this->finance_model->getPartenaireFacture($id);
		$destinataire = $partenaire->id_organisation_destinataire;
		$destinataire = $partenaire->id_organisation_destinataire;
		$data['amount'] = number_format($partenaire->amount, 0, ",", ".") . ' ' . $this->settings_model->getSettings()->currency;
		$data['id_facture'] = $partenaire->idpro;
		$is_light = $this->home_model->getOrganisationById($destinataire);
		$is_light = $is_light->is_light;

		if ($destinataire == $this->id_organisation && $is_light == "0") {
			$data['is_partenaire'] = "false";
		} else {
			$data['is_partenaire'] = "true";
		}

		if ($is_light) {
			$data['email_light'] = $is_light->email;
		}

		if ($payer == 'oui') {
			$data['payer_par'] = $this->home_model->getUserById($partenaire->users_valided);
			$data['payer_par'] = $data['payer_par']->username;
			$data['date_paiement'] = date('d/m/Y H:i', $partenaire->date_paiement);
		}



		if (isset($id)) {
			$data['code_facture'] = $id;
			$this->load->view('home/dashboard', $data); // just the header file
			$this->load->view('genererFacturerPayer', $data);
			$this->load->view('home/footer'); // just the header file
		} else {
			$this->session->set_flashdata('feedback', lang('error'));

			//  redirect('partenaire');
		}
	}

	function paiementFacture()
	{
		$code_facture = $this->input->post('code_facture');
		$id = $this->input->post('id_facture');
		$canal_paiement = $this->input->post('canal_paiement');
		$statut = $this->input->post('statut');
		$reference_paiement = $this->input->post('reference');
		$user = $this->ion_auth->get_user_id();
		$date = time();
		$infosFacture = $this->finance_model->getFacturePro($code_facture);
		$date_debut = date("d/m/Y", $infosFacture->dateDebut);
		$date_fin = date("d/m/Y", $infosFacture->dateFin);
		$id_organisation_origine = $this->id_organisation;
		$organisation_origine = $this->home_model->getOrganisationByid($id_organisation_origine);
		$organisation_partenaire = $this->home_model->getOrganisationByid($infosFacture->id_organisation_destinataire);
		$type_organisation = $organisation_partenaire->type;
		$user = $this->home_model->getUserById($this->ion_auth->get_user_id());
		$data['id_partenaire'] = $infosFacture->id_organisation_destinataire;
		$img_file_organisationLogo = $this->entete;
		$imgData_organisationLogo = base64_encode(file_get_contents($img_file_organisationLogo));
		$data["organisationLogo"] = 'image:base64:' . $imgData_organisationLogo;
		$dateNow =  date('Y-m-d');
		$dateNow = str_replace('-', '', $dateNow);
		$data["isPaid"] = "true";
		$data["paidStamp"] = "image:base64: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";
		$data["invoiceNo"] = $code_facture;
		$data["invoiceDate"] = date('d/m/Y');
		$data["periodeFacturationDu"] = $date_debut;
		$data["periodeFacturationAu"] = $date_fin;
		$data["paymentDate"] = date('d/m/Y');
		$data["paymentMethod"] = $canal_paiement;
		$data["paymentRef"] = $reference_paiement;
		$data["updatedBy"] = $user->first_name . ' ' . $user->last_name;
		$data["organizationName"] = $organisation_origine->nom;
		$data["organisationAddress"] = $organisation_origine->adresse;
		$data["ONM"] = $reference_paiement;
		$data["partnerOrganizationName"] = $organisation_partenaire->nom;
		$data["customerContact"] = $organisation_partenaire->prenom_responsable_legal . ' ' . $organisation_partenaire->nom_responsable_legal;
		$data["partnerOrganizationAddress"] = $organisation_partenaire->adresse;
		$data["customerAddr2"] = "";
		$data["partnerOrganizationCity"] = $organisation_partenaire->region;
		$data["customerZIP"] = "BP 50225 Dakar RP, (Code Postal 18 524)";
		$listBeneficiaires = $this->finance_model->getListeFacturesGroupByPayCode($code_facture);

		//$listBeneficiaires = $this->finance_model->getListeFacturesGroupByPay($this->id_organisation, $infosFacture->id_organisation_destinataire, $infosFacture->dateDebut, $infosFacture->dateFin);
		foreach ($listBeneficiaires as $benefificaire) {
			$benefificaire->transactionList = $this->finance_model->getListeFacturesDisponibleByPayCode($code_facture);
		}
		$data["listBeneficiaires"] = $listBeneficiaires;

		$dataPayment = array('users_valided' => $user->id, 'statut' => $statut, 'date_paiement' => $date,  'canal_paiement' => $canal_paiement, 'reference' => $reference_paiement);

		header('Content-Type: application/json;charset=utf-8');
		$data = json_encode($data, JSON_UNESCAPED_UNICODE);
		// var_dump($data);
		// exit();
		$accessKey = 'ODBiYzNkNzItYWE2Ni00ZGIzLWE0YzgtY2MzYjYzODkwZmRjOjA4MjQ5MjQ';
		$DWSRenderURL = 'https://eu.dws3.docmosis.com/api/render';
		$templateName =  'ecoMed24.dev/ecomed_businessInvoiceTemplate V0.5.docx';
		$outputName = $code_facture . '.pdf';
		$request = array(
			"accessKey" => $accessKey,
			"templateName" => "$templateName",
			"outputName" => "$outputName",
			"data" => "$data",
			"devMode" => "yes"
		);

		$requestHeaders = array('Content-Type' => 'multipart/form-data');

		$ch = curl_init($DWSRenderURL);

		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $requestHeaders);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		// curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

		$responseData = curl_exec($ch);

		if ($responseData != false) {

			$headers = curl_getinfo($ch);
			curl_close($ch);

			if ($headers['http_code'] == '200') {

				$tempDirName = "uploads/invoicefile/";
				$tempFileName = realpath($tempDirName) . "/" . $outputName;

				$renderedFile = file_put_contents($tempFileName, $responseData);
				$this->session->set_flashdata('feedback', 'Paiement effectué avec succés');
				$this->finance_model->updatePaymentPro($id, $dataPayment);
			} else {
				// failed - check error and result message
				//      echo "Failed:" . $responseData . "\n";
			}
		} else {

			//   echo "curlexec failed.\n\nDocmosis Cloud must be used via HTTPS.\n\nCheck your CA certificates, or try un-commenting CURLOPT_SSL_VERIFYPEER line (for troubleshooting only)";
		}
		redirect('partenaire/factures');
	}


	function genererDocumentFactureCode()
	{
		header('Content-Type: text/html; charset=utf-8');
		$data['settings'] = $this->settings_model->getSettings();
		$data['id_organisation'] = $this->id_organisation;
		$data['path_logo'] = $this->path_logo;
		$data['nom_organisation'] = $this->nom_organisation;
		$data = json_decode($_POST['test'], JSON_UNESCAPED_UNICODE);
		$count_payment = $this->db->get_where('payment_pro', array('id_organisation =' => $this->id_organisation))->num_rows() + 1;
		$idpayment = "EM221040PAIE" . $this->id_organisation . "" . str_pad($count_payment, 4, "0", STR_PAD_LEFT);

		//   echo json_encode($$data->test, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);

		$accessKey = 'ODBiYzNkNzItYWE2Ni00ZGIzLWE0YzgtY2MzYjYzODkwZmRjOjA4MjQ5MjQ';
		$DWSRenderURL = 'https://eu.dws3.docmosis.com/api/render';
		$templateName =  'ecoMed24.dev/ecomed_businessInvoiceTemplate V0.5.docx';
		$outputName = $idpayment . '.pdf';


		$request = array(
			"accessKey" => $accessKey,
			"templateName" => "$templateName",
			"outputName" => "$outputName",
			"data" => "$data",
			"devMode" => "yes"
		);


		$requestHeaders = array('Content-Type' => 'multipart/form-data');

		$ch = curl_init($DWSRenderURL);

		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $requestHeaders);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		// curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

		$responseData = curl_exec($ch);

		if ($responseData != false) {

			$headers = curl_getinfo($ch);
			curl_close($ch);

			if ($headers['http_code'] == '200') {

				$tempDirName = "uploads/invoicefile/";
				$tempFileName = realpath($tempDirName) . "/" . $outputName;

				$renderedFile = file_put_contents($tempFileName, $responseData);
				echo json_encode($outputName, JSON_UNESCAPED_UNICODE);
				//  echo "File saved to $tempFileName\n";
				//  $ressource = fopen('C:/Users/limou/Documents/ecomed24/WelcomeOuput.docx', 'rb');
				//     echo fread($ressource, filesize('WelcomeOuput.docx'));


			} else {
				// failed - check error and result message
				echo "Failed:" . $responseData . "\n";
			}
		} else {

			echo "curlexec failed.\n\nDocmosis Cloud must be used via HTTPS.\n\nCheck your CA certificates, or try un-commenting CURLOPT_SSL_VERIFYPEER line (for troubleshooting only)";
		}
		redirect('partenaire/factures');
	}

	function genereFactures2backup()
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

		if (!$this->ion_auth->in_group(array('Receptionist', 'admin', 'Assistant', 'adminmedecin'))) {
			redirect('home/permission');
		}

		if (!$this->ion_auth->logged_in()) {
			redirect('auth/login', 'refresh');
		} else {
			$listeFactureDisponible = array();
			$listeFactureDisponible = $this->finance_model->getListeFacturesDisponible($this->id_organisation);
			$info = array();
			foreach ($listeFactureDisponible as $value) {
				if (isset($value)) {
					$info[] = array(
						$value->id,
						date('d/m/Y H:i', $value->date),
						$value->id,
						$value->prestation,
						$value->nom,
						$value->name . " " . $value->last_name,
						number_format($value->amount, 0, ",", ".") . ' ' . $this->settings_model->getSettings()->currency
					);
				}
			}


			$data['listeCommandes'] = $info;


			$data['settings'] = $this->settings_model->getSettings();

			$data['id_organisation'] = $this->id_organisation;
			$data['path_logo'] = $this->path_logo;
			$data['nom_organisation'] = $this->nom_organisation;
			//	var_dump($info);
			$this->load->view('home/dashboard', $data);
			$this->load->view('liste_facture_prestation', $data);
			$this->load->view('home/footer');
		}
	}



	public function listeFacturePrestationbackup31012023()
	{

		if (!$this->ion_auth->in_group(array('Receptionist', 'admin', 'Assistant', 'adminmedecin'))) {
			redirect('home/permission');
		}

		if (!$this->ion_auth->logged_in()) {
			redirect('auth/login', 'refresh');
		} else {

			$idOrganisation = $this->input->post('idOrganisation');
			if ($idOrganisation) {
				$this->validFaurePartenaire();
			}

			$origins = $this->partenaire_model->payListeFactureByaLL($this->id_organisation, 1, false, false, 'accept');
			$originsLight = $this->partenaire_model->payListeFactureByaLL($this->id_organisation, false, 1, false, 'accept');
			$originsAssurance = $this->partenaire_model->payListeFactureByaLL($this->id_organisation, false, false, 1, 'accept');
			$info = array();
			$origins = array_merge($origins, $originsLight, $originsAssurance);
			// $payments = $this->finance_model->getStatusPaymentByTraitance(1,'finish' ,$this->id_organisation);
			foreach ($origins as $payment) {
				if ($payment->etat_assurance == 1) {
					isset($payment->id_organisation) ? $cree_par = $this->partenaire_model->getPartenairesById($payment->id_organisation)->nom : $cree_par = '';
					$date = date('d/m/Y H:i', $payment->date);
					if ($payment->etat_assurance == 1) {
						$dataTab = explode(',', $payment->category_name_assurance);
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
									$this->partenaire_model->getPartenairesById($payment->organisation_assurance)->nom,
									$payment->patient,
									number_format($tarif_professionnel, 0, ",", ".") . ' ' . $this->settings_model->getSettings()->currency
								);
							}
						}
					}
				} else if ($payment->etat == 1) {
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

				$html .= '			<link href="' . $baseURLF . 'common/css/bootstrap.min.css" rel="stylesheet">';
				$html .= '			<link href="' . $baseURLF . 'common/css/bootstrap-reset.css" rel="stylesheet">';
				$html .= '			<!--external css-->';
				$html .= '			<link href="' . $baseURLF . 'common/assets/fontawesome5pro/css/all.min.css" rel="stylesheet" />';
				$html .= '			<link href="' . $baseURLF . 'common/assets/DataTables/datatables.css" rel="stylesheet" />';
				$html .= '			<link href="' . $baseURLF . 'common/css/style.css" rel="stylesheet">';
				$html .= '			<link href="' . $baseURLF . 'common/css/style-responsive.css" rel="stylesheet" />';
				$html .= '			<link href="' . $baseURLF . 'common/css/invoice-print.css" rel="stylesheet" media="print">';
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
						$cree_par = $this->partenaire_model->getPartenairesById($payment->id_organisation)->nom;
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
			redirect('partenaire/listeFacturePrestation');
			// $this->load->view('home/dashboard', $data2);
			// $this->load->view('liste_facture_prestation', $data2);
			// $this->load->view('home/footer');
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
		$id = $this->input->post('partenaire');
		$date1 = $this->input->post('date1');
		$date2 = $this->input->post('date2');

		$info = '';
		$info0 = '';
		$ttotal = 0;
		if ($date1) {
			$date1 = str_replace('/', '-', $date1 . ' 00:00');
			$date1 = date('Y-m-d H:i', strtotime($date1));
		} else {
			$date1 =  '2020-01-01 23:59';
		}
		if ($date2) {
			$date2 = str_replace('/', '-', $date2 . ' 23:59');
			$date2 = date('Y-m-d H:i', strtotime($date2));
		} else {
			$date2 =  date('Y-m-d 23:59');
		}
		//var_dump($date1.'-------'.$date2);

		$listeFactureDisponible = array();
		$listeFactureDisponible = $this->finance_model->getListeFacturesDisponibleByPartenaire($this->id_organisation, $id);
		$info = array();

		foreach ($listeFactureDisponible as $value) {

			if ($date1 <= date('Y-m-d H:i', $value->date) && date('Y-m-d H:i', $value->date) <= $date2) {
				$info[] = array(
					$value->id,
					date('d/m/Y H:i', $value->date),
					$value->id,
					$value->prestation,
					$value->nom,
					$value->name . " " . $value->last_name,
					number_format($value->amount, 0, ",", ".") . ' ' . $this->settings_model->getSettings()->currency
				);
			}
		}

		$data['listeCommandes'] = $info;


		$data['settings'] = $this->settings_model->getSettings();

		$data['id_organisation'] = $this->id_organisation;
		$data['path_logo'] = $this->path_logo;
		$data['nom_organisation'] = $this->nom_organisation;
		$data['date_debut'] = $date1;
		$data['date_fin'] = $date2;
		$data['id_partenaire'] = $id;
		$organisation_partenaire = $this->home_model->getOrganisationByid($id);
		$data['nom_partenaire'] = $organisation_partenaire->nom;

		$this->load->view('home/dashboard', $data);
		$this->load->view('liste_facture_prestation_partenaire', $data);
		$this->load->view('home/footer');
	}


	function factureValid()
	{
		$id = $this->input->post('partenaire');
		$date1 = $this->input->post('date_debut');
		$date2 = $this->input->post('date_fin');
		$id_organisation = $this->id_organisation;
		$code_facture = $this->input->post('code_facture');
		$info = '';
		$info0 = '';
		$ttotal = 0;


		$listeFactureDisponible = array();
		$listeFactureDisponible = $this->finance_model->getListeFacturesDisponibleByPartenaire($this->id_organisation, $id);
		foreach ($listeFactureDisponible as $value) {
			if ($date1 <= date('Y-m-d H:i', $value->date) && date('Y-m-d H:i', $value->date) <= $date2) {
				$this->finance_model->updateTransactions($value->id, array('code_facture' => $code_facture, 'Facturer' => '2'));
				$ttotal = intval($ttotal) + intval($value->amount);
			}
		}
		$date = time();

		$date_from = strtotime($date1);
		$date_to = strtotime($date2);

		$dataPaymentPro = array(
			'id_organisation' => $this->id_organisation,
			'id_organisation_destinataire' => $id,
			'codefacture' => $code_facture,
			'date' => $date,
			'dateDebut' => $date_from,
			'dateFin' => $date_to,
			'amount' => $ttotal,
			'user' => $this->ion_auth->get_user_id(),
			'statut' => 'En cours'
		);



		$this->finance_model->insertPaymentPro($dataPaymentPro);
		redirect('partenaire/factures');
	}

	function genererFacturePartenaire()
	{
		$id = $this->input->post('id_partenaire');
		$date1 = $this->input->post('date_debut');
		$date2 = $this->input->post('date_fin');


		$data['settings'] = $this->settings_model->getSettings();

		$data['id_organisation'] = $this->id_organisation;
		$data['path_logo'] = $this->path_logo;
		$data['nom_organisation'] = $this->nom_organisation;
		$data['date_debut'] = $date1;
		$data['date_fin'] = $date2;
		$data['id_partenaire'] = $id;
		$organisation_partenaire = $this->home_model->getOrganisationByid($id);
		$data['nom_partenaire'] = $organisation_partenaire->nom;
		$dateNow =  date('Y-m-d');
		$dateNow = str_replace('-', '', $dateNow);
		$count_payment = $this->db->get_where('payment_pro', array('id_organisation =' => $this->id_organisation))->num_rows() + 1;
		$filename = "EM221040" . $this->id_organisation . "" . str_pad($count_payment, 4, "0", STR_PAD_LEFT);
		$data["invoiceNo"] = "uploads/invoicefile/" . $filename . ".pdf";
		$data["filename"] = $filename;
		$is_light = $this->home_model->getOrganisationById($id);
		$est_light = $is_light->is_light;
		$type = $is_light->type;
		$data['email_light'] = $is_light->email;
		if ($est_light == '1' || $type == 'Assurance' || $type == 'IPM') {
			$data['is_light'] = "yes";
		}

		$this->load->view('home/dashboard', $data);
		$this->load->view('genererFacture', $data);
		$this->load->view('home/footer');
	}

	function genererFacturePartenaireDocumente()
	{

		$id_partenaire = $this->input->get('id');
		$date_debut = $this->input->get('date_debut');
		$date_fin = $this->input->get('date_fin');
		$id_organisation_origine = $this->id_organisation;
		$date1 = str_replace('-', '/', $date_debut);
		$date1 = date('d/m/Y', strtotime($date1));
		$date2 = str_replace('-', '/', $date_fin);
		$date2 = date('d/m/Y', strtotime($date2));
		$date_from = strtotime($date_debut);
		$date_to = strtotime($date_fin);
		$organisation_origine = $this->home_model->getOrganisationByid($id_organisation_origine);
		$organisation_partenaire = $this->home_model->getOrganisationByid($id_partenaire);
		$type_organisation = $organisation_partenaire->type;
		$user = $this->home_model->getUserById($this->ion_auth->get_user_id());
		$data['id_partenaire'] = $id_partenaire;
		$img_file_organisationLogo = $this->entete;
		$imgData_organisationLogo = base64_encode(file_get_contents($img_file_organisationLogo));
		$data["organisationLogo"] = 'image:base64:' . $imgData_organisationLogo;
		$dateNow =  date('Y-m-d');
		$dateNow = str_replace('-', '', $dateNow);
		$count_payment = $this->db->get_where('payment_pro', array('id_organisation =' => $this->id_organisation))->num_rows() + 1;
		$data["invoiceNo"] = "EM221040" . $this->id_organisation . "" . str_pad($count_payment, 4, "0", STR_PAD_LEFT);
		$data["invoiceDate"] = date('d/m/Y');
		$data["periodeFacturationDu"] = $date1;
		$data["periodeFacturationAu"] = $date2;
		$data["updatedBy"] = $user->first_name . ' ' . $user->last_name;
		$data["organizationName"] = $organisation_origine->nom;
		$data["organisationAddress"] = $organisation_origine->adresse;
		$data["partnerOrganizationName"] = $organisation_partenaire->nom;
		$data["customerContact"] = $organisation_partenaire->prenom_responsable_legal . ' ' . $organisation_partenaire->nom_responsable_legal;
		$data["partnerOrganizationAddress"] = $organisation_partenaire->adresse;
		$data["customerAddr2"] = "";
		$data["partnerOrganizationCity"] = $organisation_partenaire->region;
		$data["customerZIP"] = "BP 50225 Dakar RP, (Code Postal 18 524)";
		$listeFactureDisponible = $this->finance_model->getListeFacturesDisponibleByPartenaire($this->id_organisation, $id_partenaire);
		$listBeneficiaires = $this->finance_model->getListeFacturesGroupByPatient($this->id_organisation, $id_partenaire, $date_from, $date_to);
		foreach ($listBeneficiaires as $benefificaire) {
			$benefificaire->transactionList = $this->finance_model->getListeFacturesDisponibleByPatient($this->id_organisation, $id_partenaire, $benefificaire->id_patient, $date_from, $date_to);
		}
		$data["listBeneficiaires"] = $listBeneficiaires;



		header('Content-Type: application/json;charset=utf-8');
		echo json_encode($data, JSON_UNESCAPED_UNICODE);
	}




	function genererFacturePartenairePayer()
	{

		$id_partenaire = $this->input->post('id');
		$date_debut = $this->input->post('date_debut');
		$date_fin = $this->input->post('date_fin');
		$id_organisation_origine = $this->id_organisation;


		$date1 = str_replace('-', '/', $date_debut);
		$date1 = date('d/m/Y', strtotime($date1));
		$date2 = str_replace('-', '/', $date_fin);
		$date2 = date('d/m/Y', strtotime($date2));
		$date_from = strtotime($date_debut);
		$date_to = strtotime($date_fin);
		$organisation_origine = $this->home_model->getOrganisationByid($id_organisation_origine);
		$organisation_partenaire = $this->home_model->getOrganisationByid($id_partenaire);
		$type_organisation = $organisation_partenaire->type;
		$user = $this->home_model->getUserById($this->ion_auth->get_user_id());
		$data['id_partenaire'] = $id_partenaire;
		$img_file_organisationLogo = $this->entete;
		$imgData_organisationLogo = base64_encode(file_get_contents($img_file_organisationLogo));
		$data["organisationLogo"] = 'image:base64:' . $imgData_organisationLogo;
		$dateNow =  date('Y-m-d');
		$dateNow = str_replace('-', '', $dateNow);
		$count_payment = $this->db->get_where('payment_pro', array('id_organisation =' => $this->id_organisation))->num_rows() + 1;
		$data["invoiceNo"] = "EM221040" . $this->id_organisation . "" . str_pad($count_payment, 4, "0", STR_PAD_LEFT);
		$data["invoiceDate"] = date('d/m/Y');
		$data["periodeFacturationDu"] = $date1;
		$data["periodeFacturationAu"] = $date2;
		$data["paymentDate"] = "31/01/2023";
		$data["paymentMethod"] = "WAVE";
		$data["paymentRef"] = "WA98888";
		$data["updatedBy"] = $user->first_name . ' ' . $user->last_name;
		$data["organizationName"] = $organisation_origine->nom;
		$data["organisationAddress"] = $organisation_origine->adresse;
		$data["ONM"] = "509-B/98";
		$data["partnerOrganizationName"] = $organisation_partenaire->nom;
		$data["customerContact"] = $organisation_partenaire->prenom_responsable_legal . ' ' . $organisation_partenaire->nom_responsable_legal;
		$data["partnerOrganizationAddress"] = $organisation_partenaire->adresse;
		$data["customerAddr2"] = "";
		$data["partnerOrganizationCity"] = $organisation_partenaire->region;
		$data["customerZIP"] = "BP 50225 Dakar RP, (Code Postal 18 524)";
		$listeFactureDisponible = $this->finance_model->getListeFacturesDisponibleByPartenaire($this->id_organisation, $id_partenaire);
		$listBeneficiaires = $this->finance_model->getListeFacturesGroupByPatient($this->id_organisation, $id_partenaire, $date_from, $date_to);
		foreach ($listBeneficiaires as $benefificaire) {
			$benefificaire->transactionList = $this->finance_model->getListeFacturesDisponibleByPatient($this->id_organisation, $id_partenaire, $benefificaire->id_patient, $date_from, $date_to);
		}
		$data["listBeneficiaires"] = $listBeneficiaires;



		header('Content-Type: application/json;charset=utf-8');
		echo json_encode($data, JSON_UNESCAPED_UNICODE);
	}



	function transferFacture()
	{
		$codeFacture = $this->input->post('code_facture');
		$partenaire = $this->input->post('partenaire');
		$periode_facture = $this->input->post('periode');
		$id_payment = $this->input->post('id_payment');
		$email_light = $this->input->post('email');
		$prestation = $this->input->post('prestation');
		$date1 = $this->input->post('date_debut');
		$date2 = $this->input->post('date_fin');
		$date_from = strtotime($date1);
		$date_to = strtotime($date2);
		$listeFactureDisponible = array();
		$ttotal = '';
		$listeFactureDisponible = $this->finance_model->getListeFacturesDisponibleByPartenaire($this->id_organisation, $partenaire);
		foreach ($listeFactureDisponible as $value) {
			if ($date1 <= date('Y-m-d H:i', $value->date) && date('Y-m-d H:i', $value->date) <= $date2) {
				$this->finance_model->updateTransactions($value->id, array('code_facture' => $codeFacture, 'Facturer' => '2'));
				$ttotal = intval($ttotal) + intval($value->amount);
			}
		}
		$this->finance_model->updateTransactionFacturer($id_payment, array('Facturer' => 1, 'status' => "ENVOYÉ"));

		$dataPaymentPro = array(
			'id_organisation' => $this->id_organisation,
			'id_organisation_destinataire' => $partenaire,
			'codefacture' => $codeFacture,
			'date' => time(),
			'dateDebut' => $date_from,
			'dateFin' => $date_to,
			'amount' => $ttotal,
			'user' => $this->ion_auth->get_user_id(),
			'statut' => 'En cours'
		);



		$this->finance_model->insertPaymentPro($dataPaymentPro);
		$filename = $codeFacture . ".pdf";
		// $mpdf->Output();
		$attachment_path = FCPATH . "uploads/invoicefile/$filename";
		$medium = $this->input->post('medium');

		if ($medium == 'email') {

			$patientemail = $this->input->post('email');

			$id_organisation = $this->id_organisation;
			$nom_organisation_light_origin = $this->home_model->getOrganisationByid($id_organisation);
			$nom_organisation_light_origin = $nom_organisation_light_origin->nom;

			$nom_organisation_prestataire = $this->home_model->getOrganisationByid($partenaire);
			$nom_organisation_prestataire = $nom_organisation_prestataire->nom;
			$email = $this->db->get_where('organisation', array('id' => $id_organisation))->row()->email;

			// IMPORT 
			$data1Email = array(
				'nom_organisation_prestataire' => $nom_organisation_light_origin,
				'nro_facture' => $codeFacture,
				'periode_facture' => $periode_facture,
				'nom_organisation_light_origin' => $nom_organisation_prestataire
			);


			$autoemail = $this->email_model->getAutoEmailByType('facture_light');

			$message1 = $autoemail->message;
			$subject = $this->parser->parse_string($autoemail->name, $data1Email, true);
			$messageprint2 = $this->parser->parse_string($message1, $data1Email, true);
			$dataInsertEmail = array(
				'reciepient' => $email_light,
				'subject' => $subject,
				'message' => $messageprint2,
				'date' => time(),
				'user' => $this->ion_auth->get_user_id(),
				'attachment_path' => $attachment_path,
			);
			$this->email_model->insertEmail($dataInsertEmail);

			// FIN IMPORT
			$subject = lang('lab_report');
			$this->load->library('encryption');
			$this->email->from($email);
			$this->email->to($patientemail);
			$this->email->subject($subject);
			$this->email->message('<br>Please Find your Lab Report');
			$this->email->attach('uploads/invoicefile/' . $filename);
			if ($autoemail->status == 'Active') {
				//unlink('uploads/invoicefile/' . $filename);
				$this->session->set_flashdata('feedback', lang('lab_status'));
				redirect("partenaire/factures");
			} else {
				unlink(APPPATH . '../invoicefile/' . $filename);
				$this->session->set_flashdata('feedback', lang('not') . ' ' . 'able to deliver Lab Report');
				redirect("partenaire/factures");
			}
		} else {
			$whatsapp_message = $this->db->get_where('autowhatsapptemplate', array('type' => 'Whatsapp_lab'))->row();
			if ($whatsapp_message->status == 'Active') {
				$message = $whatsapp_message->message;
				$organisation_details = $this->db->get_where('organisation', array('id' => $this->id_organisation))->row();
				$data1 = array(
					// 'name' => $patient->name . ' ' . $patient->last_name,
					// 'lastname' => $patient->last_name,
					// 'firstname' => $patient->name,
					// 'sample_date' => $data['report_details']->sampling_date,
					'numero_telephone' => $organisation_details->numero_fixe,
					'company' => $organisation_details->nom_commercial
				);
				$messageprint = $this->parser->parse_string($message, $data1);
			} else {
				$messageprint = 'Lab Report';
			}
			$to = $this->input->post('whatsapp');
			$whatsapp_cre = $this->db->get_where('whatsapp_settings', array('id' => 1))->row();
			$url =  'https://api.chat-api.com/instance' . $whatsapp_cre->instance_id . '/sendFile?token=' . $whatsapp_cre->token;
			$url1 =  'https://api.chat-api.com/instance' . $whatsapp_cre->instance_id . '/message?token=' . $whatsapp_cre->token;
			$imageLocation = base_url() . 'uploads/invoicefile/' . $filename;
			$data1 = [
				'phone' => $to,
				'body' => $messageprint,

			];
			$send1 = json_encode($data1);
			$options1 = stream_context_create([
				'http' => [
					'method' => 'POST',
					'header' => 'Content-type: application/json',
					'content' => $send1,
				]
			]);
			$result1 = file_get_contents($url1, false, $options1);
			$result_array1 = json_decode($result1, true);

			$data = [
				'phone' => $to,
				'body' => $imageLocation,
				'filename' => $filename,
				'caption' => 'test',
			];
			$send = json_encode($data);

			$options = stream_context_create([
				'http' => [
					'method' => 'POST',
					'header' => 'Content-type: application/json',
					'content' => $send,
				]
			]);
			// Send a request

			$result = file_get_contents($url, false, $options);
			$result_array = json_decode($result, true);

			if ($result_array['sent'] && $result_array1['sent']) {
				unlink('uploads/invoicefile/' . $filename);
				$this->session->set_flashdata('feedback', 'Send Lab Report');
				redirect("partenaire/factures");
			} else {
				unlink(APPPATH . '../invoicefile/' . $filename);
				$this->session->set_flashdata('feedback', lang('not') . ' ' . 'able to deliver Lab Report');
				redirect("partenaire/factures");
			}
		}
	}



	function transferFacturePayer()
	{
		$codeFacture = $this->input->post('code_facture');
		$infosFacture = $this->finance_model->getFacturePro($codeFacture);

		$partenaire = $infosFacture->id_organisation_destinataire;
		$date_debut = date('d/m/Y', $infosFacture->dateDebut);
		$date_fin = date('d/m/Y', $infosFacture->dateFin);
		$periode_facture = $date_debut + ' au ' + $date_fin;
		$email_light = $this->input->post('email');

		$filename = $codeFacture . ".pdf";
		// $mpdf->Output();
		$attachment_path = FCPATH . "uploads/invoicefile/$filename";
		$medium = $this->input->post('medium');

		if ($medium == 'email') {

			$patientemail = $this->input->post('email');

			$id_organisation = $this->id_organisation;
			$nom_organisation_light_origin = $this->home_model->getOrganisationByid($id_organisation);
			$nom_organisation_light_origin = $nom_organisation_light_origin->nom;

			$nom_organisation_prestataire = $this->home_model->getOrganisationByid($partenaire);
			$nom_organisation_prestataire = $nom_organisation_prestataire->nom;
			$email = $this->db->get_where('organisation', array('id' => $id_organisation))->row()->email;

			// IMPORT 
			$data1Email = array(
				'nom_organisation_prestataire' => $nom_organisation_light_origin,
				'nro_facture' => $codeFacture,
				'periode_facture' => $periode_facture,
				'nom_organisation_light_origin' => $nom_organisation_prestataire,
			);


			$autoemail = $this->email_model->getAutoEmailByType('facture_light');

			$message1 = $autoemail->message;
			$subject = $this->parser->parse_string($autoemail->name, $data1Email, true);
			$messageprint2 = $this->parser->parse_string($message1, $data1Email, true);
			$dataInsertEmail = array(
				'reciepient' => $email_light,
				'subject' => $subject,
				'message' => $messageprint2,
				'date' => time(),
				'user' => $this->ion_auth->get_user_id(),
				'attachment_path' => $attachment_path,
			);
			$this->email_model->insertEmail($dataInsertEmail);

			// FIN IMPORT
			$subject = lang('lab_report');
			$this->load->library('encryption');
			$this->email->from($email);
			$this->email->to($patientemail);
			$this->email->subject($subject);
			$this->email->message('<br>Please Find your Lab Report');
			$this->email->attach('uploads/invoicefile/' . $filename);
			if ($autoemail->status == 'Active') {
				//unlink('uploads/invoicefile/' . $filename);
				$this->session->set_flashdata('feedback', lang('lab_status'));
				$data_transfer = array('transfer' => 'yes');
				$this->finance_model->updatePaymentTransfert($codeFacture, $data_transfer);
				redirect("partenaire/factures");
			} else {
				unlink(APPPATH . '../invoicefile/' . $filename);
				$this->session->set_flashdata('feedback', lang('not') . ' ' . 'able to deliver Lab Report');
				redirect("partenaire/factures");
			}
		} else {
			$whatsapp_message = $this->db->get_where('autowhatsapptemplate', array('type' => 'Whatsapp_lab'))->row();
			if ($whatsapp_message->status == 'Active') {
				$message = $whatsapp_message->message;
				$organisation_details = $this->db->get_where('organisation', array('id' => $this->id_organisation))->row();
				$data1 = array(
					// 'name' => $patient->name . ' ' . $patient->last_name,
					// 'lastname' => $patient->last_name,
					// 'firstname' => $patient->name,
					// 'sample_date' => $data['report_details']->sampling_date,
					'numero_telephone' => $organisation_details->numero_fixe,
					'company' => $organisation_details->nom_commercial
				);
				$messageprint = $this->parser->parse_string($message, $data1);
			} else {
				$messageprint = 'Lab Report';
			}
			$to = $this->input->post('whatsapp');
			$whatsapp_cre = $this->db->get_where('whatsapp_settings', array('id' => 1))->row();
			$url =  'https://api.chat-api.com/instance' . $whatsapp_cre->instance_id . '/sendFile?token=' . $whatsapp_cre->token;
			$url1 =  'https://api.chat-api.com/instance' . $whatsapp_cre->instance_id . '/message?token=' . $whatsapp_cre->token;
			$imageLocation = base_url() . 'uploads/invoicefile/' . $filename;
			$data1 = [
				'phone' => $to,
				'body' => $messageprint,

			];
			$send1 = json_encode($data1);
			$options1 = stream_context_create([
				'http' => [
					'method' => 'POST',
					'header' => 'Content-type: application/json',
					'content' => $send1,
				]
			]);
			$result1 = file_get_contents($url1, false, $options1);
			$result_array1 = json_decode($result1, true);

			$data = [
				'phone' => $to,
				'body' => $imageLocation,
				'filename' => $filename,
				'caption' => 'test',
			];
			$send = json_encode($data);

			$options = stream_context_create([
				'http' => [
					'method' => 'POST',
					'header' => 'Content-type: application/json',
					'content' => $send,
				]
			]);
			// Send a request

			$result = file_get_contents($url, false, $options);
			$result_array = json_decode($result, true);

			if ($result_array['sent'] && $result_array1['sent']) {
				unlink('uploads/invoicefile/' . $filename);
				$this->session->set_flashdata('feedback', 'Send Lab Report');
				$data_transfer = array('transfer' => 'yes');
				$this->lab_model->updateLabReport($codeFacture, $data_transfer);
				redirect("partenaire/factures");
			} else {
				unlink(APPPATH . '../invoicefile/' . $filename);
				$this->session->set_flashdata('feedback', lang('not') . ' ' . 'able to deliver Lab Report');
				redirect("partenaire/factures");
			}
		}
	}

	function listePrestationByPartenairebackup()
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

		$info = '';

		/* if (!empty($date2) && !empty($date1) && $date2 < $date1) {
            echo json_encode(array('result' => false, 'message' => lang('time_selection_error_partenaite')));
            die();
        }*/

		$origins = $this->partenaire_model->payListeFactureByaLL($this->id_organisation, 1, false, false, 'accept', false, $id, $date1, $date2);
		$originsLight = $this->partenaire_model->payListeFactureByaLL($this->id_organisation, false, 1, false, 'accept', false, $id, $date1, $date2);
		$originsAssurance = $this->partenaire_model->payListeFactureByaLL($this->id_organisation, false, false, 1, 'accept', false, $id, $date1, $date2);

		$origins = array_merge($origins, $originsLight, $originsAssurance);
		// var_dump("test");
		// 
		// var_dump($origins);
		// exit();
		$info = '';
		$info0 = '';
		$paymentorganisation_destinataire = '';
		$paymentid_organisation = '';
		$Organisationdestinatairs = array();
		$Organisationorigins = array();
		$ttotal = 0;
		foreach ($origins as $payment) {


			if ($payment->etat_assurance == 1) {
				$date = date('d/m/Y H:i', $payment->date);
				if ($payment->etat_assurance == 1 && ($date1 <= $payment->date && $payment->date <= $date2)) {
					isset($payment->id_organisation) ? $cree_par = $this->partenaire_model->getPartenairesById($payment->id_organisation)->nom : $cree_par = '';
					$date = date('d/m/Y H:i', $payment->date);
					if ($payment->etat_assurance == 1 && $payment->organisation_assurance == $id && ($date1 <= $payment->date && $payment->date <= $date2)) {
						$paymentorganisation_destinataire = $payment->id_organisation; // Même info dans les 2 champs com workaround temporaire
						$paymentid_organisation = $payment->organisation_assurance;
						$dataTab = explode(',', $payment->category_name_assurance);
						foreach ($dataTab as $value) {
							$valueTab = explode('*', $value);
							if (isset($valueTab[4]) && $valueTab[1] > 0) {
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
									'<td>' . $this->partenaire_model->getPartenairesById($payment->organisation_assurance)->nom . '</td>' .
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
			} else if ($payment->etat == 1) {
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
		$is_assurance = '';
		if ($payment->etat_assurance == 1) {
			$is_assurance = 1;
		}
		$email = '';
		if (isset($Organisationorigins->email)) {
			$email = $Organisationorigins->email;
		}
		echo json_encode(array('result' => true, "message" => $info, "destinatairs" => $Organisationdestinatairs, "origins" => $Organisationorigins, "prestations" => $info0, "total" => $tarif_ttotal, "tva" => $tarif_ttva, "etatlight" => $is_light, "emailOrganisationLightOrigine" => $email, "assurance" => $is_assurance));
	}

	function validFaurePartenaire()
	{
		log_message('ecomed', 'index appointment');
		$id = $this->input->post('idOrganisation');
		$date1 = strtotime(str_replace('/', '-', $this->input->post('date1')));
		$date2 = strtotime(str_replace('/', '-', $this->input->post('date2') . ' 23:59'));
		$origins = $this->partenaire_model->payListeFactureByaLL($this->id_organisation, 1, false, false, 'accept', false, $id, $date1, $date2);
		$originslight = $this->partenaire_model->payListeFactureByaLL($this->id_organisation, false, 1, false, 'accept', false, $id, $date1, $date2);
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
							$this->partenaire_model->insertPaymentPro(array('codefacture' => $codeFacture, 'codepro' => $payment->code, 'dateDebut' => $date1, 'dateFin' => $date2, 'date' => $dateEmise));
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
							$this->partenaire_model->insertPaymentPro(array('codefacture' => $codeFacture, 'codepro' => $payment->code, 'dateDebut' => $date1, 'dateFin' => $date2, 'date' => $dateEmise));
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
		$origins = $this->partenaire_model->payListeFactureByaLL($this->id_organisation, 1, false, false, 'accept', false, $id, $date1, $date2);
		$originslight = $this->partenaire_model->payListeFactureByaLL($this->id_organisation, false, 1, false, 'accept', false, $id, $date1, $date2);
		$originsAssurance = $this->partenaire_model->payListeFactureByaLL($this->id_organisation, false, false, 1, 'accept', false, $id, $date1, $date2);
		$origins = array_merge($origins, $originslight, $originsAssurance);
		$date = time();
		$dateEmise = date('d/m/Y', $date);
		$valuenew = array();
		// var_dump($origins);
		// exit();
		// if (!empty($origins)) {
		// 	$date = time();
		// 	$date_string = date('d/m/Y H:i', $date);
		// 	$user = $this->ion_auth->get_user_id();
		// 	$data = array(
		// 		'category_name_pro' => $origins->category_name,
		// 		'date' => $date,
		// 		'user' => $user,
		// 		'date_string' => $date_string,
		// 		'id_organisation' => $this->id_organisation,
		// 		'etat' => 1, "status" => "demandpay",
		// 		"statutEtat" => $origins->statutEtat,
		// 		"statutLight" => $origins->statutLight,
		// 		'organisation_destinataire' => $id
		// 	);
		// 	$this->finance_model->insertPayment($data);
		// 	$inserted_id = $this->db->insert_id();
		// 	$count_payment = $this->db->get_where('payment', array('id_organisation =' => $this->id_organisation))->num_rows();

		// 	// $codeFacture = 'F-' . $this->code_organisation . '-' . str_pad($count_payment, 4, "0", STR_PAD_LEFT);
		// 	$codeFacture = 'F' . $this->code_organisation . '' . $count_payment;
		// 	$this->finance_model->updatePayment($inserted_id, array('code' => $codeFacture), $this->id_organisation);
		// }

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
							$this->partenaire_model->insertPaymentPro(array('codefacture' => $codeFacture, 'codepro' => $payment->code, 'dateDebut' => $date1, 'dateFin' => $date2, 'date' => $dateEmise));
						}
					}
				}
			} else if ($payment->etat_assurance == 1) {
				if ($this->id_organisation == $payment->id_organisation) {
					if ($payment->etat_assurance == 1 && $payment->organisation_assurance == $id && ($date1 <= $payment->date && $payment->date <= $date2)) {
						$dataTab = explode(',', $payment->category_name_assurance);
						$category_name = $payment->category_name_assurance;
						foreach ($dataTab as $value) {
							$valueTab = explode('*', $value);
							if (isset($valueTab[4])) {
								$id_prestation = $valueTab[0];
								$type = 6;
								$check = $valueTab[0] . '*' . $valueTab[1] . '*' . $valueTab[2] . '*' . $valueTab[3] . '*' . $type;
								$category_name = str_replace($value, $check, $category_name);
								$total = intval($total) + intval($valueTab[1]);
							}

							$valuenew = array("category_name_assurance" => $category_name, "code_pro" => $payment->code, "status" => "demandpay", "status_presta" => "finish");
						}

						if ($category_name) {
							$this->finance_model->updatePayment($payment->id, $valuenew);
							$this->partenaire_model->insertPaymentPro(array('codefacture' => $codeFacture, 'codepro' => $payment->code, 'dateDebut' => $date1, 'dateFin' => $date2, 'date' => $dateEmise));
						}
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