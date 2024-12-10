<?php
error_reporting(0);
session_start();
echo "***********";
exit;
include("../lib/connection/db-config.php");
include("../lib/class/user-class.php");
$userObj=new user();
$setCounter = 0;
$clientid=$_SESSION['clientid'];
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
    $tab_days='tran_days';	
    $tab_emp='tran_employee';
    $tab_empinc='tran_income';
    $tab_empded='tran_deduct';
    $frdt=$cmonth;
    $todt=$cmonth;
 }
else{
    $monthtit =  date('F Y',strtotime($_SESSION['frdt']));
    $tab_days='hist_days';
    $tab_emp='hist_employee';
    $tab_empinc='hist_income';
    $tab_empded='hist_deduct';

    $frdt=date("Y-m-d", strtotime($_SESSION['frdt']));
    $todt=date("Y-m-d", strtotime($_SESSION['frdt']));
	
	$sql = "SELECT LAST_DAY('".$frdt."') AS last_day";
	$row= mysql_query($sql);
	$res = mysql_fetch_assoc($row);
	$frdt = $res['last_day'];
	
 }

$p='';
if($emp=='Parent'){
    $p="(P)";
}

$setExcelName = "uan_ecr".$p;

$sql = "delete from uan_ecr";
$row =  mysql_query($sql);
exit;
// t1= tran_deduct          t2 = employee       t3 = mast_client    t4 = tran_employee  t5= tran_days
  
if($emp=='Parent')
	{
	 $sql = "SELECT t1.*,t2.first_name,t2.middle_name,t2.last_name,t2.uan,t4.pfno,t4.client_id,round(t4.gross_salary,0),t5.absent FROM $tab_empded t1 inner join $tab_days t5  on t1.emp_id = t5.emp_id and t1.sal_month = t5.sal_month  inner join employee t2  on  t1.emp_id=t2.emp_id  inner join  $tab_emp t4 on t4.emp_id = t1.emp_id  and t4.sal_month= t1.sal_month  inner join mast_client t3 on t4.client_id= t3.mast_client_id  where  t3.parentid='".$clientid."' AND  t1.head_id  in (select  mast_deduct_heads_id from mast_deduct_heads  where  deduct_heads_name like '%P.F.%'  and t4.comp_id ='".$comp_id."')  ";

	}
else{
 $sql = "SELECT t1.*,t2.first_name,t2.middle_name,t2.last_name,t2.uan,t4.pfno,t4.client_id,round(t4.gross_salary,0),t5.absent FROM $tab_empded t1  inner join $tab_days t5  on t1.emp_id = t5.emp_id and t1.sal_month = t5.sal_month  inner join employee t2  on  t1.emp_id=t2.emp_id  inner join  $tab_emp t4 on t4.emp_id = t1.emp_id  and t4.sal_month = t1.sal_month where  t4.client_id='".$clientid."' AND  t1.head_id  in (select  mast_deduct_heads_id from mast_deduct_heads  where  deduct_heads_name like '%P.F.%'  and t4.comp_id ='".$comp_id."')  ";

}

$row =  mysql_query($sql);
while($row1 = mysql_fetch_array($row))
{   
	echo $sql1= "insert into uan_ecr (uan ,memname ,gross_wages ,epf_wages,eps_wages ,edli_wages,epf_contribution,eps_contribution,epf_eps_d ,ncp_days,refund) values (";
	
	$sql1= $sql1."concat(".chr(34).chr(39).chr(34).",'".$row1['uan']."'),concat('".$row1['first_name']."','".$row1['middle_name']."','".$row1['last_name']."'),'".round($row1['gross_salary'],0)."','".round($row1['std_amt'],0);
	if ($row1['std_amt']>15000)
	{
		echo $sql1=$sql1."','15000','15000','";
		}
	 else{
		 $sql1=$sql1."','".round($row1['std_amt'],0)."','".round($row1['std_amt'],0)."','";
	 }
	 $sql1=$sql1.$row1['amount']."','".$row1['employer_contri_2']."','".$row1['employer_contri_1']."','".$row1['absent']."','0')";
	$sql1;
	
	
	$row2 = mysql_query($sql1);	
}
exit;
$setSql = "select * from uan_ecr";
$setRec = mysql_query($setSql);
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

?>







