<style>

table, td, th {
            padding: 5px!important;
            border: 1px solid #000;
            font-size:12px !important;
            font-family: monospace;

        }
		th{background:#ccc}
</style>
<?php
/*ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', dirname(__FILE__) . '/error_log.txt');
error_reporting(E_ALL);*/
$setExcelName = "employee_income";

//header("Content-type: application/octet-stream");

//header("Content-Disposition: attachment; filename=".$setExcelName.".xls");

//header("Pragma: no-cache");
//header("Expires: 0");
//error_reporting(0);
session_start();
print_r($_SESSION);
$clientid = $_SESSION['clientid'];
//include("../lib/connection/db-config.php");
$setCounter = 0;
$month=$_SESSION['month'];
$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];
$clientid=$_SESSION['clientid'];
echo $frdt=$_SESSION['frdt'];
 $frdt = date('Y-m-d',strtotime($frdt));
echo $todt=$_SESSION['todt'];
 $todt = date('Y-m-d',strtotime($todt));

include("../lib/class/user-class.php");
$userObj=new user();
$arrayfields = array();
include("../lib/class/common.php");
$common=new common();
//	print_r($_POST);	
//	print_r($_SESSION);
	$emp = $_POST['emp'];
	$empid = $_POST['empid'];
	$date1 = $frdt;
$date2 = $todt;

$ts1 = strtotime($date1);
$ts2 = strtotime($date2);

$year1 = date('Y', $ts1);
$year2 = date('Y', $ts2);

$month1 = date('m', $ts1);
$month2 = date('m', $ts2);
//if(){
 $diff = (($year2 - $year1) * 12) + ($month2 - $month1) +1;
//}

//if($emp=='all'){
	$details = $common->displayemployeeithinrange($clientid,$frdt,$todt,$emp,$empid);
//}else{
//	$details = $common->getBankDetails($empid,$clientid);
//}	

$date1 =array();
$present=array();
$absent=array();
$pl=array();
$sl=array();
$cl=array();

$frdt_new = $frdt;
$i = 0;
while (date('ym',strtotime($frdt_new))<= date('ym',strtotime($todt))){
	//echo date('ym',strtotime($frdt_new))."   ". date('ym',strtotime($todt))."<br>";
	$date1[$i] = date('M Y',strtotime($frdt_new)) ;
	$i++;
	$frdt_new=date('M Y', strtotime("+1 months", strtotime($frdt_new)));
	//echo date('ym',strtotime($frdt_new));
}
$j = $i;
echo "<table>	<tr>
<th> Sr. No.</th>
<th> Name</th>
<th> </th>";

 for($i=0;$i<$j;$i++){?><th><?php echo $date1[$i];
  
?></th><?php }?>
<th> Total</th>


</tr>
<?php 
$sr=1;
foreach($details as $det1){
	 ?>
 <?php 
	 $row = $common->getdaysdetails($clientid,$det1['emp_id'],$frdt,$todt);

	$i = 0;
	for($i = 0;$i <$j;$i++){
	$present[$i]="";
	$absent[$i]="";
	$pl[$i]="";
	$sl[$i]="";
	$cl[$i]="";
	}
	$i = 0;
	foreach($row as $row1)
	{
	//	echo "<br>1.". date('M Y',strtotime($date1[$i]))."<br>";
	//echo  "2". date('M Y',strtotime($row1['sal_month']))."<br>";
	while (date('M Y',strtotime($date1[$i])) != date('M Y',strtotime($row1['sal_month']))){
		$i++;
	}
	if (date('M Y',strtotime($date1[$i])) == date('M Y',strtotime($row1['sal_month'])) )
	{
		$present[$i]= $row1['present'];
		$absent[$i]= $row1['absent'];
		$pl[$i]= $row1['pl'];
		 $cl[$i]= $row1['cl'];
		$sl[$i]= $row1['sl'];
	
	}
	$i++;
	
	
}
?>

<tr>
<td><?php echo $sr ;?></td>
<td><?php echo $det1['emp_id']." ".$det1['first_name']." ".$det1['middle_name']." ".$det1['last_name'];?></td>
<td>Present</td>
<?php 
$pretot=0;
for ($i = 0;$i<$j;$i++){?>


	   <td>
	    <?php echo $present[$i]; $pretot+=$present[$i]; ?>  
	   </td>
<?php 
}?>
<td><?php echo $pretot;?></td>
	</tr>
	<tr>
	<td></td>
<td><?php echo "Join Date : ". date('d-m-Y',strtotime($det1['joindate']))?></td>
<td>Absent</td>
	<?php $absenttot="0";
for ($i = 0;$i<$j;$i++){?>

	   <td>
	    <?php echo $absent[$i]; $absenttot+=$absent[$i];?>  
	   </td>
<?php 
}?>
<td><?php echo $absenttot; ?></td>
	</tr>
	<tr>
	<td></td>
<td><?php if($det1['leftdate'] !="0000-00-00"){echo "Left Date : ". date('d-m-Y',strtotime($det1['leftdate']));}?></td>
<td>CL</td>
	<?php $cltot="0";
for ($i = 0;$i<$j;$i++){?>

	   <td>
	    <?php echo $cl[$i]; $cltot+=$cl[$i];?>  
	   </td>
<?php 
}?>
<td><?php echo $cltot; ?></td>
	</tr>
	<tr>
	<td></td>
<td></td>
<td>PL</td>
	<?php $pltot="0";
for ($i = 0;$i<$j;$i++){?>

	   <td>
	    <?php echo $pl[$i]; $pltot+=$pl[$i];?>  
	   </td>
<?php 
}?>
<td><?php echo $pltot; ?></td>
	</tr>
<tr>
	<td></td>
<td></td>
<td>SL</td>
	<?php $sltot="0";
for ($i = 0;$i<$j;$i++){?>

	   <td>
	    <?php echo $sl[$i]; $sltot+=$sl[$i];?>  
	   </td>
<?php 
}?>
<td><?php echo $sltot; ?></td>
	</tr>
<?php $sr++;}
echo "</table>";
	exit;
/*for($frdt_new = $frdt;$frdt_new <=$todt;strtotime("+1 months", strtotime($frdt_new))){
	$date1 = strtotime($frdt_new) ;
}
echo $date1;
*/


?>		

<div align="center"><h2>Absentism Report</h2></div>
<div align="center"><b>Client : <?php echo $_SESSION['client_name'];?></b></div>
<div align="center"><b>Period : <?php echo date('M y',strtotime($frdt)); ?></b></div><br>
<table width="100%" cellpadding="0" cellspacing="0">
<tr>
<th> Sr. No.</th>
<th> Name</th>
<th> </th>
<?php for($i=1;$i<=$diff;$i++){?><th><?php if($i!=1){$frdt = $effectiveDate; $inc=1;}else{$inc=0;} ;
  echo $effectiveDate = date('M Y', strtotime("+1 months", strtotime($frdt)));
  
?></th><?php }?>
<th> Total</th>


</tr>

<!--- for all dept -->

<?php   $sr=1; ; foreach($details as $detl){
	 $row = $common->getdaysdetails($effectiveDatepr,$clientid,$detl['emp_id']);
	?>
<tr>
<td> <?php echo $sr; //echo "=".$dept['dept_id'];?></td>
<td> <?php echo $detl['first_name']." ".$detl['middle_name']." ".$detl['last_name'];?></td>
<td> Present </td>
<?php 
$frdt1 = $_SESSION['frdt'];

for($i=1;$i<=$diff;$i++){?>
<td><?php if($i!=1){$frdt1 = $effectiveDatepr; } ;
  $effectiveDatepr = date('Y-m-d', strtotime("+1 months", strtotime($frdt1)));
 $row = $common->getdaysdetails($effectiveDatepr,$clientid,$detl['emp_id']);
  
 echo $row['present']?>
 </td>
 <?php }?>
<td> </td>
</tr>
<tr>

<td> </td>

<td> </td>
<td> Absent</td>
<?php 
$frdt1 = $_SESSION['frdt'];
for($i=1;$i<=$diff;$i++){?><td><?php if($i!=1){$frdt1 = $effectiveDate1; } ;
  $effectiveDate1 = date('Y-m-d', strtotime("+1 months", strtotime($frdt1)));
 $row = $common->getdaysdetails($effectiveDate1,$clientid,$detl['emp_id']);  
  echo $row['absent']?></td><?php }?>
<td> </td>
</tr>
<tr>
<td></td>
<td> </td>
<td>CL </td>
<?php 
$frdt1 = $_SESSION['frdt'];
for($i=1;$i<=$diff;$i++){?><td><?php if($i!=1){$frdt1 = $effectiveDate1; } ;
  $effectiveDate1 = date('Y-m-d', strtotime("+1 months", strtotime($frdt1)));
 $row = $common->getdaysdetails($effectiveDate1,$clientid,$detl['emp_id']);  
  echo $row['cl']?></td><?php }?>
<td> </td>
</tr><tr>
<td></td>
<td> </td>
<td> PL</td>
<?php 
$frdt1 = $_SESSION['frdt'];
for($i=1;$i<=$diff;$i++){?><td><?php if($i!=1){$frdt1 = $effectiveDate1; } ;
  $effectiveDate1 = date('Y-m-d', strtotime("+1 months", strtotime($frdt1)));
 $row = $common->getdaysdetails($effectiveDate1,$clientid,$detl['emp_id']);  
  echo $row['pl']?></td><?php }?>
<td> </td>
</tr>
<tr>
<td> </td>
<td></td>
<td> SL</td>
<?php 
$frdt1 = $_SESSION['frdt'];
for($i=1;$i<=$diff;$i++){?><td><?php if($i!=1){$frdt1 = $effectiveDate1; } ;
  $effectiveDate1 = date('Y-m-d', strtotime("+1 months", strtotime($frdt1)));
 $row = $common->getdaysdetails($effectiveDate1,$clientid,$detl['emp_id']);  
  echo $row['sl']?></td><?php }?>
<td> </td>
</tr>
<?php $sr++;}?>
<!--- end for all dept -->
</table>
<?php
//This Header is used to make data download instead of display the data


//It will print all the Table row as Excel file row with selected column name as header.
//echo ucwords($setMainHeader)."\n".$setData."\n";

?>
