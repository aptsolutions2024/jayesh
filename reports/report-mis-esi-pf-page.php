<?php
session_start();
/*ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', dirname(__FILE__) . '/error_log.txt');
error_reporting(E_ALL);*/
//error_reporting(0);
$month=$_SESSION['month'];
$clientid=$_SESSION['clientid'];
 $emp=$_REQUEST['emp'];
$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];



include("../lib/connection/db-config.php");
include("../lib/class/user-class.php");
$userObj=new user();
$userObj1=new user();


include("../lib/class/admin-class.php");
$adminObj=new admin();
$res=$userObj->showEmployeereport($comp_id,$user_id);

$resclt=$userObj->displayClient($clientid);
$cmonth=$resclt['current_month'];
if($month=='current'){
    $tab_emp='tran_employee';
    $tab_empded='tran_deduct';
    $frdt=$cmonth;
    $todt=$cmonth;
}
else{
   
    $tab_emp='hist_employee';
    $tab_empded='hist_deduct';
	$frdt=date("Y-m-d", strtotime($_SESSION['frdt']));
    $todt=date("Y-m-d", strtotime($_SESSION['todt']));
	
	$frdt = $userObj->getLastDay($frdt);
	
	$todt = $userObj->getLastDay($todt);
}

$monthtit =  date('F Y',strtotime($frdt));
$reporttitle="DEDUCTION DETAILS FOR THE MONTH ".$monthtit;
$p='';
if($emp=='Parent'){
    $p="(P)";
}
$_SESSION['client_name']=$resclt['client_name'].$p;
$_SESSION['reporttitle']=strtoupper($reporttitle);
$res12 = $userObj->getREportMisPf($emp,$tab_empded,$tab_emp,$clientid,$frdt,$comp_id);
//e = employee, tdd -tran_deduct,te -tran_employee
       
$tcount= mysqli_num_rows($res12);
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
<!-- header end -->
<!-- content starts -->
<div>
<div class="header_bg">
<?php
include('printheader.php');
?>
</div>
    <div class="row body" >
        <table width="100%">
    <tr>
	<th align="center" class="thheading">Sr.No </th>
        <th align="left" class="thheading">Name Of the Employee </th>
		<th class ="thheading"> ESI No </th>
		<th class ="thheading"> PF No </th>
	    <th align="center" class='thheading' >Wage Rate</th>
        <th align="center" class='thheading'>Paya. Days </th>
        <th align="center" class='thheading'>Total Wages</th>
		<th align="center" class='thheading'>Other Allow.</th>
        <th align="center" class='thheading'>Gross Earnings</th>
		<th align="center" class='thheading'>Employer</br>ESI 4.75%</th>
		<th align="center" class='thheading'>Employee</br>ESI 1.75%</th>
		<th align="center" class='thheading'>Employer</br>PF 8.33%</th>
		<th align="center" class='thheading' >Employer</br>PF 3.67%</th>
		<th align="center" class='thheading'>Employee</br>PF 12.0%</th>
		<th align="center" class='thheading'>Total Ded.</th>
		<th align="center" class='thheading'>Paid Amt.</th>
    </tr>
	

<?php
$tpayabledays = 0;
$ttotwages= 0;
$tgrearnings=0;
$t475 =0;
$t175=0;
$t833=0;
$t367=0;
$t120=0;
$ttotded=0;
$tpaidamt = 0;

$i=0;
$totded = 0;
$srno=0;
while($row=$res12->fetch_assoc()){
	if ($i > 0)
	{

	if (	$name!= $row['first_name']." ".$row['last_name']){
		$srno++;
		
		$paidamt= $gross_salary-$totded;
		echo "<tr><td>".$srno."</td><td>".$name."</td><td>".$esino."</td><td>".$pfno."</td><td>".$wagerate."</td><td>".$payabledays."</td><td>".$gross_salary."</td><td></td><td>".$gross_salary."</td><td>".$esi475."</td><td>".$esi175."</td><td>".$pf833."</td><td>".$pf367."</td><td>".$pfamount."</td><td>".$totded."</td><td>".$paidamt."</td></tr>";
        $tpayabledays = $tpayabledays+$payabledays;
		$tgrearnings = $tgrearnings+$gross_salary;
		$t475 = $t475+$esi475;
		$t175 = $t175 +$esi175;
		$t833=$t833+$pf833;
		$t367=$t367+$pf367;
		$t120 = $t120+$pfamount;
		$ttotded = $ttotded+$totded;
	$tpaidamt = $tpaidamt+$paidamt;
	$totded = 0;}
	
	}	
	$i++;
    $name= $row['first_name']." ".$row['last_name'];
	$esino=$row['esino'];
	$pfno = $row['pfno'];
	$wagerate=round($row['gross_salary']/$row['payabledays'],2);
	$payabledays = $row['payabledays'];        
	$gross_salary = $row['gross_salary'];
	if ($row['employer_contri_2']>0){
    $pf833=$row['employer_contri_2'];
	$pf367=$row['employer_contri_1'];
	$pfamount = $row['amount'];
	}
	if ($row['employer_contri_2']==0){
	$esi175=$row['amount'];
	$esi475 = $row['employer_contri_1'];
	}
	$totded = $totded+$row['amount'];
	$paidamt= $row['netsalary'];
	
	
    
}
$srno++;
echo "<tr><td>".$srno."***"."</td><td>".$name."</td><td>".$esino."</td><td>".$pfno."</td><td>".$wagerate."</td><td>".$payabledays."</td><td>".$gross_salary."</td><td></td><td>".$gross_salary."</td><td>".$esi475."</td><td>".$esi175."</td><td>".$pf833."</td><td>".$pf367."</td><td>".$pfamount."</td><td>".$totded."</td><td>".$paidamt."</td></tr>";
        $tpayabledays = $tpayabledays+$payabledays;
		$tgrearnings = $tgrearnings+$gross_salary;
		$t475 = $t475+$esi475;
		$t175 = $t175 +$esi175;
		$t833=$t833+$pf833;
		$t367=$t367+$pf367;
		$t120 = $t120+$pfamount;
		$ttotded = $ttotded+$totded;
		$tpaidamt = $tpaidamt+$paidamt;

echo "<tr>
         <th class='thheading'></th>
         <th class='thheading'></th>
         <th class='thheading'></th>
         <th class='thheading'></th>
        <th align='center' class='thheading'>Total</th>
        <th align='center' class='thheading'>".$tpayabledays ."</th>
        <th align='center'  class='thheading'>".$tgrearnings."</th>
		<th align='center'  class='thheading'></th>
        <th align='center'  class='thheading'>".NUMBER_FORMAT($tgrearnings,2,".",",")."</th>
		<th align='center'  class='thheading'>".NUMBER_FORMAT($t475,2,".",",")."</th>
		<th align='center'  class='thheading'>".NUMBER_FORMAT($t175,2,".",",")."</th>
		<th align='center'  class='thheading'>".NUMBER_FORMAT($t833,2,".",",")."</th>
		<th align='center'  class='thheading'>".NUMBER_FORMAT($t367,2,".",",")."</th>
		<th align='center'  class='thheading'>".NUMBER_FORMAT($t120,2,".",",")."</th>
		<th align='center'  class='thheading'>".NUMBER_FORMAT($ttotded,2,".",",")."</th>
		<th align='center'  class='thheading'>".NUMBER_FORMAT( $tpaidamt,2,".",",")."</th>
    </tr>
<tr><td colspan =16 ></td></tr>
";
$res13 = $userObj->getReportMisPfCharges($frdt);
$res14 = $res13->fetch_assoc();
?>	
<tr >
<td colspan = 2 > ESI Contribution </td>
<td  colspan =4> 1.75% Employees'  </td>
<td> <?php echo NUMBER_FORMAT($t175,2,".",",");?></td>
</tr>
<td colspan =2></td>
<td colspan =4> 4.75% Employers'</td>
<td> <?php echo NUMBER_FORMAT($t475,2,".",",");?> </td>
</tr>
<tr>
<td colspan =2>
</td>
<td  colspan =4>Total </td>
<td><?php echo NUMBER_FORMAT($t175+$t475,2,".",",");?></td>
</tr>
			
<tr>
<td colspan =2>
PF Contribution  </td>
<td  colspan =4>  12.00% Employees'  </td>
<td> <?php echo NUMBER_FORMAT($t120,2,".",",");?></td>
</tr>
<tr>
<td colspan =2></td>
<td  colspan =4> 8.33% Employers'</td>
<td> <?php echo NUMBER_FORMAT($t833,2,".",",");?> </td>
</tr>
<tr>
<td colspan =2></td>
<td  colspan =4> 3.67% Employers'</td>
<td> <?php echo NUMBER_FORMAT($t367,2,".",",");?> </td>
</tr>
<tr>
<td colspan =2>
</td>
                <td colspan=4 >Pf Admin Charges (<?php echo $res14['admin']?>%)</td>
                <td  ><?php echo $ac=NUMBER_FORMAT(round($tgrearnings*$res14['admin']/100,2),2,".",","); $amt1=round($tgrearnings*$res14['admin']/100,2); ?></td>
            </tr>
            <tr>
<td colspan =2>
</td>
                <td  colspan=4>D.L.I.S. Contribution (<?php echo $res14['dlis_contri']?>%)</td>
                <td  ><?php echo $dlisc=NUMBER_FORMAT(round($tgrearnings*$res14['dlis_contri']/100,2),2,".",",");$amt2= round($tgrearnings*$res14['dlis_contri']/100,2); ?></td>
            </tr>
            <tr>
<td colspan =2>
</td>
                <td colspan=4>D.L.I.S. Admin Charges (<?php echo $res14['dlis_admin']?>%)</td>
                <td  ><?php echo $dlisac=NUMBER_FORMAT(round($tgrearnings*$res14['dlis_admin']/100,2),2,".",",");
        		$amt3=round($tgrearnings*$res14['dlis_admin']/100,2);		?>
            </tr>
<tr>
<td colspan =2>
</td>
<td  colspan =4>Total </td>
<td><?php echo NUMBER_FORMAT($t120+$t367+$t833+$amt1+$amt2+$amt3,2,".",",");?></td>
</tr>
</table>
 </div>
    </div>
<!-- content end -->
<script>
    function myFunction() {
        window.print();
    }
</script>
</body>
</html>