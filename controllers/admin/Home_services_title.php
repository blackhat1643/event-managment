<?php
defined('BASEPATH') OR exit('No direct script access allowed');  

class home_services_title extends MY_Controller{ 

  function __construct(){
        parent::__construct();

        if (!$this->loggedIn) {
            $this->session->set_userdata('requested_page', $this->uri->uri_string());
            admin_redirect('login');
        }

        $this->load->library('form_validation');
        $this->load->model('Mdl_home_services_title','mdl');
        $this->load->library('pagination');
  }
    
   
    
  public function index() {
        
        $meta['page_title'] = 'Services Title';
        $this->data['homes'] = $this->mdl->get(3);
        $this->page_construct('home_services_title/index', $meta, $this->data); 
  }

  public function edit($id){
        $meta['page_title'] = 'Services Title';
        if($_POST && $_POST['title'] != '') 
        {
            
            if($this->mdl->update_row($_POST)) {
                $this->session->set_flashdata('success',lang('Update successfully'));
                redirect('admin/home_services_title');
            } else {
                $this->session->set_flashdata('error',lang('Update fail'));
                redirect('admin/home_services_title');
            }
        } else {
      
            $this->data['homes'] = $this->mdl->get($id);
            $this->page_construct('home_services_title/index',$meta, $this->data);
        }
  }

  

  
} 
