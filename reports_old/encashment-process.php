<?php
session_start();
include("../lib/class/common.php");
include("../lib/class/leave.php");
$common=new common();
$leave=new leave();

//print_r($_REQUEST);

$compid= $_SESSION['comp_id'];
$empid= $_REQUEST['empid'];
$preday= $_REQUEST['preday'];
$obday= $_REQUEST['obday'];
$earned= $_REQUEST['earned'];
$enjoyed= $_REQUEST['enjoyed'];
$balance= $_REQUEST['balance'];
$encashed= $_REQUEST['encashed'];
$rate= $_REQUEST['rate'];
$amount= $_REQUEST['amount'];
$chkbox = $_REQUEST['chkbox'];

$client= $_REQUEST['client'];
$leavetype= $_REQUEST['leavetype'];
$frdt= $_REQUEST['frdt'];
$todt= $_REQUEST['todt'];
$calculationfrm= $_REQUEST['calculationfrm'];
$calculationto= $_REQUEST['calculationto'];

$i=0;
foreach($empid as $emp){
	 if (in_array($emp, $chkbox)){
	$bankdetail = $common->getBankDetails($emp,$client);
	$bid = $bankdetail['bank_id'];
	$bankacno = $bankdetail['bankacno'];
	$paymode = $bankdetail['pay_mode'];
	
	$chkbankdtl = $leave->checkEncashment($frdt,$todt,$emp,$client,$leavetype);
	  $chkbankdtl1 = $leave->checkEncashmentRow($frdt,$todt,$emp,$client,$leavetype); 
	  echo $num = $chkbankdtl1->rowCount();
	if($num==0){
		$leave->insertEncashment($emp,$preday[$i],$obday[$i],$earned[$i],$enjoyed[$i],$balance[$i],$encashed[$i],$rate[$i],$amount[$i],$bid,$bankacno,$paymode,$client,$leavetype,$frdt,$todt,$compid);
	}else{
		
		$leave->updateEncashment($emp,$preday[$i],$obday[$i],$earned[$i],$enjoyed[$i],$balance[$i],$encashed[$i],$rate[$i],$amount[$i],$bid,$bankacno,$paymode,$client,$leavetype,$frdt,$todt,$compid);
	}
	
}	
 
$i++;
 }
?>