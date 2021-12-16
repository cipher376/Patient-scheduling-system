<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/* * *
 * *This class should only display the footer and header of the page
 * *Angular will load the rest of the page
 * *An application can have several layouts 
 * * */

class Schedule {

    public $id;
    public $service_id;
    public $date;
    public $doctor_id;
    public $user_id;
    public $status;

}

class Patient extends CI_Controller {

    public $returnData = [];
    public $schedule;

    public function __construct() {
        parent::__construct();

        $this->load->database();
        $this->load->library('Aauth');
        $this->load->model('SMS_model','sms');
        
        $this->schedule = new Schedule();
        $this->schedule->id = $this->input->post("id");
        $this->schedule->service_id = $this->input->post("service_id");
        $this->schedule->date = $this->input->post("date");
        $this->schedule->doctor_id = $this->input->post("doctor_id");
        $this->schedule->user_id = $this->input->post("user_id");
        $this->schedule->status = $this->input->post("status");

        // print_r($schedule);
        // die();
    }

// Helper functions 

    public function success($msg, $data = null) {
        $this->returnData['msg'] = $msg;
        $this->returnData['data'] = $data;
        $this->returnData['Succeeded'] = true;

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

    public function AddSchedule() {
        try {
//if(!is_login()) $this->failure("You must login to perform this action");
//Insert the new Onwer into the database
            $this->db->insert("schedule", $this->schedule);
            $schedule_id = $this->db->insert_id();
            if ($this->db->affected_rows() > 0) {
                //verify appointment
                $this->db->where("id", $schedule_id);
                $schedule = $this->db->get("schedule")->row();
                
                
                $message=[];     
                //print_r($schedule);
                //die();
                
//send sms message from to user 
                $this->db->where("user_id", $schedule->user_id);
                $message["user"] = $this->db->get("personal_info")->row();
                
                $this->db->where("user_id", $schedule->doctor_id);
                $message["doctor"] = $this->db->get("personal_info")->row();
                
                $this->db->where("id", $schedule->service_id);
                $message["service"] = $this->db->get("service")->row();
                
                //print_r($schedule);
                //print_r($message);
                
                //die();
                
                $msg = "Your ".$message["service"] ->title." appointment with Dr. ".$message['doctor']->fullname.
                        " on ".$schedule->date." has been booked. We look forward to see you.";
                
                $schedule->error = $this->sms->SendSMS($message["user"]->phone, $msg);
                //die($schedule->error);
                
                $this->success("Your appointment is sent, you will be notify shortly by sms.\n Thank you for using our service", $schedule);
             
            }
            return;
        } catch (Exception $ex) {
            $this->failure("Sending appointment failed, please try again in a few minutes.\n We appologize for the any inconvinience");
        }
    }

    public function UpdateSchedule() {
        try {
//if(!is_login()) $this->failure("You must login to perform this action");
//Insert the new Onwer into the database
            //verify appointment
            $this->db->where("id", $this->schedule->id);
            $query = $this->db->get("schedule");
            if ($this->db->affected_rows() > 0) {
                //perform update;
                $this->db->where("id", $this->schedule->id);
                $this->db->set("date", $this->schedule->date);
                $this->db->set("service_id", $this->schedule->service_id);
                $this->db->set("doctor_id", $this->schedule->doctor_id);
                $this->db->set("user_id", $this->schedule->user_id);
                $this->db->set("status", $this->schedule->status); //pending, asigned, expired, honored, ready
                $this->db->update("schedule");
                $message=[];     
                
//send sms message from to user 
                $this->db->where("user_id", $schedule->user_id);
                $message["user"] = $this->db->get("personal_info")->row();
                
                $this->db->where("user_id", $schedule->doctor_id);
                $message["doctor"] = $this->db->get("personal_info")->row();
                
                $this->db->where("id", $schedule->service_id);
                $message["service"] = $this->db->get("service")->row();
                
                $msg = "Your ".$message["service"] ->title." appointment with Dr. ".$message['doctor']->fullname.
                        " on ".$schedule->date." has been updated";
                
                $schedule->error = $this->sms->SendSMS($message["user"]->phone, $msg);
                
                $this->success("Your appointment have been updated", $query->result());
            }
            return;
        } catch (Exception $ex) {
            $this->failure("Updating appointment failed<br>Please try again at later time");
        }
    }

    public function CancelSchedule() {
        try {
//if(!is_login()) $this->failure("You must login to perform this action");
//Insert the new Onwer into the database
            $this->db->delete('schedule', array('id' => $this->schedule->id));
            if ($this->db->affected_rows() > 0) {
                $this->success("Appointment has been cancel | remove from database");
                return;
            }
        } catch (Exception $ex) {
            
        }
        $this->failure("We couldn't cancel the appointment, please try again later");
    }

    public function GetSchedulesByUser() {
        try {
//if(!is_login()) $this->failure("You must login to perform this action");
//Insert the new Onwer into the database
            $this->db->where("user_id", $this->aauth->get_user_id());
            $query = $this->db->get("schedule");
            if ($this->db->affected_rows() > 0) {
                $this->success("Your appointments have been loaded", $query->result());
            }
            return;
        } catch (Exception $ex) {
            $this->failure("Loading schedules failed");
        }
    }

    public function GetAllSchedules() {
        try {
            //if(!is_login()) $this->failure("You must login to perform this action");
            $query = $this->db->get("schedule");
            if ($this->db->affected_rows() > 0) {
                $this->success("Your appointments have been loaded", $query->result());
            }
            return;
        } catch (Exception $ex) {
            $this->failure("Saving information failed");
        }
    }

}
