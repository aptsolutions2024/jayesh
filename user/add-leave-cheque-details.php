<?php
 session_start();

include("../lib/connection/db-config.php");
include("../lib/class/user-class.php");
include("../lib/class/leave.php");
$empid = $_POST['emp_id'];
$chkdate = $_POST['chkdate'];
 $chkdate = date('Y-m-d',strtotime($chkdate));
$amount = $_POST['amount'];
$check_no = $_POST['check_no'];
$date1 = $_POST['date'];
$userObj=new user();
$leave=new leave();
$i=0;
$curmonth = date('m');
$curyear = date('Y');
//$cmonth = $_POST['$cmonth'];
$payment_date = $_POST['payment_date'];




$clientid = $_SESSION['clintid'];
$resclt=$userObj->displayClient($clientid);
$cmonth=$resclt['current_month'];
//print_r($_POST);
$i=0;
	foreach($empid as $emp){
		$chkDtl = $leave->chkLeaveChequeRowDetails($emp,$payment_date,'L');
		$num = $chkDtl->rowCount();	
		if($num == 0){
			$leave->insertLeaveCheckDetail($emp,$check_no[$i],$payment_date,$amount[$i],date('Y-m-d',strtotime($date1[$i])),'L');
		}else{			
			$leave->updateLeaveCheckDetail($emp,$check_no[$i],$payment_date,$amount[$i],date('Y-m-d',strtotime($date1[$i])),'L');		   
		}
		
		$i++;
	}

?>