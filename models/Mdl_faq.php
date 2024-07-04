<?php defined('BASEPATH') OR exit('No direct script access allowed');
 
class Mdl_faq extends CI_Model{
 
  public function __construct(){
    parent::__construct();
    $this->load->library('database'); 
  }

  private $_table = 'contact';

  public function get_all_with_pagi($id,$limit = 10,$start = 0,$w="") 
  {
    if($start == ''){ $start = 0; }
  
    $l = '';          
    $limit = $limit;
    $offset = $start;

        $l = "LIMIT $offset,$limit";          
    $query = "SELECT * FROM $this->_table WHERE is_deleted = '0' AND type = 'faq'  $w  ORDER BY id DESC $l";
    $d = ORM::for_table($this->_table)->raw_query($query)->find_array();

      if($d) { return $d; } else { return FALSE; }
  }

  public function get_search_count($limit = 10,$w) {

      $query = "SELECT * FROM `$this->_table` WHERE is_deleted = '0' AND type = 'faq' $w ORDER BY id DESC";
      $TotalData = ORM::for_table('contact')->raw_query($query)->find_array();
      $d = count($TotalData);

    if($d) { return $d; } else { return FALSE; } 
  }

}