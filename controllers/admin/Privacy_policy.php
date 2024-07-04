<?php
defined('BASEPATH') OR exit('No direct script access allowed');  

class privacy_policy extends MY_Controller{ 

  function __construct(){
        parent::__construct();

        if (!$this->loggedIn) {
            $this->session->set_userdata('requested_page', $this->uri->uri_string());
            admin_redirect('login');
        }

        $this->load->library('form_validation');
        $this->load->model('Mdl_privacy_policy','mdl');
        $this->load->library('pagination');
  }
    
   
    
  public function index() {
        
        $meta['page_title'] = 'Privacy Policy';
        $this->data['homes'] = $this->mdl->get(9);
        $this->page_construct('privacy_policy/index', $meta, $this->data); 
  }

  public function edit($id){
        $meta['page_title'] = 'Terms & Condition';
        if($_POST && $_POST['title'] != '') 
        {
            
            if($this->mdl->update_row($_POST)) {
                $this->session->set_flashdata('success',lang('Update successfully'));
                redirect('admin/privacy_policy');
            } else {
                $this->session->set_flashdata('error',lang('Update fail'));
                redirect('admin/privacy_policy');
            }
        } else {
      
            $this->data['homes'] = $this->mdl->get($id);
            $this->page_construct('privacy_policy/index',$meta, $this->data);
        }
  }

  

  
} 
