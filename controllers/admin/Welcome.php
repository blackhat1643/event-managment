<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends MY_Controller {

	function __construct()
    {
        parent::__construct();

        if (!$this->loggedIn) {
            $this->session->set_userdata('requested_page', $this->uri->uri_string());
            admin_redirect('login');
        }
        $this->load->library('form_validation');
        $this->load->model('mdl_home','mdl');
    }
    
	public function index()
	{
        $meta['page_title'] = 'Dashboard';
		
         $this->data['services']        = $this->mdl->get_services_count();
          $this->data['blogs']        = $this->mdl->get_blogs_count();
         // $this->data['teachers']        = $this->mdl->get_teachers_count();
         // $this->data['inquiry']         = $this->mdl->get_inquiry_count();
         // $this->data['subscribe']       = $this->mdl->get_subscribe_count();
        

		$this->page_construct('dashboard', $meta, $this->data);
	}
}
