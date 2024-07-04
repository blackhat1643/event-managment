<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Adminusers extends MY_Controller {

    function __construct()
    {
        parent::__construct();

        if (!$this->loggedIn) {
            $this->session->set_userdata('requested_page', $this->uri->uri_string());
            admin_redirect('login');
        }

        $this->load->library('form_validation');
        $this->load->model('Mdl_adminuser','mdl');
        $this->load->library('pagination');
    }

    public function unset_session_value() {

    $this->session->unset_userdata('admin_s_status');
    $this->session->unset_userdata('admin_s_mobile');
    $this->session->unset_userdata('admin_s_email');
    $this->session->unset_userdata('admin_s_designation');
    $this->session->unset_userdata('admin_s_name');

    $this->session->unset_userdata('adminusers_serach_page');
    $this->session->unset_userdata('adminusers_serach_data');
    redirect('admin/adminusers');

  } 
    
    public function index() {
        // Pagination Start
        $w = '';

        if($this->session->adminusers_serach_page != 'adminusers')
        {
            $this->session->unset_userdata('adminusers_serach_data');
            $this->session->unset_userdata('adminusers_serach_page');
        }  

        $paginationdata = $this->data['Settings']->rows_per_page;

        if($_POST) {
            
            if(isset($_POST['admin_s_mobile']) AND $_POST['admin_s_mobile'] != '') {
                $w .= " AND mobile ='".$_POST['admin_s_mobile']."'";
                $this->session->set_userdata('admin_s_mobile',$_POST['admin_s_mobile']);
            }
            if(isset($_POST['admin_s_designation']) AND $_POST['admin_s_designation'] != '') {
                $w .= " AND role ='".$_POST['admin_s_designation']."'";
                $this->session->set_userdata('admin_s_designation',$_POST['admin_s_designation']);
            }
            if(isset($_POST['admin_s_email']) AND $_POST['admin_s_email'] != '') {
                $w .= " AND email_id ='".$_POST['admin_s_email']."'";
                $this->session->set_userdata('admin_s_email',$_POST['admin_s_email']);
            }
            if(isset($_POST['admin_s_name']) AND $_POST['admin_s_name'] != '') {
                $w .= " AND name like '%".$_POST['admin_s_name']."%'";
                $this->session->set_userdata('state_s_state',$_POST['admin_s_name']);
            }
            if(isset($_POST['admin_s_status']) AND $_POST['admin_s_status'] != '') {
                $w .= " AND status ='".$_POST['admin_s_status']."'";
                $this->session->set_userdata('admin_s_status',$_POST['admin_s_status']);
            }

            $_SESSION['adminusers_serach_data'] = $w;
            $this->session->set_userdata('adminusers_serach_data',$w);
            $this->session->set_userdata('adminusers_serach_page','adminusers');

        }

        if(isset($this->session->adminusers_serach_data) AND $this->session->adminusers_serach_data != '')
        {
             $w = $this->session->userdata('adminusers_serach_data');
        }
        if($_POST)
        { 
               $Record = $this->mdl->get_search_count($paginationdata,$w);
        }else{
            if(isset($this->session->adminusers_serach_data) AND $this->session->adminusers_serach_data != '')
            {
                 $w = $this->session->userdata('adminusers_serach_data');
                 $Record = $this->mdl->get_search_count($paginationdata,$w);
            }
            else
            {   
                  $Record =  $this->mdl->get_count();  
            }
        }
        
        $config = $this->sam->pagination_config();
        $config['base_url'] = site_url().'admin/adminusers/index';
        $config['total_rows'] = $Record;
        $config['per_page'] = $paginationdata;
        $this->pagination->initialize($config);
        
        $meta['page_title'] = 'Admin User';
        $this->data['users'] = $this->mdl->get_users($config['per_page'],$this->uri->segment(4),$w);
        $this->data['roles'] = $this->sam->get_roles();
        $this->page_construct('adminusers/view', $meta, $this->data);
    }

     public function add_row() {
        
        $checkexist = ORM::for_table('sam_users')->where('email_id',$_POST['email'])->where('is_deleted','0')->find_one();
        if(!empty($checkexist))
        {
            $output['status'] = 2;
            $output['msg'] = 'this email id already exist';
            echo json_encode($output); 
        }else{

            $d = ORM::for_table('sam_users')->create();
            $d->emp_code                = @$_POST['emp_code'];
            $d->name                    = @$_POST['name'];
            $d->email_id                = @$_POST['email'];
            $d->mobile                  = @$_POST['mobile'];
            $d->type                    = 'admin';
            $d->password_txt            = ($_POST['pwd']!= "") ? $_POST['pwd'] : $d->password_txt;
            $d->password                = ($_POST['pwd']!= "") ? md5($_POST['pwd']) : $d->password;
            $d->status                  = isset($_POST['status']) ? $_POST['status'] : 'active';
            $d->created_by              = $this->session->userdata('loginid');
            $d->inserted_time           = date('Y-m-d H:i:s');
            if($d->save())
            {
                $output['status'] = 1;
                $output['msg'] = 'Successfully add Record';    
            }else{
                $output['status'] = 0;
                $output['msg'] = 'somthing wrong !';
            }
            echo json_encode($output); 
        }
    }

    public function edit($id) {
        $meta['page_title'] = 'Admin User';
        if($_POST && $_POST['name'] != '' ) {
            if($this->mdl->update_adminuser($_POST)) {
                $this->session->set_flashdata('success',lang('Admin Update successfully'));
                redirect('admin/adminusers');
            } else {
                $this->session->set_flashdata('error',lang('Admin Update fail'));
                redirect('admin/adminusers');
            }
        } else {
            $this->data['user'] = $this->mdl->get_user($id);
            $this->data['roles'] = $this->sam->get_roles();
            $this->page_construct('adminusers/edit',$meta, $this->data);
        }
    }
     public function row_delete($id) {
        $this->sam->_delete_by_id($id,'sam_users');
    }
}
