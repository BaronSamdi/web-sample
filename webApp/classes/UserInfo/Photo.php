<?php

namespace UserInfo;

require_once __DIR__ . '/Abstract/AbstractUserPhoto.php';
require_once __DIR__ . '/../../includes/constants.php';
require_once __DIR__ . '/../ExceptionHandling/ExceptionHandler.php';

class Photo extends AbstractUserPhoto{
	
	
	function __construct($dynamoDB_photo, $albumID){
	
		if(!$dynamoDB_photo){			
			return false;
		}
		
		$this->album_ID = $albumID;
		
		if(isset($dynamoDB_photo[MEMBER_EXTRACTED_PHOTO_ID]['S'])  && !empty($dynamoDB_photo[MEMBER_EXTRACTED_PHOTO_ID]['S']))
			$this->photo_ID = $dynamoDB_photo[MEMBER_EXTRACTED_PHOTO_ID]['S'];
		else
			$this->photo_ID = "";
		
		if(isset($dynamoDB_photo[MEMBER_EXTRACTED_PHOTO_TITLE]['S']) && !empty($dynamoDB_photo[MEMBER_EXTRACTED_PHOTO_TITLE]['S']))
			$this->photo_title = $dynamoDB_photo[MEMBER_EXTRACTED_PHOTO_TITLE]['S'];
		else
			$this->photo_title = "";
		
		if(isset($dynamoDB_photo[MEMBER_EXTRACTED_PHOTO_YEAR]['N']) &&  $dynamoDB_photo[MEMBER_EXTRACTED_PHOTO_YEAR]['N'] != 0)
			$this->photo_year = $dynamoDB_photo[MEMBER_EXTRACTED_PHOTO_YEAR]['N'];	
		else
			$this->photo_year = "";		
					
	
		$this->photo_url = "";
		$this->photo_thumb_url = "";
				
	
	}	
	
}