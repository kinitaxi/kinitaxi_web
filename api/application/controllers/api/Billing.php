<?php

defined('BASEPATH') OR exit('No direct script access allowed');

use Restserver\Libraries\REST_Controller;

require APPPATH . '/libraries/REST_Controller.php';
require 'vendor/autoload.php';

include('vendor/rmccue/requests/library/Requests.php');

Requests::register_autoloader();
class Billing extends REST_Controller {

    public $firebase;
    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->firebase = new \Firebase\FirebaseLib(DEFAULT_URL, DEFAULT_TOKEN); //load firebase engine
    }

    function add_card_post(){

        //for charging a card when adding or billing
        $new_data = json_encode($this->post());
        $new_data = (array)json_decode($new_data);

        //construct charge data
        $headers = array(
            'Authorization' => 'Bearer '. PAYSTACK_KEY
        );
        $data = [
            'email' => "customer@test.com",
            'amount' => "100",
            'card' => [
                'cvv' => $new_data['cvv'],
                'number' => $new_data['card_no'],
                'expiry_month' => $new_data['expiry_month'],
                'expiry_year' => $new_data['expiry_year']
                ],
            'pin' => $new_data['pin']
            ];

        $req = Requests::post(CHARGE_API, $headers, $data);

        //check if post went through
        if($req->success){
            $response = json_decode($req->body, TRUE);
            if($response['status'] == TRUE)
                $this->set_response([
                    'ref' => $response['data']['reference'],
                    'status' => $response['data']['status'],
                    'auth_code' => $response['data']['authorization']['authorization_code']
                ], REST_Controller::HTTP_OK);
        }
        else
            $this->set_response('failed', REST_Controller::HTTP_OK);


    }

    function complete_add_card_post(){

        //for charging a card when adding or billing
        $new_data = json_encode($this->post());
        $new_data = (array)json_decode($new_data);

        //construct charge data
        $headers = array(
            'Authorization' => 'Bearer '. PAYSTACK_KEY
        );
        $data = [
            'reference' => $new_data['ref'],
            $new_data['type'] => $new_data['value']
        ];

        $req = Requests::post(VALIDATE_API. (string)$new_data['type'], $headers, $data);
        $response = json_decode($req->body, TRUE);

        //check if post went through
        if($req->success){
            if($response['data']['authorization']['reusable'] == TRUE)
                $this->set_response($response['data']['authorization']['authorization_code'], REST_Controller::HTTP_OK);
            else $this->set_response('non_reusable', REST_Controller::HTTP_OK);
        }
        else
            $this->set_response('failed', REST_Controller::HTTP_OK);


    }

    function charge_card_post()
    {

        //for completing a charge if any additional information is required
        $new_data = json_encode($this->post());
        $new_data = (array)json_decode($new_data);

        //construct charge data
        $headers = array(
            'Authorization' => 'Bearer ' . PAYSTACK_KEY
        );
        $data = [
            'email' => $new_data['email'],
            'amount' => (float)$new_data['amount'] * 100,
            'authorization_code' => $new_data['auth_code'],
            'pin' => $new_data['pin']
        ];

        $req = Requests::post(CHARGE_RECUR_API, $headers, $data);
        $response = json_decode($req->body, TRUE);

        //logs data for record purposes
        $billing_details = [
            'amount' => (float)$new_data['amount'] * 100,
            'email' => $new_data['email'],
            'status' => $response['data']['status']
        ];
        $this->firebase->set('billing/' . $new_data['ride_id'], $billing_details);

        //check if post went through
        if ($req->success) {

            if ($response['data']['status'] == 'success'){
                $this->set_response('success', REST_Controller::HTTP_OK);
            }
            else $this->set_response('unsuccessful', REST_Controller::HTTP_OK);
        } else
            $this->set_response('failed', REST_Controller::HTTP_OK);

    }

    function getKey($seckey){
        $hashedkey = md5($seckey);
        $hashedkeylast12 = substr($hashedkey, -12);

        $seckeyadjusted = str_replace("FLWSECK-", "", $seckey);
        $seckeyadjustedfirst12 = substr($seckeyadjusted, 0, 12);

        $encryptionkey = $seckeyadjustedfirst12.$hashedkeylast12;
        return $encryptionkey;

    }

    function encrypt3Des($data, $key){

        //Pad for PKCS7
        $blockSize = mcrypt_get_block_size('tripledes', 'ecb');
        $len = strlen($data);
        $pad = $blockSize - ($len % $blockSize);
        $data = $data.str_repeat(chr($pad), $pad);

        //Encrypt data
        $encData = mcrypt_encrypt('tripledes', $key, $data, 'ecb');

        return base64_encode($encData);
    }

    function charge_post(){
        //for charging a card when adding or billing
        $new_data = json_encode($this->post());
        $new_data = (array)json_decode($new_data);


        //construct charge data
        $card = [
            'PBFPubKey' => PUB_KEY,
            'cardno' => "5199110729628914",
            'charge_type' => "preauth",
            'cvv' => "252",
            'suggested_auth' => "NOAUTH",
            'expirymonth' => "11",
            'expiryyear' => "19",
            "currency" => "NGN",
            "country" => "NG",
            "amount" => "1",
            "email" => "user@example.com",
            "phonenumber" => "08056552980",
            "firstname" => "user",
            "lastname" => "example",
            "IP" => "40.198.14",
            "txRef" => "MC-",
            "redirect_url" => "http://api.kinitaxi.com/api/index.php/api/billing/confirmation",
            "device_fingerprint" => "69e6b7f0b72037aa8428b70fbe03986c"
        ];

        $SecKey = SEC_KEY;

        $key = $this->getKey($SecKey);

        $dataReq = json_encode($card);

        $post_enc = $this->encrypt3Des( $dataReq, $key );

        //construct charge data
        $data = [
            "PBFPubKey" => PUB_KEY,
            "client" => $post_enc,
            "alg" => '3DES-24',
        ];
        $req = Requests::post(API_URL . '/charge', [], $data);
        $response = json_decode($req->body, TRUE);
        //check if post went through
        $this->set_response($response, REST_Controller::HTTP_OK);

    }

}
