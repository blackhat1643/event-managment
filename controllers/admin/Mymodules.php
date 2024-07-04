<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mymodules extends MY_Controller {

	function __construct()
    {
        parent::__construct();

        if (!$this->loggedIn) {
            $this->session->set_userdata('requested_page', $this->uri->uri_string());
            admin_redirect('login');
        }

        $this->load->library('form_validation');
        $this->load->model('Mdl_mymodules','mdl');
        $this->load->library('pagination');
    }


   public function unset_session_value() 
   {

    $this->session->unset_userdata('mymodules_s_name');
    $this->session->unset_userdata('mymodules_serach_data');
    redirect('admin/mymodules');

  }   

    public function index() {

        $w  = '';
        $paginationdata = $this->data['Settings']->rows_per_page;
        if($_POST) 
        {
            if(isset($_POST['mymodules_s_name']) AND $_POST['mymodules_s_name'] != '') 
            {
                $w .= " AND page_name like '%".$_POST['mymodules_s_name']."%'";
                $this->session->set_userdata('mymodules_s_name',$_POST['mymodules_s_name']);
            }
            $_SESSION['mymodules_serach_data'] = $w;
            $this->session->set_userdata('mymodules_serach_data',$w);

        }

        if(isset($this->session->mymodules_serach_data) AND $this->session->mymodules_serach_data != '')
        {
             $w = $this->session->userdata('mymodules_serach_data');
        }
        if($_POST)
        { 
               $Record = $this->mdl->get_search_count($paginationdata,$w);
        }else{
            if(isset($this->session->mymodules_serach_data) AND $this->session->mymodules_serach_data != '')
            {
                 $w = $this->session->userdata('mymodules_serach_data');
                 $Record = $this->mdl->get_search_count($paginationdata,$w);
            }
            else
            {   
                  $Record =  $this->mdl->get_count();  
            }
        }

        $config = $this->sam->pagination_config();
        $config['base_url'] = site_url().'admin/mymodules/index';
        $config['total_rows'] = $Record;
        $config['per_page'] = $paginationdata;
        $this->pagination->initialize($config);

        $this->data['rows'] = $this->mdl->get_all_with_pagi('id',$config['per_page'],$this->uri->segment(4),$w);
        
        $meta['page_title'] = 'My modules Master';
        $this->page_construct('mymodules/view', $meta, $this->data);
    }


    public function add_row() 
    {
        $roles = $this->sam->get_roles();
        $module_title = '';
        foreach ($roles as $role_key => $role) 
        {
            if(!empty($_POST['module_name']))
            {
                $checkesist =  ORM::for_table('sam_accessrights')->where('role_id',$role_key)->where('page_name',$_POST['module_name'])->find_one();
                if(empty($checkesist))
                {
                    $d = ORM::for_table('sam_accessrights')->create();
                    $d->role_id                = $role_key;
                    $d->module                 = $_POST['module_name'];
                    $d->page_title             = ucfirst(str_replace('_',' ',$_POST['module_name']));
                    $d->page_name              = ucfirst(str_replace('_',' ',$_POST['module_name']));
                    $d->create_access          = 'yes';
                    $d->edit_access            = 'yes';
                    $d->view_access            = 'yes';
                    $d->delete_access          = 'yes';
                    $d->is_deleted             = '0';
                    $d->save();    
                }
            }

        }
    }

   public function row_delete($id) {
        $this->_delete_by_id($id,'sam_accessrights');
   }
   
    public function _delete_by_id($id,$_table) {
        $d = ORM::for_table($_table)->where('module',$id)->delete_many();
        if($d) {
            return TRUE;
        } else {
           return FALSE;
        }
    }
    
}