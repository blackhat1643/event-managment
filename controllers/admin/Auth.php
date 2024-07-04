<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends MY_Controller
{

    function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
    }

    function login($m = NULL) {
        if ($this->loggedIn) {
            $this->session->set_flashdata('error', $this->session->flashdata('error'));
            admin_redirect('welcome');
        }
        $this->data['title'] = lang('login');

        if ($this->form_validation->run($this->my_rules())) { 
            // all validation success
            // $remember = (bool)$this->input->post('remember');
            // echo $remember;
            /// check user name and password
            $d = ORM::for_table('sam_users')->where('email_id',$this->input->post('uname'))
                                ->where('password',md5($this->input->post('pwd')))
                                ->where('status','active')
                                ->find_one();
                                
            if($d) {
                // user found Check The Type of User
                // if it is admin assign the admin role or Inspector assign Inspector role
                if($d->type == 'admin') {
                    // admin
                    $this->session->set_flashdata('message', lang('logintrue'));
                    $referrer = ($this->session->userdata('requested_page') && $this->session->userdata('requested_page') != 'admin') ? $this->session->userdata('requested_page') : 'admin';
                    $this->session->set_userdata('user_state',$d->state_id);
                    $this->session->set_userdata('identity',$d->type);
                    $this->session->set_userdata('loginid', $d->id);
                    $this->session->set_userdata('loginname', $d->first_name." ".$d->last_name);
                    redirect($referrer);
                    
                } elseif ($d->type == 'user') {
                    //inspector
                    $this->session->set_flashdata('message', lang('logintrue'));
                    $referrer = ($this->session->userdata('requested_page') && $this->session->userdata('requested_page') != 'admin') ? $this->session->userdata('requested_page') : 'admin';
                    $this->session->set_userdata('user_state',$d->state_id);
                    $this->session->set_userdata('identity',$d->type);
                    $this->session->set_userdata('loginid', $d->id);
                    $this->session->set_userdata('loginname', $d->first_name." ".$d->last_name);
                    redirect($referrer);
                } elseif ($d->type == 'admin') {
                    //inspector
                    $this->session->set_flashdata('message', lang('logintrue'));
                    $referrer = ($this->session->userdata('requested_page') && $this->session->userdata('requested_page') != 'admin') ? $this->session->userdata('requested_page') : 'admin';
                    $this->session->set_userdata('user_state',$d->state_id);
                    $this->session->set_userdata('identity',$d->type);
                    $this->session->set_userdata('loginid', $d->id);
                    $this->session->set_userdata('loginname', $d->first_name." ".$d->last_name);
                    redirect($referrer);
                } else {
                    $this->data['error'] = $this->session->flashdata('error', lang('loginunauth'));
                    admin_redirect('login');
                }
            } else {
                $this->session->set_flashdata('error', lang('loginfalse'));
                admin_redirect('login');
            }
            
        } else {
            $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
            $this->data['message'] = $this->session->flashdata('message');
            $this->load->view($this->theme . 'auth/login', $this->data);
        }
    }

    public function logout() {
        $this->session->sess_destroy();
        admin_redirect('/');
    }

    private function my_rules() {
        $this->form_validation->set_rules('uname','UserName','required|trim');
        $this->form_validation->set_rules('pwd','Password','required|trim');
        // $this->form_validation->set_rules('min_age','Minimum Age','required|trim');
        // $this->form_validation->set_rules('duration','Duration','required|trim');
        // $this->form_validation->set_rules('cost','Cost','required|numeric|trim');
    }

}
