<?php

require_once __DIR__ . '/webApp/classes/Authentication/LoginHelper.php';
require_once __DIR__ . '/webApp/classes/UserInfo/PremiumUser.php';
require_once __DIR__ . '/webApp/classes/UI/UIBuilder.php';
require_once __DIR__ . '/webApp/classes/ExceptionHandling/ExceptionHandler.php';
require_once __DIR__ . '/webApp/includes/constants.php';

session_start();

use login\LoginHelper;
use UserInfo\PremiumUser;
use UI\UIBuilder;


error_reporting(E_ALL);

$loginHelper = false;
$user= false;

if(isset($_SESSION['loginHelper'])){
	$loginHelper =  unserialize($_SESSION['loginHelper']);
}
else{
	$loginHelper = new LoginHelper();
	$_SESSION['loginHelper'] = serialize($loginHelper);
} 			

// If user is logged out - redirect to public base url,
if( !($loginHelper->is_logged_Out()) ){
		
	if(isset($_SESSION['user'])){
		$user =  unserialize($_SESSION['user']);
	}
	else{
		$user = new PremiumUser();
		$_SESSION['user'] = serialize($user);		
	}			
}

$ui_builder = new UIBuilder();

$ui_builder->verify_is_album(filter_var($_GET['id'] ,FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH));

?>


<!DOCTYPE html>
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<head>
<meta charset="UTF-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>My Photomyne Photos</title>
<meta name="description" content="Scan photos in minutes. Save your memories forever." />
<meta name="keywords" content="" />
<meta name="author" content="photomyne.com">


<!-- FACEBOOK SHARE DATA -->
<meta property="og:title" content="photomyne.com" />
<meta property="og:description"
	content=" Scan photos in minutes. Save your memories forever." />
<meta property="og:type" content="website" />
<meta property="og:url" content="http://www.photomyne.com" />
<meta property="og:site_name" content="photomyne.com" />
<meta property="fb:admins" content="" />

<!-- FACEBOOK SHARE IMAGE -->
<meta property="og:image"
	content="" />
<meta property="og:image:width" content="1200" />
<meta property="og:image:height" content="630" />
<!-- END FACEBOOK SHARE -->


<!-- TWITTER SHARE DATA -->
<meta name="twitter:card" content="summary" />
<meta name="twitter:site" content="@photomyne" />
<meta name="twitter:creator" content="@photomyne" />
<meta name="twitter:title" content="photomyne.com" />
<meta name="twitter:description"
	content="Scan photos in minutes. Save your memories forever." />
<meta name="twitter:image"
	content="" />
<!-- END TWITTER SHARE -->

<link rel="shortcut icon" href="webApp/css/styleImages/favicon.png">

<link rel="stylesheet" type="text/css" href="webApp/css/bootstrap.min.css" />
<link rel="stylesheet" type="text/css"
	href="webApp/css/font-awesome.min.css">
	



<link rel="shortcut icon" href="webApp/css/styleImages/favicon.png">
<link rel="stylesheet" type="text/css" 
	href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css" />
<link rel="stylesheet" type="text/css"
	href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css" />
<!-- link rel='stylesheet' href='webApp/css/gallery.css' type='text/css' / -->	
<link rel="stylesheet" type="text/css" href="webApp/css/magnific-popup.css" />	
<link rel="stylesheet" type="text/css" href="webApp/css/style.css" />
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="http://www.photomyne.com/webApp/js/jquery-11.0.min.js"><\/\script>');</script>
<script>
function imgError(image) {
    image.onerror = "";
    image.src = "webApp/css/styleImages/missing-image.png";
    return true;
}
</script>
<style>
.caption-wrapper .caption-content {    
    opacity: 0;
    width: 100%;
    display: inline-block;
    height: 100%;
    bottom: 0px;
    position: absolute;
    left: 0;
    padding: 0 15px;
    border: solid 8px #fff;    
}
.caption-wrapper:hover .caption-content {
    background: rgba(0, 0, 0, 0.5);   
}
.album-info h1 { 
    margin-bottom: 0px;
    margin-top:32px;
}
.album-info {    	
	padding-bottom:30px;
}

@media screen and (max-width: 767px){	
	
	.content-wrapper {	   
	    padding-bottom: 40px;
	}
	
	.container.grid-container{
		padding-right: 0px;
	    padding-left: 0px;
	    width: 100vw;	    
	}	
	.caption-wrapper {    	
    	border: solid 12px #fff;   	
	}	
	.caption-wrapper .caption-content {    	    	
    	border:none;
	}	
	.grid li {	   
	    width: 100%;
	    padding: 5px 0px 5px 0px;
	    
	}				    
   .album-info {    	
    	padding-top: 0px;
    	padding-bottom:0px;
    }	
	.album-info h1 {	    
	    margin-top: 0px;	   
	}	
	.caption-wrapper:hover .caption-content {
    	background: transparent;
    }   
}
</style>
</head>
<body data-spy="scroll" data-target="#dotSideScroll" id="top">
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-59148541-1', 'auto');
  ga('send', 'pageview');

</script>
<?php 

if (isset($_GET['id'])) {
	echo '<div class="hidden album_id" id="' .$_GET['id'].'"></div>';
}
?>
		
			<?php echo $ui_builder->add_member_pages_header_html("album") ?>
			<div class="sub-header">
				<ol class="breadcrumb hidden-xs">
					<li><a href="http://www.photomyne.com/" onClick="ga('send', 'event', 'album-page', 'home-breadcrumb' , 'click');">Home</a></li>
					<li><a href="my-albums.php" onClick="ga('send', 'event', 'album-page', 'my-albums-breadcrumb' , 'click');">My Albums</a></li>
					<?php echo '<li class="active">' . $user->get_album($_GET['id'])->get_album_title(). '</li>'; ?>										
				<!-- li class="save pull-right visible-lg"><a class="svg" href="javascript:zipFiles()"><img id="saveTopLink"
						class="svg" src="webApp/css/styleImages/save.svg"> &nbsp;&nbsp;&nbsp;&nbsp;Download photos</a></li -->
				</ol>													
				<hr class="hidden-xs">
				<div class="album-info">								
				<?php  $ui_builder->add_album_info_html($_GET['id']); ?>
				</div>
				<span><a class="svg hidden" href="javascript:scrollUp()"
				id="scrollUp"><img src="webApp/css/styleImages/up_hover.svg"></a></span> 
				<span><a class="svg hidden" href="javascript:scrollDown()"
				id="scrollDown"><img src="webApp/css/styleImages/down_hover.svg"></a></span>
			<div id="dotSideScroll">
				<ul class="nav navbar-nav">
					<li id="scrollTop" class="page-scroll hidden"><a
						href="#top"></a></li>
					<li id="scrollToSecondDot" class="page-scroll hidden"><a
						href="#secondDot"></a></li>
					<li id="scrollToThirdDot" class="page-scroll hidden"><a
						href="#thirdDot"></a></li>
					<li id="scrollToFourthDot" class="page-scroll hidden"><a
						href="#fourthDot"></a></li>
					<li id="scrollToFifthDot" class="page-scroll hidden"><a
						href="#footer-bottom"></a></li>
				</ul>
			</div>								 
				<?php $ui_builder->add_album_photos($_GET['id']); ?>
				 <br><br>	
			</div>
		</div>
	</div>
	<?php $ui_builder->add_footer_html();?>

<script type="text/javascript" src="webApp/js/external.min.js"></script>
<script type="text/javascript" src="webApp/js/jquery.magnific-popup.js"></script>
<script type='text/javascript' src='webApp/js/unveil.js'></script>	
<script type='text/javascript' src='webApp/js/album.js'></script>
</body>
</html>