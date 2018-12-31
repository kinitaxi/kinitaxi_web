<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Signin extends MY_Controller {


    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if ($_POST['email'] == 'admin@kinitaxi.com' && $_POST['password'] == '12345678'){

            $this->session->set_userdata('user',['admin']);
            $this->redirect('app/dashboard', ['success', 'Login Successful']);
        }
        else
            $this->redirect('signin', ['error', 'Incorrect credentials']);
    }
}
