<?php
session_start();
error_reporting(0);
include("../lib/connection/db-config.php");
include("../lib/class/user-class.php");
$userObj=new user();

$id= addslashes($_POST['id']);

$fdate = date("Y-m-d", strtotime($_POST['fdate']));
$tdate = date("Y-m-d", strtotime($_POST['tdate']));

$str = date("Y", strtotime($_POST['fdate']));
$end = date("y", strtotime($_POST['tdate']));
$year = $str. ' - '.$end;


$assyr = addslashes($_POST['assyr']);
$tdsc = addslashes($_POST['tdsc']);
$authp = addslashes($_POST['authp']);
$authd = addslashes($_POST['authd']);
$authmn = addslashes($_POST['authmn']);
$bcrc = addslashes($_POST['bcrc']);
$qcn1 = addslashes($_POST['qcn1']);
$qap1 = addslashes($_POST['qap1']);
$qade1 = addslashes($_POST['qade1']);
$qadp1 = addslashes($_POST['qadp1']);

$qcn2 = addslashes($_POST['qcn2']);
$qap2 = addslashes($_POST['qap2']);
$qade2 = addslashes($_POST['qade2']);
$qadp2 = addslashes($_POST['qadp2']);

$qcn3 = addslashes($_POST['qcn3']);
$qap3 = addslashes($_POST['qap3']);
$qade3 = addslashes($_POST['qade3']);
$qadp3 = addslashes($_POST['qadp3']);

$qcn4 = addslashes($_POST['qcn4']);
$qap4 = addslashes($_POST['qap4']);
$qade4 = addslashes($_POST['qade4']);
$qadp4 = addslashes($_POST['qadp4']);

$prdate = date("Y-m-d", strtotime($_POST['prdate']));



$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];
$result = $userObj->updateCompanydetails($id,$fdate,$tdate,$assyr,$tdsc,$authp,$authd,$authmn,$bcrc,$qcn1,$qap1,$qade1,$qadp1,$qcn2,$qap2,$qade2,$qadp2,$qcn3,$qap3,$qade3,$qadp3,$qcn4,$qap4,$qade4,$qadp4,$prdate,$comp_id,$user_id,$year);

?>

