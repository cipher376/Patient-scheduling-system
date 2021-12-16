<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * To perform authentication and session management
 *
 * */
class Auth extends CI_Controller {

    protected $returnData = [];
    public $user;

    public function __construct() {

        parent::__construct();

//$this->load->library('session');
        $this->load->database();
        $this->load->dbforge();
        $this->load->helper('url');
        $this->load->library('Aauth');

        $this->load->model('User_model', 'user_model');
        $this->load->model('Files_model', 'files');

        $this->user = $this->user_model->info;
//print_r($this->user);
//return;
//die(json_encode($this->user->email));
        if (empty($this->user->username)) {
            $this->user->username = explode("@", $this->user->email)[0]; //slash the email
        }
    }

    //Helper function 
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

    function has_permission($groups) {
        if (!$this->is_in_one_of_the_groups($groups)) {
            $this->failure("User don't have permission to view this page");
            die();
        }
    }

    function is_in_group($group_name) {
        $groups = $this->aauth->get_user_groups();
        foreach ($groups as $group) {
            if (strcasecmp($group->name, $group_name) == 0) {
                return true;
            }
        }
        return false;
    }

    function is_in_one_of_the_groups($groups) {
        foreach ($groups as $group) {
            if ($this->is_in_group($group)) {
                return true;
            }
        }
    }

    function get_groups($user_id) {
        $groups = $this->aauth->get_user_groups($user_id);
        $group_names = array();
        $i = 0;
        foreach ($groups as $group) {
            $group_names[$i] = $group->name;
            $i++;
        }
        return $group_names;
    }

    //Index is the default page layout
    public function Login() {
        $returnData = array();
        //print_r($this->user);        
        //die($this->user->password);
        //die($this->user->email);
        if ($this->aauth->login($this->user->email, $this->user->password, $this->user->remember)) {
            $returnData["msg"] = "Login successful";
            $returnData["Succeeded"] = true;
            //get user id
            $this->db->where('email', $this->user->email);
            $result = $this->db->get("aauth_users");
            $returnData['uid'] = $result->row()->id;
            $returnData['email'] = $this->user->email;
            $returnData['username'] = $result->row()->name;
            //Return the groups the user belongs to
            //get the groups name
            $groups = $this->aauth->get_user_groups($result->row()->id);
            $group_name = array();
            $i = 0;
            foreach ($groups as $group) {
                $group_name[$i] = $group->name;
                $i++;
            }
            $returnData['groups'] = $groups;
            $returnData['accounttype'] = $group_name;

            //get user details from user_info table
            $this->db->where("user_id", $returnData['uid']);
            $query = $this->db->get("personal_info");

            if ($this->db->affected_rows() > 0) {
                $returnData['fullname'] = $query->row()->fullname;
                $returnData['phone'] = $query->row()->phone;
                $returnData['gender'] = $query->row()->gender;
                $returnData['address'] = $query->row()->address;
                $returnData['date_of_birth'] = $query->row()->date_of_birth;
                $returnData['company'] = $query->row()->company;
                $returnData['pic'] = $query->row()->pic;
            }

            try {
                $this->db->where("user_id", $returnData['uid']);
                $query = $this->db->get("staff");
                if ($this->db->affected_rows() > 0) {
                    // print_r($query->result()[0]);
                    //die();
                    $temp = $query->result()[0];

                    $returnData['specialty'] = $temp->specialty;
                    $returnData['working_hours'] = $temp->working_hours;
                }
            } catch (Exception $e) {
                
            }
//die( $returnData['uid']);
        } else {

            $returnData["msg"] = 'Login failed';
            $returnData["Succeeded"] = false;
        }
        echo json_encode($returnData);
    }

    public function Logout() {
        $this->is_login(); // check if the user is login

        $this->aauth->logout();
        $returnData["msg"] = "Login successful";
        $returnData["Succeeded"] = true;
        echo json_encode($returnData);
    }

    public function Register() {
        $t_return = $this->aauth->create_user($this->user->email, $this->user->password, $this->user->username);
        //print($t_return);
        //die();
        if ($t_return) {
// save personal information
            $this->db->insert("personal_info", array("id" => "",
                "user_id" => $t_return, "phone" => $this->user->phone,
                "fullname" => $this->user->fullname, "gender" => $this->user->gender,
                "company" => $this->user->company, "address" => $this->user->address,
                "date_of_birth" => $this->user->date_of_birth, "pic" => ""));
            $returnData["msg"] = "Account creation successful";
            $returnData["Succeeded"] = true;
            echo json_encode($returnData);
            return;
        }
        $returnData["msg"] = "Account creation failed";
        $returnData["Succeeded"] = false;
//echo json_encode($this->user);
        echo json_encode($returnData);
    }

    public function DeleteAccount() {
        $this->is_login(); // check if the user is login
        $this->has_permission(["Admin", "Super"]);
        $this->delete_user($user_id);
    }

    public function UpdateAccount() {
        $this->is_login(); // check if the user is login
        //print_r($this->user);
        //die();
        try {
            // Updating the user table
            if (!is_null($this->user->email)) {
                $this->db->set("email", $this->user->email);
                $this->db->set("name", $this->user->username);
            }
            if (!is_null($this->user->password)) {
                $this->db->set("pass", $this->aauth->hash_password($this->user->password, $this->aauth->get_user_id()));
            }
            $this->db->where('id', $this->aauth->get_user_id());
            $this->db->update('aauth_users');

            // Updating personal information table;
            if (!empty($this->user->phone)) {
                $this->db->set("phone", $this->user->phone);
            }
            if (!empty($this->user->fullname)) {
                $this->db->set("fullname", $this->user->fullname);
            }
            if (!empty($this->user->date_of_birth)) {
                $this->db->set("date_of_birth", $this->user->date_of_birth);
            }
            if (!empty($this->user->address)) {
                $this->db->set("address", $this->user->address);
            }
            if (!empty($this->user->company)) {
                $this->db->set("company", $this->user->company);
            }
            if (!empty($this->user->gender)) {
                $this->db->set("gender", $this->user->gender);
            }
            if (!empty($this->user->pic)) {
                $this->db->set("pic", $this->user->pic);
            }
            $this->db->where('user_id', $this->aauth->get_user_id());
            $no_update = true;
            try{
            $this->db->update('personal_info');
            }catch(Exception $e){
                $no_update = false;
            }
// if no update is performed, insert as a new data
           
            if (!$no_update) {
                $data = [];
                $data["phone"] = $this->user->phone;
                $data["fullname"] = $this->user->fullname;
                $data["date_of_birth"] = $this->user->date_of_birth;
                $data["address"] = $this->user->address;
                $data["company"] = $this->user->company;
                $data["gender"] = $this->user->gender;
                $data["user_id"] = $this->aauth->get_user_id();

                $this->db->insert("personal_info", $data);
            }

            $this->db->where('email', $this->user->email);
            $result = $this->db->get("aauth_users");
            $returnData['uid'] = $result->row()->id;
            $returnData['email'] = $this->user->email;

            //Return the groups the user belongs to
            //get the groups name
            $groups = $this->aauth->get_user_groups($result->row()->id);
            $group_name = array();
            $i = 0;
            foreach ($groups as $group) {
                $group_name[$i] = $group->name;
                $i++;
            }
            $returnData['accounttype'] = $group_name;

            //get user details from user_info table
            $this->db->where("user_id", $this->aauth->get_user_id());
            $q = $this->db->get("personal_info");

            if ($this->db->affected_rows() > 0) {
                $returnData["fullname"] = $q->row()->fullname;
                $returnData["phone"] = $q->row()->phone;
                $returnData["gender"] = $q->row()->gender;
                $returnData["address"] = $q->row()->address;
                $returnData["date_of_birth"] = $q->row()->date_of_birth;
                $returnData["company"] = $q->row()->company;
                $returnData['pic'] = $q->row()->pic;
            }

            $returnData["msg"] = "Your account is updated";
            $returnData["Succeeded"] = true;
            echo json_encode($returnData);
            return;
        } catch (Exception $d) {
            
        }
        $returnData["msg"] = "Account update failed";
        $returnData["Succeeded"] = false;
        echo json_encode($returnData);
    }

    function All() {
        try {
            //get all user from database
            $users = [];
            $user = [];
            $query = $this->db->get("aauth_users");

            //print_r($query->result());
            //die();
            foreach ($query->result() as $row) {
                $user["email"] = $row->email;
                $user["username"] = $row->name;
                $user["user_id"] = $row->id;
                $user["groups"] = $this->get_groups($row->id);


                //get user details from user_info table
                $this->db->where("user_id", $row->id);
                $q = $this->db->get("personal_info");

                if ($this->db->affected_rows() > 0) {
                    $user["fullname"] = $q->row()->fullname;
                    $user["phone"] = $q->row()->phone;
                    $user["gender"] = $q->row()->gender;
                    $user["address"] = $q->row()->address;
                    $user["date_of_birth"] = $q->row()->date_of_birth;
                    $user["company"] = $q->row()->company;
                    $user['pic'] = $q->row()->pic;
                }
                
                

                $this->db->where("user_id", $row->id);
                $s = $this->db->get("staff");
                if ($this->db->affected_rows() > 0) {
                    // print_r($query->result()[0]);
                    //die();
                    $temp = $s->result()[0];
                    $user["specialty"] = $temp->specialty;
                    $user["working_hours"] = $temp->working_hours;
                }

                // add user to usess
                array_push($users, $user);
            }
            $this->success("Users are loaded", $users);
            return;
        } catch (Exception $ex) {
            
        }
        $this->failure("Loading users failed");
    }

    public function UploadImage() {
        $status = "";
        $msg = "";
        $this->load->helper('file');
        $realname = $this->input->get('id');
        //die($realname);
        $returnData = [];
        if (empty($realname)) {
            $status = "error";
            echo json_encode(array('status' => $status, 'Succeeded' => false, 'msg' => "File id not found"));
            return;
        }

        if ($status != "error") {
            $config = array();
            $config['upload_path'] = ASSET_PATH . "uploads";
            // die($config['upload_path']);
            $config['allowed_types'] = 'jpg|png';
            $config['max_size'] = 1024 * 8;
            $config['encrypt_name'] = TRUE;

            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if (!$this->upload->do_upload("file")) {
                $status = 'error';
                $msg = $this->upload->display_errors('', '');
            } else {
                $data = $this->upload->data();
                //die($realname);
                $file_id = $this->files->insert_file($data['file_name'], $realname);

                if ($file_id) {
                    $status = "success";
                    $msg = "File successfully uploaded";
                    $returnData = json_encode(array('status' => $status, 'Succeeded' => true, 'file'=>$data['file_name'], 'msg' => $msg));
                } else {
                    unlink($data['full_path']);
                    $status = "error";

                    $msg = "Something went wrong when saving the file, please try again.";
                    $returnData = json_encode(array('status' => $status, 'Succeeded' => false, 'msg' => $msg));
                }
                //die($msg);
            }
            @unlink($_FILES['file']);
        }
        echo $returnData;
    }
    
    public function UploadAttachment() {
        $status = "";
        $msg = "";
        $this->load->helper('file');
        $realname = $this->input->get('id');
        //die($realname);
        $returnData = [];
        if (empty($realname)) {
            $status = "error";
            echo json_encode(array('status' => $status, 'Succeeded' => false, 'msg' => "File id not found"));
            return;
        }

        if ($status != "error") {
            $config = array();
            $config['upload_path'] = ASSET_PATH . "uploads";
            // die($config['upload_path']);
            $config['allowed_types'] = 'jpg|png';
            $config['max_size'] = 1024 * 8;
            $config['encrypt_name'] = TRUE;

            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if (!$this->upload->do_upload("file")) {
                $status = 'error';
                $msg = $this->upload->display_errors('', '');
            } else {
                $data = $this->upload->data();
                
                if (!empty($data)) {
                    $status = "success";
                    $msg = "File successfully uploaded";
                    $returnData = json_encode(array('status' => $status, 'Succeeded' => true, 'file'=>$data['file_name'], 'msg' => $msg));
                } else {
                    unlink($data['full_path']);
                    $status = "error";

                    $msg = "Something went wrong when saving the file, please try again.";
                    $returnData = json_encode(array('status' => $status, 'Succeeded' => false, 'msg' => $msg));
                }
                //die($msg);
            }
            @unlink($_FILES['file']);
        }
        echo $returnData;
    }

    public function downloadImage() {

        $this->files->get_file($this->input->get('id'));
    }

    public function getProfileImage() {
        echo $this->files->getImagefile($this->input->get('id'));
    }

}
