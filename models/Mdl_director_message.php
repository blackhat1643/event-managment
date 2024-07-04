<?php defined('BASEPATH') OR exit('No direct script access allowed');
 
class Mdl_director_message extends CI_Model
{
 
	public function __construct()
  {
		parent::__construct();
		$this->load->library('database');
	}

	private $_table = 'tbl_updated_pages';

	public function update_row($POST)
  	{
  			
		$d = ORM::for_table($this->_table)->where('id',24)->find_one();
	  	if($d)
    	{

					$d->title               = @$_POST['title'];
					$d->banner_title        = @$_POST['banner_title'];
					$d->sub_title           = @$_POST['sub_title'];
					$d->description         = @$_POST['description'];
					$d->tag_line_1          = @$_POST['tag_line_1'];
					$d->tag_line_2          = @$_POST['tag_line_2'];
					$d->tag_line_3          = @$_POST['tag_line_3'];
					$d->tag_line_4          = @$_POST['tag_line_4'];

					if(is_uploaded_file($_FILES['image']['tmp_name'])) {
            	$rand = rand();
	            $this->sam->upload_image('image','themes/default/front/assets/images/event/',$rand);
	            $d->image = $rand.$_FILES['image']['name'];
            }          
					

			    $d->updated_time         = date('Y-m-d H:i:s');            
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