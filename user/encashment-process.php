<?php
session_start();
include("../lib/class/common.php");
include("../lib/class/leave.php");
$common=new common();
$leave=new leave();

//print_r($_POST);

$compid= $_SESSION['comp_id'];
$empid= $_POST['empid'];
$preday= $_POST['preday'];
$obday= $_POST['obday'];
$earned= $_POST['earned'];
$enjoyed= $_POST['enjoyed'];
$balance= $_POST['balance'];
$encashed= $_POST['encashed'];
$rate= $_POST['rate'];
$amount= $_POST['amount'];
$chkbox = $_POST['chkbox'];


$client= $_POST['client'];
$leavetype= $_POST['leavetype'];
$frdt= $_POST['frdt'];
$todt= $_POST['todt'];
$payment_date= $_POST['payment_date'];
$calculationfrm= $_POST['calculationfrm'];
$calculationto= $_POST['calculationto'];

$i=0;
foreach($empid as $emp){
	//echo $emp;
	 if (in_array($emp, $chkbox)){
	$bankdetail = $common->getBankDetails($emp,$client);
	$bid = $bankdetail['bank_id'];
	$bankacno = $bankdetail['bankacno'];
	$paymode = $bankdetail['pay_mode'];
	
	$chkbankdtl = $leave->checkEncashment($frdt,$todt,$emp,$client,$leavetype);
	  $chkbankdtl1 = $leave->checkEncashmentRow($frdt,$todt,$emp,$client,$leavetype); 
	 //echo  $num = mysql_num_rows($chkbankdtl1);
	  //echo  $num = $chkbankdtl1->rowCount();
	  
	if($chkbankdtl1['leave_details_id'] >0){
	   echo "<br>1 - ".$emp." update **** <br>";	
		$leave->updateEncashment($emp,$preday[$i],$obday[$i],$earned[$i],$enjoyed[$i],$balance[$i],$encashed[$i],$rate[$i],$amount[$i],$bid,$bankacno,$paymode,$client,$leavetype,$frdt,$todt,$compid,$payment_date);
	}else{
	   echo "<br>2 - ".$emp."insert *****<br>";	
		$leave->insertEncashment($emp,$preday[$i],$obday[$i],$earned[$i],$enjoyed[$i],$balance[$i],$encashed[$i],$rate[$i],$amount[$i],$bid,$bankacno,$paymode,$client,$leavetype,$frdt,$todt,$compid,$payment_date);
	}
	
}	
 
$i++;
 }
?>