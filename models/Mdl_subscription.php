<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once('traits/common_function.php');

class Mdl_subscription extends CI_Model
{
 
  use common_db_functions;

	public function __construct()
  {
		parent::__construct();
		$this->load->library('database');
	}

	private $_table = 'tbl_subscription';

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
         
					  $d->email                   = @$_POST['email'];
            $d->price              		= @$_POST['price'];
             $d->plans               		= @$_POST['plans'];
                     
	        	
	        	 if(!empty($_FILES['image']['tmp_name'])){
              $rand = rand();
              $this->sam->upload_image('image','themes/default/front/assets//images/event/',$rand);
              $d->image = $rand.$_FILES['image']['name'];
            }
  	    	if($d->save()){ 
          		return $d; 
          	} else { 
  			   return FALSE; 
  		  	}
		  }
	 }

}



