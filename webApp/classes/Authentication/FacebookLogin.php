<?php

namespace login;


require_once __DIR__ . '/../../includes/constants.php';
require_once __DIR__ . '/../ExceptionHandling/ExceptionHandler.php';
require_once __DIR__ . '/../DataRetrieval/Database_Client.php';
require_once __DIR__ . '/Facebook/autoload.php';

use Facebook\Facebook;
use DataRetrieval\Database_Client;

/*	
* Handle Facebook login flow.
*/


class FacebookLogin {
	
	 private $fb;
	 private $helper;
	 private $permissions = ['email']; // optional to add more fields	 
	 
	function __construct(){
		
		$this->fb = new Facebook([
		  'app_id' => FB_APP_ID,
		  'app_secret' => FB_APP_SECRET,
		  'default_graph_version' => FB_DEFAULT_GRAPH_VER
		  ]);
		  
		$this->helper = $this->fb->getRedirectLoginHelper();				
		
	}
	
	
	/*	
	* Log user in using Facebook's login mechanism.
	* This method is called after Facebook Login url is clicked,
	* as a callback.
	* The method is called from facebook_callback.php page.
	* We will validate the user's FB business token within this method by calling
	* verify_User_By_Facebook_ID()
	*/
	function log_In_Facebook_member(){
		
		try {
		  $accessToken = $this->helper->getAccessToken();
		} catch(Facebook\Exceptions\FacebookResponseException $e) {
		  // When Graph returns an error		 
		  throw new \Exception('Graph returned an error: ' . $e->getMessage());
		  exit;
		} catch(Facebook\Exceptions\FacebookSDKException $e) {
		  // When validation fails or other local issues		 
		  throw new \Exception('Facebook SDK returned an error: ' . $e->getMessage());
		  exit;
		}
		
		if ( !isset($accessToken)) {
		  if ($this->helper->getError()) {
			header('HTTP/1.0 401 Unauthorized');
			error_log("Error: " . $this->helper->getError(). "\n");
			error_log("Error Code: " . $this->helper->getErrorCode() . "\n");
			error_log("Error Reason: " . $this->helper->getErrorReason() . "\n");
			error_log("Error Description: " . $this->helper->getErrorDescription() . "\n");
			throw new \Exception('Facebook SDK returned an error: ' . $e->getMessage());
			
		  } else {
			header('HTTP/1.0 400 Bad Request');
			error_log("Facebook SDK returned HTTP/1.0 400 Bad Request.\n");
			throw new \Exception('Facebook SDK returned HTTP/1.0 400 Bad Request: ' . $e->getMessage());			
		  }
		  
		  // If we failed to get access by user, or technical fail, return to
		  // public page
		  header('location: '. PUBLIC_LOGIN_URL);
		  exit;
		}							
		
		// The OAuth 2.0 client handler helps us manage access tokens
		$oAuth2Client = $this->fb->getOAuth2Client();
		
		// Get the access token metadata from /debug_token
		$tokenMetadata = $oAuth2Client->debugToken($accessToken);			
		
		try {
		// Validation (these will throw FacebookSDKException's when they fail)
		$tokenMetadata->validateAppId(FB_APP_ID);						
		
		} catch(Facebook\Exceptions\FacebookSDKException $e) {
			// When validation fails or other local issues
			error_log('Facebook SDK returned an error: ' . $e->getMessage());
			throw new \Exception('Facebook SDK returned an error: ' . $e->getMessage());
			exit;
		}
		
		// Lets validate that this user is a registered memebr		
		$this->verify_User_By_Facebook_ID($accessToken);
			
		$tokenMetadata->validateExpiration();
		
		if (! $accessToken->isLongLived()) {
		  // Exchanges a short-lived access token for a long-lived one
		  try {
			$accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
		  } catch (Facebook\Exceptions\FacebookSDKException $e) {
			error_log('Error getting long-lived access token: ' . $this->helper->getMessage());
			throw new \Exception('Error getting long-lived access token: ' . $this->helper->getMessage());
			exit;
		  }				 
		}
		
		$_SESSION[FB_ACCESS_TOKEN] = (string) $accessToken;
		
		// User is logged in with a long-lived access token.
		// We can redirect them to a members-only page.
		header('location: '. MEMBERS_BASE_URL);
				
	}
	
	
	
	/*
	* Verify that the user's Facebook ID corresponds to an ID in Database.  
	* @param - Facebook $tokenMetadata used to get user facebook ID.
	* 
	* If FacebooK ID is validtaed - We will set session variables holding sthe userID, FBname and FBID 
	* and redirect the user to the members only base url.
	* If not validated - we will redirect to either PUBLIC_GET_APP_URL or PUBLIC_GET_PREMIUM_URL.
	*/
	function verify_User_By_Facebook_ID($accessToken){												
		
		$res_object = null;
		
		try{
			$fb_response = $this->fb->get('/me?fields=token_for_business,email,id&access_token=' . $accessToken);
			$res_object = $fb_response->getGraphObject();						
		}
		catch(Facebook\Exceptions\FacebookResponseException $e) {
		    // When Graph returns an error			
			error_log( $e->getMessage());
			header('location: '. PUBLIC_LOGIN_URL);
		 
		} catch(Facebook\Exceptions\FacebookSDKException $e) {
		  	error_log( $e->getMessage());
			header('location: '. PUBLIC_LOGIN_URL);
		}
		
		$result = Database_Client::get_User_Info_By_Facebook_ID($res_object->getProperty('token_for_business') /*$tokenMetadata->getUserId() '10153010801357546'*/);
		
		// If database query threw Exception
		if ( !$result ) {
			error_log('database query failed.\n');
		  	header('location: '. PUBLIC_LOGIN_URL);			
		}		
		
		$num_of_matching_rows = count($result['Items']);				
		
		
		// Possible result - Exactly one user with matching Facebook business token in DB
		if ( $num_of_matching_rows == 1 ){						
			
			//If this is not a premium member, we will not allow login and send to 'get-premium' page
			 if( !isset($result['Items'][0][MEMBER_IS_PREMIUM_USER]['S']) ||  
			 	strcmp($result['Items'][0][MEMBER_IS_PREMIUM_USER]['S'], PREMIUM_TIER_MEMBER) != 0 ) {
					
				if( isset($_SESSION[FB_ACCESS_TOKEN]) )
			 		unset($_SESSION[FB_ACCESS_TOKEN]);

				//generate email and send				
				$res = mail(CONTACT_SUPPORT_MAILTO_ADDRESS ,"Non premium member login attempt", 
						wordwrap("Facebook login attempt\n\nEmail = " . $res_object->getProperty('email') 
								. "\nuserID = " . $result['Items'][0][MEMBER_USER_ID]['S'], 70),
									 CONTACT_SUPPORT_MAILTO_HEADER);
				
				
				header('location: '. PUBLIC_GET_PREMIUM_URL);
				exit();
			}								
			
			
			$_SESSION[MEMBER_USER_ID] = $result['Items'][0][MEMBER_USER_ID]['S'];
			$_SESSION[MEMBER_FB_NAME] = $result['Items'][0][MEMBER_FB_NAME]['S'];
			$_SESSION[MEMBER_FB_ID] = $res_object->getProperty('id');
			$_SESSION[MEMBER_FB_EMAIL] = $res_object->getProperty('email');
			return true;					
		
		}
		
		
		/* 
		* Possible result - No matching Facebook ID found in DB.
		* This means a non regitered user is attempting to log in,
		* so we will him to PUBLIC_GET_APP_URL.	
		*/	
		else if ( $num_of_matching_rows == 0 ){												
			
			if( isset($_SESSION[FB_ACCESS_TOKEN]) )
			 	unset($_SESSION[FB_ACCESS_TOKEN]);
						
			//generate email and send						
			$res = mail(CONTACT_SUPPORT_MAILTO_ADDRESS ,"New contact", 
					wordwrap("Facebook login attempt\n\nEmail = "
							 . $res_object->getProperty('email'), 70), CONTACT_SUPPORT_MAILTO_HEADER);			
			
			header('location: '. PUBLIC_GET_APP_URL);
			exit();
		}
				
		// Erroneous result - Failure or corrupted data (more than 1 rows 
		// with same FB business token in DB)
		else {													
			
			$res = "Facebook login error.\n";
			$res .= 'User FB business token queried= ' . $res_object->getProperty('token_for_business');
			
			//generate email and send				
			mail(CONTACT_SUPPORT_MAILTO_ADDRESS ,"Database query error",
					wordwrap($res, 70), CONTACT_SUPPORT_MAILTO_HEADER);
			
			error_log($res);
			header('location: '. PUBLIC_SYSTEM_ERROR_URL);			
			exit($res);
		}				
			
	}
	
	/*	
	* @return - string Facebook login url.
	*/
	function get_Facebook_Login_URL(){

		return $this->helper->getLoginUrl(FACEBOOK_CALLBACK_URL, 
			$this->permissions);
	}
		
	/*	
	* @return - string Facebook logout url.
	*/
	function get_Facebook_Logout_URL(){											
		
		// Get access token before destroying session			
		$FB_AccessToken = $_SESSION[FB_ACCESS_TOKEN];						
		
		// Get facebook & app logout url	
		return $this->helper->getLogoutUrl($FB_AccessToken, LOGOUT_URL);
	}
	
}
