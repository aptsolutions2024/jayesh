<?php
 include("../lib/connection/db-config.php");
include("../lib/class/user-class.php");
session_start();
$comp_id=$_SESSION['comp_id'];
$userObj=new user();
$client_id = $_POST['clientid'];
$wagediff = 0;
$allowdiff= 0;
$otdiff = 0;
	$sql = "select distinct  ti.std_amt from tran_income ti inner join tran_days td  on td.emp_id = ti.emp_id  where( ti.head_id = 46  OR  ti.head_id = 50) and td.client_id =  '$client_id'";
	
	
	$row =  mysql_query($sql);
	$row1 = mysql_fetch_array ($row);
	$wagediff = $row1['std_amt'];
	
	 $sql = "select distinct  ti.std_amt from tran_income ti inner join tran_days td  on td.emp_id = ti.emp_id  where (ti.head_id = 45 OR ti.head_id = 52 )and td.client_id =  '$client_id'";
	$row2 =  mysql_query($sql);
	$row21 = mysql_fetch_array ($row2);
	$allowdiff = $row21['std_amt'];
	
	$sql = "select distinct  ti.std_amt from tran_income ti inner join tran_days td  on td.emp_id = ti.emp_id  where (ti.head_id = 44 or ti.head_id = 58 )  and td.client_id =  '$client_id'";
	$row3 =  mysql_query($sql);
	$row31 = mysql_fetch_array ($row3);
	$otdiff = $row31['std_amt'];
	
	
	


echo $wagediff.",".$allowdiff.",".$otdiff  ;

?>