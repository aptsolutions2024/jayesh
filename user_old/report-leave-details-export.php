<?php
 //error_reporting(0);
session_start();
include("../lib/connection/db-config.php");
include("../lib/class/user-class.php");
$setCounter = 0;
$userObj=new user();
$setCounter = 0;
$month=$_SESSION['month'];
$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];
$clintid=$_POST['client'];

$setExcelName = "leave_detail";

$res=$userObj->showEmployeereport($comp_id,$user_id);
$resclt=$userObj->displayClient($clintid);
$frdt=date("Y-m-d", strtotime($_POST['frdt1']));
$todt=date("Y-m-d", strtotime($_POST['todt1']));
 
 if ($clintid == 12 || $clintid == 13 || $clintid == 14 || $clintid == 15 || $clintid == 16)
{
$clientid = "12,13,14,15,16";
}

 
echo $sql="SELECT ld.client_id,ld.emp_id,concat(e.first_name,' ',e.middle_name,' ',e.last_name ) as name,ld.from_date,ld.to_date,ld.present,ld.ob,ld.earned,ld.enjoyed,ld.encashed,ld.rate,ld.amount,  ld.payment_date,e.joindate,e.leftdate FROM leave_details ld  INNER JOIN employee e ON ld.emp_id=e.emp_id WHERE ld.client_id in  ($clintid) AND ld.payment_date>='$frdt' and  ld.payment_date <='$todt' order by ld.payment_date ,ld.emp_id";
   $setRec = mysql_query($sql);
   

$setCounter = mysql_num_fields($setRec);
$setMainHeader="";
$setData="";
for ($i = 0; $i < $setCounter; $i++) {
    $setMainHeader .= mysql_field_name($setRec, $i)."\t";
}

while($rec = mysql_fetch_row($setRec))  {
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

$sqltab = "DROP TABLE IF EXISTS $tab" ;
$rowtab= mysql_query($sqltab);

?>







