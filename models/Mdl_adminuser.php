<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Mdl_adminuser extends CI_Model {

	public function __construct() {
		parent::__construct();
		$this->load->library('database');
	}

	private $_table = 'sam_users';





	public function get_users($limit = 10,$start = 0,$w) {
		if($w == ""){

			
			if($start == '')
			{
				$start = 0;
			}
			$d = ORM::for_table($this->_table)->where('is_deleted','0')
								->where('type','admin')	
								->order_by_desc('id')
								->limit($limit)
								->offset($start)
								->find_many();
		}else{
			if($start == '')
			{
				$start = 0;
			}
			$l = '';					
			$limit = $limit;
			$offset = $start;

	        $l = "LIMIT $offset,$limit";					

			$query = "SELECT * FROM `$this->_table` WHERE is_deleted = '0' AND type = 'admin' $w ORDER BY id DESC $l";
			

			$d = ORM::for_table('sam_users')->raw_query($query)->find_many();
		}					

		if($d) { return $d; } else { return FALSE; }
	}

	public function get_search_count($limit = 10,$w) {
			$query = "SELECT * FROM $this->_table WHERE is_deleted = '0' AND type = 'admin' $w ORDER BY id DESC";

			$TotalData = ORM::for_table('sam_users')->raw_query($query)->find_array();

			$d = count($TotalData);

		if($d) { return $d; } else { return FALSE; }
	}


	public function get_user($id) {
		$d = ORM::for_table($this->_table)
							->where('id',$id)
							->find_one();

		if($d) { return $d; } else { return FALSE; }
	}
	
	public function get_all() {
		$d = ORM::for_table($this->_table)->where('is_deleted','0')
							->order_by_asc('id')
							->find_many();

		if($d) { return $d; } else { return FALSE; }
	}
	
	public function get_user_turbine() {
		$d = ORM::for_table($this->_table)
							->where('status','active')
							->where('is_deleted','0')
							->find_many();

		if($d) { return $d; } else { return FALSE; }
	}
	
	

	public function get_count() {
		$d = ORM::for_table($this->_table)
				->where('status','active')
				->where('is_deleted','0')
				->where('type','admin')
				->count();
		if($d) { return $d; } else { return FALSE; }
	}

	public function update_adminuser($post) {
		$d = ORM::for_table($this->_table)->where('id',$post['id'])->find_one();
		

		if($d) {
			// update branch details
	        $d->name              		= $_POST['name'];
	        $d->mobile                	= $_POST['mobile'];
	        $d->email_id               	= $_POST['email'];
	        $d->password_txt            = ($_POST['pwd']!= "") ? $_POST['pwd'] : $d->password_txt;
            $d->password                = ($_POST['pwd']!= "") ? md5($_POST['pwd']) : $d->password;
	        $d->status 					= isset($_POST['status']) ? $_POST['status'] : 'active';
	        $d->updated_time            = date('Y-m-d H:i:s');

	        if($d->save()) { 
        		return $d; 
        	} 
        	else 
    		{ 
    			return FALSE; 
    		}
	    	
		} else {
			return FALSE;
		}
	}
	
	
		public function update_accessrights($post) {

		$d = ORM::for_table('sam_accessrights')->where('id',$post['id'])->find_one();

		if($d) {
			// update branch details
	$d->create_access        = isset($post['create_'.$d->page_title]) ? $post['create_'.$d->page_title] : 'no';
	$d->edit_access          = isset($post['edit_'.$d->page_title]) ? $post['edit_'.$d->page_title] : 'no';
	$d->view_access          = isset($post['view_'.$d->page_title]) ? $post['view_'.$d->page_title] : 'no';
	$d->delete_access        = isset($post['delete_'.$d->page_title]) ? $post['delete_'.$d->page_title] : 'no';

	        $d->modified             = date('Y-m-d H:i:s');
	        $d->save();


	    	return $d->id;
		} else {
			return FALSE;
		}



	}
	
	
	
	
	

	
	

}