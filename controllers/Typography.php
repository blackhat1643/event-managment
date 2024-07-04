<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

class typography extends MY_Front_Controller
{  
	function __construct()
	{ 
        parent::__construct();
        $this->load->library('form_validation');  
        
  	}
    

	function index()  
	{
		$meta['page_title'] = 'Typography  -'.$this->Settings->sitename;
		$meta['page_name'] = 'Typography'; 
		
		

		$this->frontpage_construct_page('typography/index', $meta, $this->data); 
	}

} 