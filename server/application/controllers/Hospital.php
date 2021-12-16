<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/* * *
 * *This class should only display the footer and header of the page
 * *Angular will load the rest of the page
 * *An application can have several layouts 
 * * */

class Hospital extends CI_Controller {

    public $returnData = [];

    public function __construct() {
        parent::__construct();

        $this->load->database();
        $this->load->library('Aauth');
        $this->load->model('Hospital_model', "hosptial_model");
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
    public function GetServices() {
        try {
//if(!is_login()) $this->failure("You must login to perform this action");
//Insert the new Onwer into the database
            
            $query = $this->db->get("service");
            if($this->db->affected_rows()>0){
                $this->success("Services loaded ", $query->result());
            }
            return;
        } catch (Exception $ex) {
            $this->failure("Saving information failed");
        }
    }
    
      public function PostScheduleToDoctor(){
        //get the schedule object
        $doctor_schedule =[];
        $doctor_schedule["doctor_id"] = $this->input->post("doctor_id");
        $doctor_schedule["schedule_id"] =$this->input->post("schedule_id");
        
        $this->db->insert("doctor_to_schedule",$doctor_schedule);
        if($this->db->affected_rows()>0){
            $this->success("Appointment is sent");
            return;
        }
        
        $this->failure("Failed to send appointment<br>Please try again");
    }

}
