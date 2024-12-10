<?php
session_start();
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', dirname(__FILE__) . '/error_log.txt');
error_reporting(E_ALL);
//error_reporting(0);
$month=$_SESSION['month'];
$clintid=$_SESSION['clintid'];
$emp=$_REQUEST['emp'];
$pay_type= $_REQUEST['pay_type'];
$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];


//include("../lib/connection/db-config.php");
include("../lib/class/user-class.php");
$userObj=new user();
include("../lib/class/admin-class.php");
$adminObj=new admin();
	$resclt=$userObj->displayClient($clintid);
if($month=='current'){

	$cmonth=$resclt['current_month'];
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
	$res = mysql_fetch_assoc($row);*/
	$frdt = $userObj->getLastDay($cmonth);//$res['last_day'];
    $todt = $frdt;  	
 }


if($month!=''){
  
}
$p='';
if($emp=='Parent'){
    $p="(P)";
}

$_SESSION['client_name']=$resclt['client_name'].$p;


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
		table#appletter ,table#appletter tr,table#appletter td,#tabltit table,#tabltit tr,#tabltit td {
			border: 0 !important;
		}

@page {
   
				margin: 27mm 16mm 27mm 16mm;
			}

        table {
            border-collapse: collapse;
            width: 90%;

        }

        table, td, th {
            padding: 5px!important;
            border: 1px solid black!important;
            font-size:18px !important;
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
                margin-left: 100px;
               
            }
			  
		
        }
			/*@page {
			  size: A4;
			  margin: 0 0 5%;
			  padding: 0 0 10%;
			}*/


			@media print {
			  h3 {
				position: absolute;
				page-break-before: always;
				page-break-after: always;
				bottom: 0;
				right: 0;
			  }
			  h3::before {
				position: relative;
				bottom: -20px;
				counter-increment: section;
				content: counter(section);
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
<!--<div class="header_bg">
<?php
//include('printheader.php');
?>
</div>-->
    <div >
    <table width="100%" cellpadding='0' cellspacing='0' style="border:0 !important">
    
	
	<tr>
	<td colspan="5" style="border:0 !important">	
<div class=" body row page">

<?php 
if ($pay_type=="S"){
    $resgtemp11 =$userObj->getChecklistTypeS($emp,$tab_emp,$clintid,$frdt);
	/*if($emp=='Parent'){
	    
	 $selgtemp ="select * 
	 from $tab_emp te inner join employee e on te.emp_id = e.emp_id
	 inner join mast_client mc on te.client_id = mc.mast_client_id 
	 where mc.parentid = '$clintid' and te.sal_month = '$frdt' and te.pay_mode = 'C' order by e.pay_mode,te.emp_id";
	}else {
	    $selgtemp ="select  te.*,e.first_name,e.middle_name,e.last_name, cd.check_no,cd.date from $tab_emp te inner join employee e on te.emp_id = e.emp_id inner join cheque_details cd on cd.emp_id = te.emp_id and cd.sal_month = te.sal_month and cd.type = 'S'
	 where te.client_id = '$clintid' and te.sal_month = '$frdt' and te.pay_mode = 'C' and te.netsalary>0  order by e.pay_mode ,te.emp_id";
	}
	$resgtemp11 = mysql_query($selgtemp);*/
	$bankrec = mysqli_num_rows($resgtemp11);
	  $reporttitle="CHEQUE LIST FOR THE MONTH ".$monthtit;
	$_SESSION['reporttitle']=strtoupper($reporttitle);
}

if ($pay_type=="B"){
	$startday = $_SESSION['startbonusyear'];
$endday = $_SESSION['endbonusyear'];

$resgtemp11 =$userObj->getChecklistTypeB($clintid,$endday,$startday);

	   /*$selgtemp ="select   te.tot_bonus_amt+te.tot_exgratia_amt  as netsalary,te.*,e.first_name,e.middle_name,e.last_name, cd.check_no,cd.date from bonus te inner join employee e on te.emp_id = e.emp_id inner join cheque_details cd on cd.emp_id = te.emp_id
	 where te.client_id = '$clintid' and cd.type = 'B' and te.from_date = '$startday' and todate = '$endday' and te.pay_mode = 'C' and te.tot_bonus_amt+te.tot_exgratia_amt >0  order by e.pay_mode ,te.emp_id";
	
	$resgtemp11 = mysql_query($selgtemp);*/
	$bankrec = mysqli_num_rows($resgtemp11);
	  $reporttitle="CHEQUE LIST FOR THE BONUS PERIOD  ". date('F Y',strtotime($startday))." TO ".  date('F Y',strtotime($endday));
	$_SESSION['reporttitle']=strtoupper($reporttitle);
}



	if($bankrec !=0){
include('printheader3.php');
if ($pay_type=="B"){
    $row= $userObj->getChecklistTypeBBlankRec($clintid,$endday,$startday);
/*$sql ="select  cd.date from bonus te inner join employee e on te.emp_id = e.emp_id inner join cheque_details cd on cd.emp_id = te.emp_id and cd.from_date = te.from_date and  cd.to_date = te.todate and cd.type = 'B'
	 where te.client_id = '$clintid' and te.from_date = '$startday' and todate = '$endday' and te.pay_mode = 'C' and te.tot_bonus_amt+te.tot_exgratia_amt >0  limit 1 ";*/
}
if ($pay_type=="S"){
    $row= $userObj->getChecklistTypeSBlankRec($clintid,$frdt,$tab_emp);
 /*$sql ="select  cd.date from $tab_emp te inner join employee e on te.emp_id = e.emp_id inner join cheque_details cd on cd.emp_id = te.emp_id and cd.sal_month = te.sal_month and cd.type = 'S'
	 where te.client_id = '$clintid' and cd.sal_month = '$frdt'  and te.pay_mode = 'C' and te.netsalary>0  limit 1";*/
}

//$row = mysql_query($sql);
$row2= $row->fetch_assoc();

$reporttitle2 = "Cheque Date :".date('d-m-Y',strtotime($row2['date']));

?>
</div>	
	<div class="page-bk row body" >
	
	   <div align="centre" id="tabltit"><table width="80%" ><tr><td align= "center"  style="font-size:16px!important;"> <?php echo $reporttitle2;?></td></tr>
				   <tr><td align= "center"  style="font-size:16px!important;"> <?php //echo $reporttitle3;?></td></tr></table></div>
				 
	
	
	<table width="80%">
	
	<tr>
       <th class="thheading" width="5%">SR.No.      </th>
		<th class="thheading" width="10%">Emp ID.      </th>
		<th class="thheading" width="45%">NAME OF THE EMPLOYEE </th>
        <th class="thheading" width="15%">Cheque No.</th>        
        <th class="thheading" width="15%">Amount Rs. </th>
		
    </tr>
	<?php $srno1=1; $totsal=0;
	while($recall = $resgtemp11->fetch_assoc()){
	
	
	?>
		<tr>
		<td><?php echo $srno1;?></td>
		<td align="center"><?php echo $recall['emp_id'];?></td>
		<td><?php echo $recall['first_name']." ".$recall['middle_name']." ".$recall['last_name']?></td>
		<td align="center"><?php echo $recall['check_no']; ?></td>
		<td align="right"><?php   $totsal=$totsal+$recall['netsalary']; echo number_format($recall['netsalary'],2,".",",");
	?></td>
		</tr>
		
<?php $srno1++;

		}
 ?>
		<tr>
		<td colspan="4" style="text-align:right">Total </td>
		<td align="right"> <?php echo number_format($totsal,2,".",","); ?></td>
		</tr>
		

 </table>
 <?php } 
 
 ?>
</td>
</tr>
<?php /*
$totnetsalary=0;
$srno=1;
while($row=mysql_fetch_array($res)){
    ?>
    <tr>
        <td align="center" >
            <?php
            echo $srno;
      ?>
        </td>

        <td >
            <?php
            echo $row["first_name"]." ".$row["middle_name"]." ".$row["last_name"];
       ?>
        </td>
        <td align="center" >
            <?php

                     echo $row["bank_name"].', '.$row['branch']. '  '.$row['ifsc_code'];
            ?>
        </td>

        <td align="center" >
            <?php
            echo $row['bankacno'];
            ?>
        </td>       
		<td align="center" >
            <?php
            echo $row['netsalary'];
            ?>
        </td>
    </tr>
            <?php
    $srno++;
	$totnetsalary =$totnetsalary+$row['netsalary'];

}
*/
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


</body></html>