<?php
defined('BASEPATH') OR exit('No direct script access allowed');  

class Home_news extends MY_Controller{ 

  function __construct(){
        parent::__construct();

        if (!$this->loggedIn) {
            $this->session->set_userdata('requested_page', $this->uri->uri_string());
            admin_redirect('login');
        }

        $this->load->library('form_validation');
        $this->load->model('Mdl_home_news','mdl');
        $this->load->library('pagination');
  }
    
   
    
  public function index() {
        
        $meta['page_title'] = 'Home News';
        $this->data['homes'] = $this->mdl->get(20);
        $this->page_construct('home_news/index', $meta, $this->data); 
  }

  public function edit($id){
        $meta['page_title'] = 'Home_News';
        if($_POST && $_POST['title'] != '') 
        {
            
            if($this->mdl->update_row($_POST)) {
                $this->session->set_flashdata('success',lang('Update successfully'));
                redirect('admin/home_news');
            } else {
                $this->session->set_flashdata('error',lang('Update fail'));
                redirect('admin/home_news');
            }
        } else {
      
            $this->data['homes'] = $this->mdl->get($id);
            $this->page_construct('home_news/index',$meta, $this->data);
        }
  }

  

  
} 
