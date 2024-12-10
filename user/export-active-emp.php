<?php
error_reporting(0);
session_start();
include("../lib/connection/db-config.php");
include("../lib/class/user-class.php");
$userObj=new user();
$setCounter = 0;
$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];
$setExcelName = "employee_detail";
$clientid=$_SESSION['clientid'];
$emp = $_POST['emp'];
$clientid = $_POST['clientid'];
//print_r($_SESSION);
$setRec = $userObj->exportActiveEmployee($clientid,$comp_id,$user_id,$emp);
print_r($setRec);exit;
/*if ($emp >0 ){
    
  $setSql= "SELECT e.emp_id,e.first_name,e.middle_name,e.last_name,e.desg_id,mdsg.mast_desg_name,e.dept_id,mdpt.mast_dept_name,mcl.client_name as 'Client',e.client_id,e.gender,e.bdate,e.joindate,e.due_date,e.bankacno,mb.bank_name,mb.ifsc_code,mb.branch ,e.middlename_relation,e.esino,e.pfno,e.esistatus,e.adharno,e.panno,e.driving_lic_no,e.uan,e.job_status,e.email,e.emp_add1,e.pin_code,e.mobile_no,e.ticket_no,e.married_status,e.totgrsal,e.qualif from employee e inner join mast_client mcl on e.client_id = mcl.mast_client_id  inner join mast_bank mb on e.bank_id = mb.mast_bank_id  inner join mast_dept mdpt on e.dept_id = mdpt.mast_dept_id inner join mast_desg mdsg on e.desg_id =mdsg.mast_desg_id  WHERE e.client_id= $clientid AND e.comp_id=$comp_id AND e.user_id=$user_id and job_status !='L'";
}
else

 {
	 
  $setSql= "SELECT e.emp_id,e.first_name,e.middle_name,e.last_name,e.desg_id,e.dept_id,mcl.client_name as 'Client',e.client_id,e.gender,e.bdate,e.joindate,e.due_date,e.bankacno,mb.bank_name,mb.ifsc_code,mb.branch ,e.middlename_relation,e.esino,e.pfno,e.esistatus,e.adharno,e.panno,e.driving_lic_no,e.uan,e.job_status,e.email,e.emp_add1,e.pin_code,e.mobile_no,e.ticket_no,e.married_status,e.totgrsal,e.qualif from employee e inner join mast_client mcl on e.client_id = mcl.mast_client_id  inner join mast_bank mb on e.bank_id = mb.mast_bank_id  WHERE e.comp_id=$comp_id AND e.user_id=$user_id and job_status !='L'";
	 
 }	 
$setRec = mysql_query($setSql);*/

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
?>







