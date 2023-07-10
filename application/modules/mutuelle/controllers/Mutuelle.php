<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mutuelle extends MX_Controller {

    private static $code = '';

    function __construct() {
        parent::__construct();

        $this->load->model('mutuelle_model');
        $this->load->model('dossier/dossier_model');

        /*if (!$this->ion_auth->in_group('admin')) {
            redirect('home/permission');
        }*/
        $identity = $this->session->userdata["identity"];
        self::$code = $this->settings_model->getCode($identity);
    }

    public function index() {
        $code = self::$code;

        $data['mutuelles'] = $this->mutuelle_model->getMutuelle($code);
         $data['settings'] = $this->settings_model->getSettingsId(self::$code);
        $data['menus'] = $this->settings_model->getMenuByName(self::$code);
        $this->load->view('home/dashboard',$data);
        $this->load->view('mutuelle', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function addNewView() {
        $code = self::$code;
        $data['categories'] = $this->dossier_model->getPaymentCategoryAll(self::$code);
         $data['settings'] = $this->settings_model->getSettingsId(self::$code);
        $data['menus'] = $this->settings_model->getMenuByName(self::$code);
        $this->load->view('home/dashboard',$data);
        $this->load->view('add_new', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function addNew() {
        $code = self::$code;
        $data['settings'] = $this->settings_model->getSettingsId($code);
        $id = $this->input->post('id');
        $insurance_name = $this->input->post('insurance_name');
        $discount = $this->input->post('discount');
        $remark = $this->input->post('remark');
        $insurance_no = $this->input->post('insurance_no');
        $insurance_code = $this->input->post('insurance_code');
        $status = $this->input->post('status');


        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        // Validating Name Field
        $this->form_validation->set_rules('insurance_name', 'Name', 'trim|required|min_length[2]|max_length[100]|xss_clean');

        // Validating Address Field   
        if ($this->form_validation->run() == FALSE) {
            if (!empty($id)) {
                $data = array();
                $data['mutuelle'] = $this->mutuelle_model->getMutuelleById($id, $code);
                 $data['settings'] = $this->settings_model->getSettingsId(self::$code);
        $data['menus'] = $this->settings_model->getMenuByName(self::$code);
        $this->load->view('home/dashboard',$data);
                $this->load->view('add_new', $data);
                $this->load->view('home/footer'); // just the footer file
            } else {
                $data['setval'] = 'setval';
                 $data['settings'] = $this->settings_model->getSettingsId(self::$code);
        $data['menus'] = $this->settings_model->getMenuByName(self::$code);
        $this->load->view('home/dashboard',$data);
                $this->load->view('add_new', $data);
                $this->load->view('home/footer'); // just the header file
            }
        } else {
            //$error = array('error' => $this->upload->display_errors());
            $name = $this->input->post('disease_name', true);
            $charge = $this->input->post('disease_charge', true);
            $disease = array();
            if (!empty($name))
                for ($i = 0; $i < sizeof($name); $i++) {
                    if (!empty($name[$i]))
                        $disease[$name[$i]] = $charge[$i];
                }
            $disease = json_encode($disease);

            $data = array();
            $data = array(
                'insurance_name' => $insurance_name,
                'discount' => $discount,
                'remark' => $remark,
                'insurance_no' => $insurance_no,
                'insurance_code' => $insurance_code,
                'status' => 1,
                'disease_charge' => $disease
            );
            if (empty($id)) {
                $this->mutuelle_model->insertMutuelle($code, $data);
                $this->session->set_flashdata('feedback', lang('added'));
            } else {
                $this->mutuelle_model->updateMutuelle($id, $code, $data);//                var_dump($data); exit();
                $this->session->set_flashdata('feedback', lang('updated'));
            }
        
            redirect('mutuelle');
        }
    }

    function getMutuelleById($id) {
        $data['mutuelles'] = $this->mutuelle_model->getMutuelleById($id, self::$code);
        $this->load->view('mutuelle', $data);
    }

    function getMutuelleByJason() {
        $searchTerm = $this->input->post('searchTerm');
        $response = $this->mutuelle_model->getMutuelleByJason($searchTerm, self::$code);
        echo json_encode($response);
    }

    function editMutuelle() {
        $code = self::$code;

        $id = $this->input->get('id');
        $data['mutuelle'] = $this->mutuelle_model->getMutuelleById($id, $code);
        $data['categories'] = $this->mutuelle_model->listeActeByJason($id,self::$code);
        //$data['categories'] = $this->dossier_model->getPaymentCategoryAll(self::$code);
         $data['settings'] = $this->settings_model->getSettingsId(self::$code);
        $data['menus'] = $this->settings_model->getMenuByName(self::$code);
        $this->load->view('home/dashboard',$data);
        $this->load->view('add_new', $data);
        $this->load->view('home/footer'); // just the footer file
    }

    /* function editMutuelleByJason() {
      $code = self::$code;
      $id = $this->input->get('id');
      $data['mutuelle'] = $this->mutuelle_model->getMutuelleById($id, $code);
      echo json_encode($data);
      } */

    function delete() {
        $code = self::$code;
        $id = $this->input->get('id');
        $this->mutuelle_model->delete($id, $code);
        $this->session->set_flashdata('feedback', lang('deleted'));
        redirect('mutuelle');
    }

}

/* End of file mutuelle.php */
/* Location: ./application/modules/mutuelle/controllers/mutuelle.php */
