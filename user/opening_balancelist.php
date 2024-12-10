<?php //print_r($_POST);
session_start();
//print_r($_SESSION);
//error_reporting(0);
include("../lib/class/common.php");
include("../lib/class/leave.php");

$common=new common();
$leave=new leave();

$clintid = $_POST['client'];
$emp = $_POST['emp'];
$empid = $_POST['empid'];
$leave_type = $_POST['leavetype'];
$frdt = $_POST['frdt'];
$frdt = date('Y-m-d',strtotime($frdt));
$todt = $_POST['todt'];
$todt = date('Y-m-d',strtotime($todt));

$calculationfrm = $_POST['calculationfrm'];
$calculationfrm = date('Y-m-d',strtotime($calculationfrm));
$calculationto = $_POST['calculationto'];
$calculationto = date('Y-m-d',strtotime($calculationto));
$presentday = $_POST['presentday'];

$carfrfrm = $_POST['carfrfrm'];
$carfrfrm = date('Y-m-d',strtotime($carfrfrm));
$carfrto = $_POST['carfrto'];
$carfrto = date('Y-m-d',strtotime($carfrto));
if($presentday ==""){
	$presentday=0;
}

$sel = "";
//print_r($_POST);

 $empdate = $common->showEmployeeWithClients($frdt,$clintid,$leave_type,$emp,$empid);
 //$getcalculated = $leave->getCalculated($frdt,$todt,$calculationfrm,$calculationto,$presentday,$empid);
//echo "-".$fdate."-";
 ?>
 <form method="post"  method="post" action="/add_leave_process" id="leaveupdate">
 <input type="hidden" id="client" name="client" value="<?php echo $clintid;?>">
 <input type="hidden" id="emp" name="emp" value="<?php echo $emp;?>">
 <input type="hidden" id="empid" name="empid" value="<?php echo $empid;?>">
 <input type="hidden" id="leavetype" name="leavetype" value="<?php echo $leave_type;?>">
 <input type="hidden" id="frdt" name="frdt" value="<?php echo $frdt;?>">
 <input type="hidden" id="todt" name="todt" value="<?php echo $todt;?>">
 <input type="hidden" id="calculationfrm" name="calculationfrm" value="<?php echo $calculationfrm;?>">
 <input type="hidden" id="calculationto" name="calculationto" value="<?php echo $calculationto;?>">
 <input type="hidden" id="presentday" name="presentday" value="<?php echo $presentday;?>">
 <input type="hidden" id="carfrfrm" name="carfrfrm" value="<?php echo $carfrfrm;?>">
 <input type="hidden" id="presentday" name="carfrto" value="<?php echo $presentday;?>">
<table width="100%" class="bgColor3">
		 <tr><th align="left" width="55px"><input type="checkbox" name="allcheck[]" value="all" id ="allcheck" onclick="checkAll(this.val)" checked> All</th>
			 <th align="left" width="55px">Sr. No</th>
			<th align="left">Name</th>
			 <th align="left">Granted</th>
			 <th align="left">Calculated</th>
			 <th align="left">Carried Forword</th>
			 <th align="left">Total Ob</th>
		 </tr>
		 <?php  $i =1; $ob=0; $obt =0;
		 foreach($empdate as $emp){
			 //echo $emp['emp_id'];
			 $getcalculated = $leave->getCalculated($calculationfrm,$calculationto,$emp['emp_id']);
			  
			  if($presentday !=0){
				  //echo $presentday;
				  //echo $getcalculated;
				 $getcalculated = round($getcalculated/$presentday,0);
			  }
			  
			   $chkdt11 = $leave->checkLeave($clintid,$emp['emp_id'],$leave_type,$frdt,$todt );
			   //echo $chkdt11[0]['calculated'];
			   $num111 = $chkdt11->rowCount();
			   
			   //// for carry ford start
			   $encashed = $leave->getEncashment($carfrfrm,$carfrto,$leave_type,$emp['emp_id']);
			   if ($encashed =='')
			   {	$obcf =$leave->getleaveCarriedFor($carfrfrm,$carfrto,$emp['emp_id'],$leave_type);
					$enjoyed = $leave->getEnjoyed($carfrfrm,$carfrto,$emp['emp_id'],$leave_type);
				 $carried = $obcf-$enjoyed-$encashed ;
				}
				else{
				 $carried = $encashed ;
				}
				 //$carried = 2;
				/// for carry ford end
			$num1112 = $leave->checkLeaveDetail($clintid,$emp['emp_id'],$leave_type);
			 if($num1112['granted']==""){$num1112['granted']=0;}
				 //if($num1112['carried_forward']==""){$carfrdt=0;}else{$carfrdt=$num1112['carried_forward'];}
				 $obt = $getcalculated+$num1112['granted']+$carried;
				 

 
			 if($num111 !=0){
				
			 ?>
				 <tr style="background:#ffebeb"><td><input type="checkbox" value="<?php echo $emp['emp_id'];?>" name="chkbox[]" class="selectchk" checked > </td>
						 <td align="left"><?php echo $i;?><input type="hidden" value="<?php echo $emp['emp_id'];?>" id="" name="empids[]" ></td>
						 <td align="left"><?php echo $emp['first_name']." ".$emp['middle_name']." ".$emp['last_name'];?> </td>
						 <td align="left"><input type="text" name="granted[]" class="textclass granted" id="grnd<?php echo $i;?>" value="<?php echo $num1112['granted'];?>" onfocus="calculateob(<?php echo $i;?>);" onkeyup="calculateob(<?php echo $i;?>);" id="calculv<?php echo $i;?>"></td>
						 <td align="left"><input type="text" name="calculated[]" class="textclass calculated" value="<?php echo round($num1112['calculated'],2);?>" onfocus="calculateob(<?php echo $i;?>);" onkeyup="calculateob(<?php echo $i;?>);" id="calculv<?php echo $i;?>"></td>
						 <td align="left"><input type="text" name="carriedforword[]" class="textclass carrfeed" value="<?php if($carried !=0){ echo $carried;}else{echo $num1112['carried_forward'];}?>" id="carfrd<?php echo $i;?>" onfocus="calculateob(<?php echo $i;?>);" onkeyup="calculateob(<?php echo $i;?>);" id="calculv<?php echo $i;?>"></td>
						 <td align="left" ><span id="ob<?php echo $i;?>" class="ob"><?php echo $num1112['ob'];?></span> <input type="hidden" name="ob[]" value="<?php echo $num1112['ob'];?>" id="obin<?php echo $i;?>"></td>
					 </tr>
			 <?php }else{ ?>
					 <tr><td><input type="checkbox" value="<?php echo $emp['emp_id'];?>" name="chkbox[]" class="selectchk" checked > </td>
						 <td align="left"><?php echo $i;?><input type="hidden" value="<?php echo $emp['emp_id'];?>" id="" name="empids[]" ></td>
						 <td align="left"><?php echo $emp['first_name']." ".$emp['middle_name']." ".$emp['last_name'];?> </td>
						 <td align="left"><input type="text" name="granted[]" class="textclass granted" id="grnd<?php echo $i;?>" value="0" onfocus="calculateob(<?php echo $i;?>);" onkeyup="calculateob(<?php echo $i;?>);" id="calculv<?php echo $i;?>"></td>
						 <td align="left"><input type="text" name="calculated[]" class="textclass calculated" value="<?php if($getcalculated ==""){$getcalculated =0;} echo round($getcalculated,2); ?>" id="calculv<?php echo $i;?>" onfocus="calculateob(<?php echo $i;?>);" onkeyup="calculateob(<?php echo $i;?>);" id="calculv<?php echo $i;?>"></td>
						 <td align="left"><input type="text" name="carriedforword[]" class="textclass carrfeed" value="<?php echo $carried;?>" id="carfrd<?php echo $i;?>" onfocus="calculateob(<?php echo $i;?>);" onkeyup="calculateob(<?php echo $i;?>);" id="calculv<?php echo $i;?>"></td>
						<td align="left" ><span id="ob<?php echo $i;?>" class="ob"><?php echo round($obt,2);?></span> <input type="hidden" name="ob[]" value="<?php echo round($obt,2);?>" id="obin<?php echo $i;?>"></td>
					 </tr>
			 <?php }$i++;
			 ?>
			
			 <?php }?>
		 <tr>
		 <td colspan="2"><input type="submit" name="add" value="Add" class="btnclass"></td>
		 <td colspan="5" id="succerr" class="successclass"></td>
		 <tr>
		 </table>
		 </form>
	<script>
$(document).ready(function() {
    $('#leaveupdate').on('submit',function(){
	//var type = $("#leavetype").val();
	//alert(type);
//$("#leavetypeaa").val(type);
        // Add text 'loading...' right after clicking on the submit button. 
        //$('.output_result').text('Sending...'); 

        var form = $(this);
        $.ajax({
            type:'post',
            url:'/add_leave_process',
            dataType: "text",
            data: form.serialize(),
            success: function(result){
				//$("#test").html(result);
				//result = result.trim();
				
                $("#succerr").html("Record Successfully Added/Updated");
            }
        });

        // Prevents default submission of the form after clicking on the submit button. 
        return false;   
    });
});
</script>		 	