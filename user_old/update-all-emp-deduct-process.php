<?php

session_start();

include("../lib/connection/db-config.php");
include("../lib/class/user-class.php");
$userObj=new user();

$emp_de_id=$_POST['emp_de_id'];
$texta=$_POST['texta'];

$textc=$_POST['textc'];
$caltype=$_POST['caltype'];
$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];
 $rows=$userObj->updateAllempeduct($emp_de_id,$texta,$caltype,$textc,$comp_id,$user_id);
header('location:/edit_all_employee');exit;
?>

