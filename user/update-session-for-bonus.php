<?php
session_start();
include("../lib/connection/db-config.php");
include("../lib/class/user-class.php");
$userObj=new user();
//error_reporting(0);
 $_POST['startbonusyear'];
 $_POST['endbonusyear'];
if($_POST['startbonusyear'] !=""){
/*echo $sql = "SELECT LAST_DAY('".date('Y-m-d',strtotime($_POST['startbonusyear']))."') AS last_day";
$row= mysql_query($sql);
$row1 = mysql_fetch_assoc($row);*/
  $startday = $userObj->getFirstDay($_POST['startbonusyear']);
 print_r($startday);
	
$startday = date('Y-m-d',strtotime($_POST['startbonusyear']));
}
if($_POST['endbonusyear'] !=""){
	
/*echo $sql = "SELECT LAST_DAY('".date('Y-m-d',strtotime($_POST['endbonusyear']))."') AS last_day";
$row= mysql_query($sql);
$row1 = mysql_fetch_assoc($row);
	
echo $endday = date('Y-m-d',strtotime($row1['last_day']));*/
echo $endday = $userObj->getLastDay1($_POST['endbonusyear']);
print_r($endday);
$endday = date('Y-m-d',strtotime($_POST['endbonusyear']));
}

$_SESSION['startbonusyear'] = $startday;
$_SESSION['endbonusyear'] = $endday;
?>