<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

class shop extends MY_Front_Controller
{  
	function __construct()
	{ 
        parent::__construct();
        $this->load->library('form_validation');  
        
  	}
    

	function index()  
	{
		$meta['page_title'] = 'Shop  -'.$this->Settings->sitename;
		$meta['page_name'] = 'Shop'; 
		
		

		$this->frontpage_construct_page('shop/index', $meta, $this->data); 
	}

} 