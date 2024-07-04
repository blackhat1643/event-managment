<?php
defined('BASEPATH') OR exit('No direct script access allowed');  

class Home_about_us extends MY_Controller{ 

  function __construct(){
        parent::__construct();

        if (!$this->loggedIn) {
            $this->session->set_userdata('requested_page', $this->uri->uri_string());
            admin_redirect('login');
        }

        $this->load->library('form_validation');
        $this->load->model('Mdl_home_about_us','mdl');
        $this->load->library('pagination');
  }
    
   
    
  public function index() {
        
        $meta['page_title'] = 'About us';
        $this->data['homes'] = $this->mdl->get(2);
        $this->page_construct('home_about_us/index', $meta, $this->data); 
  }

  public function edit($id){
        $meta['page_title'] = 'About Us';
        if($_POST && $_POST['title'] != '') 
        {
            
            if($this->mdl->update_row($_POST)) {
                $this->session->set_flashdata('success',lang('Update successfully'));
                redirect('admin/home_about_us');
            } else {
                $this->session->set_flashdata('error',lang('Update fail'));
                redirect('admin/home_about_us');
            }
        } else {
      
            $this->data['homes'] = $this->mdl->get($id);
            $this->page_construct('home_about_us/index',$meta, $this->data);
        }
  }

  

  
} 
