<?php
session_start();
error_reporting(0);
include("../lib/connection/db-config.php");
include("../lib/class/user-class.php");
$userObj=new user();
  $bid = addslashes($_POST['bid']);
  $name = addslashes(strtoupper($_POST['name']));
 $add = addslashes($_POST['add']);
$branch= addslashes($_POST['branch']);
$pincode = addslashes($_POST['pincode']);
$city = addslashes($_POST['city']);
$ifsccode = addslashes($_POST['ifsccode']);
$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];

$result = $userObj->updateBank($bid,$name,$add,$branch,$pincode,$city,$ifsccode,$comp_id,$user_id);



	 ?>

