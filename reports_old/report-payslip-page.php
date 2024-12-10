<?php
session_start();
//error_reporting(0);
/*ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', dirname(__FILE__) . '/error_log.txt');
error_reporting(E_ALL);
*/
$month=$_SESSION['month'];
$clientid=$_SESSION['clientid'];
$emp=$_REQUEST['emp'];
$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];
$zerosal = $_REQUEST['zerosal'];
$noofpay = $_REQUEST['noofpay'];

include("../lib/connection/db-config.php");

include("../lib/class/user-class.php");
$userObj=new user();
$userObj1=new user();

include('../fpdf/html_table.php');

$pdfHtml='';
include("../lib/class/admin-class.php");
$adminObj=new admin();
$res=$userObj->showEmployeereport($comp_id,$user_id);
$resclt=$userObj->displayClient($clientid);
//print_r($resclt);
$cmonth=$resclt['current_month'];
if($month=='current'){
    $monthtit =  date('F Y',strtotime($cmonth));
    $tab_days='tran_days';
    $tab_emp='tran_employee';
    $tab_empinc='tran_income';
    $tab_empded='tran_deduct';
    $tab_adv='tran_advance';
    $frdt=$cmonth;
    $todt=$cmonth;

 }
else{
    $tab_days='hist_days';
    $tab_emp='hist_employee';
    $tab_empinc='hist_income';
    $tab_empded='hist_deduct';
    $tab_adv='hist_advance';

	$monthtit =  date('F Y',strtotime($_SESSION['frdt']));

    $frdt=date("Y-m-d", strtotime($_SESSION['frdt']));
    $todt=date("Y-m-d", strtotime($_SESSION['todt']));
	$frdt = $userObj->getLastDay($frdt);
	$todt = $userObj->getLastDay($todt);
	
	}
$empid=$_REQUEST['empid'];

 //$sql = "SELECT * FROM $tab_days WHERE comp_id ='".$comp_id."' AND user_id='".$user_id."'  "; 
 $res =$userObj->selectReportPayslip($tab_days,$tab_emp,$clientid,$frdt,$todt,$empid,$emp,$zerosal);

$tcount= mysqli_num_rows($res);

if($month!=''){
    $reporttitle="PAYSLIP FOR THE MONTH ".strtoupper($monthtit);
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
	body{font-family:arial}
        .thheading{
            text-transform: uppercase;
            font-weight: bold;
            background-color: #fff;
        }
		.logo span.head11 {
			font-size: 17px !important;
		}
		
		span.head13 {
			font-size: 20px !important;
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
            padding: 3px!important;
            border: 1px solid black!important;
            font-size:12px !important;
            font-family:arial;
			
        }
		@page {margin :27mm 16mm 22mm 16mm;}
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
            .body { margin: 0 30px 10px 10px; }
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

<?php
$count=0;
$per=$noofpay;
$no1= 1;

while($row=$res->fetch_assoc()){
	if ($comp_id ==11)
	{
	    
	    	include "payslip_comp11.php";

	}
	else
	{
	include "payslip.php";
	}
} ?>
<!-- content end -->

<script>
    function myFunction() {
        window.print();
    }
</script>


</body>
</html>