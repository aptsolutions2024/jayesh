<?php
session_start();
   $comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];

error_reporting(0);
include("../lib/connection/db-config.php");
include("../lib/class/user-class.php");
$userObj=new user();
  $id = addslashes($_POST['id']);
  $result = $userObj->deleteintax($id,$comp_id,$user_id);
?>

