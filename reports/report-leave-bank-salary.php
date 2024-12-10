<?php
session_start();
/*ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', dirname(__FILE__) . '/error_log.txt');
error_reporting(E_ALL);*/


//error_reporting(0);
$month=$_SESSION['month'];
$clintid=$_SESSION['clintid'];
$emp=$_REQUEST['emp'];
$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];
$pay_type=$_REQUEST['pay_type'];
$checkdate= $_REQUEST['checkdate'];
$checkn=$_REQUEST['checkn']; 
if(isset($_REQUEST['sakal_type'])){
$sakal_type =  $_REQUEST['sakal_type'];
}else{
   $sakal_type =""; 
}


//include("../lib/connection/db-config.php");
include("../lib/class/user-class.php");


include("../lib/class/admin-class.php");
$adminObj=new admin();
$userObj=new user();
$resclt=$userObj->displayClient($clintid);
if ($clintid == 12 || $clintid == 13 || $clintid == 14 || $clintid == 15 || $clintid == 16)
{
$clintid = "12,13,14,15,16";
}

if ($sakal_type =='Yes')
{
$clintid = "7,8,9,17,23,24";
	
}
if ($pay_type=="S"){
	$cmonth=$resclt['current_month'];
	$monthtit =  date('F Y',strtotime($cmonth));
	if($month=='current'){
		$monthtit =  date('F Y',strtotime($cmonth));
		$tab_emp='tran_employee';
		$frdt=$cmonth;
		$todt=$cmonth;
	}
	else{
		$tab_emp='hist_employee';
		$monthtit =  date('F Y',strtotime($_SESSION['frdt']));
		$frdt=date("Y-m-d", strtotime($_SESSION['frdt']));
	}

    $field = 'sal_month';
	$resbnk=$userObj->selectedBanks($comp_id,$clintid,$field,$frdt,$tab_emp);
	
  $tcount=mysqli_num_rows($resbnk);


	if($month!=''){
		$reporttitle="SALARY FOR THE MONTH ".strtoupper($monthtit);
	}
	$_SESSION['client_name']=$resclt['client_name'];
	$_SESSION['reporttitle']=$reporttitle;

}
if ($pay_type=="L"){
		$tab_emp='leave_details';
		$payment_date=$_REQUEST['payment_date'];
		$monthtit =  date('d F Y',strtotime($payment_date));
		$frdt=date("Y-m-d", strtotime($payment_date));


    $field = 'payment_date';
	$resbnk=$userObj->selectedBanks($comp_id,$clintid,$field,$frdt,$tab_emp);
	
	$tcount=mysqli_num_rows($resbnk);


	if($month!=''){
		$reporttitle="Leave Payment done on ".strtoupper($monthtit);
	}
	$_SESSION['client_name']=$resclt['client_name'];
	$_SESSION['reporttitle']=$reporttitle;
	
}

if ($pay_type=="B"){
	$days = $_SESSION['days'];
	$monthtit =  date('My',strtotime($_SESSION['startbonusyear']))." TO " .date('My',strtotime($_SESSION['endbonusyear']));
	$tab_emp='bonus';
	$frdt=date("Y-m-d", strtotime($_SESSION['startbonusyear']));
	$todt=date("Y-m-d", strtotime($_SESSION['endbonusyear']));
	
	$reporttitle="BONUS FOR THE YEAR ".strtoupper($monthtit);
	$desc = "Bonus- ". date('My',strtotime($_SESSION['startbonusyear']))." TO " .date('My',strtotime($_SESSION['endbonusyear']));
	$_SESSION['client_name']=$resclt['client_name'];
	$_SESSION['reporttitle']=$reporttitle;
  
	$field = 'sal_month';
	$resbnk =$userObj->reportLeaveBankSalay($tab_emp,$comp_id,$clintid,$frdt,$todt);
/*	$sql = "select distinct bank_id, mb.* from $tab_emp te inner join mast_bank mb on te.bank_id = mb.mast_bank_id where te.comp_id = '$comp_id' and  te.client_id in ($clintid) and te.from_date = '$frdt' and  te.todate = '$todt'  order by mb.bank_name ";  

    $resbnk = mysql_query($sql);*/
	
	 $tcount=mysqli_num_rows($resbnk);
 
}
?>

<!DOCTYPE html>

<html lang="en-US">
<head>
    <meta charset="utf-8"/>
    <title> &nbsp;</title>
    <!-- Included CSS Files -->
    <link rel="stylesheet" href="../css/responsive.css">
    <link rel="stylesheet" href="../css/style.css">
    <style>
        .thheading{
            text-transform: uppercase;
            font-weight: bold;
            background-color: #fff;
        }
        .heading{
            margin: 10px 20px;
        }
        .btnprnt{
            margin: 10px 20px;
        }
        .page-bk {
            position: relative;

            display: block;
            page-break-after: always;
            z-index: 0;
        }
        table, td, th {
            padding: 5px!important;
            border: 1px dotted black!important;
            font-size:13px !important;
            font-family: monospace;

        }
		table#appletter ,table#appletter tr,table#appletter td,#tabltit table,#tabltit tr,#tabltit td {
			border: 0 !important;
		}
		
		div{padding-right: 20px!important;padding-left: 20px!important;
            }
        @media print
        {
            .btnprnt{display:none}
            .header_bg{
                background-color:#7D1A15;
                border-radius:0px;
            }
            .heade{
                color: #fff!important;
            }
            #header, #footer {
                display:none!important;
            }
            #footer {
					height:50px;
                display:none!important;
            }
            .body { padding: 10px; }
            body{
                margin-left: 70px;
            }
        }

        @media all {
            #watermark {
                display: none;

                float: right;
            }

            .pagebreak {
                display: none;
            }

            #header, #footer {

                display:block!important;

            }
            #footer {
			
                display:block!important;
            }
        }
    </style>
</head>
<body>
<div class="btnprnt">
    <button class="submitbtn" onclick="myFunction()">Print</button>
    <button class="submitbtn"  onclick="history.go(-1);" >Cancel</button>
</div>
<!-- header starts -->
<?php
$count=0;
//te = tran_employee, e = employee, 
while($row=$resbnk->fetch_assoc()){
   if ($pay_type =="S"){
	  
$sql11 = $userObj->reportLeaveBankSalaryPayT($tab_emp,$comp_id,$user_id,$row['mast_bank_id'],$clintid,$frdt);
		
 			  
			$sql21 = $userObj->reportLeaveBankSalaryPayT2($tab_emp,$comp_id,$user_id,$row['mast_bank_id'],$clintid,$frdt);
			
			
				 $reporttitle2 = "Salary for the  MONTH : ".date("M Y",strtotime($frdt));
		$reporttitle3 = " Client : ".$resclt['client_name'];
       
   }
	
	
   if ($pay_type =="L"){
		/*if ($clintid == 12 || $clintid == 13 || $clintid == 14 || $clintid == 15 || $clintid == 16)
		{
			$sql11 = "select te.emp_id,te.amount,e.first_name,e.middle_name,e.last_name,te.bankacno from $tab_emp te inner join employee e on te.emp_id = e.emp_id  where te.comp_id ='".$comp_id."'  AND te.bank_id='".$row['mast_bank_id']."'  and te.client_id in (12,13,14,15,16) and te.payment_date = '$frdt' and te.amount > 0 and te.pay_mode = 'T' ORDER BY te.bankacno,e.last_name,e.first_name,e.middle_name,e.Joindate ASC";
	
			$sql21 = "select sum(te.amount) as amount from $tab_emp te  where comp_id ='".$comp_id."'   AND bank_id='".$row['mast_bank_id']."' and client_id in (12,13,14,15,16)  and te.payment_date = '$frdt' and te.pay_mode = 'T'";
}
		else{*/
			 /*$sql11 = "select te.emp_id,te.amount,e.first_name,e.middle_name,e.last_name,te.bankacno from $tab_emp te inner join employee e on te.emp_id = e.emp_id  where te.comp_id ='".$comp_id."' AND  te.bank_id='".$row['mast_bank_id']."'  and te.client_id = '".$clintid."' and te.payment_date = '$frdt' and te.amount > 0 and te.pay_mode = 'T' ORDER BY te.bankacno,e.last_name,e.first_name,e.middle_name,e.Joindate ASC";*/
			 
			 $sql11 = $userObj->reportLeaveBankSalaryPayL($tab_emp,$comp_id,$row['mast_bank_id'],$clintid,$frdt);
			
			
			/*$sql21 = "select sum(te.amount) as amount from $tab_emp te  where comp_id ='".$comp_id."'  AND bank_id='".$row['mast_bank_id']."' and client_id = '".$clintid."'   and te.payment_date = '$frdt' and te.pay_mode = 'T'";*/
			
			$sql21 = $userObj->reportLeaveBankSalaryPayL2($tab_emp,$comp_id,$row['mast_bank_id'],$clintid,$frdt);
       
   //}
				 $reporttitle2 = "Leave Payment on  : ".date("d F Y",strtotime($frdt));
				 $reporttitle3 = " Client : ".$resclt['client_name'];
	}



   
   if ($pay_type =="B"){
	   $days = $_SESSION['days'];
	/*	if ($clintid == 12 || $clintid == 13 || $clintid == 14 || $clintid == 15 || $clintid == 16)
		{
			
 		$sql11 = "select te.emp_id,round(te.tot_bonus_amt +te.tot_exgratia_amt,0) as amount ,e.first_name,e.middle_name,e.last_name,te.bankacno from $tab_emp te inner join employee e on te.emp_id = e.emp_id  where te.comp_id ='".$comp_id."'  AND te.bank_id='".$row['mast_bank_id']."'  and te.client_id in (12,13,14,15,16) and te.from_date = '$frdt' and  te.todate = '$todt' and round(te.tot_bonus_amt +te.tot_exgratia_amt,0) > 0 and te.pay_mode = 'T' and  (te.apr_payable_days + te.may_payable_days+te.jun_payable_days+te.jul_payable_days+te.aug_payable_days+te.sep_payable_days+te.oct_payable_days+te.nov_payable_days+te.dec_payable_days+te.jan_payable_days+te.feb_payable_days+te.mar_payable_days) >=$days  and e.prnsrno !='Y' ORDER BY te.bankacno,e.last_name,e.first_name,e.middle_name,e.Joindate ASC";


			 $sql21 = "select sum(round(te.tot_bonus_amt +te.tot_exgratia_amt,0)) as amount from $tab_emp te  inner join employee e on te.emp_id = e.emp_id  where te.comp_id ='".$comp_id."' AND te.bank_id='".$row['mast_bank_id']."' and te.client_id in (12,13,14,15,16) and te.from_date = '$frdt' and  te.todate = '$todt'  and te.pay_mode = 'T' and  (te.apr_payable_days + te.may_payable_days+te.jun_payable_days+te.jul_payable_days+te.aug_payable_days+te.sep_payable_days+te.oct_payable_days+te.nov_payable_days+te.dec_payable_days+te.jan_payable_days+te.feb_payable_days+te.mar_payable_days) >=$days  and e.prnsrno !='Y'";
			
	$reporttitle2="BONUS FOR THE YEAR ".strtoupper($monthtit);
				
				//$reporttitle2 = "Salary for the  MONTH :".date("M Y",strtotime($frdt));
		$reporttitle3 = " Client : Emerson Group";

		}
		else{*/
			/* $sql11 = "select te.emp_id,round(te.tot_bonus_amt +te.tot_exgratia_amt,0) as amount ,e.first_name,e.middle_name,e.last_name,te.bankacno from $tab_emp te inner join employee e on te.emp_id = e.emp_id  where te.comp_id ='".$comp_id."' AND te.user_id='".$user_id."' AND te.bank_id='".$row['mast_bank_id']."'  and te.client_id = '".$clintid."' and te.from_date = '$frdt' and  te.todate = '$todt'  and round(te.tot_bonus_amt +te.tot_exgratia_amt,0) > 0 and te.pay_mode = 'T' and  (te.apr_payable_days + te.may_payable_days+te.jun_payable_days+te.jul_payable_days+te.aug_payable_days+te.sep_payable_days+te.oct_payable_days+te.nov_payable_days+te.dec_payable_days+te.jan_payable_days+te.feb_payable_days+te.mar_payable_days) >=$days and e.prnsrno !='Y' ORDER BY te.bankacno,e.last_name,e.first_name,e.middle_name,e.Joindate ASC";*/
			 
			 $sql11 = $userObj->reportLeaveBankSalaryPayB($tab_emp,$comp_id,$user_id,$row['mast_bank_id'],$clintid,$frdt,$todt,$days);
			
			 /*$sql21 = "select sum(round(te.tot_bonus_amt +te.tot_exgratia_amt,0)) as amount from $tab_emp te   inner join employee e on te.emp_id = e.emp_id  where te.comp_id ='".$comp_id."' AND te.user_id='".$user_id."' AND te.bank_id='".$row['mast_bank_id']."' and te.client_id = '".$clintid."'   and te.from_date = '$frdt' and  te.todate = '$todt'  and te.pay_mode = 'T' and  (te.apr_payable_days + te.may_payable_days+te.jun_payable_days+te.jul_payable_days+te.aug_payable_days+te.sep_payable_days+te.oct_payable_days+te.nov_payable_days+te.dec_payable_days+te.jan_payable_days+te.feb_payable_days+te.mar_payable_days) >=$days and e.prnsrno !='Y'";*/
			 
			 $sql21 = $userObj->reportLeaveBankSalaryPayB2($tab_emp,$comp_id,$user_id,$row['mast_bank_id'],$clintid,$frdt,$todt,$days);
			 
			$reporttitle="BONUS FOR THE YEAR ".strtoupper($monthtit);

			//$reporttitle2 = $reporttitle;
			$reporttitle3 = " Client : ".$resclt['client_name'];
       
   }
	//}
	$res11 =$sql11;
   $res21 =$sql21;
   // $res11 = mysql_query($sql11);
   // $res21 = mysql_query($sql21);
    $row21=$res21->fetch_assoc();
   $money=round($row21['amount']);
  $stringmoney=$userObj->convertNumberTowords($money);
  $money=number_format($money,2,".",",");
    $ecount=mysqli_num_rows($res11);
   if($ecount!='') {
       ?>

       <div <?php if ($tcount > $count){  ?>class="page-bk"<?php } ?> >
	   <div >
    <table width="80%" id="appletter" style="margin:0 auto">
	<thead>
	<tr>
	
	<td align="right"   style="text-align:left">
	<div style=" float:right">
<?php
$comapnydtl = $userObj->showCompdetailsById($comp_id);
 echo $comapnydtl['comp_name'];?>
<?php if($comapnydtl['address'] !=""){ ?><br><?php echo $comapnydtl['address']; } if($comapnydtl['addr_1'] !=""){?><br><?php echo $comapnydtl['addr_1']; } if($comapnydtl['addr_2']!=""){?><br><?php echo $comapnydtl['addr_2']; }?><br>Tel. <?php echo $comapnydtl['tel']; ?><br>Email: <?php echo $comapnydtl['email']; ?>
<br><br>	Date &nbsp; <?php echo date('d/m/Y');?>
	</div></td></tr></thead>
</table></div>

           <div class="row">
               <div>
                   <div>
                       <br/>
                       To,
                   </div>
                   <div>
                       The Branch Manager,
                   </div>
                   <div>
                       <?php if ($clintid == "7,8,9,17,23,24") {echo "IDBI BANK LTD.";} else  { echo $row['bank_name'];} ?>
                   </div>
                   <div>
                       <?php if ($clintid == "7,8,9,17,23,24") {echo " F.C. Road, Pune.";} else { echo $row['branch']; }?>
                   </div>

                   <div><br/> <br/>
                       Dear Sir,
                   </div>
                   <div class = "row">
                           Enclosed please find Cheque No. - <?php echo "     ". $checkn."  Dated : ".date('d-m-Y',strtotime($checkdate))."  for  Rs. ".  $money;  ?>/-<br> ( RUPEES <?php  echo strtoupper($stringmoney); ?> ONLY ) <br>for crediting 

					<?PHP IF ($pay_type == "S")
					 {	echo " Salary "	;}
                     else if ($pay_type=="L") 				 
					{	echo " Leave Payment "	;}
                     else if ($pay_type=="B") 				 
					{	echo " Bonus "	;}
                     ?>						   to the individual account of the persons shown below.
                   </div>

                   <div>
				   
				  
				   <div align="centre" id="tabltit"><table width="80%" ><tr><td align= "center" style="font-size:16px!important;"> <?php echo $reporttitle2;?></td></tr>
				   <tr><td align= "center" style="font-size:16px!important;"> <?php echo $reporttitle3;?></td></tr></table></div>
				   
				   
				   
				   
                       <br/>
					   
					   <?php $pageno= 1;$cnt = 0;
						?>	 
                       <table width = "90%">
                           <tr>
                                <td class='thheading' width = "10%">Sr.No</td>
                              <td class='thheading'  width = "10%">Emp.Id.</td>
                               <td class='thheading' width = "60%">Name of the employee</td>
                               <td class='thheading'  width = "10%">A/c No.</td>
                               <td class='thheading' width = "10%">Amount Rs.</td>
                           </tr>
                           <?php
						   $srno = 1;
						   print_r($res11);
                           while ($rowemp = $res11->fetch_assoc()) 
						   {
							   $cnt++;
								if (($cnt >20 &&$pageno==1 )||($cnt >35 &&$pageno>1) ) 
								{$cnt=0;
							     $pageno++;
									echo  "</div></table> ";?>
								<?php	echo"<table width = '90%'>
                           <tr>
                                <td class='thheading' width = '10%'>Sr.No</td>
                              <td class='thheading'  width = '10%'>Emp.Id.</td>
                               <td class='thheading' width = '60%'>Name of the employee</td>
                               <td class='thheading'  width = '10%'>A/c No.</td>
                               <td class='thheading' width = '10%'>Amount Rs.</td>
                           </tr><div class= 'page-bk'>  ";
                              ?>
                               <tr>
			                          <td align = "centre"><?php echo $srno; ?></td>
          				   
                                    <td><?php echo $rowemp['emp_id']; ?></td>
                                   <td><?php echo $rowemp['first_name'] . ' ' . $rowemp['middle_name'] . ' ' . $rowemp['last_name']; ?></td>
                                   <td><?php echo $rowemp['bankacno']; ?></td>
                                   <td align= "right"><?php echo number_format($rowemp['amount'],2,".",","); ?></td>
                               </tr>
							   
                               <?php $srno++;
                           }
                           ?>
						   <tr> <td></td><td></td><td></td><td align = "right">TOTAL</td><td align = "right"><?php echo $money; ?> </td></tr>
                       </table>
                   </div>


               </div>


           </div>

           <br/> <br/>

           <div class="row">

               <div>
                   Please acknowledge.
               </div>


               <div> Thanking you,</div>


               <div> Yours faithfully,</div>
               
               
               <div>
                   <br>For  <?php
                 $co_id=$_SESSION['comp_id'];
                    $rowcomp=$adminObj->displayCompany($co_id);
					
                    echo $rowcomp['comp_name']; ?>
               </div>
			   <br><br><br><br>
               
               
			   <div> PARTNER/AUTHORISED SIGNATORY</DIV>
           </div>
           <br/>
       </div>

       <?php
   }
    $count++;
	if ($clintid =="7,8,9,17,23,24" && $sakal_type =='Yes')
	{
		BREAK;
	}
}
}

?>

<!-- header end -->
<!-- content end -->

<script>
    function myFunction() {
        window.print();
    }
</script>


</body>
</html>