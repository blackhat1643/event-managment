<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

class service_plus extends MY_Front_Controller
{  
	function __construct()
	{ 
        parent::__construct();
        $this->load->library('form_validation');  
        
  	}
    

	function index()  
	{
		$meta['page_title'] = 'service_plus  -'.$this->Settings->sitename;
		$meta['page_name'] = 'service_plus'; 
		
		

		$this->frontpage_construct_page('service_plus/index', $meta, $this->data); 
	}

} 