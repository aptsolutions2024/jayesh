<?php
session_start();

include("../lib/connection/db-config.php");
include("../lib/class/user-class.php");
$userObj=new user();
//print_r($_POST);
//$user = "21";
$client_id = $_POST['clientid'];

//$client_id=$_SESSION['clientid'];
$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];

//$Session_Comp_id = '1';
$cl_name = $userObj->displayClient($client_id);

$cmonth = $cl_name['current_month'];
$sql = "SELECT LAST_DAY('".$cmonth."') AS last_day";
$row= mysql_query($sql);
$res = mysql_fetch_assoc($row);
$endmth = $res['last_day'];

$sql = "SELECT day(LAST_DAY('".$cmonth."')) AS monthdays";
$row= mysql_query($sql);
$res = mysql_fetch_assoc($row);
$monthdays = $res['monthdays'];

$sql = "SELECT date_add(date_add(LAST_DAY('".$cmonth."'),interval 1 DAY),interval -1 MONTH) AS first_day";
$row= mysql_query($sql);
$res = mysql_fetch_assoc($row);
$startmth = $res['first_day'];

// Checking data validity
      $sql = "update tran_days set invalid = '' where client_id ='".$client_id."'";
		$row= mysql_query($sql);
	  
// step 1. checking for left employees
	$sql = "SELECT emp_id,first_name,middle_name,last_name from `employee` emp WHERE  emp.client_id = '".$client_id."' and emp.job_status ='L' and emp.emp_id in (SELECT emp_id FROM tran_days)" ;
	$row= mysql_query($sql);
	$row1= mysql_query($sql);
	
	if(mysql_num_rows($row) !=0)
		{echo "\n Days details are available for left employees.Records will be deleted.".chr(13).chr(10);
			while($res = mysql_fetch_assoc($row)){
				echo $res['first_name']." ".$res['middle_name']." ".$res['last_name'].chr(13).chr(10);
				$sql2  = "delete from  tran_days  where emp_id ='".$res['emp_id']."'"; 
				    mysql_query($sql2);
			}
		};

	/*if(mysql_num_rows($row1) !=0)
		{echo chr(13).chr(10).mysql_num_rows($row1). " Records will be deleted for left employees.";
			while($res = mysql_fetch_assoc($row1)){
				$sql2  = "delete from tran_days  where emp_id ='".$res['emp_id']."'"; 
				    mysql_query($sql2);
			}
		};
*/


	$sql = "SELECT emp_id,first_name,middle_name,last_name from `employee`  emp WHERE  emp.client_id = '".$client_id."' and emp.job_status !='L' and emp.emp_id not in (SELECT emp_id FROM tran_days)" ;
	$row= mysql_query($sql);
	$row1= mysql_query($sql);
	
	if(mysql_num_rows($row) !=0)
		{echo "\n Records will be added for following employee.".chr(13).chr(10);
			while($res = mysql_fetch_assoc($row)){
				echo $res['first_name']." ".$res['middle_name']." ".$res['last_name'].chr(13).chr(10);
				$sql2  = "insert into tran_days (emp_id,sal_month,client_id,comp_id,user_id,updatedby values ('".$res['emp_id']."','".$endmth."','".$client_id."','".$comp_id."','".$user_id."','".$user_id."'"; 
				mysql_query($sql2);
			}
		};

		
	//(presentday=0 .and. othours>0)
	$sql = "SELECT trd_id from tran_days WHERE  client_id = '".$client_id."' and present = 0 and othours >0" ;
	$row= mysql_query($sql);
	if(       mysql_num_rows($row) !=0)
		{echo "\nInvalid Othours.Please Check Transction Days Details.";
			while($res = mysql_fetch_assoc($row)){
				$sql2  = "update tran_days set invalid = concat(invalid,'OtHours-') where trd_id ='".$res['trd_id']."'"; 
				    mysql_query($sql2);
			}
		};
	//All days calculation - Regular emloyees
												
    $sql = "SELECT trd_id FROM tran_days td inner join employee  emp  on emp.emp_id=td.emp_id where td.present+td.weeklyoff+td.paidholiday+td.sl+td.cl+td.pl+td.absent+td.otherleave != '".$monthdays."' and td.leftdate ='0000-00-00' and  td.client_id = '".$client_id."' and emp.joindate< '".$startmth."'" ;
	$row= mysql_query($sql);
	if(mysql_num_rows($row) !=0)
		{echo "\nInvalid Total Days for Regular Employee.Please Check Transaction Days Details.";
			while($res = mysql_fetch_assoc($row)){
				$sql2  = "update tran_days set invalid = concat(invalid,'Days Total(R)-') where trd_id ='".$res['trd_id']."'"; 
				
				    mysql_query($sql2);
			}
		};
		

	//All days calculation - Newly joined emloyees
												
 $sql = "SELECT trd_id FROM tran_days td inner join employee  emp  on emp.emp_id=td.emp_id where td.present+td.weeklyoff+td.paidholiday+td.sl+td.cl+td.pl+td.absent+td.otherleave != ('".$monthdays ."'-day(emp.joindate))+1 and td.leftdate ='0000-00-00' and  td.client_id = '".$client_id."'and  emp.joindate> '".$startmth."'"; 
	$row= mysql_query($sql);
//	print_r ($row);
	if(       mysql_num_rows($row) !=0)
		{echo " Invalid Total Days.Please Check Transaction Days Details.";
			while($res = mysql_fetch_assoc($row)){
				$sql2  = "update tran_days set invalid = concat(invalid,'Days Total(N)-') where trd_id ='".$res['trd_id']."'"; 
				    mysql_query($sql2);
			}
		};

	//All days calculation - left emloyees
												
	$sql = "SELECT trd_id FROM tran_days td inner join employee  emp  on emp.emp_id=td.emp_id where td.present+td.weeklyoff+td.paidholiday+td.sl+td.cl+td.pl+td.absent+td.otherleave != ( day(td.leftdate) - day('".$startmth."'))+1 and td.leftdate !='0000-00-00' and  td.client_id = '".$client_id."' and  emp.joindate< '".$startmth."'" ;
	$row= mysql_query($sql);
	if(       mysql_num_rows($row) !=0)
		{echo "Invalid Total Days.Please Check Transaction Days Details.";
			while($res = mysql_fetch_assoc($row)){
				$sql2  = "update tran_days set invalid = concat(invalid,'Days Total(L)-') where trd_id ='".$res['trd_id']."'"; 
				    mysql_query($sql2);
			}
		};
		
	

// Days checking is over.


//Salary Calculation
	$sql = "select trd_id from tran_days where client_id = '".$client_id."' and invalid != ''";
	$row= mysql_query($sql);
	if(       mysql_num_rows($row) !=0)
	{ ?>
		<br/>
	<?php 
		echo   "Invalid flag. Can not Proceed.";
		exit;
		}
//temp tables creation
$sqltab = "DROP TABLE IF EXISTS tab_inc".$user_id ;
$rowtab= mysql_query($sqltab);

$sqltab = "DROP TABLE IF EXISTS tab_ded".$user_id ;
$rowtab= mysql_query($sqltab);

$sqltab = "DROP TABLE IF EXISTS tab_emp".$user_id ;
$rowtab= mysql_query($sqltab);

$sqltab = "create table   tab_inc".$user_id ." as (select * from  tran_income where 1=2)";
$rowtab= mysql_query($sqltab);

$sqltab = "create table   tab_ded".$user_id ." as (select * from  tran_deduct where 1=2)";
$rowtab= mysql_query($sqltab);



$sqltab = "create table   tab_emp".$user_id ." as (select * from  tran_employee where 1=2)";
$rowtab= mysql_query($sqltab);




//insertion of data into temp tables.
$sqltab = "update tran_days td inner join emp_leave el on el.emp_id = td.emp_id  set td.plbal = el.ob-el.enjoyed  where el.leave_type_id = 5";
$rowtab= mysql_query($sqltab);

$sqltab = "update tran_days td inner join emp_leave el on el.emp_id = td.emp_id  set td.clbal = el.ob-el.enjoyed  where el.leave_type_id = 4";
$rowtab= mysql_query($sqltab);

$sqltab = "insert into tab_inc".$user_id ." (`emp_id`, `sal_month`, `head_id`, `calc_type`, `std_amt`,`amount`)  select `emp_id`, '".$cmonth."', `head_id`, `calc_type`, `std_amt`,'0' from emp_income where emp_id in (select emp_id from tran_days where client_id = '".$client_id."')";
$rowtab= mysql_query($sqltab);

$sqltab = "insert into tab_ded".$user_id ." ( `emp_id`, `sal_month`, `head_id`, `calc_type`, `std_amt`,`amount`)  select `emp_id`, '".$cmonth."', `head_id`, `calc_type`, `std_amt`,'0' from emp_deduct where emp_id in (select emp_id from tran_days where client_id = '".$client_id."')";
$rowtab= mysql_query($sqltab);

$sqltab = "INSERT INTO tab_emp".$user_id ." (`emp_id`,`sal_month`, `client_id`, `desg_id`, `dept_id`, `qualif_id`, `bank_id`, `loc_id`, `paycode_id`, `bankacno`, `esistatus`,`esino`, `comp_ticket_no`, `married_status`, `comp_id`, `user_id`,`pfno`) select `emp_id`, '".$cmonth."', `client_id`, `desg_id`, `dept_id`, `qualif_id`, `bank_id`, `loc_id`, `paycode_id`, `bankacno`, `esistatus`,`esino`, `comp_ticket_no`, `married_status` ,'".$comp_id."','".$user_id."',`pfno` from employee where emp_id in  (select emp_id from tran_days where client_id = '".$client_id."')";

$rowtab= mysql_query($sqltab);


//**************************************************************************************************************************
//payable days calculation ******************************************
 
$sql= "update tab_emp".$user_id." te inner join tran_days td  on td.emp_id = te.emp_id set te.payabledays =td.PRESENT+td.paidholiday+td.pl+td.cl+td.sl+td.additional+td.otherleave+td.weeklyoff where td.emp_id in (select emp_id from tab_inc".$user_id." inner join mast_income_heads on mast_income_heads.mast_income_heads_id = tab_inc".$user_id.".head_id where mast_income_heads.`income_heads_name` LIKE '%BASIC%'  and mast_income_heads.comp_id = '".$comp_id."' and tab_inc".$user_id.".calc_type in( 2,4))  and te.client_id = '".$client_id."'" ;
$row= mysql_query($sql);
	
$sql= "update  tab_emp".$user_id." te inner join tran_days td  on td.emp_id = te.emp_id set te.payabledays =td.pl+td.cl+td.sl+td.additional+td.otherleave+td.PRESENT+td.paidholiday where td.emp_id in (select emp_id from tab_inc".$user_id." inner join mast_income_heads on mast_income_heads.mast_income_heads_id = tab_inc".$user_id.".head_id where mast_income_heads. `income_heads_name` LIKE '%BASIC%' and mast_income_heads.comp_id = '".$comp_id."' and tab_inc".$user_id.".calc_type in( 1,3,5) )  and te.client_id = '".$client_id."'" ;
$row= mysql_query($sql);
	

//**************************************************************************************************************************
//income calculation ******************************************
//type -1 26/27	
$sql = "update  tab_inc".$user_id." ti inner join tab_emp".$user_id ." te on te.emp_id = ti.emp_id  inner join tran_days td on td.emp_id = ti.emp_id   set ti.amount = round(ti.std_amt/26*te.payabledays,2)  where ti.calc_type= 1 and td.weeklyoff <4 and client_id = '".$client_id ."' and te.payabledays >0  ";
$row= mysql_query($sql);

$sql = "update  tab_inc".$user_id." ti inner join tab_emp".$user_id ." te on te.emp_id = ti.emp_id  inner join tran_days td on td.emp_id = ti.emp_id  set ti.amount = round(ti.std_amt/(day('".$endmth."')-td.weeklyoff)*te.payabledays,2)  where ti.calc_type= 1 and td.weeklyoff >=4 and te.client_id = '".$client_id ."' and te.payabledays >0 " ;
$row= mysql_query($sql);

$sql = "update  tab_inc".$user_id." ti inner join tab_emp".$user_id ." te on te.emp_id = ti.emp_id  inner join tran_days td on td.emp_id = ti.emp_id   set ti.amount = 0  where client_id = '".$client_id ."' and te.payabledays =0  ";
$row= mysql_query($sql);

//type -2 30/31	

$sql = "update tab_inc".$user_id."  ti inner join tab_emp".$user_id ." te on te.emp_id = ti.emp_id   set ti.amount = round(ti.std_amt/day('".$endmth."')*te.payabledays,2) where ti.calc_type= 2 and te.client_id = '".$client_id ."'";
$row= mysql_query($sql);



//type -3 26 days fixed 	
$sql = "update  tab_inc".$user_id." ti inner join tab_emp".$user_id ." te on te.emp_id = ti.emp_id  inner join tran_days td on td.emp_id = ti.emp_id   set ti.amount = round(ti.std_amt/26*te.payabledays,2)  where ti.calc_type= 3  and client_id = '".$client_id ."'";
$row= mysql_query($sql);


//type -4 Consolidated  
$sql = "update tab_inc".$user_id."  ti  inner join tab_emp".$user_id ." te on te.emp_id = ti.emp_id  set ti.amount = ti.std_amt where ti.calc_type= 4 and  te.client_id = '".$client_id ."'";
$row= mysql_query($sql);

//type -5 Daily wages
$sql = "update tab_inc".$user_id."  ti  inner join tab_emp".$user_id ." te on te.emp_id = ti.emp_id   set ti.amount = round(ti.std_amt*te.payabledays,2)  where ti.calc_type= 5 and te.client_id = '".$client_id ."'";
$row= mysql_query($sql);




//grosssalary updation in tab_emp for overtime calculation
$sql = "update tab_emp".$user_id ." te inner join (select emp_id,sum(amount) as amt from tab_inc".$user_id ." ti  where ti.head_id not in (select mast_income_heads_id from mast_income_heads  where  (`income_heads_name` LIKE '%PAP. ALL.%' or `income_heads_name` LIKE '%WASHING ALLOW.%' ) and comp_id = '".$comp_id."'  )  group by emp_id ) ti on te.emp_id = ti.emp_id  set te.gross_salary = ti.amt where te.client_id ='".$client_id ."'";
$row= mysql_query($sql);


//Overtime Calculation
$sql2 = "update tab_inc".$user_id ." ti inner join tab_emp".$user_id." te on te.emp_id = ti.emp_id  inner join tran_days td on td.emp_id = ti.emp_id      set std_amt = round((te.gross_salary*2)/(te.payabledays*8),2 ) ,amount = (round((te.gross_salary*2)/(te.payabledays*8),2 )) *td.othours  where ti.head_id in (select mast_income_heads_id from mast_income_heads  where  (`income_heads_name` LIKE '%OVERTIME%' ) and comp_id = '".$comp_id."'  ) and calc_type = 7"; 
$row4= mysql_query($sql2);


//Adding records of extra income1income2,extra deduction1,extra deduction2 to respective tables 
  $sql11 = "select mast_income_heads_id as head_id from mast_income_heads  where  `income_heads_name` LIKE '%Extra Income-1%' and  comp_id = '".$comp_id."'";
$row21= mysql_query($sql11);
$row31 = mysql_fetch_assoc($row21);

$sql1 = "select emp_id,extra_inc1 from tran_days where client_id = '".$client_id ."' and extra_inc1 >0 ";
$row1= mysql_query($sql1);
while($row2 = mysql_fetch_assoc($row1))
{
  $sql21 = "insert into tab_inc".$user_id ." (emp_id,head_id,std_amt,amount,sal_month,calc_type) values ('".$row2['emp_id']."' ,'".$row31['head_id']."','0','".$row2['extra_inc1']."','".$cmonth."','0')";
	$row22= mysql_query($sql21);	
	
}

//Overtime Calculation over

//Night Shifts Calculation
 $sql = "update  tab_inc".$user_id." ti inner join tab_emp".$user_id ." te on te.emp_id = ti.emp_id  inner join tran_days td on td.emp_id = ti.emp_id   set ti.amount = round(20*td.nightshifts,2)  where ti.calc_type= 8 and td.nightshifts <= 15  and te.client_id = '".$client_id ."' and te.payabledays >0  ";

$row= mysql_query($sql);

$sql = "update  tab_inc".$user_id." ti inner join tab_emp".$user_id ." te on te.emp_id = ti.emp_id  inner join tran_days td on td.emp_id = ti.emp_id   set ti.amount = round(27*td.nightshifts,2)  where ti.calc_type= 8 and td.nightshifts > 15  and te.client_id = '".$client_id ."' and te.payabledays >0  ";
$row= mysql_query($sql);

$sql = "update  tab_inc".$user_id." ti inner join tab_emp".$user_id ." te on te.emp_id = ti.emp_id  inner join tran_days td on td.emp_id = ti.emp_id   set ti.amount = round(25*td.nightshifts,2)  where ti.calc_type= 9 and td.nightshifts <= 15  and  te.client_id = '".$client_id ."' and te.payabledays >0  ";
$row= mysql_query($sql);

$sql = "update  tab_inc".$user_id." ti inner join tab_emp".$user_id ." te on te.emp_id = ti.emp_id  inner join tran_days td on td.emp_id = ti.emp_id   set ti.amount = round(34.5*td.nightshifts,2)  where ti.calc_type= 9 and td.nightshifts > 15  and  te.client_id = '".$client_id ."' and te.payabledays >0  ";
$row= mysql_query($sql);


//extra_inc2
//echo $sql11 = "select mast_income_heads_id as head_id from mast_income_heads  where  `income_heads_name` LIKE '%REIMBURSEMENT'  and comp_id = '".$comp_id."'";
//$row21= mysql_query($sql11);
//$row31 = mysql_fetch_assoc($row21);

//echo $sql1 = "select emp_id,extra_inc2 from tran_days where client_id = '".$client_id ."' and extra_inc2 >0 ";
//$row1= mysql_query($sql1);
//while($row2 = mysql_fetch_assoc($row1))
//{
//	$sql21 = "insert into tab_inc".$user_id ." (emp_id,head_id,std_amt,amount) values ('".$row2['emp_id']."' ,'".$row31['head_id']."','0','".$row2['extra_inc2']."')";
//	$row22= mysql_query($sql21);	
//	
//}


//grosssalary updation in tab_emp
$sql = "update tab_emp".$user_id ." te inner join (select emp_id,sum(amount) as amt from tab_inc".$user_id ." group by emp_id ) ti on te.emp_id = ti.emp_id  set te.gross_salary = ti.amt where te.client_id ='".$client_id ."'";
$row= mysql_query($sql);

//**************************************************************************************************************************


//PF Calculation

 $sql = "SELECT *  FROM tab_ded".$user_id." t inner join mast_deduct_heads md on md.mast_deduct_heads_id = t.head_id  WHERE md.`deduct_heads_name` LIKE '%P.F.%'  and comp_id = '".$comp_id."'";
$row= mysql_query($sql);
while ($row1 = mysql_fetch_array($row)) 
{ 
    $sql1= "SELECT sum(amount) as amount FROM tab_inc".$user_id." WHERE   emp_id = '".$row1["emp_id"]."' and head_id in (select mast_income_heads_id from mast_income_heads  where  (`income_heads_name` LIKE '%BASIC%' or `income_heads_name` LIKE '%D.A.%' OR `income_heads_name` LIKE '%wage%' ) and comp_id = '".$comp_id."'  )";
	
	$row2 = mysql_query($sql1);
	$row3 = mysql_fetch_array($row2);
	//print_r($row3);
	$std_amt = '0';
	$employer_contri_2 = '0';
	$employer_contri_1 = '0';

	 if(intval($row3["amount"]) > '15000' )
	{
		$std_amt = 15000;
		
	}
	else
	 {
		 $std_amt = $row3["amount"];
	}

    $amount = ROUND(($std_amt)*(12/100),0);
	$employer_contri_2 = ROUND(($std_amt)*0.0833,0);
    if($employer_contri_2 > 1250)
	{
		$employer_contri_2='1250';
		}
	$employer_contri_1 = $amount - $employer_contri_2;
	
 $sql2 = "update tab_ded".$user_id." set std_amt = '".$std_amt."',amount = '".$amount."',employer_contri_1 ='".$employer_contri_1."',employer_contri_2 ='".$employer_contri_2."' where emp_id = '".$row1["emp_id"]."'and head_id = '".$row1["head_id"]."'"; 
	$row4= mysql_query($sql2);
	
	
	
}

// end of pf calculation

//echo $m=date('m',$cmonth);
 $d = explode("-", $cmonth);
$month =  $d['1'];


//$parts = explode('-',$cmonth);
//echo "2  ".$month = $parts[1];


//ESI Calculation
if( $month == '06' or  $month == '10')
{
$sqltab = "DROP TABLE IF EXISTS tab_esi".$user_id ;
$rowtab= mysql_query($sqltab);


$sqltab = "DROP TABLE IF EXISTS tab_esi2".$user_id ;
$rowtab= mysql_query($sqltab);

$sqltab = "create table   tab_esi".$user_id ." as (select * from  emp_income where 1=2)";
$rowtab= mysql_query($sqltab);


//to find std income	
 $sqltab = "insert into tab_esi".$user_id." select ei.* from emp_income ei inner join employee e on e.emp_id =ei.emp_id where e.client_id = '".$client_id ."' and e.job_status != 'L'";
$rowtab= mysql_query($sqltab);
	
$sqltab = "update 	tab_esi".$user_id." set std_amt = std_amt*26 where calc_type = 4";
$rowtab= mysql_query($sqltab);

$sql = "update tab_emp".$user_id ." te inner join (select emp_id,sum(std_amt) as amt from tab_esi".$user_id ." group by emp_id ) tesi on te.emp_id = tesi.emp_id  set te.esistatus = 'Y' where te.client_id ='".$client_id ."' nd tesi.amt <21000  ";
$row= mysql_query($sql);
}	
?>
</br>
<?php

// updating  totgrsal-OVERTIME in totdeduct field 
 $sql = "update tab_emp".$user_id ."  te inner join (select emp_id,sum(amount) as amt from tab_inc".$user_id ." where head_id not in(select mast_income_heads_id from mast_income_heads  where  (`income_heads_name` LIKE '%WASHING%')  and comp_id = '".$comp_id."'   ) group by emp_id) ti on ti.emp_id = te.emp_id  set te.tot_deduct = ti.amt where te.client_id = '".$client_id ."'";
$row= mysql_query($sql);

?>
</br>
<?php
  //updating employee`s contribution
$sql = "update tab_ded".$user_id ."  tdd inner join (select emp_id,tot_deduct,client_id  from tab_emp".$user_id ." where client_id =  '".$client_id ."' and  esistatus = 'Y' ) te on te.emp_id = tdd.emp_id  set tdd.std_amt =te.tot_deduct, tdd.amount = round(te.tot_deduct*0.0175,0),tdd.employer_contri_1 = round(te.tot_deduct*0.0475,0) where te.client_id = '".$client_id ."' and  tdd.head_id  in(select mast_deduct_heads_id from mast_deduct_heads  where  `deduct_heads_name` LIKE '%E.S.I.%' and comp_id = '".$comp_id." ' )";
$row= mysql_query($sql);
?>
</br>
<?php

//updating employer`s contribution 
$sql = "update tab_ded".$user_id ."  tdd inner join (select emp_id,totdeduct  from tab_emp".$user_id ." where client_id = '".$client_id ."' and  esistatus = 'Y' ) te on te.emp_id = tdd.emp_id  set tdd.employer_contri_1 = round(ti.amt*0.0475,0) where tdd.client_id = '".$client_id ."' and  head_id  in(select mast_deduct_heads from mast_deduct_heads  where  `mast_deduct_heads` LIKE '%ESI%' and comp_id = '".$comp_id."' )";
$row= mysql_query($sql);
?>
</br>
<?php

///////End of esino`********************

//Calculation of profession tax 

$sql = "update tab_ded".$user_id ."  tdd inner join (select temp.emp_id,temp.gross_salary,e.gender from tab_emp".$user_id ." temp INNER join employee e on e.emp_id = temp.emp_id where temp.client_id = '".$client_id ."' )  te on tdd.emp_id = te.emp_id  set amount = 175  where te.gross_salary >7500 and te.gross_salary =<10000 and te.gender = 'M' and head_id in (select mast_deduct_heads_id from mast_deduct_heads  where  `deduct_heads_name` LIKE '%PROF. TAX%'  and comp_id = '".$comp_id."')";
$row= mysql_query($sql);

$sql = "update tab_ded".$user_id ."  tdd inner join (select temp.emp_id,temp.gross_salary,e.gender from tab_emp".$user_id ." temp INNER join employee e on e.emp_id = temp.emp_id where temp.client_id = '".$client_id ."' ) te on tdd.emp_id = te.emp_id  set amount = 200  where te.gross_salary >10000 and month('".$cmonth."')!=3  and head_id in (select mast_deduct_heads_id from mast_deduct_heads  where  `deduct_heads_name` LIKE '%PROF. TAX%' and comp_id = '".$comp_id."')";
$row= mysql_query($sql);

$sql = "update tab_ded".$user_id ."  tdd inner join (select temp.emp_id,temp.gross_salary,e.gender from tab_emp".$user_id ." temp INNER join employee e on e.emp_id = temp.emp_id where temp.client_id = '".$client_id ."' )  te on tdd.emp_id = te.emp_id  set amount = 300  where te.gross_salary >10000 and month('".$cmonth."')=3 and head_id in (select mast_deduct_heads_id from mast_deduct_heads  where  `deduct_heads_name` LIKE '%PROF. TAX%'  and comp_id = '".$comp_id."') ";
$row= mysql_query($sql);



//Calculation of LABOURFUND welfare

$sql = "update tab_ded".$user_id ."  tdd inner join (select emp_id,gross_salary from tab_emp".$user_id ." where client_id ='".$client_id ."' ) te on tdd.emp_id = te.emp_id  set amount = 6,employer_contri_1 = 18  where te.gross_salary <=3000 and (month('".$cmonth."')=12 or month('".$cmonth."')=6 )and head_id in (select mast_deduct_heads_id from mast_deduct_heads  where  `deduct_heads_name` LIKE '%L.W.F.%' and comp_id = '".$comp_id."') ";
$row= mysql_query($sql);

$sql = "update tab_ded".$user_id ."  tdd inner join (select emp_id,gross_salary from tab_emp".$user_id ." where client_id= '".$client_id ."' ) te on tdd.emp_id = te.emp_id  set amount = 12,employer_contri_1 = 36  where te.gross_salary >3000 and (month('".$cmonth."')=12 or month('".$cmonth."')=6 )and head_id in (select mast_deduct_heads_id from mast_deduct_heads  where  `deduct_heads_name` LIKE '%L.W.F.%' and comp_id = '".$comp_id."') ";
$row= mysql_query($sql);


//Calculation of tds10%

$sql = "update tab_ded".$user_id ."  tdd inner join (select emp_id,gross_salary from tab_emp".$user_id ." where client_id= '".$client_id ."' ) te on tdd.emp_id = te.emp_id  set amount = round(te.gross_salary*0.1,0),std_amt =te.gross_salary  where te.gross_salary >0 and  head_id in (select mast_deduct_heads_id from mast_deduct_heads  where  `deduct_heads_name` LIKE '%TDS (10%)%' and comp_id = '".$comp_id."') ";
$row= mysql_query($sql);

//type -4 Consolidated  
 $sql = "update tab_ded".$user_id."  tdd  inner join tab_emp".$user_id ." te on te.emp_id = tdd.emp_id  set tdd.amount = tdd.std_amt where tdd.calc_type= 3 and  te.client_id = '".$client_id ."'";

$row= mysql_query($sql);



//Adding records of extra deduction1 extra deduction2 to respective tables 
$sql11 = "select mast_deduct_heads_id as head_id from mast_deduct_heads  where  `deduct_heads_name` LIKE '%Extra Deduct-1%' and comp_id = '".$comp_id."'";
$row21= mysql_query($sql11);
$row31 = mysql_fetch_assoc($row21);

$sql1 = "select emp_id,extra_ded1 from tran_days where client_id = '".$client_id ."' and extra_ded1 >0 ";
$row1= mysql_query($sql1);
while($row2 = mysql_fetch_array($row1))
{
	//print_r($row2);
	//echo $row2['emp_id'];
	 $emp = $row2['emp_id'];
$sql21 = "insert into tab_ded".$user_id ." (emp_id,head_id,std_amt,amount,sal_month,calc_type) values ('".$emp."' ,'".$row31['head_id']."','0','".$row2['extra_ded1']."','".$cmonth."','0')";
	$row22= mysql_query($sql21);	
	
}

//extra_deduct2
$sql11 = "select mast_deduct_heads_id as head_id from mast_deduct_heads  where  `deduct_heads_name` LIKE '%Extra Deduct-2%' and comp_id = '".$comp_id."'";
$row21= mysql_query($sql11);
$row31 = mysql_fetch_assoc($row21);

$sql1 = "select emp_id,extra_ded2 from tran_days where client_id = '".$client_id ."' and extra_ded2 >0 ";
$row1= mysql_query($sql1);
while($row2 = mysql_fetch_assoc($row1))
{
	$sql21 = "insert into tab_ded".$user_id ." (emp_id,head_id,std_amt,amount,sal_month,calc_type) values ('". $row2['emp_id']."' ,'".$row31['head_id']."','0','".$row2['extra_ded2']."','".$cmonth."','0')";
	$row22= mysql_query($sql21);	
	
}



//**************************************************************************************************************************
//deduction calculation ******************************************
//type -1 26/27	
$sql = "update  tab_ded".$user_id." tdd inner join tab_emp".$user_id ." te on te.emp_id = tdd.emp_id  inner join tran_days td on tdd.emp_id = td.emp_id   set tdd.amount = round(tdd.std_amt/26*te.payabledays,2)  where tdd.calc_type= 1 and td.weeklyoff <4 and client_id = '".$client_id ."' and te.payabledays >0  ";
$row= mysql_query($sql);

echo $sql = "update  tab_ded".$user_id." tdd inner join tab_emp".$user_id ." te on te.emp_id = tdd.emp_id  inner join tran_days td on tdd.emp_id = td.emp_id  set tdd.amount = round(tdd.std_amt/(day('".$endmth."')-td.weeklyoff)*te.payabledays,2)  where tdd.calc_type= 1 and td.weeklyoff >=4 and te.client_id = '".$client_id ."' and te.payabledays >0 " ;
$row= mysql_query($sql);

$sql = "update  tab_ded".$user_id." tdd inner join tab_emp".$user_id ." te on te.emp_id = tdd.emp_id  inner join tran_days td on tdd.emp_id = td.emp_id   set tdd.amount = 0  where client_id = '".$client_id ."' and te.payabledays =0  ";
$row= mysql_query($sql);

//totdeduct updation in tab_emp from tab_ded
$sql = "update tab_emp".$user_id ." te inner join (select emp_id,sum(amount) as amt from tab_ded".$user_id ." group by emp_id ) tdd on te.emp_id = tdd.emp_id  set te.tot_deduct = tdd.amt where te.client_id ='".$client_id ."'";
$row= mysql_query($sql);








//Calculation of advances

$sqltab = "DROP TABLE IF EXISTS tab_adv".$user_id ;
$rowtab= mysql_query($sqltab);

$sqltab = "create table   tab_adv".$user_id ." as (select * from  tran_advance where 1=2)";
$rowtab= mysql_query($sqltab);

 $sqltab = "INSERT INTO tab_adv".$user_id ." (`emp_id`, `client_id`, `sal_month`, `head_id`, `calc_type`, `std_amt`, `amount`, `paid_amt`, `emp_advance_id` ) select `emp_id`, '".$client_id."',  '".$cmonth."',`advance_type_id`,'0',adv_amount,`adv_installment`,'0',`emp_advnacen_id` from emp_advnacen where adv_installment > 0 and closed_on = '0000-00-00' and emp_id in  (select emp_id from tran_days where client_id = '".$client_id."')";

$rowtab= mysql_query($sqltab);


 $sql = "update tab_adv".$user_id ." tadv inner join (select emp_id,sum(amount) as amt from hist_advance group by emp_id,emp_advance_id ) hadv on tadv.emp_id = hadv.emp_id and  tadv.emp_advance_id = hadv.emp_advance_id  set tadv.paid_amt = hadv.amt ";
$row= mysql_query($sql);

$sql = "update tab_adv".$user_id ." tadv set tadv.amount = std_amt-paid_amt where amount >  std_amt-paid_amt";
$row= mysql_query($sql);

$sql = "update tab_emp".$user_id ." te inner join (select emp_id,sum(amount) as amt from tab_adv".$user_id ." group by emp_id ) tadv on te.emp_id = tadv.emp_id  set te.tot_deduct = te.tot_deduct+tadv.amt where te.client_id ='".$client_id ."'";
$row= mysql_query($sql);





//Calculation of netsalary
$sql = "update tab_emp".$user_id ." te  inner join tran_days td on te.emp_id = td.emp_id set te.netsalary = round(te.gross_salary - te.tot_deduct+td.extra_inc2,0) where  te.client_id ='".$client_id ."'";
$row= mysql_query($sql);


//*************************************
//Updating data into tran files

 $sql = "DELETE FROM tran_employee WHERE emp_id IN ( SELECT emp_id FROM tran_days WHERE client_id= '".$client_id. "')";
$row= mysql_query($sql);

$sql = "DELETE FROM tran_deduct WHERE emp_id IN ( SELECT emp_id FROM tran_days WHERE client_id= '".$client_id. "')";
$row= mysql_query($sql);

$sql = "DELETE FROM tran_income WHERE emp_id IN ( SELECT emp_id FROM tran_days WHERE client_id= '".$client_id. "')";
$row= mysql_query($sql);

$sql = "DELETE FROM tran_advance WHERE emp_id IN ( SELECT emp_id FROM tran_days WHERE client_id= '".$client_id. "')";
$row= mysql_query($sql);

$sql = "insert into tran_employee select * from tab_emp".$user_id ;
$row= mysql_query($sql);

$sql = "insert into tran_income select * from tab_inc".$user_id ;
$row= mysql_query($sql);

$sql = "insert into tran_deduct select * from tab_ded".$user_id;
$row= mysql_query($sql);

$sql = "insert into tran_advance select * from tab_adv".$user_id;
$row= mysql_query($sql);



echo "Finished.";
exit;




?>