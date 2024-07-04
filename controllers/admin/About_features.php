<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class about_features extends MY_Controller {

    function __construct()
    {
        parent::__construct();

        if (!$this->loggedIn) {
            $this->session->set_userdata('requested_page', $this->uri->uri_string());
            admin_redirect('login');
        }

        $this->load->library('form_validation');
        $this->load->model('Mdl_about_features','mdl');
        $this->load->library('pagination');
    }

    public function unset_session_value() {

    $this->session->unset_userdata('about_features_s_status');
    $this->session->unset_userdata('about_features_s_title');
    $this->session->unset_userdata('about_features_search_data');
    redirect('admin/about_features');

  } 
    
    public function index() {
        // Pagination Start
        $w = $l = '';
       
        $paginationdata = $this->data['Settings']->rows_per_page;
       
        if($_POST) {
            
            if(isset($_POST['about_features_s_title']) AND $_POST['about_features_s_title'] != '') {
                $w .= " AND title like '%".$_POST['about_features_s_title']."%'";
                $this->session->set_userdata('about_features_s_title',$_POST['about_features_s_title']);
            }
            if(isset($_POST['about_features_s_status']) AND $_POST['about_features_s_status'] != '') {
                $w .= " AND status ='".$_POST['about_features_s_status']."'";
                $this->session->set_userdata('about_features_s_status',$_POST['about_features_s_status']);
            }

            $_SESSION['about_features_search_data'] = $w;
            $this->session->set_userdata('about_features_search_data',$w);
        }

        if(isset($this->session->about_features_search_data) AND $this->session->about_features_search_data != ''){
             $w = $this->session->userdata('about_features_search_data');
        }

        $w = $this->session->userdata('about_features_search_data');
        $Record =  $this->mdl->get_count($w);  
        
        $config = $this->sam->pagination_config();
        $config['base_url'] = site_url().'admin/about_features/index';
        $config['total_rows'] = $Record;
        $config['per_page'] = $paginationdata;
        $this->pagination->initialize($config);
        
        $meta['page_title'] = 'Features';
        $this->data['rows'] = $this->mdl->get_all_with_pagi('id',$config['per_page'],$this->uri->segment(4),$w);
        $this->page_construct('about_features/view', $meta, $this->data);
    }

     public function add_row() {
            $d = ORM::for_table('tbl_about_features')->create();
           
            $d->title                   = @$_POST['title'];
            $d->description             = @$_POST['description'];
            $d->status                  = isset($_POST['status']) ? $_POST['status'] : 'active';
            $d->created_by_user_id      = $this->session->userdata('loginid');
            $d->inserted_time           = date('Y-m-d H:i:s');

            if(!empty($_FILES['image']['tmp_name'])){
              $rand = rand();
              $this->sam->upload_image('image','themes/default/front/assets//images/event/',$rand);
              $d->image = $rand.$_FILES['image']['name'];
            }

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
        $meta['page_title'] = ' Edit Features ';
        if($_POST && $_POST['title'] != '' ) {
            if($this->mdl->update_row($_POST)) {
                $this->session->set_flashdata('success',lang('Update successfully'));
                redirect('admin/about_features');
            } else {
                $this->session->set_flashdata('error',lang(' Update fail'));
                redirect('admin/about_features');
            }
        } else {
            $this->data['row'] = $this->mdl->get($id);
            $this->page_construct('about_features/edit',$meta, $this->data);
        }
    }

     public function row_delete($id) {
        $this->sam->_delete_by_id($id,'tbl_about_features');
    }
}
