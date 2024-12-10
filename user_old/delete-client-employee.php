<?php 
session_start();
//error_reporting(0);
include("../lib/connection/db-config.php");
include("../lib/class/common.php");
$common=new common();
$id=$_POST['id'];
 $result = $common->deleteClientEmployee($id);
?>

