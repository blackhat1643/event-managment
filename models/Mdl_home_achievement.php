<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once('traits/common_function.php');

class Mdl_home_achievement extends CI_Model
{
 
  use common_db_functions;

	public function __construct()
  {
		parent::__construct();
		$this->load->library('database');
	}

	private $_table = 'tbl_home_achievement';

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

   	public function get_count($w = null) {
   			$query="SELECT * FROM $this->_table WHERE is_deleted = '0' $w ORDER BY id DESC";
       	$TotalData = ORM::for_table($this->_table)->raw_query($query)->find_array();
				$d = count($TotalData);

		if($d) { return $d; } else { return FALSE; }
	}

	public function update_row($post)
  	{
		$d = ORM::for_table($this->_table)->where('id',$post['id'])->find_one();
	  	if($d)
    	{
					  $d->title                   = @$_POST['title'];
            $d->count_txt               = @$_POST['count_txt'];
            $d->icon_txt             		= @$_POST['icon_txt'];
            $d->status                  = isset($_POST['status']) ? $_POST['status'] : 'active';
            $d->created_by_user_id      = $this->session->userdata('loginid');
            $d->updated_time         = date('Y-m-d H:i:s');            
	        
  	    	if($d->save()){ 
          		return $d; 
          	} else { 
  			   return FALSE; 
  		  	}
		  }
	 }

}



