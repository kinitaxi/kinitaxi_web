<?php

defined('BASEPATH') OR exit('No direct script access allowed');

use Restserver\Libraries\REST_Controller;
use PHPMailer\PHPMailer\PHPMailer;
use Twilio\Rest\Client;

require APPPATH . '/libraries/REST_Controller.php';
require 'vendor/autoload.php';

class Messaging extends REST_Controller {

    public $firebase;
    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->firebase = new \Firebase\FirebaseLib(DEFAULT_URL, DEFAULT_TOKEN); //load firebase engine
    }

    public function ragnarok_post(){
        $new_data = json_encode($this->post());
        $new_data = (array)json_decode($new_data);

        //send sms for otp using twiliio

        //generate the otp
        $otp = mt_rand(1000, 9999);

        //determines what gateway to use
        $gateway = json_decode($this->firebase->get('appSettings/sms_gateway', true), TRUE);

        //build message parameters
        $message = "Your KiniTaxi confirmation OTP is ".$otp.". Please note that this OTP will expire in 10 minutes.";
        $sender = 'KiniTaxi';
        $recipient = $new_data['recipient'];

        if ($gateway == 'twilio'){

            // use twilio
            $sid = "AC48ac777ec27977c3c702dcd3642da29b";
            $token = "d65f8163fd7b6dc748dc259647bb495d";
            $client = new Client($sid, $token);

            $client->messages->create(
                $recipient,
                [
                    'from' => $sender,
                    'body' => $message
                ]
            );

            // return the otp
            $this->set_response($otp, REST_Controller::HTTP_OK);

        }
        else{

            $message = $message = str_replace(' ', '+', $message);
            $url = 'http://api.smartsmssolutions.com/smsapi.php?username=dechosenuchenna&password=yucee.dll&sender='. $sender .'&recipient=@@'.$recipient.'@@&message='. $message .'&';
            $data = array();
            $options = array( //build http header variables
                'http' => array(
                    'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                    'method'  => 'POST',
                    'content' => http_build_query($data)
                )
            );
            $context  = stream_context_create($options);
            $result = file_get_contents($url, false, $context);

            if ($result === FALSE) {
                $this->set_response('failed', REST_Controller::HTTP_NOT_IMPLEMENTED); // return failed;
            }
            else $this->set_response($otp, REST_Controller::HTTP_OK); // return the otp if successful;

        }

    }

    public function dispatcher_post(){
        $new_data = json_encode($this->post());
        $new_data = (array)json_decode($new_data);
        $result = '';

        foreach($new_data as $key => $data){
            $message = str_replace(' ','+',$data);
            $url = 'http://api.smartsmssolutions.com/smsapi.php?username=dechosenuchenna&password=yucee.dll&sender=Alertify&recipient=@@'.$key.'@@&message='.$message.'&';
            $data = array();
            $options = array( //build http header variables
                'http' => array(
                    'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                    'method'  => 'POST',
                    'content' => http_build_query($data)
                )
            );
            $context  = stream_context_create($options);
            $result = file_get_contents($url, false, $context);
        }

        if ($result === FALSE) {
            $this->set_response('failed', REST_Controller::HTTP_NOT_IMPLEMENTED); // return failed;
        }
        else $this->set_response('success', REST_Controller::HTTP_OK); // return the otp if successful;
    }


}
