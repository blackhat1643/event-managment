<?php 


class MY_Controller extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library('database');
        $this->load->library('Maahi_masters');
		
		// get all setting from Database
		$this->Settings = ORM::for_table('sam_settings')->where('id',1)->find_one();
        $timezone = $this->Settings->timezone;
        date_default_timezone_set($timezone);
            
		// select language
		$this->config->set_item('language',$this->Settings->language);
		$this->lang->admin_load('sam', $this->Settings->language);
		
        $this->theme = $this->Settings->theme.'/admin/views/';

		if(is_dir(VIEWPATH.$this->Settings->theme.DIRECTORY_SEPARATOR.'assets'.DIRECTORY_SEPARATOR)) {
            $this->data['assets'] = base_url() . 'themes/' . $this->Settings->theme . '/assets/';
        } else {
            $this->data['assets'] = base_url() . 'themes/default/admin/assets/';
        }

        //Front 
        $this->front_theme = $this->Settings->theme.'/front/views/';
        $this->data['front_assets'] = base_url() . 'themes/default/front/assets/'; // For Front
        $this->data['front_assets'] = base_url() . 'themes/default/front/assets/';
        

        $this->data['Settings'] = $this->Settings;
        $this->loggedIn = $this->sam->logged_in();
        if($this->loggedIn) {
        	// if user is logged in do some thing here
        }
	}

	function page_construct($page, $meta = array(), $data = array()) {
        $meta['message'] = isset($data['message']) ? $data['message'] : $this->session->flashdata('message');
        $meta['error'] = isset($data['error']) ? $data['error'] : $this->session->flashdata('error');
        $meta['warning'] = isset($data['warning']) ? $data['warning'] : $this->session->flashdata('warning');
        // $meta['info'] = $this->site->getNotifications();
        // $meta['events'] = $this->site->getUpcomingEvents();
        $meta['ip_address'] = $this->input->ip_address();
        // $meta['Owner'] = $data['Owner'];
        // $meta['Admin'] = $data['Admin'];
        // $meta['Supplier'] = $data['Supplier'];
        // $meta['Customer'] = $data['Customer'];
        $meta['Settings'] = $data['Settings'];
        // $meta['dateFormats'] = $data['dateFormats'];
        $meta['assets'] = $data['assets'];
        // $meta['GP'] = $data['GP'];
        // $meta['qty_alert_num'] = $this->site->get_total_qty_alerts();
        // $meta['exp_alert_num'] = $this->site->get_expiring_qty_alerts();
        // print_r($data);
            $meta['no_record_txt'] = "No Record Found";
        $this->load->view($this->theme . 'header', $meta);
        $this->load->view($this->theme . 'navigation');
        $this->load->view($this->theme . $page, $data);
        $this->load->view($this->theme . 'footer');
    }


}

?>