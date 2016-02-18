<?php

require_once __DIR__ . '/webApp/includes/constants.php';
require_once __DIR__ . '/webApp/classes/ExceptionHandling/ExceptionHandler.php';

session_start();

/*
* Handle logout procedure and flush session.
*/
session_unset();
		
session_destroy();
					
header('location: '. PUBLIC_BASE_URL);
