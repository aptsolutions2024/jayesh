<?php

session_start();
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', dirname(__FILE__) . '/error_log.txt');
error_reporting(E_ALL);
include("../lib/connection/db-config.php");
include("../lib/class/user-class.php");
$userObj=new user();
$setCounter = 0;
$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];
$setExcelName = "employee_detail";
 $client_id = $_SESSION['clientid'];

error_reporting(0);
/*
$file =  "c:/salary/tranDays_".$client_id.chr(46)."csv";
if (file_exists($file))
	{
        unlink($file);
    */
if($client_id!=''){
	
						/*$sql ="select td_string from mast_company where comp_id = '".$_SESSION['comp_id']."'";
						$head = mysql_query($sql);
						$headrow = mysql_fetch_array($head);
						$head = $headrow['td_string'];*/
						$head = $userObj->getmastcomptdstring();
						$exhd = explode(',',$head);
						$j= count($exhd);
			        
	   $setRec= $userObj->exportTrandayTransaction($client_id,$exhd,$j,$comp_id,$user_id);
        /*$setSql = "SELECT mc.mast_client_id as 'client_id',mc.client_name 'client_name',td.sal_month as 'Sal_month',emp.`emp_id` as 'Emp ID',concat(emp.first_name,' ',emp.last_name) AS 'Employee_Name',";
       for($i=0; $i<$j; $i++ ){
	$setSql =$setSql .", '' as ".$exhd[$i];
}                           
		`present` AS 'Present', `absent` AS 'Absent', `weeklyoff` AS 'Weekly  off', `pl` AS 'Pl', `sl` AS 'Sl',
		`cl` AS 'Cl', `paidholiday` AS 'Paid Holiday', `additional` AS 'Additional Days', `extra_inc1` AS 'Extra Income 1', `extra_inc2` AS 'Extra Income 2', `extra_ded1` AS 'Extra Deduct 2', `extra_ded2` AS 'Extra Deduct 2', td.`leftdate` AS 'Left Date', `invalid` AS 'Invalid' FROM `tran_days` td inner join mast_client mc  on td.client_id = mc.mast_client_id  inner join employee emp on emp.emp_id = td.emp_id  where td.client_id = '" . $client_id . "'  order by emp_id, employee_name ";*/
    /*$cnt = $setRec = mysql_query($sql);
    if ($cnt > 0 ){
    echo " Records generated Successfully in ".$file.".";
    }*/


   // $setRec = mysql_query($setSql);

    $setCounter = mysqli_num_fields($setRec);
    $setMainHeader = "";
    $setData = "";

    while($fld =mysqli_fetch_field($setRec)){
   
    $setMainHeader .= $fld->name."\t";
}

    while ($rec = $setRec->fetch_assoc()) {
        $rowLine = '';
        foreach ($rec as $value) {
            if (!isset($value) || $value == "") {
                $value = "\t";
            } else {
//It escape all the special charactor, quotes from the data.
                $value = strip_tags(str_replace('"', '""', $value));
                $value = '"' . $value . '"' . "\t";
            }
            $rowLine .= $value;
        }
        $setData .= trim($rowLine) . "\n";
    }
    $setData = str_replace("\r", "", $setData);

    if ($setData == "") {
        $setData = "\nno matching records found\n";
    }


}
else{

    if ($setData == "") {
        $setData = "\nno matching records found\n";
    }
}

//This Header is used to make data download instead of display the data
header("Content-type: application/octet-stream");

header("Content-Disposition: attachment; filename=" . $setExcelName . ".xls");

header("Pragma: no-cache");
header("Expires: 0");

//It will print all the Table row as Excel file row with selected column name as header.
echo ucwords($setMainHeader) . "\n" . $setData . "\n";
?>







