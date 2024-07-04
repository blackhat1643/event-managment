<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once('traits/common_function.php');


class Mdl_settings extends CI_Model {

	public function __construct() {
		parent::__construct();
		$this->load->library('database');
	}

	use common_db_functions;

	private $_table = 'sam_settings';

	public function update_settings($post) {
		$d = $this->get(1);
		if($d) {
			$d->sitename 				= $post['sitename'];

			$d->contact_email_1 				= $post['contact_email_1'];
			$d->contact_email_2 				= $post['contact_email_2'];
			$d->contact_mobile_1 				= $post['contact_mobile_1'];
			$d->contact_mobile_2 				= $post['contact_mobile_2'];
			$d->contact_country 				= $post['contact_country'];
			$d->contact_address 				= $post['contact_address'];
			$d->address_iframe 					= $post['address_iframe'];
			$d->fb_link 						= $post['fb_link'];
			$d->tw_link 						= $post['tw_link'];
			$d->instagram_link 					= $post['instagram_link'];
			$d->in_link 						= $post['in_link'];

			$d->copyright 						= $post['copyright'];

			$d->day_1 						= $post['day_1'];
			$d->day_time_1 						= $post['day_time_1'];
			$d->day_2 						= $post['day_2'];
			$d->day_time_2 						= $post['day_time_2'];
			$d->day_3 						= $post['day_3'];
			$d->day_time_3 						= $post['day_time_3'];
			$d->day_4 						= $post['day_4'];
			$d->day_time_4 						= $post['day_time_4'];


			$d->language 						= $post['language'];
			$d->rows_per_page					= $post['rows_per_page'];
			$d->timezone 						= $post['timezone'];

			// Site Logo Image
			if(is_uploaded_file($_FILES['sitelogo']['tmp_name'])) {
	            $this->sam->upload_image('sitelogo','themes/default/admin/assets/upload/logos/');
	            $d->sitelogo = $_FILES['sitelogo']['name'];
	        }
			
	        if(is_uploaded_file($_FILES['footer_logo']['tmp_name'])) {
	            $this->sam->upload_image('footer_logo','themes/default/admin/assets/upload/logos/');
	            $d->footer_logo = $_FILES['footer_logo']['name'];
	        }
	        
	        if(is_uploaded_file($_FILES['login_bg_image']['tmp_name'])) {
	            $this->sam->upload_image('login_bg_image','themes/default/admin/assets/upload/logos/');
	            $d->login_bg_image = $_FILES['login_bg_image']['name'];
	        }
		    $d->save();
		    return $d->id;
		} else {
			return FALSE;
		}
	}

	public function update_smtp_settings($post) {
		$d = $this->get(1);
		if($d) {
			$d->smtp_status 	= $post['smtp_status'];
			$d->smtp_encryption = $post['smtp_encryption'];
			$d->smtp_username	= $post['smtp_username'];
			$d->smtp_password 	= $post['smtp_password'];
			$d->smtp_name 		= $post['smtp_name'];
			$d->smtp_host 		= $post['smtp_host'];
			$d->smtp_port 		= $post['smtp_port'];
		    $d->save();
		    return $d->id;
		} else {
			return FALSE;
		}
	}
}