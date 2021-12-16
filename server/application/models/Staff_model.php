<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/* * *
 * *This class should only display the footer and header of the page
 * *Angular will load the rest of the page
 * *An application can have several layouts 
 * * */

class StaffUser {

    public $id = "";
    public $email = "";
    public $username = "";
    public $password = "";
    public $groups = "";

}

class StaffPersonalInfo {

    public $id = "";
    public $phone = "";
    public $fullname = "";
    public $gender = "";
    public $address = "";
    public $date_of_birth = "";
    public $company = "";
    public $pic = "";

}

class StaffDetail {

    public $id = "";
    public $user_id = "";
    public $working_hours = "";
    public $specialty = "";

}

class Staff_model extends CI_Model {

    public $staffs = [];
    public $staff_details;
    public $staff_personalInfo;
    public $staff_user;

    public function __construct() {
        parent::__construct();
        $this->staff_details = new StaffDetail();
        $this->staff_personalInfo = new StaffPersonalInfo();
        $this->staff_user = new StaffUser();

        $this->BindToStaff();
    }

    public function BindToStaff() {
        $this->staff_user->id = $this->input->post("account")['user_id'];
        $this->staff_user->email = $this->input->post("account")["email"];
        $this->staff_user->username = $this->input->post("account")["username"] !== "" ?
        $this->input->post("account")["username"] : explode('@', $this->input->post("account")["email"])[0];
        $this->staff_user->password = $this->input->post("account")["password"];

        $this->staff_personalInfo->phone = $this->input->post("phone");
        $this->staff_personalInfo->fullname = $this->input->post("fullname");
        $this->staff_personalInfo->gender = $this->input->post("gender");
        $this->staff_personalInfo->address = $this->input->post("address");
        $this->staff_personalInfo->date_of_birth = $this->input->post("date_of_birth");
        $this->staff_personalInfo->company = $this->input->post("company");
        $this->staff_personalInfo->pic = $this->input->post("pic");


        $this->staff_details->id = $this->input->post("id");
        $this->staff_details->user_id = $this->staff_user->id;
        $this->staff_details->working_hours = $this->input->post("working_hours");
        $this->staff_details->specialty = $this->input->post("specialty");
    }

    public function BindFromStaff() {
        
    }

    public function BindStaffToPersonalInfo($staff, $info) {
        $staff_to_return = [];
        try {
            $staff_to_return["id"] = $staff["id"];
            $staff_to_return["user_id"] = $staff["user_id"];
            $staff_to_return["service_id"] = $staff["service_id"];
            $staff_to_return["working_hours"] = $staff["working_hours"];
            $staff_to_return["specialty"] = $staff["specialty"];
        } catch (Exception $ex) {
            
        }
        try {
            // binding personal information
            $staff_to_return["fullname"] = $info["fullname"];
            $staff_to_return["date_of_birth"] = $info["date_of_birth"];
            $staff_to_return["address"] = $info["address"];
            $staff_to_return["gender"] = $info["gender"];
            $staff_to_return["phone"] = $info["phone"];
            $staff_to_return["company"] = $info["company"];
            $staff_to_return["pic"] = $info["pic"];
        } catch (Exception $ex) {
            
        }
        $groups = [];
        // bind user information
        try {
            $staff_to_return["account"]["user_id"] = $info['user_id'];
            $staff_to_return["account"]["email"] = $info['email'];
            $staff_to_return["account"]["password"] = "";
            $staff_to_return["account"]["groups"] = $info['groups'];
        } catch (Exception $ex) {
            
        }
        return $staff_to_return;
    }

}
