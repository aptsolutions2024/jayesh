<?php
session_start();
error_reporting(0);
include("../lib/connection/db-config.php");
include("../lib/class/user-class.php");
$userObj=new user();
  $empid = addslashes($_POST['empid']);
  $advamt = addslashes($_POST['advamt']);
  $advins = addslashes($_POST['advins']);
if($_POST['advdate']!='') {
    $advdate = date("Y-m-d", strtotime($_POST['advdate']));
}
else{
    $advdate=addslashes($_POST['advdate']);
}

  $advtype = addslashes($_POST['advtype']);
$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];


$result = $userObj->insertEmployeeadvances($empid,$advamt,$advins,$comp_id,$user_id,$advdate,$advtype);
?>

