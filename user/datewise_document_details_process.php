<?php
session_start();
//error_reporting(0);
ini_set('display_errors', 1);
error_reporting(0);

include("../lib/connection/db-config.php");
include("../lib/class/user-class.php");
$userObj=new user();
$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];
$clientid=$_POST['client']; 
$filename=$_FILES["file"]["tmp_name"];
$_SESSION['errorMsg']='';
$_SESSION['successMsg']='';


$empRes = $userObj->displayClientEmployeebyID($clientid);
$employeelist=[];
$headslist=array('PP','HD','WO','CO','PH','PL','AB');
//echo "<pre>";print_r($empRes);echo "</pre>";
	while($e = $empRes->fetch_assoc())  {
	   $employeelist[]=$e['emp_id']; 
	}


	if($_FILES["file"]["size"] > 0)
	{
	 
       $count=0;  
		$file = fopen($filename, "r");
		$errorMsg='';
	    while ($emapData = fgetcsv($file, 10000, ","))
	    {
	     
    			if($count==0){
    		 		$count++;
    		 		continue;
            	}
            	
            	$day=[];
            	$ot=[];
				$day[1] = trim($emapData[3]);   $day[2] = trim($emapData[4]);   $day[3] = trim($emapData[5]);	$day[4] = trim($emapData[6]);
				$day[5] = trim($emapData[7]);   $day[6] = trim($emapData[8]);   $day[7] = trim($emapData[9]);	$day[8] = trim($emapData[10]);
				$day[9] = trim($emapData[11]);  $day[10] = trim($emapData[12]); $day[11] = trim($emapData[13]); $day[12] = trim($emapData[14]);
				$day[13] = trim($emapData[15]);	$day[14] = trim($emapData[16]);	$day[15] = trim($emapData[17]);	$day[16] = trim($emapData[18]);
				$day[17] = trim($emapData[19]);	$day[18] = trim($emapData[20]);	$day[19] = trim($emapData[21]);	$day[20] = trim($emapData[22]);
				$day[21] = trim($emapData[23]);	$day[22] = trim($emapData[24]);	$day[23] = trim($emapData[25]);	$day[24] = trim($emapData[26]);
				$day[25] = trim($emapData[27]);	$day[26] = trim($emapData[28]);	$day[27] = trim($emapData[29]);	$day[28] = trim($emapData[30]);
				$day[29] = trim($emapData[31]);	$day[30] = trim($emapData[32]);	$day[31] = trim($emapData[33]);	
				
				$ot[1] = trim($emapData[34]);   $ot[2] = trim($emapData[35]);   $ot[3] = trim($emapData[36]);	$ot[4] = trim($emapData[37]);
				$ot[5] = trim($emapData[38]);   $ot[6] = trim($emapData[39]);   $ot[7] = trim($emapData[40]);	$ot[8] = trim($emapData[41]);
				$ot[9] = trim($emapData[42]);   $ot[10] = trim($emapData[43]);  $ot[11] = trim($emapData[44]);  $ot[12] = trim($emapData[45]);
				$ot[13] = trim($emapData[46]);	$ot[14] = trim($emapData[47]);	$ot[15] = trim($emapData[48]);	$ot[16] = trim($emapData[49]);
				$ot[17] = trim($emapData[50]);	$ot[18] = trim($emapData[51]);	$ot[19] = trim($emapData[52]);	$ot[20] = trim($emapData[53]);
				$ot[21] = trim($emapData[54]);	$ot[22] = trim($emapData[55]);	$ot[23] = trim($emapData[56]);	$ot[24] = trim($emapData[57]);
				$ot[25] = trim($emapData[58]);	$ot[26] = trim($emapData[59]);	$ot[27] = trim($emapData[60]);	$ot[28] = trim($emapData[61]);
				$ot[29] = trim($emapData[62]);	$ot[30] = trim($emapData[63]);	$ot[31] = trim($emapData[64]);	
				
				$emp_id=trim($emapData[1]);
                $sal_month=trim($emapData[0]);
                $emp_name=$emapData[2];
                $errorMsgtemp='';
                if (!in_array($emp_id, $employeelist)) { 
                    $errorMsgtemp.="<br><span class='errormsgspan'><b>EMP_ID-$emp_id EMP_Name-$emp_name</b> Not From Selected Client</span>";
                } 
                if($emp_id==""){
    			     $errorMsgtemp.="<br><span class='errormsgspan'>EMP_ID</b> should be there/not empty</span>";
    			    
    			 }
    			 if($sal_month==""){
    			     
    			      $errorMsgtemp.="<br><span class='errormsgspan'>Sal_month</b> should be there</span>";
    			 }
                
    			foreach($day as $key=>$val){
    			
    		     if (!in_array($day[$key], $headslist)) { 
                   $errorMsgtemp.="<br><span class='errormsgspan'><b>Day$key=$val</b> does not match</span>";
                  } 
    			
    			 if(($day[$key]!="PP" && $day[$key]!="HD") && $ot[$key]>0){
    			     
    			      $errorMsgtemp.="<br><span class='errormsgspan'><b>Ot".$key."</b> should be empty for <b>Day$key=$val</b></span>";
    			 }
    			 
    			}
    			if($errorMsgtemp && $errorMsgtemp!=""){
    			    $errorMsg.="<br><b>***** ROW - $count </b> EMP_ID - $emp_id EMP_NAME - $emp_name *******".$errorMsgtemp;
    			}
            	
    			
			$count++;
	    } 
		
	    //fclose($file);
	     echo "<br>Test3";
        if($errorMsg!='' || $errorMsg){
                        $_SESSION['errorMsg']=$errorMsg;
                      header('Location:datewise-details');
            //	echo "<script type='text/javascript'>alert('CSV File has been successfully Imported.'); window.location ='/datewise-details.php?errorMsg='+$errorMsg;	</script>";
        }else{
            
        $count=0;  
		$file = fopen($filename, "r");
		$errorMsg='';
		$sucesscnt=0;
	    while ($emapData = fgetcsv($file, 10000, ","))
	    {
	            echo "Test4";
    			if($count==0){
    		 		$count++;
    		 		continue;
            	}
            	
            	$day=[];
            	$ot=[];
				$day[1] = trim($emapData[3]);   $day[2] = trim($emapData[4]);   $day[3] = trim($emapData[5]);	$day[4] = trim($emapData[6]);
				$day[5] = trim($emapData[7]);   $day[6] = trim($emapData[8]);   $day[7] = trim($emapData[9]);	$day[8] = trim($emapData[10]);
				$day[9] = trim($emapData[11]);  $day[10] = trim($emapData[12]); $day[11] = trim($emapData[13]); $day[12] = trim($emapData[14]);
				$day[13] = trim($emapData[15]);	$day[14] = trim($emapData[16]);	$day[15] = trim($emapData[17]);	$day[16] = trim($emapData[18]);
				$day[17] = trim($emapData[19]);	$day[18] = trim($emapData[20]);	$day[19] = trim($emapData[21]);	$day[20] = trim($emapData[22]);
				$day[21] = trim($emapData[23]);	$day[22] = trim($emapData[24]);	$day[23] = trim($emapData[25]);	$day[24] = trim($emapData[26]);
				$day[25] = trim($emapData[27]);	$day[26] = trim($emapData[28]);	$day[27] = trim($emapData[29]);	$day[28] = trim($emapData[30]);
				$day[29] = trim($emapData[31]);	$day[30] = trim($emapData[32]);	$day[31] = trim($emapData[33]);	
				
				$ot[1] = trim($emapData[34]);   $ot[2] = trim($emapData[35]);   $ot[3] = trim($emapData[36]);	$ot[4] = trim($emapData[37]);
				$ot[5] = trim($emapData[38]);   $ot[6] = trim($emapData[39]);   $ot[7] = trim($emapData[40]);	$ot[8] = trim($emapData[41]);
				$ot[9] = trim($emapData[42]);   $ot[10] = trim($emapData[43]);  $ot[11] = trim($emapData[44]);  $ot[12] = trim($emapData[45]);
				$ot[13] = trim($emapData[46]);	$ot[14] = trim($emapData[47]);	$ot[15] = trim($emapData[48]);	$ot[16] = trim($emapData[49]);
				$ot[17] = trim($emapData[50]);	$ot[18] = trim($emapData[51]);	$ot[19] = trim($emapData[52]);	$ot[20] = trim($emapData[53]);
				$ot[21] = trim($emapData[54]);	$ot[22] = trim($emapData[55]);	$ot[23] = trim($emapData[56]);	$ot[24] = trim($emapData[57]);
				$ot[25] = trim($emapData[58]);	$ot[26] = trim($emapData[59]);	$ot[27] = trim($emapData[60]);	$ot[28] = trim($emapData[61]);
				$ot[29] = trim($emapData[62]);	$ot[30] = trim($emapData[63]);	$ot[31] = trim($emapData[64]);	
			
				
				$emp_id=trim($emapData[1]);
                $sal_month=trim($emapData[0]);
                $explodate=explode("-",$sal_month);
                $cur_month=date("M Y", strtotime($sal_month));
               // $year='20'.$explodate[1];
                $sal_month=date('Y-m-t',strtotime($cur_month));
                $checkexist=$userObj->checkIfUserExistbySalmonthEmpid($emp_id,$sal_month);
                if(isset($checkexist['emp_id'])){
                    //update user
                     $ottotal=0;
                     $daytotal=0;
                     
                	 $sql = "Update tran_days_details set ";
                   
                     foreach($day as $key=>$val){
    	   	           // `ot_total`, `day_total`, `created_by`, `created_on`)";
                	
    	   	          $sql.="day$key='".$val."',";
    	   	          
    	   	          if($day[$key]=="PP"){
    	   	               $daytotal=$daytotal+1;
    	   	          }elseif($day[$key]=="HD"){
    	   	               $daytotal=$daytotal+0.5; 
    	   	          }
                     
    			     }
    			     foreach($ot as $key1=>$val1){
    	   	       
    	   	          $sql.="ot$key1='".$val1."',";
    	   	          $ottotal =$ottotal+$val1;
    			     }
    			     $sql.=" day_total='".$daytotal."'";
    			      $sql.=",ot_total=".$ottotal."";
    			      $sql.=",updated_by=".$user_id;
    			      $sql.=",updated_on=NOW()";
    			   
    			     $sql.=" Where emp_id='$emp_id' and sal_month='$sal_month'";
    			     $row=$userObj->insertUpdateNewEmpTranDaysDetails($sql);
        			    if($row){
        			        $sucesscnt++;
        			    }
                    
                }else{
                    //insert user
                	 $sql = "insert into tran_days_details (`emp_id`, `sal_month`, `day1`, `day2`, `day3`, `day4`, `day5`, `day6`, `day7`, `day8`, `day9`, `day10`, `day11`, `day12`, `day13`, `day14`, `day15`, `day16`, `day17`, `day18`, `day19`, `day20`, `day21`, `day22`, `day23`, `day24`, `day25`, `day26`, `day27`, `day28`, `day29`, `day30`, `day31`, `ot1`, `ot2`, `ot3`, `ot4`, `ot5`, `ot6`, `ot7`, `ot8`, `ot9`, `ot10`, `ot11`, `ot12`, `ot13`, `ot14`, `ot15`, `ot16`, `ot17`, `ot18`, `ot19`, `ot20`, `ot21`, `ot22`, `ot23`, `ot24`, `ot25`, `ot26`, `ot27`, `ot28`, `ot29`, `ot30`, `ot31`, `ot_total`, `day_total`, `created_by`, `created_on`)";
                	 $sql.="values('$emp_id','$sal_month'";
                     $ottotal=0;
                     $daytotal=0;
                     foreach($day as $key=>$val){
    	   	          $sql.=",'".$val."'";
    	   	          if($day[$key]=="PP"){
    	   	               $daytotal=$daytotal+1;
    	   	          }elseif($day[$key]=="HD"){
    	   	               $daytotal=$daytotal+0.5; 
    	   	          }
                     
    			     }
    			     foreach($ot as $key1=>$val1){
    	   	          $sql.=",'".$val1."'";
    	   	          $ottotal =$ottotal+$val1;
    			     }
    			      $sql.=",".$ottotal."";
    			      $sql.=",'".$daytotal."'";
    			      $sql.=",'".$user_id."'";
    			      $sql.=",NOW()";
    			      $sql.=")";
    			      $row=$userObj->insertUpdateNewEmpTranDaysDetails($sql);
        			    if($row){
        			         $sucesscnt++;
        			    }
    			      
    			   
                }
			$count++;
	    } 
                $_SESSION['successMsg']=$sucesscnt." Records of CSV File has been successfully Imported";
                 header('Location:datewise-details');
        		//	echo "<script type='text/javascript'>alert('CSV File has been successfully Imported.'); window.location ='/datewise-details.php';	</script>";
        			
        }
		
}else{
               $_SESSION['errorMsg']="File should not be empty";
                     header('Location:datewise-details');
}	
?>
