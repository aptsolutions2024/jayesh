<?php
//print_r($_POST);exit;
session_start();
//error_reporting(0);
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', dirname(__FILE__) . '/error_log.txt');
error_reporting(E_ALL);
include("../lib/connection/db-config.php");
include("../lib/class/user-class.php");
$userObj=new user();

$client=$_POST['client'];
$tr_id=$_POST['tr_id'];
$emp=$_POST['emp_id'];
$smonth=$_POST['cm'];
$fp=$_POST['fp'];
$hp=$_POST['hp'];
$lw=$_POST['lw'];
$wo=$_POST['wo'];
$pr=$_POST['pr'];
$ab=$_POST['ab'];
$pl=$_POST['pl'];
$sl=$_POST['sl'];
$cl=$_POST['cl'];
$ol=$_POST['ol'];
$ph=$_POST['ph'];
$add=$_POST['add'];
$oh=$_POST['oh'];
$ns=$_POST['ns'];
$extra_inc1=$_POST['extra_inc1'];
$extra_ded1=$_POST['extra_ded1'];
$extra_ded2=$_POST['extra_ded2'];
$extra_inc2=$_POST['extra_inc2'];
$wagediff=$_POST['wagediff'];
$Allow_arrears=$_POST['Allow_arrears'];
$Ot_arrears=$_POST['Ot_arrears'];


$leftdate=$_POST['leftdate'];
$income_tax=$_POST['incometax'];
$society=$_POST['society'];
$canteen=$_POST['canteen'];
$remarks=$_POST['remarks'];
$invalid=$_POST['invalid'];

$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];
$_SESSION['clintid']=$client;

 $result=$userObj->insertTranday($client,$tr_id,$emp,$smonth,$fp,$hp,$lw,$wo,$pr,$ab,$pl,$sl,$cl,$ol,$ph,$add,$oh,$ns,$extra_inc1,$extra_inc2,$extra_ded1,$extra_ded2,$leftdate,$invalid,$comp_id,$user_id,$wagediff,$Allow_arrears,$Ot_arrears,$income_tax,$society,$canteen,$remarks);

$client_id=$client;
//$Session_Comp_id = '1';
$cl_name = $userObj->displayClient($client_id);

$cmonth = $cl_name['current_month'];

$endmth = $userObj->getLastDay($cmonth);
/*$sql = "SELECT LAST_DAY('".$cmonth."') AS last_day";
$row= mysql_query($sql);
$res = mysql_fetch_assoc($row);
$endmth = $res['last_day'];*/

$monthdays = $userObj->getMonthLastDay($cmonth);
/*$sql = "SELECT day(LAST_DAY('".$cmonth."')) AS monthdays";
$row= mysql_query($sql);
$res = mysql_fetch_assoc($row);
$monthdays = $res['monthdays'];*/


$startmth = $userObj->getMonthFirstDay($cmonth);

/*$sql = "SELECT date_add(date_add(LAST_DAY('".$cmonth."'),interval 1 DAY),interval -1 MONTH) AS first_day";
$row= mysql_query($sql);
$res = mysql_fetch_assoc($row);
$startmth = $res['first_day'];*/

// Checking data validity
$row= $userObj->setInvalidClient($client_id,$comp_id,$user_id);
/*
$sql = "update tran_days set invalid = '' where client_id ='".$client_id."'";
$row= mysql_query($sql);*/


// step 1. checking for left employees
$row1= $userObj->getLeftEmployee($client_id,$comp_id,$user_id);
$row=$row1;
/*$sql = "SELECT emp_id,first_name,middle_name,last_name from `employee` emp WHERE  emp.client_id = '".$client_id."' and emp.job_status ='L' and emp.emp_id in (SELECT emp_id FROM tran_days)" ;
$row= mysql_query($sql);
$row1= mysql_query($sql);*/

if(mysqli_num_rows($row) !=0)
{echo "\n Days details are available for left employees.Records will be deleted.".chr(13).chr(10);
while($res =$row->fetch_assoc()){
    //while($res = mysql_fetch_assoc($row)){
        echo $res['first_name']." ".$res['middle_name']." ".$res['last_name'].chr(13).chr(10);
        
        $userObj->deleteTranDay($res['emp_id']);
       /* $sql2  = "delete from  tran_days  where emp_id ='".$res['emp_id']."'";
        mysql_query($sql2);*/
    }
};



$row=$userObj->getemployeeNotInTranDay($client_id,$comp_id,$user_id);
$row1=$row;
/*$sql = "SELECT emp_id,first_name,middle_name,last_name from `employee`  emp WHERE  emp.client_id = '".$client_id."' and emp.job_status !='L' and emp.emp_id not in (SELECT emp_id FROM tran_days)" ;
$row= mysql_query($sql);
$row1= mysql_query($sql);*/

if(mysqli_num_rows($row) !=0)
{echo "\n Records will be added for following employee.".chr(13).chr(10);
    while($res = $row->fetch_assoc()){
        echo $res['first_name']." ".$res['middle_name']." ".$res['last_name'].chr(13).chr(10);
        
        $userObj->insertTranDays($res['emp_id'],$endmth,$comp_id,$user_id,$client_id);
    }
};


//(presentday=0 .and. othours>0)
$row=$userObj->getabsentDay($client_id,$comp_id,$user_id);

if(mysqli_num_rows($row) !=0)
{echo "\nInvalid Othours.Please Check Transction Days Details.";
    while($res = $row->fetch_assoc()){
        /*$sql2  = "update tran_days set invalid = concat(invalid,'OtHours-') where trd_id ='".$res['trd_id']."'";*/
        mysql_query($sql2);
       $userObj->updateSetInvalid($res['trd_id'],$comp_id,$user_id);
    }
};
//All days calculation - Regular emloyees

/*$sql = "SELECT trd_id FROM tran_days td inner join employee  emp  on emp.emp_id=td.emp_id where td.present+td.weeklyoff+td.paidholiday+td.sl+td.cl+td.pl+td.absent+td.otherleave != '".$monthdays."' and td.leftdate ='0000-00-00' and  td.client_id = '".$client_id."' and emp.joindate< '".$startmth."'" ;
$row= mysql_query($sql);*/
$row=$userObj->checkInvalidTotalDayRegularEmployee($monthdays,$client_id,$startmth,$comp_id,$user_id);

if(mysqli_num_rows($row) !=0)
{echo "\nInvalid Total Days for Regular Employee.Please Check Transaction Days Details.";
    while($res = $row->fetch_assoc()){
        $userObj->updateSetInvalid1($res['trd_id'],$comp_id,$user_id);
    }
};


//All days calculation - Newly joined emloyees

/*$sql = "SELECT trd_id FROM tran_days td inner join employee  emp  on emp.emp_id=td.emp_id where td.present+td.weeklyoff+td.paidholiday+td.sl+td.cl+td.pl+td.absent+td.otherleave != ('".$monthdays ."'-day(emp.joindate))+1 and td.leftdate ='0000-00-00' and  td.client_id = '".$client_id."'and  emp.joindate> '".$startmth."'";
$row= mysql_query($sql);*/
$row = $userObj->getCalculateNewEmployee($monthdays,$client_id,$startmth,$comp_id,$user_id);

//	print_r ($row);
if(mysqli_num_rows($row) !=0)
{echo " Invalid Total Days.Please Check Transaction Days Details.";
    while($res = $row->fetch_assoc()){
        /*$sql2  = "update tran_days set invalid = concat(invalid,'Days Total(N)-') where trd_id ='".$res['trd_id']."'";
        mysql_query($sql2);*/
        $userObj->updateSetInvalid2($res['trd_id'],$comp_id,$user_id);
    }
};

//All days calculation - left emloyees

/*$sql = "SELECT trd_id FROM tran_days td inner join employee  emp  on emp.emp_id=td.emp_id where td.present+td.weeklyoff+td.paidholiday+td.sl+td.cl+td.pl+td.absent+td.otherleave != ( day(td.leftdate) - day('".$startmth."'))+1 and td.leftdate !='0000-00-00' and  td.client_id = '".$client_id."' and  emp.joindate< '".$startmth."'" ;
$row= mysql_query($sql);*/
$row = $userObj->getCalculateLeftEmployee($client_id,$startmth,$comp_id,$user_id);
if(mysqli_num_rows($row) !=0)
{echo "Invalid Total Days.Please Check Transaction Days Details.";
    while($res = $row->fetch_assoc()){
        /*$sql2  = "update tran_days set invalid = concat(invalid,'Days Total(L)-') where trd_id ='".$res['trd_id']."'";
        mysql_query($sql2);*/
        $userObj->updateSetInvalid3($res['trd_id']);
    }
};



// Days checking is over.




if($result>0) {
  //  header("Location:tran-day.php?msg=update");
    header("/tran_day");
    exit;
}
else{
//    header("Location:tran-day.php?msg=fail");
      header("/tran_day");
  //exit;
}
?>

