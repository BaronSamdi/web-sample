<?php

namespace UserInfo;

require_once __DIR__ . '/../../includes/constants.php';
require_once __DIR__ . '/../ExceptionHandling/ExceptionHandler.php';
require_once __DIR__ . '/../DataRetrieval/Database_Client.php';
require_once __DIR__ . '/../DataRetrieval/AWS_S3_Client.php';
require_once __DIR__ . '/Album.php';
require_once __DIR__ . '/Photo.php';
require_once __DIR__ . '/Abstract/AbstractUser.php';

use DataRetrieval\Database_Client;
use DataRetrieval\AWS_S3_Client;


class PremiumUser extends AbstractUser{	
	
	function __construct(){						
				
		if(!isset($_SESSION[MEMBER_USER_ID])){
			return false;
		}
		
		$this->user_id = $_SESSION[MEMBER_USER_ID];
		
		$this->init_user_info();
		
		$this->init_albums_data();	

	}		
			
	/*
	 * fetch album and photos data from dynamoDB and init this classes data elements 
	 * 
	 */
	private function init_albums_data(){
		
		$DB_albums;
		$DB_album_photos;
		$album_photos_urls = array();
		
		// Get dynamoDB Object holding all the user's albums data
		$DB_albums = Database_Client::get_Albums_By_UserID($this->user_id);
		
		// If database query threw Exception
		if( !$DB_albums ){
			$this->user_albums_arr = false;
			$this->number_of_albums = 0;
			return;
		}				
		
		$this->number_of_albums = $DB_albums['Count'];
		
		$this->user_albums_arr = array();
				
		foreach ($DB_albums['Items'] as $album) {
						
			$curr_AlbumId = $album[MEMBER_ALBUM_ID]['S'];
					
			// Get from DB the photos Object of this specific album
			$DB_album_photos = Database_Client::get_Extracted_Shots_By_Album_ID($this->user_id, $curr_AlbumId);						
			
			
			$this->user_albums_arr[$curr_AlbumId] = new Album($album, $DB_album_photos);
				
			
			$album_photos_urls = AWS_S3_Client::get_AWS_S3_folder_presigned_urls(
					$this->user_id, $curr_AlbumId);					
			
			// If attmept to get presigned urls failed
			if(!$album_photos_urls){
				error_log('Error while trying to fetch presigned urls for ' .$this->user_id
				. '/' . $curr_AlbumId .'/');			
			}					
			
			foreach ($this->user_albums_arr[$curr_AlbumId]->get_album_photos() as &$photo) {														
				
				$img_url = $this->get_photo_url(
						$photo->get_photo_ID(), $album_photos_urls, PHOTO_URL);
				
				$img_thumb_url = $this->get_photo_url(
						$photo->get_photo_ID(), $album_photos_urls, PHOTO_THUMB_URL);
				
				/* 
				* If fetch of this photo's S3 presigned URLs failed,
				* insert broken link so img onerror method will be called on html doc loading
				* and present a "missing image" ui element.
				*/
				if(!$img_url)					
					$img_url = PUBLIC_BASE_URL . 'this-is-a-broken-image-link.jpg';					
				
				$photo->set_photo_url($img_url);				
				
				if(!$img_thumb_url)
					$img_thumb_url = PUBLIC_BASE_URL . 'this-is-a-broken-image-link.jpg';
				
				$photo->set_photo_thumbnail_url($img_thumb_url);												
				
				// set album cover photo if none exists
				if(empty($this->user_albums_arr[$curr_AlbumId]->get_cover_img_url()))
					$this->user_albums_arr[$curr_AlbumId]->set_album_cover_img_url($this->get_photo_url(
						$photo->get_photo_ID(), $album_photos_urls, PHOTO_THUMB_URL));
				
			}			
			
		}
				
	}
	
	/*
	 * init basic data
	 */
	private function init_user_info(){
		
		if(isset($_SESSION[MEMBER_FB_ID])){
			
			$this->user_name = $_SESSION[MEMBER_FB_NAME];			
			$this->user_email = $_SESSION[MEMBER_FB_EMAIL];
			$this->user_avatar_img_url = 'https://graph.facebook.com/'. $_SESSION[MEMBER_FB_ID]
			 .'/picture?type=small';
		}
		else{
			$this->user_email = $_SESSION[MEMBER_USER_EMAIL];
			$this->user_name = $_SESSION[MEMBER_FIRST_NAME] . ' ' . $_SESSION[MEMBER_LAST_NAME];
			$this->user_avatar_img_url = "";
		}
	}
	
	/*	
	* Use a album ID and photo ID to get a photo's presigned url,
	* created via AWS_S3_Client::get_AWS_S3_Presigned_Photos_Urls()
	* 
	* @param - string $photoID - extracted photo ID for which we want to get a pointing url.
	* string $albumId - the photo's containing album id.
	* array $urlsArray - array that holds the presigned urls of photos for each album.
	* $urlType - type of url to be returned (ie PHOTO_URL, PHOTO_THUMB_URL)
	*
	* @return - string url of the requested photo type
	*/
	private function get_photo_url($photoID, $urlsArray, $urlType){
		
		if(!isset($urlsArray[$photoID][$urlType])){
			return false;
		}
		
		return $urlsArray[$photoID][$urlType];
		
			
	}				
		
			
	/*
	 * get photos of specific album.
	 * @param - albumID
	 * @return - array of photo objects
	 * 
	 */	
	public function get_album_photos($albumID){
		
		 return $this->user_albums_arr[$albumID]->get_album_photos();
	}	
		
	
	/*
	* get specific album.
	* @param - albumID
	* @return - album object
	*
	*/
	public function get_album($albumID){
	
		return $this->user_albums_arr[$albumID];
	
	}	
	
}
