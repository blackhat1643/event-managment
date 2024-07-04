<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once('traits/common_function.php');

class Mdl_mymodules extends CI_Model {

	public function __construct() 
	{
		parent::__construct();
		$this->load->library('database');
	}

	use common_db_functions;

	private $_table = 'sam_accessrights';
	
	public function get_count() {
		$d = ORM::for_table($this->_table)->where('is_deleted','0')->group_by('module')
				->count();
		if($d) { return $d; } else { return FALSE; }
	}

	public function get_all_with_pagi($id,$limit = 10,$start = 0,$w) {
		if($w == ""){
		if($start == '')
		{
			$start = 0;
		}
    	$d = ORM::for_table($this->_table)->where('is_deleted','0')
    						->order_by_desc($id)
    						->limit($limit)
							->offset($start)
							->group_by('module')
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

			$query = "SELECT * FROM `$this->_table` WHERE is_deleted = '0' $w GROUP BY module  ORDER BY id DESC $l";
			
			$d = ORM::for_table('sam_accessrights')->raw_query($query)->find_many();
		}

    	if($d) { return $d; } else { return FALSE; }
    }

     public function get_search_count($limit = 10,$w) {

			$query = "SELECT * FROM `$this->_table` WHERE is_deleted = '0' $w GROUP BY module ORDER BY id DESC";

			$TotalData = ORM::for_table('sam_accessrights')->raw_query($query)->find_array();
			$d = count($TotalData);

		if($d) { return $d; } else { return FALSE; }
	}
}