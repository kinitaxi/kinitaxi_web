<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use duncan3dc\Laravel\BladeInstance;  //initialize blade engine

class MY_Controller extends CI_Controller
{
    protected $blade;
    public $userObj;

    function __construct()
    {
        parent::__construct();
        $this->blade = new BladeInstance(__DIR__ . "/../views", __DIR__ . "/../cache/views");
    }
    public function redirect($uri = '', $noty = [])
    {
        if (!empty($noty)) {
            $this->session->set_userdata('noty-type', $noty[0]);
            $this->session->set_userdata('noty-message', $noty[1]);
        }
        // sort session issue
        redirect($uri);
    }
    public function clear_session($all)
    {//clears only noty when set to false but clears user info also when true
        ($all == FALSE) ? $this->session->unset_userdata(['noty-type', 'noty-message']) :
            $this->session->unset_userdata(['noty-type', 'noty-message', 'user']);

    }
    public function retrieve_user()
    {
        //loads information specific to user
        $this->load->model('Users_m');
        $userObj = $this->session->userdata('user');  //retrieves user object from session saved during sign in
        $user_arr =[];  //declares empty user array in case no user is signed in
        (!empty($userObj))?$user_arr=[  //determines if user object exists in memory to append to else return []
            'id' => $userObj->id,
            'email' => $userObj->email,
            'phone' => $userObj->phone,
            'activated' => $userObj->activated,
            'dob' => $userObj->dob,
            'name' => $userObj->name
            ] : [];
        ///
        return $user_arr;
    }

    function decrypt($data)
    {
        $secret = "acxiapp2018";

        //Generate a key from a hash
        $key = md5(utf8_encode($secret), true);

        //Take first 8 bytes of $key and append them to the end of $key.
        $key .= substr($key, 0, 8);

        $data = base64_decode($data);

        $data = mcrypt_decrypt('tripledes', $key, $data, 'ecb');

        $len = strlen($data);
        $pad = ord($data[$len-1]);

        $decrypted = substr($data, 0, strlen($data) - $pad);

        return ($decrypted);
    }


}
