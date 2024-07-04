<?php defined('BASEPATH') OR exit('No direct script access allowed');
 
class Mdl_about_us_title extends CI_Model
{
 
	public function __construct()
  {
		parent::__construct();
		$this->load->library('database');
	}

	private $_table = 'tbl_updated_pages';

	public function update_row($post)
  	{
		$d = ORM::for_table($this->_table)->where('id',2)->find_one();
	  	if($d)
    	{
				$d->title                = $_POST['title'];
				$d->banner_title         = $_POST['banner_title'];
				$d->description          = $_POST['description'];
				$d->short_description    = $_POST['short_description'];
				
			  $d->updated_time         = date('Y-m-d H:i:s');      

			    if(is_uploaded_file($_FILES['image']['tmp_name'])) {
            	$rand = rand();
	            $this->sam->upload_image('image','themes/default/admin/assets/images/others/',$rand);
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