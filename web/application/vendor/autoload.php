<?php

// autoload.php @generated by Composer

//for loading firebase
const DEFAULT_URL = 'https://kinitaxi-1007b.firebaseio.com/';
const DEFAULT_TOKEN = 'rjV2RjDCRA8looDFQn2UuXiscIxZM1Jq3kKpblfc';
const DEFAULT_PATH = 'users';

//for paystack
const PAYSTACK_KEY = 'sk_live_a43a9d77a0ad58e92298426b7d48b38b9cd41a77';
const CHARGE_API = 'https://api.paystack.co/charge';
const CHARGE_RECUR_API = 'https://api.paystack.co/transaction/charge_authorization';
const VALIDATE_API = 'https://api.paystack.co/charge/submit_';

require_once __DIR__ . '/composer/autoload_real.php';

return ComposerAutoloaderInit1e07a97fef4d5a6fca39b1fa7d83e458::getLoader();
