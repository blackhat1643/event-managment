<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

class blog extends MY_Front_Controller
{  
	function __construct()
	{ 
        parent::__construct();
        $this->load->library('form_validation');  
        
  	}
    

	function index()  
	{
		$meta['page_title'] = 'blog  -'.$this->Settings->sitename;
		$meta['page_name'] = 'blog'; 

		$this->data['blogs'] = ORM::for_table('tbl_blogs')
                                                ->where('status','active')
                                                ->where('is_deleted','0')
                                                ->find_array();
        
		

		$this->frontpage_construct_page('blog/index', $meta, $this->data); 
	}
	
	function details($id)  
	{
		$meta['page_title'] = 'Blogs  -'.$this->Settings->sitename;
		$meta['page_name'] = 'Blogs'; 

		$this->data['detail'] = ORM::for_table('tbl_blogs')
										->where('id',$id)
										->where('status','active')
										->where('is_deleted','0')
										->find_one();
		

		$this->frontpage_construct_page('blog/details', $meta, $this->data); 
		
	}

} 