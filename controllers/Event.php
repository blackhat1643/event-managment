<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

class event extends MY_Front_Controller
{  
	function __construct()
	{ 
        parent::__construct();
        $this->load->library('form_validation');  
        
  	}
    

	function index()  
	{
		$meta['page_title'] = 'event  -'.$this->Settings->sitename;
		$meta['page_name'] = 'event'; 
		
		

		$this->frontpage_construct_page('event/index', $meta, $this->data); 
	}

} 