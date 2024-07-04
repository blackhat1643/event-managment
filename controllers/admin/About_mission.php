<?php
defined('BASEPATH') OR exit('No direct script access allowed');  

class about_mission extends MY_Controller{ 

  function __construct(){
        parent::__construct();

        if (!$this->loggedIn) {
            $this->session->set_userdata('requested_page', $this->uri->uri_string());
            admin_redirect('login');
        }

        $this->load->library('form_validation');
        $this->load->model('Mdl_about_mission','mdl');
        $this->load->library('pagination');
  }
    
   
    
  public function index() {
        
        $meta['page_title'] = 'About Mission';
        $this->data['homes'] = $this->mdl->get(12);
        $this->page_construct('about_mission/index', $meta, $this->data); 
  }

  public function edit($id){
        $meta['page_title'] = 'About Mission';
        if($_POST && $_POST['title'] != '') 
        {
            
            if($this->mdl->update_row($_POST)) {
                $this->session->set_flashdata('success',lang('Update successfully'));
                redirect('admin/about_mission');
            } else {
                $this->session->set_flashdata('error',lang('Update fail'));
                redirect('admin/about_mission');
            }
        } else {
      
            $this->data['homes'] = $this->mdl->get($id);
            $this->page_construct('about_mission/index',$meta, $this->data);
        }
  }

  

  
} 
