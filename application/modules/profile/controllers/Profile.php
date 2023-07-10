<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Profile extends MX_Controller
{

	// Declaration not required
	// var $id_organisation;
	// var $path_logo;
	// var $nom_organisation;

	function __construct()
	{
		parent::__construct();
		$this->load->model('profile_model');
		$this->load->model('home/home_model');
		$this->load->model('lab/lab_model');
		$this->load->model('services/service_model');
		if (!$this->ion_auth->logged_in()) {
			redirect('auth/login', 'refresh');
		}

		$identity = $this->session->userdata["identity"];
		$this->id_organisation = $this->home_model->get_id_organisation($identity);
		$this->path_logo = $this->home_model->get_logo_organisation($this->id_organisation);
		$this->nom_organisation = $this->home_model->get_nom_organisation($this->id_organisation);
	}

	public function index()
	{
		$data = array();
		$id = $this->ion_auth->get_user_id();
		$data['profile'] = $this->profile_model->getProfileById($id);
		// for($i=0;$i<count($data['users']);$i++) { // Recupertion img_url

		$current_id = ($data['profile'])->id;
		$group_id = $this->profile_model->getUsersGroups($current_id)->row()->group_id;
		$group_name = $this->profile_model->getGroups($group_id)->row()->name;
		$group_name = strtolower($group_name);

		if ($group_name != "admin") {
			$this->db->where("ion_user_id", $current_id);
			$query = $this->db->get($group_name);
			($data['profile'])->img_url = $query->row()->img_url;
		} else {
			($data['profile'])->img_url = ($data['profile'])->default_img_url;
		}
		($data['profile'])->groupe = $group_id;
		// }

		$data['id_organisation'] = $this->id_organisation;
		$data['path_logo'] = $this->path_logo;
		$data['nom_organisation'] = $this->nom_organisation;

		$data['regions_senegal'] = $this->home_model->getRegionsSenegal();

		$data['user_signature'] = $this->db->query("select * from doctor_signature where doc_id=$id")->result_array();


		$this->load->view('home/dashboard', $data); // just the header file
		$this->load->view('profile', $data);
		$this->load->view('home/footer'); // just the footer file
	}


	public function editProfilUser()
	{

		$id = $this->input->post('id');
		$groupe = $this->input->post('groupe');
		$prenom = $this->input->post('prenom');
		$nom = $this->input->post('nom');
		$service = $this->input->post('service');
		$phone = $this->input->post('phone');
		$password = $this->input->post('password');
		$adresse = $this->input->post('adresse');
		$region = $this->input->post('region');
		$departement = $this->input->post('departement');
		$arrondissement = $this->input->post('arrondissement');
		$collectivite = $this->input->post('collectivite');
		$pays = $this->input->post('pays');
		$email = $this->input->post('email');

		if (empty($password)) {
			$password = $this->db->get_where('users', array('id' => $id))->row()->password;
		} else {
			$password = $this->ion_auth_model->hash_password($password);
		}

		$this->profile_model->updateProfilIonUser($adresse, $email, $password, $id);

		redirect('profile');

	}

	// public function UploadSign()
	// {

	// 	$id = $this->input->post('docid');
	// 	$pin = sha1($this->input->post('inputPin'));
	// 	$file_name = $_FILES['inputsign']['name'];
		
	// 	$this->db->query("INSERT INTO `doctor_signature` (`id`, `doc_id`, `sign_name`, `pin`, `date`) VALUES (NULL, '3', 'test', '132569', '2022/10/31');");
	// 	//$this->db->query("INSERT INTO doctor_signature(doc_id,sign_name,pin) values($id,'$file_name','$pin')");
	// 	redirect('profile');

	// }


	public function editNonProfilUser()
	{
		$data = array();
		$id = $this->ion_auth->get_user_id();
		// $idOrganisation = $this->input->get('idOrganisation');
		$data['user'] = $this->home_model->getUserById($id);
		// for($i=0;$i<count($data['users']);$i++) { // Recupertion img_url

		$current_id = $data['user']->id;
		$group_id = $this->profile_model->getUsersGroups($current_id)->row()->group_id;
		$group_name = $this->profile_model->getGroups($group_id)->row()->name;
		$group_name = strtolower($group_name);

		if ($group_name != "admin") {
			$this->db->where("ion_user_id", $current_id);
			$query = $this->db->get($group_name);
			$data['user']->img_url = $query->row()->img_url;
		} else {
			$data['user']->img_url = $data['user']->default_img_url;
		}
		$data['user']->groupe = $group_id;
		// }
		$data['id_organisation'] = $this->id_organisation;
		$data['path_logo'] = $this->path_logo;
		$data['nom_organisation'] = $this->nom_organisation;
		$data['user_signature'] = $this->db->query("select * from doctor_signature where doc_id=$id")->result_array();
		$data['regions_senegal'] = $this->home_model->getRegionsSenegal();
		// $this->session->set_flashdata('feedback', "ABC: ".($data['user'])->id);
		// $data['organisation'] = $this->home_model->getOrganisationById($idOrganisation);
		$serviceTab = $this->service_model->getServiceById($data['user']->service);
		$data['name_service'] = $serviceTab->name_service;
		$data['service'] = $serviceTab->idservice;
		$this->load->view('home/dashboard', $data); // just the header file
		$this->load->view('profile', $data);
		$this->load->view('footer', $data);
	}


	public function addNonProfil()
	{

		$id = $this->input->post('id');
		$groupe = $this->input->post('groupe');
		$prenom = $this->input->post('prenom');
		$nom = $this->input->post('nom');
		$service = $this->input->post('service');
		$phone = $this->input->post('phone');
		$email = $this->input->post('email');
		$password = $this->input->post('password');
		$adresse = $this->input->post('adresse');
		$region = $this->input->post('region');
		$departement = $this->input->post('departement');
		$arrondissement = $this->input->post('arrondissement');
		$collectivite = $this->input->post('collectivite');
		$pays = $this->input->post('pays');
		$img = $this->input->post('img_url');
		$path_img = "";





		// $id = $this->input->post('id');
		// $name = $this->input->post('name');
		// $password = $this->input->post('password');
		// $email = $this->input->post('email');
		// $address = $this->input->post('address');
		// $phone = $this->input->post('phone');

		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		// $this->form_validation->set_rules('groupe', 'groupe', 'trim|required|min_length[4]|max_length[255]|xss_clean|callback_groupe_validate');
		$this->form_validation->set_rules('nom', 'nom', 'trim|required|min_length[1]|max_length[255]|xss_clean');
		$this->form_validation->set_rules('prenom', 'nom', 'trim|required|min_length[1]|max_length[255]|xss_clean');
		$this->form_validation->set_rules('phone', 'phone', 'trim|min_length[9]|max_length[45]|xss_clean');
		$this->form_validation->set_rules('email', 'email', 'trim|required|valid_email|min_length[5]|max_length[255]|xss_clean');
		if (empty($id)) {
			$this->form_validation->set_rules('password', 'password', 'trim|min_length[4]|max_length[12]|xss_clean');
		}
		$this->form_validation->set_rules('adresse', 'adresse', 'trim|required|min_length[1]|max_length[255]|xss_clean');
		$this->form_validation->set_rules('region', 'region', array('trim', '', 'min_length[1]', 'max_length[255]', 'xss_clean', array('region_validate', function ($abcd) {
			/*if($abcd == "Veuillez sélectionner une région" || $abcd == "---")
							{
									$this->form_validation->set_message('region_validate', 'Région non sélectionnée');
									return false;
							} 
							else
							{
									// User picked something.
									return true;
							}*/
		})));
		$this->form_validation->set_rules('departement', 'departement', array('trim', '', 'min_length[1]', 'max_length[255]', 'xss_clean', array('departement_validate', function ($abcd) {
			/*if($abcd == "Veuillez sélectionner un département" || $abcd == "---")
							{
									$this->form_validation->set_message('departement_validate', 'Département non sélectionné');
									return false;
							} 
							else
							{
									// User picked something.
									return true;
							}*/
		})));
		// $this->form_validation->set_rules('arrondissement', 'arrondissement', array('trim', 'required','min_length[1]','max_length[255]','xss_clean', array('arrondissement_validate', function($abcd)
		// {
		// if($abcd == "Veuillez sélectionner un arrondissement" || $abcd == "---")
		// {
		// $this->form_validation->set_message('arrondissement_validate', 'Arrondissement non sélectionné');
		// return false;
		// } 
		// else
		// {
		// // User picked something.
		// return true;
		// }
		// })));
		$this->form_validation->set_rules('arrondissement', 'arrondissement', array('trim', 'min_length[1]', 'max_length[255]', 'xss_clean'));
		// $this->form_validation->set_rules('collectivite', 'collectivite', array('trim', 'required','min_length[1]','max_length[255]','xss_clean', array('collectivite_validate', function($abcd)
		// {
		// if($abcd == "Veuillez sélectionner une collectivité" || $abcd == "---")
		// {
		// $this->form_validation->set_message('collectivite_validate', 'Collectivité non sélectionnée');
		// return false;
		// } 
		// else
		// {
		// // User picked something.
		// return true;
		// }
		// })));
		$this->form_validation->set_rules('collectivite', 'collectivite', array('trim', 'min_length[1]', 'max_length[255]', 'xss_clean'));
		$this->form_validation->set_rules('pays', 'pays', 'trim|required|min_length[1]|max_length[255]|xss_clean');
		$this->form_validation->set_rules('img_url', 'img_url', 'trim|min_length[1]|max_length[1000]|xss_clean');
		$this->form_validation->set_rules('groupe', 'groupe', array('trim', 'required', 'min_length[1]', 'max_length[255]', 'xss_clean', array('groupe_validate', function ($abcd) {
			if ($abcd == "Veuillez sélectionner un rôle") {
				$this->form_validation->set_message('groupe_validate', 'Rôle non sélectionné');
				return false;
			} else {
				// User picked something.
				return true;
			}
		})));

		if ($this->form_validation->run() == FALSE) {
			if (!empty($id)) {
				$data = array();
				// $data['settings'] = $this->settings_model->getSettings();
				// $data['organisations'] = $this->home_model->getOrganisations();
				$data['regions_senegal'] = $this->home_model->getRegionsSenegal();
				$data['setval'] = 'setval';

				// $data['nurse'] = $this->nurse_model->getNurseById($id);

				$data['id_organisation'] = $this->id_organisation;
				$data['path_logo'] = $this->path_logo;
				$data['nom_organisation'] = $this->nom_organisation;

				$this->load->view('home/dashboard', $data); // just the header file
				$this->load->view('profile', $data);
				$this->load->view('home/footer'); // just the footer file

				return;
			} else {
				$data = array();
				$data['regions_senegal'] = $this->home_model->getRegionsSenegal();
				$data['setval'] = 'setval';

				$data['id_organisation'] = $this->id_organisation;
				$data['path_logo'] = $this->path_logo;
				$data['nom_organisation'] = $this->nom_organisation;

				$this->load->view('home/dashboard', $data); // just the header file
				$this->load->view('profile', $data);
				$this->load->view('home/footer'); // just the header file

				return;
			}
		} else {
			$file_name = $_FILES['img_url']['name'];
			$file_name_pieces = explode('_', $file_name);
			$new_file_name = '';
			$count = 1;
			foreach ($file_name_pieces as $piece) {
				if ($count !== 1) {
					$piece = ucfirst($piece);
				}
				$new_file_name .= $piece;
				$count++;
			}
			$config = array(
				'file_name' => $this->id_organisation . "_" . $groupe . "_" . $new_file_name,
				'upload_path' => "./uploads/imgUsers/",
				'allowed_types' => "gif|jpg|png|jpeg|pdf",
				// 'overwrite' => False,
				'max_size' => "20480000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
				// 'max_height' => "1768",
				// 'max_width' => "2024"
			);

			$this->load->library('Upload', $config);
			$this->upload->initialize($config);

			if ($this->upload->do_upload('img_url')) {
				$path = $this->upload->data();
				$img_url = "uploads/imgUsers/" . $path['file_name'];
				$data = array();
				// $data = array(
				// 'img_url' => $img_url,
				// 'name' => $name,
				// 'email' => $email,
				// 'address' => $address,
				// 'phone' => $phone
				// );
				$data['path_img'] = "uploads/imgUsers/" . $path['file_name'];
				$path_img = "uploads/imgUsers/" . $path['file_name'];

				$data = array();
				$data = array(
					'img_url' => $path_img,
					'name' => $prenom . " " . $nom,
					'email' => $email,
					'address' => $adresse,
					'phone' => $phone
				);
				if ($groupe == 1) {
					$data3 = array(
						"default_img_url" => $path_img
					);
				}
			} else {
				if (trim($new_file_name) != "") { // Si img uploadé Mais erreur
					//$error = array('error' => $this->upload->display_errors());
					// $data = array();
					$data = array();
					// $data['settings'] = $this->settings_model->getSettings();
					// $data['organisations'] = $this->home_model->getOrganisations();
					$data['regions_senegal'] = $this->home_model->getRegionsSenegal();
					$data['setval'] = 'setval';
					$data['display_errors'] = "Upload Not ok: " . $this->upload->display_errors();


					$data['id_organisation'] = $this->id_organisation;
					$data['path_logo'] = $this->path_logo;
					$data['nom_organisation'] = $this->nom_organisation;

					// $this->session->set_flashdata('feedback', "abc: ".$new_file_name);

					$this->load->view('home/dashboard', $data); // just the header file
					$this->load->view('profile', $data);
					$this->load->view('home/footer'); // just the header file
					return;
				} else { // Sinon
					$data = array();
					$data = array(
						'name' => $prenom . " " . $nom,
						'email' => $email,
						'address' => $adresse,
						'phone' => $phone
					);
				}
			}
			// $username = $this->input->post('name');
			$username = $this->input->post('prenom');
			$arrondissement = ($arrondissement == "Veuillez sélectionner un arrondissement" || $arrondissement == "---") ? "" : $arrondissement;
			$collectivite = ($collectivite == "Veuillez sélectionner une collectivité" || $collectivite == "---") ? "" : $collectivite;
			if (empty($id)) {     // Adding New Nurse
				if ($this->ion_auth->email_check($email)) {
					$this->session->set_flashdata('feedback', lang('this_email_address_is_already_registered'));
					// redirect('users/addNonAdminUser');
					$data = array();
					// $data['settings'] = $this->settings_model->getSettings();
					// $data['organisations'] = $this->home_model->getOrganisations();
					$data['regions_senegal'] = $this->home_model->getRegionsSenegal();
					$data['setval'] = 'setval';
					// $data['display_errors'] = "Upload Not ok: ".$this->upload->display_errors();


					$data['id_organisation'] = $this->id_organisation;
					$data['path_logo'] = $this->path_logo;
					$data['nom_organisation'] = $this->nom_organisation;

					// $this->session->set_flashdata('feedback', "abc: ".$new_file_name);

					$this->load->view('home/dashboard', $data); // just the header file
					$this->load->view('profile', $data);
					$this->load->view('home/footer'); // just the header file
					return;
				} else {
					$dfg = $groupe;
					$this->ion_auth->register($username, $password, $email, $dfg);
					$ion_user_id = $this->db->get_where('users', array('email' => $email))->row()->id;

					$data2 = array('first_name' => $prenom, 'last_name' => $nom, 'service' => $service, 'phone' => $phone, 'adresse' => $adresse, 'region' => $region, 'departement' => $departement, 'arrondissement' => $arrondissement, 'collectivite' => $collectivite, 'pays' => $pays, 'id_organisation' => $this->id_organisation);
					$this->home_model->updateUserEntry($ion_user_id, $data2);

					$group_id = $this->profile_model->getUsersGroups($ion_user_id)->row()->group_id;
					$group_name = $this->profile_model->getGroups($group_id)->row()->name;
					$group_name = strtolower($group_name);
					if ($groupe != 1) { // Si différent de Admin: Insertion entrée et mise à jour
						$this->profile_model->insertProfile($data, $group_name);
						$profile_id = $this->db->get_where($group_name, array('email' => $email))->row()->id;
						$id_info = array('ion_user_id' => $ion_user_id);
						$this->profile_model->updateProfileWithUserId($profile_id, $id_info, $group_name);
					} else { // Sinon (Admin) - Mise à jour user entry
						$this->home_model->updateUserEntry($ion_user_id, $data3);
					}
					// $this->profile_model->updateProfile($ion_user_id, $data, $group_name);
					// $this->nurse_model->updateNurse($nurse_user_id, $id_info);
					$this->session->set_flashdata('feedback', "Utilisateur ajouté");
				}
			} else { // Updating Nurse
				// $ion_user_id = $this->db->get_where('users', array('id' => $id))->row()->ion_user_id;

				if ($this->ion_auth->email_check_and_not_own($email, $id)) {
					$this->session->set_flashdata('feedback', lang('this_email_address_is_already_registered'));
					// redirect('users/addNonAdminUser');
					$data = array();
					// $data['settings'] = $this->settings_model->getSettings();
					// $data['organisations'] = $this->home_model->getOrganisations();
					$data['regions_senegal'] = $this->home_model->getRegionsSenegal();
					$data['setval'] = 'setval';
					// $data['display_errors'] = "Upload Not ok: ".$this->upload->display_errors();


					$data['id_organisation'] = $this->id_organisation;
					$data['path_logo'] = $this->path_logo;
					$data['nom_organisation'] = $this->nom_organisation;

					// $this->session->set_flashdata('feedback', "abc: ".$new_file_name);

					$this->load->view('home/dashboard', $data); // just the header file
					$this->load->view('profile', $data);
					$this->load->view('home/footer'); // just the header file
					return;
				} else {
					if (empty($password)) {
						$password = $this->db->get_where('users', array('id' => $id))->row()->password;
					} else {
						$password = $this->ion_auth_model->hash_password($password);
					}
					$this->home_model->updateIonUser($username, $email, $password, $id);
					// $this->nurse_model->updateIonUser($username, $email, $password, $ion_user_id);
					// $this->nurse_model->updateNurse($id, $data);


					$this->profile_model->updateUsersGroups($id, $groupe);
					$group_id = $this->profile_model->getUsersGroups($id)->row()->group_id;
					$group_name = $this->profile_model->getGroups($group_id)->row()->name;
					$group_name = strtolower($group_name);
					if ($groupe != 1) {
						$this->profile_model->updateProfile($id, $data, $group_name);
					} else {
						$this->home_model->updateUserEntry($id, $data3);
					}
					$data2 = array('first_name' => $prenom, 'last_name' => $nom, 'service' => $service, 'phone' => $phone, 'adresse' => $adresse, 'region' => $region, 'departement' => $departement, 'arrondissement' => $arrondissement, 'collectivite' => $collectivite, 'pays' => $pays, 'id_organisation' => $this->id_organisation);
					$this->home_model->updateUserEntry($id, $data2);

					$this->session->set_flashdata('feedback', "Utilisateur modifié");
				}
			}
			// Loading View
			redirect('profile');
		}
	}


	public function addNew()
	{

		$id = $this->input->post('id');
		// $groupe = $this->input->post('groupe');
		$prenom = $this->input->post('prenom');
		$nom = $this->input->post('nom');
		$phone = $this->input->post('phone');
		$email = $this->input->post('email');
		$password = $this->input->post('password');
		$adresse = $this->input->post('adresse');
		$region = $this->input->post('region');
		$departement = $this->input->post('departement');
		$arrondissement = $this->input->post('arrondissement');
		$collectivite = $this->input->post('collectivite');
		$pays = $this->input->post('pays');
		$img = $this->input->post('img_url');
		$path_img = "";
		$groupe = $this->input->post('groupe');

		// $id = $this->input->post('id');
		// $name = $this->input->post('name');
		// $password = $this->input->post('password');
		// $email = $this->input->post('email');

		$data['profile'] = $this->profile_model->getProfileById($id);

		if ($data['profile']->email != $email) {
			if ($this->ion_auth->email_check($email)) {
				$this->session->set_flashdata('feedback', lang('this_email_address_is_already_registered'));
				redirect('profile');
			}
		}

		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		// $this->form_validation->set_rules('groupe', 'groupe', 'trim|required|min_length[4]|max_length[255]|xss_clean|callback_groupe_validate');
		$this->form_validation->set_rules('nom', 'nom', 'trim|required|min_length[1]|max_length[255]|xss_clean');
		$this->form_validation->set_rules('prenom', 'nom', 'trim|required|min_length[1]|max_length[255]|xss_clean');
		$this->form_validation->set_rules('phone', 'phone', 'trim|min_length[9]|max_length[45]|xss_clean');
		$this->form_validation->set_rules('email', 'email', 'trim|required|valid_email|min_length[5]|max_length[255]|xss_clean');
		if (empty($id)) {
			$this->form_validation->set_rules('password', 'password', 'trim|required|min_length[4]|max_length[12]|xss_clean');
		}
		$this->form_validation->set_rules('adresse', 'adresse', 'trim|required|min_length[1]|max_length[255]|xss_clean');
		$this->form_validation->set_rules('region', 'region', array('trim', 'required', 'min_length[1]', 'max_length[255]', 'xss_clean', array('region_validate', function ($abcd) {
			if ($abcd == "Veuillez sélectionner une région" || $abcd == "---") {
				$this->form_validation->set_message('region_validate', 'Région non sélectionnée');
				return false;
			} else {
				// User picked something.
				return true;
			}
		})));
		$this->form_validation->set_rules('departement', 'departement', array('trim', 'required', 'min_length[1]', 'max_length[255]', 'xss_clean', array('departement_validate', function ($abcd) {
			if ($abcd == "Veuillez sélectionner un département" || $abcd == "---") {
				$this->form_validation->set_message('departement_validate', 'Département non sélectionné');
				return false;
			} else {
				// User picked something.
				return true;
			}
		})));
		// $this->form_validation->set_rules('arrondissement', 'arrondissement', array('trim', 'required','min_length[1]','max_length[255]','xss_clean', array('arrondissement_validate', function($abcd)
		// {
		// if($abcd == "Veuillez sélectionner un arrondissement" || $abcd == "---")
		// {
		// $this->form_validation->set_message('arrondissement_validate', 'Arrondissement non sélectionné');
		// return false;
		// } 
		// else
		// {
		// // User picked something.
		// return true;
		// }
		// })));
		$this->form_validation->set_rules('arrondissement', 'arrondissement', array('trim', 'min_length[1]', 'max_length[255]', 'xss_clean'));
		// $this->form_validation->set_rules('collectivite', 'collectivite', array('trim', 'required','min_length[1]','max_length[255]','xss_clean', array('collectivite_validate', function($abcd)
		// {
		// if($abcd == "Veuillez sélectionner une collectivité" || $abcd == "---")
		// {
		// $this->form_validation->set_message('collectivite_validate', 'Collectivité non sélectionnée');
		// return false;
		// } 
		// else
		// {
		// // User picked something.
		// return true;
		// }
		// })));
		$this->form_validation->set_rules('collectivite', 'collectivite', array('trim', 'min_length[1]', 'max_length[255]', 'xss_clean'));
		$this->form_validation->set_rules('pays', 'pays', 'trim|required|min_length[1]|max_length[255]|xss_clean');

		if ($this->form_validation->run() == FALSE) {
			$data = array();
			// $id = $this->ion_auth->get_user_id();
			// $data['profile'] = $this->profile_model->getProfileById($id);

			$data['id_organisation'] = $this->id_organisation;
			$data['path_logo'] = $this->path_logo;
			$data['nom_organisation'] = $this->nom_organisation;

			$data['regions_senegal'] = $this->home_model->getRegionsSenegal();

			$data['setval'] = 'setval';

			$this->load->view('home/dashboard', $data); // just the header file
			$this->load->view('profile', $data);
			$this->load->view('home/footer'); // just the footer file

			return;
		} else {

			$file_name = $_FILES['img_url']['name'];
			$file_name_pieces = explode('_', $file_name);
			$new_file_name = '';
			$count = 1;
			foreach ($file_name_pieces as $piece) {
				if ($count !== 1) {
					$piece = ucfirst($piece);
				}
				$new_file_name .= $piece;
				$count++;
			}
			$config = array(
				'file_name' => $this->id_organisation . "_" . $groupe . "_" . $new_file_name,
				'upload_path' => "./uploads/imgUsers/",
				'allowed_types' => "gif|jpg|png|jpeg|pdf",
				// 'overwrite' => False,
				'max_size' => "20480000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
				// 'max_height' => "1768",
				// 'max_width' => "2024"
			);

			$this->load->library('Upload', $config);
			$this->upload->initialize($config);

			if ($this->upload->do_upload('img_url')) {
				$path = $this->upload->data();
				$img_url = "uploads/imgUsers/" . $path['file_name'];
				$data = array();
				// $data = array(
				// 'img_url' => $img_url,
				// 'name' => $name,
				// 'email' => $email,
				// 'address' => $address,
				// 'phone' => $phone
				// );
				$data['path_img'] = "uploads/imgUsers/" . $path['file_name'];
				$path_img = "uploads/imgUsers/" . $path['file_name'];

				$data = array();
				$data = array(
					'img_url' => $path_img,
					'name' => $prenom . " " . $nom,
					'email' => $email,
					'address' => $adresse,
					'phone' => $phone
				);
				if ($groupe == 1) {
					$data3 = array(
						"default_img_url" => $path_img
					);
				}
			} else {
				if (trim($new_file_name) != "") { // Si img uploadé Mais erreur
					//$error = array('error' => $this->upload->display_errors());
					// $data = array();
					$data = array();
					// $data['settings'] = $this->settings_model->getSettings();
					// $data['organisations'] = $this->home_model->getOrganisations();
					$data['regions_senegal'] = $this->home_model->getRegionsSenegal();
					$data['setval'] = 'setval';
					$data['display_errors'] = "Upload Not ok: " . $this->upload->display_errors();


					$data['id_organisation'] = $this->id_organisation;
					$data['path_logo'] = $this->path_logo;
					$data['nom_organisation'] = $this->nom_organisation;

					// $this->session->set_flashdata('feedback', "abc: ".$new_file_name);

					$this->load->view('home/dashboard', $data); // just the header file
					$this->load->view('profile', $data);
					$this->load->view('home/footer'); // just the header file
					return;
				} else { // Sinon
					$data = array();
					$data = array(
						'name' => $prenom . " " . $nom,
						'email' => $email,
						'address' => $adresse,
						'phone' => $phone
					);
				}
			}

			$username = $this->input->post('prenom');
			// $username = $this->input->post('name');
			$arrondissement = ($arrondissement == "Veuillez sélectionner un arrondissement" || $arrondissement == "---") ? "" : $arrondissement;
			$collectivite = ($collectivite == "Veuillez sélectionner une collectivité" || $collectivite == "---") ? "" : $collectivite;

			$ion_user_id = $this->ion_auth->get_user_id();
			$group_id = $this->profile_model->getUsersGroups($ion_user_id)->row()->group_id;
			$group_name = $this->profile_model->getGroups($group_id)->row()->name;
			$group_name = strtolower($group_name);
			if (empty($password)) {
				$password = $this->db->get_where('users', array('id' => $ion_user_id))->row()->password;
			} else {
				$password = $this->ion_auth_model->hash_password($password);
			}
			$this->profile_model->updateIonUser($username, $email, $password, $ion_user_id);

			if ($groupe != 1) {
				$this->profile_model->updateProfile($ion_user_id, $data, $group_name);
			} else {
				$this->home_model->updateUserEntry($ion_user_id, $data3);
			}

			$data2 = array('first_name' => $prenom, 'last_name' => $nom, 'phone' => $phone, 'adresse' => $adresse, 'region' => $region, 'departement' => $departement, 'arrondissement' => $arrondissement, 'collectivite' => $collectivite, 'pays' => $pays);
			$this->home_model->updateUserEntry($id, $data2);

			// if (!$this->ion_auth->in_group('admin')) {
			// $this->profile_model->updateProfile($ion_user_id, $data, $group_name);
			// }
			$this->session->set_flashdata('feedback', lang('updated'));

			// Loading View
			redirect('profile');
		}
	}


	public function addNew_2()
	{

		$id = $this->input->post('id');
		// $groupe = $this->input->post('groupe');
		$prenom = $this->input->post('prenom');
		$nom = $this->input->post('nom');
		$phone = $this->input->post('phone');
		$email = $this->input->post('email');
		$password = $this->input->post('password');
		$adresse = $this->input->post('adresse');
		$region = $this->input->post('region');
		$departement = $this->input->post('departement');
		$arrondissement = $this->input->post('arrondissement');
		$collectivite = $this->input->post('collectivite');
		$pays = $this->input->post('pays');
		$img = $this->input->post('img_url');
		$path_img = "";
		$groupe = $this->input->post('groupe');

		// $id = $this->input->post('id');
		// $name = $this->input->post('name');
		// $password = $this->input->post('password');
		// $email = $this->input->post('email');

		$data['profile'] = $this->profile_model->getProfileById($id);

		if ($data['profile']->email != $email) {
			if ($this->ion_auth->email_check($email)) {
				$this->session->set_flashdata('feedback', lang('this_email_address_is_already_registered'));
				redirect('profile');
			}
		}

		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		// $this->form_validation->set_rules('groupe', 'groupe', 'trim|required|min_length[4]|max_length[255]|xss_clean|callback_groupe_validate');
		$this->form_validation->set_rules('nom', 'nom', 'trim|required|min_length[1]|max_length[255]|xss_clean');
		$this->form_validation->set_rules('prenom', 'nom', 'trim|required|min_length[1]|max_length[255]|xss_clean');
		$this->form_validation->set_rules('phone', 'phone', 'trim|min_length[9]|max_length[45]|xss_clean');
		$this->form_validation->set_rules('email', 'email', 'trim|required|valid_email|min_length[5]|max_length[255]|xss_clean');
		if (empty($id)) {
			$this->form_validation->set_rules('password', 'password', 'trim|required|min_length[4]|max_length[12]|xss_clean');
		}
		$this->form_validation->set_rules('adresse', 'adresse', 'trim|required|min_length[1]|max_length[255]|xss_clean');
		$this->form_validation->set_rules('region', 'region', array('trim', 'required', 'min_length[1]', 'max_length[255]', 'xss_clean', array('region_validate', function ($abcd) {
			if ($abcd == "Veuillez sélectionner une région" || $abcd == "---") {
				$this->form_validation->set_message('region_validate', 'Région non sélectionnée');
				return false;
			} else {
				// User picked something.
				return true;
			}
		})));
		$this->form_validation->set_rules('departement', 'departement', array('trim', 'required', 'min_length[1]', 'max_length[255]', 'xss_clean', array('departement_validate', function ($abcd) {
			if ($abcd == "Veuillez sélectionner un département" || $abcd == "---") {
				$this->form_validation->set_message('departement_validate', 'Département non sélectionné');
				return false;
			} else {
				// User picked something.
				return true;
			}
		})));
		// $this->form_validation->set_rules('arrondissement', 'arrondissement', array('trim', 'required','min_length[1]','max_length[255]','xss_clean', array('arrondissement_validate', function($abcd)
		// {
		// if($abcd == "Veuillez sélectionner un arrondissement" || $abcd == "---")
		// {
		// $this->form_validation->set_message('arrondissement_validate', 'Arrondissement non sélectionné');
		// return false;
		// } 
		// else
		// {
		// // User picked something.
		// return true;
		// }
		// })));
		$this->form_validation->set_rules('arrondissement', 'arrondissement', array('trim', 'min_length[1]', 'max_length[255]', 'xss_clean'));
		// $this->form_validation->set_rules('collectivite', 'collectivite', array('trim', 'required','min_length[1]','max_length[255]','xss_clean', array('collectivite_validate', function($abcd)
		// {
		// if($abcd == "Veuillez sélectionner une collectivité" || $abcd == "---")
		// {
		// $this->form_validation->set_message('collectivite_validate', 'Collectivité non sélectionnée');
		// return false;
		// } 
		// else
		// {
		// // User picked something.
		// return true;
		// }
		// })));
		$this->form_validation->set_rules('collectivite', 'collectivite', array('trim', 'min_length[1]', 'max_length[255]', 'xss_clean'));
		$this->form_validation->set_rules('pays', 'pays', 'trim|required|min_length[1]|max_length[255]|xss_clean');

		if ($this->form_validation->run() == FALSE) {
			$data = array();
			// $id = $this->ion_auth->get_user_id();
			// $data['profile'] = $this->profile_model->getProfileById($id);

			$data['id_organisation'] = $this->id_organisation;
			$data['path_logo'] = $this->path_logo;
			$data['nom_organisation'] = $this->nom_organisation;

			$data['regions_senegal'] = $this->home_model->getRegionsSenegal();

			$data['setval'] = 'setval';

			$this->load->view('home/dashboard', $data); // just the header file
			$this->load->view('profile', $data);
			$this->load->view('home/footer'); // just the footer file

			return;
		} else {

			$file_name = $_FILES['img_url']['name'];
			$file_name_pieces = explode('_', $file_name);
			$new_file_name = '';
			$count = 1;
			foreach ($file_name_pieces as $piece) {
				if ($count !== 1) {
					$piece = ucfirst($piece);
				}
				$new_file_name .= $piece;
				$count++;
			}
			$config = array(
				'file_name' => $this->id_organisation . "_" . $groupe . "_" . $new_file_name,
				'upload_path' => "./uploads/imgUsers/",
				'allowed_types' => "gif|jpg|png|jpeg|pdf",
				// 'overwrite' => False,
				'max_size' => "20480000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
				// 'max_height' => "1768",
				// 'max_width' => "2024"
			);

			$this->load->library('Upload', $config);
			$this->upload->initialize($config);

			if ($this->upload->do_upload('img_url')) {
				$path = $this->upload->data();
				$img_url = "uploads/imgUsers/" . $path['file_name'];
				$data = array();
				// $data = array(
				// 'img_url' => $img_url,
				// 'name' => $name,
				// 'email' => $email,
				// 'address' => $address,
				// 'phone' => $phone
				// );
				$data['path_img'] = "uploads/imgUsers/" . $path['file_name'];
				$path_img = "uploads/imgUsers/" . $path['file_name'];

				$data = array();
				$data = array(
					'img_url' => $path_img,
					'name' => $prenom . " " . $nom,
					'email' => $email,
					'address' => $adresse,
					'phone' => $phone
				);
				if ($groupe == 1) {
					$data3 = array(
						"default_img_url" => $path_img
					);
				}
			} else {
				if (trim($new_file_name) != "") { // Si img uploadé Mais erreur
					//$error = array('error' => $this->upload->display_errors());
					// $data = array();
					$data = array();
					// $data['settings'] = $this->settings_model->getSettings();
					// $data['organisations'] = $this->home_model->getOrganisations();
					$data['regions_senegal'] = $this->home_model->getRegionsSenegal();
					$data['setval'] = 'setval';
					$data['display_errors'] = "Upload Not ok: " . $this->upload->display_errors();


					$data['id_organisation'] = $this->id_organisation;
					$data['path_logo'] = $this->path_logo;
					$data['nom_organisation'] = $this->nom_organisation;

					// $this->session->set_flashdata('feedback', "abc: ".$new_file_name);

					$this->load->view('home/dashboard', $data); // just the header file
					$this->load->view('profile', $data);
					$this->load->view('home/footer'); // just the header file
					return;
				} else { // Sinon
					$data = array();
					$data = array(
						'name' => $prenom . " " . $nom,
						'email' => $email,
						'address' => $adresse,
						'phone' => $phone
					);
				}
			}

			$username = $this->input->post('prenom');
			// $username = $this->input->post('name');
			$arrondissement = ($arrondissement == "Veuillez sélectionner un arrondissement" || $arrondissement == "---") ? "" : $arrondissement;
			$collectivite = ($collectivite == "Veuillez sélectionner une collectivité" || $collectivite == "---") ? "" : $collectivite;

			$ion_user_id = $this->ion_auth->get_user_id();
			$group_id = $this->profile_model->getUsersGroups($ion_user_id)->row()->group_id;
			$group_name = $this->profile_model->getGroups($group_id)->row()->name;
			$group_name = strtolower($group_name);
			if (empty($password)) {
				$password = $this->db->get_where('users', array('id' => $ion_user_id))->row()->password;
			} else {
				$password = $this->ion_auth_model->hash_password($password);
			}
			$this->profile_model->updateIonUser($username, $email, $password, $ion_user_id);

			if ($groupe != 1) {
				$this->profile_model->updateProfile($ion_user_id, $data, $group_name);
			} else {
				$this->home_model->updateUserEntry($ion_user_id, $data3);
			}

			$data2 = array('first_name' => $prenom, 'last_name' => $nom, 'phone' => $phone, 'adresse' => $adresse, 'region' => $region, 'departement' => $departement, 'arrondissement' => $arrondissement, 'collectivite' => $collectivite, 'pays' => $pays);
			$this->home_model->updateUserEntry($id, $data2);

			// if (!$this->ion_auth->in_group('admin')) {
			// $this->profile_model->updateProfile($ion_user_id, $data, $group_name);
			// }
			$this->session->set_flashdata('feedback', lang('updated'));

			// Loading View
			redirect('profile');
		}
	}


	/// Upload Signature

	public function uploadSign()
	{
		//$response = array();
		
		$id = $this->input->post('docid');
		$pin = sha1($this->input->post('inputPin'));
		$file_name = $_FILES['inputsign']['name'];

		$file_name_pieces = explode('_', $file_name);
		$new_file_name = '';
		$count = 1;
		foreach ($file_name_pieces as $piece) {
			if ($count !== 1) {
				$piece = ucfirst($piece);
			}
			$new_file_name .= $piece;
			$count++;
		}
		$config = array(
			'file_name' => $id . "_Doctor_Sign_" . $new_file_name,
			'upload_path' => "./uploads/imgUsers/",
			'allowed_types' => "gif|jpg|png|jpeg|pdf",
			// 'overwrite' => False,
			'max_size' => "50480000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
			// 'max_height' => "1768",
			// 'max_width' => "2024"
		);
		$config['encrypt_name'] = TRUE;
		$this->load->library('Upload', $config);
		$this->upload->initialize($config);



		if ($this->upload->do_upload('inputsign')) {
			$path = $this->upload->data();

			$img_url = "uploads/imgUsers/" . $path['file_name'];
			$data = array();
			// $data = array(
			// 'img_url' => $img_url,
			// 'name' => $name,
			// 'email' => $email,
			// 'address' => $address,
			// 'phone' => $phone
			// );
			$data['path_img'] = "uploads/imgUsers/" . $path['file_name'];
			$path_img = "uploads/imgUsers/" . $path['file_name'];

			$upload  = $this->db->query("INSERT INTO doctor_signature(doc_id,sign_name,pin) values($id,'$path_img','$pin')");

			if ($upload) {

				$response['error'] = false;
				$this->session->set_flashdata('feedback', 'Importer avec succes');
				redirect('profile');
			} else {

				$response['error'] = true;
				$this->session->set_flashdata('feedback', 'Essayer plus tard ...');
				redirect('profile');
			}
		} else {

			$response['error'] = true;
			$this->session->set_flashdata('feedback', 'Essayez plus tard....problème de téléchargement');
			redirect('profile');
		}

		echo json_encode($response);

		

		die;
		
	}

	public function viewSign()
	{
	//	$response = array();
		$id = $this->input->get('docid');
		$pin = $this->input->get('pin');
		//$pin = sha1($pin);
	    // $id = $this->input->post('docid');
		// $pin = sha1($this->input->post('pin'));

		$user_signature = $this->db->query("select * from doctor_signature where pin = '$pin' and doc_id = '$id'")->result_array();
		// var_dump(count($user_signature));
		if (count($user_signature) > 0) {

			$response['error'] = false;
			$response['user_signature'] = $user_signature;
		} else {

			$response['error'] = true;
			$response['message'] = "Code PIN Invalide";
		}

		echo json_encode($response);
		die;
	}

	public function viewSignLab()
	{
		$response = array();
		$id = $this->input->post('docid');
		$report_id = $this->input->post('report_id');
		$pin = sha1($this->input->post('inputPin'));
		$user_signature = $this->db->query("select * from doctor_signature where pin = '$pin' and doc_id = '$id'")->result_array();

		if (count($user_signature) > 0) {

			$response['error'] = false;
			$response['user_signature'] = $user_signature;
			$data_up = array('signature' => 'yes', 'doc_id' => $id);
			$this->lab_model->updateLabReport($report_id, $data_up);
		} else {

			$response['error'] = true;
			$response['message'] = "Invalid PIN";
		}

		echo json_encode($response);
		die;
	}
}

/* End of file profile.php */
/* Location: ./application/modules/profile/controllers/profile.php */
