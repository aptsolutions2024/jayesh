<?php 
//error_reporting(0);
include("../lib/class/common.php");
$common = new common();
$client = $_POST['client'];
//$emp = $_POST['emp'];
$empid =$_POST['empid'];
$frdt =$_POST['frdt'];
 $frdt =date('Y-m-d',strtotime($frdt));
$todt =$_POST['todt'];
 $todt =date('Y-m-d',strtotime($todt));

$startmonthno = date('m',strtotime($frdt));
$startyearno = date('Y',strtotime($frdt));
$calculationtype = $common->incomeCalculationType();

$todt1 = date('m/d/Y', strtotime($todt. '-1 days'));
$date1 = new DateTime($frdt);
$date2 = $date1->diff(new DateTime($todt1));
//echo $date2->d.' days'."\n";
 $year = $date2->y;
 $month = $date2->m;
if($year>0){
	$yearmon =$year*12+$month;
}else{
	$yearmon = $month;
}
 $totalm = $yearmon+1;
?>
<div><input name="chkall" type="checkbox" value="All" checked onclick="checkAll()" id="allcheck"> <b>Check/Uncheck All</b><input type="hidden" value="<?php echo $totalm;?>" name="totmon" id="totmon"></div>
<table width="100%">
<?php $k=1; $l=0; $m=0; for($i=0; $i<$totalm;$i++ ){?>
<tr>
	<td colspan="7">
	<h5><?php 
	if($startmonthno <= 12){$monno = $startmonthno+$i; }else{$startyearno = $startyearno+1; $monno = 01; }
	echo $date2 = date("F Y", mktime(0, 0, 0, $monno, 1,$startyearno));
	 $m= date('m',strtotime($date2));
	$y= date('Y',strtotime($date2));
	?>
	</h5>
	
	</td>
</tr>
<tr>
	<th width="80px">Sr No. </th>
	<th>Income Head</th>
	<th>Original / New</th>
	<th>Std. Amt.</th>
	<th>Calculation Type</th>
	<th>Amount Rs.</th>
	<th>Diff. Rs.</th>
</tr>
<?php $j=1;  $gethistincome = $common->getIncomeByEmployeeId($empid,$m,$y); 

foreach($gethistincome as $histincome){ 
?>
<tr>
	<td><?php echo $j;?> <input name="chkn[]" type="checkbox" value="<?php echo $l;?>" checked id="chk<?php echo $i;?>-<?php echo $j;?>" class="selectchk"> <input type="hidden" name="monthname[]" value="<?php echo $y.'-'.$m.'-01';?>"></td>
	<td><?php echo $histincome['income_heads_name'];?> <input type="hidden" name="orgincomhead[]" value="<?php echo $histincome['head_id'];?>"></td>
	<td>Original</td>
	<td><?php echo $histincome['std_amt'];?><input type="hidden" name="orgstdname[]" value="<?php echo $histincome['std_amt'];?>"></td>
	<td><?php echo $histincome['name'];?><input type="hidden" name="orgcaltype[]" value="<?php echo $histincome['calc_type'];?>"></td>
	<td ><span id="amt<?php echo $k.$j;?>"><?php echo $histincome['amount'];?></span><input type="hidden" name="orgamont[]" value="<?php echo $histincome['amount'];?>"></td>
	<td></td>
</tr>
<tr>
	<td></td>
	<td></td>
	<td>New</td>
	<td><input type="text" name="stdamount[]" class="textclass" onfocus="calculateAmt(<?php echo $k.$j;?>)" onkeyup="calculateAmt(<?php echo $k.$j;?>)" id="stamt<?php echo $k.$j;?>"></td>
	<td>
	<select name="calculationtype[]" class="textclass" id="caltype<?php echo $k.$j;?>">
	<?php foreach($calculationtype as $type){?>
	<option value="<?php echo $type['id'];?>" <?php if($type['id']== $histincome['calc_type']){echo "selected";} ?>><?php echo $type['name'];?></option>
	<?php }?>
	</select>
	</td>

	<td><input type="text" name="amount[]" class="textclass" id="calamo<?php echo $k.$j;?>" readonly></td>
	<td><input type="text" name="difference[]" class="textclass diffcal monsum<?php echo $i;?>" id="caldiff<?php echo $k.$j;?>" readonly></td>
</tr>
<?php $j++; $l++;} ?>

<?php if($j<=1){ ?>
<tr><td colspan="7" class="errorclass" align="center">No record found </td></tr>
<?php } else{?>
<tr>
	<td colspan="5"></td>
	<td align="right">Total</td>
	<td id="total<?php echo $i;?>" class="totsum<?php echo $m;?>" align="right"></td>
</tr>
<?php }?>
<?php $k++; $m++;} ?>
<tr>
<td ></td>
<td ><input type="submit" name="Submit" class="btnclass"></td>
	<td colspan="3" ><div id="succerr" class="hidecontent "><div class="success31">Record updated successfully!</div></div></td>
	<td align="right">Grand Total</td>
	<td align="right"><span id="grndtotal"></span><input type="hidden" value="" id="grnttotval" name="grnttotval"></td>
</tr>
</table>
