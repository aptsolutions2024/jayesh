<?php
session_start();
//error_reporting(0);
include("../lib/connection/db-config.php");
include("../lib/class/leave.php");
$leave=new leave();
  $id = addslashes($_POST['id']);
  $result = $leave->deleteleaverecord($id);
?>

