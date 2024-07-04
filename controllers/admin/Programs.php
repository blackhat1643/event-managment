<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class programs extends MY_Controller {

    function __construct()
    {
        parent::__construct();

        if (!$this->loggedIn) {
            $this->session->set_userdata('requested_page', $this->uri->uri_string());
            admin_redirect('login');
        }

        $this->load->library('form_validation');
        $this->load->model('Mdl_programs','mdl');
        $this->load->library('pagination');
    }

    public function unset_session_value() {

    $this->session->unset_userdata('programs_s_status');
    $this->session->unset_userdata('programs_s_title');
    $this->session->unset_userdata('programs_search_data');
    redirect('admin/programs');

  } 
    
    public function index() {
        // Pagination Start
        $w = $l = '';
       
        $paginationdata = $this->data['Settings']->rows_per_page;
       
        if($_POST) {
            
            if(isset($_POST['programs_s_title']) AND $_POST['programs_s_title'] != '') {
                $w .= " AND title like '%".$_POST['programs_s_title']."%'";
                $this->session->set_userdata('programs_s_title',$_POST['programs_s_title']);
            }
            if(isset($_POST['programs_s_status']) AND $_POST['programs_s_status'] != '') {
                $w .= " AND status ='".$_POST['programs_s_status']."'";
                $this->session->set_userdata('programs_s_status',$_POST['programs_s_status']);
            }

            $_SESSION['programs_search_data'] = $w;
            $this->session->set_userdata('programs_search_data',$w);
        }

        if(isset($this->session->programs_search_data) AND $this->session->programs_search_data != ''){
             $w = $this->session->userdata('programs_search_data');
        }

        $w = $this->session->userdata('programs_search_data');
        $Record =  $this->mdl->get_count($w);  
        
        $config = $this->sam->pagination_config();
        $config['base_url'] = site_url().'admin/programs/index';
        $config['total_rows'] = $Record;
        $config['per_page'] = $paginationdata;
        $this->pagination->initialize($config);
        
        $meta['page_title'] = 'Programs';
        $this->data['rows'] = $this->mdl->get_all_with_pagi('id',$config['per_page'],$this->uri->segment(4),$w);
        $this->page_construct('programs/view', $meta, $this->data);
    }

     public function add_row() {
            $d = ORM::for_table('tbl_programs')->create();
           
            $d->title                   = @$_POST['title'];
            $d->sub_title               = @$_POST['sub_title'];
            $d->rs                      = @$_POST['rs'];
            $d->tag_1               = @$_POST['tag_1'];
            $d->tag_2               = @$_POST['tag_2'];
            $d->description             = @$_POST['description'];
            $d->icon_txt                = @$_POST['icon_txt'];
            $d->status                  = isset($_POST['status']) ? $_POST['status'] : 'active';
            $d->created_by_user_id      = $this->session->userdata('loginid');
            $d->inserted_time           = date('Y-m-d H:i:s');

            if(!empty($_FILES['image']['tmp_name'])){
              $rand = rand();
              $this->sam->upload_image('image','themes/default/front/assets/images/course/',$rand);
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
        $meta['page_title'] = ' Edit Programs ';
        if($_POST && $_POST['title'] != '' ) {
            if($this->mdl->update_row($_POST)) {
                $this->session->set_flashdata('success',lang('Update successfully'));
                redirect('admin/programs');
            } else {
                $this->session->set_flashdata('error',lang(' Update fail'));
                redirect('admin/programs');
            }
        } else {
            $this->data['row'] = $this->mdl->get($id);
            $this->page_construct('programs/edit',$meta, $this->data);
        }
    }

     public function row_delete($id) {
        $this->sam->_delete_by_id($id,'tbl_programs');
    }
}
