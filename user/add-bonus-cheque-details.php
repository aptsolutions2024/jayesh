<?php
 session_start();

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
$startday = $_SESSION['startbonusyear'];
$endday = $_SESSION['endbonusyear'];

$clientid = $_SESSION['clintid'];
$resclt=$userObj->displayClient($clientid);
$cmonth=$resclt['current_month'];

	foreach($empid as $emp){
		$chkDtl = $userObj->chkBonusDetails($emp,$startday,$endday,'B');
		$num = mysqli_num_rows($chkDtl);	
		if($num == 0){
			 //$sql="insert into cheque_details(emp_id,check_no,salary_month,amount,date,db_addate) values('".$emp."','".$check_no[$i]."',now(),'".$amount[$i]."','".$chkdate."',now())";	
			 //$sql="insert into cheque_details(emp_id,check_no,from_date,to_date,amount,date,type,db_addate) values('".$emp."','".$check_no[$i]."','$startday','$endday','".$amount[$i]."','".date('Y-m-d',strtotime($date1[$i]))."','B',now())";	
		$userObj->insertCheckBonusDetails($emp,$check_no[$i],$startday,$endday,$amount[$i],$date1[$i]);
		}else{
			//  $sql="update cheque_details set date='".$chkdate."',check_no='".$check_no[$i]."',amount='".$amount[$i]."',salary_month='".$cmonth."', db_update=now() where emp_id='".$emp."' and year(salary_month)='".$curyear."' and month(salary_month) = '".$curmonth."'";	
		  //$sql="update cheque_details set date='".date('Y-m-d',strtotime($date1[$i]))."',check_no='".$check_no[$i]."',amount='".$amount[$i]."',from_date='".$startday."',to_date='".$endday."', db_update=now() where emp_id='".$emp."' and from_date='".$startday."'and to_date='".$endday."' and type = 'B'";	
		  $userObj->updateCheckBonusDetails($date1[$i],$check_no[$i],$amount[$i],$startday,$endday,$emp);
		}
		
		$i++;
	}

?>