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
$setExcelName = "employee_income";
//print_r($_POST);
//header("Content-type: application/octet-stream");

//header("Content-Disposition: attachment; filename=".$setExcelName.".xls");

//header("Pragma: no-cache");
//header("Expires: 0");
//error_reporting(0);
session_start();
//print_r($_SESSION);
$clientid = $_SESSION['clientid'];
include("../lib/connection/db-config.php");
$setCounter = 0;
$month=$_SESSION['month'];
$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];


include("../lib/class/user-class.php");
$userObj=new user();
$arrayfields = array();
include("../lib/class/common.php");
$common=new common();
//$getdetails = "select * from employee where client_id=$client_id" 
//$deptid = $common->clientDept($clientid);
//$deptdetails = $common->clientDeptDetails($clientid);
if(isset($_POST['orderbyfild'])){
		
	$orderby = $_POST['orderbyfild'];
	$ll=0;
	foreach($orderby as $order){
		$orderlist .= "order by ".$order;
		$ll++;
	}
		echo $orderlist;
	}
	
$deptdetail = $common->getDeptDetailsByClientId($clientid,$orderlist);
	$splallow = $_POST['splallow'];	
	$pf = $_POST['pf'];
	$bonus = $_POST['bonus'];
	$esi = $_POST['esi'];
	$lwf = $_POST['lwf'];
	$lww = $_POST['lww'];
	$safetyapp = $_POST['safetyapp'];
	$other = $_POST['other'];
	$trainingcharg = $_POST['trainingcharg'];
	$tds = $_POST['tds'];
	$invno = $_POST['invno'];
	$invdate = $_POST['invdate'];
	$monthlysupcharge = $_POST['monthlysupcharge'];
	$fixedsercharg = $_POST['fixedsercharg'];
	$cgst = $_POST['cgst'];
	$sgst = $_POST['sgst'];
	$orderlist ="";
	print_r($_POST);
	

	
	
	$gtincomehead = $common->getAllIncomeHeadBYClientId($clientid);
//echo "<pre>";
//print_r($gtincomehead);
//echo "</pre>";
 $totincomenum = sizeof($gtincomehead);	
?>		


<table width="100%" cellpadding="0" cellspacing="0">
<tr>
<th> Sr. No.</th>
<th> CC Code</th>
<th> CC Name</th>
<th> Man Days</th>
<th> Ot Hours</th>
<?php foreach($gtincomehead as $head){ ?>
<th> <?php echo $head['income_heads_name']?></th>
<?php }?>
<th> Salary</th>
<th> OT</th>
<th> Gr Sal</th>
<th> PF</th>
<th> Bonus</th>
<th> ESI</th>
<th> LEAVE</th>
<th> LWF</th>
<th> Safety Applia.</th>
<th> Soap,Tea ,Other Charges</th>
<th> Training Charges</th>
<th> TDS</th>
<th> R/Off</th>
<th> Total O. Cha.</th>
<th> Total</th>
<th> SuperVision</th>
<th> Service Charges</th>
<th> Total (--A--)</th>
<th> Taxable Amount</th>
<th> SGST (<?php echo $sgst;?>%)</th>
<th> CGST(<?php echo $cgst;?>%)</th>
<th> GST (<?php echo $cgst+$sgst;?>%)</th>
<th> Frand Total (A+B)</th>


</tr>
<!--- for all dept -->
<?php $sr=1; foreach($deptdetail as $dept){ 

 

$deptexp = explode(' - ',$dept['mast_dept_name']);
$countman =$common->getWorkingManByDept($dept['dept_id'],$clientid);
$othours = $common->otHoursByDept($dept['dept_id'],$clientid);
$type ="BASIC";
$basic = $income = $common->getEmployeeIncome($dept['dept_id'],$type,$comp_id);
$otincome = $common->getOtIncome($dept['dept_id'],$clientid,'OVERTIME',$comp_id);
?>

<tr>
<td> <?php echo $sr; //echo "=".$dept['dept_id'];?></td>
<td> <?php echo $deptexp[0];?></td>
<td> <?php if(isset($deptexp[1]) && $deptexp[1] !=""){echo $deptexp[1];}?></td>
<td> <?php echo $countman;?></td>
<td> <?php echo $othours ;?></td>

<?php $inctot = 0;foreach($gtincomehead as $head){ ?>
<td> <?php echo $inc = $common->getEmployeeIncomeByTypeId($dept['dept_id'],$head['head_id'],$comp_id); $inctot += $inc;?></td>
<?php $headname = $common->getIncomeHeadNameById($head['head_id']); 
if($headname =="basic"){
	$basic = $inc;
	}if($headname == "supplement alw"){
		$spclllow = $inc;
} 
}?>
<td> <?php echo $inctot;?></td>
<td> <?php echo $otincome;?></td>
<td> <?php echo $grsal = $inctot+$otincome;?></td> 
<td> <?php echo $pfamt = ($basic+$spclllow)*$pf/100;?></td>
<td> <?php echo $bonusamt = ($basic+$spclllow)*$bonus/100;?></td>
<td> <?php echo $esiamt = $grsal*$esi/100;?></td>  
<td> <?php echo $leave=0; ?></td> 
<td> <?php echo $lwf;?></td>  
<td> <?php echo $safetyapp;?></td> 
<td> <?php echo $other;?></td> 
<td> <?php echo $trainingcharg;?></td> 
<td> <?php echo $tds;?></td> 
<td> </td>
<td><?php echo $inctot;?></td>  
<td> </td>
<td> </td>
<td> </td>
<td> </td>
<td> <?php echo $taxableamount = $grsal+$pfamt+$bonusamt+$esiamt+$leave+$safetyapp+$other+$trainingcharg+$tds;?></td>

<td> <?php echo $cgstamount = $taxableamount*$cgst/100;?></td>
<td> <?php echo $sgstamount =$taxableamount*$sgst/100;?></td>
<td> <?php echo $cgstamount+$sgstamount; ?></td>
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
