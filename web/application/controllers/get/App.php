<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PHPMailer\PHPMailer\PHPMailer;

require 'application/vendor/simple_html_dom.php';

class App extends MY_Controller {

    public $firebase;

    function __construct()
    {
        // Construct the parent class
        parent::__construct();

        if (empty($this->session->userdata('user'))){
            $this->redirect('signin', ['warning', 'You are not logged in, please login to continue']);
        }
        else
            $this->firebase = new \Firebase\FirebaseLib(DEFAULT_URL, DEFAULT_TOKEN); //load firebase engine
    }

    public function index()
    {
        echo $this->blade->render("app/index", ['page' => 'Dashboard']);
        $this->clear_session(FALSE);
    }


    public function dashboard()
    {
        //get normal users count
        $users = json_decode($this->firebase->get(DEFAULT_PATH, true), TRUE);
        $users_count = count($users);

        //get drivers count
        $drivers = json_decode($this->firebase->get('drivers', true), TRUE);
        $drivers_count = count($drivers);

        //get rides count
        $rides = json_decode($this->firebase->get('rideCreated', true), TRUE);
        $rides_count = count($rides);

        //get money spent total
        $total_spent = 0;

        //pie chart defaults
        $completed = 0;
        $cancelled = 0;


        foreach ($rides as $key => $ride) {

            //sum up rides money spent by all
            $total_spent += (isset($ride['fares']))?$ride['fares']['total_fare']:0;

            if (isset($ride['status']))
                //pie chart data
                if ($ride['status'] == 'ended'){

                    $completed += 1;
                }
                elseif ($ride['status'] == 'cancelled_d' || $ride['status'] == 'cancelled_p'){

                    $cancelled += 1;
                }
        }

        //compute pie chart data
        //for computing the percents
        $tot = $completed + $cancelled;

        $cancelledRatio = round(($cancelled/$tot) * 100);
        $completedRatio = 100 - $cancelledRatio;

        //compute data for growth rate
        $growthData_u = [0,0,0,0,0,0,0,0];
        $growthData_d = [0,0,0,0,0,0,0,0];

        //groups data based on 7 days ago

        //run for 7 days of the week
        for ($i = 0; $i<8; $i++){

            //group users
            foreach($users as $user){

                $nDaysAgo = date('Y-m-d', strtotime(date('Y-m-d') . ' - '.$i.' days'));
                $joined = date('Y-m-d', $user['created_at']);

                //compare when person joined to n days ago
                if ($nDaysAgo == $joined){

                    //add data for that day
                    $growthData_u[$i] += 1;
                }
            }

            //group drivers
            foreach($drivers as $driver){

            	if (isset($driver['personal_details'])){

					$nDaysAgo = date('Y-m-d', strtotime(date('Y-m-d') . ' - '.$i.' days'));
					$joined = date('Y-m-d', $driver['personal_details']['created_at']);

					//compare when person joined to n days ago
					if ($nDaysAgo == $joined){

						//add data for that day
						$growthData_d[$i] += 1;
					}
				}
            }
        }

        unset($growthData_u[7]);
        unset($growthData_d[7]);

        $data = [
            'page' => 'dashboard',
            'users_count' => $users_count,
            'drivers_count' => $drivers_count,
            'rides_count' => $rides_count,
            'total_spent' => $total_spent,
            'completedRatio' => $completedRatio,
            'cancelledRatio' => $cancelledRatio,
            'growthData_u' => json_encode(array_reverse($growthData_u)),
            'growthData_d' => json_encode(array_reverse($growthData_d))
        ];

        echo $this->blade->render("app/dashboard", $data);
        $this->clear_session(FALSE);
    }



    public function users()
    {
        //load users
        $users = json_decode($this->firebase->get(DEFAULT_PATH, true), TRUE);

        $data = [
            'page' => 'users',
            'users' => (count($users) > 0)?$users:[]
        ];
        echo $this->blade->render("app/users", $data);
        $this->clear_session(FALSE);
    }

    public function drivers()
    {
        //load all drivers
        $drivers = json_decode($this->firebase->get('drivers', true), TRUE);

        //load all drivers that are online
        $driversOnline = json_decode($this->firebase->get('driversAvailable', true), TRUE);

        //gets all online drivers
        foreach($drivers as $key => $driver){

            //checks if driver is online and append special key
            $drivers[$key]['online'] = (in_array($key, array_keys($driversOnline)) && $driversOnline[$key]['ride_id'] == 'waiting')?'online':'offline';
        }

        //for getting all other types
        if ($_GET['retrieve'] !== 'all'){

            //checks if it's for online drivers or another type
            if ($_GET['retrieve'] == 'online'){

                $onlineDrivers = [];

                foreach($drivers as $key => $driver){

                    //checks the status of driver
                    if ($driver['online'] == 'online')
                        $onlineDrivers[$key] = $driver;
                }

                $drivers = $onlineDrivers;
            }
            else{

                $unapprovedDrivers = [];

                //filters only unapproved drivers
                foreach($drivers as $key => $driver){

                    //checks the status of driver
                    if (isset($driver['account_status']))
                        if ($driver['account_status'] == $_GET['retrieve'])
                            $unapprovedDrivers[$key] = $driver;
                }

                $drivers = $unapprovedDrivers;
            }
        }

        $data = [
            'page' => 'drivers',
            'drivers' => (count($drivers) > 0)?$drivers:[],
            'filter' => $_GET['retrieve']
        ];

        echo $this->blade->render("app/drivers", $data);
        $this->clear_session(FALSE);
    }

    public function user_profile()
    {

        //id is passed from view

        $user = json_decode($this->firebase->get(DEFAULT_PATH . '/' . $_GET['id'], true), TRUE);

        //gets all rides by user
        $ride_ids = isset($user['rides'])?array_keys($user['rides']):NULL;

        //retrieves the ride data for all rides taken by user
        $rides = [];
        $total_spent = 0;

        //put all the information for all trips inside one enclosing array
        if ($ride_ids !== NULL){
            foreach ($ride_ids as $ride_id) {
                $rides[$ride_id] = json_decode($this->firebase->get('rideCreated/'.$ride_id, true), TRUE);
                $rides[$ride_id]['driver'] = (isset($rides[$ride_id]['driver_id']))?json_decode($this->firebase->get('drivers/'.$rides[$ride_id]['driver_id'], true), TRUE):[];

                //sums up total spent by user
                $total_spent += (isset($rides[$ride_id]['fares']))?$rides[$ride_id]['fares']['total_fare']:0;
            }
        }

        //get user card information
        if (isset($user['cards'])){

            foreach ($user['cards'] as $key => $card){

                if ($key !== 'preferred_card' ){

                    //decrypt and arrange for view
                    $cardData = json_decode($this->decrypt($card), TRUE);

                    $user['cardData'][] = $cardData;

                }

            }
        }

        $data = [
            'page' => 'user profile',
            'user' => $user,
            'rides' => $rides,
            'total_spent' => $total_spent,
            'phone' => $_GET['id']
        ];

        echo $this->blade->render("app/user_profile", $data);
        $this->clear_session(FALSE);
    }

    public function driver_profile()
    {
        //id is passed from view
        $driver = json_decode($this->firebase->get('drivers/' . $_GET['id'], true), TRUE);

        //gets the id of all his trips
        $trip_ids = isset($driver['trips'])?array_keys($driver['trips']):NULL;


        //set defaults
        $total_earned = 0;
        $trips = [];

        //put all the information for all trips inside one enclosing array
        if ($trip_ids !== NULL){
            foreach ($trip_ids as $trip_id) {
                $trips[$trip_id] = json_decode($this->firebase->get('rideCreated/'.$trip_id, true), TRUE);

                $trips[$trip_id]['user'] = (isset($trips[$trip_id]['rider_id']))?json_decode($this->firebase->get(DEFAULT_PATH.'/'.$trips[$trip_id]['rider_id'], true), TRUE):[];

                //sums up total earned by driver
                $total_earned += (isset($trips[$trip_id]['fares']))?$trips[$trip_id]['fares']['total_fare']:0;
            }
        }

        //get a sample of image of the car the driver uses from google images
        /*$search_keyword=str_replace(' ','+',$driver['vehicle_details']['model'].'+'.$driver['vehicle_details']['color']);
        $newhtml = file_get_html("https://www.google.com/search?q=".$search_keyword."&tbm=isch");

        $result_image_source = '';
        for ($i = 0;$i<3;$i++)
            $result_image_source[] = $newhtml->find('img', $i)->src;*/

        $data = [
            'page' => 'driver profile',
            'driver' => $driver,
            'trips' => $trips,
            'total_earned' => $total_earned,
            //'car_sample' => $result_image_source,
            'phone' => $_GET['id']
        ];

        //render view
        echo $this->blade->render("app/driver_profile", $data);
        $this->clear_session(FALSE);
    }

    public function withdrawals(){

        $withdrawals = json_decode($this->firebase->get('withdrawalRequests', true), TRUE); //gets all withdrawal requests pending

        $unprocessed = [];
        foreach($withdrawals as $key => $withdrawal){

            //checks to filter only unprocessed withdrawals
            if (!isset($withdrawal['processed_at'])){

                $unprocessed[$key] = $withdrawal;
            }
        }

        $data = [
            'page' => 'withdrawal requests',
            'withdrawals' => $unprocessed
        ];
        echo $this->blade->render("app/withdrawals", $data);
        $this->clear_session(FALSE);
    }

    public function support(){

        $tickets = json_decode($this->firebase->get('userSupport', true), TRUE); //gets all tickets requests pending

        if ($_GET['retrieve'] !== 'all'){

            $openTickets = [];

            //filters only specific tickets
            if (count($tickets) > 0)
                foreach($tickets as $key => $ticket){

                //checks the status of driver
                if ($ticket['status'] == $_GET['retrieve'])
                    $openTickets[$key] = $ticket;
            }

            $tickets = $openTickets;
        }

        $data = [
            'page' => 'support',
            'tickets' => (count($tickets) > 0)?$tickets:[]
        ];
        echo $this->blade->render("app/support", $data);
        $this->clear_session(FALSE);
    }

    public function rides(){

        //load all drivers
        $rides = json_decode($this->firebase->get('rideCreated', true), TRUE);

        //sorts array by created_at
        foreach ($rides as $key => $node) {

                $timestamps[$key] = (isset($node['created_at']))?$node['created_at']:0;
        }

        array_multisort($timestamps, SORT_DESC, $rides);

        if ($_GET['retrieve'] !== 'all'){

            $cancelledRides = [];

            //filters only cancelled rides
            foreach($rides as $key => $ride){

                if ($_GET['retrieve'] == 'cancelled'){

                    if ($ride['status'] == 'cancelled_d' || $ride['status'] == 'cancelled_p')
                        $cancelledRides[$key] = $ride;
                }
                else
                    if ($ride['status'] == $_GET['retrieve'])
                        $cancelledRides[$key] = $ride;

            }

            $rides = $cancelledRides;
        }

        $data = [
            'page' => 'rides',
            'rides' => (count($rides) > 0)?$rides:[],
            'filter' => $_GET['retrieve']
        ];

        echo $this->blade->render("app/rides", $data);
        $this->clear_session(FALSE);
    }

    public function ride_details()
    {

        //id is passed from view

        $ride = json_decode($this->firebase->get('rideCreated' . '/' . $_GET['id'], true), TRUE);

        $driver = (isset($ride['driver_id']))?json_decode($this->firebase->get('drivers/'.$ride['driver_id'], true), TRUE):[];
        $rider = (isset($ride['rider_id']))?json_decode($this->firebase->get('users/'.$ride['rider_id'], true), TRUE):[];

        $data = [
            'page' => 'ride details',
            'rider' => $rider,
            'ride' => $ride,
            'id' => $_GET['id'],
            'driver' => $driver
        ];

        echo $this->blade->render("app/ride_details", $data);
        $this->clear_session(FALSE);
    }

    public function payments(){

        //get negative wallets payments
        $users = json_decode($this->firebase->get(DEFAULT_PATH, true), TRUE);
        $driverEarnings = json_decode($this->firebase->get('driverEarnings', true), TRUE);

        $owers = [];

        //gets if users selected or all selected
        if ($_GET['retrieve'] == 'all' || $_GET['retrieve'] == 'users'){

            //get owers from users
            foreach ($users as $key => $user){

                //check if they are owing
                if(isset($user['wallet']))
                    if(isset($user['wallet']['ride_wallet']))
                        if($user['wallet']['ride_wallet'] < 0){

                            //add user to owing array
                            $owers[$key.'u'] = $user;
                            $owers[$key.'u']['type'] = 'user';
                            $owers[$key.'u']['amount'] = $user['wallet']['ride_wallet'];
                        }

            }

        }

        //gets if drivers selected or all selected
        if ($_GET['retrieve'] == 'all' || $_GET['retrieve'] == 'drivers'){

            //get owers from drivers
            foreach ($driverEarnings as $key => $earning){

                //check if they are owing
                if(isset($earning['earning_unpaid']))
                    if($earning['earning_unpaid'] < 0){

                        //go get driver info
                        $owers[$key.'d'] = json_decode($this->firebase->get('drivers/'.$key, true), TRUE);
                        $owers[$key.'d']['type'] = 'driver';
                        $owers[$key.'d']['amount'] = $earning['earning_unpaid'];
                    }

            }

        }


        $data = [
            'page' => 'payments',
            'owers' => $owers,
            'filter' => $_GET['retrieve']
        ];

        echo $this->blade->render("app/payments", $data);
    }

    public function app_settings(){

        //for loading global parameters for app

        $setting = json_decode($this->firebase->get('appSettings', true), TRUE);

        //send sms to driver
        $url = 'http://api.smartsmssolutions.com/smsapi.php?username=dechosenuchenna&password=yucee.dll&balance=true';
        $data = array();

        //build http header variables
        $options = array(
            'http' => array(
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($data)
            )
        );
        $context  = stream_context_create($options);
        $smsBal = file_get_contents($url, false, $context);

        $data = [
            'page' => 'app settings',
            'smsbal' => $smsBal,
            'setting' => $setting
        ];

        echo $this->blade->render("app/app_settings", $data);
        $this->clear_session(FALSE);

    }


    /////////////////////////////////////////////////////////////////
    function reject_message($email,$type,$phone){

        //replace any underscore in type for profile_pic
        $type = str_replace('_','+',$type);
        $type = str_replace('pic','picture',$type);

        //send sms to driver
        $url = 'http://api.smartsmssolutions.com/smsapi.php?username=dechosenuchenna&password=yucee.dll&sender=KiniTaxi&recipient=@@'.$phone.'@@&message=Your+'.$type.'+was+rejected.+Kindly+upload+another+from+the+app.&';
        $data = array();

        //build http header variables
        $options = array(
            'http' => array(
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($data)
            )
        );
        $context  = stream_context_create($options);
        file_get_contents($url, false, $context);

        //send email
        $type = str_replace('+',' ',$type);
        //build smtp protocol for email
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = 'smtp.zoho.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'compliance@kinitaxi.com';
        $mail->Password = 'email2018';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;
        $mail->setFrom('compliance@kinitaxi.com', 'KiniTaxi');
        $mail->Timeout = 60;
        $mail->addAddress($email);
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
<body width="100%" bgcolor="#222222" style="margin: 0; mso-line-height-rule: exactly;">
    <center style="width: 100%; background: #ffffff;">
        <div style="display:none;font-size:1px;line-height:1px;max-height:0px;max-width:0px;opacity:0;overflow:hidden;mso-hide:all;font-family: sans-serif;">
            We could not verify your '.$type.'
        </div>
        <div style="max-width: 600px; margin: auto;">
            <table role="presentation" cellspacing="0" cellpadding="0" border="0" align="center" width="100%" style="max-width: 600px;">
                
                <tr>
                    <td bgcolor="#ffffff">
                        <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                            <tr>
                                <td style="padding: 40px; font-family: sans-serif; font-size: 15px; line-height: 20px; color: #555555;">
                                    Hello, your '.$type.' was rejected.<br><br> 

                                    This is as a result of it not meeting our standard.<br><br>Kindly re-upload another or a clearer version of the '.$type.'
                                    
                                    <br><br>For more info about the issue, you can send us a mail at compliance@kinitaxi.com.<br><br>
                                    
                                    Thanks<br>
                                    KiniTaxi Compliance Team
                                </td>
                                </tr>
                        </table>
                    </td>
                </tr>

            </table>
        </div>
    </center>
</body>
</html>';
        $mail->Subject = 'Compliance Team';
        $mail->send();
    }

    public function document($data){

        //split whats coming
        $new_data = explode("-",$data);

        //1 is for approved or rejected
        //0 is for license or worthiness

        //get driver email to send mail to
        $driver = json_decode($this->firebase->get('drivers/'.$new_data[2].'/personal_details', true), TRUE);

        if($this->firebase->set('drivers/'.$new_data[2].'/documents/'.$new_data[1].'/status', $new_data[0])) {

            //send message for only rejected documents
            if($new_data[0] == 'rejected'){
                $this->reject_message($driver['email'],$new_data[1],$new_data[2]);

                //change general account status to pending
                $this->firebase->set('drivers/'.$new_data[2].'/account_status', 'pending');
            }

            echo('Changes made successfully');
        }
        else
            echo('failed');

    }
}
