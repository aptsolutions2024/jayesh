<?php
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', dirname(__FILE__) . '/error_log.txt');
error_reporting(E_ALL);
include("../lib/connection/db-config.php");
include("../lib/class/user-class.php");
//include("../lib/connection/db-config.php");
$userObj=new user();
$id = $_POST['id'];
echo $num = $userObj->delCheckDetails($id);

?>