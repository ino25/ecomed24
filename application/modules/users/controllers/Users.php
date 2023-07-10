<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Users extends MX_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('nurse_model');
		$this->load->model('home/home_model');
		$this->load->model('profile/profile_model');
		$this->load->model('services/service_model');
		if (!$this->ion_auth->in_group(array('admin', 'adminmedecin'))) {
			redirect('home/permission');
		}

		$identity = $this->session->userdata["identity"];
		$this->id_organisation = $this->home_model->get_id_organisation($identity);
		$this->path_logo = $this->home_model->get_logo_organisation($this->id_organisation);
		$this->nom_organisation = $this->home_model->get_nom_organisation($this->id_organisation);
	}

	public function index()
	{
		// $data['nurses'] = $this->nurse_model->getNurse();
		// $data['users'] = $this->home_model->getOrgit add .
		// ganisationNonAdminUsers($this->id_organisation);
		$data['users'] = $this->home_model->getOrganisationNonPatientUsers($this->id_organisation);
		// $this->session->set_flashdata('feedback', "Users: ".print_r(($data['users'][0])->id));
		for ($i = 0; $i < count($data['users']); $i++) { // Recupertion img_url
			//
			$current_id = $data['users'][$i]->id;
			$group_id = $this->profile_model->getUsersGroups($current_id)->row()->group_id;
			$group = $this->profile_model->getGroups($group_id)->row();
			$group_name = $group->name;
			$group_name = strtolower($group_name);
			$group_label_fr = $group->label_fr;
			if ($group_name != "admin") {
				$this->db->where("ion_user_id", $current_id);
				$query = $this->db->get($group_name);
				$img_url = '';
				if (isset($query->row()->img_url)) {
					$img_url = $query->row()->img_url;
				}
				$data['users'][$i]->img_url = $img_url;
			} else {
				$data['users'][$i]->img_url = $data['users'][$i]->default_img_url;
			}
			$data['users'][$i]->group_label_fr = $group_label_fr;
			$tt = '';
			$tab = $this->service_model->getServiceById($data['users'][$i]->service);
			if (isset($tab)) {
				$tt = $tab->name_service;
			}
			$data['users'][$i]->service_name = $tt;
		}

		$data['users'] = $data['users'];
		$data['id_organisation'] = $this->id_organisation;
		$data['path_logo'] = $this->path_logo;
		$data['nom_organisation'] = $this->nom_organisation;



		$this->load->view('home/dashboard', $data); // just the header file
		$this->load->view('users', $data);
		$this->load->view('home/footer'); // just the header file
	}

	public function addNewView()
	{
		$this->load->view('home/dashboard'); // just the header file
		$this->load->view('add_new');
		$this->load->view('home/footer'); // just the header file
	}

	// public function addNonAdmin() {
	public function addNonPatient()
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
		$phone_recuperation = $this->input->post('phone_recuperation');
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
		//$this->form_validation->set_rules('phone', 'phone', 'trim|min_length[8]|max_length[45]|xss_clean');
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
				$this->load->view('addNonPatientUser', $data);
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
				$this->load->view('addNonPatientUser', $data);
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
					'phone' => $phone,
					'phone_recuperation' => $phone_recuperation
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
					$this->load->view('addNonPatientUser', $data);
					$this->load->view('home/footer'); // just the header file
					return;
				} else { // Sinon
					$data = array();
					$data = array(
						'name' => $prenom . " " . $nom,
						'email' => $email,
						'address' => $adresse,
						'phone' => $phone,
						'phone_recuperation' => $phone_recuperation
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
					$this->load->view('addNonPatientUser', $data);
					$this->load->view('home/footer'); // just the header file
					return;
				} else {
					// VOIR MAIL ENVOYER
				
					$dfg = $groupe;
					$idCompany = $this->id_organisation;
					$company = $this->db->get_where('organisation', array('id' => $idCompany))->row()->nom;
					$this->ion_auth->register($username, $password, $email, $dfg);
					$this->ion_auth->reset_activation($email, $username, $company);
					$ion_user_id = $this->db->get_where('users', array('email' => $email))->row()->id;

					$data2 = array('first_name' => $prenom, 'last_name' => $nom, 'service' => $service, 'phone' => $phone, 'phone_recuperation' => $phone_recuperation, 'adresse' => $adresse, 'region' => $region, 'departement' => $departement, 'arrondissement' => $arrondissement, 'collectivite' => $collectivite, 'pays' => $pays, 'id_organisation' => $this->id_organisation);
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
					$this->load->view('addNonPatientUser', $data);
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


					$old_group = $this->profile_model->getUsersGroups($id)->row()->group_id;
					$old_group_name = $this->profile_model->getGroups($old_group)->row()->name;
					$old_group_name = strtolower($old_group_name);

					$new_group = $groupe;
					$new_group_name = $this->profile_model->getGroups($new_group)->row()->name;
					$new_group_name = strtolower($new_group_name);

					if ($old_group != 1 && $new_group != 1) {
						// Si ancien groupe different d Admin & nouveau groupe différent de Admin
						// On récupere l'image de l'ancienne table
						$old_img_path = $this->profile_model->getProfileByIdAndGroupName($id, $old_group_name)->img_url;
						// On supprime l'entrée de la table de l'ancien groupe
						$this->profile_model->deleteProfileByIdAndGroupName($id, $old_group_name);
						// On insere dans la nouvelle table
						$array_old_img = array("img_url" => $old_img_path);
						$array_ion_user_id = array("ion_user_id" => $id);
						$array_final = isset($old_img_path) && $old_img_path != null ? array_merge($array_old_img, $array_ion_user_id) : $array_ion_user_id;
						$this->profile_model->insertProfile($array_final, $new_group_name);
					} else if ($old_group == 1 && $new_group != 1) {
						// Si ancien groupe Admin & nouveau groupe différent de Admin
						// On récupere l'image de l'ancienne table
						$old_img_path = $this->profile_model->getProfileById($id, $old_group_name)->default_img_url;
						// On insere dans la nouvelle table
						$array_old_img = array("img_url" => $old_img_path);
						$array_ion_user_id = array("ion_user_id" => $id);
						$array_final = isset($old_img_path) && $old_img_path != null ? array_merge($array_old_img, $array_ion_user_id) : $array_ion_user_id;
						$this->profile_model->insertProfile($array_final, $new_group_name);
					} else if ($new_group == 1) {
						// Si nouveau groupe Admin (on supprime)
						if ($old_group != 1) { // Si seulement l'ancien groupe different de Admin
							// On supprime l'entrée de la table de l'ancien groupe et on insere dans la nouvelle table			
							// On récupere l'image de l'ancienne table
							$old_img_path = $this->profile_model->getProfileByIdAndGroupName($id, $old_group_name)->img_url;
							// On supprime l'entrée de la table de l'ancien groupe
							$this->profile_model->deleteProfileByIdAndGroupName($id, $old_group_name);
							// On met à jour users
							if (isset($old_img_path) && $old_img_path != null) {
								$this->home_model->updateUserEntry($id, array("default_img_url" => $old_img_path));
							}
						}
					}

					// On met à jour users_groups dans tous les k
					$this->profile_model->updateUsersGroups($id, $groupe);
					// On récupére les infos du nouveau groupe (doublon: par précaution)
					$group_id = $this->profile_model->getUsersGroups($id)->row()->group_id;
					$group_name = $this->profile_model->getGroups($group_id)->row()->name;
					$group_name = strtolower($group_name);

					if ($groupe != 1) {
						$this->profile_model->updateProfile($id, $data, $group_name);
					} else {
						$this->home_model->updateUserEntry($id, $data3);
					}
					$data2 = array('first_name' => $prenom, 'last_name' => $nom, 'service' => $service, 'phone' => $phone, 'phone_recuperation' => $phone_recuperation, 'adresse' => $adresse, 'region' => $region, 'departement' => $departement, 'arrondissement' => $arrondissement, 'collectivite' => $collectivite, 'pays' => $pays, 'id_organisation' => $this->id_organisation);
					$this->home_model->updateUserEntry($id, $data2);

					$this->session->set_flashdata('feedback', "Utilisateur modifié");
				}
			}
			
			// Loading View
			redirect('users');
		}
	}

	function getNurse()
	{
		$data['nurses'] = $this->nurse_model->get_nurse();
		$this->load->view('nurse', $data);
	}

	public function addNonPatientUser()
	{
		$data = array();
		// $data['settings'] = $this->settings_model->getSettings();
		$data['regions_senegal'] = $this->home_model->getRegionsSenegal();
		// $idOrganisation = $this->input->get("idOrganisation");
		// $data['organisation'] = $this->home_model->getOrganisationById($idOrganisation);

		$data['id_organisation'] = $this->id_organisation;
		$data['path_logo'] = $this->path_logo;
		$data['nom_organisation'] = $this->nom_organisation;

		
		$this->load->view('home/dashboard', $data); // just the header file
		$this->load->view('addNonPatientUser', $data);
		$this->load->view('home/footer', $data);
	}

	public function editNonPatientUser()
	{
		$data = array();
		$id = $this->input->get('id');
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

		$data['regions_senegal'] = $this->home_model->getRegionsSenegal();
		// $this->session->set_flashdata('feedback', "ABC: ".($data['user'])->id);
		// $data['organisation'] = $this->home_model->getOrganisationById($idOrganisation);
		$serviceTab = $this->service_model->getServiceById($data['user']->service);
		$data['name_service'] = $serviceTab->name_service;
		$data['service'] = $serviceTab->idservice;
		$this->load->view('home/dashboard', $data); // just the header file
		$this->load->view('addNonPatientUser', $data);
		$this->load->view('footer', $data);
	}

	function editNurse()
	{
		$data = array();
		$id = $this->input->get('id');
		$data['nurse'] = $this->nurse_model->getNurseById($id);
		$this->load->view('home/dashboard'); // just the header file
		$this->load->view('add_new', $data);
		$this->load->view('home/footer'); // just the footer file
	}

	function editNurseByJason()
	{
		$id = $this->input->get('id');
		$data['nurse'] = $this->nurse_model->getNurseById($id);
		echo json_encode($data);
	}

	function delete()
	{
		$data = array();
		$id = $this->input->get('id');
		$user_data = $this->db->get_where('nurse', array('id' => $id))->row();
		$path = $user_data->img_url;

		if (!empty($path)) {
			unlink($path);
		}
		$ion_user_id = $user_data->ion_user_id;
		$this->db->where('id', $ion_user_id);
		$this->db->delete('users');
		$this->nurse_model->delete($id);
		$this->session->set_flashdata('feedback', lang('deleted'));
		redirect('nurse');
	}
}

/* End of file nurse.php */
/* Location: ./application/modules/nurse/controllers/nurse.php */