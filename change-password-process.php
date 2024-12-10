<?php
include_once($_SERVER['DOCUMENT_ROOT']."/lib/class/user-class.php");
$userobj = new user(); 
/*ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', dirname(__FILE__) . '/error_log.txt');
error_reporting(E_ALL);*/ 

$id=addslashes($_POST['id']);
$username=addslashes($_POST['username']);
$password=addslashes($_POST['password']);
$userobj->updatePass($username,$password,$id);

	 ?>

