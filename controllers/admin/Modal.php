<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Modal extends MY_Controller {

    function __construct()
    {
        parent::__construct();
    }

   private function _delete_by_id($id,$_table) {
        $d = ORM::for_table($_table)->where('id',$id)->find_one();
        if($d) {
            // change is_deleted to 1
            $d->is_deleted = '1';
            $d->save();
            echo TRUE;
        } else {
            echo FALSE;
        }
    }
/**********************************************************************************
Customer Add Delete Start
***********************************************************************************/
    


/**********************************************************************************
Send Mail  Start
***********************************************************************************/
    
    public function send_mail() { 
        
        $email = $_POST['email'];
        $Setting = ORM::for_table('sam_settings')->where('id','1')->find_one();
        $RegistrationTemplete = ORM::for_table('zyd_email_template')->where('id','1')->find_one();
        $Massage =  $RegistrationTemplete['email_body'];

        $Massage = str_replace ('[USER_NAME]',$_POST['fname'],$Massage);
        $Massage = str_replace ('[USER_EMAIL]',$_POST['email'],$Massage);
        $Massage = str_replace ('[USER_PASSWORD]',$_POST['pwd'],$Massage);
        $Massage = str_replace ('[SITE_NAME]',$Setting['sitename'],$Massage);
        
        $email_config = ORM::for_table('sam_settings')->where('id',1)->find_one();

        $config = array(
                'protocol'  => $email_config['smtp_name'],
                'smtp_host' => $email_config['smtp_host'],
                'smtp_port' => $email_config['smtp_port'],
                'smtp_user' => $email_config['smtp_username'],
                'smtp_pass' => $email_config['smtp_password'],
                'mailtype'  => 'html', 
                'charset'   => 'iso-8859-1'
            );
    
          $this->load->library('email',$config); 

          $this->email->from('no_reply@maahiit.in', 'Registration Mail');
          $this->email->to($email);
          $this->email->subject($RegistrationTemplete['subject']);
          $this->email->message($Massage);
          
          if($email_config['smtp_status'] == 'on')
          {
            $this->email->send();    
          }
      }

/**********************************************************************************
Send Mail Add Delete End
***********************************************************************************/


   /* ----------------------------------------------------------
    * --------------Start : City List by state id---------------*
    * ----------------------------------------------------------*/

    public function ajax_get_city_from_state() 
    {
        $w = "is_deleted = '0' AND status = 'active'";
        $city = [];
        if($_POST['state_id'] != '')
        {          
            $w .= "AND state_id = '".$_POST['state_id']."'";
            $query = "SELECT * FROM tbl_city WHERE $w ORDER BY city ASC";
            $city  = ORM::for_table('tbl_city')->raw_query($query)->find_array();   
        }
        echo json_encode($city);
    }

    /* ----------------------------------------------------------
    * --------------End : City List by state id---------------*
    * ----------------------------------------------------------*/


}