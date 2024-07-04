<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

class who_we_are_style_1 extends MY_Front_Controller
{  
	function __construct()
	{ 
        parent::__construct();
        $this->load->library('form_validation');  
        
  	}
    

	function index()  
	{
		$meta['page_title'] = 'who_we_are_style_1 -'.$this->Settings->sitename;
		$meta['page_name'] = 'who_we_are_style_1'; 
		$this->data['about'] = ORM::for_table('tbl_updated_pages')->where('id',2)->find_one();
		
		$this->frontpage_construct_page('who_we_are_style_1/index', $meta, $this->data); 
	}

} 