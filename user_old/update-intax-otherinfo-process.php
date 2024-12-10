<?php

session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include("../lib/connection/db-config.php");
include("../lib/class/user-class.php");
$userObj=new user();


$empid = addslashes($_POST['empid']);
$hsg_intrest = addslashes($_POST['hsg_intrest']);
$ccc = addslashes($_POST['ccc']);
$ccd = addslashes($_POST['ccd']);$ccf = addslashes($_POST['ccf']);
$relief_89 = addslashes($_POST['relief_89']);
$taxbenefit_87 = addslashes($_POST['taxbenefit_87']);
$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];
$yr=$_SESSION['yr'];
    $result = $userObj->insertotherinfo($empid,$yr,$hsg_intrest,$ccc,$ccd,$ccf,$taxbenefit_87,$relief_89,$comp_id,$user_id);

?>

