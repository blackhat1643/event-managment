<?php defined('BASEPATH') OR exit('No direct script access allowed');
 
class Mdl_covid_19 extends CI_Model
{
 
	public function __construct()
  {
		parent::__construct();
		$this->load->library('database');
	}

	private $_table = 'tbl_updated_pages';

	public function update_row($post)
  	{
		$d = ORM::for_table($this->_table)->where('id',26)->find_one();
	  	if($d)
    	{
				$d->banner_title         = $_POST['banner_title'];
				$d->title                = $_POST['title'];
				$d->sub_title                = $_POST['sub_title'];
				$d->sub_title_2                = $_POST['sub_title_2'];
				$d->description          = $_POST['description'];
				$d->short_description          = $_POST['short_description'];
			  $d->updated_time         = date('Y-m-d H:i:s');      

			    if(is_uploaded_file($_FILES['image']['tmp_name'])) {
            	$rand = rand();
	            $this->sam->upload_image('image','themes/default/front/assets/images/',$rand);
	            $d->image = $rand.$_FILES['image']['name'];
            }    

           if(is_uploaded_file($_FILES['banner_image']['tmp_name'])) {
            	$rand = rand();
	            $this->sam->upload_image('banner_image','themes/default/front/assets/images/event/',$rand);
	            $d->banner_image = $rand.$_FILES['banner_image']['name'];
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