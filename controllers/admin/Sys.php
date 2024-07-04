<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sys extends MY_Controller {

	function __construct()
    {
        parent::__construct();

        if (!$this->loggedIn) {
            $this->session->set_userdata('requested_page', $this->uri->uri_string());
            admin_redirect('login');
        }

        $this->load->library('form_validation');
        $this->load->model('mdl_settings','mdl');
    }
    
	public function index() {
       
        $meta['page_title'] = lang('syssettings');

        // Form Validation
        $this->form_validation->set_rules('sitename', lang('sitename'), 'trim|required');
        $this->form_validation->set_rules('language', lang('language'), 'trim|required');
        $this->form_validation->set_rules('rows_per_page', lang('rows_per_page'), 'trim|required');

        if($this->form_validation->run() == true) {
            // update details
            $data = [
                        "sitename"                  => $this->input->post('sitename'),

                        "contact_email_1"                  => $this->input->post('contact_email_1'),
                        "contact_email_2"                  => $this->input->post('contact_email_2'),
                        "contact_mobile_1"                  => $this->input->post('contact_mobile_1'),
                        "contact_mobile_2"                  => $this->input->post('contact_mobile_2'),
                        "contact_country"                  => $this->input->post('contact_country'),
                        "contact_address"                  => $this->input->post('contact_address'),
                        "footer_logo"                  => $this->input->post('footer_logo'),

                        "address_iframe"                => $this->input->post('address_iframe'),
                        "fb_link"                       => $this->input->post('fb_link'),
                        "tw_link"                       => $this->input->post('tw_link'),
                        "instagram_link"                => $this->input->post('instagram_link'),
                        "in_link"                       => $this->input->post('in_link'),
                        "copyright"                     => $this->input->post('copyright'),

                        "day_1"                     => $this->input->post('day_1'),
                        "day_time_1"                     => $this->input->post('day_time_1'),
                        "day_2"                     => $this->input->post('day_2'),
                        "day_time_2"                     => $this->input->post('day_time_2'),
                        "day_3"                     => $this->input->post('day_3'),
                        "day_time_3"                     => $this->input->post('day_time_3'),
                        "day_4"                     => $this->input->post('day_4'),
                        "day_time_4"                     => $this->input->post('day_time_4'),
                        
                        "language"                  => $this->input->post('language'),
                        "rows_per_page"             => $this->input->post('rows_per_page'),
                        "order_description"         => $this->input->post('order_description'),
                        "timezone"                  => $this->input->post('timezone')
                    ];

            if($this->mdl->update_settings($data)) {
                $this->session->set_flashdata('success',lang('settingupdate'));
                redirect('settings');
            } else {
                $this->session->set_flashdata('error',lang('settingupdatef'));
                redirect('settings');
            }
        } else {
            $this->data['setting'] = $this->mdl->get(1);
            $this->data['languages'] = $this->sam->get_languages();
            $this->data['timezonelist'] = sam::timezoneList();
            $this->page_construct('settings/index', $meta, $this->data);
        }
	}

}
