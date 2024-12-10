<?php
session_start();
error_reporting(0);
include("../lib/connection/db-config.php");
include("../lib/class/user-class.php");
$userObj=new user();

  $empid = addslashes($_POST['empid']);
  $id = addslashes($_POST['id']);
  $advamt = addslashes($_POST['advamt']);
  $advins = addslashes($_POST['advins']);
$advdate = date("Y-m-d", strtotime($_POST['advdate']));
$advtype = addslashes($_POST['advtype']);
$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];
//  if($id!='') {
      $result = $userObj->updateEmployeeadvances($id, $advamt, $advins,$comp_id,$user_id,$advdate,$advtype);
  /*}else{
      $result = $userObj->insertEmployeeadvances($empid,$advamt,$advins,$comp_id,$user_id);
  }*/
?>

