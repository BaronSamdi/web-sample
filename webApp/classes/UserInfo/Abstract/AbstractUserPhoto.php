<?php

namespace UserInfo;


abstract class AbstractUserPhoto {
	
	protected $album_ID;
	protected $photo_ID;
	protected $photo_title;
	protected $photo_year;	
	protected $photo_url;
	protected $photo_thumb_url;
	
	
	public function get_album_ID(){
	
		return $this->album_ID;
	}
	
	public function get_photo_ID(){
	
		return $this->photo_ID;
	}
	
	public function get_photo_title(){
		
		return $this->photo_title;
	}
	
	public function get_photo_year(){
	
		return $this->photo_year;
	}
		
	
	public function get_photo_url(){
	
		return $this->photo_url;
	}
	
	public function get_photo_thumbnail_url(){
	
		return $this->photo_thumb_url;
	}
	
	public function set_photo_url($url){
	
		$this->photo_url = $url;
	}
	
	public function set_photo_thumbnail_url($thumbnail_url){
	
		$this->photo_thumb_url = $thumbnail_url;
	}
	
}