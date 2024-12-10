<?php
 error_reporting(0);
session_start();

include("../lib/connection/db-config.php");
include("../lib/class/user-class.php");
$userObj=new user();
$setCounter = 0;
$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];
$clintid=$_SESSION['clintid'];
$client = $_POST['client'];
$startyear = date('Y-m-d',strtotime($_SESSION['startbonusyear']));
$endyear = date('Y-m-d',strtotime($_SESSION['endbonusyear']));



$setExcelName = "bonus_detail ";

   $setRec = $userObj->getBonusDetails($client,$startyear,$endyear);
 /* $setSql ="select emp.first_name,emp.middle_name,emp.last_name,emp.emp_id,emp.joindate,emp.leftdate,te.*
		from employee emp	inner join bonus te on te.emp_id = emp.emp_Id
		where te.client_id='$client' and te.from_date ='$startyear' and te.todate='$endyear' and (te.apr_payable_days + te.may_payable_days+te.jun_payable_days+te.jul_payable_days+te.aug_payable_days+te.sep_payable_days+te.oct_payable_days+te.nov_payable_days+te.dec_payable_days+te.jan_payable_days+te.feb_payable_days+te.mar_payable_days) >=0 and emp.prnsrno !='Y'";  
*/

  //$setRec = mysql_query($setSql);

 $setCounter = mysqli_num_fields($setRec);

$setMainHeader="";
$setData="";
/*for ($i = 0; $i < $setCounter; $i++) {
    $setMainHeader .= mysqli_field_name($setRec, $i)."\t";
}*/
while($fld =mysqli_fetch_field($setRec)){
   
    $setMainHeader .= $fld->name."\t";
}

while($rec = $setRec->fetch_row($setRec))  {
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
		if($value =='bankacno'){
				$value = '\''.$value;
			}
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