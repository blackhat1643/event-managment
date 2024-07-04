<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class gallery extends MY_Controller {

    function __construct()
    {
        parent::__construct();

        if (!$this->loggedIn) {
            $this->session->set_userdata('requested_page', $this->uri->uri_string());
            admin_redirect('login');
        }

        $this->load->library('form_validation');
        $this->load->model('Mdl_gallery','mdl');
        $this->load->library('pagination');
    }

    public function unset_session_value() {

        $this->session->unset_userdata('gallery_s_status');
        $this->session->unset_userdata('gallery_s_title');
        $this->session->unset_userdata('gallery_search_data');
        redirect('admin/gallery');

    } 
    
    public function index() {
        // Pagination Start
        $w = $l = '';

        $paginationdata = $this->data['Settings']->rows_per_page;

        if($_POST) {

            if(isset($_POST['gallery_s_title']) AND $_POST['gallery_s_title'] != '') {
                $w .= " AND title like '%".$_POST['gallery_s_title']."%'";
                $this->session->set_userdata('gallery_s_title',$_POST['gallery_s_title']);
            }
            if(isset($_POST['gallery_s_status']) AND $_POST['gallery_s_status'] != '') {
                $w .= " AND status ='".$_POST['gallery_s_status']."'";
                $this->session->set_userdata('gallery_s_status',$_POST['gallery_s_status']);
            }

            $_SESSION['gallery_search_data'] = $w;
            $this->session->set_userdata('gallery_search_data',$w);
        }

        if(isset($this->session->gallery_search_data) AND $this->session->gallery_search_data != ''){
           $w = $this->session->userdata('gallery_search_data');
       }

       $w = $this->session->userdata('gallery_search_data');
       $Record =  $this->mdl->get_count($w);  

       $config = $this->sam->pagination_config();
       $config['base_url'] = site_url().'admin/gallery/index';
       $config['total_rows'] = $Record;
       $config['per_page'] = $paginationdata;
       $this->pagination->initialize($config);

       $meta['page_title'] = 'Gallery';
       $this->data['category'] = ORM::for_table('tbl_category')
       ->where('status','active')
       ->where('is_deleted','0')
       ->find_array();
       $this->data['rows'] = $this->mdl->get_all_with_pagi('id',$config['per_page'],$this->uri->segment(4),$w);
       $this->page_construct('gallery/view', $meta, $this->data);
   }

   public function add_row() {
    $d = ORM::for_table('tbl_gallery')->create();

    $d->title                   = @$_POST['title'];

    if(@$_POST['category']>0)
    {
        $d->category       = implode(" ",@$_POST['category']);

    }
    else
    {
        $d->category       = "0";
    }

    $d->status                  = isset($_POST['status']) ? $_POST['status'] : 'active';
    $d->created_by_user_id      = $this->session->userdata('loginid');
    $d->inserted_time           = date('Y-m-d H:i:s');

    if(is_uploaded_file($_FILES['image']['tmp_name'])) {
        $rand = rand();
        $this->sam->upload_image('image','themes/default/front/assets/images/gallery/',$rand);
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
    $meta['page_title'] = ' Edit Gallery';
    if($_POST && $_POST['title'] != '' ) {
        if($this->mdl->update_row($_POST)) {
            $this->session->set_flashdata('success',lang('Update successfully'));
            redirect('admin/gallery');
        } else {
            $this->session->set_flashdata('error',lang(' Update fail'));
            redirect('admin/gallery');
        }
    } else {
        $this->data['row'] = $this->mdl->get($id);
        $this->page_construct('gallery/edit',$meta, $this->data);
    }
}

public function row_delete($id) {
    $this->sam->_delete_by_id($id,'tbl_gallery');
}
}
