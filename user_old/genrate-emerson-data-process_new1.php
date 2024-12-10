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
emp_id INT not null,
 sal_month DATE ,
 dept_id INT  NOT NULL,
 desg_id INT  NOT NULL,
 client_id INT  NOT NULL,
 client_name varchar(100)  NOT NULL,
 dept_name varchar(100)  NOT NULL,
 desg_name varchar(100)  NOT NULL,
 emp_name varchar(50)  NOT NULL, 
 
 payabledays_sal FLOAT  NOT NULL,
 othours_sal FLOAT  NOT NULL,
 otrate_sal FLOAT NOT NULL,
 basic_sal FLOAT  NOT NULL,
 hra_sal FLOAT  NOT NULL,
 da_sal  FLOAT  NOT NULL,
 supplli_allow_sal FLOAT NOT NULL, 
 other_allow_sal FLOAT  NOT NULL,
 super_skill_allow_sal FLOAT  NOT NULL,
 overtime_sal FLOAT  NOT NULL,
 gross_salary_sal FLOAT  NOT NULL,
 netsalary_sal float  NOT NULL,
 
 
 pf_sal FLOAT  NOT NULL,
 bonus_sal FLOAT  NOT NULL,
 esi_sal FLOAT  NOT NULL,
 lwf_sal FLOAT  NOT NULL,
 other_ded_sal FLOAT  NOT NULL,
 
 
 basic_monthly_annex FLOAT  NOT NULL,
 da_monthly_annex FLOAT  NOT NULL,
 hra_monthly_annex FLOAT  NOT NULL,
 super_skill_allow_monthly_annex FLOAT  NOT NULL,
 supplli_allow_monthly_annex FLOAT  NOT NULL,
  other_allow_monthly_annex FLOAT  NOT NULL,
 gross_monthly_annex FLOAT  NOT NULL,
 
 basic_daily_annex FLOAT  NOT NULL,
 da_daily_annex FLOAT  NOT NULL,
 hra_daily_annex FLOAT  NOT NULL,
 super_skill_allow_daily_annex FLOAT  NOT NULL,
 supplli_allow_daily_annex FLOAT  NOT NULL,
  other_allow_daily_annex FLOAT  NOT NULL,
 total_a_annex FLOAT  NOT NULL,
 
 pf_annex FLOAT  NOT NULL,
 bonus_Annex FLOAT  NOT NULL,
 total_b_annex FLOAT  NOT NULL,
 
 
 esi_annex FLOAT  NOT NULL,
 lww_annex FLOAT  NOT NULL,
 lwf_annex FLOAT  NOT NULL,
 safety_annex FLOAT  NOT NULL,
 soap_annex FLOAT  NOT NULL,
 training_annex FLOAT  NOT NULL,
 total_c_annex FLOAT  NOT NULL,
 
 total_ABC_annex FLOAT  NOT NULL,
 tds_Annex FLOAT  NOT NULL,
 total_d_annex FLOAT  NOT NULL,
 rounded_annex FLOAT  NOT NULL,
 
 emp_cnt_annex FLOAT  NOT NULL,
 bill_rate_annex float not null,
 ot_hours_annex float not null,
 ot_rate_annex FLOAT  NOT NULL,
 ot_conv_annex  FLOAT NOT NULL,
 ot_days_annex FLOAT  NOT NULL,
 ot_days_percent_annex FLOAT  NOT NULL,
 payable_days_annex FLOAT  NOT NULL,
 tot_payable_days_annex FLOAT  NOT NULL,
 
 no_of_units_annex FLOAT  NOT NULL,
 amount_annex FLOAT  NOT NULL,
 spl_allow_ip FLOAT  NOT NULL,
 pf_percent_ip FLOAT  NOT NULL,
 bonus_percent_ip FLOAT  NOT NULL,
 esi_percent_ip FLOAT  NOT NULL,
 lww_percent_ip FLOAT  NOT NULL,
 lwf_percent_ip FLOAT  NOT NULL,
 safetyapp_percent_ip FLOAT  NOT NULL,
 other_charges_percent_ip FLOAT  NOT NULL,
 trainingcharg_percent_ip  FLOAT  NOT NULL,
 tds_percent_ip FLOAT  NOT NULL,
 monthlysup_ip  FLOAT  NOT NULL,
 servicecharge_percent_ip  FLOAT  NOT NULL,
 cgst_percent_ip  FLOAT  NOT NULL,
 sgst_percent_ip  FLOAT  NOT NULL,
 igst_percent_ip  FLOAT  NOT NULL,
 
db_adddate TIMESTAMP not NULL
) ENGINE = InnoDB";

$row= mysql_query($sql);
$sql = "ALTER TABLE $tab
  ADD PRIMARY KEY (`emp_id`,`sal_month`);";
$row= mysql_query($sql);
  
//CONSTRAINT idtempemersondata_pk PRIMARY KEY (emp_id);
  $sql ="ALTER TABLE $tab
  ADD UNIQUE KEY emp_id,client_id)";
  $row= mysql_query($sql);


  
   $sql1 = "insert into $tab (   
  
 spl_allow_ip , pf_percent_ip , bonus_percent_ip , esi_percent_ip , lww_percent_ip , lwf_percent_ip , safetyapp_percent_ip , other_charges_percent_ip , trainingcharg_percent_ip , tds_percent_ip ,monthlysup_ip  , servicecharge_percent_ip ,cgst_percent_ip,sgst_percent_ip,igst_percent_ip,
client_id,emp_id,sal_month,desg_id,safety_annex,soap_annex,training_annex,emp_name,emp_cnt_annex)
  
   select '$splallow' ,'$pf','$bonus','$esi','$lww','$lwf','$safetyapp','$other','$trainingcharg','$tds','$fixedsercharg', '$monthlysupcharge','$cgst','$sgst','$igst',te.client_id,id,'$cmonth',te.design_id,$safetyapp,$other,$trainingcharg,'STD_Annex',te.no_of_employee from client_employee te   where te.client_id in(".$client.") "; 
   $setRec = mysql_query($sql1);
 
   $sql = "update  $tab eb inner join mast_client mc on mc.mast_client_id = eb.client_id  inner join mast_desg mdsg on mdsg.mast_desg_id= eb.desg_id set eb.desg_name=mdsg.mast_desg_name,eb.client_name= mc.client_name,payabledays_sal = 26";
   $setRec = mysql_query($sql);
 
 echo "<br>";
$sql= "select desg_id from $tab";
   $setRecd = mysql_query($sql);
while ($row = mysql_fetch_array($setRecd)){
	echo "<br><br>";
	echo $sql1 = "select distinct ti.head_id,ti.std_amt  from emp_income ti inner join employee e on e.emp_id = ti.emp_id where e.desg_id = ".$row['desg_id']." and e.client_id = $client  and ti.head_id = 5 order by std_amt desc limit 1";
	$setRec1 = mysql_query($sql1);
	$row1 = mysql_fetch_array($setRec1);
 	

	echo $sql2 = "update  $tab eb   set eb.basic_sal = ".$row1['std_amt'].",eb.basic_daily_annex = round(".$row1['std_amt']."/26,2),eb.basic_monthly_annex = round(".$row1['std_amt'].",2) where eb.desg_id = ".$row['desg_id'];
	$setRec = mysql_query($sql2);
	
   ////////////////
 	$sql1 = "select distinct ti.head_id,ti.std_amt  from emp_income ti inner join employee e on e.emp_id = ti.emp_id where e.desg_id = ".$row['desg_id']." and e.client_id = $client  and ti.head_id = 6 order by std_amt desc limit 1";
	$setRec1 = mysql_query($sql1);
	$row1 = mysql_fetch_array($setRec1);
 	
	echo "<br>";  
    echo  $sql2 = "update  $tab eb   set eb.da_sal = ".$row1['std_amt'].",eb.da_daily_annex = round(".$row1['std_amt']."/26,2),eb.da_monthly_annex = round(".$row1['std_amt'].",2) where eb.desg_id = ".$row['desg_id'];
	$setRec = mysql_query($sql2);
	
 
   ////////////////
 	$sql1 = "select distinct ti.head_id,ti.std_amt  from emp_income ti inner join employee e on e.emp_id = ti.emp_id where e.desg_id = ".$row['desg_id']." and e.client_id = $client  and ti.head_id = 7 order by std_amt desc limit 1";
	$setRec1 = mysql_query($sql1);
	$row1 = mysql_fetch_array($setRec1);
 	
	echo "<br>";  
    echo  $sql2 = "update  $tab eb   set eb.hra_sal = ".$row1['std_amt'].",eb.hra_daily_annex = round(".$row1['std_amt']."/26,2),eb.hra_monthly_annex = round(".$row1['std_amt'].",2) where eb.desg_id = ".$row['desg_id'];
	$setRec = mysql_query($sql2); 
  ////////////////
 	$sql1 = "select distinct ti.head_id,ti.std_amt  from emp_income ti inner join employee e on e.emp_id = ti.emp_id where e.desg_id = ".$row['desg_id']." and e.client_id = $client  and ti.head_id = 49 order by std_amt desc limit 1";
	$setRec1 = mysql_query($sql1);
	$row1 = mysql_fetch_array($setRec1);
 	
	echo "<br>";  
    echo  $sql2 = "update  $tab eb   set eb.suppli_allow_sal = ".$row1['std_amt'].",eb. suppli_allow_daily_annex = round(".$row1['std_amt']."/26,2),eb. suppli_allow_monthly_annex = round(".$row1['std_amt'].",2) where eb.desg_id = ".$row['desg_id'];
	$setRec = mysql_query($sql2);
 
 
}
 
 
 // Income updation complete 
 

 
  
  
  
  
  
   $sql1 = "insert into $tab (   
  
 spl_allow_ip , pf_percent_ip , bonus_percent_ip , esi_percent_ip , lww_percent_ip , lwf_percent_ip , safetyapp_percent_ip , other_charges_percent_ip , trainingcharg_percent_ip , tds_percent_ip ,monthlysup_ip  , servicecharge_percent_ip ,cgst_percent_ip,sgst_percent_ip,igst_percent_ip,
client_id,emp_id,sal_month,dept_id,desg_id,payabledays_sal, gross_salary_sal,netsalary_sal,lwf_sal,safety_annex,soap_annex,training_annex,emp_name)
  
   select '$splallow' ,'$pf','$bonus','$esi','$lww','$lwf','$safetyapp','$other','$trainingcharg','$tds','$fixedsercharg', '$monthlysupcharge','$cgst','$sgst','$igst',te.client_id,te.emp_id,'$cmonth',te.dept_id,te.desg_id,te.payabledays,te.gross_salary,te.netsalary,
   $lwf,$safetyapp,$other,$trainingcharg,concat(e.first_name,' ',e.middle_name,' ' ,e.last_name) from tran_employee te inner join employee e on te.emp_id=e.emp_id  where te.client_id in(".$client.") group by e.client_id,e.emp_id"; 
   $setRec = mysql_query($sql1);
 
   $sql = "update  $tab eb inner join mast_client mc on mc.mast_client_id = eb.client_id inner join mast_dept md on md.mast_dept_id = eb.dept_id inner join mast_desg mdsg on mdsg.mast_desg_id= eb.desg_id set eb.dept_name = md.mast_dept_name,eb.desg_name=mdsg.mast_desg_name,eb.client_name= mc.client_name";
   $setRec = mysql_query($sql);
 
  $sql3 = "update  temp_emerson_bill3 eb inner join tran_days td on eb.emp_id=td.emp_id  set eb.othours_sal = td.othours";
 $setRec = mysql_query($sql3);
  
 
 //Updating Income 
	$sql2 = "update  $tab eb inner join tran_income ei on eb.emp_id=ei.emp_id and ei.head_id in ( 
    select  mast_income_heads_id from mast_income_heads mih  where (lower(mih.income_heads_name)) like '%basic%' and comp_id = '$comp_id' )  set eb.basic_sal = ei.amount,eb.basic_daily_annex = round(ei.amount/eb.payabledays_sal,2),eb.basic_monthly_annex = round(ei.amount/eb.payabledays_sal*26,2) where eb.emp_name != 'STD_Annex'";
	$setRec = mysql_query($sql2);
 
$sql2 = "update  $tab eb inner join tran_income ei on eb.emp_id=ei.emp_id and ei.head_id in ( 
    select  mast_income_heads_id from mast_income_heads mih  where (lower(mih.income_heads_name)) like '%D.A.%' and comp_id = '$comp_id')  set eb.da_sal = ei.amount,eb.da_daily_annex = round(ei.amount/eb.payabledays_sal,2),eb.da_monthly_annex = round(ei.amount/eb.payabledays_sal*26,2) where eb.emp_name != 'STD_Annex'";
	$setRec = mysql_query($sql2);
 
 $sql2 = "update  $tab eb inner join tran_income ei on eb.emp_id=ei.emp_id and ei.head_id in ( 
   select  mast_income_heads_id from mast_income_heads mih  where (lower(mih.income_heads_name)) like '%h.r.a.%' and comp_id = '$comp_id')  set eb.hra_sal = ei.amount,eb.hra_daily_annex = round(ei.amount/eb.payabledays_sal,2),eb.hra_monthly_annex = round(ei.amount/eb.payabledays_sal*26,2) where eb.emp_name != 'STD_Annex'";
 $setRec = mysql_query($sql2);
 
 //super skill allow
    $sql3 = "update  $tab eb inner join tran_income ei on eb.emp_id=ei.emp_id and ei.head_id in ( 
   select  mast_income_heads_id from  mast_income_heads mih  where (lower(mih.income_heads_name)) like '%supplement alw%' and comp_id = '$comp_id' )  set eb.super_skill_allow_sal = ei.amount,eb.super_skill_allow_daily_annex = round(ei.amount/eb.payabledays_sal,2),eb.super_skill_allow_monthly_annex = round(ei.amount/eb.payabledays_sal*26,2) where eb.emp_name != 'STD_Annex'";
 $setRec = mysql_query($sql3);
 
 //super other allow  OTHER ALLOW
  $sql3 = "update  $tab eb inner join tran_income ei on eb.emp_id=ei.emp_id and ei.head_id in ( 
   select  mast_income_heads_id from  mast_income_heads mih  where (lower(mih.income_heads_name)) like '%other allow%' and comp_id = '$comp_id')  set eb.other_allow_sal = ei.amount,eb.other_allow_daily_annex = round(ei.amount/eb.payabledays_sal,2),eb.other_allow_monthly_annex = round(ei.amount/eb.payabledays_sal*26,2)where eb.emp_name != 'STD_Annex'";
 $setRec = mysql_query($sql3);
 
 //super other allow  OTHER ALLOW
  $sql3 = "update  $tab eb inner join tran_income ei on eb.emp_id=ei.emp_id and ei.head_id in ( 
   select  mast_income_heads_id from  mast_income_heads mih  where (lower(mih.income_heads_name)) like '%overtime%' and comp_id = '$comp_id')  set eb.overtime_sal = ei.amount,eb.otrate_sal = ei.std_amt where eb.emp_name != 'STD_Annex'";
 $setRec = mysql_query($sql3);
 
 $sql3 = "update  $tab eb  set eb.otrate_sal = 0 where eb.overtime_sal = 0 where eb.emp_name != 'STD_Annex'";
 $setRec = mysql_query($sql3);
 
 // Income updation complete 
 
//#################################################################################################################### 
 
//Updating salary deduction
	$sql2 = "update  $tab eb inner join tran_deduct ei on eb.emp_id=ei.emp_id and ei.head_id in ( 
    select  mast_deduct_heads_id from mast_deduct_heads mih  where (lower(mih.deduct_heads_name)) like '%P.F.%' and comp_id = '$comp_id' )  set eb.pf_sal = ei.amount where eb.emp_name != 'STD_Annex'";
	$setRec = mysql_query($sql2);
 
 
	$sql2 = "update  $tab eb inner join tran_deduct ei on eb.emp_id=ei.emp_id and ei.head_id in ( 
    select  mast_deduct_heads_id from mast_deduct_heads mih  where (lower(mih.deduct_heads_name)) like '%E.S.I.%' and comp_id = '$comp_id' )  set eb.esi_sal = ei.amount where eb.emp_name != 'STD_Annex'";
	$setRec = mysql_query($sql2);
	
		$sql2 = "update  $tab eb inner join tran_deduct ei on eb.emp_id=ei.emp_id and ei.head_id in ( 
    select  mast_deduct_heads_id from mast_deduct_heads mih  where (lower(mih.deduct_heads_name)) like '%L.W.F.%' and comp_id = '$comp_id' )  set eb.lwf_sal = ei.amount where eb.emp_name != 'STD_Annex'";
	$setRec = mysql_query($sql2);
	
 	$sql2 = "update  $tab eb inner join tran_deduct ei on eb.emp_id=ei.emp_id and ei.head_id in ( 
    select  mast_deduct_heads_id from mast_deduct_heads mih  where (lower(mih.deduct_heads_name)) not in ('%L.W.F.%','%E.S.I.%','%P.F.%') and comp_id = '$comp_id' )  set eb.other_ded_sal = ei.amount where eb.emp_name != 'STD_Annex'";
	//$setRec = mysql_query($sql2);
 
 
 //total a
  

 $sql4 = "update $tab set total_a_annex = (basic_daily_annex+da_daily_annex +hra_daily_annex+super_skill_allow_daily_annex+other_allow_daily_annex), gross_monthly_annex =basic_monthly_annex +da_monthly_annex + hra_monthly_annex +super_skill_allow_monthly_annex+ supplli_allow_monthly_annex+other_allow_monthly_annex ";
 $setRec = mysql_query($sql4);
 
 //$payabledays = 1;
 $sql ="update $tab eb set payabledays_sal =1 where emp_name = 'STD_Annex'";
 $setRec = mysql_query($sql);
 
 
   $sql3 = "update $tab set pf_annex = round((basic_daily_annex+da_daily_annex)* $pf/100,2),esi_annex=round(total_a_annex*$esi/100 ,2), bonus_annex = round((basic_daily_annex+da_daily_annex)* $bonus/100,2),lww_annex = round(round(((total_a_annex)/payabledays_sal)/26* $lww,2)*payabledays_sal,2), lwf_annex = round($lwf*payabledays_sal,2),safety_annex= round($safetyapp*payabledays_sal,2),training_annex =round($trainingcharg*payabledays_sal,2),soap_annex = round($other*payabledays_sal,2) ,total_c_annex =  round(total_a_annex*$esi/100,2)+  round(round(((total_a_annex)/payabledays_sal)/26* $lww,2)*payabledays_sal,2)+round($lwf*payabledays_sal,2)+round($safetyapp*payabledays_sal,2)+round($trainingcharg*payabledays_sal,2)+round('$other'*payabledays_sal,2) ,total_b_annex =  round((basic_daily_annex+da_daily_annex)* $pf/100,2)+round((basic_daily_annex+da_daily_annex)* $bonus/100,2)
  ";
 $setRec = mysql_query($sql3);
 
 echo "<br><br>";
  echo  $sql3 = "update $tab set total_abc_annex =  round((total_a_annex +total_b_annex +total_c_annex),2) ,tds_Annex =  round((total_a_annex +total_b_annex +total_c_annex)*$tds/100 ,2), total_d_annex =  round(total_a_annex +total_b_annex +total_c_annex + round((total_a_annex +total_b_annex +total_c_annex)*$tds/100 ,2),2),rounded_annex =  round(total_a_annex +total_b_annex +total_c_annex + round((total_a_annex +total_b_annex +total_c_annex)*$tds/100 ,2),0),bill_rate_annex = emp_cnt_annex*rounded_annex, ot_rate_annex = round(total_a_annex/4,2)";
 $setRec = mysql_query($sql3);
 
 echo "<br><br>";
  echo  $sql3 = "update $tab set ot_conv_annex = round((total_a_annex+esi_annex)/rounded_annex*100,2)";
 $setRec = mysql_query($sql3);
  
  

echo $sql = "update $tab eb inner join (select desg_id,sum(othours_sal) as ot_sal ,sum(payabledays_sal) as payabledays from $tab eb2  where eb2.emp_name != 'STD_Annex' group by desg_id) eb3 on eb3.desg_id = eb.desg_id set eb.ot_hours_annex = eb3.ot_sal,eb.ot_days_annex = round(eb3.ot_sal/8*2,2) ,eb.payable_days_annex = eb3.payabledays where eb.emp_name = 'STD_Annex'";
 $setRec = mysql_query($sql);
 
 



 
echo "<br><br>";echo  $sql3 = "update $tab set ot_days_percent_annex = round((ot_conv_annex/100)*ot_days_annex,2)";
 $setRec = mysql_query($sql3);

 echo "<br><br>"; echo  $sql3 = "update $tab set tot_payable_days_annex = round((ot_days_percent_annex +payable_days_annex),2)";
 $setRec = mysql_query($sql3);

 echo "<br><br>"; echo  $sql3 = "update $tab set no_of_units_annex = round(tot_payable_days_annex/emp_cnt_annex,2),amount_annex =   round(round(tot_payable_days_annex/emp_cnt_annex,2)*bill_rate_annex,2)";
 $setRec = mysql_query($sql3);
 
 exit;
 
$sql = "select * from temp_emerson_bill3";
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
$setExcelName = "emerson";
//This Header is used to make data download instead of display the data
header("Content-type: application/octet-stream");

header("Content-Disposition: attachment; filename=".$setExcelName.".xls");

header("Pragma: no-cache");
header("Expires: 0");

//It will print all the Table row as Excel file row with selected column name as header.
echo ucwords($setMainHeader)."\n".$setData."\n";

exit;

$totpayable= 0;
$sql = "select sum(payabledays_sal) as payabledays from temp_emerson_bill3";
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