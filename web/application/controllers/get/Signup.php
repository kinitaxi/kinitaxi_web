<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Signup extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data = array('noty' => [
            'type' => $this->session->userdata('noty-type'),
            'message' => $this->session->userdata('noty-message')
        ]);
        echo $this->blade->render("signup/index", $data);
        $this->clear_session(FALSE);
    }
    public function verify()
    {
        $data = array('noty' => [
            'type' => $this->session->userdata('noty-type'),
            'message' => $this->session->userdata('noty-message')
        ]);
        echo $this->blade->render("signup/verify", $data);
        $this->clear_session(FALSE);
    }
    public function profile()
    {
        $data = array('noty' => [
            'type' => $this->session->userdata('noty-type'),
            'message' => $this->session->userdata('noty-message')
        ]);
        echo $this->blade->render("signup/profile", $data);
        $this->clear_session(FALSE);
    }
}
