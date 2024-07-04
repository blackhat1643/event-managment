<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class home_activities extends MY_Controller {

    function __construct()
    {
        parent::__construct();

        if (!$this->loggedIn) {
            $this->session->set_userdata('requested_page', $this->uri->uri_string());
            admin_redirect('login');
        }

        $this->load->library('form_validation');
        $this->load->model('Mdl_home_activities','mdl');
        $this->load->library('pagination');
    }

    public function unset_session_value() {

    $this->session->unset_userdata('home_activities_s_status');
    $this->session->unset_userdata('home_activities_s_title');

    $this->session->unset_userdata('home_activities_serach_page');
    $this->session->unset_userdata('home_activities_search_data');
    redirect('admin/home_activities');

  } 
    
    public function index() {
        // Pagination Start
        $w = $l = '';
       
        $paginationdata = $this->data['Settings']->rows_per_page;
       
        if($_POST) {
            
            if(isset($_POST['home_activities_s_title']) AND $_POST['home_activities_s_title'] != '') {
                $w .= " AND title like '%".$_POST['home_activities_s_title']."%'";
                $this->session->set_userdata('home_activities_s_title',$_POST['home_activities_s_title']);
            }
            if(isset($_POST['home_activities_s_status']) AND $_POST['home_activities_s_status'] != '') {
                $w .= " AND status ='".$_POST['home_activities_s_status']."'";
                $this->session->set_userdata('home_activities_s_status',$_POST['home_activities_s_status']);
            }

            $_SESSION['home_activities_search_data'] = $w;
            $this->session->set_userdata('home_activities_search_data',$w);
        }

       if(isset($this->session->home_activities_search_data) AND $this->session->home_activities_search_data != '')
       {
             $w = $this->session->userdata('home_activities_search_data');
       }
        $w = $this->session->userdata('home_activities_search_data');
        $Record =  $this->mdl->get_count($w);  
        
        $config = $this->sam->pagination_config();
        $config['base_url'] = site_url().'admin/home_activities/index';
        $config['total_rows'] = $Record;
        $config['per_page'] = $paginationdata;
        $this->pagination->initialize($config);
        
        $meta['page_title'] = 'Home Achievement';
        $this->data['rows'] = $this->mdl->get_all_with_pagi('id',$config['per_page'],$this->uri->segment(4),$w);
        $this->page_construct('home_activities/view', $meta, $this->data);
    }

     public function add_row() {
            $d = ORM::for_table('tbl_home_activities')->create();
           
            $d->title                    = @$_POST['title'];
            $d->count_txt             = @$_POST['count_txt'];
            $d->icon_txt             = @$_POST['icon_txt'];
            $d->icon_style               = @$_POST['icon_style'];
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
        $meta['page_title'] = ' EDIT Home Achievement ';
        if($_POST && $_POST['title'] != '' ) {
            if($this->mdl->update_row($_POST)) {
                $this->session->set_flashdata('success',lang('Home Achievement Update successfully'));
                redirect('admin/home_activities');
            } else {
                $this->session->set_flashdata('error',lang('Home Achievement Update fail'));
                redirect('admin/home_activities');
            }
        } else {
            $this->data['row'] = $this->mdl->get($id);
            $this->page_construct('home_activities/edit',$meta, $this->data);
        }
    }
     public function row_delete($id) {
        $this->sam->_delete_by_id($id,'tbl_home_activities');
    }
}
