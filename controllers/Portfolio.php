<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

class portfolio extends MY_Front_Controller
{  
	function __construct()
	{ 
        parent::__construct();
        $this->load->library('form_validation');  
        
  	}
    

	function index()  
	{
		$meta['page_title'] = 'portfolio  -'.$this->Settings->sitename;
		$meta['page_name'] = 'portfolio'; 


		$this->data['categorys'] = ORM::for_table('tbl_category')
                                                ->where('status','active')
                                                ->where('is_deleted','0')
                                                ->find_array();
      
        $this->data['gallery'] = ORM::for_table('tbl_gallery')
                                                ->where('status','active')
                                                ->where('is_deleted','0')
                                                ->find_array();
             

		$this->frontpage_construct_page('portfolio/index', $meta, $this->data); 
	}

} 