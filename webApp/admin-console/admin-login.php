<?php
require_once __DIR__ . '/../classes/Admin/Admin.php';
require_once __DIR__ . '/../classes/ExceptionHandling/ExceptionHandler.php';
require_once __DIR__ . '/../includes/constants.php';

session_start();

use admin\Admin;

error_reporting ( E_ALL );


//If admin is logged in - redirect to admins only base url
if (isset($_SESSION[ADMIN_IS_LOGGED_IN]) ){												
	header('location: '. ADMIN_BASE_URL);
}

/*
 * validate admin credentials if submitted
*/

if ($_POST &&  empty ( $_POST ['username'] ) &&  empty ( $_POST ['password'] )) {
	$ret = 'Please enter your username and password.';
}

if ($_POST && ! empty ( $_POST ['username'] ) &&  empty ( $_POST ['password'] )) {
	$ret = 'Please enter your password.';
}

if ($_POST &&  empty ( $_POST ['username'] ) &&  !empty ( $_POST ['password'] )) {
	$ret = 'Please enter your username.';
}


if ($_POST && ! empty ( $_POST ['username'] ) && ! empty ( $_POST ['password'] )) {

	$username = strtolower(trim($_POST["username"]));
	$password = trim($_POST ['password']);
	
	$ret = Admin::validate_admin_login ( $username, $password );
}
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
<meta property="og:url" content="http://www.photomyne.com" />
<meta property="og:site_name" content="photomyne.com" />
<meta property="fb:admins" content="" />

<!-- FACEBOOK SHARE IMAGE -->
<meta property="og:image" content="" />
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
<meta name="twitter:image" content="" />
<!-- END TWITTER SHARE -->

<link rel="shortcut icon" href="../css/styleImages/favicon.png">

<link rel="stylesheet" type="text/css"
	href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css" />
<link rel="stylesheet" type="text/css" href="../css/font-awesome.min.css">
<link href='https://fonts.googleapis.com/css?family=Lily+Script+One'
	rel='stylesheet' type='text/css'>
<link href='https://cdn.datatables.net/1.10.11/css/dataTables.bootstrap.min.css'
	rel='stylesheet' type='text/css' />

<script type='text/javascript'
	src='//ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js'></script>
<script type='text/javascript' src='../js/external.min.js'></script>
<script type='text/javascript'
	src='//cdn.datatables.net/1.10.4/js/jquery.dataTables.min.js'></script>
<script type='text/javascript'
	src='https://cdn.datatables.net/1.10.11/js/dataTables.bootstrap.min.js'></script>
<style>
tr:hover {
	background-color: #ffff99;
}

th {
	text-align: center;
}

.panel-default {
    border-color: transparent;
}

.panel {
    -webkit-box-shadow: none;
    box-shadow: none;
}
</style>

</head>
<body>

	<div class="jumbotron" style="text-align: center;">
		<div class="container">
			<br>
			<h1>Photomyne Admin</h1>
		</div>
	</div>
	<div class="container">
		<div
			class="col-lg-6 col-lg-offset-3 col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2 col-xs-12">
			<div class="panel panel-default">
				<div class="panel-body">
					<form accept-charset="UTF-8" role="form" method="post" action="">
						<fieldset>
							<div class="form-group">
								<input class="form-control" placeholder="username" name="username"
									type="text">
							</div>
							<div class="form-group">
								<input class="form-control" placeholder="password" name="password"
									type="password">
							</div>
							<?php if(isset($ret)) echo '<h6 style="text-align:center; color:red;">' . $ret . '</h6>'; ?> 
							<br>
							<br> <input class="btn btn-success btn-block" type="submit"
								value="Log in">
						</fieldset>
					</form>				
				</div>
			</div>
		</div>
	</div>
	</div>
</body>
</html>