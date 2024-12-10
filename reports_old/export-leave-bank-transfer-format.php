<?php
error_reporting(0);
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
$emp=$_REQUEST['emp'];

$res=$userObj->showEmployeereport($comp_id,$user_id);
$resclt=$userObj->displayClient($clintid);
$cmonth=$resclt['current_month'];
$frdt1=$_REQUEST['from_date'];
$frdt1=date('Y-m-d',strtotime($frdt1));
$to_date=$_REQUEST['to_date'];
$to_date=date('Y-m-d',strtotime($to_date));
if($month=='current'){
	$monthtit =  date('F Y',strtotime($cmonth));
    $frdt=$cmonth;
    $todt=$cmonth;
   $tab_emp='leave_details'; 
    
    $esifrdt=$cmonth;
	
    
 }
else{

    $monthtit =  date('F Y',strtotime($_SESSION['frdt']));
	$frdt=date("Y-m-d", strtotime($_SESSION['frdt']));
    $todt=date("Y-m-d", strtotime($_SESSION['frdt']));
    $tab_emp='leave_details';
 }
$tab = "`tab_leave_".$user_id."`";
  $desc = "LEAVE SALARY FOR THE MONTH ".$monthtit;

//BANKACNO	CURR_CODE	OUTLET	TRAN_TYPE	TRAN_AMT	PERTICULAR	REFNO	REF_AMT	R_CUR_CODE
//CREATE TABLE `new_imcon_salary`. ( `id` INT NOT NULL AUTO_INCREMENT , PRIMARY KEY (`id`)) ENGINE = InnoDB;
$sqltab = "DROP TABLE IF EXISTS $tab" ;
$rowtab= mysql_query($sqltab);

$sql = "create table $tab (  `bankacno` varchar(30) not null,`curr_code` varchar(30) not null, `outlet` varchar(30) not null, `tran_type` varchar(30) not null,`tran_amt` varchar(30) not null,`perticulars` varchar(50) not null,`refno`  INT NOT NULL AUTO_INCREMENT , PRIMARY KEY (`refno`),`ref_amt` varchar(30) not null,`r_cur_code` varchar(30) not null  ) ENGINE = InnoDB";;
$row= mysql_query($sql);

 if($emp=='Parent')
 {
	 $sql = "insert into $tab (  `bankacno` ,`curr_code` , `outlet` , `tran_type` ,`tran_amt` ,`perticulars`  ,`ref_amt` ,`r_cur_code`) select concat(".chr(34).chr(39).chr(34).",te.`bankacno`),'INR','459','C',te.amount,te.from_date,te.to_date,te.amount,'INR' from $tab_emp te  inner join employee e on e.emp_id = te.emp_id  inner join mast_client t3 on te.client_id= t3.mast_client_id
	 where  t3.parentid='".$clintid."' and te.from_date >= '$frdt1' and to_date <='$to_date' and e.pay_mode = 'T'";
   $setRec = mysql_query($sql);

	 $sql = "insert into $tab (  `bankacno` ,`curr_code` , `outlet` , `tran_type` ,`tran_amt` ,`perticulars`  ,`ref_amt` ,`r_cur_code`) select concat(".chr(34).chr(39).chr(34).",te.`bankacno`),'INR','459','D',sum(te.amount),te.from_date,te.to_date,sum(te.amount),'INR' from $tab_emp te inner join employee e on e.emp_id = te.emp_id  inner join mast_client t3 on te.client_id = t3.mast_client_id  where te.from_date >= '$frdt1' and to_date <='$to_date' and te.parentid ='".$clintid."'  and e.pay_mode = 'T'";
	$setRec = mysql_query($sql);
 
 }

else{ 	

	  $sql = "insert into $tab (  `bankacno` ,`curr_code` , `outlet` , `tran_type` ,`tran_amt` ,`perticulars`  ,`ref_amt` ,`r_cur_code`) select concat(".chr(34).chr(39).chr(34).",te.`bankacno`),'INR','459','C',te.amount,'$desc',te.amount,'INR' from $tab_emp te  inner join employee e on e.emp_id = te.emp_id  inner join mast_client t3 on te.client_id= t3.mast_client_id
	 where  te.client_id ='".$clintid."' and te.from_date >= '$frdt1' and to_date <='$to_date'  and e.pay_mode = 'T'";
	$setRec = mysql_query($sql);

	  $sql = "insert into $tab (  `bankacno` ,`curr_code` , `outlet` , `tran_type` ,`tran_amt` ,`perticulars`  ,`ref_amt` ,`r_cur_code`) select concat(".chr(34).chr(39).chr(34).",te.`bankacno`),'INR','459','D',sum(te.amount),'$desc',sum(te.amount),'INR' from $tab_emp te  inner join employee e on e.emp_id = te.emp_id where  te.from_date >= '$frdt1' and to_date <='$to_date' and te.client_id ='".$clintid."'  and e.pay_mode = 'T'";
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

$sqltab = "DROP TABLE IF EXISTS $tab" ;
$rowtab= mysql_query($sqltab);

?>







