<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Subscribe extends MY_Controller{ 

  function __construct(){
        parent::__construct();

        if (!$this->loggedIn) {
            $this->session->set_userdata('requested_page', $this->uri->uri_string());
            admin_redirect('login');
        }

        $this->load->library('form_validation');
        $this->load->model('Mdl_subscribe','mdl');
          $this->load->library('pagination');
        
  }  

   public function unset_session_value() {
        $this->session->unset_userdata('subscribe_s_start_date');
        $this->session->unset_userdata('subscribe_s_end_date');
        $this->session->unset_userdata('subscribe_serach_data');
        redirect('admin/subscribe');
  }   

    
   public function index() {

        $w  = '';
        $paginationdata = $this->data['Settings']->rows_per_page;
        if($_POST) {
            
            if(isset($_POST['subscribe_s_email']) AND $_POST['subscribe_s_email'] != '') {
                $w .= " AND email like '%".$_POST['subscribe_s_email']."%'";
                $this->session->set_userdata('subscribe_s_email',$_POST['subscribe_s_email']);
            }

            $_SESSION['subscribe_serach_data'] = $w;
            $this->session->set_userdata('subscribe_serach_data',$w);
        }
        if(isset($this->session->subscribe_serach_data) AND $this->session->subscribe_serach_data != '')
        {
             $w = $this->session->userdata('subscribe_serach_data');
        }

        $Record = $this->mdl->get_search_count($w);
        $config = $this->sam->pagination_config();
        $config['base_url'] = site_url().'admin/subscribe/index';
        $config['total_rows'] = $Record;
        $config['per_page'] = $paginationdata;

        $this->pagination->initialize($config);
        $this->data['rows'] = $this->mdl->get_all_with_pagi('id',$config['per_page'],$this->uri->segment(4),$w);
        $meta['page_title'] = 'Subscribe';
        $this->page_construct('subscribe/view', $meta, $this->data);
    }

     public function row_delete($id) {
        $this->sam->_delete_by_id($id,'contact');
    }

  
} 
