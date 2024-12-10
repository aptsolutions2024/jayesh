<?php

session_start();
error_reporting(0);
include("../lib/connection/db-config.php");
include("../lib/class/user-class.php");
$userObj=new user();
 $id = addslashes($_POST['id']);
  $empid = addslashes($_POST['empid']);
  $caltype = addslashes($_POST['caltype']);
  $stdamt = addslashes($_POST['stdamt']);
$incomeid = addslashes($_POST['incomeid']);
$inremark = addslashes($_POST['inremark']);
$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];
if($id!='') {
    $result = $userObj->updateEmployeeincome($id, $caltype, $stdamt,$incomeid,$inremark,$comp_id,$user_id);

}
else{

    $result = $userObj->insertEmployeeincome($empid,$caltype,$stdamt,$incomeid,$inremark,$comp_id,$user_id);
}
?>

