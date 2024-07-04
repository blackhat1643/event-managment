<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

class cobbles extends MY_Front_Controller
{  
	function __construct()
	{ 
        parent::__construct();
        $this->load->library('form_validation');  
        
  	}
    

	function index()  
	{
		$meta['page_title'] = 'cobbles  -'.$this->Settings->sitename;
		$meta['page_name'] = 'cobbles'; 
		
		

		$this->frontpage_construct_page('cobbles/index', $meta, $this->data); 
	}

} 