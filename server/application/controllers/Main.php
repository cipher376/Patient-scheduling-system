<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/* * *
 * *This class should only display the footer and header of the page
 * *Angular will load the rest of the page
 * *An application can have several layouts 
 * * */

class Main extends CI_Controller {

    protected $auth;
    protected $userid;
    protected $applicantid;

    public function __construct() {
        parent::__construct();
        $this->load->library('Aauth');
    }

    public function _remap($method, $args = array()) {
        switch ($method) {
            case "home":
                if ($this->aauth->is_loggedin()) {
                    $this->$method();
                }
//                $this->$method();
                break;
            case "reg_login":
                if ($this->aauth->is_loggedin()) {
                    $this->$method();
                }
//                $this->$method();
                break;
            case "reg_info":
                if ($this->aauth->is_loggedin()) {
                    $this->$method();
                }
//                $this->$method();
                break;
            case "user_message":
                if ($this->aauth->is_loggedin()) {
                    $this->$method();
                }
//                $this->$method();
                break;
            case "user_profile":
                if ($this->aauth->is_loggedin()) {
                    $this->$method();
                }
//                $this->$method();
                break;
            case "user_schedule":
                if ($this->aauth->is_loggedin()) {
                    $this->$method();
                }
             
                break;
            
             case "user_history":
                if ($this->aauth->is_loggedin()) {
                    $this->$method();
                }
              //  $this->$method();
                break;
            
            
            case "admin_home":
                if ($this->aauth->is_loggedin()) {
                    $this->$method();
                }
                //$this->$method();
                break;
            case "admin_schedule":
                if ($this->aauth->is_loggedin()) {
                    $this->$method();
                }
//                $this->$method();
                break;
             case "admin_message":
                if ($this->aauth->is_loggedin()) {
                    $this->$method();
                }
//                $this->$method();
                break;
             case "admin_staff":
                if ($this->aauth->is_loggedin()) {
                    $this->$method();
                }
                break;
            case "admin_sms":
                if ($this->aauth->is_loggedin()) {
                    $this->$method();
                }
        //        $this->$method();
                break;
            case "doctor_home":
                if ($this->aauth->is_loggedin()) {
                    $this->$method();
                }
                break;
            case "admin_history":
                if ($this->aauth->is_loggedin()) {
                    $this->$method();
                }
                break;
            default :
                if ($this->aauth->is_loggedin()) {
                    $this->$method();
                } else {
                    return $this->load->view("account/login.php");
                }
                //$this->$method();
                break;
        }
    }

    private function index() {
        return $this->load->view('app/layout/dashboard.php');
    }

    private function home() {
        return $this->load->view('app/partials/home.php');
    }

    private function reg_account() {
        return $this->load->view('app/partials/reg_account.php');
    }

    private function reg_info() {
        return $this->load->view('app/partials/reg_info.php');
    }
    
    private function login(){
        return $this->load->view('account/login.php');
    }
    
    private function register(){
        return $this->load->view('account/register.php');
    }
    public  function message() {
        return $this->load->view('app/partials/message.php');
    }
    
    public function profile(){
        return $this->load->view('app/partials/profile.php');

    }
    public function user_schedule(){
        return $this->load->view('app/partials/user_schedule.php');

    }
    public function user_history(){
        return $this->load->view('app/partials/user_history.php');

    }
     public function patient_list(){
        return $this->load->view('app/partials/patient_list.php');

    }
     public function events(){
        return $this->load->view('app/partials/events.php');
    }
    
    // Admin pages
    public function admin_home(){
        return $this->load->view('app/partials/admin_home.php');
    }
    public function admin_schedule(){
        return $this->load->view("app/partials/admin_schedule.php");
    }
  
    public function admin_staff(){
        return $this->load->view("app/partials/admin_staff.php");
    }
    public function admin_sms(){
        return $this->load->view("app/partials/admin_sms.php");
    }
      // Doctors pages
    public function doctor_home(){
        return $this->load->view('app/partials/doctor_home.php');
    }
    public function admin_history(){
        return $this->load->view("app/partials/admin_history.php");
    }
}
