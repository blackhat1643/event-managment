<?php
defined('BASEPATH') OR exit('No direct script access allowed');  

class Home_banner extends MY_Controller{ 

  function __construct(){
        parent::__construct();

        if (!$this->loggedIn) {
            $this->session->set_userdata('requested_page', $this->uri->uri_string());
            admin_redirect('login');
        }

        $this->load->library('form_validation');
        $this->load->model('Mdl_home_banner','mdl');
        $this->load->library('pagination');
  }
    
   
    
  public function index() {
        
        $meta['page_title'] = 'Home Banner';
        $this->data['homes'] = $this->mdl->get(1);
        $this->page_construct('home_banner/index', $meta, $this->data); 
  }

  public function edit($id){
        $meta['page_title'] = 'Home Banner';
        if($_POST && $_POST['title'] != '') 
        {
            
            if($this->mdl->update_row($_POST)) {
                $this->session->set_flashdata('success',lang('Home Update successfully'));
                redirect('admin/home_banner');
            } else {
                $this->session->set_flashdata('error',lang('Home Update fail'));
                redirect('admin/home_banner');
            }
        } else {
      
            $this->data['homes'] = $this->mdl->get($id);
            $this->page_construct('home_banner/index',$meta, $this->data);
        }
  }

  

  
} 
