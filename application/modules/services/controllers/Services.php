<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Services extends MX_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('service_model');
        $this->load->model('department/department_model');
        $this->load->model('schedule/schedule_model');
        $this->load->model('home/home_model');

        $identity = $this->session->userdata["identity"];
       
        $this->id_organisation = $this->home_model->get_id_organisation($identity); 
        $this->path_logo = $this->home_model->get_logo_organisation($this->id_organisation);
        $this->nom_organisation = $this->home_model->get_nom_organisation($this->id_organisation);
         $this->id_serviceUser = $this->home_model->get_code_service($identity);  
    }

    public function index() {
        // $data['departments'] = $this->department_model->getDepartmentByOrganisation($this->id_organisation);
        // $data['settings'] = $this->settings_model->getSettings();
      
        // $data['services'] = $this->service_model->getServiceByOrganisation($this->id_organisation);
	
		
        $data['services'] = $this->service_model->getGenericServicesAndCoverage($this->id_organisation);
		
        $data['id_organisation'] = $this->id_organisation;
        $data['path_logo'] = $this->path_logo;
        $data['nom_organisation'] = $this->nom_organisation;

        $this->load->view('home/dashboard', $data);
        $this->load->view('service', $data);
        $this->load->view('home/footer'); // just the header file
    }
	
	function addRemoveServiceSpecialiteOrganisation() {
        $id_organisation = $this->input->get('idOrganisation');
        $id_service = $this->input->get('idService');
        $id_specialite = $this->input->get('idSpecialite');
        $statut = $this->input->get('statut');
		
        $result = $this->service_model->addRemoveServiceSpecialiteOrganisation($id_organisation, $id_service, $id_specialite, $statut);

        echo json_encode("OK");
    }
	
	
	function addRemovePrestationPanier() {
        $id_organisation = $this->input->get('idOrganisation');
        $id_prestation = $this->input->get('idPrestation');
        $statut = $this->input->get('statut');
		
        $result = $this->service_model->addRemovePrestationPanier($id_organisation, $id_prestation, $statut);

        echo json_encode("OK");
    }

    public function addNewView() {
        $data['settings'] = $this->settings_model->getSettings();
        $this->load->view('home/dashboard', $data);
        $this->load->view('add_new');
        $this->load->view('home/footer'); // just the header file
    }

    public function addNew() {
        $data['settings'] = $this->settings_model->getSettings();
        $id = $this->input->post('id');
        $name = $this->input->post('name');
        $department = $this->input->post('department');
        $description = $this->input->post('description');

        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        // Validating Name Field
        $this->form_validation->set_rules('department', 'Name', 'trim|required|min_length[0]|max_length[100]|xss_clean');
        $this->form_validation->set_rules('name', 'Name', 'trim|required|min_length[2]|max_length[100]|xss_clean');
        // Validating Password Field    
        // Validating Email Field
        $this->form_validation->set_rules('description', 'Description', 'trim|min_length[2]|max_length[1000]|xss_clean');
        // Validating Address Field   
        if ($this->form_validation->run() == FALSE) {
            if (!empty($id)) {
                $data = array();

                $data['service'] = $this->service_model->getServiceById($id);
                $data['departments'] = $this->department_model->getDepartmentByOrganisation($this->id_organisation);

                $data['id_organisation'] = $this->id_organisation;
                $data['path_logo'] = $this->path_logo;
                $data['nom_organisation'] = $this->nom_organisation;
                // $data['departments'] = $this->department_model->getDepartment();


                $this->load->view('home/dashboard', $data);
                $this->load->view('add_new', $data);
                $this->load->view('home/footer'); // just the footer file
            } else {
                $data['setval'] = 'setval';
                $data['departments'] = $this->department_model->getDepartmentByOrganisation($this->id_organisation);

                $data['id_organisation'] = $this->id_organisation;
                $data['path_logo'] = $this->path_logo;
                $data['nom_organisation'] = $this->nom_organisation;

                $this->load->view('home/dashboard', $data);
                $this->load->view('add_new', $data);
                $this->load->view('home/footer'); // just the header file
            }
        } else {
            //$error = array('error' => $this->upload->display_errors());
            $data = array();
            $data = array(
                'name_service' => $name, 'id_department' => $department, 'status_service' => 1,'id_organisation' => $this->id_organisation,
                'description_service' => $description
            );
            if (empty($id)) {     // Adding New service
                $this->service_model->insertService($data);
                $this->session->set_flashdata('feedback', lang('added'));
            } else { // Updating service
                $this->service_model->updateService($id, $data);
                $this->session->set_flashdata('feedback', lang('updated'));
            }
            // Loading View

            $this->session->set_flashdata('feedback', $this->organisation);
            redirect('services');
        }
    }

    function getService() {
        $data['services'] = $this->service_model->getService();
        $this->load->view('service', $data);
    }

    function editService() {
        $data = array();
        $id = $this->input->get('id');
        $data['service'] = $this->service_model->getService($id);
        $data['departments'] = $this->department_model->getDepartment();
        $data['settings'] = $this->settings_model->getSettings();

        $this->load->view('home/dashboard');
        $this->load->view('add_new', $data);
        $this->load->view('home/footer'); // just the footer file
    }

    function editServiceByJason() {
        $id = $this->input->get('id');
        $data['service'] = $this->service_model->getServiceById($id);
        echo json_encode($data);
    }

    function delete() {
        $id = $this->input->get('id');
        $this->service_model->delete($id);
        $this->session->set_flashdata('feedback', lang('deleted'));
        redirect('services');
    }

    function editserviceBydepartement() {
        $data = array();
        $id = $this->input->get('id');
        $data['service'] = $this->service_model->editserviceBydepartement($id);
        echo json_encode($data);
    }

    function serviceHistory() {
        $data = array();
        $id = $this->input->get('id');
        $code = self::$code;
        $data['departments'] = $this->department_model->getDepartment();
        $data['service'] = $this->service_model->getService($id)[0];
        $data['holidays'] = $this->schedule_model->getHolidaysByDoctor();
        $data['schedules'] = $this->schedule_model->getScheduleService();


        foreach ($data['service_histories'] as $patient_history) {
            if ($patient_history->category == 'employe') {
                $description_tab = explode(',', str_replace('}', '', str_replace('{', '', str_replace('"', '', $patient_history->description))));
                $description_tab1 = explode(':', $description_tab[0]);
                $description_tab2 = explode(':', $description_tab[1]);
                $description_email = explode(':', $description_tab[2]);
                $description_adress = explode(':', $description_tab[3]);
                $description_phone = explode(':', $description_tab[4]);
                $description_dep = explode(':', $description_tab[5]);
                $description_service = explode(':', $description_tab[6]);
                $description_poste = explode(':', $description_tab[7]);
                $description_profil = explode(':', $description_tab[12]);

                $description = '<b> Prenom:</b> ' . $description_tab1[1] . ', <b> Nom:</b> ' . $description_tab2[1];
                $description .= ', <b>Email:</b> ' . $description_email[1] . ',  <b> Adresse:</b> ' . $description_adress[1];
                $description .= ', <b>Telephone:</b> ' . $description_phone[1] . ', <b> Departement:</b> ' . $description_dep[1] . ', <b> Service:</b> ' . $description_service[1] . ', <b> Poste:</b> ' . $description_poste[1] . ', <b> Profil:</b> ' . $description_profil[1];

                $timeline[] = '<div class="panel-body profile-activity" >
                                           <h5 class="pull-left"><span class="label pull-right r-activity">' . lang('patient_info') . '</span></h5>
                                            <h5 class="pull-right"><i class=" fa fa-calendar"></i>' . $patient_history->date . '</h5>
                                            <div class="activity purplee">
                                                <span>
                                                    <i class="fa fa-user"></i>
                                                </span>
                                                <div class="activity-desk">
                                                    <div class="panel_ col-md-6">
                                                        <div class="panel-body">
                                                            <div class="arrow"></div>
                                                            <i class=" fa fa-list"></i>
                                                            <h4> ' . $patient_history->title . ' <a class="pull-right" title="" > <i class=" fa fa-user"></i> par  ' . $patient_history->user_name . '</a> </h4>
                                                            <p></p>
                                                            
                                                                <p>' . $description . '</p>
                                                            
                                                                
                                                        </div>
                                                    </div> 
                                                </div>
                                            </div>
                                        </div>';
            } else
            if ($patient_history->category == 'statut') {
                $description_tab = explode(',', str_replace('}', '', str_replace('{', '', str_replace('"', '', $patient_history->description))));
                $description_tab0 = explode(':', $description_tab[0]);
                $desc0 = 'actif';
                if ($description_tab0[1] == '0') {
                    $desc0 = 'inactif';
                }
                $description = '<b>Changement statut en :</b> ' . $desc0;

                $timeline[] = '<div class="panel-body profile-activity" >
                                           <h5 class="pull-left"><span class="label pull-right r-activity">' . lang('patient_info') . '</span></h5>
                                            <h5 class="pull-right"><i class=" fa fa-calendar"></i>' . $patient_history->date . '</h5>
                                            <div class="activity purplee">
                                                <span>
                                                    <i class="fa fa-user"></i>
                                                </span>
                                                <div class="activity-desk">
                                                    <div class="panel_ col-md-6">
                                                        <div class="panel-body">
                                                            <div class="arrow"></div>
                                                            <i class=" fa fa-list"></i>
                                                            <h4> ' . $patient_history->title . ' <a class="pull-right" title="" > <i class=" fa fa-user"></i> par  ' . $patient_history->user_name . '</a> </h4>
                                                            <p></p>
                                                            
                                                                <p>' . $description . '</p>
                                                            
                                                                
                                                        </div>
                                                    </div> 
                                                </div>
                                            </div>
                                        </div>';
            } else if ($patient_history->category == 'document') {

                $description_tab = explode(',', str_replace('}', '', str_replace('{', '', str_replace('"', '', $patient_history->description))));

                $description_tab0 = explode(':', $description_tab[1]);
                $description = str_replace('\/', '/', $description_tab0[1]);


                $timeline[] = '<div class="panel-body profile-activity" >
                                           <h5 class="pull-left"><span class="label pull-right r-activity"></span></h5>
                                            <h5 class="pull-right"><i class=" fa fa-calendar"></i>' . $patient_history->date . '</h5>
                                            <div class="activity purplee">
                                                <span>
                                                    <i class="fa fa-file"></i>
                                                </span>
                                                <div class="activity-desk">
                                                    <div class="panel_ col-md-6">
                                                        <div class="panel-body">
                                                            <div class="arrow"></div>
                                                            <i class=" fa fa-list"></i>
                                                            <h4> ' . $patient_history->title . '
                                                            <a class="pull-right" title="" > <i class=" fa fa-user"></i> par  ' . $patient_history->user_name . '</a></h4>
                                                                
                                                                
                                                             <p> <a class="" title="' . lang('download') . '"  href="' . $description . '" download=""> <i class=" fa fa-download"></i> Télécharger</a> 
                                                           </p>
                                                                
                                                        </div>
                                                    </div> 
                                                </div>
                                            </div>
                                        </div>';
            }
        }

        if (!empty($timeline)) {
            $data['timeline'] = $timeline;
        }
        $data['settings'] = $this->settings_model->getSettings();
        $this->load->view('home/dashboard');
        $this->load->view('service_history', $data);
        $this->load->view('home/footer'); // just the footer file
    }

    function statusServiceByJason() {
        $id = $this->input->get('id');
        $status = $this->input->get('status');
        $data = array('status_service' => $status);
        $data['service'] = $this->service_model->updateService($id, $data);
        echo json_encode($data);
    }

    function getSericeinfo() {
        $data['services'] = $this->service_model->getService();
        echo json_encode($data);
    }

    function getSericeinfoByJason() {
        $searchTerm = $this->input->post('searchTerm');
        $organisation = $this->input->post('organisation');
        if(!$organisation){
            $organisation = $this->id_organisation;
        }
        $response = $this->service_model->getSericeinfoByJason($searchTerm, $organisation);
        echo json_encode($response);
    }
	
	function getServicesInfoByJson() {
        $searchTerm = $this->input->post('searchTerm');
        $organisation = $this->input->post('organisation');
        if(!$organisation){
            $organisation = $this->id_organisation;
        }
        // $response = $this->service_model->getSericeinfoByJason($searchTerm, $organisation);
        $response = $this->service_model->getServicesCoverageByJson($searchTerm, $organisation, $this->id_serviceUser);
	echo json_encode($response);
    }
    
    function getServicesCoverageByConsultationJson() {
        $searchTerm = $this->input->post('searchTerm');
        $organisation = $this->input->post('organisation');
        if(!$organisation){
            $organisation = $this->id_organisation;
        }
        // $response = $this->service_model->getSericeinfoByJason($searchTerm, $organisation);
        $response = $this->service_model->getServicesCoverageByConsultationJson($searchTerm, $organisation, $this->id_serviceUser);
	echo json_encode($response);
    }

    function getServicesCoverageByImagerieJson() {
        $searchTerm = $this->input->post('searchTerm');
        $organisation = $this->input->post('organisation');
        if(!$organisation){
            $organisation = $this->id_organisation;
        }
        // $response = $this->service_model->getSericeinfoByJason($searchTerm, $organisation);
        $response = $this->service_model->getServicesCoverageByImagerieJson($searchTerm, $organisation, $this->id_serviceUser);
	echo json_encode($response);
    }
    
    function getServicesRdvByJson() {
        $searchTerm = $this->input->post('searchTerm');
        $organisation = $this->input->post('organisation');
        if(!$organisation){
            $organisation = $this->id_organisation;
        }
        // $response = $this->service_model->getSericeinfoByJason($searchTerm, $organisation);
        $response = $this->service_model->getServicesRdvByJson($searchTerm, $organisation, $this->id_serviceUser);
	echo json_encode($response);
    }

}

/* End of file service.php */
/* Location: ./application/modules/service/controllers/service.php */
