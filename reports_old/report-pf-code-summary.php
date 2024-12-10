<?php
session_start();
//error_reporting(0);
/*ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', dirname(__FILE__) . '/error_log.txt');
error_reporting(E_ALL);*/

$month=$_SESSION['month'];
$clientid=$_SESSION['clientid'];
$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];
$emp=$_REQUEST['emp'];



include("../lib/connection/db-config.php");
include("../lib/class/user-class.php");
$userObj=new user();


include("../lib/class/admin-class.php");
$adminObj=new admin();
$res=$userObj->showEmployeereport($comp_id,$user_id);

$resclt=$userObj->displayClient($clientid);
$cmonth=$resclt['current_month'];
$pfcode =$resclt['pfcode'];

if($month=='current'){
	$monthtit =  date('F Y',strtotime($cmonth));
    $tab_emp='tran_employee';
    $tab_empded='tran_deduct';
    $tab_days = 'tran_days';
	$frdt=$cmonth;
    $todt=$cmonth;
  }
else{
    $monthtit =  date('F Y',strtotime($_SESSION['frdt']));
    $tab_emp='hist_employee';
    $tab_empded='hist_deduct';
	$tab_days = 'hist_days';
	$frdt=date("Y-m-d", strtotime($_SESSION['frdt']));
    $todt=date("Y-m-d", strtotime($_SESSION['frdt']));
  }


// t1= tran_deduct          t2 = employee       t3 = mast_client    t4 = tran_employee  t5= tran_days
 $row = $userObj->deleteTable('uan_ecr_calc');
/*$sql = "delete from uan_ecr_calc";
$row =  mysql_query($sql);*/


// t1= tran_deduct          t2 = employee       t3 = mast_client    t4 = tran_employee  t5= tran_days
$row =  $userObj->getReportPfCodeSummery($emp,$tab_empded,$clientid,$frdt,$comp_id);

			
$res13 = $userObj->getPfChargesReport($frdt);
$res14 = $res13->fetch_assoc();
while($row1 = $row->fetch_assoc())
{   
     $row2 = $userObj->insertUanEcrReportPfCodeSummery(chr(34).chr(39).chr(34),$row1['uan'],$row1['first_name'],$row1['middle_name'],$row1['last_name'],$row1['gross_salary'],$row1['std_amt'],$row1['amount'],$row1['employer_contri_2'],$row1['employer_contri_1'],$row1['absent'],$row1['client_id']);
}
$res_uan = $userObj->selectUanEcrReportPfCodeSummery($res14['acno2']);

$res_uan1= $res_uan->fetch_assoc();;


$res_uan2=$userObj->selectSumUanEcrReportPfCodeSummery();
$totadmin_pf = 0;
$totlink_ins = 0;
/* while ($res_uan3= mysql_fetch_array($res_uan2))
{
	$totadmin_pf+=$res_uan3['acno2'];
	$totlink_ins+=$res_uan3['acno21'];
}
 */


if($month!=''){
    $reporttitle="PF CODE SUMMARY ".$monthtit;
	
}
$p='';

$_SESSION['client_name']=$resclt['client_name'].$p;
$_SESSION['reporttitle']=strtoupper($reporttitle);

?>

<!DOCTYPE html>

<html lang="en-US">
<head>

    <meta charset="utf-8"/>


    <title> &nbsp;</title>

    <!-- Included CSS Files -->
    <link rel="stylesheet" href="../css/responsive.css">
    <link rel="stylesheet" href="../css/style.css">
<script>
    function myFunction() {
        window.print();
    }
</script>

    <style>
	    .message {
              color: #FF0000;
              text-align: center;
              width: 100%;
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



        table{
            padding: 20px!important;
            border: 1px solid black!important;
            font-size:20px !important;
            font-family: monospace;
			

        }
			
			
			@td1 {
            padding: 20px!important;
            border: 1px solid black!important;
            font-size:24px !important;
            font-family: monospace;
			align:'center';
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
            .body { padding: 10px;
			}
            body{
                margin-left: 150px;
            }
			
			@page {
   
				margin: 27mm 16mm 27mm 16mm;
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


<!-- header end -->

<!-- content starts -->




<div class="page">
<div class="header_bg">
<?php
include('printheader3.php');


?>
</div>

<br><br><br>
    <div class="row body page" >
     <center>
	<table width="60%" >

    <tr>
	    <td class='td1' align='center!important'colspan ='5'><b>PF Code : <?php echo $pfcode;?></b></td>
		
    </tr>
    <tr>
	    <td  align='right!important'>No. OF EMPLOYEE</td>
		<td colspan="4" align="right"><?php echo $res_uan1['cnt'];?> </td>
    </tr>
	<tr>
	    <td  align='right!important'>EPF WAGES</td>
		<td colspan="4" align="right"><?php echo number_format($res_uan1['epf_wages'],2,".",",");?></td>
    </tr>
	<tr>
        <td  align='right!important'>EPS WAGES</td>
		<td colspan="4" align="right"><?php echo number_format($res_uan1['eps_wages'],2,".",",");?></td>
    </tr>
	<tr>
        <td  align='right!important'>EDLI WAGES</td>
		<td colspan="4" align="right"><?php echo number_format($res_uan1['edli_wages'],2,".",",");?></td>
    </tr
	<tr>
        <td  align='right!important'>ACCOUNT NO. &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(<?php echo $res14['acno1_employee'];?>%) &nbsp;&nbsp;&nbsp;&nbsp; 01 </tD>
		<td colspan="4" align="right"> <?php echo number_format($res_uan1['epf_contribution'],2,".",",");?></td>
	</tr>
	
	<tr>
        <td  align='right!important'>ACCOUNT NO. &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(<?php echo $res14['acno1_employer'];?>%) &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 01</tD>
		<td colspan="4" align="right"><?php echo number_format($res_uan1['epf_eps_d'],2,".",",");?></td>
	</tr>
	
	<tr>
        <td  align='right!important'>ACCOUNT NO. &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(<?php echo $res14['acno10'];?>%) &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 10 </td>
		<td colspan="4" align="right"><?php echo number_format($res_uan1['eps_contribution'],2,".",",");?></td>
	</tr>
	
	
	<tr>
        <td  align='right!important'>TOTAL </td>
		<td colspan="4" align="right"><?php echo  number_format( ($res_uan1['epf_contribution']+ $res_uan1['eps_contribution']+$res_uan1['epf_eps_d']),2,".",",");?></td>
	</tr>
	
	
	
	<tr>
        <td  align='right!important'>ACCOUNT NO.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (<?php echo number_format($res14['acno2'],2,".",",");?>%) &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 02</td>
		<td colspan="4"align="right"><?php 
		echo "^&U^&*^". number_format($res_uan2['acno2'],2,".",",");
		$ac02 = $res_uan2['acno2'];
		?></td>
	</tr>
	<tr>
       <td  align='right!important'>ACCOUNT NO.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (<?php echo number_format($res14['acno21'],2,".",",");?>%) &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 21 </td>
		<td colspan="4"align="right"><?php 
		echo number_format($res_uan2['acno21'],2,".",",");
		$ac21= $res_uan2['acno21'];
		?></td>
	</tr>
	<tr>
        <td  align='right!important'>ACCOUNT NO. &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(0.00%) &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 22</td>
		<td colspan="4"align="right"><?php echo number_format(round( $res_uan1['epf_wages']*.00000,2),2,".",",");
		$ac22=round($res_uan1['epf_wages']*.00000,2);?></td>
	</tr>
	
	
	<tr>
        <td  align='right!important'> TOTAL   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(<?php echo number_format($res14['acno1_employee']+$res14['acno1_employer']+$res14['acno10']+$res14['acno2']+$res14['acno21'],2,".",",");?>%) </td>
		<td colspan="4" align="right"><?php echo number_format(round($ac22+$ac21+$ac02+$res_uan1['epf_eps_d']+$res_uan1['eps_contribution']+$res_uan1['epf_contribution']),2,".",",");?></td>
	</tr>
	
	
    <tr>
       <td  align='right!important'>TRRN NO.</td>
		<td colspan="4" align="right">&nbsp;</td>
	</tr>
	
	<tr>
        <td  align='right!important'>TRRN DATE</td>
		<td colspan="4" align="right">&nbsp;</td>
	</tr>
    
	<tr>	
		<td  align='right!important'>CRN NO.</td>
		<td colspan="4"align="right>M/td>


</table></center>
        </div>
<br/><br/>
    </div>

<!-- content end -->


</body>
</html>