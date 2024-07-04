<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

class services_pages extends MY_Front_Controller
{  
	function __construct()
	{ 
        parent::__construct();
        $this->load->library('form_validation');  
        
  	}
    

	function index()  
	{
		$meta['page_title'] = 'services_pages  -'.$this->Settings->sitename;
		$meta['page_name'] = 'services_pages'; 
		
		$this->data['services'] = ORM::for_table('tbl_services')
                                                ->where('status','active')
                                                ->where('is_deleted','0')
                                                ->find_array();
       

		$this->frontpage_construct_page('services_pages/index', $meta, $this->data); 
	}

	function details($id)  
	{
		$meta['page_title'] = 'services_pages  -'.$this->Settings->sitename;
		$meta['page_name'] = 'services_pages'; 
		
		$this->data['service'] = ORM::for_table('tbl_services')
                                            ->where('id',$id)
											->where('status','active')
											->where('is_deleted','0')
											->find_one();
	
		$this->frontpage_construct_page('services_pages/details', $meta, $this->data); 
	}

} 