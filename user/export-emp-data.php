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
$setExcelName = "employee_detail";

// $setSql= "SELECT emp.`first_name` as 'First Name',emp.`middle_name` as 'Middle Name',emp.`last_name`  as 'Last Name',emp.`gender` as Gender,emp.`bdate` as 'Birth Date',emp.`joindate` as 'Join Date',emp.`due_date` as 'Due Date',emp.`leftdate` as 'Left Date',emp.`pfdate` as 'PF Date',emp.`pfno` as 'PF No','Y' as 'ESI Status' ,`esino` as  'ESI No', mde.mast_dept_name as 'Department',mq.mast_qualif_name as 'Qualification', emp.`mobile_no` as 'Phone No',emp.`pay_mode`  as 'Pay Mode',emp.`bank_id`as 'Bank Name',emp.`bankacno`  as 'Bank Ac no',emp.`comp_ticket_no`  as 'Comp Ticket No',emp.`panno`  as 'PAN no',emp.`adharno`  as 'Adhar No',emp.`uan`  as 'UAN',emp.`married_status` as 'Married Status' ,emp_add1 as 'Employee Address' FROM `employee` emp,mast_client mc,mast_desg md,`mast_dept` mde,mast_bank mb,mast_paycode mp,mast_qualif mq,mast_location ml WHERE emp.client_id=mc.mast_client_id AND emp.desg_id=md.mast_desg_id AND mde.mast_dept_id=emp.dept_id AND emp.`qualif_id`=mq.mast_qualif_id AND emp.`bank_id`=mb.mast_bank_id AND emp.`loc_id`=ml.mast_location_id AND emp.`paycode_id`= mp.mast_paycode_id  AND emp.`comp_id`='".$comp_id."' AND emp.`user_id`='".$user_id."'";

/*$setSql= "SELECT emp.`first_name` as 'First Name',emp.`middle_name` as 'Middle Name',emp.`last_name`  as 'Last Name',emp.`gender` as Gender,emp.`bdate` as 'Birth Date',emp.`joindate` as 'Join Date',emp.`due_date` as 'Due Date',emp.`leftdate` as 'Left Date',emp.`pfdate` as 'PF Date',emp.`pfno` as 'PF No','Y' as 'ESI Status' ,`esino` as  'ESI No', mde.mast_dept_name as 'Department',mq.mast_qualif_name as 'Qualification', emp.`mobile_no` as 'Phone No',emp.`pay_mode`  as 'Pay Mode' ,emp.`bank_id`as 'Bank Name',emp.`bankacno`  as 'Bank Ac no',emp.`comp_ticket_no`  as 'Comp Ticket No',emp.`panno`  as 'PAN no',emp.`adharno`  as 'Adhar No',emp.`uan`  as 'UAN',emp.`married_status` as 'Married Status' ,emp_add1 as 'Employee Address',emp.desg_id as 'Designation' FROM `employee` emp,mast_client mc,mast_desg md,`mast_dept` mde,mast_bank mb,mast_paycode mp,mast_qualif mq,mast_location ml WHERE emp.client_id=mc.mast_client_id AND emp.desg_id=md.mast_desg_id AND mde.mast_dept_id=emp.dept_id AND emp.`qualif_id`=mq.mast_qualif_id AND emp.`bank_id`=mb.mast_bank_id AND emp.`loc_id`=ml.mast_location_id AND emp.`paycode_id`= mp.mast_paycode_id  AND emp.`comp_id`='".$comp_id."' AND emp.`user_id`='".$user_id."'";*/

//$setSql= "SELECT `last_name` as 'Last Name', `first_name` as 'First Name',`middle_name` as 'Middle Name', `gender`, `bdate`, `joindate`, `leftdate`, `incrementdate`, `permanentdate`, `pfdate`,  `client_id` as 'Client', `desg_id` as 'Designation', `dept_id` as 'Department', `qualif_id` as 'Qualification', `bank_id` as 'Bank', `loc_id` as 'Location', `paycode_id` as 'paycode', `bankacno`, `middlename_relation`, `prnsrno`, `esino`, `pfno`, `esistatus`, `adharno`, `panno`, `driving_lic_no` as 'Driving Lic No', `uan`, `voter_id` as 'Voter Id', `job_status` as 'Job Status', `email`, `emp_add1` as 'Address', `mobile_no` as 'Phone No' FROM `employee` where job_status!='L' AND comp_id='".$comp_id."' AND user_id='".$user_id."'  ";





//$setRec = mysql_query($setSql);
$setRec = $userObj->exportEmpData($comp_id,$user_id);

$setCounter = mysqli_num_fields($setRec);
$setMainHeader="";
$setData="";

while($fld =mysqli_fetch_field($setRec)){
   
    $setMainHeader .= $fld->name."\t";
}

while($rec =$setRec->fetch_assoc())  {
    $rowLine = '';
    $j=0;
    foreach($rec as $value)       {
        if(!isset($value) || $value == "")  {
            $value = "\t";
        }   else  {
//It escape all the special charactor, quotes from the data.
            $value = strip_tags(str_replace('"', '""', $value));
       $value = '" "' . "\t";

$j++;
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







