<?php
//error_reporting(0);
$client = $_REQUEST['client'];
session_start();
$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];

include("../lib/connection/db-config.php");
include("../lib/class/user-class.php");
include("../lib/class/admin-class.php");
$userObj=new user();

$adminObj=new admin();
$resclt=$userObj->displayClient($client);
//print_r($resclt['client_name']);

$startyear = date('Y-m-d',strtotime($_SESSION['startbonusyear']));
$endyear = date('Y-m-d',strtotime($_SESSION['endbonusyear']));
$days = 0;
$emp = $userObj->getemployeeBonusByClient($client,$startyear,$endyear,$days,$comp_id,$user_id);

$explyr = explode('-',$startyear);
$yr = $explyr[0];
$yr = substr($yr,2,2);
 $reporttitle="Bonus Register For ".date('d-m-Y',strtotime($_SESSION['startbonusyear']))." To ".date('d-m-Y',strtotime($_SESSION['endbonusyear']));


$_SESSION['client_name']=$resclt['client_name'];
$_SESSION['reporttitle']=strtoupper($reporttitle);
?><!DOCTYPE html>

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
            page-break-before: always;
            z-index: 0;
        }
        table {
            border-collapse: collapse;
            width: 100%;
        }

        table, td, th {
            padding: 3px!important;
            border: 1px dotted black!important;
            font-size:10px !important;
            font-family: monospace;
			text-align:right;
        }
		ol{ list-style: lower-roman;}
		div,li{list-style: lower-roman;font-size:13px !important;
            font-family: monospace;}
			div{padding:5px}
		.innertable{float:right;width: 80%; margin-top:5px}
		.bord0{border:0 !important;}
		.alcenter{text-align:center}
		.spanbr {border-bottom:1px dotted #000;     clear: both;}
		.bordr {border-right:1px dotted #000;}
		.paddtb5px{padding-top:5px; padding-bottom:5px}
		.diw50per{width:50%; display:inline}
		.padd0{padding:0 !important}
		span.heade.head1{font-size:27px !important}
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
            .body { padding: 5px; }
            body{
                margin-left: 10px;
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
<div class="header_bg">
<?php
include('printheader3.php');
?>
</div>

<div class="row body ">
<div class="page-bk ">

<table width="100%" cellspacing="0" cellpadding="0">
<tr>
<!--<th width="2%">SNo</th> -->
<th >EId</th>
<th >Name of the Employee</th>
<th >Days</th>
<th >Bonus Wages</th>
<th >Bank Details</th>
<th >Signature</th>
</tr>
<?php $i=1; 
$bonuswages=0;

$i=1;
$page = 1;
$cnt=0;
while($res = mysql_fetch_array($emp)){
	
	$cnt++;
	if ($cnt>25){
		$page++;
		$cnt = 1;
	}
	if ($page>1 & $cnt==1)
	{ echo "</div>";
	  echo 	'<div class="page-bk ">';
	  include('printheader3.php');
		echo '<table width="100%" cellspacing="0" cellpadding="0">
				<tr>
				<!--<th width="2%">SNo</th> -->
				<th >EId</th>
				<th >Name of the Employee</th>
				<th >Days</th>
				<th >Bonus Wages</th>
				<th >Bank Details</th>
				<th >Signature</th>
				</tr>';
	}
	?>
<tr>
<td ><?php echo $res['emp_id'];?></td>
<td > <?php echo $res['first_name']." ".$res['middle_name']." ".$res['last_name'];?></td>
<?php $empbon = $userObj->getemployeeBonusById($res['emp_id'],$startyear,$endyear ,$comp_id,$user_id);
	
	  $res1 = mysql_fetch_array($empbon);
	
	  $res2 = $userObj->displayBank( $res1['bank_id']);
	
 echo "<td>". $res1['tot_payable_days']."</td>";
 echo "<td>". $res1['tot_bonus_amt']."</td>";
 echo "<td> ".$res1['bankacno']."<br>".$res2['bank_name']."<br>".$res2['branch']."</td>";
 echo "<td></td></tr>";
 	

  $i++;} ?>



</table>
Total no of employees : <?php echo $i-1;?>
<br><br>
</div>


</div>
<script>
    function myFunction() {
        window.print();
    }
</script>
</body>
</html>
