<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once('traits/common_function.php');


class Mdl_home extends CI_Model {

	public function __construct() {
		parent::__construct();
		$this->load->library('database');
	}

	use common_db_functions;

	private $_table = 'sam_settings';

	public function get_blogs_count() {
		$d = ORM::for_table('tbl_blogs')->where('status','active')->where('is_deleted','0')->count();
		if($d) {
			return $d;
		} else {
			return '0';
		}
	}

	public function get_services_count() {
		$d = ORM::for_table('tbl_services')->where('status','active')->where('is_deleted','0')->count();
		if($d) {
			return $d;
		} else {
			return '0';
		}
	}

	

	

	
	
}