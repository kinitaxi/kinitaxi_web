<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PHPMailer\PHPMailer\PHPMailer;

require 'vendor/autoload.php';

class Home extends MY_Controller {

    public function __construct()
    {
        parent::__construct();

    }
    public function index()
    {
        $url = API_URL.'messaging/ragnarok'; //api endpoint to post data to
        $data = array('channel' => 'sms', 'type' => 'otp', 'recipient' => $_POST['phone']); //send otp to user
        $otp = Requests::post($url, array(), $data);
        $user = (isset($_POST['phone']))?['phone' => $_POST['phone']]:[];
        if ($otp){ //check if otp was sent successfully
            $this->session->set_userdata('otp', $otp->body); //save otp to session
            $this->session->mark_as_temp('otp', 600); //set how long otp will last for - 600 seconds= 10 minutes
            $this->session->set_userdata('user', $user); //create user object to use for registration
            $this->redirect('signup/verify', ['information', 'An OTP was sent to your number, please provide it']);
        }
    }

    public function contact(){

        //build smtp protocol for email
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = 'smtp.zoho.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'hello@kinitaxi.com';
        $mail->Password = 'elatech2017';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;
        $mail->setFrom('hello@kinitaxi.com', 'Contact Form');
        $mail->Timeout = 60;
        $mail->addAddress('support@kinitaxi.com');
        $mail->isHTML(true);
        $mail->Body = '<table style="width:100%;font-size:14px;">
            <tr>
                <td><b>Someone sent you an email from your website</b></td>
            </tr><br>
            <tr><td><b>Name:</b> '.$_POST["first_name"]. ' '.$_POST["last_name"].'</td></tr>
            <tr><td><b>Email:</b> '.$_POST["email"].'</td></tr>
            <tr><td><b>Content:</b> '.$_POST["message"].'</td></tr>
            
        </table>';
        $mail->Subject = 'New Email from Website';
        if ($mail->send()) {

            $this->redirect('home', ['success', 'Mail sent successfully, someone will reach out to you soon']);
        }
        else{

        }
    }
}
