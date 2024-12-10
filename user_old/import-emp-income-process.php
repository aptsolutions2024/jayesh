r<?php
session_start();
error_reporting(0);
include("../lib/connection/db-config.php");
include("../lib/class/user-class.php");
$userObj=new user();
$incomeid=addslashes($_POST['incomeid']);
$ct=addslashes($_POST['caltype']);
$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];
$filename=$_FILES["file"]["tmp_name"];
//$income = $_POST['incomeid'];
	if($_FILES["file"]["size"] > 0)
	{
       $count=0;  
		$file = fopen($filename, "r");
	    while ($emapData = fgetcsv($file, 10000, ","))
			
	    {
			
			//print_r($emapData);
			      
			if($count!=0){
			 	/*$chk="SELECT * FROM `emp_income` WHERE `emp_id`='".addslashes($emapData[0])."' AND `head_id`='".$incomeid."' ";	
                $resultch = mysql_query($chk);*/
                $resultch = $userObj->impoEmpIncomeProcess($emapData[0],$incomeid,$comp_id,$user_id);
                $countch = mysqli_num_rows($resultch);
	           
					if($countch>0) {
						// $rowchk = mysql_fetch_array($resultch);
						$userObj->updateImpoEmpIncomeProcess($emapData[4],$ct,$emapData[5],$emapData[0],$incomeid,$comp_id,$user_id);
								/*$sql = "update emp_income set std_amt = '".addslashes($emapData[4])."',`calc_type`='".$ct."',remark='".addslashes($emapData[5])."' where `emp_id`='".addslashes($emapData[0])."' AND `head_id`='".$incomeid."' ";*/
								
							}else{								
				        $userObj->insertImpoEmpIncomeProcess($comp_id,$user_id,$emapData[0],$incomeid,$ct,$emapData[4],$emapData[5]);
							/*$sql = "INSERT INTO `emp_income`(`comp_id`, `user_id`,`emp_id`,`head_id`, `calc_type`, `std_amt`, `remark`, `db_addate`, `db_update`) VALUES ('" .$comp_id  . "','" . $user_id . "','".addslashes($emapData[0])."','".$incomeid."','".$ct."','".addslashes($emapData[4])."','".addslashes($emapData[5])."',Now(),Now())";*/}
		             
							
			}
			$count++;
	    }


	    fclose($file);

		if($count>1)
		{
			echo "<script type=\"text/javascript\">
					alert(\"CSV File has been successfully Imported.\");
 				window.location = \"import-income.php\"
				</script>";
			
		}
		
	}	
?>
