<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * To perform authentication and session management
 *
 * */
class Admin extends CI_Controller {

    public function __construct() {

        parent::__construct();

        //$this->load->library('session');
        $this->load->database();
        $this->load->dbforge();
        $this->load->helper('url');
        $this->load->library('Aauth');

        $this->load->model('User_model', 'user');
        $this->load->model('Permission_model', 'permission');
        $this->load->model('Group_model', 'group');
        $this->load->model('AdminData_model', 'data');

        $this->user->email = $this->input->post('user')['email'];
        //print_r($this->input->post('user'));die();
        $this->user->password = $this->input->post('user')['password'];
        $this->user->remember = $this->input->post('user')['remember'];
        $this->user->id = $this->input->post("user")['id'];

        $this->group->name = $this->input->post('group')['name'];
        $this->group->id = $this->input->post('group')['id'];
        $this->group->def = $this->input->post('group')['def'];

        $this->permission->name = $this->input->post('permission')['name'];
        $this->permission->id = $this->input->post('permission')['id'];
        $this->permission->def = $this->input->post('permission')['def'];
    }

    public function CreateGroup() {
        //must be an admin
        if ($this->aauth->is_loggedin() && $this->aauth->is_Admin()) {
            
            $this->aauth->create_group($this->group->name, $this->group->def);
            $returnData["Succeeded"] = true;
        } else {
            $returnData["Succeeded"] = false;
        }
        echo json_encode($returnData);
    }

    public function UpdateGroupById() {
        if ($this->aauth->is_loggedin() && $this->aauth->is_Admin()) {
            $returnData["Succeeded"] = $this->aauth->update_group($this->group->id, $this->group->name, $this->group->def);
        } else {
            $returnData["Succeeded"] = false;
        }
        echo json_encode($returnData);
    }

    public function UpdateGroupByName() {
        if ($this->aauth->is_loggedin() && $this->aauth->is_Admin()) {
            $this->aauth->update_group($this->group->name, $this->group->name, $this->group->def);

            $returnData["Succeeded"] = true;
        } else {
            $returnData["Succeeded"] = false;
        }
        echo json_encode($returnData);
    }

    public function DeleteGroupById() {
        if ($this->aauth->is_loggedin() && $this->aauth->is_Admin()) {

            if ($this->aauth->delete_group($this->group->id)) {
                $returnData["Succeeded"] = true;
            } else {
                $returnData["Succeeded"] = false;
            }
        } else {
            $returnData["Succeeded"] = false;
        }
        echo json_encode($returnData);
    }

    public function DeleteGroupByName() {
        if ($this->aauth->is_loggedin() && $this->aauth->is_Admin()) {

            if ($this->aauth->delete_group($this->group->name)) {
                $returnData["Succeeded"] = true;
            } else {
                $returnData["Succeeded"] = false;
            }
        } else {
            $returnData["Succeeded"] = false;
        }
        echo json_encode($returnData);
    }

    public function AddMemberToGroupById() {
        if ($this->aauth->is_loggedin() && $this->aauth->is_Admin()) {

            if ($this->aauth->add_member($this->user->id, $this->group->id)) {
                $returnData["Succeeded"] = true;
            } else {
                $returnData["Succeeded"] = false;
            }
        } else {
            $returnData["Succeeded"] = false;
        }
        echo json_encode($returnData);
    }

    public function AddMemberToGroupByName() {
        if ($this->aauth->is_loggedin() && $this->aauth->is_Admin()) {
            if ($this->aauth->add_member($this->user->id, $this->group->name)) {
                $returnData["Succeeded"] = true;
            } else {
                $returnData["Succeeded"] = false;
            }
        } else {
            $returnData["Succeeded"] = false;
        }
        echo json_encode($returnData);
    }

    public function RemoveMemberFromGroup() {
        //die('eh")');
        if ($this->aauth->is_loggedin() && $this->aauth->is_Admin()) {

            $returnData["Succeeded"] = $this->aauth->remove_member($this->aauth->get_user_id($this->user->email), $this->group->name);
        } else {

            $returnData["Succeeded"] = false;
        }

        echo json_encode($returnData);
    }

    public function GetGroups() {
        if ($this->aauth->is_loggedin() && $this->aauth->is_Admin()) {
            return $this->aauth->list_groups();
        } else {
            $returnData["Succeeded"] = false;
        }
        echo json_encode($returnData);
    }

    public function GetAdminData() {
        if ($this->aauth->is_loggedin() && $this->aauth->is_Admin()) {
            //Prepare the admin data
            $this->data->groups = $this->aauth->list_groups();
            $this->data->permissions = $this->aauth->list_perms();

            //Clean user data
            $users = $this->aauth->list_users();
            $_users = array();
            foreach ($users as $user) {
                $user->banned = "";
                $user->pass = "";
                $user->remember_exp = "";
                $user->remember_time = "";
                $user->verification_code = "";
                array_push($_users, $user);
            }
            $this->data->users = $users;

            // print_r($this->data);
            $returnData['data'] = $this->data;
            $returnData["Succeeded"] = true;
        } else {
            $returnData["Succeeded"] = false;
        }
        echo json_encode($returnData);
    }

}
