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
$frdt = $_POST['frdt'];
$monthlysupcharge = $_POST['monthlysupcharge'];
$fixedsercharg = $_POST['fixedsercharg'];


$client = $_POST['client'];
$tab_client = $client;
 if($client==12 || $client==14){
	$client = "12,14";
	$tab_client = "1214";
} 
$tab = "tran_emerson_bill".$tab_client;
$invno = $_POST['invno'];
$invdate = $_POST['invdate'];
 $printtype = $_POST['printtype'];
$days =26;
include("../lib/connection/db-config.php");
include("../lib/class/user-class.php");
$userObj=new user();
$resclt=$userObj->displayClient($_POST['client']);
$cmonth=$resclt['current_month'];
$_SESSION['emer_month']=date('Y-m-d',strtotime($frdt));


if (date('F Y',strtotime($cmonth)) != date('F Y',strtotime($frdt)))
{
	
  if($printtype==1){
	include_once("print-deptwise-emerson-bill_new.php");
 }else if($printtype==2){
	include_once("print-desgwise-emerson-bill_new.php"); 
 }elseif($printtype==3){
	include_once("print-client-deptwise-emerson-bill_new.php");  
 }elseif($printtype==4){
	include_once("print-dept_desgwise-emerson-bill_new2.php");  
 }elseif($printtype==5){
	include_once("print_amp_new.php");  
 } else if($printtype==6){
	include_once("print_summary_new.php");  
 }else if($printtype==7){
 include_once ("emerson_bill_new.php");
 }else if($printtype==8){
 include_once ("emerson_bill_new_excel.php");
 }


}
 //$tab = "temp_emerson_bill".$_SESSION['log_id'];
 
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
 
 payabledays_sal float(12,2)  NOT NULL,
 othours_sal float(12,2)  NOT NULL,
 otrate_sal float(12,2) NOT NULL,
 basic_sal float(12,2)  NOT NULL,
 hra_sal float(12,2)  NOT NULL,
 da_sal  float(12,2)  NOT NULL,
 supplli_allow_sal float(12,2) NOT NULL, 
 other_allow_sal float(12,2)  NOT NULL,
 super_skill_allow_sal float(12,2)  NOT NULL,
 overtime_sal float(12,2) not null,
 gross_monthly_annex float(12,2)  NOT NULL,
 
 basic_daily_annex float(12,2)  NOT NULL,
 da_daily_annex float(12,2)  NOT NULL,
 hra_daily_annex float(12,2)  NOT NULL,
 super_skill_allow_daily_annex float(12,2)  NOT NULL,
 supplli_allow_daily_annex float(12,2)  NOT NULL,
  other_allow_daily_annex float(12,2)  NOT NULL,
 total_a_annex float(12,2)  NOT NULL,
 
 pf_annex float(12,2)  NOT NULL,
 bonus_Annex float(12,2)  NOT NULL,
 total_b_annex float(12,2)  NOT NULL,
 
 
 esi_annex float(12,2)  NOT NULL,
 lww_annex float(12,2)  NOT NULL,
 lwf_annex float(12,2)  NOT NULL,
 safety_annex float(12,2)  NOT NULL,
 soap_annex float(12,2)  NOT NULL,
 training_annex float(12,2)  NOT NULL,
 total_c_annex float(12,2)  NOT NULL,
 
 total_ABC_annex float(12,2)  NOT NULL,
 tds_Annex float(12,2)  NOT NULL,
 total_d_annex float(12,2)  NOT NULL,
 rounded_annex float(12,2)  NOT NULL,
 
 emp_cnt_annex float(12,2)  NOT NULL,
 bill_rate_annex float(12,2) not null,
 ot_hours_annex float(12,2) not null,
 ot_rate_annex float(12,2)  NOT NULL,
 ot_conv_annex  float(12,2) NOT NULL,
 ot_days_annex float(12,2)  NOT NULL,
 ot_days_percent_annex float(12,2)  NOT NULL,
 payable_days_annex float(12,2)  NOT NULL,
 tot_payable_days_annex float(12,2)  NOT NULL,
 
 no_of_units_annex float(12,2)  NOT NULL,
 servicecharges float(12,2) not null,
 
 supervisioncharges float(12,2) not null,
 amount_annex float(12,2)  NOT NULL,
 
 sgst_annex float(12,2)  NOT NULL,
 cgst_annex float(12,2)  NOT NULL,
 igst_annex float(12,2)  NOT NULL,
 tot_amount_annex float(12,2)  NOT NULL,

 spl_allow_ip float(12,2)   NULL,
 
 pf_percent_ip float(12,2)  NULL,
 bonus_percent_ip float(12,2)   NULL,
 esi_percent_ip float(12,2)   NULL,
 lww_percent_ip float(12,2)   NULL,
 lwf_percent_ip float(12,2)   NULL,
 safetyapp_percent_ip float(12,2)   NULL,
 other_charges_percent_ip float(12,2)   NULL,
 trainingcharg_percent_ip  float(12,2)   NULL,
 tds_percent_ip float(12,2)   NULL,
 monthlysup_ip  float(12,2)   NULL,
 servicecharge_percent_ip  float(12,2)   NULL,
 cgst_percent_ip  float(12,2)   NULL,
 sgst_percent_ip  float(12,2)   NULL,
 igst_percent_ip  float(12,2)   NULL,
 
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

   $sql = "update  $tab eb inner join mast_client mc on mc.mast_client_id = eb.client_id  inner join mast_desg mdsg on mdsg.mast_desg_id= eb.desg_id set eb.desg_name=mdsg.mast_desg_name,eb.client_name= right(mc.client_name,5),payabledays_sal = 26";
   $setRec = mysql_query($sql);
 
 $sql= "select desg_id from $tab";
   $setRecd = mysql_query($sql);
   
while ($row = mysql_fetch_array($setRecd)){

	   $sql1 = "select distinct ti.head_id,ti.std_amt,ti.emp_id  from emp_income ti inner join employee e on e.emp_id = ti.emp_id where e.desg_id = ".$row['desg_id']." and e.client_id in( 12,14,15,16)  and ti.head_id = 5 order by std_amt desc limit 1";
	$setRec1 = mysql_query($sql1);
	$row1 = mysql_fetch_array($setRec1);
 	 
//	 echo  $row1['std_amt']."<br>";

	 $sql2 = "update  $tab eb   set eb.basic_sal = ".$row1['std_amt'].",eb.basic_daily_annex = round(".$row1['std_amt']."/26,2) where eb.desg_id = ".$row['desg_id'];
	$setRec = mysql_query($sql2);
	
   ////////////////
 	 $sql1 = "select distinct ti.head_id,ti.std_amt  from emp_income ti inner join employee e on e.emp_id = ti.emp_id where e.desg_id = ".$row['desg_id']." and e.client_id in ( 12,14,15,16)  and ti.head_id = 6 order by std_amt desc limit 1";
	$setRec1 = mysql_query($sql1);
	$row1 = mysql_fetch_array($setRec1);
 	

      $sql2 = "update  $tab eb   set eb.da_sal = ".$splallow.",eb.da_daily_annex = round(".$splallow."/26,2) where eb.desg_id = ".$row['desg_id'];
	$setRec = mysql_query($sql2);
	
 
   ////////////////
 	$sql1 = "select distinct ti.head_id,ti.std_amt  from emp_income ti inner join employee e on e.emp_id = ti.emp_id where e.desg_id = ".$row['desg_id']." and e.client_id in (12,14,15,16)  and ti.head_id = 7 order by std_amt desc limit 1";
	$setRec1 = mysql_query($sql1);
	$row1 = mysql_fetch_array($setRec1);
 	
	  
      $sql2 = "update  $tab eb   set eb.hra_sal = ".$row1['std_amt'].",eb.hra_daily_annex = round(".$row1['std_amt']."/26,2) where eb.desg_id = ".$row['desg_id'];
	$setRec = mysql_query($sql2); 
  ////////////////
 	$sql1 = "select distinct ti.head_id,ti.std_amt  from emp_income ti inner join employee e on e.emp_id = ti.emp_id where e.desg_id = ".$row['desg_id']." and e.client_id in( 12,14,15,16) and ti.head_id = 49 order by std_amt desc limit 1";
	$setRec1 = mysql_query($sql1);
	$row1 = mysql_fetch_array($setRec1);
 	
	 $sql2 = "update  $tab eb   set eb.supplli_allow_sal = ".$row1['std_amt'].",eb. supplli_allow_daily_annex = round(".$row1['std_amt']."/26,2) where eb.desg_id = ".$row['desg_id'];
 	
	$setRec = mysql_query($sql2);
 
     
 
}
 
 $sql4 = "update $tab set  gross_monthly_annex =basic_sal +da_sal + hra_sal +super_skill_allow_sal+ supplli_allow_sal+other_allow_sal ";
 $setRec = mysql_query($sql4);
 
 // Income updation complete 
 

 
  
  
  
  
  
 $sql1 = "insert into $tab (   client_id,emp_id,sal_month,dept_id,desg_id,payabledays_sal,emp_name)
  
   select te.client_id,te.emp_id,'$cmonth',te.dept_id,te.desg_id,te.payabledays,concat(e.first_name,' ',e.middle_name,' ' ,e.last_name) from tran_employee te inner join employee e on te.emp_id=e.emp_id  where te.client_id in(".$client.")  "; 
   $setRec = mysql_query($sql1);

 
   $sql = "update  $tab eb inner join mast_client mc on mc.mast_client_id = eb.client_id inner join mast_dept md on md.mast_dept_id = eb.dept_id inner join mast_desg mdsg on mdsg.mast_desg_id= eb.desg_id set eb.dept_name = md.mast_dept_name,eb.desg_name=mdsg.mast_desg_name,eb.client_name= mc.client_name";
   $setRec = mysql_query($sql);
 
 $sql3 = "update  $tab eb inner join tran_days td on eb.emp_id=td.emp_id  set eb.othours_sal = td.othours,ot_hours_annex = td.othours";

 $setRec = mysql_query($sql3);

 
  	$sql2 = "update  $tab eb inner join tran_income ei on eb.emp_id=ei.emp_id and ei.head_id in ( 
    select  mast_income_heads_id from mast_income_heads mih  where (lower(mih.income_heads_name)) like '%OVERTIME%' and comp_id = '$comp_id' )  set eb.overtime_sal = ei.amount,eb.otrate_sal= ei.std_amt where eb.emp_name != 'STD_Annex'";
	$setRec = mysql_query($sql2);
 

 //Updating Income

	 $sql2 = "update  $tab eb inner join (select  * from $tab where emp_name ='STD_Annex') eb2 on eb.desg_id = eb2.desg_id 
					 set eb. basic_daily_annex = round(eb.payabledays_sal* eb2.basic_daily_annex,2),
						 eb. da_daily_annex = round(eb.payabledays_sal* eb2.da_daily_annex,2),
						 eb. hra_daily_annex = round(eb.payabledays_sal* eb2.hra_daily_annex,2),
						 eb. super_skill_allow_daily_annex = round(eb.payabledays_sal* eb2.super_skill_allow_daily_annex,2),
						 eb. supplli_allow_daily_annex = round(eb.payabledays_sal* eb2.supplli_allow_daily_annex,2),
						 eb. other_allow_daily_annex = round(eb.payabledays_sal* eb2.other_allow_daily_annex,2),eb.gross_monthly_annex = eb2.gross_monthly_annex,eb.emp_cnt_annex = 1  where eb.emp_name !='STD_Annex'";
						 
	$setRec = mysql_query($sql2);
 	

 
	
//#################################################################################################################### 
 
 
 //total a
  
 $sql ="update $tab eb set payabledays_sal =1 where emp_name = 'STD_Annex'";
 $setRec = mysql_query($sql);
 
 $sql4 = "update $tab set total_a_annex = round((basic_daily_annex+da_daily_annex +hra_daily_annex+super_skill_allow_daily_annex+other_allow_daily_annex+supplli_allow_daily_annex),2) ";
 $setRec = mysql_query($sql4);
 
 //$payabledays = 1;

 
   $sql3 = "update $tab set pf_annex = round((basic_daily_annex+da_daily_annex+supplli_allow_daily_annex)* $pf/100,2),esi_annex=round(total_a_annex*$esi/100 ,2), bonus_annex = round((basic_daily_annex+da_daily_annex)* $bonus/100,2),lww_annex = round(round(((total_a_annex)/payabledays_sal)/26* $lww,2)*payabledays_sal,2), lwf_annex = round($lwf*payabledays_sal,2),safety_annex= round($safetyapp*payabledays_sal,2),training_annex =round($trainingcharg*payabledays_sal,2),soap_annex = round($other*payabledays_sal,2) ,total_c_annex =  round(total_a_annex*$esi/100,2)+  round(round(((total_a_annex)/payabledays_sal)/26* $lww,2)*payabledays_sal,2)+round($lwf*payabledays_sal,2)+round($safetyapp*payabledays_sal,2)+round($trainingcharg*payabledays_sal,2)+round('$other'*payabledays_sal,2) ,total_b_annex =  round((basic_daily_annex+da_daily_annex+supplli_allow_daily_annex)* $pf/100,2)+round((basic_daily_annex+da_daily_annex)* $bonus/100,2)
  ";
 $setRec = mysql_query($sql3);
 
   $sql3 = "update $tab set pf_annex =75,esi_annex=round(total_a_annex*$esi/100 ,2), bonus_annex = round((basic_daily_annex+da_daily_annex)* $bonus/100,2),lww_annex = round(round(((total_a_annex)/payabledays_sal)/26* $lww,2)*payabledays_sal,2), lwf_annex = round($lwf*payabledays_sal,2),safety_annex= round($safetyapp*payabledays_sal,2),training_annex =round($trainingcharg*payabledays_sal,2),soap_annex = round($other*payabledays_sal,2) ,total_c_annex =  round(total_a_annex*$esi/100,2)+  round(round(((total_a_annex)/payabledays_sal)/26* $lww,2)*payabledays_sal,2)+round($lwf*payabledays_sal,2)+round($safetyapp*payabledays_sal,2)+round($trainingcharg*payabledays_sal,2)+round('$other'*payabledays_sal,2) ,total_b_annex =  75+round((basic_daily_annex+da_daily_annex)* $bonus/100,2) where  pf_annex >75;
  ";
 $setRec = mysql_query($sql3);
 
  
    $sql3 = "update $tab set total_abc_annex =  round((total_a_annex +total_b_annex +total_c_annex),2) ,tds_Annex =  round((total_a_annex +total_b_annex +total_c_annex)*$tds/100 ,2), total_d_annex =  round(total_a_annex +total_b_annex +total_c_annex + round((total_a_annex +total_b_annex +total_c_annex)*$tds/100 ,2),2),rounded_annex =  round(total_a_annex +total_b_annex +total_c_annex + round((total_a_annex +total_b_annex +total_c_annex)*$tds/100 ,2),0),bill_rate_annex = emp_cnt_annex*rounded_annex, ot_rate_annex = round(total_a_annex/(payabledays_sal*4),2)";
 $setRec = mysql_query($sql3);
 
 
   $sql3 = "update $tab set ot_conv_annex = round((total_a_annex+esi_annex)/rounded_annex*100,2)";
 $setRec = mysql_query($sql3);
  
  echo "<br>";
 $sql = "update $tab eb inner join (select desg_id,sum(othours_sal) as othours ,sum(payabledays_sal) as payabledays from $tab eb2  where eb2.emp_name != 'STD_Annex' group by desg_id) eb3 on eb3.desg_id = eb.desg_id set eb.ot_hours_annex =  eb3.othours,eb.ot_days_annex = round(eb3.othours/8*2,2) ,eb.payable_days_annex = eb3.payabledays where eb.emp_name = 'STD_Annex' ";
//
 $setRec = mysql_query($sql);
 

  echo "<br>";
 $sql = "update $tab set ot_days_annex = round(ot_hours_annex/8*2,2), payable_days_annex = payabledays_sal where emp_name != 'STD_Annex' ";

 $setRec = mysql_query($sql);

   
   
//echo $sql = "update $tab eb set eb.ot_hours_annex = eb.othours_sal,eb.ot_days_annex = round(eb.othours_sal/8*2,2) ,eb.payable_days_annex = eb3.payabledays_sal where eb.emp_name = 'STD_Annex'";
 //$setRec = mysql_query($sql);



 
  $sql3 = "update $tab set ot_days_percent_annex = round((ot_conv_annex/100)*ot_days_annex,2)";
 $setRec = mysql_query($sql3);

   $sql3 = "update $tab set tot_payable_days_annex = round((ot_days_percent_annex +payable_days_annex),2)";
 $setRec = mysql_query($sql3);

  $sql3 = "update $tab set no_of_units_annex = round(tot_payable_days_annex/emp_cnt_annex,2),amount_annex =   round(round(tot_payable_days_annex/emp_cnt_annex,2)*bill_rate_annex,2)";
 $setRec = mysql_query($sql3);
 


$totpayable= 0;
$sql = "select sum(payabledays_sal) as payabledays from $tab where emp_name != 'STD_Annex'";
 $setRec = mysql_query($sql);
  $row = mysql_fetch_array($setRec);
  $totpayable = $row['payabledays'];
   $monthlysupcharge;
  
 $sql = "update $tab set supervisioncharges = round($monthlysupcharge/$totpayable* payabledays_sal,2) ";
$setRec = mysql_query($sql);
$sql = "update $tab set servicecharges = round((total_d_annex+supervisioncharges)*$fixedsercharg/100,2)";
$setRec = mysql_query($sql);
$sql = "update $tab set amount_annex = round((total_d_annex+supervisioncharges+servicecharges),2) where emp_name != 'STD_Annex'";
$setRec = mysql_query($sql);


 $sql = "update $tab set cgst_annex = round(amount_annex*$cgst/100,2),sgst_annex = round(amount_annex*$sgst/100,2),igst_annex = round(amount_annex*$igst/100,2)";
$setRec = mysql_query($sql);
$sql = "update $tab set tot_amount_annex = round(amount_annex+cgst_annex+sgst_annex+igst_annex,2)";
$setRec = mysql_query($sql);


//include ("emerson_bill_new.php");


/* 
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
$setExcelName = "emerson";
//This Header is used to make data download instead of display the data
header("Content-type: application/octet-stream");

header("Content-Disposition: attachment; filename=".$setExcelName.".xls");

header("Pragma: no-cache");
header("Expires: 0");

//It will print all the Table row as Excel file row with selected column name as header.
echo ucwords($setMainHeader)."\n".$setData."\n";
 */
 ///////// for printing ///////////////
 if($printtype==1){
	include_once("print-deptwise-emerson-bill_new.php");
 }else if($printtype==2){
	include_once("print-desgwise-emerson-bill_new.php"); 
 }elseif($printtype==3){
	include_once("print-client-deptwise-emerson-bill_new.php");  
 }elseif($printtype==4){
	
	include_once("print-dept_desgwise-emerson-bill_new2.php");  
 }elseif($printtype==5){
	include_once("print_amp_new.php");  
 }
 elseif($printtype==6){
	include_once("print_summary_new.php");  
 }else if($printtype==7){
 include_once ("emerson_bill_new_r.php");
 }else if($printtype==8){
 include_once ("emerson_bill_new_excel.php");
 }
 
 //header("location:emerson-bill.php?data=1");


?>



<!--SELECT  `dept_name`,  cnt(emp_id) as cnt,sum( `payabledays_sal`_payabledays_sal,sum( `othours_sal`) as ,othours_sal,sum(  `overtime_sal`) as overtime_sal,sum(`basic_daily_annex`) as basic_daily_annex, sum(`da_daily_annex`) as da_daily_annex, sum(`hra_daily_annex`) as hra_daily_annex, sum(`super_skill_allow_daily_annex`) as super_skill_allow_daily_annex , sum(`supplli_allow_daily_annex) as supplli_allow_daily_annex`, sum(`other_allow_daily_annex`) as other_allow_daily_annex, sum`total_a_annex`+overtime_sal) as gross, sum(`pf_annex`) as pf_annex,sum( `bonus_Annex`+ `esi_annex`+ `lww_annex`+ `lwf_annex`, +`safety_annex`+ `soap_annex`+ `training_annex`) as other_charges,sum(supervision) as supervision,sum(service) as service,sum(cgst_annex) as cgst_annex,sum(sgst_annex) as sgst_annex,sum(cgst_annex+sgst_annex) as gst_annex, sum(`tot_amount_annex`) as tot_amount_annex  FROM `temp_emerson_bill16` group by dept_name-->