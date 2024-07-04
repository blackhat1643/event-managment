<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

class shortcodes extends MY_Front_Controller
{  
	function __construct()
	{ 
        parent::__construct();
        $this->load->library('form_validation');  
        
  	}
    

	function index()  
	{
		$meta['page_title'] = 'shortcodes  -'.$this->Settings->sitename;
		$meta['page_name'] = 'shortcodes'; 
		
		

		$this->frontpage_construct_page('shortcodes/index', $meta, $this->data); 
	}

} 