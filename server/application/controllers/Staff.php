<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/* * *
 * *This class should only display the footer and header of the page
 * *Angular will load the rest of the page
 * *An application can have several layouts 
 * * */

class Staff extends CI_Controller {

    public $returnData = [];
    public $staff;
    public $user;
    public $personalInfo;
    public $staffs = [];

    public function __construct() {
        parent::__construct();

        $this->load->database();
        $this->load->library('Aauth');
        $this->load->model('Staff_model', "staff_model");

        $this->staff = $this->staff_model->staff_details;
        $this->user = $this->staff_model->staff_user;
        $this->personalInfo = $this->staff_model->staff_personalInfo;


        $this->staffs = $this->staff_model->staffs;
    }

// Helper functions 

    public function success($msg, $data = null) {
        $this->returnData['msg'] = $msg;
        $this->returnData['Succeeded'] = true;
        $this->returnData['data'] = $data;

        echo json_encode($this->returnData);
        $this->returnData = [];
    }

    public function failure($msg, $data = null) {
        $this->returnData['msg'] = $msg;
        $this->returnData['data'] = $data;
        $this->returnData['Succeeded'] = false;
        echo json_encode($this->returnData);
        $this->returnData = [];
    }

    function is_login() {
        if (!$this->aauth->is_loggedin()) {
            $this->failure("You must be login to perform this action");
            return;
        }
    }

//****************************************************************************** 
    public function Add($isUpdate = false) {
        try {
//if(!is_login()) $this->failure("You must login to perform this action");
//Insert the new Onwer into the database

            $t_return = null;
            if (!$isUpdate) {
                $t_return = $this->aauth->create_user($this->user->email, $this->user->password, $this->user->username);
               
            } else {
                $this->aauth->update_user($this->user->id, $this->user->email, $this->user->password, $this->user->username);
            }
            
            
            if (is_numeric($t_return)) {
                $this->personalInfo->user_id = $t_return;
            } else {
                $this->personalInfo->user_id = $this->user->id;
                $t_return = $this->user->id;
            }

          

            //add user to a group
            $user_to_group = [];
            if (strcasecmp($this->staff->specialty, "Physician") == 0 || strcasecmp($this->staff->specialty, "Surgeon") == 0 || strcasecmp($this->staff->specialty, "Mid-wife") == 0 || strcasecmp($this->staff->specialty, "Lab technician") == 0) {
                $this->db->set("group_id", 2);
                $this->db->where("user_id", $this->personalInfo->user_id);
                $this->db->update("aauth_user_to_group");
            } else if (strcasecmp($this->staff->specialty, "Admin") == 0) {
                $this->db->set("group_id", 1);
                $this->db->where("user_id", $this->personalInfo->user_id);
                $this->db->update("aauth_user_to_group");
            }

            if ($isUpdate) {
                //print_r($this->personalInfo);
                //die();
                if (!empty($this->personalInfo->fullname)) {
                    $this->db->set("fullname", $this->personalInfo->fullname);
                }
                if (!empty($this->personalInfo->date_of_birth)) {
                    $this->db->set("date_of_birth", $this->personalInfo->date_of_birth);
                }
                if (!empty($this->personalInfo->gender)) {
                    $this->db->set("gender", $this->personalInfo->gender);
                }
                if (!empty($this->personalInfo->address)) {
                    $this->db->set("address", $this->personalInfo->address);
                }
                if (!empty($this->personalInfo->company)) {
                    $this->db->set("company", $this->personalInfo->company);
                }
                if (!empty($this->personalInfo->phone)) {
                    $this->db->set("phone", $this->personalInfo->phone);
                }
                if (!empty($this->personalInfo->pic)) {
                    $this->db->set("pic", $this->personalInfo->pic);
                }
                $this->db->where("user_id", $this->personalInfo->user_id);
                $this->db->update("personal_info");
            } else {
                $this->db->insert("personal_info", $this->personalInfo);
                $info_id = $this->db->insert_id();
            }

            if ($this->db->affected_rows() <= 0) {
// Delete user account
                $this->aauth->delete_user($t_return);
               // $die($info_id);
                $this->failure("Saving information failed");
                return;
            }

            $this->staff->user_id = $t_return;
            $this->db->insert("staff", $this->staff);
            $staff_id = $this->db->insert_id();
            if ($this->db->affected_rows() <= 0) {
                $this->aauth->delete_user($t_return);
//remove personal details

                $this->db->delete('personal_info', array('id' => $info_id));
                $this->failure("Saving information failed");
                return;
            }

//build staff object and return;
            $return_data['id'] = $staff_id;
            $return_data["working_hours"] = $this->staff->working_hours;
            $return_data["specialty"] = $this->staff->specialty;
            $return_data['fullname'] = $this->personalInfo->fullname;
            $return_data['date_of_birth'] = $this->personalInfo->date_of_birth;
            $return_data['gender'] = $this->personalInfo->gender;
            $return_data['address'] = $this->personalInfo->address;
            $return_data['company'] = $this->personalInfo->company;
            $return_data['pic'] = $this->personalInfo->pic;
            $return_data['phone'] = $this->personalInfo->phone;
            $return_data['account']["user_id"] = $t_return;
            $return_data['account']['email'] = $this->user->email;
            $return_data['account']['password'] = "";
            $return_data['account']['username'] = $this->user->username;
            $return_data['account']['groups'] = [];

            $this->success("User with ID: " . $this->staff->user_id . " is made a staff", $return_data);
            //die();
            return;
        } catch (Exception $ex) {
            $this->failure($ex);
            //$this->failure("Saving information failed");
        }
    }

    public function Update() {
        try {

//delete the personal information
            //$this->db->delete('personal_info', array("user_id" => $this->user->id));
//delete staff
            $this->db->delete('staff', array('user_id' => $this->user->id));

            $this->Add(true);
            return;
        } catch (Exception $ex) {
            
        }
//Owner does not exist 
        $this->failure("Update failed, user is not a staff");
    }

    public function All() {
//build staff object and return
        try {
            $staffs = [];
            $personal_infos = [];
            $staffs_to_return = [];
            $query = $this->db->get("staff");

            if ($this->db->affected_rows() > 0) {
//then  found staffs
                foreach ($query->result_array() as $row) {

                    $return_data['id'] = $row["id"];
                    $return_data["working_hours"] = $row["working_hours"];
                    $return_data["specialty"] = $row["specialty"];
                    $return_data['account']["user_id"] = $row['user_id'];

//get the staff personal information and save it
                    $this->db->where("user_id", $row["user_id"]);
                    $q = null;
                    $q = $this->db->get("personal_info");
                    if ($this->db->affected_rows() > 0) {
                        $personal_info = $q->result_array()[0];
                        $return_data['fullname'] = $personal_info["fullname"];
                        $return_data['date_of_birth'] = $personal_info["date_of_birth"];
                        $return_data['gender'] = $personal_info["gender"];
                        $return_data['address'] = $personal_info["address"];
                        $return_data['company'] = $personal_info["company"];
                        $return_data['phone'] = $personal_info["phone"];
                    }

                    $this->db->where("id", $row["user_id"]);
                    $u = $this->db->get("aauth_users");
                    if ($this->db->affected_rows() > 0) {
                        $user = $u->result_array()[0];
                        $turn_data['account']["user_id"] = $row["user_id"];
                        $return_data['account']['email'] = $user["email"];
                        $return_data['account']['password'] = "";
                        $return_data['account']['username'] = $user["name"];
                        $return_data['account']['groups'] = [];
                    }

                    array_push($staffs, $return_data);
                    $return_data = [];
                }

                $this->success("Staffs loaded successfully", $staffs);
                return;
            }
            $this->success("No data found");
            return;
        } catch (Exception $ex) {
            
        }
        $this->failure("Loading Staffs failed");
        return;
    }

    public
            function Delete() {
        try {
            $this->db->where("id", $this->staff->id);
            $this->db->delete("staff");
            if ($this->db->affected_rows() > 0) {
                $this->success("Staff with ID: " . $this->staff->id . " is deleted from database");
                return;
            }
        } catch (Exception $ex) {
            
        }
        $this->failure("Deleting staff failed");
        return;
    }

}
