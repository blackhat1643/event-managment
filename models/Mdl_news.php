<?php defined('BASEPATH') OR exit('No direct script access allowed');
 require_once('traits/common_function.php'); 
class Mdl_news extends CI_Model
	
	{

	 use common_db_functions;

	public function __construct()
  {
		parent::__construct();
		$this->load->library('database');
	}

	private $_table = 'tbl_news';

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
   			$query="SELECT * FROM tbl_news WHERE is_deleted = '0' $w ORDER BY id DESC";
           	$TotalData = ORM::for_table('tbl_news')->raw_query($query)->find_array();
			$d = count($TotalData);

		if($d) { return $d; } else { return FALSE; }
	}

	public function update_row($post)
  	{
		$d = ORM::for_table($this->_table)->where('id',$post['id'])->find_one();
	  	if($d)
    	{
		    $d->title                  = @$_POST['title'];
            $d->description            = @$_POST['description'];
            $d->created_by             = @$_POST['created_by'];
            $d->news_date              = date('Y-m-d',strtotime(@$_POST['news_date']));
            if(is_uploaded_file($_FILES['news_image']['tmp_name'])) {
                $rand = rand();
            $this->sam->upload_image('news_image','themes/assets/images/news_image/',$rand);
            $d->news_image = $rand.$_FILES['news_image']['name'];

            }

            $d->status                  = isset($_POST['status']) ? $_POST['status'] : 'active';
            $d->created_by_user_id      = $this->session->userdata('loginid');
            $d->inserted_time           = date('Y-m-d H:i:s');
	      	

  	    	if($d->save()){ 
          		return $d; 
          	} else { 
  			   return FALSE; 
  		  	}
		  }
	 }
 }