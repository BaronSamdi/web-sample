<?php

namespace login;

require_once __DIR__ . '/../DataRetrieval/Database_Client.php';
require_once __DIR__ . '/../../includes/constants.php';
require_once __DIR__ . '/../ExceptionHandling/ExceptionHandler.php';

use DataRetrieval\Database_Client;
/*	
* Handle credentials login flow.
*/


class CredentialsLogin {		
	
	
	/*	
	* Check if user submitted email and password have a corresponding pair in database. 
	* @param - string user submitted email, string user submitted password.
	* If params are validtaed - We will set the user ID, user name and user email to session vars
	* and redirect to members only base url.
	* @return - If not validated - string message;
	*/
	
	public static function validateUser($email, $pwd) {				
		
		
		
		$result = Database_Client::get_User_Info_By_Email(strtolower($email));				
		
		// If database query threw Exception
		if ( !$result ) {
		  return GENERIC_SYSTEM_ERR_MSG;
		}		
		
		$num_of_matching_rows = count($result['Items']);
		
		// Possible result - Exactly one user with matching email in DB
		if ( $num_of_matching_rows == 1 ){
						
			//If this is a non-premium member, we will not allow login and send to 'Get Premium' page.			
			if( !isset($result['Items'][0][MEMBER_IS_PREMIUM_USER]['S']) ||  
			 strcmp($result['Items'][0][MEMBER_IS_PREMIUM_USER]['S'], PREMIUM_TIER_MEMBER) != 0 ) {
			 	
			 	//generate email and send						
				$res = mail(CONTACT_SUPPORT_MAILTO_ADDRESS ,"Non premium member login attempt", 
				wordwrap("Credentials login attempt\n\nUser email = " . $email .
				 " \nuserID = " . $result['Items'][0][MEMBER_USER_ID]['S'], 70), CONTACT_SUPPORT_MAILTO_HEADER);
				header('location: '. PUBLIC_GET_PREMIUM_URL);					
				exit();	
			}
			
		
			
			/*
			 * Currently allow both credentials and FB login.
			 			
			// IF user has a login with Facebook account (we found a Facebook business token
			// assigned to the user, present a message asking to login with FB.
			if ( $result['Items'][0][MEMBER_FB_BUSINESS_TOKEN]['S'] != NULL && !empty( $result['Items'][0][MEMBER_FB_BUSINESS_TOKEN]['S']) ){
				return SEND_TO_LOGIN_WITH_FACEBOOK_MSG;		
			}
			*/
			
			// If input email and password have a corresponding pair in database
			else if ( strcmp( $result['Items'][0][MEMBER_PASSWORD]['S'], (string)$pwd ) == 0 ){							
				$_SESSION[MEMBER_USER_ID] = $result['Items'][0][MEMBER_USER_ID]['S'];
				$_SESSION[MEMBER_USER_EMAIL] = $result['Items'][0][MEMBER_USER_EMAIL]['S'];
				$_SESSION[MEMBER_FIRST_NAME] = $result['Items'][0][MEMBER_FIRST_NAME]['S'];
				$_SESSION[MEMBER_LAST_NAME] = $result['Items'][0][MEMBER_LAST_NAME]['S'];
				
				$_SESSION[CREDENTIALS_LOGIN] = 'authorized';						
				header('location: '. MEMBERS_BASE_URL);	
				exit();	
				
			}
			
			// Wrong inputed password for corresponding email  
			else {				
				return WRONG_CREDENTIALS_LOGIN_ATTMEPT_MSG;
			}			
		
		}
		
		// Possible result - No matching email found in DB		
		else if($num_of_matching_rows == 0){			
			return WRONG_CREDENTIALS_LOGIN_ATTMEPT_MSG;
		}
		
		// Possible result - corrupted data (more than 1 row with same value of inputed email)
		else{
			$res = "Credentials login error\n";
			$res .= 'email queried = ' .$email . ', userID = '. $result['Items'][0][MEMBER_USER_ID]['S'];		
			
			//generate email and send			
			mail(CONTACT_SUPPORT_MAILTO_ADDRESS ,"Database query error",
					wordwrap($res, 70), CONTACT_SUPPORT_MAILTO_HEADER);
			header('location: '. PUBLIC_SYSTEM_ERROR_URL);
			exit();
		}				
										  		
	}
	
}
