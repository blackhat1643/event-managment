<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

class Home extends MY_Front_Controller{  


	function __construct(){ 
        parent::__construct();
        $this->load->library('form_validation');  
        $this->load->library('Sam','sam'); 
  	}
    
    private $_table = 'home';  
 
	function index()  
	{
		$meta['page_title'] = 'Home ';  
        $meta['home_banner'] = ORM::for_table('tbl_updated_pages')->where('id',1)->find_one();
        $meta['home_slide1'] = ORM::for_table('tbl_home_slide')->where('id',2)->find_one();
        $meta['home_slide2'] = ORM::for_table('tbl_home_slide')->where('id',3)->find_one();
        $meta['home_gallery1'] = ORM::for_table('tbl_gallery')->where('id',9)->find_one();
        $meta['home_gallery2'] = ORM::for_table('tbl_gallery')->where('id',11)->find_one();
        $this->data['home_slides'] = ORM::for_table('tbl_home_slide')
                                                ->where('status','active')
                                                ->where('is_deleted','0')
                                                ->find_array();
        $this->data['home_events'] = ORM::for_table('tbl_home_events')
                                                ->where('status','active')
                                                ->where('is_deleted','0')
                                                ->find_array();
        $this->data['services'] = ORM::for_table('tbl_services')
                                                ->where('status','active')
                                                ->where('is_deleted','0')
                                                ->find_array();
        $this->data['blogs'] = ORM::for_table('tbl_blogs')
                                                ->where('status','active')
                                                ->where('is_deleted','0')
                                                ->limit(2)
                                                ->find_array();
        $this->data['gallery'] = ORM::for_table('tbl_gallery')
                                                ->where('status','active')
                                                ->where('is_deleted','0')
                                                ->find_array();
        $this->data['home_gallery'] = ORM::for_table('tbl_gallery')
                                                ->where('status','active')
                                                ->where('is_deleted','0')
                                                ->limit(2)
                                                ->find_array();
     

      
		$this->frontpage_construct('index', $meta, $this->data);
	}
	function home_send_inquiry() 
    {
        $d = ORM::for_table('contact')->create();
        $d->type            = 'inquiry';
        $d->name         	= trim(@$_POST['inq_name']);
        $d->email     		= trim(@$_POST['inq_email']);

        $d->message      	= trim(@$_POST['message']);
        $d->inserted_time   = date('Y-m-d H:i:s');

        if($d->save()){
            $output['status'] = 1;
            $output['msg'] = 'Thanks '.$_POST['inq_name'].'..Successfully your inquiry';
        } else {
            $output['status'] = 0;
            $output['msg'] = 'Something Wrong !!';
        } 
        echo json_encode($output); 
        
     
    }

    function send_subscribe_now() 
    {
        $d = ORM::for_table('contact')->create();
        $d->type            = 'subscribe';
        $d->email     		= trim(@$_POST['sub_email']);
        $d->inserted_time   = date('Y-m-d H:i:s');

        if($d->save()){
            $output['status'] = 1;
            $output['msg'] = 'Thanks '.$_POST['sub_email'].'..Successfully Subscribe';
        } else {
            $output['status'] = 0;
            $output['msg'] = 'Something Wrong !!';
        } 
        echo json_encode($output);      
    }
    
} 