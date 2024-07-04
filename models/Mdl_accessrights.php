<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Mdl_user extends CI_Model {

	public function __construct() {
		parent::__construct();
		$this->load->library('database');
	}

	private $_table = 'sam_accessrights';

	public function get_users($limit = 10,$start = 0) {
		$d = ORM::for_table($this->_table)->where('is_deleted','0')
							->order_by_asc('first_name')
							->limit($limit)
							->offset($start)
							->find_many();

		if($d) { return $d; } else { return FALSE; }
	}

	public function get_user($id) {
		$d = ORM::for_table($this->_table)
							->where('id',$id)
							->find_one();

		if($d) { return $d; } else { return FALSE; }
	}

	public function get_count() {
		$d = ORM::for_table($this->_table)
				->where('status','active')
				->where('is_deleted','0')
				->count();
		if($d) { return $d; } else { return FALSE; }
	}





	public function update_user($post) {
		$d = ORM::for_table($this->_table)->where('id',$post['id'])->find_one();
		if($d) {
			// update branch details
			$d->branch_id               = $_POST['branchid'];
	        $d->role                    = $_POST['role'];
	        $d->first_name              = $_POST['fname'];
	        $d->last_name               = $_POST['sname'];
	        $d->code                    = $_POST['code'];
	        // $d->email_id                = $_POST['email'];
	        $d->phone_no                = $_POST['phone'];
	        $d->dob                		= $_POST['dob'];

	        $d->mobile                  = $_POST['mobile'];
	        // $d->login_name              = $_POST['loginname'];
	        $d->password                = md5($_POST['pwd']);
	        $d->use_dashboard = isset($_POST['udash']) ? $_POST['udash'] : 0;
	        // $d->is_contractor = $_POST[''];
	        $d->status = isset($_POST['status']) ? $_POST['status'] : 'active';
	        $d->modified                = date('Y-m-d H:i:s');
	        $d->modified_by             = $this->session->userdata('loginid');

	        if(is_uploaded_file($_FILES['usersign']['tmp_name'])) {
	            $this->sam->upload_image('usersign','themes/assets/images/usersign/');
	            $d->sign = $_FILES['usersign']['name'];
	        }
	        $d->save();
	    	return $d->id;
		} else {
			return FALSE;
		}
	}

	public function update_accessrights($post) {

		print_r($post);

		exit();


		$d = ORM::for_table($this->_table)->where('id',$post['id'])->find_one();


		

/*		if($d) {
			// update branch details
			$d->branch_id               = $_POST['branchid'];
	        $d->role                    = $_POST['role'];
	        $d->first_name              = $_POST['fname'];
	        $d->last_name               = $_POST['sname'];
	        $d->code                    = $_POST['code'];
	        // $d->email_id                = $_POST['email'];
	        $d->phone_no                = $_POST['phone'];
	        $d->dob                		= $_POST['dob'];

	        $d->mobile                  = $_POST['mobile'];
	        // $d->login_name              = $_POST['loginname'];
	        $d->password                = md5($_POST['pwd']);
	        $d->use_dashboard = isset($_POST['udash']) ? $_POST['udash'] : 0;
	        // $d->is_contractor = $_POST[''];
	        $d->status = isset($_POST['status']) ? $_POST['status'] : 'active';
	        $d->modified                = date('Y-m-d H:i:s');
	        $d->modified_by             = $this->session->userdata('loginid');

	        if(is_uploaded_file($_FILES['usersign']['tmp_name'])) {
	            $this->sam->upload_image('usersign','themes/assets/images/usersign/');
	            $d->sign = $_FILES['usersign']['name'];
	        }
	        $d->save();
	    	return $d->id;
		} else {
			return FALSE;
		}*/



	}










}