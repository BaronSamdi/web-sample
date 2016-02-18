<?php
require_once __DIR__ . '/webApp/classes/Authentication/LoginHelper.php';
require_once __DIR__ . '/webApp/classes/ExceptionHandling/ExceptionHandler.php';
require_once __DIR__ . '/webApp/classes/UI/UIBuilder.php';
require_once __DIR__ . '/webApp/includes/constants.php';

session_start ();

use login\LoginHelper;
use UI\UIBuilder;

error_reporting ( E_ALL );


// If user is logged in - redirect to members-only base url
if (isset($_SESSION[CREDENTIALS_LOGIN]) || isset($_SESSION[FB_ACCESS_TOKEN])){												
	header('location: '. MEMBERS_BASE_URL);
}

$loginHelper;

if(isset($_SESSION['loginHelper'])){
	$loginHelper =  unserialize($_SESSION['loginHelper']);
}
else{
	$loginHelper = new LoginHelper();
	$_SESSION['loginHelper'] = serialize($loginHelper);
}


$ui_builder = new UIBuilder();

/*
 * validate user credentials if submitted If validtaed - We will set the userID, 
 * name and Email to session vars and redirect to members only base url.
 */

if ($_POST &&  empty ( $_POST ['email'] ) &&  empty ( $_POST ['password'] )) {
	$ret = 'Please enter your email and password.';
}

if ($_POST && ! empty ( $_POST ['email'] ) &&  empty ( $_POST ['password'] )) {
	$ret = 'Please enter your password.';
}

if ($_POST &&  empty ( $_POST ['email'] ) &&  !empty ( $_POST ['password'] )) {
	$ret = 'Please enter your email.';
}


if ($_POST && ! empty ( $_POST ['email'] ) && ! empty ( $_POST ['password'] )) {
	
	$email = trim($_POST["email"]);
	
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
	  $ret = "Please enter a valid email."; 
	}
	
	else
		$ret = $loginHelper->validate_User_Credentials ( $email, trim($_POST ['password']) );
}

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
<title>My Photomyne</title>
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
</head>
<style>

p{
	color: #666666;
	font-size:16px;
}

p.get-app-p{
	margin-top:30px;
}

@media screen and (max-width:991px){

	p.get-premium-p{
		margin-top:30px;
	}
	
	p.get-app-p{
		margin-top:10px;
	}
}

a.login-p{
	color:#5fad9f;
	font-size:16px;
}

.panel-footer a.login-p{
	color:#5fad9f;
	font-size:16px;
}

.panel-footer a.login-p.close-btn{
	color:#999999;
	font-size:16px;
	padding-bottom:10px;
}

.panel-title {
    margin-top: 20px;
    font-size: 16px;
    margin-bottom: 25px;
}

.btn-success {
    margin-bottom: 0px;
 }
</style>
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
					class="col-lg-6 col-lg-offset-3 col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2 col-xs-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							<img  class="panel-logo" src="webApp/css/styleImages/Photomyne_circle.png" >

							<h4 class="panel-title">Premium members area</h4>

			    	<p>Are you a Premium user? Log into your Photomyne account to view your scanned albums.</p>			    	
			    	
			    	<p class="visible-md visible-lg">Don’t have a Premium account?<a target="_blank" class="login-p" href="https://medium.com/@Photomyne/what-is-the-premium-subscription-a8388fecfc3a#.ro8abycjn">&nbsp;Upgrade now</a></p>
			    			
			    	<a href="<?php echo $loginHelper->get_Facebook_Login_URL() ;?>" onclick="ga('send', 'event', 'login-page', 'FB-login', 'click');" class="btn btn-primary btn-block"  value="Log in" >
			    	<span class="icon-FBlogo"></span>Log in with Facebook</a>
							<img style="margin-top:30px;" src="webApp/css/styleImages/Or.png">
						</div>
						<div class="panel-body">

							<form accept-charset="UTF-8" role="form" method="post" action="">
								<fieldset>
									<div class="form-group">
										<input class="form-control" placeholder="E-mail" name="email"
											type="email">
									</div>
									<div class="form-group">
										<input class="form-control" placeholder="Password" name="password"
											type="password" value="">
									</div>									
		                			<?php if(isset($ret)) echo '<h6 class="error-msg">' . $ret . '</h6>'; ?> 	
			    					<br>
									 
									<input class="btn btn-success btn-block" type="submit"
										value="Log in" onsubmit="submit_func();">																			
								</fieldset>
							</form>
						</div>
						<div class="panel-footer">
							<a class="login-p close-btn" href="http://www.photomyne.com/"
										onclick="ga('send', 'event', 'login-page', 'close-panel-button', 'click');">Close</a>
							
							<p class="visible-xs visible-sm get-premium-p">Don’t have a Premium account?<a class="login-p" href="photomyne://subscribe">&nbsp;Upgrade now</a></p>
							<p class="get-app-p">Don’t have the Photomyne app?<a class="login-p" target="_blank" href="https://app.appsflyer.com/id1037784828?pid=webAppLoginPage">&nbsp;Download here</a></p>
							<p>Any questions?&nbsp;<a class="login-p" href="mailto:supportr@photomyne.com">Contact us</a></p>
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

 function  submit_func(){
	 ga('send', 'event', 'login-page', 'credentials-login', 'click');
}
</script>
</body>
</html>