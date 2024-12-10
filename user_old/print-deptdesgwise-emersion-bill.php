<?php
$clientid=$_POST['client'];
$clientdtl = $userObj->displayClient($clientid);
$client_name = $clientdtl['client_name'];
$current_month = $clientdtl['current_month'];

 $setExcelName ="dept_desg_wise_emerson_bill";
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
<th>Srno</th>
<th>C. C. Code</th>
<th>C.C.Name</th>
<th>Work Description</th>
<th>Mandays<br>OT Hours</th>
<th>Head Count</th>
<th>Mandays</th>
<th> Rate </th>
<th>Rs</th>
<th>Supervision Charges</th>
<th>ESI on OT</th>
<th>SUB TOTAL<br>(A)</th>
<th>Service charges<br> @ 3% (B)</th>
<th>Total A + B<br>( C )</th>
<th>SGST 9%	</th>
<th>CGST 9%	</th>
<th>Grand Total</th>

</tr>

<?php 
$sql = "select dept_name,desg_name,rate,monthlysup_ip,esi_percent_ip,otrate,cgst_percent_ip,sgst_percent_ip, count(*) as headcount, round(sum(payabledays),2) as payabledays, round(sum(othours),2) as othours, round(sum(overtime),2) as overtime,
round(sum(supervisioncharges),2)supervisioncharges   from $tab   group By dept_name,desg_name";
$res = mysql_query($sql);
 $cnt = mysql_num_rows($res);

 $headcount = 0;
 $payabledays=0;
 $othours=0;
$prev_dept="";
$prev_desg = "";

$totalsupervision  = 0;
$totalservice = 0; 
$col_1_total=0;
$col_2_total=0;
$col_3_total=0;
$col_4_total=0;
$col_5_total=0;
$col_6_total=0;
$col_7_total=0;
$col_8_total=0;
$col_9_total=0;

$col_21_total=0;
$col_22_total=0;
$col_23_total=0;
$col_24_total=0;
$col_25_total=0;
$col_26_total=0;
$col_27_total=0;
$col_28_total=0;
$col_29_total=0;


$sgst_total = 0;
$cgst_total = 0;
$esi_total =0;
$srno = 1;
$flag = 0;

echo "
<div align='center'><h2>Department Wise Client Wise Summary Report For ".date("M Y ", strtotime($current_month))."</h2></div>
<div align='center'><h2><b>Client : ". $client_name."</h2></div>" ;
while ($row = mysql_fetch_array($res)){
	if ($prev_desg==""){
			$col_1_depttotal=0;
			$col_2_depttotal=0;
			$col_3_depttotal=0;
			$col_4_depttotal=0;
			$col_5_depttotal=0;
			$col_6_depttotal=0;
			$col_7_depttotal=0;
			$col_8_depttotal=0;
			$col_9_depttotal=0;
			$col_21_depttotal=0;
			$col_22_depttotal=0;
			$col_23_depttotal=0;
			$col_24_depttotal=0;
			$col_25_depttotal=0;
			$col_26_depttotal=0;
			$col_27_depttotal=0;
			$col_28_depttotal=0;
			$col_29_depttotal=0;
		
		$prev_dept=$row['dept_name'];$prev_desg=$row['desg_name'];
		echo "<tr><td>".$srno."</td><td>".substr($row['dept_name'],0,4)."</td><td>".substr($row['dept_name'],5,100)."</td>";
						$flag = 1;

}
	if ($prev_dept!= $row['dept_name']){

			 $sql2 = "select  count(*) as headcount, round(sum(payabledays),2) as payabledays ,sum(othours) as othours   from $tab  where dept_name = '$prev_dept'  group 	By dept_name ";
			$res2 = mysql_query($sql2);
			$cnt2 = mysql_num_rows($res2);
			$row2 = mysql_fetch_array($res2);?>
		
		<tr>

		<td></td><td></td><td></td>

		<th>Total</th>
		<th>ManDays</th>
		<th align = 'right'><?php echo $row2['headcount'];?></th>
		<th align = 'right'><?php echo number_format($row2['payabledays'],2,'.',',');?></th>
		<th align = 'right'></th>

		<th  align = 'right'><?php echo number_format($col_1_depttotal,2,'.',',');?></th>		

		<th  align = 'right'><?php echo number_format($col_2_depttotal,2,'.',',');?> </th>

		<th  align = 'right'></th>

		<th  align = 'right'><?php echo number_format($col_4_depttotal,2,'.',',');?></th>
		<th  align = 'right'><?php echo number_format($col_5_depttotal,2,'.',',');?></th>
		<th  align = 'right'><?php echo number_format($col_6_depttotal,2,'.',',');?></th>
		<th  align = 'right'><?php echo number_format($col_7_depttotal,2,'.',',');?></th>
		<th  align = 'right'><?php echo number_format($col_8_depttotal,2,'.',',');?></th>
		<th  align = 'right'><?php echo number_format($col_9_depttotal,2,'.',',');?></th>
		
		</tr>
		<tr>

		<td></td><td></td><td></td><th  align = 'righ'>Total</th>
		<th  align = 'right'>OT Hours</th><th  align = 'right'></th>
		<th  align = 'right'><?php echo number_format($row2['othours'],2,'.',',')?></th>
		<th  align = 'right'></th>
		<th  align = 'right'><?php echo number_format($col_21_depttotal,2,'.',',')?></th>
		<th  align = 'right'></th>
		<th  align = 'right'><?php echo number_format($col_23_depttotal,2,'.',',')?></th>
		<th  align = 'right'><?php echo number_format($col_24_depttotal,2,'.',',')?></th>
		<th  align = 'right'><?php echo number_format($col_25_depttotal,2,'.',',')?></th>
		<th  align = 'right'><?php echo number_format($col_26_depttotal,2,'.',',')?></th>
		<th  align = 'right'><?php echo number_format($col_27_depttotal,2,'.',',')?></th>
		<th  align = 'right'><?php echo number_format($col_28_depttotal,2,'.',',')?></th>
		<th  align = 'right'><?php echo number_format($col_29_depttotal,2,'.',',')?></th>
		
		</tr>
		<tr><td></td></tr>

				<?php 
				echo "<tr><td>".$srno."</td><td>".substr($row['dept_name'],0,4)."</td><td>".substr($row['dept_name'],5,100)."</td>";
				$prev_dept=$row['dept_name'];$prev_desg=$row['desg_name'];
				$flag = 1;
					$col_1_depttotal=0;
					$col_2_depttotal=0;
					$col_3_depttotal=0;
					$col_4_depttotal=0;
					$col_5_depttotal=0;
					$col_6_depttotal=0;
					$col_7_depttotal=0;
					$col_8_depttotal=0;
					$col_9_depttotal=0;
					$col_21_depttotal=0;
					$col_22_depttotal=0;
					$col_23_depttotal=0;
					$col_24_depttotal=0;
					$col_25_depttotal=0;
					$col_26_depttotal=0;
					$col_27_depttotal=0;
					$col_28_depttotal=0;
					$col_29_depttotal=0;
					}
			
		?>


<?php if ($flag==0){echo "<td></td><td></td><td></td>";}$flag =0;?>
<td><?php echo substr($row['desg_name'],7,100);?></td>
<td>ManDays</td>
<td><?php echo $row['headcount'];$headcount +=$row['headcount'];?></td>
<td><?php echo  number_format($row['payabledays'],2,'.',',');$payabledays +=$row['payabledays'];?></td>
<td><?php echo  number_format($row['rate'],2,'.',',');?></td>

<td><?php echo number_format($row['payabledays']*$row['rate'],2,'.',',');
		$col_1=$row['payabledays']*$row['rate'];
		$col_1_total +=$row['payabledays']*$row['rate'];
		$col_1_total+=$row['payabledays']*$row['rate'];
		$col_1_depttotal+=$row['payabledays']*$row['rate'];
		
		?></td>


<td><?php echo number_format($row['supervisioncharges'],2,'.',',');
		$col_2_total+=$row['supervisioncharges'];
		$col_2_depttotal+=$row['supervisioncharges'];?></td>


<td></td>

<td><?php echo number_format($col_1+$row['supervisioncharges'],2,'.',',');
	$col_2=$col_1+$row['supervisioncharges'];
	$col_4_total+=$col_1+$row['supervisioncharges'];
		$col_4_depttotal+=$col_1+$row['supervisioncharges'];?></td>

<td><?php echo number_format( round($col_2*$row['monthlysup_ip']/100,2),2,'.',',');
           $col_3 = round($col_2*$row['monthlysup_ip']/100,2);
		$col_5_total+=$col_3;
		$col_5_depttotal+=$col_3;?></td>

<td><?php echo number_format($col_2+$col_3,2,'.',',');
	 $col_4=$col_2+$col_3;
	 $col_6_total+=$col_2+$col_3;
		$col_6_depttotal+=$col_2+$col_3;?></td>

<td><?php echo number_format($col_4*$row['sgst_percent_ip']/100,2,'.',',');
	$col_5=round($col_4*$row['sgst_percent_ip']/100,2);
	 $col_7_total+=round($col_4*$row['sgst_percent_ip']/100,2);
		$col_7_depttotal+=round($col_4*$row['sgst_percent_ip']/100,2);	?></td>

<td><?php echo number_format($col_4*$row['cgst_percent_ip']/100,2,'.',',');
	$col_6=round($col_4*$row['cgst_percent_ip']/100,2);
		 $col_8_total+=round($col_4*$row['cgst_percent_ip']/100,2);
		$col_8_depttotal+=round($col_4*$row['cgst_percent_ip']/100,2);	?></td>

<td><?php echo  number_format($col_4+$col_5+$col_6,2,'.',',');
	 $col_9_total+=$col_4+$col_5+$col_6;
		$col_9_depttotal+=$col_4+$col_5+$col_6;?></td>
</tr>
<tr>

<td></td><td></td><td></td><td><?php echo substr($row['desg_name'],7,100);?></td>
<td>OT Hours</td><td></td>
<td><?php echo  number_format($row['othours'],2,'.',',')?></td>
<td><?php echo  number_format($row['otrate'],2,'.',',')?></td>
<td><?php echo  number_format($row['overtime'],2,'.',',');
	$col_21_total+=$row['overtime'];
		$col_21_depttotal+=$row['overtime'];

?></td>
<td></td>
<td><?php echo number_format(round($row['overtime']*$row['esi_percent_ip']/100,2),2,'.',',');

				$esi=round($row['overtime']*$row['esi_percent_ip']/100,2);
				$col_23_total+=round($row['overtime']*$row['esi_percent_ip']/100,2);
				$col_23_depttotal+=round($row['overtime']*$row['esi_percent_ip']/100,2);
					?></td>
	
<td> <?php echo  number_format($row['overtime']+$esi,2,'.',',');
			$col_2=$row['overtime']+$esi;
			$col_24_total+=$row['overtime']+$esi;
			$col_24_depttotal+=$row['overtime']+$esi;
			?></td>

<td><?php echo number_format( round($col_2*$row['monthlysup_ip']/100,2),2,'.',',');
           $col_3 = round($col_2*$row['monthlysup_ip']/100,2);
			$col_25_depttotal+=$col_3;
			$col_25_total+=$col_3;?></td>

<td><?php echo number_format($col_2+$col_3,2,'.',',');
	 $col_4=$col_2+$col_3;
	 
	 $col_26_depttotal+=$col_2+$col_3;
	 $col_26_total+=$col_2+$col_3;?>

<td><?php echo number_format($col_4*$row['sgst_percent_ip']/100,2,'.',',');
	$col_5=round($col_4*$row['sgst_percent_ip']/100,2);
	
	
	 $col_27_depttotal+= round($col_4*$row['sgst_percent_ip']/100,2);
	 $col_27_total+= round($col_4*$row['sgst_percent_ip']/100,2);?></td>
?></td>

<td><?php echo number_format($col_4*$row['cgst_percent_ip']/100,2,'.',',');
	$col_6=round($col_4*$row['cgst_percent_ip']/100,2);
		 $col_28_depttotal+= round($col_4*$row['cgst_percent_ip']/100,2);
	 $col_28_total+= round($col_4*$row['cgst_percent_ip']/100,2);?></td>

<td><?php echo  number_format($col_4+$col_5+$col_6,2,'.',',');
	 $col_29_depttotal+= $col_4+$col_5+$col_6;
	 $col_29_total+= $col_4+$col_5+$col_6;

 ?></td>
</tr>
			


<?php } ?>

//<!-- For last dept -->
<?php 
			$sql2 = "select  count(*) as headcount, round(sum(payabledays),2) as payabledays,sum(othours) as othours    from $tab  where dept_name = '$prev_dept'  group 	By dept_name ";
			$res2 = mysql_query($sql2);
			$cnt2 = mysql_num_rows($res2);
			$row2 = mysql_fetch_array($res2);?>
		
		<tr>

		<td></td><td></td><td></td>

		<th>Total</th>
		<th>ManDays</th>
		<th align = 'right'><?php echo $row2['headcount'];?></th>
		<th align = 'right'><?php echo number_format($row2['payabledays'],2,'.',',');?></th>
		<th align = 'right'></th>

		<th  align = 'right'><?php echo number_format($col_1_depttotal,2,'.',',');?></th>		

		<th  align = 'right'><?php echo number_format($col_2_depttotal,2,'.',',');?> </th>

		<th  align = 'right'></th>

		<th  align = 'right'><?php echo number_format($col_4_depttotal,2,'.',',');?></th>
		<th  align = 'right'><?php echo number_format($col_5_depttotal,2,'.',',');?></th>
		<th  align = 'right'><?php echo number_format($col_6_depttotal,2,'.',',');?></th>
		<th  align = 'right'><?php echo number_format($col_7_depttotal,2,'.',',');?></th>
		<th  align = 'right'><?php echo number_format($col_8_depttotal,2,'.',',');?></th>
		<th  align = 'right'><?php echo number_format($col_9_depttotal,2,'.',',');?></th>
		
		</tr>
		<tr>

		<td></td><td></td><td></td><th  align = 'righ'>Total</th>
		<th  align = 'right'>OT Hours</th><th  align = 'right'></th>
		<th  align = 'right'><?php echo number_format($row2['othours'],2,'.',',')?></th>
		<th  align = 'right'></th>
		<th  align = 'right'><?php echo number_format($col_21_depttotal,2,'.',',')?></th>
		<th  align = 'right'></th>
		<th  align = 'right'><?php echo number_format($col_23_depttotal,2,'.',',')?></th>
		<th  align = 'right'><?php echo number_format($col_24_depttotal,2,'.',',')?></th>
		<th  align = 'right'><?php echo number_format($col_25_depttotal,2,'.',',')?></th>
		<th  align = 'right'><?php echo number_format($col_26_depttotal,2,'.',',')?></th>
		<th  align = 'right'><?php echo number_format($col_27_depttotal,2,'.',',')?></th>
		<th  align = 'right'><?php echo number_format($col_28_depttotal,2,'.',',')?></th>
		<th  align = 'right'><?php echo number_format($col_29_depttotal,2,'.',',')?></th>
		
		</tr>


		<!--//Grand Total-->
		<?php $sql2 = "select  count(*) as headcount, round(sum(payabledays),2) as payabledays,sum(othours) as othours    from $tab  where dept_name = '$prev_dept' ";
			$res2 = mysql_query($sql2);
			$cnt2 = mysql_num_rows($res2);
			$row2 = mysql_fetch_array($res2);?>
		
		
				<tr>

		<td></td><td></td><td></td>

		<th>Total</th>
		<th>ManDays</th>
		<th align = 'right'><?php echo $row2['headcount'];?></th>
		<th align = 'right'><?php echo number_format($row2['payabledays'],2,'.',',');?></th>
		<th align = 'right'></th>

		<th  align = 'right'><?php echo number_format($col_1_total,2,'.',',');?></th>		

		<th  align = 'right'><?php echo number_format($col_2_total,2,'.',',');?> </th>

		<th  align = 'right'></th>

		<th  align = 'right'><?php echo number_format($col_4_total,2,'.',',');?></th>
		<th  align = 'right'><?php echo number_format($col_5_total,2,'.',',');?></th>
		<th  align = 'right'><?php echo number_format($col_6_total,2,'.',',');?></th>
		<th  align = 'right'><?php echo number_format($col_7_total,2,'.',',');?></th>
		<th  align = 'right'><?php echo number_format($col_8_total,2,'.',',');?></th>
		<th  align = 'right'><?php echo number_format($col_9_total,2,'.',',');?></th>
		
		</tr>
		<tr>

		<td></td><td></td><td></td><th  align = 'righ'>Total</th>
		<th  align = 'right'>OT Hours</th><th  align = 'right'></th>
		<th  align = 'right'><?php echo number_format($row2['othours'],2,'.',',')?></th>
		<th  align = 'right'></th>
		<th  align = 'right'><?php echo number_format($col_21_total,2,'.',',')?></th>
		<th  align = 'right'></th>
		<th  align = 'right'><?php echo number_format($col_23_total,2,'.',',')?></th>
		<th  align = 'right'><?php echo number_format($col_24_total,2,'.',',')?></th>
		<th  align = 'right'><?php echo number_format($col_25_total,2,'.',',')?></th>
		<th  align = 'right'><?php echo number_format($col_26_total,2,'.',',')?></th>
		<th  align = 'right'><?php echo number_format($col_27_total,2,'.',',')?></th>
		<th  align = 'right'><?php echo number_format($col_28_total,2,'.',',')?></th>
		<th  align = 'right'><?php echo number_format($col_29_total,2,'.',',')?></th>
		
		</tr>

</table>

