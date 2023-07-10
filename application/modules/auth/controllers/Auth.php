<?php defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends MX_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->library(array('ion_auth', 'form_validation'));
		$this->load->helper(array('url', 'language'));

		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

		$this->lang->load('auth');
	}

	//redirect if needed, otherwise display the user list
	function index()
	{

		if (!$this->ion_auth->logged_in()) {
			//redirect them to the login page
			redirect('auth/login', 'refresh');
		}
		/*	elseif (!$this->ion_auth->is_admin()) //remove this elseif if you want to enable this for non-admins
		{
			//redirect them to the home page because they must be an administrator to view this
			return show_error('You must be an administrator to view this page.');
		}
        */ else {
			//set the flash data error message if there is one
			$data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

			//list the users
			$data['users'] = $this->ion_auth->users()->result();
			foreach ($data['users'] as $k => $user) {
				$data['users'][$k]->groups = $this->ion_auth->get_users_groups($user->id)->result();
			}

			// $this->_render_page('auth/index', $data);
			redirect('home', 'refresh');
		}
	}

	//log the user in
	function login()
	{

		if ($this->ion_auth->logged_in()) {
			//redirect them to the login page
			redirect('home');
		}
		$data['title'] = "Login";

		//validate form input
		$this->form_validation->set_rules('identity', 'Email', 'required');
		$this->form_validation->set_rules('password', 'Mot de pass', 'required');

		if ($this->form_validation->run() == true) {
			//check to see if the user is logging in
			//check for "remember me"
			$remember = (bool) $this->input->post('remember');

			// OTP RELATED CHANGES START
			$login_outcome = $this->ion_auth->login($this->input->post('identity'), $this->input->post('password'), $remember);
			if (is_array($login_outcome) && count($login_outcome) >= 2) {
				$login_success = $login_outcome[0];
				$details = $login_outcome[1];
				// $login_message = print_r($details);
				$login_message = $details["error_message"];
				$phone = $details["phone"];
				$email = $details["email"];
				$password = $details["password"];
				$id = $details["id"];
			} else {
				$login_success = $login_outcome;
			}
			// OTP RELATED CHANGES END

			if ($login_success) {
				//if the login is successful
				//redirect them back to the home page
				$this->session->set_flashdata('message', '<span style="color:green;font-weight: bold;">' . $this->ion_auth->messages() . '</span>');
				redirect('/', 'refresh');
			} else {
				// OTP RELATED CHANGES END
				if ($login_message != null && !empty($login_message)) {
					// Refus car X time écoulé depuis derniere connexion
					// $this->session->set_flashdata('message', $login_message);
					// redirect('auth/otp_auth', 'refresh');
					$data["message"] = $login_message;
					$data["phone"] = $phone;
					$data["email"] = $email;
					$data["password"] = $password;
					$data["id"] = $id;
					// Generation OTP + envoi
					$random_otp = mt_rand(100000, 999999); // A optimiser
					$this->db->query("insert into generated_otp (user_id, mobile_number, email, otp, date_created) VALUES(" . $id . ", \"" . $phone . "\",\"" . $email . "\",\"" . $random_otp . "\",\"" . time() . "\")");

					$min_avant_expiration = $this->ion_auth->config->item('otp_expiration', 'ion_auth') / 60;
					// Envoi SMS par SMS
					$dataInsert = array(
						'recipient' => $phone,
						// 'message' => $messageprint,
						'message' => "Votre code de vérification valide pour " . $min_avant_expiration . " minutes: " . $random_otp . ". Merci d'utiliser ecoMed24!",
						'date' => time(),
						'user' => $id
					);
					$this->sms_model->insertSms($dataInsert);

					// Envoi par Email
					$dataInsertEmail = array(
						'reciepient' => $email,
						'subject' => "Code de vérification ecoMed24",
						'message' => "Votre code de vérification valide pour " . $min_avant_expiration . " minutes: " . $random_otp . ". Merci d'utiliser ecoMed24!",
						// 'message' => str_replace($toReplace, $replaceBy, $messageprint2),
						'date' => time(),
						'user' => $id
					);
					$this->email_model->insertEmail($dataInsertEmail);

					$this->_render_page('auth/otp_auth', $data);
				} else {
					//if the login was un-successful
					//redirect them back to the login page
					// END
					$this->session->set_flashdata('message', $this->ion_auth->errors());
					redirect('auth/login', 'refresh'); //use redirects instead of loading views for compatibility with MY_Controller libraries
					// OTP RELATED CHANGES END	
				}
				// END
			}
		} else {

			//the user is not logging in so display the login page
			//set the flash data error message if there is one
			$data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

			$data['identity'] = array(
				'name' => 'identity',
				'id' => 'identity',
				'type' => 'text',
				'value' => $this->form_validation->set_value('identity'),
			);
			$data['password'] = array(
				'name' => 'password',
				'id' => 'password',
				'type' => 'password',
			);

			$this->_render_page('auth/login', $data);
		}
	}

	function superlogin()
	{

		if ($this->ion_auth->logged_in()) {
			//redirect them to the login page
			redirect('auth/superlogin');
		}
		$data['title'] = "Login";

		//validate form input
		$this->form_validation->set_rules('identity', 'Identity', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');

		if ($this->form_validation->run() == true) {
			//check to see if the user is logging in
			//check for "remember me"
			// $remember = (bool) $this->input->post('remember');
			$remember = false;

			if ($this->ion_auth->superlogin($this->input->post('identity'), $this->input->post('password'), $remember)) {
				//if the login is successful
				//redirect them back to the home page
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				redirect('home/superhome', 'refresh');
				// redirect('https://www.phptpoint.com/codeigniter-session/', 'refresh');
			} else {
				//if the login was un-successful
				//redirect them back to the login page
				$this->session->set_flashdata('message', $this->ion_auth->errors());
				redirect('auth/superlogin', 'refresh'); //use redirects instead of loading views for compatibility with MY_Controller libraries
			}
		} else {
			//the user is not logging in so display the login page
			//set the flash data error message if there is one
			$data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

			$data['identity'] = array(
				'name' => 'identity',
				'id' => 'identity',
				'type' => 'text',
				'value' => $this->form_validation->set_value('identity'),
			);
			$data['password'] = array(
				'name' => 'password',
				'id' => 'password',
				'type' => 'password',
			);

			$this->_render_page('auth/superlogin', $data);
		}
	}

	public function maskAllButLast4($cc)
	{

		$cc_length = strlen($cc);

		for ($i = 0; $i < $cc_length - 4; $i++) {

			// if ($cc[$i] == '-') {

			// continue;
			// }

			$cc[$i] = '*';
		}

		return $cc;
	}

	public function maskEmail($email)
	{

		$buff = explode("@", $email);

		$part1 = $buff[0];
		$buff2 = explode(".", $buff[1]);
		$part2 = $buff2[0];
		$extension = $buff2[1];

		$part1_length = strlen($part1);
		$part2_length = strlen($part2);

		for ($i = 0; $i < $part1_length; $i++) {
			$part1[$i] = '*';
		}

		for ($i = 0; $i < $part2_length; $i++) {
			$part2[$i] = '*';
		}

		return $part1 . "@" . $part2 . "." . $extension;
	}


	function patientlogin2()
	{


		if ($this->ion_auth->logged_in()) {
			//redirect them to the login page
			redirect('auth/patient');
		}
		$data['title'] = "Login";
		$identity = $this->input->post('identity');
		if (!empty($identity)) {
			$patient = $this->home_model->getPatientById($identity);
			if (!empty($patient)) {
				var_dump($this->ion_auth->logged_in());
				exit();
				$this->session->set_flashdata('message', '<span style="color:green;font-weight: bold;">' . $this->ion_auth->messages() . '</span>');
				redirect("auth/superlogin", 'refresh');

				// $data['user'] = $this->home_model->getUserById($patient->ion_user_id);
				// $data["phone"] = $patient->phone;
				// $data["email"] = $patient->email;
				// $data["id"] = $patient->ion_user_id;
				// $data["password"] = $data['user']->password;
				// // Generation OTP + envoi
				// $random_otp = mt_rand(100000, 999999); // A optimiser
				// $this->db->query("insert into generated_otp (user_id, mobile_number, email, otp, date_created) VALUES(" . $patient->ion_user_id . ", \"" . $patient->phone . "\",\"" . $patient->email . "\",\"" . $random_otp . "\",\"" . time() . "\")");

				// $min_avant_expiration = $this->ion_auth->config->item('otp_expiration', 'ion_auth') / 60;
				// // Envoi SMS par SMS
				// $dataInsert = array(
				// 	'recipient' => $patient->phone,
				// 	// 'message' => $messageprint,
				// 	'message' => "Votre code de vérification valide pour " . $min_avant_expiration . " minutes: " . $random_otp . ". Merci d'utiliser ecoMed24!",
				// 	'date' => time(),
				// 	'user' => $patient->id
				// );
				// $this->sms_model->insertSms($dataInsert);

				// // Envoi par Email
				// $dataInsertEmail = array(
				// 	'reciepient' => $patient->email,
				// 	'subject' => "Code de vérification ecoMed24",
				// 	'message' => "Votre code de vérification valide pour " . $min_avant_expiration . " minutes: " . $random_otp . ". Merci d'utiliser ecoMed24!",
				// 	// 'message' => str_replace($toReplace, $replaceBy, $messageprint2),
				// 	'date' => time(),
				// 	'user' => $patient->ion_user_id
				// );
				// $this->email_model->insertEmail($dataInsertEmail);
				// $data['message'] = $this->error_start_delimiter . "<i class='fa fa-exclamation-triangle' style='font-size:30px;color:red;'></i><p style='width:80%;margin:auto;color:#000;text-align:center;font-size:95%;'>Vous devez vérifier votre identité.<br/>Un code de vérification valide pour " . $min_avant_expiration . " minutes vous a été envoyé par SMS au " . $this->maskAllButLast4($patient->phone) . " et par email à l'adresse " . $this->maskEmail($patient->email) . ".</p>" . $this->error_end_delimiter;
				// $this->_render_page('auth/otp_auth_patient', $data);
			}
		} else {
			$this->_render_page('auth/patientlogin', $data);
		}
	}


	function patientlogin()
	{

		$this->form_validation->set_rules('identity', 'Identity', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');

		if (($this->form_validation->run() == true)) {
			$identity = $this->input->post('identity');
			$patient = $this->home_model->getPatientById($identity);
			if (!empty($patient->patient_id)) {
				$data["email"] = $patient->email;
				$data["patient_id"] = $patient->patient_id;
				$data["id"] = $patient->id;
				$data["password"] = $data['user']->password;
				$random_otp = mt_rand(100000, 999999); // A optimiser
				$this->db->query("insert into generated_otp (user_id, mobile_number, email, otp, date_created) VALUES(" . $patient->id . ", \"" . $patient->phone . "\",\"" . $patient->email . "\",\"" . $random_otp . "\",\"" . time() . "\")");

				$min_avant_expiration = $this->ion_auth->config->item('otp_expiration', 'ion_auth') / 60;
				// Envoi SMS par SMS
				$dataInsert = array(
					'recipient' => $patient->phone,
					// 'message' => $messageprint,
					'message' => "Votre code de vérification valide pour " . $min_avant_expiration . " minutes: " . $random_otp . ". Merci d'utiliser ecoMed24!",
					'date' => time(),
					'user' => $patient->id
				);
				$this->sms_model->insertSms($dataInsert);

				// Envoi par Email
				$dataInsertEmail = array(
					'reciepient' => $patient->email,
					'subject' => "Code de vérification ecoMed24",
					'message' => "Votre code de vérification valide pour " . $min_avant_expiration . " minutes: " . $random_otp . ". Merci d'utiliser ecoMed24!",
					// 'message' => str_replace($toReplace, $replaceBy, $messageprint2),
					'date' => time(),
					'user' => $patient->ion_user_id
				);
				$this->email_model->insertEmail($dataInsertEmail);
				$data['message'] = $this->error_start_delimiter . "<i class='fa fa-exclamation-triangle' style='font-size:30px;color:red;'></i><p style='width:80%;margin:auto;color:#000;text-align:center;font-size:95%;'>Vous devez vérifier votre identité.<br/>Un code de vérification valide pour " . $min_avant_expiration . " minutes vous a été envoyé par SMS au " . $this->maskAllButLast4($patient->phone) . " et par email à l'adresse " . $this->maskEmail($patient->email) . ".</p>" . $this->error_end_delimiter;	
				$this->load->view('auth/otp_auth_patient', $data);
			} else {
				$data['message'] = 'Identifiant du patient incorrect. Merci de rééssayer';
				$this->_render_page('auth/patientlogin', $data);
			}
		} else {
			$data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

			$data['identity'] = array(
				'name' => 'identity',
				'id' => 'identity',
				'type' => 'text',
				'value' => $this->form_validation->set_value('identity'),
			);
			$data['password'] = array(
				'name' => 'password',
				'id' => 'password',
				'type' => 'password',
			);

			$this->_render_page('auth/patientlogin', $data);
		}
	}


	function patientloginconnexion()
	{

		$identity = $this->input->post('identity');
		$patient = $this->home_model->getPatientById($identity);
		$idPatient = $patient->id;
		// if ($this->ion_auth->logged_in()) {
		// 	//redirect them to the login page
		// 	redirect('home/dossierpatient?id=' . $idPatient, 'refresh');
		// }
		$data['title'] = "Login";

		//validate form input
		$this->form_validation->set_rules('identity', 'Identity', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');

		if ($this->form_validation->run() == true) {
			var_dump('test');
			exit();
			//$remember = false;

			$data["email"] = $patient->email;
			$data["id"] = $patient->ion_user_id;
			$data["password"] = $data['user']->password;
			// Generation OTP + envoi
			$random_otp = mt_rand(100000, 999999); // A optimiser
			$this->db->query("insert into generated_otp (user_id, mobile_number, email, otp, date_created) VALUES(" . $patient->ion_user_id . ", \"" . $patient->phone . "\",\"" . $patient->email . "\",\"" . $random_otp . "\",\"" . time() . "\")");

			$min_avant_expiration = $this->ion_auth->config->item('otp_expiration', 'ion_auth') / 60;
			// Envoi SMS par SMS
			$dataInsert = array(
				'recipient' => $patient->phone,
				// 'message' => $messageprint,
				'message' => "Votre code de vérification valide pour " . $min_avant_expiration . " minutes: " . $random_otp . ". Merci d'utiliser ecoMed24!",
				'date' => time(),
				'user' => $patient->id
			);
			$this->sms_model->insertSms($dataInsert);

			// Envoi par Email
			$dataInsertEmail = array(
				'reciepient' => $patient->email,
				'subject' => "Code de vérification ecoMed24",
				'message' => "Votre code de vérification valide pour " . $min_avant_expiration . " minutes: " . $random_otp . ". Merci d'utiliser ecoMed24!",
				// 'message' => str_replace($toReplace, $replaceBy, $messageprint2),
				'date' => time(),
				'user' => $patient->ion_user_id
			);
			$this->email_model->insertEmail($dataInsertEmail);
			$data['message'] = $this->error_start_delimiter . "<i class='fa fa-exclamation-triangle' style='font-size:30px;color:red;'></i><p style='width:80%;margin:auto;color:#000;text-align:center;font-size:95%;'>Vous devez vérifier votre identité.<br/>Un code de vérification valide pour " . $min_avant_expiration . " minutes vous a été envoyé par SMS au " . $this->maskAllButLast4($patient->phone) . " et par email à l'adresse " . $this->maskEmail($patient->email) . ".</p>" . $this->error_end_delimiter;
			$this->_render_page('auth/otp_auth_patient', $data);





			// if ($this->ion_auth->appointmentcenterlogin($this->input->post('identity'), $this->input->post('password'), $remember)) {
			// 	//if the login is successful
			// 	//redirect them back to the home page
			// 	var_dump('home/dossierpatient?id=' . $idPatient);
			// 	exit();
			// 	$this->session->set_flashdata('message', $this->ion_auth->messages());
			// 	redirect('home/dossierpatient?id=' . $idPatient, 'refresh');
			// 	// redirect('https://www.phptpoint.com/codeigniter-session/', 'refresh');
			// } else {
			// 	//if the login was un-successful
			// 	//redirect them back to the login page
			// 	$this->session->set_flashdata('message', $this->ion_auth->errors());
			// 	redirect('auth/appointmentcenterlogin', 'refresh'); //use redirects instead of loading views for compatibility with MY_Controller libraries
			// }
		} else {
			//the user is not logging in so display the login page
			//set the flash data error message if there is one
			$data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

			$data['identity'] = array(
				'name' => 'identity',
				'id' => 'identity',
				'type' => 'text',
				'value' => $this->form_validation->set_value('identity'),
			);
			$data['password'] = array(
				'name' => 'password',
				'id' => 'password',
				'type' => 'password',
			);

			$this->_render_page('auth/appointmentcenterlogin', $data);
		}
	}

	function appointmentcenterlogin()
	{
		$identity = $this->input->post('identity');
		$patient = $this->home_model->getPatientById($identity);
		$idPatient = $patient->id;
		$dossier = 'dossier';
		if ($this->ion_auth->logged_in()) {
			//redirect them to the login page
			redirect('patient/medicalHistory?id=' . $idPatient . '&dossier=' . $dossier);
		}
		$data['title'] = "Login";

		//validate form input
		$this->form_validation->set_rules('identity', 'Identity', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');

		if ($this->form_validation->run() == true) {
			//check to see if the user is logging in
			//check for "remember me"
			// $remember = (bool) $this->input->post('remember');
			$remember = false;

			if ($this->ion_auth->appointmentcenterlogin($this->input->post('identity'), $this->input->post('password'), $remember)) {
				//if the login is successful
				//redirect them back to the home page
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				redirect('patient/medicalHistory?id=' . $idPatient . '&dossier=' . $dossier, 'refresh');
				// redirect('https://www.phptpoint.com/codeigniter-session/', 'refresh');
			} else {
				//if the login was un-successful
				//redirect them back to the login page
				$this->session->set_flashdata('message', $this->ion_auth->errors());
				redirect('auth/appointmentcenterlogin', 'refresh'); //use redirects instead of loading views for compatibility with MY_Controller libraries
			}
		} else {
			//the user is not logging in so display the login page
			//set the flash data error message if there is one
			$data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

			$data['identity'] = array(
				'name' => 'identity',
				'id' => 'identity',
				'type' => 'text',
				'value' => $this->form_validation->set_value('identity'),
			);
			$data['password'] = array(
				'name' => 'password',
				'id' => 'password',
				'type' => 'password',
			);

			$this->_render_page('auth/appointmentcenterlogin', $data);
		}
	}

	function patientloginbackup()
	{

		if ($this->ion_auth->logged_in()) {
			//redirect them to the login page
			redirect('auth/appointmentcenterlogin');
		}
		$data['title'] = "Login";

		//validate form input
		$this->form_validation->set_rules('identity', 'Identity', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');

		if ($this->form_validation->run() == true) {
			//check to see if the user is logging in
			//check for "remember me"
			// $remember = (bool) $this->input->post('remember');
			$remember = false;

			if ($this->ion_auth->patientcenterlogin($this->input->post('identity'), $this->input->post('password'), $remember)) {
				//if the login is successful
				//redirect them back to the home page
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				redirect('home/appointmentcenterhome', 'refresh');
				// redirect('https://www.phptpoint.com/codeigniter-session/', 'refresh');
			} else {
				//if the login was un-successful
				//redirect them back to the login page
				$this->session->set_flashdata('message', $this->ion_auth->errors());
				redirect('auth/appointmentcenterlogin', 'refresh'); //use redirects instead of loading views for compatibility with MY_Controller libraries
			}
		} else {
			//the user is not logging in so display the login page
			//set the flash data error message if there is one
			$data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

			$data['identity'] = array(
				'name' => 'identity',
				'id' => 'identity',
				'type' => 'text',
				'value' => $this->form_validation->set_value('identity'),
			);
			$data['password'] = array(
				'name' => 'password',
				'id' => 'password',
				'type' => 'password',
			);

			$this->_render_page('auth/appointmentcenterlogin', $data);
		}
	}

	//log the user out
	function logout()
	{
		$data['title'] = "Logout";

		//log the user out
		$logout = $this->ion_auth->logout();

		//redirect them to the login page
		$this->session->set_flashdata('message', $this->ion_auth->messages());
		redirect('auth/login', 'refresh');
	}

	//change password
	function change_password()
	{
		$this->form_validation->set_rules('old', $this->lang->line('change_password_validation_old_password_label'), 'required');
		$this->form_validation->set_rules('new', $this->lang->line('change_password_validation_new_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[new_confirm]');
		$this->form_validation->set_rules('new_confirm', $this->lang->line('change_password_validation_new_password_confirm_label'), 'required');

		if (!$this->ion_auth->logged_in()) {
			redirect('auth/login', 'refresh');
		}

		$user = $this->ion_auth->user()->row();

		if ($this->form_validation->run() == false) {
			//display the form
			//set the flash data error message if there is one
			$data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

			$data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
			$data['pattern'] = $this->config->item('pwd_pattern', 'ion_auth');
			$data['old_password'] = array(
				'name' => 'old',
				'id'   => 'old',
				'type' => 'password',
			);
			$data['new_password'] = array(
				'name' => 'new',
				'id'   => 'new',
				'type' => 'password',
				'pattern' => '^.{' . $data['min_password_length'] . '}.*$',
			);
			$data['new_password_confirm'] = array(
				'name' => 'new_confirm',
				'id'   => 'new_confirm',
				'type' => 'password',
				'pattern' => '^.{' . $data['min_password_length'] . '}.*$',
			);
			$data['user_id'] = array(
				'name'  => 'user_id',
				'id'    => 'user_id',
				'type'  => 'hidden',
				'value' => $user->id,
			);

			//render
			$this->_render_page('auth/change_password', $data);
		} else {
			$identity = $this->session->userdata('identity');

			$change = $this->ion_auth->change_password($identity, $this->input->post('old'), $this->input->post('new'));

			if ($change) {
				//if the password was successfully changed
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				$this->logout();
			} else {
				$this->session->set_flashdata('message', $this->ion_auth->errors());
				redirect('auth/change_password', 'refresh');
			}
		}
	}

	function resend_otp()
	{

		$id = $this->input->get("id");
		$phone = $this->input->get("phone");
		$email = $this->input->get("email");

		// Generation OTP + envoi
		$random_otp = mt_rand(100000, 999999); // A optimiser
		$this->db->query("insert into generated_otp (user_id, mobile_number, email, otp, date_created) VALUES(" . $id . ", \"" . $phone . "\",\"" . $email . "\",\"" . $random_otp . "\",\"" . time() . "\")");

		$min_avant_expiration = $this->ion_auth->config->item('otp_expiration', 'ion_auth') / 60;

		// Envoi SMS par SMS
		$dataInsert = array(
			'recipient' => $phone,
			// 'message' => $messageprint,
			'message' => "Votre code de vérification valide pour " . $min_avant_expiration . " minutes: " . $random_otp . ". Merci d'utiliser ecoMed24!",
			'date' => time(),
			'user' => $id
		);
		$this->sms_model->insertSms($dataInsert);

		// Envoi par Email
		$dataInsertEmail = array(
			'reciepient' => $email,
			'subject' => "Code de vérification ecoMed24",
			'message' => "Votre code de vérification valide pour " . $min_avant_expiration . " minutes: " . $random_otp . ". Merci d'utiliser ecoMed24!",
			// 'message' => str_replace($toReplace, $replaceBy, $messageprint2),
			'date' => time(),
			'user' => $id
		);
		$this->email_model->insertEmail($dataInsertEmail);

		$data["message"] = "<i class='fa fa-exclamation-triangle' style='font-size:30px;color:green;'></i><p style='width:80%;margin:auto;color:#000;text-align:center;font-size:95%;'>Un nouveau code de vérification vous a été envoyé.</p>";

		echo json_encode($data);
	}

	function otp_auth()
	{
		$otp = $this->input->post('otp');
		$phone = $this->input->post('phone');
		$email = $this->input->post('email');
		$password = $this->input->post('password');
		$id = $this->input->post('id');

		// echo "<script language=\"javascript\">alert(\"".$otp."\");</script>";
		// echo "<script language=\"javascript\">alert(\"".$phone."\");</script>";
		// echo "<script language=\"javascript\">alert(\"".$email."\");</script>";
		// echo "<script language=\"javascript\">alert(\"".$password."\");</script>";
		// echo "<script language=\"javascript\">alert(\"".$id."\");</script>";
		$this->form_validation->set_rules('otp', 'OTP', 'trim|required|min_length[6]|max_length[6]|xss_clean');

		if ($this->form_validation->run() == false) {
			$data["message"] = "<i class='fa fa-exclamation-triangle' style='font-size:30px;color:red;'></i><p style='width:80%;margin:auto;color:#000;text-align:center;font-size:95%;'>Le format du code de vérification est incorrect.</p>";
			$data["phone"] = $phone;
			$data["email"] = $email;
			$data["password"] = $password;
			$data["id"] = $id;
			$this->_render_page('auth/otp_auth', $data);
		} else {

			// Check validité du OTP saisi
			// $found = $this->db->query("select count(id) as total_matches from generated_otp where user_id = ".$id." and otp=\"".$otp."\" and is_valid")->row()->total_matches;
			$row = $this->db->query("select id, (unix_timestamp() - date_created) as time_since_generation from generated_otp where user_id = " . $id . " and otp=\"" . $otp . "\" and !for_patient_record and is_valid")->row();
			$found = $row->id;
			$time_since_generation = $row->time_since_generation;
			// $time_before_expiration = 15*60;
			$time_before_expiration = $this->ion_auth->config->item('otp_expiration', 'ion_auth');
			if ($found) {
				if ($time_since_generation <= $time_before_expiration) { // OTP pas encore expiré

					if ($this->ion_auth->is_time_locked_out($email)) // On check d'abord s'il n'est pas actuellement bloqué
					{
						//Hash something anyway, just to take up time
						$this->ion_auth->hash_password($password);

						$temps_blocage = $this->ion_auth->config->item('lockout_time', 'ion_auth') / 60;
						$maximum_login_attempts = $this->ion_auth->config->item('maximum_login_attempts', 'ion_auth');
						// $data["message"] = "<i class='fa fa-exclamation-triangle' style='font-size:30px;color:red;'></i><p style='width:80%;margin:auto;color:#000;text-align:center;font-size:95%;'>Vous avez atteint le nombre maximum de tentatives autorisé. Votre compte est temporairement bloqué.</p>";
						$data["message"] = "<i class='fa fa-exclamation-triangle' style='font-size:30px;color:red;'></i><p style='width:80%;margin:auto;color:#000;text-align:center;font-size:95%;'>Suite à vos " . $maximum_login_attempts . " tentatives avec un code erroné, votre compte est temporairement bloqué. Merci de patienter " . $temps_blocage . " minutes puis de cliquer sur Renvoyer le code.</p>";
						$data["phone"] = $phone;
						$data["email"] = $email;
						$data["password"] = $password;
						$data["id"] = $id;
						$this->_render_page('auth/otp_auth', $data);
						return false; // Pour sortir
					}

					// echo "<script language=\"javascript\">alert(\"Here I am still 2\");</script>";
					// Si OTP OK
					// Mise à jour otp_validated
					$this->db->query("update users set otp_validated = 1 where id = " . $id);
					$this->db->query("update generated_otp set is_valid = 0 where user_id = " . $id . " and otp = \"" . $otp . "\" and !for_patient_record");

					// echo "<script language=\"javascript\">alert(\"Here I am still 3\");</script>";
					// Nouvelle tentative de connexion
					$login_outcome = $this->ion_auth->login($email, $password);
					if (!is_array($login_outcome)) {
						$login_success = $login_outcome;

						// echo "<script language=\"javascript\">alert(\"Here I am still 4\");</script>";
					}
					if ($login_success) { // Redirection vers index() (pour accès ensuite à home)
						//if the login is successful
						//redirect them back to the home page
						$this->session->set_flashdata('message', $this->ion_auth->messages());

						// echo "<script language=\"javascript\">alert(\"Here I am still 5\");</script>";
						redirect('/', 'refresh');
					}
				} else { // OTP expiré
					$data["message"] = "<i class='fa fa-exclamation-triangle' style='font-size:30px;color:red;'></i><p style='width:80%;margin:auto;color:#000;text-align:center;font-size:95%;'>Le code de vérification a expiré. Merci de cliquer sur le bouton Renvoyer le code.</p>";
					$data["phone"] = $phone;
					$data["email"] = $email;
					$data["password"] = $password;
					$data["id"] = $id;
					$this->_render_page('auth/otp_auth', $data);
				}
			} else {

				if ($this->ion_auth->is_time_locked_out($email)) // Si 3 atteints (déjà aavant du clic)
				{
					//Hash something anyway, just to take up time
					$this->ion_auth->hash_password($password);


					$temps_blocage = $this->ion_auth->config->item('lockout_time', 'ion_auth') / 60;
					$maximum_login_attempts = $this->ion_auth->config->item('maximum_login_attempts', 'ion_auth');
					// $temps_blocage_restant = time() - $this->ion_auth->get_last_attempt_time($email); Brouillon: à finir
					// $data["message"] = "<i class='fa fa-exclamation-triangle' style='font-size:30px;color:red;'></i><p style='width:80%;margin:auto;color:#000;text-align:center;font-size:95%;'>Vous avez atteint le nombre maximum de tentatives autorisé. Votre compte est temporairement bloqué.</p>";
					$data["message"] = "<i class='fa fa-exclamation-triangle' style='font-size:30px;color:red;'></i><p style='width:80%;margin:auto;color:#000;text-align:center;font-size:95%;'>Suite à vos " . $maximum_login_attempts . " tentatives avec un code erroné, votre compte est temporairement bloqué. Merci de patienter " . $temps_blocage . " minutes puis de cliquer sur Renvoyer le code.</p>";
				} else { // Sinon	

					if ($this->ion_auth->get_last_attempt_time($email) < (time() - $this->ion_auth->config->item('lockout_time', 'ion_auth'))) // Si pas d'essai récent
					{
						$this->ion_auth->clear_login_attempts($email); // On vide les tentatives anciennes
					}
					// Increase login_attempts
					$this->ion_auth->increase_login_attempts($email);
					if ($this->ion_auth->is_time_locked_out($email)) // Si 3 atteints (déjà aavant du clic)
					{
						$temps_blocage = $this->ion_auth->config->item('lockout_time', 'ion_auth') / 60;
						$maximum_login_attempts = $this->ion_auth->config->item('maximum_login_attempts', 'ion_auth');
						// $temps_blocage_restant = $temps_blocage - $this->ion_auth->get_last_attempt_time($email); // Brouillon
						// $data["message"] = "<i class='fa fa-exclamation-triangle' style='font-size:30px;color:red;'></i><p style='width:80%;margin:auto;color:#000;text-align:center;font-size:95%;'>Vous avez atteint le nombre maximum de tentatives autorisé. Votre compte est temporairement bloqué.</p>";
						$data["message"] = "<i class='fa fa-exclamation-triangle' style='font-size:30px;color:red;'></i><p style='width:80%;margin:auto;color:#000;text-align:center;font-size:95%;'>Suite à vos " . $maximum_login_attempts . " tentatives avec un code erroné, votre compte est temporairement bloqué. Merci de patienter " . $temps_blocage . " minutes puis de cliquer sur Renvoyer le code.</p>";
					} else {
						$data["message"] = "<i class='fa fa-exclamation-triangle' style='font-size:30px;color:red;'></i><p style='width:80%;margin:auto;color:#000;text-align:center;font-size:95%;'>Le code de vérification saisi est incorrect. Merci de rééssayer.</p>";
					}
				}
				$data["phone"] = $phone;
				$data["email"] = $email;
				$data["password"] = $password;
				$data["id"] = $id;
				$this->_render_page('auth/otp_auth', $data);
			}
		}
	}

	function otp_auth_patient()
	{
		$otp = $this->input->post('otp');
		$phone = $this->input->post('phone');
		$email = $this->input->post('email');
		$password = $this->input->post('password');
		$id = $this->input->post('id');
		$patient_id = $this->input->post('patient_id');
		$remember = (bool) $this->input->post('remember');
		$dossier = 'dossier';
		// echo "<script language=\"javascript\">alert(\"".$otp."\");</script>";
		// echo "<script language=\"javascript\">alert(\"".$phone."\");</script>";
		// echo "<script language=\"javascript\">alert(\"".$email."\");</script>";
		// echo "<script language=\"javascript\">alert(\"".$password."\");</script>";
		// echo "<script language=\"javascript\">alert(\"".$id."\");</script>";
		$this->form_validation->set_rules('otp', 'OTP', 'trim|required|min_length[6]|max_length[6]|xss_clean');

		if ($this->form_validation->run() == false) {
			$data["message"] = "<i class='fa fa-exclamation-triangle' style='font-size:30px;color:red;'></i><p style='width:80%;margin:auto;color:#000;text-align:center;font-size:95%;'>Le format du code de vérification est incorrect.</p>";
			$data["phone"] = $phone;
			$data["email"] = $email;
			$data["password"] = $password;
			$data["id"] = $id;
			$this->_render_page('auth/patientlogin', $data);
		} else {

			// Check validité du OTP saisi
			// $found = $this->db->query("select count(id) as total_matches from generated_otp where user_id = ".$id." and otp=\"".$otp."\" and is_valid")->row()->total_matches;
			$row = $this->db->query("select id, (unix_timestamp() - date_created) as time_since_generation from generated_otp where user_id = " . $id . " and otp=\"" . $otp . "\" and !for_patient_record and is_valid")->row();
			if(empty($row)){
				$data["message"] = "<i class='fa fa-exclamation-triangle' style='font-size:30px;color:red;'></i><p style='width:80%;margin:auto;color:#000;text-align:center;font-size:95%;'>Le code de vérification saisi est incorrect. Merci de rééssayer.</p>";
				$data["phone"] = $phone;
				$data["email"] = $email;
				$data["password"] = $password;
				$data["id"] = $id;
				$data["patient_id"] = $patient_id;
			}
			$found = $row->id;
			$time_since_generation = $row->time_since_generation;
			// $time_before_expiration = 15*60;
			$time_before_expiration = $this->ion_auth->config->item('otp_expiration', 'ion_auth');
			if ($found) {
				if ($time_since_generation <= $time_before_expiration) { // OTP pas encore expiré
					$this->db->query("update users set otp_validated = 1 where id = " . $id);
					$this->db->query("update generated_otp set is_valid = 0 where user_id = " . $id . " and otp = \"" . $otp . "\" and !for_patient_record");

					// echo "<script language=\"javascript\">alert(\"Here I am still 3\");</script>";
					// Nouvelle tentative de connexion
					$login_outcome = $this->ion_auth->appointmentcenterlogin($patient_id, $this->input->post('password'), $remember);
					if (!is_array($login_outcome)) {
						$login_success = $login_outcome;

						// echo "<script language=\"javascript\">alert(\"Here I am still 4\");</script>";
					}
					if ($login_success) { // Redirection vers index() (pour accès ensuite à home)
						//if the login is successful
						//redirect them back to the home page
						$this->session->set_flashdata('message', $this->ion_auth->messages());
						redirect('patient/medicalHistory?id=' . $id . '&dossier=' . $dossier, 'refresh');
					}
				} else { // OTP expiré
					$data["message"] = "<i class='fa fa-exclamation-triangle' style='font-size:30px;color:red;'></i><p style='width:80%;margin:auto;color:#000;text-align:center;font-size:95%;'>Le code de vérification a expiré. Merci de cliquer sur le bouton Renvoyer le code.</p>";
					$data["phone"] = $phone;
					$data["email"] = $email;
					$data["password"] = $password;
					$data["id"] = $id;
					$data["patient_id"] = $patient_id;
				//	$this->_render_page('auth/otp_auth_patient', $data);
				}
			} else {

				if ($this->ion_auth->is_time_locked_out($email)) // Si 3 atteints (déjà aavant du clic)
				{
					//Hash something anyway, just to take up time
					$this->ion_auth->hash_password($password);


					$temps_blocage = $this->ion_auth->config->item('lockout_time', 'ion_auth') / 60;
					$maximum_login_attempts = $this->ion_auth->config->item('maximum_login_attempts', 'ion_auth');
					// $temps_blocage_restant = time() - $this->ion_auth->get_last_attempt_time($email); Brouillon: à finir
					// $data["message"] = "<i class='fa fa-exclamation-triangle' style='font-size:30px;color:red;'></i><p style='width:80%;margin:auto;color:#000;text-align:center;font-size:95%;'>Vous avez atteint le nombre maximum de tentatives autorisé. Votre compte est temporairement bloqué.</p>";
					$data["message"] = "<i class='fa fa-exclamation-triangle' style='font-size:30px;color:red;'></i><p style='width:80%;margin:auto;color:#000;text-align:center;font-size:95%;'>Suite à vos " . $maximum_login_attempts . " tentatives avec un code erroné, votre compte est temporairement bloqué. Merci de patienter " . $temps_blocage . " minutes puis de cliquer sur Renvoyer le code.</p>";
				} else { // Sinon	

					if ($this->ion_auth->get_last_attempt_time($email) < (time() - $this->ion_auth->config->item('lockout_time', 'ion_auth'))) // Si pas d'essai récent
					{
						$this->ion_auth->clear_login_attempts($email); // On vide les tentatives anciennes
					}
					// Increase login_attempts
					$this->ion_auth->increase_login_attempts($email);
					if ($this->ion_auth->is_time_locked_out($email)) // Si 3 atteints (déjà aavant du clic)
					{
						$temps_blocage = $this->ion_auth->config->item('lockout_time', 'ion_auth') / 60;
						$maximum_login_attempts = $this->ion_auth->config->item('maximum_login_attempts', 'ion_auth');
						// $temps_blocage_restant = $temps_blocage - $this->ion_auth->get_last_attempt_time($email); // Brouillon
						// $data["message"] = "<i class='fa fa-exclamation-triangle' style='font-size:30px;color:red;'></i><p style='width:80%;margin:auto;color:#000;text-align:center;font-size:95%;'>Vous avez atteint le nombre maximum de tentatives autorisé. Votre compte est temporairement bloqué.</p>";
						$data["message"] = "<i class='fa fa-exclamation-triangle' style='font-size:30px;color:red;'></i><p style='width:80%;margin:auto;color:#000;text-align:center;font-size:95%;'>Suite à vos " . $maximum_login_attempts . " tentatives avec un code erroné, votre compte est temporairement bloqué. Merci de patienter " . $temps_blocage . " minutes puis de cliquer sur Renvoyer le code.</p>";
					} else {
						$data["message"] = "<i class='fa fa-exclamation-triangle' style='font-size:30px;color:red;'></i><p style='width:80%;margin:auto;color:#000;text-align:center;font-size:95%;'>Le code de vérification saisi est incorrect. Merci de rééssayer.</p>";
					}
				}
				$data["phone"] = $phone;
				$data["email"] = $email;
				$data["password"] = $password;
				$data["id"] = $id;
				$this->_render_page('auth/otp_auth_patient', $data);
			}
		}
	}


	

	//forgot password
	function forgot_password()
	{
		//setting validation rules by checking wheather identity is username or email
		if ($this->config->item('identity', 'ion_auth') == 'username') {
			$this->form_validation->set_rules('email', $this->lang->line('forgot_password_username_identity_label'), 'required');
		} else {
			$this->form_validation->set_rules('email', $this->lang->line('forgot_password_validation_email_label'), 'required|valid_email');
		}


		if ($this->form_validation->run() == false) {
			//setup the input
			$data['email'] = array(
				'name' => 'email',
				'id' => 'email',
			);

			if ($this->config->item('identity', 'ion_auth') == 'username') {
				$data['identity_label'] = $this->lang->line('forgot_password_username_identity_label');
			} else {
				$data['identity_label'] = $this->lang->line('forgot_password_email_identity_label');
			}

			//set any errors and display the form
			$data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
			$this->_render_page('auth/forgot_password', $data);
		} else {
			// get identity from username or email
			if ($this->config->item('identity', 'ion_auth') == 'username') {
				$identity = $this->ion_auth->where('username', strtolower($this->input->post('email')))->users()->row();
			} else {
				$identity = $this->ion_auth->where('email', strtolower($this->input->post('email')))->users()->row();
			}

			if (empty($identity)) {

				if ($this->config->item('identity', 'ion_auth') == 'username') {
					$this->ion_auth->set_message('forgot_password_username_not_found');
				} else {
					$this->ion_auth->set_message('forgot_password_email_not_found');
				}

				$this->session->set_flashdata('message', $this->ion_auth->messages());
				redirect("auth/forgot_password", 'refresh');
			}

			//run the forgotten password method to email an activation code to the user
			$forgotten = $this->ion_auth->forgotten_password($identity->{$this->config->item('identity', 'ion_auth')});

			if ($forgotten) {
				//if there were no errors
				$this->session->set_flashdata('message', '<span style="color:green;font-weight: bold;">' . $this->ion_auth->messages() . '</span>');
				redirect("auth/login", 'refresh'); //we should display a confirmation page here instead of the login page
			} else {
				$this->session->set_flashdata('message', $this->ion_auth->errors());
				redirect("auth/forgot_password", 'refresh');
			}
		}
	}


	//reset password - final step for forgotten password
	public function reset_password($code = NULL)
	{

		if (!$code) {
			show_404();
		}

		$user = $this->ion_auth->forgotten_password_check($code);

		if ($user) {
			//if the code is valid then display the password reset form

			//$this->form_validation->set_rules('new', $this->lang->line('reset_password_validation_new_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[new_confirm]');
			$this->form_validation->set_rules('new', $this->lang->line('reset_password_validation_new_password_label'), 'required|matches[new_confirm]');
			$this->form_validation->set_rules('new_confirm', $this->lang->line('reset_password_validation_new_password_confirm_label'), 'required');

			if ($this->form_validation->run() == false) {
				//display the form

				//set the flash data error message if there is one
				$data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message', '<span style="color:green;font-weight: bold;">' . $this->ion_auth->messages());

				$data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
				$data['pattern'] = $this->config->item('pwd_pattern', 'ion_auth');
				/*$data['new_password'] = array(
					'name' => 'new',
					'id'   => 'new',
				'type' => 'password',
					'pattern' => $data['pattern'],
				);
				$data['new_password_confirm'] = array(
					'name' => 'new_confirm',
					'id'   => 'new_confirm',
					'type' => 'password',
					'pattern' => $data['pattern'],
				);
				$data['user_id'] = array(
					'name'  => 'user_id',
					'id'    => 'user_id',
					'type'  => 'hidden',
					'value' => $user->id,
				);*/

				$data['user_id'] = $user->id;
				$data['csrf'] = $this->_get_csrf_nonce();
				$data['code'] = $code;

				//render
				$this->_render_page('auth/reset_password', $data);
			} else {
				// do we have a valid request?
				if ($this->_valid_csrf_nonce() === FALSE || $user->id != $this->input->post('user_id')) {

					//something fishy might be up
					$this->ion_auth->clear_forgotten_password_code($code);

					//show_error($this->lang->line('error_csrf'));
					$this->session->set_flashdata('message', $this->lang->line('error_csrf'));
					redirect("auth/forgot_password", 'refresh');
				} else {
					$pattern = $data['pattern'];
					if (!preg_match($pattern, $this->input->post('new'))) {
						// finally change the password
						$identity = $user->{$this->config->item('identity', 'ion_auth')};
						$change = $this->ion_auth->reset_password($identity, $this->input->post('new'));
						if ($change) {
							//if the password was successfully changed
							$this->session->set_flashdata('message', '<span style="color:green;font-weight: bold;">' . $this->ion_auth->messages() . '</span>');
							redirect("auth/login", 'refresh');
						} else {
							$this->session->set_flashdata('message', $this->ion_auth->errors());
							redirect('auth/reset_password/' . $code, 'refresh');
						}
					} else {
						$this->session->set_flashdata('message', lang('format_password_new_password'));
						redirect('auth/reset_password/' . $code, 'refresh');
					}
				}
			}
		} else {
			//if the code is invalid then send them back to the forgot password page
			$this->session->set_flashdata('message', $this->ion_auth->errors());
			redirect("auth/forgot_password", 'refresh');
		}
	}


	//activate the user
	function activate($id, $code = false)
	{
		if ($code !== false) {
			$activation = $this->ion_auth->activate($id, $code);
		} else if ($this->ion_auth->is_admin()) {
			$activation = $this->ion_auth->activate($id);
		}

		if ($activation) {
			//redirect them to the auth page
			/*$this->session->set_flashdata('message', $this->ion_auth->messages());
			redirect("auth", 'refresh');*/
			$this->ion_auth->activateresetpwd($id, $code);
			$this->reset_password($code);
		} else {
			//redirect them to the forgot password page
			$this->session->set_flashdata('message', $this->ion_auth->errors());
			redirect("auth/forgot_password", 'refresh');
		}
	}

	//deactivate the user
	function deactivate($id = NULL)
	{
		if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin()) {
			//redirect them to the home page because they must be an administrator to view this
			return show_error('You must be an administrator to view this page.');
		}

		$id = (int) $id;

		$this->load->library('form_validation');
		$this->form_validation->set_rules('confirm', $this->lang->line('deactivate_validation_confirm_label'), 'required');
		$this->form_validation->set_rules('id', $this->lang->line('deactivate_validation_user_id_label'), 'required|alpha_numeric');

		if ($this->form_validation->run() == FALSE) {
			// insert csrf check
			$data['csrf'] = $this->_get_csrf_nonce();
			$data['user'] = $this->ion_auth->user($id)->row();

			$this->_render_page('auth/deactivate_user', $data);
		} else {
			// do we really want to deactivate?
			if ($this->input->post('confirm') == 'yes') {
				// do we have a valid request?
				if ($this->_valid_csrf_nonce() === FALSE || $id != $this->input->post('id')) {
					show_error($this->lang->line('error_csrf'));
				}

				// do we have the right userlevel?
				if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
					$this->ion_auth->deactivate($id);
				}
			}

			//redirect them back to the auth page
			redirect('auth', 'refresh');
		}
	}

	//create a new user
	function create_user()
	{
		$data['title'] = "Create User";

		if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin()) {
			redirect('auth', 'refresh');
		}

		$tables = $this->config->item('tables', 'ion_auth');

		//validate form input
		$this->form_validation->set_rules('first_name', $this->lang->line('create_user_validation_fname_label'), 'required');
		$this->form_validation->set_rules('last_name', $this->lang->line('create_user_validation_lname_label'));
		$this->form_validation->set_rules('email', $this->lang->line('create_user_validation_email_label'), 'required|valid_email|is_unique[' . $tables['users'] . '.email]');
		$this->form_validation->set_rules('phone', $this->lang->line('create_user_validation_phone_label'), 'required');
		$this->form_validation->set_rules('company', $this->lang->line('create_user_validation_company_label'));
		$this->form_validation->set_rules('password', $this->lang->line('create_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
		$this->form_validation->set_rules('password_confirm', $this->lang->line('create_user_validation_password_confirm_label'), 'required');

		if ($this->form_validation->run() == true) {
			$username = strtolower($this->input->post('first_name')) . ' ' . strtolower($this->input->post('last_name'));
			$email    = strtolower($this->input->post('email'));
			$password = $this->input->post('password');

			$additional_data = array(
				'first_name' => $this->input->post('first_name'),
				'last_name'  => $this->input->post('last_name'),
				'company'    => $this->input->post('company'),
				'phone'      => $this->input->post('phone'),
			);
		}
		if ($this->form_validation->run() == true && $this->ion_auth->register($username, $password, $email, $additional_data)) {
			//check to see if we are creating the user
			//redirect them back to the admin page
			$this->session->set_flashdata('message', $this->ion_auth->messages());
			redirect("auth", 'refresh');
		} else {
			//display the create user form
			//set the flash data error message if there is one
			$data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

			$data['first_name'] = array(
				'name'  => 'first_name',
				'id'    => 'first_name',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('first_name'),
			);
			$data['last_name'] = array(
				'name'  => 'last_name',
				'id'    => 'last_name',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('last_name'),
			);
			$data['email'] = array(
				'name'  => 'email',
				'id'    => 'email',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('email'),
			);
			$data['company'] = array(
				'name'  => 'company',
				'id'    => 'company',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('company'),
			);
			$data['phone'] = array(
				'name'  => 'phone',
				'id'    => 'phone',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('phone'),
			);
			$data['password'] = array(
				'name'  => 'password',
				'id'    => 'password',
				'type'  => 'password',
				'value' => $this->form_validation->set_value('password'),
			);
			$data['password_confirm'] = array(
				'name'  => 'password_confirm',
				'id'    => 'password_confirm',
				'type'  => 'password',
				'value' => $this->form_validation->set_value('password_confirm'),
			);

			$this->_render_page('auth/create_user', $data);
		}
	}

	//edit a user
	function edit_user($id)
	{
		$data['title'] = "Edit User";

		if (!$this->ion_auth->logged_in() || (!$this->ion_auth->is_admin() && !($this->ion_auth->user()->row()->id == $id))) {
			redirect('auth', 'refresh');
		}

		$user = $this->ion_auth->user($id)->row();
		$groups = $this->ion_auth->groups()->result_array();
		$currentGroups = $this->ion_auth->get_users_groups($id)->result();

		//validate form input
		$this->form_validation->set_rules('first_name', $this->lang->line('edit_user_validation_fname_label'), 'required');
		$this->form_validation->set_rules('last_name', $this->lang->line('edit_user_validation_lname_label'), 'required');
		$this->form_validation->set_rules('phone', $this->lang->line('edit_user_validation_phone_label'), 'required');
		$this->form_validation->set_rules('company', $this->lang->line('edit_user_validation_company_label'), 'required');

		if (isset($_POST) && !empty($_POST)) {
			// do we have a valid request?
			if ($this->_valid_csrf_nonce() === FALSE || $id != $this->input->post('id')) {
				show_error($this->lang->line('error_csrf'));
			}

			//update the password if it was posted
			if ($this->input->post('password')) {
				$this->form_validation->set_rules('password', $this->lang->line('edit_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
				$this->form_validation->set_rules('password_confirm', $this->lang->line('edit_user_validation_password_confirm_label'), 'required');
			}

			if ($this->form_validation->run() === TRUE) {
				$data = array(
					'first_name' => $this->input->post('first_name'),
					'last_name'  => $this->input->post('last_name'),
					'company'    => $this->input->post('company'),
					'phone'      => $this->input->post('phone'),
				);

				//update the password if it was posted
				if ($this->input->post('password')) {
					$data['password'] = $this->input->post('password');
				}



				// Only allow updating groups if user is admin
				if ($this->ion_auth->is_admin()) {
					//Update the groups user belongs to
					$groupData = $this->input->post('groups');

					if (isset($groupData) && !empty($groupData)) {

						$this->ion_auth->remove_from_group('', $id);

						foreach ($groupData as $grp) {
							$this->ion_auth->add_to_group($grp, $id);
						}
					}
				}

				//check to see if we are updating the user
				if ($this->ion_auth->update($user->id, $data)) {
					//redirect them back to the admin page if admin, or to the base url if non admin
					$this->session->set_flashdata('message', $this->ion_auth->messages());
					if ($this->ion_auth->is_admin()) {
						redirect('auth', 'refresh');
					} else {
						redirect('/', 'refresh');
					}
				} else {
					//redirect them back to the admin page if admin, or to the base url if non admin
					$this->session->set_flashdata('message', $this->ion_auth->errors());
					if ($this->ion_auth->is_admin()) {
						redirect('auth', 'refresh');
					} else {
						redirect('/', 'refresh');
					}
				}
			}
		}

		//display the edit user form
		$data['csrf'] = $this->_get_csrf_nonce();

		//set the flash data error message if there is one
		$data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

		//pass the user to the view
		$data['user'] = $user;
		$data['groups'] = $groups;
		$data['currentGroups'] = $currentGroups;

		$data['first_name'] = array(
			'name'  => 'first_name',
			'id'    => 'first_name',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('first_name', $user->first_name),
		);
		$data['last_name'] = array(
			'name'  => 'last_name',
			'id'    => 'last_name',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('last_name', $user->last_name),
		);
		$data['company'] = array(
			'name'  => 'company',
			'id'    => 'company',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('company', $user->company),
		);
		$data['phone'] = array(
			'name'  => 'phone',
			'id'    => 'phone',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('phone', $user->phone),
		);
		$data['password'] = array(
			'name' => 'password',
			'id'   => 'password',
			'type' => 'password'
		);
		$data['password_confirm'] = array(
			'name' => 'password_confirm',
			'id'   => 'password_confirm',
			'type' => 'password'
		);

		$this->_render_page('auth/edit_user', $data);
	}

	// create a new group
	function create_group()
	{
		$data['title'] = $this->lang->line('create_group_title');

		if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin()) {
			redirect('auth', 'refresh');
		}

		//validate form input
		$this->form_validation->set_rules('group_name', $this->lang->line('create_group_validation_name_label'), 'required|alpha_dash');

		if ($this->form_validation->run() == TRUE) {
			$new_group_id = $this->ion_auth->create_group($this->input->post('group_name'), $this->input->post('description'));
			if ($new_group_id) {
				// check to see if we are creating the group
				// redirect them back to the admin page
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				redirect("auth", 'refresh');
			}
		} else {
			//display the create group form
			//set the flash data error message if there is one
			$data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

			$data['group_name'] = array(
				'name'  => 'group_name',
				'id'    => 'group_name',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('group_name'),
			);
			$data['description'] = array(
				'name'  => 'description',
				'id'    => 'description',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('description'),
			);

			$this->_render_page('auth/create_group', $data);
		}
	}

	//edit a group
	function edit_group($id)
	{
		// bail if no group id given
		if (!$id || empty($id)) {
			redirect('auth', 'refresh');
		}

		$data['title'] = $this->lang->line('edit_group_title');

		if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin()) {
			redirect('auth', 'refresh');
		}

		$group = $this->ion_auth->group($id)->row();

		//validate form input
		$this->form_validation->set_rules('group_name', $this->lang->line('edit_group_validation_name_label'), 'required|alpha_dash');

		if (isset($_POST) && !empty($_POST)) {
			if ($this->form_validation->run() === TRUE) {
				$group_update = $this->ion_auth->update_group($id, $_POST['group_name'], $_POST['group_description']);

				if ($group_update) {
					$this->session->set_flashdata('message', $this->lang->line('edit_group_saved'));
				} else {
					$this->session->set_flashdata('message', $this->ion_auth->errors());
				}
				redirect("auth", 'refresh');
			}
		}

		//set the flash data error message if there is one
		$data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

		//pass the user to the view
		$data['group'] = $group;

		$readonly = $this->config->item('admin_group', 'ion_auth') === $group->name ? 'readonly' : '';

		$data['group_name'] = array(
			'name'  => 'group_name',
			'id'    => 'group_name',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('group_name', $group->name),
			$readonly => $readonly,
		);
		$data['group_description'] = array(
			'name'  => 'group_description',
			'id'    => 'group_description',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('group_description', $group->description),
		);

		$this->_render_page('auth/edit_group', $data);
	}


	function _get_csrf_nonce()
	{
		$this->load->helper('string');
		$key   = random_string('alnum', 8);
		$value = random_string('alnum', 20);
		$this->session->set_flashdata('csrfkey', $key);
		$this->session->set_flashdata('csrfvalue', $value);

		return array($key => $value);
	}

	function _valid_csrf_nonce()
	{
		if (
			$this->input->post($this->session->flashdata('csrfkey')) !== FALSE &&
			$this->input->post($this->session->flashdata('csrfkey')) == $this->session->flashdata('csrfvalue')
		) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	function _render_page($view, $data = null, $render = false)
	{

		$this->viewdata = (empty($data)) ? $data : $data;

		$view_html = $this->load->view($view, $this->viewdata, $render);

		if (!$render) return $view_html;
	}

	function fPasswordSadm()
	{
		//setting validation rules by checking wheather identity is username or email
		if ($this->config->item('identity', 'ion_auth') == 'username') {
			$this->form_validation->set_rules('email', $this->lang->line('forgot_password_username_identity_label'), 'required');
		} else {
			$this->form_validation->set_rules('email', $this->lang->line('forgot_password_validation_email_label'), 'required|valid_email');
		}
		$data =  array('email' => strtolower($this->input->post('email')), 'phone' => $this->input->post('phone'));

		if ($this->form_validation->run() == false) {
			//setup the input
			$data['email'] = array(
				'name' => 'email',
				'id' => 'email',
			);

			if ($this->config->item('identity', 'ion_auth') == 'username') {
				$data['identity_label'] = $this->lang->line('forgot_password_username_identity_label');
			} else {
				$data['identity_label'] = $this->lang->line('forgot_password_email_identity_label');
			}

			//set any errors and display the form
			$data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
			$this->_render_page('auth/fPasswordSadm', $data);
		} else {
			// get identity from username or email
			if ($this->config->item('identity', 'ion_auth') == 'username') {
				$identity = $this->ion_auth->where('username', strtolower($this->input->post('email')))->users()->row();
			} else {
				///$identity = $this->ion_auth->where('email', strtolower($this->input->post('email')))->users()->row();

				$identity = $this->ion_auth->ion_authSuperadm($data);
			}

			if (empty($identity)) {

				$this->ion_auth->set_message('forgot_password_email_not_found');

				$this->session->set_flashdata('message', $this->ion_auth->messages());
				redirect("auth/fPasswordSadm", 'refresh');
			}

			//run the forgotten password method to email an activation code to the user
			$forgotten = $this->ion_auth->updatepasswordSadm($identity->email);

			if ($forgotten) {
				$user = $this->ion_auth->ion_authSuperadm($data);
				//if there were no errors
				$this->session->set_flashdata('message', '<span style="color:green;font-weight: bold;">' . $this->ion_auth->messages() . '</span>');
				$data1Email = array(
					'identity' => $user->email,
					'reset_url' => base_url() . 'auth/reset_passwordSadm/' . $user->forgotten_password_code
				);

				$autoemail = $this->email_model->getAutoEmailByType('forgot_password_by_email');
				$message1 = $autoemail->message;
				$subject = $this->parser->parse_string($autoemail->name, $data1Email, TRUE);
				// $subject = $this->lang->line('email_forgotten_password_subject')." ecoMed24";
				$messageprint2 = $this->parser->parse_string($message1, $data1Email, TRUE);

				$toReplace = array("\r\n", "\r", "\n");
				$replaceBy = array("", "", "");

				$dataInsertEmail = array(
					'reciepient' => $identity->email,
					'subject' => $subject,
					// 'message' => $messageprint2,
					'message' => str_replace($toReplace, $replaceBy, $messageprint2),
					'date' => time(),
					'user' => $user->id
				);
				$this->email_model->insertEmail($dataInsertEmail);
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				redirect("auth/superlogin", 'refresh'); //we should display a confirmation page here instead of the login page
			} else {
				$this->session->set_flashdata('message', $this->ion_auth->errors());
				redirect("auth/fPasswordSadm", 'refresh');
			}
		}
	}

	public function reset_passwordSadm($code = NULL)
	{

		if (!$code) {
			show_404();
		}

		$user = $this->ion_auth->forgotten_password_checkSadm($code);

		if ($user) {
			//if the code is valid then display the password reset form

			//$this->form_validation->set_rules('new', $this->lang->line('reset_password_validation_new_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[new_confirm]');
			$this->form_validation->set_rules('new', $this->lang->line('reset_password_validation_new_password_label'), 'required|matches[new_confirm]');
			$this->form_validation->set_rules('new_confirm', $this->lang->line('reset_password_validation_new_password_confirm_label'), 'required');

			if ($this->form_validation->run() == false) {
				//display the form

				//set the flash data error message if there is one
				$data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

				$data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
				$data['pattern'] = $this->config->item('pwd_pattern', 'ion_auth');
				/*$data['new_password'] = array(
					'name' => 'new',
					'id'   => 'new',
				'type' => 'password',
					'pattern' => $data['pattern'],
				);
				$data['new_password_confirm'] = array(
					'name' => 'new_confirm',
					'id'   => 'new_confirm',
					'type' => 'password',
					'pattern' => $data['pattern'],
				);
				$data['user_id'] = array(
					'name'  => 'user_id',
					'id'    => 'user_id',
					'type'  => 'hidden',
					'value' => $user->id,
				);*/

				$data['user_id'] = $user->id;
				$data['csrf'] = $this->_get_csrf_nonce();
				$data['code'] = $code;

				//render
				$this->_render_page('auth/reset_passwordSadm', $data);
			} else {
				// do we have a valid request?
				if ($this->_valid_csrf_nonce() === FALSE || $user->id != $this->input->post('user_id')) {

					//something fishy might be up
					$this->ion_auth->clear_forgotten_password_codeSadm($code);

					//show_error($this->lang->line('error_csrf'));
					$this->session->set_flashdata('message', $this->lang->line('error_csrf'));
					redirect("auth/fPasswordSadm", 'refresh');
				} else {
					$pattern = $data['pattern'];
					if (!preg_match($pattern, $this->input->post('new'))) {
						// finally change the password
						$identity = $user->{$this->config->item('identity', 'ion_auth')};
						$change = $this->ion_auth->reset_passwordSadm($identity, $this->input->post('new'));
						if ($change) {
							//if the password was successfully changed
							$this->session->set_flashdata('message', $this->ion_auth->messages());
							redirect("auth/superlogin", 'refresh');
						} else {
							$this->session->set_flashdata('message', $this->ion_auth->errors());
							redirect('auth/reset_passwordSadm/' . $code, 'refresh');
						}
					} else {
						$this->session->set_flashdata('message', lang('format_password_new_password'));
						redirect('auth/reset_passwordSadm/' . $code, 'refresh');
					}
				}
			}
		} else {
			//if the code is invalid then send them back to the forgot password page
			$this->session->set_flashdata('message', $this->ion_auth->errors());
			redirect("auth/fPasswordSadm", 'refresh');
		}
	}
}
