<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Signin extends MY_Controller {

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
        echo $this->blade->render("signin/index", $data);
        $this->clear_session(FALSE);
    }
}
