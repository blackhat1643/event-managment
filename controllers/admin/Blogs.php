<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Blogs extends MY_Controller {

    function __construct()
    {
        parent::__construct();

        if (!$this->loggedIn) {
            $this->session->set_userdata('requested_page', $this->uri->uri_string());
            admin_redirect('login');
        }

        $this->load->library('form_validation');
        $this->load->model('Mdl_blogs','mdl');
        $this->load->library('pagination');
    }

    public function unset_session_value() {

    $this->session->unset_userdata('blog_s_status');
    $this->session->unset_userdata('blog_s_title');

    $this->session->unset_userdata('blog_serach_page');
    $this->session->unset_userdata('blog_search_data');
    redirect('admin/blogs');

  } 
    
    public function index() {
        // Pagination Start
        $w = $l = '';
       
        $paginationdata = $this->data['Settings']->rows_per_page;
       
        if($_POST) {
            
            if(isset($_POST['blog_s_title']) AND $_POST['blog_s_title'] != '') {
                $w .= " AND title like '%".$_POST['blog_s_title']."%'";
                $this->session->set_userdata('blog_s_title',$_POST['blog_s_title']);
            }
            if(isset($_POST['blog_s_status']) AND $_POST['blog_s_status'] != '') {
                $w .= " AND status ='".$_POST['blog_s_status']."'";
                $this->session->set_userdata('blog_s_status',$_POST['blog_s_status']);
            }

            $_SESSION['blog_search_data'] = $w;
            $this->session->set_userdata('blog_search_data',$w);
        }

       if(isset($this->session->blog_search_data) AND $this->session->blog_search_data != '')
       {
             $w = $this->session->userdata('blog_search_data');
       }
        $w = $this->session->userdata('blog_search_data');
        $Record =  $this->mdl->get_count($w);  
        
        $config = $this->sam->pagination_config();
        $config['base_url'] = site_url().'admin/blogs/index';
        $config['total_rows'] = $Record;
        $config['per_page'] = $paginationdata;
        $this->pagination->initialize($config);
        
        $meta['page_title'] = 'Blogs';
        $this->data['rows'] = $this->mdl->get_all_with_pagi('id',$config['per_page'],$this->uri->segment(4),$w);
        $this->page_construct('blogs/view', $meta, $this->data);
    }

     public function add_row() {
        
            $d = ORM::for_table('tbl_blogs')->create();
            $d->title                  = @$_POST['title'];
            $d->sub_title              = @$_POST['sub_title'];
            $d->short_description      = @$_POST['short_description'];
            $d->description            = @$_POST['description'];
            $d->created_by             = @$_POST['created_by'];
            $d->news_date              = date('Y-m-d',strtotime(@$_POST['news_date']));
            
            if(is_uploaded_file($_FILES['news_image']['tmp_name'])) {
                $rand = rand();
                $this->sam->upload_image('news_image','themes/default/front/assets/images/blog/',$rand);
                $d->news_image = $rand.$_FILES['news_image']['name'];
            }
            
            if(is_uploaded_file($_FILES['banner']['tmp_name'])) {
                $rand = rand();
                $this->sam->upload_image('banner','themes/default/front/assets/images/blog/',$rand);
                $d->banner = $rand.$_FILES['banner']['name'];
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
        $meta['page_title'] = ' EDIT Blogs ';
        if($_POST && $_POST['title'] != '' ) {
            if($this->mdl->update_row($_POST)) {
                $this->session->set_flashdata('success',lang('Our Fcilities Update successfully'));
                redirect('admin/blogs');
            } else {
                $this->session->set_flashdata('error',lang('Our Fcilities Update fail'));
                redirect('admin/blogs');
            }
        } else {
             $this->data['row'] = $this->mdl->get($id);
            $this->page_construct('blogs/edit',$meta, $this->data);
        }
    }
     public function row_delete($id) {
        $this->sam->_delete_by_id($id,'tbl_blogs');
    }
}
