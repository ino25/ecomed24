<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Poste extends MX_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('poste_model');
        $this->load->model('department/department_model');
        $this->load->model('services/service_model');

        if (!$this->ion_auth->in_group('admin')) {
            redirect('home/permission');
        }

    }

    public function index() {
        $data['postes'] = $this->poste_model->getPoste();
        $data['services'] = $this->service_model->getService();
        $data['settings'] = $this->settings_model->getSettings();
      
        $this->load->view('home/dashboard');
        $this->load->view('poste', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function addNewView() {

        $this->load->view('home/dashboard');
        $this->load->view('add_new');
        $this->load->view('home/footer'); // just the header file
    }

    public function addNew() {
        $data['settings'] = $this->settings_model->getSettings();
        $id = $this->input->post('id');
        $name = $this->input->post('name');
        $description = $this->input->post('description');
        $service = $this->input->post('service');

        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        // Validating Name Field
        $this->form_validation->set_rules('name', 'Name', 'trim|required|min_length[2]|max_length[100]|xss_clean');
        // Validating Password Field    
        // Validating Email Field
        $this->form_validation->set_rules('description', 'Description', 'trim|min_length[2]|max_length[1000]|xss_clean');
        // Validating Address Field   
        if ($this->form_validation->run() == FALSE) {
            if (!empty($id)) {
                $data = array();
                $data['poste'] = $this->poste_model->getPosteById($id);
                $data['services'] = $this->service_model->getService();
              
                $this->load->view('home/dashboard');
                $this->load->view('add_new', $data);
                $this->load->view('home/footer'); // just the footer file
            } else {
                $data['setval'] = 'setval';
         
                $this->load->view('home/dashboard');
                $this->load->view('add_new', $data);
                $this->load->view('home/footer'); // just the header file
            }
        } else {
            //$error = array('error' => $this->upload->display_errors());
            $data = array();
            $data = array(
                'name_poste' => $name, 'status_poste' => 1,
                'description_poste' => $description, 'id_service' => $service
            );
            if (empty($id)) {     // Adding New poste
                $this->poste_model->insertPoste( $data);
                $this->session->set_flashdata('feedback', lang('added'));
            } else { // Updating poste
                $this->poste_model->updatePoste($id, $data);
                $this->session->set_flashdata('feedback', lang('updated'));
            }
            // Loading View
            redirect('poste');
        }
    }

    function getPoste() {
        $data['postes'] = $this->poste_model->getPoste();
        $this->load->view('poste', $data);
    }

    function editPoste() {
        $data = array();
        $id = $this->input->get('id');
        $data['poste'] = $this->poste_model->getPosteById($id);
 
        $this->load->view('home/dashboard');
        $this->load->view('add_new', $data);
        $this->load->view('home/footer'); // just the footer file
    }

    function editPosteByJason() {
        $id = $this->input->get('id');
        $data['poste'] = $this->poste_model->getPosteById($id);
        echo json_encode($data);
    }

    function delete() {
        $id = $this->input->get('id');
        $this->poste_model->delete($id);
        $this->session->set_flashdata('feedback', lang('deleted'));
        redirect('poste');
    }

    function editposteByservice() {
        $data = array();
        $id = $this->input->get('id');
        $data['poste'] = $this->poste_model->editposteByservice($id);
        echo json_encode($data);
    }

}

/* End of file poste.php */
/* Location: ./application/modules/poste/controllers/poste.php */
