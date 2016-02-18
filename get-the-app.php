<?php
require_once __DIR__ . '/webApp/classes/Authentication/LoginHelper.php';
require_once __DIR__ . '/webApp/classes/ExceptionHandling/ExceptionHandler.php';
require_once __DIR__ . '/webApp/classes/UI/UIBuilder.php';
require_once __DIR__ . '/webApp/includes/constants.php';


/*
 * Handle logout procedure and flush session.
*/
if(!(session_status() == PHP_SESSION_NONE) ) {
	session_unset();	
	session_destroy();
}

/*
 * Begin new session.
*/

session_start ();


use UI\UIBuilder;

error_reporting ( E_ALL );


// If user is logged in - redirect to members-only base url
if (isset($_SESSION[CREDENTIALS_LOGIN]) || isset($_SESSION[FB_ACCESS_TOKEN])){												
	header('location: '. MEMBERS_BASE_URL);
}

$ui_builder = new UIBuilder();
?>

<!-- TBD impl & test auto ver -->
<!-- ?php 

function autoVer($url){
	$path = pathinfo($url);
	$ver = '.'.filemtime($_SERVER['DOCUMENT_ROOT'].$url).'.';
	echo $path['dirname'].'/'.str_replace('.', $ver, $path['basename']);
}

include($_SERVER['DOCUMENT_ROOT'].'/path/to/autoVer.php');

? -->
<!-- link rel="stylesheet" href="<!-- ?php autoVer('/webApp/css/style.css'); ?>" type="text/css" />
<script type="text/javascript" src="<!-- ?php autoVer('/scripts/prototype.js'); ?>"></script  -->

<!DOCTYPE html>
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<head>
<meta charset="UTF-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Get Photomyne</title>
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

<link rel="shortcut icon" href="webApp/css/styleImages/favicon.png">

<link rel="stylesheet" type="text/css" href="webApp/css/bootstrap.min.css" />
<link rel="stylesheet" type="text/css"
	href="webApp/css/font-awesome.min.css">
<link href='https://fonts.googleapis.com/css?family=Lily+Script+One'
	rel='stylesheet' type='text/css'>
<link rel="stylesheet" type="text/css" href="webApp/css/login.css" />
<style>
@media (min-width: 1100px){
	.panel-body {
	    margin-bottom:30px;   
	}
}
.btn-success {   
    margin-top: 20px;
}

.panel-body {
    padding-top: 15px;
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
	<div id="login-wrapper">
		<div class="container">
			<div class="row vertical-offset-100">
				<div
					class="col-lg-5 col-lg-offset-3 col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2 col-xs-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							<img class="panel-logo" src="webApp/css/styleImages/Photomyne_circle.png">

							<h4 class="panel-title">Get the App!</h4>
						</div>
						<div class="panel-body">

							<p>Oh, hello! New to Photomyne?</p>
							<p> Photomyne lets you rediscover precious moments of your past, 
							save them and share them with the ones you love.</p>
							<p>Download the app and start scanning memories.</p>
							<br><br>
							<a href="https://app.appsflyer.com/id1037784828?pid=PhotomyneSharePage" 
							target="_blank" class="btn btn-success btn-block"
							onclick="ga('send', 'event', 'get-the-app-page', 'get-app-button', 'click');">Get the app for free</a>														
						</div>
						<div class="panel-footer">
							<a href="http://www.photomyne.com/"
								onclick="ga('send', 'event', 'get-the-app-page', 'close-panel-button', 'click');">Close</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script type='text/javascript' src='webApp/js/jquery-11.0.min.js'></script>
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
</script>
</body>
</html>