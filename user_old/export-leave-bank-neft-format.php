<?php
//error_reporting(0);
$pay_type =$_POST['pay_type'];

session_start();
include("../lib/connection/db-config.php");
include("../lib/class/user-class.php");
$userObj=new user();
$setCounter = 0;
$month=$_SESSION['month'];
$comp_id=$_SESSION['comp_id'];
$setExcelName = "neft-export";

$clintid=$_SESSION['clintid'];
$resclt=$userObj->displayClient($clintid);
$cmonth=$resclt['current_month'];

if ($comp_id ==1)
	{$comp = "IMCON";}
else 
	{$comp = "ICS";}


if ($clintid == 12 || $clintid == 13 || $clintid == 14 || $clintid == 15 || $clintid == 16)
{
$clintid = "12,13,14,15,16";
}

if ($pay_type == 'S'){
	$monthtit =  date('F Y',strtotime($cmonth));
	if($month=='current'){
		$tab_emp='tran_employee';
		$frdt=$cmonth;
	}
	else{
		$tab_emp='hist_employee';
	}
	$frdt=date("Y-m-d", strtotime($frdt));
	$desc = "SAL. ".$monthtit;
	
  $setRec = $userObj->getExportLeaveBankNeftFormt($desc,$tab_emp,$clintid,$frdt);
  
  	/*$setSql= "SELECT te.netsalary,mc.bankacno as sender_bankacno,mb.ifsc_code,te.`bankacno` as beneficiary_acno ,'10' as 'Account Type',concat(e.first_name,' ',e.middle_name,' ',e.last_name) AS 'Beneficiary Customer Name', e.pin_code as 'Beneficiary Customer Address','".$desc ."' as 'Sender to Receiver Information', mc.comp_name as 'Originator Of Remittance' FROM $tab_emp te inner join employee e on e.emp_id = te.emp_id inner join mast_company mc on te.comp_id = mc.comp_id  inner JOIN mast_bank mb on te.bank_id = mb.mast_bank_id where te.client_id in (".$clintid.") and e.pay_mode = 'N' and sal_month = '$frdt' ";*/
}

if ($pay_type == 'L'){
	$payment_date = $_POST['payment_date'];

	$tab_emp='leave_details';
	$desc = "Leave Payment";
	$payment_date=date("Y-m-d", strtotime($payment_date));
	
  /*	$setSql= "SELECT te.amount,mc.bankacno as sender_bankacno,mb.ifsc_code,te.`bankacno` as beneficiary_acno ,'10' as 'Account Type',concat(e.first_name,' ',e.middle_name,' ',e.last_name) AS 'Beneficiary Customer Name', e.pin_code as 'Beneficiary Customer Address','".$desc ."' as 'Sender to Receiver Information', mc.comp_name as 'Originator Of Remittance' FROM $tab_emp te inner join employee e on e.emp_id = te.emp_id inner join mast_company mc on te.comp_id = mc.comp_id  inner JOIN mast_bank mb on te.bank_id = mb.mast_bank_id where te.client_id in (".$clintid.") and e.pay_mode = 'N' and payment_date = '$payment_date' and te.amount>0 ";*/
  	
  	$setRec = $userObj->getExportLeaveBankNeftFormtPayL($desc,$tab_emp,$clintid,$payment_date);
	}

		
if ($pay_type == 'B'){
	
	   $days = $_SESSION['days'];
	$monthtit =  date('My',strtotime($_SESSION['startbonusyear']))." TO " .date('My',strtotime($_SESSION['endbonusyear']));
	$tab_emp='bonus';
	$frdt=date("Y-m-d", strtotime($_SESSION['startbonusyear']));
	$todt=date("Y-m-d", strtotime($_SESSION['endbonusyear']));
	$desc = "Bonus- ". date('My',strtotime($_SESSION['startbonusyear']))." TO " .date('My',strtotime($_SESSION['endbonusyear']));
  	/*$setSql= "SELECT  round(te.tot_bonus_amt +te.tot_exgratia_amt,0) as amount ,mc.bankacno as sender_bankacno,mb.ifsc_code,te.`bankacno` as beneficiary_acno ,'10' as 'Account Type',concat(e.first_name,' ',e.middle_name,' ',e.last_name) AS 'Beneficiary Customer Name', e.pin_code as 'Beneficiary Customer Address','".$desc ."' as 'Sender to Receiver Information', mc.comp_name as 'Originator Of Remittance' FROM $tab_emp te inner join employee e on e.emp_id = te.emp_id inner join mast_company mc on te.comp_id = mc.comp_id  inner JOIN mast_bank mb on te.bank_id = mb.mast_bank_id where te.client_id in (".$clintid.") and te.pay_mode = 'N' and te.from_date = '$frdt' and  te.todate = '$todt' and  (te.apr_payable_days + te.may_payable_days+te.jun_payable_days+te.jul_payable_days+te.aug_payable_days+te.sep_payable_days+te.oct_payable_days+te.nov_payable_days+te.dec_payable_days+te.jan_payable_days+te.feb_payable_days+te.mar_payable_days) >=$days and e.prnsrno !='Y'  "; */
  	
  	$setRec = $userObj->getExportLeaveBankNeftFormtPayB($desc,$tab_emp,$clintid,$frdt,$todt,$days);
}

	

$setCounter = mysqli_num_fields($setRec);
$setMainHeader="";
$setData="";
   while($fld =mysqli_fetch_field($setRec)){
   
    $setMainHeader .= $fld->name."\t";
}

while($rec = $setRec->fetch_assoc())  {
    $rowLine = '';
    foreach($rec as $value)       {
        if(!isset($value) || $value == "")  {
            $value = "\t";
			
        }   else  {
//It escape all the special charactor, quotes from the data.
     //       $value = strip_tags(str_replace('"', '""', $value));
     //       $value = '"' . $value . '"' . "\t";
	 
	        $value = strip_tags(str_replace('"', '""', $value));
            $value = '' . $value . ' ' . "\t";
	 
        }
        $rowLine .= $value;
    }
    //$setData .= trim($rowLine)."\n";
$setData .= trim($rowLine).chr(13).chr(10);
}
$setData = str_replace("\r", "", $setData);

if ($setData == "") {
    $setData = "\nno matching records found\n";
}

//This Header is used to make data download instead of display the data
header("Content-type: application/octet-stream");

header("Content-Disposition: attachment; filename=".$setExcelName.".xls");

header("Pragma: no-cache");
header("Expires: 0");

//It will print all the Table row as Excel file row with selected column name as header.
echo ucwords($setMainHeader)."\n".$setData."\n";
?>







