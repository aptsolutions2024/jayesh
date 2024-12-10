<?php
error_reporting(0);
include("../lib/class/common.php");
$common = new common();

$client = $_POST['client'];
$empid = $_POST['empid'];
$dt = $_POST['dt'];
$dt = date('Y-m-d',strtotime($dt));
$frdt = $_POST['frdt'];
$frdt = date('Y-m-d',strtotime($frdt));
$todt = $_POST['todt'];
$todt = date('Y-m-d',strtotime($todt));
$chkn = $_POST['chkn'];

$orgincomhead = $_POST['orgincomhead'];
$orgstdname = $_POST['orgstdname'];
$orgcaltype = $_POST['orgcaltype'];
$orgamont = $_POST['orgamont'];
$stdamount = $_POST['stdamount'];
$caltype = $_POST['calculationtype'];
$amount = $_POST['amount'];
$difference = $_POST['difference'];
$grnttotval = $_POST['grnttotval'];
$monthname = $_POST['monthname'];
$bankdtl = $common->getBankDetails($empid,$client);
$bankid = $bankdtl['bank_id'];
$bankacno = $bankdtl['bankacno'];
$paymode = $bankdtl['pay_mode'];
if($grnttotval>0){
$resid = $common->insertArrears($empid,$dt,$frdt,$todt,$grnttotval,$bankid,$bankacno,$paymode);
$i=0;
foreach($chkn as $chk){	
	$common->insertArrears2($resid,$orgincomhead[$chk],$orgcaltype[$chk],$caltype[$chk],$orgstdname[$chk],$stdamount[$chk],$orgamont[$chk],$amount[$chk],$difference[$chk],$monthname[$chk]);
}
}
 
?>