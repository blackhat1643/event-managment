<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Our_facilities extends MY_Controller {

    function __construct()
    {
        parent::__construct();

        if (!$this->loggedIn) {
            $this->session->set_userdata('requested_page', $this->uri->uri_string());
            admin_redirect('login');
        }

        $this->load->library('form_validation');
        $this->load->model('Mdl_our_facilities','mdl');
        $this->load->library('pagination');
    }

    public function unset_session_value() {

    $this->session->unset_userdata('our_facilities_s_status');
    $this->session->unset_userdata('our_facilities_s_title');

    $this->session->unset_userdata('our_facilities_serach_page');
    $this->session->unset_userdata('our_facilities_search_data');
    redirect('admin/our_facilities');

  } 
    
    public function index() {
        // Pagination Start
        $w = $l = '';
       
        $paginationdata = $this->data['Settings']->rows_per_page;
       
        if($_POST) {
            
            if(isset($_POST['our_facilities_s_title']) AND $_POST['our_facilities_s_title'] != '') {
                $w .= " AND title like '%".$_POST['our_facilities_s_title']."%'";
                $this->session->set_userdata('our_facilities_s_title',$_POST['our_facilities_s_title']);
            }
            if(isset($_POST['our_facilities_s_status']) AND $_POST['our_facilities_s_status'] != '') {
                $w .= " AND status ='".$_POST['our_facilities_s_status']."'";
                $this->session->set_userdata('our_facilities_s_status',$_POST['our_facilities_s_status']);
            }

            $_SESSION['our_facilities_search_data'] = $w;
            $this->session->set_userdata('our_facilities_search_data',$w);
        }

       if(isset($this->session->our_facilities_search_data) AND $this->session->our_facilities_search_data != '')
       {
             $w = $this->session->userdata('our_facilities_search_data');
       }
        $w = $this->session->userdata('our_facilities_search_data');
        $Record =  $this->mdl->get_count($w);  
        
        $config = $this->sam->pagination_config();
        $config['base_url'] = site_url().'admin/our_facilities/index';
        $config['total_rows'] = $Record;
        $config['per_page'] = $paginationdata;
        $this->pagination->initialize($config);
        
        $meta['page_title'] = 'Our Facilities';
        $this->data['rows'] = $this->mdl->get_all_with_pagi('id',$config['per_page'],$this->uri->segment(4),$w);
        $this->page_construct('our_facilities/view', $meta, $this->data);
    }

     public function add_row() {
        
            $d = ORM::for_table('tbl_our_facilities')->create();
            $d->title                    = @$_POST['title'];
            $d->description             = @$_POST['description'];
        
            if(is_uploaded_file($_FILES['image']['tmp_name'])) {
            $this->sam->upload_image('image','themes/assets/images/facilities_image/',$rand);
            $d->image = $rand.$_FILES['image']['name'];
            }

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
        $meta['page_title'] = ' EDIT Our Fcilities ';
        if($_POST && $_POST['title'] != '' ) {
            if($this->mdl->update_row($_POST)) {
                $this->session->set_flashdata('success',lang('Our Fcilities Update successfully'));
                redirect('admin/our_facilities');
            } else {
                $this->session->set_flashdata('error',lang('Our Fcilities Update fail'));
                redirect('admin/our_facilities');
            }
        } else {
            $this->data['row'] = $this->mdl->get($id);
            $this->page_construct('our_facilities/edit',$meta, $this->data);
        }
    }
     public function row_delete($id) {
        $this->sam->_delete_by_id($id,'tbl_our_facilities');
    }
}
