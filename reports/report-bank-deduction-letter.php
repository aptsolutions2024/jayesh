<?php
session_start();
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', dirname(__FILE__) . '/error_log.txt');
error_reporting(E_ALL);
//error_reporting(0);
$month=$_SESSION['month'];
$clintid=$_SESSION['clintid'];
$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];
$checkn = $_REQUEST['checkn'];
$checkdate = $_REQUEST['checkdate'];

//include("../lib/connection/db-config.php");
include("../lib/class/user-class.php");
include("../lib/class/admin-class.php");
$adminObj=new admin();

$userObj=new user();
$resclt=$userObj->displayClient($clintid);


	$cmonth=$resclt['current_month'];
	$monthtit =  date('F Y',strtotime($cmonth));
	if($month=='current'){
		$monthtit =  date('F Y',strtotime($cmonth));
		$tab_deduct='tran_deduct';
		$tab_emp='tran_employee';
		$frdt=$cmonth;
		$todt=$cmonth;
	}
	else{
		$tab_deduct='hist_deduct';
		$tab_emp='hist_employee';
		$monthtit =  date('F Y',strtotime($_SESSION['frdt']));
		$frdt=date("Y-m-d", strtotime($_SESSION['frdt']));
	}

    $field = 'sal_month';
	$resbnk=$userObj->selectedBanks_deduct($comp_id,$clintid,$field,$frdt,$tab_emp,$tab_deduct);
	$tcount=mysqli_num_rows($resbnk);


	if($month!=''){
		$reporttitle="DEDUCTION LIST FOR THE MONTH ".strtoupper($monthtit);
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
            .body { padding: 30px; }
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
            $res11 = $userObj->getReportBankDeductionLetter($tab_deduct,$tab_emp,$comp_id,$user_id,$row['mast_bank_id'],$clintid,$frdt);
			/*$sql11 = "select tdd.emp_id,tdd.amount as amount ,e.first_name,e.middle_name,e.last_name,ed.remark from $tab_deduct tdd  inner join emp_deduct ed on ed.emp_id = tdd.emp_id and tdd.bank_id =ed.bank_id inner join $tab_emp te on te.emp_id = tdd.emp_id and te.sal_month = tdd.sal_month inner join employee e on tdd.emp_id = e.emp_id  where te.comp_id ='".$comp_id."' AND te.user_id='".$user_id."' AND tdd.bank_id='".$row['mast_bank_id']."'  and te.client_id = '".$clintid."' and tdd.sal_month = '$frdt' and tdd.amount>0  ORDER BY e.last_name,e.first_name,e.middle_name,e.Joindate ASC";*/
			
			  /*$sql21 = "select sum(tdd.amount) as amount from $tab_deduct tdd inner join $tab_emp te on te.emp_id = tdd.emp_id and te.sal_month = tdd.sal_month where te.comp_id ='".$comp_id."' AND te.user_id='".$user_id."' AND tdd.bank_id='".$row['mast_bank_id']."' and client_id = '".$clintid."'   and tdd.sal_month = '$frdt' ";*/

			$res21 = $userObj->getReportBankDeductionLetter2($tab_deduct,$tab_emp,$comp_id,$user_id,$row['mast_bank_id'],$clintid,$frdt);
			     
				 $reporttitle2 = "DEDUCTION LIST for the  MONTH :".date("M Y",strtotime($frdt));
				 $reporttitle3 = "";
	//$reporttitle3 = " Client : ".$resclt['client_name'];
	
	
   
    //$res11 = mysql_query($sql11);
    //$res21 = mysql_query($sql21);
    $row21=$res21->fetch_assoc();
   $money=round($row21['amount']);
  $stringmoney=$userObj->convertNumberTowords($money);
  $money=number_format($money,2,".",",");
     $ecount=mysqli_num_rows($res11);
   if($ecount!='') {
       ?>

       
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

           <div class="row" width="80%">
               <div>
                   <div>
                       <br/>
                       To,
                   </div>
                   <div>
                       The Branch Manager,
                   </div>
                   <div>
                       <?php echo $row['bank_name']; ?>
                   </div>
                   <div>
                       <?php echo $row['branch']; ?>
                   </div>

                   <div class = "row"><br/> <br/>
                       Dear Sir,
					   <br/> <br/>
					   Sub : Recovery of Loan Installment / dues and remittance there of.
					   <br/> <br/>
					   The following amounts have been deducted from the concerned employees, as per your instructions, from <br> their pay for the month of <?php echo date("M Y",strtotime($frdt)); ?> pn account of their dues towards loan installment.<br> The details of receovery effected are as follows :
					   
                   </div>
                  
                   <div>
				   
				  
				 <!--    <div align="centre" id="tabltit"><table width="80%" ><tr><td align= "center"> <?php //echo $reporttitle2;?></td></tr>
				   <tr><td align= "center"> <?php //echo $reporttitle3;?></td></tr></table></div>
				  -->
				   
                       <br/>
					   
					   <?php $pageno= 1;$cnt = 0;
						?>	 
                       <table width = "90%">
                           <tr>
                                <td class='thheading' width = "10%">Sr.No</td>
                              <td class='thheading'  width = "10%">Emp.Id.</td>
                               <td class='thheading' width = "40%">Name of the employee</td>
                               <td class='thheading' width = "10%">Amount Rs.</td>
                               <td class='thheading' width = "30%">Loan Acno. / Ref No./ Date</td>
                           </tr>
                           <?php
						   $srno = 1;
                           while ($rowemp = $res11->fetch_assoc()) 
						   {
							   $cnt++;
								if (($cnt >20 &&$pageno==1 )||($cnt >35 &&$pageno>1) ) 
								{$cnt=0;
							     $pageno++;
									echo  "<div class = 'page-bk'></div></table> ";
									

									echo"<table width = '90%'>
                           <tr>
                                <td class='thheading' width = '10%'>Sr.No</td>
                              <td class='thheading'  width = '10%'>Emp.Id.</td>
                               <td class='thheading' width = '60%'>Name of the employee</td>
                               <td class='thheading' width = '10%'>Amount Rs.</td>
                           </tr><div class= 'page-bk'>  ";
						 
								 
							 }
						

							   
                               ?>
                               <tr>
			                          <td align = "centre"><?php echo $srno; ?></td>
          				   
                                    <td><?php echo $rowemp['emp_id']; ?></td>
                                   <td><?php echo $rowemp['first_name'] . ' ' . $rowemp['middle_name'] . ' ' . $rowemp['last_name']; ?></td>
                                   <td align= "right"><?php echo number_format($rowemp['amount'],0,".",","); ?></td>
                                   <td align= "left"><?php echo $rowemp['remark']; ?></td>
                               </tr>
							    
                               <?php $srno++;
                           }
                           ?>
						   <tr> <td></td><td></td><td align = "right">TOTAL</td><td align = "right"><?php echo $money; ?> </td><td></td></tr>
                       </table>
                   </div>


               </div>


           </div>

           <br/> <br/>
		   
		    <div class = "row">
                       Enclosed please find Cheque No. -  <?php echo "   ".$checkn."   Dated  :  ".date('d/m/Y' ,strtotime($checkdate))."  "; ?> drawn on  IDBI Bank , F.C.Road,Branch  for Rs. <?php echo $money;  ?>/- ( RUPEES <?php  echo strtoupper($stringmoney); ?> ONLY )<br>in your favour towards remittance of deduction for the <?  echo  $row['bank_name']  ;?> for the above employees.
                   </div>


           <div class="row">
               <div>
			   <br>
                   Kindly acknowledge.
               <br>
               <br>
               </div>


               <div> Thanking you,<br><br>
               
               </div>


               <div> Yours faithfully,</div>
               
               
               <div>
                   For  <?php
                 $co_id=$_SESSION['comp_id'];
                    $rowcomp=$adminObj->displayCompany($co_id);
					
                    echo $rowcomp['comp_name']; ?>
               </div>
			   <br><br><br><br>
               
               
			   <div> PARTNER/AUTHORISED SIGNATORY</DIV>
			   <div class= 'page-bk'></div>
           </div>
           <br/>
       </div>

       <?php
   }
    $count++;
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