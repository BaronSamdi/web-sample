<?php
//add the recipient address here
$myemail = 'support@photomyne.com';
 
//grab named inputs from html
if (isset($_POST['email'])) {
$email = strip_tags($_POST['email']);
$subject = strip_tags($_POST['subject']);
 
//generate email and send
$to = $myemail;
$email_subject = $subject;
$email_body = "Photomyne support Email:\n\n".
$headers .= "Reply-To: $email";
mail($to,$email_subject,$email_body,$headers);
}
