<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller {

    public function __construct()
    {
        parent::__construct();

        //checks for admin.kinitaxi.com

        //splits the link request
        $subdoms = explode('.', $_SERVER['HTTP_HOST']);

        if (count($subdoms)>2 && $subdoms[0] == 'admin') {

            //do the check to see if school user is logged in
            $this->redirect('signin', ['info', 'Please login to continue']);
            //if school user logged in then open dashboard straight away else open signin page
        }
    }

    public function index()
	{

        $data = array('noty' => [
            'type' => $this->session->userdata('noty-type'),
            'message' => $this->session->userdata('noty-message')
        ]);
        echo $this->blade->render("home/index", $data);
        $this->clear_session(FALSE);
	}

	public function terms(){

        $data = array('noty' => [
            'type' => $this->session->userdata('noty-type'),
            'message' => $this->session->userdata('noty-message')
        ]);
        echo $this->blade->render("home/terms", $data);
        $this->clear_session(FALSE);
    }

	public function choose(){

        $data = array('noty' => [
            'type' => $this->session->userdata('noty-type'),
            'message' => $this->session->userdata('noty-message')
        ]);
        echo $this->blade->render("home/choose", $data);
        $this->clear_session(FALSE);
    }
}
