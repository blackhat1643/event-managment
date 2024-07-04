<?php defined('BASEPATH') OR exit('No direct script access allowed');
 
class Mdl_home_faq extends CI_Model
{
 
	public function __construct()
  {
		parent::__construct();
		$this->load->library('database');
	}

	private $_table = 'tbl_home_faq';

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

    public function get_users($limit = 10,$start = 0,$w) {
		if($w == ""){

			
			if($start == '')
			{
				$start = 0;
			}
			$d = ORM::for_table($this->_table)->where('is_deleted','0')	
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

			$query = "SELECT * FROM `$this->_table` WHERE is_deleted = '0'  $w ORDER BY id DESC $l";
			

			$d = ORM::for_table('tbl_home_faq')->raw_query($query)->find_many();
		}					

		if($d) { return $d; } else { return FALSE; }
	}

	public function get_user($id) {
		$d = ORM::for_table($this->_table)
							->where('id',$id)
							->find_one();

		if($d) { return $d; } else { return FALSE; }
	}

   	public function get_count($w = null) {
   			$query="SELECT * FROM tbl_home_faq WHERE is_deleted = '0' $w ORDER BY id DESC";
           	$TotalData = ORM::for_table('tbl_home_faq')->raw_query($query)->find_array();
			$d = count($TotalData);

		if($d) { return $d; } else { return FALSE; }
	}

	public function update_row($post)
  	{
		$d = ORM::for_table($this->_table)->where('id',$post['id'])->find_one();
	  	if($d)
    	{
					  $d->title                    = @$_POST['title'];
            $d->description             = @$_POST['description'];
            $d->status                  = isset($_POST['status']) ? $_POST['status'] : 'active';
            $d->created_by_user_id      = $this->session->userdata('loginid');
            $d->inserted_time           = date('Y-m-d H:i:s');
            
	      	 	$d->updated_time         = date('Y-m-d H:i:s');            
	        

  	    	if($d->save()){ 
          		return $d; 
          	} else { 
  			   return FALSE; 
  		  	}
		  }
	 }
 public function get_search_count($limit = 10,$w) {
			$query = "SELECT * FROM `$this->_table` WHERE is_deleted = '0' $w ORDER BY id DESC";
			$TotalData = ORM::for_table($this->_table)->raw_query($query)->find_array();
			$d = count($TotalData);

		if($d) { return $d; } else { return FALSE; }
	}

	
	function get($id) 
  {

    $d = ORM::for_table($this->_table)->where('id',$id)->find_one();   
    if($d) { return $d; } else { return FALSE; }
  }

  


}
