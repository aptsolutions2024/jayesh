<?php
session_start();
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', dirname(__FILE__) . '/error_log.txt');
error_reporting(E_ALL);
include("../lib/connection/db-config.php");
include("../lib/class/user-class.php");

$setCounter = 0;
$userObj=new user();
$pay_type =$_POST['pay_type'];
$sakal_type =$_POST['sakal_type'];
$month=$_SESSION['month'];
$comp_id=$_SESSION['comp_id'];
$clintid=$_SESSION['clintid'];
$setExcelName = "transfer-export";
$user_id=$_SESSION['log_id'];


	$tab = "`tab_".$user_id."`";
	//$sqltab = "DROP TABLE IF EXISTS $tab" ;
	$userObj->dropTable($tab);
	//$rowtab= mysql_query($sqltab);
$userObj->createUserTempExportleaveBankTransfer($tab);
	/*$sql = "create table $tab (  `bankacno` varchar(30) not null,`curr_code` varchar(30) not null, `outlet` varchar(30) not null, `tran_type` varchar(30) not null,`tran_amt` varchar(30) not null,`perticulars` varchar(50) not null,`refno`  INT NOT NULL AUTO_INCREMENT , PRIMARY KEY (`refno`),`ref_amt` varchar(30) not null,`r_cur_code` varchar(30) not null  ) ENGINE = InnoDB";;
	$row= mysql_query($sql);*/

if ($clintid == 12 || $clintid == 13 || $clintid == 14 || $clintid == 15 || $clintid == 16)
{
$clintid = "12,13,14,15,16";
}

if ($sakal_type =='Yes')
{
$clintid = "7,8,9,17,23,24";
	
}

if ($pay_type =="S"){
	$resclt=$userObj->displayClient($clintid);
	$cmonth=$resclt['current_month'];
	if($month=='current'){
		$monthtit =  date('F Y',strtotime($cmonth));
		$frdt=$cmonth;
		$tab_emp="tran_employee";
		}
	else{
		$monthtit =  date('F Y',strtotime($_SESSION['frdt']));
		$frdt=date("Y-m-d", strtotime($_SESSION['frdt']));
		$tab_emp='hist_employee';
	}
	$desc = "Salry for ".$monthtit;


	$setRec = $userObj->insertUserTempExportleaveBankTransfer($tab,$desc,$tab_emp,$clintid,$frdt);

	 /*$sql = "insert into $tab (  `bankacno` ,`curr_code` , `outlet` , `tran_type` ,`tran_amt` ,`perticulars`  ,`ref_amt` ,`r_cur_code`) select mc.`bankacno`,'INR','459','D',sum(te.netsalary),'$desc',sum(te.netsalary),'INR' from mast_company mc  inner join $tab_emp te on te.comp_id = mc.comp_id inner join mast_bank mb on te.bank_id = mb.mast_bank_id   where  te.sal_month >= '$frdt' and te.client_id  in ($clintid)  and te.pay_mode = 'T' and mb.bank_name like '%IDBI%'";
	$setRec = mysql_query($sql);*/
	$setRec = $userObj->insertUserTempExportleaveBankTransfer2($tab,$desc,$tab_emp,$clintid,$frdt);
	
	
	
	
	
	
	

}

if ($pay_type =="L"){
	$frdt=$_POST['payment_date'];
	$tab_emp="leave_details";
	$frdt=date("Y-m-d", strtotime($frdt));
	$desc = "Leave Payment";

	 /*$sql = "insert into $tab (  `bankacno` ,`curr_code` , `outlet` , `tran_type` ,`tran_amt` ,`perticulars`  ,`ref_amt` ,`r_cur_code`) select te.`bankacno`,'INR','459','C',te.amount,'$desc',te.amount,'INR' from $tab_emp te  inner join employee e on e.emp_id = te.emp_id  inner join mast_client t3 on te.client_id= t3.mast_client_id inner join mast_bank mb on te.bank_id = mb.mast_bank_id  
	where  te.client_id   in ($clintid) and te.payment_date = '$frdt' and e.pay_mode = 'T' and mb.bank_name like '%IDBI%' ";
	$setRec = mysql_query($sql);*/
	$setRec = $userObj->insertUserTempExportleaveBankTransferL($tab,$desc,$tab_emp,$clintid,$frdt);


//echo "<br>";

	/*echo $sql = "insert into $tab (  `bankacno` ,`curr_code` , `outlet` , `tran_type` ,`tran_amt` ,`perticulars`  ,`ref_amt` ,`r_cur_code`) select mc.`bankacno`,'INR','459','D',sum(te.amount),'$desc',sum(te.amount),'INR' from mast_company mc  inner join $tab_emp te on te.comp_id = mc.comp_id inner join mast_bank mb on te.bank_id = mb.mast_bank_id   where  te.payment_date >= '$frdt' and te.client_id  in ($clintid)  and te.pay_mode = 'T' and mb.bank_name like '%IDBI%'";
	
	
	$setRec = mysql_query($sql); */
	$setRec = $userObj->insertUserTempExportleaveBankTransferL2($tab,$desc,$tab_emp,$clintid,$frdt);

	}
if ($pay_type =="B"){
	 $days = $_SESSION['days'];
	$resclt=$userObj->displayClient($clintid);
	$monthtit =  date('My',strtotime($_SESSION['startbonusyear']))." TO " .date('My',strtotime($_SESSION['endbonusyear']));
	$tab_emp='bonus';
	$frdt=date("Y-m-d", strtotime($_SESSION['startbonusyear']));
	$todt=date("Y-m-d", strtotime($_SESSION['endbonusyear']));
	$reporttitle="BONUS FOR THE YEAR ".strtoupper($monthtit);
	$desc = "Bonus- ". date('My',strtotime($_SESSION['startbonusyear']))." TO " .date('My',strtotime($_SESSION['endbonusyear']));
  
	
	  /*$sql = "insert into $tab (  `bankacno` ,`curr_code` , `outlet` , `tran_type` ,`tran_amt` ,`perticulars`  ,`ref_amt` ,`r_cur_code`) select te.`bankacno`,'INR','459','C',round(te.tot_bonus_amt +te.tot_exgratia_amt,0),'$desc',round(te.tot_bonus_amt +te.tot_exgratia_amt,0),'INR' from $tab_emp te  inner join employee e on e.emp_id = te.emp_id  inner join mast_client t3 on te.client_id= t3.mast_client_id inner join mast_bank mb on te.bank_id = mb.mast_bank_id  
	where  te.client_id in ($clintid) and te.from_date = '$frdt' and  te.todate = '$todt' and te.pay_mode = 'T' and mb.bank_name like '%IDBI%' and  (te.apr_payable_days + te.may_payable_days+te.jun_payable_days+te.jul_payable_days+te.aug_payable_days+te.sep_payable_days+te.oct_payable_days+te.nov_payable_days+te.dec_payable_days+te.jan_payable_days+te.feb_payable_days+te.mar_payable_days) >=$days and e.prnsrno !='Y'  ";
	$setRec = mysql_query($sql);*/
		$setRec = $userObj->insertUserTempExportleaveBankTransferB($tab,$desc,$tab_emp,$clintid,$frdt,$todt,$days);
    
/*	$sql = "insert into $tab (  `bankacno` ,`curr_code` , `outlet` , `tran_type` ,`tran_amt` ,`perticulars`  ,`ref_amt` ,`r_cur_code`) select mc.`bankacno`,'INR','459','D',sum(round(te.tot_bonus_amt +te.tot_exgratia_amt,0)),'$desc',sum(round(te.tot_bonus_amt +te.tot_exgratia_amt,0)),'INR' from mast_company mc  inner join $tab_emp te on te.comp_id = mc.comp_id inner join mast_bank mb on te.bank_id = mb.mast_bank_id   where te.from_date = '$frdt' and  te.todate = '$todt' and te.client_id  in ($clintid)  and te.pay_mode = 'T' and mb.bank_name like '%IDBI%' and (te.apr_payable_days + te.may_payable_days+te.jun_payable_days+te.jul_payable_days+te.aug_payable_days+te.sep_payable_days+te.oct_payable_days+te.nov_payable_days+te.dec_payable_days+te.jan_payable_days+te.feb_payable_days+te.mar_payable_days) >=$days and e.prnsrno !='Y'  ";
	$setRec = mysql_query($sql);*/
	
	$setRec = $userObj->insertUserTempExportleaveBankTransferB2($tab,$desc,$tab_emp,$clintid,$frdt,$todt,$days);

}

   /*$sql = "select * from $tab";
   $setRec = mysql_query($sql);*/
   
   $setRec = $userObj->selectTab($tab);
  

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
            $value = strip_tags(str_replace('"', '""', $value));
            $value = '"' . $value . '"' . "\t";
        }
        $rowLine .= $value;
    }
    $setData .= trim($rowLine)."\n";
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

/*$sqltab = "DROP TABLE IF EXISTS $tab" ;
$rowtab= mysql_query($sqltab);*/
$userObj->dropTable($tab);

?>







