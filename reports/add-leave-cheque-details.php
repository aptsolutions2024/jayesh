<?php
 session_start();

include("../lib/connection/db-config.php");
include("../lib/class/user-class.php");
include("../lib/class/leave.php");
$empid = $_REQUEST['emp_id'];
$chkdate = $_REQUEST['chkdate'];
 $chkdate = date('Y-m-d',strtotime($chkdate));
$amount = $_REQUEST['amount'];
$check_no = $_REQUEST['check_no'];
$date1 = $_REQUEST['date'];
$userObj=new user();
$leave=new leave();
$i=0;
$curmonth = date('m');
$curyear = date('Y');
//$cmonth = $_REQUEST['$cmonth'];
$fromdate = $_REQUEST['fromdate'];
$todate = $_REQUEST['todate'];



$clientid = $_SESSION['clintid'];
$resclt=$userObj->displayClient($clientid);
$cmonth=$resclt['current_month'];
//print_r($_REQUEST);
$i=0;
	foreach($empid as $emp){
		$chkDtl = $leave->chkLeaveChequeRowDetails($emp,$fromdate,$todate,'L');
		$num = $chkDtl->rowCount();	
		if($num == 0){
			$leave->insertLeaveCheckDetail($emp,$check_no[$i],$fromdate,$todate,$amount[$i],date('Y-m-d',strtotime($date1[$i])),'L');
		}else{			
			$leave->updateLeaveCheckDetail($emp,$check_no[$i],$fromdate,$todate,$amount[$i],date('Y-m-d',strtotime($date1[$i])),'L');		   
		}
		
		$i++;
	}

?>