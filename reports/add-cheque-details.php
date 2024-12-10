<?php
 session_start();

include("../lib/connection/db-config.php");
include("../lib/class/user-class.php");
$empid = $_REQUEST['emp_id'];
$chkdate = $_REQUEST['chkdate'];
 $chkdate = date('Y-m-d',strtotime($chkdate));
$amount = $_REQUEST['amount'];
$check_no = $_REQUEST['check_no'];
$date1 = $_REQUEST['date'];
$userObj=new user();
$i=0;
$curmonth = date('m');
$curyear = date('Y');
//$cmonth = $_REQUEST['$cmonth'];

$clientid = $_SESSION['clintid'];
$resclt=$userObj->displayClient($clientid);
$cmonth=$resclt['current_month'];

	foreach($empid as $emp){
		$chkDtl = $userObj->chkDetails($emp,$cmonth,'S');
		$num = mysql_num_rows($chkDtl);	
		if($num == 0){
			 //$sql="insert into cheque_details(emp_id,check_no,salary_month,amount,date,db_addate) values('".$emp."','".$check_no[$i]."',now(),'".$amount[$i]."','".$chkdate."',now())";	
			 $sql="insert into cheque_details(emp_id,check_no,sal_month,amount,date,type,db_addate) values('".$emp."','".$check_no[$i]."','$cmonth','".$amount[$i]."','".date('Y-m-d',strtotime($date1[$i]))."','S',now())";	
		
		}else{
			//  $sql="update cheque_details set date='".$chkdate."',check_no='".$check_no[$i]."',amount='".$amount[$i]."',salary_month='".$cmonth."', db_update=now() where emp_id='".$emp."' and year(salary_month)='".$curyear."' and month(salary_month) = '".$curmonth."'";	
		   $sql="update cheque_details set date='".date('Y-m-d',strtotime($date1[$i]))."',check_no='".$check_no[$i]."',amount='".$amount[$i]."',sal_month='".$cmonth."', db_update=now() where emp_id='".$emp."' and sal_month='".$cmonth."' and type = 'S'";	
		  
		}
		$row = mysql_query($sql);
		$i++;
	}

?>