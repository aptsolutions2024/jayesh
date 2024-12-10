<?php
//echo "<pre>";
//print_r($_POST);exit;
include("../lib/connection/db-config.php");
include("../lib/class/user-class.php");
session_start();
$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];

$userObj=new user();
$fildt = explode('#',$_POST['otherid']);
//print_r($fildt);exit;
$empid = $_POST['empid'];
 $fldv = $_POST[$fildt[1]];


if($fildt[1]!='mast_bank'){
$i=0;

foreach($empid as $emp){
$userObj->updateEmpOtherData($fildt[0],$fldv[$i],$emp,$comp_id,$user_id);
  $i++;  
}
}
else
{
    $bank_no = $_POST['bank_no'];
   $i=0;

foreach($empid as $emp){
$userObj->updateBankEmpOtherData($fildt[0],$fldv[$i],$bank_no[$i],$emp,$comp_id,$user_id);
  $i++;  
} 
}
//$userObj->updateEmpOtherData();

?>