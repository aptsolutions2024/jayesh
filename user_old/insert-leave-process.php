<?php

session_start();
error_reporting(0);
include("../lib/connection/db-config.php");
include("../lib/class/user-class.php");
$userObj=new user();
  $id = addslashes($_POST['id']);
  $ob = addslashes($_POST['ob']);
  $lt = addslashes($_POST['lt']);
  $ason = addslashes($_POST['ason']);
  $empid = addslashes($_POST['empid']);
  $leayear = addslashes($_POST['leayear']);
$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];
if($id!=''){
    $result = $userObj->updateEmployeeleave($id,$ob,$leayear,$comp_id,$user_id,$ason,$lt);
}else{
    $result = $userObj->insertEmployeeleave($empid,$ob,$leayear,$comp_id,$user_id,$ason,$lt);
}

?>

