<?php
//error_reporting(0);
session_start();
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', dirname(__FILE__) . '/error_log.txt');
error_reporting(E_ALL);
include("../lib/connection/db-config.php");

include("../lib/class/user-class.php");
$setCounter = 0;
$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];
$setExcelName = "employee_detail";
$userObj=new user();

  // $setSql= "SELECT emp.`emp_id` as 'EMP ID', emp.`first_name` as 'First Name',emp.`middle_name` as 'Middle Name',emp.`last_name`  as 'Last Name',emp.`bdate` as 'Birth Date',emp.`joindate` as 'Join Date',emp.`leftdate` as 'Left Date',emp.`incrementdate`  as 'Increment Date',emp.`permanentdate` as 'Permanent Date',emp.`pfdate` as 'PF Date',emp.`bankacno` as 'Bank A/c no',emp.`middlename_relation` as 'Middle name Relation',emp.`prnsrno` as 'PRNSR No',emp.`esino` as 'ESI No',emp.`pfno` as 'PF no',emp.`esistatus` as 'ESI Status',emp.`adharno` as 'Adhar No',emp.`panno` as 'Pan No',emp.`driving_lic_no` as 'Driving Lic No',emp.`uan` as UAN,emp.`voter_id` as 'Voter Id',emp.`job_status` as 'Job Status',emp.`emp_add1` as 'Address1', mc.client_name as 'Clint Name',md.mast_desg_name as 'Designation',mde.mast_dept_name as 'Department',mb.bank_name as 'Bank Name',mp.mast_paycode_name as 'Pay Code',ml.mast_location_name as 'Location',mq.mast_qualif_name as 'Qualification', emp.`mobile_no` as 'Phone No'  FROM `employee` emp,mast_client mc,mast_desg md,`mast_dept` mde,mast_bank mb,mast_paycode mp,mast_qualif mq,mast_location ml WHERE emp.client_id=mc.mast_client_id AND emp.desg_id=md.mast_desg_id AND mde.mast_dept_id=emp.dept_id AND emp.`qualif_id`=mq.mast_qualif_id AND emp.`bank_id`=mb.mast_bank_id AND emp.`loc_id`=ml.mast_location_id AND emp.`paycode_id`= mp.mast_paycode_id  AND emp.`comp_id`='".$comp_id."' AND emp.`user_id`='".$user_id."'"; 
  
 /* $setSql = "select e.*,mb.ifsc_code,mb.branch from employee  e  inner join mast_bank mb on e.bank_id = mb.mast_bank_id  where e.comp_id = '".$comp_id."'";
  
if($_POST['cal']!='all' && $_POST['cal']!='0'){
    $setSql .= " AND e.client_id='".$_POST['cal']."'";
}
 $setSql .= " order by e.client_id,e.emp_id,e.client_id,e.first_name,e.middle_name,e.last_name ";
echo $setSql;*/

//$setSql= "SELECT emp.`first_name` as 'First Name',emp.`middle_name` as 'Middle Name',emp.`last_name`  as 'Last Name',emp.`gender` as Gender,emp.`bdate` as 'Birth Date',emp.`joindate` as 'Join Date',emp.`due_date` as 'Due Date',emp.`leftdate` as 'Left Date',emp.`pfdate` as 'PF Date',emp.`pfno` as 'PF No',emp.`esistatus` as 'ESI Status' ,`esino` as  'ESI No', mde.mast_dept_name as 'Department',mq.mast_qualif_name as 'Qualification', emp.`mobile_no` as 'Phone No',emp.`pay_mode`  as 'Pay Mode',emp.`bankacno`  as 'Bank Ac no',emp.`comp_ticket_no`  as 'Comp Ticket No',emp.`panno`  as 'PAN no',emp.`adharno`  as 'Adhar No',emp.`uan`  as 'UAN',emp.`married_status` as 'Married Status'  FROM `employee` emp,mast_client mc,mast_desg md,`mast_dept` mde,mast_bank mb,mast_paycode mp,mast_qualif mq,mast_location ml WHERE emp.client_id=mc.mast_client_id AND emp.desg_id=md.mast_desg_id AND mde.mast_dept_id=emp.dept_id AND emp.`qualif_id`=mq.mast_qualif_id AND emp.`bank_id`=mb.mast_bank_id AND emp.`loc_id`=ml.mast_location_id AND emp.`paycode_id`= mp.mast_paycode_id  AND emp.`comp_id`='".$comp_id."' AND emp.`user_id`='".$user_id."'";


$setRec = $userObj->exportAllEmployee($comp_id,$_POST['cal']);
//$setRec = mysql_query($setSql);

 $setCounter = mysqli_num_fields($setRec);
$setMainHeader="";
$setData="";
for ($i = 0; $i < $setCounter; $i++) {
    $colObj = mysqli_fetch_field_direct($setRec,$i);
    $setMainHeader .=$colObj->name."\t";
    //mysqli_fetch_field($setRec, $i)."\t";
}
$result = array();
         $table = array();
         $field = array();

         /*for ($i = 0; $i < $setCounter; ++$i) {
             mysqli_fetch_field_direct($result,$i);
             //array_push($table, mysqli_field_table($setRec, $i));
             //array_push($field, mysqli_field_name($setRec, $i));
         }
         print_r($field);*/
         
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







