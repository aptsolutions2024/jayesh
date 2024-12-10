<?php

//print_r($_REQUEST);
ini_set('display_errors', 1);
ini_set('log_errors', 1);
error_reporting(E_ALL);
//error_reporting(0);
session_start();
include("../lib/connection/db-config.php");
$setCounter = 0;
$month=$_SESSION['month'];
$comp_id=$_SESSION['comp_id'];
$clintid=$_SESSION['clintid'];
$user_id=$_SESSION['log_id'];
$setExcelName = "payslip";
$client_id=$_REQUEST['cal'];

$setExcelName = "Paysheet_".$client_id;
//$emp = $_REQUEST['emp'];
//$name = $_REQUEST['name'];
include("../lib/class/user-class.php");
include("../lib/class/admin-class.php");
$userObj=new user();
$adminObj=new admin();
$resclt=$userObj->displayClient($clintid);

$rowclient=$userObj->displayClient($client_id);
$cmonth=$rowclient['current_month'];
$inhdar = array();
$inhd =0;
$std_inhdar = array();
$std_inhd =0;
$advhd = 0;
$advhdar = array();

$dedhdar = array();
$dedhd =0;
//$noofper = $_REQUEST['noofper'];
$maxcol=0;




$tab = "`tab_".$user_id."`";

if($month=='current'){
	$monthtit =  date('F Y',strtotime($cmonth));
    $frdt=$cmonth;
    $todt=$cmonth;
  }
else
  {
    $monthtit =  date('F Y',strtotime($_SESSION['frdt']));
	$frdt=date("Y-m-d", strtotime($_SESSION['frdt']));
    $todt=date("Y-m-d", strtotime($_SESSION['todt']));
  }
  
$row= $userObj-> genarateTempPaysheet($inhdar,$inhd,$std_inhdar,$std_inhd,$advhd,$advhdar,$dedhdar,$dedhd,$cmonth);

$inhdar = $row[0];
$inhd= $row[1];
$std_inhdar= $row[2];
$std_inhd= $row[3];
$advhd= $row[4];
$advhdar= $row[5];
$dedhdar= $row[6];
$dedhd= $row[7];
$rowtab=$row[8];
$setData="";
while($rec=$rowtab->fetch_assoc())  {
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

$row2= $userObj-> exportexceldata();
$rowtab3 =$row2->fetch_assoc();
$setCounter= sizeof($rowtab3);




$setMainHeader="";

for ($i = 0; $i < $setCounter; $i++) {
   $setMainHeader .= array_keys($rowtab3)[$i]."\t";
}






//This Header is used to make data download instead of display the data
header("Content-type: application/octet-stream");

header("Content-Disposition: attachment; filename=".$setExcelName.".xls");

header("Pragma: no-cache");
header("Expires: 0");

//It will print all the Table row as Excel file row with selected column name as header.
echo ucwords($setMainHeader)."\n".$setData."\n";

?>
