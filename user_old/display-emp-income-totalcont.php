<?php
include("../lib/connection/db-config.php");
include("../lib/class/user-class.php");
$userObj=new user();
$id = $_POST['id'];


echo $gettotalincomeCont=$userObj->getsumTotalCont($id);

?>