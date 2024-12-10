<?php
session_start();
/*ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', dirname(__FILE__) . '/error_log.txt');*/
error_reporting(E_ALL);

include("../lib/connection/db-config.php");
include("../lib/class/user-class.php");
$userObj=new user();
$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];
$client_id=addslashes($_POST['client']);


$row1 = $userObj->importTransactionProcess($client_id,$comp_id,$user_id);
$row_cl =$row1->fetch_assoc();
 $client_date = $row_cl['current_month'];

$filename=$_FILES["file"]["tmp_name"];
 

	if($_FILES["file"]["size"] > 0)
	{
	
       $update_count=0;  
	   $insert_count = 0;
	    $count =0;
		$file = fopen($filename, "r");
	
		    while($emapData = fgetcsv($file, 10000, ","))
	    {
			print_r($emapData);
			  

			if($count!=0){

                  	$date1=explode("/",$emapData[2]);
	                echo  $tempdate= $date1[2]."-".$date1[1]."-".$date1[0];

					 
					if ($tempdate == $client_date) { 
						$head =$userObj->getmastcomptdstring();
						$exhd = explode(',',$head);
						$j= count($exhd);
						
						$userObj->getEmployeeFromTrandays($emapData[3],$comp_id,$user_id);
			        
							$cnt=$userObj->getEmployeeFromTrandays($emapData[3],$comp_id,$user_id);
			
							echo "1111";
							if($cnt>0) {
								$result =$userObj->updateTrandaySalMonth($client_date,$exhd,$emapData,$j,$comp_id,$user_id);
								
								$update_count++;
							    $result = $userObj->updateTrandays($client_date,$emapData[3],$comp_id,$user_id);
								
               
							}
	                         
							else{
							    echo "helo *************************888888";
							    $result = $userObj->insertTrandaysImport($client_date,$emapData,$comp_id,$user_id,$client_id);
								$result = $userObj->updateTrandays1($emapData[3],$comp_id,$user_id);
								
							
 							
                 				$insert_count++;
							}
}
					}
					$count++;
	    }
		
		
	    fclose($file);
		
		exit;
		//if($count>1)
		//{
			echo "<script type=\"text/javascript\">
			       
					alert(\"CSV File has been successfully Imported.". $insert_count ." records inserted.".$update_count." records have been updated.  \");
 				window.location = \"/import_transactions\"
				</script>";
			
	//	}
		
	}	
?>
