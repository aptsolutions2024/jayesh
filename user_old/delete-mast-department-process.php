<?php
session_start();
error_reporting(0);
include("../lib/connection/db-config.php");
include("../lib/class/user-class.php");
$userObj=new user();
  $did = addslashes($_POST['did']);
  $result = $userObj->deleteDepartment($did);
?>

