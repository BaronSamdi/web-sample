<?php

namespace UI;

require_once __DIR__ . '/../Authentication/LoginHelper.php';
require_once __DIR__ . '/../UserInfo/PremiumUser.php';
require_once __DIR__ . '/../../includes/constants.php';
require_once __DIR__ . '/../ExceptionHandling/ExceptionHandler.php';


use UserInfo\PremiumUser;
use login\LoginHelper;

class UIBuilder {
	
	
	private $user;
	private $loginHelper;
	
	/*
	 * init class.
	 * 
	 * 
	 */
	function __construct() {

		if(isset($_SESSION['user'])){
			$this->user =  unserialize($_SESSION['user']);			
		}
		else{
			$this->user = false;			
		}

		
		
		if(isset($_SESSION['loginHelper'])){
			$this->loginHelper =  unserialize($_SESSION['loginHelper']);
		}
		else{
			$this->loginHelper = false;
		}
		
	}
	
	/*
	 * add albums grid and data to my-albums page
	 * @return - html sructure of albums masonry grid
	 * 
	 */
	public function add_albums_html() {
		if (!$this->user)
			echo "";			
		
		// counters to find first and last album element
		$num_of_albums = $this->user->get_number_of_albums();
		$index = 1;
		$isLastAlbum = false;
		
		$html = "";
				
		// init grid head	
		$html .= '<ul class="grid no-cssanimations" id="grid">';
		
		// if there are no user albums, show only 'add album' image
		if($num_of_albums == 0){
			$html .= '<li class="visible-lg"><img class="add-album-img" src="webApp/css/styleImages/Add_new_album.png"></li>';
		}
		
		// for every album
		foreach ( $this->user->get_all_albums() as $album ) {

			if($index == $num_of_albums)
				$isLastAlbum = true;
						
			
			// TBD - get same size cover photo for all albums.
			// if title is too long, shorten it
			$album_title = $album->get_album_title();
			if(strlen($album_title) > 25){
				$album_title = substr($album_title, 0, 23) . '...';
			}
			
			// if this is the first album
			if($index == 1){
				$html .= '<li><div class="caption-wrapper first-album">';
			}
			
			// if this is the last album
			else if($isLastAlbum){
				$html .= '<li class="last-album"><div class="caption-wrapper last-mobile-album-cover">';
			}
			else{
				$html .= '<li><div class="caption-wrapper">';
			}
			
			// If this is an empty album
			if($album->get_number_of_photos() == 0){
				$html .= '<a href="album.php?id=' . $album->get_album_ID() . '" onclick="ga(\'send\', \'event\', \'my-albums-page\', \'open-empty-album-' . $album->get_album_ID() . '\', \'click\');">
				<img src="webApp/css/styleImages/empty_album.png" onerror="imgError(this);">';
			}
			else{
				$html .= '<a href="album.php?id=' . $album->get_album_ID() . '" onclick="ga(\'send\', \'event\', \'my-albums-page\', \'open-album\', \'click\');">
				<img src="' .$album->get_cover_img_url()
								.'" onerror="imgError(this);">';
			}
			
				
			// add overlay and album info text elements
			$html .= '<div class="caption-content"><span class="expand-icon"><span class="album-cover-info"><h5>' . $album_title .'</h5>';
			
			$html .= '<h6 class="desc">';
			
			if(!empty($album->get_album_year())){
				$html .= $album->get_album_year() . '&nbsp;&middot;&nbsp;';
			}
			
			if(!empty($album->get_album_location())){
				$html .= $album->get_album_location() .'&nbsp;&middot;&nbsp;';
			}
			
			if(!empty($album->get_number_of_photos())){
				$html .= $album->get_number_of_photos() .' photos';
			}
			else{
				$html .= '0 photos';
			}
			
			// close album html structure
			$html .= '</h6></span></span></div></a><div></li>';
			
			$index += 1;
			
		}
		
		$html .= '<li class="hidden-lg hidden-xs add-album-li"><a href="photomyne://"><img class="add-album-img" src="webApp/css/styleImages/add_new_album_tablet.png"></a></li>';
		$html .= '<li class="visible-xs add-album-li"><a href="photomyne://"><img class="add-album-img" src="webApp/css/styleImages/add_new_album_mobile.jpg"></a></li>';
		
		// close masonry grid 
		$html .= '</ul>';
						
		
		
		echo $html;
	}
	
	
	/*
	* add albums info to top of specific album page
	* @return - html sructure of text element
	*
	*/
	public function add_album_info_html($albumID) {										
		
		if (!$this->user)
			echo "";
		
		$album = $this->user->get_album($albumID);
		
		// start html structure
		$html =
		'<h1 id="album-title">' . $album->get_album_title() . '</h1>';
		
		if(!empty($album->get_album_year()))
			$html .= '<h2>' . $album->get_album_year() . '</h2>';
		
		$html .= '<h3>' . $album->get_number_of_photos() . ' photos';
		
		if(!empty($album->get_album_location()))
			$html .= '&nbsp;&middot;&nbsp;' . $album->get_album_location() . '</h3>';
		// end html structure 
		
		echo $html;
	}
	
	
	
	
	/*
	* add photos html grid and data to specific album page
	* @param - album id
	* @return - html sructure of photos grid element
	*
	*/
	public function add_album_photos($albumID) {
	
		if (!$this->user)
			echo "";
	
		
		// counters to find first and last photo element
		$num_of_photos = $this->user->get_album($albumID)->get_number_of_photos();
		$index = 1;
		$isLastPhoto = false;		
		
		$html = "";
				
		// start desktop html grid element		
		$html .= '<ul id="grid" class="grid effect-1 hidden-xs popup-gallery">';						
				
		// for every photo
		foreach ( $this->user->get_album($albumID)->get_album_photos() as $photo ) {			
			
			if($index == $num_of_photos)
				$isLastPhoto = true;			

			
			
			// start specific photo html element
			if(!$isLastPhoto){
		
				$html .= '<li><div class="caption-wrapper">';
			}

			else{
			
				$html .= '<li><div id="last-photo" class="caption-wrapper">';
			}						
			
			// add inner image src and link
			$html .=			
				'<a onclick="ga(\'send\', \'event\', \'album-page\', \'photo-click\', \'click\');" class="image-link" href="' .$photo->get_photo_url() .'" title = "' . $photo->get_photo_title() . '">
							<img class="imgSrc" src="webApp/css/styleImages/small_preloader.gif" data-src="' .$photo->get_photo_thumbnail_url()
								.'" onerror="imgError(this);" alt = "' . $photo->get_photo_title() . '"
										title = "' . $photo->get_photo_title() . '">
							<div class="caption-content"><span class="expand-icon"></span></div></a><div></li>';
			$index += 1;
		}
		
		// end desktop html photo grid
		$html .= '</ul>';
		
		// start mobile html grid element
		$html .= '<ul class="grid no-cssanimations visible-xs">';
	
		// restart photo counters
		$index = 1;
		$isLastPhoto = false;							
		
		
		foreach ( $this->user->get_album($albumID)->get_album_photos() as $photo ) {				
			
			if($index == $num_of_photos)
				$isLastPhoto = true;								
			
			if(!$isLastPhoto){
		
			$html .= '<li><div class="caption-wrapper">';			
			}
			
			else{
				
				$html .= '<li><div id="mobile-last-photo" class="caption-wrapper">';	
			}
			
			$html .= '<img 
						src="webApp/css/styleImages/small_preloader.gif" data-src="' . $photo->get_photo_url() .'" title="' . $photo->get_photo_title() . '"
						alt="' . $photo->get_photo_title() . '" onerror="imgError(this);"/>
					<div class="caption-content">
						<div class="row">
							<div class="col-md-10">
								<h5></h5>								
							</div>						
						</div>
					</div>
				</div>
				<div class="mobile-details-view visible-xs">
					<h5>' . $photo->get_photo_title() . '</h5>
				</div>
			</li>';
			
			$index += 1;
		}
		
		$html .= '</ul>';
		// end mobile html grid element
		

		
		echo $html;
	}
	
	
	
	/*
	* add user name and avatar html snippet
	*/
	public function add_user_name_and_avatar(){
		
		$html = "";
		
		if (!$this->user)
			$html;				
		
		if(!empty($this->user->get_user_avatar_img_url()) ){
			
			$html .= '<img class="img-user-avatar" src="' .$this->user->get_user_avatar_img_url() .'">&nbsp;&nbsp;' 
					. $this->user->get_user_name(); 
			
		}
		else{
			
			$html .= '<img class="img-user-icon-mobile pull-right visible-xs" src="webApp/css/styleImages/user_mobile.png">
					<img class="img-user-icon hidden-xs" src="webApp/css/styleImages/user_small.png">
					<img class="img-user-icon visible-xlg hidden-xs" src="webApp/css/styleImages/user_big.png">;&nbsp;&nbsp;' . $this->user->get_user_name();
			
		}		
		
		return $html;
						
	}
	
	
	/*
	* get user name
	*/
	public function add_user_name(){
	
		if (!$this->user)
			return "";
				
		return $this->user->get_user_name();
	
	}
	
	
	/*
	* add user avatar html snippet
	*/
	public function add_user_avatar(){
	
		$html = "";
		
		if (!$this->user)
			return $html;			
	
		if(!empty($this->user->get_user_avatar_img_url()) ){
				
			$html .= '<img class="user-avatar" src="' .$this->user->get_user_avatar_img_url() .'">';
				
		}
		else{
				
			$html .= '<span class="icon-usericon"></span>';
				
		}
	
		return $html;
	
	}
	
	/*
	 * add user avatar html snippet.
	 * @param - $avatarWidth string avatar img width, $avatarHeight string avatar img height,
	 * The paramters are for pixel size.
	 */
	
	public function add_user_avatar_with_sizes($avatarWidth, $avatarHeight){
		
		$html = "";
		
		if (!$this->user)
			$html;				
		
		if(!empty($this->user->get_user_avatar_img_url()) ){
		
			$html .= '<img style="width:' .$avatarWidth. 'px; height:' . $avatarHeight . 'px;" src="' .$this->user->get_user_avatar_img_url() .'">';
		
		}
		else{
		
			$html .= '<img class="img-user-icon-mobile pull-right visible-xs" src="webApp/css/styleImages/user_mobile.png">
					<img class="img-user-icon hidden-xs" src="webApp/css/styleImages/user_small.png">
					<img class="img-user-icon visible-xlg hidden-xs" src="webApp/css/styleImages/user_big.png">';
		
		}
		
		return $html;
	}
	
	
	/*
	* verify a given album id exists in user data.
	* album links in 'my-albums.php' will send to album.php?id=albumId.
	* So we will verify that the url param sent is in fact a valid albumId.
	* 
	* @param - albumId
	* @return - none if valid, if not valid redirect to 404.php
	*
	*/
	public function verify_is_album($albumId){
		
		if (!$this->user)
			header('location: '. PUBLIC_BASE_URL);
		
		$album_ids = $this->user->get_all_albums_ids();
		if(!isset($album_ids[$albumId])){
			header('location: '. PUBLIC_404_URL);
		}		
	}
	
	/*
	 * add footer html snippet
	 */
	public function add_footer_html(){
	
		$html = '<div class="container footer" id="bottom">
			<div id="footer-bottom">
				<h5>
					<a id="footer-homepage-link" target="_blank"
					href="' . PUBLIC_BASE_URL . '">Photomyne</a>&nbsp;&copy;&nbsp;'
							. date("Y") . '&nbsp All
						Rights Reserved
				</h5>
			</div>
		</div>';
		
		echo $html;
	}
	
	/*
	* add header html snippet for premium members inner pages.
	* @param - name of page generated. ie; 'album', 'my-albums'.. 
	*
	*/
	public function add_member_pages_header_html($pageName){						
		
		$html = "";
		
		// if data corrupt
		if (!isset($_SESSION[CREDENTIALS_LOGIN]) && !isset($_SESSION[FB_ACCESS_TOKEN]))
			return $html;
		
		if (!$this->user)
			return $html;
		
		if (!$this->loginHelper)
			return $html;
		
		// param that holds the correct page to point to in case this
		// is mobile view and user clicks 'back' arrow in mobile nav header.
		$mobile_back_arrow_address = "";				
		
		switch($pageName){
			case "album":
				$mobile_back_arrow_address = PUBLIC_BASE_URL . 'my-albums.php';
				break;
					
			case "my-albums":
				$mobile_back_arrow_address = PUBLIC_BASE_URL;
				break;
					
			default:
				$mobile_back_arrow_address = PUBLIC_BASE_URL;
				break;
		}
		
		
		// start html structure
		$html .= 
		'<div id="preloader">
		<div id="stat">
		<div class="stat2"></div>
		</div>
		</div>
		<div class="content-wrapper" id="content-wrapper">
		<div class="container grid-container" id="grid-container">
		<div class="container header">
		<div class="navElement-top clearfix hidden-xs">
		<div class="row topRow"">
						<div class="col-lg-4 col-md-4 col-sm-4 topAppStoreLink">
		
							<a href="https://www.facebook.com/Photomyne?fref=ts" target="_blank"
							onclick="ga(\'send\', \'event\', \''.$pageName.'-page\', \'facebook-toplink\', \'click\');"><i
									class="fa fa-facebook"></i></a> <a href="https://twitter.com/photomyne"
											target="_blank" onclick="ga(\'send\', \'event\', \''.$pageName.'-page\', \'twitter-toplink\', \'click\');"><i class="fa fa-twitter"></i></a> <a
										 href="https://www.youtube.com/channel/UCecU6umHbTT_6M3iT4NvC-Q"
										 		target="_blank" onclick="ga(\'send\', \'event\', \''.$pageName.'-page\', \'youtube-toplink\', \'click\');"><i class="fa fa-youtube-play"></i></a> <a
										 		href="https://medium.com/@Photomyne" target="_blank" onclick="ga(\'send\', \'event\', \''.$pageName.'-page\', \'medium-toplink\', \'click\');"><i
										 		class="fa fa-medium"></i></a>		
										 		</div>
										 		<div class="col-lg-4 col-md-4 col-sm-4 logo-col">
										 		<a href="' . PUBLIC_BASE_URL . '"><img class="logo"
										 				src="webApp/css/styleImages/logox2.png"></a>
										 				</div>
										 				<div class="col-lg-4 col-md-4 col-sm-4 topRightLinks">										 				
									<div id="login-dropdown" class="dropdown">
								    <a id="login-dropdown-link" class="login-dropdown-link" href="#"
								    class="dropdown-toggle" data-toggle="dropdown">								    
								   '.$this->add_user_avatar() . $this->add_user_name().'</a>
								    <ul class="dropdown-menu">
								      <li><a href="' . $this->loginHelper->get_log_out_URL().'" onclick="ga(\'send\', \'event\', \''.$pageName.'-page\', \'desktop-logout-link\', \'click\');">log out</a></li>						      
								    </ul>
								  </div>										 														
								</div>
							</div>
						</div>
						<div class="container-fluid mobile-nav">
							<nav class="navbar visible-xs">
								<div id="mobile-logout-row" class="row mobile-logout-div-closed">
									<div class="col-xs-4 mobile-logout-col">
										<div class="mobile-back-icon-holder">
											<a class="icon-a" href="' . $mobile_back_arrow_address .'"><span class="icon-backicon"></span></a>
		
										</div>
									</div>
									
									<div class="col-xs-4 nav-logo">
										<a href="' . PUBLIC_BASE_URL . '"><img
											class="logo" src="webApp/css/styleImages/logox2.png"></a>		
									</div>
									<div class="col-xs-4 nav-user">
										<div class="mobile-user-icon-holder">
											<a class="icon-a" href="#" onclick="toggleMobileDropdown()"> 
											'. $this->add_user_avatar().'
											</a>
		
										</div>
									</div>
									<div id="mobile-logout" class="col-xs-12 mobile-logout">
										<p class="mobile-logout-name">' . $this->user->get_user_name() . '</p>
										<a class="mobile-logout-link" href="' . $this->loginHelper->get_log_out_URL() . '"
												 onclick="ga(\'send\', \'event\', \''.$pageName.'-page\', \'mobile-logout-link\', \'click\');">log out</a>
									</div>
								</div>						
							</nav>
						</div>
						
		
					</div>';
		// end html strcture
		
		echo $html;
		
	}
		
}

?>