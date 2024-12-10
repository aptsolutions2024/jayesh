<?php
session_start();

include("../lib/class/user-class.php");
$userObj=new user();
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', dirname(__FILE__) . '/error_log.txt');
error_reporting(E_ALL);
$client_id = $_POST['clientid'];

$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];

$cl_name = $userObj->displayClient($client_id);

$cmonth = $cl_name['current_month'];
$endmth =$userObj->getLastDay($cmonth);

$monthdays = $userObj->getMonthDay1($cmonth);

$startmth =$userObj->getFirstDay($cmonth);



$row = $userObj->updateSalCalTranEmployee();

$row = $userObj->updateSalCalTranAdvance();

$row = $userObj->updateSalCalTranDays();

$row=$userObj->deleteSalCalTranDays($client_id);

echo "&&&&&&&&&&&&&&&";
// Checking data validity
	$row=$userObj->updateSalCalInvalidTranDays($client_id);
	  
// step 1. checking for left employees
	
	$row=$userObj->getSalCalLeftEmployee($client_id);
	$row1=$row;
	
	if(mysqli_num_rows($row) !=0)
		{echo "\n Days details are available for left employees.Records will be deleted.".chr(13).chr(10);
			while($res = $row->fetch_assoc()){
				echo $res['first_name']." ".$res['middle_name']." ".$res['last_name'].chr(13).chr(10);
				$userObj->delSalCalTranDaysByEmployee($res['emp_id']);
				
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


	
	
	$row=$userObj->getSalCalNotLeftEmployee($client_id);
	$row1=$row;
	
	if(mysqli_num_rows($row) !=0)
		{echo "\n Records will be added for following employee.".chr(13).chr(10);
			while($res = $row->fetch_assoc()){
				echo $res['first_name']." ".$res['middle_name']." ".$res['last_name'].chr(13).chr(10);
				$userObj->getSalCalInsertTranDay($res['emp_id'],$endmth,$client_id,$comp_id,$user_id);
			}
		};

		
	//(presentday=0 .and. othours>0)
	
	$row= $userObj->getSalCalTranDayPres0NotOther0($client_id);
	if(       mysqli_num_rows($row) !=0)
		{echo "\nInvalid Othours.Please Check Transction Days Details.";
			while($res = $row->fetch_assoc()){
				
				$userObj->updateSalCalTranDayInvalidOt($res['trd_id']);
			}
		};
	//All days calculation - Regular emloyees
												
    /**/
	$row= $userObj->getAllDaysCalculation($monthdays,$client_id,$startmth);
	if(mysqli_num_rows($row) !=0)
		{echo "\nInvalid Total Days for Regular Employee.Please Check Transaction Days Details.";
			while($res = $row->fetch_assoc()){
				$userObj->updateSalCalTranDayInvalidTotalDay($res['trd_id']);
			}
		};
		

	//All days calculation - Newly joined emloyees

	$row= $userObj->getAllDaysCalculationNewEmployee($monthdays,$client_id,$startmth);
//	print_r ($row);
	if(mysqli_num_rows($row) !=0)
		{echo " Invalid Total Days.Please Check Transaction Days Details.";
			while($res =$row->fetch_assoc()){
				$userObj->updateSalCalTranDayInvalidTotalDayNewEmp($res['trd_id']);
			}
		};

	//All days calculation - left emloyees
	
	$row= $userObj->getAllDaysCalculationLeftEmployee($client_id,$startmth);
	if(mysqli_num_rows($row) !=0)
		{echo "Invalid Total Days.Please Check Transaction Days Details.";
			while($res = $row->fetch_assoc()){
				$userObj->updateAllDaysCalculationLeftEmployee($res['trd_id']);
			}
		};

// Days checking is over.

echo "HHHHHHHHHHHHHHHHHH";exit;

//Salary Calculation

	$row=$userObj->getsalCalAllDaysCalculationInvalid($client_id);
	
	if(       mysqli_num_rows($row) !=0)
	{ ?>
		<br/>
	<?php 
		echo   "Invalid flag. Can not Proceed.";
//		exit;
		}
//temp tables creation

$userObj->creatSalCalTabIncUser($user_id);

$userObj->creatSalCalTabDedUser($user_id);

$userObj->creatSalCalTabEmpUser($user_id);

echo "HHHHHHHHHHHHHHHHHH";

//insertion of data into temp tables.
 $rowtab = $userObj->updateSalCalTranDays1();
 
 $rowtab = $userObj->updateSalCalTranDays2();

$rowtab = $userObj->updateSalCalTabInc($user_id,$cmonth,$client_id);

$rowtab = $userObj->updateSalCalTabDed($user_id,$cmonth,$client_id);

$rowtab = $userObj->updateSalCalTabEmp($user_id,$cmonth,$comp_id,$client_id);


echo "1  //********************************************************************";
//******************************************************
//payable days calculation ******************************************
 

$row = $userObj->updateSalCalPayableDay($user_id,$comp_id,$client_id);

$row = $userObj->updateSalCalPayableDay1($user_id,$comp_id,$client_id);
	
	
//**************************************************************************************************************************
//income calculation ******************************************
//type -1 26/27	

$row = $userObj->updateSalCalIncomeCalType1_26_27($user_id,$client_id);

$row = $userObj->updateSalCalIncomeCalType1_26_27_1($user_id,$endmth,$client_id);

$row = $userObj->updateSalCalIncomeCalType1_26_27_2($user_id,$client_id);


//type -2 30/31	

$row = $userObj->updateSalCalIncomeCalType2_30_31($user_id,$endmth,$client_id);

//type -14 26 days fixed 

$row = $userObj->updateSalCalIncomeCalType2_14_26($user_id,$client_id);

//type -3Consolidated  

$row = $userObj->updateSalCalIncomeCalType3Consilidated($user_id,$client_id);

//type -5 Daily wages

$row = $userObj->updateSalCalIncomeCalType5DailyWages($user_id,$client_id);

//type -16 per presnt Day

$row = $userObj->updateSalCalIncomeCalType16PerPresentDay($user_id,$client_id);

//type -14 26 days per month

 $row = $userObj->updateSalCalIncomeCalType14_26dayPerMonth($user_id,$client_id);

//grosssalary updation in tab_emp for overtime calculation- 7 or 12 (GROSS-WASHING-(PAP ALL+PERTOL aLL))/8*2   /  (GROSS-WASHING-PAP ALL)/8 

 $row = $userObj->updateSalCalGrossSalOvertime($user_id,$comp_id,$client_id);

//Overtime Calculation - calc_type 7or 12

//calc_type -15 per hour 

 $row = $userObj->updateSalCalType15PerHour($user_id,$client_id);
 
 $row4 = $userObj->updateSalCalType7PerHour($user_id,$comp_id);
 
 $row4 = $userObj->updateSalCalType12PerHour($user_id,$comp_id);

//grosssalary updation in tab_emp for overtime calculation-11 (GROSS-CONVEYANCE)/8*2

 $row4 = $userObj->updateSalCalGrossalOvrTCal11($user_id,$comp_id,$client_id);

$row4 = $userObj->updateSalCalGrossalOvrTCal11_1($user_id,$comp_id);

echo " //grosssalary updation in tab_emp for overtime calculation-13 (BASIC+DA)/8*2";

$row4 = $userObj->updateSalCalGrossalOvrTCal13($user_id,$comp_id,$client_id);

$row4 = $userObj->updateSalCalGrossalOvrTCal13_1($user_id,$comp_id);

//Overtime Calculation over * * * * * * * * * * * * * * * * * * * 

//Night Shifts Calculation

$row = $userObj->updateSalCalNightShift20($user_id,$client_id);

$row = $userObj->updateSalCalNightShift27($user_id,$client_id);

$row = $userObj->updateSalCalNightShift25($user_id,$client_id);

$row = $userObj->updateSalCalNightShift34($user_id,$client_id);

$row = $userObj->updateSalCalNightShift($user_id,$client_id);

//Night Shifts Calculation * * * * * * * * * * * * * * * * * * * * * 

//Adding records of extra income1income2,extra deduction1,extra deduction2 to respective tables 


$row21 = $userObj->getSalCalExtraIncome($comp_id);
$row31 = $row21->fetch_assoc();


$row1 = $userObj->getSalCalExtraIncome1($client_id);
while($row2 = $row1->fetch_assoc())
{
	$userObj->insertSalCalTabInc($user_id,$row2['emp_id'],$row31['head_id'],$row2['extra_inc1'],$cmonth);
}


$row21 = $userObj->getSalCalIncHeadIncome2($comp_id);
$row31 = $row21->fetch_assoc();

$row1 = $userObj->getSalCalExtraIncome2($client_id);
while($row2 = $row1->fetch_assoc())
{
  $userObj->insertSalCalTabInc2($user_id,$row2['emp_id'],$row31['head_id'],$row2['extra_inc2'],$cmonth);
}

//Adding records of wagediff  to respective tables 

if ($_POST['wagediff']>0) 
	
	{
			$wagediffrate= $_POST['wagediff'];

			$res1 = $userObj->getSalCalPrevMonth($cmonth);
            $res2 = $res1->fetch_assoc();
			//$res2['prev_month'];
			
			
			$row21 = $userObj->getSalCalWageDiffIncomeHead($comp_id);
			$row31 = $row21->fetch_assoc();

			
			$row1 = $userObj->getSalCalPayableDay($client_id,$res2['prev_month']);
			//$sql1= "SELECT sum(amount) as amount FROM hist_income WHERE   emp_id = '".$row1["emp_id"]."' and head_id in (select mast_income_heads_id from mast_income_heads  where  (`income_heads_name` LIKE '%BASIC%' or `income_heads_name` LIKE '%D.A.%'  ) and comp_id = '".$comp_id."'  )";
			
		
			while($row2 = $row1->fetch_assoc())
			{
		   if ($row2['payabledays']>0)
		   {
				$userObj->insertSalCalPayableDay($user_id,$row2['emp_id'],$row31['head_id'],$wagediffrate,$row2['payabledays'],$cmonth);
			}
		   
			} 
		
		
	}
else
	
	{
        
        $row21 = $userObj->getSalCalWithoutWageDiffIncomeHead($comp_id);
		$row31 = $row21->fetch_assoc();

		$row1= $userObj->getSalCalWageDiffByClient($client_id);
		while($row2 = $row1->fetch_assoc())
		{
			$userObj->insertSalCalTabIncUser($user_id,$row2['emp_id'],$row31['head_id'],$row2['wagediff'],$cmonth);
		}
	}
//Adding records of allow_arrears to respective tables 
if ($_POST['allowdiff']>0) 
	
	{
			$allowdiffrate= $_POST['allowdiff'];
			$res1= $userObj->getSalCalPrevMonth();
			$res2 = $res1->fetch_assoc();
			
		 
			$row21=$userObj->getSalCalALWArrears($comp_id);
			$row31 = mysql_fetch_assoc($row21);

			$row1=$userObj->getSalCalPayableDays($client_id,$res2['prev_month']);
			
			//$sql1= "SELECT sum(amount) as amount FROM hist_income WHERE   emp_id = '".$row1["emp_id"]."' and head_id in (select mast_income_heads_id from mast_income_heads  where  (`income_heads_name` LIKE '%BASIC%' or `income_heads_name` LIKE '%D.A.%'  ) and comp_id = '".$comp_id."'  )";
			
		
			while($row2 = $row1->fetch_assoc())
			{
		      if ($row2['payabledays']>0){
		          $userObj->getSalCalTabIncUserAllOwDiff($user_id,$row2['emp_id'],$row31['head_id'],$allowdiffrate,$row2['payabledays'],$cmonth);
			  }
		
		
	}}
else
	
	{

		$row21 = $userObj->getSalCalALWArrears($comp_id);
		$row31 = $row21->fetch_assoc();

		 /*$sql1 = "select emp_id,Allow_arrears from tran_days where client_id = '".$client_id ."' and Allow_arrears >0 ";
		$row1= mysql_query($sql1);*/
		$row1 = $userObj->getSalCalALWArrearsTranDay($client_id);
		while($row2 = $row1->fetch_assoc())
		{  
		    $userObj->insertSalCalALWArrearsTabIncUser($user_id,$row2['emp_id'],$row31['head_id'],$row2['Allow_arrears'],$cmonth);
			
		}
	}
//Adding records of ot arrears  to respective tables 

if ($_POST['otdiff']>0) 
	
	{
			$otdiffrate= $_POST['otdiff'];
			$res1 = $userObj->getSalCalPrevMonth($cmonth);
			$res2 = $res1->fetch_assoc();
			
		
			$row21=$userObj->getSalCalIncomeHeadOT($comp_id);
			$row31 = $row21->fetch_assoc();

			$row1= $userObj->getSalCalOTTranHistDay($client_id,$res2['prev_month']);
			
			while($row2 = $row1->fetch_assoc())
			{ 
		      if ($row2['othours']>0){
					 
					$userObj->insertSalCalOTTabIncUser($user_id,$row2['emp_id'],$row31['head_id'],$otdiffrate,$row2['othours'],$cmonth);
					}
			}
	}
else
	{

		$row21= $userObj->getSalCalIncomeHeadOT($comp_id);
		$row31 = $row21->fetch_assoc();

		$row1 = $userObj->getSalCalOtApprearsTranDay22($client_id);
		while($row2 = $row1->fetch_assoc())
		{
		
			$userObj->insertSalCalOTTabIncUser1($user_id,$row2['emp_id'],$row31['head_id'],$row2['Ot_arrears'],$cmonth);
		}
	}
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
$userObj->updateSalCalTabIncUserGross($user_id,$client_id);


//**************************************************************************************************************************
$row=$userObj->pf_calc($comp_id,$user_id,$endmth);

//PF Calculation

/* $sql = "SELECT e.bdate,t.*  FROM tab_ded".$user_id." t inner join employee e on e.emp_id = t.emp_id inner join mast_deduct_heads md on md.mast_deduct_heads_id = t.head_id  WHERE md.`deduct_heads_name` LIKE '%P.F.%'  and md.comp_id = '".$comp_id."'";
$row= mysql_query($sql);


while ($row1 = mysql_fetch_array($row)) 
{ 
// echo "*********************************************************************************$$$$$$$$$$$$$$$$$$$$$$$$$$$$";

	if ($client_id == 11 || $client_id == 12 ||$client_id == 14 ||$client_id == 15 || $client_id == 16 || $client_id == 18 ||$client_id == 19 || $client_id == 20  || $client_id == 7  || $client_id == 10 || $client_id == 3  || $client_id == 2 || $client_id == 26   )
	 
	 { 
	   $sql1= "SELECT sum(amount) as amount FROM tab_inc".$user_id." WHERE   emp_id = '".$row1["emp_id"]."' and head_id in (select head_id  from emp_income  where emp_id = '".$row1["emp_id"]."' and  head_id != 7 and head_id != 27 and head_id != 43  and calc_type in (1,2,5,14)  and comp_id = '".$comp_id."'               )";

	 }
 else
 {
    $sql1= "SELECT sum(amount) as amount FROM tab_inc".$user_id." WHERE   emp_id = '".$row1["emp_id"]."' and head_id in (select mast_income_heads_id from mast_income_heads  where  (`income_heads_name` LIKE '%BASIC%' or `income_heads_name` LIKE '%D.A.%'  or `income_heads_name` LIKE '%wage%'  ) and comp_id = '".$comp_id."'  )";
 }
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
		 $std_amt = round($row3["amount"],0);
	}

	 	$sql2= "SELECT sum(amount) as amount FROM tab_inc".$user_id." WHERE   emp_id = '".$row1["emp_id"]."' and head_id in (select mast_income_heads_id from mast_income_heads  where  ( `income_heads_name` LIKE '%wage%' ) and comp_id = '".$comp_id."'  )";
	
	
	$amount = ROUND(($std_amt)*(12/100),0);
	$employer_contri_2 = ROUND(($std_amt)*0.0833,0);
    if($employer_contri_2 > 1250)
	{
		$employer_contri_2='1250';
	}
	
	
	
	$datediff =0;
	$datediff = $endmth - $row1['bdate'];
	 
	 
	 
		$todt1 = date('Y-m-d', strtotime($row1['bdate']. '-1 days'));
		$date1 = new DateTime($endmth);
		$date2 = $date1->diff(new DateTime($todt1));
		$date2->d.' days'."\n";
		echo $year = $date2->y;
		
    if ($year >=58 ){
	{
			$employer_contri_2 = 0;
			}
	
	}
	$employer_contri_1 = $amount - $employer_contri_2;
	
 $sql2 = "update tab_ded".$user_id." set std_amt = '".$std_amt."',amount = '".$amount."',employer_contri_1 ='".$employer_contri_1."',employer_contri_2 ='".$employer_contri_2."' where emp_id = '".$row1["emp_id"]."'and head_id = '".$row1["head_id"]."'"; 
	$row4= mysql_query($sql2);
	
	
	
}
*/
// end of pf calculation






//echo $m=date('m',$cmonth);
 $d = explode("-", $cmonth);
$month =  $d['1'];


//$parts = explode('-',$cmonth);
//echo "2  ".$month = $parts[1];



$row = $userObj->esi_calc($month,$client_id,$user_id,$comp_id);

//Calculation of profession tax 
	

/*$sql = "update tab_ded".$user_id ."  tdd inner join (select temp.emp_id,temp.gross_salary,e.gender from tab_emp".$user_id ." temp INNER join employee e on e.emp_id = temp.emp_id  where temp.client_id = '".$client_id ."' )  te on tdd.emp_id = te.emp_id  set amount = 175  where te.gross_salary >=7501 and te.gross_salary < 10000 and te.gender = 'M' and head_id in (select mast_deduct_heads_id from mast_deduct_heads  where  `deduct_heads_name` LIKE '%PROF. TAX%'  and comp_id = '".$comp_id."')";
$row= mysql_query($sql);*/
$userObj->updateSalCalTabDedProfTax($user_id,$client_id,$comp_id);  
/*echo $sql = "update tab_ded".$user_id ."  tdd inner join (select temp.emp_id,temp.gross_salary,e.gender from tab_emp".$user_id ." temp INNER join employee e on e.emp_id = temp.emp_id where temp.client_id = '".$client_id ."' ) te on tdd.emp_id = te.emp_id  set amount = 200  where te.gross_salary >=10000 and month('".$cmonth."')!=2  and head_id in (select mast_deduct_heads_id from mast_deduct_heads  where  `deduct_heads_name` LIKE '%PROF. TAX%' and comp_id = '".$comp_id."')";
$row= mysql_query($sql);*/
$userObj->updateSalCalTabDedProfTax1($user_id,$client_id,$cmonth,$comp_id);
echo "<br>";


/*echo  $sql = "update tab_ded".$user_id ."  tdd inner join (select temp.emp_id,temp.gross_salary,e.gender from tab_emp".$user_id ." temp INNER join employee e on e.emp_id = temp.emp_id where temp.client_id = '".$client_id ."' )  te on tdd.emp_id = te.emp_id  set amount = 300  where te.gross_salary >=10000 and month('".$cmonth."')=2 and head_id in (select mast_deduct_heads_id from mast_deduct_heads  where  `deduct_heads_name` LIKE '%PROF. TAX%'  and comp_id = '".$comp_id."') ";
$row= mysql_query($sql);*/
$userObj->updateSalCalTabDedProfTax2($user_id,$client_id,$cmonth,$comp_id);


//Calculation of LABOURFUND welfare

/*$sql = "update tab_ded".$user_id ."  tdd inner join (select emp_id,gross_salary from tab_emp".$user_id ." where client_id ='".$client_id ."' ) te on tdd.emp_id = te.emp_id  set amount = 6,employer_contri_1 = 18  where te.gross_salary <=3000 and (month('".$cmonth."')=12 or month('".$cmonth."')=6 )and head_id in (select mast_deduct_heads_id from mast_deduct_heads  where  `deduct_heads_name` LIKE '%L.W.F.%' and comp_id = '".$comp_id."') and te.gross_salary> 0 ";
$row= mysql_query($sql);*/

$userObj->updateSalCalTabUserLabourFund($user_id,$client_id,$cmonth,$comp_id);

/*$sql = "update tab_ded".$user_id ."  tdd inner join (select emp_id,gross_salary from tab_emp".$user_id ." where client_id= '".$client_id ."' ) te on tdd.emp_id = te.emp_id  set amount = 12,employer_contri_1 = 36  where te.gross_salary >3000 and (month('".$cmonth."')=12 or month('".$cmonth."')=6 )and head_id in (select mast_deduct_heads_id from mast_deduct_heads  where  `deduct_heads_name` LIKE '%L.W.F.%' and comp_id = '".$comp_id."') and te.gross_salary> 0 ";
$row= mysql_query($sql);*/
$userObj->updateSalCalTabUserLabourFund36($user_id,$client_id,$cmonth,$comp_id);

//Calculation of tds10%

/*$sql = "update tab_ded".$user_id ."  tdd inner join (select emp_id,gross_salary from tab_emp".$user_id ." where client_id= '".$client_id ."' ) te on tdd.emp_id = te.emp_id  set amount = round(te.gross_salary*0.1,0),std_amt =te.gross_salary  where te.gross_salary >0 and  head_id in (select mast_deduct_heads_id from mast_deduct_heads  where  `deduct_heads_name` LIKE '%TDS (10%)%' and comp_id = '".$comp_id."') ";
$row= mysql_query($sql);*/
$userObj->updateSalCalTabUserTDS10P($user_id,$client_id,$comp_id);

//type -4 Consolidated  
/* $sql = "update tab_ded".$user_id."  tdd  inner join tab_emp".$user_id ." te on te.emp_id = tdd.emp_id  set tdd.amount = tdd.std_amt where tdd.calc_type= 3 and  te.client_id = '".$client_id ."'";

$row= mysql_query($sql);*/
$userObj->updateSalCalTabUserConsolidate($user_id,$client_id);


//type -5 Daily wages
/*$sql = "update tab_ded".$user_id."  tdd inner join tab_emp".$user_id ." te on te.emp_id = tdd.emp_id   set tdd.amount = round(tdd.std_amt*te.payabledays,2)  where tdd.calc_type= 5 and te.client_id = '".$client_id ."'";
$row= mysql_query($sql);*/
$userObj->updateSalCalTabUserDailyWages($user_id,$client_id);
//Adding records of extra deduction1 extra deduction2 to respective tables 


/*$sql11 = "select mast_deduct_heads_id as head_id from mast_deduct_heads  where  `deduct_heads_name` LIKE '%Deduct-1%' and comp_id = '".$comp_id."'";
$row21= mysql_query($sql11);
$row31 = mysql_fetch_assoc($row21);*/

$row31 = $userObj->getSalCalDeductHead($comp_id);

/*$sql1 = "select emp_id,extra_ded1 from tran_days where client_id = '".$client_id ."' and extra_ded1 >0 ";
$row1= mysql_query($sql1);*/
$row1 = $userObj->getSalCalExtraDeduct1($client_id);
while($row2 = $row1->fetch_assoc())
{
	//print_r($row2);
	//echo $row2['emp_id'];
	 $emp = $row2['emp_id'];
/*$sql21 = "insert into tab_ded".$user_id ." (emp_id,head_id,std_amt,amount,sal_month,calc_type) values ('".$emp."' ,'".$row31['head_id']."','0','".$row2['extra_ded1']."','".$cmonth."','0')";
	$row22= mysql_query($sql21);*/	
	$userObj->insertSalCalExtraDeduct1($user_id,$emp,$row31['head_id'],$row2['extra_ded1'],$cmonth);
}

//extra_deduct2
/*$sql11 = "select mast_deduct_heads_id as head_id from mast_deduct_heads  where  `deduct_heads_name` LIKE '%Deduct-2%' and comp_id = '".$comp_id."'";
$row21= mysql_query($sql11);
$row31 = mysql_fetch_assoc($row21);*/
$row31 = $userObj->getSalCalDeductHeadDed2($comp_id);

/*$sql1 = "select emp_id,extra_ded2 from tran_days where client_id = '".$client_id ."' and extra_ded2 >0 ";
$row1= mysql_query($sql1);*/
$row1 = $userObj->getSalCalDeductHeadDed2Grt0($client_id);
while($row2 = $row1->fetch_assoc())
{
	
	$userObj->insertSalCalExtraDeduct2($user_id,$row2['emp_id'],$row31['head_id'],$row2['extra_ded2'],$cmonth);
}

//Income Tax Deduction
/*$sql11 = "select mast_deduct_heads_id as head_id from mast_deduct_heads  where  `deduct_heads_name` LIKE '%INCOMETAX%' and comp_id = '".$comp_id."'";
$row21= mysql_query($sql11);
$row31 = mysql_fetch_assoc($row21);*/
$row31 = $userObj->insertSalCalTaxDed($comp_id);

/*$sql1 = "select emp_id,incometax from tran_days where client_id = '".$client_id ."' and incometax >0 ";
$row1= mysql_query($sql1);*/
$row1 = $userObj->getSalCalTaxDedTranDay($client_id);
while($row2 = $row1->fetch_assoc())
{
	$userObj->insertSalCalTaxDedUser($user_id,$row2['emp_id'],$row31['head_id'],$row2['incometax'],$cmonth);
}

//Canteen Deduction
/*$sql11 = "select mast_deduct_heads_id as head_id from mast_deduct_heads  where  `deduct_heads_name` LIKE '%CANTEEN%' and comp_id = '".$comp_id."'";
$row21= mysql_query($sql11);
$row31 = mysql_fetch_assoc($row21);*/
$row31 = $userObj->getSalCalDedCanteen($comp_id);

/*$sql1 = "select emp_id,canteen from tran_days where client_id = '".$client_id ."' and canteen >0 ";
$row1= mysql_query($sql1);*/
$row1 = $userObj->getSalCalEmpCanteenTran($client_id);
while($row2 = $row1->fetch_assoc())
{
 	/*$sql21 = "insert into tab_ded".$user_id ." (emp_id,head_id,std_amt,amount,sal_month,calc_type) values ('". $row2['emp_id']."' ,'".$row31['head_id']."','0','".round($row2['canteen'],0)."','".$cmonth."','0')";

	$row22= mysql_query($sql21);*/	
	$userObj->insertSalCalCanteenDedUser($user_id,$row2['emp_id'],$row31['head_id'],$row2['canteen'],$cmonth);
}


//**************************************************************************************************************************
//deduction calculation ******************************************
//type -1 26/27	


/*$sql = "update  tab_ded".$user_id." tdd inner join tab_emp".$user_id ." te on te.emp_id = tdd.emp_id  inner join tran_days td on tdd.emp_id = td.emp_id   set tdd.amount = round(tdd.std_amt/26*te.payabledays,2)  where tdd.calc_type= 1 and td.weeklyoff <4 and client_id = '".$client_id ."' and te.payabledays >0  ";
$row= mysql_query($sql);*/
$userObj->updateSalCalDedType1_26_27($user_id,$client_id);

/* $sql = "update  tab_ded".$user_id." tdd inner join tab_emp".$user_id ." te on te.emp_id = tdd.emp_id  inner join tran_days td on tdd.emp_id = td.emp_id  set tdd.amount = round(tdd.std_amt/(day('".$endmth."')-td.weeklyoff)*te.payabledays,2)  where tdd.calc_type= 1 and td.weeklyoff >=4 and te.client_id = '".$client_id ."' and te.payabledays >0 " ;
$row= mysql_query($sql);*/
$userObj->updateSalCalDedType1_26_27_1($user_id,$endmth,$client_id);

//type -2 30/31	

/*$sql = "update tab_ded".$user_id."  tdd inner join tab_emp".$user_id ." te on te.emp_id = tdd.emp_id   set tdd.amount = round(tdd.std_amt/day('".$endmth."')*te.payabledays,0) where tdd.calc_type= 2 and te.client_id = '".$client_id ."'";
$row= mysql_query($sql);*/
$userObj->updateSalCalDedType2_30_31($user_id,$endmth,$client_id);

/*$sql = "update  tab_ded".$user_id." tdd inner join tab_emp".$user_id ." te on te.emp_id = tdd.emp_id  inner join tran_days td on tdd.emp_id = td.emp_id   set tdd.amount = 0  where client_id = '".$client_id ."' and te.payabledays =0  and te.gross_salary = 0 ";
$row= mysql_query($sql);*/

$userObj->updateSalCalDedType2_30_31_1($user_id,$client_id);









//Calculation of advances

/*$sqltab = "DROP TABLE IF EXISTS tab_adv".$user_id ;
$rowtab= mysql_query($sqltab);

$sqltab = "create table   tab_adv".$user_id ." as (select * from  tran_advance where 1=2)";
$rowtab= mysql_query($sqltab);*/

$userObj->createSalCalAdvanceTable($user_id);
/*echo  $sqltab = "INSERT INTO tab_adv".$user_id ." (`emp_id`, `comp_id`,`client_id`, `sal_month`, `head_id`, `calc_type`, `std_amt`, `amount`, `paid_amt`, `emp_advance_id` ) select `emp_id`, '".$comp_id."', '".$client_id."',  '".$cmonth."',`advance_type_id`,'0',adv_amount,`adv_installment`,'0',`emp_advnacen_id` from emp_advnacen where adv_installment > 0 and adv_amount-received_amt >0 and closed_on < '2001-01-01' and emp_id in  (select emp_id from tran_days where client_id = '".$client_id."')";

$rowtab= mysql_query($sqltab);*/
$userObj->insertSalCalAdvanceTable($user_id,$comp_id,$client_id,$cmonth);
echo "<br>";
/*echo  $sql = "update tab_adv".$user_id ." tadv inner join (select emp_id,sum(amount) as amt,emp_advance_id  from hist_advance group by emp_id,emp_advance_id ) hadv on tadv.emp_id = hadv.emp_id and  tadv.emp_advance_id = hadv.emp_advance_id  set tadv.paid_amt = hadv.amt ";
$row= mysql_query($sql);*/
$userObj->updateSalCalAdvanceTable($user_id);

echo "<br>";
/*echo  $sql = "update tab_adv".$user_id ." tadv set tadv.amount = std_amt-paid_amt where amount >=  std_amt-paid_amt";
$row= mysql_query($sql);*/

$userObj->updateSalCalAdvanceTableStdAmt($user_id);

/*echo $sql = "update tab_adv".$user_id ." tadv inner join tran_employee te on te.emp_id = tadv.emp_id  set tadv.amount = 0 where te.netsalary < tadv.amount";
$row= mysql_query($sql);*/
$userObj->updateSalCalAdvanceTableTAdvAmt($user_id);


// total_deductions  = 0 for netsalary = 0 or payabledays = 0;
/*echo $sql = "update  tab_ded".$user_id." tdd inner join tab_emp".$user_id ." te on te.emp_id = tdd.emp_id  set tdd.amount = 0  where client_id = '".$client_id ."' and te.payabledays =0  and te.gross_salary=0 ";
$row= mysql_query($sql);*/
$userObj->updateSalCalTotDedNetSalPayDay($user_id,$client_id);
/*echo $sql = "update  tab_adv".$user_id." tadv inner join tab_emp".$user_id ." te on te.emp_id = tadv.emp_id  set tadv.amount = 0  where client_id = '".$client_id ."' and te.payabledays =0  and te.gross_salary=0";
$row= mysql_query($sql);*/
$userObj->updateSalCalTotAdvNetSalPayDay($user_id,$client_id);


//totdeduct updation in tab_emp from tab_ded
/*$sql = "update tab_emp".$user_id ." te inner join (select emp_id,sum(amount) as amt from tab_ded".$user_id ." group by emp_id ) tdd on te.emp_id = tdd.emp_id  set te.tot_deduct = tdd.amt where te.client_id ='".$client_id ."'";
$row= mysql_query($sql);*/

$userObj->updateSalCalTotDedTabEmp($user_id,$client_id);

/*$sql = "update tab_emp".$user_id ." te inner join (select emp_id,sum(amount) as amt from tab_adv".$user_id ." group by emp_id ) tadv on te.emp_id = tadv.emp_id  set te.tot_deduct = te.tot_deduct+tadv.amt where te.client_id ='".$client_id ."'";
$row= mysql_query($sql);*/

$userObj->updateSalCalTabAdv($user_id,$client_id);



//Calculation of netsalary

/*
$sql = "update tab_emp".$user_id ." te  inner join tran_days td on te.emp_id = td.emp_id set te.netsalary = round(te.gross_salary - te.tot_deduct,0) where  te.client_id ='".$client_id ."'";
$row= mysql_query($sql);*/

$userObj->getSalCalTabAdvTranDay($user_id,$client_id);


//Rounded Off Deduction

$row31 = $userObj->getSalCalTabMastDedHeadRoff($comp_id);

$row1= $userObj->getSalCalNetSal($user_id,$client_id);
while($row2 = $row1->fetch_assoc())
{
	$row22=$userObj->insertSalCalTabDedUserRoundOff($user_id,$row2['emp_id'],$row31['head_id'],$row2['roundoff'],$cmonth);

	$row= $userObj->updateSalCalTotDed($user_id,$row2['roundoff'],$row2['emp_id']);
	
}

//*************************************
//Updating data into tran files
$userObj->deleteAllTranTable($client_id);
$userObj->insertTranTable($user_id);
/*
$sql = "DELETE FROM tran_employee WHERE emp_id IN ( SELECT emp_id FROM tran_days WHERE client_id= '".$client_id. "')";
$row= mysql_query($sql);

$sql = "DELETE FROM tran_deduct WHERE emp_id IN ( SELECT emp_id FROM tran_days WHERE client_id= '".$client_id. "')";
$row= mysql_query($sql);

$sql = "DELETE FROM tran_income WHERE emp_id IN ( SELECT emp_id FROM tran_days WHERE client_id= '".$client_id. "')";
$row= mysql_query($sql);

$sql = "DELETE FROM tran_advance WHERE emp_id IN ( SELECT emp_id FROM tran_days WHERE client_id= '".$client_id. "')";
$row= mysql_query($sql);



$sql = "DELETE FROM tran_employee WHERE emp_id  not IN ( SELECT emp_id FROM tran_days) ";
$row= mysql_query($sql);

$sql = "DELETE FROM tran_deduct WHERE emp_id  not IN ( SELECT emp_id FROM tran_days) ";
$row= mysql_query($sql);

$sql = "DELETE FROM tran_income WHERE emp_id  not IN ( SELECT emp_id FROM tran_days) ";
$row= mysql_query($sql);

$sql = "DELETE FROM tran_advance WHERE emp_id  not IN ( SELECT emp_id FROM tran_days) ";
"')";
$row= mysql_query($sql);


$sql = "insert into tran_employee select * from tab_emp".$user_id ;
$row= mysql_query($sql);

$sql = "insert into tran_income select * from tab_inc".$user_id ;
$row= mysql_query($sql);

$sql = "insert into tran_deduct select * from tab_ded".$user_id;
$row= mysql_query($sql);

$sql = "insert into tran_advance select * from tab_adv".$user_id;
$row= mysql_query($sql);

*/

echo "Finished.";
exit;




?>