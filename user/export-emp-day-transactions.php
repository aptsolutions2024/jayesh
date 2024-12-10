<?php
session_start();
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', dirname(__FILE__) . '/error_log.txt');
error_reporting(E_ALL);
include("../lib/connection/db-config.php");
include("../lib/class/user-class.php");
include("../lib/class/admin-class.php");
$userObj=new user();
$admin=new admin();
$setCounter = 0;
$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];
$setExcelName = "employee_detail";
$client_id = $_SESSION['clientid'];

//error_reporting(0);
//$setSql = "select 'client_id','client_name','Sal_month','Emp_Id' ,' Employee_Name', 'Present','Absent','Weekly  off','Pl','Sl','El','Paid Holiday','Additional Days','Extra Income 1','Extra Income 2','Extra Deduct 1','Extra Deduct 2','Left Date','Invalid' union all SELECT mc.mast_client_id ,mc.client_name,mc.current_month as 'Sal_month',emp.`emp_id` as 'Emp_ID',concat(emp.first_name,' ',emp.last_name) AS 'Employee_NAME', '', '', '', '', '', '', '', '', '', '', '', '', '', '' FROM `employee` emp inner join mast_client mc  on emp.client_id = mc.mast_client_id where emp.client_id = '".$client_id."' and emp.job_status != 'L'  order by employee_name";	

  /*$sql ="select td_string from mast_company where comp_id = '".$_SESSION['comp_id']."'";
  $head = mysql_query($sql);
  $headrow = $head->fetch_assoc($head);
  $head = $headrow['td_string'];*/
  $head = $userObj->getmastcomptdstring();
  $exhd = explode(',',$head);
  
  //$crmonth = $admin->getClientMonth($client_id);
  $resclt=$userObj->displayClient($client_id);
$crmonth=$resclt['current_month'];
  //echo $monthday = date("m", strtotime( date( "Y-m-d", strtotime( date("Y-m-d",$crmonth) ) ) . "1 month" );
  //$endmth =$userObj->getLastDay($crmonth);
  $endmth = date("d", strtotime($crmonth));
  $j= count($exhd);
$setRec = $userObj->showEployeedetailsWlDate($client_id,$crmonth);

    $setMainHeader = "";
    $setData = "";
    $setMainHeader= "Employee Id"."\t";
    $setMainHeader.= "Client Name"."\t";
    $setMainHeader.= "Month"."\t";
    $setMainHeader.= "Employee"."\t";
    $setMainHeader.= "Extra Inc1"."\t";
    $setMainHeader.= "Extra Ded1"."\t";
    $setMainHeader.= "Ot Hours"."\t";
    $setMainHeader.= "Additional"."\t";

      
  for($i=1;$i<=$endmth;$i++){
      $setMainHeader .= "Day ".$i."\t";
  }

/*while($fld =mysqli_fetch_field($setRec)){
   
    $setMainHeader .= $fld->name."\t";
}*/
//print_r($setRec);
    while ($rec = $setRec->fetch_assoc()) {
        $rowLine = '';
        foreach ($rec as $value) {
            if (!isset($value) || $value == "") {
                $value = "\t";
            } else {
//It escape all the special charactor, quotes from the data.
                $value = strip_tags(str_replace('"', '""', $value));
                $value = '"' . $value.  '"' . "\t";
                //$value .= '"' . $client_id.  '"' . "\t";
            }
            $rowLine .= $value;
        }
        $setData .= trim($rowLine) . "\n";
    }
    $setData = str_replace("\r", "", $setData);

    /*if ($setData == "") {
        $setData = "\nno matching records found\n";
    }*/


//else{

    if ($setData == "") {
        $setData = "\nno matching records found\n";
    }
//}

//This Header is used to make data download instead of display the data
header("Content-type: application/octet-stream");

header("Content-Disposition: attachment; filename=" . $setExcelName . ".xls");

header("Pragma: no-cache");
header("Expires: 0");

//It will print all the Table row as Excel file row with selected column name as header.
echo ucwords($setMainHeader) . "\n" . $setData . "\n";




?>







