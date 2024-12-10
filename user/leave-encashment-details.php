
<?php //print_r($_POST);
session_start();
//error_reporting(0);
//print_r($_SESSION);
$user_id = $_SESSION['log_id'];

$clintid = $_POST['client'];
$emp = $_POST['emp'];
$empid = $_POST['empid'];
$leave_type = $_POST['leavetype'];
$frdt = $_POST['frdt'];
$frdt = date('Y-m-d',strtotime($frdt));
$todt = $_POST['todt'];
$todt = date('Y-m-d',strtotime($todt));
$payment_date = $_POST['payment_date'];
$payment_date = date('Y-m-d',strtotime($payment_date));


?>

<script>
 function delrow(id) {
	    alert(1);
        if(confirm('Are you You Sure want to delete this record?')) {
            $.post('/delete_leave_record', {
                'id': id
            },function(data){
                $("#success2").html("Recourd Delete Successfully!");
               alert('Recourd Deleted Successfully');
              });
        }
 }
</script>
 	<script>
$(document).ready(function() {
    $('#encashment').on('submit',function(){
        var form = $(this);
        $.ajax({
            type:'post',
            url:'/encashment_process',
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



function calbala(id){ //alert(id);
		 var ob = $("#ob"+id).val();
		 var calcul = $("#calcul"+id).val();
		 var enjoy = $("#enjoy"+id).val();
		 var balval = parseFloat(ob)+parseFloat(calcul)-parseFloat(enjoy);
		 var rate = $("#rate"+id).val();
		 $("#bal"+id).val(balval);
		 $("#baltext"+id).text(balval);
		  $("#encash"+id).val(balval);
		  var amountt = parseFloat(rate)*parseFloat(balval);
		  $("#amounttxt"+id).text(amountt);
		  $("#amountinp"+id).val(amountt);
		 
		 
		 
		 
	 }
	 
	 
	 
</script>	
<?php 


/* $calculationfrm = $_POST['calculationfrm'];
$calculationfrm = date('Y-m-d',strtotime($calculationfrm));
$calculationto = $_POST['calculationto'];
$calculationto = date('Y-m-d',strtotime($calculationto));
 */$presentday = $_POST['presentday'];
$compid =$_SESSION['comp_id'];
$sel = "";
include("../lib/class/common.php");
include("../lib/class/leave.php");
include("../lib/connection/db-config.php");
include("../lib/class/user-class.php");
$common=new common();
$leave=new leave();
$user=new user();
$empdate = $common->showleaveEmployee($frdt,$todt,$clintid,$leave_type,$emp,$empid);

//$num = $empdate->rowCount();

$clientdtl = $user->displayClient($clintid);
 $clientdtl['current_month'];
 $lock =0;
 if($presentday==20){
	 $lock =21;
 }
 if($presentday==11.43){
	 $lock =21;
 }
 
?>
<form method="post"  action="/encashment_process" id="encashment" >
<input type="hidden" name="client" value="<?php echo $clintid;?>">
<input type="hidden"  name="leavetype" value="<?php echo $leave_type;?>">
<input type="hidden"  name="frdt" value="<?php echo $frdt;?>">
<input type="hidden"  name="todt" value="<?php echo $todt;?>">
<input type="hidden"  name="calculationfrm" value="<?php echo $calculationfrm;?>">
<input type="hidden"  name="calculationto" value="<?php echo $calculationto;?>">
<input type="hidden"  name="payment_date" value="<?php echo $payment_date;?>">
<table width="100%" class="bgColor3">
 <tr>
	 <th>Sr. No <input type="checkbox" name="allcheck[]" value="all" id ="allcheck" onclick="checkAll(this.val)" > All</th>
	<th>Name</th>
	 <th>Present Day</th>
	 <th>Ob</th>
	 <th>Earned</th>
	 <th>Enjoyed</th>
	 <th>Balanced</th>
	 <th>Encashed</th>
	 <th>Rate Rs.</th>
	 <th>Amount</th>
	 <th>Action</th>
 </tr>
 <?php $i =1;
       
      if( $clientdtl['current_month'] <= $todt){$tab = 'tran_income';$tab_emp = 'tran_employee';$calc_month = $clientdtl['current_month'];}
	  else {$tab='hist_income';$tab_emp = 'hist_employee';$calc_month = $todt;}
 //foreach($empdate as $emp){
	 while($emp=mysql_fetch_array($empdate)){
		//echo $emp['emp_id'];
	 $getcalculated = $leave->getCalculated($frdt,$todt,$emp['emp_id']);
	 $getcalculated_curr = $leave->getCalculated_curr($frdt,$todt,$emp['emp_id']);
	 $present=$getcalculated+$getcalculated_curr;
	  
	           if ($presentday >0 ){
					//$getcalculated = round($getcalculated/$presentday,0);}
				$getcalculated = round($present/$presentday,0);
				if ($getcalculated>21 && $presentday=="11.43" ) $getcalculated= 21;}
				
			   else{
					$getcalculated = 0;
			   }
			   
				if($emp['leftdate'] =="0000-00-00"){
					    
						$rate = $leave->GetAmountForEncashmentNoLeftEmp($emp['emp_id'],$todt,$compid,$tab,$tab_emp,$clintid,$calc_month);
				   
				}else{
					    
							$rate = $leave->getAmountForEncashmentLeftEmp($emp['emp_id'],$frdt,$todt);
				}
				$amt = $rate['amount'];$rate = $amt ;

			   
			  $obdtl = $leave->getOB($emp['emp_id'],$clintid,$leave_type,$frdt,$todt);
			  $obdtlday = $leave->getDetailsFromLDays($emp['emp_id'],$clintid,$leave_type,$frdt,$todt);
			  $obdtlday21 = $leave->getDetailsFromLDays_curr($emp['emp_id'],$clintid,$leave_type,$frdt,$todt);
			  
			  
			  
			 
			 $pday =$obdtlday['presentsum'];  
			//echo $obdtlday['sumt']; 
			  
		$chkbankdtl = $leave->checkEncashment($frdt,$todt,$emp['emp_id'],$clintid,$leave_type);
		$chkbankdtl2 = $leave->checkEncashmentRow($frdt,$todt,$emp['emp_id'],$clintid,$leave_type);
		//print_r($chkbankdtl2);
		//$num =$chkbankdtl2->rowCount();
		//$num= mysql_num_rows($chkbankdtl2);
		// $chkbankdtl2['leave_details_id'];
		
	 
if($chkbankdtl2['leave_details_id'] !=0){	 
	 ?>
	 <tr style="background:#ffebeb">
	 <td><?php echo $i; ?> <input type="checkbox" value="<?php echo $emp['emp_id'];?>" name="chkbox[]" class="selectchk"  ></td>
	 <td><?php echo $emp['first_name']." ".$emp['middle_name']." ".$emp['last_name'];?> <input type="hidden" value="<?php echo $emp['emp_id'];?>" name="empid[]"></td>
	 <td><?php echo $chkbankdtl['present'];?> <input type="hidden" name="preday[]" value="<?php echo $chkbankdtl['present'];?>"></td>
	 <td><?php //echo $chkbankdtl['ob']; ?>  <input type="text" value="<?php echo $chkbankdtl['ob'];?>" name="obday[]" class="textclass"  onfocus="calbala(<?php echo $i;?>);" onkeyup="calbala(<?php echo $i;?>);" id="ob<?php echo $i;?>"> </td>
	 <td><?php $earned = $chkbankdtl['earned']; if($presentday==12 && $earned >21){$earned =21;} echo $earned; ?> <input type="hidden" value="<?php echo $earned;?>" name="earned[]" id="calcul<?php echo $i;?>"></td>
	 <td><?php echo $chkbankdtl['enjoyed'];?> <input type="hidden" value="<?php echo $chkbankdtl['enjoyed'];?>" name="enjoyed[]" id="enjoy<?php echo $i;?>"></td>
	 <td><span id="baltext<?php echo $i;?>"><?php echo $chkbankdtl['balanced'];?><span> <input type="hidden" value="<?php echo $chkbankdtl['balanced'];?>" name="balance[]" id="bal<?php echo $i;?>"> </td>
	 <td> <input type="text" value="<?php echo $chkbankdtl['encashed'];?>" name="encashed[]" class="textclass " id="encash<?php echo $i;?>"onfocus="rateCal(<?php echo $i;?>);" onkeyup="rateCal(<?php echo $i;?>);"></td>
	 <td><input type="text" value="<?php echo $chkbankdtl['rate'];?>" name="rate[]" class="textclass " id="rate<?php echo $i;?>" onfocus="rateCal(<?php echo $i;?>);" onkeyup="rateCal(<?php echo $i;?>);"></td>
	 <td><span id="amounttxt<?php echo $i;?>"><?php echo $chkbankdtl['amount'];?></span> <input type="hidden" value="<?php echo $chkbankdtl['amount'];?>" name="amount[]"  id="amountinp<?php echo $i;?>"></td>
	 <td>  
	 
	 <a href="javascrip:void()" onclick="delrow(<?php echo  $chkbankdtl2['leave_details_id'];?>)">
                                <img src="../images/delete-icon.png"/></a>
</td>
 </tr>
<?php } else {?>
 <tr >
	 <td><?php echo $i; ?> <input type="checkbox" value="<?php echo $emp['emp_id'];?>" name="chkbox[]" class="selectchk"  ></td>
	 <td><?php echo $emp['first_name']." ".$emp['middle_name']." ".$emp['last_name'];?> <input type="hidden" value="<?php echo $emp['emp_id'];?>" name="empid[]"></td>
	 
	 <td><?php echo $present;?> <input type="hidden" name="preday[]" value="<?php echo $present;?>"></td>
	 
	 <td><?php //echo $obdtl;?>  <input type="text" value="<?php echo $obdtl;?>" name="obday[]" class="textclass" onfocus="calbala(<?php echo $i;?>);" onkeyup="calbala(<?php echo $i;?>);" id="ob<?php echo $i;?>"></td>
	 
	 <td><?php //echo $getcalculated; 
	 if($presentday==12 && $getcalculated >21){$getcalculated =21;} echo $getcalculated;?> <input type="hidden" value="<?php echo $getcalculated;?>" name="earned[]" id="calcul<?php echo $i;?>"></td>
	 
	 <td><?php   $enjoyed = $obdtlday['sumt']+$obdtlday21['sumt']; echo round($enjoyed,2); ?> <input type="hidden" value="<?php echo round($enjoyed,2);?>" name="enjoyed[]" id="enjoy<?php echo $i;?>"></td>
	 
	 <td><span id="baltext<?php echo $i;?>"><?php echo $balance = $obdtl+$getcalculated-$enjoyed;?></span> <input type="hidden" value="<?php echo $balance;?>" name="balance[]" id="bal<?php echo $i;?>"></td>
	 
	 <!--<td> <input type="text" value="<?php echo $balance;?>" name="encashed[]" class="textclass " id="encash<?php //echo $i;?>"onfocus="rateCal(<?php //echo $i;?>);" onkeyup="rateCal(<?php //echo $i;?>);"></td>-->
	 
	 <td> <input type="text" value="<?php $encash = 0; echo $encash;?>" name="encashed[]" class="textclass " id="encash<?php echo $i;?>"onfocus="rateCal(<?php echo $i;?>);" onkeyup="rateCal(<?php echo $i;?>);"></td>
	 
	 <td><input type="text" value="<?php echo $rate;?>" name="rate[]" class="textclass " id="rate<?php echo $i;?>" onfocus="rateCal(<?php echo $i;?>);" onkeyup="rateCal(<?php echo $i;?>);"></td>
	 
	 <td><span id="amounttxt<?php echo $i;?>"><?php echo round($rate*$encash,0);?></span> <input type="hidden" value="<?php echo round($rate*$encash,0);?>" name="amount[]"  id="amountinp<?php echo $i;?>"></td>
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
