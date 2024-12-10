<?php
session_start();
//error_reporting(0);
/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/


include("../lib/class/user-class.php");
$userObj=new user();
  $id = addslashes($_POST['id']);

$empid = addslashes($_POST['empid']);
$allow_name = addslashes($_POST['allow_name']);
$allow_amt = addslashes($_POST['allow_amt']);
$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];
$yr=$_SESSION['yr'];
if($id!='') {
    $result = $userObj->updateintaxallow($id,$allow_name,$allow_amt,$comp_id,$user_id);

}
else{
    $result = $userObj->insertintaxallow($empid,$allow_name,$allow_amt,$comp_id,$user_id,$yr);
}
?>

