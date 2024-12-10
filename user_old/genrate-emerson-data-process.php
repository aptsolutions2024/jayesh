<?php
//print_r($_POST);
// 1 for deptwise
// 2 for designation wise
// 3 for dept + client wise
	
session_start();
ini_set('max_execution_time', 300); //300 seconds = 5 minutes
$comp_id = $_SESSION['comp_id'];
$splallow = $_POST['splallow'];
$pf = $_POST['pf'];
$bonus = $_POST['bonus'];
$esi = $_POST['esi'];
$lww = $_POST['lww'];
$lwf = $_POST['lwf'];
$safetyapp = $_POST['safetyapp'];
$other = $_POST['other'];
$trainingcharg = $_POST['trainingcharg'];
$tds = $_POST['tds'];
$cgst = $_POST['cgst'];
$sgst = $_POST['sgst'];
$igst = $_POST['igst'];

$monthlysupcharge = $_POST['monthlysupcharge'];
$fixedsercharg = $_POST['fixedsercharg'];


$client = $_POST['client'];
if($client==12 || $client==14){
	$client = "12,14";
}
$invno = $_POST['invno'];
$invdate = $_POST['invdate'];
$printtype = $_POST['printtype'];
$days =26;
include("../lib/connection/db-config.php");
include("../lib/class/user-class.php");
$userObj=new user();
$resclt=$userObj->displayClient($_POST['client']);
$cmonth=$resclt['current_month'];

 $tab = "temp_emerson_bill".$_SESSION['log_id'];
 
 $sqltab = "DROP TABLE IF EXISTS $tab" ;
 $rowtab= mysql_query($sqltab);

 $sql = "create table $tab (

 dept_id INT not null,
 desg_id INT not null,
 client_id INT not null,
 spl_allow_ip FLOAT not null,
 pf_percent_ip FLOAT not null,
 bonus_percent_ip FLOAT not null,
 esi_percent_ip FLOAT not null,
 lww_percent_ip FLOAT not null,
 lwf_percent_ip FLOAT not null,
 safetyapp_percent_ip FLOAT not null,
 other_charges_percent_ip FLOAT not null,
 trainingcharg_percent_ip  FLOAT not null,
 tds_percent_ip FLOAT not null,
 monthlysup_ip  FLOAT not null,
 servicecharge_percent_ip  FLOAT not null,
 cgst_percent_ip  FLOAT not null,
 sgst_percent_ip  FLOAT not null,
 igst_percent_ip  FLOAT not null,
 client_name varchar(100) not null,
 dept_name varchar(100) not null,
 desg_name varchar(100) not null,
 emp_name varchar(50) not null, 
 emp_id INT not null,
 sal_month DATE ,
 gross_salary FLOAT not null,
 netsalary INT not null,
 payabledays FLOAT not null,
 othours FLOAT not null,
 otrate FLOAT not null,

 

 
 basic_amt FLOAT not null,
 hra_amt FLOAT not null,
 da_amt  FLOAT not null,
 supplli_serve_allow_amt FLOAT not null,
 other_allow_amt FLOAT not null,
 super_skill_allow_amt FLOAT not null,
 overtime FLOAT not null,
 
 pf FLOAT not null,
 bonus FLOAT not null,
 esi FLOAT not null,
 lww FLOAT not null,
 lwf FLOAT not null,
 safetyapp FLOAT not null,
 soap FLOAT not null,
 trainingcharg FLOAT not null,
 tds FLOAT not null,

 supervisioncharges FLOAT not null,
 servicecharges FLOAT not null,

 
 
total_a_amt FLOAT not null,
total_b_amt FLOAT not null,
total_c_amt FLOAT not null,
total_abc_amt FLOAT not null,
total_d_amt FLOAT not null,
taxable FLOAT not null,

cgst FLOAT not null,
sgst FLOAT not null,
igst FLOAT not null,
final FLOAT not null,


db_adddate TIMESTAMP NOT NULL
) ENGINE = InnoDB";
$row= mysql_query($sql);

//CONSTRAINT idtempemersondata_pk PRIMARY KEY (emp_id);
  $sql ="ALTER TABLE $tab
  ADD UNIQUE KEY emp_id,client_id)";
  $row= mysql_query($sql);


  $sql1 = "insert into $tab (   
  
 spl_allow_ip , pf_percent_ip , bonus_percent_ip , esi_percent_ip , lww_percent_ip , lwf_percent_ip , safetyapp_percent_ip , other_charges_percent_ip , trainingcharg_percent_ip , tds_percent_ip ,monthlysup_ip  , servicecharge_percent_ip ,cgst_percent_ip,sgst_percent_ip,igst_percent_ip,
client_id,emp_id,sal_month,dept_id,desg_id,payabledays,gross_salary,netsalary,lwf,safetyapp,soap,trainingcharg,emp_name)
  
   select '$splallow' ,'$pf','$bonus','$esi','$lww','$lwf','$safetyapp','$other','$trainingcharg','$tds','$fixedsercharg', '$monthlysupcharge','$cgst','$sgst','$igst',te.client_id,te.emp_id,'$cmonth',te.dept_id,te.desg_id,te.payabledays,te.gross_salary,te.netsalary,
   $lwf,$safetyapp,$other,$trainingcharg,concat(e.first_name,' ',e.middle_name,' ' ,e.last_name) from tran_employee te inner join employee e on te.emp_id=e.emp_id  where te.client_id in(".$client.") group by e.client_id,e.emp_id"; 
   $setRec = mysql_query($sql1);
 
   $sql = "update  $tab eb inner join mast_client mc on mc.mast_client_id = eb.client_id inner join mast_dept md on md.mast_dept_id = eb.dept_id inner join mast_desg mdsg on mdsg.mast_desg_id= eb.desg_id set eb.dept_name = md.mast_dept_name,eb.desg_name=mdsg.mast_desg_name,eb.client_name= mc.client_name";
   $setRec = mysql_query($sql);
 
 
 
 //Updating Income 
	$sql2 = "update  $tab eb inner join tran_income ei on eb.emp_id=ei.emp_id and ei.head_id in ( 
    select  mast_income_heads_id from mast_income_heads mih  where (lower(mih.income_heads_name)) like '%basic%' and comp_id = '$comp_id' )  set eb.basic_amt = ei.amount";
	$setRec = mysql_query($sql2);
 
$sql2 = "update  $tab eb inner join tran_income ei on eb.emp_id=ei.emp_id and ei.head_id in ( 
    select  mast_income_heads_id from mast_income_heads mih  where (lower(mih.income_heads_name)) like '%D.A.%' and comp_id = '$comp_id')  set eb.da_amt = ei.amount";
	$setRec = mysql_query($sql2);
 
 $sql2 = "update  $tab eb inner join tran_income ei on eb.emp_id=ei.emp_id and ei.head_id in ( 
   select  mast_income_heads_id from mast_income_heads mih  where (lower(mih.income_heads_name)) like '%h.r.a.%' and comp_id = '$comp_id')  set eb.hra_amt = ei.amount";
 $setRec = mysql_query($sql2);
 
 //super skill allow
    $sql3 = "update  $tab eb inner join tran_income ei on eb.emp_id=ei.emp_id and ei.head_id in ( 
   select  mast_income_heads_id from  mast_income_heads mih  where (lower(mih.income_heads_name)) like '%supplement alw%' and comp_id = '$comp_id' )  set eb.super_skill_allow_amt = ei.amount";
 $setRec = mysql_query($sql3);
 
 //super other allow  OTHER ALLOW
  $sql3 = "update  $tab eb inner join tran_income ei on eb.emp_id=ei.emp_id and ei.head_id in ( 
   select  mast_income_heads_id from  mast_income_heads mih  where (lower(mih.income_heads_name)) like '%other allow%' and comp_id = '$comp_id')  set eb.other_allow_amt = ei.amount";
 $setRec = mysql_query($sql3);
 
 //super other allow  OTHER ALLOW
  $sql3 = "update  $tab eb inner join tran_income ei on eb.emp_id=ei.emp_id and ei.head_id in ( 
   select  mast_income_heads_id from  mast_income_heads mih  where (lower(mih.income_heads_name)) like '%overtime%' and comp_id = '$comp_id')  set eb.overtime = ei.amount";
 $setRec = mysql_query($sql3);
 // Income updation complete 
 
 
 //total a
    $sql4 = "update temp_emerson_bill3 set total_a_amt = (basic_amt+hra_amt+supplli_serve_allow_amt+other_allow_amt+super_skill_allow_amt+da_amt+overtime)";
 $setRec = mysql_query($sql4);
 
 $sql3 = "update temp_emerson_bill3 set pf = round((basic_amt+da_amt)* $pf/100,2),esi=round(total_a_amt*$esi/100 ,2), bonus = round((basic_amt+da_amt)* $bonus/100,2),lww = round(round(((total_a_amt-overtime)/payabledays)/26* $lww,2)*payabledays,2), lwf = round($lwf*payabledays,2),safetyapp= round($safetyapp*payabledays,2),trainingcharg =round($trainingcharg*payabledays,2),soap = round($other*payabledays,2) ,total_c_amt =  round(total_a_amt*$esi/100,2)+  round(round(((total_a_amt-overtime)/payabledays)/26* $lww,2)*payabledays,2)+round($lwf*payabledays,2)+round($safetyapp*payabledays,2)+round($trainingcharg*payabledays,2)+round('$other'*payabledays,2) ,total_b_amt =  round((basic_amt+da_amt)* $pf/100,2)+round((basic_amt+da_amt)* $bonus/100,2)
 ";
 $setRec = mysql_query($sql3);
 
 $sql3 = "update temp_emerson_bill3 set total_abc_amt =  round((total_a_amt +total_b_amt +total_c_amt),2) ,tds =  round((total_a_amt +total_b_amt +total_c_amt)*$tds/100 ,2), total_d_amt =  round(total_a_amt +total_b_amt +total_c_amt + round((total_a_amt +total_b_amt +total_c_amt)*$tds/100 ,2),0) ";
 $setRec = mysql_query($sql3);





 $sql3 = "update  temp_emerson_bill3 eb inner join tran_days td on eb.emp_id=td.emp_id  set eb.othours = td.othours";
 $setRec = mysql_query($sql3);
  
  $sql3 = "update  temp_emerson_bill3 eb inner join tran_income ti on eb.emp_id=ti.emp_id  set eb.overtime = ti.amount, otrate = ti.std_amt where ti.head_id in (select mast_income_heads_id from mast_income_heads where income_heads_name like '%OVERTIME%') ";
 $setRec = mysql_query($sql3);

 
$totpayable= 0;
$sql = "select sum(payabledays) as payabledays from temp_emerson_bill3";
 $setRec = mysql_query($sql);
  $row = mysql_fetch_array($setRec);
  $totpayable = $row['payabledays'];
  echo $monthlysupcharge;
$sql = "update temp_emerson_bill3 set supervisioncharges = round('$monthlysupcharge'/'$totpayable'* payabledays,2)";
$setRec = mysql_query($sql);

$sql = "update temp_emerson_bill3 set servicecharges = round((total_d_amt+supervisioncharges)*'$fixedsercharg'/100,2)";
$setRec = mysql_query($sql);

$sql = "update temp_emerson_bill3 set taxable = round((total_d_amt+supervisioncharges+servicecharges),2)";
$setRec = mysql_query($sql);


$sql = "update temp_emerson_bill3 set cgst = round(taxable*cgst_percent_ip/100,2),sgst = round(taxable*sgst_percent_ip/100,2),igst = round(taxable*igst_percent_ip/100,2)";
$setRec = mysql_query($sql);

$sql = "update temp_emerson_bill3 set final = round(taxable+cgst+sgst+igst,2)";
$setRec = mysql_query($sql);

 
 ///////// for printing ///////////////
 if($printtype==1){
	include_once("print-deptwise-emersion-bill.php");
 }else if($printtype==2){
	include_once("print-desgwise-emersion-bill.php"); 
 }elseif($printtype==3){
	include_once("print-client-deptwise-emersion-bill.php");  
 }
 
 //header("location:emerson-bill.php?data=1");
?>