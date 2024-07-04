<?php
defined('BASEPATH') OR exit('No direct script access allowed');  

class about_us_title extends MY_Controller{ 

  function __construct(){
        parent::__construct();

        if (!$this->loggedIn) {
            $this->session->set_userdata('requested_page', $this->uri->uri_string());
            admin_redirect('login');
        }

        $this->load->library('form_validation');
        $this->load->model('Mdl_about_us_title','mdl');
        $this->load->library('pagination');
  }
    
   
    
  public function index() {
        
        $meta['page_title'] = 'About Us';
        $this->data['homes'] = $this->mdl->get(2);
        $this->page_construct('about_us_title/index', $meta, $this->data); 
  }

  public function edit($id){
        $meta['page_title'] = 'About Us';
        if($_POST && $_POST['title'] != '') 
        {
            
            if($this->mdl->update_row($_POST)) {
                $this->session->set_flashdata('success',lang('Update successfully'));
                redirect('admin/about_us_title');
            } else {
                $this->session->set_flashdata('error',lang('Update fail'));
                redirect('admin/about_us_title');
            }
        } else {
      
            $this->data['homes'] = $this->mdl->get($id);
            $this->page_construct('about_us_title/index',$meta, $this->data);
        }
  }

  

  
} 
