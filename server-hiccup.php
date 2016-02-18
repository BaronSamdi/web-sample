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
<link href="https://fonts.googleapis.com/css?family=Lily+Script+One"
	rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="webApp/css/login.css" />
<style>
.btn-success {   
    margin-top: 20px;
}

h1, .h1 {
    font-size: 30px;
    margin-top: 10px;
    margin-bottom: 0px;
}

.panel-body {
    padding-top: 10px;
}

p{
	color: #666666;
	font-size:16px;
}

p.get-app-p{
	margin-top:30px;
}

a.login-p{
	color:#5fad9f;
	font-size:16px;
}

.panel-footer a.login-p{
	color:#5fad9f;
	font-size:16px;
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
					class="col-lg-6 col-lg-offset-3 col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2 col-xs-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							<img  class="panel-logo" src="webApp/css/styleImages/Photomyne_circle.png">

							<h4 class="panel-title">Photomyne</h4>
						</div>
						<div class="panel-body">
							<h1>Oh, Snap!</h1><h1>Server hiccup.</h1>
							<br>
							<p>An unexpected server error occurred.</p><p>It's not you - it's us :)</p>
							<br><br>							
							<a class="btn btn-success btn-block" 
							href="http://www.photomyne.com/my-albums.php"
							onclick="ga('send', 'event', 'server-hiccup-page', 'back-to-photomyne-button', 'click');">Back to Photomyne</a>														
						</div>
						<div class="panel-footer">
							<a href="http://www.photomyne.com/my-albums.php" 
								onclick="ga('send', 'event', 'server-hiccup-page', 'close-panel-button', 'click');">Close</a>
							<p class="get-app-p" >If this persists&nbsp;<a class="login-p" href="mailto:supportr@photomyne.com">contact support</a></p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript" src="webApp/js/jquery-11.0.min.js"></script>
	<script type="text/javascript" src="webApp/js/external.min.js"></script>
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