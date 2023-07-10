<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function required() {
    $CI = & get_instance();

    $CI->load->library('Ion_auth');
    $CI->load->library('session');
    $CI->load->library('form_validation');
    $CI->load->library('upload');

    $CI->load->config('paypal');

    $RTR = & load_class('Router');

    if ($RTR->class != "frontend" && $RTR->class != "auth" && $RTR->class != "qrcode") {
        if (!$CI->ion_auth->logged_in()) {
            redirect('auth/login');
        }
    }

    if ($RTR->class != "frontend" && $RTR->class != "auth") {
        $CI->language = $CI->db->get('settings')->row()->language;
        $CI->lang->load('system_syntax', $CI->language);
    }

    $CI->language = $CI->db->get('settings')->row()->language;
    $CI->lang->load('system_syntax', $CI->language);
    $settings = $CI->db->get('settings')->row();
    $CI->currency = $settings->currency;
    $CI->load->model('settings/settings_model');
    $CI->load->model('sms/sms_model');
    $CI->load->model('email/email_model');
    $CI->load->model('ion_auth_model');
    $CI->load->library('parser');
    $CI->load->helper('security');
    $CI->load->model('prescription/prescription_model');
    $CI->load->model('home/home_model');
    if ($RTR->class != "Prescription"){
    $transfer_prescription_list = $CI->db->get('transfer_prescription')->result();
    $new_settings = $CI->db->get_where('whatsapp_settings', array('id' => 1))->row()->status_changed;
 
    foreach ($transfer_prescription_list as $transfer) {
        
        if ($transfer->status != 'Expired') {
            $new_date = $transfer->add_date + ($new_settings * 24 * 60 * 60);
            if ($new_date < time()) {
                $status = array('status' => 'Expired');
                $CI->db->where('id', $transfer->id)->update('transfer_prescription', $status);
            }
        }
    }
    }
}
