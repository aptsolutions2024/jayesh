<?php
session_start();

$comp_id=$_SESSION['comp_id'];
//include("../lib/connection/db-config.php");
include("../lib/class/user-class.php");
$userObj=new user();

/*1
$sql = "select current_month from mast_client where comp_id = '$comp_id'";
$row= mysql_query($sql);
$res = mysql_fetch_assoc($row);
$cmonth = $res['current_month'];*/

/*2
$sql = "insert into  hist_employee select * from tran_employee where comp_id = '$comp_id'";
$row= mysql_query($sql);*/


/*3
$sql = "insert into  hist_days  ( `emp_id`, `client_id`, `sal_month`, `fullpay`, `halfpay`, `leavewop`, `present`, `absent`, `weeklyoff`, `pl`, `sl`, `cl`, `otherleave`, `paidholiday`, `additional`, `othours`, `nightshifts`, `extra_inc1`, `extra_inc2`, `extra_ded1`, `extra_ded2`, `leftdate`, `wagediff`, `Allow_arrears`, `Ot_arrears`, `invalid`, `comp_id`, `user_id`) select  `emp_id`, `client_id`, `sal_month`, `fullpay`, `halfpay`, `leavewop`, `present`, `absent`, `weeklyoff`, `pl`, `sl`, `cl`, `otherleave`, `paidholiday`, `additional`, `othours`, `nightshifts`, `extra_inc1`, `extra_inc2`, `extra_ded1`, `extra_ded2`, `leftdate`, `wagediff`, `Allow_arrears`, `Ot_arrears`, `invalid`, `comp_id`, `user_id`  from tran_days where comp_id = '".$comp_id."'" ;
$row= mysql_query($sql);*/

/*4
$sql = "insert into hist_income ( `emp_id`, `sal_month`, `head_id`, `calc_type`, `std_amt`, `amount`) select  t1.emp_id, t1.sal_month, t1.head_id, t1.calc_type, t1.std_amt, t1.amount from tran_income t1 inner join tran_employee t2 on t1.emp_id = t2.emp_id and t1.sal_month = t2.sal_month where t2.comp_id  =  '$comp_id' ";
$row= mysql_query($sql);*/

/*5
$sql = "insert into hist_deduct  ( `emp_id`, `sal_month`, `head_id`, `calc_type`, `std_amt`, `amount`, `employer_contri_1`, `employer_contri_2`, `bank_id`)select t1.emp_id, t1.sal_month, t1.head_id, t1.calc_type, t1.std_amt, t1.amount, t1.employer_contri_1, t1.employer_contri_2, t1.bank_id from tran_deduct t1 inner join tran_employee t2 on t1.emp_id = t2.emp_id and t1.sal_month = t2.sal_month where t2.comp_id  =  '$comp_id'" ;
$row= mysql_query($sql);*/

/*6
$sql = "insert into hist_advance ( `emp_id`, `client_id`, `comp_id`, `sal_month`, `head_id`, `calc_type`, `std_amt`, `amount`, `paid_amt`, `emp_advance_id`)select  t1.emp_id, t1.client_id, t1.comp_id, t1.sal_month, t1.head_id, t1.calc_type, t1.std_amt, t1.amount, t1.paid_amt, t1.emp_advance_id from tran_advance t1 inner join tran_employee t2 on t1.emp_id = t2.emp_id and t1.sal_month = t2.sal_month where t2.comp_id  =  '$comp_id'" ;
$row= mysql_query($sql);*/

/*7 $sql = "DELETE FROM tran_employee  WHERE emp_id IN ( SELECT emp_id FROM tran_days WHERE comp_id = '".$comp_id. "')";
$row= mysql_query($sql);


$sql = "DELETE FROM tran_deduct WHERE emp_id IN ( SELECT emp_id FROM tran_days WHERE comp_id = '".$comp_id. "')";
$row= mysql_query($sql);

$sql = "DELETE FROM tran_income WHERE emp_id IN ( SELECT emp_id FROM tran_days WHERE comp_id = '".$comp_id. "')";
$row= mysql_query($sql);

$sql = "DELETE FROM tran_advance  WHERE emp_id IN ( SELECT emp_id FROM tran_days WHERE comp_id = '".$comp_id. "')";
$row= mysql_query($sql);

$sql = "DELETE FROM tran_employee  WHERE emp_id IN ( SELECT emp_id FROM tran_days WHERE comp_id = '".$comp_id. "')";
$row= mysql_query($sql);


$sql = "DELETE FROM tran_days WHERE comp_id = '".$comp_id. "'";
$row= mysql_query($sql);*/




/*8
$sql = "update mast_client set current_month =last_day(DATE_ADD( current_month, INTERVAL 1 month )) WHERE comp_id = '".$comp_id. "'";
$row= mysql_query($sql);*/



$cmonth = $userObj->selectcurrent_month($comp_id);

$userObj->insertHistEmployee($comp_id);

$userObj->insertHistDay($comp_id);

$userObj->insertHistIncome($comp_id);

$userObj->insertHistDeduct($comp_id);

$userObj->insertHistAdvance($comp_id);

$userObj->deleteTranTableMonthlyclosing($comp_id);

$userObj->updateEmployeeMonthlyClosing($comp_id);

$userObj->updateMastClientMonthlyClosing($comp_id);



//Leave calculation pending
/*$sql11 = "select el.* from emp_leave el inner join tran_days td on td.emp_id= el.emp_id where td.pl>0  and el.leave_type_id = 5  and td.comp_id = '$comp_id'";
$row11= mysql_query($sql11);

while($row2 = mysql_fetch_array($row11))
 { 
    $sql2 = "update emp_leave el inner join tran_days td on el.emp_id = td.emp_id set el.enjoyed  = el.enjoyed+td.pl where el.emp_leave_id = ' ".$row2['emp_leave_id']."'  and td.comp_id = '$comp_id' ";
		$row21= mysql_query($sql2);
}
 
$sql = " select el.* from emp_leave el inner join tran_days td on td.emp_id= el.emp_id where td.cl>0  and leave_type_id = 4   and td.comp_id = '$comp_id'";
$row= mysql_query($sql);

while($row2 = mysql_fetch_array($row))
 { 
    $sql2 = "update emp_leave el inner join tran_days td on el.emp_id = td.emp_id set el.enjoyed  = el.enjoyed+td.cl where el.emp_leave_id = '".$row2['emp_leave_id']."'  and td.comp_id = '$comp_id' "; 
		$row21= mysql_query($sql2);
}
*/ 
 
/*  $sql = "update employee e inner join tran_employee te on te.emp_id = e.emp_id set e.esistatus = te.esistatus where  e.comp_id = '$comp_id'  ";
$row= mysql_query($sql);*/

 

 
 






?>