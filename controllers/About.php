<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

class About extends MY_Front_Controller
{  
	function __construct()
	{ 
        parent::__construct();
        $this->load->library('form_validation');  
  	}
    
	function index()  
	{
		$meta['page_title'] = 'About Page -'.$this->Settings->sitename;
		$meta['about_us_title'] = ORM::for_table('tbl_updated_pages')->where('id',2)->find_one();
		$this->data['teachers'] = ORM::for_table('tbl_our_teachers')
												->where('status','active')
												->where('is_deleted','0')
												->find_array();
		$this->data['about_achievements'] = ORM::for_table('tbl_about_achievement')
												->where('status','active')
												->where('is_deleted','0')
												->find_array();
		$this->data['why_choose_us'] = ORM::for_table('tbl_why_choose_us')
												->where('status','active')
												->where('is_deleted','0')
												->find_array();
		$this->data['brand_logo'] = ORM::for_table('tbl_brand_logo')
												->where('status','active')
												->where('is_deleted','0')
												->find_array();
		$this->data['testimonials'] = ORM::for_table('tbl_home_testimonial')
												->where('status','active')
												->where('is_deleted','0')
												->find_array();

		$this->frontpage_construct('about/index', $meta, $this->data); 
	}

} 