<?php
session_start();
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', dirname(__FILE__) . '/error_log.txt');
error_reporting(E_ALL);
//error_reporting(0);
include("../lib/connection/db-config.php");
include("../lib/class/admin-class.php");
$adminObj=new admin();

include("../lib/class/user-class.php");
$userObj=new user();

$clientid=$_SESSION['clientid'];
$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];
$emp_id = $_REQUEST['eid'];


$res11 =$userObj->getReportGraduaty($emp_id);
$row2 = $res11->fetch_assoc();

$tcount= mysqli_num_rows($res11);
if ($row2['months']>=6){$years=$row2['years']+1;}else{$years=$row2['years'];} 

if ($tcount==0){echo "Invalid Left Date";exit;}

$row4 =$userObj->getReportGraduatySum($comp_id,$row2["emp_id"]);

$row3 = $row4->fetch_assoc();
$basic_da = $row3['amount'];
$basic_da_rate = round($basic_da/26,2);
$one_year_gratuity = round($basic_da_rate*15,2);
$tot_gratuity =round($one_year_gratuity*$years,2);
	
$res=$userObj->showEmployeereport($comp_id,$user_id);
$resclt=$userObj->displayClient($clientid);

$_SESSION['client_name']=$resclt['client_name'];
$_SESSION['reporttitle']="GRATUITY REPORT";

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
            padding: 15px!important;
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

<!-- content starts -->

<div>
<div class="header_bg">
<?php
include('printheader3.php');
echo "<br><br>";
?>
</div>
    <div class="row body" >
        <table width="90%">
    <tr>
	
	<td> Employee Name </td> <td><?php echo $row2['name'];?></td></tr>
	<td> Employee Id </td> <td><?php echo $row2['emp_id'];?></td></tr>
	<td> Client Name </td> <td><?php echo $row2['client_name'];?></td></tr>
	<td> Join Date </td> <td><?php echo date('d-m-Y',strtotime($row2['joindate']));?></td></tr>
	<td> Left Date </td> <td><?php echo date('d-m-Y',strtotime($row2['leftdate']));?></td></tr>
	<td> Total Service </td> <td><?php echo $row2['service'];?></td></tr>
	<td> Rounded To </td> <td><?php echo $years.' Years';?></td></tr>
	<td> Basic+D.A. </td> <td align='left'><?php echo 'Rs. '.number_format($basic_da,2,'.',',');?></td></tr>
	<td> Rates  </td> <td align='left'><?php echo 'Rs. '.number_format($basic_da_rate,2,'.',',');?></td></tr>
	<td> One Year Gratuity  </td> <td align='left'><?php echo 'Rs. '.number_format($one_year_gratuity,2,'.',',');?></td></tr>
	<td> Total Gratuity  </td> <td align='left'><?php echo 'Rs. '.number_format($tot_gratuity,2,'.',',');?></td></tr>
	<td> Rounded Gratuity  </td> <td align='left'><?php echo 'Rs. '.number_format(round($tot_gratuity,0),2,'.',',');?></td></tr>

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


</body>
</html>