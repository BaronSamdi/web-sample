<?php

namespace login;

require_once __DIR__ . '/../../includes/constants.php';
require_once __DIR__ . '/../ExceptionHandling/ExceptionHandler.php';
require_once __DIR__ . '/CredentialsLogin.php';
require_once __DIR__ . '/FacebookLogin.php';


/*	
* Handle all login flows, credential, Facebook (or others).
*/


class LoginHelper{
	
	
	private $facebookLogin;	
	
	
	function __construct(){
				
		$this->facebookLogin = new FacebookLogin();
	}
	
	
	/*	
	* @return - If user is logged out, return false.
	* else redirect to members only base url and return true.
	*/
	function is_logged_In(){
		
		if (!isset($_SESSION[CREDENTIALS_LOGIN]) && !isset($_SESSION[FB_ACCESS_TOKEN]))										
			return false;
					
		else {
			header('location: '. MEMBERS_BASE_URL);
			return true;
		}
	}	
	
	
	/*	
	* @return - If user is logged in, return false.
	* else redirect to public base url and return true.
	*/
	function is_logged_Out(){
		
		if (isset($_SESSION[CREDENTIALS_LOGIN]) || isset($_SESSION[FB_ACCESS_TOKEN]))												
			return false;
				
		else{
			header('location: '. PUBLIC_BASE_URL);
			return true;
		}
		
	}
	
	/*
	* @param - string user submitted email, string user submitted password.
	* @return - string message, empty if credentials are validated;
	*/
	function validate_User_Credentials($email, $pwd){
		
		return CredentialsLogin::validateUser($email, $pwd);
	
	}

	/*
	* For use of UIBuilder creating elements in members only inner pages.
	* @return - string Facebook logout url if this is a Facebook login session,
	* or const string LOGOUT_URL if this is a credentials login session.
	*/
	public function get_log_out_URL(){
		if(isset($_SESSION[FB_ACCESS_TOKEN]))
			return $this->facebookLogin->get_Facebook_Logout_URL();
		else
			return LOGOUT_URL;
	}
	
	/*	
	* @return - string Facebook login url.
	*/
	function get_Facebook_Login_URL(){
		
		return $this->facebookLogin->get_Facebook_Login_URL();
	}
		
	
}