<?php
 //error_reporting(0);
session_start();


include("../lib/connection/db-config.php");
include("../lib/class/user-class.php");
$setCounter = 0;
$userObj=new user();
$setCounter = 0;
$month=$_SESSION['month'];
$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];
$clintid=$_SESSION['clintid'];
$setExcelName = "employee_detail";
$emp=$_POST['emp'];

$res=$userObj->showEmployeereport($comp_id,$user_id);
$resclt=$userObj->displayClient($clintid);
$cmonth=$resclt['current_month'];
if($month=='current'){
	$monthtit =  date('F Y',strtotime($cmonth));
    $frdt=$cmonth;
    $todt=$cmonth;
    $tab_emp='tran_employee';
    $tab_empded='tran_deduct';
	$tab_empinc='tran_income';
    $esifrdt=$cmonth;
	$tab_days='tran_days';
    
 }
else{

    $monthtit =  date('F Y',strtotime($_SESSION['frdt']));
	$frdt=date("Y-m-d", strtotime($_SESSION['frdt']));
    $todt=date("Y-m-d", strtotime($_SESSION['frdt']));
    $tab_emp='hist_employee';
    $tab_empded='hist_deduct';
	$tab_empinc='hist_income';
	$tab_days='hist_days';

 }
$tab = "`tab_".$user_id."`";
  $desc = "SALARY FOR THE MONTH ".$monthtit;

//BANKACNO	CURR_CODE	OUTLET	TRAN_TYPE	TRAN_AMT	PERTICULAR	REFNO	REF_AMT	R_CUR_CODE
//CREATE TABLE `new_imcon_salary`. ( `id` INT NOT NULL AUTO_INCREMENT , PRIMARY KEY (`id`)) ENGINE = InnoDB;
$sqltab = "DROP TABLE IF EXISTS $tab" ;
$rowtab= mysql_query($sqltab);

$sql = "create table $tab (  `bankacno` varchar(30) not null,`curr_code` varchar(30) not null, `outlet` varchar(30) not null, `tran_type` varchar(30) not null,`tran_amt` varchar(30) not null,`perticulars` varchar(50) not null,`refno`  INT NOT NULL AUTO_INCREMENT , PRIMARY KEY (`refno`),`ref_amt` varchar(30) not null,`r_cur_code` varchar(30) not null  ) ENGINE = InnoDB";;
$row= mysql_query($sql);



	 $sql = "insert into $tab (  `bankacno` ,`curr_code` , `outlet` , `tran_type` ,`tran_amt` ,`perticulars`  ,`ref_amt` ,`r_cur_code`) select concat(".chr(34).chr(39).chr(34).",te.`bankacno`),'INR','459','C',te.netsalary,'$desc',te.netsalary,'INR' from $tab_emp te  inner join employee e on e.emp_id = te.emp_id   inner join mast_bank mb on te.bank_id = mb.mast_bank_id  inner join mast_client t3 on te.client_id= t3.mast_client_id
	 where  te.client_id  in ( 12,13,14,15,16) and mb.bank_name like '%IDBI%' and te.sal_month = '".$frdt."'  and e.pay_mode = 'T'";
	$setRec = mysql_query($sql);

	 $sql = "insert into $tab (  `bankacno` ,`curr_code` , `outlet` , `tran_type` ,`tran_amt` ,`perticulars`  ,`ref_amt` ,`r_cur_code`) select concat(".chr(34).chr(39).chr(34).",mc.`bankacno`),'INR','459','D',sum(te.netsalary),'$desc',sum(te.netsalary),'INR' from $tab_emp te  inner join employee e on e.emp_id = te.emp_id   inner join mast_bank mb on te.bank_id = mb.mast_bank_id  inner join mast_company mc on te.comp_id = mc.comp_id   where  te.comp_id  ='".$comp_id ."' and te.sal_month = '".$frdt."' and te.client_id in ( 12,13,14,15,16)  and mb.bank_name like '%IDBI%' and e.pay_mode = 'T'";
	$setRec = mysql_query($sql);
  
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

$sqltab = "DROP TABLE IF EXISTS $tab" ;
$rowtab= mysql_query($sqltab);

?>







