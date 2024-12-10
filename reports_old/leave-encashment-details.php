<?php //print_r($_REQUEST);
session_start();
//error_reporting(0);
//print_r($_SESSION);
print_r($_REQUEST);
$user_id = $_SESSION['log_id'];

$clintid = $_REQUEST['client'];
$emp = $_REQUEST['emp'];
$empid = $_REQUEST['empid'];
$leave_type = $_REQUEST['leavetype'];
$frdt = $_REQUEST['frdt'];
$frdt = date('Y-m-d',strtotime($frdt));
$todt = $_REQUEST['todt'];
$todt = date('Y-m-d',strtotime($todt));
$calculationfrm = $_REQUEST['calculationfrm'];
$calculationfrm = date('Y-m-d',strtotime($calculationfrm));
$calculationto = $_REQUEST['calculationto'];
$calculationto = date('Y-m-d',strtotime($calculationto));
$presentday = $_REQUEST['presentday'];
$compid =$_SESSION['comp_id'];
$sel = "";
include("../lib/class/common.php");
include("../lib/class/leave.php");
include("../lib/connection/db-config.php");
include("../lib/class/user-class.php");
$common=new common();
$leave=new leave();
$user=new user();
$empdate = $common->showEmployeeWithClients($frdt,$clintid,$leave_type,$emp,$empid);
$num = $empdate->rowCount();

$clientdtl = $user->displayClient($clintid);
 $clientdtl['current_month'];
?>
<form action="encashment-process.php" id="encashment" method="post">
<input type="hidden" name="client" value="<?php echo $clintid;?>">
<input type="hidden"  name="leavetype" value="<?php echo $leave_type;?>">
<input type="hidden"  name="frdt" value="<?php echo $frdt;?>">
<input type="hidden"  name="todt" value="<?php echo $todt;?>">
<input type="hidden"  name="calculationfrm" value="<?php echo $calculationfrm;?>">
<input type="hidden"  name="calculationto" value="<?php echo $calculationto;?>">
<table width="100%" class="bgColor3">
 <tr>
	 <th>Sr. No <input type="checkbox" name="allcheck[]" value="all" id ="allcheck" onclick="checkAll(this.val)" checked> All</th>
	<th>Name</th>
	 <th>Present Day</th>
	 <th>Ob</th>
	 <th>Earned</th>
	 <th>Enjoyed</th>
	 <th>Balanced</th>
	 <th>Encashed</th>
	 <th>Rate Rs.</th>
	 <th>Amount</th>
 </tr>
 <?php $i =1; foreach($empdate as $emp){
	 $getcalculated = $leave->getCalculated($calculationfrm,$calculationto,$emp['emp_id']);
			  $getcalculated = round($getcalculated/$presentday,0);
			  $obdtl = $leave->getOB($emp['emp_id'],$clintid,$leave_type,$frdt,$todt);
			  $obdtlday = $leave->getDetailsFromLDays($emp['emp_id'],$clintid,$leave_type,$frdt,$todt);
			  //print_r($obdtlday);
			  /// get amount
			  if($emp['leftdate'] =="0000-00-00"){
				  $rate = $leave->GetAmountForEncashmentNoLeftEmp($emp['emp_id'],$todt,$compid);
			  }else{
				  $rate = $leave->getAmountForEncashmentLeftEmp($emp['emp_id'],$frdt,$todt);
			  }
		 if($rate==""){
			$rate=0; 
		 }
			 $pday =$obdtlday['presentsum'];  
			//echo $obdtlday['sumt']; 
			  
		$chkbankdtl = $leave->checkEncashment($frdt,$todt,$emp['emp_id'],$clintid,$leave_type);
		$chkbankdtl2 = $leave->checkEncashmentRow($frdt,$todt,$emp['emp_id'],$clintid,$leave_type);
		$num =$chkbankdtl2->rowCount();
		
		
	 
if($num !=0){	 
	 ?>
	 <tr style="background:#ffebeb">
	 <td><?php echo $i; ?> <input type="checkbox" value="<?php echo $emp['emp_id'];?>" name="chkbox[]" class="selectchk" checked ></td>
	 <td><?php echo $emp['first_name']." ".$emp['middle_name']." ".$emp['last_name'];?> <input type="hidden" value="<?php echo $emp['emp_id'];?>" name="empid[]"></td>
	 <td><?php echo $chkbankdtl['present'];?> <input type="hidden" name="preday[]" value="<?php echo $chkbankdtl['present'];?>"></td>
	 <td><?php echo $chkbankdtl['ob']; ?>  <input type="hidden" value="<?php echo $chkbankdtl['ob'];?>" name="obday[]"> </td>
	 <td><?php echo $chkbankdtl['earned'];?> <input type="hidden" value="<?php echo $chkbankdtl['earned'];?>" name="earned[]"></td>
	 <td><?php echo $chkbankdtl['enjoyed'];?> <input type="hidden" value="<?php echo $chkbankdtl['enjoyed'];?>" name="enjoyed[]"></td>
	 <td><?php echo $chkbankdtl['balanced'];?> <input type="hidden" value="<?php echo $chkbankdtl['balanced'];?>" name="balance[]"></td>
	 <td> <input type="text" value="<?php echo $chkbankdtl['encashed'];?>" name="encashed[]" class="textclass " id="encash<?php echo $i;?>"onfocus="rateCal(<?php echo $i;?>);" onkeyup="rateCal(<?php echo $i;?>);"></td>
	 <td><input type="text" value="<?php echo $chkbankdtl['rate'];?>" name="rate[]" class="textclass " id="rate<?php echo $i;?>" onfocus="rateCal(<?php echo $i;?>);" onkeyup="rateCal(<?php echo $i;?>);"></td>
	 <td><span id="amounttxt<?php echo $i;?>"><?php echo $chkbankdtl['amount'];?></span> <input type="hidden" value="<?php echo $chkbankdtl['amount'];?>" name="amount[]"  id="amountinp<?php echo $i;?>"></td>
 </tr>
<?php } else {?>
 <tr >
	 <td><?php echo $i; ?> <input type="checkbox" value="<?php echo $emp['emp_id'];?>" name="chkbox[]" class="selectchk" checked ></td>
	 <td><?php echo $emp['first_name']." ".$emp['middle_name']." ".$emp['last_name'];?> <input type="hidden" value="<?php echo $emp['emp_id'];?>" name="empid[]"></td>
	 <td><?php echo $pday;?> <input type="hidden" name="preday[]" value="<?php echo $pday;?>"></td>
	 <td><?php echo $obdtl;?>  <input type="hidden" value="<?php echo $obdtl;?>" name="obday[]"></td>
	 <td><?php echo $getcalculated;?> <input type="hidden" value="<?php echo $getcalculated;?>" name="earned[]"></td>
	 <td><?php   $enjoyed = $obdtlday['sumt']; echo round($enjoyed,2); ?> <input type="hidden" value="<?php echo round($enjoyed,2);?>" name="enjoyed[]"></td>
	 <td><?php echo $balance = $obdtl+$getcalculated-$enjoyed;?> <input type="hidden" value="<?php echo $balance;?>" name="balance[]"></td>
	 <td> <input type="text" value="<?php echo $balance;?>" name="encashed[]" class="textclass " id="encash<?php echo $i;?>"onfocus="rateCal(<?php echo $i;?>);" onkeyup="rateCal(<?php echo $i;?>);"></td>
	 <td><input type="text" value="<?php echo $rate;?>" name="rate[]" class="textclass " id="rate<?php echo $i;?>" onfocus="rateCal(<?php echo $i;?>);" onkeyup="rateCal(<?php echo $i;?>);"></td>
	 <td><span id="amounttxt<?php echo $i;?>"><?php echo round($rate*$balance);?></span> <input type="hidden" value="<?php echo round($rate*$balance);?>" name="amount[]"  id="amountinp<?php echo $i;?>"></td>
 </tr>
<?php }?>
 <?php $i++; } 
 if($i ==1){?>
<tr align="center">
	<td colspan="10" class="tdata errorclass">
		<span class="norec">No Record found</span>
	</td>
<tr>
 <?php }?>
 <tr>
 <td></td>
<td ><input type="submit" value="Submit" class="btnclass"></td>
<td colspan="8" class="successclass" id="success"></td>
</tr>
 </table>
 </form>
 <div id="test"></div>
 	<script>
$(document).ready(function() {
    $('#encashment').on('submit',function(){
        var form = $(this);
        $.ajax({
            type:'post',
            url:'encashment-process.php',
            dataType: "text",
            data: form.serialize(),
            success: function(result){	 alert(result);	
//$("#test").text(result);			
                $("#success").html("Record Successfully Added/Updated");
            }
        });
        // Prevents default submission of the form after clicking on the submit button. 
        return false;   
    });
});
</script>	