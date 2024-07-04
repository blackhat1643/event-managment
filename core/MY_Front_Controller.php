<?php 

class MY_Front_Controller extends CI_Controller {

	public function __construct() {
        parent::__construct();
        $this->load->library('database');
        // new Database;

        // get all setting from Database
        $this->Settings = ORM::for_table('sam_settings')->where('id',1)->find_one();
        $this->login_info = ORM::for_table('sam_users')->where('id',$this->session->userdata('user_loginid'))->find_one();
        $timezone = $this->Settings->timezone;
        date_default_timezone_set($timezone);
            
        // select language
        $this->config->set_item('language',$this->Settings->language);
        $this->lang->admin_load('sam', $this->Settings->language);
        
        $this->theme = $this->Settings->theme.'/front/views/';

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
        $this->data['login_info'] = $this->login_info;
        
        $this->User_loggedIn = $this->sam->user_logged_in();


        if($this->User_loggedIn) {
            // if user is logged in do some thing here
        }
    }
    function frontpage_construct($page, $meta = array(), $data = array()) {

        $meta['message'] = isset($data['message']) ? $data['message'] : $this->session->flashdata('message');
        $meta['error'] = isset($data['error']) ? $data['error'] : $this->session->flashdata('error');
        $meta['warning'] = isset($data['warning']) ? $data['warning'] : $this->session->flashdata('warning');
        $meta['ip_address'] = $this->input->ip_address();
        $meta['Settings'] = $data['Settings'];
        $meta['login_info'] = $this->data['login_info'];

        $meta['front_assets'] = $data['front_assets'];

        $this->load->view($this->front_theme . 'header', $meta);
        $this->load->view($this->front_theme . $page, $data);
        $this->load->view($this->front_theme . 'footer');
    }

    function frontpage_construct_page($page, $meta = array(), $data = array()) {

        $meta['message'] = isset($data['message']) ? $data['message'] : $this->session->flashdata('message');
        $meta['error'] = isset($data['error']) ? $data['error'] : $this->session->flashdata('error');
        $meta['warning'] = isset($data['warning']) ? $data['warning'] : $this->session->flashdata('warning');
        $meta['ip_address'] = $this->input->ip_address();
        $meta['Settings'] = $data['Settings'];
        $meta['login_info'] = $this->data['login_info'];

        $meta['front_assets'] = $data['front_assets'];

        $this->load->view($this->front_theme . 'header_page', $meta);
        $this->load->view($this->front_theme . $page, $data);
        $this->load->view($this->front_theme . 'footer');
    }

}

?>