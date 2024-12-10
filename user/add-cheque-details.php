<?php
 session_start();
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', dirname(__FILE__) . '/error_log.txt');
error_reporting(E_ALL);
include("../lib/connection/db-config.php");
include("../lib/class/user-class.php");
$empid = $_POST['emp_id'];
$chkdate = $_POST['chkdate'];
 $chkdate = date('Y-m-d',strtotime($chkdate));
$amount = $_POST['amount'];
$check_no = $_POST['check_no'];
$date1 = $_POST['date'];
$userObj=new user();
$i=0;
$curmonth = date('m');
$curyear = date('Y');
//$cmonth = $_POST['$cmonth'];

$clientid = $_SESSION['clintid'];
$resclt=$userObj->displayClient($clientid);
$cmonth=$resclt['current_month'];

	foreach($empid as $emp){
		$chkDtl = $userObj->chkDetails($emp,$cmonth,'S');
		$num = mysqli_num_rows($chkDtl);	
		if($num == 0){
			 $row =	$userObj->addcheckDetails($emp,$check_no[$i],$cmonth,$amount[$i],$date1[$i]);
			 /*$sql="insert into cheque_details(emp_id,check_no,sal_month,amount,date,type,db_addate) values('".$emp."','".$check_no[$i]."','$cmonth','".$amount[$i]."','".date('Y-m-d',strtotime($date1[$i]))."','S',now())";*/	
		
		}else{
			$row =	$userObj->updatecheckDetails($date1[$i],$check_no[$i],$cmonth,$amount[$i],$emp);	
		   /*$sql="update cheque_details set date='".date('Y-m-d',strtotime($date1[$i]))."',check_no='".$check_no[$i]."',amount='".$amount[$i]."',sal_month='".$cmonth."', db_update=now() where emp_id='".$emp."' and sal_month='".$cmonth."' and type = 'S'";*/	
		  
		}
		//$row = mysql_query($sql);
		$i++;
	}

?>