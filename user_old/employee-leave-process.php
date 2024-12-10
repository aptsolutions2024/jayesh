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
  $ob = addslashes($_POST['ob']);
  if($_POST['ltdate']!='') {
      $ltdate = date("Y-m-d", strtotime($_POST['ltdate']));
  }
  if($_POST['lfdate']!='') {
      $lfdate = date("Y-m-d", strtotime($_POST['lfdate']));
  }
  $lt = addslashes($_POST['lt']);

$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];
$result = $userObj->insertEmployeeleave($empid,$ob,$ltdate,$comp_id,$user_id,$lfdate,$lt);
?>

