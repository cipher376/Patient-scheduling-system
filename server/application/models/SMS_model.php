<?php

require TWILIO . '/autoload.php';

use Twilio\Twiml;
use Twilio\Rest\Client;

defined('BASEPATH') OR exit('No direct script access allowed');

/*
  // Your Account SID and Auth Token from twilio.com/console
  $account_sid = 'ACXXXXXXXXXXXXXXXXXXXXXXXXXXXX';
  $auth_token = 'your_auth_token';
  // In production, these should be environment variables. E.g.:
  // $auth_token = $_ENV["TWILIO_ACCOUNT_SID"]

  // A Twilio number you own with SMS capabilities
  $twilio_number = "+15017122661";

  $client = new Client($account_sid, $auth_token);
  $client->messages->create(
  // Where to send a text message (your cell phone?)
  '+15558675310',
  array(
  'from' => $twilio_number,
  'body' => 'I sent this message in under 10 minutes!'
  )
  );

 */

class SMS_model extends CI_Model {

    private $account_sid = 'AC9c1fe70243597c7d5ef6ddf1a6ade702';
    private $auth_token = '078f81839a4de4fc2f70cdc9febcf1e5';
    private $twilio_number = "+19042990176";
    private $receiver = '+233544686951';
    private $message = "";

    function __construct() {
        parent::__construct();
    }

    public function SendSMS($receiver, $message) {
        $error = "";
        try{
        $client = new Client($this->account_sid, $this->auth_token);
        $client->messages->create(
                $receiver, array(
            'from' => $this->twilio_number,
            'body' => $message
                )
        );
        }catch(Exception $e){
            $error = $e;
        }
        
        return $error;
    }

    public function ReplySMS() {
// Set the content-type to XML to send back TwiML from the PHP Helper Library
        header("content-type: text/xml");
        $response = new Twiml();
        $response->message(
                "I'm using the Twilio PHP library to respond to this SMS!"
        );

        echo $response;
    }

}
