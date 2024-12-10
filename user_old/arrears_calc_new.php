<?php 
$head_id = $_SESSION['head_id'];
$new_amount = $_SESSION['new_amount'];
$client_id = $_SESSION['client_id'];
$emp_id = $_SESSION['emp_id'];
$payment_date = $_SESSION['payment_date'];

//present ,new_amount ,ot_arrears
$condition =" sal_month  >=  $from_date and sal_month <= $to_date and emp_id in ($emp_id) and client_id = '".$client_id ."'  ";
$head_cnt = 0;
foreach($head_id as $head_id1 )
  {
	$sql = "delete from arrears2 where $condition and  head_id = $head_id1";
	mysql_query ($sql);

	$sql = "delete from arrears where from_date  >=  $from_date and to_date <= $to_date and emp_id in ($emp_id) and client_id = '".$client_id ."'  ";
	$row= mysql_query($sql);
	
   $sql = "insert into arrears2 ( `payabledays`, `othours`, `weeklyoff`, `head_id`, `org_calc_type`, `new_calc_type`, `sal_month`, `org_std_amount`, `org_amount`, `new_std_amt`, `new_amount`, `amount`, ) Select he.payabledays,he.othours,he.weeklyoff,hi.head_id1,hi.calc_type,hi.calc_type,hi.sal_month,hi.std_amt,hi.amount,$new_amount[$head_cnt],0  from hist_income hi inner join hist_employee he on he.emp_id = hi.emp_id and he.sal_month = hi.sal_month and hi.head_id = $head_id1 and hi.sal_month  >=  $from_date and hi.sal_month <= to_date and emp_id in ($emp_id) ";
	$row= mysql_query($sql);
	$head_cnt++;
   }
   
   
   //type -1 26/27	
		$sql = "update  arrears2    set new_amt = round(new_std_amt/26*payabledays,2)  where new_calc_type= 1 and weeklyoff <4 and payabledays >0 and $condition  ";
		$row= mysql_query($sql);

		$sql = "update  arrears2 set  new_amt = round(std_amt/(day(sal_month) -weeklyoff)*payabledays,2)  where new_calc_type= 1 and weeklyoff >=4 and te.payabledays >0  and $condition " ;
		$row= mysql_query($sql);

		$sql = "update  arrears2   set  new_amt = 0  where  new_calc_type= 1 and  payabledays =0  and $condition ";
		$row= mysql_query($sql);

	//type -2 30/31	

		$sql = "update arrears2 amount = round( new_std_amt/day(sal_month)*payabledays,2) where new_calc_type= 2 and $condition ";
		$row= mysql_query($sql);



	//type -14 26 days fixed 	
		$sql = "update arrears2 set new_amount = round(new_std_amt/26*payabledays,2)  where new_calc_type=14  and $condition ";
		$row= mysql_query($sql);


	//type -3Consolidated  
		$sql = "update arrears2 set new_amount = new_std_amt where new_calc_type= 3 and $condition ";
		$row= mysql_query($sql);

	//type -5 Daily wages
		$sql = "update arrears2 set new_amount = round(new_std_amt*payabledays,2)  where new_calc_type= 5 and $condition";
		$row= mysql_query($sql);

	//type -16 per presnt Day
		$sql = "update arrears    set new_amount = round(new_std_amt*present,2)  where new_calc_type= 	16 and $condition ";
		$row= mysql_query($sql);

	// Overtime Calculation
		$sql = "update arrears    set new_amount = round(new_std_amt*othours,2)  where head_id in (select mast_income_heads_id from mast_income_heads where income_heads_name line '%OVERTIME%' and comp_id = $_SESSION('comp_id')) and $condition ";
		$row= mysql_query($sql);


	//Calculation of diff
	   $sql = "update arrears set amount= org_amount-new_amount where $condition";
	   $row= mysql_query($sql);
	   
	
	//Calculation of diff
	   $sql = " INSERT INTO `arrears`(`client_id`, `emp_id`, `bank_id`, `date`, `from_date`, `to_date`, `bankacno`, `pay_mode`, `wagediff`, `Allow_arrears`, ot_arrears,`amount`)  select a.$client_id,a.emp_id,e.bank_id,$payment_date, $from_date,$to_date,e.bankacno,e.pay_mode,0,0,0,sum(amount) from arrears2 a inner join employee e on e.emp_id = a.emp_id where  a.from_date  >=  $from_date and a.to_date <= $to_date and a.emp_id in ($emp_id) and a.client_id = $client_id group by a.emp_id"; 
	   $row= mysql_query($sql);

	//Calculation of wagediff
		$sql = "update arrears set wagediff = (select sum(a.amount) from arrears2 a where  a.from_date  >=  $from_date and a.to_date <= $to_date and a.emp_id in ($emp_id) and a.client_id = $client_id and a.$head_id in (select mast_income_heads_id from mast_income_heads where income_heads_name like '%BASIC%' or  income_heads_name like '%D.A.%')  group by a.emp_id";
	   $row= mysql_query($sql);
	   
	//Calculation of Ot_arrears
		$sql = "update arrears set ot_arrears = (select sum(a.amount) from arrears2 a where  a.from_date  >=  $from_date and a.to_date <= $to_date and a.emp_id in ($emp_id) and a.client_id = $client_id and a.$head_id in (select mast_income_heads_id from mast_income_heads where income_heads_name like '%OVERTIME%' )  group by a.emp_id";
	   $row= mysql_query($sql);

   //Calculation of Allow_arrears
		$sql = "update arrears set allow_arrears = amount-wagediff-ot_arrears where from_date  >=  $from_date and to_date <= $to_date and emp_id in ($emp_id) and client_id = $client_id";
	   $row= mysql_query($sql);

	   