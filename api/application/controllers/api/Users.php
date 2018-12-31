<?php

defined('BASEPATH') OR exit('No direct script access allowed');

use Restserver\Libraries\REST_Controller;
use PHPMailer\PHPMailer\PHPMailer;

require APPPATH . '/libraries/REST_Controller.php';
require 'vendor/autoload.php';

class Users extends REST_Controller {

    public $firebase;

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->firebase = new \Firebase\FirebaseLib(DEFAULT_URL, DEFAULT_TOKEN); //load firebase engine
    }

    public function check_user_get(){
        $new_data = json_encode($this->get());
        $new_data = (array)json_decode($new_data);

        $existUser = json_decode($this->firebase->get(DEFAULT_PATH . '/' . $new_data['phone'], true), TRUE);
        if (is_null($existUser)){
            $this->set_response('null', REST_Controller::HTTP_OK); // OK (200) being the HTTP response code;
        }
        else{
            $this->set_response('exists', REST_Controller::HTTP_OK); // OK (200) being the HTTP response code;
        }
    }

    public function register_post(){
        $new_data = json_encode($this->post());
        $new_data = (array)json_decode($new_data);

        //checks if override is set on
        $existUser = json_decode($this->firebase->get(DEFAULT_PATH . '/' . $new_data['phone'], true), TRUE);

        if (is_null($existUser) || $new_data['override'] == 'true'){
            $user = [
                "first_name" => $new_data['first_name'],
                "last_name" => $new_data['last_name'],
                "photo_url" => $new_data['photo_url'],
                "email" => (isset($new_data['email']))?$new_data['email']:'false',
                "created_at" => $new_data['created_at']
            ];
            //perform save operation of user
            if($this->firebase->set(DEFAULT_PATH . '/' . $new_data['phone'], $user)) {
                if(isset($new_data['email']))
                {
                    //send welcome email
                    //build smtp protocol for email
                    $mail = new PHPMailer(true);
                    $mail->isSMTP();
                    $mail->Host = 'smtp.zoho.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = 'hello@kinitaxi.com';
                    $mail->Password = 'email2018';
                    $mail->SMTPSecure = 'tls';
                    $mail->Port = 587;
                    $mail->setFrom('hello@kinitaxi.com', 'Kinitaxi');
                    $mail->Timeout = 60;
                    $mail->addAddress($new_data['email']);
                    $mail->isHTML(true);
                    $mail->Body = '<!DOCTYPE html>
                            <html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta charset="utf-8"> <!-- utf-8 works for most cases -->
        <meta name="viewport" content="width=device-width"> <!-- Forcing initial-scale shouldn\'t be necessary -->
        <meta http-equiv="X-UA-Compatible" content="IE=edge"> <!-- Use the latest (edge) version of IE rendering engine -->
        <meta name="x-apple-disable-message-reformatting">  <!-- Disable auto-scale in iOS 10 Mail entirely -->
        <title></title> <!-- The title tag shows in email notifications, like Android 4.4. -->
    
        <style>
            html,
            body {
                margin: 0 auto !important;
                padding: 0 !important;
                height: 100% !important;
                width: 100% !important;
            }
            * {
                -ms-text-size-adjust: 100%;
                -webkit-text-size-adjust: 100%;
            }
            div[style*="margin: 16px 0"] {
                margin:0 !important;
            }
            table,
            td {
                mso-table-lspace: 0pt !important;
                mso-table-rspace: 0pt !important;
            }
            table {
                border-spacing: 0 !important;
                border-collapse: collapse !important;
                table-layout: fixed !important;
                margin: 0 auto !important;
            }
            table table table {
                table-layout: auto; 
            }
            
            /* What it does: Uses a better rendering method when resizing images in IE. */
            img {
                -ms-interpolation-mode:bicubic;
            }
            
            /* What it does: A work-around for iOS meddling in triggered links. */
            .mobile-link--footer a,
            a[x-apple-data-detectors] {
                color:inherit !important;
                text-decoration: underline !important;
            }
    
            /* What it does: Prevents underlining the button text in Windows 10 */
            .button-link {
                text-decoration: none !important;
            }
          
        </style>
        
        <!-- Progressive Enhancements -->
        <style>
            
            /* What it does: Hover styles for buttons */
            .button-td,
            .button-a {
                transition: all 100ms ease-in;
            }
            .button-td:hover,
            .button-a:hover {
                background: #555555 !important;
                border-color: #555555 !important;
            }
    
        </style>
    
    </head>
    <body width="100%" style="margin: 0; mso-line-height-rule: exactly;">
        <center style="width: 100%; background: #222222;">
    
            <!-- Visually Hidden Preheader Text : BEGIN -->
            <div style="display:none;font-size:1px;line-height:1px;max-height:0;max-width:0;opacity:0;overflow:hidden;mso-hide:all;font-family: sans-serif;">
                You are now part of the Kinitaxi family.
            </div>
            <table style="background-color: #D8D8D8; margin: 0; mso-table-lspace: 0; mso-table-rspace: 0; padding: 0; width: 100%;" cellspacing="0" cellpadding="0" border="0" bgcolor="#D8D8D8" width="100%" data-module-id="23" class="in-container ui-sortable-handle">
                <tbody><tr>
                  <td align="center" valign="top">
                    <table class="p100" style="background-color: white; margin: 0; mso-table-lspace: 0; mso-table-rspace: 0; padding: 0; width: 800px;" width="800" cellspacing="0" cellpadding="0" border="0" bgcolor="#F5F5F5">
                      <tbody><tr>
                        <td style="width: 30px;" width="30" valign="top" align="left">&nbsp;</td>
                        <td align="center" valign="top">
                          <table class="p100" style="margin: 0; mso-table-lspace: 0; mso-table-rspace: 0; padding: 0; width: 600px;" width="600" cellspacing="0" cellpadding="0" border="0">
                            <tbody><tr>
                              <td align="center" valign="top">
                                <table class="p100" style="margin: 0; mso-table-lspace: 0; mso-table-rspace: 0; padding: 0; width: 600px;" width="600" cellspacing="0" cellpadding="0" border="0">
                                  <tbody><tr>
                                    <td style="height: 30px; line-height: 30px; mso-line-height-rule: exactly;" valign="top" align="left">&nbsp;</td>
                                  </tr>
                                  <tr>
                                    <td class="hide" style="height: 25px; line-height: 25px; mso-line-height-rule: exactly;" valign="top" align="left">&nbsp;</td>
                                  </tr>
                                  <tr>
                                    <td style="color: rgb(91, 91, 91); font-size: 12px; font-weight: 300; letter-spacing: 0.1em; text-align: center; text-transform: uppercase; cursor: pointer; box-sizing: content-box; outline: none 0px;" valign="top" align="left" class="editable_text header2"><font face="\'Open Sans\', sans-serif">We are excited to have you</font>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td style="height: 15px; line-height: 15px; mso-line-height-rule: exactly;" valign="top" align="left">&nbsp;</td>
                                  </tr>
                                  <tr>
                                    <td style="color: rgb(51, 51, 51); font-size: 35px; font-weight: 700; letter-spacing: 0; text-align: center; cursor: pointer;" valign="top" align="left" class="editable_text header"><font face="\'Open Sans\', sans-serif">WELCOME ABOARD</font>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td style="height: 30px; line-height: 30px; mso-line-height-rule: exactly;" valign="top" align="left">&nbsp;</td>
                                  </tr>
                                  <tr>
                                    <td class="hide" style="height: 5px; line-height: 5px; mso-line-height-rule: exactly;" valign="top" align="left">&nbsp;</td>
                                  </tr>
                                  <tr>
                                    <td style="border-bottom: 1px solid #ccc; height: 1px; line-height: 1px; mso-line-height-rule: exactly;" valign="top" align="left">&nbsp;</td>
                                  </tr>
                                </tbody></table>
                              </td>
                            </tr>
                            <tr>
                              <td style="height: 40px; line-height: 40px; mso-line-height-rule: exactly;" valign="top" align="left">&nbsp;</td>
                            </tr>
                            <tr>
                              <td align="center" valign="top">
                                <table class="p100" style="margin: 0; mso-table-lspace: 0; mso-table-rspace: 0; padding: 0; width: 600px;" width="600" cellspacing="0" cellpadding="0" border="0" align="center">
                                  <tbody><tr>
                                    <td valign="top" align="left">
                                      <table style="margin: 0; mso-table-lspace: 0; mso-table-rspace: 0; padding: 0; width: 100%;" cellspacing="0" cellpadding="0" border="0" width="100%">
                                        <tbody><tr>
                                          <td style="background-color: transparent; height: 60px; line-height: 60px; width: auto; mso-line-height-rule: exactly;" valign="top" align="left" bgcolor="transparent">
                                            
                                          </td>
                                        </tr>
                                        <tr>
                                          <td style="background-color: #ffffff; height: 60px; line-height: 60px; max-width: 240px; width: auto; mso-line-height-rule: exactly;" valign="top" align="left" bgcolor="#ffffff">
                                            
                                          </td>
                                        </tr>
                                      </tbody></table>
                                    </td>
                                    <td style="width: 120px;" width="120" valign="top" align="left">
                                      <table style="background-color: #ffffff; border-bottom-left-radius: 0; border-bottom-right-radius: 0; border-top-left-radius: 60px; border-top-right-radius: 60px; margin: 0; mso-table-lspace: 0; mso-table-rspace: 0; padding: 0; width: 120px;" width="120" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff">
                                        <tbody><tr>
                                          <td valign="middle" style="background-color: #ffffff; border-bottom-left-radius: 0; border-bottom-right-radius: 0; border-top-left-radius: 60px; border-top-right-radius: 60px; height: 120px; line-height: 120px; width: 120px; mso-line-height-rule: exactly;" width="120" align="center" bgcolor="#ffffff">
                                            <table style="margin: 0; mso-table-lspace: 0; mso-table-rspace: 0; padding: 0; width: 100px;" width="100" cellspacing="0" cellpadding="0" border="0" align="center">
                                              <tbody><tr>
                                                <td style="height: 100px; width: 100px;" width="100" valign="top" align="left">
                                                  <a href="#" style="border: none; display: block; outline: none; text-decoration: none; cursor: pointer;">
                                                    <img src="http://138.197.230.230/kini_alone.png" alt="myPhoto" style="-ms-interpolation-mode: bicubic; border: 0; border-bottom-left-radius: 50px; border-bottom-right-radius: 50px; border-top-left-radius: 50px; border-top-right-radius: 50px; display: block; height: 100px; outline: 0; text-decoration: none; width: 100px;" width="100" border="0">
                                                  </a>
                                                </td>
                                              </tr>
                                            </tbody></table>
                                          </td>
                                        </tr>
                                      </tbody></table>
                                    </td>
                                    <td valign="top" align="left">
                                      <table style="margin: 0; mso-table-lspace: 0; mso-table-rspace: 0; padding: 0; width: 100%;" cellspacing="0" cellpadding="0" border="0" width="100%">
                                        <tbody><tr>
                                          <td style="background-color: transparent; height: 60px; line-height: 60px; width: auto; mso-line-height-rule: exactly;" valign="top" align="left" bgcolor="transparent">
                                            
                                          </td>
                                        </tr>
                                        <tr>
                                          <td style="background-color: #ffffff; height: 60px; line-height: 60px; max-width: 240px; width: auto; mso-line-height-rule: exactly;" valign="top" align="left" bgcolor="#ffffff">
                                            
                                          </td>
                                        </tr>
                                      </tbody></table>
                                    </td>
                                  </tr>
                                </tbody></table>
                              </td>
                            </tr>
                          </tbody></table>
                          <table class="p100" style="background-color: #ffffff; margin: 0; mso-table-lspace: 0; mso-table-rspace: 0; padding: 0; width: 600px;" width="600" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff" align="center">
                            <tbody><tr>
                              <td style="width: 30px;" width="30" valign="top" align="left">&nbsp;</td>
                              <td style="width: 540px;" width="540" valign="top" align="left">
                                <table class="p100" style="margin: 0; mso-table-lspace: 0; mso-table-rspace: 0; padding: 0; width: 540px;" width="540" cellspacing="0" cellpadding="0" border="0">
                                  <tbody><tr>
                                    <td style="height: 20px; line-height: 20px; mso-line-height-rule: exactly;" valign="top" align="left">&nbsp;</td>
                                  </tr>
                                  <tr>
                                    <td style="color: rgb(0, 0, 0); font-size: 19px; font-weight: 300; letter-spacing: 0; text-align: center; cursor: pointer;" valign="top" align="left" class="editable_text header3"><font face="\'Open Sans\', sans-serif">Welcome to Kinitaxi</font>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td style="height: 15px; line-height: 15px; mso-line-height-rule: exactly;" valign="top" align="left">&nbsp;</td>
                                  </tr>
                                  <tr>
                                    <td style="color: rgb(158, 158, 158); font-size: 12px; letter-spacing: 0.1em; text-align: center; cursor: pointer;" valign="top" align="left" class="editable_text text"><font face="\'Open Sans\', sans-serif">The easiest way to get around town</font>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td style="height: 25px; line-height: 25px; mso-line-height-rule: exactly;" valign="top" align="left">&nbsp;</td>
                                  </tr>
                                  <tr>
                                    <td style="color: rgb(139, 139, 139); font-size: 14px; font-style: italic; letter-spacing: 0.02em; line-height: 23px; text-align: center; word-spacing: 0.1em; cursor: pointer;" valign="top" align="left" class="editable_text text2"><font face="\'Open Sans\', sans-serif">Hi, thanks for signing up to ride with Kinitaxi. You work really hard to get to where you are going, we want to help you get there faster and in comfort. Hailing rides has never been this easy, just select where you are going and in minutes a driver is there to pick you up. We can'."'".'t wait to see how you will use Kinitaxi, cheers.</font>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td style="height: 25px; line-height: 25px; mso-line-height-rule: exactly;" valign="top" align="left">&nbsp;</td>
                                  </tr>
                                  <tr>
                                    <td style="color: #81c644; font-size: 59px; line-height: 60px; text-align: center; mso-line-height-rule: exactly;" valign="top" align="left">”</td>
                                  </tr>
                                </tbody></table>
                              </td>
                              <td style="width: 30px;" width="30" valign="top" align="left">&nbsp;</td>
                            </tr>
                          </tbody></table>
                          <table class="p100" style="margin: 0; mso-table-lspace: 0; mso-table-rspace: 0; padding: 0; width: 600px;" width="600" cellspacing="0" cellpadding="0" border="0">
                            <tbody><tr>
                              <td style="height: 60px; line-height: 60px; mso-line-height-rule: exactly;" valign="top" align="left">&nbsp;</td>
                            </tr>
                          </tbody></table>
                        </td>
                        <td style="width: 30px;" width="30" valign="top" align="left">&nbsp;</td>
                      </tr>
                    </tbody></table>
                  </td>
                </tr>
              </tbody>
            </table>
            </center>
    </body>
    </html>';
                    $mail->Subject = 'Welcome Aboard';
                    $mail->send();
                }
                $this->set_response('success', REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            } else {
                $this->set_response('failed', REST_Controller::HTTP_NOT_IMPLEMENTED); // OK (200) being the HTTP response code;
            }
        }
        else{
            $this->set_response('exists', REST_Controller::HTTP_OK); // OK (200) being the HTTP response code;
        }
    }

    public function users_get()
    {

        if (isset($_GET['user'])){ //gets data for specific user
            $this->set_response(json_decode($this->firebase->get(DEFAULT_PATH.'/'.$_GET['user'], true), TRUE), REST_Controller::HTTP_OK);
        }
        else {
            $users = json_decode($this->firebase->get(DEFAULT_PATH, true), TRUE);
            //todo: paginate all users
            $this->set_response(isset($_GET['count']) ? count($users) : $users, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }
    }

    public function users_post(){
        //for updating a specific user
        if (isset($_POST['phone'])){
            if($this->firebase->update(DEFAULT_PATH . '/' . $_POST['phone'], [
                'first_name' => $_POST['first_name'],
                'last_name' => $_POST['last_name'],
                'email' => $_POST['email']
            ])) {
                $this->set_response('success', REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            } else {
                $this->set_response('failed', REST_Controller::HTTP_NOT_IMPLEMENTED);
            }
        }
        ///////////////////////////////////////////////////////////////////////
    }
    public function users_delete(){
        //for deleting a specific user
        if (isset($_GET['user_id'])){
            if($this->firebase->delete(DEFAULT_PATH . '/' . $_GET['user_id'])) {
                $this->set_response('success', REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            } else {
                $this->set_response('failed', REST_Controller::HTTP_NOT_IMPLEMENTED);
            }
        }
        ///////////////////////////////////////////////////////////////////////
    }

    public function ride_history_get(){
        //first run data encoding and decoding
        $new_data = json_encode($this->get());
        $new_data = (array)json_decode($new_data, TRUE);

        //get all ride history for the user
        $rides = json_decode($this->firebase->get(DEFAULT_PATH .'/'.$new_data['user_id'].'/rides', true), TRUE); //gets the position of the rider

        //trims the number of rides retrieved depending on the page_no |page_no can be 'all'
        $rides = (is_numeric($new_data['page_no']))?array_slice($rides, ((int)$new_data['page_no']-1)*10, 10):$rides;

        //fetch the data for every ride in $rides
        $ride_data = [];
        if (count($rides)>0){
            foreach($rides as $key => $ride){
                $temData = json_decode($this->firebase->get('rideCreated/'.$key, true), TRUE);
                $ride_data[] = [
                    'ride_id' => $key,
                    'pickup_address' => $temData['pickup_address'],
                    'destination_address' => $temData['destination_address'],
                    'total_fare' => (is_null($temData['fares']['total_fare']))?0:$temData['fares']['total_fare'],
                    'status' => $temData['status'],
                    'created_at' => $temData['created_at'],
                ];
            }
            $this->set_response($ride_data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }else $this->set_response('no_ride', REST_Controller::HTTP_OK); // OK (200) being the HTTP response code



    }
}
