<?php       
//
session_start();
ini_set('display_errors', 1);
ini_set('log_errors', 1);
error_reporting('E_ALL');
//include_once($_SERVER['DOCUMENT_ROOT']."/lib/connection/db-config.php");
//$admin=new admin();
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', dirname(__FILE__) . '/error_log.txt');
error_reporting(E_ALL); 
//echo "Hiiii";exit;
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




// $filename ='employee_csv.csv';
 
		$count=0;  
	//	$file = fopen($filename, "r");
	//	echo "Please wait.File is being uploaded.";
		$sql = "TRUNCATE employee";
		$result = mysqli_query($con,$sql);
		$sql = "TRUNCATE emp_income";
		$result = mysqli_query($con,$sql);
		$sql = "TRUNCATE  emp_deduct";
		$result = mysqli_query($con,$sql);
		$comp_id = 11;
		$user_id = 11;
		
		$file = fopen("employee_csv.csv","r");
        $emapData=fgetcsv($file);
        

	    while ($emapData = fgetcsv($file,10000, ",")) 
			
	    { 
		
			if($count>=0){

				if($emapData[12]!=''){
                	$date1=explode("/",$emapData[12]);
	                 $bdate= $date1[2]."-".$date1[1]."-".$date1[0];
						}
				else{
					$bdate='0000-00-00';
				}
				echo "<br>";
				
				if($emapData[11]!=''){
					$date1=explode("/",$emapData[11]);
	                 $jdate= $date1[2]."-".$date1[1]."-".$date1[0];
	                }
				else{
						$jdate='0000-00-00';
				}
				echo "<br>";
				if($emapData[13]!=''){
					$date1=explode("/",$emapData[13]);
	                 $ldate= $date1[2]."-".$date1[1]."-".$date1[0];

						}
				else{
					$ldate='0000-00-00';
				}
		

			echo	 $sql = "insert into employee (paycode_id, clientno, first_name, middle_name, last_name,
				emp_add1, pin_code, mobile_no, gender,pay_mode,bankcode,bankacno,bdate,joindate,leftdate,pfno,esistatus,esino,dept,qualif,comp_ticket_no,panno,adharno,uan,married_status,middlename_relation,comp_id,user_id,ticket_no) values (	'".addslashes($emapData[1])."','".addslashes($emapData[2])."','".addslashes($emapData[3])."','".addslashes($emapData[4])."','".addslashes($emapData[5])."',
				'','',
				'".addslashes($emapData[52])."','".addslashes($emapData[17])."','','','".addslashes($emapData[48])."','".$bdate ."','".$jdate."','".$ldate ."','".addslashes($emapData[9])."','".addslashes($emapData[8])."','".addslashes($emapData[10])."','".addslashes($emapData[14])."','".addslashes($emapData[15])."','','','','
','','S','".$comp_id."','".$user_id."','".addslashes($emapData[0])."')";			
			
					$result = mysqli_query($con,$sql);
				echo 	$empid=mysqli_insert_id($con); 
				echo "<br>";
					$idpr='';
					if($emapData[50]=='AdharCard'){
						$idpr ='adharno';
					}else if($emapData[50]=='PanCard'){
						$idpr ='panno';
					}else if($emapData[50]=='VoterId'){
						$idpr ='voter_id';
					}
					if($idpr !=""){
						$sql = "update employee set ".$idpr."='".$emapData[51]."' where emp_id='".$empid."'";
						$result = mysqli_query($con,$sql);
					}
					
				  $calc_type ="5";
				 /* if ($emapData[13] =="D"){$calc_type = 5;}
				  if ($emapData[13] =="S"){$calc_type = 14;}
				  if ($emapData[13] =="M"){$calc_type = 2;}*/
				 //BASIC
					 $sql = " insert into emp_income (emp_id,  `comp_id`, `ticket_no`, `user_id`, `head_id`, `calc_type`, `std_amt`, `remark`  ) values     ($empid,'".$comp_id."', '".addslashes(intval($emapData[1]))."','".$user_id."',1,".$calc_type.",".addslashes($emapData[20]).",'') "; 
					 $result = mysqli_query($con,$sql);
				 //DA
					if ($emapData[21]>0){				
					$sql = " insert into emp_income (emp_id,  `comp_id`, `ticket_no`, `user_id`, `head_id`, `calc_type`, `std_amt`, `remark`) values     ($empid,'".$comp_id."', '".addslashes(intval($emapData[1]))."','".$user_id."',2,".$calc_type.",".addslashes($emapData[21]).",'') ";
					$result = mysqli_query($con,$sql);}
					
				 //HRA
					if ($emapData[23]>0){				
					$sql = " insert into emp_income (emp_id,  `comp_id`, `ticket_no`, `user_id`, `head_id`, `calc_type`, `std_amt`, `remark`) values     ($empid,'".$comp_id."', '".addslashes(intval($emapData[1]))."','".$user_id."',3,".$calc_type.",".addslashes($emapData[23]).",'') ";
					$result = mysqli_query($con,$sql);}
					
				 //edu
					if ($emapData[25]>0){				
					$sql = " insert into emp_income (emp_id,  `comp_id`, `ticket_no`, `user_id`, `head_id`, `calc_type`, `std_amt`, `remark` )	values   ($empid,'".$comp_id."', '".addslashes(intval($emapData[1]))."','".$user_id."',4,".$calc_type.",".addslashes($emapData[25]).",'') ";
					$result = mysqli_query($con,$sql);}
				
				 //washing
					if ($emapData[26]>0){				
					$sql = " insert into emp_income (emp_id,  `comp_id`, `ticket_no`, `user_id`, `head_id`, `calc_type`, `std_amt`, `remark` )	values   ($empid,'".$comp_id."', '".addslashes(intval($emapData[1]))."','".$user_id."',5,".$calc_type.",".addslashes($emapData[26]).",'') ";
					$result = mysqli_query($con,$sql);}
				 
				  //conveyance
					if ($emapData[27]>0){				
					$sql = " insert into emp_income (emp_id,  `comp_id`, `ticket_no`, `user_id`, `head_id`, `calc_type`, `std_amt`, `remark` )	values   ($empid,'".$comp_id."', '".addslashes(intval($emapData[1]))."','".$user_id."',6,".$calc_type.",".addslashes($emapData[27]).",'') ";
					$result = mysqli_query($con,$sql);}
				
				  //canteen
					if ($emapData[30]>0){				
					$sql = " insert into emp_income (emp_id,  `comp_id`, `ticket_no`, `user_id`, `head_id`, `calc_type`, `std_amt`, `remark` )	values   ($empid,'".$comp_id."', '".addslashes(intval($emapData[1]))."','".$user_id."',7,".$calc_type.",".addslashes($emapData[30]).",'') ";
					$result = mysqli_query($con,$sql);}
				
				 //medical
					if ($emapData[33]>0){				
					$sql = " insert into emp_income (emp_id,  `comp_id`, `ticket_no`, `user_id`, `head_id`, `calc_type`, `std_amt`, `remark` )	values   ($empid,'".$comp_id."', '".addslashes(intval($emapData[1]))."','".$user_id."',8,".$calc_type.",".addslashes($emapData[33]).",'') ";
					$result = mysqli_query($con,$sql);}
				 
				  //incentive
					if ($emapData[34]>0){				
					$sql = " insert into emp_income (emp_id,  `comp_id`, `ticket_no`, `user_id`, `head_id`, `calc_type`, `std_amt`, `remark` )	values   ($empid,'".$comp_id."', '".addslashes(intval($emapData[1]))."','".$user_id."',9,".$calc_type.",".addslashes($emapData[34]).",'') ";
					$result = mysqli_query($con,$sql);}
					
					 //other all
					if ($emapData[35]>0){				
					$sql = " insert into emp_income (emp_id,  `comp_id`, `ticket_no`, `user_id`, `head_id`, `calc_type`, `std_amt`, `remark` )	values   ($empid,'".$comp_id."', '".addslashes(intval($emapData[1]))."','".$user_id."',10,".$calc_type.",".addslashes($emapData[35]).",'') ";
					$result = mysqli_query($con,$sql);}
					
					 //vehicle 
					if ($emapData[36]>0){				
					$sql = " insert into emp_income (emp_id,  `comp_id`, `ticket_no`, `user_id`, `head_id`, `calc_type`, `std_amt`, `remark` )	values   ($empid,'".$comp_id."', '".addslashes(intval($emapData[1]))."','".$user_id."',11,".$calc_type.",".addslashes($emapData[36]).",'') ";
					$result = mysqli_query($con,$sql);}
				
				 //mobile
					if ($emapData[39]>0){				
					$sql = " insert into emp_income (emp_id,  `comp_id`, `ticket_no`, `user_id`, `head_id`, `calc_type`, `std_amt`, `remark` )	values   ($empid,'".$comp_id."', '".addslashes(intval($emapData[1]))."','".$user_id."',12,".$calc_type.",".addslashes($emapData[39]).",'') ";
					$result = mysqli_query($con,$sql);}
				
				 //production 
					if ($emapData[40]>0){				
					$sql = " insert into emp_income (emp_id,  `comp_id`, `ticket_no`, `user_id`, `head_id`, `calc_type`, `std_amt`, `remark` )	values   ($empid,'".$comp_id."', '".addslashes(intval($emapData[1]))."','".$user_id."',13,".$calc_type.",".addslashes($emapData[40]).",'') ";
					$result = mysqli_query($con,$sql);}
					
					 //overtime
					if ($emapData[41]>0){				
					$sql = " insert into emp_income (emp_id,  `comp_id`, `ticket_no`, `user_id`, `head_id`, `calc_type`, `std_amt`, `remark` )	values   ($empid,'".$comp_id."', '".addslashes(intval($emapData[1]))."','".$user_id."',14,".$calc_type.",".addslashes($emapData[41]).",'') ";
					$result = mysqli_query($con,$sql);}
				
				
				 //P.F.
					if ($emapData[6]=="TRUE"){				
					$sql = " insert into emp_deduct (emp_id,  `comp_id`, `ticket_no`, `user_id`, `head_id`, `calc_type`, `std_amt`, `remark` )	values   ($empid,'".$comp_id."', '".addslashes(intval($emapData[1]))."','".$user_id."',1,7,12,'') ";
					$result = mysqli_query($con,$sql);}

				 //esi
					if ($emapData[8]=='TRUE'){				
					$sql = " insert into emp_deduct (emp_id,  `comp_id`, `ticket_no`, `user_id`, `head_id`, `calc_type`, `std_amt`, `remark` )	values   ($empid,'".$comp_id."', '".addslashes(intval($emapData[1]))."','".$user_id."',2,7,0,'') ";
					$result = mysqli_query($con,$sql);}
				 //prof.Tax.
					if ($emapData[7]=='TRUE'){				
					$sql = " insert into emp_deduct (emp_id,  `comp_id`, `ticket_no`, `user_id`, `head_id`, `calc_type`, `std_amt`, `remark` )	values   ($empid,'".$comp_id."', '".addslashes(intval($emapData[1]))."','".$user_id."',3,7,0,'') ";
					$result = mysqli_query($con,$sql);}
		
		}
			$count++;
		//	if ($count>15){break;}
	    }
	    fclose($file);
		
		$sql = "update employee e inner join mast_client mc on mc.clientno = e.clientno set e.client_id = mc.mast_client_id,desg_id = 1";
		$result = mysqli_query($con,$sql);
echo "<br>";
	echo 	$sql = "update employee e inner join mast_dept md on md.dept = e.dept and  md.comp_id = e.comp_id    set e.dept_id = md.mast_dept_id";
		$result = mysqli_query($con,$sql);

		$sql = "update employee e inner join mast_bank mb on mb.bankcode = e.bankcode and mb.comp_id = e.comp_id  set e.bank_id = mb.mast_bank_id";
		$result = mysqli_query($con,$sql);
		
		$sql = "update employee e set e.pay_mode = 'C' where comp_id = 1 and bankcode = '010'";
		$result = mysqli_query($con,$sql);
		
		$sql = "update employee e set e.pay_mode = 'T' where comp_id = 1 and bankcode <> '010'";
		$result = mysqli_query($con,$sql);
		
		$sql = "update employee e inner join mast_qualif md on md.qualif = e.qualif and  md.comp_id = e.comp_id  set e.qualif_id = md.mast_qualif_id";
		$result = mysqli_query($con,$sql);
		
		$sql = "update employee e inner join mast_desg md on md.desg = e.desg and  md.comp_id = e.comp_id  set e.desg_id = md.mast_desg_id";
		$result = mysqli_query($con,$sql);
	
		$sql = "update employee  set job_status = 'L' where leftdate >'2000-01-01' ";
		$result = mysqli_query($con,$sql);
		
		if($count>1)
		{
			echo "<script type=\"text/javascript\">
					alert(\"CSV File has been successfully Imported.\");
 				</script>";
			
		}
		
		?>