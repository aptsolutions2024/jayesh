<?php
session_start();
error_reporting(0);
include("../lib/connection/db-config.php");
include("../lib/class/user-class.php");
$userObj=new user();
$name = addslashes(strtoupper($_POST['name']));
$did = addslashes($_POST['did']);
$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];
$result = $userObj->updateDepartment($did,$name,$comp_id,$user_id);
?>

