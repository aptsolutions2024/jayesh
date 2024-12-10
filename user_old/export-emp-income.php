<?php
//error_reporting(0);
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', dirname(__FILE__) . '/error_log.txt');
error_reporting(E_ALL);
session_start();
include("../lib/connection/db-config.php");
include("../lib/class/user-class.php");
$userObj=new user();
$setCounter = 0;
$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];
echo $clint_id=$_GET['cid']; 
$setExcelName = "employee_income";
$file =  "empinc_".$clint_id.".csv";
  if (file_exists($file)) {
        unlink($file);
    }

/*echo $setSql= "select 'Emp_id','first_name','middle_name','last_name','Std_amt','Remark' union all SELECT emp_id as 'Employee ID',`last_name` as 'Last Name',`first_name` as 'First Name',`middle_name` as 'Middle Name','0','0' FROM `employee` WHERE  `comp_id`='".$comp_id."' AND`user_id`='".$user_id."' AND employee.client_id='".$clint_id."' and employee.job_status != 'L'  INTO OUTFILE '".$file."' FIELDS TERMINATED BY ','   ENCLOSED BY '".chr(34) ."'  LINES TERMINATED BY '"."\n"."' ";*/
//echo $setSql= "SELECT DISTINCT e.emp_id as 'Employee ID',e.`last_name` as 'Last Name',e.`first_name` as 'First Name',e.`middle_name` as 'Middle Name',ei.`calc_type`=' ' as 'cal',ei.`std_amt`=' ' as 'amount',ei.`remark`=' ' as 'Remark' FROM `employee` e,emp_income ei where e.job_status!='L' AND ei.user_id!=e.emp_id";


/*$setSql= " SELECT distinct emp_id as 'Employee ID',`last_name` as 'Last Name',`first_name` as 'First Name',`middle_name` as 'Middle Name' FROM `employee` WHERE  `comp_id`='".$comp_id."' AND`user_id`='".$user_id."' AND employee.client_id='".$clint_id."' and employee.job_status != 'L' ";

$setRec = mysql_query($setSql);*/

$setRec =$userObj->exportEmpIncome($comp_id,$user_id,$clint_id);





$setCounter = mysqli_num_fields($setRec);
$setMainHeader="";
$setData="";

/*while($fld =mysqli_fetch_field($setRec)){
   
    $setMainHeader .= $fld->name."\t";
}*/
while($fld =mysqli_fetch_field($setRec)){
   
    $setMainHeader .= $fld->name."\t";
}
$setMainHeader .="STD Amount \t";
$setMainHeader .="Remark \t";
while($rec = $setRec->fetch_assoc())  {
    $rowLine = '';
    $j=0;
    foreach($rec as $value)       {
        if(!isset($value) || $value == "")  {
            $value = "\t";
        }   else  {
//It escape all the special charactor, quotes from the data.
            $value = strip_tags(str_replace('"', '""', $value));
            if($j>3) {
                $value = '" "' . "\t";
            } else{
                $value = '"' . $value . '"' . "\t";
            }

     $j++;
        }
        $rowLine .= $value;
    }
    $setData .= trim($rowLine)."\n";
}
$setData = str_replace("\r", "", $setData);

if ($setData == "") {
   // $setData = "\nno matching records found\n";
}

$setCounter = mysqli_num_fields($setRec);



//This Header is used to make data download instead of display the data
header("Content-type: application/octet-stream");

header("Content-Disposition: attachment; filename=".$setExcelName.".xls");

header("Pragma: no-cache");
header("Expires: 0");

//It will print all the Table row as Excel file row with selected column name as header.
echo ucwords($setMainHeader)."\n".$setData."\n";
?>







