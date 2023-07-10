<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');



class Whatsapp extends MX_Controller {

       function __construct() {
        parent::__construct();
        $this->load->model('whatsapp_model');
        
    }
     public function autoWhatsappTemplate() {
        $data['settings'] = $this->settings_model->getSettings();
        $data['shortcode'] = $this->whatsapp_model->getAutoWhatsappTemplate();
        $this->load->view('home/superdashboard', $data);
        $this->load->view('autowhatsapptemplate', $data);
        $this->load->view('home/footer', $data);
    }
    function getAutoWhatsappTemplateList() {
        $type = $this->input->post('type');
        $requestData = $_REQUEST;
        $start = $requestData['start'];
        $limit = $requestData['length'];
        $search = $this->input->post('search')['value'];

        if ($limit == -1) {
            if (!empty($search)) {
                $data['cases'] = $this->whatsapp_model->getAutoWhatsappTemplateBySearch($search);
            } else {
                $data['cases'] = $this->whatsapp_model->getAutoWhatsappTemplate();
            }
        } else {
            if (!empty($search)) {
                $data['cases'] = $this->whatsapp_model->getAutoWhatsappTemplateByLimitBySearch($limit, $start, $search);
            } else {
                $data['cases'] = $this->whatsapp_model->getAutoWhatsappTemplateByLimit($limit, $start);
            }
        }
        //  $data['patients'] = $this->patient_model->getVisitor();
        $i = 0;
        $count = 0;
        foreach ($data['cases'] as $case) {
            $i = $i + 1;
           

                $options1 = ' <a type="button" class="btn btn-success btn-xs btn_width editbutton1" title="' . lang('edit') . '" data-toggle = "modal" data-id="' . $case->id . '"><i class="fa fa-edit"> </i></a>';
                // $options1 = '<a type='button" class="btn btn-success btn-xs btn_width" title="" . lang('edit') . '"data-toggle = "modal" data-id="' . $case->id . '"><i class="fa fa-edit"></i></a>';
                //    $options2 = '<a class="btn btn-danger btn-xs btn_width" title="' . lang('delete') . '" href="whatsapp/deleteTemplate?id=' . $case->id . '&redirect=whatsapp/whatsappTemplate" onclick="return confirm(\'Are you sure you want to delete this item?\');"><i class="fa fa-trash-o"></i></a>';
            
            $info[] = array(
                $i,
                $case->type,
                $case->message,
                $case->status,
                $options1
            );
            $count = $count + 1;
        }

        if (!empty($data['cases'])) {
            $output = array(
                "draw" => intval($requestData['draw']),
                "recordsTotal" => $count,
                "recordsFiltered" => $count,
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

 public function editAutoWhatsappTemplate() {
        $id = $this->input->get('id');
        $data['autotemplatename'] = $this->whatsapp_model->getAutoWhatsappTemplateById($id);
        $data['autotag'] = $this->whatsapp_model->getAutoWhatsappTemplateTag($data['autotemplatename']->type);
        if ($data['autotemplatename']->status == 'Active') {
            $data['status_options'] = '<option value="Active" selected>' . lang("active") . '
                            </option>
                            <option value="Inactive"> ' . lang("inactive") . '
        </option>';
        } else {
            $data['status_options'] = '<option value="Active">' . lang("active") . '
                            </option>
                            <option value="Inactive" selected> ' . lang("inactive") . '
        </option>';
        }
        echo json_encode($data);
    }
 public function addNewAutoWhatsappTemplate() {
        $message = $this->input->post('message');
        $name = $this->input->post('category');
        $id = $this->input->post('id');
        $status = $this->input->post('status');

        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        $this->form_validation->set_rules('message', 'Message', 'trim|xss_clean|required');
        if ($this->form_validation->run() == FALSE) {

            $data['settings'] = $this->settings_model->getSettings();
           
            $this->load->view('home/superdashboard', $data);
            $this->load->view('autowhatsapptemplate', $data);
            $this->load->view('home/footer', $data);
        } else {
            $data = array();
            $data = array(
                'name' => $name,
                'message' => $message,
                'status' => $status,
            );

            $this->whatsapp_model->updateAutoWhatsappTemplate($data, $id);
            $this->session->set_flashdata('feedback', lang('updated'));

            redirect('whatsapp/autoWhatsappTemplate');
        }
    }
}