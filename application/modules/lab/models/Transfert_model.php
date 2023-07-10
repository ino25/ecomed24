<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Transfert_model extends CI_model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

   

}
