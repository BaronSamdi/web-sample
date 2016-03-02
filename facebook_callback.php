<?php

require_once __DIR__ . '/webApp/includes/constants.php';
require_once __DIR__ . '/webApp/classes/Authentication/FacebookLogin.php';
require_once __DIR__ . '/webApp/classes/ExceptionHandling/ExceptionHandler.php';

session_start();

use login\FacebookLogin;


/*
* Handle Facebook login calback by calling
* log_In_Facebook_member()
*/

$facebookLogin = new FacebookLogin();
$facebookLogin->log_In_Facebook_member();

