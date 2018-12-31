<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Signup extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        //load users model
        $this->load->model('Users_m');
        if ($this->Users_m->where(['email' => $_POST['email']])->get()!== FALSE){ //checks if users already exists
            $this->redirect('signup',['error', "User already exists"]);
        }else{
            $data=[
                'email' => $_POST['email'],
                'name' => $_POST['name'],
                'password' => hash('gost', $_POST['password']),
                'activated' => 0
            ];
            if ($this->Users_m->insert($data) !== FALSE){
                $user = $this->Users_m->where(['email' => $data['email']])->as_array()->get();
                $this->session->set_userdata('user', (object)$user); //sign in to session
                $this->redirect('dashboard',['success', 'Registration was successful, go to your email to activate']); // new registration
            }
        }
    }
    public function verify()
    {
        //compare session otp with user input
        if ($_POST['otp'] == $this->session->userdata('otp')){
            $this->redirect('signup/profile', ['success', 'Verification complete']);
        }
        else $this->redirect('signup/verify', ['error', 'OTP does not match, click on resend to receive another.']);
    }
    public function profile()
    {
        //todo: check if user is coming from facebook or google or regular data
        if (isset($_POST['name'])){
            $names = explode(' ', $_POST['name']); //split incoming name to first and last name
            $user = [
                'first_name' => $names[0],
                'last_name' => $names[1],
                'phone' => $_POST['phone'],
                'email' => $_POST['email'],
                'photo_url' => $_POST['image']
            ];
            $this->session->set_userdata('profile', $user); //save new user in session for signin
            //perform registration to firebase
            $url = API_URL.'users/register'; //api endpoint to register user to
            $data = array('first_name' => $names[0], 'last_name' => $names[1], 'email' => $_POST['email'], 'photo_url' => $_POST['image'],
                'phone' => $this->session->userdata('user')['phone']); //send data to api for registration

            if ((Requests::post($url, array(), $data))->status_code == 200){
                $this->redirect('app', ['success', 'Registration was successful']);
            }
            else $this->redirect('home', ['error', 'Something went wrong']);
        }
    }
}
