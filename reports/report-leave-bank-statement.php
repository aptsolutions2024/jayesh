<?php
session_start();

//error_reporting(0);
$month=$_SESSION['month'];
$clintid=$_SESSION['clintid'];
$emp=$_REQUEST['emp'];
$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];

$frdt1=$_REQUEST['from_date'];
$frdt1=date('Y-m-d',strtotime($frdt1));
$to_date=$_REQUEST['to_date'];
$to_date=date('Y-m-d',strtotime($to_date));

include("../lib/connection/db-config.php");
include("../lib/class/user-class.php");
$userObj=new user();
include("../lib/class/admin-class.php");
$adminObj=new admin();

if($month=='current'){
	$resclt=$userObj->displayClient($clintid);
	$cmonth=$resclt['current_month'];
    $monthtit =  date('F Y',strtotime($cmonth));
     $tab_emp='leave_details';
    //$frdt=$cmonth;
   // $todt=$cmonth;
 }
else{
    $monthtit =  date('F Y',strtotime($_SESSION['frdt']));
    $tab_emp='leave_details';

    $frdt=date("Y-m-d", strtotime($_SESSION['frdt']));
    $todt=date("Y-m-d", strtotime($_SESSION['frdt']));
	
	$sql = "SELECT LAST_DAY('".$frdt."') AS last_day";
	$row= mysql_query($sql);
	$res = mysql_fetch_assoc($row);
	$frdt = $res['last_day'];
    $todt = $frdt;  	
 }

 $selbank= "select * from mast_bank where comp_id ='$comp_id'";
$resbank = mysql_query($selbank);
$rowbank = mysql_num_rows($resbank );




if($month!=''){
    $reporttitle="BANK LIST FOR THE MONTH ".$monthtit;
}
$p='';
if($emp=='Parent'){
    $p="(P)";
}

$_SESSION['client_name']=$resclt['client_name'].$p;

$_SESSION['reporttitle']=strtoupper($reporttitle)
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

        table, td, th {
            padding: 5px!important;
            border: 1px dotted black!important;
            font-size:16px !important;
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
			/*@page {
			  size: A4;
			  margin: 0 0 5%;
			  padding: 0 0 10%;
			}*/


			@media print {
			  h3 {
				position: absolute;
				page-break-before: always;
				page-break-after: always;
				bottom: 0;
				right: 0;
			  }
			  h3::before {
				position: relative;
				bottom: -20px;
				counter-increment: section;
				content: counter(section);
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

<!-- header end -->
<!-- content starts -->
<div>
<!--<div class="header_bg">
<?php
//include('printheader.php');
?>
</div>-->
    <div >
    <table width="100%" cellpadding='0' cellspacing='0' style="border:0 !important">
    
	
	<tr>
	<td colspan="5" style="border:0 !important">	
	
<?php 
while($rowb = mysql_fetch_array($resbank)){
	$bid = $rowb['mast_bank_id'];
	if($emp=='Parent'){
	 $selgtemp ="select * 
	 from $tab_emp te inner join employee e on te.emp_id = e.emp_id
	 inner join mast_client mc on te.client_id = mc.mast_client_id 
	 where mc.parentid = '$clintid' and te.bank_id = '$bid' and te.from_date >= '$frdt1' and to_date <='$to_date' order by e.pay_mode,te.bankacno";
	}else {
	 $selgtemp ="select * 
	 from $tab_emp te inner join employee e on te.emp_id = e.emp_id
	 where te.client_id = '$clintid' and te.bank_id = '$bid' and te.from_date >= '$frdt1' and to_date <='$to_date' order by e.pay_mode ,te.bankacno";
	}
	//echo $selgtemp;
	$resgtemp11 = mysql_query($selgtemp);
	$bankrec = mysql_num_rows($resgtemp11);
	if($bankrec !=0){ ?>
<div class="header_bg">
<?php
include('printheader.php');
?>
</div>	
	<div class="page-bk row body" >
	<table width="100%">
	<tr>
	<td colspan="5" align="center">   Bank Statement For <?php echo date('F Y',strtotime($to_date));?><br><?php echo $rowb['bank_name']." (".$rowb['branch'].") IFSC - " .$rowb['ifsc_code']?></td>
	</tr>
	
	<tr>
       <th class="thheading" width="5%">SR.No.      </th>
		<th class="thheading" width="10%">Emp ID.      </th>
		<th class="thheading" width="32">Pay Mode </th>
        <th class="thheading" width="32">NAME OF THE EMPLOYEE </th>
        <th class="thheading" width="30%">A/C No.</th>        
        <th class="thheading" width="15%">NETSALARY Rs. </th>
		
    </tr>
	<?php $srno1=1; $totsal=0;
	while($recall = mysql_fetch_array($resgtemp11)){	
	?>
		<tr>
		<td><?php echo $srno1;?></td>
		<td align="center"><?php echo $recall['emp_id'];?></td>
		<td align="center"><?php if($recall['pay_mode'] == 'T'){echo "Transfer";}else if($recall['pay_mode'] == 'C'){echo "Cheque";}else if($recall['pay_mode'] == 'N'){echo "NEFT";}?></td>
		<td><?php echo $recall['first_name']." ".$recall['middle_name']." ".$recall['last_name']?></td>
		<td align="center"><?php echo $recall['bankacno']; ?></td>
		<td align="right"><?php   $totsal=$totsal+$recall['amount']; echo number_format($recall['amount'],2,".",",");
	?></td>
		</tr>		
<?php $srno1++;
		}
 ?>
		<tr>
		<td colspan="5" style="text-align:right">Total </td>
		<td align="right"> <?php echo number_format($totsal,2,".",","); ?></td>
		</tr>
		

 </table>
 <div><br><br><br> By Cheque No. _____________ dt. ___________  for Rs.<?php echo number_format($totsal,2,".",","); ?></div>
 </div> <?php } 
 }
 ?>
</td>
</tr>

</table>

        </div>
<br/><br/>
    </div>

<!-- content end -->

<script>
    function myFunction() {
        window.print();
    }
</script>


</body></html>