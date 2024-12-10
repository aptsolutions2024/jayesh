<?php
 //error_reporting(0);
session_start();


include("../lib/connection/db-config.php");
include("../lib/class/user-class.php");
$setCounter = 0;
$userObj=new user();
$month=$_SESSION['month'];
$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];
$clintid=$_SESSION['clintid'];
$setExcelName = "emerson_export";
$frdt=$_SESSION['frdt'];
$frdt=date('Y-m-d',strtotime($frdt));
$resclt=$userObj->displayClient($clintid);
$cmonth=$resclt['current_month'];
$pay_type= $_POST['pay_type'];

if ($pay_type=="S"){
	if($month=='current'){
		$monthtit =  date('F Y',strtotime($cmonth));
		$frdt=$cmonth;
		$tab_emp='tran_employee';
    
	}
	else{

		$monthtit =  date('F Y',strtotime($_SESSION['frdt']));
		$frdt=date("Y-m-d", strtotime($_SESSION['frdt']));
		$tab_emp='hist_employee';
	}
	$desc = "Salary ".$monthtit;
}
if ($pay_type=="L"){
		$monthtit =  date('F Y',strtotime($_POST['payment_date']));
		$frdt=$_POST['payment_date'];
		$frdt=date("Y-m-d", strtotime($frdt));
		$tab_emp='leave_details';
	$desc = "LEAVE Payment";
}


if ($pay_type=="B"){
		$monthtit =  date('My',strtotime($_SESSION['startbonusyear']))." TO " .date('My',strtotime($_SESSION['endbonusyear']));
	$tab_emp='bonus';
	$frdt=date("Y-m-d", strtotime($_SESSION['startbonusyear']));
	$todt=date("Y-m-d", strtotime($_SESSION['endbonusyear']));
	
	$reporttitle="BONUS FOR THE YEAR ".strtoupper($monthtit);
	$desc = "Bonus- ". date('My',strtotime($_SESSION['startbonusyear']))." TO " .date('My',strtotime($_SESSION['endbonusyear']));
  
}
$tab = "tab_leave_".$user_id."";
$bank[0]="IDBI";
$bank[1]="KARAD";

$sqltab = "DROP TABLE IF EXISTS $tab" ;
$rowtab= mysql_query($sqltab);

   $sql = "create table $tab (  `bankacno` varchar(30) not null,`curr_code` varchar(30) not null, `outlet` varchar(30) not null, `tran_type` varchar(30) not null,`tran_amt` varchar(30) not null,`perticulars` varchar(50) not null,`refno`  INT NOT NULL AUTO_INCREMENT , PRIMARY KEY (`refno`),`ref_amt` varchar(30) not null,`r_cur_code` varchar(30) not null  ) ENGINE = InnoDB";
	$row= mysql_query($sql);

echo "<br>";
 
 
 if ($pay_type=="S"){
	  $sql = "insert into $tab (  `bankacno` ,`curr_code` , `outlet` , `tran_type` ,`tran_amt` ,`perticulars`  ,`ref_amt` ,`r_cur_code`) select te.`bankacno`,'INR','459','C',te.netsalary,'$desc',te.netsalary,'INR' from $tab_emp te  inner join employee e on e.emp_id = te.emp_id   inner join mast_bank mb on te.bank_id = mb.mast_bank_id  inner join mast_client t3 on te.client_id= t3.mast_client_id
	 where  te.client_id  in ( 12,13,14,15,16) and (mb.bank_name like '%IDBI%' ) and te.sal_month = '$frdt' and e.pay_mode = 'T' and te.netsalary >0 and te.comp_id ='".$comp_id."'";
	$setRec = mysql_query($sql);
//or  mb.bank_name like '%KARAD%' 
	  $sql = "insert into $tab (  `bankacno` ,`curr_code` , `outlet` , `tran_type` ,`tran_amt` ,`perticulars`  ,`ref_amt` ,`r_cur_code`) select mc.`bankacno`,'INR','459','D',sum(te.netsalary),'$desc',sum(te.netsalary),'INR' from $tab_emp te  inner join employee e on e.emp_id = te.emp_id   inner join mast_bank mb on te.bank_id = mb.mast_bank_id  inner join mast_company mc on te.comp_id = mc.comp_id   where  te.comp_id  ='".$comp_id ."' and te.sal_month >= '$frdt' and  te.client_id in ( 12,13,14,15,16)  and mb.bank_name like '%IDBI%' and e.pay_mode = 'T' and te.netsalary >0 and  te.comp_id ='".$comp_id."' ";;
	$setRec = mysql_query($sql);
 }
 
 if ($pay_type=="L"){
	 $sql = "insert into $tab (  `bankacno` ,`curr_code` , `outlet` , `tran_type` ,`tran_amt` ,`perticulars`  ,`ref_amt` ,`r_cur_code`) select te.`bankacno`,'INR','459','C',te.amount,'$desc',te.amount,'INR' from $tab_emp te  inner join employee e on e.emp_id = te.emp_id   inner join mast_bank mb on te.bank_id = mb.mast_bank_id  inner join mast_client t3 on te.client_id= t3.mast_client_id
	 where  te.client_id  in ( 12,13,14,15,16) and (mb.bank_name like '%IDBI%'  ) and te.payment_date >= '$frdt'  and e.pay_mode = 'T' and te.amount >0 and te.comp_id ='".$comp_id."'";
	$setRec = mysql_query($sql);
	
//or  mb.bank_name like '%KARAD%'

	$sql = "insert into $tab (  `bankacno` ,`curr_code` , `outlet` , `tran_type` ,`tran_amt` ,`perticulars`  ,`ref_amt` ,`r_cur_code`) select mc.`bankacno`,'INR','459','D',sum(te.amount),'$desc',sum(te.amount),'INR' from $tab_emp te  inner join employee e on e.emp_id = te.emp_id   inner join mast_bank mb on te.bank_id = mb.mast_bank_id  inner join mast_company mc on te.comp_id = mc.comp_id   where  te.comp_id  ='".$comp_id ."' and te.payment_date >= '$frdt'  and te.client_id in ( 12,13,14,15,16)  and mb.bank_name like '%IDBI%' and e.pay_mode = 'T' and te.amount >0 and  te.comp_id ='".$comp_id."' ";
	$setRec = mysql_query($sql);
	
 }
 
 if ($pay_type=="B"){
	 $days = $_SESSION['days'];
	 $sql = "insert into $tab (  `bankacno` ,`curr_code` , `outlet` , `tran_type` ,`tran_amt` ,`perticulars`  ,`ref_amt` ,`r_cur_code`) select te.`bankacno`,'INR','459','C', round(te.tot_bonus_amt +te.tot_exgratia_amt,0) ,'$desc',round(te.tot_bonus_amt +te.tot_exgratia_amt,0) ,'INR' from $tab_emp te  inner join employee e on e.emp_id = te.emp_id   inner join mast_bank mb on te.bank_id = mb.mast_bank_id  inner join mast_client t3 on te.client_id= t3.mast_client_id
	where  te.client_id  in ( 12,13,14,15,16) and (mb.bank_name like '%IDBI%'  ) and te.from_date = '$frdt' and  te.todate = '$todt' and te.pay_mode = 'T' and round(te.tot_bonus_amt +te.tot_exgratia_amt,0)  >0 and te.comp_id ='".$comp_id."' and  (te.apr_payable_days + te.may_payable_days+te.jun_payable_days+te.jul_payable_days+te.aug_payable_days+te.sep_payable_days+te.oct_payable_days+te.nov_payable_days+te.dec_payable_days+te.jan_payable_days+te.feb_payable_days+te.mar_payable_days) >=$days and e.prnsrno !='Y' ";
	$setRec = mysql_query($sql);
//or  mb.bank_name like '%KARAD%'
 $sql = "insert into $tab (  `bankacno` ,`curr_code` , `outlet` , `tran_type` ,`tran_amt` ,`perticulars`  ,`ref_amt` ,`r_cur_code`) select mc.`bankacno`,'INR','459','D',sum(round(te.tot_bonus_amt +te.tot_exgratia_amt,0) ),'$desc',sum(te.netsalary),'INR' from $tab_emp te  inner join employee e on e.emp_id = te.emp_id   inner join mast_bank mb on te.bank_id = mb.mast_bank_id  inner join mast_company mc on te.comp_id = mc.comp_id   where  te.comp_id  ='".$comp_id ."' and te.from_date = '$frdt' and  te.todate = '$todt' and  te.client_id in ( 12,13,14,15,16)  and mb.bank_name like '%IDBI%' and te.pay_mode = 'T' and round(te.tot_bonus_amt +te.tot_exgratia_amt,0)  >0 and  te.comp_id ='".$comp_id."' and  (te.apr_payable_days + te.may_payable_days+te.jun_payable_days+te.jul_payable_days+te.aug_payable_days+te.sep_payable_days+te.oct_payable_days+te.nov_payable_days+te.dec_payable_days+te.jan_payable_days+te.feb_payable_days+te.mar_payable_days) >=$days and e.prnsrno !='Y' ";
	$setRec = mysql_query($sql);
	
 }
 $sql = "select * from $tab";
 
   $setRec = mysql_query($sql);

$setCounter = mysql_num_fields($setRec);
$setMainHeader="";
$setData="";
for ($i = 0; $i < $setCounter; $i++) {
    $setMainHeader .= mysql_field_name($setRec, $i)."\t";
}

while($rec = mysql_fetch_row($setRec))  {
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

//$sqltab = "DROP TABLE IF EXISTS $tab" ;
$rowtab= mysql_query($sqltab);

?>







