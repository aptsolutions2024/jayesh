<?php
//error_reporting(0);
session_start();
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', dirname(__FILE__) . '/error_log.txt');
error_reporting(E_ALL);
//include("../lib/connection/db-config.php");
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
	
	$frdt =$userObj->getLastDay($frdt);
	
 }

$p='';
if($emp=='Parent'){
    $p="(P)";
}

$setExcelName = "uan_ecr".$p;


$row = $userObj->deleteTable('uan_ecr');
// t1= tran_deduct          t2 = employee       t3 = mast_client    t4 = tran_employee  t5= tran_days
  $row22 = $userObj->reportPfUANEcr($emp,$tab_empded,$tab_days,$tab_emp,$clintid,$frdt,$comp_id);
 mysqli_num_rows($row22);
while($row1 = $row22->fetch_assoc())
{   $row = $userObj->insertReportPfUANEcr('',$row1['uan'],$row1['first_name'],$row1['middle_name'],$row1['last_name'],$row1['gross_salary'],$row1['std_amt'],$row1['amount'],$row1['employer_contri_2'],$row1['employer_contri_1'],$row1['absent']);
	
}
$setRec =$userObj->selectuanecr('uan_ecr');

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
          //  $value = strip_tags(str_replace('"', '""', $value));
            $value =  $value . "#~#";
			     //$value = '"' . $value . '"' . "#~#";
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

header("Content-Disposition: attachment; filename=".$setExcelName.".csv");

header("Pragma: no-cache");
header("Expires: 0");

//It will print all the Table row as Excel file row with selected column name as header.
echo $setData."\n";
?>







