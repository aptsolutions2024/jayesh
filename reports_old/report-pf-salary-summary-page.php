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
 $comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];

//include("../lib/connection/db-config.php");
include("../lib/class/user-class.php");
$userObj=new user();
$userObj1=new user();

include("../lib/class/admin-class.php");
$adminObj=new admin();
$resclt=$userObj->displayClient($clientid);
 $cmonth=$resclt['current_month'];
// $cmonth= date('Y-m-d');
if($month=='current'){
    $monthtit =  date('F Y',strtotime($cmonth));
    $tab_days='tran_days';
    $tab_emp='tran_employee';
    $tab_empinc='tran_income';
    $tab_empded='tran_deduct';
    $frdt=$cmonth;
    $todt=$cmonth;
 }
else{
    $monthtit =  date('F Y',strtotime($_SESSION['frdt']));
    $tab_days='hist_days';
    $tab_emp='hist_employee';
    $tab_empinc='hist_income';
    $tab_empded='hist_deduct';

    $frdt=date("Y-m-d", strtotime($_SESSION['frdt']));
    $todt=date("Y-m-d", strtotime($_SESSION['frdt']));
	
	/*$sql = "SELECT LAST_DAY('".$frdt."') AS last_day";
	$row= mysql_query($sql);
	$res = mysql_fetch_assoc($row);
	$frdt = $res['last_day'];*/
	$frdt = $userObj->getLastDay($frdt);
 }
$resclt=$userObj->displayClient($clientid);
 //echo $frdt;
 /*if($emp=='Parent'){
	$sqlall ="inner join mast_client t3 where t3.parentId = '".$clientid."'";
 }else{
	$sqlall ="inner join employee t2 where t2.client_id ='".$clientid."'";
	
 }*/
if($emp=='Parent'){
	// All Employees
	$resall = $userObj->parentAllEmpCountPfSalReport($tab_emp,$clientid,$frdt);
	$resallgsal = $userObj->parentAllEmpTotalPfSalReport($tab_emp,$clientid,$frdt);
	$resallpfsal = $userObj->parentAllEmpPfSalReport($tab_empded,$tab_emp,$clientid,$frdt,$comp_id);
	
	//Left Employees
    $resallleft = $userObj->parentLeftEmpCountPfSalReport($tab_emp,$tab_days,$clientid,$frdt);
    $resallgsalleft = $userObj->parentLeftEmpTotalPfSalReport($tab_emp,$tab_days,$clientid,$frdt);
	 
    $resallpfsalleft = $userObj->parentLeftEmpPfSalReport($tab_empded,$tab_emp,$tab_days,$clientid,$frdt,$comp_id);
	
//newly joined	
    $resallnew = $userObj->parentNewEmpCountPfSalReport($tab_emp,$clientid,$frdt);
    
    $resallgsalnew = $userObj->parentNewEmpTotalPfSalReport($tab_emp,$clientid,$frdt);
	
	$resallpfsalnew = $userObj->parentNewEmpPfSalReport($tab_empded,$tab_emp,$clientid,$frdt,$comp_id);
	
	//age>58 
    $resallab58 = $userObj->parentage58EmpPfSalReport($tab_emp,$clientid,$frdt);
			
    $resallgsalab58 = $userObj->parentAge58EmpTotalPfSalReport($tab_emp,$clientid,$frdt);
	
	$resallpfsalab58 = $userObj->parentAge58EmpPfSalReport1($tab_empded,$tab_emp,$clientid,$frdt,$comp_id);

	}
else{
	$resall = $userObj->allEmpCountPfSalReport($tab_emp,$clientid,$frdt);
	
	$resallgsal = $userObj->allEmpTotalPfSalReport($tab_emp,$clientid,$frdt);
	$resallpfsal = $userObj->allEmpPfSalReport($tab_empded,$tab_emp,$clientid,$frdt,$comp_id);

	//left employees
	$resallleft = $userObj->leftEmpCountPfSalReport($tab_emp,$tab_days,$clientid,$frdt);
	
	$resallgsalleft = $userObj->leftEmpTotalPfSalReport($tab_emp,$tab_days,$clientid,$frdt);
	
	$resallpfsalleft = $userObj->leftEmpPfSalReport($tab_empded,$tab_emp,$tab_days,$clientid,$frdt,$comp_id);
	
	 
	//newly joined	
	
	 $resallnew = $userObj->newEmpCountPfSalReport($tab_emp,$clientid,$frdt);
    
    $resallgsalnew = $userObj->newEmpTotalPfSalReport($tab_emp,$clientid,$frdt);
	
	$resallpfsalnew = $userObj->newEmpPfSalReport($tab_empded,$tab_emp,$clientid,$frdt,$comp_id);

	//age>58 
	
	$resallab58 = $userObj->age58EmpPfSalReport($tab_emp,$clientid,$frdt);
			
    $resallgsalab58 = $userObj->age58EmpTotalPfSalReport($tab_emp,$clientid,$frdt);
	
	$resallpfsalab58 = $userObj->age58EmpPfSalReport1($tab_empded,$tab_emp,$clientid,$frdt,$comp_id);

}	

	//$resall = mysql_query($sqlall_emp_cnt);
	$rowsal = $resall->fetch_assoc();
	$alltotemp = $rowsal['cnt'];
	if($alltotemp ==""){$alltotemp =0;}
//	$resallgsal = mysql_query($sqlall_emp_totsal);
	$rowallgsal = $resallgsal->fetch_assoc();
	$alltotgsal = $rowallgsal['gross_salary'];
	if($alltotgsal ==""){$alltotgsal =0;}
	//$resallpfsal = mysql_query($sqlall_emp_pfsal);
	$rowallpfsal = $resallpfsal->fetch_assoc();
	$alltotpfsal = $rowallpfsal['std_amt'];
	if($alltotpfsal ==""){$alltotpfsal =0;}

//left emp
	//$resallleft = mysql_query($sqlleft_emp_cnt);
	$rowallleft = $resallleft->fetch_assoc();
	$alltotleft = $rowallleft['cnt'];
	//$resallgsalleft = mysql_query($sqlleft_emp_totsal);
	$rowallgsalleft = $resallgsalleft->fetch_assoc();
	$alltotgsalleft = $rowallgsalleft['gross_salary'];
	if($alltotgsalleft ==""){$alltotgsalleft =0;}
	
	//$resallpfsalleft = mysql_query($sqlleft_emp_pfsal);
	$rowallpfsalleft = $resallpfsalleft->fetch_assoc();
	$alltotpfsalleft = $rowallpfsalleft['std_amt'];
	if($alltotpfsalleft ==""){$alltotpfsalleft =0;}	

	//new emp
//	$resallnew = mysql_query($sqlnew_emp_cnt);
	$rowallnew = $resallnew->fetch_assoc();
	$alltotnew = $rowallnew['cnt'];
	
	//$resallgsalnew = mysql_query($sqlnew_emp_totsal);
	$rowallgsalnew = $resallgsalnew->fetch_assoc();
	$alltotgsalnew = $rowallgsalnew['gross_salary'];
	if($alltotgsalnew ==""){$alltotgsalnew =0;}
	
//	$resallpfsalnew = mysql_query($sqlnew_emp_pfsal);
	$rowallpfsalnew = $resallpfsalnew->fetch_assoc();
	$alltotpfsalnew = $rowallpfsalnew['std_amt'];
	if($alltotpfsalnew ==""){$alltotpfsalnew =0;}
	
	// age > 58	
	//$resallab58 = mysql_query($sqlab58_emp_cnt);
	$rowallab58 = $resallab58->fetch_assoc();
	$alltotab58 = $rowallab58['cnt'];
	
//	$resallgsalab58 = mysql_query($sqlab58_emp_totsal);
	$rowallgsalab58 = $resallgsalab58->fetch_assoc();
	$alltotgsalab58 = $rowallgsalab58['gross_salary'];
	if($alltotgsalab58 ==""){$alltotgsalab58 =0;}
	
//	$resallpfsalab58 = mysql_query($sqlnab58_emp_pfsal);
	$rowallpfsalab58 = $resallpfsalab58->fetch_assoc();
	$alltotpfsalab58 = $rowallpfsalab58['std_amt'];
	if($alltotpfsalab58 ==""){$alltotpfsalab58 =0;}

$p='';
if($month!=''){
    $reporttitle="EMPLOYEE SALARY SUMMERY OF ".$monthtit;
}
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
		.head1{font-size:26px !important}
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
<!-- header end -->
<!-- content starts -->
<div>
<div class="header_bg">
<?php
include('printheader.php');
?>
</div>
    <div class="row body" >
<div>&nbsp;</div>
        <table width="100%">
    <tr>
        <th align="center" width="25%" class="thheading" ></th>
        <th align="left" colspan="25%" class="thheading">No Of employees </th>
		<th align="left" colspan="25%" class="thheading">Total Gross Salary </th>
		<th align="left" colspan="25%" class="thheading">PF Salary </th>
    </tr>
	 <tr>
        <th align="left" width="25%" class="thheading" >Total Employees Covered Under PF</th>
        <th align="left" colspan="25%" class="thheading"><?php echo $alltotemp;?> </th>
		<th align="left" colspan="25%" class="thheading"><?php echo $alltotgsal; ?></th>
		<th align="left" colspan="25%" class="thheading"><?php echo $alltotpfsal;?></th>
    </tr>
	 <tr>
        <th align="left" width="25%" class="thheading" >Left Employees</th>
        <th align="left" colspan="25%" class="thheading"><?php echo $alltotleft;?> </th>
		<th align="left" colspan="25%" class="thheading"><?php echo $alltotgsalleft;?></th>
		<th align="left" colspan="25%" class="thheading"> <?php echo $alltotpfsalleft;?></th>
    </tr>
	 <tr>
        <th align="left" width="25%" class="thheading" >Joined</th>
        <th align="left" colspan="25%" class="thheading"><?php echo $alltotnew; ?></th>
		<th align="left" colspan="25%" class="thheading"> <?php echo $alltotgsalnew;?></th>
		<th align="left" colspan="25%" class="thheading"> <?php echo $alltotpfsalnew; ?></th>
    </tr>
	 <tr>
        <th align="left" width="25%" class="thheading" >Age > 58</th>
        <th align="left" colspan="25%" class="thheading"><?php echo $alltotab58; ?> </th>
		<th align="left" colspan="25%" class="thheading"> <?php echo $alltotgsalab58; ?></th>
		<th align="left" colspan="25%" class="thheading"> <?php echo $alltotpfsalab58;?></th>
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