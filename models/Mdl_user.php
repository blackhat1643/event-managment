<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once('traits/common_function.php');

class Mdl_user extends CI_Model {

	public function __construct() {
		parent::__construct();
		$this->load->library('database');
	}

		use common_db_functions;
	private $_table = 'sam_users';

	public function get_all_with_pagi($id,$limit = 10,$start = 0,$w="") 
	{
		if($start == ''){ $start = 0; }
	
		$l = '';					
		$limit = $limit;
		$offset = $start;

        $l = "LIMIT $offset,$limit";					
		$query = "SELECT * FROM $this->_table WHERE is_deleted = '0'  $w ORDER BY id DESC $l";
		$d = ORM::for_table($this->_table)->raw_query($query)->find_array();

    	if($d) { return $d; } else { return FALSE; }
    }

     public function get_search_count($limit = 10,$w) {
			$query = "SELECT * FROM `$this->_table` WHERE is_deleted = '0' $w ORDER BY id DESC";
			$TotalData = ORM::for_table($this->_table)->raw_query($query)->find_array();
			$d = count($TotalData);

		if($d) { return $d; } else { return FALSE; }
	}

	

	public function update_row($post) {
		$d = ORM::for_table($this->_table)->where('id',$post['id'])->find_one();
	
		if($d) {
			
            $d->name                     = $_POST['name'];
	        $d->email_id                 = $_POST['email'];
	        $d->mobile                   = $_POST['mobile'];
	        $d->password                 = ($_POST['pwd']!= "") ? md5($_POST['pwd']) : $d->password;
	        $d->password_txt             = ($_POST['pwd']!= "") ? $_POST['pwd'] : $d->password_txt;
	        $d->status                   = isset($_POST['status']) ? $_POST['status'] : 'active';
	        $d->updated_time             = date('Y-m-d H:i:s');
	    	if($d->save()) 
        	{ 
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
	
	
	

}