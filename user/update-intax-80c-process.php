<?php

session_start();
error_reporting(0);
include("../lib/connection/db-config.php");
include("../lib/class/user-class.php");
$userObj=new user();
  $id = addslashes($_POST['id']);

$empid = addslashes($_POST['empid']);
$c_desc = addslashes($_POST['c_desc']);
$c_amt = addslashes($_POST['c_amt']);
$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];
$yr=$_SESSION['yr'];
if($id!='') {
    $result = $userObj->updateintaxc($id,$c_desc,$c_amt,$comp_id,$user_id);

}
else{
    $result = $userObj->insertintaxc($empid,$c_desc,$c_amt,$comp_id,$user_id,$yr);
}
?>

