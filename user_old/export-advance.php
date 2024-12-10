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
$setExcelName = "employee_advance";
$setRec = $userObj->exportAdvance($comp_id,$user_id);
/* $setSql= "SELECT emp.`first_name` as 'First Name', emp.`middle_name` as 'Middle Name', emp.`last_name`  as 'Last Name', emp.`gender` as Gender ,emp.`email` as Email, ea.`date` as 'Date', ea.`adv_amount` as 'Advance Amount', ea.`adv_installment` as Installment FROM `employee` emp ,emp_advnacen ea WHERE emp.emp_id=ea.user_id  AND ea.`comp_id`='".$comp_id."' AND ea.`user_id`='".$user_id."'";
$setRec = mysql_query($setSql);
*/

$setCounter = mysqli_num_fields($setRec);
$setMainHeader="";
$setData="";

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







