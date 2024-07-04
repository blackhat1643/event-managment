<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class why_choose_us extends MY_Controller {

    function __construct()
    {
        parent::__construct();

        if (!$this->loggedIn) {
            $this->session->set_userdata('requested_page', $this->uri->uri_string());
            admin_redirect('login');
        }

        $this->load->library('form_validation');
        $this->load->model('Mdl_why_choose_us','mdl');
        $this->load->library('pagination');
    }

    public function unset_session_value() {

    $this->session->unset_userdata('why_choose_us_s_status');
    $this->session->unset_userdata('why_choose_us_s_title');

    $this->session->unset_userdata('why_choose_us_serach_page');
    $this->session->unset_userdata('why_choose_us_search_data');
    redirect('admin/why_choose_us');

  } 
    
    public function index() {
        // Pagination Start
        $w = $l = '';
       
        $paginationdata = $this->data['Settings']->rows_per_page;
       
        if($_POST) {
            
            if(isset($_POST['why_choose_us_s_title']) AND $_POST['why_choose_us_s_title'] != '') {
                $w .= " AND title like '%".$_POST['why_choose_us_s_title']."%'";
                $this->session->set_userdata('why_choose_us_s_title',$_POST['why_choose_us_s_title']);
            }
            if(isset($_POST['why_choose_us_s_status']) AND $_POST['why_choose_us_s_status'] != '') {
                $w .= " AND status ='".$_POST['why_choose_us_s_status']."'";
                $this->session->set_userdata('why_choose_us_s_status',$_POST['why_choose_us_s_status']);
            }

            $_SESSION['why_choose_us_search_data'] = $w;
            $this->session->set_userdata('why_choose_us_search_data',$w);
        }

       if(isset($this->session->why_choose_us_search_data) AND $this->session->why_choose_us_search_data != '')
       {
             $w = $this->session->userdata('why_choose_us_search_data');
       }
        $w = $this->session->userdata('why_choose_us_search_data');
        $Record =  $this->mdl->get_count($w);  
        
        $config = $this->sam->pagination_config();
        $config['base_url'] = site_url().'admin/why_choose_us/index';
        $config['total_rows'] = $Record;
        $config['per_page'] = $paginationdata;
        $this->pagination->initialize($config);
        
        $meta['page_title'] = 'why choose us';
        $this->data['rows'] = $this->mdl->get_all_with_pagi('id',$config['per_page'],$this->uri->segment(4),$w);
        $this->page_construct('why_choose_us/view', $meta, $this->data);
    }

     public function add_row() {
            $d = ORM::for_table('tbl_why_choose_us')->create();
           
            $d->title                    = @$_POST['title'];
            $d->description             = @$_POST['description'];
            $d->icon_txt             = @$_POST['icon_txt'];
            $d->icon_txt_2             = @$_POST['icon_txt_2'];
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
        $meta['page_title'] = ' EDIT Why Choose Us ';
        if($_POST && $_POST['title'] != '' ) {
            if($this->mdl->update_row($_POST)) {
                $this->session->set_flashdata('success',lang('Achievement Update successfully'));
                redirect('admin/why_choose_us');
            } else {
                $this->session->set_flashdata('error',lang('Achievement Update fail'));
                redirect('admin/why_choose_us');
            }
        } else {
            $this->data['row'] = $this->mdl->get($id);
            $this->page_construct('why_choose_us/edit',$meta, $this->data);
        }
    }
     public function row_delete($id) {
        $this->sam->_delete_by_id($id,'tbl_why_choose_us');
    }
}
