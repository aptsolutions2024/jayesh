<?php       
$con=mysql_connect("localhost","root","");
 mysql_select_db("imcon_salary",$con)
or die("Could not connect trial");

if(!$con){
    die('Could not connect: '.mysql_error());
}

 $filename ='c:/ICS_SALM_1csv.csv';
		$count=0;  
		$file = fopen($filename, "r");
		echo "Please wait.File is being uploaded.";
	/*	$sql = "delete from hist_employee";
		$result = mysql_query($sql);
		echo $sql = "delete from hist_income";
		$result = mysql_query($sql);
		$sql = "delete from hist_deduct";
		$result = mysql_query($sql);
		$sql = "delete from hist_days";
		$result = mysql_query($sql);
		$sql = "delete from hist_advance";
		$result = mysql_query($sql);*/
		echo "%%%%%%%%%%%%%";
		
			
	    while ($emapData = fgetcsv($file,10000, ",")) 
			
	    {
			if($count>7){
				
				$sqlemp = "select * from employee where ticket_no = '". addslashes($emapData[3])."'"; 
				$resultemp = mysql_query($sqlemp);
				$resemp = mysql_fetch_array($resultemp);
if  ($resemp['emp_id'] >0){				
				
hist_employee	1 - sal_month	employee_client_id		4  -  employee.joindate				8- pay_mode	9- bank_id	10- bankacno														24-pfno		26-esistatus	27-esino		29- dept_id	30-qualif_id								38- payabledays																																	71-gross_salary																										97- tot_deduct	98-netsalary			101 - employee leftdate																										127-dept_id																				

sal_month,client_id,employee.joindate,pay_mode,bank_id,bankacno,pfno,esistatus,esino,dept_id,qualif_id,payabledays,gross_salary,tot_deduct,netsalary,leftdate,																	127-dept_id,																	

			
				 $sql = "insert into hist_employee	(sal_month,client_id,employee.joindate,pay_mode,bank_id,bankacno,pfno,esistatus,esino,dept_id,qualif_id,payabledays,gross_salary,tot_deduct,netsalary,leftdate,dept_id																	
) 
											 values ( '".addslashes(intval($emapData[3]))."','".date('Y-m-d', strtotime($emapData[2]))."','".addslashes($emapData[3])."','".addslashes($emapData[4])."','".addslashes($emapData[6])."','".addslashes($emapData[7])."','".addslashes($emapData[15])."','".addslashes($emapData[28])."','".addslashes($emapData[39])."','".addslashes($emapData[42])."','".addslashes($emapData[46])."','".addslashes($emapData[47])."','".addslashes($emapData[48])."','".addslashes($emapData[49])."','".addslashes($emapData[50])."','3','4')";					
				 $result = mysql_query($sql);
				
				 $sql = "insert into hist_days (`emp_id`, `sal_month`, `ticketno`, cl,pl,present,weeklyoff,`additional`,  `paidholiday`,  `absent`, `extra_inc1`, `extra_inc2`, `extra_ded1`,  `leftdate`,`clbal`, `plbal`,  `comp_id`, `user_id` )
				values ('".addslashes(intval($emapData[3]))."','".date('Y-m-d', strtotime($emapData[2]))."','".addslashes($emapData[3])."','".addslashes($emapData[8])."','".addslashes($emapData[9])."','".addslashes($emapData[10])."','".addslashes($emapData[11])."','".addslashes($emapData[12])."','".addslashes($emapData[13])."','".addslashes($emapData[14])."','".addslashes($emapData[23])."','".addslashes($emapData[41])."','".addslashes($emapData[38])."','".date('Y-m-d', strtotime($emapData[43]))."','".addslashes($emapData[44])."','".addslashes($emapData[45])."',3,4)";
				
				 $result = mysql_query($sql);
				 
				 //BASIC
				 $sql = " insert into hist_income (`emp_id`, `sal_month`, `ticketno`, `head_id`, `calc_type`, `std_amt`, `amount`, `clientno` )
				                       values     ( '".addslashes(intval($emapData[3]))."','".date('Y-m-d', strtotime($emapData[2]))."','".addslashes($emapData[3])."','15',2,0,".addslashes($emapData[17]).",'') ";
				 $result = mysql_query($sql);
				 //HRA
				 $sql = " insert into hist_income (`emp_id`, `sal_month`, `ticketno`, `head_id`, `calc_type`, `std_amt`, `amount`, `clientno` )
				                       values     ( '".addslashes(intval($emapData[3]))."','".date('Y-m-d', strtotime($emapData[2]))."','".addslashes($emapData[3])."','9',2,0,".addslashes($emapData[18]).",'') ";
				 $result = mysql_query($sql);
				 //Washing Allow
				 if ($emapData[19] >0){
	
					$sql = " insert into hist_income (`emp_id`, `sal_month`, `ticketno`, `head_id`, `calc_type`, `std_amt`, `amount`, `clientno` )
				                       values     ( '".addslashes(intval($emapData[3]))."','".date('Y-m-d', strtotime($emapData[2]))."','".addslashes($emapData[3])."','12',2,0,".addslashes($emapData[19]).",'') ";
				 $result = mysql_query($sql);
				 }
				 //City Comp. Allow
				 if ($emapData[20] >0){
				 $sql = " insert into hist_income (`emp_id`, `sal_month`, `ticketno`, `head_id`, `calc_type`, `std_amt`, `amount`, `clientno` )
				                       values     ( '".addslashes(intval($emapData[3]))."','".date('Y-m-d', strtotime($emapData[2]))."','".addslashes($emapData[3])."','11',2,0,".addslashes($emapData[20]).",'') ";
				 $result = mysql_query($sql);
			 }
				 //Conveyance
				 				 if ($emapData[21] >0){
$sql = " insert into hist_income (`emp_id`, `sal_month`, `ticketno`, `head_id`, `calc_type`, `std_amt`, `amount`, `clientno` )
				                       values     ( '".addslashes(intval($emapData[3]))."','".date('Y-m-d', strtotime($emapData[2]))."','".addslashes($emapData[3])."','10',2,0,".addslashes($emapData[21]).",'') ";
				 $result = mysql_query($sql);
								 }
				 // Other Allow.
				 				 if ($emapData[22] >0){

				 $sql = " insert into hist_income (`emp_id`, `sal_month`, `ticketno`, `head_id`, `calc_type`, `std_amt`, `amount`, `clientno` )
				                       values     ( '".addslashes(intval($emapData[3]))."','".date('Y-m-d', strtotime($emapData[2]))."','".addslashes($emapData[3])."','13',2,0,".addslashes($emapData[22]).",'') ";
				 $result = mysql_query($sql);
								 }
				 //Incentive 
				 				 if ($emapData[24] >0){

				 $sql = " insert into hist_income (`emp_id`, `sal_month`, `ticketno`, `head_id`, `calc_type`, `std_amt`, `amount`, `clientno` )
				                       values     ( '".addslashes(intval($emapData[3]))."','".date('Y-m-d', strtotime($emapData[2]))."','".addslashes($emapData[3])."','20',2,0,".addslashes($emapData[24]).",'') ";
								 $result = mysql_query($sql);}
				//Arr_Basic
								 if ($emapData[25] >0){

				 $sql = " insert into hist_income (`emp_id`, `sal_month`, `ticketno`, `head_id`, `calc_type`, `std_amt`, `amount`, `clientno` )
				                       values     ( '".addslashes(intval($emapData[3]))."','".date('Y-m-d', strtotime($emapData[2]))."','".addslashes($emapData[3])."','16',2,0,".addslashes($emapData[25]).",'') ";
				 $result = mysql_query($sql);
								 }
				//Arr_ HCC
								 if ($emapData[26] >0){

				$sql = " insert into hist_income (`emp_id`, `sal_month`, `ticketno`, `head_id`, `calc_type`, `std_amt`, `amount`, `clientno` )
				                       values     ( '".addslashes(intval($emapData[3]))."','".date('Y-m-d', strtotime($emapData[2]))."','".addslashes($emapData[3])."','17',2,0,".addslashes($emapData[26]).",'') ";
				 $result = mysql_query($sql);
								 }				 
				 //Arr_washing 
				 				 if ($emapData[27] >0){

				 $sql = " insert into hist_income (`emp_id`, `sal_month`, `ticketno`, `head_id`, `calc_type`, `std_amt`, `amount`, `clientno` )
				                       values     ( '".addslashes(intval($emapData[3]))."','".date('Y-m-d', strtotime($emapData[2]))."','".addslashes($emapData[3])."','18',2,0,".addslashes($emapData[27]).",'') ";
								 $result = mysql_query($sql);}
				 //IncomeTax
				 				 if ($emapData[52] >0){

				 $sql = " insert into hist_income (`emp_id`, `sal_month`, `ticketno`, `head_id`, `calc_type`, `std_amt`, `amount`, `clientno` )
				                       values     ( '".addslashes(intval($emapData[3]))."','".date('Y-m-d', strtotime($emapData[2]))."','".addslashes($emapData[3])."','19',2,0,".addslashes($emapData[52]).",'') ";
				 $result = mysql_query($sql);
								 }
				 
				 //PF
			     $sql = "insert into hist_deduct( `emp_id`, `sal_month`,`ticketno`, `head_id`, `calc_type`, `std_amt`, `amount`,  `employer_contri_1`, `employer_contri_2`	)
									values      ('".addslashes(intval($emapData[3]))."','".date('Y-m-d', strtotime($emapData[2]))."','".addslashes($emapData[3])."',8,7,0,".addslashes($emapData[29]).",".addslashes($emapData[30]).",".addslashes($emapData[32]).")";
				 $result = mysql_query($sql);
				
				//ESI					
				 $sql = "insert into hist_deduct( `emp_id`, `sal_month`,`ticketno`, `head_id`, `calc_type`, `std_amt`, `amount`,`employer_contri_1`, `employer_contri_2`	)
									values      ('".addslashes(intval($emapData[3]))."','".date('Y-m-d', strtotime($emapData[2]))."','".addslashes($emapData[3])."',9,7,0,".addslashes($emapData[33]).",".addslashes($emapData[34]).",0)";
				 $result = mysql_query($sql);

				//Prof tax 
				 $sql = "insert into hist_deduct( `emp_id`, `sal_month`,`ticketno`, `head_id`, `calc_type`, `std_amt`, `amount`, `employer_contri_1`, `employer_contri_2`	)
									values      ('".addslashes(intval($emapData[3]))."','".date('Y-m-d', strtotime($emapData[2]))."','".addslashes($emapData[3])."',10,7,0,".addslashes($emapData[35]).",0,0)";
				$result = mysql_query($sql);
				
			
			}
			$count++;
	    }
		
		
	    fclose($file);

		$sql = "update hist_income hi inner join employee e on e.ticket_no =hi.ticketno set hi.emp_id =e.emp_id";
		$result = mysql_query($sql);

		$sql = "update hist_deduct hd inner join employee e on e.ticket_no =hd.ticketno set hi.emp_id =e.emp_id";
		$result = mysql_query($sql);
		
		$sql = "update hist_days hd inner join employee e on e.ticket_no =hd.ticketno set hi.emp_id =e.emp_id";
		$result = mysql_query($sql);
		
		if($count>1)
		{
			echo "<script type=\"text/javascript\">
					alert(\"CSV File has been successfully Imported.\");
 				</script>";
			
		}
		
		?>
		
		
		
		hist_days		(SAL_MONTH,	TICKETNO,					CL	PL	PRESENT,	WEEKLYOFF,	ADDITIONAL-13	PAIDHOLIDAY-14	ABSENT									EXTRA_INC1															Extra_ded1			EXTRA_INC2		LEFTDATE	CLBAL	PLBAL									
values (hist_days		SAL_MONTH	TICKETNO					CL	PL	10	WEEKLYOFF-11	ADDITIONAL-13	PAIDHOLIDAY-14	ABSENT									EXTRA_INC1															Extra_ded1			EXTRA_INC2		LEFTDATE	CLBAL	PLBAL									
