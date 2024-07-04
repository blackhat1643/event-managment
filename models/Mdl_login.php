<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Mdl_login extends CI_Model{ 

	public function __construct(){
		parent::__construct();
		$this->load->library('database'); 
	}

	private $_table = 'sam_users';  


}