<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include('application/vendor/rmccue/requests/library/Requests.php');
Requests::register_autoloader();

class App extends MY_Controller {

    public $firebase;
    public function __construct()
    {
        parent::__construct();

        //checks if session has expired
        //if (empty($this->session->userdata('user'))){
            //$this->redirect('signin', ['warning', 'You are not logged in, please login to continue']);
        //}

        //load firebase engine
        if (empty($this->session->userdata('user'))){
            $this->redirect('signin', ['warning', 'You are not logged in, please login to continue']);
        }
        else
            $this->firebase = new \Firebase\FirebaseLib(DEFAULT_URL, DEFAULT_TOKEN);
    }

    public function index()
    {
    }

    public function user_profile(){

        //updates user information
        $data = [
            'first_name' => $_POST['first_name'],
            'last_name' => $_POST['last_name'],
            'email' => $_POST['email']
        ];

        //send changes to fire-base
        if($this->firebase->update(DEFAULT_PATH . '/'. $_POST['phone'], $data))
            echo('User profile updated successfully');
        else
            echo('failed');

    }

    public function driver_profile(){

        //updates driver information
        $data = [
            'first_name' => $_POST['first_name'],
            'last_name' => $_POST['last_name'],
            'email' => $_POST['email']
        ];
        $data2 = [
            'color' => $_POST['car_color'],
            'year' => $_POST['car_year'],
            'make' => $_POST['car_make'],
            'model' => $_POST['car_model']
        ];

        //send changes to fire-base
        if($this->firebase->update('drivers/'. $_POST['phone'] .'/personal_details', $data)){
            $this->firebase->update('drivers/'. $_POST['phone'] .'/vehicle_details', $data2);
            echo('Driver profile updated successfully');
        }
        else
            echo('failed');

    }

    public function delete_driver(){

        //deletes user from fire-base
        if($this->firebase->delete('drivers/'. $_POST['driver_id']))
            echo('Driver deleted successfully');
        else
            echo('failed');
    }

    public function delete_user(){

        //deletes user from fire-base
        if($this->firebase->delete(DEFAULT_PATH . '/'. $_POST['user_id']))
            echo('User deleted successfully');
        else
            echo('failed');
    }

    public function app_settings(){

        $_POST['drivers_percentage'] = 100 - $_POST['drivers_percentage'];

        if($this->firebase->set('appSettings/', $_POST))
            echo('Settings changed successfully');
        else
            echo('failed');
    }

    public function approve_driver(){

        //for approving a driver's account

        //change values in database
        if($this->firebase->set('drivers/'.$_POST['driver_id'].'/account_status', 'approved')) {

            //change status of all documents to approved
            $this->firebase->set('drivers/'.$_POST['driver_id'].'/documents/license/status', 'approved');
            $this->firebase->set('drivers/'.$_POST['driver_id'].'/documents/worthiness/status', 'approved');
            $this->firebase->set('drivers/'.$_POST['driver_id'].'/documents/profile_pic/status', 'approved');

            //send sms and email of congratulations
            //send sms to driver
            $url = 'http://api.smartsmssolutions.com/smsapi.php?username=dechosenuchenna&password=yucee.dll&sender=KiniTaxi&recipient=@@'.$_POST['driver_id'].'@@&message=Your+account+has+been+approved,+you+can+now+take+trips+on+the+app.+Welcome+to+KiniTaxi.&';
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

            //todo: send email to driver

            //go back to former page
            echo('Driver has been approved successfully');
        }
        else echo('failed');

    }

    public function suspend_driver(){

        //for suspending a driver's account

        //change values in database
        if($this->firebase->set('drivers/'.$_POST['driver_id'].'/account_status', 'suspended')) {

            //send sms and email of congratulations
            //send sms to driver
            $url = 'http://api.smartsmssolutions.com/smsapi.php?username=dechosenuchenna&password=yucee.dll&sender=KiniTaxi&recipient=@@'.$_POST['driver_id'].'@@&message=You+have+been+suspended+from+taking+any+trips,+contact+support+at+support@kinitaxi.com+for+rectification.&';
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

            //todo: send email to driver

            //go back to former page
            echo('Driver has been suspended from taking trips');
        }
        else echo('failed');

    }

    public function unsuspend_driver(){

        //for suspending a driver's account

        //change values in database
        if($this->firebase->set('drivers/'.$_POST['driver_id'].'/account_status', 'approved')) {

            //send sms and email of congratulations
            //send sms to driver
            $url = 'http://api.smartsmssolutions.com/smsapi.php?username=dechosenuchenna&password=yucee.dll&sender=KiniTaxi&recipient=@@'.$_POST['driver_id'].'@@&message=Your+account+has+been+released,+you+can+now+take+trips+on+KiniTaxi.&';
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

            //todo: send email to driver

            //go back to former page
            echo('Driver suspension has been lifted');
        }
        else echo('failed');

    }

    public function process_withdrawal(){

        //retrieve user account details
        $recipient = $this->firebase->get('drivers/'.$_POST['payment_id'] .'/bank_details/account_hash', true);
        $recipient = str_replace('"','',$recipient);

        //checks to know if account number has been added
        if ($recipient !== NULL){

            //post money to account using paystack
            $headers = array(
                'Authorization' => 'Bearer '. PAYSTACK_KEY
            );
            $data = [
                'source' => 'balance',
                'amount' => $_POST['amount'] * 100,
                'recipient' => $recipient,
                'reason' => 'KiniTaxi Driver'
            ];
            $req = Requests::post('https://api.paystack.co/transfer', $headers, $data);

            //decode response
            $response = json_decode($req->body, TRUE);

            if ($req->success){

                //update the withdrawal status
                $date = new DateTime();
                $this->firebase->set('withdrawalRequests/'.$_POST['payment_id'] .'/processed_at', $date->getTimestamp());
                echo('sent');
            }
            else
                echo($response['message']);
        }
        else echo('Account number does has not been added yet');



    }

    public function collect_payment(){

        //retrieve user cards
        $user = json_decode($this->firebase->get(DEFAULT_PATH.'/' .$_POST['user_id'],true),TRUE);
        $userCards = $user['cards'];
        $billStatus = FALSE;

        //iterate over all available cards
        foreach($userCards as $card){

            //pass card for decryption
            $card1 = json_decode($this->decrypt($card), TRUE);

            //try and bill the main card itself
            $billStatus = $this->bill_card($card1['card_no'], $card1['cvv'], $card1['expiry_month'], $card1['expiry_year'], $card1['pin'], $_POST['amount'], $user['email']);

            if ($billStatus == 'success'){

                //logs data for record purposes
                $billing_details = [
                    'amount' => $_POST['amount'] * 100,
                    'email' => $user['email'],
                    'status' => 'success'
                ];
                $this->firebase->set('billing/' . $_POST['user_id'] . '/', $billing_details);

                //exit the loop
                break;
            }

        }

        if ($billStatus == 'success'){

            //make user account 0
            $this->firebase->set(DEFAULT_PATH.'/'.$_POST['user_id'].'/wallet/ride_wallet', 0);

            echo('collected');
        }
        else
            echo('Could not collect payment');


    }


    function bill_card($card_no, $cvv, $exp_month, $exp_year, $pin, $amount, $email){

        //construct charge data
        $headers = array(
            'Authorization' => 'Bearer '. PAYSTACK_KEY
        );
        $data = [
            'email' => $email,
            'amount' => $amount * 100,
            'card' => [
                'cvv' => $cvv,
                'number' => $card_no,
                'expiry_month' => $exp_month,
                'expiry_year' => $exp_year
            ],
            'pin' => $pin
        ];

        $req = Requests::post(CHARGE_API, $headers, $data);

        //check if post went through
        if($req->success){

            $response = json_decode($req->body);

            if($response->data->status == 'success')
                return ('success');
        }
        else
            return ('failed');


    }

    /*function bill_auth($auth_code, $pin, $amount, $email){

        //construct charge data
        $headers = array(
            'Authorization' => 'Bearer ' . PAYSTACK_KEY
        );
        $data = [
            'email' => $email,
            'amount' => $amount * 100,
            'authorization_code' => $auth_code,
            'pin' => $pin
        ];

        $req = Requests::post(CHARGE_RECUR_API, $headers, $data);
        $response = json_decode($req->body, TRUE);

        //check if post went through
        if ($req->success) {
            if ($response['data']['status'] == 'success'){
                return ('success');
            }
            else return ('failed');
        } else
            return ('failed');


    }*/
}
