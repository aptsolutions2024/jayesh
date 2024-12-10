<?php
session_start();
//error_reporting(0);
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', dirname(__FILE__) . '/error_log.txt');
error_reporting(E_ALL);
include("../lib/connection/db-config.php");
include("../lib/class/user-class.php");
$userObj=new user();
$fname=addslashes(strtoupper($_POST['fname']));
$mname=addslashes(strtoupper($_POST['mname']));
$lname=addslashes(strtoupper($_POST['lname']));
if($_POST['lodate']!=''){
	$lodate=date("Y-m-d", strtotime($_POST['lodate']));
}
else{
	$lodate='';
	}
if($_POST['incdate']!=''){
$incdate=date("Y-m-d", strtotime($_POST['incdate']));
}
else{
	$incdate='';
	}
if($_POST['perdate']!=''){	
$perdate=date("Y-m-d", strtotime($_POST['perdate']));
}
else{
	$perdate='';
	}
if($_POST['pfdate']!=''){
$pfdate=date("Y-m-d", strtotime($_POST['pfdate']));
}
else{
	$pfdate='';
	}
$client=addslashes($_POST['client']);
$design=addslashes($_POST['design']);
$depart=addslashes($_POST['depart']);
$qualifi=addslashes($_POST['qualifi']);
$bank=addslashes($_POST['bank']);
$location=addslashes($_POST['location']);
$bankacno=addslashes($_POST['bankacno']);
$paycid=addslashes($_POST['paycid']);
$esistatus=addslashes($_POST['esistatus']);
$namerel=addslashes(strtoupper($_POST['namerel']));
$prnsrno=addslashes($_POST['prnsrno']);
$esicode=addslashes($_POST['esicode']);
$pfcode=addslashes($_POST['pfcode']);

//$tanno=addslashes($_POST['tanno']);

$adhaar=addslashes($_POST['adhaar']);
$drilno=addslashes($_POST['drilno']);
$uan=addslashes($_POST['uan']);
$votid=addslashes($_POST['votid']);
$jobstatus=addslashes($_POST['jobstatus']);
$gentype=addslashes($_POST['gentype']);
$bdate=date("Y-m-d", strtotime($_POST['bdate']));
$joindate=date("Y-m-d", strtotime($_POST['joindate']));
$add1=addslashes($_POST['add1']);

$panno=addslashes($_POST['panno']);
$email=addslashes($_POST['emailtext']);
$phoneno=addslashes($_POST['phone']);
$duedate=date("Y-m-d", strtotime($_POST['duedate']));
$ticket_no=addslashes($_POST['ticket_no']);
$comp_ticket_no=addslashes($_POST['comp_ticket_no']);
$married_status=addslashes($_POST['married_status']);
$pay_mode=addslashes($_POST['pay_mode']);
$pin_code=addslashes($_POST['pin_code']);
$handicap=addslashes($_POST['handicap']);
$nation=addslashes(strtoupper($_POST['nation']));

$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];
 echo $result = $userObj->insertEmployee($fname,$mname,$lname,$gentype,$bdate,$joindate,$lodate,$incdate,$add1,$panno,$perdate,$pfdate,$client,$design,$depart,$qualifi,$bank,$location,$bankacno,$paycid,$esistatus,$namerel,$prnsrno,$esicode,$pfcode,$adhaar,$drilno,$uan,$votid,$jobstatus,$email,$phoneno,$duedate,$ticket_no,$comp_ticket_no,$married_status,$pay_mode,$pin_code,$handicap,$nation,$comp_id,$user_id);
 ?>

