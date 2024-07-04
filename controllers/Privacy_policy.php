<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

class privacy_policy extends MY_Front_Controller
{  
	function __construct()
	{ 
        parent::__construct();
        $this->load->library('form_validation');  
        
  	}
    

	function index()  
	{
		$meta['page_title'] = 'privacy_policy  -'.$this->Settings->sitename;
		$meta['page_name'] = 'privacy_policy'; 
		
		

		$this->frontpage_construct_page('privacy_policy/index', $meta, $this->data); 
	}

} 