<?php
defined('BASEPATH') OR exit('No direct script access allowed');  

class subscribe_title extends MY_Controller{ 

  function __construct(){
        parent::__construct();

        if (!$this->loggedIn) {
            $this->session->set_userdata('requested_page', $this->uri->uri_string());
            admin_redirect('login');
        }

        $this->load->library('form_validation');
        $this->load->model('Mdl_contact_title','mdl');
        $this->load->library('pagination');
  }
    
   
    
  public function index() {
        
        $meta['page_title'] = 'About Samanvay Hospital';
        $this->data['homes'] = $this->mdl->get(16);
        $this->page_construct('contact_title/index', $meta, $this->data); 
  }

  public function edit($id){
        $meta['page_title'] = 'Contact_title';
        if($_POST && $_POST['title'] != '') 
        {
            
            if($this->mdl->update_row($_POST)) {
                $this->session->set_flashdata('success',lang('Update successfully'));
                redirect('admin/contact_title');
            } else {
                $this->session->set_flashdata('error',lang('Update fail'));
                redirect('admin/about_samanvay_hospital');
            }
        } else {
      
            $this->data['homes'] = $this->mdl->get($id);
            $this->page_construct('about_samanvay_hospital/index',$meta, $this->data);
        }
  }

  

  
} 
