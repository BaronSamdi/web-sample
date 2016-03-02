<?php

namespace DataRetrieval;

require_once __DIR__ . '/../../includes/constants.php';
require_once __DIR__ . '/../ExceptionHandling/ExceptionHandler.php';
require_once __DIR__ . '../../../../../vendor/autoload.php';

use Aws\DynamoDb\DynamoDbClient;
use Aws\DynamoDb\Exception\DynamoDbException;

$_SERVER['HOME'] = SERVER_HOME;
error_reporting(E_ALL);
/*	
* Handle all database queries.
*/
 
 
 class Database_Client{
	
	private static $dynamoDB_client;
	private static $initialized = false;		
	
	private function __construct() {}		
	
	private static function initialize()
    {
        if (self::$initialized)
            return;
               
		self::$dynamoDB_client = 
			DynamoDbClient::factory(array(
			'profile' => DB_PROFILE,
			'region' => DB_REGION  
			));			
			
		self::$initialized = true;
		
		
    }
	
	
	
	
	/*
	* Fecth user data from DB, where key is email
	* 
	* @param - string user email	
	* @return - dynamoDB query Object, false if DynamoDbException is thrown.
	*/
	static function get_User_Info_By_Email($email){	 													
		
		try {		
			
			self::initialize();				
		
			$result = self::$dynamoDB_client->query([
				'TableName' => DB_USERS_TABLE,
				'IndexName' => DB_USERS_USER_MAIL_INDEX,													    		
				
				'KeyConditionExpression' => MEMBER_USER_EMAIL .' = :v_email',
				'ExpressionAttributeValues' => [
				':v_email' => ['S' => $email]
				],
				'ScanIndexForward' => false													       																																				
			]);						
		}
		
		catch(DynamoDbException $e){
			
			error_log($e->getMessage());
			return false;
		}
		
		return $result;																			
		
	}
	
	/*
	* Fecth user data from DB, where key is facebook business token
	* 
	* @param - string user Facebook business token	
	* @return - dynamoDB query Object, false if DynamoDbException is thrown.
	*/
	static function get_User_Info_By_Facebook_ID($fb_Business_Token){				
		
		try{
			self::initialize();
			
			
			$result = self::$dynamoDB_client->query([
				'TableName' => DB_USERS_TABLE,
				'IndexName' => DB_USERS_FB_BUSINESS_TOKEN_INDEX,													    		
				
				'KeyConditionExpression' => MEMBER_FB_BUSINESS_TOKEN .' = :v_fb_Business_Token',
				'ExpressionAttributeValues' => [
				':v_fb_Business_Token' => ['S' => $fb_Business_Token]
				],
				'ScanIndexForward' => false													       																																				
			]);	
		}
		catch(DynamoDbException $e){
			
			error_log($e->getMessage());
			return false;
		}
		
		return $result;
	}
	
	
	/*
	* Fecth user's albums from DB, where key is user ID 
	* 
	* @param - string user ID	
	* @return - dynamoDB query Object, false if DynamoDbException is thrown.
	*/
	static function get_Albums_By_UserID($UserId){				
		
		try{
			self::initialize();
				
			 $result = self::$dynamoDB_client->query([
				'TableName' => DB_ALBUMS_TABLE,											    		
								
				'KeyConditionExpression' => MEMBER_USER_ID .' = :v_userID',
				'ExpressionAttributeValues' => [
				':v_userID' => ['S' => $UserId]
				],				
				'ScanIndexForward' => true													       																																				
			]);	
		}
		catch(DynamoDbException $e){
			
			error_log($e->getMessage());
			return false;
		}
		
		return $result;				
	}
	
	
	/*
	* Fecth extracted shots associated to a specific album.  
	*  
	* @param - string user ID, string album ID	
	* @return - dynamoDB query Object, false if DynamoDbException is thrown.
	*/
	static function get_Extracted_Shots_By_Album_ID($UserId, $albumID){					
		
		try{
			self::initialize();
				
			 $result = self::$dynamoDB_client->query([
				'TableName' => DB_EXTRACTED_PHOTOS_TABLE,
				'IndexName' => DB_EXTRACTED_PHOTOS_USERID_ALBUMID_INDEX,											    		
								
				'KeyConditionExpression' => MEMBER_USER_ID . ' = :v_userID AND ' . MEMBER_ALBUM_ID .' = :v_albumID',
				'ExpressionAttributeValues' => [
				':v_userID' => ['S' => $UserId],
				':v_albumID' => ['S' => $albumID]
				],				
				'ScanIndexForward' => false													       																																				
			]);	
		}
		catch(DynamoDbException $e){
			
			error_log($e->getMessage());
			return false;
		}
		return $result;				
	}
	
	
	
	
	/*
	 * Fecth user data from DB, where key is user ID
	*
	* @param - string user user ID
	* @return - dynamoDB query Object, false if DynamoDbException is thrown.
	*/
	static function get_user_Info_By_userID($userID){
	
		try {
	
			self::initialize();
	
			$result = self::$dynamoDB_client->query([
					'TableName' => DB_USERS_TABLE,
					
	
					'KeyConditionExpression' => MEMBER_USER_ID .' = :v_userID',
					'ExpressionAttributeValues' => [
					':v_userID' => ['S' => $userID]
					],
					'ScanIndexForward' => false
					]);
		}
	
		catch(DynamoDbException $e){
	
			error_log($e->getMessage());
			return false;
		}
	
		return $result;
	
	}
	
	
	
}
