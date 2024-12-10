<?php

session_start();
error_reporting(0);
include("../lib/connection/db-config.php");
include("../lib/class/user-class.php");
$userObj=new user();
  $id = addslashes($_POST['id']);

$empid = addslashes($_POST['empid']);
$income_desc = addslashes($_POST['income_desc']);
$income_amt = addslashes($_POST['income_amt']);
$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];
$yr=$_SESSION['yr'];
if($id!='') {
    $result = $userObj->updateintaxincome($id,$income_desc,$income_amt,$comp_id,$user_id,$yr);

}
else{
    $result = $userObj->insertintaxincome($empid,$income_desc,$income_amt,$comp_id,$user_id,$yr);
}
?>

