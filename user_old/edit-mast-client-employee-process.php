<?php 
session_start();
//error_reporting(0);
include("../lib/connection/db-config.php");
include("../lib/class/common.php");
$common=new common();

$client = $_POST['client'];
$design = $_POST['design'];
$noofemployee = $_POST['noofemployee'];
$id=$_POST['rid'];
$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];

 $result = $common->updateClientEmployee($client,$design,$noofemployee,$id);
?>

