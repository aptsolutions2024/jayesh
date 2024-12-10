<?php       
ignore_user_abort(true);
set_time_limit(0);
$con = mysqli_connect('localhost','aptsolutions','godaddy@2020','ghare');

/* mysqli_select_db("ghare",$con)
or die("Could not connect Ghare");
//comp=11
if(!$con){
    die('Could not connect: '.mysqli_error());
}*/

$mysqli = new mysqli("localhost","aptsolutions","godaddy@2020","ghare");

// Check connection
if ($mysqli -> connect_errno) {
  echo "Failed to connect to mysqli: " . $mysqli -> connect_error;
  exit();
}
//$file = fopen("salmast1.csv","r");
//print_r(fgetcsv($file));
 //$filename ='salmastcsv.csv';
		$count=0;  
		//$file = fopen($filename, "r");
		$file = fopen("salmastcsv.csv","r");
		/*echo "Please wait.File is being uploaded.";*/
	/*	$sql = "TRUNCATE `hist_employee`;";
		$result = mysqli_query($mysqli,$sql);
		$sql = "TRUNCATE hist_income";
		$result = mysqli_query($mysqli,$sql);
		$sql = "TRUNCATE  hist_deduct";
		$result = mysqli_query($mysqli,$sql);
		$sql = "TRUNCATE  hist_days";
		$result = mysqli_query($mysqli,$sql);*/
		
		
		while ($emapData = fgetcsv($file,10000000, ",")) 
			
	    { if ($count <=10000) {$count++;}else {break;}
	    }
	    
			
	    while ($emapData = fgetcsv($file,10000000, ",")) 
			
	    { if ($count >15000) {exit;
	    }
	       // print_r($emapData);
			//echo $count;
			if($count>1){
			   // echo "Hii";
			//	echo $emapData[3];
			echo 	 $sqlemp = "select * from employee where ticket_no = lpad('".$emapData[1]."',6,'0') ";
				echo "<br>";
				$resemp = mysqli_query($mysqli,$sqlemp);
                 $resemp1 = mysqli_fetch_array($resemp);
                 
				 echo $x = mysqli_num_rows($resemp);
				 $empid=$resemp1['emp_id'];
			
			if ($x > 0){
                    				
					if($emapData[1]!=''){
					    //echo $emapData[0];
					 $date1=explode("/",$emapData[0]);
	                 $sdate= $date1[2]."-".$date1[1]."-".$date1[0];
							}
					else{
							$sdate='0000-00-00';
					}
	          echo "<br>".$count."-".$sdate."-".$resemp1['emp_id'];

				 $sql = "insert into hist_employee(`emp_id`, `sal_month`, `client_id`, `desg_id`, `dept_id`, `qualif_id`, `bank_id`, `loc_id`, `paycode_id`, `bankacno`, `esistatus`,`esino`, 
					 `pfno`, `comp_ticket_no`, `pay_mode`, `payabledays`, `gross_salary`, `tot_deduct`, `netsalary`, `comp_id`, `user_id`, `db_adddate`, `db_update` ) values ( '".$resemp1['emp_id']."','".$sdate."','".$resemp1['client_id']."','".$resemp1['desg_id']."','".$resemp1['dept_id']."','".$resemp1['qualif_id']."','".$resemp1['bank_id']."','".$resemp1['loc_id']."','".$resemp1['paycode_id']."','".$resemp1['bankacno']."','".addslashes( ($emapData[11]))."' ,'".$resemp1['esino']."','".$resemp1['pfno']."','-','p','".  addslashes( ($emapData[27]))."','".  addslashes( ($emapData[51]))."','".  addslashes( ($emapData[79]))."','".  addslashes( ($emapData[80]))."','11','11',now(),now())";				
					$result = mysqli_query($mysqli,$sql);
					
				 $sql = "insert into hist_days (`emp_id`, `sal_month`, `client_id`,  `present`, `absent`, `weeklyoff`, `pl`, `sl`, `cl`, `otherleave`, `paidholiday`, `additional`, `othours`, `nightshifts`, `extra_inc1`, `extra_ded1`, `wagediff`,`comp_id`, `user_id` )values ( '".$resemp1['emp_id']."','".$sdate."','".$resemp1['client_id']."','".addslashes( ($emapData[16]))."','".addslashes( ($emapData[19]))."','".addslashes( ($emapData[17]))."','".addslashes( ($emapData[24]))."','".addslashes( ($emapData[26]))."','".addslashes( ($emapData[25]))."','ol','".addslashes( ($emapData[18]))."','".addslashes( ($emapData[20]))."','".addslashes( ($emapData[21]))."','".addslashes( ($emapData[23]))."','".addslashes( ($emapData[44]))."','".addslashes( ($emapData[68]))."','".addslashes( ($emapData[30]))."','11','11')";
					$result = mysqli_query($mysqli,$sql);
				 
				 	if ($emapData[6] =="D"){$calc_type = 5;}
					if ($emapData[6] =="S"){$calc_type = 14;}
					if ($emapData[6] =="M"){$calc_type = 2;}

				//BASIC
				 $sql = " insert into hist_income (`emp_id`,`comp_id`,`user_id`, `sal_month`, `head_id`, `calc_type`, `std_amt`, `amount` ) values ('".$resemp1['emp_id']."','11','11','".$sdate."','".$resemp1['head_id']."','5','".$resemp1inc['std_amt']."','".addslashes( ($emapData[28]))."')";
				 
				 
				 
				 
				 $std_amt=0;
				 $calc_type ="5";
				 /* if ($emapData[13] =="D"){$calc_type = 5;}
				  if ($emapData[13] =="S"){$calc_type = 14;}
				  if ($emapData[13] =="M"){$calc_type = 2;}*/
				 //BASIC
				 if ($emapData[28]> 0){
					 
					 $sqlempinc = "select std_amt from emp_income where emp_id = '".$resemp1['emp_id']."' and head_id='1'";
				$resempinc = mysqli_query($mysqli,$sqlempinc);
                 $resemp1inc = mysqli_fetch_array($resempinc);
				 $xinc = mysqli_num_rows($resempinc);
				 if($xinc>0)
				 {
					$std_amt= $resemp1inc['std_amt'];
				 }
				 
					 $sql = " insert into hist_income (emp_id,  `comp_id`, `user_id`, `head_id`, `calc_type`, `std_amt`, `amount`, `remark` , `sal_month` , `db_adddate`, `db_update` ) values     ($empid,'11','11',1,".$calc_type.",".$std_amt.",".addslashes($emapData[28]).",'-','".$sdate."',now(),now())"; 
				 $result = mysqli_query($mysqli,$sql);
				 }
				 //DA
				 if ($emapData[29]> 0){
					 
					 $sql = " insert into hist_income (emp_id,  `comp_id`, `user_id`, `head_id`, `calc_type`, `std_amt`, `amount`, `remark` , `sal_month` , `db_adddate`, `db_update` ) values     ($empid,'11','11',2,".$calc_type.",".$std_amt.",".addslashes($emapData[29]).",'-','".$sdate."',now(),now())"; 
				 $result = mysqli_query($mysqli,$sql);
				 }
				//HRA
				 if ($emapData[31]> 0){
					 
					 $sql = " insert into hist_income (emp_id,  `comp_id`, `user_id`, `head_id`, `calc_type`, `std_amt`, `amount`, `remark` , `sal_month` , `db_adddate`, `db_update` ) values     ($empid,'11','11',3,".$calc_type.",".$std_amt.",".addslashes($emapData[31]).",'-','".$sdate."',now(),now())"; 
				 $result = mysqli_query($mysqli,$sql);
				 }
				 
				 
				 //edu
					if ($emapData[33]> 0){
					 
					 $sql = " insert into hist_income (emp_id,  `comp_id`, `user_id`, `head_id`, `calc_type`, `std_amt`, `amount`, `remark` , `sal_month` , `db_adddate`, `db_update` ) values     ($empid,'11','11',4,".$calc_type.",".$std_amt.",".addslashes($emapData[33]).",'-','".$sdate."',now(),now())"; 
				 $result = mysqli_query($mysqli,$sql);
				 }
				
				 //washing
					if ($emapData[34]> 0){
					 
					 $sql = " insert into hist_income (emp_id,  `comp_id`, `user_id`, `head_id`, `calc_type`, `std_amt`, `amount`, `remark`, `sal_month` , `db_adddate`, `db_update`  ) values     ($empid,'11','11',5,".$calc_type.",".$std_amt.",".addslashes($emapData[34]).",'-','".$sdate."',now(),now())"; 
				 $result = mysqli_query($mysqli,$sql);
				 }
				 
				  //conveyance
					if ($emapData[35]> 0){
					 
					 $sql = " insert into hist_income (emp_id,  `comp_id`, `user_id`, `head_id`, `calc_type`, `std_amt`, `amount`, `remark`, `sal_month` , `db_adddate`, `db_update`  ) values     ($empid,'11','11',6,".$calc_type.",".$std_amt.",".addslashes($emapData[35]).",'-','".$sdate."',now(),now())"; 
				 $result = mysqli_query($mysqli,$sql);
				 }
				
				  //canteen
					if ($emapData[38]> 0){
					 
					 $sql = " insert into hist_income (emp_id,  `comp_id`, `user_id`, `head_id`, `calc_type`, `std_amt`, `amount`, `remark` , `sal_month` , `db_adddate`, `db_update` ) values     ($empid,'11','11',7,".$calc_type.",".$std_amt.",".addslashes($emapData[38]).",'-','".$sdate."',now(),now())"; 
				 $result = mysqli_query($mysqli,$sql);
				 }
				
				 //medical
					if ($emapData[41]> 0){
					 
					 $sql = " insert into hist_income (emp_id,  `comp_id`, `user_id`, `head_id`, `calc_type`, `std_amt`, `amount`, `remark`, `sal_month` , `db_adddate`, `db_update`  ) values     ($empid,'11','11',8,".$calc_type.",".$std_amt.",".addslashes($emapData[41]).",'-','".$sdate."',now(),now())"; 
				 $result = mysqli_query($mysqli,$sql);
				 }
				 
				  //incentive
					if ($emapData[42]> 0){
					 
					 $sql = " insert into hist_income (emp_id,  `comp_id`, `user_id`, `head_id`, `calc_type`, `std_amt`, `amount`, `remark`, `sal_month` , `db_adddate`, `db_update`  ) values     ($empid,'11','11',9,".$calc_type.",".$std_amt.",".addslashes($emapData[42]).",'-','".$sdate."',now(),now())"; 
				 $result = mysqli_query($mysqli,$sql);
				 }
					
					 //other all
					if ($emapData[43]> 0){
					 
					 $sql = " insert into hist_income (emp_id,  `comp_id`, `user_id`, `head_id`, `calc_type`, `std_amt`, `amount`, `remark` , `sal_month` , `db_adddate`, `db_update` ) values     ($empid,'11','11',10,".$calc_type.",".$std_amt.",".addslashes($emapData[43]).",'-','".$sdate."',now(),now())"; 
				 $result = mysqli_query($mysqli,$sql);
				 }
					 //vehicle 
					if ($emapData[45]> 0){
					 
					 $sql = " insert into hist_income (emp_id,  `comp_id`, `user_id`, `head_id`, `calc_type`, `std_amt`, `amount`, `remark`, `sal_month` , `db_adddate`, `db_update`  ) values     ($empid,'11','11',11,".$calc_type.",".$std_amt.",".addslashes($emapData[45]).",'-','".$sdate."',now(),now())"; 
				 $result = mysqli_query($mysqli,$sql);
				 }
				
				 //mobile
					if ($emapData[49]> 0){
					 
					 $sql = " insert into hist_income (emp_id,  `comp_id`, `user_id`, `head_id`, `calc_type`, `std_amt`, `amount`, `remark` , `sal_month` , `db_adddate`, `db_update` ) values     ($empid,'11','11',12,".$calc_type.",".$std_amt.",".addslashes($emapData[49]).",'-','".$sdate."',now(),now())"; 
				 $result = mysqli_query($mysqli,$sql);
				 }
				
				 //production 
					if ($emapData[47]> 0){
					 
					 $sql = " insert into hist_income (emp_id,  `comp_id`, `user_id`, `head_id`, `calc_type`, `std_amt`, `amount`, `remark` , `sal_month` , `db_adddate`, `db_update` ) values     ($empid,'11','11',13,".$calc_type.",".$std_amt.",".addslashes($emapData[47]).",'-' ,'".$sdate."',now(),now())"; 
				 $result = mysqli_query($mysqli,$sql);
				 }
					
					 //overtime
					if ($emapData[50]> 0){
					 
					 $sql = " insert into hist_income (emp_id,  `comp_id`, `user_id`, `head_id`, `calc_type`, `std_amt`, `amount`, `remark`, `sal_month` , `db_adddate`, `db_update` ) values     ($empid,'11','11',14,".$calc_type.",".$std_amt.",".addslashes($emapData[50]).",'-','".$sdate."',now(),now())"; 
				 $result = mysqli_query($mysqli,$sql);
				 }
					 //income1
					if ($emapData[44]> 0){
					 
					 $sql = " insert into hist_income (emp_id,  `comp_id`, `user_id`, `head_id`, `calc_type`, `std_amt`, `amount`, `remark`, `sal_month` , `db_adddate`, `db_update`) values($empid,'11','11',15,".$calc_type.",".$std_amt.",".addslashes($emapData[44]).",'-','".$sdate."',now(),now())"; 
				 $result = mysqli_query($mysqli,$sql);
				 }
				 
				 
				 
				 
				
				 //P.F.
					if ($emapData[54]> 0){
					 
					 $sql = " insert into hist_deduct (`emp_id`, `sal_month`, `head_id`, `calc_type`, `std_amt`, `amount`, `employer_contri_1`, `employer_contri_2`, `db_adddate`, `db_update`) values($empid,'".$sdate."','1','7',".addslashes($emapData[52]).",".addslashes($emapData[69]).",".addslashes($emapData[71]).",".addslashes($emapData[72]).",now(),now())"; 
				 $result = mysqli_query($mysqli,$sql);
				 }
				 //esi
					if ($emapData[55]> 0){
					 
					 $sql = " insert into hist_deduct (`emp_id`, `sal_month`, `head_id`, `calc_type`, `std_amt`, `amount`, `employer_contri_1`, `employer_contri_2`, `db_adddate`, `db_update`) values($empid,'".$sdate."','2','7',".addslashes($emapData[53]).",".addslashes($emapData[55]).",".addslashes($emapData[74]).",'0','0',now(),now())"; 
				 $result = mysqli_query($mysqli,$sql);
				 }
				 
				 
				 
				 //prof.Tax.
					if ($emapData[56]> 0){
					 
					 $sql = " insert into hist_deduct (`emp_id`, `sal_month`, `head_id`, `calc_type`,`amount`, `employer_contri_1`, `employer_contri_2`, `db_adddate`, `db_update`) values($empid,'".$sdate."','3','7',".addslashes($emapData[56]).",'0','0',now(),now())"; 
				 $result = mysqli_query($mysqli,$sql);
				 }
					
					
			
	    }
		}$count++;
	    }
		
	    fclose($file);
        
		
		if($count>1)
		{
			echo "<script type=\"text/javascript\">
					alert(\"CSV File has been successfully Imported.\");
 				</script>";
			
		}
		
		?>
		
