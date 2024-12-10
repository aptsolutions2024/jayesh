<?php
session_start();
error_reporting(0);
/*ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', dirname(__FILE__) . '/error_log.txt');
error_reporting(E_ALL);*/
$month=$_SESSION['month'];
$clientid=$_SESSION['clientid'];
$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];
$eid = $_REQUEST['eid'];

//include("../lib/connection/db-config.php");
include("../lib/class/user-class.php");
include("../lib/class/admin-class.php");
$userObj=new user();
$adminObj=new admin();
$res=$userObj->showEmployeereport($comp_id,$user_id);
$resclt=$userObj->displayClient($clientid);
$resemp =$userObj->showEployeedetails($eid,$comp_id,$user_id);

$cmonth=$resclt['current_month'];
    $tab_days='hist_days';
    $tab_emp='hist_employee';
    $tab_empinc='hist_income';
    $tab_empded='hist_deduct';
    $tab_adv='hist_advance';	

	$period =  date('F Y',strtotime($_SESSION['frdt']))." TO ". date('F Y',strtotime($_SESSION['todt']));

  $frdt=date("Y-m-d", strtotime($_SESSION['frdt']));
  $todt=date("Y-m-d", strtotime($_SESSION['todt']));
	
	$frdt =$userObj->getLastDay($frdt);
    $todt =	$userObj->getLastDay($todt);
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
                margin-left: 70px;
            }

        }

        @media all {
            #watermark {
                display: none;

                float: right;
            }
		@page {
   
				margin: 27mm 16mm 27mm 16mm;
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
.withoutbord table, .withoutbord td,.withoutbord tr,.withoutbord{border:0 !important}
    </style>
</head>
<body>
<div class="btnprnt">
    <button class="submitbtn" onclick="myFunction()">Print</button>
    <button class="submitbtn"  onclick="history.go(-1);" >Cancel</button>
</div>
<div class="clear" style="clear:both;"></div>
<div class="page-bk">
  <div class="row body page">

      <div class="twelve" align="center">
      <h6> (For Unexempted establishment only )  </h6><h2>                        Form No.3-A (Revised)  </h2>
	  <h6> EMPLOYEES' PROVIDENT FUND SCHEME, 1952( PARAS, 35 AND 42 ) AND</h6>
	  <h6> THE EMPLOYEES' FAMILY PENSION SCHEME, 1971( PARA 14 )</h6>
	  
	  <h5> Contribution card for the currency period from <?php  echo date('F Y',strtotime($_SESSION['frdt'])); ?> To <?php echo date('F Y',strtotime($_SESSION['todt'])) ;?> </h5>
	  
	  <br><br>
      </div>
<table width="100%" style= "border:0">
	
	<tr>
	<td> 1. Account No. :</td>
	<td> <?php echo $resemp['pfno'];?></td>
	<td> 4. Name of the Establishment :</td>
	<td> <?php $res = $userObj->showCompdetailsById($comp_id);
				echo $res['comp_name']."<br>";
				echo $res['addr_1'].' '.$res['addr_2'];?>
				</td>
</tr>
	
<tr>
	<td> 2. Name and Surname :</td>
	<td> <?php echo $resemp['first_name'].' '.$resemp['last_name']; $leftdate  =$resemp['leftdate'] ;?></td>
	<td> 5. Statutory rate of contri.:</td>
	<td> 12 % </td>
</tr>

<tr>
	<td> 3. Middle Name :</td>
	<td> <?php echo $resemp['middle_name'].' '.$resemp['last_name'];?></td>
	<td> 6. Voluntary higher rate of employees' if any :</td>
	<td> NIL </td>
</tr>

	</table>
	<br><br>
	<div align = 'centre'>
<table>
<tr>
<th rowspan = 2>Month (1)</th>
<th rowspan = 2>Wages (2)</th>
<th rowspan = 2>EPF Employee(3) </th>
<th rowspan=2 >EPF - Emplyoer<br>3.67% (4) </th>
<th rowspan = 2>Pension - Emplyoer<br>8.33% (4) </th>
<th rowspan = 2>Refund (5)</th>
<th rowspan = 2>NCP Days (6)</th>
<th rowspan = 2>Remarks (7)</th>
</tr>
<tr>
<!-- content starts -->
<?php

$res = $userObj->getReportForm3A($comp_id,$frdt,$todt,$eid);

$tot_std_amt = 0;
$tot_amount = 0;
$tot_employer_contri_1 = 0;
$tot_employer_contri_2 = 0;

while($row=$res->fetch_assoc())	{ 
	echo "<tr>
	        <td align ='right'>" . date('M Y',strtotime($row['sal_month']))."</td>
			<td align ='right'>".number_format(round($row['std_amt'],0),2,'.',',')."</td>
			<td  align ='right'>".number_format(round($row['amount'],0),2,'.',',')."</td>
			<td align ='right'>".number_format(round($row['employer_contri_1'],0),2,'.',',')."</td>
			<td align ='right'>".number_format(round($row['employer_contri_2'],0),2,'.',',')."</td>
			<td></td>
			<td align ='right'>".$row['absent']."</td>
			<td></td></tr>";
			
$tot_std_amt = $tot_std_amt+round($row['std_amt'],0) ;
$tot_amount =$tot_amount+round($row['amount'],0) ;
$tot_employer_contri_1 = $tot_employer_contri_1 +round($row['employer_contri_1'],0) ;
$tot_employer_contri_2 = $tot_employer_contri_2+round($row['employer_contri_2'],0) ;
    }

	echo "<div align = 'centre'><tr>
	        <td  style='text-align:right;'> TOTAL </td>
			<td  align ='right'>".number_format($tot_std_amt,2,'.',',')."</td>
			<td  align ='right'>".number_format($tot_amount,2,'.',',')."</td>
			<td  align ='right'>".number_format($tot_employer_contri_1,2,'.',',')."</td>
			<td  align ='right'>".number_format($tot_employer_contri_2,2,'.',',')."</td>
			<td></td>
			<td></td>
			<td></td></tr>";


?>


</table></div>
<div>
<br>
<br>
    Certified that the difference between  the total of the contributions shown 
	under cols.(3) and (4) of the above  table  and  that  arrived at the total
	wages shown in col.(2) at the prescribed rate is solely due to the rounding
	off of contribution to the nearest rupees under the rules.
	<br>
<br><br>
<table width = "100%" class="withoutbord">
  <tr >
<td>  Date of leaving service : <?php echo  date('d-m-Y',strtotime($leftdate));?></td><td> Reason of Leaving :   </td>
</tr>
<tr>
<td>Dated : </td><td></td>
</tr>


<tr><td></td>
</tr>
<tr><td></td>
</tr>
<tr><td></td>
</tr>
<tr>
<td></td><td><br>SIGNATURE OF EMPLOYER
<br>         (WITH OFFICIAL SEAL)       </td></tr>                                        
</table> 
	
</div>


<script>
    function myFunction() {
        window.print();
    }
</script>


</body>
</html>