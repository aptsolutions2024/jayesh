<?php
//include("../lib/connection/db-config.php");
include("../lib/class/user-class.php");
$id = $_POST['id'];
$amt = $_POST['amt'];
$checkno = $_POST['checkno'];
$userObj=new user();
 //$sql = "update cheque_details set check_no='".$checkno."',amount='".$amt."' where chk_detail_id='".$id."'";
 $userObj->updateChkDetails($checkno,$amt,$id);

?>