<?php
defined('BASEPATH') OR exit('No direct script access allowed');  

class terms extends MY_Controller{ 

  function __construct(){
        parent::__construct();

        if (!$this->loggedIn) {
            $this->session->set_userdata('requested_page', $this->uri->uri_string());
            admin_redirect('login');
        }

        $this->load->library('form_validation');
        $this->load->model('Mdl_terms','mdl');
        $this->load->library('pagination');
  }
    
   
    
  public function index() {
        
        $meta['page_title'] = 'Terms & Condition';
        $this->data['homes'] = $this->mdl->get(8);
        $this->page_construct('terms/index', $meta, $this->data); 
  }

  public function edit($id){
        $meta['page_title'] = 'Terms & Condition';
        if($_POST && $_POST['title'] != '') 
        {
            
            if($this->mdl->update_row($_POST)) {
                $this->session->set_flashdata('success',lang('Update successfully'));
                redirect('admin/terms');
            } else {
                $this->session->set_flashdata('error',lang('Update fail'));
                redirect('admin/terms');
            }
        } else {
      
            $this->data['homes'] = $this->mdl->get($id);
            $this->page_construct('terms/index',$meta, $this->data);
        }
  }

  

  
} 
