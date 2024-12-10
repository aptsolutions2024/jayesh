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
	{$tab = "tran_emerson_bill".$tab_client;}
else
	{$tab = "hist_emerson_bill".$tab_client;}	

 
 header("Content-type: application/octet-stream");

header("Content-Disposition: attachment; filename=".$setExcelName.".xls");

header("Pragma: no-cache");
header("Expires: 0"); 
 ?>
<style>
table,tr,th,td{border:1px solid #000; padding:5px}
th{background-color:#ccc}
</style>
<table width="100%" >
<tr>
<th> Sr.no </th>
<th> CC Code </th>
<th> Department</th>
<th></th>
<th> Head Count</th>
<th> Payable Days</th>
<th> Wages </th>
<th> OT Hours</th>
<th> OT Sal</th>
<th> Gross </th>
<th> PF </th>
<th> Other Charges </th>
<th> Bill Amt.</th>
<th> Supervision Char. </th>
<th> Service Char.</th>
<th> Total (A) </th>
<th> CGst </th>
<th> SGst</th>
<th> Total Amt.</th>
</tr>

<?php
 $sql = "SELECT  dept_id,`dept_name`, client_name, client_id,count(emp_id) as headcount,sum( `payabledays_sal`)payabledays_sal,sum( `othours_sal`) as othours_sal,sum(  `overtime_sal`) as overtime_sal,sum(`basic_daily_annex`) as basic_daily_annex, sum(`da_daily_annex`) as da_daily_annex, sum(`hra_daily_annex`) as hra_daily_annex, sum(`super_skill_allow_daily_annex`) as super_skill_allow_daily_annex , sum(supplli_allow_daily_annex) as supplli_allow_daily_annex, sum(`other_allow_daily_annex`) as other_allow_daily_annex,sum(total_a_annex) as total_a_annex, sum(total_a_annex+overtime_sal) as gross, sum(`pf_annex`) as pf_annex,sum( `bonus_Annex`+ `esi_annex`+ `lww_annex`+ `lwf_annex` +`safety_annex`+ `soap_annex`+ `training_annex`+tds_annex) as other_charges,sum(supervisioncharges) as supervisioncharges,sum(servicecharges) as servicecharges,sum(cgst_annex) as cgst_annex,sum(sgst_annex) as sgst_annex,sum(cgst_annex+sgst_annex) as gst_annex, sum(`tot_amount_annex`) as tot_amount_annex  FROM $tab where emp_name !='STD_Annex' and sal_month = '$frdt' group by  dept_name,client_name";


$res1 = mysql_query($sql);
 $cnt1 = mysql_num_rows($res1);
 
echo "
<div align='center'><h2>Department Wise Summary Report For ".date("M Y ", strtotime($frdt))."</h2></div>
<div align='center'><h2><b>Client : ". $client_name."</h2></div>" ;
$prev_dept_id = "";
$srno =1;
while ($row = mysql_fetch_array($res1)){
	if ($tab_client=="1214"){
	if ($prev_dept_id != $row['dept_id'] && $prev_dept_id != "")
	{
		
	
		 $sql = "SELECT  `dept_name`, client_name, count(emp_id) as headcount,sum( `payabledays_sal`)payabledays_sal,sum( `othours_sal`) as othours_sal,sum(  `overtime_sal`) as overtime_sal,sum(`basic_daily_annex`) as basic_daily_annex, sum(`da_daily_annex`) as da_daily_annex, sum(`hra_daily_annex`) as hra_daily_annex, sum(`super_skill_allow_daily_annex`) as super_skill_allow_daily_annex , sum(supplli_allow_daily_annex) as supplli_allow_daily_annex, sum(`other_allow_daily_annex`) as other_allow_daily_annex, sum(total_a_annex) as total_a_annex,sum(total_a_annex+overtime_sal) as gross, sum(`pf_annex`) as pf_annex,sum( `bonus_Annex`+ `esi_annex`+ `lww_annex`+ `lwf_annex` +`safety_annex`+ `soap_annex`+ `training_annex`) as other_charges,sum(supervisioncharges) as supervisioncharges,sum(servicecharges) as servicecharges,sum(cgst_annex) as cgst_annex,sum(sgst_annex) as sgst_annex,sum(cgst_annex+sgst_annex) as gst_annex, sum(`tot_amount_annex`) as tot_amount_annex  FROM $tab where emp_name !='STD_Annex' and sal_month = '$frdt' and dept_id = ".$prev_dept_id;
		$res2 = mysql_query($sql);
		$row2 = mysql_fetch_array($res2);
?>
	<tr>
	
		<th align= 'right'><?php echo "";?></th>
		<th align= 'right'><?php echo "";?></th>
		<th align= 'right'><?php echo "DEPT Total : ";?></th>
		<th align= 'right'><?php //echo $row2['client_name'];?></th>
		<th align= 'right'><?php echo $row2['headcount'];?></th>
		<th align= 'right'><?php echo number_format($row2['payabledays_sal'],2,".",",");?></th>
		<th align= 'right'><?php echo number_format($row2['total_a_annex'],2,".",",");?></th>
		<th align= 'right'><?php echo number_format($row2['othours_sal'],2,".",",");?></th>
		<th align= 'right'><?php echo number_format($row2['overtime_sal'],2,".",",");?></th>
		<th align= 'right'><?php echo number_format($row2['gross'],2,".",",");?></th>
		<th align= 'right'><?php echo number_format($row2['pf_annex'],2,".",",");?></th>
		<th align= 'right'><?php echo number_format($row2['other_charges'],2,".",",");?></th>
		<th align= 'right'><?php echo number_format($row2['gross']+$row2['pf_annex']+$row2['other_charges'],2,".",",");?></th>
		<th align= 'right'><?php echo number_format($row2['supervisioncharges'],2,".",",");?></th>
		<th align= 'right'><?php echo number_format($row2['servicecharges'],2,".",",");?></th>
		<th align= 'right'><?php echo number_format($row2['gross']+$row2['pf_annex']+$row2['other_charges']+$row2['servicecharges']+$row2['supervisioncharges'],2,".",",");?></th>
		
		<th align= 'right'><?php echo number_format($row2['cgst_annex'],2,".",",");?></th>
		<th align= 'right'><?php echo number_format($row2['sgst_annex'],2,".",",");?></th>
		<th align= 'right'><?php echo number_format($row2['gross']+$row2['pf_annex']+$row2['other_charges']+$row2['servicecharges']+$row2['supervisioncharges']+$row2['cgst_annex']+$row2['sgst_annex'],2,".",",");?></th>
	</tr>	
    <?php 
	} }
	
	if ($prev_dept_id != $row['dept_id'])
	{
	
	?>
	
	<tr>
	<td align='right'><?php echo $srno;?></td>
	<td align= 'right'><?php echo substr($row['dept_name'],0,4);?></td>
	<td align= 'right'><?php echo $row['dept_name'];?></td>
	
	<?php $srno++;}
	else
	{?>
	<td align='right'><?php echo " ";?></td>
	<td align='right'><?php echo " ";?></td>
	<td align='right'><?php echo " ";?></td>
		
	<?php }
	$prev_dept_id = $row['dept_id'];
	
	
	
	?>
	<td align= 'right'><?php if ($row['client_id']==12 ) {echo "Manu.";} elseif ($row['client_id']==14 ) {echo "Serv.";} elseif  ($row['client_id']==15 ) {echo "Motor";} else {echo "AAU.";}?></td>
	<td align= 'right'><?php echo $row['headcount'];?></td>
	<td align= 'right'><?php echo number_format($row['payabledays_sal'],2,".",",");?></td>
	<td align= 'right'><?php echo number_format($row['total_a_annex'],2,".",",");?></td>
	<td align= 'right'><?php echo number_format($row['othours_sal'],2,".",",");?></td>
	<td align= 'right'><?php echo number_format($row['overtime_sal'],2,".",",");?></td>
	<td align= 'right'><?php echo number_format($row['gross'],2,".",",");?></td>
	<td align= 'right'><?php echo number_format($row['pf_annex'],2,".",",");?></td>
	<td align= 'right'><?php echo number_format($row['other_charges'],2,".",",");?></td>
	<td align= 'right'><?php echo number_format($row['gross']+$row['pf_annex']+$row['other_charges'],2,".",",");?></td>
	<td align= 'right'><?php echo number_format($row['supervisioncharges'],2,".",",");?></td>
	<td align= 'right'><?php echo number_format($row['servicecharges'],2,".",",");?></td>
	<td align= 'right'><?php echo number_format($row['gross']+$row['pf_annex']+$row['other_charges']+$row['supervisioncharges']+$row['servicecharges'],2,".",",");?></td>
	
	
	<td align= 'right'><?php echo number_format($row['cgst_annex'],2,".",",");?></td>
	<td align= 'right'><?php echo number_format($row['sgst_annex'],2,".",",");?></td>
	<td align= 'right'><?php echo number_format($row['gross']+$row['pf_annex']+$row['other_charges']+$row['servicecharges']+$row['supervisioncharges']+$row['cgst_annex']+$row['sgst_annex'],2,".",",");?></td>
</tr>
<?php } 

if($tab_client=="1214"){
  $sql = "SELECT  `dept_name`, client_name, count(emp_id) as headcount,sum( `payabledays_sal`)payabledays_sal,sum( `othours_sal`) as othours_sal,sum(  `overtime_sal`) as overtime_sal,sum(`basic_daily_annex`) as basic_daily_annex, sum(`da_daily_annex`) as da_daily_annex, sum(`hra_daily_annex`) as hra_daily_annex, sum(`super_skill_allow_daily_annex`) as super_skill_allow_daily_annex , sum(supplli_allow_daily_annex) as supplli_allow_daily_annex, sum(`other_allow_daily_annex`) as other_allow_daily_annex, sum(total_a_annex) as total_a_annex,sum(total_a_annex+overtime_sal) as gross, sum(`pf_annex`) as pf_annex,sum( `bonus_Annex`+ `esi_annex`+ `lww_annex`+ `lwf_annex` +`safety_annex`+ `soap_annex`+ `training_annex`+tds_annex) as other_charges,sum(supervisioncharges) as supervisioncharges,sum(servicecharges) as servicecharges,sum(cgst_annex) as cgst_annex,sum(sgst_annex) as sgst_annex,sum(cgst_annex+sgst_annex) as gst_annex, sum(`tot_amount_annex`) as tot_amount_annex  FROM $tab where emp_name !='STD_Annex'  and sal_month = '$frdt' and dept_id = ".$prev_dept_id;
		$res2 = mysql_query($sql);
		$row2 = mysql_fetch_array($res2);?>
	<tr>
	
		<th align= 'right'><?php echo " ";?></th>
		<th align= 'right'><?php echo " ";?></th>
		<th align= 'right'><?php echo "DEPT Total : ";?></th>
		<th align= 'right'><?php //echo $row2['client_name'];?></th>
		<th align= 'right'><?php echo $row2['headcount'];?></th>
		<th align= 'right'><?php echo number_format($row2['payabledays_sal'],2,".",",");?></th>
		<th align= 'right'><?php echo number_format($row2['total_a_annex'],2,".",",");?></th>
		<th align= 'right'><?php echo number_format($row2['othours_sal'],2,".",",");?></th>
		<th align= 'right'><?php echo number_format($row2['overtime_sal'],2,".",",");?></th>
		<th align= 'right'><?php echo number_format($row2['gross'],2,".",",");?></th>
		<th align= 'right'><?php echo number_format($row2['pf_annex'],2,".",",");?></th>
		<th align= 'right'><?php echo number_format($row2['other_charges'],2,".",",");?></th>
		<th align= 'right'><?php echo number_format($row2['gross']+$row2['pf_annex']+$row2['other_charges'],2,".",",");?></th>
		<th align= 'right'><?php echo number_format($row2['supervisioncharges'],2,".",",");?></th>
		<th align= 'right'><?php echo number_format($row2['servicecharges'],2,".",",");?></th>
		<th align= 'right'><?php echo number_format($row2['gross']+$row2['pf_annex']+$row2['other_charges']+$row2['servicecharges']+$row2['supervisioncharges'],2,".",",");?></th>
		<th align= 'right'><?php echo number_format($row2['cgst_annex'],2,".",",");?></th>
		<th align= 'right'><?php echo number_format($row2['sgst_annex'],2,".",",");?></th>
		<th align= 'right'><?php echo number_format($row2['gross']+$row2['pf_annex']+$row2['other_charges']+$row2['servicecharges']+$row2['supervisioncharges']+$row2['cgst_annex']+$row2['sgst_annex'],2,".",",");?></th></tr>
<?php }
  $sql = "SELECT  `dept_name`, client_name, count(emp_id) as headcount,sum( `payabledays_sal`)payabledays_sal,sum( `othours_sal`) as othours_sal,sum(  `overtime_sal`) as overtime_sal,sum(`basic_daily_annex`) as basic_daily_annex, sum(`da_daily_annex`) as da_daily_annex, sum(`hra_daily_annex`) as hra_daily_annex, sum(`super_skill_allow_daily_annex`) as super_skill_allow_daily_annex , sum(supplli_allow_daily_annex) as supplli_allow_daily_annex, sum(`other_allow_daily_annex`) as other_allow_daily_annex, sum(total_a_annex) as total_a_annex,sum(total_a_annex+overtime_sal) as gross, sum(`pf_annex`) as pf_annex,sum( `bonus_Annex`+ `esi_annex`+ `lww_annex`+ `lwf_annex` +`safety_annex`+ `soap_annex`+ `training_annex`+tds_annex) as other_charges,sum(supervisioncharges) as supervisioncharges,sum(servicecharges) as servicecharges,sum(cgst_annex) as cgst_annex,sum(sgst_annex) as sgst_annex,sum(cgst_annex+sgst_annex) as gst_annex, sum(`tot_amount_annex`) as tot_amount_annex  FROM $tab where emp_name !='STD_Annex' and sal_month = '$frdt' ";
		$res2 = mysql_query($sql);
		$row2 = mysql_fetch_array($res2);?>
	<tr>
		<th align= 'right'><?php echo "";?></th>
		<th align= 'right'><?php echo " ";?></th>
		<th align= 'right'><?php echo "Grand Total : ";?></th>
		<th align= 'right'><?php //echo $row2['client_name'];?></th>
		<th align= 'right'><?php echo $row2['headcount'];?></th>
		<th align= 'right'><?php echo number_format($row2['payabledays_sal'],2,".",",");?></th>
		<th align= 'right'><?php echo number_format($row2['total_a_annex'],2,".",",");?></th>
		<th align= 'right'><?php echo number_format($row2['othours_sal'],2,".",",");?></th>
		<th align= 'right'><?php echo number_format($row2['overtime_sal'],2,".",",");?></th>
		<th align= 'right'><?php echo number_format($row2['gross'],2,".",",");?></th>
		<th align= 'right'><?php echo number_format($row2['pf_annex'],2,".",",");?></th>
		<th align= 'right'><?php echo number_format($row2['other_charges'],2,".",",");?></th>
		<th align= 'right'><?php echo number_format($row2['gross']+$row2['pf_annex']+$row2['other_charges'],2,".",",");?></th>
		<th align= 'right'><?php echo number_format($row2['supervisioncharges'],2,".",",");?></th>
		<th align= 'right'><?php echo number_format($row2['servicecharges'],2,".",",");?></th>
		<th align= 'right'><?php echo number_format($row2['gross']+$row2['pf_annex']+$row2['other_charges']+$row2['servicecharges']+$row2['supervisioncharges'],2,".",",");?></th>

		<th align= 'right'><?php echo number_format($row2['cgst_annex'],2,".",",");?></th>
		<th align= 'right'><?php echo number_format($row2['sgst_annex'],2,".",",");?></th>
		<!--<th align= 'right'><?php echo number_format($row2['tot_amount_annex'],2,".",",");?></th></tr>-->
		<th align= 'right'><?php echo number_format($row2['gross']+$row2['pf_annex']+$row2['other_charges']+$row2['servicecharges']+$row2['supervisioncharges']+$row2['cgst_annex']+$row2['sgst_annex'],2,".",",");?></th></tr>
		
		
</table>

