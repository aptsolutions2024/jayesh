<?php
session_start();
//error_reporting(0);
include("../lib/connection/db-config.php");
//print_r($_SESSION);

 $startday = $_SESSION['startbonusyear'];
 $endday = $_SESSION['endbonusyear'];
$user = $_SESSION['log_id'];
$compid = $_SESSION['comp_id'];

$client = $_POST['client'];
$type = $_POST['type'];
$comptype = $_POST['comptype'];


 $exgratia = $_POST['exgratia'];
 $bonusrate = $_POST['bonusrate'];
 $amount = $_POST['amount'];
 
 if ($comptype=="new"){
 echo $sql2 = "select distinct(e.emp_id),e.bank_id,e.bankacno,e.pay_mode from employee e inner join hist_employee he on e.emp_id=he.emp_id where e.client_id='".$client."' and he.sal_month>= '".$startday."' and he.sal_month <= '".$endday."' ";
 }
 else
 {$sql2 = "select distinct(e.emp_id),e.bank_id,e.bankacno,e.pay_mode from employee e inner join hist_employee he on e.emp_id=he.emp_id where he.client_id='".$client."' and he.sal_month>= '".$startday."' and he.sal_month <= '".$endday."' ";
 }
 echo $sql2;
$row2 = mysql_query($sql2);
while($res2 = mysql_fetch_array($row2)){
	$empnum = mysql_num_rows($row2);
	if($empnum !=0){
		echo "<br>";
		echo $sqlchk ="select count(*) cnt,id from bonus where emp_id='".$res2['emp_id']."' and from_date = '".$startday."' and todate ='".$endday."'";
		$rowchk = mysql_query($sqlchk);
		$reschk = mysql_fetch_assoc($rowchk);
		$cknum = $reschk['cnt'];
		
		if($cknum ==0){ 
		 	$sql = "insert into bonus(from_date,todate,emp_id,bank_id,bankacno,pay_mode,calc_type,bonus_rate,exgratia_rate,user_id,comp_id,updated,client_id) values ('".$startday."','".$endday."','".$res2['emp_id']."','".$res2['bank_id']."','".$res2['bankacno']."','".$res2['pay_mode']."','".$type."','".$bonusrate."','".$exgratia."','".$user."','".$compid."',now(),'$client')";
		}else{
		 	$sql = "update bonus set bank_id ='".$res2['bank_id']."',bankacno='".$res2['bankacno']."',pay_mode='".$res2['pay_mode']."',calc_type='".$type."',bonus_rate='".$bonusrate."',exgratia_rate='".$exgratia."',user_id='".$user."',comp_id='".$compid."',updated=now(),client_id =  where emp_id='".$res2['emp_id']."' and from_date = '".$startday."' and todate ='".$endday."'";			
		}
		  
		$res1 = mysql_query($sql);
		if($cknum ==0){ 
		$lastinsid = mysql_insert_id();
		$condition= ' id = '.		$lastinsid;
		}else{
			$lastinsid = $res2['emp_id'];
			$condition= ' emp_id = '.$lastinsid ." and from_date = '".$startday."' and todate ='".$endday."'";
		}
	 

 if ($comptype=="new"){
	 $sql3 ="select sum(ti.amount) amount,te.emp_id empid, mih.income_heads_name head_name,
		te.sal_month sal_month,te.payabledays payabldays ,td.* from hist_employee te
		inner join hist_income ti on te.emp_id = ti.emp_id and ti.sal_month=te.sal_month
		inner join hist_days td on te.emp_id = td.emp_id and td.sal_month=te.sal_month		
		inner join mast_income_heads mih on mih.mast_income_heads_id = ti.head_id
		where te.emp_id ='".$res2['emp_id']."' and (mih.income_heads_name like '%Basic%' or mih.income_heads_name like '%D.A.%' or mih.income_heads_name like '%WAGE DIFF%' ) and mih.comp_id ='".$_SESSION['comp_id']."' and  te.sal_month between '".$startday."' and '".$endday."' group by te.sal_month"; 
 }
else{
	 $sql3 ="select sum(ti.amount) amount,te.emp_id empid, mih.income_heads_name head_name,
		te.sal_month sal_month,te.payabledays payabldays ,td.* from hist_employee te
		inner join hist_income ti on te.emp_id = ti.emp_id and ti.sal_month=te.sal_month
		inner join hist_days td on te.emp_id = td.emp_id and td.sal_month=te.sal_month		
		inner join mast_income_heads mih on mih.mast_income_heads_id = ti.head_id
		where te.emp_id ='".$res2['emp_id']."' and (mih.income_heads_name like '%Basic%' or mih.income_heads_name like '%D.A.%' or mih.income_heads_name like '%WAGE DIFF%' ) and mih.comp_id ='".$_SESSION['comp_id']."' and  te.sal_month between '".$startday."' and '".$endday."' and hist_employee.client_id = '$client' group by te.sal_month"; 
	
} 
		//te.client_id ='".$client."' and
		$res3 = mysql_query($sql3);		
		
		//update
		$bonusamttot =0;
		$exgratiaamttoto =0;
		while($row3 = mysql_fetch_array($res3)){
			$month = date('m',strtotime($row3['sal_month']));
			$monthdays = 0;
			if($month == 1){
				$monthwages = "jan";
				$monthdays = 26;
			}else if($month == 2){
				$monthwages = "feb";
				$year= date("Y",strtotime($row3['sal_month']));
				if ((($year % 4) == 0) && ((($year % 100) != 0) || (($year % 400) == 0))) 
					{$monthdays = 25;}
				else
					{$monthdays = 24;}
			}
			else if($month == 3){
				$monthwages = "mar";
				$monthdays = 26;
			}
			else if($month == 4){
				$monthwages = "apr";
				$monthdays = 25;
			}
			else if($month == 5){
				$monthwages = "may";
				$monthdays = 26;
			}
			else if($month == 6){
				$monthwages = "jun";
				$monthdays = 25;
			}
			else if($month == 7){
				$monthwages = "jul";
				$monthdays = 26;
			}
			else if($month == 8){
				$monthwages = "aug";
				$monthdays = 26;
			}
			else if($month == 9){
				$monthwages = "sep";
				$monthdays = 25;
			}
			else if($month == 10){
				$monthwages = "oct";
				$monthdays = 26;
			}
			else if($month == 11){
				$monthwages = "nov";
				$monthdays = 25;
			}
			else if($month == 12){
				$monthwages = "dec";
				$monthdays = 26;
			}
			








			//$sqlpaybleday  = "select * from "
			$amt = $row3['amount'];
			if($type =='2' &&  $row3['amount'] < $amount){
				$amt = $amount;	
			}
			else if($type =='3'){
				//if ( $amt > $amount)
				//{$amt = $amount;}
				$amt = $amount;
                $amt = round($amt*$row3['payabldays']/$monthdays,2);
				if ($amt > $amount){$amt = $amount;}
			}
			else{
				$amt = $row3['amount'];
			}
			$bonusamt = ($amt)*$bonusrate/100;
			$exgratiaamt = $amt*$exgratia/100; //default 11.67
			
				
			 $update1 = "update bonus set ".$monthwages."_wages = '".$row3['amount']."',".$monthwages."_bonus_wages = '".$amt."',".$monthwages."_payable_days = '".$row3['payabldays']."',".$monthwages."_bonus_amt = '".$bonusamt."',".$monthwages."_exgratia_amt = '".$exgratiaamt."' where emp_id ='".$res2['emp_id']."' and  from_date = '".$startday ."' and todate = '".$endday."'";			
			mysql_query($update1);
			
			
		}	
			
			
			
			

			 $sql3 ="select sum(ti.amount) amount,te.emp_id empid, mih.income_heads_name head_name,
		te.sal_month sal_month,te.payabledays payabldays from tran_employee te
		inner join tran_income ti on te.emp_id = ti.emp_id and ti.sal_month=te.sal_month 
		inner join mast_income_heads mih on mih.mast_income_heads_id = ti.head_id
		where te.emp_id ='".$res2['emp_id']."' and (mih.income_heads_name like '%Basic%' or mih.income_heads_name like '%D.A.%' ) and mih.comp_id ='".$_SESSION['comp_id']."' and te.client_id ='".$client."' and te.sal_month between '".$startday."' and '".$endday."' group by te.sal_month"; 
	
		
		$res3 = mysql_query($sql3);		
		
		//update
		$bonusamttot =0;
		$exgratiaamttoto =0;
		while($row3 = mysql_fetch_array($res3)){
			$month = date('m',strtotime($row3['sal_month']));
			$amt = $row3['amount'];
			if($type =='2' &&  $row3['amount'] < $amount){
				$amt = $amount;	
			}
			else if($type =='3' &&  $row3['amount'] > $amount){
				$amt = $amount;	
			}
			else{
				$amt = $row3['amount'];
			}
				
				echo "<br> @@@";
		

			if($month == 1){
				$monthwages = "jan";
				if($type =='3'){
					$amt = round($amt/26*$row3['payabledays'],2);
				}
			}else if($month == 2){
				$monthwages = "feb";
				if($type =='3'){
					$amt = round($amt/24*$row3['payabledays'],2);
				}
			}
			else if($month == 3){
				$monthwages = "mar";
				if($type =='3'){
					$amt = round($amt/26*$row3['payabledays'],2);
				}
			}
			else if($month == 4){
				$monthwages = "apr";
				if($type =='3'){
					$amt = round($amt/25*$row3['payabledays'],2);
				}
			}
			else if($month == 5){
				$monthwages = "may";
				if($type =='3'){
					$amt = round($amt/26*$row3['payabledays'],2);
				}
			}
			else if($month == 6){
				if($type =='3'){
					$amt = round($amt/25*$row3['payabledays'],2);
				}
				$monthwages = "jun";
			}
			else if($month == 7){
				$monthwages = "jul";
				if($type =='3'){
					$amt = round($amt/26*$row3['payabledays'],2);
				}
			}
			else if($month == 8){
				$monthwages = "aug";
				if($type =='3'){
					$amt = round($amt/26*$row3['payabledays'],2);
				}
			}
			else if($month == 9){
				$monthwages = "sep";
				if($type =='3'){
					$amt = round($amt/25*$row3['payabledays'],2);
				}
			}
			else if($month == 10){
				$monthwages = "oct";
				if($type =='3'){
					$amt = round($amt/26*$row3['payabledays'],2);
				}
			}
			else if($month == 11){
				$monthwages = "nov";
				if($type =='3'){
					$amt = round($amt/25*$row3['payabledays'],2);
				}
			}
			else if($month == 12){
				$monthwages = "dec";
				if($type =='3'){
					$amt = round($amt/26*$row3['payabledays'],2);
				}
			}


			//$sqlpaybleday  = "select * from "
			//$row3['amount'] = actual wages
			// type 1 at actual 
			// type 2 min $amount or greater 
			// type 3 max $amount 			
			$bonusamt = ($amt)*$bonusrate/100;
	    
			$exgratiaamt = $amt*$exgratia/100; //default 11.67
			
			 $update1 = "update bonus set ".$monthwages."_wages = '".$row3['amount']."',".$monthwages."_bonus_wages = '".$amt."',".$monthwages."_payable_days = '".$row3['payabldays']."',".$monthwages."_bonus_amt = '".$bonusamt."',".$monthwages."_exgratia_amt = '".$exgratiaamt."' where emp_id ='".$res2['emp_id']."' and  from_date = '".$startday ."' and todate = '".$endday."'";			
			mysql_query($update1);
			
			
			

			
			
			
			
			
			/* $update2 = "update bonus set ".$monthwages."_bonus_wages = '".$amt."' where id ='".$lastinsid."'";
			mysql_query($update2);
			
			$update3 = "update bonus set ".$monthwages."_payable_days = '".$row3['payabldays']."' where id ='".$lastinsid."'";
			mysql_query($update3);
			
			$bonusamt = ($amt)*$bonusrate/100;
			
			$update4 = "update bonus set ".$monthwages."_bonus_amt = '".$bonusamt."' where id ='".$lastinsid."'";
			mysql_query($update4);
			
			$exgratiaamt = $amt*$exgratia/100; //default 11.67

			 $update5 = "update bonus set ".$monthwages."_exgratia_amt = '".$exgratiaamt."' where id ='".$lastinsid."'";
			mysql_query($update5);*/	
		}
		
		 
		
			$selbon ="select round(apr_bonus_amt + may_bonus_amt + jun_bonus_amt + jul_bonus_amt + aug_bonus_amt + sep_bonus_amt + oct_bonus_amt + nov_bonus_amt + dec_bonus_amt + jan_bonus_amt + feb_bonus_amt + mar_bonus_amt,0) as bonustotal,
			round(apr_exgratia_amt + may_exgratia_amt + jun_exgratia_amt + jul_exgratia_amt + aug_exgratia_amt + sep_exgratia_amt + oct_exgratia_amt + nov_exgratia_amt + dec_exgratia_amt + jan_exgratia_amt + feb_exgratia_amt + mar_exgratia_amt,0) as exgratiatotal
			from bonus where $condition";
		
			$rowbon = mysql_query($selbon);
			
			$resbon = mysql_fetch_assoc($rowbon);
			
			$update6 = "update bonus set tot_bonus_amt = '".round($resbon['bonustotal'],0)."',tot_exgratia_amt = '".round($resbon['exgratiatotal'],0)."' ,   client_id = '$client' where ".$condition;
			mysql_query($update6);			
			
			
			 $update6 = "update bonus set tot_bonus_amt = 7000 where tot_bonus_amt = 6997 and  from_date = '".$startday ."' and todate = '".$endday."' ";
			mysql_query($update6);		
			
			
			echo "&&&&&&&&&&&&&&&&";
			 echo $update6 = "update bonus set tot_payable_days = apr_payable_days + may_payable_days+jun_payable_days+jul_payable_days+aug_payable_days+sep_payable_days+oct_payable_days+nov_payable_days+dec_payable_days+jan_payable_days+feb_payable_days+mar_payable_days where   from_date = '".$startday ."' and todate = '".$endday."' and  client_id = '$client' ";
			mysql_query($update6);		

	  $update6 = "update bonus set tot_bonus_amt = tot_bonus_amt - ((tot_bonus_amt+tot_exgratia_amt)-16800) where tot_bonus_amt+tot_exgratia_amt >16800 and  from_date = '".$startday ."' and todate = '".$endday."' and  client_id = '$client' ";
			mysql_query($update6);		
			
			
	
	}
}

?>