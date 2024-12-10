<?php
session_start();
error_reporting(0);
include("../lib/connection/db-config.php");
include("../lib/class/user-class.php");
$userObj=new user();
  $cid = addslashes($_POST['cid']);
  $result = $userObj->deleteClient($cid);
?>

