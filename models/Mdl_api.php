<?php defined('BASEPATH') OR exit('No direct script access allowed');
    
require_once APPPATH.'third_party/PHPMailer.php';

class Mdl_api extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->library('database');
    }

    private $page_limit = 10;

   
    


    


}