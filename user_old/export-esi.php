<?php
//error_reporting(0);
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', dirname(__FILE__) . '/error_log.txt');
error_reporting(E_ALL);
session_start();
//include("../lib/connection/db-config.php");
$setCounter = 0;
$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];
$setExcelName = "esi_export";
$clintid=$_SESSION['clintid'];
$month=$_SESSION['month'];
include("../lib/class/user-class.php");
$userObj=new user();


if($month=='current'){
    $tab_emp='tran_employee';
    $tab_empded='tran_deduct';
    
	$resclt=$userObj->displayClient($clintid);
$cmonth=$resclt['current_month'];
    $frdt=$cmonth;
 }
else{
    $tab_emp='hist_employee';
    $tab_empded='hist_deduct';
	$frdt=date("Y-m-d", strtotime($_SESSION['frdt']));
 }

$setRec =$userObj->exportEsi($tab_empded,$tab_emp,$frdt,$comp_id);
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