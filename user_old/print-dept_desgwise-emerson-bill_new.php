<?php

//session_start();

//error_reporting(0);

$clientid=$_POST['client'];
$clientdtl = $userObj->displayClient($clientid);
$client_name = $clientdtl['client_name'];
$current_month = $clientdtl['current_month'];

$setExcelName ="department_wise_emerson_bill";

$client = $_POST['client'];
$tab_client = $client;

if($client==12 || $client==14){
	$client = "12,14";
	$tab_client = "1214";
}

$frdt= $_SESSION['emer_month'];
if ($frdt==$current_month)
	{$tab = "tran_emerson_bill".$tab_client;
	$frdt=$current_month;}
else
	{$tab = "hist_emerson_bill".$tab_client;}	

header("Content-type: application/octet-stream");

header("Content-Disposition: attachment; filename=".$setExcelName.".xls");

header("Pragma: no-cache");
header("Expires: 0"); 
?>
<style>
th{border:1px solid #000; padding:5px}
th{background-color:#ccc} 

        table, td, {
            padding: 3px!important;
            border: 1px solid black!important;
            font-size:10px !important;
            font-family: monospace;
			align:right!important;

        }



</style>
<div class="btnprnt">
    <button class="submitbtn" onclick="myFunction()">Print</button>
    <button class="submitbtn"  onclick="history.go(-1);" >Cancel</button>
</div>

<table width="100%" >
<tr>
<th> Sr.no </th>
<th> CC Code </th>
<th> CC Name</th>
<th> Work Desc.</th>
<th> </th>
<th> Head Count</th>
<th> Man Days</th>
<th> Rate </th>
<th> Rs.</th>
<th> ESI on OT <br>4.75%</th>
<th> Supervision Charges </th>
<th> Sub Total (A) </th>
<th> Service Charges @3% (B) </th>
<th> Total A+B (C)</th>
<th> CGst </th>
<th> SGst</th>
<th> Total Gst 18% (D)</th>
<th> Grand Total (C+D)</th>
</tr>

<?php
$dman_head_count = 0;$dot_head_count= 0;$dman_paydays = 0;$dot_paydays=0;$dman_rs=0;$dot_rs=0;$dman_esi=0;$dot_esi=0;$dman_sup = 0;$dot_sup = 0;$dman_sub = 0;$dot_sub =0;$dman_service= 0;$dot_service = 0;$dman_ab = 0;$dot_ab = 0;$dman_cgst = 0;$dman_sgst = 0;$dot_cgst = 0;$dot_sgst = 0;$dman_gst=0;$dot_gst = 0;$dman_grand = 0;$dot_grand = 0;
$gman_head_count = 0;$got_head_count= 0;$gman_paydays = 0;$got_paydays=0;$gman_rs=0;$got_rs=0;$gman_esi=0;$got_esi=0;$gman_sup = 0;$got_sup = 0;$gman_sub = 0;$got_sub =0;$gman_service= 0;$got_service = 0;$gman_ab = 0;$got_ab = 0;$gman_cgst = 0;$gman_sgst = 0;$got_cgst = 0;$got_sgst = 0;$gman_gst=0;$got_gst = 0;$gman_grand = 0;$got_grand = 0;

  $sql = "SELECT  desg_id,dept_id,`dept_name`,desg_name, client_name, client_id,count(emp_id) as headcount,sum( `payabledays_sal`) as payabledays_sal,otrate_sal,sum( `othours_sal`) as othours_sal,sum(  `overtime_sal`) as overtime_sal,sum(`basic_daily_annex`) as basic_daily_annex, sum(`da_daily_annex`) as da_daily_annex, sum(`hra_daily_annex`) as hra_daily_annex, sum(`super_skill_allow_daily_annex`) as super_skill_allow_daily_annex , sum(supplli_allow_daily_annex) as supplli_allow_daily_annex, sum(`other_allow_daily_annex`) as other_allow_daily_annex,sum(total_a_annex) as total_a_annex,sum(total_d_annex) as total_d_annex, sum(bill_rate_annex) as bill_rate_annex,sum(total_a_annex+overtime_sal) as gross, sum(`pf_annex`) as pf_annex,sum( `bonus_Annex`+ `esi_annex`+ `lww_annex`+ `lwf_annex` +`safety_annex`+ `soap_annex`+ `training_annex`) as other_charges,sum(supervisioncharges) as supervisioncharges,sum(servicecharges) as servicecharges,sum(cgst_annex) as cgst_annex,sum(sgst_annex) as sgst_annex,sum(cgst_annex+sgst_annex) as gst_annex, sum(`tot_amount_annex`) as tot_amount_annex  FROM $tab where emp_name !='STD_Annex' and sal_month = '$frdt'  group by  dept_name,desg_id";

$res1 = mysql_query($sql);
 $cnt1 = mysql_num_rows($res1);
 
echo "
<div align='center'><h2>Department Category Wise Summary Report For ".date("M Y ", strtotime($frdt))."</h2></div>
<div align='center'><h2><b>Client : ". $client_name."</h2></div>" ;
$prev_dept_id = "";
$srno =1;
while ($row = mysql_fetch_array($res1)){
	if ($prev_dept_id != $row['dept_id'] && $prev_dept_id != "")
	{
	?>
	<tr>
		<th align= 'right'><?php echo "";?></th>
		<th align= 'right'><?php echo "";?></th>
		<th align= 'right'><?php echo "";?></th>
		<th align= 'right'><?php echo "DEPT Total : ";?></th>
		<th align= 'right'><?php echo "ManDays";?></th>
		<th align= 'right'><?php echo $dman_head_count;?></th>
		<th align= 'right'><?php echo number_format($dman_paydays,2,".",",");?></th>
		<th align= 'right'><?php echo "-";?></th>
		<th align= 'right'><?php echo number_format($dman_rs,2,".",",");?></th>
		<th align= 'right'><?php echo "-";?></th>
		<th align= 'right'><?php echo number_format($dman_sup,2,".",",");?></th>
		<th align= 'right'><?php echo number_format($dman_sub,2,".",",");?></th>
		<th align= 'right'><?php echo number_format($dman_service,2,".",",");?></th>
		<th align= 'right'><?php echo number_format($dman_ab,2,".",",");?></th>
		<th align= 'right'><?php echo number_format($dman_cgst,2,".",",");?></th>
		<th align= 'right'><?php echo number_format($dman_sgst,2,".",",");?></th>
		<th align= 'right'><?php echo number_format($dman_gst,2,".",",");?></th>
		<th align= 'right'><?php echo number_format($dman_grand,2,".",",");?></th>
	</tr>
	<tr>
		<th align= 'right'><?php echo "";?></th>
		<th align= 'right'><?php echo "";?></th>
		<th align= 'right'><?php echo "";?></th>
		<th align= 'right'><?php echo " ";?></th>
		<th align= 'right'><?php echo "OT Hours";?></th>
		<th align= 'right'><?php echo "-";?></th>
		<th align= 'right'><?php echo number_format($dot_paydays,2,".",",");?></th>
		<th align= 'right'><?php echo "-";?></th>
		<th align= 'right'><?php echo number_format($dot_rs,2,".",",");?></th>
		<th align= 'right'><?php echo number_format($dot_esi,2,".",",");?></th>
		<th align= 'right'><?php echo number_format($dot_sup,2,".",",");?></th>
		<th align= 'right'><?php echo number_format($dot_sub,2,".",",");?></th>
		<th align= 'right'><?php echo number_format($dot_service,2,".",",");?></th>
		<th align= 'right'><?php echo number_format($dot_ab,2,".",",");?></th>
		<th align= 'right'><?php echo number_format($dot_cgst,2,".",",");?></th>
		<th align= 'right'><?php echo number_format($dot_sgst,2,".",",");?></th>
		<th align= 'right'><?php echo number_format($dot_gst,2,".",",");?></th>
		<th align= 'right'><?php echo number_format($dot_grand,2,".",",");?></th>
	</tr>
	
	<?php 
	
	$gman_head_count += $dman_head_count;$got_head_count+= $dot_head_count;$gman_paydays +=$dman_paydays;$got_paydays+=$dot_paydays;$gman_rs+=$dman_rs;$got_rs+=$dot_rs;$gman_esi+=$dman_esi;$got_esi+=$dot_esi;$gman_sup +=$dman_sup ;$got_sup +=$dot_sup;$gman_sub += $dman_sub;$got_sub +=$dot_sub ;$gman_service+=$dman_service;$got_service+=$dot_service;$gman_ab +=$dman_ab ;$got_ab += $dot_ab ;$gman_cgst +=$dman_cgst;$gman_sgst +=$dman_sgst;$got_sgst += $dot_sgst ;$gman_gst+=$dman_gst;$got_gst += $dot_gst;$gman_grand += $dman_grand ;$got_grand += $dot_grand;
	
	$dman_head_count = 0;$dot_head_count= 0;$dman_paydays = 0;$dot_paydays=0;$dman_rs=0;$dot_rs=0;$dman_esi=0;$dot_esi=0;$dman_sup = 0;$dot_sup = 0;$dman_sub = 0;$dot_sub =0;$dman_service= 0;$dot_service = 0;$dman_ab = 0;$dot_ab = 0;$dman_cgst = 0;$dman_sgst = 0;$dot_cgst = 0;$dot_sgst = 0;$dman_gst=0;$dot_gst = 0;$dman_grand = 0;$dot_grand = 0;
	}
	
	if ($prev_dept_id != $row['dept_id'] )
	{
     ?>
	<tr>
	<td align='right'><?php echo $srno;?></td>
	<td align= 'right'><?php echo substr($row['dept_name'],0,4);
	?></td>
	<td align= 'right'><?php echo $row['dept_name'];?></td>
	<?php }
	else {
	?>		
	<tr>
	<td align='right'><?php echo " ";?></td>
	<td align= 'right'><?php echo " ";?></td>
	<td align= 'right'><?php echo " ";?></td>
	<?php }
	$prev_dept_id = $row['dept_id'];
	?>
	
	<td align= 'right'><?php echo substr($row['desg_name'],7,20);?></td>
	<td align= 'right'><?php echo "Man Days";?></td>
	<td align= 'right'><?php echo $row['headcount'];?></td>
	<td align= 'right'><?php echo number_format($row['payabledays_sal'],2,".",",");
	$dman_paydays +=$row['payabledays_sal'];
	$dman_head_count +=$row['headcount'];
	$sql1= "select rounded_annex from $tab where emp_name = 'STD_Annex'  and  desg_id= '".$row['desg_id']."'";
	$row_desg=mysql_query($sql1);
	$row_desg1 = mysql_fetch_array($row_desg);
$man_rs = 	round($row_desg1['rounded_annex']*round($row['payabledays_sal'],2),2);
	$dman_rs +=$man_rs;
	$dman_sup+=$row['supervisioncharges'];
	
	$man_sub = round($man_rs+$row['supervisioncharges'],2);
	$man_service = round($man_sub*.03,2);
	$man_ab = $man_sub+$man_service;
	$man_cgst = round($man_ab*.09,0);
	$man_sgst = round($man_ab*.09,0);
	$man_gst = $man_cgst+$man_sgst;
	$man_grand = $man_gst+$man_ab;
	
	$dman_sub+=$man_sub;
	$dman_service+=$man_service;
	$dman_ab+=$man_ab;
	$dman_cgst+=$man_cgst;
	$dman_sgst+=$man_sgst;
	$dman_gst+=$man_gst;
	$dman_grand+=$man_grand;
	
	
	
	
	
	?></td>
	<td align= 'right'><?php //echo number_format(round($row['bill_rate_annex']/$row['payabledays_sal'],0),2,".",",");
	echo number_format($row_desg1['rounded_annex'],2,".",",");?></td>
	<td align= 'right'><?php echo number_format($man_rs,2,".",",");?></td>
	<td align= 'right'><?php echo "-";?></td>
	<td align= 'right'><?php echo number_format($row['supervisioncharges'],2,".",",");?></td>
	<td align= 'right'><?php echo number_format($man_sub,2,".",",");?></td>
	<td align= 'right'><?php echo number_format($man_service,2,".",",");?></td>
	<td align= 'right'><?php echo number_format($man_ab,2,".",",");?></td>
	<td align= 'right'><?php echo number_format($man_cgst,2,".",",");?></td>
	<td align= 'right'><?php echo number_format($man_sgst,2,".",",");?></td>
	<td align= 'right'><?php echo number_format($man_gst,2,".",",");?></td>
	<td align= 'right'><?php echo number_format($man_grand,2,".",",");?></td>
</tr>
<tr>
	<td align='right'><?php echo " ";?></td>
	<td align= 'right'><?php echo " ";?></td>
	<td align= 'right'><?php echo " ";?></td>
	<td align= 'right'><?php echo substr($row['desg_name'],7,20);?></td>
	<td align= 'right'><?php echo "OT HRs.";?></td>
	<td align= 'right'><?php echo " ";?></td>
	
	<td align= 'right'><?php echo number_format($row['othours_sal'],2,".",",");?></td>
	<td align= 'right'><?php echo number_format($row['otrate_sal'],2,".",",");
	$dot_paydays +=$row['othours_sal'];
	$dot_head_count +=0;
	$dot_rs +=round($row['overtime_sal'],2);
	$ot_esi= round(round($row['overtime_sal'],2)*0.0475,2);
	$ot_sub = round($row['overtime_sal']+$ot_esi,2);
	$ot_service = round($ot_sub*.03,2);
	$ot_ab = $ot_sub+$ot_service;
	$ot_cgst = round($ot_ab*.09,2);
	$ot_sgst = round($ot_ab*.09,2);
	$ot_gst = $ot_cgst+$ot_sgst;
	$ot_grand = $ot_gst+$ot_ab;
	
	$dot_esi+= $ot_esi;
	$dot_sup+=0;
	$dman_sub+=$ot_sub;
	$dot_service+=$ot_service;
	$dot_ab+=$ot_ab;
	$dot_cgst+=$ot_cgst;
	$dot_sgst+=$ot_sgst;
	$dot_gst+=$ot_gst;
	$dot_grand+=$ot_grand;
		
	?></td>
	<td align= 'right'><?php echo number_format($row['overtime_sal'],2,".",",");?></td>
	<td align= 'right'><?php echo number_format($ot_esi,2,".",",");?></td>
	<td align= 'right'><?php echo " ";?></td>
	<td align= 'right'><?php echo number_format($ot_sub,2,".",",");?></td>
	<td align= 'right'><?php echo number_format($ot_service,2,".",",");?></td>
	<td align= 'right'><?php echo number_format($ot_ab,2,".",",");?></td>
	<td align= 'right'><?php echo number_format($ot_cgst,2,".",",");?></td>
	<td align= 'right'><?php echo number_format($ot_sgst,2,".",",");?></td>
	<td align= 'right'><?php echo number_format($ot_gst,2,".",",");?></td>
	<td align= 'right'><?php echo number_format($ot_grand,2,".",",");?></td>
</tr>

<?php } 

$gman_head_count += $dman_head_count;$got_head_count+= $dot_head_count;$gman_paydays +=$dman_paydays;$got_paydays+=$dot_paydays;$gman_rs+=$dman_rs;$got_rs+=$dot_rs;$gman_esi+=$dman_esi;$got_esi+=$dot_esi;$gman_sup +=$dman_sup ;$got_sup +=$dot_sup;$gman_sub += $dman_sub;$got_sub +=$dot_sub ;$gman_service+=$dman_service;$got_service+=$dot_service;$gman_ab +=$dman_ab ;$got_ab += $dot_ab ;$gman_cgst +=$dman_cgst;$gman_sgst +=$dman_sgst;$got_sgst += $dot_sgst ;$gman_gst+=$dman_gst;$got_gst += $dot_gst;$gman_grand += $dman_grand ;$got_grand += $dot_grand;
	
?>



<tr>
		<th align= 'right'><?php echo "";?></th>
		<th align= 'right'><?php echo "";?></th>
		<th align= 'right'><?php echo "";?></th>
		<th align= 'right'><?php echo "DEPT Total : ";?></th>
		<th align= 'right'><?php echo "ManDays";?></th>
		<th align= 'right'><?php echo $dman_head_count;?></th>
		<th align= 'right'><?php echo number_format($dman_paydays,2,".",",");?></th>
		<th align= 'right'><?php echo "-";?></th>
		<th align= 'right'><?php echo number_format($dman_rs,2,".",",");?></th>
		<th align= 'right'><?php echo "-";?></th>
		<th align= 'right'><?php echo number_format($dman_sup,2,".",",");?></th>
		<th align= 'right'><?php echo number_format($dman_sub,2,".",",");?></th>
		<th align= 'right'><?php echo number_format($dman_service,2,".",",");?></th>
		<th align= 'right'><?php echo number_format($dman_ab,2,".",",");?></th>
		<th align= 'right'><?php echo number_format($dman_cgst,2,".",",");?></th>
		<th align= 'right'><?php echo number_format($dman_sgst,2,".",",");?></th>
		<th align= 'right'><?php echo number_format($dman_gst,2,".",",");?></th>
		<th align= 'right'><?php echo number_format($dman_grand,2,".",",");?></th>
	</tr>
	<tr>
		<th align= 'right'><?php echo "";?></th>
		<th align= 'right'><?php echo "";?></th>
		<th align= 'right'><?php echo "";?></th>
		<th align= 'right'><?php echo "";?></th>
		<th align= 'right'><?php echo "OT Hours";?></th>
		<th align= 'right'><?php echo "-";?></th>
		<th align= 'right'><?php echo number_format($dot_paydays,2,".",",");?></th>
		<th align= 'right'><?php echo "-";?></th>
		<th align= 'right'><?php echo number_format($dot_rs,2,".",",");?></th>
		<th align= 'right'><?php echo number_format($dot_esi,2,".",",");?></th>
		<th align= 'right'><?php echo number_format($dot_sup,2,".",",");?></th>
		<th align= 'right'><?php echo number_format($dot_sub,2,".",",");?></th>
		<th align= 'right'><?php echo number_format($dot_service,2,".",",");?></th>
		<th align= 'right'><?php echo number_format($dot_ab,2,".",",");?></th>
		<th align= 'right'><?php echo number_format($dot_cgst,2,".",",");?></th>
		<th align= 'right'><?php echo number_format($dot_sgst,2,".",",");?></th>
		<th align= 'right'><?php echo number_format($dot_gst,2,".",",");?></th>
		<th align= 'right'><?php echo number_format($dot_grand,2,".",",");?></th>
	</tr>
	
<tr>
		<th align= 'right'><?php echo "";?></th>
		<th align= 'right'><?php echo "";?></th>
		<th align= 'right'><?php echo "";?></th>
		<th align= 'right'><?php echo "GRAND Total : ";?></th>
		<th align= 'right'><?php echo "ManDays";?></th>
		<th align= 'right'><?php echo $gman_head_count;?></th>
		<th align= 'right'><?php echo number_format($gman_paydays,2,".",",");?></th>
		<th align= 'right'><?php echo "-";?></th>
		<th align= 'right'><?php echo number_format($gman_rs,2,".",",");?></th>
		<th align= 'right'><?php echo "-";?></th>
		<th align= 'right'><?php echo number_format($gman_sup,2,".",",");?></th>
		<th align= 'right'><?php echo number_format($gman_sub,2,".",",");?></th>
		<th align= 'right'><?php echo number_format($gman_service,2,".",",");?></th>
		<th align= 'right'><?php echo number_format($gman_ab,2,".",",");?></th>
		<th align= 'right'><?php echo number_format($gman_cgst,2,".",",");?></th>
		<th align= 'right'><?php echo number_format($gman_sgst,2,".",",");?></th>
		<th align= 'right'><?php echo number_format($gman_gst,2,".",",");?></th>
		<th align= 'right'><?php echo number_format($gman_grand,2,".",",");?></th>
	</tr>
	<tr>
		<th align= 'right'><?php echo "";?></th>
		<th align= 'right'><?php echo "";?></th>
		<th align= 'right'><?php echo "";?></th>
		<th align= 'right'><?php echo "";?></th>
		<th align= 'right'><?php echo "OT Hours";?></th>
		<th align= 'right'><?php echo "-";?></th>
		<th align= 'right'><?php echo number_format($got_paydays,2,".",",");?></th>
		<th align= 'right'><?php echo "-";?></th>
		<th align= 'right'><?php echo number_format($got_rs,2,".",",");?></th>
		<th align= 'right'><?php echo number_format($got_esi,2,".",",");?></th>
		<th align= 'right'><?php echo number_format($got_sup,2,".",",");?></th>
		<th align= 'right'><?php echo number_format($got_sub,2,".",",");?></th>
		<th align= 'right'><?php echo number_format($got_service,2,".",",");?></th>
		<th align= 'right'><?php echo number_format($got_ab,2,".",",");?></th>
		<th align= 'right'><?php echo number_format($got_cgst,2,".",",");?></th>
		<th align= 'right'><?php echo number_format($got_sgst,2,".",",");?></th>
		<th align= 'right'><?php echo number_format($got_gst,2,".",",");?></th>
		<th align= 'right'><?php echo number_format($got_grand,2,".",",");?></th>
	</tr>



</table>
     <script>
    function myFunction() {
        window.print();
    }
</script>
