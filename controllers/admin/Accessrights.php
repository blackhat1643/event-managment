<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Accessrights extends MY_Controller {

	function __construct()
    {
        parent::__construct();

        if (!$this->loggedIn) {
            $this->session->set_userdata('requested_page', $this->uri->uri_string());
            admin_redirect('login');
        }

        $this->load->library('form_validation');
        $this->load->model('mdl_user','mdl');
        // $this->load->model('mdl_accessrights','model');

        $this->load->library('pagination');
    }
    
	public function index() {
        // Pagination Start
        $config = $this->sam->pagination_config();
        $config['base_url'] = site_url().'accessrights/index';
        $config['total_rows'] = $this->mdl->get_count();
        $config['per_page'] = $this->data['Settings']->rows_per_page;
        $this->pagination->initialize($config);
        // Pagination End
		$meta['page_title'] = 'Access Rights';

       // $this->data['users'] = $this->mdl->get_users($config['per_page'],$this->uri->segment(3));
       // $this->load->model('mdl_branch');
       // $this->data['branchs'] = $this->mdl_branch->get_all();

        $this->data['roles'] = $this->sam->get_roles();


		$this->page_construct('accessrights/view', $meta, $this->data);

	}




    public function edit($id) {
        $meta['page_title'] = lang('edituser');
        if($_POST && $_POST['fname'] != '' && $_POST['sname'] != '') {



            if($this->mdl->Mdl_accessrights($_POST)) {
                $this->session->set_flashdata('success',lang('uupdate'));
                redirect('accessrights');
            } else {
                $this->session->set_flashdata('error',lang('uupdatef'));
                redirect('accessrights');
            }


        } else {

          //  $this->data['user'] = $this->mdl->get_user($id);
           // $this->load->model('mdl_branch');
           // $this->data['branchs'] = $this->mdl_branch->get_all();

           
            $this->data['roles'] = $this->sam->get_roles();
            

            $this->page_construct('accessrights/edit',$meta, $this->data);
        }
    }



    public function getaccessrights($id) {
               $d = ORM::for_table('sam_accessrights')
                ->where('role_id',$id)               
                ->where('is_deleted',0)
                ->find_array(); 
 
                $output = "";
                $output .='<input type="hidden" name="role_id" id="role_id" class="role_id" value="'.$id.'">';
        foreach ($d as $dl) {
                   $create_access = ""; 
                   $edit_access = "";
                   $view_access = "";
                   $delete_access = "";

                if($dl['create_access'] == 'yes'){ $create_access = 'checked'; }else{ $create_access = ''; }
                if($dl['edit_access'] == 'yes'){ $edit_access = 'checked'; }else{ $edit_access = ''; }
                if($dl['view_access'] == 'yes'){ $view_access = 'checked'; }else{ $view_access = ''; }
                if($dl['delete_access'] == 'yes'){ $delete_access = 'checked'; }else{ $delete_access = ''; }
                
                 $output .='<tr>
                            <td>'.ucfirst($dl['page_title']).'
                            <input type="hidden" name="page_title[]" value="'.$dl['page_title'].'"></td>
                            <td class="text-center"><input  type="checkbox" class="checkbox_c" value="yes" name="create_'.$dl['page_title'].'"  '.$create_access.'></td>
                            <td class="text-center"><input type="checkbox" class="checkbox_c" value="yes" name="view_'.$dl['page_title'].'" '.$view_access.' ></td>
                            <td class="text-center"><input type="checkbox" class="checkbox_c" value="yes" name="edit_'.$dl['page_title'].'" '.$edit_access.'></td>
                            <td class="text-center"><input type="checkbox" value="yes" class="checkbox_c" name="delete_'.$dl['page_title'].'" '.$delete_access.'></td>
                         </tr>';
                }
            echo $output;
    }


    public function saveaccessrole() {


        $serialize_data = $_REQUEST['serializedata'];
        parse_str($serialize_data,$dataarray);


        $d = ORM::for_table('sam_accessrights')
                ->where('role_id',$dataarray['role_id'])               
                ->where('is_deleted',0)
                ->find_array();
               
         if($d){
            foreach ($d as $rl) {            
                // matched page title update
                   if(in_array($rl['page_title'], $dataarray['page_title'])){
                        $dataarray['id'] = $rl['id'];  
                        $this->mdl->update_accessrights($dataarray);
                        }
                       $dbpagettitle[] = $rl['page_title'];
                    }
                // unmatched page title insert 
                if($result = array_diff_assoc($dataarray['page_title'],$dbpagettitle)){

                foreach ($result as $resultloop) {
                
                      $d = ORM::for_table('sam_accessrights')->create();

                        $d->page_title          = $resultloop;                        
                        $d->role_id           = $dataarray['role_id'];

                        $d->create_access        = isset($dataarray['create_'.$resultloop]) ? $dataarray['create_'.$resultloop] : 'no';
                        
                        $d->edit_access          = isset($dataarray['edit_'.$resultloop]) ? $dataarray['edit_'.$resultloop] : 'no';
                        
                        $d->view_access          = isset($dataarray['view_'.$resultloop]) ? $dataarray['view_'.$resultloop] : 'no';
                        
                        $d->delete_access        = isset($dataarray['delete_'.$resultloop]) ? $dataarray['delete_'.$resultloop] : 'no';
                        $d->save();     


                     }
                       //if($d->id) { return $d->id; } else { return FALSE; }
                   }
            }else{

                // New Role assign

                foreach ($dataarray['page_title'] as $newrole) {
                      $b = ORM::for_table('sam_accessrights')->create();
                        $b->page_title          = $newrole;                        
                        $b->role_id           = $dataarray['role_id'];
                        $b->create_access        = isset($dataarray['create_'.$newrole]) ? $dataarray['create_'.$newrole] : 'no';
                        
                        $b->edit_access          = isset($dataarray['edit_'.$newrole]) ? $dataarray['edit_'.$newrole] : 'no';
                        
                        $b->view_access          = isset($dataarray['view_'.$newrole]) ? $dataarray['view_'.$newrole] : 'no';
                        
                        $b->delete_access        = isset($dataarray['delete_'.$newrole]) ? $dataarray['delete_'.$newrole] : 'no';
                        $b->save();     
                     }
            }


    }

    

    






}
