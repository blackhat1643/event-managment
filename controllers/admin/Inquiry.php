<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inquiry extends MY_Controller{ 

  function __construct(){
        parent::__construct();

        if (!$this->loggedIn) {
            $this->session->set_userdata('requested_page', $this->uri->uri_string());
            admin_redirect('login');
        }

        $this->load->library('form_validation');
        $this->load->model('Mdl_inquiry','mdl');
          $this->load->library('pagination');
        
  }  

   public function unset_session_value() {
        $this->session->unset_userdata('inquiry_s_start_date');
        $this->session->unset_userdata('inquiry_s_end_date');
        $this->session->unset_userdata('inquiry_serach_data');
        redirect('admin/inquiry');
  }   

   public function index() {

        $w  = '';
        $paginationdata = $this->data['Settings']->rows_per_page;
        if($_POST) {
            if($_POST['inquiry_s_start_date'] != '' AND $_POST['inquiry_s_end_date'] == '') {
                $w .= "AND DATE(inserted_time) = '".$_POST['inquiry_s_start_date']."'";
                $this->session->set_userdata('inquiry_s_start_date',$_POST['inquiry_s_start_date']);
            }
            
            if($_POST['inquiry_s_start_date'] != '' AND $_POST['inquiry_s_end_date'] != '') {
                $w .= "AND DATE(inserted_time) BETWEEN  '".$_POST['inquiry_s_start_date']."' AND  '".$_POST['inquiry_s_end_date']."'";
                $this->session->set_userdata('inquiry_s_start_date',$_POST['inquiry_s_start_date']);
                $this->session->set_userdata('inquiry_s_end_date',$_POST['inquiry_s_end_date']);
            }

            $_SESSION['inquiry_serach_data'] = $w;
            $this->session->set_userdata('inquiry_serach_data',$w);
        }
        if(isset($this->session->inquiry_serach_data) AND $this->session->inquiry_serach_data != '')
        {
             $w = $this->session->userdata('inquiry_serach_data');
        }

        $Record = $this->mdl->get_search_count($w);
        $config = $this->sam->pagination_config();
        $config['base_url'] = site_url().'admin/inquiry/index';
        $config['total_rows'] = $Record;
        $config['per_page'] = $paginationdata;

        $this->pagination->initialize($config);
        $this->data['rows'] = $this->mdl->get_all_with_pagi('id',$config['per_page'],$this->uri->segment(4),$w);
        $meta['page_title'] = 'Inquiries';
        $this->page_construct('inquiry/view', $meta, $this->data);
    }

     public function row_delete($id) {
        $this->sam->_delete_by_id($id,'contact');
    }

  
} 
