<?php
session_start();
/*
 * Basic Site Settings and API Configuration
 */

//Include Google client library 
include_once 'src/Google_Client.php';
include_once 'src/contrib/Google_Oauth2Service.php';

// Database configuration
define('DB_HOST', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'gdp');
define('DB_USER_TBL', 'users');

// Google API configuration
define('GOOGLE_CLIENT_ID', '363960158363-h8blu0152g2t90jcfvo15a4o5svmn4hk.apps.googleusercontent.com');
define('GOOGLE_CLIENT_SECRET', 'EMWLUfqFGdoigyIIceIJX9hZ');
define('GOOGLE_REDIRECT_URL', 'http://localhost:8000/inicio');

// Start session
if(!session_id()){
    session_start();
}

// Call Google API
$gClient = new Google_Client();
$gClient->setApplicationName('Login to Unnoba TEST');
$gClient->setClientId(GOOGLE_CLIENT_ID);
$gClient->setClientSecret(GOOGLE_CLIENT_SECRET);
$gClient->setRedirectUri(GOOGLE_REDIRECT_URL);

$google_oauthV2 = new Google_Oauth2Service($gClient);
