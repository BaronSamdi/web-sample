<?php

namespace UserInfo;


abstract class AbstractUserAlbum {
	
	protected $album_id;
	protected $number_of_photos;
	protected $album_photos_arr;
	protected $album_title;
	protected $album_year;
	protected $album_location;
	protected $album_cover_img_url;
	
	
	public function get_album_ID(){
	
		return $this->album_id;
	}
	
	public function get_number_of_photos(){
	
		return $this->number_of_photos;
	}
	
	public function get_album_title(){
		
		return $this->album_title;
	}
	
	public function get_album_year(){
	
		return $this->album_year;
	}
	
	public function get_album_location(){
	
		return $this->album_location;
	}
	
	public function get_album_photos(){
	
		return $this->album_photos_arr;
	}
		
	
	public function get_cover_img_url(){
	
		return $this->album_cover_img_url;
	}
	
	public function set_album_cover_img_url($url){
		$this->album_cover_img_url = $url;
	}
		
	
}