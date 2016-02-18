<?php

namespace UserInfo;


abstract class AbstractUser {
	
	protected $user_albums_arr;
	protected $number_of_albums;
	protected $user_name;
	protected $user_id;
	protected $user_email;
	protected $user_avatar_img_url;
	
	
	public function get_number_of_albums(){
		return $this->number_of_albums;
	}
	
	public function get_all_albums(){
		return $this->user_albums_arr;
	}
	
	public function get_all_albums_ids(){
		$IDs_arr = array();
		$albums = $this->user_albums_arr;
		
		foreach ( $albums as $album ) {
			
			$IDs_arr[$album->get_album_ID()] = $album->get_album_ID();			
		}
		
		return $IDs_arr;
		
	}
	
	public function get_user_name(){
		return $this->user_name;
	}
	
	public function get_user_ID(){
		return $this->user_id;
	}
	
	public function get_user_email(){
		return $this->user_email;
	}
	
	public function get_user_avatar_img_url(){
		return $this->user_avatar_img_url;
	}
	
	
	
	
	public function set_user_name($name){
		$this->user_name = $name;
	}
	
	public function set_user_email($email){
		$this->user_email = $email;
	}
	
	public function set_user_avatar_img_url($url){
		$this->user_avatar_img_url = $url;
	}
	
	
}