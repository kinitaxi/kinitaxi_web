<?php

defined('BASEPATH') OR exit('No direct script access allowed');

use Restserver\Libraries\REST_Controller;
use PHPMailer\PHPMailer\PHPMailer;

require APPPATH . '/libraries/REST_Controller.php';
require 'vendor/autoload.php';

class Drivers extends REST_Controller
{

    public $firebase;

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->firebase = new \Firebase\FirebaseLib(DEFAULT_URL, DEFAULT_TOKEN); //load firebase engine
    }

    public function check_driver_get()
    {
        $new_data = json_encode($this->get());
        $new_data = (array)json_decode($new_data);

        $existUser = $this->firebase->get('drivers/' . $new_data['phone'], true);

        if ($existUser == 'null') {
            $this->set_response('null', REST_Controller::HTTP_OK); // OK (200) being the HTTP response code;
        } else {
            $this->set_response('exists', REST_Controller::HTTP_OK); // OK (200) being the HTTP response code;
        }
    }
    
    public function check_status_get()
    {
        $new_data = json_encode($this->get());
        $new_data = (array)json_decode($new_data);

        $status = json_decode($this->firebase->get('drivers' . '/' . $new_data['phone'] . '/account_status', true), TRUE);
        $this->set_response($status, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code;
    }

    public function send_email_post()
    {
        $new_data = json_encode($this->post());
        $new_data = (array)json_decode($new_data);

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
        $mail->setFrom('hello@kinitaxi.com', 'KiniTaxi');
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
                    You are now part of the KiniTaxi family.
                </div>
                <table style="background-color: white; margin: 0; mso-table-lspace: 0; mso-table-rspace: 0; padding: 0; width: 100%;" cellspacing="0" cellpadding="0" border="0" bgcolor="#D8D8D8" width="100%" data-module-id="19" class="in-container ui-sortable-handle">
                    <tbody>
                        <tr>
                          <td align="center" valign="top">
                            <table class="p100" style="margin: 0; mso-table-lspace: 0; mso-table-rspace: 0; padding: 0; width: 800px;" width="800" cellspacing="0" cellpadding="0" border="0">
                              <tbody><tr>
                                <td style="background-color: #18273D;" align="center" valign="top" bgcolor="#18273D">
                                  <!--[if gte mso 9]>
                                       <v:rect xmlns:v="urn:schemas-microsoft-com:vml" fill="true" stroke="false" style="width:800px;">
                                      <v:fill type="frame" src="" color="#26233A" ></v:fill>
                                      <v:textbox style="mso-fit-shape-to-text:true" inset="0,0,0,0">
                                      <![endif]-->
                                  <table class="p100" style="margin: 0; mso-table-lspace: 0; mso-table-rspace: 0; padding: 0; width: 660px;" width="660" cellspacing="0" cellpadding="0" border="0" align="center">
                                    <tbody><tr>
                                      <td style="width: 30px;" width="30" valign="top" align="left">&nbsp;</td>
                                      <td align="center" valign="top">
                                        <table class="p100" style="margin: 0; mso-table-lspace: 0; mso-table-rspace: 0; padding: 0; width: 600px;" width="600" cellspacing="0" cellpadding="0" border="0" align="center">
                                          <tbody><tr>
                                            <td valign="top" align="left">
                                              <table class="p100" style="margin: 0; mso-table-lspace: 0; mso-table-rspace: 0; padding: 0; width: 600px;" width="600" cellspacing="0" cellpadding="0" border="0">
                                                <tbody><tr>
                                                  <td style="height: 30px; line-height: 30px; mso-line-height-rule: exactly;" valign="top" align="left">&nbsp;</td>
                                                </tr>
                                                <tr>
                                                  <td class="hide" style="height: 25px; line-height: 25px; mso-line-height-rule: exactly;" valign="top" align="left">&nbsp;</td>
                                                </tr>
                                                <tr>
                                                  <td style="color: rgb(255, 255, 255); font-size: 12px; font-weight: 400; letter-spacing: 0.1em; text-align: center; text-transform: uppercase; cursor: pointer;" valign="top" align="left" class="editable_text header2"><font face="\'Open Sans\', sans-serif">WELCOME TO KINITAXI DRIVER</font>
                                                  </td>
                                                </tr>
                                                <tr>
                                                  <td style="height: 15px; line-height: 15px; mso-line-height-rule: exactly;" valign="top" align="left">&nbsp;</td>
                                                </tr>
                                                <tr>
                                                  <td style="color: rgb(255, 255, 255); font-size: 35px; font-weight: 700; letter-spacing: 0px; text-align: center; cursor: pointer;" valign="top" align="left" class="editable_text header"><font face="\'Open Sans\', sans-serif">Work on your own time, Earn what you want.</font>
                                                  </td>
                                                </tr>
                                                <tr>
                                                  <td style="height: 30px; line-height: 30px; mso-line-height-rule: exactly;" valign="top" align="left">&nbsp;</td>
                                                </tr>
                                                <tr>
                                                  <td class="hide" style="height: 5px; line-height: 5px; mso-line-height-rule: exactly;" valign="top" align="left">&nbsp;</td>
                                                </tr>
                                                <tr>
                                                  <td style="border-bottom: 1px solid #79767F; height: 1px; line-height: 1px; mso-line-height-rule: exactly;" valign="top" align="left">&nbsp;</td>
                                                </tr>
                                              </tbody></table>
                                            </td>
                                          </tr>
                                        </tbody></table>
                                        <table class="p90" style="margin: 0; mso-table-lspace: 0; mso-table-rspace: 0; padding: 0; width: 600px;" width="600" cellspacing="0" cellpadding="0" border="0" align="center">
                                          <tbody><tr>
                                            <td style="height: 40px; line-height: 40px; mso-line-height-rule: exactly;" valign="top" align="left">&nbsp;</td>
                                          </tr>
                                          <tr>
                                            <td class="text editable_text" style="color: rgb(255, 255, 255); font-size: 14px; font-weight: normal; letter-spacing: 0.02em; line-height: 23px; text-align: center; cursor: pointer;" valign="top" align="left"><font face="\'Open Sans\', sans-serif">We have received your registration and we are currently reviewing it, we will get back to you when your account is approved. <br><br>If we find anything wrong we will notify you on what you need to do next. <br><br>Once again, welcome.</font>
                                            </td>
                                          </tr>
                                          <tr>
                                            <td style="height: 40px; line-height: 40px; mso-line-height-rule: exactly;" valign="top" align="left">&nbsp;</td>
                                          </tr>
                                          <!--
                                          <tr>
                                            <td align="center" valign="top">
                                              <a href="#" class="p100" style="border: none; display: block; outline: none; text-decoration: none; cursor: pointer;">
                                                <img src="" alt="Image" class="p100" style="-ms-interpolation-mode: bicubic; border: 0; display: block; outline: 0; text-decoration: none; width: 600px;" width="600" border="0">
                                              </a>
                                            </td>
                                          </tr>
                                          -->
                                        </tbody></table>
                                      </td>
                                      <td style="width: 30px;" width="30" valign="top" align="left">&nbsp;</td>
                                    </tr>
                                  </tbody></table>
                                  <!--[if gte mso 9]>
                                       </v:textbox>
                                      </v:fill>
                                      </v:rect>
                                      <![endif]-->
                                </td>
                              </tr>
                            </tbody></table>
                          </td>
                        </tr>
                    </tbody>
                </table>
            </center>
        </body>
    </html>';
        $mail->Subject = 'Welcome to KiniTaxi Driver';
        if ($mail->send()) {
            $this->set_response('success', REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->set_response('failed', REST_Controller::HTTP_OK); // OK (200) being the HTTP response code;
        }
    }

    function upload_post()
    {
        $new_data = json_encode($this->post());
        $new_data = (array)json_decode($new_data);

        //checks if the driver already has a folder
        if (!file_exists('assets/img/driver/' . $new_data['phone']))
            mkdir('assets/img/driver/' . $new_data['phone'], 0700); //if driver dosen't have then create folder

        //convert and save file, also check if it exists first, if yes delete then put else just put
        if (!file_exists('assets/img/driver/' . $new_data['phone'] . '/' . $new_data['type'] . '.jpg'))
            $this->base64_to_jpeg($new_data['file_string'], 'assets/img/driver/' . $new_data['phone'] . '/' . $new_data['type'] . '.jpg');
        else{
            //delete file
            unlink('assets/img/driver/' . $new_data['phone'] . '/' . $new_data['type'] . '.jpg');
            //paste new one
            $this->base64_to_jpeg($new_data['file_string'], 'assets/img/driver/' . $new_data['phone'] . '/' . $new_data['type'] . '.jpg');
        }


        $file_details = [
            'url' => 'http://api.kinitaxi.com/assets/img/driver/' . $new_data['phone'] . '/' . $new_data['type'] . '.jpg',
            'status' => 'pending'
        ];

        //saves the document path for this driver in database
        if ($this->firebase->set('drivers/' . $new_data['phone'] . '/documents/' . $new_data['type'], $file_details)) {
            $this->set_response('success', REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->set_response('failed', REST_Controller::HTTP_OK); // OK (200) being the HTTP response code;
        }
    }

    function base64_to_jpeg($base64_string, $output_file)
    {
        $ifp = fopen($output_file, "wb");
        fwrite($ifp, base64_decode($base64_string));
        fclose($ifp);
        return ($output_file);
    }

    public function drivers_get()
    {
        //perform get operation of all drivers
        //todo: find a way to trim resulting array for slow networks and big data
        $drivers = json_decode($this->firebase->get('drivers', true), TRUE);
        //retrieves only one user information using passed id

        // counts all the drivers in the system
        if (isset($_GET['driver'])) {
            $this->set_response(json_decode($this->firebase->get('drivers/' . $_GET['driver'], true), TRUE), REST_Controller::HTTP_OK);
        } elseif (isset($_GET['working'])) { //get only drivers working
            $this->set_response(json_decode($this->firebase->get('driversWorking', true), TRUE), REST_Controller::HTTP_OK);
        } else {
            $this->set_response(isset($_GET['count']) ? count($drivers) : $drivers, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }
    }



    public function withdrawals_get()
    {
        $withdrawals = json_decode($this->firebase->get('withdrawalRequests', true), TRUE);

        $this->set_response(isset($_GET['count']) ? count($withdrawals) : $withdrawals, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
    }


    public function trip_history_get()
    {
        //first run data encoding and decoding
        $new_data = json_encode($this->get());
        $new_data = (array)json_decode($new_data, TRUE);

        //get all ride history for the user
        $rides = json_decode($this->firebase->get('drivers/' . $new_data['driver_id'] . '/trips', true), TRUE); //gets the position of the rider

        //trims the number of rides retrieved depending on the page_no |page_no can be 'all'
        $rides = (is_numeric($new_data['page_no'])) ? array_slice($rides, ((int)$new_data['page_no'] - 1) * 10, 10) : $rides;

        //fetch the data for every ride in $rides
        $ride_data = [];
        if (count($rides) > 0) {
            foreach ($rides as $key => $ride) {
                $temData = json_decode($this->firebase->get('rideCreated/' . $key, true), TRUE);
                $ride_data[] = [
                    'ride_id' => $key,
                    'pickup_address' => $temData['pickup_address'],
                    'destination_address' => $temData['destination_address'],
                    'total_fare' => (is_null($temData['fares']['total_fare'])) ? 0 : $temData['fares']['total_fare'],
                    'status' => $temData['status'],
                    'created_at' => $temData['created_at'],
                ];
            }
            $this->set_response($ride_data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else $this->set_response('no_ride', REST_Controller::HTTP_OK); // OK (200) being the HTTP response code

    }

    public function add_account_post(){

        //adds drivers bank details database

        $new_data = json_encode($this->post());
        $new_data = (array)json_decode($new_data);


        $headers = array(
            'Authorization' => 'Bearer '. PAYSTACK_KEY
        );
        $data = [
            'type' => 'nuban',
            'name' => $new_data['name'],
            'account_number' => $new_data['account_number'],
            'description' => 'KiniTaxi Driver',
            'bank_code' => $new_data['bank_code'],
            'currency' => 'NGN'
        ];

        $req = Requests::post('https://api.paystack.co/transferrecipient', $headers, $data);
        $response = json_decode($req->body, TRUE);

        $bankDetails = [];

        if($req->success) {

            //save recipient transfer for driver
            $bankDetails = [
                'account_hash' => $response['data']['recipient_code'],
                'account_number' => $new_data['account_number'],
                'bank_code' => $new_data['bank_code'],
                'account_name' => $new_data['name'],
                'bank_name' => $new_data['bank']
            ];

            if ($this->firebase->set('drivers/' . $new_data['phone'] . '/bank_details', $bankDetails)) {
                $this->set_response('success', REST_Controller::HTTP_OK);
            } else {
                $this->set_response('failed', REST_Controller::HTTP_OK);
            }
        }
        else
            $this->set_response('failed', REST_Controller::HTTP_OK);
    }
}
