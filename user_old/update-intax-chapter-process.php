<?php

session_start();
error_reporting(0);
include("../lib/connection/db-config.php");
include("../lib/class/user-class.php");
$userObj=new user();
  $id = addslashes($_POST['id']);

$empid = addslashes($_POST['empid']);
$section_name = addslashes($_POST['section_name']);
$gross_amt = addslashes($_POST['gross_amt']);
$deduct_amt = addslashes($_POST['deduct_amt']);
$qual_amt = addslashes($_POST['qual_amt']);
$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];
$yr=$_SESSION['yr'];
if($id!='') {
    $result = $userObj->updateintaxchapter($id,$section_name,$gross_amt,$qual_amt,$deduct_amt,$comp_id,$user_id);

}
else{
    $result = $userObj->insertintaxchapter($empid,$section_name,$gross_amt,$qual_amt,$deduct_amt,$comp_id,$user_id,$yr);
}
?>

