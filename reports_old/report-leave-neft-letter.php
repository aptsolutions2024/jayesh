<?php
session_start();
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', dirname(__FILE__) . '/error_log.txt');
error_reporting(E_ALL);

//error_reporting(E_All);
$pay_type =$_REQUEST['pay_type'];
$month=$_SESSION['month'];
$clintid=$_SESSION['clintid'];
$emp=$_REQUEST['emp'];
$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];
$checkdate= $_REQUEST['checkdate'];
$checkn=$_REQUEST['checkn'];

//include("../lib/connection/db-config.php");
include("../lib/class/user-class.php");
include("../lib/class/admin-class.php");

$userObj=new user();
$adminObj=new admin();


//$res=$userObj->showEmployeereport($comp_id,$user_id);
$resclt=$userObj->displayClient($clintid);
$cmonth=$resclt['current_month'];
if ($comp_id ==1)
	{$comp = "IMCON";}
else 
	{$comp = "ICS";}


   if ($clintid == 12 || $clintid == 13 || $clintid == 14 || $clintid == 15 || $clintid == 16)
{
$clintid = "12,13,14,15,16";
}


if ($pay_type == 'S'){
	$monthtit =  date('M Y',strtotime($cmonth));
	if($month=='current'){
		$monthtit =  date('M Y',strtotime($cmonth));
		$tab_emp='tran_employee';
		$frdt=$cmonth;
		$todt=$cmonth;
	}
	else{
		$tab_emp='hist_employee';
		$monthtit =  date('M Y',strtotime($_SESSION['frdt']));
		$frdt=date("Y-m-d", strtotime($_SESSION['frdt']));
		$todt=date("Y-m-d", strtotime($_SESSION['frdt']));
	}
$reporttitle="";
	if($month!=''){
		$reporttitle="SALARY FOR THE MONTH ".strtoupper($monthtit);
	}
   $desc = "SAL. ".$monthtit;
   $res11 = $userObj->getReportLeaveNeft($desc,$comp,$tab_emp,$comp_id,$clintid,$frdt);
     /*$sql11= "SELECT te.netsalary as amount,mc.bankacno as bankacno,mc.comp_name,mb.ifsc_code,te.bankacno as beneficiary_acno ,'10' as type,concat(e.first_name,' ',e.middle_name,' ',e.last_name) AS name, e.pin_code,'".$desc ."' as descri, '".$comp."' as Originator from $tab_emp te inner join employee e on te.emp_id = e.emp_id inner join mast_bank mb on mb.mast_bank_id = te.bank_id inner join mast_company mc on mc.comp_id = te.comp_id where te.comp_id  in (".$comp_id.")  AND  te.client_id  in (".$clintid.") and te.sal_month = '$frdt' and te.netsalary > 0 and te.pay_mode = 'N' ORDER BY te.bank_id, te.Client_id,te.bankacno,e.last_name,e.first_name,e.middle_name,e.Joindate ASC";
  
				 $reporttitle2 = "Salary for the  MONTH :".date("M Y",strtotime($frdt));
				 $reporttitle3 = " Client : ".$resclt['client_name'];
				
        if ($clintid == "12,13,14,15,16")
        {
        	$reporttitle3 = " Client : EMERSON GROUP ";
        }

				 $res11 = mysql_query($sql11);*/
    $ecount=mysqli_num_rows($res11);

	/*$sql21 = "select sum(te.netsalary) as totamount from $tab_emp te  where comp_id ='".$comp_id."' AND user_id='".$user_id."'  and client_id in  (".$clintid.")   and te.sal_month = '$frdt'  and te.pay_mode = 'N' ";
    $res21 = mysql_query($sql21);*/
    $res21 = $userObj->getSumReportLeaveNeft($tab_emp,$comp_id,$user_id,$clintid,$frdt);
    $row21=$res21->fetch_assoc();

	$money=round($row21['totamount']);
	$stringmoney=$userObj->convertNumberTowords($money);
 	$reporttitle2 = "Salary for the  MONTH :".date("M Y",strtotime($frdt));
	$reporttitle3 = " Client : ".$resclt['client_name'];
    
	
    
  
  
  
}

if ($pay_type == 'L'){
	 $payment_date = $_REQUEST['payment_date'];
	$desc = "Leave Payment";
	$monthtit = "Leave Payment done on ". date('d F Y',strtotime($payment_date));
	$tab_emp='leave_details';
	

	$reporttitle="Leave Payment done on ". date('d F Y',strtotime($payment_date));
	$frdt=date("Y-m-d", strtotime($_SESSION['frdt']));
	$payment_date=date("Y-m-d", strtotime($payment_date));
	$res11 = $userObj->getSumReportLeavPaymenteNeft1($desc,$comp,$comp_id,$clintid,$payment_date);
     /*$sql11= "SELECT te.amount as amount,mc.bankacno as bankacno,mc.comp_name,mb.ifsc_code,te.bankacno as beneficiary_acno ,'10' as type,concat(e.first_name,' ',e.middle_name,' ',e.last_name) AS name, e.pin_code,'".$desc ."' as descri, '".$comp."' as Originator from leave_details te  inner join employee e on te.emp_id = e.emp_id inner join mast_bank mb on mb.mast_bank_id = te.bank_id inner join mast_company mc on mc.comp_id = te.comp_id where te.comp_id ='".$comp_id."' AND   te.client_id in  (".$clintid.") and te.payment_date = '$payment_date' and te.amount > 0 and te.pay_mode = 'N'  ORDER BY te.bank_id, te.Client_id,te.bankacno,e.last_name,e.first_name,e.middle_name,e.Joindate ASC";
  
    $res11 = mysql_query($sql11);*/
    $ecount=mysqli_num_rows($res11);
     /*$res21 = $userObj->getSumReportLeavPaymenteNeft($comp_id,$clintid,$payment_date);
	$sql21 = "select sum(te.amount) as totamount from leave_details te  where comp_id ='".$comp_id."'   and client_id in  (".$clintid.")   and payment_date = '$payment_date' and te.pay_mode = 'N' ";
    $res21 = mysql_query($sql21);*/
    $row21=$res21->fetch_array($res21);

	$money=round($row21['totamount']);
	$stringmoney=$userObj->convertNumberTowords($money);
 				 $reporttitle2 = "Leave Payment on  :". date('d F Y',strtotime($payment_date));
				 $reporttitle3 = " Client : ".$resclt['client_name'];

	}
	
	if ($pay_type == 'B'){
	//$_SESSION['startbonusyear']
	
	   $days = $_SESSION['days'];
	 $monthtit =  date('My',strtotime($_SESSION['startbonusyear']))." TO " .date('My',strtotime($_SESSION['endbonusyear']));
	$tab_emp='bonus';
	$frdt=date("Y-m-d", strtotime($_SESSION['startbonusyear']));
	$todt=date("Y-m-d", strtotime($_SESSION['endbonusyear']));
	
	$reporttitle="BONUS FOR THE YEAR ".strtoupper($monthtit);
	$desc = "Bonus- ". date('y',strtotime($_SESSION['startbonusyear']))."-" .date('y',strtotime($_SESSION['endbonusyear']));
  
  $res11 = $userObj->getbonueReportLeaveAmt($desc,$comp,$tab_emp,$comp_id,$clintid,$frdt,$todt,$days,$resclt['client_name'],$reporttitle);
     /*$sql11= "SELECT round(te.tot_bonus_amt +te.tot_exgratia_amt,0) as amount,mc.bankacno as bankacno,mc.comp_name,mb.ifsc_code,te.bankacno as beneficiary_acno ,'10' as type,concat(e.first_name,' ',e.middle_name,' ',e.last_name) AS name, e.pin_code,'".$desc ."' as descri, '".$comp."' as Originator from $tab_emp te inner join employee e on te.emp_id = e.emp_id inner join mast_bank mb on mb.mast_bank_id = te.bank_id inner join mast_company mc on mc.comp_id = te.comp_id where te.comp_id ='".$comp_id."'   and te.client_id in  (".$clintid.") and te.from_date = '$frdt' and  te.todate = '$todt' and round(te.tot_bonus_amt +te.tot_exgratia_amt,0) > 0 and te.pay_mode = 'N'  and  (te.apr_payable_days + te.may_payable_days+te.jun_payable_days+te.jul_payable_days+te.aug_payable_days+te.sep_payable_days+te.oct_payable_days+te.nov_payable_days+te.dec_payable_days+te.jan_payable_days+te.feb_payable_days+te.mar_payable_days) >=$days and e.prnsrno !='Y' ORDER BY te.bank_id, te.Client_id,te.bankacno,e.last_name,e.first_name,e.middle_name,e.Joindate ASC";
  */
	$reporttitle2 = $reporttitle;
	$reporttitle3 = " Client : ".$resclt['client_name'];


/*	$res11 = mysql_query($sql11);*/
    $ecount=mysqli_num_rows($res11);
$res21 = $userObj->getSumLeaveNeftLetter($comp_id,$user_id,$clintid,$frdt,$todt,$days,$tab_emp);
	 /*$sql21 = "select sum(round(te.tot_bonus_amt +te.tot_exgratia_amt,0) ) as totamount from $tab_emp te    inner join employee e on te.emp_id = e.emp_id where te.comp_id ='".$comp_id."' AND te.user_id='".$user_id."'   and client_id in  (".$clintid.")   and te.from_date = '$frdt' and  te.todate = '$todt'  and te.pay_mode = 'N'  and  (te.apr_payable_days + te.may_payable_days+te.jun_payable_days+te.jul_payable_days+te.aug_payable_days+te.sep_payable_days+te.oct_payable_days+te.nov_payable_days+te.dec_payable_days+te.jan_payable_days+te.feb_payable_days+te.mar_payable_days) >=$days  and e.prnsrno !='Y'";
    $res21 = mysql_query($sql21);*/
    $row21=$res21->fetch_array();

	$money=round($row21['totamount']);
	$stringmoney=$userObj->convertNumberTowords($money);
 	
	
    
  
  
  
}


$_SESSION['client_name']=$resclt['client_name'];
$_SESSION['reporttitle']=$reporttitle;

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

            /*display: block;*/
            page-break-after: always;
            z-index: 0;

        }


        table {
            border-collapse: collapse;
            width: 100%;

        }
			table#appletter ,table#appletter tr,table#appletter td,#tabltit table,#tabltit tr,#tabltit td {
			border: 0 !important;
		}
	

        table, td, th {
            padding: 5px!important;
            border: 1px dotted black!important;
            font-size:12px !important;
            font-family: monospace;

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
                display:none!important;
            }
            .body { padding: 10px; }
            body{
                margin-left: 50px;
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

                display:none!important;

            }
            #footer {
                display:none!important;
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


<?php
	$count=0;
   if($ecount!='') {
	   
	
	   
?>
       <div > 
           <div class="row">
               <div>
                   <div>
                       <br/>
                       To,
                   </div>
                   <div>
   				      <?php 
						echo "The Branch Manager,"."<br>";
						echo "IDBI ,F.C.ROAD,"."<br>";
						echo "PUNE"."<br>";
					  ?>

                   </div>
                </div>

				<div>
					<br/> 
					<br/>
                       Dear Sir,
                </div>
                <div>
                                  Enclosed please find Cheque No. - <?php echo "     ". $checkn."  Dated : ".date('d-m-Y',strtotime($checkdate))."  for  Rs. ".  number_format($money,2,".",",");  ?>/- <br>( RUPEES <?php  echo strtoupper($stringmoney); ?> ONLY )<br>

                       for crediting salary to the individual account of the persons shown

                       below.
           
                </div>
		   
		   
	
				   <div align="centre" id="tabltit" style="font-size:18px!important;"><table width="80%" ><tr><td align= "center" style="font-size:16px!important;"> <?php echo $reporttitle2;?></td></tr>
				   <tr><td align= "center" style="font-size:16px!important;"> <?php echo $reporttitle3;?></td></tr></table></div>
				   
				   			   
			    

		   <div>
                    <br/>
                    <table width = "90%">
                        <tr>
					           <th >Net Salary</th>
                               <th >Senders AcNo</th>
                               <th >IFSC Code</th>
                               <th>Beneficiary AcNo</th>
                               <th>A/c Type</th>
							   <th>Emp. Name</th>
							   
                               <th>Bene. Add.</th>
							   <th>Information</th>
							   <th>Originator of Remi.</th>
                        </tr>
                           <?php $pageno= 1;$cnt = 0;
							 

						   while ($rowemp = $res11->fetch_assoc()) {
							   
							    $cnt++;
								if (($cnt >15 &&$pageno==1 )||($cnt >22 &&$pageno>1) ) 
								{$cnt=0;
							     $pageno++;
									echo  "</table> <div class= 'page-bk'></div>";
									

									echo"<table width = '90%'>
                           <tr>
<th >Net Salary</th>
                               <th >Senders AcNo</th>
                               <th >IFSC Code</th>
                               <th>Beneficiary AcNo</th>
                               <th>A/c Type</th>
							   <th>Emp. Name</th>
							   
                               <th>Bene. Add.</th>
							   <th>Information</th>
							   <th>Originator of Remi.</th>
                           </tr><div class= 'page-bk'></div>  ";
						 
							
							 }
						?>
							   
							   
                               <tr>

							   
						        <td align="right"><?php echo number_format($rowemp['amount'],2,".",",")?></td>
								<td><?php echo $rowemp['bankacno']?></td>
								<td><?php echo $rowemp['ifsc_code']?></td>
								<td><?php echo $rowemp['beneficiary_acno']?></td>
								
								<td><?php echo $rowemp['type']?></td>
							    <td><?php echo $rowemp['name']; ?></td>
							   <td><?php echo $rowemp['pin_code'] ; ?></td>
							   <td><?php echo  $rowemp['descri']; ?></td>
                               <td><?php echo $comp; ?></td>
                               </tr>
							   
                               <?php 
                           }
                           ?>
						   <tr> <td align="right"><?php echo number_format($money,2); ?> </td></tr>
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
                   For  <?php echo $comapnydtl['comp_name']; ?>
               </div>
			   <br><br><br><br>
               
               
			   <div> PARTNER/AUTHORISED SIGNATORY</DIV>
           </div>
           <br/>
       </div>

       <?php
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