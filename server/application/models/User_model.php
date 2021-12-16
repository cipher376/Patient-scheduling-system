<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/* * *
 * *This class should only display the footer and header of the page
 * *Angular will load the rest of the page
 * *An application can have several layouts 
 * * */

class User {
    public $email = "";
    public $phone = "";
    public $remember = "";
    public $username = "";
    public $password = "";
    public $accounttype = "";
    public $groups = "";
    public $user_id = "";
    public $fullname = "";
    public $gender = "";
    public $address = "";
    public $date_of_birth = "";
    public $company = "";

}

class User_model extends CI_Model {

    public $info;

    public function __construct() {
        parent:: __construct();

        $this->info = new User();
        $this->BindUser();
    }

    public function BindUser() {
        $this->info->email = $this->input->post("email");
        $this->info->phone = $this->input->post("phone");
        $this->info->remember = $this->input->post("remember");
        $this->info->username = $this->input->post("username");
        $this->info->password = $this->input->post("password");
        $this->info->user_id = $this->input->post("user_id");
        $this->info->accounttype = $this->input->post("accounttype");

        $this->info->fullname = $this->input->post("fullname");
        $this->info->gender = $this->input->post("gender");
        $this->info->address = $this->input->post("address");
        $this->info->date_of_birth = $this->input->post("date_of_birth");
        $this->info->company = $this->input->post("company");
        $this->info->pic = $this->input->post("pic");
    }

}
