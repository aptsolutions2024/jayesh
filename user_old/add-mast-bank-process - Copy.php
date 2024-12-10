<?php
session_start();
error_reporting(0);
include("../lib/connection/db-config.php");
include("../lib/class/user-class.php");
$userObj=new user();
  $name = $_POST['name'];
 $add = $_POST['add'];
$branch = $_POST['branch'];
$pincode = $_POST['pincode'];
$city = $_POST['city'];
$ifsccode = $_POST['ifsccode'];
$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];
  $result = $userObj->insertBank($name,$add,$branch,$pincode,$city,$ifsccode,$comp_id,$user_id);



	 ?>

