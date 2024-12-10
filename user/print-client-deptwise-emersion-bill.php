<?php

//session_start();


$clientid=$_POST['client'];
$clientdtl = $userObj->displayClient($clientid);
$client_name = $clientdtl['client_name'];
$current_month = $clientdtl['current_month'];

$setExcelName ="department_wise_emerson_bill";
 header("Content-type: application/octet-stream");

header("Content-Disposition: attachment; filename=".$setExcelName.".xls");

header("Pragma: no-cache");
header("Expires: 0");?>
<style>
table,tr,th,td{border:1px solid #000; padding:5px}
th{background-color:#ccc}
</style>
<table width="100%" >
<tr>
<th> Sal Month </th>
<th> Client</th>
<th> Department</th>
<th> Designation</th>
<th> Count </th>
<th> Payable Days</th>
<th> OT Hours</th>
<th> Basic </th>
<th> HRA </th>
<th> D.A. </th>
<th> Supplli.Allow</th>
<th> Other Amt </th>
<th> Superskill Allow</th>
<th> Overtime </th>
<th> Total(A)</th>
<th> PF</th>
<th> Bonus</th>
<th> Total(B) </th>
<th> ESI </th>
<th> LWW </th>
<th> LWF </th>
<th> SafetyApp</th>
<th> Other Charges</th>
<th> Training Charges</th>
<th> Total(C) </th>
<th> A+B+C</th>
<th> Tds </th>
<th> Total(D) </th>
<th> Super.Char</th>
<th> Service Char. </th>
<th> Total Taxable </th>
<th> Cgst 9%</th>
<th> Sgst 9%</th>
<th> Igst 9%</th>
<th> Total  </th>
</tr>

<?php 
$sql = "select sal_month,client_name,dept_name,desg_name,count(*) as headcount, round(sum(payabledays),2) as payabledays, round(sum(othours),2) as othours,round(sum(basic_amt),2) as basic,round(sum(da_amt),2) as da, round(sum(hra_amt),2) as hra,round(sum(supplli_serve_allow_amt),2) as ssallow,round(sum(super_skill_allow_amt),2) as superskillallow,round(sum(other_allow_amt),2) as otherallow,  round(sum(overtime),2) as overtime,round(sum(gross_salary),2) as gross,round(sum(pf),2) as pf ,round(sum(esi),2) as esi,round(sum(bonus),2) as bonus,round(sum(lww),2) as lww,round(sum(lwf),2) as lwf,round(sum(safetyapp),2) as safetyapp,round(sum(soap),2) as soap,round(sum(trainingcharg),2) as trainingcharg,round(sum(tds),2) as tds,round(sum(other_allow_amt),2) as other,round(sum(total_d_amt),2) as total_d_amt,round(sum(total_c_amt),2) as total_c,round(sum(total_abc_amt),2) as total_abc_amt,round(sum(total_a_amt),2) as totala, round(sum(total_b_amt),2) as totalb,round(sum(supervisioncharges),2)supervisioncharges ,round(sum(servicecharges),2) as servicecharges ,cgst_percent_ip,sgst_percent_ip,igst_percent_ip ,round(sum(cgst),2) as cgst ,round(sum(sgst),2) as sgst ,round(sum(igst),2) as igst,round(sum(taxable),2) as taxable,round(sum(final),2) as final  from $tab   group By dept_name,client_name";
$res = mysql_query($sql);
 $cnt = mysql_num_rows($res);

 $headcount = 0;
 $payabledays=0;
 $othours=0;
$basic = 0;
$da=0;
$hra= 0;
$ssallow = 0;
$otherallow=0;
$superskillallow=0;
$overtime=0;
$pf = 0;
$bonus = 0;
$esi = 0;
$lww = 0;
$lwf = 0;
$safetyapp = 0;
$soap = 0;
$trainingcharg = 0;
$tds = 0;
$totala = 0;
$totalb =0;
$totalc= 0;
$totalabc=0;
$totald=0;
$taxable = 0;
$final= 0;
$totaltaxable = 0;
$totalcgst=0;
$totalsgst=0;
$totaligst=0;
$totalsupervision= 0;
$totalservice = 0;
$prev_dept="";
$prev_client = "";

echo "
<div align='center'><h2>Department Wise Client Wise Summary Report For ".date("M Y ", strtotime($current_month))."</h2></div>
<div align='center'><h2><b>Client : ". $client_name."</h2></div>" ;
while ($row = mysql_fetch_array($res)){
	if ($prev_client==""){$prev_dept=$row['dept_name'];$prev_client=$row['client_name'];}
	if ($prev_dept!= $row['dept_name']){
			 $sql2 = "select sal_month,client_name,dept_name,desg_name,count(*) as headcount, round(sum(payabledays),2) as payabledays, round(sum(othours),2) as othours,round(sum(basic_amt),2) as basic,round(sum(da_amt),2) as da, round(sum(hra_amt),2) as hra,round(sum(supplli_serve_allow_amt),2) as ssallow,round(sum(super_skill_allow_amt),2) as superskillallow,round(sum(other_allow_amt),2) as otherallow,  round(sum(overtime),2) as overtime,round(sum(gross_salary),2) as gross,round(sum(pf),2) as pf ,round(sum(esi),2) as esi,round(sum(bonus),2) as bonus,round(sum(lww),2) as lww,round(sum(lwf),2) as lwf,round(sum(safetyapp),2) as safetyapp,round(sum(soap),2) as soap,round(sum(trainingcharg),2) as trainingcharg,round(sum(tds),2) as tds,round(sum(other_allow_amt),2) as other,round(sum(total_d_amt),2) as total_d_amt,round(sum(total_c_amt),2) as total_c,round(sum(total_abc_amt),2) as total_abc_amt,round(sum(total_a_amt),2) as totala, round(sum(total_b_amt),2) as totalb,round(sum(supervisioncharges),2)supervisioncharges ,round(sum(servicecharges),2) as servicecharges ,cgst_percent_ip,sgst_percent_ip,igst_percent_ip ,round(sum(cgst),2) as cgst ,round(sum(sgst),2) as sgst ,round(sum(igst),2) as igst,round(sum(taxable),2) as taxable,round(sum(final),2) as final from $tab where dept_name = '$prev_dept'  group By dept_name ";
			$res2 = mysql_query($sql2);
			$cnt2 = mysql_num_rows($res2);
			$row2 = mysql_fetch_array($res2);?>
			<td></td>
		
			<td></td>
			<td><?php echo $row['dept_name'];?></td>
			<td>Total</td>
			<td><?php echo $row2['headcount'];?></td>
			<td><?php echo $row2['payabledays'];$payabledays +=$row['payabledays'];?></td>
			<td><?php echo $row2['othours'];$othours +=$row['othours'];?></td>
			<td><?php echo $row2['basic'];$basic +=$row['basic']; ?></td>
		<td><?php echo $row2['da'];?></td>
		<td><?php echo $row2['hra'];?></td>
		<td><?php echo $row2['ssallow'];?></td>
		<td><?php echo $row2['otherallow'];?></td>
		<td><?php echo $row2['superskillallow']; ?></td>
		<td><?php echo $row2['overtime'];?></td>
		<td><?php echo $row2['totala']; ?></td>
		<td><?php echo $row2['pf'];  ?></td>
		<td><?php echo $row2['bonus'];?></td>
		<td><?php echo $row2['totalb']; ?></td>
		<td><?php echo $row2['esi'];?></td>
		<td><?php echo $row2['lww'];?></td>
		<td><?php echo $row2['lwf'];?></td>
		<td><?php echo $row2['safetyapp'];?></td>
		<td><?php echo $row2['soap']; ?></td>
		<td><?php echo $row2['trainingcharg'];?></td>
		<td><?php echo $row2['total_c']; ?></td>
		<td><?php echo $row2['total_abc_amt'];?></td>
		<td> <?php echo $row2['tds'];?></td>
		<td><?php echo $row2['total_d_amt']; ?></td>
		<td><?php echo $supervision?></td>
		<td><?php echo $service = 0;
				  $taxable=$row2['total_d_amt']+$supervision+$service;
				  $totalservice+=$service;?></td>

		<td><?php  echo $taxable;
					$totaltaxable = $totaltaxable+$taxable;?> </td>
		<td> <?php echo $cgst1=round($taxable*$row['cgst_percent_ip']/100,2);
					$totalcgst=$totalcgst+ $cgst1; ?></td>
		<td><?php echo $sgst1=round($taxable*$row['sgst_percent_ip']/100,2);
					$totalsgst=$totalsgst+$sgst1; ?>
		</td>
		<td><?php echo $igst1=round($taxable*$row['igst_percent_ip']/100,2); 
					$totaligst=$totaligst+ $igst1; ?></td>
		<td><?php echo $taxable+$cgst1+$sgst1+$igst1;
						$final =$final+$taxable+$cgst1+$sgst1+$igst1; ?></td>
		</tr>
				
				<tr>
				<td></td>
				</tr>
				<?php $prev_dept=$row['dept_name'];$prev_client=$row['client_name'];
			}
			
		?>


<tr>
<?php $dept= $row['dept_name'];?>
<td><?php echo $row['sal_month'];?></td>

<td><?php echo $row['client_name'];?></td>
<td></td>
<td><?php //echo $row['desg_name'];?></td>
<td><?php echo $row['headcount'];$headcount +=$row['headcount'];?></td>
<td><?php echo $row['payabledays'];$payabledays +=$row['payabledays'];?></td>
<td><?php echo $row['othours'];$othours +=$row['othours'];?></td>
<td><?php echo $row['basic'];$basic +=$row['basic']; ?></td>
<td><?php echo $row['da'];$da+=$row['da']; ?></td>
<td><?php echo $row['hra'];$hra+=$row['hra'];?></td>
<td><?php echo $row['ssallow'];$ssallow  += $row['ssallow'];?></td>
<td><?php echo $row['otherallow'];$otherallow+=$row['otherallow'];?></td>
<td><?php echo $row['superskillallow'];$superskillallow+=$row['superskillallow']; ?></td>
<td><?php echo $row['overtime'];$overtime += $row['overtime'];?></td>
<td><?php echo $row['totala']; $totala +=$row['totala']; ?></td>
<td><?php echo $row['pf']; $pf+=$row['pf']; ?></td>
<td><?php echo $row['bonus'];$bonus+=$row['bonus'];?></td>
<td><?php echo $row['totalb']; $totalb +=$row['totalb']; ?></td>
<td><?php echo $row['esi'];$esi+= $row['esi'];?></td>
<td><?php echo $row['lww'];$lww+=$row['lww'];?></td>
<td><?php echo $row['lwf'];$lwf += $row['lwf'];?></td>
<td><?php echo $row['safetyapp'];$safetyapp+=$row['safetyapp'];?></td>
<td><?php echo $row['soap']; $soap+=$row['soap'];?></td>
<td><?php echo $row['trainingcharg'];$trainingcharg+=$row['trainingcharg'];?></td>
<td><?php echo $row['total_c']; $totalc += $row['total_c']; ?></td>
<td><?php echo $row['total_abc_amt']; $totalabc += $row['total_abc_amt'];?></td>
<td> <?php echo $row['tds'];$tds +=$row['tds'];?></td>
<td><?php echo $row['total_d_amt']; $totald += $row['total_d_amt']; ?></td>
<td><?php echo $supervision= round($row['supervisioncharges']/$cnt,0);$totalsupervision +=$supervision; ?></td>
<td><?php echo $service = round(($row['total_d_amt']+$supervision)*$row['servicecharges']/100,2);
		  $taxable=$row['total_d_amt']+$supervision+$service;
		  $totalservice+=$service;?></td>

<td><?php  echo $taxable;
			$totaltaxable = $totaltaxable+$taxable;?> </td>
<td> <?php echo $cgst1=round($taxable*$row['cgst_percent_ip']/100,2);
			$totalcgst=$totalcgst+ $cgst1; ?></td>
<td><?php echo $sgst1=round($taxable*$row['sgst_percent_ip']/100,2);
			$totalsgst=$totalsgst+$sgst1; ?>
</td>
<td><?php echo $igst1=round($taxable*$row['igst_percent_ip']/100,2); 
			$totaligst=$totaligst+ $igst1; ?></td>
<td><?php echo $taxable+$cgst1+$sgst1+$igst1;
				$final =$final+$taxable+$cgst1+$sgst1+$igst1; ?></td>
</tr>
<?php } 

//<!-- For last dept -->

			 $sql2 = "select sal_month,client_name,dept_name,desg_name,count(*) as headcount, round(sum(payabledays),2) as payabledays, round(sum(othours),2) as othours,round(sum(basic_amt),2) as basic,round(sum(da_amt),2) as da, round(sum(hra_amt),2) as hra,round(sum(supplli_serve_allow_amt),2) as ssallow,round(sum(super_skill_allow_amt),2) as superskillallow,round(sum(other_allow_amt),2) as otherallow,  round(sum(overtime),2) as overtime,round(sum(gross_salary),2) as gross,round(sum(pf),2) as pf ,round(sum(esi),2) as esi,round(sum(bonus),2) as bonus,round(sum(lww),2) as lww,round(sum(lwf),2) as lwf,round(sum(safetyapp),2) as safetyapp,round(sum(soap),2) as soap,round(sum(trainingcharg),2) as trainingcharg,round(sum(tds),2) as tds,round(sum(other_allow_amt),2) as other,round(sum(total_d_amt),2) as total_d_amt,round(sum(total_c_amt),2) as total_c,round(sum(total_abc_amt),2) as total_abc_amt,round(sum(total_a_amt),2) as totala, round(sum(total_b_amt),2) as totalb,round(sum(supervisioncharges),2)supervisioncharges ,round(sum(servicecharges),2) as servicecharges ,cgst_percent_ip,sgst_percent_ip,igst_percent_ip ,round(sum(cgst),2) as cgst ,round(sum(sgst),2) as sgst ,round(sum(igst),2) as igst,round(sum(taxable),2) as taxable,round(sum(final),2) as final from $tab where dept_name = '$dept'  group By dept_name ";
			$res2 = mysql_query($sql2);
			$cnt2 = mysql_num_rows($res2);
			$row2 = mysql_fetch_array($res2);?>
		
<tr>	<td></td>
		
			<td></td>
			<td><?php echo $row['dept_name'];?></td>
			<td>Total1</td>
			<td><?php echo $row2['headcount'];?></td>
			<td><?php echo $row2['payabledays'];$payabledays +=$row['payabledays'];?></td>
			<td><?php echo $row2['othours'];$othours +=$row['othours'];?></td>
			<td><?php echo $row2['basic'];$basic +=$row['basic']; ?></td>
		<td><?php echo $row2['da'];?></td>
		<td><?php echo $row2['hra'];?></td>
		<td><?php echo $row2['ssallow'];?></td>
		<td><?php echo $row2['otherallow'];?></td>
		<td><?php echo $row2['superskillallow']; ?></td>
		<td><?php echo $row2['overtime'];?></td>
		<td><?php echo $row2['totala']; ?></td>
		<td><?php echo $row2['pf'];  ?></td>
		<td><?php echo $row2['bonus'];?></td>
		<td><?php echo $row2['totalb']; ?></td>
		<td><?php echo $row2['esi'];?></td>
		<td><?php echo $row2['lww'];?></td>
		<td><?php echo $row2['lwf'];?></td>
		<td><?php echo $row2['safetyapp'];?></td>
		<td><?php echo $row2['soap']; ?></td>
		<td><?php echo $row2['trainingcharg'];?></td>
		<td><?php echo $row2['total_c']; ?></td>
		<td><?php echo $row2['total_abc_amt'];?></td>
		<td> <?php echo $row2['tds'];?></td>
		<td><?php echo $row2['total_d_amt']; ?></td>
		<td><?php echo $supervision?></td>
		<td><?php echo $service = 0;
				  $taxable=$row2['total_d_amt']+$supervision+$service;
				  $totalservice+=$service;?></td>

		<td><?php  echo $taxable;
					$totaltaxable = $totaltaxable+$taxable;?> </td>
		<td> <?php echo $cgst1=round($taxable*$row['cgst_percent_ip']/100,2);
					$totalcgst=$totalcgst+ $cgst1; ?></td>
		<td><?php echo $sgst1=round($taxable*$row['sgst_percent_ip']/100,2);
					$totalsgst=$totalsgst+$sgst1; ?>
		</td>
		<td><?php echo $igst1=round($taxable*$row['igst_percent_ip']/100,2); 
					$totaligst=$totaligst+ $igst1; ?></td>
		<td><?php echo $taxable+$cgst1+$sgst1+$igst1;
						$final =$final+$taxable+$cgst1+$sgst1+$igst1; ?></td>
		</tr>
				
				<tr>
				<td></td>
				</tr>

				




<td></td>

<td></td>
<td></td>
<td>Grand Total</td>
<td><?php echo $headcount;?></td>
<td><?php echo $payabledays;?></td>
<td><?php echo $othours;?></td>
<td><?php echo $basic; ?></td>
<td><?php echo $da;?> </td>
<td><?php echo $hra;?></td>
<td><?php echo $ssallow;?></td>
<td><?php echo $otherallow;?></td>
<td><?php echo $superskillallow; ?></td>
<td><?php echo $overtime;?></td>
<td><?php echo $totala; ?></td>
<td><?php echo $pf; ?></td>
<td><?php echo $bonus;?></td>
<td><?php echo $totalb; ?></td>
<td><?php echo $esi;?></td>
<td><?php echo $lww;?></td>
<td><?php echo $lwf;?></td>
<td><?php echo $safetyapp;?></td>
<td><?php echo $soap;?></td>
<td><?php echo $trainingcharg;?></td>
<td><?php echo $totalc; ?></td>
<td><?php echo $totalabc;?></td>
<td> <?php echo $tds;?></td>
<td><?php echo $totald; ?></td>
<td><?php echo $totalsupervision;?></td>
<td><?php echo $totalservice;?></td>
<td><?php  echo $totaltaxable;?></td>
<td> <?php echo $totalcgst; ?></td>
<td><?php echo $totalsgst; ?></td>
<td><?php echo $totaligst; ?></td>
<td><?php echo $final; ?></td>
</tr>


				

</table>

