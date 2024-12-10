<?php
session_start();
error_reporting(0);
include("../lib/connection/db-config.php");
include("../lib/class/user-class.php");
$userObj=new user();

 $chno = addslashes($_POST['chno']);
$status = addslashes($_POST['status']);

$deposite_date=date("Y-m-d", strtotime($_POST['deposite_date']));
$salmonth=date("Y-m-t", strtotime($_POST['salmonth']));

$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];
$result = $userObj->insertitdeposit($chno,$status,$deposite_date,$salmonth,$comp_id,$user_id);

?>

