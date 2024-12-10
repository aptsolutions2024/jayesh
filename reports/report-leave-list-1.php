<?php
session_start();

//error_reporting(0);
$clientid=$_SESSION['clintid'];
$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];
$payment_date=$_REQUEST['payment_date'];
$payment_date=date("Y-m-d", strtotime($payment_date));

include("../lib/connection/db-config.php");
include("../lib/class/user-class.php");


include("../lib/class/admin-class.php");
$adminObj=new admin();
$userObj=new user();
$resclt=$userObj->displayClient($clientid);
$reporttitle="Leave Details for Payment on ".date('d-m-Y',strtotime($payment_date));
$_SESSION['client_name']=$resclt['client_name'];
$_SESSION['reporttitle']=strtoupper($reporttitle);
	
$sql = "select ld.*,concat(e.first_name,' ',e.middle_name,' ',e.last_name) as name from leave_details ld inner join employee e on e.emp_id = ld.emp_id where ld.client_id = '$clientid' and payment_date ='$payment_date' order by ld.from_date,ld.emp_id";
$res = mysql_query($sql);

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

<div class="header_bg">
<?php
include('printheader.php');
?>
</div>

 <div class="page-bk" >
      <table width = "90%">
            <tr>
                <td class='thheading'>SrNo</td>
                <td class='thheading'>From<br> Date</td>
                <td class='thheading'>To<br> Date</td>
                <td class='thheading'>Employee Details </td>
                <td class='thheading'>Present</td>
                <td class='thheading'>OB</td>
                <td class='thheading'>Earned</td>
                <td class='thheading'>Enjoyed</td>
                <td class='thheading'>Encashed</td>
				<td class='thheading'>CB</td>
                <td class='thheading'>Rate</td>
                <td class='thheading'>Amount Rs.</td>
            </tr>
            <?php
				$srno = 1;
				$totamount = 0;
                while ($rowld = mysql_fetch_array($res)) {
            ?>
					<tr>
			        <td align = "centre"><?php echo $srno; ?></td>
			        <td align = "centre"><?php echo date("d-m-Y",strtotime($rowld['from_date']));?></td>
			        <td align = "centre"><?php echo date("d-m-Y",strtotime($rowld['to_date']));?></td>
			        <td align = "centre"><?php echo $rowld['emp_id']." ",$rowld['name']; ?></td>
			        <td align = "centre"><?php echo number_format($rowld['present'],2,".",","); ?></td>
			        <td align = "centre"><?php echo $rowld['ob']; ?></td>
			        <td align = "centre"><?php echo $rowld['earned']; ?></td>
			        <td align = "centre"><?php echo $rowld['enjoyed']; ?></td>
			        <td align = "centre"><?php echo $rowld['encashed']; ?></td>
			        <td align = "centre"><?php echo $rowld['cb']; ?></td>
			        <td align = "right"><?php echo $rowld['rate']; ?></td>
			        <td align = "right"><?php echo number_format($rowld['amount'],2,".",","); ?></td>
					</tr>
			<?php $srno++;
					$totamount = $totamount+$rowld['amount'];
				}
			?>
					<tr>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td>Total Rs.</td>
			        <td align = "right"><?php echo number_format($totamount,2,".",","); ?></td>
			        </tr>
</table>					
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