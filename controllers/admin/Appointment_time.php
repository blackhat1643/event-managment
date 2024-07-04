<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class appointment_time extends MY_Controller {

    function __construct()
    {
        parent::__construct();
        if (!$this->loggedIn) {
            $this->session->set_userdata('requested_page', $this->uri->uri_string());
            admin_redirect('login');
        }
        $this->load->library('form_validation');
        $this->load->model('Mdl_appointment_time','mdl');
        $this->load->library('pagination');
    }

    public function unset_session_value() {

    $this->session->unset_userdata('appointment_time_s_status');
    $this->session->unset_userdata('appointment_time_s_title');

    $this->session->unset_userdata('appointment_time_serach_page');
    $this->session->unset_userdata('appointment_time_search_data');
    redirect('admin/appointment_time');
  } 
    
    public function index() {
        // Pagination Start
        $w = $l = '';
       
        $paginationdata = $this->data['Settings']->rows_per_page;
       
        if($_POST) {
            
            if(isset($_POST['appointment_time_s_title']) AND $_POST['appointment_time_s_title'] != '') {
                $w .= " AND title like '%".$_POST['appointment_time_s_title']."%'";
                $this->session->set_userdata('appointment_time_s_title',$_POST['appointment_time_s_title']);
            }
            if(isset($_POST['appointment_time_s_status']) AND $_POST['appointment_time_s_status'] != '') {
                $w .= " AND status ='".$_POST['appointment_time_s_status']."'";
                $this->session->set_userdata('appointment_time_s_status',$_POST['appointment_time_s_status']);
            }

            $_SESSION['appointment_time_search_data'] = $w;
            $this->session->set_userdata('appointment_time_search_data',$w);
        }

       if(isset($this->session->appointment_time_search_data) AND $this->session->appointment_time_search_data != '')
       {
             $w = $this->session->userdata('appointment_time_search_data');
       }
        $w = $this->session->userdata('appointment_time_search_data');
        $Record =  $this->mdl->get_count($w);  
        
        $config = $this->sam->pagination_config();
        $config['base_url'] = site_url().'admin/appointment_time/index';
        $config['total_rows'] = $Record;
        $config['per_page'] = $paginationdata;
        $this->pagination->initialize($config);
        
        $meta['page_title'] = 'Appointment time';
        $this->data['rows'] = $this->mdl->get_all_with_pagi('id',$config['per_page'],$this->uri->segment(4),$w);
        $this->page_construct('appointment_time/view', $meta, $this->data);
    }

     public function add_row() {
        
            $d = ORM::for_table('tbl_appointment_time')->create();
            $d->title                  = @$_POST['title'];
            $d->status                  = isset($_POST['status']) ? $_POST['status'] : 'active';
            $d->created_by_user_id      = $this->session->userdata('loginid');
            $d->inserted_time           = date('Y-m-d H:i:s');
          
            if($d->save()){
                $output['status'] = 1;
                $output['msg'] = 'Successfully add Record';    
            }else{
                $output['status'] = 0;
                $output['msg'] = 'somthing wrong !';
            }
            echo json_encode($output); 
        
        
    }

    public function edit($id) {
        $meta['page_title'] = ' EDIT Appointment time ';
        if($_POST && $_POST['title'] != '' ) {
            if($this->mdl->update_row($_POST)) {
                $this->session->set_flashdata('success',lang('Our News Update successfully'));
                redirect('admin/appointment_time');
            } else {
                $this->session->set_flashdata('error',lang('Our News Update fail'));
                redirect('admin/appointment_time');
            }
        } else {
          $this->data['row'] = $this->mdl->get($id);
            $this->page_construct('appointment_time/edit',$meta, $this->data);
        }
    }
     public function row_delete($id) {
        $this->sam->_delete_by_id($id,'tbl_appointment_time');
    }
}
