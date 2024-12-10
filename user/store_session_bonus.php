<?php
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
$_SESSION['days']=$_POST['days'];

print_r($_SESSION);
?>

