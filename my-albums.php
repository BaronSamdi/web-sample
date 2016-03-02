<?php


require_once __DIR__ . '/webApp/classes/Authentication/LoginHelper.php';
require_once __DIR__ . '/webApp/classes/UserInfo/PremiumUser.php';
require_once __DIR__ . '/webApp/classes/UI/UIBuilder.php';
require_once __DIR__ . '/webApp/includes/constants.php';
require_once __DIR__ . '/webApp/classes/ExceptionHandling/ExceptionHandler.php';


session_start();

use login\LoginHelper;
use UserInfo\PremiumUser;
use UI\UIBuilder;

error_reporting(E_ALL);

$loginHelper = false;
$user = false;

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
<title>My Photomyne Albums</title>
<meta name="description"
	content="Scan photos in minutes. Save your memories forever." />
<meta name="keywords" content="" />
<meta name="author" content="photomyne.com">

<!-- FACEBOOK SHARE DATA -->
<meta property="og:title" content="photomyne.com" />
<meta property="og:description"
	content=" Scan photos in minutes. Save your memories forever." />
<meta property="og:type" content="website" />
<meta property="og:url"
	content="http://www.photomyne.com" />
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

<link rel="shortcut icon" href="webApp/css/styleImages/favicon.png" />
<link rel="stylesheet" type="text/css" 
	href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css" />
<link rel="stylesheet" type="text/css"
	href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
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
    background: -moz-linear-gradient(top,  rgba(78,78,78,0) 0%, rgba(0,0,0,0.8) 100%); /* FF3.6-15 */
	background: -webkit-linear-gradient(top,  rgba(78,78,78,0) 0%,rgba(0,0,0,0.8) 100%); /* Chrome10-25,Safari5.1-6 */
	background: linear-gradient(to bottom,  rgba(78,78,78,0) 0%,rgba(0,0,0,0.8) 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#004e4e4e', endColorstr='#a6000000',GradientType=0 ); /* IE6-9 */
    background-size: auto 200%;
    background-position: 0 0%;
    transition: background-position 0.5s;    
    opacity: 1;
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
	background-position: 0 100%;   
}
@media screen and (max-width: 767px){	
				
	.caption-wrapper .caption-content {
	   	background: -moz-linear-gradient(top,  rgba(78,78,78,0) 0%, rgba(0,0,0,0.65) 100%); /* FF3.6-15 */
		background: -webkit-linear-gradient(top,  rgba(78,78,78,0) 0%,rgba(0,0,0,0.65) 100%); /* Chrome10-25,Safari5.1-6 */
		background: linear-gradient(to bottom,  rgba(78,78,78,0) 0%,rgba(0,0,0,0.65) 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
		filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#004e4e4e', endColorstr='#a6000000',GradientType=0 ); /* IE6-9 */ 
		border: none;  
		border-right:solid 12px #fff;
		border-left:solid 12px #fff;
		border-top:solid 2px #fff;
		border-bottom:solid 2px #fff;
		margin-bottom: 4px;	
		padding: 0 18px;
	}		
	.grid li {	   
	    width: 100%;
	    padding-top:0px;
	    padding-bottom:0px;
	    padding: 0px 0px 0px 0px;
	}				
	.container.grid-container{
		padding-right: 0px;
	    padding-left: 0px;
	    width: 100vw;	    
	}
}
</style>
</head>
<body>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-59148541-1', 'auto');
  ga('send', 'pageview');

</script>
			
			<?php echo $ui_builder->add_member_pages_header_html("my-albums") ?>
			<div class="sub-header">
				<ol class="breadcrumb hidden-xs">
					<li><a href="http://www.photomyne.com/" onClick="ga('send', 'event', 'my-albums-page', 'home-breadcrumb' , 'click');">Home</a></li>
					<li class="active">My Albums</li>										
				</ol>
				
				<hr class="hidden-xs">
				<div class="album-info">
				<h1 style="text-align:center;">My Albums (<?php if($user != false)echo $user->get_number_of_albums(); ?>)</h1>
				</div>				
				 <?php $ui_builder->add_albums_html();?>
				 <br><br>	
			</div>
		</div>
	</div>
	<?php $ui_builder->add_footer_html();?>	
	<script type='text/javascript' src="webApp/js/external.min.js"></script>
	<script type="text/javascript">
//Fix for Facebook login bug that concats #_=_ to url
 if (window.location.hash && window.location.hash == '#_=_') {
     if (window.history && history.pushState) {
         window.history.pushState("", document.title, window.location.pathname);
     } else {
         // Prevent scrolling by storing the page's current scroll offset
         var scroll = {
             top: document.body.scrollTop,
             left: document.body.scrollLeft
         };
         window.location.hash = '';
         // Restore the scroll offset, should be flicker free
         document.body.scrollTop = scroll.top;
         document.body.scrollLeft = scroll.left;
     }
 }


 
function toggleMobileDropdown() {
		
	 $("#mobile-logout").animate({
	        height: 'toggle',
	 	}, {
	     duration: 200,         
	    });			
}
	
// preloader
	$(window).load(function() {
		$('#stat').fadeOut();
		$('#preloader').delay(350).fadeOut('slow');
	});					

	new AnimOnScroll( document.getElementById( 'grid' ), {
		minDuration : 0.4,
		maxDuration : 0.7,
		viewportFactor : 0.2
	} );
	
					
	
</script>

</body>
</html>