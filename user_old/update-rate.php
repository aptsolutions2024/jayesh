<?php error_reporting(0);
 $desgid=$_POST['desgid'];
$cid= $_POST['cid'];
 $rate = $_POST['rate']; 
include("../lib/connection/db-config.php");
 $sql = "update client_employee set rate=$rate where design_id=$desgid and client_id in($cid) limit 1";
mysql_query($sql);

?>