<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends MY_Controller {

	function __construct() {
		parent::__construct();
	}

	function index() {
		// if(!SITE) { redirect('admin'); }
		$this->load->view('index');      
		
		// redirect('appointment');
	}
}