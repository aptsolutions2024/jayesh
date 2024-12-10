<?php
session_start();
error_reporting(0);
//include("../lib/connection/db-config.php");
include("../lib/class/user-class.php");
$userObj=new user();

 $id = addslashes($_POST['id']);
 $chno = addslashes($_POST['chno']);
$status = addslashes($_POST['status']);

$deposite_date=date("Y-m-d", strtotime($_POST['deposite_date']));
$salmonth=date("Y-m-d", strtotime($_POST['salmonth']));

$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];
$result = $userObj->updateitdeposit($id,$chno,$status,$deposite_date,$salmonth,$comp_id,$user_id);

?>

