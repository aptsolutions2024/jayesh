<?php
session_start();

//error_reporting(0);
$month=$_SESSION['month'];
$clientid=$_SESSION['clientid'];
$emp=$_REQUEST['eid'];
$advdate1= date("Y-m-d",strtotime($_REQUEST['advdate']));

//include("../lib/connection/db-config.php");
include("../lib/class/user-class.php");
$userObj=new user();


include("../lib/class/admin-class.php");
$adminObj=new admin();


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
  
$res12 = $userObj->getReportAdvanceEmployee($emp,$advdate1);
$res122 = $res12->fetch_assoc();
//print_r ($res122);



$res = $userObj->getHistAdvance($res122['emp_advnacen_id']);
$res1 = $userObj->getTranAdvance($res122['emp_advnacen_id']);

if($month!=''){
    $reporttitle="Statement For Advance taken of Rs." .$res122['adv_amount']." on ".date("d-m-Y",strtotime($advdate1))." By ".$res122['first_name']." ".$res122['middle_name']." ".$res122['last_name']  ;
}
$_SESSION['client_name']=$resclt['client_name'];
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
    
        <th class="thheading" >Date</th>
        <th class="thheading" >INST.AMT. RS.
        </th>
        </th>
        <th class="thheading" >Earlier Paid Amount RS.<br> (Excluding current Inst.)
        </th>
        <th class="thheading" >BALANCE RS.
        </th>
    </tr>

<?php
 $i=1;
//print_r($res11);

while($row=$res->fetch_assoc()){?>
    <tr>
        <td align="center" >
            <?php
            echo $i;
      ?>
        </td>
    <td align="center" >
            <?php
            echo date("d-m-Y",strtotime($row['sal_month']));
      ?>
        </td>
        <td align="right" >
            <?php
                     echo number_format($row['amount'],2,".",",");
            ?>
        </td>

        <td align="right" >
            <?php
            echo $row['paid_amt']."<br>";
            ?>
        </td>
		<td align="right" >
            <?php
            echo number_format($res122['adv_amount']-($row['paid_amt']+$row['amount']),2,".",",");
			
            ?>
        </td>

	</tr>
            <?php
    $i++;

}
while($row=$res1->fetch_assoc()){?>
    <tr>
        <td align="center" >
            <?php
            echo $i;
      ?>
        </td>
    <td align="center" >
            <?php
            echo  date("d-m-Y",strtotime($row['sal_month']));
      ?>
        </td>
        <td align="right" >
            <?php
                     echo number_format($row['amount'],2,".",",");
            ?>
        </td>

        <td align="right" >
            <?php
            echo $row['paid_amt']."<br>";
            ?>
        </td>
		<td align="right" >
            <?php
            echo number_format($res122['adv_amount']-($row['paid_amt']+$row['amount']),2,".",",");
			
            ?>
        </td>

	</tr>
            <?php
    $i++;

}

?>
    
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