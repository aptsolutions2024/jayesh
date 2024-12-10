<?php
session_start();
error_reporting(0);
include("../lib/connection/db-config.php");
include("../lib/class/user-class.php");
$userObj=new user();

$emp=$_POST['emp'];
$client=$_POST['client'];
$empid=$_POST['emp_id'];
$date=date("Y-m-d", strtotime($_POST['date']));

$bank_id=$_POST['bank_id'];
$bankac=$_POST['bankac'];
$paymode=$_POST['paymode'];
$trl_id=$_POST['trl_id'];
$lt=$_POST['lt'];
$lday=$_POST['lday'];
$t1 = strtotime($_POST['frdate']);
$t2 = strtotime($_POST['todate']);
$total_sec = abs($t2-$t1);
$total_min = floor($total_sec/60);
$total_hour = floor($total_min/60);


$present_day = floor($total_hour/24);
$frdate = date("Y-m-d",$t1);
$todate = date("Y-m-d",$t2);
$pr=$_POST['pr'];
$lea=$_POST['lea'];
$ob=$_POST['ob'];
$lej=$_POST['lej'];
$bl=$_POST['bl'];
$rate=$_POST['rate'];
$amt=$_POST['amt'];
$chq=$_POST['chq'];

$leave_earned=round($present_day/$lday);

$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];
$_SESSION['clintid']=$client;

$result=$userObj->insertTranleaveday($trl_id,$present_day,$empid,$date,$frdate,$todate,$pr,$lea,$ob,$lej,$bl,$rate,$amt,$chq,$bank_id,$bankac,$paymode,$comp_id,$user_id);

if($result>0) {
    header("Location:tran-leave.php?msg=update");   exit;
    ?>
    <div class="twelve padd0 columns successclass">
                    <br />Transactions Updated Successfully!<br />
                </div>
<?php
    exit;
}
else{
    ?>
    <div class="twelve padd0 columns errorclass">
        <br />Transactions Updated Failed!<br />
    </div>
    <?php

  header("Location:tran-leave.php?msg=fail");
    exit;
}
?>

