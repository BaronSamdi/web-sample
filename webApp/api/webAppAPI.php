<?php

require_once __DIR__ . '/../classes/UserInfo/PremiumUser.php';
require_once __DIR__ . '/../classes/ExceptionHandling/ExceptionHandler.php';
require_once __DIR__ . '/../includes/constants.php';

session_start();

use UserInfo\PremiumUser;


/*
 *  Use this file to execute external api calls to the webApp
*
*/



// param to hold api call result, ie: success, fail
$result = array();

// If no user is logged in
if( !isset($_SESSION['user']) ){
 	 $result['error'] = 'No logged in member.';
 	   	
}

// If no function request was provided in the call
if( !isset($_POST['function_name']) )
	{ $result['error'] = 'No function name provided.'; }


if( !isset($result['error']) ) {
	
	// Get the user if needed
	// $user = unserialize($_SESSION['user']);	

	
	/***** execute the correct function - example ****
	 * 
	 * switch($_POST['function_name']) {
	 *		case 'foo':
	 *		
	 *			// If we also sent arguments to the function
	 *			if( !isset($_POST['arguments']) ) { 
	 *				$result['error'] = 'Function arguments missing.'; 
	 *			}
	 *	   		echo $user->foo($_POST['arguments'][0]);
	 *	   		break;
	 *
	 *		default:
	 *  		$result['error'] = 'No corresponding ' .$_POST['function_name'] . ' function found.';
	 *			break;
	 *	}
	 * 
	 */	

}

	
							
	