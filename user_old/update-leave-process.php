<?php

session_start();
error_reporting(0);
include("../lib/connection/db-config.php");
include("../lib/class/user-class.php");
$userObj=new user();
  $id = addslashes($_POST['id']);
  $ob = addslashes($_POST['ob']);
  $empid = addslashes($_POST['empid']);

$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];
if($_POST['ltdate']!='') {
    $ltdate = date("Y-m-d", strtotime($_POST['ltdate']));
}
if($_POST['lfdate']!='') {
    $lfdate = date("Y-m-d", strtotime($_POST['lfdate']));
}
$lt = $_POST['lt'];
if($id!=''){
    $result = $userObj->updateEmployeeleave($id,$ob,$ltdate,$comp_id,$user_id,$lfdate,$lt);
}else{
    $result = $userObj->insertEmployeeleave($empid,$ob,$ltdate,$comp_id,$user_id,$lfdate,$lt);
}

?>

