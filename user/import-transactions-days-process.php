<?php
session_start();
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', dirname(__FILE__) . '/error_log.txt');
//error_reporting(E_ALL);

include("../lib/connection/db-config.php");
include("../lib/class/user-class.php");
$userObj=new user();
$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];
$client_id=addslashes($_POST['client']);


$row1 = $userObj->importTransactionProcess($client_id,$comp_id,$user_id);
$row_cl =$row1->fetch_assoc();
 $client_date = $row_cl['current_month'];
$client_date1 =  date('Y-m-d', strtotime($client_date));
$client_date11 =  date('d-m-Y', strtotime($client_date));
 $client_date = date('d/m/Y', strtotime($client_date));
 $validleave = array('PP','PH','AA','WW','HD','PL','SL','CL');
 //print_r($validleave);
 $resclt=$userObj->displayClient($client_id);
echo  $crmonth=$resclt['current_month'];
  echo "<Br>";
 $endmth = date("d", strtotime($crmonth));

 $emp = array();
$filename=$_FILES["file"]["tmp_name"];
 
	if($_FILES["file"]["size"] > 0)
	{
       $update_count=0;  
	   $insert_count = 0;
	    $count =0;
		$file = fopen($filename, "r");
	    $k=0;
	    //foreach($data as $key => $value)
	    $inemp =0;
		while($emapData = fgetcsv($file, 10000, ","))
	    {
			$i=1;
			if($count!=0){ 
			    print_r($emapData);
					echo $tempdate =  $emapData[2];
					$tempdate = str_replace("/","-",$tempdate);
					if ($client_date1 !=  date('Y-m-d', strtotime($tempdate))) {
					    echo "Invalid month. Cannot import data.";exit;
					}
				//	if($emapData[0] || !$emapData[1] || !$emapData[2] || //!$emapData[3]){ echo "1";
				      $geterror =0;
					   $aa=0;$pp=0;$ww=0;$ph=0;$hd=0;$pl=0;$cl=0;$sl=0;
					     for($j=0; $j<$endmth; $j++ ){  $valiclid = $j+8;
					         echo $emapData[$valiclid]." ";
					         if(!in_array(strtoupper($emapData[$valiclid]),$validleave)){
					             $emp[] = $emapData[0];
					             echo $valiclid ;
					              $geterror =1;
					         }
					         if(strtoupper($emapData[$valiclid]) =="PP"){
					             $pp++;
					         }elseif(strtoupper($emapData[$valiclid]) =="PH"){
					             $ph++;
					         }elseif(strtoupper($emapData[$valiclid] )=="AA"){
					             $aa++;
					         }elseif(strtoupper($emapData[$valiclid] )=="WW"){
					             $ww++;
					         }elseif(strtoupper($emapData[$valiclid]) =="HD"){
					             $pp =$pp+0.5;$aa=$aa+0.5;
					         }elseif(strtoupper($emapData[$valiclid]) =="PL"){
					             $pl++;
					         }elseif(strtoupper($emapData[$valiclid]) =="SL"){
					             $sl++;
					         }elseif(strtoupper($emapData[$valiclid]) =="CL"){
					             $cl++;
					         }
					         
					     }
					     /******* for transaction ******/
					 //   echo "$geterror"." - ".$emapData[0]."<br>";
					     if($geterror !=1){
					         
					         for ($k=$endmth+8;$k<=38;$k++)
					         {
					             $emapData[$k]="-";
					         }
					         
					         //$pmonth = date('Y-m-d',strtotime($emapData[2]));
					         $pmonth = date('Y-m-d', strtotime($tempdate));
    					     $cnt = $resclt=$userObj->checkEmpDaysTran($client_id,$emapData[0],$pmonth);
    			             if($cnt ==0){ echo "11";
    			                $userObj->insertEmpDaysTran($client_id,$emapData[0],$pmonth,$pp,$ph,$aa,$ww,$hd,$pl,$sl,$cl,strtoupper($emapData[4]),strtoupper($emapData[5]),strtoupper($emapData[6]),strtoupper($emapData[7]),strtoupper($emapData[8]),strtoupper($emapData[9]),strtoupper($emapData[10]),strtoupper($emapData[11]),strtoupper($emapData[12]),strtoupper($emapData[13]),strtoupper($emapData[14]),strtoupper($emapData[15]),strtoupper($emapData[16]),strtoupper($emapData[17]),strtoupper($emapData[18]),strtoupper($emapData[19]),strtoupper($emapData[20]),strtoupper($emapData[21]),strtoupper($emapData[22]),strtoupper($emapData[23]),strtoupper($emapData[24]),strtoupper($emapData[25]),strtoupper($emapData[26]),strtoupper($emapData[27]),strtoupper($emapData[28]),strtoupper($emapData[29]),strtoupper($emapData[30]),strtoupper($emapData[31]),strtoupper($emapData[32]),strtoupper($emapData[33]),strtoupper($emapData[34]),strtoupper($emapData[35]),strtoupper($emapData[36]),strtoupper($emapData[37]),strtoupper($emapData[38]),$comp_id,$user_id);
    			                $inemp++;
    			             }else{
    					         $pmonth = date('Y-m-d', strtotime($tempdate));

    			                 $trid=$userObj->getEmpDaysTran($client_id,$emapData[0],$pmonth);
    			                  $userObj->updateEmpDaysTran($client_id,$emapData[0],$pmonth,$pp,$ph,$aa,$ww,$hd,$pl,$sl,$cl,strtoupper($emapData[4]),strtoupper($emapData[5]),strtoupper($emapData[6]),strtoupper($emapData[7]),strtoupper($emapData[8]),strtoupper($emapData[9]),strtoupper($emapData[10]),strtoupper($emapData[11]),strtoupper($emapData[12]),strtoupper($emapData[13]),strtoupper($emapData[14]),strtoupper($emapData[15]),strtoupper($emapData[16]),strtoupper($emapData[17]),strtoupper($emapData[18]),strtoupper($emapData[19]),strtoupper($emapData[20]),strtoupper($emapData[21]),strtoupper($emapData[22]),strtoupper($emapData[23]),strtoupper($emapData[24]),strtoupper($emapData[25]),strtoupper($emapData[26]),strtoupper($emapData[27]),strtoupper($emapData[28]),strtoupper($emapData[29]),strtoupper($emapData[30]),strtoupper($emapData[31]),strtoupper($emapData[32]),strtoupper($emapData[33]),strtoupper($emapData[34]),strtoupper($emapData[35]),strtoupper($emapData[36]),strtoupper($emapData[37]),strtoupper($emapData[38]),$trid,$comp_id,$user_id);
    			                  $inemp++;
    			             }
					     }
					   /******* end for transaction ******/
			    
				//	}
				$i++;
			}
			$count++;
			$k++;
	    }
	//	print_r($emp); 
		$arrayempval = array_count_values($emp);
		//print_r(array_diff($emp, array_unique($emp)));
		//exit;
		//print_r(array_unique($emp)); exit;
	    fclose($file);
	    $html='';
		foreach ($arrayempval as $key => $value){
		    $html .= "Empid ".$key." invalid field count is ".$value."| "."";
		}
		//exit;
		//if($count>1)
		//{
		//	echo "<script type=\"text/javascript\">
			       
		//			alert(\"CSV File has been successfully Imported.". $inemp ." records inserted.".$update_count." records have been updated. ".$html." \");
 		//		window.location = \"/import-transactions-days\"
		//		</script>";
			
	//	}
		
	}	
?>
