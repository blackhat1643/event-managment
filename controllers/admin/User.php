<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends MY_Controller {

    function __construct()
    {
        parent::__construct();

        if (!$this->loggedIn) {
            $this->session->set_userdata('requested_page', $this->uri->uri_string());
            admin_redirect('login');
        }

        $this->load->library('form_validation');
        $this->load->model('mdl_user','mdl');
        $this->load->library('pagination');
    }
       

     public function unset_session_value() {

        $this->session->unset_userdata('user_s_status');
        $this->session->unset_userdata('user_s_mobile');
        $this->session->unset_userdata('user_s_email');
        $this->session->unset_userdata('user_s_designation');
        $this->session->unset_userdata('user_s_name');
        $this->session->unset_userdata('user_serach_data');
        $this->session->unset_userdata('user_serach_page');
        redirect('admin/user');

    }  
    
    public function index() {
        
        $w = $l = '';
        $paginationdata = $this->data['Settings']->rows_per_page;

        if($_POST) {
            if(isset($_POST['user_s_mobile']) AND $_POST['user_s_mobile'] != '') {
                $w .= " AND mobile ='".$_POST['user_s_mobile']."'";
                $this->session->set_userdata('user_s_mobile',$_POST['user_s_mobile']);
            }
            if(isset($_POST['user_s_designation']) AND $_POST['user_s_designation'] != '') {
                $w .= " AND role ='".$_POST['user_s_designation']."'";
                $this->session->set_userdata('user_s_designation',$_POST['user_s_designation']);
            }
            if(isset($_POST['user_s_email']) AND $_POST['user_s_email'] != '') {
                $w .= " AND email_id ='".$_POST['user_s_email']."'";
                $this->session->set_userdata('user_s_email',$_POST['user_s_email']);
            }
            if(isset($_POST['user_s_name']) AND $_POST['user_s_name'] != '') {
                $w .= " AND first.name like '%".$_POST['user_s_name']."'";
                $this->session->set_userdata('user_s_name',$_POST['user_s_name']);
            }
            if(isset($_POST['user_s_status']) AND $_POST['user_s_status'] != '') {
                $w .= " AND first.status ='".$_POST['user_s_status']."'";
                $this->session->set_userdata('user_s_status',$_POST['user_s_status']);
            }

            $_SESSION['user_serach_data'] = $w;
            $this->session->set_userdata('user_serach_data',$w);

        }

        if(isset($this->session->user_serach_data) AND $this->session->user_serach_data != ''){
             $w = $this->session->userdata('user_serach_data');
        }

        $Record = $this->mdl->get_search_count($paginationdata,$w);
        $config = $this->sam->pagination_config();
        $config['base_url'] = site_url().'admin/user/index';
        $config['total_rows'] = $Record;
        $config['per_page'] = $paginationdata;
        $this->pagination->initialize($config);

        $meta['page_title'] = 'Employee master';
        $this->data['rows'] = $this->mdl->get_all_with_pagi('id',$config['per_page'],$this->uri->segment(4),$w);
        
         if(isset($_POST['SearchValue']))
        {
          if($_POST['SearchValue'] == 'excel')
          {
            $this->Exportuser($this->data['users']);
          }    
        }
        $this->page_construct('user/view', $meta, $this->data);
    }

      public function add_row() 
    {
        $d = ORM::for_table('sam_users')->create();
        $d->name                     = $_POST['name'];
        $d->email_id                 = $_POST['email'];
        $d->mobile                   = $_POST['mobile'];
        $d->password                = ($_POST['pwd']!= "") ? md5($_POST['pwd']) : '';
        $d->password_txt            = ($_POST['pwd']!= "") ? $_POST['pwd'] : '';
        $d->status                   = isset($_POST['status']) ? $_POST['status'] : 'active';
        $d->is_deleted               = '0';
        $d->inserted_time            = date('Y-m-d H:i:s');
        $d->created_by_user_id       = $this->session->userdata('loginid');

        $d->save();
        echo $d->id;
    }
    
    
    public function edit($id) {
        $meta['page_title'] = 'Edit Employee master';
        if($_POST && $_POST['name'] != '') {
            if($this->mdl->update_row($_POST)) {
                $this->session->set_flashdata('success',lang('User Update successfully'));
                redirect('user');
            } else {
                $this->session->set_flashdata('error',lang('User Update fail'));
                redirect('user');
            }
        } else {
            
            $this->data['row'] = $this->mdl->get($id);
            $this->page_construct('user/edit',$meta, $this->data);
        }
    }

   public function user_profile_edit($id) {
        $meta['page_title'] = lang('Update Profile');
        if($_POST) {
            if($this->mdl->update_row($_POST)) {
                $this->session->set_flashdata('success',lang('uupdate'));
                redirect($_SERVER['HTTP_REFERER']);

            } else {
                redirect('admin');
            }
        } else {
            $this->data['user'] = $this->mdl->get($id);
            $this->page_construct('user/user_profile_update',$meta, $this->data);
        }
    }

     function citylistby_state()
     {
        $d = ORM::for_table('zyd_city')->whereIn('state_id',$_POST['state_id'])->where('is_deleted','0')->find_array();
        echo json_encode($d);

     }


}
