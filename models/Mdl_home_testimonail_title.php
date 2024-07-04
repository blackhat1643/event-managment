<?php defined('BASEPATH') OR exit('No direct script access allowed');
 
class Mdl_home_testimonail_title extends CI_Model
{
 
	public function __construct()
  {
		parent::__construct();
		$this->load->library('database');
	}

	private $_table = 'tbl_updated_pages';

	public function update_row($post)
  	{
		$d = ORM::for_table($this->_table)->where('id',7)->find_one();
	  	if($d)
    	{
			
			$d->title                		= $_POST['title'];
			$d->sub_title                		= $_POST['sub_title'];
			$d->description          		= $_POST['description'];
	    $d->updated_time         = date('Y-m-d H:i:s');            
	        
      	if(!empty($_FILES['image']['tmp_name'])){
    		  $rand = rand();
          $this->sam->upload_image('image','themes/assets/images/banner/',$rand);
          $d->image = $rand.$_FILES['image']['name'];
        }
	      

  	    	if($d->save()){ 
          		return $d; 
          	} else { 
  			   return FALSE; 
  		  	}
		  }
	 }

	
	function get($id) 
  {

    $d = ORM::for_table($this->_table)->where('id',$id)->find_one();   
    if($d) { return $d; } else { return FALSE; }
  }

  


}