<?php
//error_reporting(0);
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', dirname(__FILE__) . '/error_log.txt');
error_reporting(E_ALL);
session_start();
include("../lib/connection/db-config.php");
include("../lib/class/user-class.php");
$userObj=new user();
$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];
$clientid=$_POST['clientid']; 
$filename=$_FILES["file"]["tmp_name"];
$res1 = $userObj->emportEmpProcess($comp_id);
/*  $sql1 = "select mast_deduct_heads_id from mast_deduct_heads where (deduct_heads_name LIKE 'P.F.' OR deduct_heads_name LIKE 'E.S.I.' OR deduct_heads_name LIKE 'PROF. TAX' OR deduct_heads_name LIKE 'L.W.F.') and comp_id ='".$comp_id."' GROUP by deduct_heads_name"; 
$res1 = mysql_query($sql1);*/

$headid = array();
while($row111 = $res1->fetch_assoc()){
	$headid[] = $row111['mast_deduct_heads_id'];
}
 $pfid = $headid[0];
 $esiid = $headid[1];
 $proftaxid = $headid[2];
 $lwfid = $headid[3];
	if($_FILES["file"]["size"] > 0)
	{
       $count=0;  
		$file = fopen($filename, "r");
	    while ($emapData = fgetcsv($file, 10000, ","))
	    {
			if($count!=0){
        
                

				$dept = addslashes($emapData[12]);
             //  ECHO "   <br>dept ";
         		 	   $dept_id=$userObj->getDeptId($dept,$comp_id);


 			   $qualif = addslashes($emapData[13]);
		echo "   <br>***Qualif ";
            $qualif_id=$userObj->getQualifId($qualif,$comp_id);

                
				//echo $emapData[24];
				//echo  "$$$";
				echo $desg = addslashes($emapData[24]);
	//echo "  <br> ***designation ";
				if ($clientid == 12 || $clientid == 13 || $clientid == 14 || $clientid == 15 || $clientid == 16){
					echo $pos = strpos($desg,"-"); echo "  **  ";
				   echo  $desg = substr($emapData[24],0,$pos+1);
echo "<br>"				   ;
				}
			//	echo  "*****".$desg." <br>";
				//echo $comp_id." <br>";
                   $desg_id=$userObj->getDesgIdNew($desg,$comp_id);
				 
				
	 
				 if($emapData[16]==""){$bank ='280';}else{
				echo $bank = addslashes($emapData[16]);
				echo "    bank - ";
				  $bank_id=$userObj->getBankId($bank,$comp_id);
				 }
				  
				  print_r($emapData);
				   echo "hello".$emapData[4]."hello"; 
				   if($emapData[4]!="" && $emapData[4]!=" "){
					 $empdata4 = date('Y-m-d', strtotime(str_replace('/', '-', $emapData[4])));
				   }else{
					   $empdata4 = "0000-00-00";
				   }
				   if($emapData[5]!="" && $emapData[5]!=" "){
					 $empdata5 = date('Y-m-d', strtotime(str_replace('/', '-', $emapData[5])));
				   }else{
					   $empdata5 = "";
				   }
				   if($emapData[6]!="" && $emapData[6]!=" "){
					 $empdata6 = date('Y-m-d', strtotime(str_replace('/', '-', $emapData[6])));
				   }else{
					   $empdata6 = "0000-00-00";
				   }
				   if($emapData[7]!="" && $emapData[7]!=" "){
					 $empdata7 = date('Y-m-d', strtotime(str_replace('/', '-', $emapData[7])));
				   }else{
					   $empdata7 = "0000-00-00";
				   }
				   if($emapData[8]!="" && $emapData[8]!=" "){
					 $empdata8 = date('Y-m-d', strtotime(str_replace('/', '-', $emapData[8])));
				   }else{
					   $empdata8 = "0000-00-00";
				   }
				 //$emapData[4] = date('Y-m-d', strtotime(str_replace('/', '-', $emapData[4])));
       
if($emapData[1] !="" && $emapData[1] !=" "){
echo $empid = $userObj->getImportInsertEmployee($comp_id,$user_id,$emapData[0],$emapData[1],$emapData[2],$emapData[3],$empdata4,$empdata5,$empdata6,$empdata7,$empdata8,$emapData[9],'Y',$emapData[11],$dept_id,$qualif_id,$emapData[14],$emapData[15],$bank_id,$emapData[17],$emapData[18],$emapData[19],$emapData[20],$emapData[21],$emapData[22],$emapData[23],$desg_id,$clientid);
/* echo $sql = "INSERT INTO  `employee`(`comp_id`, `user_id`,`first_name`,`middle_name`,`last_name`,`gender`,`bdate`,`joindate`,`due_date`,`leftdate`,`pfdate`,`pfno`,`esistatus`,`esino`,`dept_id`,`qualif_id`,`mobile_no`,`pay_mode`,`bank_id`,`bankacno`,`comp_ticket_no`,`panno`,`adharno`,`uan`,`married_status`,emp_add1,desg_id,client_id) VALUES ('" .$comp_id  . "','" . $user_id . "','".addslashes($emapData[0])."','".addslashes($emapData[1])."','".addslashes($emapData[2])."',
'".addslashes($emapData[3])."','".$empdata4."','".$empdata5."','".$empdata6."',
'".$empdata7."','".$empdata8."','".addslashes($emapData[9])."','Y','".addslashes($emapData[11])."','".$dept_id."','".$qualif_id."','".addslashes($emapData[14])."','".addslashes($emapData[15])."','".$bank_id."','".addslashes($emapData[17])."',
'".addslashes($emapData[18])."','".addslashes($emapData[19])."','".addslashes($emapData[20])."','".addslashes($emapData[21])."','".addslashes($emapData[22])."','".addslashes($emapData[23])."','".$desg_id."' ,'".$clientid."')";

$result = mysql_query($sql);*/




/* $sqlpf = "insert into emp_deduct(comp_id,emp_id,user_id,head_id,calc_type,std_amt) values('".$comp_id."','".$empid."','".$user_id."','".$pfid."',7,0) ";
$respf = mysql_query($sqlpf);*/
$respf = $userObj->getImportEmployeeDeduct($comp_id,$empid,$user_id,$pfid);

 /*$sqlesi = "insert into emp_deduct(comp_id,emp_id,user_id,head_id,calc_type,std_amt) values('".$comp_id."','".$empid."','".$user_id."','".$esiid."',7,0) ";
$respf = mysql_query($sqlesi);*/
$respf = $userObj->getImportEmployeeDeduct1($comp_id,$empid,$user_id,$esiid);
//echo "<br>";
/* $sqlpt = "insert into emp_deduct(comp_id,emp_id,user_id,head_id,calc_type,std_amt) values('".$comp_id."','".$empid."','".$user_id."','".$proftaxid."',7,0) ";
$respf = mysql_query($sqlpt);*/

$userObj->getImportEmployeeDeduct2($comp_id,$empid,$user_id,$proftaxid);

/* $sqlpt = "insert into emp_deduct(comp_id,emp_id,user_id,head_id,calc_type,std_amt) values('".$comp_id."','".$empid."','".$user_id."','".$lwfid."',7,0) ";
 
$respf = mysql_query($sqlpt);*/

$userObj->getImportEmployeeDeduct3($comp_id,$empid,$user_id,$lwfid);
//                echo '<br/>';

}
			}
			$count++;
	    } 

		
	    fclose($file);

/*if($count>1)
		{
			echo "<script type=\"text/javascript\">
					alert(\"CSV File has been successfully Imported.\");
 				window.location = \"import-emp.php\"
				</script>";
			
		}*/
		
	}	
?>
