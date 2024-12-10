<?php
session_start();
//error_reporting(0);
/*ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', dirname(__FILE__) . '/error_log.txt');
error_reporting(E_ALL);*/
include("../lib/class/user-class.php");
$userObj=new user();
$name = addslashes(strtoupper($_POST['name']));
$id = addslashes($_POST['id']);
$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];
$result = $userObj->updateLeavetype($id,$name,$comp_id,$user_id);
?>

