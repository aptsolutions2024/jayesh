<?php
error_reporting(0);
session_start();
include("../lib/class/advance.php");
include("../lib/class/common.php");
$advance =new advance();
$common = new common();
$advtype = $_POST['advtype'];
 $_POST['advdate'];
//print_r($_POST);
 $advdate = date('Y-m-d',strtotime($_POST['advdate']));

$advamt = $_POST['advamt'];
$advinstall = $_POST['advinstall'];
$closeon = $_POST['closeon'];
$received_amt= $_POST['received_amt'];

$user = $_SESSION['log_id'];
$comp = $_SESSION['comp_id'];

$empid = $_POST['emp_adv_id'];
$i=0;
echo "hello";
foreach($empid as $emp){
echo $num = $advance->checkAdvances($_POST['emp_adv_id'][$i],$advtype,$advdate); 
$date = date('Y-m-d',strtotime($closeon[$i]));
if($num == '0'){
$advance->insertAdvances($advtype,$advdate,$user,$comp,$empid[$i],$advamt[$i],$advinstall[$i],$date);
}else{
$advance->updateAdvances($advtype,$advdate,$user,$comp,$empid[$i],$advamt[$i],$advinstall[$i],$date);	
}	
$i++;
}
//
?>