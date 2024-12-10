<?php
//error_reporting(0);
/*ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', dirname(__FILE__) . '/error_log.txt');
error_reporting(E_ALL);*/
session_start();
//print_r($_SESSION);
include("../lib/connection/db-config.php");
include("../lib/class/user-class.php");
$setCounter = 0;
$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];
$setExcelName = "cheque_list";
$client = $_SESSION['clientid'];

//echo $checkdate1 = str_replace(('-','/',$_POST['checkdate']);
$checkdate1= date('Y-m-d',strtotime($_GET['checkdate']));

$type = $_GET['type'];

 $month=$_SESSION['month'];
$userObj=new user(); 
$resclt=$userObj->displayClient($client);
 $cmonth=$resclt['current_month'];

 if($month=='current'){
    $monthtit =  date('F Y',strtotime($cmonth));
    $tab_emp='tran_employee';
     $sal_month=$cmonth;
 }
else{
  $monthtit =  date('F Y',strtotime($_SESSION['frdt']));    
    $tab_emp='hist_employee';
	$frdt =  date('Y-m-d',strtotime($_SESSION['frdt']));   
	/*$sql = "SELECT LAST_DAY('".$frdt."') AS last_day";
	$row= mysql_query($sql);
	$res = mysql_fetch_assoc($row);
	 $sal_month = $res['last_day'];*/
	$sal_month = $userObj->selectLasrDay($frdt);
 }

//print_r($_SESSION);
if ($type = 'S')
{	
    $setRec = $userObj->getCheckPrintTypeSFroPrint($client,$comp_id,$user_id,$sal_month);
    /*$setSql= "SELECT e.emp_id,concat(e.first_name,' ' ,e.middle_name,' ' ,e.last_name) as name ,mcl.client_name as 'Client',cd.check_no,cd.date,cd.amount,cd.type from employee e inner join mast_client mcl on e.client_id = mcl.mast_client_id inner join cheque_details cd on cd.emp_id = e.emp_id WHERE e.client_id= $client AND e.comp_id=$comp_id AND e.user_id=$user_id and cd.sal_month = '".$sal_month."'"; */
   
}



//$setRec = mysql_query($setSql);

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







