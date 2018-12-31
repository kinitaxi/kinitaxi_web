<?php

defined('BASEPATH') OR exit('No direct script access allowed');

use Restserver\Libraries\REST_Controller;
use PHPMailer\PHPMailer\PHPMailer;

require APPPATH . '/libraries/REST_Controller.php';
require 'vendor/autoload.php';

class Rides extends REST_Controller {
    public $firebase;
    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->firebase = new \Firebase\FirebaseLib(DEFAULT_URL, DEFAULT_TOKEN); //load firebase engine
    }

    public function ride_history_get()
    {
        $rides = json_decode($this->firebase->get('rideHistory', true), TRUE);
        if (isset($_GET['user'])){
            $user_rides = [];
            foreach($rides as $key => $ride) {
                if ($ride['rider_id'] == $_GET['user']){
                    $user_rides[$key] = $ride;
                }
            }
            $this->set_response($user_rides, REST_Controller::HTTP_OK);
        }
        else{
            $this->set_response(count($rides), REST_Controller::HTTP_OK);
        }
    }

    public function ride_get()
    {
        //first run data encoding and decoding
        $new_data = json_encode($this->get());
        $new_data = (array)json_decode($new_data);

        //gets specific ride data
        $ride = json_decode($this->firebase->get('rideCreated/'.$new_data['ride_id'], true), TRUE);


        //get the driver details asociated with the ride
        $driver = json_decode($this->firebase->get('drivers/'.$ride['driver_id'], true), TRUE);

        $rideData = [
            'rating' => $ride['rating'],
            'total_fares' => (is_null($ride['fares']['total_fare']))?0:$ride['fares']['total_fare'],
            'pickup_address' => $ride['pickup_address'],
            'destination_address' => $ride['destination_address'],
            'status' => $ride['status'],
            'payment_method' => $ride['payment_method'],
            'created_at' => $ride['created_at'],
            'driver_firstname' => $driver['personal_details']['first_name'],
            'driver_lastname' => $driver['personal_details']['last_name'],
            'driver_pic' => $driver['documents']['profile_pic']['url'],
            'driver_carmodel' => $driver['vehicle_details']['model'],
            'driver_carcolor' => $driver['vehicle_details']['color'],
            'driver_caryear' => $driver['vehicle_details']['year'],
            'driver_carmake' => $driver['vehicle_details']['make'],
            'driver_platenumber' => $driver['vehicle_details']['plate_number'],
            'feedback' => (isset($ride['feedback']))?$ride['feedback']:''
        ];
        $this->set_response($rideData, REST_Controller::HTTP_OK);
    }

    public function send_receipt_post(){

        //for sending receipts for rides taken
        $new_data = json_encode($this->post());
        $new_data = (array)json_decode($new_data);

        //build smtp protocol for email
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = 'smtp.zoho.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'hello@kinitaxi.com';
        $mail->Password = 'email2017';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;
        $mail->setFrom('hello@kinitaxi.com', 'KiniTaxi');
        $mail->Timeout = 60;
        $mail->addAddress($new_data['email']);
        $mail->isHTML(true);

        //retrieve all information concerning ride with id posted
        $ride = json_decode($this->firebase->get('rideCreated/'.$new_data['ride_id']), true);

        //retrieve driver info
        $driver = json_decode($this->firebase->get('drivers/'.$ride['driver_id']), true);

        //checks if there was more than one stop and creates the html body for them
        //$second_stop = (!empty($ride['stop2']))?'<br><br><img src="http://138.197.230.230/kinitaxi/end.png" style="width:15px;"/> '.$ride['stop2']:'';
        //$third_stop = (!empty($ride['stop3']))?'<br><br><img src="http://138.197.230.230/kinitaxi/end.png" style="width:15px;"/> '.$ride['stop3']:'';
        //
        $mail->Body = '<!DOCTYPE html>
                            <html xmlns="http://www.w3.org/1999/xhtml">
    <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
    <style type="text/css">
        @media only screen and (min-device-width: 481px) {
            div[id="main"] {
                width: 480px !important;
            }
        }
    </style>
</head>

<body marginheight="0" marginwidth="0" style="-webkit-font-smoothing: antialiased; width: 100% !important; -webkit-text-size-adjust: none; margin: 0; padding: 0">
    
    <!--TEST-FORM-->
    <!--[if (mso) | (IE)]><table cellpadding="0" cellspacing="0" border="0" valign="top" width="480" align="center"><tr><td valign="top" align="left" style=" word-break:normal; border-collapse:collapse; font-family:\'Circular\', \'Helvetica Neue\', Helvetica, Arial, sans-serif; font-size:12px; line-height:18px; color:#555555;"><![endif]-->
    <table cellpadding="0" cellspacing="0" border="0" valign="top" width="100%" align="center" style="width:100%; max-width:480px; font-weight: bold;">
        <tbody><tr>
            <td valign="top" align="left" style=" word-break:normal; border-collapse:collapse; font-size:12px; line-height:18px; color:#555555; font-weight:bold;">
                <center>
                    <div id="main">
                        <table class="header-root" width="100%" cellpadding="0" cellspacing="0" style="border: none; margin: 0; border-collapse: collapse; padding: 0; width: 100%; height: 50px;">
                            <tbody valign="middle" style="border: none; margin: 0; padding: 0;">
                                <tr valign="middle" style="border: none; margin: 0; padding: 0; height: 20px;">
                                    <td colspan="3" height="20" valign="middle" style="border: none; margin: 0; padding: 0; height: 20px;"></td>
                                </tr>
                                <tr valign="middle" style="border: none; margin: 0; padding: 0;">
                                    <td width="6.25%" valign="middle" style="border: none; margin: 0; padding: 0; width: 6.25%;"></td>
                                    <td valign="middle" style="border: none; margin: 0; padding: 0;">
                                        <a href="https://www.acxi.ng/" style="border: none; align:center; margin: 0; padding: 0; text-decoration: none;" target="_blank"><img class="logo" src="http://138.197.230.230/logo.png" width="122" height="122" alt="" style="border: none; margin: 0; padding: 0; padding-left:32%; display: block; max-width: 100%; width: 122px; height: 122px;"></a>
                                    </td>
                                    <td width="6.25%" valign="middle" style="border: none; margin: 0; padding: 0; width: 6.25%;"></td>
                                </tr>
                                <tr valign="middle" style="border: none; margin: 0; padding: 0; height: 20px;">
                                    <td colspan="3" height="20" valign="middle" style="border: none; margin: 0; padding: 0; height: 20px;"></td>
                                </tr>
                            </tbody>
                        </table>
                        <table class="title-subtitle-root" width="100%" cellpadding="0" cellspacing="0" style="border: none; margin: 0; border-collapse: collapse; padding: 0; width: 100%;">
                            <tbody valign="middle" style="border: none; margin: 0; padding: 0;">
                                <tr valign="middle" style="border: none; margin: 0; padding: 0; height: 28px;">
                                    <td colspan="3" height="28" valign="middle" style="border: none; margin: 0; padding: 0; height: 28px;"></td>
                                </tr>
                                <tr valign="middle" style="border: none; margin: 0; padding: 0;">
                                    <td width="6.25%" valign="middle" style="border: none; margin: 0; padding: 0; width: 6.25%;"></td>
                                    <td valign="middle" style="border: none; margin: 0; padding: 0;">
                                        <h1 class="font title-subtitle-title" align="center" style="border: none; margin: 0; padding: 0;  text-decoration: none; color: rgb(85, 85, 85); font-size: 35px;line-height: 45px; letter-spacing: -0.04em; text-align: center;">                   
                                            Thank you for riding with us
                                        </h1>
                                    </td>
                                    <td width="6.25%" valign="middle" style="border: none; margin: 0; padding: 0; width: 6.25%;"></td>
                                </tr>
                                <tr valign="middle" style="border: none; margin: 0; padding: 0; height: 16px;">
                                    <td colspan="3" height="16" valign="middle" style="border: none; margin: 0; padding: 0; height: 16px;"></td>
                                </tr>
                            </tbody>
                        </table>
                        <table class="text-root" width="100%" cellpadding="0" cellspacing="0" style="border: none; margin: 0; border-collapse: collapse; padding: 0; width: 100%;">
                            <tbody valign="middle" style="border: none; margin: 0; padding: 0;">
                                <tr valign="middle" style="border: none; margin: 0; padding: 0;">
                                    <td class="table-separator" width="6.25%" valign="middle" style="width: 6.25%; border: none; margin: 0; padding: 0;"></td>
                                    <td valign="middle" style="border: none; margin: 0; padding: 0;">
                                        <table cellspacing="0" cellpadding="0" border="0" width="100%" style="margin: 0; padding: 0">
                                            <tbody>
                                                <tr>
                                                    <td class="font text-paragraph" align="left" style="border: none; margin: 0; padding: 0 0 5px;  font-weight: 300; text-align: left; text-decoration: none; color: rgb(97, 100, 103); font-size: 14px; line-height: 20px;">
                                                        <center style="border: none; margin: 0; padding: 0;">
                                                        Receipt ID: acxi/017/192736/'.$new_data['ride_id'].'
                                                            <center style="border: none; margin: 0; padding: 0;"></center>
                                                        </center>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                    <td class="table-separator" width="6.25%" valign="middle" style="width: 6.25%; border: none; margin: 0; padding: 0;"></td>
                                </tr>
                                <tr valign="middle" style="border: none; margin: 0; padding: 0;">
                                    <td colspan="3" class="text-padding" height="20" valign="middle" style="border: none; margin: 0; padding: 0; height: 20px;"></td>
                                </tr>
                            </tbody>
                        </table>
                        <table class="text-root" width="100%" cellpadding="0" cellspacing="0" style="border: none; margin: 0; border-collapse: collapse; padding: 0; width: 100%;">
                            <tbody valign="middle" style="border: none; margin: 0; padding: 0;">
                                <tr valign="middle" style="border: none; margin: 0; padding: 0;">
                                    <td class="table-separator" width="6.25%" valign="middle" style="width: 6.25%; border: none; margin: 0; padding: 0;"></td>
                                    <td valign="middle" style="border: none; margin: 0; padding: 0;">
                                        <table cellspacing="0" cellpadding="0" border="0" width="100%" style="margin: 0; padding: 0">
                                            <tbody>
                                                <tr>
                                                    <td class="font text-paragraph" align="left" style="border: none; margin: 0; padding: 0 0 5px;  font-weight: bold; text-align: left; text-decoration: none; color: rgb(85, 85, 85); font-size: 14px; line-height: 20px;">
                                                        <center style="border: none; margin: 0; padding: 0;">
                                                            Your trip summary
                                                            <center style="border: none; margin: 0; padding: 0;"></center>
                                                        </center>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                    <td class="table-separator" width="6.25%" valign="middle" style="width: 6.25%; border: none; margin: 0; padding: 0;"></td>
                                </tr>
                                <tr valign="middle" style="border: none; margin: 0; padding: 0;">
                                    <td colspan="3" class="text-padding" height="20" valign="middle" style="border: none; margin: 0; padding: 0; height: 20px;"></td>
                                </tr>
                            </tbody>
                        </table>
                        <table class="text-root" width="100%" cellpadding="0" cellspacing="0" style="border: none; margin: 0; border-collapse: collapse; padding: 0; width: 100%;">
                            <tbody valign="middle" style="border: none; margin: 0; padding: 0;">
                                <tr valign="middle" style="border: none; margin: 0; padding: 0;">
                                    <td class="table-separator" width="6.25%" valign="middle" style="width: 6.25%; border: none; margin: 0; padding: 0;"></td>
                                    <td valign="middle" style="border: none; margin: 0; padding: 0;">
                                        <table cellspacing="0" cellpadding="0" border="0" width="100%" style="margin: 0; padding: 0">
                                            <tbody>
                                                <tr>
                                                    <td class="font text-paragraph" align="left" style="border: none; margin: 0; padding: 0 0 5px;  font-weight: 300;
                                                                text-align: left; text-decoration: none; color: rgb(97, 100, 103); font-size: 14px; line-height: 20px;">
                                                        <table class="purchase-details" cellspacing="0" cellpadding="0" width="100%" bgcolor="#ffffff" style="margin: 0; padding: 0; background: rgb(252, 252, 252); border-collapse: collapse; width: 100%">
                                                            <tbody>
                                                                <tr>
                                                                    <td style="border-style: solid; border-width: 1px; border-color: rgb(227, 227, 227)">
                                                                        <table cellspacing="0" cellpadding="0" width="100%" style="margin: 0; padding: 0; width: 100%">
                                                                            <tbody>
                                                                                <tr class="purchase-details-padding" valign="middle" style="border: none; margin: 0; padding: 0; height: 10px;">
                                                                                    <td colspan="4" height="10" valign="middle" style="border: none; margin: 0; padding: 0; height: 10px; font-size: 10px; line-height: 10px"></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td width="5%" valign="middle" style="border: none; margin: 0; padding: 0; width: 5%;"></td>
                                                                                    <td valign="middle" style="font-weight: bold; font-family:\'Circular\', \'Helvetica Neue\', Helvetica, Arial, sans-serif;">
                                                                                    <img src="https://acxi.ng/public/assets/img/start.png" style="width:15px;"/>
                                                                                        '.$ride['pickup_address'].'<br><br><img src="https://acxi.ng/public/assets/img/end.png" style="width:15px;"/> '.$ride['destination_address'].'
                                                                                    </td>
                                                                                    <td width="5%" valign="middle" style="border: none; margin: 0; padding: 0; width: 5%;"></td>
                                                                                </tr>
                                                                                <tr class="purchase-details-padding" valign="middle" style="border: none; margin: 0; padding: 0; height: 10px;">
                                                                                    <td colspan="4" height="10" valign="middle" style="border: none; margin: 0; padding: 0; height: 10px; font-size: 10px; line-height: 10px"></td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                                
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                    <td class="table-separator" width="6.25%" valign="middle" style="width: 6.25%; border: none; margin: 0; padding: 0;"></td>
                                </tr>
                                <tr valign="middle" style="border: none; margin: 0; padding: 0;">
                                    <td colspan="3" class="text-padding" height="20" valign="middle" style="border: none; margin: 0; padding: 0; height: 20px;"></td>
                                </tr>
                            </tbody>
                        </table>
                        <table class="text-root" width="100%" cellpadding="0" cellspacing="0" style="border: none; margin: 0; border-collapse: collapse; padding: 0; width: 100%;">
                            <tbody valign="middle" style="border: none; margin: 0; padding: 0;">
                                <tr valign="middle" style="border: none; margin: 0; padding: 0;">
                                    <td class="table-separator" width="6.25%" valign="middle" style="width: 6.25%; border: none; margin: 0; padding: 0;"></td>
                                    <td valign="middle" style="border: none; margin: 0; padding: 0;">
                                        <table cellspacing="0" cellpadding="0" border="0" width="100%" style="margin: 0; padding: 0">
                                            <tbody>
                                                <tr>
                                                    <td class="font text-paragraph" align="left" style="border: none; margin: 0; padding: 0 0 5px;  font-weight: bold; text-align: left; text-decoration: none; color: rgb(85, 85, 85); font-size: 14px; line-height: 20px;">
                                                        <center style="border: none; margin: 0; padding: 0;">
                                                            Cost breakdown
                                                            <center style="border: none; margin: 0; padding: 0;"></center>
                                                        </center>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                    <td class="table-separator" width="6.25%" valign="middle" style="width: 6.25%; border: none; margin: 0; padding: 0;"></td>
                                </tr>
                                <tr valign="middle" style="border: none; margin: 0; padding: 0;">
                                    <td colspan="3" class="text-padding" height="20" valign="middle" style="border: none; margin: 0; padding: 0; height: 20px;"></td>
                                </tr>
                            </tbody>
                        </table>
                        <table class="text-root" width="100%" cellpadding="0" cellspacing="0" style="border: none; margin: 0; border-collapse: collapse; padding: 0; width: 100%;">
                            <tbody valign="middle" style="border: none; margin: 0; padding: 0;">
                                <tr valign="middle" style="border: none; margin: 0; padding: 0;">
                                    <td class="table-separator" width="6.25%" valign="middle" style="width: 6.25%; border: none; margin: 0; padding: 0;"></td>
                                    <td valign="middle" style="border: none; margin: 0; padding: 0;">
                                        <table cellspacing="0" cellpadding="0" border="0" width="100%" style="margin: 0; padding: 0">
                                            <tbody>
                                                <tr>
                                                    <td class="font text-paragraph" align="left" style="border: none; margin: 0; padding: 0 0 5px;  font-weight: 300;
                                                                text-align: left; text-decoration: none; color: rgb(97, 100, 103); font-size: 14px; line-height: 20px;">
                                                        <table class="purchase-details" cellspacing="0" cellpadding="0" width="100%" bgcolor="#F7F7F7" style="margin: 0; padding: 0; background: rgb(252, 252, 252); border-collapse: collapse; width: 100%">
                                                            <tbody>
                                                                <tr>
                                                                    <td style="border-style: solid; border-width: 1px; border-color: rgb(227, 227, 227)">
                                                                        <table cellspacing="0" cellpadding="0" width="100%" style="margin: 0; padding: 0; width: 100%">
                                                                            <tbody>
                                                                                <tr class="purchase-details-padding" valign="middle" style="border: none; margin: 0; padding: 0; height: 10px;">
                                                                                    <td colspan="4" height="10" valign="middle" style="border: none; margin: 0; padding: 0; height: 10px; font-size: 10px; line-height: 10px"></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td width="5%" valign="middle" style="border: none; margin: 0; padding: 0; width: 5%;"></td>
                                                                                    <td valign="middle" style="font-weight: bold; font-family:\'Circular\', \'Helvetica Neue\', Helvetica, Arial, sans-serif;">
                                                                                        Base fare
                                                                                    </td>
                                                                                    <td width="20%" valign="middle" style="text-align: right; width: 20%; vertical-align: top; font-family:\'Circular\', \'Helvetica Neue\', Helvetica, Arial, sans-serif;">
                                                                                        ₦ ' . number_format($ride['fares']['base_fare']) . '
                                                                                    </td>
                                                                                    <td width="5%" valign="middle" style="border: none; margin: 0; padding: 0; width: 5%;"></td>
                                                                                </tr>
                                                                                <tr class="purchase-details-padding" valign="middle" style="border: none; margin: 0; padding: 0; height: 10px;">
                                                                                    <td colspan="4" height="10" valign="middle" style="border: none; margin: 0; padding: 0; height: 10px; font-size: 10px; line-height: 10px"></td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="border-style: solid; border-width: 1px; border-color: rgb(227, 227, 227)">
                                                                        <table cellspacing="0" cellpadding="0" width="100%" style="margin: 0; padding: 0; width: 100%">
                                                                            <tbody>
                                                                                <tr class="purchase-details-padding" valign="middle" style="border: none; margin: 0; padding: 0; height: 10px;">
                                                                                    <td colspan="4" height="10" valign="middle" style="border: none; margin: 0; padding: 0; height: 10px; font-size: 10px; line-height: 10px"></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td width="5%" valign="middle" style="border: none; margin: 0; padding: 0; width: 5%;"></td>
                                                                                    <td valign="middle" style="font-weight: bold; font-family:\'Circular\', \'Helvetica Neue\', Helvetica, Arial, sans-serif;">
                                                                                        Distance fare
                                                                                    </td>
                                                                                    <td width="20%" valign="middle" style="text-align: right; width: 20%; vertical-align: top; font-family:\'Circular\', \'Helvetica Neue\', Helvetica, Arial, sans-serif;">
                                                                                        ₦'.number_format($ride['fares']['distance_fare']).'
                                                                                    </td>
                                                                                    <td width="5%" valign="middle" style="border: none; margin: 0; padding: 0; width: 5%;"></td>
                                                                                </tr>
                                                                                <tr class="purchase-details-padding" valign="middle" style="border: none; margin: 0; padding: 0; height: 10px;">
                                                                                    <td colspan="4" height="10" valign="middle" style="border: none; margin: 0; padding: 0; height: 10px; font-size: 10px; line-height: 10px"></td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="border-style: solid; border-width: 1px; border-color: rgb(227, 227, 227)">
                                                                        <table cellspacing="0" cellpadding="0" width="100%" style="margin: 0; padding: 0; width: 100%">
                                                                            <tbody>
                                                                                <tr class="purchase-details-padding" valign="middle" style="border: none; margin: 0; padding: 0; height: 10px;">
                                                                                    <td colspan="4" height="10" valign="middle" style="border: none; margin: 0; padding: 0; height: 10px; font-size: 10px; line-height: 10px"></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td width="5%" valign="middle" style="border: none; margin: 0; padding: 0; width: 5%;"></td>
                                                                                    <td valign="middle" style="font-weight: bold; font-family:\'Circular\', \'Helvetica Neue\', Helvetica, Arial, sans-serif;">
                                                                                        Time fare
                                                                                    </td>
                                                                                    <td width="20%" valign="middle" style="text-align: right; width: 20%; vertical-align: top; font-family:\'Circular\', \'Helvetica Neue\', Helvetica, Arial, sans-serif;">
                                                                                        ₦'.number_format($ride['fares']['time_fare']).'
                                                                                    </td>
                                                                                    <td width="5%" valign="middle" style="border: none; margin: 0; padding: 0; width: 5%;"></td>
                                                                                </tr>
                                                                                <tr class="purchase-details-padding" valign="middle" style="border: none; margin: 0; padding: 0; height: 10px;">
                                                                                    <td colspan="4" height="10" valign="middle" style="border: none; margin: 0; padding: 0; height: 10px; font-size: 10px; line-height: 10px"></td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="border-style: solid; border-width: 1px; border-color: rgb(227, 227, 227)">
                                                                        <table cellspacing="0" cellpadding="0" width="100%" style="margin: 0; padding: 0; width: 100%">
                                                                            <tbody>
                                                                                <tr class="purchase-details-padding" valign="middle" style="border: none; margin: 0; padding: 0; height: 10px;">
                                                                                    <td colspan="4" height="10" valign="middle" style="border: none; margin: 0; padding: 0; height: 10px; font-size: 10px; line-height: 10px"></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td width="5%" valign="middle" style="border: none; margin: 0; padding: 0; width: 5%;"></td>
                                                                                    <td valign="middle" style="font-weight: bold; font-family:\'Circular\', \'Helvetica Neue\', Helvetica, Arial, sans-serif;">
                                                                                        Stop fare
                                                                                    </td>
                                                                                    <td width="20%" valign="middle" style="text-align: right; width: 20%; vertical-align: top; font-family:\'Circular\', \'Helvetica Neue\', Helvetica, Arial, sans-serif;">
                                                                                        ₦'.number_format($ride['fares']['stop_fare']).'
                                                                                    </td>
                                                                                    <td width="5%" valign="middle" style="border: none; margin: 0; padding: 0; width: 5%;"></td>
                                                                                </tr>
                                                                                <tr class="purchase-details-padding" valign="middle" style="border: none; margin: 0; padding: 0; height: 10px;">
                                                                                    <td colspan="4" height="10" valign="middle" style="border: none; margin: 0; padding: 0; height: 10px; font-size: 10px; line-height: 10px"></td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="border-style: solid; border-width: 1px; border-color: rgb(227, 227, 227)">
                                                                        <table cellspacing="0" cellpadding="0" width="100%" style="margin: 0; padding: 0; width: 100%">
                                                                            <tbody>
                                                                                <tr class="purchase-details-padding" valign="middle" style="border: none; margin: 0; padding: 0; height: 10px;">
                                                                                    <td colspan="4" height="10" valign="middle" style="border: none; margin: 0; padding: 0; height: 10px; font-size: 10px; line-height: 10px"></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td width="5%" valign="middle" style="border: none; margin: 0; padding: 0; width: 5%;"></td>
                                                                                    <td valign="middle" style="font-weight: bold; font-family:\'Circular\', \'Helvetica Neue\', Helvetica, Arial, sans-serif;">
                                                                                        Total
                                                                                    </td>
                                                                                    <td width="20%" valign="middle" style="text-align: right; width: 20%; vertical-align: top; font-family:\'Circular\', \'Helvetica Neue\', Helvetica, Arial, sans-serif;">
                                                                                        ₦'.number_format($ride['fares']['total_fare']).'
                                                                                    </td>
                                                                                    <td width="5%" valign="middle" style="border: none; margin: 0; padding: 0; width: 5%;"></td>
                                                                                </tr>
                                                                                <tr class="purchase-details-padding" valign="middle" style="border: none; margin: 0; padding: 0; height: 10px;">
                                                                                    <td colspan="4" height="10" valign="middle" style="border: none; margin: 0; padding: 0; height: 10px; font-size: 10px; line-height: 10px"></td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                    <td class="table-separator" width="6.25%" valign="middle" style="width: 6.25%; border: none; margin: 0; padding: 0;"></td>
                                </tr>
                                <tr valign="middle" style="border: none; margin: 0; padding: 0;">
                                    <td colspan="3" class="text-padding" height="20" valign="middle" style="border: none; margin: 0; padding: 0; height: 20px;"></td>
                                </tr>
                            </tbody>
                        </table>
                        
                        <table class="text-root" width="100%" cellpadding="0" cellspacing="0" style="border: none; margin: 0; border-collapse: collapse; padding: 0; width: 100%;">
                            <tbody valign="middle" style="border: none; margin: 0; padding: 0;">
                                <tr valign="middle" style="border: none; margin: 0; padding: 0;">
                                    <td class="table-separator" width="6.25%" valign="middle" style="width: 6.25%; border: none; margin: 0; padding: 0;"></td>
                                    <td valign="middle" style="border: none; margin: 0; padding: 0;">
                                        <table cellspacing="0" cellpadding="0" border="0" width="100%" style="margin: 0; padding: 0px">
                                            <tbody>
                                                <tr>
                                                    <td class="font text-paragraph" align="left" style="border: none; margin: 0; padding: 0px 0px 5px;  font-weight: 300; text-align: left; text-decoration: none; color: rgb(97, 100, 103); font-size: 14px; line-height: 20px;">
                                                        <center style="border: none; margin: 0; padding: 0;"><b align="left" style="border: none; margin: 0; padding: 0; font-family: Circular, &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; text-align: left; text-decoration: none; font-weight: bold;">
                                                            Payment Method
                                                            </b>
                                                        </center>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <table cellspacing="0" cellpadding="0" border="0" width="100%" style="margin: 0; padding: 0px">
                                            <tbody>
                                                <tr>
                                                    <td class="font text-paragraph" align="left" style="border: none; margin: 0; padding: 0px 0px 5px;  font-weight: 300; text-align: left; text-decoration: none; color: rgb(97, 100, 103); font-size: 14px; line-height: 20px;">
                                                        <center style="border: none; margin: 0; padding: 0;">
                                                            '.$ride['payment_method'].'
                                                        </center> 
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                    <td class="table-separator" width="6.25%" valign="middle" style="width: 6.25%; border: none; margin: 0; padding: 0;"></td>
                                </tr>
                                <tr valign="middle" style="border: none; margin: 0; padding: 0;">
                                    <td colspan="3" class="text-padding" height="20" valign="middle" style="border: none; margin: 0; padding: 0; height: 20px;"></td>
                                </tr>
                            </tbody>
                        </table>
                        <table class="text-root" width="100%" cellpadding="0" cellspacing="0" style="border: none; margin: 0; border-collapse: collapse; padding: 0; width: 100%;">
                            <tbody valign="middle" style="border: none; margin: 0; padding: 0;">
                                <tr valign="middle" style="border: none; margin: 0; padding: 0;">
                                    <td class="table-separator" width="6.25%" valign="middle" style="width: 6.25%; border: none; margin: 0; padding: 0;"></td>
                                    <td valign="middle" style="border: none; margin: 0; padding: 0;">
                                            <table cellspacing="0" cellpadding="0" border="0" width="100%" style="margin: 0; padding: 0px">
                                                <tbody>
                                                    <tr>
                                                        <td class="font text-paragraph" align="left" style="border: none; margin: 0; padding: 0px 0px 5px;  font-weight: bold; text-align: left; text-decoration: none; color: rgb(97, 100, 103); font-size: 14px; line-height: 20px;">
                                                            <center style="border: none; margin: 0; padding: 0;"><b align="left" style="border: none; margin: 0; padding: 0; font-family: Circular, &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; text-align: left; text-decoration: none; font-weight: bold;">
                                                                Your Driver was
                                                                </b>
                                                            </center>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <table cellspacing="0" cellpadding="0" border="0" width="100%" style="margin: 0; padding: 0">
                                                <tbody>
                                                    <tr>
                                                        <td class="font text-paragraph" align="left" style="border: none; margin: 0; padding: 0 0 5px;  font-weight: 300; text-align: left; text-decoration: none; color: rgb(97, 100, 103); font-size: 14px; line-height: 20px;">
                                                            <center style="border: none; margin: 0; padding: 0;">'.$driver['personal_details']['first_name'].' '.$driver['personal_details']['last_name'].' - '. $ride['driver_id'].'</center>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                    </td>
                                    <td class="table-separator" width="6.25%" valign="middle" style="width: 6.25%; border: none; margin: 0; padding: 0;"></td>
                                </tr>
                                <tr valign="middle" style="border: none; margin: 0; padding: 0;">
                                    <td colspan="3" class="text-padding" height="20" valign="middle" style="border: none; margin: 0; padding: 0; height: 20px;"></td>
                                </tr>
                            </tbody>
                        </table>
                        <table class="text-root" width="100%" cellpadding="0" cellspacing="0" style="border: none; margin: 0; border-collapse: collapse; padding: 0; width: 100%;">
                            <tbody valign="middle" style="border: none; margin: 0; padding: 0;">
                                <tr valign="middle" style="border: none; margin: 0; padding: 0;">
                                    <td class="table-separator" width="6.25%" valign="middle" style="width: 6.25%; border: none; margin: 0; padding: 0;"></td>
                                    <td valign="middle" style="border: none; margin: 0; padding: 0;">
                                        <table cellspacing="0" cellpadding="0" border="0" width="100%" style="margin: 0; padding: 0px">
                                            <tbody>
                                                <tr>
                                                    <td class="font text-paragraph" align="left" style="border: none; margin: 0; padding: 0px 0px 5px;  font-weight: 300; text-align: left; text-decoration: none; color: rgb(97, 100, 103); font-size: 14px; line-height: 20px;">
                                                        <center style="border: none; margin: 0; padding: 0;">
                                                            <font size="-1" style="border: none; margin: 0; padding: 0;">
    
  
  You do not need to take any further action, we have already charged you for the above sum. 

    &nbsp; 
  
  If you did not initiate this ride, kindly send a mail to complaints@acxi.ng, or by filling out a <a href="https://www.acxi.ng/#complaints" target="_blank">complaint form</a>.

                                                            </font>
                                                        </center>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                    <td class="table-separator" width="6.25%" valign="middle" style="width: 6.25%; border: none; margin: 0; padding: 0;"></td>
                                </tr>
                                <tr valign="middle" style="border: none; margin: 0; padding: 0;">
                                    <td colspan="3" class="text-padding" height="20" valign="middle" style="border: none; margin: 0; padding: 0; height: 20px;"></td>
                                </tr>
                            </tbody>
                        </table>
                        <table class="text-root" width="100%" cellpadding="0" cellspacing="0" style="border: none; margin: 0; border-collapse: collapse; padding: 0; width: 100%;">
                            <tbody valign="middle" style="border: none; margin: 0; padding: 0;">
                            <tr valign="middle" style="border: none; margin: 0; padding: 0;">
                                <td class="table-separator" width="6.25%" valign="middle" style="width: 6.25%; border: none; margin: 0; padding: 0;"></td>
                                <td valign="middle" style="border: none; margin: 0; padding: 0;">
                                    <table cellspacing="0" cellpadding="0" border="0" width="100%" style="margin: 0; padding: 0px">
                                        <tbody>
                                        <tr>
                                            <td class="font text-paragraph" align="left" style="border: none; margin: 0; padding: 0px 0px 5px;  font-weight: 300; text-align: left; text-decoration: none; color: rgb(97, 100, 103); font-size: 14px; line-height: 20px;">
                                                <center style="border: none; margin: 0; padding: 0;">
                                                    <font size="-1" style="border: none; margin: 0; padding: 0;">
This mail was sent to you automatically from <a href="https://acxi.ng" target="_blank">Acxi</a>.
                                                    </font>
                                                </center>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </td>
                                <td class="table-separator" width="6.25%" valign="middle" style="width: 6.25%; border: none; margin: 0; padding: 0;"></td>
                            </tr>
                            <tr valign="middle" style="border: none; margin: 0; padding: 0;">
                                <td colspan="3" class="text-padding" height="20" valign="middle" style="border: none; margin: 0; padding: 0; height: 20px;"></td>
                            </tr>
                            </tbody>
                        </table>
                        </div>
                </center>
            </td>
        </tr>
    </tbody></table>

</body>
    </html>';

        $mail->Subject = 'Summary of Your Ride';

        if ($mail->send()) {
            $this->set_response('success', REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->set_response('failed', REST_Controller::HTTP_OK); // OK (200) being the HTTP response code;
        }
    }

    public function assign_driver_get()
    {
        //first run data encoding and decoding
        $new_data = json_encode($this->get());
        $new_data = (array)json_decode($new_data);
        //get all available drivers and calculate their closeness to the rider
        $riderPos = json_decode($this->firebase->get('rideRequest/'.$new_data['ride_id'].'/location', true), TRUE); //gets the position of the rider
        $availableDrivers = json_decode($this->firebase->get('driversAvailable', true), TRUE);

        //get the limit for the radius to apply
        $driver_radius_limit = $this->firebase->get('appSettings/driver_radius_limit', true);
        $proximityTable = [];

        //todo: Optimize comparison for all at once
        foreach ($availableDrivers as $key => $availableDriver){ //calculate the closeness of all drivers
            //create table of proximity

            //make sure all retrieved distance falls within accepted radius as set by admin
            $distBetween = $this->distanceBetween($riderPos['latitude'], $riderPos['longitude'],
                $availableDriver['location']['latitude'], $availableDriver['location']['longitude']);

            if ($distBetween <= $driver_radius_limit) {
                $proximityTable[$key] = $distBetween;
            }
        }
        asort($proximityTable); //sorts according to the shortest distance

        if (count($proximityTable) !== 0) { //checks if there is a driver in the table
            if ($this->firebase->update('driversAvailable/' . array_keys($proximityTable)[0], ['ride_id' => $new_data['ride_id']])) {
                $this->set_response('success', REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            } else {
                $this->set_response('failed', REST_Controller::HTTP_NOT_IMPLEMENTED);
            }
        }
        else {
            $this->set_response('no_driver', REST_Controller::HTTP_OK);
        }
    }

    public function find_driver_post()
    { //this one returns the driver phone number found

        //first run data encoding and decoding
        $new_data = json_encode($this->post());
        $new_data = (array)json_decode($new_data, TRUE);

        //get all available drivers and calculate their closeness to the rider
        $riderPos = json_decode($this->firebase->get('rideRequest/'.$new_data['ride_id'].'/location', true), TRUE); //gets the position of the rider
        $availableDrivers = json_decode($this->firebase->get('driversAvailable', true), TRUE);

        //get the limit for the radius to apply
        $driver_radius_limit = str_replace('"','',$this->firebase->get('appSettings/driver_radius_limit', true)) + 0;
        $proximityTable = [];

        //todo: Optimize comparison for all at once
        foreach ($availableDrivers as $key => $availableDriver){ //calculate the closeness of all drivers
            //create table of proximity

            //make sure all retrieved distance falls within accepted radius as set by admin
            $distBetween = $this->distanceBetween($riderPos['latitude'], $riderPos['longitude'],
                $availableDriver['location']['latitude'], $availableDriver['location']['longitude']);

            if ($distBetween <= $driver_radius_limit && $availableDriver['ride_id'] == 'waiting') {
                $proximityTable[$key] = $distBetween;
            }
        }

        //sorts the drivers array according to the shortest distance
        asort($proximityTable);

        //retrieve only the phone numbers
        $proximityTable = array_keys($proximityTable);

        //removes drivers that have declined the request before
        $proximityTable = (!empty($new_data['declined']))?array_diff($proximityTable, $new_data['declined']):$proximityTable; //remove rejected drivers from the list

        //checks if there is a driver in the table and returns it else returns no_drivers
        $this->set_response((count($proximityTable))?$proximityTable[0]:'no_driver', REST_Controller::HTTP_OK);
    }

    function distanceBetween($lat1, $lng1, $lat2, $lng2, $miles = false)
    {
        $pi80 = M_PI / 180;
        $lat1 *= $pi80;
        $lng1 *= $pi80;
        $lat2 *= $pi80;
        $lng2 *= $pi80;

        $r = 6372.797; // mean radius of Earth in km
        $dlat = $lat2 - $lat1;
        $dlng = $lng2 - $lng1;
        $a = sin($dlat / 2) * sin($dlat / 2) + cos($lat1) * cos($lat2) * sin($dlng / 2) * sin($dlng / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        $km = $r * $c;

        return ($miles ? ($km * 0.621371192) : $km);
    }

    public function direction_post(){

        //first run data encoding and decoding
        $new_data = json_encode($this->post());
        $new_data = (array)json_decode($new_data, TRUE);

        $url = $new_data['url'];
        $data = array();
        $options = array( //build http header variables
            'http' => array(
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'GET',
                'content' => http_build_query($data)
            )
        );
        $context  = stream_context_create($options);
        $result = file_get_contents($url, false, $context);

        if ($result === FALSE) {
            $this->set_response('failed', REST_Controller::HTTP_NOT_IMPLEMENTED); // return failed;
        }
        else $this->set_response(json_decode($result, TRUE), REST_Controller::HTTP_OK); // return the otp if successful;
    }

}
