<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

class contact extends MY_Front_Controller
{  
	function __construct()
	{ 
        parent::__construct();
        $this->load->library('form_validation');  
        
  	}
    

	function index()  
	{
		$meta['page_title'] = 'contact  -'.$this->Settings->sitename;
		$meta['page_name'] = 'contact'; 
		$meta['contact_title'] = ORM::for_table('tbl_updated_pages')->where('id',15)->find_one();
		
		

		$this->frontpage_construct_page('contact/index', $meta, $this->data); 
	}
	function send_inquiry() 
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

} 