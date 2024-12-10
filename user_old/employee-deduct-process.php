<?php

session_start();
//error_reporting(0);
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', dirname(__FILE__) . '/error_log.txt');
error_reporting(E_ALL);
include("../lib/connection/db-config.php");
include("../lib/class/user-class.php");
$userObj=new user();
  $empid = addslashes($_POST['empid']);
  $decaltype = addslashes($_POST['decaltype']);
  $destdamt = addslashes($_POST['destdamt']);
  $destdremark= addslashes($_POST['destdremark']);
  $destid= addslashes($_POST['destid']);
  $selbank= addslashes($_POST['selbank']);
  $comp_id=$_SESSION['comp_id'];
  $user_id=$_SESSION['log_id'];

$result = $userObj->insertEmployeeeduct($empid,$decaltype,$destdamt,$destid, $destdremark,$comp_id,$user_id,$selbank);
?>

