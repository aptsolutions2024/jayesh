<?php
session_start();
error_reporting(0);
include("../lib/connection/db-config.php");
include("../lib/class/user-class.php");
$userObj=new user();
$name = addslashes(strtoupper($_POST['name']));
$id = $_POST['id'];
$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];
$result = $userObj->updateAdvancetype($id,$name,$comp_id,$user_id);
?>

