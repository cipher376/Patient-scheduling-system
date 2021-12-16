<?php

defined('BASEPATH') or exit('No direct script access allowed');

/* * *
 * *This class should only display the footer and header of the page
 * *Angular will load the rest of the page
 * *An application can have several layouts 
 * * */

class Account extends CI_Controller
{

    protected $auth;
    protected $userid;
    protected $applicantid;

    public function __construct()
    {
        parent::__construct();
        //$this->load->library('Aauth');
    }

    public function _remap($method, $args = array())
    {
        switch ($method) {
            case "login":
                $this->$method();
                break;
            case "register":
                $this->$method();
                break;
        }
    }

 
    private function login()
    {
        return $this->load->view("account/login.php");
    }

    private function register()
    {
        return $this->load->view("account/register.php");
    }


}
