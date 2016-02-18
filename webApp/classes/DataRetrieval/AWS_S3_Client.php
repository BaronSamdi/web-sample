<?php

namespace DataRetrieval;

require_once __DIR__ . '/../../includes/constants.php';
require_once __DIR__ . '/../ExceptionHandling/ExceptionHandler.php';
require_once __DIR__ . '../../../../../vendor/autoload.php';

use Aws\S3\S3Client;
use Aws\Exception\AwsException;
use Aws\S3\Exception\S3Exception;

$_SERVER['HOME'] = SERVER_HOME;
error_reporting(E_ALL);

class AWS_S3_Client{

	private static $S3Client;
	private static $initialized = false;		
	
	private function __construct() {}		
	
	private static function initialize(){
        
		if (self::$initialized)
            return;
               
		self::$S3Client = 
			S3Client::factory(array(
    		'profile' => AWS_S3_PROFILE,
			'region' => AWS_S3_REGION
			 ));						
			
		self::$initialized = true;
    }	
	
	/*
	* Update AWS S3 permissions of all items in a specific folder associated with a specific user.	
	* @param - string $userId - user ID of member that these items are associated with.
	* $folderName - string name of S3 prefix\folder in which these items reside.
	* $ACL - string AWS S3 permission type
	* @return - true if procedure was successful, else false.
	* 
	*  Currently unused function - here for future possible use
	*/
	public static function update_AWS_S3_folder_ACL_permissions($userId, $folderName, $ACL){					
		
		try{
			
			self::initialize();
			
			$objects = self::$S3Client->getIterator('ListObjects', array(
			'Bucket' => USER_CONTENT_BUCKET_NAME,
			'Delimiter' =>	 '/',
			'Prefix' => $userId .'/' . $folderName .'/'
			)); 	
			
			foreach ($objects as $object) {				
				$key = $object['Key'];				
				$ret = self::$S3Client->putObjectAcl(array(
					'Bucket' => USER_CONTENT_BUCKET_NAME,
    				'Key'    => $key,
					'ACL'    => $ACL   		
					));
			}	
			
			return true;	
			
		}
		
		catch(AwsException $e){
			error_log($e->getMessage());
			return false;
		}
		
		catch(S3Exception $e){
			error_log($e->getMessage());
			return false;
		}
					
	}
	
	/*
	* Fetch S3 presigned urls for content of a specific user.
	* 
	* @param - string $userId - user ID of member that these items are associated with,
	* string $folderName - S3 prefix for the folder containing user content.
	* @return - array $photos_urls_arr with this folder's photos urls, else false if procedure fails.
	*/
	public static function get_AWS_S3_folder_presigned_urls($userId, $folderName){	
		
		try{
			
			self::initialize();
			
			$objects = self::$S3Client->getIterator('ListObjects', array(
			'Bucket' => USER_CONTENT_BUCKET_NAME,
			'Delimiter' =>	 '/',
			'Prefix' => $userId .'/' . $folderName .'/'
			)); 	
						
			$photos_urls_arr = array();
			
			foreach ($objects as $object) {				
				$key = $object['Key'];
				
				// If this is a photo type to be shown to user
				if (strpos($key, '_inner')){										
		
					$cmd = self::$S3Client->getCommand('GetObject', array(
						'Bucket' => USER_CONTENT_BUCKET_NAME,
						'Key'    => $key
					));
																
					$presignedUrl = $cmd->createPresignedUrl(S3_PRESIGNED_URL_TTL);						
					
					self::add_presigned_url_to_array($photos_urls_arr, $key, $presignedUrl);																																						
				}
			}
			return $photos_urls_arr;	
			
		}
		
		catch(AwsException $e){
			error_log($e->getMessage());
			return false;
		}				
		
		catch(S3Exception $e){
			error_log($e->getMessage());
			return false;
		}							
	}
	
	/*
	* Populate associative array containing S3 presigned URLs:
	* 
	* associative array structure -
	* key = string dynamo DB photo ID (ie; "photoXX_XXX-XXX-XXX" without "inner_" prefix and without filetype postfix) 
	* value = associative array 
	*  --- key = string image type (ie; 'PHOTO_URL\PHOTO_THUMB_URL') 
	*  --- value = string photo's S3 presigned url'\'photo thumbnail's S3 presigned url'.
	* 
	* so array structure is - [photo ID][image type] = corresponding S3 url
	*
	* @param
	* 1. array $arr - array to be populated
	* 2. string $photo_S3_name - photo S3 full name as found by $S3Client->getIterator()	
	* 3. string $presignedUrl - this photos's S3 presigned url.
	*
	*/
	private static function add_presigned_url_to_array(&$arr, $photo_S3_name, $presignedUrl){			
				
		$photo_prefix_index = strpos($photo_S3_name, 'Photo');
		
		$photo_id = substr($photo_S3_name, $photo_prefix_index);
		
		$photo_id = str_replace("inner_", "", $photo_id);
					
		
		if(strpos($photo_id, '_thumb2')){														
			$photo_id = str_replace("_thumb2.jpg", "", $photo_id);
			$arr[$photo_id][PHOTO_URL] = $presignedUrl;								
		}
		else if(strpos($photo_id, '_thumb')){
			$photo_id = str_replace("_thumb.jpg", "", $photo_id);
			$arr[$photo_id][PHOTO_THUMB_URL] = $presignedUrl;								
			
		}
		else{
			$photo_id = str_replace(".jpg", "", $photo_id);
			$arr[$photo_id][PHOTO_URL] = $presignedUrl;												
		}				
	
	}
}