Function calc_arrears (emp_id,head_id,new_calc_type,from_date to_date  )

foreach ($emp_id as $emp_id1 )
{
  foreach($head_id as $head_id )
  {
   $sql = "Select he.payabledays,he.othours,hi.head_id,hi.calc_type  from hist_income hi inner join hist_employee he on he.emp_id = hi.emp_id and he.sal_month = hi.sal_month and hi.head_id = $head_id1 and hi.sal_month  >=  $from_date and $hi.sal_month <= to_date"
   $res = mysql_query ($sql);
   while ($res1 = mysql_fetch_array 
   
  
  }
}



if (new_calc_type == 1)
		//type -1 26/27	
		$new_amount =  "update  tab_inc".$user_id." ti inner join tab_emp".$user_id ." te on te.emp_id = ti.emp_id  inner join tran_days td on td.emp_id = ti.emp_id   set ti.amount = round(ti.std_amt/26*te.payabledays,2)  where ti.calc_type= 1 and td.weeklyoff <4 and client_id = '".$client_id ."' and te.payabledays >0  ";
$row= mysql_query($sql);

$sql = "update  tab_inc".$user_id." ti inner join tab_emp".$user_id ." te on te.emp_id = ti.emp_id  inner join tran_days td on td.emp_id = ti.emp_id  set ti.amount = round(ti.std_amt/(day('".$endmth."')-td.weeklyoff)*te.payabledays,2)  where ti.calc_type= 1 and td.weeklyoff >=4 and te.client_id = '".$client_id ."' and te.payabledays >0 " ;
$row= mysql_query($sql);

$sql = "update  tab_inc".$user_id." ti inner join tab_emp".$user_id ." te on te.emp_id = ti.emp_id  inner join tran_days td on td.emp_id = ti.emp_id   set ti.amount = 0  where client_id = '".$client_id ."' and te.payabledays =0  ";
$row= mysql_query($sql);











$sql = "update  tab_inc".$user_id." ti inner join tab_emp".$user_id ." te on te.emp_id = ti.emp_id  inner join tran_days td on td.emp_id = ti.emp_id   set ti.amount = round(ti.std_amt/26*te.payabledays,2)  where ti.calc_type= 1 and td.weeklyoff <4 and client_id = '".$client_id ."' and te.payabledays >0  ";
$row= mysql_query($sql);

$sql = "update  tab_inc".$user_id." ti inner join tab_emp".$user_id ." te on te.emp_id = ti.emp_id  inner join tran_days td on td.emp_id = ti.emp_id  set ti.amount = round(ti.std_amt/(day('".$endmth."')-td.weeklyoff)*te.payabledays,2)  where ti.calc_type= 1 and td.weeklyoff >=4 and te.client_id = '".$client_id ."' and te.payabledays >0 " ;
$row= mysql_query($sql);

$sql = "update  tab_inc".$user_id." ti inner join tab_emp".$user_id ." te on te.emp_id = ti.emp_id  inner join tran_days td on td.emp_id = ti.emp_id   set ti.amount = 0  where client_id = '".$client_id ."' and te.payabledays =0  ";
$row= mysql_query($sql);

//type -2 30/31	

$sql = "update tab_inc".$user_id."  ti inner join tab_emp".$user_id ." te on te.emp_id = ti.emp_id   set ti.amount = round(ti.std_amt/day('".$endmth."')*te.payabledays,2) where ti.calc_type= 2 and te.client_id = '".$client_id ."'";
$row= mysql_query($sql);



//type -14 26 days fixed 	
$sql = "update  tab_inc".$user_id." ti inner join tab_emp".$user_id ." te on te.emp_id = ti.emp_id  inner join tran_days td on td.emp_id = ti.emp_id   set ti.amount = round(ti.std_amt/26*te.payabledays,2)  where ti.calc_type=14  and client_id = '".$client_id ."'";
$row= mysql_query($sql);


//type -3Consolidated  
$sql = "update tab_inc".$user_id."  ti  inner join tab_emp".$user_id ." te on te.emp_id = ti.emp_id  set ti.amount = ti.std_amt where ti.calc_type= 3 and  te.client_id = '".$client_id ."'";
$row= mysql_query($sql);

//type -5 Daily wages
echo  $sql = "update tab_inc".$user_id."  ti  inner join tab_emp".$user_id ." te  on te.emp_id = ti.emp_id   set ti.amount = round(ti.std_amt*te.payabledays,2)  where ti.calc_type= 5 and te.client_id = '".$client_id ."'";
$row= mysql_query($sql);

//type -16 per presnt Day
echo  $sql = "update tab_inc".$user_id."  ti  inner join tran_days te on te.emp_id = ti.emp_id   set ti.amount = round(ti.std_amt*te.present,2)  where ti.calc_type= 16 and te.client_id = '".$client_id ."'";
$row= mysql_query($sql);

//type -14 26 days per month
echo $sql = "update tab_inc".$user_id."  ti inner join tab_emp".$user_id ." te on te.emp_id = ti.emp_id   set ti.amount = round(ti.std_amt/26*te.payabledays,2) where ti.calc_type= 14 and te.client_id = '".$client_id ."'";
$row= mysql_query($sql);
 

//grosssalary updation in tab_emp for overtime calculation- 7 or 12 (GROSS-WASHING-PAP ALL)/8*2   /  (GROSS-WASHING-PAP ALL)/8 
$sql = "update tab_emp".$user_id ." te inner join (select emp_id,sum(amount) as amt from tab_inc".$user_id ." ti  where ti.head_id not in (select mast_income_heads_id from mast_income_heads  where  (`income_heads_name` LIKE '%PAP. ALL.%' or `income_heads_name` LIKE '%WASHING ALLOW.%' ) and comp_id = '".$comp_id."'  )  group by emp_id ) ti on te.emp_id = ti.emp_id  set te.gross_salary = ti.amt where te.client_id ='".$client_id ."'";


$row= mysql_query($sql);


//Overtime Calculation - calc_type 7or 12

//calc_type -15 per hour 
 echo $sql = "update tab_inc".$user_id."  ti  inner join tran_days td on td.emp_id = ti.emp_id   set ti.amount = round(ti.std_amt*td.othours,2)  where ti.calc_type= 15 and td.client_id = '".$client_id ."'";
$row= mysql_query($sql);
 
 echo "****";
$sql2 = "update tab_inc".$user_id ." ti inner join tab_emp".$user_id." te on te.emp_id = ti.emp_id  inner join tran_days td on td.emp_id = ti.emp_id      set std_amt = round((te.gross_salary*2)/(te.payabledays*8),2 ) ,amount = (round((te.gross_salary*2)/(te.payabledays*8),2 )) *td.othours  where ti.head_id in (select mast_income_heads_id from mast_income_heads  where  (`income_heads_name` LIKE '%OVERTIME%' ) and comp_id = '".$comp_id."'  ) and calc_type = 7"; 
$row4= mysql_query($sql2);

$sql2 = "update tab_inc".$user_id ." ti inner join tab_emp".$user_id." te on te.emp_id = ti.emp_id  inner join tran_days td on td.emp_id = ti.emp_id      set std_amt = round((te.gross_salary)/(te.payabledays*8),2 ) ,amount = (round((te.gross_salary)/(te.payabledays*8),2 )) *td.othours  where ti.head_id in (select mast_income_heads_id from mast_income_heads  where  (`income_heads_name` LIKE '%OVERTIME%' ) and comp_id = '".$comp_id."'  ) and calc_type = 12"; 
$row4= mysql_query($sql2);


//grosssalary updation in tab_emp for overtime calculation-11 (GROSS-CONVEYANCE)/8*2


$sql = "update tab_emp".$user_id ." te inner join (select emp_id,sum(amount) as amt from tab_inc".$user_id ." ti  where ti.head_id not in (select mast_income_heads_id from mast_income_heads  where  (`income_heads_name` LIKE '%CONVEYANCE%' ) and comp_id = '".$comp_id."'  )  group by emp_id ) ti on te.emp_id = ti.emp_id  set te.gross_salary = ti.amt where te.client_id ='".$client_id ."'";
$row= mysql_query($sql);



$sql2 = "update tab_inc".$user_id ." ti inner join tab_emp".$user_id." te on te.emp_id = ti.emp_id  inner join tran_days td on td.emp_id = ti.emp_id      set std_amt = round((te.gross_salary*2)/(te.payabledays*8),2 ) ,amount = (round((te.gross_salary*2)/(te.payabledays*8),2 )) *td.othours  where ti.head_id in (select mast_income_heads_id from mast_income_heads  where  (`income_heads_name` LIKE '%OVERTIME%' ) and comp_id = '".$comp_id."'  ) and calc_type = 11"; 
$row4= mysql_query($sql2);



//grosssalary updation in tab_emp for overtime calculation-13 (BASIC+DA)/8*2

$sql = "update tab_emp".$user_id ." te inner join (SELECT sum(amount) as amt,emp_id FROM tab_inc".$user_id." WHERE   head_id in (select mast_income_heads_id from mast_income_heads  where  (`income_heads_name` LIKE '%BASIC%' or `income_heads_name` LIKE '%D.A.%' OR `income_heads_name` LIKE '%wage%' ) and comp_id = '".$comp_id."') GROUP BY EMP_ID  ) ti on te.emp_id = ti.emp_id  set te.gross_salary = ti.amt where te.client_id ='".$client_id ."'";
$row= mysql_query($sql);

$sql2 = "update tab_inc".$user_id ." ti inner join tab_emp".$user_id." te on te.emp_id = ti.emp_id  inner join tran_days td on td.emp_id = ti.emp_id      set std_amt = round((te.gross_salary*2)/(te.payabledays*8),2 ) ,amount = (round((te.gross_salary*2)/(te.payabledays*8),2 )) *td.othours  where ti.head_id in (select mast_income_heads_id from mast_income_heads  where  (`income_heads_name` LIKE '%OVERTIME%' ) and comp_id = '".$comp_id."'  ) and calc_type = 13"; 
$row4= mysql_query($sql2);
	


//Overtime Calculation over * * * * * * * * * * * * * * * * * * * 






//Night Shifts Calculation
 $sql = "update  tab_inc".$user_id." ti inner join tab_emp".$user_id ." te on te.emp_id = ti.emp_id  inner join tran_days td on td.emp_id = ti.emp_id   set ti.amount = round(20*td.nightshifts,2)  where ti.calc_type= 8 and td.nightshifts <= 15  and te.client_id = '".$client_id ."' and te.payabledays >0  ";

$row= mysql_query($sql);

$sql = "update  tab_inc".$user_id." ti inner join tab_emp".$user_id ." te on te.emp_id = ti.emp_id  inner join tran_days td on td.emp_id = ti.emp_id   set ti.amount = round(27*td.nightshifts,2)  where ti.calc_type= 8 and td.nightshifts > 15  and te.client_id = '".$client_id ."' and te.payabledays >0  ";
$row= mysql_query($sql);

$sql = "update  tab_inc".$user_id." ti inner join tab_emp".$user_id ." te on te.emp_id = ti.emp_id  inner join tran_days td on td.emp_id = ti.emp_id   set ti.amount = round(25*td.nightshifts,2)  where ti.calc_type= 9 and td.nightshifts <= 15  and  te.client_id = '".$client_id ."' and te.payabledays >0  ";
$row= mysql_query($sql);

$sql = "update  tab_inc".$user_id." ti inner join tab_emp".$user_id ." te on te.emp_id = ti.emp_id  inner join tran_days td on td.emp_id = ti.emp_id   set ti.amount = round(34.5*td.nightshifts,2)  where ti.calc_type= 9 and td.nightshifts > 15  and  te.client_id = '".$client_id ."' and te.payabledays >0  ";
$row= mysql_query($sql);


$sql = "update  tab_inc".$user_id." ti inner join tab_emp".$user_id ." te on te.emp_id = ti.emp_id  inner join tran_days td on td.emp_id = ti.emp_id   set ti.amount = round(ti.std_amt*td.nightshifts,2)  where ti.calc_type= 10 and td.nightshifts > 0  and  te.client_id = '".$client_id ."' and te.payabledays >0  ";
$row= mysql_query($sql);

//Night Shifts Calculation * * * * * * * * * * * * * * * * * * * * * 




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


//Adding records of wagediff  to respective tables 
$sql11 = "select mast_income_heads_id as head_id from mast_income_heads  where  `income_heads_name` LIKE '%Wage Diff' and  comp_id = '".$comp_id."'";
$row21= mysql_query($sql11);
$row31 = mysql_fetch_assoc($row21);

$sql1 = "select emp_id,wagediff from tran_days where client_id = '".$client_id ."' and wagediff >0 ";
$row1= mysql_query($sql1);
while($row2 = mysql_fetch_assoc($row1))
{
 echo  $sql21 = "insert into tab_inc".$user_id ." (emp_id,head_id,std_amt,amount,sal_month,calc_type) values ('".$row2['emp_id']."' ,'".$row31['head_id']."','0','".$row2['wagediff']."','".$cmonth."','0')";
	$row22= mysql_query($sql21);	
	
}

//Adding records of allow_arrears to respective tables 
$sql11 = "select mast_income_heads_id as head_id from mast_income_heads  where  `income_heads_name` LIKE '%Allow. Aarrears' and  comp_id = '".$comp_id."'";
$row21= mysql_query($sql11);
$row31 = mysql_fetch_assoc($row21);

$sql1 = "select emp_id,Allow_arrears from tran_days where client_id = '".$client_id ."' and Allow_arrears >0 ";
$row1= mysql_query($sql1);
while($row2 = mysql_fetch_assoc($row1))
{
  $sql21 = "insert into tab_inc".$user_id ." (emp_id,head_id,std_amt,amount,sal_month,calc_type) values ('".$row2['emp_id']."' ,'".$row31['head_id']."','0','".$row2['Allow_arrears']."','".$cmonth."','0')";
	$row22= mysql_query($sql21);	
	
}

//Adding records of ot arrears  to respective tables 
$sql11 = "select mast_income_heads_id as head_id from mast_income_heads  where  `income_heads_name` LIKE '%OT. Aarrears' and  comp_id = '".$comp_id."'";
$row21= mysql_query($sql11);
$row31 = mysql_fetch_assoc($row21);

$sql1 = "select emp_id,Ot_arrears from tran_days where client_id = '".$client_id ."' and Ot_arrears >0 ";
$row1= mysql_query($sql1);
while($row2 = mysql_fetch_assoc($row1))
{
  $sql21 = "insert into tab_inc".$user_id ." (emp_id,head_id,std_amt,amount,sal_month,calc_type) values ('".$row2['emp_id']."' ,'".$row31['head_id']."','0','".$row2['Ot_arrears']."','".$cmonth."','0')";
	$row22= mysql_query($sql21);	
	
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
$sql = "update tab_emp".$user_id ." te inner join (select emp_id,sum(amount) as amt from tab_inc".$user_id ." group by emp_id ) ti on te.emp_id = ti.emp_id  set te.gross_salary = ti.amt where te.client_id ='".$client_id ."'";
$row= mysql_query($sql);

//**************************************************************************************************************************
