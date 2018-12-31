<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Security extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        //checks if session has expired
    }

    public function index()
    {
        echo json_encode(csrf_token('value'));
    }

}
