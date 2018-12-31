<?php

defined('BASEPATH') OR exit('No direct script access allowed');

use Restserver\Libraries\REST_Controller;
use Flutterwave\Card;
use Flutterwave\Flutterwave;
use Flutterwave\AuthModel;
use Flutterwave\Currencies;
use Flutterwave\Countries;
use Flutterwave\FlutterEncrypt;

require APPPATH . '/libraries/REST_Controller.php';
require 'vendor/autoload.php';
include('vendor/rmccue/requests/library/Requests.php');

Requests::register_autoloader();


class Payments extends REST_Controller {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $merchantkey = MERCHANT_KEY;
        $apiKey = API_KEY;
        $env = ENV;
        Flutterwave::setMerchantCredentials($merchantkey, $apiKey, $env);
    }

    public function charge_post(){
        //todo: use this same module for end ride for billing the user, but calculate amount and retrieve card info from profile
        $new_data = json_encode($this->post());
        $new_data = (array)json_decode($new_data);

        $card = [
            "card_no" => $new_data['card_no'],
            "cvv" => $new_data['cvv'],
            "expiry_month" => $new_data['expiry_month'],
            "expiry_year" => $new_data['expiry_year'],
            "pin" => $new_data['pin']
        ];
        $custId = "76464";
        $currency = Currencies::NAIRA; //currency to charge the card
        $authModel = AuthModel::PIN;
        $narration = "narration for this transaction";
        $responseUrl = ""; //callback url
        $country = Countries::NIGERIA;
        $amount = $new_data['amount'];

        $req = Card::charge($card, $amount, $custId, $currency, $country, $authModel, $narration, $responseUrl);
        if($req->isSuccessfulResponse()) {
            $this->set_response($req->getResponseData()['data']['otptransactionidentifier'], REST_Controller::HTTP_OK);
        }else $this->set_response('failed', REST_Controller::HTTP_NOT_IMPLEMENTED);
    }

    public function otp_confirm_post(){
        $new_data = json_encode($this->post());
        $new_data = (array)json_decode($new_data);

        $ref = $new_data['ref']; //opt sent to card user
        $otp = $new_data['otp']; //opt sent to card user

        $req = Card::validate($ref, $otp, $cardType = "");
        if($req->isSuccessfulResponse()) {
            $this->set_response($req->getResponseData()['data'], REST_Controller::HTTP_OK);
        }else $this->set_response($req->getResponseData()['data']['responsemessage'], REST_Controller::HTTP_OK);
    }

    public function rebill_post(){

        $custId = "76464";

        $currency = Currencies::NAIRA; //currency to charge the card
        $authModel = AuthModel::PIN;
        $narration = "narration for this transaction";
        $responseUrl = ""; //callback url
        $country = Countries::NIGERIA;
        $amount = 10;

        $result = Card::chargeToken($_POST['token'], $amount, $custId, $currency, $country, $narration, $authModel, ['5886'], '', $responseUrl);

        $this->set_response($result->getResponseMessage(), REST_Controller::HTTP_OK);
    }




    public function tokenize_post(){

        $card = [
            "card_no" => "5199110119017470",
            "cvv" => "000",
            "expiry_month" => "02",
            "expiry_year" => "2020"
        ];

        $authModel = AuthModel::NOAUTH; //this tells flutterwave how to validate the user of the card is the card owner
        $validateOption = Flutterwave::SMS; //this tells flutterwave to send authentication otp via sms
        $result = Card::tokenize($card, $authModel, $validateOption, $bvn = "");

        $this->set_response($result->getResponseData(), REST_Controller::HTTP_OK);
    }

    public function preauthorize_post(){

        $result = Card::preAuthorize($_POST['token'], 50, Currencies::NAIRA);
        $this->set_response($result->getResponseData(), REST_Controller::HTTP_OK);
    }

    public function card_charge_post(){

        $result = Card::capture($_POST['ref'], $_POST['id'], 50, Currencies::NAIRA);
        if ($result->isSuccessfulResponse()) {
            $this->set_response($result->getResponseData()['data']['responsemessage'], REST_Controller::HTTP_OK);
        }
    }

    public function refund_post(){

        $custId = "76464";

        $currency = Currencies::NAIRA; //currency to charge the card
        $authModel = AuthModel::PIN;
        $narration = "narration for this transaction";
        $responseUrl = ""; //callback url
        $country = Countries::NIGERIA;
        $amount = 50;

        $result = Card::chargeToken($_POST['token'], $amount, $custId, $currency, $country, $narration, $authModel, ['5886'], '', $responseUrl);

        $this->set_response($result->getResponseMessage(), REST_Controller::HTTP_OK);
    }

}
