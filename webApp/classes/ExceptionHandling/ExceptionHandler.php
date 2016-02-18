<?php

require_once __DIR__ . '/../../includes/constants.php';


/*
 * this class is responsibe for catching any
 * uncought thrown exception 
 * 
 * 
 */
class ExceptionHandler {
	public function __construct() {
		@set_exception_handler ( array (
				$this,
				'exception_handler' 
		) );
	}
	public function exception_handler($exception) {
		
		//generate email and send
		$res = mail(CONTACT_SUPPORT_MAILTO_ADDRESS ,"System Exception thrown",
			wordwrap("Exception message:\n\n". $exception->getMessage(), 70), CONTACT_SUPPORT_MAILTO_HEADER);
		
		header('location: '. PUBLIC_SYSTEM_ERROR_URL);
	}
}

// init exception object 
$exceptionHandler = new ExceptionHandler ();
