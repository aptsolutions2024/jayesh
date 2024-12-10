<?php
session_start();
error_reporting(0);
$month=$_SESSION['month'];
$clintid=$_SESSION['clintid'];
$emp=$_REQUEST['emp'];
$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];
$pay_type = $_REQUEST['pay_type'];
$checkdate= $_REQUEST['checkdate'];
$checkn=$_REQUEST['checkn'];
$checkdate_K= $_REQUEST['checkdate_K'];
$checkn_K=$_REQUEST['checkn_K'];






include("../lib/connection/db-config.php");
include("../lib/class/user-class.php");
$userObj=new user();

include("../lib/class/admin-class.php");
$adminObj=new admin();
$resclt=$userObj->displayClient($clintid);
$frdt=$_SESSION['frdt'];
$frdt=date('Y-m-d',strtotime($frdt));
$sql = "select * from mast_bank where bank_name like '%IDBI%' or bank_name like '%KARAD%'";
$resb21 = mysql_query($sql);

$bank[0]="IDBI";
$bank[1]="KARAD";


$resclt=$userObj->displayClient($clintid);
$cmonth=$resclt['current_month'];
if ($pay_type=="S"){
	if($month=='current'){
		$monthtit =  date('F Y',strtotime($cmonth));
		$tab_emp='tran_employee';
		$frdt=$cmonth;
		}
	else{
		$tab_emp='tran_employee';
		$monthtit =  date('F Y',strtotime($_SESSION['frdt']));
		$frdt=date("Y-m-d", strtotime($_SESSION['frdt']));
	}

	if($month!=''){
		$reporttitle="SALARY FOR THE MONTH ".strtoupper($monthtit);
	}
}

if ($pay_type=="L"){
	
		 $monthtit =  date('d F Y',strtotime($_REQUEST['from_date']));
		$tab_emp='leave_details';
		 $frdt=date("Y-m-d",strtotime($_REQUEST['from_date']));
		 $reporttitle="Leave Payment done on ".strtoupper($monthtit);
	
}
if ($pay_type=="B"){
	$monthtit =  date('My',strtotime($_SESSION['startbonusyear']))." TO " .date('My',strtotime($_SESSION['endbonusyear']));
	$tab_emp='bonus';
	$frdt=date("Y-m-d", strtotime($_SESSION['startbonusyear']));
	$todt=date("Y-m-d", strtotime($_SESSION['endbonusyear']));
	
	$reporttitle="BONUS FOR THE YEAR ".strtoupper($monthtit);
	$desc = "Bonus- ". date('My',strtotime($_SESSION['startbonusyear']))." TO " .date('My',strtotime($_SESSION['endbonusyear']));
  
  
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
	.letterhead{
		font-family:arial;
		 float:right
	}
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

        table, td, th {
            padding: 5px!important;
            border: 1px dotted black!important;
            font-size:12px !important;
            font-family: monospace;

        }
		table#appletter ,table#appletter tr,table#appletter td,#tabltit table,#tabltit tr,#tabltit td {
			border: 0 !important;
		}
				div{padding-right: 20px!important;
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
<?php
$count=0;
//te = tran_employee, e = employee, 
//while($row=mysql_fetch_array($resb21 ))
	for($i=0;$i<2;$i++)

{
   
?>
<div class="page-bk" >
 </div>
<?php

if ($pay_type=="S"){ 
  $sql11 = "select te.emp_id,te.netsalary as amount,e.first_name,e.middle_name,e.last_name,te.bankacno from $tab_emp te inner join employee e on te.emp_id = e.emp_id  inner join mast_bank mb on te.bank_id = mb.mast_bank_id   where (mb.bank_name like '%".$bank[$i]."%' ) and  te.client_id  in ( 12,13,14,15,16) and te.sal_month = '$frdt' and te.netsalary > 0 and te.pay_mode = 'T' ORDER BY te.pay_mode,te.bankacno,e.last_name,e.first_name,e.middle_name,e.joindate ASC";
  
    $sql21 = "select sum(te.netsalary) as amount from $tab_emp te inner join mast_bank mb on te.bank_id = mb.mast_bank_id   where  (mb.bank_name like '%".$bank[$i]."%' )  and te.client_id  in ( 12,13,14,15,16)  and te.sal_month = '$frdt'  and te.pay_mode = 'T'";
     $reporttitle2 = "Salary for the  MONTH :".date("M Y",strtotime($frdt));
				 $reporttitle3 = " Client : Emerson Group";
	}
if ($pay_type=="L"){

	
	$sql11 = "select te.emp_id,te.amount,e.first_name,e.middle_name,e.last_name,te.bankacno from $tab_emp te inner join employee e on te.emp_id = e.emp_id  inner join mast_bank mb on te.bank_id = mb.mast_bank_id   where (mb.bank_name like '%".$bank[$i]."%' ) and  te.client_id  in ( 12,13,14,15,16) and te.payment_date = '$frdt'  and te.amount > 0 and te.pay_mode = 'T' ORDER BY te.pay_mode,te.bankacno,e.last_name,e.first_name,e.middle_name,e.joindate ASC";
  
    $sql21 = "select sum(te.amount) as amount from $tab_emp te inner join mast_bank mb on te.bank_id = mb.mast_bank_id   where  (mb.bank_name like '%".$bank[$i]."%' )  and te.client_id  in ( 12,13,14,15,16)  and te.payment_date >= '$frdt'   and te.pay_mode = 'T'";
 				 $reporttitle2 = "Leave Payment on  :".date("d F Y",strtotime($frdt));
				 $reporttitle3 = " Client : EmersonGroup";
	
}	

if ($pay_type=="B"){ 
	$days = $_SESSION['days'];
   $sql11 = "select te.emp_id,round(te.tot_bonus_amt +te.tot_exgratia_amt,0) as amount,e.first_name,e.middle_name,e.last_name,te.bankacno from $tab_emp te inner join employee e on te.emp_id = e.emp_id  inner join mast_bank mb on te.bank_id = mb.mast_bank_id   where (mb.bank_name like '%".$bank[$i]."%' ) and  te.client_id  in ( 12,13,14,15,16) and te.from_date = '$frdt' and  te.todate = '$todt' and round(te.tot_bonus_amt +te.tot_exgratia_amt,0) > 0 and te.pay_mode = 'T' and  (te.apr_payable_days + te.may_payable_days+te.jun_payable_days+te.jul_payable_days+te.aug_payable_days+te.sep_payable_days+te.oct_payable_days+te.nov_payable_days+te.dec_payable_days+te.jan_payable_days+te.feb_payable_days+te.mar_payable_days) >=$days and e.prnsrno !='Y' ORDER BY te.pay_mode,te.bankacno,e.last_name,e.first_name,e.middle_name,e.joindate ASC";
  $sql21 = "select sum(round(te.tot_bonus_amt +te.tot_exgratia_amt,0)) as amount from $tab_emp te inner join mast_bank mb on te.bank_id = mb.mast_bank_id   inner join employee e on te.emp_id = e.emp_id  where  (mb.bank_name like '%".$bank[$i]."%' )  and te.client_id  in ( 12,13,14,15,16)  and te.from_date = '$frdt' and  te.todate = '$todt'   and te.pay_mode = 'T' and  (te.apr_payable_days + te.may_payable_days+te.jun_payable_days+te.jul_payable_days+te.aug_payable_days+te.sep_payable_days+te.oct_payable_days+te.nov_payable_days+te.dec_payable_days+te.jan_payable_days+te.feb_payable_days+te.mar_payable_days) >=$days and e.prnsrno !='Y' ";
     $reporttitle2 = $reporttitle;
				 $reporttitle3 = " Client : Emerson Group";
	}	
  
    $res11 = mysql_query($sql11);
    $res21 = mysql_query($sql21);
    $row21=mysql_fetch_array($res21);
   $money=round($row21['amount']);
  $stringmoney=$userObj->convertNumberTowords($money);
 // $money=number_format($money,2,".",",");
    $ecount=mysql_num_rows($res11);
   if($ecount!='') {
       ?>
       <div <?php if (3 < $count){ ?>class="page-bk"<?php } ?> >
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
                       To,
                   </div>
                   <div>
				      <?php if ($bank[$i]=="IDBI"){
                       echo "The Branch Manager,"."<br>";
					   echo "IDBI ,F.C.ROAD BRANCH,"."<br>";
					   echo "PUNE"."<br>"; ?>
					   
                   <div><br/>
                       Dear Sir,
                   
					Enclosed please find Cheque No. - <?php echo "     ". $checkn."  Dated : ".date('d-m-Y',strtotime($checkdate))."  for  Rs. ".  number_format($money,2,".",",");  ?>/- ( RUPEES <?php  echo strtoupper($stringmoney); ?> ONLY ) for crediting 
				     <?PHP IF ($pay_type == "S")
					 {	echo " Salary "	;}
                     else if ($pay_type=="L") 				 
					{	echo " Leave Payment "	;}
                     else if ($pay_type=="B") 				 
					{	echo " Bonus "	;}
                     ?>

					to the individual account of the persons shown below.
  
				 
                   </div>
				


				<?php	   }
					  ELSE
						  {
                       echo "Branch Manager,"."<br>";
					   echo "The KARAD URBAN CO-OP BANK LTD"."<br>";
					   echo "TALBHAGH BRANCH"."<br>";?>
					   
					   
                   <div><br/>
                       Dear Sir,
                   </div>
                   <div>
                            Enclosed please find Cheque No. - <?php echo "     ". $checkn."  Dated : ".date('d-m-Y',strtotime($checkdate))."  for  Rs. ".  number_format($money,2,".",",");  ?>/- <br>( RUPEES <?php  echo strtoupper($stringmoney); ?> ONLY )<br>

                       for crediting     <?PHP IF ($pay_type == "S")
					 {	echo " Salary "	;}
                     else if ($pay_type=="L") 				 
					{	echo " Leave Payment "	;}
                     else if ($pay_type=="B") 				 
					{	echo " Bonus "	;}
                     ?>
 to the individual account of the persons shown

                       below.
  
                 
				 
				 
				 
				 
                   </div>
				
					 <?php  }?>
                   </div>
	   <?php $pageno= 1;$cnt = 0;
						?>	 

				   <div align="centre" id="tabltit"><table width="80%" ><tr><td align= "center"  style="font-size:16px!important;"> <?php echo $reporttitle2;?></td></tr>
				   <tr><td align= "center"  style="font-size:16px!important;"> <?php echo $reporttitle3;?></td></tr></table></div>
				   
				   
                       <br/>
					   <table width = "90%">
                           <tr>
                                <td class='thheading'>Sr.No</td>
                              <td class='thheading'>Emp.Id.</td>
                               <td class='thheading'>Name of the employee</td>
                               <td class='thheading'>A/c No.</td>
                               <td class='thheading' align = 'right'>Amount Rs.</td>
                           </tr>
                           <?php
						   $srno = 1;
                           while ($rowemp = mysql_fetch_array($res11)) {
							   
							   	   $cnt++;
								if (($cnt >20 &&$pageno==1 )||($cnt >35 &&$pageno>1) ) 
								{$cnt=0;
							     $pageno++;
									echo  "</div></table> ";
									

									echo"<table width = '90%'>
                           <tr>
                                <td class='thheading'>Sr.No</td>
                              <td class='thheading'>Emp.Id.</td>
                               <td class='thheading'>Name of the employee</td>
                               <td class='thheading'>A/c No.</td>
                               <td class='thheading'>Amount Rs.</td>
                           </tr><div class= 'page-bk'>  ";
						 
								 
							 }
						

							   
                         
							   
							   
							   
                               $sql211 = "select amount from leave_details where emp_id ='".$rowemp['emp_id']."'  ";
                               $res211 = mysql_query($sql211);
                               $row211=mysql_fetch_array($res211);
                               ?>
                               <tr>
			                          <td align = "centre"><?php echo $srno; ?></td>
          				   
                                    <td><?php echo $rowemp['emp_id']; ?></td>
                                   <td><?php echo $rowemp['first_name'] . ' ' . $rowemp['middle_name'] . ' ' . $rowemp['last_name']; ?></td>
                                   <td><?php echo $rowemp['bankacno']; ?></td>
                                   <td align = 'right'><?php echo $salarynet = $rowemp['amount']; //$allsalarynet += $salarynet;?></td>
                               </tr>
							   
                               <?php $srno++;
                           }
                           ?>
						   <tr> <td></td><td></td><td></td><td align = "right">TOTAL</td><td align = 'right'><?php
						   echo number_format($money,2,".",","); ?> </td></tr>
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
                   For  <?php
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
	
	
}


?>
<div class="page-bk" ></div>

<div <?php $count=0;if (3 < $count){ ?>class="page-bk"<?php } ?> >
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
if ($pay_type=="S"){
	$sql11 = "select te.bank_id,sum(te.netsalary) as amount,mb.bank_name,mb.branch,mb.ifsc_code  from $tab_emp te inner join employee e on te.emp_id = e.emp_id  inner join mast_bank mb on te.bank_id = mb.mast_bank_id   where (mb.bank_name like '%KARAD%' ) and  te.client_id  in ( 12,13,14,15,16) and te.sal_month = '$frdt' and te.netsalary > 0 and te.pay_mode = 'T'  group by te.bank_id ORDER BY mb.ifsc_code";
}
if ($pay_type=="L"){
 $sql11 = "select te.bank_id,sum(te.amount) as amount,mb.bank_name,mb.branch,mb.ifsc_code  from $tab_emp te inner join employee e on te.emp_id = e.emp_id  inner join mast_bank mb on te.bank_id = mb.mast_bank_id   where (mb.bank_name like '%KARAD%' ) and  te.client_id  in ( 12,13,14,15,16) and te.payment_date = '$frdt'  and te.amount > 0 and te.pay_mode = 'T'  group by te.bank_id ORDER BY mb.ifsc_code";
}

if ($pay_type=="B"){
 $sql11 = "select te.bank_id,sum(te.tot_bonus_amt+tot_exgratia_amt) as amount,mb.bank_name,mb.branch,mb.ifsc_code  from $tab_emp te inner join employee e on te.emp_id = e.emp_id  inner join mast_bank mb on te.bank_id = mb.mast_bank_id   where (mb.bank_name like '%KARAD%' ) and  te.client_id  in ( 12,13,14,15,16) and te.from_date = '$frdt' and  te.todate = '$todt'   and te.tot_bonus_amt+tot_exgratia_amt > 0 and (te.apr_payable_days + te.may_payable_days+te.jun_payable_days+te.jul_payable_days+te.aug_payable_days+te.sep_payable_days+te.oct_payable_days+te.nov_payable_days+te.dec_payable_days+te.jan_payable_days+te.feb_payable_days+te.mar_payable_days) >=$days  and e.prnsrno !='Y' and te.pay_mode = 'T'  group by te.bank_id ORDER BY mb.ifsc_code";
}
  
    $res11 = mysql_query($sql11);
?>
                   <div> <div>
                   <div>
                       <br/>
                       To,<br>
                       Branch Manager<br>
					   The KARAD URBAN CO-OP BANK LTD;
					   <br>
					    TALBHAGH BRANCH<br>					  
						<br><br>
						
						 Enclosed herewith the cheque <?php echo "     ". $checkn_K."  Dated : ".date('d-m-Y',strtotime($checkdate_K))?>  
						for a consolidated amount of <?php echo number_format($money,2,".",",");?>/-

						(<?php echo  $stringmoney;?>

						drawn in your name for crediting respective branches as shown in the enclosed

						list towards 

						<?PHP IF ($pay_type == "S")
					 {	echo " Salary "	;}
                     else if ($pay_type=="L") 				 
					{	echo " Leave Payment "	;}
                     else if ($pay_type=="B") 				 
					{	echo " Bonus "	;}
                     ?>

						payments of our employees who have SB accounts with above

						mentioned branches.
						

                   </div>
                       <br/>
					   <div>
                       <table width = "80%">
                           <tr>						   
                                <td class='thheading'>Sr.No.</td>
                                <td class='thheading'>Bank Name</td>
                              <td class='thheading'>Branch</td>
                               
                               <td class='thheading' align = 'right'>Amount Rs.</td>
                           </tr>
                           <?php
						   $srno = 1;
                           while ($rowemp = mysql_fetch_array($res11)) {
                               ?>
                               <tr>
			                          <td align = "centre"><?php echo $srno; ?></td>          				   
                                    <td><?php echo $rowemp['bank_name']; ?></td>
                                   <td><?php echo $rowemp['branch'] ; ?></td>                               
                                   <td align = 'right'><?php echo $rowemp['amount']; ?></td>
                               </tr>							   
                               <?php $srno++;
                           }
						     $money=round($row21['amount']);
								$stringmoney=$userObj->convertNumberTowords($money);

                           ?>
						   <tr> <td></td><td></td><td align = "right">TOTAL</td><td align = 'right'><?php echo number_format($money,2,'.',','); ?> </td></tr>
                       </table></div>
                   </div>
<div>
</div>
</div>
</div>
<!-- header end -->
<!-- content end -->

<script>
    function myFunction() {
        window.print();
    }
</script>
</body>
</html>