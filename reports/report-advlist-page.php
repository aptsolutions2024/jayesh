<?php
session_start();
//error_reporting(0);
/*ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', dirname(__FILE__) . '/error_log.txt');
error_reporting(E_ALL);*/
$month=$_SESSION['month'];
$clientid=$_SESSION['clientid'];
$emp=$_REQUEST['emp'];
$advtype= $_REQUEST['advtype'];
$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];

//include("../lib/connection/db-config.php");
include("../lib/class/user-class.php");
$userObj=new user();

include("../lib/class/admin-class.php");
$adminObj=new admin();
$res=$userObj->showEmployeereport($comp_id,$user_id);

$resclt=$userObj->displayClient($clientid);
$cmonth=$resclt['current_month'];

if($month=='current'){
	$monthtit =  date('F Y',strtotime($cmonth));
    $tab_emp='tran_employee';
    $tab_empded='tran_deduct';
	$tab_adv = 'tran_advance';
    $frdt=$cmonth;
    $todt=$cmonth;
  }
else{
    $monthtit =  date('F Y',strtotime($_SESSION['frdt']));
    $tab_emp='hist_employee';
    $tab_empded='hist_deduct';
	$tab_adv = 'hist_advance';
	$frdt=date("Y-m-d", strtotime($_SESSION['frdt']));
    $todt=date("Y-m-d", strtotime($_SESSION['frdt']));
  }
// t1= tran_          t2 = employee       t3 = mast_client    t4 = tran_employee
  $res12 = $userObj->getReportAdvlist($emp,$advtype,$tab_adv,$clientid,$comp_id,$frdt,$todt,$month);
$tcount= mysqli_num_rows($res12);
    $res22 = $userObj->getAdvanceTypeName($advtype);
	$row22=$res22->fetch_assoc();

if($month!=''){
    $reporttitle=$row22['advance_type_name']." Statement for the month ".$monthtit;
}
$p='';
if($emp=='Parent'){
    $p="(P)";
}
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
	div{padding-right: 20px!important;padding-left: 20px!important;
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
<div class="header_bg">
<?php
include('printheader3.php');
?>
</div>
    <div class="row body" >
    <table width="100%">
    <tr>
	    <th class="thheading" >SrNo.</th>
        <th class="thheading" colspan="3">NAME OF THE EMPLOYEE
        </th>
        <th class="thheading" >ADV. DATE
        </th>
        <th class="thheading" >ADV.AMOUNT RS.
        </th>
        <th class="thheading" >INST.AMT. RS.
        </th>
        <th class="thheading" >DETAILS of Paid Amt.
        </th>
        <th class="thheading" >AMOUNT PAID<br> So far
        </th>
        <th class="thheading" >BALANCE RS.
        </th>
    </tr>

<?php
$totalamt=0;
$totalbal=0;


$ttotalco2=0;
$totalco2=0;
$totalstdam=0;
$c[]='';
$i=1;
$tot_inst= 0;
$tot_bal = 0;

while($row=$res12->fetch_assoc()){
   // print_r($row);
    $totaltype=0;
	$res22 = $userObj->getReportEmpAdvanceRec($row['emp_advance_id']);
	$row22=$res22->fetch_assoc();
    ?>
    <tr>
        <td align="center" >
            <?php
            echo $i;
      ?>
        </td>
        <td colspan="3">
            <?php
            echo $row["first_name"]." ".$row["middle_name"]." ".$row["last_name"]." (".$row["emp_id"].")";
       ?>
        </td>
        <td align="center" >
            <?php
            echo date('d-m-y',strtotime($row22['date']));
            ?>
        </td>       
		<td align="center" >
            <?php
            echo $row22['adv_amount'];
            ?>
        </td>
        <td align="right" >
            <?php
                     echo number_format($row['amount'],2,".",",");
					$totalamt +=$row['amount'];
            ?>
        </td>
 <td align="center" >
            <?php
            //echo $row['paid_amt']."<br>";
			$sql1 = "select id from employee";
	
    $res22 =$userObj->getReportEmpAdvanceRecByEmp($row['emp_id'],$frdt,$row['emp_advance_id']);
	while ($row2=$res22->fetch_assoc()){
		echo date("M y", strtotime($row2['sal_month']))."-".$row2['amount']."&nbsp&nbsp&nbsp ";
	}
			
            ?>
        </td>
		<td align="center" >
            <?php
            echo $row['paid_amt']+$row['amount'];
?>
</td>
		<td align="right" >
            <?php
            echo number_format($row22['adv_amount']-($row['paid_amt']+$row['amount']),2,".",",");
			$tot_bal+= $row22['adv_amount']-($row['paid_amt']+$row['amount']);
            ?>
        </td>
	</tr>
            <?php
    $i++;
}
?>
    <tr>
	    <th class="thheading" colspan="5" align = 'right'>Total 
        </th>
        <th class="thheading" align = "right">
        </th>
        <th class="thheading" align = "right" ><?php echo number_format($totalamt,2,".",","); ?>
        </th>
        <th class="thheading" >
        </th>
		  <th class="thheading" >
        </th>
        <th class="thheading" align = "right"><?php echo number_format($tot_bal,2,".",","); ?>
        </th>
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
</body>
</html>