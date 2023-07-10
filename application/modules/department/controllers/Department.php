<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Department extends MX_Controller {

	var $id_organisation = '';
	var $path_logo = '';
	var $nom_organisation = '';
	 
    function __construct() {
        parent::__construct();

        $this->load->model('department_model');
        $this->load->model('home/home_model');

        if (!$this->ion_auth->in_group(array('admin','adminmedecin'))) {
            redirect('home/permission');
        }
		
		$identity = $this->session->userdata["identity"];
		
		$this->id_organisation = $this->home_model->get_id_organisation($identity); 
		$this->path_logo = $this->home_model->get_logo_organisation($this->id_organisation); 
		$this->nom_organisation = $this->home_model->get_nom_organisation($this->id_organisation);
    }

    public function index() {
		$identity = $this->session->userdata["identity"];
		if ($identity == 'superadmin@zuulumed.net' || $identity == 'superadminlabo@zuulumed.net') {
              redirect('home/superhome');
         }
		 
		$data['id_organisation'] = $this->id_organisation;
		$data['path_logo'] = $this->path_logo;
		$data['nom_organisation'] = $this->nom_organisation;
		
        // $data['departments'] = $this->department_model->getDepartment();
        $data['departments'] = $this->department_model->getDepartmentByOrganisation($this->id_organisation);
        $this->load->view('home/dashboard',$data); // just the header file
        $this->load->view('department', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function addNewView() {
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('add_new');
        $this->load->view('home/footer'); // just the header file
    }

    public function addNew() {
        $id = $this->input->post('id');
        $name = $this->input->post('name');
        $description = $this->input->post('description');

        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        // Validating Name Field
        $this->form_validation->set_rules('name', 'Name', 'trim|required|min_length[2]|max_length[100]|xss_clean');
        // Validating Password Field    
        // Validating Email Field
       // $this->form_validation->set_rules('description', 'Description', 'trim|required|min_length[2]|max_length[1000]|xss_clean');
        // Validating Address Field   
        if ($this->form_validation->run() == FALSE) {
            if (!empty($id)) {
                $data = array();
                $data['department'] = $this->department_model->getDepartmentById($id);
                $this->load->view('home/dashboard'); // just the header file
                $this->load->view('add_new', $data);
                $this->load->view('home/footer'); // just the footer file
            } else {
                $data['setval'] = 'setval';
                $this->load->view('home/dashboard'); // just the header file
                $this->load->view('add_new', $data);
                $this->load->view('home/footer'); // just the header file
            }
        } else {
			// $this->session->set_flashdata('feedback', "ID Organisation: ".$this->id_organisation);
            $data = array();
            $data = array(
                'name' => $name,
                // 'id_organisation' => $this->home_model->get_id_organisation($this->session->userdata["identity"]), 
                'id_organisation' => $this->id_organisation, 
                'description' => $description
            );
            if (empty($id)) {     // Adding New department
                $this->department_model->insertDepartment($data);
                $this->session->set_flashdata('feedback', "Departement ajouté");
                // $this->session->set_flashdata('feedback', self::$id_or);
            } else { // Updating department
                $this->department_model->updateDepartment($id, $data);
                $this->session->set_flashdata('feedback', lang('updated'));
            }
            // Loading View
            redirect('department');
        }
    }

    function getDepartment() {
        $data['departments'] = $this->department_model->getDepartment();
        $this->load->view('department', $data);
    }

    function editDepartment() {
        $data = array();
        $id = $this->input->get('id');
        $data['department'] = $this->department_model->getDepartmentById($id);
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('add_new', $data);
        $this->load->view('home/footer'); // just the footer file
    }

    function editDepartmentByJason() {
        $id = $this->input->get('id');
        $data['department'] = $this->department_model->getDepartmentById($id);
        echo json_encode($data);
    }

    function delete() {
        $id = $this->input->get('id');
        $this->department_model->delete($id);
        $this->session->set_flashdata('feedback', lang('deleted'));
        redirect('department');
    }

}

/* End of file department.php */
/* Location: ./application/modules/department/controllers/department.php */
