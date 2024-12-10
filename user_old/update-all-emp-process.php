<?php
session_start();
include("../lib/connection/db-config.php");
include("../lib/class/user-class.php");
$userObj=new user();
$fielda=$_POST['fielda'];
$fieldb=$_POST['fieldb'];
$fieldc=$_POST['fieldc'];
$fieldd=$_POST['fieldd'];
$empid=$_POST['empid'];
$texta=$_POST['texta'];
$textb=$_POST['textb'];
$textc=$_POST['textc'];
$textd=$_POST['textd'];
$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];

$rows=$userObj->updateAllemp($empid,$fielda,$fieldb,$fieldc,$fieldd,$texta,$textb,$textc,$textd,$comp_id,$user_id);
header('location:/edit_all_employee');//exit;
?>
<script>
//location.href ="/edit_all_employee";
//return false;
</script>

