<?php
defined('BASEPATH') OR exit('No direct script access allowed');  

class principal_message extends MY_Controller{ 

  function __construct(){
        parent::__construct();

        if (!$this->loggedIn) {
            $this->session->set_userdata('requested_page', $this->uri->uri_string());
            admin_redirect('login');
        }

        $this->load->library('form_validation');
        $this->load->model('Mdl_principal_message','mdl');
        $this->load->library('pagination');
  }
    
   
    
  public function index() {
        
        $meta['page_title'] = 'Principal Message';
        $this->data['homes'] = $this->mdl->get(25);
        $this->page_construct('principal_message/index', $meta, $this->data); 
  }

  public function edit($id){
        $meta['page_title'] = 'Principal Message';
        if($_POST && $_POST['title'] != '') 
        {
            
            if($this->mdl->update_row($_POST)) {
                $this->session->set_flashdata('success',lang('Update successfully'));
                redirect('admin/principal_message');
            } else {
                $this->session->set_flashdata('error',lang('Update fail'));
                redirect('admin/principal_message');
            }
        } else {
      
            $this->data['homes'] = $this->mdl->get($id);
            $this->page_construct('principal_message/index',$meta, $this->data);
        }
  }

  

  
} 
