<?php

namespace UserInfo;

require_once __DIR__ . '/Abstract/AbstractUserAlbum.php';
require_once __DIR__ . '/Photo.php';
require_once __DIR__ . '/../../includes/constants.php';
require_once __DIR__ . '/../ExceptionHandling/ExceptionHandler.php';

class Album extends AbstractUserAlbum {

	
	function __construct($dynamoDB_album, $dynamoDB_photos_arr){
		
		if(!$dynamoDB_album){			
			return false; 
		}
		
		if(isset($dynamoDB_album[MEMBER_ALBUM_ID]['S']) && !empty($dynamoDB_album[MEMBER_ALBUM_ID]['S']))
			$this->album_id = $dynamoDB_album[MEMBER_ALBUM_ID]['S'];
		else 
			$this->album_id = "";
		
		if(isset($dynamoDB_album[MEMBER_ALBUM_TITLE]['S']) && !empty($dynamoDB_album[MEMBER_ALBUM_TITLE]['S']))
			$this->album_title = $dynamoDB_album[MEMBER_ALBUM_TITLE]['S'];
		else
			$this->album_title = "";
		
		if(isset($dynamoDB_album[MEMBER_ALBUM_YEAR]['N']) && $dynamoDB_album[MEMBER_ALBUM_YEAR]['N'] != 0)
			$this->album_year = $dynamoDB_album[MEMBER_ALBUM_YEAR]['N'];
		else
			$this->album_year = "";
		
		if(isset($dynamoDB_album[MEMBER_ALBUM_PLACE]['S']) && !empty($dynamoDB_album[MEMBER_ALBUM_PLACE]['S']))
			$this->album_location = $dynamoDB_album[MEMBER_ALBUM_PLACE]['S'];
		else
			$this->album_location = "";
		
		// TBD - get from DB a predesignated album cover photo
		$this->album_cover_img_url = "";		
		
		if(!$dynamoDB_photos_arr){
			$this->album_photos_arr = false;
			$this->number_of_photos = 0;
		}
		else{
						
			$this->album_photos_arr = array();						
			
			
			foreach($dynamoDB_photos_arr['Items'] as $photo){
												
				$this->album_photos_arr[$photo[MEMBER_EXTRACTED_PHOTO_ID]['S']] = 
				new Photo($photo, $this->album_id);
				
			}												
			
			$this->number_of_photos = count($this->album_photos_arr);
		}		
		
	}
	
	/*
	* Create and return a json object representing this album's photos data.
	* 
	* Currently unused function - here for possible future use,
	* (for example - via external api calls).
	*/
	public function get_photos_arr_json(){
		
		$arr = array();		
		$arr['Count'] = $this->number_of_photos;
		$arr['Items'] = $this->album_photos_arr;
		return json_encode($arr);
	}
	
	/*
	 * @return album title
	 */
	public function get_album_title(){
	
		if(!empty($this->album_title))
			return $this->album_title;
		else
			return 'Untitled Album';

	}
	
}