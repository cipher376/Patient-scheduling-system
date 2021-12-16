<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/* * *
 * *This class should only display the footer and header of the page
 * *Angular will load the rest of the page
 * *An application can have several layouts 
 * * */

class MessageStruct{
        public $id;
        public $sender_id;
        public $receiver_id;
        public $content;
        public $title;
        public $date;
        public $attachment;
}

class Message extends CI_Controller {

    public $returnData = [];
    public $message;

    public function __construct() {
        parent::__construct();

        $this->load->database();
        $this->load->library('Aauth');
        $this->load->model('SMS_model', "sms");
        $this->load->model('Files_model', "files");
        

        $this->message = new MessageStruct();

        //Binds
        $this->message->id = $this->input->post("id");
        $this->message->sender_id = $this->input->post("sender_id");
        $this->message->receiver_id = $this->input->post("receiver_id");
        $this->message->content = $this->input->post("content");
        $this->message->title = $this->input->post("title");
        $this->message->date = $this->input->post("date");
        $this->message->attachment = $this->input->post("attachment");

        //print_r($this->message);
        //die();
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
    
    public function GetMessagesByUserId() {
        try {
            //if(!is_login()) $this->failure("You must login to perform this action");
            //Insert the new Onwer into the database
            
            //die("hello");
            
            $messages = [];
            $message = [];
            $this->db->where("receiver_id", $this->aauth->get_user_id());
            $query = $this->db->get("message");
            if ($this->db->affected_rows() > 0) {
                foreach ($query->result() as $msg) {
                    $message["id"] = $msg->id;
                    $message["title"] = $msg->title;
                    $message["date"] = $msg->date;
                    $message["content"] = $msg->content;
                    $message["sender_id"] = $msg->sender_id;
                    $message["receiver_id"] = $msg->receiver_id;
                    $message["attachment"] = $msg->attachment;
                    try{
                    //get sender information;
                    $this->db->where("id", $msg->sender_id);
                    $query = $this->db->get("aauth_users");
                    $s = $query->row();
                    $message["sender_email"] = $s->email;
                    
                    }
                     catch (Exception $ex) {

                    }
                     try{
                    $this->db->where("user_id", $msg->sender_id);
                    $query = $this->db->get("personal_info");
                    $p = $query->row();
                    $message["sender_name"] = $p->fullname;
                    }
                     catch (Exception $ex) {

                    }
                     try{
                    //die($msg->sender_id);
                    $this->db->where("user_id", $msg->sender_id);
                    $query = $this->db->get("staff");
                    $p = $query->row();
                    
                    //print($p);
                    //print_r($p);
                    //die();
                    $message["sender_specialty"] = $p->specialty;
                    }
                     catch (Exception $ex) {

                    }
                    array_push($messages, $message);
                }

                $this->success("Messages loaded successfully ", $messages);
            }
            return;
        } catch (Exception $ex) {
            $this->failure("Saving information failed");
        }
    }

    public function sendMessage() {
        $this->db->insert("message", $this->message);
        if ($this->db->affected_rows() > 0) {
            $this->success("Messages loaded successfully ", $this->message);

            // mark schedule as honoured
            $this->db->where("id", $this->input->post('schedule_id'));
            $this->db->set("status", 'honored'); //pending, asigned, expired, honored, ready
            $this->db->update("schedule");
            
            
            $this->db->where("id", $this->input->post('schedule_id'));
            $query = $this->db->get("schedule");
            
            if($this->db->affected_rows()>0){
                $schedule = $query->row();
                //get user 
                $this->db->where("user_id", $schedule->user_id);
            $query = $this->db->get("personal_info");
            
            if($this->db->affected_rows()>0){
                $receiver = $query->row();
                $msg = $this->message->title."\n".$this->message->content ."\n ".$this->message->date. +" \n No Reply";
                
                 $eroor = $this->sms->SendSMS($receiver->phone, $msg);
                
            }
            }
            
           
            return;
        }
        $this->failure("Failed to send message, Please try again");
    }

    public function deleteMessage() {
        $this->db->where("receiver_id", $this->aauth->get_user_id());
        $this->db->where("id", $this->message->id);
        $query = $this->db->delet("message");
        if ($this->affected_rows() > 0) {
            $this->success("Message is deleted");
            return;
        }
    }

    public function SendSMS() {
        $this->sms->SendSMS("+233544686951", "Your appointment is ready");
    }
    
    public function downloadAttachment() {
        $this->files->get_attachment($this->input->post('id'));
    }
    public function getAttachementUrl(){
        $path = $this->files->get_attachment_path($this->input->post('id'));
        
         $this->success("", $path);
    }

}
