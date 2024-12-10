<?php
//print_r($_REQUEST);
error_reporting(0);
session_start();
include("../lib/connection/db-config.php");
$setCounter = 0;
$month=$_SESSION['month'];
$comp_id=$_SESSION['comp_id'];
$clintid=$_SESSION['clintid'];
$user_id=$_SESSION['log_id'];
$setExcelName = "payslip";
$client_id=$_REQUEST['cal'];

$setExcelName = "Paysheet_".$client_id;
//$emp = $_REQUEST['emp'];
//$name = $_REQUEST['name'];
include("../lib/class/user-class.php");
include("../lib/class/admin-class.php");
$userObj=new user();
$adminObj=new admin();
$resclt=$userObj->displayClient($clintid);

$rowclient=$userObj->displayClient($client_id);
$cmonth=$rowclient['current_month'];
$inhdar = array();
$inhd =0;
$advhd = 0;
$advhdar = array();

$dedhdar = array();
$dedhd =0;
$noofper = $_REQUEST['noofper'];

if($month=='current'){
	$monthtit =  date('F Y',strtotime($cmonth));
    $tab_emp='tran_employee';
    $tab_empded='tran_deduct';
	$tab_days = 'tran_days';
	$tab_inc = 'tran_income';
	$tab_adv = 'tran_advance';
    $frdt=$cmonth;
    $todt=$cmonth;
  }
else{
    $monthtit =  date('F Y',strtotime($_SESSION['frdt']));
    $tab_emp='hist_employee';
    $tab_empded='hist_deduct';
	$tab_days = 'hist_days';
	$tab_inc = 'hist_income';
	$tab_adv = 'hist_advance';
	$frdt=date("Y-m-d", strtotime($_SESSION['frdt']));
    $todt=date("Y-m-d", strtotime($_SESSION['todt']));
	
	$sql = "SELECT LAST_DAY('".$frdt."') AS last_day";
	$row= mysql_query($sql);
	$res = mysql_fetch_assoc($row);
	$frdt = $res['last_day'];
	
	//$todt=date("Y-m-d", strtotime('2017-06-30'));
	
  }
$tab = "`tab_".$user_id."`";


include("../user/paysheet_calc.php");



$Sql1= "select distinct (deptname) from $tab order by deptname, emp_id,sal_month ";
$res = mysql_query($Sql1);

if($month!=''){
    $reporttitle="Paysheet for ".date('F Y',strtotime($frdt));
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
	<script type="text/javascript" src="../js/jquery.min.js"></script>
    
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
			    padding-right: 50px;
			
        }
  table {
            border-collapse: collapse;
		    width: 100%;
			 padding: 5px!important;
            border:none;
            font-size:11px !important;
            font-family: monospace;
		
        }
		
		table2 {
            border:0px;
		
        }
		        

		td, th {
            padding: 5px!important;
            border: 1px solid black!important;
            font-size:11px !important;
            font-family: monospace;
			 
        }
		div{font-size:11px !important;}
		
		table.padd0imp ,.padd0imp tr{border:0 !important}
		.per20inl{width:20%; display:inline-block; align:left;font-size:11px !important;
            font-family: monospace;}
			.textlower{text-transform: lowercase;}
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
            .body { padding: 10px 50px 0; }
            body{
                margin-left: 50px;
            }	
			
		
        }
			
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
		@page  
{ 
    size: auto;   /* auto is the initial value */ 

    /* this affects the margin in the printer settings */ 
    margin: 0 0 22px;  
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
<br>
<br>
<?php

include('printheader3.php');

?>
</div>

<?php //echo count($inhdar);
//echo count($dedhdar);
//echo count($days); ?>
<?php while($res1 = mysql_fetch_array($res)) {

	 $setSql1= "select * from $tab where deptname = '".$res1['deptname']."' order by emp_id,sal_month ";
	$setRec = mysql_query($setSql1);
	echo "<div class='row body page-bk' cellspacing='0' cellpadding='0'>";
     echo "<div style = 'font-size:16px!important;'>DEPARTMENT : ".$res1['deptname']."</div>"; ?>
 	
<table class="table1" width="" border-collapse border="0" >
<tr> 
<td width="2%"><b>srno</b> </td>
<td width="3%"><b>EmpId</b></td>
<td width="12%"><b>Name</b></td>
<td colspan="12" width="66%">&nbsp;</td>
<td  width="6%" align="center"><b>Total</b></td>
<td  width="6%" align="center"><b>Netsal</b></td>
</tr>
<?php
$incarray = array();

 $sr=1; 
 
 
 while($rec = mysql_fetch_array($setRec)) { 
 
	if($sr%$noofper==0)
 {
	 echo "</table></div><div class=' row body page-bk'><table class='padd0imp table2' cellspacing='0' cellpadding='0' border='0'> ";
	 echo '<tr> 
<td width="2%"><b>srno</b> </td>
<td width="3%"><b>EmpId</b></td>
<td width="12%"><b>Name</b></td>
<td colspan="12" width="66%">&nbsp;</td>
<td  width="6%" align="center"><b>Total</b></td>
<td  width="6%" align="center"><b>Netsal</b></td>
</tr>';
 }
 ?>
<tr style="border:0px!important">
<td><?php echo $sr;?></td>
<td  ><?php echo $rec['emp_id'];?></td>
<td ><?php echo $rec['emp_name'];?></td>


<td colspan="12" class="padd0" style="border: 0px solid black!important;">
<table cellspacing='0' cellpadding='0'  style="border: 0px solid black!important;">
<tr >
<th width="8%" align="left"  >Days :</th>
<td  colspan="12"  >
<?php foreach($days as $day ){$day1 = clean($day);if ($rec[$day]> 0){echo "<div class='per20inl' style='padding-right:25px'>";


if (substr(strtoupper($day),0,5) == 'PRESE'){
	 echo "PR.DAY";
}elseif (substr(strtoupper($day),0,5) == 'WEEKL'){
	 echo "W.OFF.";
}elseif ( substr(strtoupper($day),0,5) == 'OTHOU'){
	 echo "O.T.";
}else {echo substr(strtoupper($day),0,5);}
echo "<span class='".$day1." ' style='float:right'>".number_format($rec[$day],2,'.',',').'</span>&nbsp;</div>'; }}?>
</td>
</tr>
<tr>
<th width="8%" align="left" >Inc. : </th>
<td width="92% colspan="13">
<?php foreach($inhdar as $inc){$inc1 = clean($inc); if($rec[strtolower($inc)]>0) {  echo "<div class='per20inl' style='padding-right:25px'>";
IF (substr($inc,0,5)=='OVERT')
{ echo "O.T.";}

ELSE
{echo substr($inc,0,5);}

echo "<span class='".strtolower($inc1)."' style='float:right'>".number_format($rec[strtolower($inc)],2,".",",").'</span>&nbsp;</div>' ;} }?>
</td>
</tr>
<tr>
<th width="8%" align="left"  >Ded. :</th>
<td width="92% colspan="13"><?php foreach($dedhdar as $ded){$ded1 = clean($ded);if ($rec[strtolower($ded)]>0){ echo "<div class='per20inl' style='padding-right:25px'>";

if (substr($ded,0,5)=='PROF.')
{ echo "P.TAX";}
ELSE{
	echo substr($ded,0,5);}


echo "<span  style='float:right'  >".number_format($rec[strtolower($ded)],2,'.',',') .'</span><input type="hidden" value="'.$rec[strtolower($ded)].'" class="'.strtolower($ded1).'">&nbsp;</div>';} }?>
</td>
</tr>
<?php if ($advhd >0){?>
<tr>
<th width="8%" align="left" >Adv. :</th>
<td width="92% colspan="13"><?php foreach($advhdar as $adv){$adv1 = clean($adv);if ($rec[strtolower($adv)]>0){ echo "<div class='per20inl' style='padding-right:25px'>";


if (substr($adv,0,5)=='FESTI')
{ echo "F.ADV";}
else if (substr($adv,0,5)=='SALAR')
{ echo "S.ADV";}
else
{echo substr($adv,0,5); }

echo "<span  style='float:right'  >".number_format($rec[strtolower($adv)],2,".",",") .'</span><input type="hidden" value="'.$rec[strtolower($adv)].'" class="'.strtolower($adv1).'">&nbsp;</div>';} }?>
</td>
</tr>
<?php }?>

</table>

</td>
<td width="6%">
<span class="payabledays"><?php echo $rec['payabledays']; $totpayable +=$rec['payabledays'];$dtotpayable +=$rec['payabledays']; ?> </span> <br><br>
<span class="grosssalary"><?php echo number_format($rec['gross_salary'],2); $dtotgrosssal +=$rec['gross_salary'];$totgrosssal +=$rec['gross_salary']; ?></span> <br><br>
<span class="totdeduct"><?php echo number_format($rec['tot_deduct'],2); $tottotded +=$rec['tot_deduct'];$dtottotded +=$rec['tot_deduct'];?></span><br>

</td>
<td width="6%"><?php echo "<br><br><br><br>".number_format($rec['netsalary'],2); $totnetsalary +=$rec['netsalary'];$dtotnetsalary +=$rec['netsalary'];?> </td>
</tr>


   
<?php $sr++;  }

$sql = "select ";
foreach($days as $day ){$sql .=" sum(`".$day."`) as '".$day."',";}
foreach($inhdar as $inc){$sql .=" sum(`".$inc."`) as '".strtolower($inc)."',";}
foreach($dedhdar as $ded){$sql .=" sum(`".$ded."`) as '".strtolower($ded)."',";}
foreach($advhdar as $adv){$sql .=" sum(`".$adv."`) as '".strtolower($adv)."',";}

$sql .=" sum(payabledays) as payabledays,sum(tot_deduct) as tot_deduct,sum(netsalary) as netsalary,sum(gross_salary) as gross_salary from $tab where deptname = '".$res1['deptname']."'";

$res3 = mysql_query($sql);
$res4 = mysql_fetch_array($res3);
?>

<tr>
<td> &nbsp; </td>
<td></td>
<td>DEPT. Total</td>
<td colspan="12" class="padd0" >
<table class="padd0imp">
<tr>


<th width="8%" align="left"  >Days :</th>
<td  colspan="12"  >
<?php foreach($days as $day ){$day1 = clean($day);if ($res4[$day]> 0){echo "<div class='per20inl' style='padding-right:15px'>";


if (substr(strtoupper($day),0,5) == 'PRESE'){
	 echo "PR.DAY";
}elseif (substr(strtoupper($day),0,5) == 'WEEKL'){
	 echo "W.OFF.";
}elseif ( substr(strtoupper($day),0,5) == 'OTHOU'){
	 echo "O.T.";
}else {echo substr(strtoupper($day),0,5);}

echo "<span class='".$day1." ' style='float:right'>".number_format($res4[$day],2,'.',',').'</span>&nbsp;</div>'; }}?>
</td>
</tr>
<tr>
<th width="8%" align="left" >Inc. : </th>
<td colspan="12">
<?php foreach($inhdar as $inc){$inc1 = clean($inc); if($res4[strtolower($inc)]>0) {  echo "<div class='per20inl' style='padding-right:15px'>";


IF (substr($inc,0,5)=='OVERT')
{ echo "O.T.";}

ELSE
{echo substr($inc,0,5);}



echo "<span class='".strtolower($inc1)."' style='float:right'>".number_format($res4[strtolower($inc)],2,".",",").'</span>&nbsp;</div>' ;} }?>
</td>
</tr>
<tr>
<th width="8%" align="left"  >Ded. :</th>
<td colspan="12"><?php foreach($dedhdar as $ded){$ded1 = clean($ded);if ($res4[strtolower($ded)]>0){ echo "<div class='per20inl' style='padding-right:15px'>";


if (substr($ded,0,5)=='PROF.')
{ echo "P.TAX";}
ELSE{
	echo substr($ded,0,5);}

echo "<span  style='float:right'  >".number_format($res4[strtolower($ded)],2,'.',',') .'</span><input type="hidden" value="'.$rec[strtolower($ded)].'" class="'.strtolower($ded1).'">&nbsp;</div>';} }?>
</td>
</tr>
<?php if ($advhd >0){?>
<tr>
<th width="8%" align="left" >Adv. :</th>
<td colspan="12"><?php foreach($advhdar as $adv){$adv1 = clean($adv);if ($res4[strtolower($adv)]>0){ echo "<div class='per20inl' style='padding-right:15px'>";

if (substr($adv,0,5)=='FESTI')
{ echo "F.ADV";}
else if (substr($adv,0,5)=='SALAR')
{ echo "S.ADV";}
else
{echo substr($adv,0,5); }


echo "<span  style='float:right'  >".number_format($res4[strtolower($adv)],2,".",",") .'</span><input type="hidden" value="'.$rec[strtolower($adv)].'" class="'.strtolower($adv1).'">&nbsp;</div>';} } ?></td>
</tr>
<?php }?>

</table>

</td>
<td width="6%">
<span ><?php echo $dtotpayable; ?></span> <br><br>
<span ><?php echo number_format($dtotgrosssal,2);?></span> <br><br>
<span ><?php echo number_format($dtottotded,2);?></span><br>

</td>
<td width="6%"><?php echo "<br><br><br><br>".number_format($dtotnetsalary,2);$dtotpayable=0;$dtotgrosssal=0;$dtottotded=0;$dtotnetsalary=0;?> </td>
</tr>
</table>
</div>




<?php }
?><!--- for total ----->

<div class = "row body">
<table class="table1" width="" border-collapse border="0" >
<tr> 
<td width="2%"><b>srno</b> </td>
<td width="3%"><b>EmpId</b></td>
<td width="12%"><b>Name</b></td>
<td colspan="12" width="66%">&nbsp;</td>
<td  width="6%" align="center"><b>Total</b></td>
<td  width="6%" align="center"><b>Netsal</b></td>
</tr>


   
<?php $sr++;  

$sql = "select ";
foreach($days as $day ){$sql .=" sum(`".$day."`) as '".$day."',";}
foreach($inhdar as $inc){$sql .=" sum(`".$inc."`) as '".strtolower($inc)."',";}
foreach($dedhdar as $ded){$sql .=" sum(`".$ded."`) as '".strtolower($ded)."',";}
foreach($advhdar as $adv){$sql .=" sum(`".$adv."`) as '".strtolower($adv)."',";}

$sql .=" sum(payabledays) as payabledays,sum(tot_deduct) as tot_deduct,sum(netsalary) as netsalary,sum(gross_salary) as gross_salary from $tab ";

$res3 = mysql_query($sql);
$res4 = mysql_fetch_array($res3);
?>

<tr>
<td> &nbsp; </td>
<td></td>
<td>Grand Total</td>
<td colspan="12" class="padd0" >
<table class="padd0imp">
<tr>


<th width="8%" align="left"  >Days :</th>
<td  colspan="12"  >
<?php foreach($days as $day ){$day1 = clean($day);if ($res4[$day]> 0){echo "<div class='per20inl' style='padding-right:15px'>";


if (substr(strtoupper($day),0,5) == 'PRESE'){
	 echo "PR.DAY";
}elseif (substr(strtoupper($day),0,5) == 'WEEKL'){
	 echo "W.OFF.";
}elseif ( substr(strtoupper($day),0,5) == 'OTHOU'){
	 echo "O.T.";
}else {echo substr(strtoupper($day),0,5);}

echo "<span class='".$day1." ' style='float:right'>".number_format($res4[$day],2,'.',',').'</span>&nbsp;</div>'; }}?>
</td>
</tr>
<tr>
<th width="8%" align="left" >Inc. : </th>
<td colspan="12">
<?php foreach($inhdar as $inc){$inc1 = clean($inc); if($res4[strtolower($inc)]>0) {  echo "<div class='per20inl' style='padding-right:15px'>";


IF (substr($inc,0,5)=='OVERT')
{ echo "O.T.";}

ELSE
{echo substr($inc,0,5);}



echo "<span class='".strtolower($inc1)."' style='float:right'>".number_format($res4[strtolower($inc)],2,".",",").'</span>&nbsp;</div>' ;} }?>
</td>
</tr>
<tr>
<th width="8%" align="left"  >Ded. :</th>
<td colspan="12"><?php foreach($dedhdar as $ded){$ded1 = clean($ded);if ($res4[strtolower($ded)]>0){ echo "<div class='per20inl' style='padding-right:15px'>";


if (substr($ded,0,5)=='PROF.')
{ echo "P.TAX";}
ELSE{
	echo substr($ded,0,5);}

echo "<span  style='float:right'  >".number_format($res4[strtolower($ded)],2,'.',',') .'</span><input type="hidden" value="'.$rec[strtolower($ded)].'" class="'.strtolower($ded1).'">&nbsp;</div>';} }?>
</td>
</tr>
<?php if ($advhd >0){?>
<tr>
<th width="8%" align="left" >Adv. :</th>
<td colspan="12"><?php foreach($advhdar as $adv){$adv1 = clean($adv);if ($res4[strtolower($adv)]>0){ echo "<div class='per20inl' style='padding-right:15px'>";

if (substr($adv,0,5)=='FESTI')
{ echo "F.ADV";}
else if (substr($adv,0,5)=='SALAR')
{ echo "S.ADV";}
else
{echo substr($adv,0,5); }


echo "<span  style='float:right'  >".number_format($res4[strtolower($adv)],2,".",",") .'</span><input type="hidden" value="'.$rec[strtolower($adv)].'" class="'.strtolower($adv1).'">&nbsp;</div>';} } ?></td>
</tr>
<?php }?>

</table>

</td>
<td width="6%">
<span ><?php echo $totpayable; ?></span> <br><br>
<span ><?php echo number_format($totgrosssal,2);?></span> <br><br>
<span ><?php echo number_format($tottotded,2);?></span><br>

</td>
<td width="6%"><?php echo "<br><br><br><br>".number_format($totnetsalary,2);?> </td>
</tr>
</table>
</div>













































<script>
    function myFunction() {
        window.print();
    }
	
</script>



<?php function clean($string) {
   $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
   $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.

   return preg_replace('/-+/', '-', $string); // Replaces multiple hyphens with single one.
}?>
</body>
</html>
