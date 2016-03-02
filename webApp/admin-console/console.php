<?php
require_once __DIR__ . '/../classes/Admin/Admin.php';
require_once __DIR__ . '/../classes/ExceptionHandling/ExceptionHandler.php';
require_once __DIR__ . '/../includes/constants.php';

session_start();

use admin\Admin;

error_reporting ( E_ALL );


//If admin is not logged in - redirect to admin log in page
if (!isset($_SESSION[ADMIN_IS_LOGGED_IN]) ){												
	header('location: '. ADMIN_LOGIN_URL);
}

if ($_POST && ! empty ( $_POST ['userID'] ) ) {

	$userID = trim($_POST["userID"]);
	header('location: '. ADMIN_BASE_URL . '?userID='.$userID);

}


else if ($_POST && ! empty ( $_POST ['email'] ) ) {
	
	$email = strtolower(trim($_POST["email"]));
	header('location: '. ADMIN_BASE_URL . '?email='.$email);
	
}

else if ($_POST && ! empty ( $_POST ['name'] )) {
	//$name = trim($_POST["name"]);
	//header('location: '. ADMIN_BASE_URL . '?name='.$name);	
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

<link rel="shortcut icon" href="../css/styleImages/favicon.png">

<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css" />
<link rel="stylesheet" type="text/css"
	href="../css/font-awesome.min.css">
<link href='//fonts.googleapis.com/css?family=Lily+Script+One' rel='stylesheet' type='text/css'>
<link href='//cdn.datatables.net/1.10.11/css/jquery.dataTables.min.css' rel='stylesheet' type='text/css'/>

<script type='text/javascript' src='//ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js'></script>
<script type='text/javascript' src='../js/external.min.js'></script>
<script type='text/javascript' src='//cdn.datatables.net/1.10.4/js/jquery.dataTables.min.js'></script>

<style>
body {    
    min-height: 96vh;
}


tr.inner,
tr.inner.odd,
tr.inner.even
{
	-webkit-transition: all 0.3s;
    -moz-transition: all 0.3s;
    -o-transition: all 0.3s;
    transition: all 0.3s;
}

tr.inner:hover,
tr.inner.odd:hover,
tr.inner.even:hover,
table.dataTable.stripe tbody tr.odd:hover, table.dataTable.display tbody tr.odd:hover,
table.dataTable.stripe tbody tr.even:hover, table.dataTable.display tbody tr.even:hover {
	background-color: #ffff99;
	-webkit-transition: all 0.3s;
    -moz-transition: all 0.3s;
    -o-transition: all 0.3s;
    transition: all 0.3s;
}

th {
    text-align: left;
    background-color: #b4b4b4;
}
</style>

</head>
<body>

<div class="jumbotron" style="text-align:center;">
	<div class="container">              
		<br>		
		<div class="row" style="text-align:center;">
			<form accept-charset="UTF-8" role="form" method="post" action="">
				<fieldset>
					<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
						<div class="form-group">
							<input class="form-control" placeholder="userID" name="userID"
						type="text">
						</div>
					</div>
					<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
						<div class="form-group">
							<input class="form-control" placeholder="E-mail" name="email"
								type="email">
						</div>
					</div> 
					<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
						<div class="form-group">
							<input class="form-control" placeholder="name" name="name"
								type="text">
						</div>
					</div>
					<br>
					<div class="row" style="text-align:center;">
						<div class="col-lg-4 col-lg-offset-4 col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 col-xs-12">
							<input class="btn btn-success btn-block" type="submit"
								value="Search">	
						</div>
					</div> 
				</fieldset> 
			</form>
		</div>		   
	</div>
</div>

            
<?php 
	if(isset($_GET['email'])){
		Admin::get_Admin_Info_By_Email(trim($_GET['email']));
	}
	else if(isset($_GET['userID'])){
		Admin::get_Admin_Info_By_userID(trim($_GET['userID']));
	}
	else if(isset($_GET['name'])){
		Admin::get_Admin_Info_By_Name($_GET['name']);
	}
	else echo '<div class="container">
						<div class="row">
						<h2 style="text-align:center;">Ready To Go</h2>
						
					</div></div>';						
?>
<br><br>
</body>
</html>