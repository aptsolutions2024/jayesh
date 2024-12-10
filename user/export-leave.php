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
$setExcelName = "employee_leave";
$setRec = $userObj->exportLeave($comp_id,$user_id);
/*$setRec = $setSql= "SELECT emp.`first_name` as 'First Name', emp.`middle_name` as 'Middle Name', emp.`last_name`  as 'Last Name', emp.`gender` as Gender ,emp.`email` as Email,el.year as Year,el.ob as OB FROM `employee` emp ,emp_leave el WHERE emp.emp_id=el.emp_id  AND emp.`comp_id`='".$comp_id."' AND emp.`user_id`='".$user_id."'";
$setRec = mysql_query($setSql);*/

echo $setCounter = mysqli_num_fields($setRec);
$setMainHeader="";
$setData="";
//for ($i = 0; $i < $setCounter; $i++) {
while($fld =mysqli_fetch_field($setRec)){
   
    $setMainHeader .= $fld->name."\t";//mysqli_fetch_field($setRec, $i)."\t"; //mysqli_field_name($setRec, $i)."\t";
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

$setCounter = mysqli_num_fields($setRec);



//This Header is used to make data download instead of display the data
header("Content-type: application/octet-stream");

header("Content-Disposition: attachment; filename=".$setExcelName.".xls");

header("Pragma: no-cache");
header("Expires: 0");

//It will print all the Table row as Excel file row with selected column name as header.
echo ucwords($setMainHeader)."\n".$setData."\n";
?>







