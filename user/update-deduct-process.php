<?php

session_start();
error_reporting(0);
include("../lib/connection/db-config.php");
include("../lib/class/user-class.php");
$userObj=new user();
  $id = $_POST['id'];
  $decaltype = addslashes($_POST['decaltype']);
  $destdamt= addslashes($_POST['destdamt']);
$empid = addslashes($_POST['empid']);

$destdremark = addslashes($_POST['destdremark']);
$destid = addslashes($_POST['destid']);
$selbank = addslashes($_POST['selbank']);

$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];
if($id!='') {
    $result = $userObj->updateEmployeeeduct($id,$decaltype,$destdamt,$destid, $destdremark,$comp_id,$user_id,$selbank);
}
else{
    $result = $userObj->insertEmployeeeduct($empid,$decaltype,$destdamt,$destid, $destdremark,$comp_id,$user_id,$selbank);
}
?>

