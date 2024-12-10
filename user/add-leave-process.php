<?php
session_start();
//print_r($_POST);
include("../lib/class/common.php");
include("../lib/class/leave.php");
$common=new common();
$leave=new leave();
$compid = $_SESSION['comp_id'];
$user = $_SESSION['log_id'];

$clintid = $_POST['client'];
$emp = $_POST['emp'];
$empid = $_POST['empid'];
$leave_type = $_POST['leavetype'];
$frdt = $_POST['frdt'];
$frdt = date('Y-m-d',strtotime($frdt));
$todt = $_POST['todt'];
$todt = date('Y-m-d',strtotime($todt));
$calculationfrm = $_POST['calculationfrm'];
$calculationfrm = date('Y-m-d',strtotime($calculationfrm));
$calculationto = $_POST['calculationto'];
$calculationto = date('Y-m-d',strtotime($calculationto));
$presentday = $_POST['presentday'];
$carfrfrm = $_POST['carfrfrm'];
$carfrto = $_POST['carfrto'];
//array values
$chkbox = $_POST['chkbox'];
$granted = $_POST['granted'];
$calculated = $_POST['calculated'];
$carriedforword = $_POST['carriedforword'];
$empids = $_POST['empids'];
$ob = $_POST['ob'];

$i=0;
//print_r($granted);
foreach($granted as $grant){ 
// check by calcution dates
/*  $chkdt = $leave->checkLeave($clintid,$empids[$i],$leave_type,$calculationfrm,$calculationto);
 $num = $chkdt->rowCount();
	if($num ==0){ //echo "hello 123";	
		
	 */
//$ob = $grant+$calculated[$i]+$carriedforword[$i];
	 if (in_array($empids[$i], $chkbox)){
		 //query for getting ob



			// check by To date, from date 
			$chkdt1 = $leave->checkLeaveFrToDate($clintid,$emp,$empids[$i],$leave_type,$frdt,$todt);
				$num1 = $chkdt1->rowCount();
		
			if($num1 ==0){ //echo "hello 123 inserted";
				$chkdt1 = $leave->insertLeave($clintid,$empids[$i],$leave_type,$frdt,$todt,$calculationfrm,$calculationto,$grant,$calculated[$i],$carriedforword[$i],$ob[$i],$compid,$user);
			}else{ //echo "hello 123 updated";
				//$message = "Records alrady is existed within period ";
				$chkdt1 = $leave->updateLeave($clintid,$empids[$i],$leave_type,$frdt,$todt,$calculationfrm,$calculationto,$grant,$calculated[$i],$carriedforword[$i],$ob[$i],$compid,$user);
			}
		}
		
	/* }else{
		echo $message = "Records alrady is existed within calculation period ";
		//return false;
	}
	 */
	$i++;
}


?>