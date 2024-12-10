<?php
include_once($_SERVER['DOCUMENT_ROOT']."/lib/class/user-class.php");
$userObj=new user();
$to = addslashes($_POST['emailaddress']);
$keydata = rand(0,10000000000);
$authkey = base64_encode($keydata);
$userObj->insertAuthkey($to,$authkey);
$subject = 'Forgot Password';

$headers = "From: developer.vilas@gmail.com\r\n";

$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=UTF-8\r\n";

$message = '<div>Hello User,<br>For reset your password <a href="http://aptsolutions.in/?authkey='.$authkey.'">Click Here </a></div>';


mail($to, $subject, $message, $headers);

?>