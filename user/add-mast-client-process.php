<?php
session_start();
error_reporting(0);
include("../lib/connection/db-config.php");
include("../lib/class/user-class.php");
$userObj=new user();
$name = addslashes(strtoupper($_POST['name']));
 $add1 = addslashes($_POST['add1']);
$esicode = addslashes($_POST['esicode']);
$pfcode = addslashes($_POST['pfcode']);
$tanno = addslashes($_POST['tanno']);
$panno = addslashes($_POST['panno']);
$gstno = addslashes($_POST['gstno']);
$sc = addslashes($_POST['sc']);
$email= $_POST['email'];
$mont=date("Y-m-d", strtotime($_POST['cm']));
$parent=addslashes($_POST['parent']);
$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];
$result = $userObj->insertClient($name,$add1,$esicode,$pfcode,$tanno,$panno,$gstno,$mont,$parent,$comp_id,$user_id,$sc,$email);

?>

