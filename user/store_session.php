<?php
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', dirname(__FILE__) . '/error_log.txt');
error_reporting(E_ALL);
session_start();
$_SESSION['clintid']=$_POST['clientid'];
$_SESSION['clientid']=$_POST['clientid'];
$_SESSION['month']=$_POST['month_value'];
if(isset($_POST['frdt'])){
$_SESSION['frdt']=$_POST['frdt'];
}
if(isset($_POST['todt'])){
$_SESSION['todt']=$_POST['todt'];
}
//print_r($_SESSION);
?>

