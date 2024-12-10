<?php
session_start();
//error_reporting(0);
/*ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', dirname(__FILE__) . '/error_log.txt');
error_reporting(E_ALL);*/
$month=$_SESSION['month'];
$clientid=$_SESSION['clientid'];
//$emp=$_REQUEST['emp'];
$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];


include("../lib/connection/db-config.php");
include("../lib/class/user-class.php");
$userObj=new user();
$userObj1=new user();


include("../lib/class/admin-class.php");
$adminObj=new admin();

include("../lib/class/common.php");
$common=new common();
$res=$userObj->showEmployeereport($comp_id,$user_id);

$resclt=$userObj->displayClient($clientid);
$mon = $_REQUEST['mon'];
$frdt = $_REQUEST['frdt'];
 $todt = $_REQUEST['todt'];
if($mon =='current'){
 $cmonth=$resclt['current_month'];
 $frdt =$resclt['current_month'];
}

if($month=='current'){
    $monthtit =  date('F Y',strtotime($cmonth));
    //$tab_days='tran_days';
    $tab_emp='tran_employee';
    //$tab_empinc='tran_income';
    $tab_empded='tran_deduct';
	 $cmonth=$resclt['current_month'];
 $frdt =$resclt['current_month'];
 }
else{
    $monthtit =  date('F Y',strtotime($_SESSION['frdt']));
    //$tab_days='hist_days';
    $tab_emp='hist_employee';
    //$tab_empinc='hist_income';
    $tab_empded='hist_deduct';
	//$tab_adv='hist_advance';

    //$frdt=date("Y-m-d", strtotime($_SESSION['frdt']));
    //$todt=date("Y-m-d", strtotime($_SESSION['frdt']));
	
	//$sql = "SELECT LAST_DAY('".$frdt."') AS last_day";
	//$row= mysql_query($sql);
	//$res = mysql_fetch_assoc($row);
	//$frdt = $res['last_day'];
	
 }
 
$frdt = date('Y-m-d',strtotime($frdt));
$todt = date('Y-m-d',strtotime($todt));
//t1 = tran_deduct   t2= employee      t3= tran_days    t4 = tran_emp      t5=mast_client

$res =$userObj->getReportEsiSummery($tab_empded,$tab_emp,$comp_id,$frdt);

$res_tot =$userObj->getReportEsiSummery2($tab_empded,$tab_emp,$comp_id,$frdt);

if($month!=''){
    $reporttitle="ESI Summery Statement FOR THE MONTH ".$monthtit;
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
    
		.tdtext{
            text-transform: uppercase;
			 align-content: center;
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

<div>
<div class="header_bg">
<?php
include('printheader3.php');
?>
</div>
 
    <div class="row body" >

<table width='100%'>

 <tr>
        <th class='thheading' width='5%'>Client NO </th>
        <th class='thheading' width='25%'>Client Name </th>
        <th class='thheading' width='10%'>Total Rs. </th>
        <th class='thheading' width='10%'>Employee</th>
        <th class='thheading' width='10%'>Employer</th>
        <th class='thheading' width='15%'>Total</th>
        <th class='thheading' width='10%'>No. Of Employee</th>
    </tr>

<?php 
//foreach($getdetails1 as $client){
while($client = $res->fetch_assoc()){ 
  ?>
 <tr>
        <td ><?php echo $client['client_id'];?> </td>
        <td ><?php echo $client['client_name'];?>  </td>
        <td ><?php echo $client['std_amt'];?>  </td>
        <td ><?php echo $client['amount'];?> </td>
        <td ><?php echo $client['employer'];?> </td>
        <td > <?php echo number_format($client['amount']+$client['employer'],2,".",",");?></td>
        <td ><?php echo $client['cnt'];?> </td>
    </tr>
<?php } 
$client = $res_tot->fetch_assoc();
?>

<tr>
        <td ></td>
        <td >Total  </td>
        <td ><?php echo $client['std_amt'];?>  </td>
        <td ><?php echo $client['amount'];?> </td>
        <td ><?php echo $client['employer'];?> </td>
        <td > <?php echo number_format($client['amount']+$client['employer'],2,".",",");?></td>
        <td ><?php echo $client['cnt'];?> </td>

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